<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Cache;
use Carbon\Carbon;

class LastUserActivity
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

        //Caso o usuário esteja logado,a cada novo request atualiza no Cache que esta online
        if(Auth::check()) {
            $company_code = Auth::user()->getCompanyInfo()->code;

            $expiresAt = Carbon::now()->addMinutes(1);
            Cache::put('user-is-online-'.$company_code.'-'.Auth::user()->id, true, $expiresAt);
        }
        return $next($request);


    }
}
