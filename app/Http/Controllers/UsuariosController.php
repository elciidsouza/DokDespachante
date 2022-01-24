<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $usuarios = User::all();
        return view("pages.usuarios.index", [
            'usuarios' => $usuarios
        ]);
    }

    public function form($id = 0){
        $dadosUsuario = [];
        if($id != 0){
            $dadosUsuario = User::find($id);
        }
        return view("pages.usuarios.form", [
            'usuario' => $dadosUsuario
        ]);
    }

    public function store(Request $request){
        try{
            if(isset($request->user_id)){
                $dadosUsuario = User::find($request->user_id);

                $dadosUsuario->name = $request->name;
                $dadosUsuario->email = $request->email;
                if(isset($request->password)){
                    $dadosUsuario->password = Hash::make($request->password);
                }

                $dadosUsuario->save();

                $msg = "Usuário alterado com sucesso.";
            } else {
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                $msg = "Usuário criado com sucesso.";
            }

            return [
                'status' => 'success',
                'msg' => $msg
            ];

        } catch(Exception $e){
            return [
                'status' => 'error',
                'msg' => $e->getMessage()
            ];
        }
    }

    public function delete(Request $request){
        try{
            if(User::find($request->id)->delete()){
                return [
                    'status' => 'success',
                    'msg' => "Usuário excluido com sucesso."
                ];
            }
        } catch(Exception $e){
            if($e->getCode() === '23000'){
                return [
                    'status' => 'error',
                    'msg' => "Este usuário possui um ou mais veículos associados a ele, por isto, não pode ser excluído."
                ];
            }
            return [
                'status' => 'error',
                'msg' => $e->getMessage()
            ];
        }
    }
}
