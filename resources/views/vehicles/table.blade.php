<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="table-responsive" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="vehicles-table">
            <thead>
                <th class="th_grid">Company Id</th>
        <th class="th_grid">Courier Id</th>
        <th class="th_grid">Vehicle Type Id</th>
        <th class="th_grid">Number Plate</th>
                <th colspan="3">Ação</th>
            </thead>
            <tbody>
            @foreach($vehicles as $vehicles)
                <tr>
                    <td>{!! $vehicles->company_id !!}</td>
            <td>{!! $vehicles->courier_id !!}</td>
            <td>{!! $vehicles->vehicle_type_id !!}</td>
            <td>{!! $vehicles->number_plate !!}</td>
                    <td>
                        {!! Form::open(['route' => ['vehicles.destroy', $vehicles->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{!! route('vehicles.show', [$vehicles->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a href="{!! route('vehicles.edit', [$vehicles->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>