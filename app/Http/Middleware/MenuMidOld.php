<?php

namespace App\Http\Middleware;
use App\Models\Module;

use Closure;

class MenuMid
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
        //Só carrega este middleware se o usuário estiver logado
        if(Auth::check()){
            \Menu::make('MyNavBar', function($menu){
                $modulos = Module::where('enabled',1)
                                ->where('submodule', NULL)
                                ->orwhere('submodule', '')
                                ->get();
                $cont = 1;
                print_r($modulos);
                foreach($modulos as $mod){
                    $nickname = 'Nick'.$cont;
                    $menu->add($mod->name, array('class' => 'menu_ext', 'nickname' => $nickname))
                        ->link->attr(array('data-toggle' => "collapse", 'href' => ".collapse".$nickname, 'aria-expanded'=>"false", 'aria-controls'=> "collapseExample"));
                    //Icone
                    $menu->$nickname->prepend('<img class="icon_menu" src="{{ asset(\'/icons/'.$mod->icon.'.png\') }}" alt="Operações">')
                                    ->append('<span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>');;
                    $submodules = Module::where('enabled',1)
                                ->where('module', $mod->module)
                                ->where('submodule','<>',NULL)
                                ->where('submodule','<>','')
                                ->get();
                    foreach($submodules as $sub){
                            $menu->$nickname->add($sub->name, array('url' => $sub->url, 'class'=> "collapse collapse".$nickname, 'aria-expanded' => 'false'));
                    }
                    $cont++;
                }
            });
        }
        return $next($request);
    }
}
