<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Usuário gerencial = Tela de relatórios
        if(Auth::user()->user_type_code == 'GERENCIAL'){
            return view('admin.repBranchs');
        }else{
            return view('dashboard');
        }
        
    }
}
