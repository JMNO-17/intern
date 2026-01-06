<?php

namespace App\Repositories\Interfaces;

interface SettingRepositoryInterface
{
    public function all();

    public function find($id);

    public function store($data);

    public function update($data);

    public function removeImage($data);
}
