@extends('layouts.app')

@section('content')
@php
    //Array com as opções de cada campo
    $arrayFields = array('ean'=> 'EAN', 'dsc' => 'Descrição', 
                            'prd' => 'Código Interno', 
                            'qde' => 'Saldo',
                            'fix' => 'Texto Fixo',
                            'dat' => 'Data e Hora Apontamento',
                            'datexp' => 'Data e Hora Exportação');
    //Array com as opções para preencher os caracteres a mais
    $arrayPreenc = array('0' => 'Zeros', ' ' => 'Espaços em Branco', '-' => 'Hífen');

    //Array com as opções para preencher os campos de data
    $arrayDat = array('dd/mm/yyyy H:i:s' => 'dd/mm/yyyy H:i:s',
                        'dd-mm-yyyy H:i:s' => 'dd-mm-yyyy H:i:s',
                        'yyyy-mm-dd H:i:s' => 'yyyy-mm-dd H:i:s',
                        'yyyy-dd-mm H:i:s' => 'yyyy-dd-mm H:i:s',
                        'dd/mm/yyyy' => 'dd/mm/yyyy',
                        'dd-mm-yyyy' => 'dd-mm-yyyy');

    //Array com os delimitadores
    $arrayDelim = array(';' => 'Ponto e Vírgula', ':' => 'Dois Pontos', ',' => 'Vírgula');

