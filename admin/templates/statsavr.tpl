

<!-- container stats avg begin -->
<script src="files/js/highcharts.js"></script>

<style>
    .graph {
        width: 300px;
        height: 150px;
        margin: 0 auto
    }
    .rate-block {
        padding: 20px 30px 10px;
    }
    .rate-block, .rates .container {
        background-color: #fff;
    }
    .rate-block .rate-header {
        margin-right: 5px;
        margin-top: -40px;
        width: 125px;
        display: inline-block;
        vertical-align: middle;
    }
    .rate-chart {
        margin-right: -10px;
        display: inline-block;
        vertical-align: middle;
    }
</style>

<div class="jumbotron">
    <h3>Среднее значение</h3>
    <div class="jumbotron" style="max-width: 100%; margin: auto;">
        <div class="form-group" >
            <div style="display:inline-block; margin-top: 20px;">
                <div class="rate-block">
                    <div class="rate-header">
                        <H2>USD:</H2>
                        <H3><?= round((float)$stat['usd_sell'], 3) ?> <sup style="font-size: 13px; color: #7cb5ec;">Продажа</sup></H3>
                        <H3><?= round((float)$stat['usd_buy'], 3) ?> <sup style="font-size: 13px; color: #f7a35c;">Покупка</sup></H3>
                    </div>
                    <div id="container_usd" class="rate-chart graph"></div>
                </div>
                <script>
            Highcharts.chart('container_usd', {

                series: [{
                    name: 'Installation',
                    lineWidth: 40,
                    marker: {
                        radius: 0
                    }
                }, {
                    name: 'New visitors'
                }],

                title: {
                    text: null
                },

                subtitle: {
                    text: null
                },

                yAxis: {
                    title: {
                        text: null
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    shared: true,
                    crosshairs: false
                },

                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: false
                        },
                        enableMouseTracking: true
                    }
                },

                xAxis: {
                    //tickInterval: 200 * 24 * 3600 * 1000, // one week
                    categories: <?= $data_graph ?>,
                    tickWidth: 0,
                    gridLineWidth: 0,
                    //showFirstLabel: true
                    crosshair: {
                        width: 1,
                        color: 'grey'
                    }
                },
                series: [{
                    name: 'Продажа',
                    lineWidth: 4,
                    marker: {
                        radius: 0
                    },
                    color: '#7cb5ec',
                    data: <?= $data_graph_usd_sell ?>
                }, {
                    name: 'Покупка',
                    lineWidth: 4,
                    marker: {
                        radius: 0
                    },
                    color: '#f7a35c',
                    data: <?= $data_graph_usd_buy ?>
                }]
            });
                </script>
            </div>

            <div style="display:inline-block; margin-top: 20px;">
                <div class="rate-block">
                    <div class="rate-header">
                        <H2>EUR:</H2>
                        <H3><?= round((float)$stat['eur_sell'], 3) ?> <sup style="font-size: 13px; color: #7cb5ec;">Продажа</sup></H3>
                        <H3><?= round((float)$stat['eur_buy'], 3) ?> <sup style="font-size: 13px; color: #f7a35c;">Покупка</sup></H3>
                    </div>
                    <div id="container_eur" class="rate-chart graph"></div>
                </div>
                <script>
                    Highcharts.chart('container_eur', {

                        series: [{
                            name: 'Installation',
                            lineWidth: 40,
                            marker: {
                                radius: 0
                            }
                        }, {
                            name: 'New visitors'
                        }],

                        title: {
                            text: null
                        },

                        subtitle: {
                            text: null
                        },

                        yAxis: {
                            title: {
                                text: null
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            shared: true,
                            crosshairs: false
                        },

                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: false
                                },
                                enableMouseTracking: true
                            }
                        },

                        xAxis: {
                            //tickInterval: 200 * 24 * 3600 * 1000, // one week
                            categories: <?= $data_graph ?>,
                        tickWidth: 0,
                        gridLineWidth: 0,
                        //showFirstLabel: true
                        crosshair: {
                        width: 1,
                            color: 'grey'
                    }
                    },
                    series: [{
                        name: 'Продажа',
                        lineWidth: 4,
                        marker: {
                            radius: 0
                        },
                        color: '#7cb5ec',
                        data: <?= $data_graph_eur_sell ?>
                    }, {
                        name: 'Покупка',
                            lineWidth: 4,
                            marker: {
                            radius: 0
                        },
                        color: '#f7a35c',
                            data: <?= $data_graph_eur_buy ?>
                    }]
                    });
                </script>
            </div>

            <div style="display:inline-block; margin-top: 20px;">
                <div class="rate-block">
                    <div class="rate-header">
                        <H2>RUB:</H2>
                        <H3><?= round((float)$stat['rub_sell'], 3) ?> <sup style="font-size: 13px; color: #7cb5ec;">Продажа</sup></H3>
                        <H3><?= round((float)$stat['rub_buy'], 3) ?> <sup style="font-size: 13px; color: #f7a35c;">Покупка</sup></H3>
                    </div>
                    <div id="container_rub" class="rate-chart graph"></div>
                </div>
                <script>
                    Highcharts.chart('container_rub', {

                        series: [{
                            name: 'Installation',
                            lineWidth: 40,
                            marker: {
                                radius: 0
                            }
                        }, {
                            name: 'New visitors'
                        }],

                        title: {
                            text: null
                        },

                        subtitle: {
                            text: null
                        },

                        yAxis: {
                            title: {
                                text: null
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            shared: true,
                            crosshairs: false
                        },

                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: false
                                },
                                enableMouseTracking: true
                            }
                        },

                        xAxis: {
                            //tickInterval: 200 * 24 * 3600 * 1000, // one week
                            categories: <?= $data_graph ?>,
                        tickWidth: 0,
                        gridLineWidth: 0,
                        //showFirstLabel: true
                        crosshair: {
                        width: 1,
                            color: 'grey'
                    }
                    },
                    series: [{
                        name: 'Продажа',
                        lineWidth: 4,
                        marker: {
                            radius: 0
                        },
                        color: '#7cb5ec',
                        data: <?= $data_graph_rub_sell ?>
                    }, {
                        name: 'Покупка',
                            lineWidth: 4,
                            marker: {
                            radius: 0
                        },
                        color: '#f7a35c',
                            data: <?= $data_graph_rub_buy ?>
                    }]
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<!-- container stats avg end -->

