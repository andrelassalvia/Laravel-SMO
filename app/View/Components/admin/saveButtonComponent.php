<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;

class saveButtonComponent extends Component
{
    /**
        Create a save button
     */
    public function __construct()
    {

    }

    public function render()
    {
        return view('components.admin.save-button-component');
    }
}
