<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Redirect;
use Flash;
use Lang;
use Session;
use Config;
use DB;
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
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * Função executada ao clicar no botão de Login
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function login(Request $request)
    {
        $input = $request->all();
        $company_code = $input['company_code'];
        $company_branch = $input['company_branch'];

        //Valida se a empresa existe
        $comp = DB::table('companies')->where('code', $company_code)->count();
        if($comp >= 1){
            //Valida se a Filial existe e pega o nome do banco de dados
            $brch = DB::table('companies')
                      ->where('code', $company_code)
                      ->where('branch', $company_branch)
                      ->select('database_name','status')
                      ->get();

            if($brch->count() <> 0){
                if($brch[0]->status == 1){
                    //Existe. Atribui nova conexão de acordo com o campo database_name
                    DB::disconnect();
                    \Config::set('database.connections.mysql.database', $brch[0]->database_name);
                    DB::reconnect();
                }else{
                    Flash::error(Lang::get('auth.status_branch'));
                    return redirect(route('login'));
                }

            }else{
                Flash::error(Lang::get('auth.branch'));
                return redirect(route('login'));
            }
        }else{
            Flash::error(Lang::get('auth.company'));
            return redirect(route('login'));
        }

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

        //Filial diferente da cadastrada
        if($request->company_id <> $user->company_id){
            Auth::logout();
            Flash::error(Lang::get('auth.branch'));
            return redirect(route('login'));
        }

        //Usuário Inativo
        if($user->status == 0){
            Auth::logout();
            Flash::error(Lang::get('auth.status'));
            return redirect(route('login'));
        }
        
    }
    
    //Define qual campo vai ser utilizado para login
    public function username()
    {
        return 'code';
    }
}
