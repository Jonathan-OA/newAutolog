<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Document Type Code Field -->
{!! Form::label('document_type_code', Lang::get('models.document_type_code').':') !!}
{!! Form::text('document_type_code', null, ['class' => 'form-control']) !!}

<!-- Liberation Rule Code Field -->
{!! Form::label('liberation_rule_code', Lang::get('models.liberation_rule_code').':') !!}
{!! Form::text('liberation_rule_code', null, ['class' => 'form-control']) !!}

<!-- Order Field -->
{!! Form::label('order', Lang::get('models.order').':') !!}
{!! Form::number('order', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('documentTypeRules.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
