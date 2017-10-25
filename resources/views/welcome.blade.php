<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{% csrf_token() %}}">

    <title>{{% config('app.name', 'AUTOLOG WMS') %}}</title>

    <!-- Styles -->
    
    <link href="css/foundation.css" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">
</head>
<body class="login">
    <div class="login_page">
        AUTOLOG WMS
    </div> 
    <form class="form-horizontal" role="form" method="POST" action="{{% url('/login') %}}">
      {{% csrf_field() %}}
        <div class="row">
                <div class="small-10 medium-6 small-centered columns login_page_inputs">
                    <label>Empresaaa
                        <input class="input_login form-control" type="text" placeholder="Empresa">
                    </label>
                    <label>Usuário
                        <input class="input_login form-control" name="email" id="email" type="text" required placeholder="Usuário / Email">
                    </label>
                    <label>Senha
                        <input class="input_login form-control" type="password" name="password" id="password" required placeholder="Senha">
                    </label>
                    <button type="submit" class="expanded button entrar">
                        Login
                    </button>
                </div>
        </div>
    </form>
    <div class="login_page_rodape">
        TWX 2017
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