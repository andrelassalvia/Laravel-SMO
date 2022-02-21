<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;

class backButtonComponent extends Component
{
    /**
     * Link to return to index page
     */

    public $model; // model we are working

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.back-button-component');
    }

    public function routeModel()
    {
        $table = $this->model->getTable();
        return $table;
    }
}
