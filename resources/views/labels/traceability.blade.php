@extends('layouts.app')

@section('content')

    <link rel="stylesheet" type="text/css" href="{{asset('/css/timeline.min.css') }}" />
    <!-- BreadCrumb - Trilha  -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{!! route('labels.index') !!}">@lang('models.labels')</a></li>
          <li class="breadcrumb-item active" aria-current="page">@lang('buttons.traceability')</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel pbread panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.label_id'): {{$label->barcode}} &nbsp; &nbsp; - &nbsp; &nbsp;@lang('models.batch'): {{$label->batch}}
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Alerta de erro / sucesso -->
                        @include('flash::message')
                        <div class="panel-trace">
                            <div class="">
                                <div class="timeline-centered">
                                @php
                                    //Variavel para intercalar direita / esquerda
                                    $right = true;
                                @endphp    
                                @foreach($activities as $activity)
                                <article class="timeline-entry ">
                                        <div class="timeline-entry-inner">
                                            <time class="timeline-time" datetime="2014-01-10T03:45">
                                                <span>{{Carbon\Carbon::parse($activity->start_date)->format('H:i')}}</span> 
                                                <span>{{Carbon\Carbon::parse($activity->start_date)->format('d/m/Y')}}</span>
                                                <span>{{$activity->user_code}}</span>
                                            </time>
            
                                            <div class="timeline-icon {{(!$right)?'bg-secondary' : 'bg-success'}}">
                                                {{$activity->operation_code}}
                                            </div>
                                            <div class="timeline-label">
                                                    <h2>{{$activity->description}}</h2>
                                                        <b>Quantidade:</b> {{$activity->qty}} {{$activity->uom_code}}   |
                                                        <b>Palete:</b> {{$activity->plt_barcode}}   |  
                                                        <b>Endereço:</b> {{$activity->orig_location_code}} 
                                                            @if(!empty($activity->dest_location_code))
                                                            => {{$activity->dest_location_code}}
                                                            @endif
                                                        
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