<?php

namespace App\Http\Services;

use Intervention\Image\Image;
use grandt\ResizeGif\ResizeGif;
use Illuminate\Support\Facades\Storage;

class ImageService
{

    /**
     * Store a regular image file in the filesystem
     *
     * @param $image
     * @param $directory
     * @return array
     */
    public static function storeImageFile($image, $directory)
    {
        $extension = self::extension($image);

        if ($extension === false) {
            return [];
        }

        // store the file
        $image_location = Storage::putFile($directory, $image);

        return self::createReturnData($image_location, $extension);
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
        $image_data = explode(',', $image);
        $base_64_data = base64_decode($image_data[1]);

        // store the string
        $image_location = Storage::putFile($directory, $base_64_data);

        return self::createReturnData($image_location, $extension);
    }

    /**
     * Create an array containing all the data regarding an image store
     *
     * @param $image_location
     * @param $extension
     * @return array
     */
    protected static function createReturnData($image_location, $extension)
    {
        $data = [];
        $data['location'] = $image_location;
        $data['tall_image'] = self::checkImageHeight($image_location);

        if ($extension === ".gif") {
            $data['gif_image'] = true;
            self::createGIFImageVersions($image_dir, $image_file);
        } else {
            $data['gif_image'] = false;
            self::createImageVersions($image_dir, $image_file);
        }

        return $data;
    }

    /**
     * Return the file extension of a file
     *
     * @param $file
     * @return bool|mixed
     */
    public static function extension($file)
    {
        $tmp_dir = sys_get_temp_dir();
        $tmp_file = str_random(20);
        $tmp_location = $tmp_dir.DS.$tmp_file;

        copy($file, $tmp_location);
        $mime_type = mime_content_type($tmp_location);
        unlink($tmp_location);

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
        $handler = finfo_open();
        $mime_type = finfo_buffer($handler, $image_data, FILEINFO_MIME_TYPE);
        finfo_close($handler);

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
        if (strpos($mime, 'image')) {
            return str_replace('image/', '.', $mime);
        }

        return false;
    }

    public static function base64ToImage($base64_string, $output_file)
    {

    }

    public static function checkImageHeight($img)
    {
        $image = new Image();
        $img_height = $image->make($img)->height();
        if ($img_height > 900) {
            return 1;
        }
        return 0;
    }

    public static function createGIFImageVersions($dir, $file)
    {
        $png_file = substr($file, 0, strpos($file, '.gif'));
        $png_file .= '.png';

        // big image - gif
        ResizeGif::ResizeToWidth($dir.$file, $dir.$file.'_temp', 600);

        rename($dir.$file.'_temp', $dir.$file);

        // medium image - gif
        ResizeGif::ResizeToWidth($dir.$file, $dir.DS.'460'.DS.$file, 460);

        // medium image - png
        $img = Image::make($dir.$file);
        $img->resize(460, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($dir.DS.'460'.DS.$png_file, 70);

        // small image - png
        $img->resizeCanvas(300, 160, 'center');
        $img->save($dir.DS.'300'.DS.$png_file, 70);
    }

    public static function createImageVersions($dir, $file)
    {
        // big image
        $img = Image::make($dir.$file);
        $img->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($dir.$file, 70);
        $img->save($dir.$file, 70);

        // medium image
        $img->resize(460, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($dir.DS.'460'.DS.$file, 70);

        // small image
        $img->resizeCanvas(300, 160, 'center');
        $img->save($dir.DS.'300'.DS.$file, 70);
    }
}
