<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TipoAtendimento;
use App\Models\Atendimento;
use App\Models\GrupoExame;

use App\Http\Requests\Admin\TipoAtendimentoFormRequest;
use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\DeleteRegister;
use App\Classes\ChangeRegister;
use App\Classes\SearchRequest;

class TipoAtendimentoController extends Controller
{
    public function __construct(
        TipoAtendimento $tipoAtendimento,
        Atendimento $atendimento,
        GrupoExame $grupoExame
        )
    {
        $this->tipoAtendimento = $tipoAtendimento;
        $this->atendimento = $atendimento;
        $this->grupoExame = $grupoExame;
    }

    public function index()
    {
        $tipoAtendimentos = new CollectData($this->tipoAtendimento);
        $data = $tipoAtendimentos->collection(
            'nome', 
            'ASC',
            false
        );
        return view(
            'admin.tipoAtendimento.index', 
            compact('data')
        );
    }

    public function create()
    {
        $data = $this->tipoAtendimento;
        return view('admin.tipoAtendimento.create', compact('data'));
    }

    public function store(TipoAtendimentoFormRequest $request)
    {
        $dataForm = $request->validated();
        $nome = $dataForm['nome'];

        $tipoAtendimentos = new SaveInDatabase($this->tipoAtendimento);
        $tipoAtendimentos = $tipoAtendimentos->saveDatabase(
            ['nome'],
            [$nome],
            'tipoatendimento.index',
            ['success' => 'Registro cadastrado com sucesso'],
            'tipoatendimento.create',
            ['errors' => 'Registro já cadastrado'],
            ''
        );

        return $tipoAtendimentos;
    }

    public function show($id)
    {
        $data = $this->tipoAtendimento->find($id);

        return view(
            'admin.tipoAtendimento.show', 
            compact('data'));
    }

    public function edit($id)
    {
        $data = $this->tipoAtendimento->find($id);

        return view(
            'admin.tipoAtendimento.edit',
            compact('data')
        );
    }

    public function update(TipoAtendimentoFormRequest $request, $id)
    {
        $dataForm = $request->validated();
        $nome = $dataForm['nome'];
        $tipoAtendimentos = new ChangeRegister($this->tipoAtendimento);
        $tipoAtendimentos = $tipoAtendimentos->changeRegisterInDatabase(
            $id,
            ['nome'],
            [$nome],
            'tipoatendimento.index',
            ['success' => 'Registro alterado com sucesso'],
            'tipoatendimento.edit',
            ['errors' => 'Registro já cadastrado no banco de dados']
        );

        return $tipoAtendimentos;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipoAtendimentos = new DeleteRegister($this->tipoAtendimento);
        $tipoAtendimentos = $tipoAtendimentos->erase(
            $id,
            [$this->atendimento, $this->grupoExame],
            ['tipoatendimento_id'],
            'tipoatendimento.show',
            'tipoatendimento.index',
            ['success' => 'Registro deletado com sucesso'],
            ''
        );

        return $tipoAtendimentos;
    }

    public function search(Request $request)
    {
        $dataForm = $request->only('nome');
        $data = '%'.$dataForm['nome'].'%';

        $tipoAtendimentos = new SearchRequest($this->tipoAtendimento);
        $tipoAtendimentos = $tipoAtendimentos->searchIt(
            'nome',
           ['data' => $data]
        );

        return view(
            'admin.tipoAtendimento.index',
            compact('tipoAtendimentos', 'data')
        );
    }
}
