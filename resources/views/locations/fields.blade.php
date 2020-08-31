<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Department Code Field -->
{!! Form::label('department_code', Lang::get('models.department_code').':') !!}
{!! Form::text('department_code', null, ['class' => 'form-control','id' => 'autocomplete', 'table' => 'departments']) !!}  

<!-- Deposit Code Field -->
{!! Form::label('deposit_code', Lang::get('models.deposit_code').':') !!}
{!! Form::text('deposit_code', null, ['class' => 'form-control','id' => 'autocomplete1', 'table' => 'deposits', 'id_dep' => 'autocomplete', 'readonly']) !!}  

<!-- Sector Code Field -->
{!! Form::label('sector_code', Lang::get('models.sector_code').':') !!}
{!! Form::text('sector_code', null, ['class' => 'form-control','id' => 'autocomplete2', 'table' => 'sectors', 'id_dep' => 'autocomplete1', 'readonly']) !!}  

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    <input id='id' name='id' type='hidden' value='{!! $location->id !!}'>
    {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
@else
    {!! Form::text('code', null, ['class' => 'form-control']) !!}  
@endif

<!-- Barcode Field -->
{!! Form::label('barcode', Lang::get('models.barcode').':') !!}
{!! Form::text('barcode', null, ['class' => 'form-control']) !!}

<!-- Status Field -->
{!! Form::label('status', Lang::get('models.status').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="status"  value="0" >
    {{ Form::checkbox('status', 1, (!empty($location->status)) ? $location->status : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'status']) }}
    <label class="onoffswitch-label" for="status">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Aisle Field -->
{!! Form::label('aisle', Lang::get('models.aisle').':') !!}
{!! Form::text('aisle', null, ['class' => 'form-control']) !!}

<!-- Column Field -->
{!! Form::label('column', Lang::get('models.column').':') !!}
{!! Form::text('column', null, ['class' => 'form-control']) !!}

<!-- Level Field -->
{!! Form::label('level', Lang::get('models.level').':') !!}
{!! Form::number('level', null, ['class' => 'form-control']) !!}

<!-- Depth Field -->
{!! Form::label('depth', Lang::get('models.depth').':') !!}
{!! Form::number('depth', null, ['class' => 'form-control']) !!}



<!-- Location Type Code Field -->
{!! Form::label('location_type_code', Lang::get('models.location_type_code').':') !!}
{!! Form::select('location_type_code', $location_types, (!empty($location->location_type_code)) ? $location->location_type_code : 'null', ['class' => 'form-control']) !!}

<!-- Location Function Code Field -->
{!! Form::label('location_function_code', Lang::get('models.location_function_code').':') !!}
{!! Form::select('location_function_code', $location_functions, (!empty($location->location_function_code)) ? $location->location_function_code : 'null', ['class' => 'form-control']) !!}

<!-- Stock Type Field -->
{!! Form::label('stock_type_code', Lang::get('models.stock_type_code').':') !!}
{!! Form::select('stock_type_code', $stock_types, (!empty($location->stock_type_code)) ? $location->stock_type_code : 'null', ['class' => 'form-control']) !!}

<!-- Abz Code Field -->
{!! Form::label('abz_code', Lang::get('models.abz_code').':') !!}
{!! Form::number('abz_code', null, ['class' => 'form-control']) !!}

<!-- Label Type Code Field -->
{!! Form::label('label_type_code', Lang::get('models.label_type_code').':') !!}
{!! Form::text('label_type_code', null, ['class' => 'form-control','id' => 'autocomplete3', 'table' => 'label_types']) !!}  


<!-- Sequence Arm Field -->
{!! Form::label('sequence_arm', Lang::get('models.sequence_arm').':') !!}
{!! Form::number('sequence_arm', null, ['class' => 'form-control']) !!}

<!-- Sequence Sep Field -->
{!! Form::label('sequence_sep', Lang::get('models.sequence_sep').':') !!}
{!! Form::number('sequence_sep', null, ['class' => 'form-control']) !!}

<!-- Sequence Inv Field -->
{!! Form::label('sequence_inv', Lang::get('models.sequence_inv').':') !!}
{!! Form::number('sequence_inv', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('locations.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
