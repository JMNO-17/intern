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
                $otherImages = MediaUploadHelper::extractImagesFromData($data, 'other_images');
                $product = Product::create($data);
                MediaUploadHelper::processImages($product, $featuredImages, 'featured_image', 'product');
                MediaUploadHelper::processImages($product, $otherImages, 'other_images', 'productOtherImages');
            DB::commit();

            return $product;
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag([
                'catch_exception' => $e->getMessage(),
            ]));
        }
    }

    public function update($data, $section)
    {
        try {
            DB::beginTransaction();
            MediaUploadHelper::handleImageUpdate($section, $data, 'featured_image', 'product');
            MediaUploadHelper::handleImageUpdate($section, $data, 'other_images', 'productOtherImages');
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

    public function forceDelete($product)
    {
        $product->forceDelete();
    }
}

