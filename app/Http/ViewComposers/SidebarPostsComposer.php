<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SidebarPostsComposer
{

    protected $posts;

    public function compose(View $view)
    {
        $this->posts = DB::table('posts')
            ->orderBy(DB::raw('RAND()'))
            ->take(30)
            ->get();

        $view->with([
            'sidebarPosts' => $this->posts
        ]);
    }
}
