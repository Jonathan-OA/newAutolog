<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;

class InstallController extends Controller
{
    public function index(){
        echo \Auth::guard('web')->user();
        exit;
        $modulos = App\Module::all();
        return view('modulos.install.install', ['modulos' => $modulos]);
    }
}
