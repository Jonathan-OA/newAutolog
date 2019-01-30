<!-- Id Field -->
<div class="col-md-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $inventoryStatus->id !!}</p>
</div>

<!-- Description Field -->
<div class="col-md-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $inventoryStatus->description !!}</p>
</div>

<!-- Created At Field -->
<div class="col-md-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $inventoryStatus->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="col-md-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $inventoryStatus->updated_at !!}</p>
</div>

