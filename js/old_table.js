;

$(function () {

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

           // console.log(result);

            var usd_buy_arr = [];
            var usd_sell_arr = [];
            var eur_buy_arr = [];
            var eur_sell_arr = [];
            var rub_buy_arr = [];
            var rub_sell_arr = [];

            $.each(result, function (key, element) {

                var usd_buy = (Math.round(element.usd_buy * 10000) / 10000 );
                var usd_sell = (Math.round(element.usd_sell * 10000) / 10000 );
                var eur_buy = (Math.round(element.eur_buy * 10000) / 10000 );
                var eur_sell = (Math.round(element.eur_sell * 10000) / 10000 );
                var rub_buy = (Math.round(element.rub_buy * 10000) / 10000 );
                var rub_sell = (Math.round(element.rub_sell * 10000) / 10000 );

                usd_buy_arr.push(usd_buy);
                usd_sell_arr.push(usd_sell);
                eur_buy_arr.push(eur_buy);
                eur_sell_arr.push(eur_sell);
                rub_buy_arr.push(rub_buy);
                rub_sell_arr.push(rub_sell);

                var reg = /Адрес: (.*?) Тел.:/;
                var address = element.address.split(reg);

                $("#myTable").tablesorter({
                    theme: 'blue'
                });

                $("#myTable tbody").append('<tr>' +
                    '<td data-id-bank="' + element.banks_id + '"><a href="' + element.url + '" target="_blank"><img src="/admin/files/img/ico/' + element.ico + '" alt="Иконка ' + element.name + '">' + element.name + '</a>' +
                    '<div data-info="info" class="address" data-id="' + element.banks_id + '">Адрес: ' + address[1] + '<br>Тел.:' + address[2] + '<br><span>Банк обновлял курсы: <time>' + element.time + '</time></span>' +
                    '</div>' +
                    '</td>' +
                    '<td class="usd-buy">' + usd_buy + '</td>' +
                    '<td class="usd-sale">' + usd_sell + '</td>' +
                    '<td class="eur-buy">' + eur_buy + '</td>' +
                    '<td class="eur-sale">' + eur_sell + '</td>' +
                    '<td class="rur-buy">' + rub_buy + '</td>' +
                    '<td class="rur-sale">' + rub_sell + '</td>' +
                    '</tr>');

            });

            Array.max = function( array ){
                return Math.max.apply( Math, array );
            };
            Array.min = function( array ){
                return Math.min.apply( Math, array );
            };

            var usd_buy_max = Array.max(usd_buy_arr);
            var usd_sell_min = Array.min(usd_sell_arr);
            var eur_buy_max = Array.max(eur_buy_arr);
            var eur_sell_min = Array.min(eur_sell_arr);
            var rub_buy_max = Array.max(rub_buy_arr);
            var rub_sell_min = Array.min(rub_sell_arr);

            var min_max_arr = [];
            min_max_arr.push(usd_buy_max);
            min_max_arr.push(usd_sell_min);
            min_max_arr.push(eur_buy_max);
            min_max_arr.push(eur_sell_min);
            min_max_arr.push(rub_buy_max);
            min_max_arr.push(rub_sell_min);

            $("#myTable").trigger("update");
            var sorting = [[0, 0]];
            $("#myTable").trigger("sorton", [sorting]);


            $(".cent").removeClass('tablesorter-header').css('background-color', '#e6EEEE');

            minmax(min_max_arr);

            $("img.load").hide();
            $("#myTable").show();

        }).fail(function () {
            console.log('Что-то пошло не так. Повторите позже.');
        });
    }

    banksTableGet();

    $("a.navicon-button").click(function () {
        $(this).toggleClass("open");
    });

    function minmax(min_max_arr) {

            $(".tablesorter").tablesorter();

            $('.usd-buy').each(function (i, elem) {
                if (parseFloat(min_max_arr[0]) == parseFloat($(this).html())) {
                    try {
                        $(this).css("background-color", "#D0D98B");
                        $(this).css("font-weight", "bold");
                    } catch (e) {
                    }
                }
            });

            $('.usd-sale').each(function (i, elem) {
                if (parseFloat(min_max_arr[1]) == parseFloat($(this).html())) {
                    try {
                        $(this).css("background-color", "#D0D98B");
                        $(this).css("font-weight", "bold");
                    } catch (e) {
                    }
                }
            });

            $('.eur-buy').each(function (i, elem) {
                if (parseFloat(min_max_arr[2]) == parseFloat($(this).html())) {
                    try {
                        $(this).css("background-color", "#D0D98B");
                        $(this).css("font-weight", "bold");
                    } catch (e) {
                    }
                }
            });

            $('.eur-sale').each(function (i, elem) {
                if (parseFloat(min_max_arr[3]) == parseFloat($(this).html())) {
                    try {
                        $(this).css("background-color", "#D0D98B");
                        $(this).css("font-weight", "bold");
                    } catch (e) {
                    }
                }
            });

            $('.rur-buy').each(function (i, elem) {
                if (parseFloat(min_max_arr[4]) == parseFloat($(this).html())) {
                    try {
                        $(this).css("background-color", "#D0D98B");
                        $(this).css("font-weight", "bold");
                    } catch (e) {
                    }
                }
            });

            $('.rur-sale').each(function (i, elem) {
                if (parseFloat(min_max_arr[5]) == parseFloat($(this).html())) {
                    try {
                        $(this).css("background-color", "#D0D98B");
                        $(this).css("font-weight", "bold");
                    } catch (e) {
                    }
                }
            });
    }

    $('.show-new').on('click', function () {
        deleteCookie("show_view");
        window.location.href = "/";
    });
});
