<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;

class listComponent extends Component
{
    /**
        Table with a collection list
     */

    public $data; // data coming from controller
    public $column; // Column name on table

    public function __construct($data, $column)
    {
        $this->data = $data;
        $this->column = $column;
    }

    public function render()
    {
        $data = $this->data;
        return view('components.admin.list-component', compact('data'));
    }

    public function tableName()
    {
        return $this->data[0]->getTable();
    }
}
