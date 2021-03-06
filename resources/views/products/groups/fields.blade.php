<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
    <!-- Id Field -->
    <input id='id' name='id' type='hidden' value='{!! $group->id !!}'>
@else
    {!! Form::text('code', null, ['class' => 'form-control']) !!}  
@endif

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Product Type Code Field -->
{!! Form::label('product_type_code', Lang::get('models.product_type_code').':') !!}
{!! Form::select('product_type_code', $prd_types, null, ['class' => 'form-control']) !!}

<!-- Label Type Code Field -->
{!! Form::label('label_type_code', Lang::get('models.label_type_code').':') !!}
{!! Form::text('label_type_code', null, ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'label_types']) !!}

<!-- TRF Movement Field -->
<span aria-label="@lang('infos.groups.trf_movement')" data-microtip-position="right" role="tooltip">
    <img class='icon' src='{{asset('/icons/information.png') }}' >
</span>
{!! Form::label('trf_movement', Lang::get('models.trf_movement').':') !!}
{!! Form::number('trf_movement', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('groups.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
