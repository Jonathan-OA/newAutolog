<?php

namespace App\Http\Controllers\Modulos\Geral;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App;

class GridController extends Controller
{
    function getColumns($module){
        $grid = App\Grid::where('module', $module)
                       ->first();
        return json_decode($grid->columns, true);
    }

    function setColumns(){
        $columns = Input::all();
        $grid = App\Grid::where('module', 'Produção')
                       ->first();
        $grid->module = 'Produção';
        //$grid->submodule = $module;
        $grid->columns = json_encode($columns);
        if($grid->save()){
            echo 'aeeee';
        }
    }
}
