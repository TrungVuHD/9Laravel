<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Category;

class CategoriesController extends Controller
{

	public function index()
	{

		$categories = Category::paginate(15);

		return view('categories.index', [ 'categories' => $categories ]);
	}

	public function show ()
	{

		return view('categories.show');
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
		$image_name = str_random(20);
		$image_name .= '.'.$request->image->getClientOriginalExtension();

		$file = $request
			->image
			->move('category-images', $image_name);

		$category->title = $request->title;
		$category->slug = str_slug($request->title);
		$category->description = $request->description;
		$category->published = $request->published;
		$category->show_in_menu = $request->show_in_menu;
		$category->image = $file->getPathname();

		$category->save();

		return redirect()
			->back()
			->with('status', 'The category has been saved');

	}

	public function edit(Request $request, $category)
	{

		$categoryObject = Category::where('id', $category)->firstOrFail();

		return view('categories.create', ['category' => $categoryObject]);
	}

	public function update(Request $request, $category)
	{

		$this->validate($request, [
			'title' => 'required|max:255',
			'description' => 'required',
			'published' => 'required|integer',
			'show_in_menu' => 'required|integer',
			'image' => 'image',
		]);

		// Update the image only if the file input selected a file 
		if(isset($request->image)) {

			// Upload the image and generate the random file name
			// I was unable to use the request store function 
			// or the Storage Facade to upload images
			$image_name = str_random(20);
			$image_name .= '.'.$request->image->getClientOriginalExtension();

			$file = $request
				->image
				->move('category-images', $image_name);
		}

		$categoryObject = Category::where('id', $category)->firstOrFail();
		
		
		$categoryObject->title = $request->title;
		$categoryObject->slug = str_slug($request->title);
		$categoryObject->description = $request->description;
		$categoryObject->published = $request->published;
		$categoryObject->show_in_menu = $request->show_in_menu;
		$categoryObject->image = isset($file) ? $file->getPathname() : $categoryObject->image;

		$categoryObject->save();

		return redirect()
			->back()
			->with('status', 'The category has been updated');


	}
}
