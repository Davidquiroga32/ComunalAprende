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
            [
                'family' => 'Poppins',
                'weight' => 400,
                'url'    => 'https://fonts.gstatic.com/s/poppins/v20/pxiEyp8kv8JHgFVrJJfecg.woff2',
                'cache'  => storage_path('fonts/poppins-400.woff2'),
            ],
            [
                'family' => 'Poppins',
                'weight' => 700,
                'url'    => 'https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLCz7Z1xlFQ.woff2',
                'cache'  => storage_path('fonts/poppins-700.woff2'),
            ],
            [
                'family' => 'Poppins',
                'weight' => 900,
                'url'    => 'https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLBT5Z1xlFQ.woff2',
                'cache'  => storage_path('fonts/poppins-900.woff2'),
            ],
        ];

        // Crear directorio si no existe
        if (!is_dir(storage_path('fonts'))) {
            mkdir(storage_path('fonts'), 0755, true);
        }

        $css = '';

        foreach ($fonts as $font) {
            // Intentar leer desde caché local primero
            if (file_exists($font['cache'])) {
                $data = file_get_contents($font['cache']);
            } else {
                // Descargar y cachear
                $ctx = stream_context_create([
                    'http' => [
                        'timeout' => 10,
                        'header'  => "User-Agent: Mozilla/5.0\r\n",
                    ],
                ]);
                $data = @file_get_contents($font['url'], false, $ctx);
                if ($data) {
                    file_put_contents($font['cache'], $data);
                }
            }

            if ($data) {
                $b64 = base64_encode($data);
                $css .= "@font-face {
                    font-family: '{$font['family']}';
                    font-weight: {$font['weight']};
                    font-style: normal;
                    src: url('data:font/woff2;base64,{$b64}') format('woff2');
                }\n";
            }
        }

        // Fallback: si no se pudieron cargar fuentes, usar system fonts
        if (empty($css)) {
            $css = "/* Fuentes no disponibles, usando fallback del sistema */\n";
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