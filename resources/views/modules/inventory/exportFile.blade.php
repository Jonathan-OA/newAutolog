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
    $arrayPreenc = array('0' => 'Zeros', " " => 'Espaços em Branco', '-' => 'Hífen');

    //Array com as opções para preencher os campos de data
    $arrayDat = array('%d/%m/%Y %H:%i:%s' => 'dd/mm/yyyy H:i:s',
                        '%d-%m-%Y %H:%i:%s' => 'dd-mm-yyyy H:i:s',
                        '%Y-%m-%d %H:%i:%s' => 'yyyy-mm-dd H:i:s',
                        '%Y-%d-%m %H:%i:%s' => 'yyyy-dd-mm H:i:s',
                        '%d/%m/%Y' => 'dd/mm/yyyy',
                        '%d-%m-%Y' => 'dd-mm-yyyy');

    //Array com os delimitadores
    $arrayDelim = array(';' => 'Ponto e Vírgula', ':' => 'Dois Pontos', ',' => 'Vírgula');

@endphp

    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.document_exp') - {{$document->document_type_code}} {{$document->number}}
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['url' => 'inventory/'.$document->id.'/exportFile', 'method' => 'POST', 'id' => 'formExport']) !!}
                            <!--Modal para informar a descrição do perfil a ser criado (primeira utilização) - ao Clicar em exportar -->
                            <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    {!! Form::label('profile_desc', "Novo perfil identificado. Informe uma descrição:") !!}
                                                    {!! Form::text('profile_desc', '', ['class' => 'form-control', 'id' => 'profile_desc']) !!}  
                                                    <div class="row"> 
                                                        <div class="col-md-12">
                                                            {!! Form::submit(Lang::get('buttons.continue'), ['class' => 'btn btn-primary']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>           
                            </div>
                            <div class="form-group">
                                <div class="form_fields ui-droppable">
                                     @include('flash::message')
                                     <div class="row">
                                        <div class="col-md-6">
                                            <!-- Perfil de Exportação -->
                                            {!! Form::label('profile_export', Lang::get('models.profile_export').':') !!}
                                            <select class="form-control" name="profile_export" id="profile_export" >
                                                <option></option> 
                                                @foreach ($profiles as $profile)
                                                <option value="{{$profile['id']}}" {{($profile['id'] == $profileExport) ? 'selected' : ''}} format="{{$profile['format']}}" delim="{{$profile['delimiter']}}"> {{$profile['description']}} </option> 
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                        <div class="alert alert-info" style="margin-top: 15px">
                                            <strong>!! Confirme ou altere a ordem em que as informações devem ser exportadas em cada linha. Clique e arraste os blocos para alterar a ordenação.</strong>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <!-- Delimitador  -->
                                            {!! Form::label('delimiter', '*'.Lang::get('models.delimiter').':') !!}
                                            {!! Form::text('delimiter',';', ['class' => 'form-control props', 'id' => 'delimiter', 'required', 'maxlength' => '4']) !!}
                                           
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
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
                                                        <label for="eanMax">Num . Dígitos</label>
                                                        <input class="form-control props" type="number" size="5" name="eanMax" id="eanMax"/>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="icon_grid" aria-label="@lang('buttons.add')" data-microtip-position="bottom" role="tooltip">
                                                <a href="#" onClick="addField();">
                                                    <img class='icon' src='{{asset('/icons/add.png') }}'>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3" align="right">
                                            <strong> => Linha de exemplo: </strong>
                                        </div>
                                        <div class="col-md-9" id="exampleLine" style="width: auto; border: 1px solid #0a7941; border-radius: 5px;"></div>
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
                     <a href="{!! route('inventory.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
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
    #exampleLine b {color: red;}
    #exampleLine {font-weight: bold;}
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script>
        var uptProfile = 0; //Variavel que indica se houve alteração para salvar um novo perfil
        var count = 2;
        var oldValue = "";
        var summarizeSelected;
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
                        var int = String(quebra[0]).padStart(maxLength - decimals, caracter);
                        var dec = String(quebra[1]).padEnd(decimals, caracter);
                        newValue = String(int)+"."+String(dec);
                    }else{
                        newValue = String(value).padStart(maxLength, caracter)
                    }
                }else{
                    newValue = value.padEnd(maxLength, caracter);
                    newValue = newValue.substring(0,maxLength);
                }
                return newValue;
            }else{
                return value;
            }
        }

        //Modifica a linha de exemplo de acordo com as propriedades definidas
        function modifyExample(){
            uptProfile = 1; //Indica que houve alteração nas configs. Salva uma nova
            var exampleLine = "";
            var fieldsList = $("select[name^='fieldsOrder[]']");
            var delimiter = "<b>"+$("#delimiter").val()+"</b>";
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
                            } else if(qdeDig == "" || qdeDig == 0){
                                alert('Total de Digitos não pode ser 0');
                                $("#qdeMax").val('5');
                                exampleLine = exampleLine+String(subString(12,5,0,qdeDec))+delimiter;
                                $("#qdeMax").focus();
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
                            var fix = $("#fixFormat").val();
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
                        case 'datexp':
                            var dat = $("#datexpFormat").val();
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
            $("input[type='radio'][name='summarize']").on("change", function(event){
                
                if(summarizeSelected != event.target.value){
                    uptProfile = 1;
                    $('#summarize').val(event.target.value);
                }
            });
            //Muda os número da ordem dos campos caso reordene
            $( "#sortable" ).on( "sortstop", function( event, ui ) {
                var titlesField = $("span[class^='fieldTitle']");
                titlesField.map(function(ix, element) {
                    $(element).html("Campo "+(ix+1));
                })

                //Recarrega a linha de exemplo reorganizando as infos
                modifyExample();
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
                                            '<input class="form-control props" type="number" size="5" min="0" required value="5"max="20" name="qdeMax" id="qdeMax"/>'+
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
                                            '<input class="form-control props" type="text" size="5" name="fixFormat" id="fixFormat"/>');
                        break;
                    case 'dat':
                        $("#field_"+i).html('<label for="datFormat">Formato: </label>'+
                                            '{!! Form::select('datFormat',$arrayDat, null, ['class' => 'form-control props', 'id' => 'datFormat']) !!}');            
                    break;
                    case 'datexp':
                        $("#field_"+i).html('<label for="datexpFormat">Formato: </label>'+
                                            '{!! Form::select('datexpFormat',$arrayDat, null, ['class' => 'form-control props', 'id' => 'datexpFormat']) !!}');            
                    break;
                }
                //Verifica se de erro na validação
                if(error == 0){
                    var selectDest = $('select:not("#'+this.id+'") option[value="'+newValue+'"]:selected');

                    //Como mudou o campo selecionado no select atual, busca o outro select que estava com este valor selecionado e atribui o valor antigo
                    selectDest.parent().find('option[value="'+oldValue+'"]').prop('selected', true).trigger('change');
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

            //Ao clicar em submit valida se a descrição do perfil esta setada
            $("#formExport").submit(function(e){
                if(uptProfile == 1){
                    e.preventDefault();
                    //Tira a model de carregando e mostra a model para a descrição do perfil
                    $('#loadingModal').modal('toggle');
                    $('#profileModal').modal();
                    uptProfile = 0;
                }else{
                    $('#profileModal').modal('hide');
                }
                
               
            })

            //Ao selecionar um outro perfil de exportação, reajusta o grids de acordo
            $('#profile_export').change(function(){
                
                //Pega o formato do perfil selecionado
                var newFormat = JSON.parse($('#profile_export option:selected').attr('format'));
                //Seta o delimitador
                $('#delimiter').val($('#profile_export option:selected').attr('delim'));

                //Apaga os blocos atuais
                $('#sortable:not(".ui-sortable-handle")').children('li').remove();
                count = 1;
                //Loop nos campos para montar novamente a ordenação correta
                newFormat.fields.forEach(element => {
                    //Adiciona um novo bloco
                    addField();
                    //Seta o campo na ordem
                    $("#fieldInfo_"+(count-1)).val(element.code);
                    //Força o evento change para atualizar as linhas
                    $('.props').trigger('change');
                });
                //Segundo loop pois estava tendo problema em atribuir os valores no primeiro
                newFormat.fields.forEach(element => {
                    //Loop para setar as propriedades de cada campo (qdeMax, qdeDigitos...)
                    for (var [key, value] of Object.entries(element)) {
                        if(value == "") value = " ";
                        if(key != 'code'){
                            $('#'+key).val(value).trigger('change');
                        }
                        modifyExample(); //Modifica a linha de exemplo a cada alteração
                        
                    }
                });

                //Seta se é sumarizado ou não
                $("input[name=summarize][value='"+newFormat.options.summarize+"']").prop("checked",true);
                summarizeSelected = newFormat.options.summarize;
                uptProfile = 0;
                
            })

            //Se existir algum perfil já cadastrado no cliente, recarrega automaticamente os blocos
            if(parseInt($('#profile_export').val()) > 0)
                $('#profile_export').trigger("change");
        });
    </script>
@endsection 