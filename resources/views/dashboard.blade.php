@extends('layouts.app')

@section('content')
<div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading trash ui-droppable">
                    <!-- Dashboard -->
                    @lang('models.dashboard') 
                </div>
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Grid customizavel com os gráficos cadastrados na tabela Graphs -->
                            <div class="grid-stack">
                                <div class="grid-stack-item"
                                    data-gs-x="0" data-gs-y="0"
                                    data-gs-width="4" data-gs-height="2">
                                        <div class="grid-stack-item-content kpi dash_sep"> 
                                                <h2> 105 </h2>
                                                <h4> Pedidos Expedidos </h4>
                                        </div>
                                </div>
                                <div class="grid-stack-item"
                                    data-gs-x="4" data-gs-y="0"
                                    data-gs-width="2" data-gs-height="2">
                                        <div class="grid-stack-item-content kpi dash_prod" > 
                                                <h2> 58 </h2>
                                                <h4> Tarefas Executadas </h4>
                                        </div>
                                </div>
                                <div class="grid-stack-item "
                                    data-gs-x="6" data-gs-y="0"
                                    data-gs-width="2" data-gs-height="2">
                                        <div class="grid-stack-item-content kpi dash_rec" > 
                                                <h2> 10 </h2>
                                                <h4> Usuários Criados </h4>
                                        </div>
                                </div>

                                <div class="grid-stack-item ui-droppable"
                                    data-gs-x="0" data-gs-y="2"
                                    data-gs-width="4" data-gs-height="4">
                                        <div class="grid-stack-item-content" style="background-color: #fbfbfb"> 
                                                <canvas id="Chart1"></canvas>
                                        </div>
                                </div>
                                <div class="grid-stack-item"
                                    data-gs-x="4" data-gs-y="2"
                                    data-gs-width="4" data-gs-height="4">
                                        <div class="grid-stack-item-content" style="background-color: #fbfbfb"> 
                                                <canvas id="Chart2"></canvas>
                                        </div>
                                </div>
                                <div class="grid-stack-item"
                                    data-gs-x="8" data-gs-y="2"
                                    data-gs-width="4" data-gs-height="6">
                                        <div class="grid-stack-item-content" style="background-color: #fbfbfb"> 
                                                <canvas id="Chart3"></canvas>
                                        </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.4.0/gridstack.min.css" />
    <script type="text/javascript" src='https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js'></script>
    <script type="text/javascript" src='//cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.4.0/gridstack.min.js'></script>
    <script type="text/javascript" src='//cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.4.0/gridstack.jQueryUI.min.js'></script>
    
    <script type="text/javascript" src='//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js'></script>
    <script type="text/javascript" src='//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js'></script>
    <script src="https://cdn.rawgit.com/emn178/Chart.PieceLabel.js/master/build/Chart.PieceLabel.min.js"></script>

    <script type="text/javascript">
        $(function () {
            //Opções para deixar que um grafico possa ser retirado do dashboard
            var opts = { float: false,
                removable: '.trash',
                removeTimeout: 100,
                acceptWidgets: '.grid-stack-item'}

            $('.grid-stack').gridstack(opts);


            var ctx = document.getElementById("Chart1").getContext('2d');
            generateGraph(ctx, 'api/graphs/1');

            var ctx2 = document.getElementById("Chart2").getContext('2d');
            generateGraph(ctx2, 'api/graphs/2');

            var ctx3 = document.getElementById("Chart3").getContext('2d');
            generateGraph(ctx3, 'api/graphs/3');
        });

        
        


    </script>

    @endsection