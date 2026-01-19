<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\common;
use App\Models\Section;
use Illuminate\Support\Arr;
use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $serviceRepository;
    public $sections;
    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->sections = Section::all();

    }
    public function index()
    {
        abort_if(Gate::denies('service_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $services = $this->serviceRepository->all();
        return view('admin.services.index', compact('services'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('service_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sections = $this->sections;
        return view('admin.services.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $this->serviceRepository->store($request->all());
        return redirect()->route('admin.services.index')->with('success', __('global.created_success'));
    }

    /**
     * Display the specified resource.
     */
   public function show(Service $service)
{
    abort_if(Gate::denies('service_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    // Get all attributes except timestamps and id
    $fields = Arr::except($service->getAttributes(), ['id', 'deleted_at', 'created_at', 'updated_at']);

    // Replace section_id with section name
    $fields['section_id'] = optional($service->section)->name;

    // Include images if exist
    $images = $service->getMedia('service_image');
    if ($images->isNotEmpty()) {
        $fields['service_image'] = $images;
    }

    // Pass to generic show view
    $redirect_route = route('admin.services.index');
    $label = 'service';

    return view('admin.common.show', compact('label', 'fields', 'redirect_route'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        // dd($service);
        abort_if(Gate::denies('service_edit'),Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sections = $this->sections;
        return view('admin.services.edit', compact('service', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $this->serviceRepository->update($request->all(),$service);
        return redirect()->route('admin.services.index')->with('success', __('global.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        abort_if(Gate::denies('service_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->serviceRepository->forceDelete($service);
        return redirect()->back()->with('success', __('global.deleted_success'));
    }

    public function storeMedia(Request $request)
    {
        $path = storage_path('uploads/temp/service/' .Auth::id());
        $file = $request->file('file');
        $response = common::storeMedia($path, $file);
        return $response;
    }

    public function removeMedia(Request $request)
    {

        $type = $request->type;
        $fileName = $request->file_name ?? null;
        $service = Service::find($request->id);
        $status = false;
        if ($type == 'service_image' && $fileName && $service) {
            $mediaItem = $service->getMedia('service_image')->firstWhere('file_name', $fileName);
            if (! $mediaItem) {
                 $mediaItem = $service->getMedia('service_image')->filter(function($m) use ($fileName) {
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
