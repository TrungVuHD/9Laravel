<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', 'App\Http\ViewComposers\RequestComposer');
        View::composer('includes/sidebar', 'App\Http\ViewComposers\SidebarPostsComposer');
        View::composer(
            [
                'includes/top-menu',
                'includes/modals'
            ],
            'App\Http\ViewComposers\CategoriesComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
