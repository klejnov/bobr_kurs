function authjs() {
    var l = $('#login').val();
    var p = $('#password').val();

    $.post('index.php?action=authpost',
        {login:l, password:p},
        function (data) {
        },
        'json'
    )
        .fail(function () {
            alertify.error('Ошибка отправки формы');
        })
        .done(function (data) {
            if (data.result == false) {
                alertify.error('Неправильный логин или пароль');
            } else {
                window.location.href = "index.php";
            }
        });
}

 function edituser() {

//     var login_user_js = $('#login_user').val();
//     var name_user_js = $('#name_user').val();
//
//     $.post('index.php?action=polzovatel',
//         {login_user_php:login_user_js,name_user_php:name_user_js},
//         function (data) {
//         },
//         'json'
//     )
//         .fail(function () {
//             alertify.error('Ошибка отправки формы');
//         })
//         .done(function (data) {
//             if (data.result == false) {
//                 alertify.error('Неправильно введен логин или имя. Скорее всего такой логин уже есть');
//             } else {
//                 alertify.success('Данные сохранены');
//                 setTimeout('window.location.href = "index.php?action=edituser"', 2000);
//             }
//         });

     var formData = new FormData();
     formData.append('login_user_js', $('#login_user').val());
     formData.append('name_user_js', $('#name_user').val());
// Attach file
     formData.append('file', $('input[type=file]')[0].files[0]);
     $.ajax({
         url: 'index.php?action=polzovatel',
         type: 'POST',
         data: formData,
         async: false,
         dataType: 'json',
         success: function (data) {
                if (data.result == false) {
                alertify.error('Неправильно введен логин или имя. Скорее всего такой логин уже есть');
            } else {
                alertify.success('Данные сохранены');
                setTimeout('window.location.href = "index.php?action=edituser"', 2000);
            }
         },
         cache: false,
         contentType: false,
         processData: false
     });
}

function delbank(del_id_bank) {
    alertify.confirm("Вы точно хотите удалить?", function () {
        $.post('index.php?action=delbank',
            {del_id_bankphp:del_id_bank},
            function (data) {
            },
            'json'
        )
            .fail(function () {
                alertify.error('Ошибка отправки формы. У вас нет прав на удаление');
            })
            .done(function (data) {
                if (data.result == false) {
                    window.location.href = "index.php?action=auth";
                } else {
                    window.location.href = "index.php?action=bank";
                }
            });

    }, function() {
        alertify.success('А жаль');
    });
}

function editbank() {
    // var name_bankjs = $('#name_bank').val();
    // var latlng_bankjs = $('#latlng_bank').val();
    // var url_bankjs = $('#url_bank').val();
    // var address_bankjs = $('#address_bank').val();
    // var id = gup('id');
    // var auto = $("#auto").prop('checked')
    //     $.post('index.php?action=editbankpost',
    //     {namebankphp:name_bankjs,idphp:id,autophp:auto,latlngphp:latlng_bankjs,urlphp:url_bankjs,addressphp:address_bankjs},
    //     function (data) {
    //     },
    //     'json'
    // )
    //     .fail(function () {
    //         alertify.error('Ошибка отправки формы');
    //     })
    //     .done(function (data) {
    //         if (data.result == false) {
    //             window.location.href = "index.php?action=auth";
    //         } else {
    //             window.location.href = "index.php?action=bank";
    //         }
    //     });

    var formData = new FormData();
    formData.append('name_bankjs', $('#name_bank').val());
    formData.append('latlng_bankjs', $('#latlng_bank').val());
    formData.append('url_bankjs', $('#url_bank').val());
    formData.append('address_bankjs', $('#address_bank').val());
    formData.append('id', gup('id'));
    formData.append('auto', $("#auto").prop('checked'));
    formData.append('icojs', $('select[id=ico_select]').val());
    formData.append('url_parser_bankjs', $('#url_parser_bank').val());
    formData.append('note_bankjs', $('#note_bank').val());

// Attach file
    formData.append('file', $('input[type=file]')[0].files[0]);
    $.ajax({
        url: 'index.php?action=editbankpost',
        type: 'POST',
        data: formData,
        async: false,
        dataType: 'json',
        success: function (data) {
            alertify.parent(document.body);
            if (data.result == false) {
                window.location.href = "index.php?action=auth";
            } else {
                alertify.success('Данные сохранены');
                setTimeout('window.location.href = "index.php?action=bank"', 2000);
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function gup(name, url) {
    if (!url) url = location.href
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&#]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( url );
    return results == null ? null : results[1];
}

function editkurs(id_bankjs, th) {
    var usd_buy = $(th).parent().parent().find('.usd_buy').val();
    var usd_sell = $(th).parent().parent().find('.usd_sell').val();
    var eur_buy = $(th).parent().parent().find('.eur_buy').val();
    var eur_sell = $(th).parent().parent().find('.eur_sell').val();
    var rub_buy = $(th).parent().parent().find('.rub_buy').val();
    var rub_sell = $(th).parent().parent().find('.rub_sell').val();

    $.post('index.php?action=editkurs',
        {id_bankphp:id_bankjs,usd_buyphp:usd_buy,usd_sellphp:usd_sell,eur_buyphp:eur_buy,
            eur_sellphp:eur_sell,rub_buyphp:rub_buy,rub_sellphp:rub_sell},
        function (data) {
        },
        'json'
    )
        .fail(function () {
            alertify.error('Ошибка отправки формы');
        })
        .done(function (data) {
            if (data.result == false) {
                window.location.href = "index.php?action=auth";
            } else {
                alertify.success('Данные сохранены');
            }
        });
}

//Функция по выбору банка и получения его ID и получения периода
function banksstats(period) {
    var bank_id = $('select[id=selectbank]').val();
    window.location.href = "index.php?action=stats&bank=" + bank_id + "&period=" + period;
}
$( document ).ready(function() {
    $('#selectbank').on('change', function() {
        banksstats('day');
    })

    alertify.parent(document.body);

// Функция отлавливает выбор из формы выбора списка иконок
    $('#ico_select').on('change', function() {
        //alert ($(this).val());
        if ($(this).val() == 1) {
            $('#hide_file').show();
            } else {
            $('#hide_file').hide();
        }
    })
});


