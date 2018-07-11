<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Number Field -->
{!! Form::label('number', Lang::get('models.number').':') !!}
{!! Form::text('number', null, ['class' => 'form-control']) !!}

<!-- Customer Id Field -->
{!! Form::label('customer_id', Lang::get('models.customer_id').':') !!}
{!! Form::number('customer_id', null, ['class' => 'form-control']) !!}

<!-- Supplier Id Field -->
{!! Form::label('supplier_id', Lang::get('models.supplier_id').':') !!}
{!! Form::number('supplier_id', null, ['class' => 'form-control']) !!}

<!-- Courier Id Field -->
{!! Form::label('courier_id', Lang::get('models.courier_id').':') !!}
{!! Form::number('courier_id', null, ['class' => 'form-control']) !!}

<!-- Invoice Field -->
{!! Form::label('invoice', Lang::get('models.invoice').':') !!}
{!! Form::number('invoice', null, ['class' => 'form-control']) !!}

<!-- Serial Number Field -->
{!! Form::label('serial_number', Lang::get('models.serial_number').':') !!}
{!! Form::number('serial_number', null, ['class' => 'form-control']) !!}

<!-- Emission Date Field -->
{!! Form::label('emission_date', 'Emission Date:') !!}
{!! Form::date('emission_date', null, ['class' => 'form-control']) !!}

<!-- Start Date Field -->
{!! Form::label('start_date', 'Start Date:') !!}
{!! Form::date('start_date', null, ['class' => 'form-control']) !!}

<!-- End Date Field -->
{!! Form::label('end_date', 'End Date:') !!}
{!! Form::date('end_date', null, ['class' => 'form-control']) !!}

<!-- Wave Field -->
{!! Form::label('wave', Lang::get('models.wave').':') !!}
{!! Form::number('wave', null, ['class' => 'form-control']) !!}

<!-- Total Volumes Field -->
{!! Form::label('total_volumes', Lang::get('models.total_volumes').':') !!}
{!! Form::number('total_volumes', null, ['class' => 'form-control']) !!}

<!-- Total Weight Field -->
{!! Form::label('total_weight', Lang::get('models.total_weight').':') !!}
{!! Form::number('total_weight', null, ['class' => 'form-control']) !!}

<!-- Document Status Id Field -->
{!! Form::label('document_status_id', Lang::get('models.document_status_id').':') !!}
{!! Form::number('document_status_id', null, ['class' => 'form-control']) !!}

<!-- Total Net Weigth Field -->
{!! Form::label('total_net_weigth', Lang::get('models.total_net_weigth').':') !!}
{!! Form::number('total_net_weigth', null, ['class' => 'form-control']) !!}

<!-- Driver Id Field -->
{!! Form::label('driver_id', Lang::get('models.driver_id').':') !!}
{!! Form::number('driver_id', null, ['class' => 'form-control']) !!}

<!-- Vehicle Id Field -->
{!! Form::label('vehicle_id', Lang::get('models.vehicle_id').':') !!}
{!! Form::number('vehicle_id', null, ['class' => 'form-control']) !!}

<!-- Priority Field -->
{!! Form::label('priority', Lang::get('models.priority').':') !!}
{!! Form::number('priority', null, ['class' => 'form-control']) !!}

<!-- Comments Field -->
{!! Form::label('comments', Lang::get('models.comments').':') !!}
{!! Form::text('comments', null, ['class' => 'form-control']) !!}

<!-- Document Type Code Field -->
{!! Form::label('document_type_code', Lang::get('models.document_type_code').':') !!}
{!! Form::text('document_type_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('documentts.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
