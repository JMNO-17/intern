<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    public function all();
    public function find($id);
    public function store($data);
    public function update($data, $category);
    public function forceDelete($category);
}
