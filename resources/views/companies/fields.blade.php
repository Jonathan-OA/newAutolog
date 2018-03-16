<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
@else
    {!! Form::text('code', null, ['class' => 'form-control']) !!}  
@endif

<!-- Branch Field -->
{!! Form::label('branch', Lang::get('models.branch').':') !!}
{!! Form::text('branch', null, ['class' => 'form-control']) !!}

<!-- Name Field -->
{!! Form::label('name', Lang::get('models.name').':') !!}
{!! Form::text('name', null, ['class' => 'form-control']) !!}

<!-- Cnpj Field -->
{!! Form::label('cnpj', Lang::get('models.cnpj').':') !!}
{!! Form::text('cnpj', null, ['class' => 'form-control']) !!}

<!-- Trading Name Field -->
{!! Form::label('trading_name', Lang::get('models.trading_name').':') !!}
{!! Form::text('trading_name', null, ['class' => 'form-control']) !!}

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
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('companies.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
