<?php

namespace App\Http\Controllers\Web\V1;

use App\Exceptions\Web\WebServiceExplainedException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\WebBaseController;
use App\Http\Forms\Web\V1\ProductWebForm;
use App\Http\Requests\Web\V1\ProductCategoryWebRequest;
use App\Http\Requests\Web\V1\ProductWebRequest;
use App\Models\Entities\Product;
use App\Services\Common\V1\Support\FileService;
use Illuminate\Http\Request;

class ProductController extends WebBaseController
{
    protected $fileService;

    function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }


    public function index(ProductCategoryWebRequest $request) {
        $category_id = $request->category_id;
        $products = Product::where('category_id', $category_id)->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends(request()->query());
        return $this->adminPagesView('product.index', compact('products', 'category_id'));
    }

    public function create(ProductCategoryWebRequest $request) {
        $category_id = $request->category_id;
        $product_web_form = ProductWebForm::inputGroups(null);
        return $this->adminPagesView('product.create', compact('category_id', 'product_web_form'));
    }

    public function store(ProductCategoryWebRequest $productCategoryWebRequest, ProductWebRequest $request) {
        $category_id = $productCategoryWebRequest->category_id;
        $path = null;
        try {
            $path = $this->fileService->store($request->image, Product::IMAGE_DIRECTORY);

            Product::create([
                'category_id' => $category_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'image_path' => $path
            ]);
            $this->added();
        } catch (\Exception $exception) {
            if($path) $this->fileService->remove($path);
            throw new WebServiceExplainedException($exception->getMessage());
        }
        return redirect()->route('product.index', ['category_id' => $category_id]);
    }

    public function edit(ProductCategoryWebRequest $request) {
        $product = Product::find($request->id);
        $category_id = $request->category_id;
        $product_web_form = ProductWebForm::inputGroups($product);
        return $this->adminPagesView('product.edit', compact('category_id',
            'product_web_form', 'product'));
    }

    public function update(ProductCategoryWebRequest $productCategoryWebRequest, ProductWebRequest $request) {
        $category_id = $productCategoryWebRequest->category_id;
        $product = Product::find($productCategoryWebRequest->id);
        $old_path = $product->image_path;
        try {
            if($request->image) {
                $path = $this->fileService->updateWithRemoveOrStore($request->image, Product::IMAGE_DIRECTORY, $old_path);
                $old_path = $path;
            }
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'image_path' => $old_path
            ]);
            $this->edited();
        } catch (\Exception $exception) {
            if($path) $this->fileService->remove($path);
            throw new WebServiceExplainedException($exception->getMessage());
        }
        return redirect()->route('product.index', ['category_id' => $category_id]);
    }
}
