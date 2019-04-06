<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../admin/files/img/favicon.ico">

    <title>Авторизация :: Курсы валют в Бобруйске</title>

    <!-- Bootstrap core CSS -->
    <link href="../admin/files/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../admin/files/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../admin/files/css/navbar.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
      <script src="../admin/files/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../admin/files/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <!-- /container form auth-->
    <div class="container">
      <div class="jumbotron" style="max-width: 500px; margin: auto;">
            <div style="text-align: center;">
                <img src="files/img/avatars/<?=$privet_avatar?>" alt="Avatar" style="width:60%; border-radius: 50%; margin: 10px 0px;" >
            </div>
          <div style="text-align: center;">
              <?=$privet_name?>
          </div>
              <label for="login">Логин</label>
              <div class="form-group input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input type="text" class="form-control" id="login" placeholder="Логин">
              </div>
              <label for="password">Пароль</label>
              <div class="form-group input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input type="password" class="form-control" id="password" placeholder="Введите пароль">
              </div>
              <button style="width: 100%; outline: none;" class="btn btn-success" onclick="authjs()" autofocus>Вход</button>
      </div>
    </div>
    <!-- /container form auth-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/alertifyjs/alertify.js/v1.0.10/dist/js/alertify.js"></script>
    <script src="../admin/files/js/kurs.js"></script>
    <script>window.jQuery || document.write('<script src="files/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../admin/files/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../admin/files/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
