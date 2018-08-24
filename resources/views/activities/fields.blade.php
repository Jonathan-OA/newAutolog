<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Task Id Field -->
<input id='task_id' name='task_id' type='hidden' value='{!! $activity->task_id !!}'>

<!-- User Id Field -->
<input id='user_id' name='user_id' type='hidden' value='{!! Auth::user()->id !!}'>

<!-- Date Field -->
<input id='date' name='date' type='hidden' value='{!! (!empty($activity->end_date)? $activity->end_date : date('Y-m-d') )!!}'>


<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Document Id Field -->
<input id='document_id' name='document_id' type='hidden' value='{!! (!empty($activity->document_id)? $activity->document_id : null ) !!}'>

<!-- Document Item Id Field -->
<input id='document_item_id' name='document_item_id' type='hidden' value='{!! (!empty($activity->document_item_id)? $activity->document_item_id : null ) !!}'>


<!-- Label Id Field -->
{!! Form::label('label_id', Lang::get('models.label_id').':') !!}
{!! Form::number('label_id', null, ['class' => 'form-control']) !!}

<!-- Pallet Id Field -->
{!! Form::label('pallet_id', Lang::get('models.pallet_id').':') !!}
{!! Form::number('pallet_id', null, ['class' => 'form-control']) !!}

<!-- Qty Field -->
{!! Form::label('qty', Lang::get('models.qty').':') !!}
{!! Form::number('qty', null, ['class' => 'form-control']) !!}

<!-- Reason Id Field -->
{!! Form::label('reason_id', Lang::get('models.reason_id').':') !!}
{!! Form::number('reason_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! action('ActivityController@index',[$activity->task_id]) !!}" class="btn btn-default">@lang('buttons.cancel')</a>
