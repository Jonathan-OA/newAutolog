@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Instalação do Sistema
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="POST" action="install/trans">
                            {% csrf_field() %}
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th> </td>
                                    <th> Módulos Disponíveis </td>
                                </tr>
                                </thead>
                                @foreach ($modules as $module)
                                    <tr>
                                        <td align="center" width="50">
                                                <input type="hidden" name="module_chk[{% $module->id %}]" value="0" >
                                                <input type="checkbox" name="module_chk[{% $module->id %}]" autocomplete="off" value="1" @if($module->enabled == 1) checked @endif >
                                        </td>   
                                        <td>
                                            @if(!empty($module->submodule))
                                                --- >
                                            @endif
                                            {% $module->name %}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <button type="submit" class="btn btn-success center-block">Prosseguir</button>
                        </form>
                    </div>
                    
                </div>
               
            </div>
        </div>
    </div>
@endsection
