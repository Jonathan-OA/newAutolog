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
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">
</head>
<body class="login">
    <div class="login_page">
        AUTOLOG WMS
    </div>
    </br>
    <form class="form-horizontal" role="form" method="POST" action="{{% url('/login') %}}">
      {{% csrf_field() %}}
        <div class="row">
                <div class="col-xs-10 col-sm-6 col-centered login_page_inputs">
                    <div class="form-group">
                        <label for="company_id">Empresa</label>
                        <select name="company_id" id="company_id" class="form-control">
                            @foreach ($companies as $company)
                               <option value={{% $company->id %}}> {{% $company->name %}} - {{% $company->branch %}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="code">Usuário</label>
                        <input type="text" class="form-control" name="code"  id="code" placeholder="Usuário" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Senha</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary entrar btn-block center-block">
                        Login
                    </button>
                    <br>
                    @if (count($errors))
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger text-center" role="alert">{{% $error %}} </div>
                            @endforeach
                    @endif
                </div>
        </div>
    </form>
    <footer class="login_page_rodape">
        TWX 2016
    </footer>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/app.js"></script>

    <script>
        $(document).foundation();
    </script>

</body>
</html>