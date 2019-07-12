<div class="form_fields">
@include('adminlte-templates::common.errors')

@if(isset($action) && $action == 'edit')
    <input id='id' name='id' type='hidden' value='{!! $notification->id !!}'>
@endif

<!-- User Id Field -->
{!! Form::label('user_id', Lang::get('models.user_id').':') !!}
{!! Form::number('user_id', null, ['class' => 'form-control']) !!}

<!-- Message Field -->
{!! Form::label('message', Lang::get('models.message').':') !!}
{!! Form::textarea('message', null, ['class' => 'form-control']) !!}

<!-- Visualized Field -->
<div class="form-group col-sm-6">
    {!! Form::label('visualized', 'Visualized:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('visualized', false) !!}
        {!! Form::checkbox('visualized', '1', null) !!} 1
    </label>
</div>
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('notifications.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>