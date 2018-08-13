<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" href="../img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/fontawesome.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../libs/dataTables/datatables.min.css">
s

    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../libs/dataTables/datatables.min.js"></script>

    <script src="../libs/coreui/coreui.min.js"></script>
    <script src="../libs/chart.js/custom-tooltips.min.js"></script>
    <script src="../libs/chart.js/chart.min.js"></script>

    <title>Курсы валют в Бобруйске</title>
</head>
<body>


<div class="container d-none d-xl-block">
    <div class="row">
        <div class="col-12">
            <a class="navbar-brand logo" href="https://bobr.by/">
                <img src="../img/logo2-40px.png" class="d-inline-block align-top" alt="Курсы валют"><br>
                <span class="logo-title">Курсы валют</span>
            </a>
        </div>
    </div>
</div>


<div class="container">
    <nav class="navbar navbar-expand-xl navbar-light bobr-menu">
        <div class="container">
            <a class="navbar-brand d-xl-none d-block" href="https://bobr.by/">
                <img src="../img/logo.png" class="d-inline-block align-top" alt="">
            </a>
            <a class="navicon-button x d-xl-none d-block" data-toggle="collapse" data-target="#navbarNav"
               aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <div class="navicon"></div>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a href="https://bobr.by/news">Новости</a></li>
                    <li class="nav-item"><a href="https://bobr.by/city">Наш Бобруйск</a></li>
                    <li class="nav-item"><a href="https://bobr.by/katalog">Каталог организаций</a></li>
                    <li class="nav-item"><a href="https://bobr.by/relax/foto">Отдых</a></li>
                    <li class="nav-item"><a href="https://bobr.by/job/vacancy2">Работа</a></li>
                    <li class="nav-item"><a href="https://bobr.by/advertisement/categories">Объявления</a></li>
                    <li class="nav-item"><a href="https://bobr.by/poster/kino/4293.html">Афиша</a></li>
                    <li class="nav-item"><a href="https://bobr.by/communication/lastcomments">Общение</a></li>
                    <li class="nav-item"><a href="https://bobr.by/reklama">Реклама на портале</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-4 col-md-4 col-lg-4">
            <div class="brand-card usd-card">
                <div class="brand-card-header bg-usd">
                    <i class="fas fa-dollar-sign"></i>
                    <div class="chart-wrapper">
                        <canvas id="usd-box-chart-1" height="90"></canvas>
                    </div>
                </div>
                <div class="brand-card-body">
                    <div>
                        <div class="text-value" id="current-rate-usd-buy"><i class="fas fa-spinner fa-spin"></i></div>
                        <div class="text-uppercase text-muted small">Покупка</div>
                    </div>
                    <div>
                        <div class="text-value" id="current-rate-usd-sell"><i class="fas fa-spinner fa-spin"></i></div>
                        <div class="text-uppercase text-muted small">Продажа</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4 col-md-4 col-lg-4">
            <div class="brand-card eur-card">
                <div class="brand-card-header bg-eur">
                    <i class="fas fa-euro-sign"></i>
                    <div class="chart-wrapper">
                        <canvas id="eur-box-chart-2" height="90"></canvas>
                    </div>
                </div>
                <div class="brand-card-body">
                    <div>
                        <div class="text-value" id="current-rate-eur-buy"><i class="fas fa-spinner fa-spin"></i></div>
                        <div class="text-uppercase text-muted small">Покупка</div>
                    </div>
                    <div>
                        <div class="text-value" id="current-rate-eur-sell"><i class="fas fa-spinner fa-spin"></i></div>
                        <div class="text-uppercase text-muted small">Продажа</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4 col-md-4 col-lg-4">
            <div class="brand-card rub-card">
                <div class="brand-card-header bg-rub">
                    <i class="fas fa-ruble-sign"></i>
                    <div class="chart-wrapper">
                        <canvas id="rub-box-chart-3" height="90"></canvas>
                    </div>
                </div>
                <div class="brand-card-body">
                    <div>
                        <div class="text-value" id="current-rate-rub-buy"><i class="fas fa-spinner fa-spin"></i></div>
                        <div class="text-uppercase text-muted small">Покупка</div>
                    </div>
                    <div>
                        <div class="text-value" id="current-rate-rub-sell"><i class="fas fa-spinner fa-spin"></i></div>
                        <div class="text-uppercase text-muted small">Продажа</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="container">
    <div class="row">

        <div class="col-sm-12 col-md-12 col-lg-6">


            <table class="table dataTable" id="myTable" data-order='[[ 1, "asc" ]]' data-page-length='5'>
                <thead>
                <tr>
                    <th>Банк</th>
                    <th>Покупка</th>
                    <th>Продажа</th>
                    <th>Сумма</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Беларусбанк № 703/104</td>
                    <td>2.009</td>
                    <td>2.009</td>
                    <td>61</td>
                </tr>
                <tr>
                    <td>Беларусбанк № 703/104</td>
                    <td>3.009</td>
                    <td>2.009</td>
                    <td>61</td>
                </tr>
                <tr>
                    <td>Беларусбанк № 703/104</td>
                    <td>2.009</td>
                    <td>2.009</td>
                    <td>61</td>
                </tr>
                <tr>
                    <td>Беларусбанк № 703/104</td>
                    <td>2.009</td>
                    <td>2.009</td>
                    <td>61</td>
                </tr>
                <tr>
                    <td>Беларусбанк № 703/104</td>
                    <td>2.009</td>
                    <td>2.009</td>
                    <td>61</td>
                </tr>
                <tr>
                    <td>Беларусбанк № 703/104</td>
                    <td>2.009</td>
                    <td>2.009</td>
                    <td>61</td>
                </tr>
                <tr>
                    <td>Беларусбанк № 703/104</td>
                    <td>2.009</td>
                    <td>2.009</td>
                    <td>61</td>
                </tr>
                <tr>
                    <td>Беларусбанк № 703/104</td>
                    <td>2.019</td>
                    <td>2.009</td>
                    <td>61</td>
                </tr>
                <tr>
                    <td>Беларусбанк № 703/104</td>
                    <td>2.009</td>
                    <td>2.009</td>
                    <td>61</td>
                </tr>
                <tr>
                    <td>Беларусбанк № 703/104</td>
                    <td>2.009</td>
                    <td>2.009</td>
                    <td>61</td>
                </tr>

            </table>

        </div>

        <div class="col-sm-12 col-md-12 col-lg-6">

        </div>

    </div>
</div>




<script src="../js/script.js"></script>
</body>
</html>