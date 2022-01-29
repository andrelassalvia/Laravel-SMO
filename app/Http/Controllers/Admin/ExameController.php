<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ExameFormRequest; 
use App\Models\Exame;


class ExameController extends Controller
{
    // Construct method
    public function __construct(Exame $exame ){
        $this->exame = $exame;
 
    }

    public function index()
    {
        $exames = $this->exame->collection();
        
        return view ('admin.exame.index', compact('exames'));
    }
  
    public function create()
    {
        return view ('admin.exame.create');
    }

    public function store(ExameFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        
        $exame = $this->exame->saveInDatabase($nome);
        return $exame;
        
    }
    
    public function show($id)
    {
        // buscar a exame
        $exame = $this->exame->get($id);
        return view ('admin.exame.show', compact('exame'));
    }

    
    public function edit($id)
    {
        // buscar a exame
        $exame = $this->exame->get($id);
        return view ('admin.exame.edit', ['exame'=>$exame]);
    }

    
    public function update(ExameFormRequest $request, $id)
    {
        // pegar os dados do request
        $dataForm = $request->all();
        $nome = $dataForm['nome'];

        $alter = $this->exame->changeRegister($id, $nome, $dataForm);
        return $alter;
    }

    
    public function destroy($id)
    {
        return $this->exame->erase($id);
    }

    public function search(Request $request){

        $dataForm = $request->all();
        $nome = '%'.$dataForm['nome'].'%';

        $exames = $this->exame->search('nome', 'like', $nome, 'ASC', 5);
    
        return view('admin.exame.index', ['dataForm'=>$dataForm, 'exames'=>$exames]);
    }
}
