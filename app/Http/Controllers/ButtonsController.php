<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ButtonsController extends Controller
{
    public function getButtons($modulo){
        
        $permissions = ['edit' => 1];

        return view("modulos.$modulo.getButtons")->with(['permissions' => $permissions]);
    }
}
