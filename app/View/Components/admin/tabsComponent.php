<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;

class tabsComponent extends Component
{
    /**
     * Create a single navigation tab
     */
    public $active; // define if this is the active tab ('active' or '')
    public $route; // target route
    public $id; // data id coming from controller
    public $tabName; // written on tab legend
       
    public function __construct($active, $route, $id, $tabName)
    {
        $this->active = $active;
        $this->route = $route;
        $this->id = $id;
        $this->tabName = $tabName;
    }


    public function render()
    {
        $active = $this->active;
        $route = $this->route;
        $id = $this->id;
        $tabName = $this->tabName;

        return view(
        'components.admin.tabs-component',
        compact('active', 'route', 'id', 'tabName')
        );
    }
}

