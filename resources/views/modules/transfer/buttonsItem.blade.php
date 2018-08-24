<script type="text/ng-template" id="options">    
    <div id="hhhaaa" class="ui-grid-cell-contents" style="overflow: visible !important;"  ng-controller="DetCtrl">
        <!-- Funções para status 0 -->
        <span ng-if="row.entity.document_status_id == 0">
             <!-- Editar (Apenas status 0) -->
             <button ng-click="callRoute('../../transfer/'+row.entity.document_id+'/items/'+row.entity.id+'/edit')" class="icon_action" aria-label="@lang('buttons.edit')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{ asset('/icons/editar.png') }}'> 
            </button>
        </span>
        
        <!-- Detalhar -->
        <!-- <button ng-click="callRoute('./transfer/'+row.entity.id+'/items')" class="icon_action" aria-label="@lang('buttons.detail')" data-microtip-position="left" role="tooltip"> 
            <img class='icon' src='{{asset('/icons/detalhes.png') }}'>
        </button>
        -->
        
        <!-- Opções  -->
        <button class="icon_action" aria-label="@lang('buttons.action')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{asset('/icons/opcoes.png') }}'>
        </button>
    </div>
</script>