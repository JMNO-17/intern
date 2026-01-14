<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\common;
use App\Models\Section;
use Illuminate\Support\Arr;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Interfaces\AboutRepositoryInterface;

class AboutController extends Controller
{
    public $aboutRepository;
    public $sections;
    public function __construct(AboutRepositoryInterface $aboutRepository)
    {
        $this->aboutRepository = $aboutRepository;
        $this->sections = Section::all();
    }

    public function index()
    {
        // dd("This index method is disabled.");
        abort_if(Gate::denies('about_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $abouts = $this->aboutRepository->all();
        return view('admin.abouts.index', compact('abouts'));
    }

    public function create()
    {
        abort_if(Gate::denies('about_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sections = $this->sections;
        return view('admin.abouts.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $this->aboutRepository->store($request->all());
        return redirect()->route('admin.abouts.index')->with('success', __('global.created_success'));
    }

    public function show(About $about)
    {
        abort_if(Gate::denies('about_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $fields = Arr::except($about->getAttributes(), ['id', 'deleted_at', 'created_at', 'updated_at']);
        $fields['section_id'] = optional($about->section)->name;
        $redirect_route = route('admin.abouts.index');
        $label = 'about';
        $images = $about->getMedia('aboutus_image');
        if ($images->isNotEmpty()) {
            $fields['aboutus_image'] = $images;
        }
        return view('admin.common.show', compact('label', 'fields', 'redirect_route'));
    }

    public function edit(About $about)
    {
        abort_if(Gate::denies('about_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sections = $this->sections;
        return view('admin.abouts.edit', compact('about', 'sections'));
    }

    public function update(Request $request, About $about)
    {
        $this->aboutRepository->update($request->all(), $about);
        return redirect()->route('admin.abouts.index')->with('success', __('global.updated_success'));
    }

    public function destroy(About $about)
    {
        abort_if(Gate::denies('about_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->aboutRepository->forceDelete($about);
        return redirect()->back()->with('success', __('global.deleted_success'));
    }

    public function storeMedia(Request $request)
    {
        $path = storage_path('uploads/temp/about/' . Auth::id());
        $file = $request->file('file');
        $response = common::storeMedia($path, $file);
        return $response;
    }

    public function removeMedia(Request $request)
    {
        $type = $request->type;
        $about = About::find($request->id);
        $status = false;
        if ($type == 'aboutus_image') {
            $mediaItem = $about->getMedia('aboutus_image')->first();
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
