<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="table-responsive" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="suppliers-table">
            <thead>
                <th class="th_grid">Code</th>
        <th class="th_grid">Company Id</th>
        <th class="th_grid">Name</th>
        <th class="th_grid">Trading Name</th>
        <th class="th_grid">Cnpj</th>
        <th class="th_grid">State Registration</th>
        <th class="th_grid">Address</th>
        <th class="th_grid">Number</th>
        <th class="th_grid">Neighbourhood</th>
        <th class="th_grid">City</th>
        <th class="th_grid">State</th>
        <th class="th_grid">Country</th>
        <th class="th_grid">Zip Code</th>
        <th class="th_grid">Phone1</th>
        <th class="th_grid">Phone2</th>
        <th class="th_grid">Active</th>
        <th class="th_grid">Obs1</th>
        <th class="th_grid">Obs2</th>
        <th class="th_grid">Obs3</th>
                <th colspan="3">Ação</th>
            </thead>
            <tbody>
            @foreach($suppliers as $suppliers)
                <tr>
                    <td>{!! $suppliers->code !!}</td>
            <td>{!! $suppliers->company_id !!}</td>
            <td>{!! $suppliers->name !!}</td>
            <td>{!! $suppliers->trading_name !!}</td>
            <td>{!! $suppliers->cnpj !!}</td>
            <td>{!! $suppliers->state_registration !!}</td>
            <td>{!! $suppliers->address !!}</td>
            <td>{!! $suppliers->number !!}</td>
            <td>{!! $suppliers->neighbourhood !!}</td>
            <td>{!! $suppliers->city !!}</td>
            <td>{!! $suppliers->state !!}</td>
            <td>{!! $suppliers->country !!}</td>
            <td>{!! $suppliers->zip_code !!}</td>
            <td>{!! $suppliers->phone1 !!}</td>
            <td>{!! $suppliers->phone2 !!}</td>
            <td>{!! $suppliers->active !!}</td>
            <td>{!! $suppliers->obs1 !!}</td>
            <td>{!! $suppliers->obs2 !!}</td>
            <td>{!! $suppliers->obs3 !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>