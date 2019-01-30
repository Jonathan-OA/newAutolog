<script type="text/ng-template" id="options">    
    <div id="hhhaaa" class="ui-grid-cell-contents" style="overflow: visible !important;"  ng-controller="DetCtrl">
        <!-- Funções para status 0 -->
        <span ng-if="row.entity.inventory_status_id == 0">
             <!-- Exluir (Apenas status 0) -->
             <button ng-click="removeItem(row.entity.document_id,row.entity.location_code,row.entity.product_code,'@lang("buttons.msg_remove")')" class="icon_action" aria-label="@lang('buttons.remove')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{ asset('/icons/remover.png') }}'> 
            </button>
        </span>
    </div>
</script>