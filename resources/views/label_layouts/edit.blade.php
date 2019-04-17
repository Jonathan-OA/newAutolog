@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.label_layouts') 
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::model($labelLayout, ['route' => ['labelLayouts.update', $labelLayout->id], 'method' => 'patch']) !!}
                                @include('label_layouts.fields',['action' => "edit"])
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
   $(function() {
        viewLabel();
       $("#commands").change(function(){
         viewLabel();
       })

        
    })

    function viewLabel (){
        var baseStr =  $('#commands').val();
            baseStr = baseStr.replace(/\n{1,}/g,'');
            baseStr = baseStr.replace(/%{1,}/g,'*');

            console.log(baseStr);
            //Seta a image
            $('#viewer').attr("src", "http://api.labelary.com/v1/printers/8dpmm/labels/4x4/0/"+baseStr);
    }
   

</script>

@endsection