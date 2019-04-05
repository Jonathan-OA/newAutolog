@extends('layouts.app')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('/timeline/css/default.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{asset('/timeline/css/component.css') }}" />
		<script src="{{asset('/timeline/js/modernizr.custom.js') }}"></script>
<style>


</style>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.labels') - 00000003
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Alerta de erro / sucesso -->
                        @include('flash::message')
                        <div class="container">
                            <div class="main">
                                <ul class="cbp_tmtimeline">

                                @foreach($activities as $activity)
                                    <li>
                                        <time class="cbp_tmtime" datetime="{{$activity->start_date}}">
                                            <span>{{Carbon\Carbon::parse($activity->start_date)->format('d/m/Y')}}</span> 
                                            <span>{{Carbon\Carbon::parse($activity->start_date)->format('H:i')}}</span>
                                            <span>{{strtoupper($activity->user_code)}}</span></time>
                                        <div class="cbp_tmicon cbp_tmicon-phone"></div>
                                        <div class="cbp_tmlabel">
                                            <h5><b>{{$activity->operation_code}} - {{$activity->description}}</b></h4>
                                            <p><b>Quantidade:</b> {{$activity->qty}} {{$activity->uom_code}}</p>
                                            <p><b>Palete:</b> {{$activity->plt_barcode}} 
                                            <p><b>Endereço:</b> {{$activity->orig_location_code}} 
                                                @if(!empty($activity->dest_location_code))
                                                   => {{$activity->dest_location_code}}
                                                @endif
                                            </p>
                                            
                                           
                                        </div>
                                    </li>
                                @endforeach
                                </ul>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection