@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   Suppliers
                </div>
                
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            @include('flash::message')
                            <div class="row buttons_grid">
                                <a class="btn btn-success"  href="{!! route('suppliers.create') !!}">Adicionar</a>
                            </div>
                            <div class="panel-body">
                                @include('suppliers.table')
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
    $(function() {
      var table = $("#suppliers-table").DataTable({
            "scrollX": true,
            ajax: 'suppliers/datatable',
            fixedColumns:   {
                leftColumns: 0,
                rightColumns: 1
            },
            columns: [ { data: 'code' },
                { data: 'company_id' },
                { data: 'name' },
                { data: 'trading_name' },
                { data: 'cnpj' },
                { data: 'state_registration' },
                { data: 'address' },
                { data: 'number' },
                { data: 'neighbourhood' },
                { data: 'city' },
                { data: 'state' },
                { data: 'country' },
                { data: 'zip_code' },
                { data: 'phone1' },
                { data: 'phone2' },
                { data: 'active' },
                { data: 'obs1' },
                { data: 'obs2' },
                { data: 'obs3' },
               
                       { data: null,
                          defaultContent: "<button id='edit'><img class='icon' src='<% asset('/icons/editar.png') %>'' alt='Editar'></button><button id='remove'><img class='icon' src='<% asset('/icons/remover.png') %>'' alt='Remover'></button>" 
                       }],
      });
      
      $('#suppliers-table tbody').on( 'click', 'button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var id = $(this).attr('id');
            if(id == 'edit'){
                //Editar Registro
                window.location.href = "{!! URL::to('suppliers/"+data.id+"/edit') !!}";
            }else{
                //Excluir Registro
                window.location.href = "{!! URL::to('suppliers/"+data.id+"/destroy') !!}";
            }
            
    });
                    
    });

</script>
@endsection