<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Level Field -->
{!! Form::label('level', Lang::get('models.level').':') !!}


{!! Form::select('level', array('1' => '1', '2' => '2', '3' => '3'), null, ['class' => 'form-control']) !!}

<!-- Product Code Field -->
<input id='product_code' name='product_code' type='hidden' value='{!! $product_code !!}'>

<!-- Uom Code Field -->
{!! Form::label('uom_code', Lang::get('models.uom_code').':') !!}
@if(isset($action) && $action == 'edit')
{!! Form::text('uom_code', null, ['class' => 'form-control','readonly']) !!}    
    <!-- Id Field -->
    <input id='id' name='id' type='hidden' value='{!! $packing->id !!}'>
@else
    {!! Form::text('uom_code', null, ['class' => 'form-control','id' => 'autocomplete', 'table' => 'uoms']) !!}    
@endif


<!-- Barcode Field -->
{!! Form::label('barcode', Lang::get('models.barcode').':') !!}
{!! Form::text('barcode', null, ['class' => 'form-control']) !!}

<!-- Prev Qty Field -->
{!! Form::label('prev_qty', Lang::get('models.prev_qty').':') !!}
{!! Form::number('prev_qty', null, ['class' => 'form-control', 'step' => '0.000001', 'placeholder' => '0,000000']) !!}


<!-- Prev Level Field -->
{!! Form::label('prev_level', Lang::get('models.prev_level').':') !!}
{!! Form::number('prev_level', null, ['class' => 'form-control']) !!}

<!-- Prim Qty Field -->
{!! Form::label('prim_qty', Lang::get('models.prim_qty').':') !!}
{!! Form::number('prim_qty', null, ['class' => 'form-control', 'step' => '0.000001', 'placeholder' => '0,000000']) !!}



<!-- Label Type Code Field -->
{!! Form::label('label_type_code', Lang::get('models.label_type_code').':') !!}
{!! Form::text('label_type_code', null, ['class' => 'form-control','id' => 'autocomplete1', 'table' => 'label_types']) !!}

<!-- Total Weight Field -->
{!! Form::label('total_weight', Lang::get('models.total_weight').':') !!}
{!! Form::number('total_weight', null, ['class' => 'form-control']) !!}

<!-- Total Net Weight Field -->
{!! Form::label('total_net_weight', Lang::get('models.total_net_weight').':') !!}
{!! Form::number('total_net_weight', null, ['class' => 'form-control']) !!}

<!-- Lenght Field -->
{!! Form::label('lenght', Lang::get('models.lenght').':') !!}
{!! Form::number('lenght', null, ['class' => 'form-control']) !!}

<!-- Width Field -->
{!! Form::label('width', Lang::get('models.width').':') !!}
{!! Form::number('width', null, ['class' => 'form-control']) !!}

<!-- Depth Field -->
{!! Form::label('depth', Lang::get('models.depth').':') !!}
{!! Form::number('depth', null, ['class' => 'form-control']) !!}

<!-- Total M3 Field -->
{!! Form::label('total_m3', Lang::get('models.total_m3').':') !!}
{!! Form::number('total_m3', null, ['class' => 'form-control']) !!}

<!-- Stacking Field -->
{!! Form::label('stacking', Lang::get('models.stacking').':') !!}
{!! Form::number('stacking', null, ['class' => 'form-control']) !!}

<!-- Packing Type Code Field -->
{!! Form::label('packing_type_code', Lang::get('models.packing_type_code').':') !!}
{!! Form::text('packing_type_code', null, ['class' => 'form-control','id' => 'autocomplete2', 'table' => 'packing_types']) !!}

<!-- Print Label Field -->
{!! Form::label('print_label', Lang::get('models.print_label').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="print_label"  value="0" >
    {{ Form::checkbox('print_label', 1, (!empty($packing->print_label)) ? $packing->print_label : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'print_label']) }}
    <label class="onoffswitch-label" for="print_label">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>
    
<!-- Create Label Field -->
{!! Form::label('create_label', Lang::get('models.create_label').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="create_label"  value="0" >
    {{ Form::checkbox('create_label', 1, (!empty($packing->create_label)) ? $packing->create_label : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'create_label']) }}
    <label class="onoffswitch-label" for="create_label">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Conf Batch Field -->
{!! Form::label('conf_batch', Lang::get('models.conf_batch').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="conf_batch"  value="0" >
    {{ Form::checkbox('conf_batch', 1, (!empty($packing->conf_batch)) ? $packing->conf_batch : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'conf_batch']) }}
    <label class="onoffswitch-label" for="conf_batch">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Conf Weight Field -->
{!! Form::label('conf_weight', Lang::get('models.conf_weight').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="conf_weight"  value="0" >
    {{ Form::checkbox('conf_weight', 1, (!empty($packing->conf_weight)) ? $packing->conf_weight : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'conf_weight']) }}
    <label class="onoffswitch-label" for="conf_weight">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Conf Serial Field -->
{!! Form::label('conf_serial', Lang::get('models.conf_serial').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="conf_serial"  value="0" >
    {{ Form::checkbox('conf_serial', 1, (!empty($packing->conf_serial)) ? $packing->conf_serial : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'conf_serial']) }}
    <label class="onoffswitch-label" for="conf_serial">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Conf Batch Supplier Field -->
{!! Form::label('conf_batch_supplier', Lang::get('models.conf_batch_supplier').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="conf_batch_supplier"  value="0" >
    {{ Form::checkbox('conf_batch_supplier', 1, (!empty($packing->conf_batch_supplier)) ? $packing->conf_batch_supplier : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'conf_batch_supplier']) }}
    <label class="onoffswitch-label" for="conf_batch_supplier">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Conf Due Date Field -->
{!! Form::label('conf_due_date', Lang::get('models.conf_due_date').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="conf_due_date"  value="0" >
    {{ Form::checkbox('conf_due_date', 1, (!empty($packing->conf_due_date)) ? $packing->conf_due_date : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'conf_due_date']) }}
    <label class="onoffswitch-label" for="conf_due_date">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Conf Prod Date Field -->
{!! Form::label('conf_prod_date', Lang::get('models.conf_prod_date').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="conf_prod_date"  value="0" >
    {{ Form::checkbox('conf_prod_date', 1, (!empty($packing->conf_prod_date)) ? $packing->conf_prod_date : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'conf_prod_date']) }}
    <label class="onoffswitch-label" for="conf_prod_date">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Conf Lenght Field -->
{!! Form::label('conf_length', Lang::get('models.conf_length').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="conf_length"  value="0" >
    {{ Form::checkbox('conf_length', 1, (!empty($packing->conf_length)) ? $packing->conf_length : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'conf_length']) }}
    <label class="onoffswitch-label" for="conf_length">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Conf Width Field -->
{!! Form::label('conf_width', Lang::get('models.conf_width').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="conf_width"  value="0" >
    {{ Form::checkbox('conf_width', 1, (!empty($packing->conf_width)) ? $packing->conf_width : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'conf_width']) }}
    <label class="onoffswitch-label" for="conf_width">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Conf Height Field -->
{!! Form::label('conf_height', Lang::get('models.conf_height').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="conf_height"  value="0" >
    {{ Form::checkbox('conf_height', 1, (!empty($packing->conf_height)) ? $packing->conf_height : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'conf_height']) }}
    <label class="onoffswitch-label" for="conf_height">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! action('PackingController@index',[$product_code]) !!}" class="btn btn-default">@lang('buttons.cancel')</a>
