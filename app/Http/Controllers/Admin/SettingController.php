<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Repositories\Interfaces\SettingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class SettingController extends Controller
{
    public $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->can('setting_edit')) {
            abort(403);
        }

        // $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.edit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $files = [];
        $content = [];
        foreach ($request->all() as $key => $value) {
            if ($request->hasFile($key)) {
                $files[$key] = $request->file($key);
            } else {
                $content[$key] = $value;
            }
        }
        $input['files'] = $files;
        $input['content'] = $content;

        $this->settingRepository->update($input);

        return redirect()->back()->with('success', __('global.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        abort_if(Gate::denies('setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $setting = $this->settingRepository->removeImage($request);

        // return response()->json([
        //     'success' => 'Successfully Delete Existing Image of '.$setting->display_name.'.',
        //     'setting' => $setting,
        // ], 200);
    }
}
