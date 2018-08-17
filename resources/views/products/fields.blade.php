<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id="company_id" name="company_id" type="hidden" value="{!! Auth::user()->company_id !!}">

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
     <!-- Id Field -->
     <input id='id' name='id' type='hidden' value='{!! $product->id !!}'>
@else
    {!! Form::text('code', null, ['class' => 'form-control']) !!}  
@endif

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Status Field -->
{!! Form::label('status', Lang::get('models.status').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="status"  value="0" >
    {{ Form::checkbox('status', 1, (!empty($product->status)) ? $product->status : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'status']) }}
    <label class="onoffswitch-label" for="status">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Origin Field -->
{!! Form::label('origin', Lang::get('models.origin_product').':') !!}
{!! Form::text('origin', null, ['class' => 'form-control']) !!}

<!-- Product Type Code Field -->
{!! Form::label('product_type_code', Lang::get('models.product_type_code').':') !!}
{!! Form::select('product_type_code', $prd_types, null, ['class' => 'form-control']) !!}

<!-- Group Code Field -->
{!! Form::label('group_code', Lang::get('models.group_code').':') !!}
{!! Form::select('group_code', $groups, null, ['class' => 'form-control']) !!}

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
{!! Form::label('inventory_date', Lang::get('models.inventory_date').':') !!}
{!! Form::date('inventory_date', (!empty($product->inventory_date)) ? $product->inventory_date->format('Y-m-d') : '', ['class' => 'form-control','readonly']) !!}

<!-- Critical Date1 Field -->
{!! Form::label('critical_date1', Lang::get('models.critical_date1').':') !!}
{!! Form::date('critical_date1', (!empty($product->critical_date1)) ? $product->critical_date1->format('Y-m-d') : '', ['class' => 'form-control']) !!}

<!-- Critical Date2 Field -->
{!! Form::label('critical_date2', Lang::get('models.critical_date2').':') !!}
{!! Form::date('critical_date2', (!empty($product->critical_date2)) ? $product->critical_date2->format('Y-m-d') : '', ['class' => 'form-control']) !!}

<!-- Critical Date3 Field -->
{!! Form::label('critical_date3', Lang::get('models.critical_date3').':') !!}
{!! Form::date('critical_date3', (!empty($product->critical_date3)) ? $product->critical_date3->format('Y-m-d') : '', ['class' => 'form-control']) !!}

<!-- Ripeness Date Field -->
{!! Form::label('ripeness_date', Lang::get('models.ripeness_date').':') !!}
{!! Form::date('ripeness_date', (!empty($product->ripeness_date)) ? $product->ripeness_date->format('Y-m-d') : '', ['class' => 'form-control']) !!}

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
