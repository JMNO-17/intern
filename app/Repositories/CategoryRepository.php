<?php

namespace App\Repositories;

use Exception;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(): Collection
    {
        return Category::latest()->get();
    }

    public function find($id)
    {
        return $this->all()->find($id);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $categoryImages = $data['category_image'] ?? [];
            unset($data['category_image']);
            $category = Category::create($data);
            DB::commit();

            $tempFolder = storage_path('uploads/temp/category/' . Auth::id());
            foreach ((array) $categoryImages as $file){
                $filePath = $tempFolder . '/' . $file;
                if(is_file($filePath)) {
                    try {
                        $category->addMedia($filePath)->toMediaCollection('category_image');
                    } catch (Exception $e) {
                        Log::warning("Failed to attach media: {$filePath}",[
                            'error' => $e->getMessage(),
                            'category_id' => $category->id,
                        ]);
                    }
                }
            }
            return $category;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Category creation failed', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function update($data, $category)
    {
        try {
            DB::beginTransaction();
            if (isset($data['category_image']) && is_array($data['category_image'])) {
                foreach ($data['category_image'] as $fileName) {
                    $tempPath = storage_path('uploads/temp/category/' .Auth::id() . '/' . $fileName);
                    if (file_exists($tempPath)) {
                        try {
                            $category->addMedia($tempPath)->toMediaCollection('category_image');
                            if (file_exists($tempPath)) {
                                unlink($tempPath);
                            }
                        } catch (Exception $e) {
                            Log::error("Failed to add media file: {$tempPath}", [
                                'error' => $e->getMessage(),
                                'category_id' => $category->id,
                            ]);
                        }
                    } else {
                        Log::warning("Category image file not found in temp directory: {$tempPath}", [
                            'category_id' => $category->id,
                            'file_name' => $fileName,
                        ]);
                    }
                }
                $tempFolder = storage_path('uploads/temp/category/' . Auth::id());
                if (File::exists($tempFolder) && count(File::files($tempFolder)) === 0) {
                    File::deleteDirectory($tempFolder);
                }
            }
            unset($data['category_image']);
            $category->update($data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Category update failed', [
                'category_id' => $category->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception' => $e->getMessage()]));
        }
        return $category;

    }


    public function forceDelete($category)
    {
        $category->forceDelete();
    }
}
