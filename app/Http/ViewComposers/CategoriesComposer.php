<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Category;

class CategoriesComposer
{
    /**
     * Add the categories variables to every single view
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $menu_categories = Category::where('published', 1)->get();
        $menu_visible_categories = Category::where('show_in_menu', 1)->where('published', 1)->get();

        $view->with(compact('menu_categories', 'menu_visible_categories'));
    }
}
