<div class="form_fields">
@include('adminlte-templates::common.errors')
<!-- Company Id Field -->
{!! Form::label('company_id', Lang::get('models.company_id').':') !!}
{!! Form::number('company_id', null, ['class' => 'form-control']) !!}

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
{!! Form::text('code', null, ['class' => 'form-control']) !!}

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Status Field -->
{!! Form::label('status', Lang::get('models.status').':') !!}
{!! Form::number('status', null, ['class' => 'form-control']) !!}

<!-- Item Type Code Field -->
{!! Form::label('item_type_code', Lang::get('models.item_type_code').':') !!}
{!! Form::text('item_type_code', null, ['class' => 'form-control']) !!}

<!-- Group Code Field -->
{!! Form::label('group_code', Lang::get('models.group_code').':') !!}
{!! Form::text('group_code', null, ['class' => 'form-control']) !!}

<!-- Subgroup Code Field -->
{!! Form::label('subgroup_code', Lang::get('models.subgroup_code').':') !!}
{!! Form::text('subgroup_code', null, ['class' => 'form-control']) !!}

<!-- Margin Div Field -->
{!! Form::label('margin_div', Lang::get('models.margin_div').':') !!}
{!! Form::number('margin_div', null, ['class' => 'form-control']) !!}

<!-- Cost Field -->
{!! Form::label('cost', Lang::get('models.cost').':') !!}
{!! Form::number('cost', null, ['class' => 'form-control']) !!}

<!-- Phase Code Field -->
{!! Form::label('phase_code', Lang::get('models.phase_code').':') !!}
{!! Form::text('phase_code', null, ['class' => 'form-control']) !!}

<!-- Abz Code Field -->
{!! Form::label('abz_code', Lang::get('models.abz_code').':') !!}
{!! Form::text('abz_code', null, ['class' => 'form-control']) !!}

<!-- Inventory Date Field -->
{!! Form::label('inventory_date', 'Inventory Date:') !!}
{!! Form::date('inventory_date', null, ['class' => 'form-control']) !!}

<!-- Due Date Field -->
{!! Form::label('due_date', 'Due Date:') !!}
{!! Form::date('due_date', null, ['class' => 'form-control']) !!}

<!-- Critical Date1 Field -->
{!! Form::label('critical_date1', 'Critical Date1:') !!}
{!! Form::date('critical_date1', null, ['class' => 'form-control']) !!}

<!-- Critical Date2 Field -->
{!! Form::label('critical_date2', 'Critical Date2:') !!}
{!! Form::date('critical_date2', null, ['class' => 'form-control']) !!}

<!-- Critical Date3 Field -->
{!! Form::label('critical_date3', 'Critical Date3:') !!}
{!! Form::date('critical_date3', null, ['class' => 'form-control']) !!}

<!-- Ripeness Date Field -->
{!! Form::label('ripeness_date', 'Ripeness Date:') !!}
{!! Form::date('ripeness_date', null, ['class' => 'form-control']) !!}

<!-- Obs1 Field -->
{!! Form::label('obs1', Lang::get('models.obs1').':') !!}
{!! Form::text('obs1', null, ['class' => 'form-control']) !!}

<!-- Obs2 Field -->
{!! Form::label('obs2', Lang::get('models.obs2').':') !!}
{!! Form::text('obs2', null, ['class' => 'form-control']) !!}

<!-- Obs3 Field -->
{!! Form::label('obs3', Lang::get('models.obs3').':') !!}
{!! Form::text('obs3', null, ['class' => 'form-control']) !!}

<!-- Obs4 Field -->
{!! Form::label('obs4', Lang::get('models.obs4').':') !!}
{!! Form::text('obs4', null, ['class' => 'form-control']) !!}

<!-- Obs5 Field -->
{!! Form::label('obs5', Lang::get('models.obs5').':') !!}
{!! Form::text('obs5', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('products.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
