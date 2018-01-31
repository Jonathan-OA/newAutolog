<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Redirect;
use Flash;
use Lang;
use Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $username = 'code';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, User $user)
    {
        //Valida se limite de usuários já foi atingido
        if($user->valQtyUsers()){
            //Se usuário já esta logado, da erro.
            if(!$user->valLogged($request->ip())){
                Auth::logout();
                Flash::error(Lang::get('validation.loged'));
                return redirect(route('login'));
            }
        }else{
            //Limite Excedido
            Auth::logout();
            Flash::error(Lang::get('validation.qty_users'));
            return redirect(route('login'));
        }
        
    }
}
