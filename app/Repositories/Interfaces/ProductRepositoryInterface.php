<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function all();
    public function find($id);
    public function store($data);
    public function update($data, $product);
    public function forceDelete($product);
}
