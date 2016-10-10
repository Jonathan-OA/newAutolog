@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Dashboard
                </div>

                <div class="panel-body">
                <div class="row">
                        <div class="col-sm-4 center-block">
                            <div class="kpi dash_sep">
                                <img class="icon_dash" src="<% asset('/icons/separation.png') %>" alt="Separação"> 
                                 1500 Paletes
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="kpi dash_prod">
                               <img class="icon_dash" src="<% asset('/icons/production.png') %>" alt="Produção">
                                6500 m2
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="kpi dash_rec">
                                <img class="icon_dash" src="<% asset('/icons/receipt.png') %>" alt="Recebimento">
                                 500 Paletes
                            </div>
                        </div>
                    </div>
                    <div id="dbTarget" style="position:relative;" class="rf"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

