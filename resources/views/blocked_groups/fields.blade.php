<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Deposit Code Field -->
{!! Form::label('deposit_code', Lang::get('models.deposit_code').':') !!}
{!! Form::text('deposit_code', null, ['class' => 'form-control','id'=> 'autocomplete', 'table' => 'deposits']) !!}

<!-- Sector Code Field -->
{!! Form::label('sector_code', Lang::get('models.sector_code').':') !!}
{!! Form::text('sector_code', null, ['class' => 'form-control','id'=> 'autocomplete1', 'table' => 'sectors', 'id_dep' => 'autocomplete', 'readonly']) !!}

<!-- Group Code Field -->
{!! Form::label('group_code', Lang::get('models.group_code').':') !!}
{!! Form::text('group_code', null, ['class' => 'form-control','id'=> 'autocomplete2', 'table' => 'groups']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('blockedGroups.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
