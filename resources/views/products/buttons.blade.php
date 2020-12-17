<script type="text/ng-template" id="tplButtons">
        <!-- Status do Doc: document_status_id (Pendente, Liberado, Execução, Liberado) -->
        <!-- Status do Inv: inventory_status_id (Pendente, 1ª Contagem Pendente, 2ª Contagem Pendente, etc) -->
        <!-- função callRoute com o segundo parametro = 1: acessa a rota por ajax. segundo parametro  vazio: redireciona -->
        <div ng-attr-id="buttons{%row.id%}" style="overflow: visible !important;">

                <!-- Editar  -->
                <button ng-click="callRoute('./products/'+row.id+'/edit')" class="icon_action" aria-label="@lang('buttons.edit')" data-microtip-position="left" role="tooltip">
                        <img class='icon' src='{{ asset('/icons/editar.png') }}'>
                </button>

                <!-- Packings  -->
                <button ng-click="callRoute('./packings/ix/'+row.code)" class="icon_action" aria-label="@lang('buttons.packings')" data-microtip-position="left" role="tooltip">
                        <img class='icon' src='{{ asset('/icons/embalagens3.png') }}'>
                </button>

                <!-- Excluir -->
                <button ng-click="callRouteConfirm('./products/'+row.id, 1, '@lang('buttons.msg_remove')', 'delete')" class="icon_action" aria-label="@lang('buttons.remove')" data-microtip-position="left" role="tooltip">
                        <img class='icon' src='{{ asset('/icons/cancelar.png') }}'>
                </button>

        </div>
</script>