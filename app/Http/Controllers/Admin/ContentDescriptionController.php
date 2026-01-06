<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\common;
use App\Http\Controllers\Controller;
use App\Models\ContentDescription;
use App\Models\Section;
use App\Repositories\Interfaces\ContentDescriptionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ContentDescriptionController extends Controller
{
    public $contentdescriptionRepository;
    public $sections;
    public function __construct(ContentDescriptionRepositoryInterface $contentdescriptionRepository) {
        $this->contentdescriptionRepository = $contentdescriptionRepository;
        $this->sections = Section::all();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('contentdescription_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $this->contentdescriptionRepository->all();
        return view('admin.contentdescriptions.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('contentdescription_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sections = $this->sections;
        return view('admin.contentdescriptions.create',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('contentdescription_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->contentdescriptionRepository->store($request->all());
        // dd($request->all());
        return redirect()->route('admin.contentdescriptions.index')->with('success', __('global.created_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ContentDescription $contentdescription)
    {
        abort_if(Gate::denies('contentdescription_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $fields = Arr::except($contentdescription->getAttributes(), ['id', 'deleted_at', 'created_at', 'updated_at']);
        $fields['section_id'] = optional($contentdescription->section)->name;

        // $custom_fields = [
        //     'section_id' => $contentdescription->section->name
        // ];
        // foreach ($custom_fields as $key => $value) {
        //     $fields[$key] = $value;
        // }

        $redirect_route = route('admin.contentdescriptions.index');
        $label = 'contentdescription';
        $featured_image = $contentdescription->getMedia('featured_image')->first();
        if ($featured_image) {
            $fields['featured_image'] = $contentdescription->getMedia('featured_image')->first();
        }

        $otherImages = $contentdescription->getMedia('other_images');
        if ($otherImages->isNotEmpty()) {
            $fields['other_images'] = $otherImages;
        }

        return view('admin.common.show',compact('label','fields','redirect_route'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentDescription $contentdescription)
    {
        abort_if(Gate::denies('contentdescription_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sections = $this->sections;
        return view('admin.contentdescriptions.edit',compact('contentdescription','sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentDescription $contentdescription)
    {
        abort_if(Gate::denies('contentdescription_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->contentdescriptionRepository->update($request->all(),$contentdescription);
        return redirect()->route('admin.contentdescriptions.index')->with('success', __('global.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentDescription $contentdescription)
    {
        abort_if(Gate::denies('contentdescription_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->contentdescriptionRepository->forceDelete($contentdescription);
        return redirect()->route('admin.contentdescriptions.index')->with('success', __('global.deleted_success'));
    }

    public function storeMedia(Request $request)
    {
        if ($request->header('type')) {
            $path = storage_path('uploads/temp/contentdescriptionOtherImages/' . Auth::id());
        } else {
            $path = storage_path('uploads/temp/contentdescription/' . Auth::id());
        }

        $file = $request->file('file');
        $response = common::storeMedia($path, $file);
        return $response;
    }

    public function removeMedia(Request $request)
    {
        $type = $request->type;
        $contentdescription = ContentDescription::find($request->id);
        $status = false;
        if (! $contentdescription) {
            return response()->json([
                'status' => false,
                'type' => $type,
                'message' => 'Content Description not found.',
            ], 404);
        }
        if ($type == 'featured_image') {
            $contentdescription->clearMediaCollection('featured_image');
            $status = true;
        } elseif ($type == 'other_images') {
            if ($request->has('type') == 'other_images') {
                $media = $contentdescription->getMedia('other_images')->where('name', $request->file_name)->first();
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
}
