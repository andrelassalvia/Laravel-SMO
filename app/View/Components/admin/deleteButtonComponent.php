<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;

class deleteButtonComponent extends Component
{
    /**
     * Create a delete button
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.delete-button-component');
    }
}
