<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TipoUsuario;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UsersFormRequest;
use App\Http\Requests\Admin\UsersSaveFormRequest;
use App\Classes\SearchRequest;
use App\Classes\CollectData;
use App\Classes\CheckDataBase;
use App\Classes\SaveInDatabase;
use App\Classes\ChangeRegister;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\PasswordFormRequest;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    use SuccessRedirectMessage, FailRedirectMessage;

    public function __construct(
        User $user,
        TipoUsuario $tipoUsuario
    )
    {
        $this->user = $user;
        $this->tipoUsuario = $tipoUsuario;
    }

    public function index()
    {
        $data = new CollectData($this->user);
        $data = $data->collection('name', 'ASC', false);
        return view('admin.usuario.index', compact('data'));
    }

    public function create()
    {
        $tipoUsuarios = new CollectData($this->tipoUsuario);
        $tipoUsuarios = $tipoUsuarios->collection(
            'nome',
            'ASC',
            true
        );
        return view('admin.usuario.create', compact('tipoUsuarios'));
    }

    public function store(UsersFormRequest $request)
    {
        $dataForm = $request->validated();
        $data = new CheckDataBase($this->user);
        $data = $data->checkInDatabase(
            ['email'],
            [$dataForm['email']]
        );
        if($data == null){
            return FailRedirectMessage::failRedirect(
                'users.create',
                ['errors' => 'Email de usuário já cadastrado'],
                ''
            );
        } else {
            $save = new SaveInDatabase($this->user);
            $dataForm['password'] = bcrypt($dataForm['password']);
            $save = $save->saveDatabase($dataForm);
            return SuccessRedirectMessage::successRedirect(
                'users.index',
                ['success' => 'Usuário cadastrado com sucesso'],
                ''
            );
        }
    }

    public function edit($id)
    {
        $data = $this->user->find($id);
        // dd($data);
        $tipoUsuarios = new CollectData($this->tipoUsuario);
        $tipoUsuarios = $tipoUsuarios->collection(
            'nome',
            'ASC',
            true
        );
        return view('admin.usuario.edit', compact('data', 'tipoUsuarios'));
    }

    public function update(Request $request, UsersSaveFormRequest $formRequest, $id)
    {
        $validated = $formRequest->validated();
        $data = $request->validate([
            'name' => 'required|min:3|max:30',
            'email' => 'required|email',
            'password' => 'confirmed',
            'tipousuario_id' => 'required',
            'status' => 'required'
        ]);
       
        if($data['password']){
           $data['password'] = bcrypt($data['password']);
           $newData = new ChangeRegister($this->user);
           $newData = $newData->changeRegisterInDatabase($id, $data);
           if($newData){
               return SuccessRedirectMessage::successRedirect(
                   'users.index',
                   ['success' => 'Dados do usuário alterados com sucesso'],
                   ''
               );
           } else {
               return FailRedirectMessage::failRedirect(
                   'users.edit',
                   ['errors' => 'Falha na alteração'],
                   ''
               );
           }
        } else {
            $newData = new ChangeRegister($this->user);
            $newData = $newData->changeRegisterInDatabase($id, $validated);
            if($newData){
                return SuccessRedirectMessage::successRedirect(
                    'users.index',
                    ['success' => 'Dados do usuário alterados com sucesso'],
                    ''
                );
            } else {
                return FailRedirectMessage::failRedirect(
                    'users.edit',
                    ['errors' => 'Falha na alteração'],
                    ''
                );
            }
        }
    }

    public function search(Request $request)
    {
        $dataForm = $request->validate([
            'name' => 'required'
        ]);
        $nome = '%'.$dataForm['name'].'%';
        $data = new SearchRequest($this->user);
        $data = $data->searchIt('name', ['nome' => $nome]);
        return view('admin.usuario.index', compact('data', 'nome', 'dataForm'));
    }

    public function passwordEdit()
    {
       $user = Auth::user();
       return view('admin.usuario.password_edit', compact('user'));
    }

    public function passwordUpdate(PasswordFormRequest $request, $id)
    {
        $dataForm = $request->validated();
        $dataForm['password'] = bcrypt($dataForm['password']);
        if(Hash::check($dataForm['last_password'], Auth::user()->password)){
            $user = $this->user->find($id);
            $update = $user->update($dataForm);
            if($update){
                return SuccessRedirectMessage::successRedirect(
                    'password.edit',
                    ['success' => 'Senha alterada com sucesso'],
                    ''
                );
            } else {
                return FailRedirectMessage::failRedirect(
                    'password.edit',
                    ['errors' => 'Falha na alteração da senha'],
                    ''
                );
            }
        } else {
            return FailRedirectMessage::failRedirect(
                'password.edit',
                ['errors' => 'Senha não coincide com a registrada'],
                ''
            );
        }
    }
}
