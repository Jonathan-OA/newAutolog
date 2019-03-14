<script type="text/ng-template" id="tplButtons">  
    <!-- Status do Doc: document_status_id (Pendente, Liberado, Execução, Liberado) --> 
    <!-- Status do Inv: inventory_status_id (Pendente, 1ª Contagem Pendente, 2ª Contagem Pendente, etc) --> 
    <!-- função callRoute com o segundo parametro = 1: acessa a rota por ajax. segundo parametro  vazio: redireciona -->
    <div ng-attr-id="buttons{%row.id%}"  style="overflow: visible !important;" >
        <!-- Detalhar -->
         <button  ng-click="callRoute('./inventory/'+row.id+'/items')" class="icon_action" aria-label="@lang('buttons.detail')" data-microtip-position="left" role="tooltip"> 
            <img class='icon' src='{{asset('/icons/detalhes.png') }}'>
        </button>

        <!-- Funções para status de documento  0 -->
        <span ng-if="row.status_doc == 0 || !row.status_inv">
            <!-- Selecionar Itens (Apenas status 0) -->
            <button ng-click="callRoute('./inventory/'+row.id+'/selectItems')" class="icon_action" aria-label="@lang('buttons.select_items')" data-microtip-position="left" role="tooltip">
               <img class='icon' src='{{ asset('/icons/selectItems.png') }}'> 
           </button> 
       </span>

        <!-- 1ª Contagem  -->
        <button ng-if="row.status_inv == 0 || !row.status_inv" class="icon_action" 
                ng-click="callRoute('./inventory/'+row.id+'/liberate/1', 1, $scope)" aria-label="@lang('buttons.1acont')" data-microtip-position="left" role="tooltip">
            <img class='icon' src='{{asset('/icons/1acont.png') }}'>
        </button>

        <!-- 2ª Contagem (Status 21) -->
        <button ng-if="row.status_inv == 21" class="icon_action" 
                ng-click="callRoute('./inventory/'+row.id+'/liberate/2', 1)" aria-label="@lang('buttons.2acont')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{asset('/icons/2acont.png') }}'>
        </button>

        <!-- 3ª Contagem (Status 31)  -->
        <button ng-if="row.status_inv == 31"  class="icon_action" 
                ng-click="callRoute('./inventory/'+row.id+'/liberate/3', 1)" aria-label="@lang('buttons.3acont')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{asset('/icons/3acont.png') }}'>
        </button>

         <!-- Retornar e Relatorio de Contagens realizadas (Status Doc > 1 e < 8) -->
         <span ng-if="row.status_doc != 0  && row.status_doc != 8">
            <button ng-click="callRoute('./inventory/'+row.id+'/return', 1)"
                    class="icon_action" aria-label="@lang('buttons.return')" data-microtip-position="left" role="tooltip">
                    <img class='icon' src='{{asset('/icons/retornar.png') }}'>
            </button>
            <button ng-click="callRoute('./inventoryItems/'+row.id+'/report')"
                    class="icon_action" aria-label="@lang('reports.reportInv')" data-microtip-position="left" role="tooltip">
                    <img class='icon' src='{{asset('/icons/retornar.png') }}'>
            </button>
        </span>
    </div>
</script>