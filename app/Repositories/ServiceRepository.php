<?php

namespace App\Repositories;

use Exception;
use App\Models\Service;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\ServiceRepositoryInterface;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function all(): Collection
    {
        return Service::latest()->get();
    }

    public function find($id)
    {
        return $this->all()->find($id);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $serviceImages = $data['service_image'] ?? [];
            unset($data['service_image']);
            $service = Service::create($data);
            DB::commit();

            $tempFolder = storage_path('uploads/temp/service/' . Auth::id());
            foreach ((array) $serviceImages as $file){
                $filePath = $tempFolder . '/' . $file;
                if(is_file($filePath)) {
                    try {
                        $service->addMedia($filePath)->toMediaCollection('service_image');
                    } catch (Exception $e) {
                        Log::warning("Failed to attach media: {$filePath}",[
                            'error' => $e->getMessage(),
                            'service_id' => $service->id,
                        ]);
                    }
                }
            }
            return $service;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Service creation failed', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function update($data, $service)
    {
        try {
            DB::beginTransaction();
            if (isset($data['service_image']) && is_array($data['service_image'])) {
                foreach ($data['service_image'] as $fileName) {
                    $tempPath = storage_path('uploads/temp/service/' .Auth::id() . '/' . $fileName);
                    if (file_exists($tempPath)) {
                        try {
                            $service->addMedia($tempPath)->toMediaCollection('service_image');
                            if (file_exists($tempPath)) {
                                unlink($tempPath);
                            }
                        } catch (Exception $e) {
                            Log::error("Failed to add media file: {$tempPath}", [
                                'error' => $e->getMessage(),
                                'service_id' => $service->id,
                            ]);
                        }
                    } else {
                        Log::warning("service image file not found in temp directory: {$tempPath}", [
                            'service_id' => $service->id,
                            'file_name' => $fileName,
                        ]);
                    }
                }
                $tempFolder = storage_path('uploads/temp/service/' . Auth::id());
                if (File::exists($tempFolder) && count(File::files($tempFolder)) === 0) {
                    File::deleteDirectory($tempFolder);
                }
            }
            unset($data['service_image']);
            $service->update($data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Service update failed', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception' => $e->getMessage()]));
        }
        return $service;

    }


    public function forceDelete($service)
    {
        $service->forceDelete();
    }
}
