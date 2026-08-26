<?php

namespace App\Services;

use Cloudinary;
use Cloudinary\Uploader;
use Illuminate\Http\UploadedFile;

class CloudinaryImageUploader
{
    public function __construct()
    {
        $this->withoutSdkDeprecationNoise(
            fn () => Cloudinary::config_from_url(config('services.cloudinary.url'))
        );
    }

    public function store(UploadedFile $file, string $folder = 'products'): string
    {
        $result = $this->withoutSdkDeprecationNoise(
            fn () => Uploader::upload($file->getRealPath(), ['folder' => $folder])
        );

        return $result['public_id'];
    }

    public function delete(string $publicId): void
    {
        $this->withoutSdkDeprecationNoise(
            fn () => Uploader::destroy($publicId)
        );
    }

    public function url(string $publicId): string
    {
        return $this->withoutSdkDeprecationNoise(
            fn () => cloudinary_url($publicId, ['secure' => true])
        );
    }

    /**
     * cloudinary/cloudinary_php 1.x passes null into string-typed builtins
     * in a few places, which PHP 8.1+ reports as deprecation notices.
     * The SDK still works correctly; this just keeps that noise out of logs.
     */
    private function withoutSdkDeprecationNoise(callable $callback): mixed
    {
        $previous = error_reporting();
        error_reporting($previous & ~E_DEPRECATED);

        try {
            return $callback();
        } finally {
            error_reporting($previous);
        }
    }
}
