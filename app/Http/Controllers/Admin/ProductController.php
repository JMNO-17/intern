<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\common;
use App\Models\Section;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
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
    public $sections;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->sections = Section::all();
    }

    public function index()
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $products = $this->productRepository->all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sections =$this->sections;
        return view('admin.products.create', compact('sections'));
    }

    public function store(StoreProductRequest $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'price' => 'required|numeric|min:0',
        //     'section_id' => 'required|exists:sections,id',
        // ]);


        $this->productRepository->store($request->all());
        return redirect()->route('admin.products.index')->with('success', __('global.created_success'));
    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $fields = Arr::except($product->getAttributes(), ['id', 'deleted_at', 'created_at', 'updated_at']);
        $fields['section_id'] = optional($product->section)->name;
        $redirect_route = route('admin.products.index');
        $label = 'product';
        $images = $product->getMedia('featured_image');
        if ($images->isNotEmpty()) {
            $fields['featured_image'] = $images;
        }
        $otherImages = $product->getMedia('other_images');
        if ($otherImages->isNotEmpty()) {
            $fields['other_images'] = $otherImages;
        }
        return view('admin.common.show', compact('label', 'fields', 'redirect_route'));

    }

    public function edit(Product $product)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sections =$this->sections;
        return view('admin.products.edit', compact('product', 'sections'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productRepository->update($request->all(), $product);
        return redirect()->route('admin.products.index')->with('success', __('global.updated_success'));
    }


    public function destroy(product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->productRepository->forceDelete($product);
        return redirect()->back()->with('success', __('global.deleted_success'));
    }

    public function storeMedia(Request $request)
    {
        if ($request->header('type')) {
            $path = storage_path('uploads/temp/productOtherImages/' . Auth::id());
        } else {
            $path = storage_path('uploads/temp/product/' . Auth::id());
        }

        $file = $request->file('file');
        $response = common::storeMedia($path, $file);
        return $response;
    }

    public function removeMedia(Request $request)
    {
        $type = $request->type;
        $product = product::find($request->id);
        $status = false;
        if (! $product) {
            return response()->json([
                'status' => false,
                'type' => $type,
                'message' => 'Content Description not found.',
            ], 404);
        }
        if ($type == 'featured_image') {
            $product->clearMediaCollection('featured_image');
            $status = true;
        } elseif ($type == 'other_images') {
            if ($request->has('type') == 'other_images') {
                $media = $product->getMedia('other_images')->where('name', $request->file_name)->first();
                if ($media) {
                    $media->delete();
                    $status = true;
                }
            }
            $status = true;
        }

        return response()->json([
            'status' => $status,
            'type' => $type,
        ]);
    }

    public function changeStatus(Request $request)
    {
        $activeCount = Product::where('status', true)->count();
        if ($activeCount <= 1 && $request->status == 'false') {
            return response()->json(['error' => 'One Product Must Be Active.'], 400);
        } else {
            $Product = Product::find($request->id);
            $Product->status = $request->status == 'false' ? false : true;
            if ($request->status == false) {
                $Product->save();
            } elseif ($request->status == true) {
                $Product->save();
            }
            $Product->save();
            return response()->json(['success' => 'Successfully change status.'], 200);
        }
    }
}
