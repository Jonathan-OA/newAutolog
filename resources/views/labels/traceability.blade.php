@extends('layouts.app')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('/timeline/css/styles.min.css') }}" />

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
                            <div class="row">
                                <div class="timeline-centered">
                                @php
                                    //Variavel para intercalar direita / esquerda
                                    $right = true;
                                @endphp    
                                @foreach($activities as $activity)
                                <article class="timeline-entry {{(!$right)?'left-aligned' : ''}}">
                                        <div class="timeline-entry-inner">
                                            <time class="timeline-time" datetime="2014-01-10T03:45">
                                                <span>{{Carbon\Carbon::parse($activity->start_date)->format('H:i')}}</span> 
                                                <span>{{Carbon\Carbon::parse($activity->start_date)->format('d/m/Y')}}</span>
                                            </time>
            
                                            <div class="timeline-icon {{(!$right)?'bg-secondary' : 'bg-success'}}">
                                                <i class="entypo-feather"></i>
                                            </div>
                                            <div class="timeline-label">
                                                    <h2><a href="#">{{$activity->operation_code}}</a> <span>{{$activity->description}}</span></h2>
                                                        <p><b>Quantidade:</b> {{$activity->qty}} {{$activity->uom_code}}
                                                        <b>Palete:</b> {{$activity->plt_barcode}} 
                                                        <b>Endereço:</b> {{$activity->orig_location_code}} 
                                                            @if(!empty($activity->dest_location_code))
                                                            => {{$activity->dest_location_code}}
                                                            @endif
                                                        </p>
                                            </div>
                                        </div>
                                    </article>
                                    @php
                                        $right = !$right;
                                    @endphp   
                                @endforeach
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

@endsection