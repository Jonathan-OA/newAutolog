    
    <div class="form_fields">
        @foreach($permissions as $permission)
            @if($permission->module_name <> $moduleAnt)
            <div class="drop_header">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="float: left; margin-right: 2vw">
                            <div class="input-group-text">
                            <input type="checkbox" id ="hm_{{$permission->module_name}}" name="{{$permission->module_name}}" >
                            </div>
                        </div>
                        <span style="vertical-align: middle">
                            @lang('models.module_name'): {{ $permission->module_name }}
                        </span>
                    </div>
            </div>       
                @php
                    $moduleAnt = $permission->module_name;
                @endphp  
            @endif
            <div class="drop_row" >
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="float: left; margin-right: 2vw">
                            <div class="input-group-text">
                            <input type="checkbox" id="{{ $permission->module_name }}.{{ $permission->code }}" value="{{$permission->code}}" name="pms[]" {{ (($permission->operation_code) ? 'checked' : '') }}>
                            </div>
                        </div>
                        <span style="vertical-align: middle">
                            {{ $permission->code }} - {{$permission->description}}
                        </span>
                    </div>                    
            </div>
        @endforeach
    </div>
  

    <!-- Submit Field -->
    {!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('userPermissions.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
    