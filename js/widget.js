;

$(function () {

    function ratesWidgetGet(period) {

        var periodWidget = period;

        $.ajax({
            type: "POST",
            url: "index.php",
            dataType: "json",
            data: {AjaxAction: "WidgetGet", AjaxPeriod: periodWidget}
        }).done(function (result) {

            if ($.isEmptyObject(result)) {
                console.log('Завершаем работу. Пустой объект JSON');
                return;
            }

            $("#current-rate-usd-buy").text(result.current_rate_usd_buy);
            $("#current-rate-usd-sell").text(result.current_rate_usd_sell);
            $("#current-rate-eur-buy").text(result.current_rate_eur_buy);
            $("#current-rate-eur-sell").text(result.current_rate_eur_sell);
            $("#current-rate-rub-buy").text(result.current_rate_rub_buy);
            $("#current-rate-rub-sell").text(result.current_rate_rub_sell);

            Chart.defaults.global.pointHitDetectionRadius = 1;
            Chart.defaults.global.tooltips.enabled = true;
            Chart.defaults.global.tooltips.mode = 'index';
            Chart.defaults.global.tooltips.intersect = true;
            Chart.defaults.global.tooltips.position = 'nearest';

            var brandBoxChartLabels = result.graph_time;
            var brandBoxChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                elements: {
                    point: {
                        radius: 0,
                        hitRadius: 10,
                        hoverRadius: 4,
                        hoverBorderWidth: 3
                    }
                }
            };
            var brandBoxChart1 = new Chart($('#usd-box-chart-1'), {
                type: 'line',
                data: {
                    labels: brandBoxChartLabels,
                    datasets: [{
                        label: 'Продажа',
                        backgroundColor: 'rgba(255,255,255,0.1)',
                        borderColor: 'rgba(255,255,255,0.55)',
                        pointHoverBackgroundColor: '#fff',
                        borderWidth: 2,
                        data: result.graph_usd_sell
                    }, {
                        label: 'Покупка',
                        backgroundColor: 'rgba(255,255,255,.1)',
                        borderColor: 'rgba(255,255,255,.55)',
                        pointHoverBackgroundColor: '#00ffa9',
                        borderWidth: 2,
                        data: result.graph_usd_buy
                    }]
                },
                options: brandBoxChartOptions
            });
            var brandBoxChart2 = new Chart($('#eur-box-chart-2'), {
                type: 'line',
                data: {
                    labels: brandBoxChartLabels,
                    datasets: [{
                        label: 'Продажа',
                        backgroundColor: 'rgba(255,255,255,.1)',
                        borderColor: 'rgba(255,255,255,.55)',
                        pointHoverBackgroundColor: '#fff',
                        borderWidth: 2,
                        data: result.graph_eur_sell
                    }, {
                        label: 'Покупка',
                        backgroundColor: 'rgba(255,255,255,.1)',
                        borderColor: 'rgba(255,255,255,.55)',
                        pointHoverBackgroundColor: '#2b99ff',
                        borderWidth: 2,
                        data: result.graph_eur_buy
                    }]
                },
                options: brandBoxChartOptions
            });
            var brandBoxChart3 = new Chart($('#rub-box-chart-3'), {
                type: 'line',
                data: {
                    labels: brandBoxChartLabels,
                    datasets: [{
                        label: 'Продажа',
                        backgroundColor: 'rgba(255,255,255,.1)',
                        borderColor: 'rgba(255,255,255,.55)',
                        pointHoverBackgroundColor: '#fff',
                        borderWidth: 2,
                        data: result.graph_rub_sell
                    }, {
                        label: 'Покупка',
                        backgroundColor: 'rgba(255,255,255,.1)',
                        borderColor: 'rgba(255,255,255,.55)',
                        pointHoverBackgroundColor: '#ff1f62',
                        borderWidth: 2,
                        data: result.graph_rub_buy
                    }]
                },
                options: brandBoxChartOptions
            });


        }).fail(function () {
            alert('Что-то пошло не так. Повторите позже.');
        });
    }

    ratesWidgetGet("WidgetWeek");

    $("i.fas.fa-chart-line").on('click', function () {
        $(this).find(".dynamics").slideDown(300).delay(2000).slideUp(300);
    });

    $(".brand-card").on('click', function (event) {

        var target = $(event.target);
        if (!target.hasClass('fa-chart-line')) {

            window.top.location.href='http://klejnov.ga:81/'
        }
    });
});
