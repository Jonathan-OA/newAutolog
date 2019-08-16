<div class="form_fields" style="height: 55vh;margin-top: 10px;"> 
    <!-- Loop por todas os saldos -->     
    @foreach($invItems as $item)
        <!-- Se o deposito atual é diferente do anterior (ou vazio), mostra a linha de cabeçalho -->
        @if($item->deposit_code <> $depositAnt)
        </table>
        <div class="drop_header">
                <div class="input-group mb-3">
                    <div class="input-group-prepend" style="float: left; margin-right: 2vw">
                        <div class="input-group-text">
                        <!-- Checkbox que armazenará todos os depositos selecionados -->
                        <input type="checkbox" id ="H_{{$item->deposit_code}}" name="deposits[]" value="{{$item->deposit_code}}">
                        </div>
                    </div>
                    <span style="vertical-align: middle">
                        @lang('models.deposit_code'): {{ $item->deposit_code }}
                    </span>
                </div>
        </div>
        <table class="table table-bordered" id="items-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid"> </th>
                <th class="th_grid">@lang('models.location_code') </th>
                <th class="th_grid">@lang('models.product_code') </th>
                <th class="th_grid">@lang('models.stock') </th>
                <th class="th_grid">@lang('models.1acount') </th>
                <th class="th_grid">@lang('models.margin_div') </th>
            </thead>
            <tbody>
            @php
                $depositAnt = $item->deposit_code;
            @endphp  
        @endif
        <tr>
            <td class="td_center">
                <input type="checkbox" id="V{{$item->deposit_code}}" name="items[]" value="{{$item->location_code}}+{{$item->product_code}}" {{ (($item->count > 0 || $item->exs > 0) ? 'disabled' : '') }} >
            </td>
            <td>{!! $item->location_code !!}</td> <!--Endereço -->
            <td>{!! $item->product_code !!}</td> <!--Produto --> 
            <td class="td_center">{!! (float)$item->qty_wms !!} </td> <!--Saldo --> 
            <td class="td_center">{!! (float)$item->qty1 !!} </td> <!--1ª Count --> 
            <td class="td_center">{!! (float)($item->qty1 - $item->qty_wms)!!} </td> <!--Div --> 
            </td>
        </tr>
            
    @endforeach
</table>
</div>
  
<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['name' => 'teste', 'class' => 'btn btn-primary']) !!}
<a href="{!! route('inventory.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
    