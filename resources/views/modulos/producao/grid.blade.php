@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Módulo de Produção
                </div>
                <div ng-controller="MainCtrl">
                 <div class="panel-body">
                        <div ui-grid="gridOptions" ui-grid-selection ui-grid-expandable ui-grid-pagination class="grid">
                        <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
</script>
@endsection

