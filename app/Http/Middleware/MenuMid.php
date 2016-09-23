<?php

namespace App\Http\Middleware;
use App\Module;

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
        \Menu::make('MyNavBar', function($menu){
            $modulos = Module::where('enabled',1)->get();
            foreach($modulos as $name){
                $menu->add($name->name, $name->url)->link->attr(array('class' => 'menu_ext'));
            }
            /*$menu->add('Operações', 'operacoes')->link->attr(array('class' => 'menu_ext'));
            $menu->operacoes->add('Teste');
            
            $menu->add('Etiquetas','etiquetas')->link->attr(array('class' => 'menu_ext'));;
            $menu->etiquetas->add('Teste2');
            $menu->add('Ajustes', 'ajustes');
            $menu->add('Configurações',  'configuracoes');
            */
        });
        return $next($request);
    }
}
