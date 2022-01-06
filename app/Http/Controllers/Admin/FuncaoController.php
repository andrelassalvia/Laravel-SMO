<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Funcao;
use App\Http\Requests\Admin\FuncaoFormRequest; 

class FuncaoController extends Controller
{
    // Construct method
    private $funcao;
    public function __construct(Funcao $funcao){
        $this->funcao = $funcao;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funcoes = $this->funcao->orderBy('nome', 'ASC')->paginate(5);
        return view ('admin.funcao.index', ['funcoes' => $funcoes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.funcao.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FuncaoFormRequest $request)
    {
        $dataForm = $request->all();
        // print_r($dataForm);
        $nome = $dataForm['nome'];
        // print_r($nome);

        // Verifica de o nome ja esta cadastrado
        $funcao = $this->funcao->where('nome', '=', $nome)->get()->first();
        if($funcao != null){
            return redirect()->route('funcoes.create')->withErrors(['errors'=> 'Função já cadastrada'])->withInput();
        }
        
        // inserir o nome
        $insert = $this->funcao->insert(['nome' => $nome]);

        if($insert){
            return redirect()->route('funcoes.index')->with(['success'=>'Registro Cadastrado com Sucesso'])->withInput();
        }
        else{
            return redirect('admin/funcoes/create')->withErrors(['errors' => 'Erro na insercao'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request){

        $dataForm = $request->all();
        // print_r($dataForm);
        $nome = '%'.$dataForm['nome'].'%';
        // print_r($nome);
        $funcoes = $this->funcao->where('nome','LIKE',$nome)->orderBy('nome', 'ASC')->paginate(5);

        return view('admin.funcao.index', ['dataForm'=>$dataForm, 'funcoes'=>$funcoes]);
    }

}
