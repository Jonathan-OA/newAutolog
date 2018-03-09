@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.stocks')
                </div>
                <div class="panel panel-default">
                    <div class="panel-body" >
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open(['route' => 'stocks.store']) !!}
                                <div class="form-group">
                                    @include('stocks.fields')
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
<script>
    var table;
    $(function() {
        //Busca embalagens após preencher um produto
        $('#autocomplete').focusout(function() {
            var produto = $(this).val();
            $.ajax({ 
                type: 'get',
                url: "{!! URL::to('packings/datatable/') !!}/"+produto,
                success: function(data) {
                    var options ="<option value='' selected> Unidade de Medida -  "+produto+"</option>";
                    $.each(data.data, function(key, value) {
                        console.log(value);
                        options += "<option value='" + value.uom_code + "' nivel='"+value.level+"' qdeant ='"+value.prev_qty+"'>" + value.uom_code + "</option>";
                    });
                    $('select[name="uom_code"],select[name="prev_uom_code"]').html(options);
                }
            })
        });

         //Busca fatores da prdemb
         $('#uom_code').change(function() {
             var selecionado = $("option:selected", this);
             if(selecionado.attr('nivel'))
            console.log($("option:selected", this).attr('qdeant'));
        });

    });
</script>
@endsection

luiz.tofoli