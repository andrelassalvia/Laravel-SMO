<?php

namespace App\Http\Controllers\Admin;

use App\AbstractClasses\CheckDataBase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Exame;
use App\Models\AtendimentoExame;
use App\Models\GrupoExame;

use App\Http\Requests\Admin\ExameFormRequest; 
use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\ChangeRegister;
use App\Classes\CheckToDelete;
use App\Classes\DeleteRegister;
use App\Classes\SearchRequest;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;

class ExameController extends Controller
{
    use SuccessRedirectMessage, FailRedirectMessage;

    public function __construct(
        AtendimentoExame $atendimentoExame,
        GrupoExame $grupoExame
    ) 
    {
        $this->atendimentoExame = $atendimentoExame;
        $this->grupoExame = $grupoExame;
    }
    
    public function index(Exame $exame)
    {
        $this->authorize('view-any', $exame);
        $exames = new CollectData($exame);
        $data = $exames->collection('nome', 'ASC', false);     
        return view ('admin.exame.index', compact('data'));
    }
  
    public function create(Exame $exame)
    {
        $this->authorize('create', $exame);
        $data = $exame;
        return view ('admin.exame.create', compact('data'));
    }

    public function store(ExameFormRequest $request, Exame $exame)
    {
        $this->authorize('create', $exame);
        $dataForm = $request->validated();
        $data = new CheckDataBase($exame);
        $data = $data->checkInDatabase(['nome'], [$dataForm['nome']]);
        if($data){
            $store = new SaveInDatabase($exame);
            $store = $store->saveDatabase($data);
            return SuccessRedirectMessage::successRedirect(
                'exame.index',
                ['success' => 'Exame cadastrado com sucesso'],
                ''
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'exame.create',
                ['errors' => 'Exame já cadastrado'],
                ''
            );
        }
    }
    
    public function show(Exame $exame, $id)
    {
        $this->authorize('view', $exame);
        $data = Exame::find($id);
        return view ('admin.exame.show', compact('data'));
    }
    
    public function edit(Exame $exame, $id)
    {
        $this->authorize('update', $exame);
        $data = Exame::find($id);
        return view ('admin.exame.edit', compact('data'));
    }
    
    public function update(ExameFormRequest $request, Exame $exame, $id)
    {
        $this->authorize('update', $exame);
        $dataForm = $request->validated();
        $alter = new CheckDataBase($exame);
        $alter = $alter->checkInDatabase(
            ['nome'],
            [$dataForm['nome']]
        );
        if($alter){
            $newRegister = new ChangeRegister(($exame));
            $newRegister = $newRegister->changeRegisterInDatabase(
                $id,
                $alter
            );
            return SuccessRedirectMessage::successRedirect(
                'exame.index',
                ['success' => 'Exame alterado com sucesso'],
                $id
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'exame.edit',
                ['errors' => 'Exame já cadastrado'],
                $id
            );
        }
    }

    public function destroy(Exame $exame, $id)
    {
        $this->authorize('delete', $exame);
        $check = new CheckToDelete($exame);
        $check = $check->checkDb(
            $id,
            [$this->grupoExame, $this->atendimentoExame],
            ['exame_id']
        );
        if($check){
            return FailRedirectMessage::failRedirect(
                'exame.show',
                ['errors' => "Existe um registro vinculado a ". $check['table']],
                $id
            );
        } else {
            $delete = new DeleteRegister($exame);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'exame.index',
                ['success' => 'Exame apagado com sucesso'],
                ''
            );
        }
    }

    public function search(Request $request, Exame $exame)
    {
        $dataForm = $request->validate([
            'nome' => 'required'
        ]);
        $nome = '%'.$dataForm['nome'].'%';
        $exames = new SearchRequest($exame);
        $data = $exames->searchIt('nome', ['nome' => $nome]);

        
        return view('admin.exame.index',compact('nome', 'data', 'dataForm'));
    }
}
