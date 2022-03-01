<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class DisabledInput extends Component
{
    public $data;
    public $blade;

    public function __construct($data, $blade)
    {
        $this->data = $data;
        $this->blade = $blade;
    }

    public function render()
    {
        return view('components.forms.disabled-input');
    }

    public function label()
    {
        $tableName = $this->data->getTable();
        switch ($tableName) {
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
        return Str::ucfirst($tableName);
        
    }

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
}
