<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Funcao;
use App\Http\Requests\Admin\FuncaoFormRequest; 
use App\Models\Empregado;

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
        // buscar a funcao
        $funcao = $this->funcao->find($id);
        return view ('admin.funcao.show', ['funcao'=>$funcao]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // buscar a funcao
        $funcao = $this->funcao->find($id);
        return view ('admin.funcao.edit', ['funcao'=>$funcao]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FuncaoFormRequest $request, $id)
    {
        // Buscar funcao
        $funcao = $this->funcao->find($id);

        // GRAVAR FUNCAO

            // pegar os dados do request
        $dataForm = $request->all();
        $nome = $dataForm['nome'];

            // verificar se ha duplicidade no BD
        $busca = $this->funcao->where('nome', '=', $nome)->where('id', '<>', $id)->get()->first();
        if($busca != null){
            return redirect()->route('funcoes.edit', $id)->withErrors(['errors'=>'Função já cadastrada'])->withInput();
        }

            // altera valor
        $update = $funcao->update($dataForm);
        if($update){
            return redirect()->route('funcoes.index')->with(['success'=>'Função cadastrada com sucesso'])->withInput();
        }else{
            return redirect()->route('funcoes.edit', $id)->withErrors(['errors'=>'Erro na inserção'])->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Busca a funcao no BD
        $funcao = $this->funcao->find($id);

        // vinculada com chave estrangeira?
            // a tabela funcao possui relacao com a tabela empregagdo
        $busca = Empregado::where('funcao_id', '=', $id)->get()->count();
        if($busca > 0){
            $mensagem = "Falha no Delete. Existem $busca empregado(s) com esta função.";
            return redirect()->route('funcoes.show', $id)->withErrors(['errors' => $mensagem])->withInput();
        }

        // nao havendo vinculacao podemos deletar
        $delete = $funcao->delete();

        // retorna mensagem de sucesso ou erro no processo
        if($delete){
            return redirect()->route('funcoes.index')->with(['success' => 'Função deletada com sucesso']);
        }
        else{
            return redirect()->route('funcoes.show',$id)->withErrors(['errors' => 'Erro no Delete.'])->withInput();
        }

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
