<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;

class InstallController extends Controller
{
    public function index(){
        $modules = App\Module::all();
        return view('modules.install.index', ['modules' => $modules]);
    }

    //Salva modulos e encaminha para a pagina de transações
    public function step1(Request $request){
        $modules = $request->input('module_chk');
        foreach($modules as $id => $value){
           $module =  App\Module::find($id);
           $module->enabled = $value;
           $module->save();
        }

        $operations = App\Models\Operations::orderBy('module')->get();
        return view('modules.install.trans', ['operations' => $operations]);
    }

    //Salva as transações e encaminha para a pagina de parâmetros
    public function step2(Request $request){

    }
}
