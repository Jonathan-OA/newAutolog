<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
@else
    {!! Form::text('code', null, ['class' => 'form-control']) !!}  
@endif

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}


<!-- Val Integer Field -->
{!! Form::label('val_integer', Lang::get('models.val_integer').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="val_integer"  value="0" >
    {{ Form::checkbox('val_integer', 1, (!empty($uom->val_integer)) ? $uom->val_integer : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'val_integer']) }}
    <label class="onoffswitch-label" for="val_integer">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Decimal Places Field -->
{!! Form::label('decimal_places', Lang::get('models.decimal_places').':') !!}
{!! Form::select('decimal_places', [ 0 => 'Nenhuma', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'], (!empty($uom->decimal_places)) ? $uom->decimal_places : '', ['class' => 'form-control', 'id' => 'decimal_places']) !!}

</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('uoms.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
