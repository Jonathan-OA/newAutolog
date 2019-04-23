<!-- layout da modal para realizar impressões -->
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
                <div class="panel-default" >
                <div class="panel-heading">
                        @lang('models.print')
                    </div>
                </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(['route' => 'supports.store']) !!}
                    <div class="form-group">
                                <!-- Código da empresa -->
                                <input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

                                <!-- Fila -->
                                {!! Form::label('printer', Lang::get('models.printer').':') !!}
                                {!! Form::select('printer',  array() , NULL,  ['id' => 'printers', 'class' => 'form-control', 'readonly']) !!}
                                
                                <!-- Tipo de Impressora -->
                                {!! Form::label('printer_type_code', Lang::get('models.printer_type_code').':') !!}
                                {!! Form::select('printer_type_code',  array(), NULL , ['id' => 'printer_types','class' => 'form-control', 'readonly']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('buttons.cancel')</button>
                    {!! Form::submit(Lang::get('buttons.print'), ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@section('scripts')
<script>
    $(function() {
        $("#button-print").click(function(){
            //Lista impressoras disponíveis
            $.ajax({
                url: "http://192.168.0.108:9101/printers",
                method: "POST",
            }).done(function(options) {
                $.each(options['printers'], function(index,value){
                    var key = Object.keys(value)[0];
                    $("#printers").append('<option value="'+value[key]+'">'+key+'</option>');
                })
            }).fail(function() {
                alert( "Não foi possível encontrar o servidor de Impressão." );
            });

            //Carrega impressoras para o tipo de etiqueta
            $.ajax({
                url: "labelLayouts/PRDCAD/printers",
                method: "GET",
            }).done(function(options) {
                $.each(options, function(index,value){
                    $("#printer_types").append('<option value="'+index+'">'+value+'</option>');
                })
            }).fail(function() {
                alert( "Não foi possível encontrar tipos de impressoras cadastrados" );
            });

        })
        

        
    });

</script>
@endsection