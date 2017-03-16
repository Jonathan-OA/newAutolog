<div class="form_fields">
<!-- Code Field -->
{!! Form::label('code', 'Code:') !!}
{!! Form::text('code', null, ['class' => 'form-control']) !!}

<!-- Company Id Field -->
{!! Form::label('company_id', 'Company Id:') !!}
{!! Form::number('company_id', null, ['class' => 'form-control']) !!}

<!-- Name Field -->
{!! Form::label('name', 'Name:') !!}
{!! Form::text('name', null, ['class' => 'form-control']) !!}

<!-- Trading Name Field -->
{!! Form::label('trading_name', 'Trading Name:') !!}
{!! Form::text('trading_name', null, ['class' => 'form-control']) !!}

<!-- Cnpj Field -->
{!! Form::label('cnpj', 'Cnpj:') !!}
{!! Form::text('cnpj', null, ['class' => 'form-control']) !!}

<!-- State Registration Field -->
{!! Form::label('state_registration', 'State Registration:') !!}
{!! Form::text('state_registration', null, ['class' => 'form-control']) !!}

<!-- Address Field -->
{!! Form::label('address', 'Address:') !!}
{!! Form::text('address', null, ['class' => 'form-control']) !!}

<!-- Number Field -->
{!! Form::label('number', 'Number:') !!}
{!! Form::number('number', null, ['class' => 'form-control']) !!}

<!-- Neighbourhood Field -->
{!! Form::label('neighbourhood', 'Neighbourhood:') !!}
{!! Form::text('neighbourhood', null, ['class' => 'form-control']) !!}

<!-- City Field -->
{!! Form::label('city', 'City:') !!}
{!! Form::text('city', null, ['class' => 'form-control']) !!}

<!-- State Field -->
{!! Form::label('state', 'State:') !!}
{!! Form::text('state', null, ['class' => 'form-control']) !!}

<!-- Country Field -->
{!! Form::label('country', 'Country:') !!}
{!! Form::text('country', null, ['class' => 'form-control']) !!}

<!-- Zip Code Field -->
{!! Form::label('zip_code', 'Zip Code:') !!}
{!! Form::text('zip_code', null, ['class' => 'form-control']) !!}

<!-- Phone1 Field -->
{!! Form::label('phone1', 'Phone1:') !!}
{!! Form::text('phone1', null, ['class' => 'form-control']) !!}

<!-- Phone2 Field -->
{!! Form::label('phone2', 'Phone2:') !!}
{!! Form::text('phone2', null, ['class' => 'form-control']) !!}

<!-- Active Field -->
{!! Form::label('active', 'Active:') !!}
{!! Form::number('active', null, ['class' => 'form-control']) !!}

<!-- Obs1 Field -->
{!! Form::label('obs1', 'Obs1:') !!}
{!! Form::text('obs1', null, ['class' => 'form-control']) !!}

<!-- Obs2 Field -->
{!! Form::label('obs2', 'Obs2:') !!}
{!! Form::text('obs2', null, ['class' => 'form-control']) !!}

<!-- Obs3 Field -->
{!! Form::label('obs3', 'Obs3:') !!}
{!! Form::text('obs3', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
<a href="{!! route('customers.index') !!}" class="btn btn-default">Cancelar</a>
