<!-- Id Field -->
<div class="col-md-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $roles->id !!}</p>
</div>

<!-- Name Field -->
<div class="col-md-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $roles->name !!}</p>
</div>

<!-- Slug Field -->
<div class="col-md-12">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{!! $roles->slug !!}</p>
</div>

<!-- Description Field -->
<div class="col-md-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $roles->description !!}</p>
</div>

<!-- Created At Field -->
<div class="col-md-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $roles->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="col-md-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $roles->updated_at !!}</p>
</div>

