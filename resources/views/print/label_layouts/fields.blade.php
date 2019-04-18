<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

@if(isset($action) && $action == 'edit')
    <input id='id' name='id' type='hidden' value='{!! $labelLayout->id !!}'>
@endif

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('code', null, ['class' => 'form-control', 'readonly']) !!}
@else
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
@endif

<!-- Label Type Code Field -->
{!! Form::label('label_type_code', Lang::get('models.label_type_code').':') !!}
{!! Form::text('label_type_code', null, ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'label_types']) !!}

<!-- Printer Type Code Field -->
{!! Form::label('printer_type_code', Lang::get('models.printer_type_code').':') !!}
{!! Form::text('printer_type_code', null, ['class' => 'form-control', 'id' => 'autocomplete1', 'table' => 'printer_types']) !!}

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Status Field -->
{!! Form::label('status', Lang::get('models.status').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="status"  value="0" >
    {{ Form::checkbox('status', 1, (!empty($labelLayout->status)) ? $labelLayout->status : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'status']) }}
    <label class="onoffswitch-label" for="status">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Commands Field -->
<div class="col-md-6">
    {!! Form::label('commands', Lang::get('models.commands').':') !!}
    {!! Form::textarea('commands', null, ['class' => 'form-control', 'id' => 'commands']) !!}
</div>
<div class="col-md-6">
    <!-- Div para pré visualização da ETQ -->
    <span aria-label="@lang('infos.labellayouts.commands')" data-microtip-position="bottom" role="tooltip">
            <img class='icon' src='{{asset('/icons/information.png') }}' >
        </span>
    {!! Form::label('viewer', Lang::get('models.viewer').':') !!}
    <div style="max-height: 231px" >
        <img id="viewer" height="231px"/>
    </div>
</div>

<!-- Width Field -->
{!! Form::label('width', Lang::get('models.width').':') !!}
{!! Form::number('width', null, ['class' => 'form-control']) !!}

<!-- Height Field -->
{!! Form::label('height', Lang::get('models.height').':') !!}
{!! Form::number('height', null, ['class' => 'form-control']) !!}

<!-- Across Field -->
{!! Form::label('across', Lang::get('models.across').':') !!}
{!! Form::number('across', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('labelLayouts.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>