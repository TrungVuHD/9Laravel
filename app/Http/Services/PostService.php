<?php

namespace App\Http\Services;

use App\Comment;
use App\Post;

class PostService extends Service
{
    /**
     * Return the number of comments
     *
     * @param Comment $comments
     * @param Comment $sub_comments
     * @return int
     */
    public function noComments(Comment $comments, Comment $sub_comments)
    {
        return (int) ($comments->count() + $sub_comments->get()->count());
    }

    /**
     * Store a post image to the filesystem
     */
    public function storeImage($request)
    {
        $is_base_64 = !$request->notBase64Image;
        $dir = Post::IMG_DIR;
        $this->createDirs();

        if ($is_base_64) {
            return ImageService::storeBase64Image($request->image, $dir);
        }

        return ImageService::storeImageFile($request->image, $dir);
    }

    /**
     * Create Post directories
     */
    public function createDirs()
    {
        clearstatcache();

        $parent_dir = storage_path(Post::IMG_DIR);

        $dirs = [ 'original', '600', '460', '300' ];

        array_walk($dirs, function ($dir) use ($parent_dir) {
            $path = $parent_dir . DIRECTORY_SEPARATOR . $dir;

            if (!file_exists($path)) {
                mkdir($path, 755, true);
            }
        });
    }
}
