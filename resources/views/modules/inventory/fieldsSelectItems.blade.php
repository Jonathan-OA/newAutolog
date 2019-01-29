<div class="form_fields" style="height: 55vh;margin-top: 10px;"> 
    <!-- Loop por todas os saldos -->     
    @foreach($stocks as $stock)
        <!-- Se o deposito atual é diferente do anterior (ou vazio), mostra a linha de cabeçalho -->
        @if($stock->deposit_code <> $depositAnt)
        </table>
        <div class="drop_header">
                <div class="input-group mb-3">
                    <div class="input-group-prepend" style="float: left; margin-right: 2vw">
                        <div class="input-group-text">
                        <!-- Checkbox que armazenará todos os depositos selecionados -->
                        <input type="checkbox" id ="H_{{$stock->deposit_code}}" name="deposits[]" value="{{$stock->deposit_code}}">
                        </div>
                    </div>
                    <span style="vertical-align: middle">
                        @lang('models.deposit_code'): {{ $stock->deposit_code }}
                    </span>
                </div>
        </div>
        <table class="table table-bordered" id="items-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid"> </th>
                <th class="th_grid">@lang('models.location_code') </th>
                <th class="th_grid">@lang('models.product_code') </th>
                <th class="th_grid">@lang('models.stock') </th>
                <th class="th_grid" width="50%">@lang('models.status') </th>
            </thead>
            <tbody>
            @php
                $depositAnt = $stock->deposit_code;
            @endphp  
        @endif
        <tr>
            <td class="td_center">
                <input type="checkbox" id="V{{$stock->deposit_code}}" name="items[]" value="{{$stock->location_code}}+{{$stock->product_code}}" {{ (($stock->count > 0 || $stock->exs > 0) ? 'disabled' : '') }} >
            </td>
            <td>{!! $stock->location_code !!}</td>
            <td>{!! $stock->product_code !!}</td>
            <td class="td_center">{!! (float)$stock->qde !!} {!! $stock->prim_uom_code !!}</td>
            <td class="td_center">
            @if($stock->count > 0 || $stock->exs > 0)
                <!-- Valida se produto / endereço pode ser incluído no inventario -->
               
                @if($stock->exs > 0)
                     <!-- Item já inserido -->
                     <img class='icon' src='{{asset('/icons/checked.png') }}'>
                @else
                    <!-- Item com reserva / empenho -->
                    <img class='icon' src='{{asset('/icons/warning.png') }}'>
                    @lang('validation.inv_stock')
                @endif

            @endif
            </td>
        </tr>
            
    @endforeach
</table>
</div>
  
<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['name' => 'teste', 'class' => 'btn btn-primary']) !!}
<a href="{!! route('inventory.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
    