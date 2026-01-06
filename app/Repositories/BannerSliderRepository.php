<?php

namespace App\Repositories;

use Exception;
use App\Models\BannerSlider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\BannerSliderRepositoryInterface;

class BannerSliderRepository implements BannerSliderRepositoryInterface
{
    public function all(): Collection
    {
        return BannerSlider::latest()->get();
    }

    public function find($id)
    {
        return $this->all()->find($id);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $bannerImages = $data['banner_image'] ?? [];
            unset($data['banner_image']);
            $bannerslider = BannerSlider::create($data);
            DB::commit();
            // Attach media after commit
            $tempFolder = storage_path('uploads/temp/bannerslider/' . Auth::id());
            foreach ((array) $bannerImages as $file) {
                $filePath = $tempFolder . '/' . $file;
                if (is_file($filePath)) {
                    try {
                        $bannerslider->addMedia($filePath)->toMediaCollection('banner_image');
                    } catch (Exception $e) {
                        Log::warning("Failed to attach media: {$filePath}", [
                            'error' => $e->getMessage(),
                            'bannerslider_id' => $bannerslider->id,
                        ]);
                    }
                }
            }
            // optional cleanup
            // File::deleteDirectory($tempFolder);
            return $bannerslider;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Bannerslider creation failed', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function update($data, $bannerslider)
    {
        try {
            DB::beginTransaction();
            if (isset($data['banner_image']) && is_array($data['banner_image'])) {
                foreach ($data['banner_image'] as $fileName) {
                    $tempPath = storage_path('uploads/temp/bannerslider/' . Auth::id() . '/' . $fileName);
                    if (file_exists($tempPath)) {
                        try {
                            $bannerslider->addMedia($tempPath)->toMediaCollection('banner_image');
                            if (file_exists($tempPath)) {
                                unlink($tempPath);
                            }
                        } catch (Exception $e) {
                            Log::error("Failed to add media file: {$tempPath}", [
                                'error' => $e->getMessage(),
                                'bannerslider_id' => $bannerslider->id,
                            ]);
                        }
                    } else {
                        // For multiple images, just skip if not found in temp, but log for traceability
                        Log::warning("Banner image file not found in temp directory: {$tempPath}", [
                            'bannerslider_id' => $bannerslider->id,
                            'file_name' => $fileName,
                        ]);
                    }
                }
                $tempFolder = storage_path('uploads/temp/bannerslider/' . Auth::id());
                if (File::exists($tempFolder) && count(File::files($tempFolder)) === 0) {
                    File::deleteDirectory($tempFolder);
                }
            }
            unset($data['banner_image']);
            $bannerslider->update($data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Banner Slider update failed', [
                'bannerslider_id' => $bannerslider->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception' => $e->getMessage()]));
        }
        return $bannerslider;
    }

    public function forceDelete($bannerslider)
    {
        $bannerslider->forceDelete();
    }
}
