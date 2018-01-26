<div class="form_fields">
    @include('adminlte-templates::common.errors')
    
    <!-- Company Id Field -->
    <input id="company_id" name="company_id" type="hidden" value="{!! Auth::user()->company_id !!}">

    <!-- Module Name Field -->
    {!! Form::label('module_name', Lang::get('models.module_name').':') !!}
    {!! Form::select('module_name', $modules, 'null', ['class' => 'form-control']) !!}

    <!-- Operation Code Field -->
    {!! Form::label('operation_code', Lang::get('models.operation_code').':') !!}
    {!! Form::select('operation_code', $operations, 'null', ['class' => 'form-control']) !!}

    <!-- Code Field -->
    {!! Form::label('code', Lang::get('models.code').':') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}

    <!-- Description Field -->
    {!! Form::label('description', Lang::get('models.description').':') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}

    <!-- Value Field -->
    {!! Form::label('value', Lang::get('models.value').':') !!}
    {!! Form::text('value', null, ['class' => 'form-control']) !!}

    <!-- Def Value Field -->
    {!! Form::label('def_value', Lang::get('models.def_value').':') !!}
    {!! Form::text('def_value', null, ['class' => 'form-control']) !!}

</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('parameters.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>