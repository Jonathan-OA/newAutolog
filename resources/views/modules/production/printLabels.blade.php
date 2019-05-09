@extends('layouts.app')

@section('content')
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
                                {!! Form::model($document, ['route' => ['production.update', $document->id], 'method' => 'patch']) !!}
                                <div class="" style="margin: 0 15px 0 15px">
                                    <table class="table table-bordered table-striped" id="modules-table" cellspacing="0" width="100%">
                                        <thead>
                                            <th class="th_grid">@lang('models.product_code')</th>
                                            <th class="th_grid">@lang('models.qty_doc')</th>
                                            <th class="th_grid">@lang('models.qty_printed')</th>
                                            <th class="th_grid">@lang('models.qty_print')</th>
                                            <th class="th_grid">@lang('models.uom_code')</th>
                                            <th class="th_grid">@lang('models.prim_qty')</th>
                                            <th class="th_grid">@lang('models.prim_uom_code')</th>
                                            <th class="th_grid">@lang('models.batch')</th>
                                            <th class="th_grid">@lang('models.batch_supplier')</th>
                                            <th class="th_grid">@lang('models.due_date')</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($documentItems as $item)
                                                @php
                                                    //Valida as linhas q tem obrigação de preencher lote, data de validade, etc.
                                                    $rBatch = ($item['conf_batch'] <> 0)? '' : 'readonly';
                                                    $rBatchSup = ($item['conf_batch_supplier'] <> 0)? '' : 'readonly';
                                                    $rSerial = ($item['conf_serial'] <> 0)? '' : 'readonly';
                                                    $rDueDate = ($item['conf_due_date'] <> 0)? '' : 'readonly';
                                                @endphp

                                                <tr>
                                                    <td align="center">
                                                        <!-- Código do Produto -->
                                                        <b>{{$item['product_code']}}</b>
                                                    </td>
                                                    <td>
                                                        <!-- Quantidade total no documento -->
                                                        {{$item['qty']}}
                                                    </td>
                                                    <td>
                                                        <!-- Quantidade de etqs impressas -->
                                                        0
                                                    </td>
                                                    <td>
                                                        <!-- Quantidade a imprimir -->
                                                        <div class="form-control">
                                                            <input id="aImprimir" type="number" name="qtyPrint[]" value=1>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Unidade Principal  -->
                                                        <div class="form-control">
                                                            <input type="text" name="uom_code[]" value="{{$item['uom_code_print']}}" size="6">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Quantidade Primária -->
                                                        <div class="form-control">
                                                            <input type="number" name="prim_qty[]" value="{{$item['prev_qty']}}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Unidade Primária -->
                                                        {{$item['uom_code']}}
                                                    </td>
                                                    <td>
                                                        <!-- Lote -->
                                                        <div class="form-control {{ (($rBatch == '')?'input_error':'')}}" >
                                                            <input type="text" name="batch[]" value="{{$item['batch']}}" size="20" {{$rBatch}}>
                                                        </div>
                                                    </td>
                                                    <td class="">
                                                        <!-- Lote Fornecedor-->
                                                        <div class="form-control {{ (($rBatchSup == '')?'input_error':'')}}">
                                                            <input type="text" name="batch_supplier[]" value="{{$item['batch_supplier']}}" size="20" {{$rBatchSup}}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Data de Validade -->
                                                        <div class="form-control {{ (($rDueDate == '')?'input_error':'')}}">
                                                            <input type="date" name="due_date[]" value="" size="10" {{$rDueDate}}>
                                                        </div>
                                                    </td>
                                                </tr>    
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            {!! Form::submit(Lang::get('buttons.print'), ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
@endsection
