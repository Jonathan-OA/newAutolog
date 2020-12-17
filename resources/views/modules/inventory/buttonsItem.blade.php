
<script type="text/ng-template" id="tplButtons">  
    <!-- Status do Doc: document_status_id (Pendente, Liberado, Execução, Liberado) --> 
    <!-- Status do Inv: inventory_status_id (Pendente, 1ª Contagem Pendente, 2ª Contagem Pendente, etc) --> 
    <div ng-attr-id="buttons{%row.id%}"  style="overflow: visible !important;" >
        <span ng-if="row.inventory_status_id == 0">
             <!-- Exluir Linha (Apenas com inventário status 0) -->
             <button ng-click="removeItem(row.entity.document_id,row.entity.location_code,row.entity.product_code,'@lang("buttons.msg_remove")')" class="icon_action" aria-label="@lang('buttons.remove')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{ asset('/icons/remover.png') }}'> 
            </button>
        </span>
        <span>
             <!-- Auditoria  -->
             <button ng-click="callRoute('./returnLocation/'+row.location_code')" class="icon_action" aria-label="@lang('buttons.audit_acont')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{ asset('/icons/login.png') }}'> 
            </button>
        </span>
        <!-- Retornar contagens do endereço - reiniciar na contagem atual-->
        <span ng-if="row.status_doc != 0  && row.status_doc != 8">
            <button ng-click="callRouteConfirm('./returnLocation/'+row.location_code, 1, '@lang('buttons.msg_return_location')')" class="icon_action" aria-label="@lang('buttons.return')" data-microtip-position="left" role="tooltip">
                    <img class='icon' src='{{asset('/icons/retornar.png') }}'>
            </button>
    </span>
    </div>
</script>