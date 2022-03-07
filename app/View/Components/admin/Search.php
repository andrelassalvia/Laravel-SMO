<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Search extends Component
{
    public $name;
    public $table;
    public $placeholder;

    public function __construct($name, $table, $placeholder)
    {
        $this->name = $name;
        $this->table = $table;
        $this->placeholder = $placeholder;
    }

    public function render()
    {
        return view('components.admin.search');
    }
}
