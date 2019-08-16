@extends('layouts.app')
@section('content')
    <!-- BreadCrumb - Trilha  -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{!! route('inventory.index') !!}">@lang('models.inventory')</a></li>
          <li class="breadcrumb-item active" aria-current="page">@lang('buttons.add_items')</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel pbread panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.items_select') - {{$document->document_type_code}} {{$document->number}}
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @include('flash::message')
                        <div id="msg_excluir"></div>
                        <div class="panel-body">
                            <div class="row">
                                {!! Form::open(['url' => 'inventory/'.$document->id.'/selectItems']) !!}
                                <div class="col-md-10">
                                    <!-- Deposits Field -->
                                    {!! Form::label('deposits', Lang::get('models.deposits').':') !!}
                                    {!! Form::text('deposits', null, ['class' => 'form-control','id' => 'autocomplete1', 'table' => 'deposits', 'multiple']) !!}
                                </div>
                                <div class="col-md-2" style="padding-top:25px">
                                    {!! Form::submit(Lang::get('buttons.filter'), ['class' => 'btn btn-primary']) !!}
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(['url' => 'inventory/'.$document->id.'/storeItem']) !!}
                                        <div class="form-group" style="overflow-y: auto">
                                                @include('modules.inventory.fieldsSelectItems')
                                        </div>
                                    {!! Form::close() !!}
                                </div>
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
    var table;
    $(function() {
        //Função para selecionar todos os endereços do depósito
        $("input[id^='H_']").change(function(){
            //Pega nome do depósito clicado (desconsiderando os desabilitados por conter reserva)
            var deposit = $(this).attr("value");
            var locations = $("input[id^='V"+deposit+"']:enabled");
            if($(this).prop('checked')){
                locations.prop('checked', true);
            }else{
                locations.prop('checked', false);
            }
        })
                    
    });

</script>
@endsection