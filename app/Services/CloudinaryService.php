<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Http\UploadedFile;

class CloudinaryService
{
    protected Cloudinary $cloudinary;

    public function __construct()
    {
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
    }

    /**
     * Sube un archivo a Cloudinary.
     * Retorna ['url' => '...', 'public_id' => '...']
     */
    public function subir(UploadedFile $file, string $carpeta, string $tipo = 'image'): array
    {
        $opciones = [
            'folder'          => 'comunalaprende/' . $carpeta,
            'resource_type'   => $tipo,
            'use_filename'    => false,
            'unique_filename' => true,
        ];

        if ($tipo === 'image') {
            $opciones['transformation'] = [
                ['quality' => 'auto', 'fetch_format' => 'auto'],
            ];
        }

        $resultado = $this->cloudinary->uploadApi()->upload(
            $file->getRealPath(),
            $opciones
        );

        return [
            'url'       => $resultado['secure_url'],
            'public_id' => $resultado['public_id'],
        ];
    }

    /**
     * Elimina un archivo de Cloudinary por su public_id.
     */
    public function eliminar(?string $publicId, string $tipo = 'image'): void
    {
        if (empty($publicId)) return;
        try {
            $this->cloudinary->uploadApi()->destroy($publicId, ['resource_type' => $tipo]);
        } catch (\Exception $e) {
            \Log::warning("Cloudinary eliminar {$publicId}: " . $e->getMessage());
        }
    }

    /**
     * Detecta el tipo de recurso según el MIME del archivo.
     */
    public static function detectarTipo(UploadedFile $file): string
    {
        $mime = $file->getMimeType();
        if (str_starts_with($mime, 'video/')) return 'video';
        if (str_starts_with($mime, 'image/')) return 'image';
        return 'raw';
    }

    /**
     * Extrae el public_id de una URL de Cloudinary para poder borrarlo.
     * https://res.cloudinary.com/x/image/upload/v123/comunalaprende/cursos/abc.jpg
     * → comunalaprende/cursos/abc
     */
    public static function urlAPublicId(string $url): ?string
    {
        if (empty($url) || !str_contains($url, 'cloudinary.com')) return null;
        $partes = explode('/upload/', $url);
        if (count($partes) < 2) return null;
        $resto = preg_replace('/^v\d+\//', '', $partes[1]);
        $resto = preg_replace('/\.[^.]+$/', '', $resto);
        return $resto ?: null;
    }
}