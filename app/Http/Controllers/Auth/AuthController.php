<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AuthController extends Controller
{
    public function index(LoginRequest $request)
    {

            $code = $request->input('code');
            $pw = $request->input('password');
            if ($this->auth->attempt(['code' => $code, 'password' => $pw]))
            {
                echo 'aee';
            }
            else
            {
                echo 'not logged in';
            }


    }
}
