<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" href="../img/favicon/favicon.ico" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Курсы валют в Бобруйске / Бобруйский портал BOBR.BY</title>
    <meta name="description" content="Виджет курсов валют всех банков Бобруйска. Динамика изменения курсов валют в Бобруйске">
    <meta name="keywords" content="Курсы валют в Бобруйске, Бобруйск, курсы валют, виджет, динамика курсов, график">

    <link rel="stylesheet" href="../libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../css/widget.css">

    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../libs/bootstrap/bootstrap.min.js"></script>
    <script src="../libs/chart.js/chart.min.js"></script>

</head>
<body>

<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel" data-interval="7000">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="brand-card usd-card">
                                <div class="brand-card-header bg-usd">
                                    <i class="fontello-icon icon-dollar">&#xf155;</i>
                                    <i class="fas fa-chart-line fontello-icon icon-chart-line" title="Динамика за 2 недели">
                                        <span class="dynamics dynamics-usd">Динамика за 2 недели</span>
                                    </i>
                                    <div class="chart-wrapper">
                                        <canvas id="usd-box-chart-1" height="90"></canvas>
                                    </div>
                                </div>
                                <div class="brand-card-body">
                                    <div>
                                        <div class="text-value" id="current-rate-usd-buy">
                                            <i class="fontello-icon icon-spinner animate-spin">&#xf110;</i>
                                        </div>
                                        <div class="text-uppercase text-muted small">Покупка</div>
                                    </div>
                                    <div>
                                        <div class="text-value" id="current-rate-usd-sell">
                                            <i class="fontello-icon icon-spinner animate-spin">&#xf110;</i>
                                        </div>
                                        <div class="text-uppercase text-muted small">Продажа</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="brand-card eur-card">
                                <div class="brand-card-header bg-eur">
                                    <i class="fontello-icon icon-euro">&#xf153;</i>
                                    <i class="fas fa-chart-line fontello-icon icon-chart-line" title="Динамика за 2 недели">
                                        <span class="dynamics">Динамика за 2 недели</span>
                                    </i>
                                    <div class="chart-wrapper">
                                        <canvas id="eur-box-chart-2" height="90"></canvas>
                                    </div>
                                </div>
                                <div class="brand-card-body">
                                    <div>
                                        <div class="text-value" id="current-rate-eur-buy">
                                            <i class="fontello-icon icon-spinner animate-spin">&#xf110;</i>
                                        </div>
                                        <div class="text-uppercase text-muted small">Покупка</div>
                                    </div>
                                    <div>
                                        <div class="text-value" id="current-rate-eur-sell">
                                            <i class="fontello-icon icon-spinner animate-spin">&#xf110;</i>
                                        </div>
                                        <div class="text-uppercase text-muted small">Продажа</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="brand-card rub-card">
                                <div class="brand-card-header bg-rub">
                                    <i class="fontello-icon icon-rouble">&#xf158;</i>
                                    <i class="fas fa-chart-line fontello-icon icon-chart-line" title="Динамика за 2 недели">
                                        <span class="dynamics">Динамика за 2 недели</span>
                                    </i>
                                    <div class="chart-wrapper">
                                        <canvas id="rub-box-chart-3" height="90"></canvas>
                                    </div>
                                </div>
                                <div class="brand-card-body">
                                    <div>
                                        <div class="text-value" id="current-rate-rub-buy">
                                            <i class="fontello-icon icon-spinner animate-spin">&#xf110;</i>
                                        </div>
                                        <div class="text-uppercase text-muted small">Покупка</div>
                                    </div>
                                    <div>
                                        <div class="text-value" id="current-rate-rub-sell">
                                            <i class="fontello-icon icon-spinner animate-spin">&#xf110;</i>
                                        </div>
                                        <div class="text-uppercase text-muted small">Продажа</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <i class="fa-chevron-left fontello-icon icon-left-open" aria-hidden="true">&#xe801;</i>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <i class="fa-chevron-right fontello-icon icon-right-open" aria-hidden="true">&#xe803;</i>
                    </a>

                </div>

            </div>
        </div>
    </div>

</main>

<script src="../js/widget.js"></script>

</body>
</html>