<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<% csrf_token() %>">

    <title><% config('app.name', 'AUTOLOG WMS') %></title>

    <!-- Styles -->
    <link href="<% asset('/datatables/datatables.min.css') %>"  rel="stylesheet">
    <link href="<% asset('/css/bootstrap.min.css') %> " rel="stylesheet">
    <link href="<% asset('/css/app.css') %>" rel="stylesheet">

</head>
<body>
    <div class="lay_header">
        <div class="lay_menu">
            <a href="#" id="button_menu"> 
                <img class="icon" src="<% asset('/icons/menu.png') %>" alt="Menu">
            </a>
        </div>
        <div class="title"> AUTOLOG WMS </div>
        <!-- Authentication Links -->
        <div class="lay_login hidden-sm">
                <img class="icon" src="<% asset('/icons/account.png') %>" alt="Account">
                <div class="lay_logout">
                    <a  href="<% url('/logout') %>" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <img class="icon" src="<% asset('/icons/logout.png') %>" alt="Logout">
                    </a>
                    <form id="logout-form" action="<% url('/logout') %>" method="POST" style="display: none;">
                                        <% csrf_field() %>
                    </form>
                </div>
                <div class="lay_account">
                    <% strtoupper(Auth::user()->name) %>
                    </br>
                    CHFR - 01
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 hidden-sm no-pad-rg">
            <div class="lay_menu_op" id="lay_menu_op">
                {!! $MyNavBar->asUl(array('class' => 'vertical menu', 'data-accordion-menu' => '')) !!}
            </div>
        </div>
        <div class="col-sm-10">
           <div class="container-fluid">
                @yield('content')
           </div>
        </div>
    </div>

    <!-- Scripts -->
    
    {{-- <script src="<% asset('/js/angular/angular.min.js') %>"></script>
    <script src="<% asset('/js/vendor/jquery.min.js') %>"></script>
    <script src="<% asset('/js/angular/angular-touch.min.js') %>"></script>
    <script src="<% asset('/js/angular/angular-animate.min.js') %>"></script>  --}}
    <script src="<% asset('/js/vendor/jquery.min.js') %>"></script> 
    <script src="<% asset('/datatables/datatables.min.js') %>"></script>
      
    <script src="<% asset('/js/vendor/what-input.js') %>"></script>
    <script src="<% asset('/js/bootstrap.min.js') %>"></script>
    <script src="<% asset('/js/app.js') %>"></script>
    {{-- <script src="<% asset('/js/release/ui-grid.min.js') %>"></script> --}}

    @yield('scripts')

</body>
</html>