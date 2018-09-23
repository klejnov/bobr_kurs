;

$(function () {

    var settings = {};

    var table = '';

    var tableArr = {};

    var myMap = '';
    var usdBuy = '';
    var usdSell = '';
    var eurBuy = '';
    var eurSell = '';
    var rubBuy = '';
    var rubSell = '';

    function getCookie(name) {
        var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
        return v ? v[2] : null;
    }

    function setCookie(name, value, days) {
        var d = new Date;
        d.setTime(d.getTime() + 24 * 60 * 60 * 1000 * days);
        document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString();
    }

    function deleteCookie(name) {
        setCookie(name, '', -1);
    }


    if (getCookie("s_number")) {
        settings = {
            btnBuy: getCookie("s_btnBuy") === 'true',
            btnSell: getCookie("s_btnSell") === 'true',
            btnUsd: getCookie("s_btnUsd") === 'true',
            btnEur: getCookie("s_btnEur") === 'true',
            btnRub: getCookie("s_btnRub") === 'true',
            number: +getCookie("s_number")
        };

    } else {
        settings = {
            btnBuy: true,
            btnSell: false,
            btnUsd: true,
            btnEur: false,
            btnRub: false,
            number: 100
        };
        setCookie("s_btnBuy", true, 5);
        setCookie("s_btnSell", false, 5);
        setCookie("s_btnUsd", true, 5);
        setCookie("s_btnEur", false, 5);
        setCookie("s_btnRub", false, 5);
        setCookie("s_number", 100, 5);
    }

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
            console.log('Что-то пошло не так. Повторите позже.');
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

            //console.log(result);

            tableArr = result;

            getDataSearchFormChart();

            // Отключил
            // $('input.form-control').on('keyup change', function () {
            //     showInfoBank();
            // });


            ymaps.ready(function () {
                var flag = true;
                init();
                tableCreate();
                tableCalc(flag);
                showBanksAll();
                placemarkHoverSelect();
            });

        }).fail(function () {
            console.log('Что-то пошло не так. Повторите позже.');
        });
    }


    ratesWidgetGet("WidgetWeek"); // WidgetWeek, WidgetMonth, WidgetYear

    banksTableGet();

    var tableCalc = function (flag) {


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
            var rub_buy_sum = (Math.round(element.rub_buy * settings.number * 100) / 10000 );
            var rub_sell_sum = (Math.round(element.rub_sell * settings.number * 100) / 10000 );

            var latlng = element.latlng.split(',').reverse().join(',');

            var reg = /Адрес: (.*?) Тел.:/;
            var address = element.address.split(reg);

            table.row.add([
                '<td data-id-bank="' + element.banks_id + '"><img src="/admin/files/img/ico/' + element.ico + '" alt="Иконка ' + element.name + '">' + element.name + '' +
                '<div data-info="info" data-id="' + element.banks_id + '" style="display: none">Адрес: ' + address[1] + '<br>Тел.:' + address[2] + '<br><input type="button" value="Неверный курс?" onclick="infoMessage(\'' + element.banks_id + '\', \'' + element.name + '\', \'' + address[1] + '\', \'' + usd_buy + '\', \'' + usd_sell + '\', \'' + eur_buy + '\', \'' + eur_sell + '\', \'' + rub_buy + '\', \'' + rub_sell + '\')"><span>Банк обновлял курсы: <time>' + element.time + '</time></span>' +
                '<img width="100%" src="data:image/gif;base64,R0lGODlhqAIsAZECADWz27vM0////wAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFCgACACwAAAAAqAIsAQAC/5SPqcvtD6OctNqLs968+w+G4kiW5omm6sq27gvH8kzX9o3n+s73/g8MCofEovGITCqXzKbzCY1Kp9Sq9YrNarfcrvcLDovH5LL5jE6r1+y2+w2Py+f0uv2Oz+v3/L7/DxgoOEhYaHiImKi4yNjo+AgZKTlJWWl5iZmpucnZ6fkJGio6SlpqeoqaqrrK2ur6ChsrO0tba3uLm6u7y9vr+wscLDxMXGx8jJysvMzc7PwMHS09TV1tfY2drb3N3e39DR4uPk5ebn6Onq6+zt7u/g4fLz9PX29/j5+vv8/f7/8PMKDAgQQLGjyIMKHChQwbOnwIMaLEiRQrWryIMaPGjf8cO3r8CDKkyJEkS5o8iTKlypUsW7p8CTOmzJk0a9q8iTOnzp08e/r8CTSo0KFEixo9ijSp0qVMmzp9CjWq1KlUq1q9ijWr1q1cu3r9Cjas2LFky5o9izat2rVs27p9Czeu3Ll069q9izev3r18+/r9Cziw4MGECxs+jDix4sWMGzt+DDmy5MmUK1u+jDmz5s2cO3v+DDq06NGkS5s+jTq16tWsW7t+DTu27Nm0a9u+jTu37t28e/vuGCC48OAMhg8vbpz4guTKFTAPgDx5dOPTjy9nXl347yzPszdP0P26dPHUyVt3jt28dvXfEYTfbuU9+PTox9cvf//8fPv78ff/1+8eff+tB18V8gXIH4L+KQjgAQc6KCCDBA7YHoQJWrhggVE8aACHAngIYoQYNtihiCVeeGKGKZKooRMhovihiTHC+KKKM9pYI4setshEjhNKWOGKP444pJBB3qijjD4eyeMSS0LHHpT5FYkklU96JyWFWQK5ZZNNXBkllmKGSeaUR4Lp5RNoajmmmV0a+WaVZypJJ4xpIrEml22yWSafbu6p550u1okjoUnSaKiVic5pp6COPgpppJJOSmmlll6Kaaaabsppp55+Cmqooo5Kaqmmnopqqqquymqrrr4Ka6yyzkprrbbeimuuuu7Ka6++/gpssMIOS2yxxh6LbLLKly7LbLPOPgtttNJOS2211l6Lbbbabsttt95+C2644o5Lbrnmnotuuuquy2677r4Lb7zyzktvvfbei2+++u7Lb7/+/gtwwAIPTHDBBh+McMIKL8xwww4/DHHEEk9MccUWX4xxxhpvzHHHHn8Mcsgij0xyySafjHLKKq/McssuvwxzzDLPTHPNNt+Mc84678xzzz7/DHRXBQAAIfkEBQoAAgAsCAGQAAgADAAAAgiEj6nL7Q9jKgAh+QQFCgACACwYAZAACAAMAAACCISPqcvtD2MqACH5BAUKAAIALCgBkAAIAAwAAAIIhI+py+0PYyoAIfkEBQoAAgAsOAGQAAgADAAAAgiEj6nL7Q9jKgAh+QQFCgACACxIAZAACAAMAAACCISPqcvtD2MqACH5BAUKAAIALFgBkAAIAAwAAAIIhI+py+0PYyoAIfkEBQoAAgAsaAGQAAgADAAAAgiEj6nL7Q9jKgAh+QQFCgACACx4AZAACAAMAAACCISPqcvtD2MqACH5BAUKAAIALIgBkAAIAAwAAAIIhI+py+0PYyoAIfkEBQoAAgAsmAGQAAgADAAAAgiEj6nL7Q9jKgAh+QQFCgACACwAAAAAAQABAAACAlQBADs=" alt="Карта ' + element.name + '" data-pic="https://static-maps.yandex.ru/1.x/?l=map&pt=' + latlng + ',pm2rdl&size=514,300&z=16&lang=ru_RU">' +
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

        if (flag != true){
            setTimeout(function () {
                placemarkHoverSelect();
            },4000);
        }
    };

    var showBanksAll = function () {

        var pageText = '<span>Показать</span> <button type="button" class="btn btn-outline-secondary show-all">ВСЕ</button> <span>банки</span>';
        $('.allbanks').html(pageText);

        $('input.form-control-sm').attr("placeholder", "Поиск");


        $('.show-all').on('click', function (e) {
            e.preventDefault();
            table.page.len(tableArr.length).draw(); //50
            showInfoBank();
            var pageText = '<button type="button" class="btn btn-outline-secondary show-10">Свернуть</button> <span class="align-middle">банки</span>';
            $('.allbanks').html(pageText);

            $('.show-10').on('click', function (e) {
                e.preventDefault();
                table.page.len(11).draw();
                showInfoBank();
                showBanksAll();
            });

        });
    };


    function showInfoBank() {

        $('tbody>tr').off('click');
        table.draw();

        $('tbody>tr').on('click', function () {
            var value = $(this).find('div').html();

            var id = $(this).find('div').data("id");

            if ($(this).parent().find('[data-id-bank="' + id + '"]').is('[data-id-bank="' + id + '"]')) {

                var block = $(this).parent().find('[data-id-bank="' + id + '"]');
                block.slideUp(300);

                setTimeout(function () {
                    block.remove();
                }, 350);

            } else {
                $(this).after('<tr data-id-bank="' + id + '"><td  colspan="3"><p style="display: none" data-id-bank="' + id + '">' + value + '</p></td></tr>');

                $(this).parent().find('[data-id-bank="' + id + '"]').slideDown(300);


            }
            // var kx = $(this).parent().find('[data-id-bank="bank' + id + '"] img').data('pic');
            // $(this).parent().find('[data-id-bank="bank' + id + '"] img').attr('src', kx);

            var src_pic = $(this).parent().find('[data-id-bank="' + id + '"] img');
            src_pic.attr('src', src_pic.data('pic'));

        });
    }

    $('thead tr').on('click', function () {
        showInfoBank();
    });


    $('input.number').on('keyup change', function () {
        var value = $(this).val();

        settings.number = +value;

        setCookie("s_number", +value, 5);

        table.clear();

        tableCalc();

    });


    var tableCreate = function () {

        $('#myTable').DataTable({
            "paging": true,
            "pagingType": "first_last_numbers",
            "ordering": true,
            "info": true,
            "dom": "<'row'<'col-sm-12 col-md-6'><'col-sm-12 col-md-6'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-xl-7 col-lg-7 col-md-6 col-sm-6 allbanks col'><'col-xl-5 col-lg-5 col-md-6 col-sm-6 col'f>>",
            language: {

                "processing": "Подождите...",
                "search": "",
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

            },
            "createdRow": function (row, data, dataIndex) {

                var id = $(data[0]).data("id-bank");
                //$(row).addClass( 'bank-' + id );
                $(row).attr('data-bank', id);

            }
        });

        table = $('#myTable').DataTable();

        settingsApply();

    };

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
        setCookie("s_btnUsd", true, 5);
        setCookie("s_btnEur", false, 5);
        setCookie("s_btnRub", false, 5);
        settingsApply();
    });
    $('#eur').on('click', function () {
        settings.btnEur = true;
        settings.btnUsd = false;
        settings.btnRub = false;
        setCookie("s_btnEur", true, 5);
        setCookie("s_btnUsd", false, 5);
        setCookie("s_btnRub", false, 5);
        settingsApply();
    });
    $('#rub').on('click', function () {
        settings.btnRub = true;
        settings.btnUsd = false;
        settings.btnEur = false;
        setCookie("s_btnRub", true, 5);
        setCookie("s_btnUsd", false, 5);
        setCookie("s_btnEur", false, 5);
        settingsApply();
    });


    $("a.navicon-button").click(function () {
        $(this).toggleClass("open");
    });


    $('.btn-left').on('click', function () {
        settings.btnBuy = true;
        settings.btnSell = false;
        setCookie("s_btnBuy", true, 5);
        setCookie("s_btnSell", false, 5);
        settingsApply();
    });

    function btnLeftClick(column) {
        table.order([column, 'asc']).draw();
    };

    $('.btn-right').on('click', function () {
        settings.btnBuy = false;
        settings.btnSell = true;
        setCookie("s_btnBuy", false, 5);
        setCookie("s_btnSell", true, 5);
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

            // Добавляем коллекцию на карту.
            myMap.geoObjects.removeAll();
            myMap.geoObjects.add(bobrBy);
            myMap.geoObjects.add(usdSell);
            // Устанавливаем карте центр и масштаб так, чтобы охватить коллекцию целиком.
            myMap.setBounds(usdSell.getBounds());
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

            // Добавляем коллекцию на карту.
            myMap.geoObjects.removeAll();
            myMap.geoObjects.add(bobrBy);
            myMap.geoObjects.add(usdBuy);
            // Устанавливаем карте центр и масштаб так, чтобы охватить коллекцию целиком.
            myMap.setBounds(usdBuy.getBounds());
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

            // Добавляем коллекцию на карту.
            myMap.geoObjects.removeAll();
            myMap.geoObjects.add(bobrBy);
            myMap.geoObjects.add(eurSell);
            // Устанавливаем карте центр и масштаб так, чтобы охватить коллекцию целиком.
            myMap.setBounds(eurSell.getBounds());
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

            // Добавляем коллекцию на карту.
            myMap.geoObjects.removeAll();
            myMap.geoObjects.add(bobrBy);
            myMap.geoObjects.add(eurBuy);
            // Устанавливаем карте центр и масштаб так, чтобы охватить коллекцию целиком.
            myMap.setBounds(eurBuy.getBounds());
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

            // Добавляем коллекцию на карту.
            myMap.geoObjects.removeAll();
            myMap.geoObjects.add(bobrBy);
            myMap.geoObjects.add(rubSell);
            // Устанавливаем карте центр и масштаб так, чтобы охватить коллекцию целиком.
            myMap.setBounds(rubSell.getBounds());
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

            // Добавляем коллекцию на карту.
            myMap.geoObjects.removeAll();
            myMap.geoObjects.add(bobrBy);
            myMap.geoObjects.add(rubBuy);
            // Устанавливаем карте центр и масштаб так, чтобы охватить коллекцию целиком.
            myMap.setBounds(rubBuy.getBounds());
        }

        $(".number").val(settings.number);

        //Отключил!!!
        //showInfoBank();

        //console.log('Настройки в функции:');
        //console.log(settings);

    };


    //ЯндексКарты

    function init() {
        myMap = new ymaps.Map("map", {
            center: [53.139563, 29.219260],
            zoom: 12
        });

// Создаем коллекцию геообъектов и задаем опции.
        usdBuy = new ymaps.GeoObjectCollection({}, {
            preset: "islands#darkGreenStretchyIcon",
            strokeWidth: 4,
            geodesic: true
        });
        usdSell = new ymaps.GeoObjectCollection({}, {
            preset: "islands#darkGreenStretchyIcon",
            strokeWidth: 4,
            geodesic: true
        });
        eurBuy = new ymaps.GeoObjectCollection({}, {
            preset: "islands#lightBlueStretchyIcon",
            strokeWidth: 4,
            geodesic: true
        });
        eurSell = new ymaps.GeoObjectCollection({}, {
            preset: "islands#lightBlueStretchyIcon",
            strokeWidth: 4,
            geodesic: true
        });
        rubBuy = new ymaps.GeoObjectCollection({}, {
            preset: "islands#redStretchyIcon",
            strokeWidth: 4,
            geodesic: true
        });
        rubSell = new ymaps.GeoObjectCollection({}, {
            preset: "islands#redStretchyIcon",
            strokeWidth: 4,
            geodesic: true
        });
        bobrBy = new ymaps.GeoObjectCollection({}, {
            preset: "islands#grayStretchyIcon",
            strokeWidth: 4,
            geodesic: true
        });

// Добавляем в коллекцию метки.

        bobrBy.add(new ymaps.Placemark(["53.13789", "29.22835"], {
            iconContent: "BOBR.by",
            balloonContentHeader: "Офис BOBR.by",
            balloonContentFooter: "График работы офиса: с 9.00 до 17.30, пятница до 17.00, выходной: суббота, воскресенье.",
            hintContent: "Подробнее о нас",
            balloonContentBody: [
                '<address>',
                '<strong>Адрес</strong>',
                ' ул. Карла Либкнехта, 25',
                '<br/>',
                '<strong>Телефоны</strong>',
                ' (0225) <a href="tel:+375225707044">70-70-44</a> (гор.), (029) <a href="tel:+375291205550">120-55-50</a> (vel)',
                '<br/>',
                '<strong>E-mail</strong>',
                ' <a href="mailto:admin@bobr.by">admin@bobr.by</a>',
                '</address>'
            ].join('')
        }));


        $.each(tableArr, function (key, element) {

            var latlng = element.latlng.split(',');

            var placemark_usdBuy = new ymaps.Placemark([latlng[0], latlng[1]]);
            usdBuy.add(placemark_usdBuy);

            var placemark_usdSell = new ymaps.Placemark([latlng[0], latlng[1]]);
            usdSell.add(placemark_usdSell);

            var placemark_eurBuy = new ymaps.Placemark([latlng[0], latlng[1]]);
            eurBuy.add(placemark_eurBuy);

            var placemark_eurSell = new ymaps.Placemark([latlng[0], latlng[1]]);
            eurSell.add(placemark_eurSell);

            var placemark_rubBuy = new ymaps.Placemark([latlng[0], latlng[1]]);
            rubBuy.add(placemark_rubBuy);

            var placemark_rubSell = new ymaps.Placemark([latlng[0], latlng[1]]);
            rubSell.add(placemark_rubSell);

        });

        $(".spinner-show").hide();
        $(".button-show").show();
        $(".table-show").show();
        $(".google-play-show").show();
        $(".map").addClass('map-show');
        $(".wrapper-chart").css("opacity", "1");
    }

    setTimeout(function () {
        var find = $(".dataTables_empty").html();
        if (find == "В таблице отсутствуют данные") {

            console.log("В таблице отсутствуют данные");
        }
    }, 3000);

    function placemarkHoverSelect() {


        table.page.len(tableArr.length).draw(); //50
        $.each(tableArr, function (key, element) {

            var latlng = element.latlng.split(',');

            var usd_buy = (Math.round(element.usd_buy * 10000) / 10000 );
            var usd_sell = (Math.round(element.usd_sell * 10000) / 10000 );
            var eur_buy = (Math.round(element.eur_buy * 10000) / 10000 );
            var eur_sell = (Math.round(element.eur_sell * 10000) / 10000 );
            var rub_buy = (Math.round(element.rub_buy * 10000) / 10000 );
            var rub_sell = (Math.round(element.rub_sell * 10000) / 10000 );

            var placemark_usdBuy = new ymaps.Placemark([latlng[0], latlng[1]], {
                iconContent: usd_buy,
                balloonContentBody: [
                    '<address>',
                    '<img src="/admin/files/img/ico/' + element.ico + '" alt="Иконка ' + element.name + '"> <strong>' + element.name + '</strong>',
                    '<br/>',
                    element.address,
                    '<br/>',
                    'Подробнее: <a href="' + element.url + '" target="_blank">о банке</a>',
                    '</address>'
                ].join('')
            });

            $('#myTable').find('[data-bank="' + element.id + '"]').on('mouseenter', function () {
                    placemark_usdBuy.options.set('preset', 'islands#orangeStretchyIcon');
                    placemark_usdBuy.options.set('zIndex', 1000);
                })
                .on('mouseleave', function () {
                    placemark_usdBuy.options.unset('preset');
                    placemark_usdBuy.options.unset('zIndex');
                });

            usdBuy.add(placemark_usdBuy);


            var placemark_usdSell = new ymaps.Placemark([latlng[0], latlng[1]], {
                iconContent: usd_sell,
                balloonContentBody: [
                    '<address>',
                    '<img src="/admin/files/img/ico/' + element.ico + '" alt="Иконка ' + element.name + '"> <strong>' + element.name + '</strong>',
                    '<br/>',
                    element.address,
                    '<br/>',
                    'Подробнее: <a href="' + element.url + '" target="_blank">о банке</a>',
                    '</address>'
                ].join('')
            });

            $('#myTable').find('[data-bank="' + element.id + '"]').on('mouseenter', function () {
                    placemark_usdSell.options.set('preset', 'islands#orangeStretchyIcon');
                    placemark_usdSell.options.set('zIndex', 1000);
                })
                .on('mouseleave', function () {
                    placemark_usdSell.options.unset('preset');
                    placemark_usdSell.options.unset('zIndex');
                });

            usdSell.add(placemark_usdSell);


            var placemark_eurBuy = new ymaps.Placemark([latlng[0], latlng[1]], {
                iconContent: eur_buy,
                balloonContentBody: [
                    '<address>',
                    '<img src="/admin/files/img/ico/' + element.ico + '" alt="Иконка ' + element.name + '"> <strong>' + element.name + '</strong>',
                    '<br/>',
                    element.address,
                    '<br/>',
                    'Подробнее: <a href="' + element.url + '" target="_blank">о банке</a>',
                    '</address>'
                ].join('')
            });

            $('#myTable').find('[data-bank="' + element.id + '"]').on('mouseenter', function () {
                    placemark_eurBuy.options.set('preset', 'islands#orangeStretchyIcon');
                    placemark_eurBuy.options.set('zIndex', 1000);
                })
                .on('mouseleave', function () {
                    placemark_eurBuy.options.unset('preset');
                    placemark_eurBuy.options.unset('zIndex');
                });

            eurBuy.add(placemark_eurBuy);


            var placemark_eurSell = new ymaps.Placemark([latlng[0], latlng[1]], {
                iconContent: eur_sell,
                balloonContentBody: [
                    '<address>',
                    '<img src="/admin/files/img/ico/' + element.ico + '" alt="Иконка ' + element.name + '"> <strong>' + element.name + '</strong>',
                    '<br/>',
                    element.address,
                    '<br/>',
                    'Подробнее: <a href="' + element.url + '" target="_blank">о банке</a>',
                    '</address>'
                ].join('')
            });

            $('#myTable').find('[data-bank="' + element.id + '"]').on('mouseenter', function () {
                    placemark_eurSell.options.set('preset', 'islands#orangeStretchyIcon');
                    placemark_eurSell.options.set('zIndex', 1000);
                })
                .on('mouseleave', function () {
                    placemark_eurSell.options.unset('preset');
                    placemark_eurSell.options.unset('zIndex');
                });

            eurSell.add(placemark_eurSell);


            var placemark_rubBuy = new ymaps.Placemark([latlng[0], latlng[1]], {
                iconContent: rub_buy,
                balloonContentBody: [
                    '<address>',
                    '<img src="/admin/files/img/ico/' + element.ico + '" alt="Иконка ' + element.name + '"> <strong>' + element.name + '</strong>',
                    '<br/>',
                    element.address,
                    '<br/>',
                    'Подробнее: <a href="' + element.url + '" target="_blank">о банке</a>',
                    '</address>'
                ].join('')
            });

            $('#myTable').find('[data-bank="' + element.id + '"]').on('mouseenter', function () {
                    placemark_rubBuy.options.set('preset', 'islands#orangeStretchyIcon');
                    placemark_rubBuy.options.set('zIndex', 1000);
                })
                .on('mouseleave', function () {
                    placemark_rubBuy.options.unset('preset');
                    placemark_rubBuy.options.unset('zIndex');
                });

            rubBuy.add(placemark_rubBuy);


            var placemark_rubSell = new ymaps.Placemark([latlng[0], latlng[1]], {
                iconContent: rub_sell,
                balloonContentBody: [
                    '<address>',
                    '<img src="/admin/files/img/ico/' + element.ico + '" alt="Иконка ' + element.name + '"> <strong>' + element.name + '</strong>',
                    '<br/>',
                    element.address,
                    '<br/>',
                    'Подробнее: <a href="' + element.url + '" target="_blank">о банке</a>',
                    '</address>'
                ].join('')
            });

            $('#myTable').find('[data-bank="' + element.id + '"]').on('mouseenter', function () {
                    placemark_rubSell.options.set('preset', 'islands#orangeStretchyIcon');
                    placemark_rubSell.options.set('zIndex', 1000);
                })
                .on('mouseleave', function () {
                    placemark_rubSell.options.unset('preset');
                    placemark_rubSell.options.unset('zIndex');
                });

            rubSell.add(placemark_rubSell);

        });
        table.page.len(11).draw();
    }


    function banksChartGet(idBank, currency, period) {

        $.ajax({
            type: "POST",
            url: "index.php",
            dataType: "json",
            data: {AjaxAction: "ChartInfoGet", AjaxIdBank: idBank, AjaxCurrency: currency, AjaxPeriod: period}
        }).done(function (result) {

            if ($.isEmptyObject(result)) {
                console.log('Завершаем работу. Пустой объект JSON');
                return;
            }

            var ChartArr = result;

            // console.log(ChartArr.graph_time);
            // console.log(ChartArr.graph_buy);
            // console.log(ChartArr.graph_sell);

            mainChartUpdate(ChartArr);

        }).fail(function () {
            console.log('Что-то пошло не так. Повторите позже.');
        });
    }

    var mainChart = new Chart($('#main-chart'), {
        type: 'line',
        options: {
            maintainAspectRatio: false,
            legend: {
                position: 'bottom'
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        color: 'transparent',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        fontSize: 10,
                        display: false
                    }
                }],
                yAxes: [{
                    gridLines: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        fontSize: 10,
                        display: true
                    }
                }]
            },
            elements: {
                line: {
                    borderWidth: 1
                },
                point: {
                    radius: 4,
                    hitRadius: 10,
                    hoverRadius: 4
                }
            }
        }
    });

    function mainChartUpdate(ChartArr) {

        mainChart.data.labels = ChartArr.graph_time;

        mainChart.data.datasets[0] = {
            label: 'Покупка',
            backgroundColor: 'transparent',
            borderColor: getStyle('--info'),
            pointHoverBackgroundColor: '#fff',
            pointBackgroundColor: '#fff',
            data: ChartArr.graph_buy
        };

        mainChart.data.datasets[1] = {
            label: 'Продажа',
            borderDash: [5, 5],
            backgroundColor: 'transparent',
            borderColor: getStyle('--success'),
            pointHoverBackgroundColor: '#fff',
            pointBackgroundColor: '#fff',
            data: ChartArr.graph_sell
        };

        mainChart.update();

    }


    $(".dropdown-menu .dropdown-item").on("click", function () {

        var periodText = $(this).text();
        var period = $(this).data("period");
        $(this).parent().parent().find("button").text(periodText);
        $(this).parent().parent().find("button").data("period", period);

        getDataSearchFormChart();
    });

    $('#basic').on('change', function () {
        getDataSearchFormChart();
    });

    $("label").on("click", function () {
        setTimeout(function () {
            getDataSearchFormChart();
        }, 100)
    });

    function getDataSearchFormChart() {

        tableArr.sort(function (a, b) {
            if (a.name < b.name) return -1;
            if (a.name > b.name) return 1;
            return 0;
        });

        $.each(tableArr, function (key, element) {

            $("select.selectpicker").append("<option value=\"" + element.id + "\">" + element.name + "</option>").selectpicker('refresh');

            if ($('#basic').val() == element.id) {
                var reg = /Адрес: (.*?) Тел.:/;
                var address = element.address.split(reg);
                $(".address").html(address[1]);
            }
        });


        var period = $(".graph-btn button").data("period");
        var idBank = $('#basic').val();
        var currency = $(".graph-btn input:checked").val();

        //console.log('id банка: ' + idBank + ' Валюта: ' + currency + ' Период: ' + period);


        banksChartGet(idBank, currency, period);

    }

    setTimeout(function () {
        $(".message-wrapper").slideDown(300);
    }, 600000);

    $('#reload').on('click', function () {
        document.getElementById('reload-wrapper').setAttribute('style', 'display: none;');
        location.reload();
    });

    $('.show-classic').on('click', function () {

        setCookie("show_view", "classic", 30);
        window.location.href = "/?classic=show";
    });


});


