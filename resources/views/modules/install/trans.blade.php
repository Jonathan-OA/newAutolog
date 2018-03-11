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
                                    <th> </th>
                                    <th> Operações Disponíveis </th>
                                </tr>
                                </thead>
                                @php
                                     $module_ant = '';
                                @endphp
                                @foreach ($operations as $operation)
                                    @if($module_ant <> $operation->module)
                                        <tr>
                                            <td> {% $operation->module %}</td>
                                        </tr>
                                        @php
                                            $module_ant = $operation->module;
                                        @endphp 
                                    @endif
                                    <tr>
                                        <td align="center" width="50">
                                                <input type="hidden" name="module_chk[{% $operation->id %}]" value="0" >
                                                <input type="checkbox" name="module_chk[{% $operation->id %}]" autocomplete="off" value="1"  >
                                        </td>   
                                        <td>
                                            
                                            {% $operation->code %}
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
