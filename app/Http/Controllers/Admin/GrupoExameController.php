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
use App\Classes\DeleteRegister;

class GrupoExameController extends Controller
{
    public function __construct(
        GrupoExame $grupoExame,
        Grupo $grupo,
        Exame $exame,
        TipoAtendimento $tipoAtendimento
    ) {
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
        $dataform = $request->validated();
        $exame_id = $dataform['exame_id'];
        $tipoatendimento_id = $dataform['tipoatendimento_id'];

        $grupoExames = new SaveInDatabase($this->grupoExame);
        $grupoExames = $grupoExames->saveDatabase(
            ['grupo_id', 'exame_id', 'tipoatendimento_id'],
            [$id, $exame_id, $tipoatendimento_id],
            'grupoexame.index',
            ['success' => 'Registro cadastrado com sucesso'],
            'grupoexame.index',
            ['errors' => 'Este registro já consta no banco de dados'],
            $id
        );

        return $grupoExames;
    }

    public function destroy($id)
    {
        $register = $this->grupoExame->find($id);
        $grupo_id = $register['grupo_id'];
        
        $deleted = new DeleteRegister($this->grupoExame);
        $deleted = $deleted->erase(
            $id,
            [],
            [],
            'grupoexame.index',
            'grupoexame.index',
            ['success' => 'Registro deletado com sucesso'],
            $grupo_id
        );

        return $deleted;
    }
}
