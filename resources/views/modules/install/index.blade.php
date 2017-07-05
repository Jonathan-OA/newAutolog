@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Instalação do Sistema
                </div>

                <div class="panel-body">
                    <form method="POST" action="">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th> </td>
                                <th> Módulos Disponíveis </td>
                            </tr>
                            </thead>
                            @foreach ($modulos as $modulo)
                                <tr>
                                    <td align="center" width="50">
                                            <input type="checkbox" name="modulo_chk[]" autocomplete="off" checked="{{% $modulo->enabled%}}">
                                    </td>   
                                    <td>
                                        {{% $modulo->name %}}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        
                    </form>
                </div>
                
            </div>
            <button type="submit" class="btn btn-success center-block">
                        Prosseguir
                        </button>
        </div>
    </div>
@endsection
