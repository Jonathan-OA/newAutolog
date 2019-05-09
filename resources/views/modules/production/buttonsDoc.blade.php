<script type="text/ng-template" id="tplButtons">     
    <!-- Status do Doc: document_status_id (Pendente, Liberado, Execução, Liberado) --> 
    <!-- função callRoute com o segundo parametro = 1: acessa a rota por ajax; segundo parametro  vazio: redireciona -->
    
    <div ng-attr-id="buttons{%row.id%}"  style="overflow: visible !important;" >
        <!-- Detalhar -->
        <button ng-click="callRoute('./production/'+row.id+'/items')" class="icon_action" aria-label="@lang('buttons.detail')" data-microtip-position="left" role="tooltip"> 
            <img class='icon' src='{{asset('/icons/detalhes.png') }}'>
        </button>

        <!-- Funções para status 0 -->
        <span ng-if="row.document_status_id == 0">
            <!-- Imprimir Etiquetas (Apenas status 0) -->
            <button ng-click="callRoute('./production/'+row.id+'/print')" class="icon_action" aria-label="@lang('buttons.print_labels')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{ asset('/icons/printer.png') }}'> 
            </button>
            <!-- Liberar (Apenas status 0) -->
            <button ng-click="callRoute('./document/liberate/prod', 1, 'post')" class="icon_action" aria-label="@lang('buttons.liberate')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{ asset('/icons/liberar.png') }}'> 
            </button>
             <!-- Editar (Apenas status 0) -->
             <button ng-click="callRoute('./production/'+row.id+'/edit')" class="icon_action" aria-label="@lang('buttons.edit')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{ asset('/icons/editar.png') }}'> 
            </button>
            <!-- Cancelar (Apenas status 0) -->
            <button ng-click="callRouteConfirm('./document/cancel/prod', 1,'@lang('buttons.msg_cancel')','post')" class="icon_action" aria-label="@lang('buttons.cancel')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{ asset('/icons/cancelar.png') }}'> 
            </button>
             <!-- Imprimir Documento (Apenas status 0) -->
             <button ng-click="callRoute('./document/liberate/prod', 1, 'post')" class="icon_action" aria-label="@lang('buttons.print_doc')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{ asset('/icons/printer_doc.png') }}'> 
            </button>
        </span>
        
        <!-- Retornar (Status 1 e 2) -->
        <button ng-if="row.document_status_id == 1 || row.document_status_id == 2 "
                ng-click="callRouteConfirm('./document/return/prod', 1, '@lang('buttons.msg_return')', 'post')"
                class="icon_action" aria-label="@lang('buttons.return')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{asset('/icons/retornar.png') }}'>
        </button>
    </div>
</script>