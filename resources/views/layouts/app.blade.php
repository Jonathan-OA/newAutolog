<!DOCTYPE html>
<html lang="pt-br" ng-app>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{% csrf_token() %}}">

    <title>{{% config('app.name', 'AUTOLOG WMS') %}}</title>

    <!-- Styles -->
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <link href="css/app.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/razorflow.min.css">

</head>
<body>
    <div class="lay_header">
        <div class="lay_menu">
            <a href="#" id="button_menu"> 
                <img class="icon" src="{{% asset('/icons/menu.png') %}}" alt="Menu">
            </a>
        </div>
        <div class="title"> AUTOLOG WMS </div>
        <!-- Authentication Links -->
        <div class="lay_login hidden-sm">
                <img class="icon" src="{{% asset('/icons/account.png') %}}" alt="Account">
                <div class="lay_logout">
                    <a  href="{{% url('/logout') %}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <img class="icon" src="{{% asset('/icons/logout.png') %}}" alt="Logout">
                    </a>
                    <form id="logout-form" action="{{% url('/logout') %}}" method="POST" style="display: none;">
                                        {{% csrf_field() %}}
                    </form>
                </div>
                <div class="lay_account">
                    {{% strtoupper(Auth::user()->name) %}}
                    </br>
                    CHFR - 01
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 hidden-sm no-pad-rg">
            <div class="lay_menu_op" id="lay_menu_op">
                {!! $MyNavBar->asUl(array('class' => 'vertical menu', 'data-accordion-menu' => '')) !!}
                <!--
                <ul class="vertical menu" data-accordion-menu>
                    <li>
                        <a class="menu_ext" href="#"><img class="icon_menu" src="{{% asset('/icons/operacoes.png') %}}" alt="Operações">  Operações</a>
                        <ul class="menu vertical nested">
                        <li><a href="#">Item 1A</a></li>
                        <li><a href="#">Item 1B</a></li>
                        </ul>
                    </li>
                    <li><a href="#"><img class="icon_menu" src="{{% asset('/icons/ajustes.png') %}}" alt="Ajustes">  Ajustes</a></li>
                    <li><a href="#"><img class="icon_menu" src="{{% asset('/icons/etiquetas.png') %}}" alt="Etiquetas">  Etiquetas</a></li>
                    <li><a href="#"><img class="icon_menu" src="{{% asset('/icons/configuracoes.png') %}}" alt="Configurações">  Configurações</a></li>
                </ul>
                -->
            </div>
        </div>
        <div class="col-sm-10">
           <div class="container-fluid">
                @yield('content')
           </div>
        </div>
    </div>

    <!-- Scripts -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
    <script src="js/vendor/jquery.min.js"></script>
    <script type="text/javascript" src="js/razorflow.min.js"></script>
    <script type="text/javascript" src="js/razorflow.devtools.min.js"></script>
    <script type="text/javascript" src="js/dashboard_app.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/app.js"></script>

</body>
</html>