@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.inventory') - @lang('models.document_edit') {{$document->number}}
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::model($document, ['route' => ['inventory.update', $document->id], 'method' => 'patch']) !!}
                                @include('modules.inventory.fieldsDoc', ['action' => 'edit'])
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div> 
            </div>
        </div>

    </div>
@endsection
