<?php

namespace App\Repositories\Interfaces;

interface ServiceRepositoryInterface
{
    public function all();
    public function find($id);
    public function store($data);
    public function update($data, $service);
    public function forceDelete($service);
}
