<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="table-responsive" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="roles-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.name') </th>
                <th class="th_grid">@lang('models.slug') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.action')</th>
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