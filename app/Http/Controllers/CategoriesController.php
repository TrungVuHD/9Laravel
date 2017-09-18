<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Category;
use App\Post;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(15);
        return view('categories.index', ['categories' => $categories ]);
    }

    public function show(Request $request, $category)
    {
        $category = Category::where('slug', $category)->first();
        $category_id = isset($category->id) ? $category->id : 0;
        $posts = Post::where('cat_id', $category_id)->orderBy('id', 'DESC')->paginate(20);

        if ($category_id == 0) {
            abort(404);
        }

        return view('9gag.index', ['category_id' => $category_id, 'posts' => $posts]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'published' => 'required|integer',
            'show_in_menu' => 'required|integer',
            'image' => 'image',
        ]);

        $category = new Category();

        // Upload the image and generate the random file name
        // I was unable to use the request store function
        // or the Storage Facade to upload images
        $image_dir = base_path().DS.'public'.DS.'img'.DS.'categories';
        $image_name = str_random(20);
        $image_name .= '.'.$request->image->getClientOriginalExtension();
        $image_location = $image_dir.DS.$image_name;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request
                ->image
                ->move($image_dir, $image_name);

            $category->image = $image_name;

            $img = Image::make($image_location);
            $img->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($image_location, 70);
        }

        $category->title = $request->title;
        $category->slug = str_slug($request->title);
        $category->description = $request->description;
        $category->published = $request->published;
        $category->show_in_menu = $request->show_in_menu;

        $category->save();

        return redirect()
            ->back()
            ->with('status', 'The category has been saved');
    }

    public function edit(Request $request, $category)
    {
        $category = Category::where('id', $category)->firstOrFail();
        return view('categories.create', ['category' => $category]);
    }

    public function update(Request $request, $category)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'published' => 'required|integer',
            'show_in_menu' => 'required|integer'
        ]);

        $category = Category::where('id', $category)->firstOrFail();
        $category->title = $request->title;
        $category->slug = str_slug($request->title);
        $category->description = $request->description;
        $category->published = $request->published;
        $category->show_in_menu = $request->show_in_menu;
        $category->save();

        return redirect()
            ->back()
            ->with('status', 'The category has been updated');
    }

    public function destroy(Request $request, $category)
    {
        Category::destroy($category);
        return redirect()
            ->back()
            ->with('status', 'The category has been deleted.');
    }
}
