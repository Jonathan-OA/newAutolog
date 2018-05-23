<!-- Id Field -->
<div class="col-md-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $volumeStatus->id !!}</p>
</div>

<!-- Description Field -->
<div class="col-md-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $volumeStatus->description !!}</p>
</div>

<!-- Created At Field -->
<div class="col-md-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $volumeStatus->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="col-md-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $volumeStatus->updated_at !!}</p>
</div>

