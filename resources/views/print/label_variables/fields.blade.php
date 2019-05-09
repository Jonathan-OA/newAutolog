<div class="form_fields">
@include('adminlte-templates::common.errors')
@include('flash::message')

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    <input id='id' name='id' type='hidden' value='{!! $labelVariable->id !!}'>
    {!! Form::text('code', null, ['class' => 'form-control','readonly']) !!}
@else
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
@endif

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Size Field -->
{!! Form::label('size', Lang::get('models.size').':') !!}
{!! Form::number('size', null, ['class' => 'form-control']) !!}

<!-- Size Start Field -->
{!! Form::label('size_start', Lang::get('models.size_start').':') !!}
{!! Form::number('size_start', (empty($labelVariable->size_start))?0:$labelVariable->size_start, ['class' => 'form-control']) !!}

<!-- Table Field -->
{!! Form::label('table', Lang::get('models.table').':') !!}
{!! Form::text('table', null, ['class' => 'form-control']) !!}

<!-- Field Field -->
{!! Form::label('field', Lang::get('models.field').':') !!}
{!! Form::text('field', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('labelVariables.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>