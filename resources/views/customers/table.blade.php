<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="table-responsive" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="customers-table">
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
            </thead>
            <tbody>
            @foreach($customers as $customers)
                <tr>
                    <td>{!! $customers->code !!}</td>
            <td>{!! $customers->company_id !!}</td>
            <td>{!! $customers->name !!}</td>
            <td>{!! $customers->trading_name !!}</td>
            <td>{!! $customers->cnpj !!}</td>
            <td>{!! $customers->state_registration !!}</td>
            <td>{!! $customers->address !!}</td>
            <td>{!! $customers->number !!}</td>
            <td>{!! $customers->neighbourhood !!}</td>
            <td>{!! $customers->city !!}</td>
            <td>{!! $customers->state !!}</td>
            <td>{!! $customers->country !!}</td>
            <td>{!! $customers->zip_code !!}</td>
            <td>{!! $customers->phone1 !!}</td>
            <td>{!! $customers->phone2 !!}</td>
            <td>{!! $customers->active !!}</td>
            <td>{!! $customers->obs1 !!}</td>
            <td>{!! $customers->obs2 !!}</td>
            <td>{!! $customers->obs3 !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>