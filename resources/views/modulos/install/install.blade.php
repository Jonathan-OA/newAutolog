@extends('layouts.app')

@section('content')
    <div class="row ins_title"> 
        Instalação do Sistema 
    </div>
    <form method="POST" action="">
        <div class="row ins_caption">
            Módulos Disponíveis
        </div>
        <table class="table_default stack">
            @foreach ($modulos as $modulo)
                <tr>
                    <td align="center" width="50">
                       <input type="checkbox" name="modulo_chk[]" checked="{{ $modulo->enabled}}"> 
                    </td>   
                    <td>
                        {{ $modulo->name }}
                    </td>
                </tr>
            @endforeach
        </table>
    </form>
@endsection
