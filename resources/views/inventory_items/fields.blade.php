<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Document Id Field -->
{!! Form::label('document_id', Lang::get('models.document_id').':') !!}
{!! Form::number('document_id', null, ['class' => 'form-control']) !!}

<!-- Product Code Field -->
{!! Form::label('product_code', Lang::get('models.product_code').':') !!}
{!! Form::text('product_code', null, ['class' => 'form-control']) !!}

<!-- Pallet Id Field -->
{!! Form::label('pallet_id', Lang::get('models.pallet_id').':') !!}
{!! Form::number('pallet_id', null, ['class' => 'form-control']) !!}

<!-- Label Id Field -->
{!! Form::label('label_id', Lang::get('models.label_id').':') !!}
{!! Form::number('label_id', null, ['class' => 'form-control']) !!}

<!-- Location Code Field -->
{!! Form::label('location_code', Lang::get('models.location_code').':') !!}
{!! Form::text('location_code', null, ['class' => 'form-control']) !!}

<!-- Qty Wms Field -->
{!! Form::label('qty_wms', Lang::get('models.qty_wms').':') !!}
{!! Form::number('qty_wms', null, ['class' => 'form-control']) !!}

<!-- Inventory Status Id Field -->
{!! Form::label('inventory_status_id', Lang::get('models.inventory_status_id').':') !!}
{!! Form::number('inventory_status_id', null, ['class' => 'form-control']) !!}

<!-- Qty 1Count Field -->
{!! Form::label('qty_1count', Lang::get('models.qty_1count').':') !!}
{!! Form::number('qty_1count', null, ['class' => 'form-control']) !!}

<!-- User 1Count Field -->
{!! Form::label('user_1count', Lang::get('models.user_1count').':') !!}
{!! Form::text('user_1count', null, ['class' => 'form-control']) !!}

<!-- Date 1Count Field -->
{!! Form::label('date_1count', 'Date 1Count:') !!}
{!! Form::date('date_1count', null, ['class' => 'form-control']) !!}

<!-- Qty 2Count Field -->
{!! Form::label('qty_2count', Lang::get('models.qty_2count').':') !!}
{!! Form::number('qty_2count', null, ['class' => 'form-control']) !!}

<!-- User 2Count Field -->
{!! Form::label('user_2count', Lang::get('models.user_2count').':') !!}
{!! Form::text('user_2count', null, ['class' => 'form-control']) !!}

<!-- Date 2Count Field -->
{!! Form::label('date_2count', 'Date 2Count:') !!}
{!! Form::date('date_2count', null, ['class' => 'form-control']) !!}

<!-- Qty 3Count Field -->
{!! Form::label('qty_3count', Lang::get('models.qty_3count').':') !!}
{!! Form::number('qty_3count', null, ['class' => 'form-control']) !!}

<!-- User 3Count Field -->
{!! Form::label('user_3count', Lang::get('models.user_3count').':') !!}
{!! Form::text('user_3count', null, ['class' => 'form-control']) !!}

<!-- Date 3Count Field -->
{!! Form::label('date_3count', 'Date 3Count:') !!}
{!! Form::date('date_3count', null, ['class' => 'form-control']) !!}

<!-- Qty 4Count Field -->
{!! Form::label('qty_4count', Lang::get('models.qty_4count').':') !!}
{!! Form::number('qty_4count', null, ['class' => 'form-control']) !!}

<!-- User 4Count Field -->
{!! Form::label('user_4count', Lang::get('models.user_4count').':') !!}
{!! Form::text('user_4count', null, ['class' => 'form-control']) !!}

<!-- Date 4Count Field -->
{!! Form::label('date_4count', 'Date 4Count:') !!}
{!! Form::date('date_4count', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('inventoryItems.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
