<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class RequestComposer
{
    /**
     * Add the request variable to all views
     *
     * @param View $view
     * @param Request $request
     */
    public function compose(View $view, Request $request)
    {
        $view->with('request', $request);
    }
}

