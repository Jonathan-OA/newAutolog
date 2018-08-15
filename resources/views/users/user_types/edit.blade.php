@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.user_types')
                </div>
                <div class="panel panel-default">
                    <div class="panel-body" >
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::model($userType, ['route' => ['userTypes.update', $userType->id], 'method' => 'patch']) !!}
                                  @include('users.user_types.fields',['action' => "edit"])
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
    var table;
    $(function() {
        $('#status').change(function(){
            //Caso um tipo de usuário seja desativado, da mensagem de confirmação
            if($(this).prop('checked') === false){
                if(!confirm('Caso exista usuários para este tipo, TODOS serão desativados. Deseja continuar?')){
                    $(this).prop('checked', true);
                }
            }
        })
    })

</script>
@endsection