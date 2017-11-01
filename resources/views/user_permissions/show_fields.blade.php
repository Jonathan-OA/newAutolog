<!-- Id Field -->
<div class="col-md-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $userPermission->id !!}</p>
</div>

<!-- User Type Code Field -->
<div class="col-md-12">
    {!! Form::label('user_type_code', 'User Type Code:') !!}
    <p>{!! $userPermission->user_type_code !!}</p>
</div>

<!-- Operation Code Field -->
<div class="col-md-12">
    {!! Form::label('operation_code', 'Operation Code:') !!}
    <p>{!! $userPermission->operation_code !!}</p>
</div>

<!-- Created At Field -->
<div class="col-md-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $userPermission->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="col-md-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $userPermission->updated_at !!}</p>
</div>

