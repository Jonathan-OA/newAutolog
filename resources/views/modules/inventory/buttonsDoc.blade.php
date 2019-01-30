<script type="text/ng-template" id="options">    
    <div id="hhhaaa" class="ui-grid-cell-contents" style="overflow: visible !important;"  ng-controller="MainCtrl">
        <!-- Detalhar -->
        <!-- <button data-toggle="modal" ng-click="showGridDet(, row.entity.number)" data-target="#myModal" class="icon_action" aria-label="@lang('buttons.detail')" data-microtip-position="left" role="tooltip"> -->
         <button ng-click="callRoute('./inventory/'+row.entity.id+'/items')" class="icon_action" aria-label="@lang('buttons.detail')" data-microtip-position="left" role="tooltip"> 
            <img class='icon' src='{{asset('/icons/detalhes.png') }}'>
        </button>

        <!-- Funções para status 0 -->
        <span ng-if="row.entity.inventory_status_id == 0 || !row.entity.inventory_status_id">
            <!-- Exluir (Apenas status 0) -->
            <button ng-click="callRoute('./inventory/'+row.entity.id+'/selectItems')" class="icon_action" aria-label="@lang('buttons.select_items')" data-microtip-position="left" role="tooltip">
               <img class='icon' src='{{ asset('/icons/selectItems.png') }}'> 
           </button>
       </span>

        <!-- Opções  -->
        <button class="icon_action" aria-label="@lang('buttons.action')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{asset('/icons/opcoes.png') }}'>
        </button>
    </div>
</script>