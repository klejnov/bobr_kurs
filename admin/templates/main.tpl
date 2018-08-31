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

    <title>Курсы валют в Бобруйске</title>

      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script>window.jQuery || document.write('<script src="files/js/vendor/jquery.min.js"><\/script>')</script>
      <script src="https://cdn.rawgit.com/alertifyjs/alertify.js/v1.0.10/dist/js/alertify.js"></script>
      <script src="files/js/kurs.js"></script>
      <script src="files/js/bootstrap.min.js"></script>
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <script src="files/js/ie10-viewport-bug-workaround.js"></script>

      <!-- Скрипт для загрузки файлов -->
      <script type="text/javascript" src="files/js/bootstrap-button-to-input-file.min.js"></script>

      <!-- Bootstrap core CSS -->
    <link href="files/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="files/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="files/css/navbar.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Load c3.css -->
    <link href="libs/c3/c3.css" rel="stylesheet">

    <!-- Load d3.js and c3.js -->
    <script src="libs/c3/d3.v5.min.js" charset="utf-8"></script>
    <script src="libs/c3/c3.js"></script>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
    <script src="files/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="files/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->

    <link href="files/css/style.css" rel="stylesheet">

  </head>

  <body>

    <div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Главная</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li<?=$active_stats?>><a href="index.php?action=stats">Графики</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Настройки<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li<?=$active_banks?>><a href="index.php?action=bank">Банки</a></li>
                  <li><a href="index.php?action=cron">Обновить курсы</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Архив</li>
                  <li<?=$active_statsavr?>><a href="index.php?action=statsavr">Статистика</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="../">На сайт</a></li>
              <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <div class="chip">
                    <img src="files/img/avatars/<?=$user_data2['avatar']?>" alt="Person" width="50" height="50">
                    <?=$user_data2['name']?>
                  </div>
                  </a>
                <ul class="dropdown-menu">
                  <li<?=$active_edituser?>><a href="index.php?action=edituser"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Редактировать</a></li>
                  <li><a href="../admin/index.php?action=logout"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Выйти</a></li>
                </ul></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
        <div class="kurs_main">
        <?=$content?>
        </div>

    </div> <!-- /container -->
  </body>
</html>
