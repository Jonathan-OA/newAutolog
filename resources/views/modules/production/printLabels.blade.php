@extends('layouts.app')
@section('content')
{{Session::get('filePrint')}}
{{Session::get('print')}}

    <!-- BreadCrumb - Trilha  -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! route('production.index') !!}">@lang('models.production')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('buttons.print')</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default pbread" >
                <div class="panel-heading">
                    @lang('models.print') - @lang('models.document_edit') {{$document->number}}
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="form_fields form_bread">
                                <!-- Alerta de erro / sucesso -->
                                <div id="msg_excluir"></div>
                                
                                {!! Form::open(['route' => 'production.print']) !!}
        
                                <!-- Modal de Impressão -->
                                <div class="modal fade" id="printModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                    @include('layouts.print')

                                    <!-- Tipo de Etiqueta a Ser gerada -->
                                    <input id="label_type_code" type="hidden" name="label_type_code" value="PRDCAD">

                                    <!-- Tipo de Etiqueta a Ser gerada -->
                                    <input id="document_id" type="hidden" name="document_id" value="{{$document->id}}">
                                </div>
                                <!-- -->

                                <div class="" style="margin: 0 15px 0 15px">
                                    <table class="table table-bordered table-striped" id="modules-table" cellspacing="0" width="100%">
                                        <thead>
                                            <th class="th_grid">!</th>
                                            <th class="th_grid">@lang('models.product_code')</th>
                                            <th class="th_grid">@lang('models.qty_doc')</th>
                                            <th class="th_grid">@lang('models.qty_printed')</th>
                                            <th class="th_grid">@lang('models.qty_print')</th>
                                            <th class="th_grid">@lang('models.uom_code')</th>
                                            <th class="th_grid">@lang('models.prim_qty')</th>
                                            <th class="th_grid">@lang('models.prim_uom_code')</th>
                                            <th class="th_grid">@lang('models.total')</th>
                                            <th class="th_grid">@lang('models.batch')</th>
                                            <th class="th_grid">@lang('models.batch_supplier')</th>
                                            <th class="th_grid">@lang('models.due_date')</th>
                                            <th class="th_grid">@lang('models.length')</th>
                                            <th class="th_grid">@lang('models.width')</th>
                                            <th class="th_grid">@lang('models.obs1')</th>
                                            <th class="th_grid">@lang('models.obs2')</th>
                                            <th class="th_grid">@lang('models.obs3')</th>
                                        </thead>
                                        <tbody>
                                                @php
                                                    $lineNum = 0;
                                                @endphp
                                            @foreach ($documentItems as $item)
                                                @php
                                                    //Valida as linhas q tem obrigação de preencher lote, data de validade, etc.
                                                    $rBatch = ($item['conf_batch'] <> 0)? '' : 'readonly'; //Lote
                                                    $rBatchSup = ($item['conf_batch_supplier'] <> 0)? '' : 'readonly'; //Lote Fornec
                                                    $rSerial = ($item['conf_serial'] <> 0)? '' : 'readonly'; //Serial Number
                                                    $rDueDate = ($item['conf_due_date'] <> 0)? '' : 'readonly'; //Validade
                                                    $rLength = ($item['conf_length'] <> 0)? '' : 'readonly'; //Comprimento
                                                    $rWidth = ($item['conf_width'] <> 0)? '' : 'readonly';  //Largura
                                                @endphp

                                                <tr>
                                                    <td align="center">
                                                        <!-- Ícone de Atenção para campos obrigatórios -->
                                                        <span id="requiredFields" aria-label="@lang('infos.required_fields')" data-microtip-position="right" role="tooltip">
                                                                <img class='icon' src='{{asset('/icons/warning.png') }}' >
                                                        </span>
                                                    </td>
                                                    <td align="center">
                                                        <!-- Código do Produto -->
                                                        <b>{{$item['product_code']}}</b>
                                                        <input type="hidden" name="infos[{{$lineNum}}][product_code]" value="{{$item['product_code']}}">
                                                    </td>
                                                    <td align="right">
                                                        <!-- Quantidade total no documento -->
                                                        {{number_format($item['qty'],2,',','.')}}
                                                    </td>
                                                    <td>
                                                        <!-- Quantidade de etqs impressas -->
                                                        0
                                                    </td>
                                                    <td>
                                                        <!-- Quantidade a imprimir -->
                                                        <div class="form-control">
                                                            <input id="qty_print" type="number" name="infos[{{$lineNum}}][qty_print]" 
                                                             value="{{ old("infos.$lineNum.qty_print", 1)}}" size="3" max="100">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Unidade Principal  -->
                                                        <div class="form-control">
                                                            <input type="text" name="infos[{{$lineNum}}][uom_code]" value="{{$item['uom_code_print']}}" size="4">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Quantidade Primária -->
                                                        <div class="form-control">
                                                            <input id="prim_qty" type="number"  name="infos[{{$lineNum}}][prim_qty]" step="0.000001" size="8"
                                                             maxlength="16" value="{{ old("infos.$lineNum.prim_qty", $item['prim_qty'])}}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Unidade Primária -->
                                                        {{$item['uom_code']}}
                                                    </td>
                                                    <td class="total" align="right">
                                                        <!-- Total -->
                                                        {{($item['prim_qty']*1)}}
                                                    </td>
                                                    <td>
                                                        <!-- Lote -->
                                                        <div class="form-control {{ (($rBatch == '')?'input_error':'')}}" >
                                                            <input type="text" name="infos[{{$lineNum}}][batch]" value="{{ old("infos.$lineNum.batch", $item['batch'])}}" 
                                                            size="10" maxlength="20" {{$rBatch}}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Lote Fornecedor-->
                                                        <div class="form-control {{ (($rBatchSup == '')?'input_error':'')}}">
                                                            <input type="text" name="infos[{{$lineNum}}][batch_supplier]" value="{{ old("infos.$lineNum.batch_supplier", $item['batch_supplier'])}}"
                                                             size="10" maxlength="20" {{$rBatchSup}}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Data de Validade -->
                                                        <div class="form-control {{ (($rDueDate == '')?'input_error':'')}}">
                                                            <input type="date" name="infos[{{$lineNum}}][due_date]" value="{{ old("infos.$lineNum.due_date")}}" size="6" {{$rDueDate}}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Comprimento -->
                                                        <div class="form-control {{ (($rLength == '')?'input_error':'')}}">
                                                            <input type="number" name="infos[{{$lineNum}}][length]" value="{{ old("infos.$lineNum.length", 0)}}" step="0.000001" size="6" maxlength="16" {{$rLength}}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Largura -->
                                                        <div class="form-control {{ (($rWidth == '')?'input_error':'')}}">
                                                            <input type="number" name="infos[{{$lineNum}}][width]"  value="{{ old("infos.$lineNum.width", 0)}}" size="6" step="0.000001"  maxlength="16" {{$rWidth}}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- OBS1 -->
                                                        <div class="form-control">
                                                            <input type="text" name="infos[{{$lineNum}}][obs1]" value="{{ old("infos.$lineNum.obs1", '')}}" size="10" maxlength="40">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- OBS2 -->
                                                        <div class="form-control">
                                                            <input type="text" name="infos[{{$lineNum}}][obs2]" value="{{ old("infos.$lineNum.obs2", '')}}" size="10" maxlength="40"> 
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- OBS3 -->
                                                        <div class="form-control">
                                                            <input type="text" name="infos[{{$lineNum}}][obs3]" value="{{ old("infos.$lineNum.obs3", '')}}" size="10" maxlength="40">
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php
                                                    $lineNum++;
                                                @endphp    
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                               
                            </div>
                            {!! Form::submit(Lang::get('buttons.print'), ['class' => 'btn btn-primary']) !!}
                            <a href="#" data-toggle='modal' data-target='#printModal' class="btn btn-primary">@lang('buttons.print')</a>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
           
            $("input").on('keyup change',function () {
                var tr = $(this).closest('tr');
                var divInput = $(this).closest('div');
                var id = $(this).attr('id'); //Pega o ID para identificar o input

                // Ao alterar a quantidade impressa, multiplica pela quantidade para calcular o total
                if(id == 'qty_print' || id == 'prim_qty'){
                    var qty_print = parseFloat(tr.find('input#qty_print').val());
                    var prim_qty = parseFloat(tr.find('input#prim_qty').val());
                    var total = qty_print * prim_qty;
                    tr.find('td.total').html(total);
                }

                if(id == 'qty_print' || id == 'prim_qty'){
                    var qty_print = parseFloat(tr.find('input#qty_print').val());
                    var prim_qty = parseFloat(tr.find('input#prim_qty').val());
                    var total = qty_print * prim_qty;
                }

                //Se preencheu todos os campos obrigatórios da linha, retira o ícone de aviso
                if($(this).val() != ''){
                    divInput.removeClass('input_error');
                    if(tr.find('div.input_error').length == 0){
                        tr.find('span#requiredFields').hide();
                    }else{
                        tr.find('span#requiredFields').show();
                    }
                }
                

            })

        })
    </script>

@endsection