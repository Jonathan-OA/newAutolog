<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Document Id Field -->
{!! Form::label('document_id', Lang::get('models.document_id').':') !!}
{!! Form::number('document_id', null, ['class' => 'form-control']) !!}

<!-- Document Item Id Field -->
{!! Form::label('document_item_id', Lang::get('models.document_item_id').':') !!}
{!! Form::number('document_item_id', null, ['class' => 'form-control']) !!}

<!-- Product Code Field -->
{!! Form::label('product_code', Lang::get('models.product_code').':') !!}
{!! Form::text('product_code', null, ['class' => 'form-control']) !!}

<!-- Pallet Id Field -->
{!! Form::label('pallet_id', Lang::get('models.pallet_id').':') !!}
{!! Form::number('pallet_id', null, ['class' => 'form-control']) !!}

<!-- Label Id Field -->
{!! Form::label('label_id', Lang::get('models.label_id').':') !!}
{!! Form::number('label_id', null, ['class' => 'form-control']) !!}

<!-- Qty Field -->
{!! Form::label('qty', Lang::get('models.qty').':') !!}
{!! Form::number('qty', null, ['class' => 'form-control']) !!}

<!-- Liberation Status Id Field -->
{!! Form::label('liberation_status_id', Lang::get('models.liberation_status_id').':') !!}
{!! Form::number('liberation_status_id', null, ['class' => 'form-control']) !!}

<!-- Orig Location Code Field -->
{!! Form::label('orig_location_code', Lang::get('models.orig_location_code').':') !!}
{!! Form::text('orig_location_code', null, ['class' => 'form-control']) !!}

<!-- Dest Location Code Field -->
{!! Form::label('dest_location_code', Lang::get('models.dest_location_code').':') !!}
{!! Form::text('dest_location_code', null, ['class' => 'form-control']) !!}

<!-- Task Id Field -->
{!! Form::label('task_id', Lang::get('models.task_id').':') !!}
{!! Form::number('task_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('liberationItems.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
