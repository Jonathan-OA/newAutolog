@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Instalação do Sistema
                </div>
            </div>
            {{% $documents %}}
            <button type="submit" class="btn btn-success center-block">
                        Prosseguir
                        </button>
        </div>
    </div>
@endsection
