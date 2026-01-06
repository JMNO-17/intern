<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\common;
use App\Models\Section;
use Illuminate\Support\Arr;
use App\Models\BannerSlider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Interfaces\BannerSliderRepositoryInterface;

class BannerSliderController extends Controller
{
    public $bannersliderRepository;
    public $sections;
    public function __construct(BannerSliderRepositoryInterface $bannersliderRepository)
    {
        $this->bannersliderRepository = $bannersliderRepository;
        $this->sections = Section::all();
    }

    public function index()
    {
        abort_if(Gate::denies('bannerslider_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $bannersliders = $this->bannersliderRepository->all();
        return view('admin.bannersliders.index', compact('bannersliders'));
    }

    public function create()
    {
        abort_if(Gate::denies('bannerslider_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sections = $this->sections;
        return view('admin.bannersliders.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $this->bannersliderRepository->store($request->all());
        return redirect()->route('admin.bannersliders.index')->with('success', __('global.created_success'));
    }

    public function show(BannerSlider $bannerslider)
    {
        abort_if(Gate::denies('bannerslider_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $fields = Arr::except($bannerslider->getAttributes(), ['id', 'deleted_at', 'created_at', 'updated_at']);
        $fields['section_id'] = optional($bannerslider->section)->name;

        $redirect_route = route('admin.bannersliders.index');
        $label = 'bannerslider';
        $images = $bannerslider->getMedia('banner_image');
        if ($images->isNotEmpty()) {
            $fields['banner_image'] = $images;
        }
        return view('admin.common.show', compact('label', 'fields', 'redirect_route'));
    }

    public function edit(BannerSlider $bannerslider)
    {
        abort_if(Gate::denies('bannerslider_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sections = $this->sections;
        return view('admin.bannersliders.edit', compact('bannerslider', 'sections'));
    }

    public function update(Request $request, BannerSlider $bannerslider)
    {
        $this->bannersliderRepository->update($request->all(), $bannerslider);
        return redirect()->route('admin.bannersliders.index')->with('success', __('global.updated_success'));
    }

    public function destroy(BannerSlider $bannerslider)
    {
        abort_if(Gate::denies('bannerslider_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->bannersliderRepository->forceDelete($bannerslider);
        return redirect()->back()->with('success', __('global.deleted_success'));
    }

    public function storeMedia(Request $request)
    {
        $path = storage_path('uploads/temp/bannerslider/' . Auth::id());
        $file = $request->file('file');
        $response = common::storeMedia($path, $file);
        return $response;
    }

    public function removeMedia(Request $request)
    {
        $type = $request->type;
        $bannerslider = BannerSlider::find($request->id);
        $status = false;
        if ($type == 'banner_image') {
            $mediaItem = $bannerslider->getMedia('banner_image')->first();
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
