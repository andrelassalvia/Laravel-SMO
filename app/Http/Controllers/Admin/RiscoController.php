<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Risco;
use App\Models\TipoRisco;
use App\Models\AtendimentoRisco;
use App\Models\GrupoRisco;
use App\Http\Requests\Admin\RiscoFormRequest;
use App\Classes\Risco\CollectData;
use App\Classes\Risco\SaveInDatabase;
use App\Classes\Risco\DeleteRegister;
use App\Classes\Risco\ChangeRegister;
use App\Classes\Setor\SearchRequest;


class RiscoController extends Controller
{
    public function __construct
    (
        Risco $risco,
        TipoRisco $tipoRisco,
        AtendimentoRisco $atendimentoRisco,
        GrupoRisco $grupoRisco
        
    )
    {
        $this->risco = $risco;
        $this->tipoRisco = $tipoRisco;
        $this->atendimentoRisco = $atendimentoRisco;
        $this->grupoRisco = $grupoRisco;
    }

    public function index()
    {
        $riscos = new CollectData($this->risco);
        $riscos = $riscos->collection('nome', 'ASC');

        return view ('admin.risco.index', compact('riscos'));
    }
   
    public function create()
    {
        $tipoRiscos = new CollectData($this->tipoRisco);
        $tipoRiscos = $tipoRiscos->collection('nome', 'ASC');
        // dd($tipoRiscos);
        return view ('admin.risco.create', compact('tipoRiscos'));
    }
     
    public function store(RiscoFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = filter_var($dataForm['nome'], FILTER_SANITIZE_STRING);
        $tipoRisco_id = filter_var($dataForm['tiporisco_id'], FILTER_SANITIZE_STRING);
        
        $riscos = new SaveInDatabase($this->risco);
        $riscos = $riscos->saveDatabase
        (
            ['nome', 'tiporisco_id'],
            [$nome, $tipoRisco_id],
            'riscos.index',
            ['success' => 'Risco cadastrado com sucesso'],
            'riscos.create',
            ['errors' => 'Risco já cadastrado'],
            ''
            
        );

        return $riscos;
    }

    public function show($id)
    {
        $risco = $this->risco->find($id);
    
        return view ('admin.risco.show', compact('risco'));
    }

    public function edit($id)
    {
      $risco = $this->risco->find($id);
      $tipoRisco = $risco->tiporisco->nome;

      $tipoRiscos = new CollectData($this->tipoRisco);
      $tipoRiscos = $tipoRiscos->collection('nome', 'ASC');

      return view('admin.risco.edit',
        [
            'risco' => $risco, 
            'tipoRisco' =>$tipoRisco, 
            'tipoRiscos' => $tipoRiscos
        ]);
    }

    public function update(RiscoFormRequest $request, $id)
    {
        $dataForm = $request->all();
        $nome = filter_var($dataForm['nome'], FILTER_SANITIZE_STRING);
        $tipoRisco_id = filter_var($dataForm['tiporisco_id'], FILTER_SANITIZE_STRING);

        $riscos = new ChangeRegister($this->risco);
        $riscos = $riscos->changeRegisterInDatabase
        (
            $id,
            ['nome', 'tiporisco_id'],
            [$nome, $tipoRisco_id],
            'riscos.index',
            ['success' => 'Registro alterado com sucesso'],
            'riscos.edit',
            ['errors' => 'Registro já cadastrado na base de dados']
        );

        return $riscos;
    }

    public function destroy($id)
    {
        $riscos = new DeleteRegister($this->risco);
        $riscos = $riscos->erase
        (
            $id,
            [$this->atendimentoRisco, $this->grupoRisco],
            ['risco_id'],
            'riscos.show',
            'riscos.index',
            ['success' => 'Registro deletado com sucesso'],
            ''

        );

        return $riscos;
    }

    public function search(Request $request)
    {
        $dataForm = $request->all();
        $nome = filter_var("%".$dataForm['nome']."%", FILTER_SANITIZE_STRING);
        $riscos = new SearchRequest($this->risco);
        $riscos = $riscos->searchIt
        (
            'nome',
            [$nome]

        );

        return view('admin.risco.index' ,compact('riscos'));
    }
}
