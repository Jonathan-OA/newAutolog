<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Carbon;
use Session;
use Redirect;

class ControlLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * Valida se o usuário já esta logado e se ultrapassou o limite de usuários permitidos
     * 
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $idUsuario = $event->user['original']['id'];
        $user = User::find($idUsuario);
        
        $dataAtual = Carbon\Carbon::now();
        //Pega Sessão Atual
        $session_id = Session::getId();

        if($dataAtual->toDateTimeString() <> $user->last_login and $session_id == $user->session){
            //Atualiza data do ultimo login para a atual
            $user->last_login = $dataAtual->toDateTimeString();
            $user->session = $session_id;
            $user->save();
        }else{
            Redirect::to('user/login')->with('errors', ['Your account hasnt been activated']);
        }
        
    }
}
