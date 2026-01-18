<?php

namespace App\Repositories\Interfaces;

interface AboutRepositoryInterface
{
    public function all();
    public function find($id);
    public function store($data);
    public function update($data, $section);
    public function forceDelete($section);
}