function messageSend(banks_id, text) {

    $.ajax({
        type: "POST",
        url: "index.php",
        dataType: "json",
        data: {AjaxAction: "Message", AjaxText: text, AjaxBanksId: banks_id}
    }).done(function (result) {
        console.log(result);

        if ($.isEmptyObject(result)) {
            console.log('Завершаем работу. Пустой объект JSON');
            return;
        }

        swal({
            type: 'success',
            title: 'Ваше сообщение отправлено',
            timer: 2500
        });

    }).fail(function () {

        swal({
            type: 'error',
            title: 'Ошибка отправки',
            timer: 2500
        });

        console.log('Что-то пошло не так. Повторите позже.');
    });
}


function infoMessage(banks_id, name, address, usd_buy, usd_sell, eur_buy, eur_sell, rub_buy, rub_sell) {
    console.log('TEST');

    swal.mixin({
        confirmButtonText: 'Дальше &rarr;',
        showCancelButton: false,
        showCloseButton: true,
        progressSteps: ['<i class="fas fa-dollar-sign">', '<i class="fas fa-euro-sign">', '<i class="fas fa-ruble-sign">']
    }).queue([
        {
            title: name,
            html:
            '<small>Адрес: ' + address + '</small><br><br>' +
            'Курс покупки: ' + usd_buy + '<br>' +
            'Курс продажи: ' + usd_sell,
            input: 'checkbox',
            inputValue: 0,
            inputPlaceholder: 'Подтверждаю, что курс <i class="fas fa-dollar-sign"></i> ошибочный'
        },
        {
            title: name,
            html:
            '<small>Адрес: ' + address + '</small><br><br>' +
            'Курс покупки: ' + eur_buy + '<br>' +
            'Курс продажи: ' + eur_sell,
            input: 'checkbox',
            inputValue: 0,
            inputPlaceholder: 'Подтверждаю, что курс <i class="fas fa-euro-sign"></i> ошибочный'
        },
        {
            title: name,
            html:
            '<small>Адрес: ' + address + '</small><br><br>' +
            'Курс покупки: ' + rub_buy + '<br>' +
            'Курс продажи: ' + rub_sell,
            input: 'checkbox',
            inputValue: 0,
            inputPlaceholder: 'Подтверждаю, что курс <i class="fas fa-ruble-sign"></i> ошибочный'
        },
        {
            title: 'Оставьте свои замечания',
            text: 'поле можно оставить пустым',
            input: 'textarea',
            inputPlaceholder: 'Можете указать верный курс в банке, либо просто оставить поле пустым...',
            confirmButtonText: 'Сообщить!'
        }
    ]).then(function (result) {

        if (result.value) {

            var msg = "Сообщаю, что на вашем сайте ";
            msg += "курсы покупки/продажи USD составляют " + usd_buy + " / " + usd_sell;
            if (result.value[0]) {
                msg += " и это не верные курсы! ";
            } else {
                msg += " и это верные курсы. ";
            }
            msg += "Курсы покупки/продажи EUR составляют " + eur_buy + " / " + eur_sell;
            if (result.value[1]) {
                msg += " и это не верные курсы! ";
            } else {
                msg += " и это верные курсы. ";
            }
            msg += "Курсы покупки/продажи RUB составляют " + rub_buy + " / " + rub_sell;
            if (result.value[2]) {
                msg += " и это не верные курсы! ";
            } else {
                msg += " и это верные курсы. ";
            }
            if (result.value[3]) {
                var text = result.value[3].replace(/\r?\n/g, " ");
                msg += "Дополнительно хочу сообщить: " + text;
            }
            console.log(banks_id + '' + msg);

            messageSend(banks_id, msg);
        }
    })
}


