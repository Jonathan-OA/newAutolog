@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading ptabs">
                    <!-- Abas -->
                    <ul class="nav nav-tabs">
                         <!-- Textos baseados no arquivo de linguagem -->
                         <li ><a href="#">@lang('models.users') </a></li>
                         <li><a href="{!! route('userTypes.index') !!}">@lang('models.user_types')</a></li>
                         <li class="active-l"><a href="{!! url('users/online') !!}">@lang('models.users_online')</a></li>  
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @include('flash::message')
                        <div id="msg_excluir"></div>
                        <div class="row buttons_grid">
                            <br>
                            Total Online:  <b>{{count($usersOn)}} / {{ $usersDeskDisp }}</b>
                            <br>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 pad-ct">
                                    <div class="" style="margin: 0 15px 0 15px">
                                    <table class="table table-bordered stri" id="users-table" cellspacing="0" width="100%">
                                        <thead>
                                            <th class="th_grid">@lang('models.code') </th>
                                            <th class="th_grid">@lang('models.name') </th>
                                            <th class="th_grid">@lang('models.user_type_code') </th>
                                            <th class="th_grid">Online </th>
                                        </thead>
                                        <tbody>
                                        @foreach($usersOn as $user)
                                            <tr>
                                                <td>{!! $user->code !!}</td>
                                                <td>{!! $user->name !!}</td>
                                                <td>{!! $user->user_type_code !!}</td>
                                                <td class="td_center">
                                                    <img style="height: 20px" src="{!!asset('/icons/active.png') !!}" />
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection