@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Instalação do Sistema
                </div>
                <table ng-controller="ProductionCtl">
                    <tr ng-repeat="document in documents">
                                        {{ document.number }}
                                    </tr>

                </table>
                
            </div>
            <button type="submit" class="btn btn-success center-block">
                        Prosseguir
                        </button>
        </div>
    </div>
@endsection

<script>
    var ProductionCtl = function($scope){
        $scope.documents = {{% $documents %}};
    }
</script>