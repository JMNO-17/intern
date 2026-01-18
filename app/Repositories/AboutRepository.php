<?php

namespace App\Repositories;

use Exception;
use App\Models\About;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\AboutRepositoryInterface;

class AboutRepository implements AboutRepositoryInterface
{
    public function all(): Collection
    {
        return About::latest()->get();
    }

    public function find($id)
    {
        return $this->all()->find($id);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $aboutImages = $data['about_image'] ?? [];
            unset($data['about_image']);
            $about = About::create($data);
            DB::commit();
            // Attach media after commit
            $tempFolder = storage_path('uploads/temp/about/' . Auth::id());
            foreach ((array) $aboutImages as $file) {
                $filePath = $tempFolder . '/' . $file;
                if (is_file($filePath)) {
                    try {
                        $about->addMedia($filePath)->toMediaCollection('about_image');
                    } catch (Exception $e) {
                        Log::warning("Failed to attach media: {$filePath}", [
                            'error' => $e->getMessage(),
                            'about_id' => $about->id,
                        ]);
                    }
                }
            }
            // optional cleanup
            // File::deleteDirectory($tempFolder);
            return $about;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('About creation failed', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function update($data, $about)
    {
        try {
            DB::beginTransaction();
            if (isset($data['about_image']) && is_array($data['about_image'])) {
                foreach ($data['about_image'] as $fileName) {
                    $tempPath = storage_path('uploads/temp/about/' . Auth::id() . '/' . $fileName);
                    if (file_exists($tempPath)) {
                        try {
                            $about->addMedia($tempPath)->toMediaCollection('about_image');
                            if (file_exists($tempPath)) {
                                unlink($tempPath);
                            }
                        } catch (Exception $e) {
                            Log::error("Failed to add media file: {$tempPath}", [
                                'error' => $e->getMessage(),
                                'about_id' => $about->id,
                            ]);
                        }
                    } else {
                        // For multiple images, just skip if not found in temp, but log for traceability
                        Log::warning("About image file not found in temp directory: {$tempPath}", [
                            'about_id' => $about->id,
                            'file_name' => $fileName,
                        ]);
                    }
                }
                $tempFolder = storage_path('uploads/temp/about/' . Auth::id());
                if (File::exists($tempFolder) && count(File::files($tempFolder)) === 0) {
                    File::deleteDirectory($tempFolder);
                }
            }
            unset($data['about_image']);
            $about->update($data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('About update failed', [
                'about_id' => $about->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception' => $e->getMessage()]));
        }
        return $about;
    }

    public function forceDelete($about)
    {
        $about->forceDelete();
    }
}
