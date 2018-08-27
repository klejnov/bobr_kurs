<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" href="../img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/fontawesome.css">
    <link rel="stylesheet" href="../libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../libs/dataTables/datatables.min.css">
    <link rel="stylesheet" href="../libs/bootstrap-select/bootstrap-select.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../libs/bootstrap/popper.min.js"></script>
    <script src="../libs/bootstrap/bootstrap.min.js"></script>
    <script src="../libs/dataTables/datatables.min.js"></script>

    <script src="../libs/coreui/coreui.min.js"></script>
    <script src="../libs/chart.js/custom-tooltips.min.js"></script>
    <script src="../libs/chart.js/chart.min.js"></script>
    <script src="../libs/bootstrap-select/bootstrap-select.min.js"></script>

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

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
                    <i class="fas fa-chart-line" title="Динамика за 2 недели">
                        <div class="dynamics">Динамика за 2 недели</div>
                    </i>
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
                    <i class="fas fa-chart-line" title="Динамика за 2 недели">
                        <div class="dynamics">Динамика за 2 недели</div>
                    </i>
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
                    <i class="fas fa-chart-line" title="Динамика за 2 недели">
                        <div class="dynamics">Динамика за 2 недели</div>
                    </i>
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
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

            <div class="spinner-show"><i class="fas fa-spinner fa-spin"></i></div>
            <div class="row">

                <div class="col-xl-4 col-lg-6 col-md-5 col-sm-6">
                    <div class="buy-sell button-show">
                        <button type="button" class="btn btn-block btn-outline-usd btn-left">Купить</button>
                        <button type="button" class="btn btn-block btn-outline-usd btn-right">Продать</button>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 select-input button-show">
                    <label class="sr-only" for="inlineFormInputGroup"></label>
                    <div class="input-group mb-1">
                        <input type="number" min="0" class="form-control number" id="inlineFormInputGroup" value="">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-4 col-md-5 col-sm-4 btn-content button-show">
                    <button type="button" class="btn btn-block btn-outline-usd" id="usd"><i
                                class="fas fa-dollar-sign"></i></button>
                    <button type="button" class="btn btn-block btn-outline-eur" id="eur"><i
                                class="fas fa-euro-sign"></i></button>
                    <button type="button" class="btn btn-block btn-outline-rub" id="rub"><i
                                class="fas fa-ruble-sign"></i></button>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-show">
                        <table class="table dataTable" id="myTable" data-page-length='10'>
                            <thead>
                            <tr>
                                <th>Банк</th>
                                <th>Курс</th>
                                <th>Курс</th>
                                <th>Получу</th>
                                <th>Отдам</th>
                                <th>Курс</th>
                                <th>Курс</th>
                                <th>Получу</th>
                                <th>Отдам</th>
                                <th>Курс</th>
                                <th>Курс</th>
                                <th>Получу</th>
                                <th>Отдам</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="map">
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>

</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="wrapper-chart">
                <div class="col-sm-12 col-md-4 col-lg-3">
                    <select id="basic" class="selectpicker show-tick form-control" data-live-search="true">
                    </select>
                    <div class="address"></div>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-9">
                    <div class="input-group-append graph-btn">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-light active">
                                <input type="radio" name="options" id="option1" value="usd" autocomplete="off"
                                       checked><i
                                        class="fas fa-dollar-sign"></i>
                            </label>
                            <label class="btn btn-light">
                                <input type="radio" name="options" id="option2" value="eur" autocomplete="off"><i
                                        class="fas fa-euro-sign"></i>
                            </label>
                            <label class="btn btn-light">
                                <input type="radio" name="options" id="option3" value="rub" autocomplete="off"><i
                                        class="fas fa-ruble-sign"></i>
                            </label>

                            <button class="btn btn-light dropdown-toggle period" type="button" data-toggle="dropdown"
                                    data-period="week"
                                    aria-haspopup="true" aria-expanded="false">Неделя
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" data-period="day" href="#">Сутки</a>
                                <a class="dropdown-item" data-period="week" href="#">Неделя</a>
                                <a class="dropdown-item" data-period="month" href="#">Месяц</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">

                    <div>
                        <canvas id="main-chart" style="height: 350px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row b-footer">
        <div class="text-wrapper">
            &copy; <a href="https://bobr.by">BOBR.BY</a>, 2006 &ndash; <?= $year ?></div>
    </div>
</div>

<script src="../js/script.js"></script>

</body>
</html>