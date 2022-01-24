<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Auth;
use App\Models\Veiculos;

class VeiculosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $veiculos = Veiculos::all();
        return view("pages.veiculos.index", [
            'veiculos' => $veiculos
        ]);
    }

    public function form($id = 0){
        $dadosVeiculo = [];
        if($id != 0){
            $dadosVeiculo = Veiculos::find($id);
            if(Auth::user()->id != $dadosVeiculo->usuario_id){
                return redirect()->route('veiculos');
            }
        }
        return view("pages.veiculos.form", [
            'veiculo' => $dadosVeiculo
        ]);
    }

    public function store(Request $request){
        try{
            if(isset($request->veiculo_id)){
                $dadosVeiculo = Veiculos::find($request->veiculo_id);

                if(Auth::user()->id != $dadosVeiculo->usuario_id){
                    throw new Exception('Você não pode editar o veículo de outro usuário.');
                }

                $dadosVeiculo->usuario_id = Auth::user()->id;
                $dadosVeiculo->placa = $request->placa;
                $dadosVeiculo->modelo = $request->modelo;
                $dadosVeiculo->cor = $request->cor;
                $dadosVeiculo->tipo = $request->tipo;

                $dadosVeiculo->save();

                $msg = "Veículo alterado com sucesso.";
            } else {
                Veiculos::create([
                    'usuario_id' => Auth::user()->id,
                    'placa' => $request->placa,
                    'modelo' => $request->modelo,
                    'cor' => $request->cor,
                    'tipo' => $request->tipo,
                ]);
                
                $msg = "Veículo criado com sucesso.";
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
        $veiculosDados = Veiculos::find($request->id);
        if($veiculosDados){
            if(Auth::user()->id != $veiculosDados->usuario_id){
                return [
                    'status' => 'error',
                    'msg' => 'Você não pode editar o veículo de outro usuário.'
                ];
            }
            $veiculosDados->delete();
            return [
                'status' => 'success',
                'msg' => "Veículo excluido com sucesso."
            ];
        } else {
            return [
                'status' => 'error',
                'msg' => 'Ocorreu um erro ao deletar o veículo. Tente novamente.'
            ];
        }
    }
}
