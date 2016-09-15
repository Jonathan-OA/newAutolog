<!DOCTYPE html>
<html lang="en">
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
<body class="login">
    <div class="login_page">
        AUTOLOG WMS
    </div>
    <div class="login_page_inputs">
        <label>Empresa
        <img class="icon_login" src="{{ asset('/icons/empresa.png') }}" alt="Empresa"> <input type="text" placeholder="Empresa">
        </label>
        <label>Usuário
        <br>
        <img class="icon_login" src="{{ asset('/icons/login.png') }}" alt="Usuário"> <input type="text" placeholder="Usuário / Email">
        </label>
        <label>Senha
        <br>
        <img class="icon_login" src="{{ asset('/icons/senha.png') }}" alt="Senha"> <input type="password" placeholder="Senha">
        </label>
        <a href="#features" class="button">Entrar</a>
    </div>
    <div class="login_page_rodape">
        TWX 2016
    </div>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/foundation.min.js"></script>
    <script src="js/app.js"></script>

    <script>
        $(document).foundation();
    </script>

</body>
</html>