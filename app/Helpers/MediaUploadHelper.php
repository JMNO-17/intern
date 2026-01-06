<?php

namespace App\Helpers;

use Exception;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MediaUploadHelper
{
    /**
     * @param  $data
     * @param $key
     * @return array
    */
    public static function extractImagesFromData(&$data, $key)
    {
        if (empty($data[$key])) {
            return [];
        }
        $images = $data[$key];
        unset($data[$key]);
        return is_array($images) ? $images : [];
    }

    /**
     * @param  $model
     * @param  $images
     * @param  $collection
     * @param  $tempFolderName
     * @return void
    */
    public static function processImages($model, $images, $collection, $tempFolderName)
    {
        if (empty($images)) {
            return;
        }
        $tempFolder = self::getTempFolderPath($tempFolderName);
        foreach ($images as $fileName) {
            $filePath = $tempFolder . '/' . $fileName;
            if (file_exists($filePath)) {
                self::addMediaToCollection($model, $filePath, $collection);
            }
        }
        self::cleanupTempFolder($tempFolder);
    }

    /**
     * @param  $folderName
     * @return string
    */
    private static function getTempFolderPath($folderName)
    {
        return storage_path("uploads/temp/{$folderName}/" . Auth::id());
    }

    /**
     * @param  $model
     * @param  $filePath
     * @param  $collection
     * @return void
    */
    private static function addMediaToCollection($model, $filePath, $collection)
    {
        try {
            $model->addMedia($filePath)->toMediaCollection($collection);
        } catch (Exception $e) {
            Log::error("Failed to add {$collection} file: {$filePath}", [
                'error' => $e->getMessage(),
                'contentdescription_id' => $model->id,
            ]);
        }
    }

    /**
     * @param  $tempFolder
     * @return void
    */
    public static function cleanupTempFolder($tempFolder)
    {
        if (File::exists($tempFolder)) {
            File::deleteDirectory($tempFolder);
        }
    }

    /**
     * @param  $model
     * @param  $data
     * @param  $imageKey
     * @param  $tempFolderName
     * @return void
    */
    public static function handleImageUpdate($model, &$data, $imageKey, $tempFolderName)
    {
        if (!isset($data[$imageKey]) || !is_array($data[$imageKey])) {
            unset($data[$imageKey]);
            return;
        }
        $tempFolder = self::getTempFolderPath($tempFolderName);
        $collection = $imageKey;
        foreach ($data[$imageKey] as $fileName) {
            $tempPath = $tempFolder . '/' . $fileName;
            if (file_exists($tempPath)) {
                self::addMediaToCollection($model, $tempPath, $collection);
                self::deleteFile($tempPath);
            } else {
                self::checkExistingMedia($model, $fileName, $collection);
            }
        }
        self::cleanupEmptyTempFolder($tempFolder);
        unset($data[$imageKey]);
    }

    private static function deleteFile($filePath)
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    private static function checkExistingMedia($model, $fileName, $collection)
    {
        $existingMedia = $model->getMedia($collection)->where('file_name', $fileName)->first();
        if (!$existingMedia) {
            Log::warning("Image file not found in temp directory", [
                'contentdescription_id' => $model->id,
                'file_name' => $fileName,
                'collection' => $collection,
            ]);
        }
    }

    private static function cleanupEmptyTempFolder($tempFolder)
    {
        if (File::exists($tempFolder) && count(File::files($tempFolder)) === 0) {
            File::deleteDirectory($tempFolder);
        }
    }

}
