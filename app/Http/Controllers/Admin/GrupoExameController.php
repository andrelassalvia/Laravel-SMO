<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\GrupoExame;
use App\Models\Grupo;
use App\Models\Exame;
use App\Models\TipoAtendimento;

use App\Http\Requests\Admin\GrupoExameFormRequest;
use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\CheckDataBase;
use App\Classes\DeleteRegister;
use App\Classes\CheckToDelete;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;

class GrupoExameController extends Controller
{
    use SuccessRedirectMessage, FailRedirectMessage;

    public function __construct(
        GrupoExame $grupoExame,
        Grupo $grupo,
        Exame $exame,
        TipoAtendimento $tipoAtendimento
    ) 
    {
        $this->grupoExame = $grupoExame;
        $this->grupo = $grupo;
        $this->exame = $exame;
        $this->tipoAtendimento = $tipoAtendimento;
    }

    public function index($id)
    {
        $data = $this->grupo->find($id);
        $exames = new CollectData($this->exame);
        $exames = $exames->collection(
            'nome',
            'ASC',
            true
        );
        $tipoAtendimentos = new CollectData($this->tipoAtendimento);
        $tipoAtendimentos = $tipoAtendimentos->collection(
            'nome',
            'ASC',
            true
        );
        $grupoExames = $this->grupoExame->where('grupo_id', $id)->get();
        return view(
            'Admin.grupoExame.index', 
            compact('data', 'exames', 'tipoAtendimentos', 'grupoExames') 
        );
    }

    public function store(GrupoExameFormRequest $request, $id)
    {
        $dataForm = $request->validated();
        $data = new CheckDataBase($this->grupoExame);
        $data = $data->checkInDatabase(
            ['grupo_id', 'exame_id', 'tipoatendimento_id'], 
            [$id, $dataForm['exame_id'], $dataForm['tipoatendimento_id']]);
        if($data){
            $store = new SaveInDatabase($this->grupoExame);
            $store = $store->saveDatabase($data);
            return SuccessRedirectMessage::successRedirect(
                'grupoexame.index',
                ['success' => 'Registro cadastrado com sucesso'],
                $id
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'grupoexame.index',
                ['errors' => 'Registro já cadastrado'],
                $id
            );
        }
    }

    public function destroy($id)
    {
        $register = $this->grupoExame->find($id);
        $mainId = $register['grupo_id'];
        $check = new CheckToDelete($this->grupoExame);
        $check = $check->checkDb(
            $id,
            [],
            []
        );
        if($check){
            return FailRedirectMessage::failRedirect(
                'grupoexame.index',
                ['errors' => "Existe um registro vinculado a ". $check['table']],
                $id
            );
        } else {
            $delete = new DeleteRegister($this->grupoExame);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'grupoexame.index',
                ['success' => 'Registro apagado com sucesso'],
                $mainId
            );
        }
    }
}
