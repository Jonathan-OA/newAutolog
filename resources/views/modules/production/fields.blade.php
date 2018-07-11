<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Document Type Code Field -->
{!! Form::label('document_type_code', Lang::get('models.document_type_code').':') !!}
{!! Form::select('document_type_code', $document_types,(!empty($document->document_type_code)) ? $document->document_type_code : '', ['class' => 'form-control']) !!}

<!-- Number Field -->
{!! Form::label('number', Lang::get('models.number').':') !!}
{!! Form::text('number', null, ['class' => 'form-control']) !!}

<!-- Customer Code Field -->
{!! Form::label('customer_code', Lang::get('models.customer_code').':') !!}
{!! Form::number('customer_code', null, ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'customers']) !!}

<!-- Supplier Code Field -->
{!! Form::label('supplier_code', Lang::get('models.supplier_code').':') !!}
{!! Form::text('supplier_code', null, ['class' => 'form-control', 'id' => 'autocomplete1', 'table' => 'suppliers']) !!}

<!-- Courier Code Field -->
{!! Form::label('courier_code', Lang::get('models.courier_code').':') !!}
{!! Form::text('courier_code', null, ['class' => 'form-control', 'id' => 'autocomplete2', 'table' => 'couriers']) !!}

<!-- Document Status Id Field -->
{!! Form::label('document_status_id', Lang::get('models.document_status_id').':') !!}
{!! Form::text('document_status_id', null, ['class' => 'form-control', 'id' => 'autocomplete3', 'table' => 'document_status']) !!}

<!-- Comments Field -->
{!! Form::label('comments', Lang::get('models.comments').':') !!}
{!! Form::text('comments', null, ['class' => 'form-control']) !!}


</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('production.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
