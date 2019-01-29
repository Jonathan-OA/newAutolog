<div class="form_fields">
    <!-- Alerta de erro / sucesso -->
    @include('flash::message')
    @include('adminlte-templates::common.errors')

    <!-- Company Id Field -->
    <input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

    <!-- User Id Field -->
    @if(!empty($action) && $action == 'edit')
        <input id='user_id' name='user_id' type='hidden' value='{!! $document->user_id !!}'>
    @else
        <input id='user_id' name='user_id' type='hidden' value='{!! Auth::user()->id !!}'>
    @endif

    <!-- Document Type Code Field -->
    {!! Form::label('document_type_code', Lang::get('models.document_type_code').':') !!}
    {!! Form::select('document_type_code', $document_types,(!empty($document->document_type_code)) ? $document->document_type_code : '', ['class' => 'form-control']) !!}

    <!-- Number Field -->
    {!! Form::label('number', Lang::get('models.number').':') !!}
    @if(!empty($action) && $action == 'edit')
        {!! Form::text('number', null, ['class' => 'form-control', 'readonly']) !!}
    @else
        {!! Form::text('number', null, ['class' => 'form-control']) !!}
    @endif

    <!-- Document Status Field -->
    @if(!empty($action) && $action == 'edit')
        <input id='document_status_id' name='document_status_id' type='hidden' value='{!! $document->document_status_id !!}'>
    @else
        <input id='document_status_id' name='document_status_id' type='hidden' value='0'>
    @endif

    <!-- Emission Date Field -->
    {!! Form::label('emission_date', Lang::get('models.emission_date').':') !!}
    {!! Form::date('emission_date', (!empty($document->emission_date)) ? $document->emission_date->format('Y-m-d') : date('Y-m-d'), ['class' => 'form-control']) !!}


    <!-- Comments Field -->
    {!! Form::label('comments', Lang::get('models.comments').':') !!}
    {!! Form::text('comments', null, ['class' => 'form-control']) !!}

    <hr>
    <div class="panel-heading" >
        Parâmetros
    </div>
    <hr>
    {!! Form::label('comments', 'Contagens:') !!}
    {{ Form::radio('result', 'buy' , false) }} 1
    {{ Form::radio('result', 'buy' , true) }} 2
    {{ Form::radio('result', 'buy' , false) }} 3 
    {{ Form::radio('result', 'sell' , false) }} 4
<br>
    {!! Form::label('comments', 'Valida Saldo:') !!}
    {{ Form::radio('saldo', 'buy' , true) }} Sim
    {{ Form::radio('saldo', 'buy' , true) }} Não

</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('inventory.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
