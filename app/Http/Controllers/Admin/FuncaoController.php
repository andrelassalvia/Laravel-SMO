<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\FuncaoFormRequest; 
use App\Models\Empregado;
use App\Repositories\Interfaces\FuncaoInterface;



class FuncaoController extends Controller
{
    // Construct method
   
    protected $repo;
    public function __construct(FuncaoInterface $repo){
        $this->repo = $repo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $funcoes = $this->repo->allOrdered('nome', 'ASC', 5);
        
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
        $nome = $dataForm['nome'];

        // Verifica de o nome ja esta cadastrado
        $funcao = $this->repo->checkDb('nome', '=', $nome);
        
        if($funcao != null){
            return $this->repo->failRedirect('funcoes.create', ['errors'=> 'Função já cadastrada']);
        }
        
        // inserir o nome
        $insert = $this->repo->insert(['nome' => $nome]);

        if($insert){
            return $this->repo->successRedirect('funcoes.index', ['success'=>'Registro Cadastrado com Sucesso']);
        }
        else{
            return $this->repo->failRedirect('funcoes.create', ['errors' => 'Erro na inserção.']);
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
        $funcao = $this->repo->get($id);
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
        $funcao = $this->repo->get($id);
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
        $funcao = $this->repo->get($id);
        
        // GRAVAR FUNCAO

            // pegar os dados do request
        $dataForm = $request->all();
        
        $nome = $dataForm['nome'];

            // verificar se ha duplicidade no BD
        $busca = $this->repo->checkDb('nome', '=', $nome);
        if($busca != null){
            return $this->repo->failRedirect('funcoes.edit', ['errors' => 'Funcao ja cadastrada'], $id);
        }

            // altera valor
            $update = $this->repo->update($funcao, $dataForm);
            
            if($update){
                return $this->repo->successRedirect('funcoes.index', ['success' => 'Funcao cadastrada com sucesso.']);
            }
            else{
                return $this->repo->failRedirect('funcoes.edit', ['errors' => 'Erro na insercao'], $id);
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
        $funcao = $this->repo->get($id);

        // Verificar chaves estrangerias com outras tabelas
        //     // tabela empregagdo
        $busca = Empregado::where('funcao_id', '=', $id)->get()->count();
        if($busca > 0){
            $mensagem = "Falha no Delete. Existem $busca empregado(s) com esta função.";
            return $this->repo->failRedirect('funcoes.show', $mensagem, $id);
        }
        
        // nao havendo vinculacao podemos deletar
        $delete = $this->repo->delete($funcao);

        // retorna mensagem de sucesso ou erro no processo
        if($delete){
            return $this->repo->successRedirect('funcoes.index', ['success' => 'Funcao deletada com sucesso.']);
        }else{
            return $this->repo->failRedirect('funcoes.show', ['errors'=>'Erro no delete'], $id);
        }
    }

    public function search(Request $request){

        $dataForm = $request->all();
        $nome = '%'.$dataForm['nome'].'%';

        $funcoes = $this->repo->search('nome', 'like', $nome, 'ASC', 5);
    
        return view('admin.funcao.index', ['dataForm'=>$dataForm, 'funcoes'=>$funcoes]);
    }
}
