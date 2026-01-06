<?php

namespace App\Repositories;

use App\Models\Section;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\SectionRepositoryInterface;

class SectionRepository implements SectionRepositoryInterface
{
    public function all(): Collection
    {
        return Section::all();
    }

    public function find($id)
    {
        return $this->all()->find($id);
    }

    public function store($data)
    {
        return Section::create($data);
    }

    public function update($data, $section)
    {
        return $section->update($data);
    }

    public function forceDelete($section)
    {
        $section->forceDelete();
    }
}
