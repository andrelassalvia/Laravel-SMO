<?php

namespace App\Http\Controllers\Admin;

use App\Classes\CheckDataBase;
use App\Classes\SaveInDatabase;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\EmpregadoFormRequest;
use App\Models\Empregado;
use App\Models\Setor;
use App\Models\Funcao;
use App\Models\Grupo;
use App\Classes\CollectData;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;

class EmpregadoController extends Controller
{
    use FailRedirectMessage, SuccessRedirectMessage;

    public function __construct(
        Setor $setor,
        Funcao $funcao,
        Grupo $grupo
    )
    {
        $this->setor = $setor;
        $this->funcao = $funcao;
        $this->grupo = $grupo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Empregado $empregado)
    {
        $data = new CollectData($empregado);
        $data = $data->collection('nome', 'ASC', false);
        return view('admin.empregado.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Empregado $empregado)
    {
        $setor = new CollectData($this->setor);
        $setor = $setor->collection('nome', 'ASC', 'true');
        // dd($setor);
        $funcao = $this->funcao->where('id', '0')->orderBy('nome', 'ASC')->get();
        $grupo = $this->grupo->where('id', '0')->orderBy('nome', 'ASC')->get();
        $data = $empregado;
        return view(
            'admin.empregado.create', 
            compact('setor', 'funcao', 'grupo', 'data')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpregadoFormRequest $request, Empregado $empregado)
    {
        $dataForm = $request->validated();
        $data = new CheckDataBase($empregado);
        $data = $data->checkInDatabase(
            ['cpf', 'ctps', 'serie'], 
            [$dataForm['cpf'], $dataForm['ctps'], $dataForm['serie']]
        );
       if($data){
           $store = new SaveInDatabase($empregado);
           $store = $store->saveDatabase($dataForm);
           if($store){
               return SuccessRedirectMessage::successRedirect(
                   'empregados.index',
                   ['success' => 'Empregado cadastrado com sucesso'],
                   ''
               );
           } else {
               return FailRedirectMessage::failRedirect(
                   'empregados.create',
                   ['errors' => 'Falha no cadastramento'],
                   ''
               );
           }
       } else{
           return FailRedirectMessage::failRedirect(
               'empregados.create', 
               ['errors' => 'Empregado já registrado no banco de dados'],
               ''
           );
       }        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Empregado::find($id);  
        $setores = $this->setor->orderBy('nome', 'ASC')->get();            
        return view('admin.empregado.edit', compact('data', 'setores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmpregadoFormRequest $request, $id)
    {        
        $dataForm = $request->validated();
        $empregado = Empregado::find($id);        
        $update = $empregado->update($dataForm);
        if($update){
            return redirect()
                ->route('empregados.index')
                ->with(['success' => 'Registro alterado com sucesso'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function loadFuncoes($setor_id)
    {
        $funcao = DB::table('funcao')
                ->select('funcao.id', 'funcao.nome')
                ->join('grupofuncao', 'grupofuncao.funcao_id', '=', 'funcao.id')
                ->where('grupofuncao.setor_id', $setor_id)
                ->orderBy('nome', 'ASC')
                ->get();

        return response()->json($funcao);
    }

    public function loadGrupos($setor_id, $funcao_id)
    {
        $grupo = DB::table('grupo')
                ->select('grupo.id', 'grupo.nome')
                ->join('grupofuncao', 'grupofuncao.grupo_id', '=', 'grupo.id')
                ->where('funcao_id', $funcao_id)
                ->where('setor_id', $setor_id)
                ->orderBy('nome', 'ASC')
                ->get();
        
        return response()->json($grupo);
    }

    public function search(Request $request, Empregado $empregado)
    {
        $dataForm = $request->validate([
            'nome' => 'required'
        ]);
        $nome = '%'.$dataForm['nome'].'%';
        $data = $empregado->where('nome', 'like', $nome)->orderBy('nome', 'ASC')->paginate(5);
        return view('admin.empregado.index', compact('nome', 'data', 'dataForm'));
    }
}
