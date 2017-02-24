<!-- Code Field -->
<div class="form-group">
    {!! Form::label('code', 'Code:') !!}
    <p>{!! $permission->code !!}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $permission->description !!}</p>
</div>

<!-- Module Field -->
<div class="form-group">
    {!! Form::label('module', 'Module:') !!}
    <p>{!! $permission->module !!}</p>
</div>

<!-- Active Field -->
<div class="form-group">
    {!! Form::label('active', 'Active:') !!}
    <p>{!! $permission->active !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $permission->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $permission->updated_at !!}</p>
</div>

