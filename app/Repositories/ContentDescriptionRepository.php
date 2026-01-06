<?php

namespace App\Repositories;

use App\Helpers\MediaUploadHelper;
use App\Models\ContentDescription;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\ContentDescriptionRepositoryInterface;
use Exception;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContentDescriptionRepository implements ContentDescriptionRepositoryInterface
{
    public function all(): Collection
    {
        return ContentDescription::latest()->get();
    }

    public function find($id)
    {
        return $this->all()->find($id);
    }

    public function store($data)
    {

        try {
            DB::beginTransaction();
                $featuredImages = MediaUploadHelper::extractImagesFromData($data, 'featured_image');
                $otherImages = MediaUploadHelper::extractImagesFromData($data, 'other_images');
                $contentdescription = ContentDescription::create($data);
                MediaUploadHelper::processImages($contentdescription, $featuredImages, 'featured_image', 'contentdescription');
                MediaUploadHelper::processImages($contentdescription, $otherImages, 'other_images', 'contentdescriptionOtherImages');
            DB::commit();

            return $contentdescription;
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag([
                'catch_exception' => $e->getMessage(),
            ]));
        }
    }

    public function update($data, $model)
    {
        try {
            DB::beginTransaction();
            MediaUploadHelper::handleImageUpdate($model, $data, 'featured_image', 'contentdescription');
            MediaUploadHelper::handleImageUpdate($model, $data, 'other_images', 'contentdescriptionOtherImages');
            // unset($data['featured_image'], $data['other_images']);
            $model->update($data);
            DB::commit();

            return $model;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ContentDescription update failed', [
                'contentdescription_id' => $model->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag([
                'catch_exception' => $e->getMessage(),
            ]));
        }
    }

    public function forceDelete($section)
    {
        $section->forceDelete();
    }
}
