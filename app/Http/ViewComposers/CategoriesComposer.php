<?php 

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Category;


class CategoriesComposer 
{

	protected $categories;
	protected $menuCategories;

	public function compose(View $view) 
	{	
		$this->categories = Category::where('published', 1)->get();
		$this->menuCategories = Category::where('show_in_menu', 1)->where('published', 1)->get();

		$view->with([
			'menuPostCategories' => $this->categories,
			'menuVisiblePostCategories' => $this->menuCategories,
		]);
	}
}