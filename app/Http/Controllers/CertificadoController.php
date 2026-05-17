<?php
namespace App\Http\Controllers;
use App\Models\Certificado;
use App\Models\Curso;
use Illuminate\Support\Facades\Auth;
use Spatie\Browsershot\Browsershot;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificadoController extends Controller
{
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

        // Generar QR
        $urlVerificacion = route('certificado.verificar', $certificado->codigo);
        $qrSvg    = QrCode::size(150)->margin(1)->generate($urlVerificacion);
        $qrBase64 = base64_encode($qrSvg);

        // Renderizar vista a HTML
        $html = view('certificados.certificado-pdf', [
            'certificado'     => $certificado,
            'user'            => $user,
            'curso'           => $curso,
            'qrBase64'        => $qrBase64,
            'urlVerificacion' => $urlVerificacion,
        ])->render();

        $filename = 'certificado-' . str_replace(' ', '-', strtolower($curso->titulo)) . '.pdf';


        $browsershot = Browsershot::html($html)
            ->landscape()
            ->paperSize(297, 210)
            ->margins(0, 0, 0, 0)
            ->showBackground()
            ->waitUntilNetworkIdle()
            ->setChromePath(env('PUPPETEER_EXECUTABLE_PATH', '/root/.nix-profile/bin/chromium'))
            ->addChromiumArguments(['no-sandbox', 'disable-setuid-sandbox', 'disable-dev-shm-usage', 'disable-gpu']);

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