<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon;
use App\User;

class ControlLogout
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
     * Atualiza o horario de login para -1 minuto (desconsiderar usuario logado nas outras funções)
     * 
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        //Pega Data Atual
        $dataAtual = Carbon\Carbon::now();
        //Subtrai 1 minuto
        $dataAtual->subMinute(); 
        $user = User::find($event->user->id);
        //Atualiza data do ultimo login para a calculada
        $user->last_login = $dataAtual->toDateTimeString();
        $user->save();
        
    }
}
