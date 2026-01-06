<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeletePopup extends Component
{
    /**
     * Create a new component instance.
     */
    public $id;

    public $action;

    public bool $isDestroy = false;

    public string $restoreText;

    public function __construct($id, $action, bool $isDestroy = false, string $restoreText = '')
    {
        $this->id = $id;
        $this->action = $action;
        $this->isDestroy = $isDestroy; // checck resource destroy or not (resource destroy use DELETE Method)
        $this->restoreText = $restoreText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.delete-popup');
    }
}
