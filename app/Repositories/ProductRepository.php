<?php

namespace App\Repositories;

use Exception;
use App\Helpers\MediaUploadHelper;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function all(): Collection
    {
        return Product::latest()->get();
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
                $product = Product::create($data);
                MediaUploadHelper::processImages($product, $featuredImages, 'featured_image', 'product');
            DB::commit();

            return $product;
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag([
                'catch_exception' => $e->getMessage(),
            ]));
        }
    }

    //  public function store($data)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $productImages = $data['featured_image'] ?? [];
    //         unset($data['featured_image']);
    //         $product = product::create($data);
    //         DB::commit();

    //         $tempFolder = storage_path('uploads/temp/product/' . Auth::id());
    //         foreach ((array) $productImages as $file){
    //             $filePath = $tempFolder . '/' . $file;
    //             if(is_file($filePath)) {
    //                 try {
    //                     $product->addMedia($filePath)->toMediaCollection('featured_image');
    //                 } catch (Exception $e) {
    //                     Log::warning("Failed to attach media: {$filePath}",[
    //                         'error' => $e->getMessage(),
    //                         'product_id' => $product->id,
    //                     ]);
    //                 }
    //             }
    //         }
    //         return $product;
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::error('product creation failed', [
    //             'error' => $e->getMessage(),
    //         ]);
    //         throw $e;
    //     }
    // }


    public function update($data, $section)
    {
        try {
            DB::beginTransaction();
            MediaUploadHelper::handleImageUpdate($section, $data, 'featured_image', 'product');
            // unset($data['featured_image'], $data['other_images']);
            $section->update($data);
            DB::commit();

            return $section;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Product update failed', [
                'product_id' => $section->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag([
                'catch_exception' => $e->getMessage(),
            ]));
        }
    }

    //   public function update($data, $product)
    // {
    //     try {
    //         DB::beginTransaction();
    //         if (isset($data['featured_image']) && is_array($data['featured_image'])) {
    //             foreach ($data['featured_image'] as $fileName) {
    //                 $tempPath = storage_path('uploads/temp/product/' .Auth::id() . '/' . $fileName);
    //                 if (file_exists($tempPath)) {
    //                     try {
    //                         $product->addMedia($tempPath)->toMediaCollection('featured_image');
    //                         if (file_exists($tempPath)) {
    //                             unlink($tempPath);
    //                         }
    //                     } catch (Exception $e) {
    //                         Log::error("Failed to add media file: {$tempPath}", [
    //                             'error' => $e->getMessage(),
    //                             'product_id' => $product->id,
    //                         ]);
    //                     }
    //                 } else {
    //                     Log::warning("product image file not found in temp directory: {$tempPath}", [
    //                         'product_id' => $product->id,
    //                         'file_name' => $fileName,
    //                     ]);
    //                 }
    //             }
    //             $tempFolder = storage_path('uploads/temp/product/' . Auth::id());
    //             if (File::exists($tempFolder) && count(File::files($tempFolder)) === 0) {
    //                 File::deleteDirectory($tempFolder);
    //             }
    //         }
    //         unset($data['featured_image']);
    //         $product->update($data);
    //         DB::commit();
    //     } catch (Exception $e) {
    //         DB::rollback();
    //         Log::error('product update failed', [
    //             'product_id' => $product->id,
    //             'error' => $e->getMessage(),
    //         ]);
    //         return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception' => $e->getMessage()]));
    //     }
    //     return $product;

    // }



    public function forceDelete($product)
    {
        $product->forceDelete();
    }
}

