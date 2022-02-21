<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;

class formComponent extends Component
{
    /**
        Make a single form option component to be used within formNameComponent
     */

    public $label; // Label lgeend
    public $optionColumn; // column to look for in the model
    public $data; // coming from model controller

    public function __construct($label, $optionColumn, $data)
    {
        $this->label = $label;
        $this->optionColumn = $optionColumn;
        $this->data = $data;
    }

    public function render()
    {
        $label = $this->label;
        $optionColumn = $this->optionColumn;
        $data = $this->data;

        return view(
        'components.admin.form-component',
        compact('label', 'optionColumn', 'data')
        );
    }
}
