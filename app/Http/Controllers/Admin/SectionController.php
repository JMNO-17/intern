<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Interfaces\SectionRepositoryInterface;

class SectionController extends Controller
{
    public $sectionRepository;
    public function __construct(SectionRepositoryInterface $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function index()
    {
        abort_if(Gate::denies('section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sections = $this->sectionRepository->all();
        return view('admin.sections.index', compact('sections'));
    }

    public function show(Section $section)
    {
        abort_if(Gate::denies('section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $fields = Arr::except($section->getAttributes(), ['id', 'deleted_at', 'created_at', 'updated_at']);
        $fields['menu_id'] = optional($section->menu)->name;

        $redirect_route = route('admin.sections.index');
        $label = 'section';
        return view('admin.common.show', compact('label', 'fields', 'redirect_route'));
    }
}
