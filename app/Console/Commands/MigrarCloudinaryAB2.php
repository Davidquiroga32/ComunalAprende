<?php

namespace App\Console\Commands;

use App\Models\Curso;
use App\Models\Leccion;
use App\Models\User;
use App\Services\B2Service;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Console\Command;

class MigrarCloudinaryAB2 extends Command
{
    protected $signature   = 'migrar:cloudinary-a-b2 {--dry-run : Solo muestra lo que haría, sin hacer cambios}';
    protected $description = 'Migra los archivos de Comunal Aprende desde Cloudinary a Backblaze B2';

    private B2Service $b2;
    private Cloudinary $cloudinary;
    private bool $dryRun = false;

    public function handle(): void
    {
        $this->dryRun = $this->option('dry-run');

        if ($this->dryRun) {
            $this->warn('⚠  MODO DRY-RUN: no se harán cambios en la base de datos ni en B2.');
        }

        $this->b2 = app(B2Service::class);

        $this->cloudinary = new Cloudinary(
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => config('cloudinary.cloud_name'),
                    'api_key'    => config('cloudinary.api_key'),
                    'api_secret' => config('cloudinary.api_secret'),
                ],
                'url' => ['secure' => true],
            ])
        );

        $this->info('');
        $this->info('════════════════════════════════════════════════════');
        $this->info('   Migración Cloudinary → Backblaze B2');
        $this->info('════════════════════════════════════════════════════');

        $this->migrarImagenesCursos();
        $this->migrarLecciones();
        $this->migrarAvatares();

        $this->info('');
        $this->info('✅ Migración completada.');
    }

    // ─────────────────────────────────────────────────
    //  CURSOS — imágenes de portada
    // ─────────────────────────────────────────────────
    private function migrarImagenesCursos(): void
    {
        $this->info('');
        $this->info('📁 Migrando imágenes de cursos...');

        $cursos = Curso::whereNotNull('imagen')
            ->where('imagen', 'like', '%cloudinary.com%')
            ->get();

        if ($cursos->isEmpty()) {
            $this->line('   Sin imágenes de cursos que migrar.');
            return;
        }

        foreach ($cursos as $curso) {
            $this->line("   → Curso #{$curso->id}: {$curso->titulo}");
            $this->line("     URL original: {$curso->imagen}");

            try {
                $nuevaUrl = $this->descargarYSubir(
                    $curso->imagen,
                    "comunalaprende/cursos/{$curso->id}_portada"
                );

                $this->line("     URL nueva:    {$nuevaUrl}");

                if (!$this->dryRun) {
                    $curso->update(['imagen' => $nuevaUrl]);
                }

                $this->info("     ✓ OK");
            } catch (\Throwable $e) {
                $this->error("     ✗ Error: " . $e->getMessage());
            }
        }
    }

    // ─────────────────────────────────────────────────
    //  LECCIONES — archivos, videos e imágenes inline
    // ─────────────────────────────────────────────────
    private function migrarLecciones(): void
    {
        $this->info('');
        $this->info('📁 Migrando archivos de lecciones...');

        // PDFs / documentos
        $lecciones = Leccion::whereNotNull('archivo')
            ->where('archivo', 'like', '%cloudinary.com%')
            ->get();

        foreach ($lecciones as $leccion) {
            $this->line("   → Lección #{$leccion->id} (PDF/doc): {$leccion->titulo}");

            try {
                $ext      = $this->extensionDesdeUrl($leccion->archivo);
                $nuevaUrl = $this->descargarYSubir(
                    $leccion->archivo,
                    "comunalaprende/lecciones/pdfs/{$leccion->id}_archivo.{$ext}"
                );

                $this->line("     URL nueva: {$nuevaUrl}");

                if (!$this->dryRun) {
                    $leccion->update(['archivo' => $nuevaUrl]);
                }

                $this->info("     ✓ OK");
            } catch (\Throwable $e) {
                $this->error("     ✗ Error: " . $e->getMessage());
            }
        }

        // Videos propios (video_local = public_id de Cloudinary)
        $leccionesVideo = Leccion::whereNotNull('video_local')
            ->whereNotNull('video_url')
            ->where('video_url', 'like', '%cloudinary.com%')
            ->get();

        foreach ($leccionesVideo as $leccion) {
            $this->line("   → Lección #{$leccion->id} (video): {$leccion->titulo}");

            try {
                $ext      = $this->extensionDesdeUrl($leccion->video_url) ?: 'mp4';
                $key      = "comunalaprende/lecciones/videos/{$leccion->id}_video.{$ext}";
                $nuevaUrl = $this->descargarYSubir($leccion->video_url, $key);

                $this->line("     URL nueva: {$nuevaUrl}");

                if (!$this->dryRun) {
                    $leccion->update([
                        'video_url'   => $nuevaUrl,
                        'video_local' => $key,
                    ]);
                }

                $this->info("     ✓ OK");
            } catch (\Throwable $e) {
                $this->error("     ✗ Error: " . $e->getMessage());
            }
        }

        // Imágenes inline en contenido HTML (TinyMCE)
        $this->info('');
        $this->info('📁 Migrando imágenes inline del editor TinyMCE...');

        $leccionesTexto = Leccion::whereNotNull('contenido')
            ->where('contenido', 'like', '%cloudinary.com%')
            ->get();

        foreach ($leccionesTexto as $leccion) {
            $this->line("   → Lección #{$leccion->id} (contenido HTML): {$leccion->titulo}");

            $contenido    = $leccion->contenido;
            $nuevaContenido = $contenido;
            $count        = 0;

            // Extraer todas las URLs de Cloudinary del HTML
            preg_match_all(
                '#https://res\.cloudinary\.com/[^\s"\'<>]+#',
                $contenido,
                $matches
            );

            foreach (array_unique($matches[0]) as $urlOriginal) {
                try {
                    $ext      = $this->extensionDesdeUrl($urlOriginal) ?: 'jpg';
                    $hash     = substr(md5($urlOriginal), 0, 12);
                    $key      = "comunalaprende/lecciones/imagenes/leccion_{$leccion->id}_{$hash}.{$ext}";
                    $nuevaUrl = $this->descargarYSubir($urlOriginal, $key);

                    $nuevaContenido = str_replace($urlOriginal, $nuevaUrl, $nuevaContenido);
                    $count++;
                } catch (\Throwable $e) {
                    $this->error("     ✗ Error con imagen {$urlOriginal}: " . $e->getMessage());
                }
            }

            if ($count > 0) {
                $this->line("     Imágenes migradas: {$count}");
                if (!$this->dryRun) {
                    $leccion->update(['contenido' => $nuevaContenido]);
                }
                $this->info("     ✓ OK");
            } else {
                $this->line("     Sin imágenes nuevas que migrar.");
            }
        }
    }

    // ─────────────────────────────────────────────────
    //  USUARIOS — avatares
    // ─────────────────────────────────────────────────
    private function migrarAvatares(): void
    {
        $this->info('');
        $this->info('📁 Migrando avatares de usuarios...');

        $usuarios = User::whereNotNull('avatar')
            ->where('avatar', 'like', '%cloudinary.com%')
            ->get();

        if ($usuarios->isEmpty()) {
            $this->line('   Sin avatares que migrar.');
            return;
        }

        foreach ($usuarios as $user) {
            $this->line("   → Usuario #{$user->id}: {$user->name}");

            try {
                $ext      = $this->extensionDesdeUrl($user->avatar) ?: 'jpg';
                $nuevaUrl = $this->descargarYSubir(
                    $user->avatar,
                    "comunalaprende/avatars/{$user->id}_avatar.{$ext}"
                );

                $this->line("     URL nueva: {$nuevaUrl}");

                if (!$this->dryRun) {
                    $user->update(['avatar' => $nuevaUrl]);
                }

                $this->info("     ✓ OK");
            } catch (\Throwable $e) {
                $this->error("     ✗ Error: " . $e->getMessage());
            }
        }
    }

    // ─────────────────────────────────────────────────
    //  HELPERS
    // ─────────────────────────────────────────────────

    /**
     * Descarga un archivo de Cloudinary (u otra URL pública)
     * y lo sube a B2 con la key indicada.
     * Retorna la URL pública en B2.
     */
    private function descargarYSubir(string $urlOrigen, string $key): string
    {
        if ($this->dryRun) {
            return '[DRY-RUN] ' . config('b2.public_url') . '/' . $key;
        }

        $contentType = B2Service::detectarContentType($key);
        $resultado   = $this->b2->subirDesdeUrl($urlOrigen, $key, $contentType);

        return $resultado['url'];
    }

    /**
     * Extrae la extensión de una URL ignorando query strings.
     */
    private function extensionDesdeUrl(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH) ?? $url;
        $ext  = pathinfo($path, PATHINFO_EXTENSION);

        // Cloudinary puede devolver URLs sin extensión o con transformaciones
        // Intenta detectar por el path
        if (empty($ext)) {
            if (str_contains($path, '/video/')) return 'mp4';
            if (str_contains($path, '/raw/'))   return 'pdf';
            return 'jpg';
        }

        // Quitar parámetros si vienen pegados a la extensión
        return strtolower(explode('?', $ext)[0]);
    }
}