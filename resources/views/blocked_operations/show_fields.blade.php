<!-- Id Field -->
<div class="col-md-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $blockedOperation->id !!}</p>
</div>

<!-- Company Id Field -->
<div class="col-md-12">
    {!! Form::label('company_id', 'Company Id:') !!}
    <p>{!! $blockedOperation->company_id !!}</p>
</div>

<!-- Operation Code Field -->
<div class="col-md-12">
    {!! Form::label('operation_code', 'Operation Code:') !!}
    <p>{!! $blockedOperation->operation_code !!}</p>
</div>

<!-- Product Code Field -->
<div class="col-md-12">
    {!! Form::label('product_code', 'Product Code:') !!}
    <p>{!! $blockedOperation->product_code !!}</p>
</div>

<!-- Created At Field -->
<div class="col-md-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $blockedOperation->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="col-md-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $blockedOperation->updated_at !!}</p>
</div>

