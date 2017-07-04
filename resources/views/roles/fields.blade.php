<div class="form_fields">
<!-- Name Field -->
{!! Form::label('name', 'Name:') !!}
{!! Form::text('name', null, ['class' => 'form-control']) !!}

<!-- Slug Field -->
{!! Form::label('slug', 'Slug:') !!}
{!! Form::text('slug', null, ['class' => 'form-control']) !!}

<!-- Description Field -->
{!! Form::label('description', 'Description:') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
<a href="{!! route('roles.index') !!}" class="btn btn-default">Cancelar</a>
