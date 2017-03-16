@extends('layouts.app')
 <style>
      rect.bordered {
        stroke: #E6E6E6;
        stroke-width:2px;   
      }

      rect.bordered:hover{
          stroke: black;
          stroke-width:2px; 
      }

      text.mono {
        font-size: 9pt;
        font-family: Consolas, courier;
        fill: #aaa;
      }

      text.axis-workweek {
        fill: #000;
      }

      text.axis-worktime {
        fill: #000;
      }
    </style>
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
                    <svg id="fillgauge1" width="97%" height="250" onclick="gauge1.update(NewValue());"></svg>
<svg id="fillgauge2" width="19%" height="200" onclick="gauge2.update(NewValue());"></svg>
<svg id="fillgauge3" width="19%" height="200" onclick="gauge3.update(NewValue());"></svg>
<svg id="fillgauge4" width="19%" height="200" onclick="gauge4.update(NewValue());"></svg>
<svg id="fillgauge5" width="19%" height="200" onclick="gauge5.update(NewValue());"></svg>
<svg id="fillgauge6" width="19%" height="200" onclick="gauge6.update(NewValue());"></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
     var gauge1 = loadLiquidFillGauge("fillgauge1", 55);
    var config1 = liquidFillGaugeDefaultSettings();
    config1.circleColor = "#FF7777";
    config1.textColor = "#FF4444";
    config1.waveTextColor = "#FFAAAA";
    config1.waveColor = "#FFDDDD";
    config1.circleThickness = 0.2;
    config1.textVertPosition = 0.2;
    config1.waveAnimateTime = 1000;
    var gauge2= loadLiquidFillGauge("fillgauge2", 28, config1);
    var config2 = liquidFillGaugeDefaultSettings();
    config2.circleColor = "#D4AB6A";
    config2.textColor = "#553300";
    config2.waveTextColor = "#805615";
    config2.waveColor = "#AA7D39";
    config2.circleThickness = 0.1;
    config2.circleFillGap = 0.2;
    config2.textVertPosition = 0.8;
    config2.waveAnimateTime = 2000;
    config2.waveHeight = 0.3;
    config2.waveCount = 1;
    var gauge3 = loadLiquidFillGauge("fillgauge3", 60.1, config2);
    var config3 = liquidFillGaugeDefaultSettings();
    config3.textVertPosition = 0.8;
    config3.waveAnimateTime = 5000;
    config3.waveHeight = 0.15;
    config3.waveAnimate = false;
    config3.waveOffset = 0.25;
    config3.valueCountUp = false;
    config3.displayPercent = false;
    var gauge4 = loadLiquidFillGauge("fillgauge4", 50, config3);
    var config4 = liquidFillGaugeDefaultSettings();
    config4.circleThickness = 0.15;
    config4.circleColor = "#808015";
    config4.textColor = "#555500";
    config4.waveTextColor = "#FFFFAA";
    config4.waveColor = "#AAAA39";
    config4.textVertPosition = 0.8;
    config4.waveAnimateTime = 1000;
    config4.waveHeight = 0.05;
    config4.waveAnimate = true;
    config4.waveRise = false;
    config4.waveHeightScaling = false;
    config4.waveOffset = 0.25;
    config4.textSize = 0.75;
    config4.waveCount = 3;
    var gauge5 = loadLiquidFillGauge("fillgauge5", 60.44, config4);
    var config5 = liquidFillGaugeDefaultSettings();
    config5.circleThickness = 0.4;
    config5.circleColor = "#6DA398";
    config5.textColor = "#0E5144";
    config5.waveTextColor = "#6DA398";
    config5.waveColor = "#246D5F";
    config5.textVertPosition = 0.52;
    config5.waveAnimateTime = 5000;
    config5.waveHeight = 0;
    config5.waveAnimate = false;
    config5.waveCount = 2;
    config5.waveOffset = 0.25;
    config5.textSize = 1.2;
    config5.minValue = 30;
    config5.maxValue = 150
    config5.displayPercent = false;
    var gauge6 = loadLiquidFillGauge("fillgauge6", 120, config5);

    function NewValue(){
        if(Math.random() > .5){
            return Math.round(Math.random()*100);
        } else {
            return (Math.random()*100).toFixed(1);
        }
    }
    </script>

@endsection