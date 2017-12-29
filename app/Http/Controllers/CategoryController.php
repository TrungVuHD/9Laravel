<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCategory;
use App\Http\Requests\StoreCategory;
use App\Category;
use App\Post;

class CategoryController extends Controller
{
    /**
     * Display a listing of records
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::paginate(20);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show a record
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $category_id = Category::where('slug', $slug)->first()->id;
        $posts = Post::where('cat_id', $category_id)
            ->withCount(['points', 'comments'])
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return view('9gag.index', compact('category_id', 'posts'));
    }

    /**
     * Show the form for creating a record
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Create a record
     *
     * @param StoreCategory $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCategory $request)
    {
        $category = new Category($request->all());
        $category->slug = str_slug($request->title);
        $category->save();

        return back()->with('status', 'The category has been saved');
    }

    /**
     * Show the form for updating a record
     *
     * @param $category_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($category_id)
    {
        $category = Category::find($category_id);
        return view('categories.create', compact('category'));
    }

    /**
     * Update a record
     *
     * @param UpdateCategory $request
     * @param $category_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCategory $request, $category_id)
    {
        $category = Category::find($category_id);
        $category->fill($request->all());
        $category->slug = str_slug($request->title);
        $category->save();

        return back()->with('status', 'The category has been updated');
    }

    /**
     * Destroy a record
     *
     * @param $category_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($category_id)
    {
        Category::find($category_id)->destroy();

        return back()->with('status', 'The category has been deleted.');
    }
}
