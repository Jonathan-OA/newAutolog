<div class="form_fields" style="height: 55vh;margin-top: 10px;"> 
    <input type="hidden"  name="invCount" value="{{$invCount}}">
    <!-- Loop por todas os saldos -->     
    @foreach($invItems as $item)
        @php
            $code = $item->location_code.'+'.$item->product_code; //Código da linha é produto + endereço
        @endphp  
        <!-- Se o deposito atual é diferente do anterior (ou vazio), mostra a linha de cabeçalho -->
        @if($item->deposit_code <> $depositAnt)
        </table>
        <table class="table table-bordered" id="items-table" cellspacing="0" width="100%">
            <thead> 
                <tr >
                    <th class="input-group-text">
                        <!-- Checkbox que armazenará todos os depositos selecionados -->
                        <input type="checkbox" 
                            id ="P_{{$item->deposit_code}}" 
                            name="deposits[]" value="{{$item->deposit_code}}">
                        2ª
                    </th>
                    <th class="input-group-text">
                        <!-- Checkbox que armazenará todos os depositos selecionados -->
                        <input type="checkbox" 
                            id ="F_{{$item->deposit_code}}" 
                            name="deposits[]" value="{{$item->deposit_code}}">
                        Fin
                    </th>
    
                    <th colspan="5" class="drop_header">
                        @lang('models.deposit_code'): {{ $item->deposit_code }}
                    </th>
                </tr>
                <th class="th_grid" width="65px">2ª Cont</th>
                <th class="th_grid" width="65px">Finalizar</th>
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
            <td class="td_center radioClick">
                <input type="radio" id="P{{$item->deposit_code}}" name="items[{{$code}}]" value="P" {{ (($item->count > 0 || $item->exs > 0) ? 'disabled' : '') }} > 
            </td>
            <td class="td_center radioClick">
            <input type="radio" id="F{{$item->deposit_code}}" prd="{{$item->product_code}}" loc="{{$item->location_code}}" name="items[{{$code}}]" value="F" {{ (($item->count > 0 || $item->exs > 0) ? 'disabled' : '') }} > 
            </td>
            <td>{!! $item->location_code !!}</td> <!--Endereço -->
            <td>{!! $item->product_code !!}</td> <!--Produto --> 
            <td class="td_center">{!! (float)$item->qty_wms !!} </td> <!--Saldo --> 
            <td class="td_center">{!! (float)$item->qty1 !!} </td> <!--1ª Count --> 
            <td class="td_center {!! (($item->qty1 - $item->qty_wms) < 0)? 'statred' : 'statgreen' !!}">
                {!! (float)($item->qty1 - $item->qty_wms)!!} 
            </td> <!--Div --> 
           
        </tr>
            
    @endforeach
</table>
</div>
  
<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['name' => 'teste', 'class' => 'btn btn-primary']) !!}
<a href="{!! route('inventory.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
    