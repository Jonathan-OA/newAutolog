<script type="text/ng-template" id="tplButtons">     
    <!-- Status do Doc: document_status_id (Pendente, Liberado, Execução, Liberado) --> 
    <div ng-attr-id="buttons{%row.id%}"  style="overflow: visible !important;" >
        <!-- Funções para status 0 -->
        <span ng-if="row.document_status_id == 0">
             <!-- Editar (Apenas status 0) -->
             <button ng-click="callRoute('../../production/'+row.document_id+'/items/'+row.id+'/edit')" class="icon_action" aria-label="@lang('buttons.edit')" data-microtip-position="left" role="tooltip">
                <img class='icon' src='{{ asset('/icons/editar.png') }}'> 
            </button>
        </span>
        
        <!-- Detalhar -->
        <!-- <button ng-click="callRoute('./production/'+row.id+'/items')" class="icon_action" aria-label="@lang('buttons.detail')" data-microtip-position="left" role="tooltip"> 
            <img class='icon' src='{{asset('/icons/detalhes.png') }}'>
        </button>
        -->
        
    </div>
</script>