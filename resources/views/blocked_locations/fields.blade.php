<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Location Code Field -->
{!! Form::label('location_code', Lang::get('models.location_code').':') !!}
{!! Form::text('location_code', null, ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'locations']) !!}

<!-- Product Code Field -->
{!! Form::label('product_code', Lang::get('models.product_code').':') !!}
{!! Form::text('product_code', null, ['class' => 'form-control', 'id' => 'autocomplete1', 'table' => 'products']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('blockedLocations.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
