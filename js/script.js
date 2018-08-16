;

$(function () {

    var table = '';

    var settings = {
        btnBuy: true,
        btnSell: false,
        btnUsd: true,
        btnEur: false,
        btnRub: false,
        number: 100
    };

    var tableArr = {};

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
            $(".button-show").show();
            $(".table-show").show();
            $(".dataTable tbody").empty();

            tableArr = result;

            tableCreate();
            tableCalc();

            $('input.form-control').on('keyup change', function () {
                showInfoBank();
            });

        }).fail(function () {
            alert('Что-то пошло не так. Повторите позже.');
        });
    }


    ratesWidgetGet();
    banksTableGet();


    function tableCalc() {

        console.log('Таблица:1');
        console.log(tableArr);

        console.log('Таблица2:');
        console.log(settings);

        $.each(tableArr, function (key, element) {

            var usd_buy = (Math.round(element.usd_buy * 10000) / 10000 );
            var usd_sell = (Math.round(element.usd_sell * 10000) / 10000 );
            var eur_buy = (Math.round(element.eur_buy * 10000) / 10000 );
            var eur_sell = (Math.round(element.eur_sell * 10000) / 10000 );
            var rub_buy = (Math.round(element.rub_buy * 10000) / 10000 );
            var rub_sell = (Math.round(element.rub_sell * 10000) / 10000 );

            var usd_buy_sum = (Math.round(element.usd_buy * settings.number * 10000) / 10000 );
            var usd_sell_sum = (Math.round(element.usd_sell * settings.number * 10000) / 10000 );
            var eur_buy_sum = (Math.round(element.eur_buy * settings.number * 10000) / 10000 );
            var eur_sell_sum = (Math.round(element.eur_sell * settings.number * 10000) / 10000 );
            var rub_buy_sum = (Math.round(element.rub_buy * settings.number * 10000) / 10000 );
            var rub_sell_sum = (Math.round(element.rub_sell * settings.number * 10000) / 10000 );

            var latlng = element.latlng.split(',').reverse().join(',');

            table.row.add([
                '<td><img src="/admin/files/img/ico/' + element.ico + '" alt="">' + element.name + '' +
                '<div data-info="info" data-id="' + element.banks_id + '" style="display: none">' + element.address + '<br><span>Банк обновлял курсы: ' + element.time + '</span>' +
                '<img width="100%" src="data:image/gif;base64,R0lGODlhqAIsAZECADWz27vM0////wAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFCgACACwAAAAAqAIsAQAC/5SPqcvtD6OctNqLs968+w+G4kiW5omm6sq27gvH8kzX9o3n+s73/g8MCofEovGITCqXzKbzCY1Kp9Sq9YrNarfcrvcLDovH5LL5jE6r1+y2+w2Py+f0uv2Oz+v3/L7/DxgoOEhYaHiImKi4yNjo+AgZKTlJWWl5iZmpucnZ6fkJGio6SlpqeoqaqrrK2ur6ChsrO0tba3uLm6u7y9vr+wscLDxMXGx8jJysvMzc7PwMHS09TV1tfY2drb3N3e39DR4uPk5ebn6Onq6+zt7u/g4fLz9PX29/j5+vv8/f7/8PMKDAgQQLGjyIMKHChQwbOnwIMaLEiRQrWryIMaPGjf8cO3r8CDKkyJEkS5o8iTKlypUsW7p8CTOmzJk0a9q8iTOnzp08e/r8CTSo0KFEixo9ijSp0qVMmzp9CjWq1KlUq1q9ijWr1q1cu3r9Cjas2LFky5o9izat2rVs27p9Czeu3Ll069q9izev3r18+/r9Cziw4MGECxs+jDix4sWMGzt+DDmy5MmUK1u+jDmz5s2cO3v+DDq06NGkS5s+jTq16tWsW7t+DTu27Nm0a9u+jTu37t28e/vuGCC48OAMhg8vbpz4guTKFTAPgDx5dOPTjy9nXl347yzPszdP0P26dPHUyVt3jt28dvXfEYTfbuU9+PTox9cvf//8fPv78ff/1+8eff+tB18V8gXIH4L+KQjgAQc6KCCDBA7YHoQJWrhggVE8aACHAngIYoQYNtihiCVeeGKGKZKooRMhovihiTHC+KKKM9pYI4setshEjhNKWOGKP444pJBB3qijjD4eyeMSS0LHHpT5FYkklU96JyWFWQK5ZZNNXBkllmKGSeaUR4Lp5RNoajmmmV0a+WaVZypJJ4xpIrEml22yWSafbu6p550u1okjoUnSaKiVic5pp6COPgpppJJOSmmlll6Kaaaabsppp55+Cmqooo5Kaqmmnopqqqquymqrrr4Ka6yyzkprrbbeimuuuu7Ka6++/gpssMIOS2yxxh6LbLLKly7LbLPOPgtttNJOS2211l6Lbbbabsttt95+C2644o5Lbrnmnotuuuquy2677r4Lb7zyzktvvfbei2+++u7Lb7/+/gtwwAIPTHDBBh+McMIKL8xwww4/DHHEEk9MccUWX4xxxhpvzHHHHn8Mcsgij0xyySafjHLKKq/McssuvwxzzDLPTHPNNt+Mc84678xzzz7/DHRXBQAAIfkEBQoAAgAsCAGQAAgADAAAAgiEj6nL7Q9jKgAh+QQFCgACACwYAZAACAAMAAACCISPqcvtD2MqACH5BAUKAAIALCgBkAAIAAwAAAIIhI+py+0PYyoAIfkEBQoAAgAsOAGQAAgADAAAAgiEj6nL7Q9jKgAh+QQFCgACACxIAZAACAAMAAACCISPqcvtD2MqACH5BAUKAAIALFgBkAAIAAwAAAIIhI+py+0PYyoAIfkEBQoAAgAsaAGQAAgADAAAAgiEj6nL7Q9jKgAh+QQFCgACACx4AZAACAAMAAACCISPqcvtD2MqACH5BAUKAAIALIgBkAAIAAwAAAIIhI+py+0PYyoAIfkEBQoAAgAsmAGQAAgADAAAAgiEj6nL7Q9jKgAh+QQFCgACACwAAAAAAQABAAACAlQBADs=" alt="Местонахождение банка" data-pic="https://static-maps.yandex.ru/1.x/?l=map&pt=' + latlng + ',pm2rdl&size=514,300&z=16&lang=ru_RU">' +
                '</div>' +
                '<i class="fas fa-info-circle"></i>' +
                '</td>',
                '<td>' + usd_buy + '</td>',
                '<td>' + usd_sell + '</td>',
                '<td class="usd_buy_sum">' + usd_buy_sum + ' р.</td>',
                '<td class="usd_sell_sum">' + usd_sell_sum + ' р.</td>',
                '<td>' + eur_buy + '</td>',
                '<td>' + eur_sell + '</td>',
                '<td class="eur_buy_sum">' + eur_buy_sum + ' р.</td>',
                '<td class="eur_sell_sum">' + eur_sell_sum + ' р.</td>',
                '<td>' + rub_buy + '</td>',
                '<td>' + rub_sell + '</td>',
                '<td class="rub_buy_sum">' + rub_buy_sum + ' р.</td>',
                '<td class="rub_sell_sum">' + rub_sell_sum + ' р.</td>'
            ]).draw(true);

            showInfoBank();
        });

    }

    function showInfoBank() {

        $('tbody>tr').off('click');
        table.draw();
        $('tbody>tr').on('click', function () {
            //$(this).toggleClass("active");
            var value = $(this).find('div').html();
            console.log(value);

            var id = $(this).find('div').data("id");


            if ($(this).parent().find('[data-id-bank="bank' + id + '"]').is('[data-id-bank="bank' + id + '"]')) {

                $(this).parent().find('[data-id-bank="bank' + id + '"]').remove();
            } else {
                $(this).after('<tr data-id-bank="bank' + id + '"><td  colspan="3"><p style="display: none" data-id-bank="bank' + id + '">' + value + '</p></td></tr>');

                $(this).parent().find('[data-id-bank="bank' + id + '"]').slideDown(300);


            }
            var kx = $(this).parent().find('[data-id-bank="bank' + id + '"] img').data('pic');
            $(this).parent().find('[data-id-bank="bank' + id + '"] img').attr('src', kx);

            //$('.dataTable tr:empty').remove();

        });
    }

    $('thead tr').on('click', function () {
        showInfoBank();
    });


    $('input.number').on('keyup change', function () {
        var value = $(this).val();
        console.log(table);
        settings.number = +value;

        table.clear();

        tableCalc();

    });


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

        settingsApply();


        $('#show-10').on('click', function (e) {
            e.preventDefault();
            table.page.len(10).draw();
            showInfoBank();
        });

        $('#show-all').on('click', function (e) {
            e.preventDefault();
            table.page.len(100).draw();
            showInfoBank();
        });

    }

    function usdShow(a, b, c) {
        for (var i = 0; i <= 12; i++) {
            table.column(i).visible(false, false);
            if (i == a || i == b || i == c) { // спрятать
                table.column(i).visible(true, false);
            }
        }
    }

    function eurShow(a, b, c) {
        for (var i = 0; i <= 12; i++) {
            table.column(i).visible(false, false);
            if (i == a || i == b || i == c) { // спрятать
                table.column(i).visible(true, false);
            }
        }
    }

    function rubShow(a, b, c) {
        for (var i = 0; i <= 12; i++) {
            table.column(i).visible(false, false);
            if (i == a || i == b || i == c) { // спрятать
                table.column(i).visible(true, false);
            }
        }
    }


    $('#usd').on('click', function () {
        settings.btnUsd = true;
        settings.btnEur = false;
        settings.btnRub = false;
        settingsApply();
    });
    $('#eur').on('click', function () {
        settings.btnEur = true;
        settings.btnUsd = false;
        settings.btnRub = false;
        settingsApply();
    });
    $('#rub').on('click', function () {
        settings.btnRub = true;
        settings.btnUsd = false;
        settings.btnEur = false;
        settingsApply();
    });


    $("a").click(function () {
        $(this).toggleClass("open");
        $("h1").addClass("fade");
    });


    $('.btn-left').on('click', function () {
        settings.btnBuy = true;
        settings.btnSell = false;
        settingsApply();
    });

    function btnLeftClick(column) {
        table.order([column, 'asc']).draw();
    };

    $('.btn-right').on('click', function () {
        settings.btnBuy = false;
        settings.btnSell = true;
        settingsApply();
    });

    function btnRightClick(column) {
        table.order([column, 'desc']).draw();
    };

    $("i.fas.fa-chart-line").on('click', function () {
        $(this).find(".dynamics").slideDown(300).delay(2000).slideUp(300);
    });


    function settingsApply() {
        $(".btn-right").removeClass("btn-outline-usd btn-outline-eur btn-outline-rub btn-usd btn-eur btn-rub");
        $(".btn-left").removeClass("btn-outline-usd btn-outline-eur btn-outline-rub btn-usd btn-eur btn-rub");

        $("#usd").removeClass("btn-usd");
        $("#eur").removeClass("btn-eur");
        $("#rub").removeClass("btn-rub");

        $("#usd").addClass("btn-outline-usd");
        $("#eur").addClass("btn-outline-eur");
        $("#rub").addClass("btn-outline-rub");

        if (settings.btnUsd && settings.btnBuy) {
            $(".btn-right").addClass("btn-outline-usd");
            $(".btn-left").addClass("btn-usd");

            $("#usd").removeClass("btn-outline-usd");
            $("#usd").addClass("btn-usd");
            $("#inlineFormInputGroup").css({'borderColor': '#4dbd74', 'color': '#4dbd74'});

            var column = 2;
            usdShow(0, 2, 4);
            btnLeftClick(column);
        }
        if (settings.btnUsd && settings.btnSell) {
            $(".btn-left").addClass("btn-outline-usd");
            $(".btn-right").addClass("btn-usd");

            $("#usd").removeClass("btn-outline-usd");
            $("#usd").addClass("btn-usd");
            $("#inlineFormInputGroup").css({'borderColor': '#4dbd74', 'color': '#4dbd74'});

            var column = 1;
            usdShow(0, 1, 3);
            btnRightClick(column);
        }

        if (settings.btnEur && settings.btnBuy) {
            $(".btn-right").addClass("btn-outline-eur");
            $(".btn-left").addClass("btn-eur");

            $("#eur").removeClass("btn-outline-eur");
            $("#eur").addClass("btn-eur");
            $("#inlineFormInputGroup").css({'borderColor': '#3cb6d9', 'color': '#3cb6d9'});

            var column = 6;
            eurShow(0, 6, 8);
            btnLeftClick(column);
        }
        if (settings.btnEur && settings.btnSell) {
            $(".btn-left").addClass("btn-outline-eur");
            $(".btn-right").addClass("btn-eur");

            $("#eur").removeClass("btn-outline-eur");
            $("#eur").addClass("btn-eur");
            $("#inlineFormInputGroup").css({'borderColor': '#3cb6d9', 'color': '#3cb6d9'});

            var column = 5;
            eurShow(0, 5, 7);
            btnRightClick(column);
        }

        if (settings.btnRub && settings.btnBuy) {
            $(".btn-right").addClass("btn-outline-rub");
            $(".btn-left").addClass("btn-rub");

            $("#rub").removeClass("btn-outline-rub");
            $("#rub").addClass("btn-rub");
            $("#inlineFormInputGroup").css({'borderColor': '#f66c6a', 'color': '#f66c6a'});

            var column = 10;

            rubShow(0, 10, 12);
            btnLeftClick(column);
        }
        if (settings.btnRub && settings.btnSell) {
            $(".btn-left").addClass("btn-outline-rub");
            $(".btn-right").addClass("btn-rub");

            $("#rub").removeClass("btn-outline-rub");
            $("#rub").addClass("btn-rub");
            $("#inlineFormInputGroup").css({'borderColor': '#f66c6a', 'color': '#f66c6a'});

            var column = 9;
            rubShow(0, 9, 11);
            btnRightClick(column);
        }

        $(".number").val(settings.number);


        showInfoBank();

        console.log('Настройки в функции:');
        console.log(settings);

    };


});


