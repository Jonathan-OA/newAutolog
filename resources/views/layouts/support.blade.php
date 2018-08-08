<!-- layout da modal para envio de suportes -->
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
                <div class="panel-default" >
                <div class="panel-heading">
                        @lang('models.support')
                    </div>
                </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(['route' => 'supports.store']) !!}
                    <div class="form-group">
                                <!-- Código da empresa -->
                                <input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

                                <!-- Rota para retorno após envio -->
                                <input id='url' name='url' type='hidden' value='{!! Route::currentRouteName() !!}'>

                                <!-- URL -->
                                {!! Form::label('url_user', Lang::get('models.url').':') !!}
                                {!! Form::text('url_user',  Request::url() , ['class' => 'form-control', 'readonly']) !!}
                                
                                <!-- Usuário -->
                                {!! Form::label('user_code', Lang::get('models.user_code').':') !!}
                                {!! Form::text('user_code',  Auth::user()->code , ['class' => 'form-control', 'readonly']) !!}
                                
                                <!-- Mensagem -->
                                {!! Form::label('message', Lang::get('models.message').':') !!}
                                {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('buttons.cancel')</button>
                    {!! Form::submit(Lang::get('buttons.send'), ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
