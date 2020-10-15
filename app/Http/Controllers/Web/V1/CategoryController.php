<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\WebBaseController;
use App\Http\Forms\Web\V1\CategoryWebForm;
use App\Http\Requests\Web\V1\CategoryWebRequest;
use App\Models\Entities\Category;
use Illuminate\Http\Request;

class CategoryController extends WebBaseController
{
    public function index() {
        $categories = Category::paginate(10);
        $category_web_form = CategoryWebForm::inputGroups();
        return $this->adminPagesView('category.index', compact('categories', 'category_web_form'));
    }

    public function store(CategoryWebRequest $request) {
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        $this->added();
        return redirect()->route('category.index');
    }


    public function update(CategoryWebRequest $request) {
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->save();
        $this->edited();
        return redirect()->route('category.index');
    }

    public function delete(CategoryWebRequest $request) {
        Category::destroy($request->id);
        $this->deleted();
        return redirect()->route('category.index');
    }
}
