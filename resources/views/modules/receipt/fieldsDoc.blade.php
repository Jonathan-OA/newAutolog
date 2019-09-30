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
    {!! Form::select('document_type_code', $document_types,(!empty($document->document_type_code)) ? $document->document_type_code : '', ['class' => 'form-control', 'id' => 'document_type_code','']) !!}

    <!-- Number Field -->
    {!! Form::label('number', Lang::get('models.number').':') !!}
    @if(!empty($action) && $action == 'edit')
        {!! Form::text('number', null, ['class' => 'form-control', 'readonly']) !!}
    @else
        {!! Form::text('number', null, ['class' => 'form-control', 'id' => 'document_number']) !!}
    @endif
    
    <!-- Supplier Code Field -->
    {!! Form::label('supplier_code', Lang::get('models.supplier_code').':') !!}
    {!! Form::text('supplier_code', null, ['class' => 'form-control', 'id' => 'autocomplete1', 'table' => 'suppliers']) !!}

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
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('receipt.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>


