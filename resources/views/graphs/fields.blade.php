<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Code Field -->
                                      {!! Form::label('code', Lang::get('models.code').':') !!}
                                      @if(isset($action) && $action == 'edit')
                                         {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
                                      @else
                                         {!! Form::text('code', null, ['class' => 'form-control']) !!}
                                      @endif

<!-- Title Field -->
{!! Form::label('title', Lang::get('models.title').':') !!}
{!! Form::text('title', null, ['class' => 'form-control']) !!}

<!-- Type Field -->
{!! Form::label('type', Lang::get('models.type').':') !!}
{!! Form::text('type', null, ['class' => 'form-control']) !!}

<!-- Color Field -->
{!! Form::label('color', Lang::get('models.color').':') !!}
{!! Form::text('color', null, ['class' => 'form-control']) !!}

<!-- Enabled Field -->
{!! Form::label('enabled', Lang::get('models.enabled').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="enabled"  value="0" >
    {{ Form::checkbox('enabled', 1, (!empty($graph->enabled)) ? $graph->enabled : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'enabled']) }}
    <label class="onoffswitch-label" for="enabled">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('graphs.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
