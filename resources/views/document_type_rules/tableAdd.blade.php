<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered table-striped din_table" id="documentTypeRules-add"
               cellspacing="0" width="100%" >
            <thead>
                <th class="th_grid"></th>
                <th class="th_grid" width="5%">@lang('models.code') </th>
                <th class="th_grid" width="40%">@lang('models.description') </th>
                <th class="th_grid" width="54%">@lang('models.parameters') </th>
            </thead>
            <span class="">
            <tbody>
            @foreach($rulesMov as $rule)
                <tr id="{!! $rule->code !!}">
                    <td class="th_grid"> 
                                <button class='add' aria-label='@lang('buttons.add')' data-microtip-position='left' role='tooltip' ><img class='icon' src='{{asset('/icons/add.png') }}'></button>
                    </td>
                    <td class="td_center">{!! $rule->code !!}</td>
                    <td>{!! $rule->description !!}</td>
                    <td>{!! $rule->parameters !!}</td>
                    
                </tr>
            @endforeach
            </tbody>
        </span>
        </table>
        </div>
    </div>
</div>