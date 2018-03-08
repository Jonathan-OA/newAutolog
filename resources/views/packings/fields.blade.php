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
{!! Form::select('uom_code', $uoms, null, ['class' => 'form-control']) !!}

<!-- Barcode Field -->
{!! Form::label('barcode', Lang::get('models.barcode').':') !!}
{!! Form::text('barcode', null, ['class' => 'form-control']) !!}

<!-- Prev Qty Field -->
{!! Form::label('prev_qty', Lang::get('models.prev_qty').':') !!}
{!! Form::number('prev_qty', null, ['class' => 'form-control', 'step' => '0.000001', 'placeholder' => '0,000000']) !!}


<!-- Prev Level Field -->
{!! Form::label('prev_level', Lang::get('models.prev_level').':') !!}
{!! Form::number('prev_level', null, ['class' => 'form-control']) !!}

<!-- Label Type Code Field -->
{!! Form::label('label_type_code', Lang::get('models.label_type_code').':') !!}
{!! Form::text('label_type_code', null, ['class' => 'form-control','id' => 'autocomplete', 'table' => 'label_types']) !!}

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
{!! Form::select('print_label', array('' => '','1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}

<!-- Create Label Field -->
{!! Form::label('create_label', Lang::get('models.create_label').':') !!}
{!! Form::select('create_label', array('' => '','1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}

<!-- Conf Batch Field -->
{!! Form::label('conf_batch', Lang::get('models.conf_batch').':') !!}
{!! Form::select('conf_batch', array('' => '', '1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}

<!-- Conf Weight Field -->
{!! Form::label('conf_weight', Lang::get('models.conf_weight').':') !!}
{!! Form::select('conf_weight', array('' => '','1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}

<!-- Conf Serial Field -->
{!! Form::label('conf_serial', Lang::get('models.conf_serial').':') !!}
{!! Form::select('conf_serial', array('' => '','1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}

<!-- Conf Batch Supplier Field -->
{!! Form::label('conf_batch_supplier', Lang::get('models.conf_batch_supplier').':') !!}
{!! Form::select('conf_batch_supplier', array('' => '','1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}

<!-- Conf Due Date Field -->
{!! Form::label('conf_due_date', Lang::get('models.conf_due_date').':') !!}
{!! Form::select('conf_due_date', array('' => '','1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}

<!-- Conf Prod Date Field -->
{!! Form::label('conf_prod_date', Lang::get('models.conf_prod_date').':') !!}
{!! Form::select('conf_prod_date', array('' => '','1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}

<!-- Conf Lenght Field -->
{!! Form::label('conf_length', Lang::get('models.conf_length').':') !!}
{!! Form::select('conf_length', array('' => '','1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}

<!-- Conf Width Field -->
{!! Form::label('conf_width', Lang::get('models.conf_width').':') !!}
{!! Form::select('conf_width', array('' => '','1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}

<!-- Conf Height Field -->
{!! Form::label('conf_height', Lang::get('models.conf_height').':') !!}
{!! Form::select('conf_height', array('' => '','1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}

</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! action('PackingController@index',[$product_code]) !!}" class="btn btn-default">@lang('buttons.cancel')</a>
