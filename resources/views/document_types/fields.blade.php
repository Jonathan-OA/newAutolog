<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Id Field -->
@if(isset($action) && $action == 'edit')
    <input id='id' name='id' type='hidden' value='{!! $documentType->id !!}'>
@endif

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
@else
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
@endif

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Moviment Code Field -->
{!! Form::label('moviment_code', Lang::get('models.moviment_code').':') !!}
{!! Form::text('moviment_code', null, ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'moviments']) !!}

<!-- Lib Automatic Field -->
{!! Form::label('lib_automatic', Lang::get('models.lib_automatic').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="lib_automatic"  value="0" >
    {{ Form::checkbox('lib_automatic', 1, (!empty($documentType->lib_automatic)) ? $documentType->lib_automatic : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'lib_automatic']) }}
    <label class="onoffswitch-label" for="lib_automatic">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Lib Location Field -->
{!! Form::label('lib_location', Lang::get('models.lib_location').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="lib_location"  value="0" >
    {{ Form::checkbox('lib_location', 1, (!empty($documentType->lib_location)) ? $documentType->lib_location : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'lib_location']) }}
    <label class="onoffswitch-label" for="lib_location">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Num Automatic Field -->
{!! Form::label('num_automatic', Lang::get('models.num_automatic').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="num_automatic"  value="0" >
    {{ Form::checkbox('num_automatic', 1, (!empty($documentType->num_automatic)) ? $documentType->num_automatic : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'num_automatic']) }}
    <label class="onoffswitch-label" for="num_automatic">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Print Labels Field -->
{!! Form::label('print_labels', Lang::get('models.print_labels').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="print_labels"  value="0" >
    {{ Form::checkbox('print_labels', 1, (!empty($documentType->print_labels)) ? $documentType->print_labels : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'print_labels']) }}
    <label class="onoffswitch-label" for="print_labels">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Partial Lib Field -->
{!! Form::label('partial_lib', Lang::get('models.partial_lib').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="partial_lib"  value="0" >
    {{ Form::checkbox('partial_lib', 1, (!empty($documentType->partial_lib)) ? $documentType->partial_lib : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'partial_lib']) }}
    <label class="onoffswitch-label" for="partial_lib">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Deposits Lib Field -->
{!! Form::label('lib_deposits', Lang::get('models.lib_deposits').':') !!}
{!! Form::text('lib_deposits', null, ['class' => 'form-control','id' => 'autocomplete1', 'table' => 'deposits', 'multiple']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('documentTypes.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
