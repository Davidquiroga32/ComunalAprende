<?php

namespace App\Console\Commands;

use App\Models\Curso;
use App\Models\Leccion;
use App\Models\User;
use App\Services\B2Service;
use Illuminate\Console\Command;

class MigrarCloudinaryAB2 extends Command
{
    protected $signature   = 'migrar:cloudinary-a-b2 {--dry-run : Solo muestra lo que haría, sin hacer cambios}';
    protected $description = 'Migra los archivos de Comunal Aprende desde Cloudinary a Backblaze B2';

    private B2Service $b2;
    private bool $dryRun = false;
    private int $exitados = 0;
    private int $fallidos = 0;

    public function handle(): int
    {
        $this->dryRun = $this->option('dry-run');

        if ($this->dryRun) {
            $this->warn('⚠  MODO DRY-RUN: no se harán cambios en la base de datos ni en B2.');
        }

        $this->b2 = app(B2Service::class);

        $this->info('');
        $this->info('════════════════════════════════════════════════════');
        $this->info('   Migración Cloudinary → Backblaze B2');
        $this->info('════════════════════════════════════════════════════');
        $this->info('');

        $this->migrarImagenesCursos();
        $this->migrarLecciones();
        $this->migrarAvatares();

        $this->info('');
        $this->info("✅ Migración completada. Exitosos: {$this->exitados} | Fallidos: {$this->fallidos}");

        return $this->fallidos > 0
            ? self::FAILURE
            : self::SUCCESS;
    }

    // ─────────────────────────────────────────────────
    //  CURSOS — imágenes de portada
    // ─────────────────────────────────────────────────
    private function migrarImagenesCursos(): void
    {
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

            try {
                $nuevaUrl = $this->descargarYSubir(
                    $curso->imagen,
                    "comunalaprende/cursos/{$curso->id}_portada"
                );

                $this->line("     URL nueva: {$nuevaUrl}");

                if (! $this->dryRun) {
                    $curso->update(['imagen' => $nuevaUrl]);
                }

                $this->info('     ✓ OK');
                $this->exitados++;
            } catch (\Throwable $e) {
                $this->error("     ✗ Error: " . $e->getMessage());
                $this->fallidos++;
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

                if (! $this->dryRun) {
                    $leccion->update(['archivo' => $nuevaUrl]);
                }

                $this->info('     ✓ OK');
                $this->exitados++;
            } catch (\Throwable $e) {
                $this->error("     ✗ Error: " . $e->getMessage());
                $this->fallidos++;
            }
        }

        // Videos propios (video_local = public_id en Cloudinary)
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

                if (! $this->dryRun) {
                    $leccion->update([
                        'video_url'   => $nuevaUrl,
                        'video_local' => $key,
                    ]);
                }

                $this->info('     ✓ OK');
                $this->exitados++;
            } catch (\Throwable $e) {
                $this->error("     ✗ Error: " . $e->getMessage());
                $this->fallidos++;
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

            $contenido      = $leccion->contenido;
            $nuevaContenido = $contenido;
            $count          = 0;

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
                    $this->exitados++;
                } catch (\Throwable $e) {
                    $this->error("     ✗ Error con imagen {$urlOriginal}: " . $e->getMessage());
                    $this->fallidos++;
                }
            }

            if ($count > 0) {
                $this->line("     Imágenes migradas: {$count}");
                if (! $this->dryRun) {
                    $leccion->update(['contenido' => $nuevaContenido]);
                }
                $this->info('     ✓ OK');
            } else {
                $this->line('     Sin imágenes nuevas que migrar.');
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

                if (! $this->dryRun) {
                    $user->update(['avatar' => $nuevaUrl]);
                }

                $this->info('     ✓ OK');
                $this->exitados++;
            } catch (\Throwable $e) {
                $this->error("     ✗ Error: " . $e->getMessage());
                $this->fallidos++;
            }
        }
    }

    // ─────────────────────────────────────────────────
    //  HELPERS
    // ─────────────────────────────────────────────────

    /**
     * Descarga un archivo desde una URL pública de Cloudinary
     * y lo sube a B2 con la key indicada.
     *
     * Para Cloudinary, las URLs son públicas y no requieren
     * autenticación — no se necesita el SDK de Cloudinary.
     */
    private function descargarYSubir(string $urlOrigen, string $key): string
    {
        if ($this->dryRun) {
            return '[DRY-RUN] ' . $key;
        }

        // Limpiar la URL de Cloudinary: eliminar transformaciones
        // Ej: https://res.cloudinary.com/cloud/image/upload/w_300,c_fill/v1/carpeta/archivo.jpg
        // →   https://res.cloudinary.com/cloud/image/upload/v1/carpeta/archivo.jpg
        $urlLimpia = $this->limpiarUrlCloudinary($urlOrigen);

        $contentType = B2Service::detectarContentType($key);

        // Intentar primero con URL limpia, luego con original
        try {
            $resultado = $this->b2->subirDesdeUrl($urlLimpia, $key, $contentType);
        } catch (\Throwable $e) {
            // Fallback a la URL original si la limpia falla
            $resultado = $this->b2->subirDesdeUrl($urlOrigen, $key, $contentType);
        }

        return $resultado['url'];
    }

    /**
     * Elimina transformaciones de una URL de Cloudinary para
     * obtener el archivo original.
     *
     * Cloudinary: .../upload/{transformaciones}/{version}/{public_id}
     * Queremos:   .../upload/{version}/{public_id}  (sin transformaciones)
     */
    private function limpiarUrlCloudinary(string $url): string
    {
        // Si no es una URL de Cloudinary, la devolvemos tal cual
        if (! str_contains($url, 'cloudinary.com')) {
            return $url;
        }

        // Eliminar parámetros de transformación entre /upload/ y /v\d+/ o el public_id
        // Patrón: /upload/t_xxx,w_300,.../  →  /upload/
        return preg_replace(
            '#(/upload/)(?:[a-z_,./0-9]+(?<!v\d{1,10})/)*#',
            '$1',
            $url
        ) ?? $url;
    }

    /**
     * Extrae la extensión de una URL ignorando query strings.
     */
    private function extensionDesdeUrl(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH) ?? $url;
        $ext  = pathinfo($path, PATHINFO_EXTENSION);

        if (empty($ext)) {
            if (str_contains($path, '/video/')) return 'mp4';
            if (str_contains($path, '/raw/'))   return 'pdf';
            return 'jpg';
        }

        return strtolower(explode('?', $ext)[0]);
    }
}