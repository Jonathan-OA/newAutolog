@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Customers
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($customers, ['route' => ['customers.update', $customers->id], 'method' => 'patch']) !!}

                        @include('customers.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection