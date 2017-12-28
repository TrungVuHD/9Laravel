<?php

namespace App\Http\Services;

use App\Comment;
use App\Post;
use Illuminate\Database\Eloquent\Collection;

class PostService extends Service
{
    /**
     * Return the number of comments
     *
     * @param Collection $comments
     * @param Collection $sub_comments
     * @return int
     */
    public function noComments(Collection $comments, Collection $sub_comments)
    {
        return (int) ($comments->count() + $sub_comments->count());
    }

    /**
     * Store a post image to the filesystem
     */
    public function storeImage($request)
    {
        $is_base_64 = (bool)$request->base_64;
        $dir = Post::IMG_DIR;
        self::createDirs();

        if ($is_base_64) {
            return ImageService::storeBase64Image($request->image, $dir);
        }

        return ImageService::storeImageFile($request->image, $dir);
    }

    /**
     * Create Post directories
     */
    public static function createDirs()
    {
        clearstatcache();

        $parent_dir = storage_path('app' . self::DS . 'public' . self::DS . Post::IMG_DIR);

        $dirs = ImageService::SIZES;

        array_walk($dirs, function ($dir) use ($parent_dir) {
            $path = $parent_dir . DIRECTORY_SEPARATOR . $dir;

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        });
    }
}
