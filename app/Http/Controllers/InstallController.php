<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;

class InstallController extends Controller
{
    public function index(){
        $modulos = App\Module::all();
        return view('modulos.instalador.index', ['modulos' => $modulos]);
    }
}
