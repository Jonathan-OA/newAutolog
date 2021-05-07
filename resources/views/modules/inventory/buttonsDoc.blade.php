<script type="text/ng-template" id="tplButtons">
        <!-- Status do Doc: document_status_id (Pendente, Liberado, Execução, Liberado) -->
        <!-- Status do Inv: inventory_status_id (Pendente, 1ª Contagem Pendente, 2ª Contagem Pendente, etc) -->
        <!-- função callRoute com o segundo parametro = 1: acessa a rota por ajax. segundo parametro  vazio: redireciona -->
        <div ng-attr-id="buttons{%row.id%}" style="overflow: visible !important;">
                <!-- Detalhar -->
                <button ng-click="callRoute('./inventory/'+row.id+'/items')" class="icon_action" aria-label="@lang('buttons.detail')" data-microtip-position="left" role="tooltip">
                        <img class='icon' src='{{asset('/icons/detalhes.png') }}'>
                </button>

                <!-- Funções para status de documento  0 -->
                <span ng-if="row.status_doc == 0 || !row.status_inv">
                        <!-- Selecionar Itens (Apenas status 0 e Casos onde o Inventory_Value é null) 
                        <span ng-if="row.inventory_value >= 0">
                                <button ng-click="callRoute('./inventory/'+row.id+'/selectItems')" class="icon_action" aria-label="@lang('buttons.select_items')" data-microtip-position="left" role="tooltip">
                                        <img class='icon' src='{{ asset('/icons/selectItems.png') }}'>
                                </button>
                        </span>-->

                        <!-- Editar (Apenas status 0) -->
                        <button ng-click="callRoute('./inventory/'+row.id+'/edit')" class="icon_action" aria-label="@lang('buttons.edit')" data-microtip-position="left" role="tooltip">
                                <img class='icon' src='{{ asset('/icons/editar.png') }}'>
                        </button>
                </span>

                <!-- 1ª Contagem  -->
                <button ng-if="row.status_inv == 0 || !row.status_inv" class="icon_action" ng-click="callRoute('./inventory/'+row.id+'/liberate/1', 1, $scope)" aria-label="@lang('buttons.1acont')" data-microtip-position="left" role="tooltip">
                        <img class='icon' src='{{asset('/icons/1acont.png') }}'>
                </button>

                <!-- 2ª Contagem (Status 21 ou 1 e com o inventário aceitando mais de uma contagem) -->
                <button ng-if="((row.status_inv == 21 || row.status_inv == 1) && row.counts > 1)" class="icon_action" ng-click="callRoute('./inventory/'+row.id+'/selectItemsCount/2')" aria-label="@lang('buttons.2acont')" data-microtip-position="left" role="tooltip">
                        <img class='icon' src='{{asset('/icons/2acont.png') }}'>
                </button>

                <!-- 3ª Contagem (Status 31 ou 2 e com o inventário aceitando mais de duas contagem)   -->
                <button ng-if="((row.status_inv == 31 || row.status_inv == 2) && row.counts > 2)" class="icon_action" ng-click="callRoute('./inventory/'+row.id+'/selectItemsCount/3')" aria-label="@lang('buttons.3acont')" data-microtip-position="left" role="tooltip">
                        <img class='icon' src='{{asset('/icons/3acont.png') }}'>
                </button>

                <!-- Recarregar arquivo de leitura  -->
                <span ng-if="row.status_doc == 2 || row.status_doc == 1">
                        <button  class="icon_action" ng-click="callRoute('./inventory/reimportFile/'+row.id)" aria-label="@lang('buttons.reload_file')" data-microtip-position="left" role="tooltip">
                                <img class='icon' src='{{asset('/icons/import.png') }}'>
                        </button>
                </span>

                <!-- Finalizar Inventário   -->
                <button ng-if="(row.status_inv > 1 && row.status_inv != 8 && row.status_inv != 9 || (row.status_inv == 1 && row.counts == 1))" class="icon_action" ng-click="callRouteConfirm('./inventory/'+row.id+'/finalize',1,'@lang('buttons.msg_finalize_inv')')" aria-label="@lang('buttons.finalize_inv')" data-microtip-position="left" role="tooltip">
                        <img class='icon' src='{{asset('/icons/finalize.png') }}'>
                </button>

                <!-- Retornar (Status 1 ou 2) -->
                <span ng-if="row.status_doc == 1  || row.status_doc == 2">
                        <button ng-click="callRouteConfirm('./inventory/'+row.id+'/return', 1, '@lang('buttons.msg_return')')" class="icon_action" aria-label="@lang('buttons.return')" data-microtip-position="left" role="tooltip">
                                <img class='icon' src='{{asset('/icons/retornar.png') }}'>
                        </button>
                </span>
                

                <!-- Relatório de Contagens -->
                <span ng-if="row.status_doc != 0   && row.status_doc != 9 ">
                        <button ng-click="callRoute('./inventoryItems/'+row.id+'/report')" class="icon_action" aria-label="@lang('reports.reportInv')" data-microtip-position="left" role="tooltip">
                                <img class='icon' src='{{asset('/icons/report.png') }}'>
                        </button>
                </span>

                 <!-- Exportar TXT -->
                <span ng-if="row.status_doc == 16 || row.status_doc == 8">
                        <button ng-click="callRoute('./inventory/'+row.id+'/exportFile')" class="icon_action" aria-label="@lang('buttons.export')" data-microtip-position="left" role="tooltip">
                                <img class='icon' src='{{asset('/icons/export.png') }}'>
                        </button>
                </span>

                <!-- Reabrir (Status 8 ou 16) -->
                <span ng-if="row.status_doc == 8  || row.status_doc == 16">
                        <button ng-click="callRouteConfirm('./inventory/'+row.id+'/reopen', 1, '@lang('buttons.msg_reopen')')" class="icon_action" aria-label="@lang('buttons.reopen')" data-microtip-position="left" role="tooltip">
                                <img class='icon' src='{{asset('/icons/reabrir.png') }}'>
                        </button>
                </span>
        </div>
</script>