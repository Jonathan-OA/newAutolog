<!-- Id Field -->
<div class="col-md-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $graph->id !!}</p>
</div>

<!-- Description Field -->
<div class="col-md-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $graph->description !!}</p>
</div>

<!-- Type Field -->
<div class="col-md-12">
    {!! Form::label('type', 'Type:') !!}
    <p>{!! $graph->type !!}</p>
</div>

<!-- Qry Field -->
<div class="col-md-12">
    {!! Form::label('qry', 'Qry:') !!}
    <p>{!! $graph->qry !!}</p>
</div>

<!-- Created At Field -->
<div class="col-md-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $graph->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="col-md-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $graph->updated_at !!}</p>
</div>