@endphp
    <!--Modal para informar a descrição do perfil a ser criado (primeira utilização) - ao Clicar em exportar -->
    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
        {!! Form::label('profile_export', "Descrição do novo perfil:") !!}
        {!! Form::text('profile_export', '', ['class' => 'form-control']) !!}               
    </div>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.document_exp') - {{$document->document_type_code}} {{$document->number}}
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['url' => 'inventory/'.$document->id.'/exportFile', 'method' => 'POST']) !!}
                            <div class="form-group">
                                <div class="form_fields ui-droppable">
                                     @include('flash::message')
                                     <div class="row">
                                        <div class="col-md-6">
                                            <!-- Perfil  -->
                                            {!! Form::label('profile_export', Lang::get('models.profile_export').':') !!}
                                            {!! Form::text('profile_export', '', ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'customers']) !!}
                                        </div>
                                    </div>
                                        <div class="alert alert-info" style="margin-top: 15px">
                                            <strong>!! Confirme ou altere a ordem em que as informações devem ser exportadas em cada linha. Clique e arraste os blocos para alterar a ordenação.</strong>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <!-- Delimitador  -->
                                            {!! Form::label('delimiter', '*'.Lang::get('models.delimiter').':') !!}
                                            {!! Form::select('delimiter',$arrayDelim , null, ['class' => 'form-control props', 'id' => 'delimiter', 'required']) !!}
                                           
                                        </div>
                                    </div>
                                    <ul id="sortable" style="margin-top: 5px">
                                        <li class="ui-state-default">
                                            <span aria-label="@lang('buttons.remove')" data-microtip-position="bottom" role="tooltip">
                                                <a href="#" onClick="removeField(this);">
                                                    <img class='icon' src='{{asset('/icons/cancelar2.png') }}'>
                                                </a>
                                            </span>
                                            <span class="fieldTitle">  Campo 1 </span>
                                            {!! Form::select('fieldsOrder[]',$arrayFields , null, ['class' => 'form-control props', 'id' => 'fieldInfo_1']) !!}
                                            <hr>
                                            <div class="props" style="font-size: 0.8em; text-align: left" id="field_1">
                                                <label for="eanMax">Limite Caracteres</label>
                                                <input class="form-control props" type="number" size="5" name="eanMax" id="eanMax"/>
                                                <label for="eanPre">Preencher</label>
                                                {!! Form::select('eanPre',$arrayPreenc , null, ['class' => 'form-control props', 'id' => 'eanPre']) !!}
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="icon_grid" aria-label="@lang('buttons.add')" data-microtip-position="bottom" role="tooltip">
                                        <a href="#" onClick="addField();">
                                            <img class='icon' src='{{asset('/icons/add.png') }}'>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong>Linha de exemplo: <strong>
                                        </div>
                                        <div class="col-md-10" id="exampleLine">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="panel-heading" >
                                        @lang('models.options')
                                    </div>
                                    <hr>
                                    <span aria-label="@lang('infos.param_sumprod')" data-microtip-position="right" role="tooltip">
                                        <img class='icon' src='{{asset('/icons/information.png') }}' >
                                    </span>
                                    {!! Form::label('summarize', Lang::get('parameters.param_sumprod')) !!}
                                    {{ Form::radio('summarize', '1' , false) }} Sim
                                    {{ Form::radio('summarize', '0' , true) }} Não
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- Submit Field -->
                     {!! Form::submit(Lang::get('buttons.export'), ['class' => 'btn btn-primary']) !!}
                     <a  href="#" id="buttonProfile" data-toggle="modal" data-target="#profileModal" title="Salvar Perfil">
                        <img class="icon" src="{{ asset('/icons/account_notf.png') }}" alt="Account">
                    </a>
                </div>   
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
    #sortable li { margin: 3px 3px 3px 0; padding: 5px; float: left; font-size: 1.2em; text-align: center; width: 11%  }
    #sortable li select {margin-top: 5px}
    #sortable li img {width: 15px}
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script>
        var count = 2;
        var oldValue = "";
        //Adiciona um novo campo para incluir na exportação
        function addField(){
            //Inserir no máximo 8 campos
            if(count <= 8){
                $( "#sortable" ).append(
                    '<li class="ui-state-default">'+
                    '<span aria-label="@lang('buttons.remove')" data-microtip-position="bottom" role="tooltip">'+
                        '<a href="#" onClick="removeField(this);">'+
                            '<img src="{{asset("/icons/cancelar2.png") }}">'+
                        '</a>'+
                    '</span> <span class="fieldTitle"> Campo '+count+' </span>'+
                    '<select name="fieldsOrder[]" class="form-control props" id="fieldInfo_'+count+'">'+
                        '<option value=""></option>'+
                        '<option value="ean">EAN</option>'+
                        '<option value="dsc">Descrição</option>'+
                        '<option value="prd">Código Interno</option>'+
                        '<option value="qde">Saldo</option>'+
                        '<option value="fix">Texto Fixo</option>'+
                        '<option value="dat">Data e Hora Apontamento</option>'+
                        '<option value="datexp">Data e Hora Exportação</option>'+
                    '</select>'+
                    '<hr><div style="font-size: 0.8em; text-align: left" id="field_'+count+'"></div></li>'
                );
                count++;
            }
        }
        //Apaga bloco selecionado
        function removeField(element){
            $(element).parents('li').remove();
            count--;
        }

        //Corta a string de acordo com um máximo e completa com os caracteres informados
        //Esquerda para numeros e direita para textos
        function subString(value, maxLength, caracter, decimals = ""){
            //Só faz o ajuste se o parametro de tamanho máximo for preenchido
            if(maxLength){
                var newValue = "";
                //Para numero que possuam casas decimais, ajusta cada 'bloco'
                if(decimals != ""){
                    if(decimals != 0){
                        //Se não tem ., adiciona para fazer os cortes corretamente
                        if(String(value).indexOf('.') <= "0"){
                            value = value+'.00';
                        }
                        var quebra = String(value).split('.');
                        console.log(quebra);
                        var int = String(quebra[0]).padStart(maxLength - decimals, caracter);
                        var dec = String(quebra[1]).padEnd(decimals, caracter);
                        newValue = String(int)+"."+String(dec);
                    }else{
                        newValue = String(value).padStart(maxLength, caracter)
                    }
                }else{
                    newValue = value.padEnd(maxLength, caracter)
                }
                return newValue;
            }else{
                return value;
            }
        }

        //Modifica a linha de exemplo de acordo com as propriedades definidas
        function modifyExample(){
            var exampleLine = "";
            var fieldsList = $("select[name^='fieldsOrder[]']");
            var delimiter = $("#delimiter").val();
            if(delimiter){
                //Loop nos campos para gerar novamente a linha de exemplo
                fieldsList.map(function() {
                    var field = $(this).val();
                    switch(field){
                        case 'qde':
                            var qdeDig = $("#qdeMax").val();
                            var qdeDec = $("#qdeDec").val();
                            if(qdeDig && qdeDec > qdeDig){
                                alert('Número de Casas Decimais não pode ser maior que o total');
                                var qdeDec = $("#qdeDec").val('0');
                                var qdeDec = $("#qdeDec").focus();
                            }else{
                                exampleLine = exampleLine+String(subString(12,qdeDig,0,qdeDec))+delimiter;
                            }
                            
                            break
                        case 'dsc':
                            var dscDig = $("#dscMax").val();
                            var dscPre = $("#dscPre").val();
                            exampleLine = exampleLine+subString("PRATELEIRA GRANDE",dscDig,dscPre)+delimiter;
                            break
                        case 'prd':
                            var prdDig = $("#prdMax").val();
                            var prdPre = $("#prdPre").val();
                            exampleLine = exampleLine+subString("PRD01",prdDig,prdPre)+delimiter;
                            break
                        case 'fix':
                            var fix = $("#fixedValue").val();
                            exampleLine = exampleLine+fix+delimiter;
                            break
                        case 'ean':
                            var eanDig = $("#eanMax").val();
                            exampleLine = exampleLine+subString("989812346564",eanDig,0)+delimiter;
                            break
                        case 'dat':
                            var dat = $("#datFormat").val();
                            exampleLine = exampleLine+dat+delimiter;
                            break
                    }
                });
                $("#exampleLine").html(exampleLine);
            }
        }

        $( function() {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();

            //Muda os número da ordem dos campos caso reordene
            $( "#sortable" ).on( "sortstop", function( event, ui ) {
                var titlesField = $("span[class^='fieldTitle']");
                titlesField.map(function(ix, element) {
                    $(element).html("Campo "+(ix+1));
                })
            } );
            
             //Monitora cada alteração do select para evitar que o mesmo campo se repita
             $(".ui-droppable").on('focus','select',function(){
                //Guarda o valor antigo para a troca
                oldValue = this.value;
            }).on('change','select[name^="fieldsOrder[]"]', function () {
                //Validações para garantir que o valor informado coincida com o label da coluna
                var newValue = this.value;
                //Pega referencia da linha de exemplo para comparar
                var i = this.id.substr(-1);
                let error = 0;
                switch(newValue){
                    case 'qde':
                        $("#field_"+i).html('<label for="qdeMax">Total Dígitos: </label>'+
                                            '<input class="form-control props" type="number" size="5" min="0" max="20" name="qdeMax" id="qdeMax"/>'+
                                            '<label for="qdeDec">Casas Decimais: </label>'+
                                            '<input class="form-control props" type="number" min="0" max="6" value="0" size="5" name="qdeDec" id="qdeDec"/>');
                        break;
                    case 'dsc':
                        $("#field_"+i).html('<label for="eanMax">Num. Caracteres: </label>'+
                                            '<input class="form-control props" type="number" size="5" min="0" max="150" name="dscMax" id="dscMax"/>'+
                                            '<label for="dscPre">Preencher: </label>'+
                                            '{!! Form::select('dscPre',$arrayPreenc , null, ['class' => 'form-control props', 'id' => 'dscPre']) !!}');            
                    break;    
                    case 'prd':
                        $("#field_"+i).html('<label for="prdMax">Num. Caracteres: </label>'+
                                            '<input class="form-control props" type="number" size="5" min="0" max="30" name="prdMax" id="prdMax"/>'+
                                            '<label for="prdPre">Preencher:</label>'+
                                            '{!! Form::select('prdPre',$arrayPreenc, null, ['class' => 'form-control props', 'id' => 'prdPre']) !!}');            
                    break;
                    case 'ean':
                        $("#field_"+i).html('<label for="eanMax">Num. Dígitos: </label>'+
                                            '<input class="form-control props" type="number" size="5" min="0" max="30" name="eanMax" id="eanMax" />');
                        break;
                    case 'fix':
                        $("#field_"+i).html('<label for="fixedValue">Valor:</label>'+
                                            '<input class="form-control props" type="text" size="5" name="fixedValue" id="fixedValue"/>');
                        break;
                    case 'dat':
                        $("#field_"+i).html('<label for="datFormat">Formato: </label>'+
                                            '{!! Form::select('datFormat',$arrayDat, null, ['class' => 'form-control props', 'id' => 'datFormat']) !!}');            
                    break;
                    case 'datexp':
                        $("#field_"+i).html('<label for="datFormat">Formato: </label>'+
                                            '{!! Form::select('datFormat',$arrayDat, null, ['class' => 'form-control props', 'id' => 'datFormat']) !!}');            
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

            //Cada alteração nas propriedades, ajusta a linha de exemplo
            $(".ui-droppable").on('change','.props',function(){
                modifyExample();
            });

        });
    </script>
@endsection 