
<script type="text/ng-template" id="tplButtons">  
    <!-- Status do Doc: document_status_id (Pendente, Liberado, Execução, Liberado) --> 
    <!-- Status do Inv: inventory_status_id (Pendente, 1ª Contagem Pendente, 2ª Contagem Pendente, etc) --> 
    <div ng-attr-id="buttons{%row.id%}"  style="overflow: visible !important;" >
        <span ng-if="row.inventory_status_id == 0">
             <!-- Exluir (Apenas status 0) -->
             <button ng-click="removeItem(row.entity.document_id,row.entity.location_code,row.entity.product_code,'@lang("buttons.msg_remove")')" class="icon_action" aria-label="@lang('buttons.remove')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{ asset('/icons/remover.png') }}'> 
            </button>
        </span>
    </div>
</script>