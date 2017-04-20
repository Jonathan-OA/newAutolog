@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   Vehicles
                </div>
                
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            @include('flash::message')
                            <div class="row buttons_grid">
                                <a class="btn btn-success"  href="{!! route('vehicles.create') !!}">Adicionar</a>
                            </div>
                            <div class="panel-body">
                                @include('vehicles.table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
$(function() {
    $("#vehicles-table").DataTable({
        "scrollX": true,
        ajax: 'vehicles/datatable',
        columns: [ { data: 'company_id' },
                { data: 'courier_id' },
                { data: 'vehicle_type_id' },
                { data: 'number_plate' },
                ,
                   {defaultContent: "<a href=\"{!! route('vehicles.show', [$vehicles->id]) !!}\" class='btn btn-default btn-xs'><i class=\"glyphicon glyphicon-eye-open\"></i></a>"}]
    });
});
</script>
@endsection