<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Veiculos;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $usuarios = User::count();
        $veiculos = Veiculos::get();
        return view('dashboard', [
            'qtd_usuarios' => $usuarios,
            'veiculos' => $veiculos
        ]);
    }
}
