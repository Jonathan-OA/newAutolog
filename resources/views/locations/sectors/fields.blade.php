<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Deposit Code Field -->
{!! Form::label('deposit_code', Lang::get('models.deposit_code').':') !!}
{!! Form::select('deposit_code', $deposits, null, ['class' => 'form-control']) !!}

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
{!! Form::text('code', null, ['class' => 'form-control']) !!}

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Status Field -->
{!! Form::label('status', Lang::get('models.status').':') !!}
{!! Form::select('status', array('1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('sectors.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
