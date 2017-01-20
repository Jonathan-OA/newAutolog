<table class="table table-responsive" id="customers-table">
    <thead>
        <th>Code</th>
        <th>Company Id</th>
        <th>Name</th>
        <th>Cnpj</th>
        <th>Address</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($customers as $customer)
        <tr>
            <td>{!! $customer->code !!}</td>
            <td>{!! $customer->company_id !!}</td>
            <td>{!! $customer->name !!}</td>
            <td>{!! $customer->cnpj !!}</td>
            <td>{!! $customer->address !!}</td>
            <td>
                {!! Form::open(['route' => ['customers.destroy', $customer->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('customers.show', [$customer->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('customers.edit', [$customer->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>