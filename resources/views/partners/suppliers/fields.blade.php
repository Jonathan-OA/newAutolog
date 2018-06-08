<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id="company_id" name="company_id" type="hidden" value="{!! Auth::user()->company_id !!}">

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
@else
    {!! Form::text('code', null, ['class' => 'form-control']) !!}  
@endif

<!-- Name Field -->
{!! Form::label('name', Lang::get('models.name').':') !!}
{!! Form::text('name', null, ['class' => 'form-control']) !!}

<!-- Trading Name Field -->
{!! Form::label('trading_name', Lang::get('models.trading_name').':') !!}
{!! Form::text('trading_name', null, ['class' => 'form-control']) !!}

<!-- Cnpj Field -->
{!! Form::label('cnpj', Lang::get('models.cnpj').':') !!}
{!! Form::text('cnpj', null, ['class' => 'form-control']) !!}

<!-- State Registration Field -->
{!! Form::label('state_registration', Lang::get('models.state_registration').':') !!}
{!! Form::text('state_registration', null, ['class' => 'form-control']) !!}

<!-- Address Field -->
{!! Form::label('address', Lang::get('models.address').':') !!}
{!! Form::text('address', null, ['class' => 'form-control']) !!}

<!-- Number Field -->
{!! Form::label('number', Lang::get('models.number').':') !!}
{!! Form::number('number', null, ['class' => 'form-control']) !!}

<!-- Neighbourhood Field -->
{!! Form::label('neighbourhood', Lang::get('models.neighbourhood').':') !!}
{!! Form::text('neighbourhood', null, ['class' => 'form-control']) !!}

<!-- City Field -->
{!! Form::label('city', Lang::get('models.city').':') !!}
{!! Form::text('city', null, ['class' => 'form-control']) !!}

<!-- State Field -->
{!! Form::label('state', Lang::get('models.state').':') !!}
{!! Form::text('state', null, ['class' => 'form-control']) !!}

<!-- Country Field -->
{!! Form::label('country', Lang::get('models.country').':') !!}
{!! Form::text('country', null, ['class' => 'form-control']) !!}

<!-- Zip Code Field -->
{!! Form::label('zip_code', Lang::get('models.zip_code').':') !!}
{!! Form::text('zip_code', null, ['class' => 'form-control']) !!}

<!-- Phone1 Field -->
{!! Form::label('phone1', Lang::get('models.phone1').':') !!}
{!! Form::text('phone1', null, ['class' => 'form-control']) !!}

<!-- Phone2 Field -->
{!! Form::label('phone2', Lang::get('models.phone2').':') !!}
{!! Form::text('phone2', null, ['class' => 'form-control']) !!}

<!-- Active Field -->
{!! Form::label('status', Lang::get('models.active').':') !!}
{!! Form::select('status', array('1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}

<!-- Obs1 Field -->
{!! Form::label('obs1', Lang::get('models.obs1').':') !!}
{!! Form::text('obs1', null, ['class' => 'form-control']) !!}

<!-- Obs2 Field -->
{!! Form::label('obs2', Lang::get('models.obs2').':') !!}
{!! Form::text('obs2', null, ['class' => 'form-control']) !!}

<!-- Obs3 Field -->
{!! Form::label('obs3', Lang::get('models.obs3').':') !!}
{!! Form::text('obs3', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('suppliers.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
