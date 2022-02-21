<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;

class addRegister extends Component
{
    
    // * Button to create a new register
     

    public $table; // model to create a register
    public $title; // Button legend

    public function __construct($table, $title)
    {
        $this->title = $title;
        $this->table = $table;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.add-register');
    }
}
