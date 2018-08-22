<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Operation Code Field -->
{!! Form::label('operation_code', Lang::get('models.operation_code').':') !!}
{!! Form::text('operation_code', null, ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'operations']) !!}

<!-- Start Date Field -->
<input id='start_date' name='start_date' type='hidden' value='{!! (!empty($task->start_date)? $task->start_date : null ) !!}'>

<!-- End Date Field -->
<input id='end_date' name='end_date' type='hidden' value='{!! (!empty($task->end_date)? $task->end_date : null )!!}'>

<!-- Document Id Field -->
<input id='document_id' name='document_id' type='hidden' value='{!! (!empty($task->document_id)? $task->document_id : null ) !!}'>

<!-- Document Item Id Field -->
<input id='document_item_id' name='document_item_id' type='hidden' value='{!! (!empty($task->document_item_id)? $task->document_item_id : null ) !!}'>

<!-- Status Field -->
{!! Form::label('task_status_id', Lang::get('models.task_status_id').':') !!}
{!! Form::select('task_status_id', $taskStatus, null, ['class' => 'form-control']) !!}

<!-- Orig Location Code Field -->
{!! Form::label('orig_location_code', Lang::get('models.orig_location_code').':') !!}
{!! Form::text('orig_location_code', null, ['class' => 'form-control', 'id' => 'autocomplete1', 'table' => 'locations']) !!}

<!-- Dest Location Code Field -->
{!! Form::label('dest_location_code', Lang::get('models.dest_location_code').':') !!}
{!! Form::text('dest_location_code', null, ['class' => 'form-control', 'id' => 'autocomplete2', 'table' => 'locations']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('tasks.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
