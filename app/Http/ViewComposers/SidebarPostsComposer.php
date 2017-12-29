<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Post;

class SidebarPostsComposer
{
    /**
     * Add the sidebar_posts variable to all views
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $sidebar_posts = Post::inRandomOrder()->paginate(30);
        $view->with(compact('sidebar_posts'));
    }
}
