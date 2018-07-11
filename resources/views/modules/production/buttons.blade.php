<script type="text/ng-template" id="options">

    
    <div id="hhhaaa" class="ui-grid-cell-contents" style="overflow: visible !important;"  ng-controller="MainCtrl">
        <!-- Liberar (Apenas status 0) -->
        <button ng-click="callRoute('./document/liberate/'+row.entity.id)" ng-if="row.entity.document_status_id == 0" class="icon_action" aria-label="@lang('buttons.liberate')" data-microtip-position="left" role="tooltip">
            <img class='icon' src='{{ asset('/icons/liberar.png') }}'> 
        </button>
        <!-- Detalhar -->
        <button data-toggle="modal" ng-click="showGridDet(row.entity.id, row.entity.number)" data-target="#myModal" class="icon_action" aria-label="@lang('buttons.detail')" data-microtip-position="left" role="tooltip">
            <img class='icon' src='{{asset('/icons/detalhes.png') }}'>
        </button>
        <!-- Retornar (Status 1 e 2) -->
        <button ng-if="row.entity.document_status_id == 1 || row.entity.document_status_id == 2 " class="icon_action" aria-label="@lang('buttons.return')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{asset('/icons/retornar.png') }}'>
        </button>
        <!-- Opções  -->
        <button class="icon_action" aria-label="@lang('buttons.action')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{asset('/icons/opcoes.png') }}'>
        </button>
    </div>
</script>