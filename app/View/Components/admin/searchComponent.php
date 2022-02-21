<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;

class searchComponent extends Component
{
    /**
        Create a field to search for registers
     */
    public $table; // working model
    public $placeholder; // written on placeholder field
    
    public function __construct($table, $placeholder)
    {
        $this->table = $table;
        $this->placeholder = $placeholder;
    }

    public function render()
    {
        return view('components.admin.search-component');
    }

    
}
