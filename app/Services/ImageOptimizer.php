<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizer
{
    public const MAX_BYTES = 716800; // 700 KB

    /**
     * Store an image on the public disk. Files already at or under 700 KB are
     * stored as-is. Larger files are compressed (and scaled if needed).
     */
    public function store(UploadedFile $file, string $directory = 'media'): string
    {
        $directory = trim($directory, '/');
        $sourcePath = $file->getRealPath();
        $size = is_string($sourcePath) && is_file($sourcePath) ? (int) filesize($sourcePath) : 0;

        $originalExt = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        if (! in_array($originalExt, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
            $originalExt = 'jpg';
        }

        if ($size > 0 && $size <= self::MAX_BYTES) {
            $filename = Str::uuid()->toString().'.'.$originalExt;

            return $file->storeAs($directory, $filename, 'public');
        }

        $compressed = $this->compressToLimit($sourcePath, $originalExt);
        if ($compressed === null) {
            $filename = Str::uuid()->toString().'.'.$originalExt;

            return $file->storeAs($directory, $filename, 'public');
        }

        $filename = Str::uuid()->toString().'.'.$compressed['extension'];
        $relative = $directory.'/'.$filename;
        Storage::disk('public')->put($relative, $compressed['binary']);

        return $relative;
    }

    /**
     * @return array{binary:string,extension:string}|null
     */
    protected function compressToLimit(?string $sourcePath, string $extension): ?array
    {
        if (! $sourcePath || ! is_file($sourcePath) || ! function_exists('imagecreatetruecolor')) {
            return null;
        }

        $image = $this->createGdImage($sourcePath, $extension);
        if (! $image) {
            return null;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        if ($width < 1 || $height < 1) {
            imagedestroy($image);

            return null;
        }

        $outputExt = in_array($extension, ['png', 'gif'], true) ? 'jpg' : ($extension === 'jpeg' ? 'jpg' : $extension);

        if ($outputExt === 'jpg') {
            $width = imagesx($image);
            $height = imagesy($image);
            $canvas = imagecreatetruecolor($width, $height);
            if ($canvas) {
                $white = imagecolorallocate($canvas, 255, 255, 255);
                imagefilledrectangle($canvas, 0, 0, $width, $height, $white);
                imagecopy($canvas, $image, 0, 0, 0, 0, $width, $height);
                imagedestroy($image);
                $image = $canvas;
            }
        }
        $quality = 85;

        for ($attempt = 0; $attempt < 12; $attempt++) {
            $binary = $this->encode($image, $outputExt, $quality);
            if ($binary !== null && strlen($binary) <= self::MAX_BYTES) {
                imagedestroy($image);

                return ['binary' => $binary, 'extension' => $outputExt];
            }

            if ($quality > 45) {
                $quality -= 10;

                continue;
            }

            $width = max(1, (int) round($width * 0.82));
            $height = max(1, (int) round($height * 0.82));
            $resized = imagescale($image, $width, $height);
            if (! $resized) {
                break;
            }
            imagedestroy($image);
            $image = $resized;
            $quality = 80;
        }

        $binary = $this->encode($image, $outputExt, max(40, $quality));
        imagedestroy($image);

        return $binary === null ? null : ['binary' => $binary, 'extension' => $outputExt];
    }

    /**
     * @return \GdImage|resource|null
     */
    protected function createGdImage(string $path, string $extension)
    {
        $data = @file_get_contents($path);
        if ($data === false) {
            return null;
        }

        $image = @imagecreatefromstring($data);
        if ($image) {
            return $image;
        }

        return match ($extension) {
            'jpg', 'jpeg' => function_exists('imagecreatefromjpeg') ? @imagecreatefromjpeg($path) : null,
            'png' => function_exists('imagecreatefrompng') ? @imagecreatefrompng($path) : null,
            'gif' => function_exists('imagecreatefromgif') ? @imagecreatefromgif($path) : null,
            'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : null,
            default => null,
        };
    }

    /**
     * @param  \GdImage|resource  $image
     */
    protected function encode($image, string $extension, int $quality): ?string
    {
        ob_start();
        $ok = false;

        if ($extension === 'webp' && function_exists('imagewebp')) {
            $ok = imagewebp($image, null, $quality);
        } elseif ($extension === 'png' && function_exists('imagepng')) {
            $level = (int) round((100 - $quality) / 10);
            $ok = imagepng($image, null, min(9, max(0, $level)));
        } elseif (function_exists('imagejpeg')) {
            if (function_exists('imagepalettetotruecolor')) {
                @imagepalettetotruecolor($image);
            }
            if (function_exists('imagealphablending')) {
                imagealphablending($image, true);
            }
            if (function_exists('imagesavealpha')) {
                imagesavealpha($image, false);
            }
            $ok = imagejpeg($image, null, $quality);
        }

        $binary = ob_get_clean();

        return $ok && is_string($binary) && $binary !== '' ? $binary : null;
    }
}
