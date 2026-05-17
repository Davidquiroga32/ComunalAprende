<?php
namespace App\Http\Controllers;
use App\Models\Certificado;
use App\Models\Curso;
use Illuminate\Support\Facades\Auth;
use Spatie\Browsershot\Browsershot;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificadoController extends Controller
{
    /**
     * Rutas de fuentes locales disponibles en Railway (Nixpacks).
     * Todas están en /usr/share/fonts/truetype/google-fonts/ y dejavu/
     */
    private function getFontFaceCSS(): string
    {
        $fonts = [
            // Poppins Regular
            '/usr/share/fonts/truetype/google-fonts/Poppins-Regular.ttf',
            // Poppins Bold
            '/usr/share/fonts/truetype/google-fonts/Poppins-Bold.ttf',
            // DejaVu Sans (fallback robusto para caracteres especiales como tildes)
            '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
            '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
        ];

        $css = '';

        // Poppins Regular
        if (file_exists($fonts[0])) {
            $b64 = base64_encode(file_get_contents($fonts[0]));
            $css .= "@font-face {
                font-family: 'Poppins';
                font-weight: 400;
                font-style: normal;
                src: url('data:font/truetype;base64,{$b64}') format('truetype');
            }\n";
        }

        // Poppins Bold
        if (file_exists($fonts[1])) {
            $b64 = base64_encode(file_get_contents($fonts[1]));
            $css .= "@font-face {
                font-family: 'Poppins';
                font-weight: 700;
                font-style: normal;
                src: url('data:font/truetype;base64,{$b64}') format('truetype');
            }\n";
        }

        // DejaVu Sans Regular (fallback para tildes y caracteres especiales)
        if (file_exists($fonts[2])) {
            $b64 = base64_encode(file_get_contents($fonts[2]));
            $css .= "@font-face {
                font-family: 'DejaVu Sans';
                font-weight: 400;
                font-style: normal;
                src: url('data:font/truetype;base64,{$b64}') format('truetype');
            }\n";
        }

        // DejaVu Sans Bold
        if (file_exists($fonts[3])) {
            $b64 = base64_encode(file_get_contents($fonts[3]));
            $css .= "@font-face {
                font-family: 'DejaVu Sans';
                font-weight: 700;
                font-style: normal;
                src: url('data:font/truetype;base64,{$b64}') format('truetype');
            }\n";
        }

        return $css;
    }

    /** Descargar PDF del certificado */
    public function descargar(Curso $curso)
    {
        $user = Auth::user();

        // Verificar que completó el curso
        $inscripcion = $user->cursos()
            ->where('curso_id', $curso->id)
            ->wherePivot('completado', true)
            ->first();

        if (!$inscripcion) {
            return redirect()->route('dashboard.certificados')
                ->with('error', 'Debes completar el curso para obtener el certificado.');
        }

        // Obtener o crear certificado
        $certificado = Certificado::firstOrCreate(
            ['user_id' => $user->id, 'curso_id' => $curso->id],
            ['fecha_emision' => $inscripcion->pivot->fecha_completado ?? now()]
        );

        // Generar QR como SVG y convertir a Base64
        $urlVerificacion = route('certificado.verificar', $certificado->codigo);
        $qrSvg    = QrCode::size(150)->margin(1)->generate($urlVerificacion);
        $qrBase64 = base64_encode($qrSvg);

        // Obtener CSS con fuentes embebidas
        $fontFaceCSS = $this->getFontFaceCSS();

        // Convertir logo a Base64 para embeber en el HTML
        $logoBase64 = '';
        $logoPath = public_path('images/logo.png');
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        // Convertir firma a Base64 si existe
        $firmaBase64 = '';
        $firmaPath = public_path('images/firma-ivan-castillo.png');
        if (file_exists($firmaPath)) {
            $firmaBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($firmaPath));
        }

        // Renderizar vista a HTML
        $html = view('certificados.certificado-pdf', [
            'certificado'     => $certificado,
            'user'            => $user,
            'curso'           => $curso,
            'qrBase64'        => $qrBase64,
            'urlVerificacion' => $urlVerificacion,
            'fontFaceCSS'     => $fontFaceCSS,
            'logoBase64'      => $logoBase64,
            'firmaBase64'     => $firmaBase64,
        ])->render();

        $filename = 'certificado-' . str_replace(' ', '-', strtolower($curso->titulo)) . '.pdf';

        $chromePath = env('PUPPETEER_EXECUTABLE_PATH', '/run/current-system/sw/bin/chromium');

        // Fallback de rutas de Chromium en Railway
        if (!file_exists($chromePath)) {
            $fallbacks = [
                '/run/current-system/sw/bin/chromium',
                '/root/.nix-profile/bin/chromium',
                '/usr/bin/chromium-browser',
                '/usr/bin/chromium',
                '/nix/var/nix/profiles/default/bin/chromium',
            ];
            foreach ($fallbacks as $path) {
                if (file_exists($path)) {
                    $chromePath = $path;
                    break;
                }
            }
        }

        $browsershot = Browsershot::html($html)
            ->landscape()
            ->paperSize(297, 210)
            ->margins(0, 0, 0, 0)
            ->showBackground()
            ->waitUntilNetworkIdle()
            ->windowSize(1280, 800)
            ->timeout(120)
            ->setChromePath($chromePath)
            ->addChromiumArguments([
                'no-sandbox',
                'disable-setuid-sandbox',
                'disable-dev-shm-usage',
                'disable-gpu',
                'disable-web-security',
                'allow-file-access-from-files',
                'disable-extensions',
                'disable-software-rasterizer',
                'font-render-hinting=none',
                'run-all-compositor-stages-before-draw',
            ]);


        $pdf = $browsershot->pdf();

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /** Página pública de verificación */
    public function verificar(string $codigo)
    {
        $certificado = Certificado::where('codigo', $codigo)
            ->with(['user', 'curso'])
            ->firstOrFail();

        return view('certificados.certificado-verificar', compact('certificado'));
    }
}