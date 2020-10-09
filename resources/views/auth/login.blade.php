<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('app.name') }}</title>

    <!-- Styles -->
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">
</head>
<body class="login">
    <div class="login_page">
        {{config('app.name') }}
    </div>
    </br>
    <form id="formLogin" class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
      {{csrf_field() }}
        <div class="row">
                <div class="col-xs-10 col-sm-6 col-centered login_page_inputs">
                    <div class="form-group">
                        <div class = "col-sm-6">
                            <label for="code">Empresa</label>
                            <input type="text" class="form-control" name="company_code"  id="company_code" placeholder="Código da Empresa" required>
                        </div>
                        <div class = "col-sm-6">
                                <label for="code">Filial</label>
                                <input type="text" class="form-control" name="company_branch"  id="company_branch" placeholder="Código da Filial" required>
                            </div>
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
                                <div class="alert alert-danger" role="alert">{{$error }} </div>
                            @endforeach
                    @endif
                    @include('flash::message')
                </div>
        </div>
    </form>
    <footer class="login_page_rodape">
        TWX 2019
    </footer>
    <script src="{{ asset('/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/jquery/jquery-ui.min.js') }}"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/app.js"></script>

    <script>

        $(function(){
            //Ao dar o submit, grava as informações de empresa e filial no local storage
            $( "#formLogin" ).submit(function( event ) {
                localStorage.setItem("AUTOLOGWMS_CompanyCode",$('#company_code').val());
                localStorage.setItem("AUTOLOGWMS_BranchCode",$('#company_branch').val());
            })

            //Recupera as informações de empresa e filial gravadas, para colocar nos inputs
            if(localStorage.getItem("AUTOLOGWMS_CompanyCode")){
                $('#company_code').val(localStorage.getItem("AUTOLOGWMS_CompanyCode"));
                $('#company_branch').val(localStorage.getItem("AUTOLOGWMS_BranchCode"));
                $('#code').focus();
            }else{
                $('#company_code').focus();
            }
            

        })
    </script>

</body>
</html>