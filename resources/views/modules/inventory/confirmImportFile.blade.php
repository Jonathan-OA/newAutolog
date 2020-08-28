@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.pre_document_imp') 
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['url' => 'inventory/importFile', 'files' => true, 'method' => 'POST']) !!}
                            <div class="form-group">
                                <div class="form_fields">
                                     @include('flash::message')
                                    <div class="alert alert-info">
                                        <strong>@lang('infos.attention.import')</strong>
                                    </div>

                                    <table class="table table-bordered" id="modules-table" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                @php
                                                    //Array com as opções de cada campo
                                                    $arrayFields = array('ean'=> 'EAN', 'dsc' => 'Descrição', 
                                                                         'prd' => 'Código Produto', 
                                                                         'qde' => 'Saldo', 'lot' => 'Lote Ativo');
                                                    //Filtra o array acima de acordo com os campos selecionados pelo user na tela anterior
                                                    $arrayFields = array_intersect_key($arrayFields, array_flip($fields));
                                                @endphp
                                                <th> # </th>
                                                @foreach($fields as $key => $field)
                                                    <th class="th_grid"> Campo {{($key+1)}} 
                                                        {!! Form::select('fieldsOrder[]',$arrayFields , $field, ['class' => 'form-control', 'id' => 'fieldInfo_'.$key]) !!}
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="background-color: #d0d0d0">Linha Ex.</td>
                                                @foreach($infos as $key => $info)
                                                <td id="field_{{$key}}">{{$info}}</td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <div class="panel-heading" >
                                        @lang('models.parameters')
                                    </div>
                                    <hr>
                                    <span aria-label="@lang('infos.param_count')" data-microtip-position="right" role="tooltip">
                                        <img class='icon' src='{{asset('/icons/information.png') }}' >
                                    </span>
                                    {!! Form::label('counts', Lang::get('parameters.param_count')) !!}
                                    {{ Form::radio('counts', '1' , true) }} 1
                                    {{ Form::radio('counts', '2' , false) }} 2
                                    {{ Form::radio('counts', '3' , false) }} 3 
                                    {{ Form::radio('counts', '4' , false) }} 4

                                    {{-- Envia o nome do arquivo carregado  para recuperar depois --}}
                                    {!! Form::hidden('fileName', $fileName) !!}
                                    {!! Form::hidden('extFile', $extFile) !!}
                                    {!! Form::hidden('sepFile', $sepFile) !!}
                                    {!! Form::hidden('customer_code', $customer_code) !!}
                                    {!! Form::hidden('billing_type', $billing_type) !!}
                                    {!! Form::hidden('inventory_value', $inventory_value) !!}
                                    
                                    <br>
                                    <!-- Parâmetros de Inventário -->
                                    <span id="parameters">
                                        <span aria-label="@lang('infos.param_stock')" data-microtip-position="right" role="tooltip">
                                            <img class='icon' src='{{asset('/icons/information.png') }}' >
                                        </span>
                                        {!! Form::label('vstock', Lang::get('parameters.param_stock')) !!}
                                        {{ Form::radio('vstock', '1' , true) }} @lang('models.yes')
                                        {{ Form::radio('vstock', '0' , true) }} @lang('models.no')
                                        <br>
                                        <span aria-label="@lang('infos.param_product')" data-microtip-position="right" role="tooltip">
                                            <img class='icon' src='{{asset('/icons/information.png') }}' >
                                        </span>
                                        {!! Form::label('vproduct', Lang::get('parameters.param_product')) !!}
                                        {{ Form::radio('vproduct', '0' , true) }} @lang('models.no')
                                        <br>
                                        <span aria-label="@lang('infos.param_location')" data-microtip-position="right" role="tooltip">
                                            <img class='icon' src='{{asset('/icons/information.png') }}' >
                                        </span>
                                        {!! Form::label('vlocation', Lang::get('parameters.param_location')) !!} 
                                        {{ Form::radio('vlocation', '0' , true) }} @lang('models.no')
                                        <br>
                                    </span>
                                </div>
                                <!-- Submit Field -->
                                {!! Form::submit(Lang::get('buttons.import'), ['class' => 'btn btn-primary']) !!}
                                <a href="{!! route('inventory.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
                            
                            </div>
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
        var oldValue;
        $(function() {
            //Monitora cada alteração do select para evitar que o mesmo campo se repita
            $("select").on('focus', function () {
                //Guarda o valor antigo para a troca
                oldValue = this.value;
            }).change(function() {

                //Validações para garantir que o valor informado coincida com o label da coluna
                var newValue = this.value;
                //Pega referencia da linha de exemplo para comparar
                var i = this.id.substr(-1);
                var expValue = $("#field_"+i).html();
                let error = 0;

                switch(newValue){
                    case 'qde':
                        if(expValue.length && (!$.isNumeric(expValue) || expValue.length > 7)){
                            alert('Valor de exemplo não corresponde a uma quantidade válida!');
                            error = 1;
                        }
                        break;
                    case 'dsc':
                        if(expValue.length && $.isNumeric(expValue)){
                            alert('Descrição inválida!');
                            error = 1;
                        }
                    break;    
                    case 'prd':
                        if(expValue.length && (expValue.length > 20 || expValue.length < 2)){
                            alert('Código Interno deve ter entre 2 e 20 caracteres!');
                            error = 1;
                        }
                    break;
                    case 'ean':
                        if(expValue.length && (!$.isNumeric(expValue) || expValue.length < 13)){
                            alert('EAN inválido!');
                            error = 1;
                        }
                        break;
                    break;
                }
                //Verifica se de erro na validação
                if(error == 0){
                    var selectDest = $('select:not("#'+this.id+'") option[value="'+newValue+'"]:selected');

                    //Como mudou o campo selecionado no select atual, busca o outro select que estava com este valor selecionado e atribui o valor antigo
                    selectDest.parent().find('option[value="'+oldValue+'"]').prop('selected', true);
                    //Atribui novo valor na variavel para próximas alterações
                    oldValue = this.value;
                }else{
                    //Se deu erro, volta o valor antigo
                    this.value = oldValue; 
                }
            });
        })
    </script>
@endsection 