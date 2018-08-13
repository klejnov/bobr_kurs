;

$(function () {

    var table = '';

    function ratesWidgetGet() {

        $.ajax({
            type: "POST",
            url: "index.php",
            dataType: "json",
            data: {AjaxAction: "WidgetGet"}
        }).done(function (result) {

            $("#current-rate-usd-buy").text(result.current_rate_usd_buy);
            $("#current-rate-usd-sell").text(result.current_rate_usd_sell);
            $("#current-rate-eur-buy").text(result.current_rate_eur_buy);
            $("#current-rate-eur-sell").text(result.current_rate_eur_sell);
            $("#current-rate-rub-buy").text(result.current_rate_rub_buy);
            $("#current-rate-rub-sell").text(result.current_rate_rub_sell);

            if ($.isEmptyObject(result)) {
                console.log('Завершаем работу. Пустой объект JSON');
                return;
            }

            //console.log(result);

            Chart.defaults.global.pointHitDetectionRadius = 1;
            Chart.defaults.global.tooltips.enabled = false;
            Chart.defaults.global.tooltips.mode = 'index';
            Chart.defaults.global.tooltips.position = 'nearest';
            Chart.defaults.global.tooltips.custom = CustomTooltips;

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
                        backgroundColor: 'rgba(255,255,255,.1)',
                        borderColor: 'rgba(255,255,255,.55)',
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

    function banksTableGet() {

        $.ajax({
            type: "POST",
            url: "index.php",
            dataType: "json",
            data: {AjaxAction: "TableInfoGet"}
        }).done(function (result) {

            if ($.isEmptyObject(result)) {
                console.log('Завершаем работу. Пустой объект JSON');
                return;
            }

            console.log(result);
            $(".spinner-show").hide();
            $(".table-show").show();
            $(".dataTable tbody").empty();

            $.each(result, function (key, element) {

                $(".dataTable tbody").append('<tr data-id-bank="' + element.banks_id + '">' +
                    '<td><img src="/admin/files/img/ico/' + element.ico + '" alt="">' + element.name + '</td>' +
                    '<td>' + (Math.round(element.usd_buy * 10000) / 10000 ) + '</td>' +
                    '<td>' + (Math.round(element.usd_sell * 10000) / 10000 ) + '</td>' +
                    '<td>' + (Math.round(element.eur_buy * 10000) / 10000 ) + '</td>' +
                    '<td>' + (Math.round(element.eur_sell * 10000) / 10000 ) + '</td>' +
                    '<td>' + (Math.round(element.rub_buy * 10000) / 10000 ) + '</td>' +
                    '<td>' + (Math.round(element.rub_sell * 10000) / 10000 ) + '</td>' +
                    '<td>' + element.time + '</td>' +
                    '</tr>');

            });

            tableCreate();

        }).fail(function () {
            alert('Что-то пошло не так. Повторите позже.');
        });
    }


    ratesWidgetGet();
    banksTableGet();


    function tableCreate() {

        $('#myTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "dom": '<"top">rt<"bottom">f<"clear">',
            language: {

                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                },
                "aria": {
                    "sortAscending": ": активировать для сортировки столбца по возрастанию",
                    "sortDescending": ": активировать для сортировки столбца по убыванию"
                }

            }
        });

        table = $('#myTable').DataTable();

        usdShow();

        $('#show-10').on('click', function (e) {
            e.preventDefault();
            table.page.len(10).draw();
        });

        $('#show-all').on('click', function (e) {
            e.preventDefault();
            table.page.len(100).draw();
        });

    }

    function usdShow() {
        for (var i = 0; i <= 7; i++) {
            table.column(i).visible(true, false);
            if (i >= 3 && i <= 6) {
                table.column(i).visible(false, false);
            }
        }

        table.order([2, 'asc']).draw();
    }

    function eurShow() {
        for (var i = 0; i <= 7; i++) {
            table.column(i).visible(true, false);
            if (i >= 1 && i <= 2 || i >= 5 && i <= 6) {
                table.column(i).visible(false, false);
            }
        }
    }

    function rubShow() {
        for (var i = 0; i <= 7; i++) {
            table.column(i).visible(true, false);
            if (i >= 1 && i <= 4) {
                table.column(i).visible(false, false);
            }
        }
    }


    $('#usd').on('click', function () {
        usdShow();
    });
    $('#eur').on('click', function () {
        eurShow();
    });
    $('#rub').on('click', function () {
        rubShow();
    });


    //console.log('Тест2');

    $("a").click(function () {
        $(this).toggleClass("open");
        $("h1").addClass("fade");
    });


    $('.btn-left').on('click', function () {
        $(".btn-right").addClass("btn-outline-eur");
        $(".btn-left").addClass("btn-eur");
        $(".btn-left").removeClass("btn-outline-eur");
        $(".btn-right").removeClass("btn-eur");
        table.order([2, 'asc']).draw();

    });
    $('.btn-right').on('click', function () {
        $(".btn-left").addClass("btn-outline-eur");
        $(".btn-right").addClass("btn-eur");
        $(".btn-right").removeClass("btn-outline-eur");
        $(".btn-left").removeClass("btn-eur");
        table.order([1, 'desc']).draw();
    });

    $("i.fas.fa-chart-line").on('click', function () {
        $(this).find(".dynamics").slideDown(300).delay(2000).slideUp(300);
    });

});
