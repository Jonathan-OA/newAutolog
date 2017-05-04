@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   Customers
                </div>
                
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            @include('flash::message')
                            <div class="row buttons_grid">
                                <a class="btn btn-success"  href="{!! route('customers.create') !!}">Adicionar</a>
                            </div>
                            <div class="panel-body">
                                @include('customers.table')
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
      var table = $("#customers-table").DataTable({
            "scrollX": true,
            ajax: 'customers/datatable',
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
                  className: "td_grid",
                  defaultContent: "<button id='edit'><img class='icon' src='<% asset('/icons/editar.png') %>'' alt='Editar'></button><button id='remove'><img class='icon' src='<% asset('/icons/remover.png') %>'' alt='Remover'></button>" 
                }],
      });
      
      $('#customers-table tbody').on( 'click', 'button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var id = $(this).attr('id');
            if(id == 'edit'){
                //Editar Registro
                window.location.href = "{!! URL::to('customers/"+data.id+"/edit') !!}";
            }else{
                //Excluir Registro
                window.location.href = "{!! URL::to('customers/"+data.id+"/destroy') !!}";
            }
            
    });
                    
    });

</script>
@endsection