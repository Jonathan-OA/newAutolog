@extends('layouts.app')

@section('content')
    <!-- BreadCrumb - Trilha  -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{!! route('userTypes.index') !!}">@lang('models.user_types')</a></li>
          <li class="breadcrumb-item active" aria-current="page">@lang('buttons.permissions')</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel pbread panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.user_permissions') - @lang('models.user_type_code'): {{$userTypeCode}}
                </div>
                <div class="panel pbread panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            @include('flash::message')
                            <div id="msg_excluir"></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! Form::open(['route' => 'userPermissions.store']) !!}
                                            <div class="form-group">
                                                 @include('users.user_permissions.show_operations')
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
    </div>
@endsection
@section('scripts')
<script>
    var table;
    $(function() {
        //Função para selecionar todas as operações dos modulos
        $("input[id^='hm_']").change(function(){
            //Pega nome do módulo clicado
            var module = $(this).attr("name");
            var operations = $("input[id^='"+module+".']");
            operations.prop('checked', !operations.prop('checked'));
        })
                    
    });

</script>
@endsection