<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Category;
use App\Post;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function show(Request $request, $slug)
    {
        $category_id = $this->categoryRepository->getIdBySlug($slug);
        $posts = Post::where('cat_id', $category_id)->orderBy('id', 'DESC')->paginate(20);

        return view('9gag.index', compact('category_id', 'posts'));
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

        // add the processed slug variable to the request array
        $slug = str_slug($request->title);
        $request->request->add(['slug' => $slug]);

        $category = new Category($request->all());
        $category->save();

        return redirect()
            ->back()
            ->with('status', 'The category has been saved');
    }

    public function edit(Request $request, $category_id)
    {
        $category = $this->categoryRepository->getById($category_id);
        return view('categories.create', compact('category'));
    }

    public function update(Request $request, $category_id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'published' => 'required|integer',
            'show_in_menu' => 'required|integer'
        ]);

        // add the processed slug variable to the request array
        $slug = str_slug($request->title);
        $request->request->add(['slug' => $slug]);

        $category = $this->categoryRepository->getById($category_id);
        $category->fill($request->all());
        $category->save();

        return redirect()
            ->back()
            ->with('status', 'The category has been updated');
    }

    public function destroy(Request $request, $category_id)
    {
        $category = $this->categoryRepository->getById($category_id);
        $this->categoryRepository->destroy($category);

        return redirect()
            ->back()
            ->with('status', 'The category has been deleted.');
    }
}
