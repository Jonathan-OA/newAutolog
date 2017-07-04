@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   Roles
                </div>
                
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            @include('flash::message')
                            <div class="row buttons_grid">
                                <a class="btn btn-success"  href="{!! route('roles.create') !!}">Adicionar</a>
                            </div>
                            <div class="panel-body">
                                @include('roles.table')
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
      var table = $("#roles-table").DataTable({
            "scrollX": true,
            ajax: 'roles/datatable',
            fixedColumns:   {
                leftColumns: 0,
                rightColumns: 1
            },
            columns: [ { data: 'name' },
                { data: 'slug' },
                { data: 'description' },
               
                       { data: null,
                         className: "td_grid",
                         defaultContent: "<button id='edit'><img class='icon' src='<% asset('/icons/editar.png') %>'' alt='Editar'></button><button id='remove'><img class='icon' src='<% asset('/icons/remover.png') %>'' alt='Remover'></button>" 
                       }],
      });
      
      $('#roles-table tbody').on( 'click', 'button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var id = $(this).attr('id');
            if(id == 'edit'){
                //Editar Registro
                window.location.href = "{!! URL::to('roles/"+data.id+"/edit') !!}";
            }else{
                //Excluir Registro
                if(confirm('Deseja excluir este registro?')){
                    var tk = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: 'roles/'+data.id,
                        type: 'post',
                        data: {_method: 'delete', _token :tk},
                        success: function(scs){ table.ajax.reload( null, false );}
                    });
                }
            }
            
    });
                    
    });

</script>
@endsection