<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TipoAtendimento;
use App\Models\Atendimento;
use App\Models\GrupoExame;

use App\Http\Requests\Admin\TipoAtendimentoFormRequest;
use App\Classes\TipoAtendimento\CollectData;
use App\Classes\TipoAtendimento\SaveInDatabase;
use App\Classes\TipoAtendimento\DeleteRegister;
use App\Classes\TipoAtendimento\ChangeRegister;
use App\Classes\TipoAtendimento\SearchRequest;

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
        $tipoAtendimentos = $tipoAtendimentos->collection(
            'nome', 
            'ASC'
        );
        return view(
            'admin.tipoAtendimento.index', 
            compact('tipoAtendimentos')
        );
    }

    public function create()
    {
        return view('admin.tipoAtendimento.create');
    }

    public function store(TipoAtendimentoFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = filter_var(
            $dataForm['nome'],
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );

        $tipoAtendimentos = new SaveInDatabase($this->tipoAtendimento);
        $tipoAtendimentos = $tipoAtendimentos->saveDatabase(
            ['nome'],
            [$nome],
            'tipoAtendimentos.index',
            ['success' => 'Registro cadastrado com sucesso'],
            'tipoAtendimentos.create',
            ['errors' => 'Registro já cadastrado'],
            ''
        );

        return $tipoAtendimentos;
    }

    public function show($id)
    {
        $tipoAtendimentos = $this->tipoAtendimento->find($id);

        return view(
            'admin.tipoAtendimento.show', 
            compact('tipoAtendimentos'));
    }

    public function edit($id)
    {
        $tipoAtendimentos = $this->tipoAtendimento->find($id);

        return view(
            'admin.tipoAtendimento.edit',
            compact('tipoAtendimentos')
        );
    }

    public function update(TipoAtendimentoFormRequest $request, $id)
    {
        $dataForm = $request->all();
        $nome = filter_var(
            $dataForm['nome'],
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
        $tipoAtendimentos = new ChangeRegister($this->tipoAtendimento);
        $tipoAtendimentos = $tipoAtendimentos->changeRegisterInDatabase(
            $id,
            ['nome'],
            [$nome],
            'tipoAtendimentos.index',
            ['success' => 'Registro alterado com sucesso'],
            'tipoAtendimentos.edit',
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
            'tipoAtendimentos.show',
            'tipoAtendimentos.index',
            ['success' => 'Registro deletado com sucesso'],
            ''
        );

        return $tipoAtendimentos;
    }

    public function search(Request $request)
    {
        $dataForm = $request->all();
        $data = filter_var(
            '%'.$dataForm['nome'].'%',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );

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
