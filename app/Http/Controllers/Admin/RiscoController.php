<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Risco;
use App\Models\TipoRisco;
use App\Models\AtendimentoRisco;
use App\Models\GrupoRisco;

use App\Http\Requests\Admin\RiscoFormRequest;
use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\DeleteRegister;
use App\Classes\ChangeRegister;
use App\Classes\SearchRequest;


class RiscoController extends Controller
{
    public function __construct(
        Risco $risco,
        TipoRisco $tipoRisco,
        AtendimentoRisco $atendimentoRisco,
        GrupoRisco $grupoRisco
        
    ) {
        $this->risco = $risco;
        $this->tipoRisco = $tipoRisco;
        $this->atendimentoRisco = $atendimentoRisco;
        $this->grupoRisco = $grupoRisco;
    }

    public function index()
    {
        $riscos = new CollectData($this->risco);
        $data = $riscos->collection('nome', 'ASC', false);

        return view ('admin.risco.index', compact('data'));
    }
   
    public function create()
    {
        $data = $this->risco;
        $tipoRiscos = new CollectData($this->tipoRisco);
        $tipoRiscos = $tipoRiscos->collection('nome', 'ASC', true);

        return view ('admin.risco.create', compact('tipoRiscos', 'data'));
    }
     
    public function store(RiscoFormRequest $request)
    {
        $dataForm = $request->validated();
        $nome = $dataForm['nome'];
        $tipoRisco_id = $dataForm['tiporisco_id'];
        
        $riscos = new SaveInDatabase($this->risco);
        $riscos = $riscos->saveDatabase(
            ['nome', 'tiporisco_id'],
            [$nome, $tipoRisco_id],
            'risco.index',
            ['success' => 'Risco cadastrado com sucesso'],
            'risco.create',
            ['errors' => 'Risco já cadastrado'],
            ''
        );

        return $riscos;
    }

    public function show($id)
    {
        $data = $this->risco->find($id);
    
        return view ('admin.risco.show', compact('data'));
    }

    public function edit($id)
    {
      $data = $this->risco->find($id);

      $tipoRiscos = new CollectData($this->tipoRisco);
      $tipoRiscos = $tipoRiscos->collection('nome', 'ASC', true);

      return view(
          'admin.risco.edit', 
          compact('data', 'tipoRiscos')
      );
    }

    public function update(RiscoFormRequest $request, $id)
    {
        $dataForm = $request->validated();
        $nome = 
            $dataForm['nome'];
        $tipoRisco_id = $dataForm['tiporisco_id'];

        $riscos = new ChangeRegister($this->risco);
        $riscos = $riscos->changeRegisterInDatabase(
            $id,
            ['nome', 'tiporisco_id'],
            [$nome, $tipoRisco_id],
            'risco.index',
            ['success' => 'Registro alterado com sucesso'],
            'risco.edit',
            ['errors' => 'Registro já cadastrado na base de dados']
        );

        return $riscos;
    }

    public function destroy($id)
    {
        $riscos = new DeleteRegister($this->risco);
        $riscos = $riscos->erase(
            $id,
            [$this->atendimentoRisco, $this->grupoRisco],
            ['risco_id'],
            'risco.show',
            'risco.index',
            ['success' => 'Registro deletado com sucesso'],
            ''
        );

        return $riscos;
    }

    public function search(Request $request)
    {
        $dataForm = $request->only('nome');
        $nome = "%".$dataForm['nome']."%";
        $riscos = new SearchRequest($this->risco);
        $riscos = $riscos->searchIt('nome', [$nome]);

        return view('admin.risco.index' ,compact('riscos'));
    }
}
