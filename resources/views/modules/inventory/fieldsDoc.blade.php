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

    <!-- Parâmetros do Inventário -->
    <hr>
    <div class="panel-heading" >
        @lang('models.parameters')
    </div>
    <hr>
    <span aria-label="@lang('infos.param_count')" data-microtip-position="right" role="tooltip">
        <img class='icon' src='{{asset('/icons/information.png') }}' >
    </span>
    {!! Form::label('counts', Lang::get('parameters.param_count')) !!}
    {{ Form::radio('counts', '1' , false) }} 1
    {{ Form::radio('counts', '2' , true) }} 2
    {{ Form::radio('counts', '3' , false) }} 3 
    {{ Form::radio('counts', '4' , false) }} 4
    <br>
    <span id="parameters">
        <span aria-label="@lang('infos.param_stock')" data-microtip-position="right" role="tooltip">
            <img class='icon' src='{{asset('/icons/information.png') }}' >
        </span>
        {!! Form::label('vstock', Lang::get('parameters.param_stock')) !!}
        {{ Form::radio('vstock', '1' , true) }} @lang('models.yes')
        {{ Form::radio('vstock', '0' , true) }} @lang('models.no')
        <br>
        <span aria-label="@lang('infos.param_product')" data-microtip-position="right" role="tooltip">
            <img class='icon' src='{{asset('/icons/information.png') }}' >
        </span>
        {!! Form::label('vproduct', Lang::get('parameters.param_product')) !!}
        {{ Form::radio('vproduct', '1' , true) }} @lang('models.yes')
        {{ Form::radio('vproduct', '0' , true) }} @lang('models.no')
        <br>
        <span aria-label="@lang('infos.param_location')" data-microtip-position="right" role="tooltip">
            <img class='icon' src='{{asset('/icons/information.png') }}' >
        </span>
        {!! Form::label('vlocation', Lang::get('parameters.param_stock')) !!} 
        {{ Form::radio('vlocation', '1' , true) }} @lang('models.yes')
        {{ Form::radio('vlocation', '0' , true) }} @lang('models.no')
        <br>
    </span>
    <span id="parameters_inv" style="display: none">
        <span aria-label="@lang('infos.param_productdef')" data-microtip-position="right" role="tooltip">
            <img class='icon' src='{{asset('/icons/information.png') }}' >
        </span>
        {!! Form::label('productdef', Lang::get('parameters.param_productdef')) !!} 
        {!! Form::text('productdef', null, ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'products']) !!}
    </span>
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary', 'onclick' => 'return confirm("'.Lang::get('parameters.confirm').'")']) !!}
<a href="{!! route('inventory.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
