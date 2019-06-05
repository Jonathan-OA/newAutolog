<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrintConfigController extends Controller
{
    /**
     * Página que lista todas as impressoras disponíveis no servidor de impressão
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('print.printConfig');
    }
}
