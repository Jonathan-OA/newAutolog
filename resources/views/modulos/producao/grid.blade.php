@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Módulo de Produção
                </div>
                <div class="row buttons_grid">
                    <a href="#" id="button_menu"> 
                        <img class="icon_grid" src="<% asset('/icons/add.png') %>" alt="Adicionar">
                    </a>
                    <a href="#" id="button_menu"> 
                        <img class="icon_grid" src="<% asset('/icons/import.png') %>" alt="Importar">
                    </a>
                </div>
                 <div class="panel-body">
                    <div ng-controller="MainCtrl">
                            <div ui-grid="gridOptions" ui-grid-selection ui-grid-expandable ui-grid-pagination class="grid">
                            </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
    <script>
</script>
@endsection

