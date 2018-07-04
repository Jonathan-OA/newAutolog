<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Module;

class GenerateMenus
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
        \Menu::make('MyNavBar', function($menu){
            $modulos = Module::where('enabled',1)
                             ->where('submodule', NULL)
                             ->orwhere('submodule', '')
                             ->get();
            $cont = 1;
            foreach($modulos as $mod){
                $nickname = 'Nick'.$cont;
                $menu->add($mod->name, array('class' => 'menu_ext', 'nickname' => $nickname))
                     ->link->attr(array('data-toggle' => "collapse", 'href' => ".collapse".$nickname, 'aria-expanded'=>"false", 'aria-controls'=> "collapseExample"));
                //Icone
                $menu->$nickname->prepend('<img class="icon_menu" src="'.asset('/icons/'.$mod->icon.'.png').'" alt="Icone">')
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
        return $next($request);
    }
}
