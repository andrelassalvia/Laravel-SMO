<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class BasicForm extends Component
{
    public $data; // data coming from controller
    public $blade; // create, edit, show or index
    public $group; // case blade = index => the name of group model

    public function __construct($data, $blade, $group)
    {
        $this->data = $data;
        $this->blade = $blade;
        $this->group = $group;
    }

    public function render()
    {
        return view('components.forms.basic-form');
    }

    public function tableName()
    {
        return $this->data->getTable();
    }

    public function routeModel()
    {
        switch ($this->blade) {
            case 'create':
                return $this->tableName().".store";
                break;

            case 'edit':
                return $this->tableName().".update";
                break;

            case 'index':
                return $this->group.".store"; 
                break;
            
            default:
                return $this->tableName().".destroy";
                break;
        }
    }

    public function info()
    {
        if($this->blade == 'create'){
            return null;
        } else {
            return $this->data->id;
        }
    }
}
