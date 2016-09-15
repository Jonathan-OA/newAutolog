<!DOCTYPE html>
<html lang="pt-bren">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AUTOLOG WMS') }}</title>

    <!-- Styles -->
    
    <link href="css/foundation.css" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">

</head>
<body>
    <div class="lay_header">
        <div class="lay_menu">
            <a href="#" id="button_menu"> 
                <img class="icon" src="{{ asset('/icons/menu.png') }}" alt="Menu">
            </a>
        </div>
        <div class="title"> AUTOLOG WMS </div>
        <!-- Authentication Links -->
        <div class="lay_login show-for-medium">
        @if (Auth::guest())        
                <a class="tiny button" href="{{ url('/login') }}">Login</a>
                <a class="tiny button" href="{{ url('/register') }}">Register</a>
        @else
                <img class="icon" src="{{ asset('/icons/account.png') }}" alt="Account">
                <div class="lay_logout">
                    <a  href="{{ Auth::logout() }}">
                        <img class="icon" src="{{ asset('/icons/logout.png') }}" alt="Logout">
                    </a>
                </div>
                <div class="lay_account">
                    AUTOLOG
                    </br>
                    CHFR - 01
                </div>
        @endif
        </div>
    </div>
    <div class="lay_menu_op" id="lay_menu_op">
        <ul class="vertical menu" data-accordion-menu>
            <li>
                <a class="menu_ext" href="#"><img class="icon_menu" src="{{ asset('/icons/operacoes.png') }}" alt="Operações">  Operações</a>
                <ul class="menu vertical nested">
                <li><a href="#">Item 1A</a></li>
                <li><a href="#">Item 1B</a></li>
                </ul>
            </li>
            <li><a href="#"><img class="icon_menu" src="{{ asset('/icons/ajustes.png') }}" alt="Ajustes">  Ajustes</a></li>
            <li><a href="#"><img class="icon_menu" src="{{ asset('/icons/etiquetas.png') }}" alt="Etiquetas">  Etiquetas</a></li>
            <li><a href="#"><img class="icon_menu" src="{{ asset('/icons/configuracoes.png') }}" alt="Configurações">  Configurações</a></li>
        </ul>
    </div>
    @yield('content')

    <!-- Scripts -->
    
    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/foundation.min.js"></script>
    <script src="js/app.js"></script>

    <script>
      $(document).foundation();
    </script>

</body>
</html>
