<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Module;
use Auth;
use DB;
use Config;
use Session;

class ChangeDatabase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Valida se o nome da database esta armazenado na sessão (ação realizada na validação do login )
        //Caso esteja, altera cada request para a conexão correta
        $database_code = Session::get('tenancy_code');
    
        if(trim($database_code) <> ''){
            \Config::set('database.connections.tenant.database',  $database_code);
            DB::purge('tenant');
            DB::setDefaultConnection('tenant');
        }

        return $next($request);
    }
}