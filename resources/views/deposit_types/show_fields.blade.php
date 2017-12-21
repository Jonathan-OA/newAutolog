<!-- Id Field -->
<div class="col-md-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $depositType->id !!}</p>
</div>

<!-- Code Field -->
<div class="col-md-12">
    {!! Form::label('code', 'Code:') !!}
    <p>{!! $depositType->code !!}</p>
</div>

<!-- Description Field -->
<div class="col-md-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $depositType->description !!}</p>
</div>

<!-- Created At Field -->
<div class="col-md-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $depositType->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="col-md-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $depositType->updated_at !!}</p>
</div>

