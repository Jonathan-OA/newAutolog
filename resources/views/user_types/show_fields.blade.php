<!-- Code Field -->
<div class="col-md-12">
    {!! Form::label('code', 'Code:') !!}
    <p>{!! $userType->code !!}</p>
</div>

<!-- Description Field -->
<div class="col-md-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $userType->description !!}</p>
</div>

<!-- Active Field -->
<div class="col-md-12">
    {!! Form::label('active', 'Active:') !!}
    <p>{!! $userType->active !!}</p>
</div>

<!-- Created At Field -->
<div class="col-md-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $userType->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="col-md-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $userType->updated_at !!}</p>
</div>

