<?php

namespace App\Http\Services;

use grandt\ResizeGif\ResizeGif;
use Illuminate\Support\Facades\Storage;
use Image;

class ImageService extends Service
{
    /**
     * The constant containing all image widths that should be created
     */
    const SIZES = [
        600,
        400,
        200
    ];

    /**
     * Store a regular image file in the filesystem
     *
     * @param $image
     * @param $directory
     * @return array
     */
    public static function storeImageFile($image, $directory)
    {
        $extension = self::fileExtension($image);
        if ($extension === false) {
            return [];
        }

        $file_name = str_random(60) . "{$extension}";
        $file_location = $directory . DS . $file_name;

        if (starts_with($image, 'http')) {
            $image = file_get_contents($image);
        }

        // store the file
        $was_stored = Storage::put($file_location, $image);

        return self::createReturnData($file_location, $was_stored);
    }

    /**
     * Store a base64 image in the filesystem
     *
     * @param $image
     * @param $directory
     * @return array
     */
    public static function storeBase64Image($image, $directory)
    {
        $extension = self::base64ImageExtension($image);

        if ($extension === false) {
            return [];
        }

        // create the base64 string to be stored
        $file_name = str_random(20) . "{$extension}";
        $file_location = $directory . DIRECTORY_SEPARATOR . $file_name;
        $image_data = explode(',', $image);
        $base_64_data = base64_decode($image_data[1]);

        // store the string
        $was_stored = Storage::put($file_location, $base_64_data);

        return self::createReturnData($file_location, $was_stored);
    }

    /**
     * Create an array containing all the data regarding an image store
     *
     * @param $storage_path
     * @param $success
     * @return array
     */
    protected static function createReturnData($storage_path, $success)
    {
        if (!$success) {
            return [];
        }

        $data = [];
        $absolute_path = storage_path('app' . DS . 'public' . DS . $storage_path);
        $extension = pathinfo($absolute_path, PATHINFO_EXTENSION);
        $data['location'] = $absolute_path;
        $data['image'] = $data['basename'] = basename($absolute_path);
        $data['tall_image'] = self::isTall($absolute_path);
        $data['gif'] = $extension === "gif";

        if ($extension === "gif") {
            self::multipleGifSizes($absolute_path, self::SIZES);
        } else {
            self::multipleSizes($absolute_path, self::SIZES);
        }

        return $data;
    }

    /**
     * Return the file extension of a file
     *
     * @param $file
     * @return bool|mixed
     */
    public static function fileExtension($file)
    {
        $tmp_file_location = sys_get_temp_dir() . DS . str_random(20);

        copy($file, $tmp_file_location);
        $mime_type = mime_content_type($tmp_file_location);
        unlink($tmp_file_location);

        return self::extensionFromMime($mime_type);
    }

    /**
     * Return the file extension of a base64 string
     *
     * @param $base64
     * @return bool|mixed
     */
    public static function base64ImageExtension($base64)
    {
        $data = explode(',', $base64);
        $image_data = base64_decode($data[1]);
        $finfo_handle = finfo_open();
        $mime_type = finfo_buffer($finfo_handle, $image_data, FILEINFO_MIME_TYPE);
        finfo_close($finfo_handle);

        return self::extensionFromMime($mime_type);
    }

    /**
     * Create image extensions from mime types
     *
     * @param $mime
     * @return bool|mixed
     */
    public static function extensionFromMime($mime)
    {
        if (strpos($mime, 'image') !== -1) {
            return str_replace('image/', '.', $mime);
        }

        return false;
    }

    /**
     * Check to see if the image is tall
     *
     * @param $location
     * @return bool
     */
    public static function isTall($location)
    {
        $img = Image::make($location);
        $height = $img->height();
        $width = $img->width();

        return ($height / $width) > 3;
    }

    /**
     * Generate different GIF and non-GIF image sizes
     *
     * @param string $path
     * @param array $sizes
     * @return array
     */
    public static function multipleGifSizes(string $path, array $sizes)
    {
        $dir = dirname($path);
        $file = basename($path);
        $versions = [];

        array_walk($sizes, function ($size) use ($path, $dir, $file, $versions) {
            $destination = $dir . DS . $size . DS . $file;
            ResizeGif::ResizeToWidth($path, $destination, (int)$size);
            $versions[] = [
                'type' => 'gif',
                'size' => $size
            ];
        });

        return $versions + self::multipleSizes($path, $sizes);
    }

    /**
     * Generate different image sizes
     *
     * @param string $path
     * @param array $sizes
     * @return array
     */
    public static function multipleSizes(string $path, array $sizes)
    {
        $dir = dirname($path);
        $file = basename($path);
        $versions = [];

        array_walk($sizes, function ($size) use ($path, $dir, $file, $versions) {
            $store_path = $dir . DS . $size . DS . $file;
            $img = Image::make($path);
            $img->resize((int)$size, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($store_path, 70);
            $versions[] = [
                'type' => 'non-gif',
                'size' => $size
            ];
        });

        return $versions;
    }
}
