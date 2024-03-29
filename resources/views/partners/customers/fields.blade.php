<div class="form_fields">
@include('adminlte-templates::common.errors')


<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    <input id='id' name='id' type='hidden' value='{!! $customer->id !!}'>
    {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
@else
    {!! Form::text('code', null, ['class' => 'form-control','maxlength' => '40', 'required']) !!}  
@endif

<!-- Name Field -->
{!! Form::label('name', Lang::get('models.name').':') !!}
{!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => '100', 'required']) !!}

<!-- Trading Name Field -->
{!! Form::label('trading_name', Lang::get('models.trading_name').':') !!}
{!! Form::text('trading_name', null, ['class' => 'form-control','maxlength' => '100', 'required']) !!}

<!-- Cnpj Field -->
{!! Form::label('cnpj', Lang::get('models.cnpj').':') !!}
{!! Form::text('cnpj', null, ['class' => 'form-control', 'id' => 'cnpj', 'minlength' => '18', 'required']) !!}

<!-- State Registration Field -->
{!! Form::label('state_registration', Lang::get('models.state_registration').':') !!}
{!! Form::text('state_registration', null, ['class' => 'form-control']) !!}

<!-- Due Days Field -->
{!! Form::label('due_days', Lang::get('models.due_days').':') !!}
{!! Form::number('due_days', null, ['class' => 'form-control', 'min' => 0]) !!}

<!-- Prefix Code  -->
{!! Form::label('prefix_code', Lang::get('models.prefix_code').':') !!}
{!! Form::text('prefix_code', null, ['class' => 'form-control', 'maxlength' => '4']) !!}


<!-- Active Field -->
{!! Form::label('status', Lang::get('models.status').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="status"  value="0" >
    {{ Form::checkbox('status', 1, (!empty($customer->status)) ? $customer->status : 1 ,['class' => 'onoffswitch-checkbox', 'id' => 'status']) }}
    <label class="onoffswitch-label" for="status">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Zip Code Field -->
{!! Form::label('zip_code', Lang::get('models.zip_code').':') !!}
{!! Form::text('zip_code', null, ['class' => 'form-control','maxlength' => '10', 'minlength' => '10', 'id' => 'zip_code']) !!}

<!-- Address Field -->
{!! Form::label('address', Lang::get('models.address').':') !!}
{!! Form::text('address', null, ['class' => 'form-control', 'maxlength' => '60', 'id' => 'address', 'required']) !!}

<!-- Number Field -->
{!! Form::label('number', Lang::get('models.number').':') !!}
{!! Form::number('number', null, ['class' => 'form-control','step' => '1', 'max' => '99999', 'min' => '1', 'id' => 'number']) !!}

<!-- Neighbourhood Field -->
{!! Form::label('neighbourhood', Lang::get('models.neighbourhood').':') !!}
{!! Form::text('neighbourhood', null, ['class' => 'form-control','maxlength' => '40', 'id' => 'neighbourhood']) !!}

<!-- City Field -->
{!! Form::label('city', Lang::get('models.city').':') !!}
{!! Form::text('city', null, ['class' => 'form-control','maxlength' => '30', 'id' => 'city']) !!}

<!-- State Field -->
{!! Form::label('state', Lang::get('models.state').':') !!}
{!! Form::text('state', null, ['class' => 'form-control', 'maxlength' => '3', 'id' => 'state']) !!}

<!-- Country Field -->
{!! Form::label('country', Lang::get('models.country').':') !!}
{!! Form::text('country', null, ['class' => 'form-control', 'maxlength' => '20', 'id' => 'country']) !!}


<!-- Phone1 Field -->
{!! Form::label('phone1', Lang::get('models.phone1').':') !!}
{!! Form::text('phone1', null, ['class' => 'form-control', 'maxlength' => '15', 'minlength' => '14', 'required',  'id' => 'phone1']) !!}

<!-- Phone2 Field -->
{!! Form::label('phone2', Lang::get('models.phone2').':') !!}
{!! Form::text('phone2', null, ['class' => 'form-control', 'maxlength' => '15', 'minlength' => '14', 'id' => 'phone2']) !!}


<!-- Obs1 Field -->
{!! Form::label('obs1', Lang::get('models.obs1').':') !!}
{!! Form::text('obs1', null, ['class' => 'form-control', 'maxlength' => '40']) !!}

<!-- Obs2 Field -->
{!! Form::label('obs2', Lang::get('models.obs2').':') !!}
{!! Form::text('obs2', null, ['class' => 'form-control', 'maxlength' => '40']) !!}

<!-- Obs3 Field -->
{!! Form::label('obs3', Lang::get('models.obs3').':') !!}
{!! Form::text('obs3', null, ['class' => 'form-control', 'maxlength' => '40']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('customers.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>

@section('scripts')
    <script src="{{ URL::asset('/js/jquery/jquery.mask.js') }}"></script>
    <script>
        $(function() {

            //Função que valida os dois tipos de telefone
            var SPMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };


            //Masks
            $('#cnpj').mask('00.000.000/0000-00');
            $('#zip_code').mask('00.000-000');
            $('#phone1').mask(SPMaskBehavior,spOptions);
            $('#phone2').mask(SPMaskBehavior,spOptions);

            $('#zip_code').change(function(){
                if($('#zip_code').length = 8){
                    var cep = $('#zip_code').val().replace(".","").replace("-","");

                    $.ajax("../cep/"+ cep)
                    .done(function(data) {
                        var resp = JSON.parse(data);
                        $('#address').val(resp.logradouro);
                        $('#neighbourhood').val(resp.bairro);
                        $('#state').val(resp.uf);
                        $('#city').val(resp.localidade);
                        $('#country').val("Brasil");
                    })
                }
            })
        })

    </script>
@endsection