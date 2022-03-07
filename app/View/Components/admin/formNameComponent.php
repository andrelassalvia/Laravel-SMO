<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class formNameComponent extends Component
{
    /**
     * basic form to create, edit and show a register
     */

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
        return view('components.admin.form-name-component');
    }

    public function tableName()
    {

        return $this->data->getTable();
    }

    // which route the model will go
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

    // returns the if necessary id from data
    public function info()
    {
        if($this->blade == 'create'){
            return null;
        } else {
            return $this->data->id;
        }
    }

    // Uppercase model name to use in label
    public function modelUpper()
    {
        switch ($this->tableName()) {
            case 'tipoatendimento':
                return 'Tipo de Atendimento';
                break;

            case 'tipousuario':
                return 'Tipo de Usuário';
                break;
            
            default:
                '';
                break;
        }
        return Str::ucfirst($this->tableName());
    }

    // fill field vlaue with correct argument
    public function value()
    {
        $val = null;

        if($this->blade == 'create'){
          $val = old('nome');
        } else {
           $val = $this->data->nome;
        }

        return $val;
    }

    // if rendering show the input field must be disabled
    public function able()
    {
        if($this->blade == 'show' || $this->blade == 'index'){
            return 'readonly';
        }
    }
}
