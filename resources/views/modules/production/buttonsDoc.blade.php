<script type="text/ng-template" id="tplButtons">     
    <!-- Status do Doc: document_status_id (Pendente, Liberado, Execução, Liberado) --> 
    <!-- função callRoute com o segundo parametro = 1: acessa a rota por ajax; segundo parametro  vazio: redireciona -->

   

    <div ng-attr-id="buttons{%row.id%}"  style="overflow: visible !important;" >
        <!-- Detalhar -->
        <button ng-click="callRoute('./production/'+row.id+'/items')" class="icon_action" aria-label="@lang('buttons.detail')" data-microtip-position="bottom" role="tooltip"> 
            <img class='icon' src='{{asset('/icons/detalhes.png') }}'>
        </button>

        <!-- Funções para status 0 -->
        <span ng-if="row.document_status_id == 0">
            <!-- Imprimir Etiquetas (Apenas status 0 e tipo de documento com print_labels ativo) -->
            <span ng-if="row.print_labels == 1">
                <button ng-click="callRoute('./production/'+row.id+'/print')" class="icon_action" aria-label="@lang('buttons.print_labels')" data-microtip-position="bottom" role="tooltip">
                    <img class='icon' src='{{ asset('/icons/printer.png') }}'> 
                </button>
            </span>
            <!-- Liberar (Apenas status 0) -->
            <!-- Se tela de endereço esta habilitada para o TipoDoc, chama tela de endereço destino  -->
            <span ng-if="row.lib_location == 1">
                <button ng-click="callRoute('./production/'+row.id+'/liberate')" class="icon_action" aria-label="@lang('buttons.liberate')" data-microtip-position="bottom" role="tooltip">
                    <img class='icon' src='{{ asset('/icons/liberar.png') }}'> 
                </button>
            </span>
            <!-- Se tela de endereço esta desabilitada para o TipoDoc, chama direto o script de liberação  -->
            <span ng-if="row.lib_location == 0">
                <button ng-click="callRoute('./document/liberate/prod', 1, 'post')" class="icon_action" aria-label="@lang('buttons.liberate')" data-microtip-position="bottom" role="tooltip">
                    <img class='icon' src='{{ asset('/icons/liberar.png') }}'> 
                </button>
            </span>

             <!-- Editar (Apenas status 0) -->
             <button ng-click="callRoute('./production/'+row.id+'/edit')" class="icon_action" aria-label="@lang('buttons.edit')" data-microtip-position="bottom" role="tooltip">
                <img class='icon' src='{{ asset('/icons/editar.png') }}'> 
            </button>
            <!-- Cancelar (Apenas status 0) -->
            <button ng-click="callRouteConfirm('./document/cancel/prod', 1,'@lang('buttons.msg_cancel')','post')" class="icon_action" aria-label="@lang('buttons.cancel')" data-microtip-position="bottom" role="tooltip">
                <img class='icon' src='{{ asset('/icons/cancelar.png') }}'> 
            </button>
             <!-- Imprimir Documento (Apenas status 0 e Tipo de Documento com print_labels_doc ativo) -->
             <!-- Passa o tipo de etiqueta para a modal de impressão (data-labe_type) -->
             <span ng-if="row.print_labels_doc == 1">
                <button href="#" data-toggle="modal" data-target="#printModal"  
                    data-label_type="{%row.label_type_code%}"
                    data-document_id="{%row.id%}"
                    data-document_number="{%row.number%}"
                    class="icon_action" aria-label="@lang('buttons.print_doc')" data-microtip-position="bottom" role="tooltip">
                    <img class='icon' src='{{ asset('/icons/printer_doc.png') }}'> 
                </button>
            </span>
        </span>
        
        <!-- Retornar (Status 1 e 2) -->
        <button ng-if="row.document_status_id == 1 || row.document_status_id == 2 "
                ng-click="callRouteConfirm('./document/return/prod', 1, '@lang('buttons.msg_return')', 'post')"
                class="icon_action" aria-label="@lang('buttons.return')" data-microtip-position="bottom" role="tooltip">
                <img class='icon' src='{{asset('/icons/retornar.png') }}'>
        </button>
    </div>
</script>