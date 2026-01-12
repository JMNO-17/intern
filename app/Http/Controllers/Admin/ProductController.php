<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\common;
use App\Models\Category;


use Illuminate\Support\Arr;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductController extends Controller
{
    public $productRepository;
    public $categories;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->categories = Category::all();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $products = $this->productRepository->all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories =$this->categories;
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->productRepository->store($request->all());
        return redirect()->route('admin.products.index')->with('success', __('global.created_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        abort_if(Gate::denies('product_access'),Response::HTTP_FORBIDDEN, '403 Forbidden');
        $fields = Arr::except($product->getAttributes(), ['id', 'deleted_at', 'created_at', 'updated_at']);
        $fields['category_id'] = optional($product->category)->name;

        $redirect_route = route('admin.products.index');
        $label = 'product';
        $images = $product->getMedia('product_image');
        if ($images->isNotEmpty()) {
            $fields['product_image'] = $images;
        }
        return view('admin.common.show', compact('label', 'fields', 'redirect_route'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories =$this->categories;
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->productRepository->update($request->all(), $product);
        return redirect()->route('admin.products.index')->with('success', __('global.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->productRepository->forceDelete($product);
        return redirect()->back()->with('success', __('global.deleted_success'));
    }

    public function storeMedia(Request $request)
    {
        $path = storage_path('uploads/temp/product/' . Auth::id());
        $file = $request->file('file');
        $response = common::storeMedia($path, $file);
        return $response;
    }

    public function removeMedia(Request $request)
    {
        $type = $request->type;
        $product = product::find($request->id);
        $status = false;
        if ($type == 'product_image') {
            $mediaItem = $product->getMedia('product_image')->first();
            if ($mediaItem) {
                $mediaItem->delete();
                $status = true;
            }
        }
        return response()->json([
            'status' => $status,
            'type' => $type,
        ]);
    }

    public function changeStatus(Request $request)
    {
        $activeCount = User::where('status', true)->count();
        if ($activeCount <= 1 && $request->status == 'false') {
            return response()->json(['error' => 'One User Must Be Active.'], 400);
        } else {
            $user = User::find($request->id);
            $user->status = $request->status == 'false' ? false : true;
            if ($request->status == false) {
                $user->save();
            } elseif ($request->status == true) {
                $user->save();
            }
            $user->save();
            return response()->json(['success' => 'Successfully change status.'], 200);
        }
    }
}
