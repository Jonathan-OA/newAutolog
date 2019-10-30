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
use Closure;
use App\Models\Company;
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

    protected $maxAttempts = 3; // Máximo de tentativas antes de bloquear o login
    protected $decayMinutes = 1.5; // Tempo de bloqueio em minutos

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

        //Seta a conexão defaul como a principal
        DB::setDefaultConnection('mysql');

        // Valida se bate a quantidade de tentativas de login 
        //Caso sim, trava o login para o IP por 1 minuto
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }


        //LÓGICA NO LOGIN PARA DIRECIONAR PARA O BANCO CORRETO
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
                    //Existe. Valida se o databasename existe no destino
                    $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
                    $db = DB::select($query, [$brch[0]->database_name]);
                    if(empty($db)){
                        //Database cadastrada no banco principal não existe (companies)
                        //Incrementa tentativas de login
                        $this->incrementLoginAttempts($request);
                        Flash::error(Lang::get('auth.database'));
                        return redirect(route('login'));
                    }else{
                        //Atribui nova conexão de acordo com o campo database_name
                        DB::purge('tenant');
                        DB::setDefaultConnection('tenant');
                        \Config::set('database.connections.tenant.database', $brch[0]->database_name);
                        DB::reconnect('tenant');
                        
                       
                        //Grava session com o código do banco de dados
                        //Middleware ChangeDatabase é chamado a cada request para tratar o banco correto
                        Session::put('tenancy_code', $brch[0]->database_name);

                        

                        $company_id = Company::getCompanyID($company_code, $company_branch);
                        if($company_id == 0){
                            //Erro ao identificar company_id
                            Flash::error(Lang::get('auth.database'));
                            return redirect(route('login'));
                        }

                        $request['company_id'] = $company_id;
                        
                        //Continua o processo original do metodo login() em AuthenticatesUser
                        $this->validateLogin($request);


                        if ($this->attemptLogin($request)) {
                            return $this->sendLoginResponse($request);
                        }

                        // If the login attempt was unsuccessful we will increment the number of attempts
                        // to login and redirect the user back to the login form. Of course, when this
                        // user surpasses their maximum number of attempts they will get locked out.
                        $this->incrementLoginAttempts($request);

                        return $this->sendFailedLoginResponse($request);
                    }
                }else{
                    //Filial desativada
                    //Incrementa tentativas de login
                    $this->incrementLoginAttempts($request);
                    Flash::error(Lang::get('auth.status_branch'));
                    return redirect(route('login'));
                }

            }else{
                //Filial invalida
                //Incrementa tentativas de login
                $this->incrementLoginAttempts($request);
                Flash::error(Lang::get('auth.branch'));
                return redirect(route('login'));
            }
        }else{
            //Empresa inválida
            //Incrementa tentativas de login
            $this->incrementLoginAttempts($request);
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
                Session::flush();
                Auth::logout();
                Flash::error(Lang::get('validation.loged'));
                return redirect(route('login'));
            }
        }else{
            //Limite Excedido
            Session::flush();
            Auth::logout();
            Flash::error(Lang::get('validation.qty_users'));
            return redirect(route('login'));
        }

        //Filial diferente da cadastrada
        if($request->company_id <> $user->company_id){
            Session::flush();
            Auth::logout();
            Flash::error(Lang::get('auth.branch'));
            return redirect(route('login'));
        }

        //Usuário Inativo
        if($user->status == 0){
            Session::flush();
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
