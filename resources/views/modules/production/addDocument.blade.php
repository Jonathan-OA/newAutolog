@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Módulo de Produção - Adicionar Documento
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">

                            @include('flash::message')
                            
                            <form  method="POST" action="{% url('/documents') %}">
                                {% csrf_field() %}
                                <div class="form-group">
                                    <label for="number">Número</label>
                                    <input type="text" class="form-control" name="number" id="number" placeholder="Número">
                                    <label for="document_type_code">Tipo de Documento</label>
                                    <select name="document_type_code" id="document_type_code" class="form-control">
                                        @foreach ($tipos as $tipo)
                                            <option value="{% $tipo->code %}"> {% $tipo->code %} - {% $tipo->description %} </option>
                                        @endforeach
                                    </select>

                                    <label for="customer_id">Cliente</label>
                                    <select name="customer_id" id="customer_id" class="form-control" required>
                                        @foreach ($tipos as $tipo)
                                            <option value="{% $tipo->code %}"> {% $tipo->code %} - {% $tipo->description %} </option>
                                        @endforeach
                                    </select>
                                 </div>
                                 <input type="hidden" name="_token" value="{% csrf_token() %}" />
                                 <button type="submit" class="btn btn-success">Adicionar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection