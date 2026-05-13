<?php

namespace App\Services;

use Aws\S3\S3Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class B2Service
{
    protected S3Client $client;
    protected string $bucket;
    protected string $publicUrl;

    public function __construct()
    {
        $this->bucket    = config('b2.bucket');
        $this->publicUrl = rtrim(config('b2.public_url'), '/');

        $this->client = new S3Client([
            'version'     => 'latest',
            'region'      => 'us-east-005',
            'endpoint'    => config('b2.endpoint'),
            'credentials' => [
                'key'    => config('b2.key_id'),
                'secret' => config('b2.app_key'),
            ],
            'use_path_style_endpoint' => true,
        ]);
    }

    /**
     * Sube un archivo a Backblaze B2.
     * Retorna ['url' => '...', 'public_id' => '...']
     *
     * @param  UploadedFile  $file
     * @param  string        $carpeta   ej: 'cursos', 'avatars', 'lecciones/videos'
     * @param  string        $tipo      'image' | 'video' | 'raw'  (solo para compatibilidad)
     */
    public function subir(UploadedFile $file, string $carpeta, string $tipo = 'image'): array
    {
        $extension = $file->getClientOriginalExtension();
        $nombre    = Str::uuid() . '.' . $extension;
        $key       = 'comunalaprende/' . trim($carpeta, '/') . '/' . $nombre;

        $this->client->putObject([
            'Bucket'      => $this->bucket,
            'Key'         => $key,
            'Body'        => fopen($file->getRealPath(), 'rb'),
            'ContentType' => $file->getMimeType(),
            'ACL'         => 'public-read',
        ]);

        return [
            'url'       => $this->publicUrl . '/' . $key,
            'public_id' => $key,
        ];
    }

    /**
     * Sube un archivo desde una ruta local (usado en migración).
     */
    public function subirDesdeRuta(string $rutaLocal, string $key, string $contentType = 'application/octet-stream'): array
    {
        $this->client->putObject([
            'Bucket'      => $this->bucket,
            'Key'         => $key,
            'Body'        => fopen($rutaLocal, 'rb'),
            'ContentType' => $contentType,
            'ACL'         => 'public-read',
        ]);

        return [
            'url'       => $this->publicUrl . '/' . $key,
            'public_id' => $key,
        ];
    }

    /**
     * Sube contenido desde una URL remota (usado en migración desde Cloudinary).
     */
    public function subirDesdeUrl(string $urlOrigen, string $key, string $contentType = 'application/octet-stream'): array
    {
        $contenido = file_get_contents($urlOrigen);

        if ($contenido === false) {
            throw new \RuntimeException("No se pudo descargar: {$urlOrigen}");
        }

        $this->client->putObject([
            'Bucket'      => $this->bucket,
            'Key'         => $key,
            'Body'        => $contenido,
            'ContentType' => $contentType,
            'ACL'         => 'public-read',
        ]);

        return [
            'url'       => $this->publicUrl . '/' . $key,
            'public_id' => $key,
        ];
    }

    /**
     * Elimina un archivo de B2 por su key (public_id).
     */
    public function eliminar(?string $publicId, string $tipo = 'image'): void
    {
        if (empty($publicId)) return;

        try {
            $this->client->deleteObject([
                'Bucket' => $this->bucket,
                'Key'    => $publicId,
            ]);
        } catch (\Exception $e) {
            \Log::warning("B2 eliminar {$publicId}: " . $e->getMessage());
        }
    }

    /**
     * Extrae el public_id (key) de una URL de B2.
     *
     * URL: https://f005.backblazeb2.com/file/ComunalAprende-media/comunalaprende/cursos/uuid.jpg
     * Key: comunalaprende/cursos/uuid.jpg
     */
    public static function urlAPublicId(string $url): ?string
    {
        if (empty($url)) return null;

        // Patrón: /file/BUCKET/...
        if (preg_match('#/file/[^/]+/(.+)$#', $url, $m)) {
            return $m[1];
        }

        // Fallback: si ya es una key directa (no empieza con http)
        if (!str_starts_with($url, 'http')) {
            return $url ?: null;
        }

        return null;
    }

    /**
     * Detecta el ContentType apropiado según la extensión.
     */
    public static function detectarContentType(string $filename): string
    {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        return match($ext) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png'         => 'image/png',
            'webp'        => 'image/webp',
            'gif'         => 'image/gif',
            'mp4'         => 'video/mp4',
            'mov'         => 'video/quicktime',
            'webm'        => 'video/webm',
            'avi'         => 'video/avi',
            'pdf'         => 'application/pdf',
            'doc'         => 'application/msword',
            'docx'        => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'ppt'         => 'application/vnd.ms-powerpoint',
            'pptx'        => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            default       => 'application/octet-stream',
        };
    }
}