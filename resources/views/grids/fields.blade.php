<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Module Field -->
{!! Form::label('module', Lang::get('models.module').':') !!}
{!! Form::text('module', null, ['class' => 'form-control']) !!}

<!-- Submodule Field -->
{!! Form::label('submodule', Lang::get('models.submodule').':') !!}
{!! Form::text('submodule', null, ['class' => 'form-control']) !!}

<!-- Columns Field -->
{!! Form::label('columns', Lang::get('models.columns').':') !!}
{!! Form::textarea('columns', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('grids.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
