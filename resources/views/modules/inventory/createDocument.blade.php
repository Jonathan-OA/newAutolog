@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.inventory') - @lang('models.document_create')
                </div>
                <div class="panel panel-default">
                    <div class="panel-body" >
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open(['route' => 'inventory.store']) !!}
                                <div class="form-group">
                                    @include('modules.inventory.fieldsDoc')
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
    $(function() {
        $('#document_type_code').change(function(){
            //TIPO = INV é inventário cego, sem validar endereço, palete e quantidade.
            if(this.value == 'INV'){
                $('#parameters').hide();
                $('#parameters_inv').show();
                alert('ATENÇÃO: Este tipo de inventário não realiza nenhuma validação no sistema.');
            }else{
                $('#parameters').show();
                $('#parameters_inv').hide();
            }
        })
       
    })
    </script>    
@endsection