<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\common;
use App\Models\Section;
use Illuminate\Support\Arr;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;

    }
    public function index()
    {
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = $this->categoryRepository->all();
        return view('admin.categories.index', compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $sections = $this->sections;
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->categoryRepository->store($request->all());
        return redirect()->route('admin.categories.index')->with('success', __('global.created_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        abort_if(Gate::denies('category_access'),Response::HTTP_FORBIDDEN, '403 Forbidden');
        $fields = Arr::except($category->getAttributes(), ['id', 'deleted_at', 'created_at', 'updated_at']);
        // $fields['section_id'] = optional($category->section)->name;

        $redirect_route = route('admin.categories.index');
        $label = 'category';
        $images = $category->getMedia('category_image');
        if ($images->isNotEmpty()) {
            $fields['category_image'] = $images;
        }
        return view('admin.common.show', compact('label', 'fields', 'redirect_route'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // dd($cate gory);
        abort_if(Gate::denies('category_edit'),Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $sections = $this->sections;
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->categoryRepository->update($request->all(),$category);
        return redirect()->route('admin.categories.index')->with('success', __('global.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(category $category)
    {
        abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->categoryRepository->forceDelete($category);
        return redirect()->back()->with('success', __('global.deleted_success'));
    }

    public function storeMedia(Request $request)
    {
        $path = storage_path('uploads/temp/category/' .Auth::id());
        $file = $request->file('file');
        $response = common::storeMedia($path, $file);
        return $response;
    }

    public function removeMedia(Request $request)
    {

        $type = $request->type;
        $fileName = $request->file_name ?? null;
        $category = Category::find($request->id);
        $status = false;
        if ($type == 'category_image' && $fileName && $category) {
            $mediaItem = $category->getMedia('category_image')->firstWhere('file_name', $fileName);
            if (! $mediaItem) {
                 $mediaItem = $category->getMedia('category_image')->filter(function($m) use ($fileName) {
                    return $m->file_name === $fileName;
                })->first();
            }
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
}
