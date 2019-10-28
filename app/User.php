<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Config;
use Carbon;
use Session;
use Request;
use Auth;
use DB;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id','code','name', 'email', 'password','user_type_code','last_notification'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    // Valida se usuário já esta logado
    public function valLogged($ip){
        
        //Pega Data Atual
        $dataAtual = Carbon\Carbon::now();
        //Pega Sessão Atual
        $session_id = Session::getId();
        //Se a diferença for menor que 1 minutos, significa que ainda esta logado
        $ultimo = Carbon\Carbon::parse($this->last_login); 
       

        if($dataAtual->diffInMinutes($ultimo) <= 1 && $this->last_ip <> $ip && trim($this->last_login) <> ''){
            return false;
        }else{
            //Atualiza data do ultimo login para a atual
            $this->last_login = $dataAtual->toDateTimeString();
            $this->last_ip = $ip;
            $this->save();
            return true;
        }
    }

    // Valida quantidade de usuários logados
    public function valQtyUsers(){
        //Parâmetro com o limite de usuários desktop
        $config = Config::where('code', 'usuarios_desktop')
                        ->get();


        //Pega Data Atual e diminui 1 minuto para validação
        $dataAtual = Carbon\Carbon::now()->subMinute();

        //Busca quantidade de usuários logados (diferença <= 1 minuto)
        $qdeUsers = User::where('company_id', Auth::user()->company_id)
                        ->where('last_login','>=', $dataAtual )
                        ->count();
        
        //$qdeUsers = ($qdeUsers == 0)? 3 : $qdeUsers;
        //echo $config[0]->value;exit;

        if($qdeUsers < $config[0]->value){
            //Ok
            return true;
        }else{
            //Limite excedido
            return false;
        }                     

    }

    //Função que atualiza o horário de login com o atual
    public function updateLogin(){

        //Pega Data Atual
        $dataAtual = Carbon\Carbon::now();

        //Atualiza data do ultimo login para a atual
        $this->last_login = $dataAtual->toDateTimeString();
        $this->save();

    }

}
