<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="table-responsive" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="roles-table">
            <thead>
                <th class="th_grid">Name</th>
        <th class="th_grid">Slug</th>
        <th class="th_grid">Description</th>
                <th class="th_grid">Ação</th>
            </thead>
            <tbody>
            @foreach($roles as $roles)
                <tr>
                    <td>{!! $roles->name !!}</td>
            <td>{!! $roles->slug !!}</td>
            <td>{!! $roles->description !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>