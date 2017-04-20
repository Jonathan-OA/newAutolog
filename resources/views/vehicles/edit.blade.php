@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Vehicles
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($vehicles, ['route' => ['vehicles.update', $vehicles->id], 'method' => 'patch']) !!}

                        @include('vehicles.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection