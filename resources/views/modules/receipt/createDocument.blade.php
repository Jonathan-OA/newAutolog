@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.receipt') - @lang('models.document_create')
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['route' => 'receipt.store']) !!}
                            <div class="form-group">
                                @include('modules.receipt.fieldsDoc')
                            </div>
                            {!! Form::close() !!}
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
            //Armazena o array com informações de tdos os tipos de documentos do módulo
            var docTypesInfos = @json($document_types_infos);
  
            //Valida se o número é criado automaticamente ou não
          $("#document_type_code").on('change load',function(){
              valNumAutomatic();
          })
  
          valNumAutomatic();
  
          //Valida se o número é criado automaticamente ou não (cadastro do tipo de produto - num_automatic)
          function valNumAutomatic(){
              var value = $("#document_type_code").val();
              if(docTypesInfos[value]['num_automatic'] === true){
                  $("#document_number").attr('readonly', 'true');
                  $("#document_number").val('Gerado Automaticamente');
              }else{
                  $("#document_number").removeAttr('readonly');
                  $("#document_number").val('');
              }
          }
        })
  </script>
@endsection