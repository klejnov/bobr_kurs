<?php

define('DS', DIRECTORY_SEPARATOR);

$config = require "config.php";

/**
 * Автоматическая загрузка классов
 */

spl_autoload_register(function ($class_name) {

    $patchFile = __DIR__ . DS . '../classes' . DS . $class_name . '.php';

    if (!file_exists($patchFile)) {
        echo "Файла с классом $class_name нет";
        die();
    }
    include $patchFile;
});


$db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'], $config['username'],
    $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

function authuser($func_login, $func_password)
{
    global $db;
    $query = $db->prepare(
        "SELECT id,
                    role,
                    name,
                    avatar,
                    password        
                FROM user
                WHERE login = :sql_login"
    );
    $query->execute(array(
        'sql_login' => $func_login,
    ));
    $data = $query->fetch(PDO::FETCH_ASSOC);

    if (password_verify($func_password, $data['password'])) {
        return $data;
    } else {
        return false;
    }

    //для генерации пароля к новому пользователю:
    //    $options = [
    //        'cost' => 11,
    //    ];
    //    echo password_hash("pass", PASSWORD_BCRYPT, $options);

}

// Функция возвращает имя, avatar и id
function userinfo($func_id)
{
    global $db;
    $query = $db->prepare(
        "SELECT id, 
                name,
                login,
                avatar,
                role        
                FROM user 
                WHERE id = :sql_id"
    );
    $query->execute(array(
        'sql_id' => $func_id,
    ));
    $data = $query->fetch(PDO::FETCH_ASSOC);

    return $data;
}

// Функция меняем имя, логин или аватарку
function edituser($func_id, $func_login, $func_name, $func_avatar)
{
    //echo $func_name;
    global $db;
    $avatar_mysql = '';
    if ($func_avatar) {
        $avatar_mysql = ', avatar = :sql_avatar';
    }
    $avatar_arr = array();
    if ($func_avatar) {
        $avatar_arr = array('sql_avatar' => $func_avatar,);
    }
    $query = $db->prepare(
        "SELECT id
                FROM user 
                WHERE login = :sql_login AND id <> :sql_id"
    );
    $query->execute(array(
        'sql_login' => $func_login,
        'sql_id'    => $func_id,
    ));
    $data = $query->fetch(PDO::FETCH_ASSOC);
    //При одинаковых логинах в data запишется одномерный массив с id пользователя.
    //При разных логинах вернется null
    //Далее делаю условие если не массив, то выполняю update.
    if (!$data) {
        $query = $db->prepare(
            "UPDATE user
                    SET name = :sql_name, login = :sql_login $avatar_mysql
                    WHERE id = :sql_id"
        );
        $query->execute(array(
                            'sql_name'  => $func_name,
                            'sql_login' => $func_login,
                            'sql_id'    => $func_id,
                        ) + $avatar_arr);
        //$data = $query->fetch(PDO::FETCH_ASSOC);
        return true;
    } else {
        return false;
    }
}

function lastLoginUser($user_id) {

    global $db;

    $query = $db->prepare(
        "UPDATE user
                    SET logined_at = NOW()
                    WHERE id = :sql_user_id"
    );
    $query->execute(array(
        'sql_user_id' => $user_id,
    ));
}

// Функция добавляем банк
function addbank(
    $func_name, $func_auto, $func_latlng, $func_url, $func_address, $func_ico_bank, $func_url_parser, $func_note
) {
    //echo $func_name;
    global $db;
//    $ico_mysql = ', (NULL)';
//    if ($func_ico_bank) {
//        $ico_mysql = ', :sql_ico_bank';
//    }
//    $ico_arr = array();
//    if ($func_ico_bank) {
//        $ico_arr = array('sql_ico_bank' => $func_ico_bank,);
//    }
    $query = $db->prepare(
        "INSERT INTO 
              banks (name, auto, latlng, url, address, ico, url_parser, note) 
              VALUES (:sql_name, :sql_auto, :sql_latlng, :sql_url, :sql_address, :sql_ico_bank, :sql_url_parser, :sql_note);"
    );
    $query->execute(array(
        'sql_name'       => $func_name,
        'sql_auto'       => $func_auto,
        'sql_latlng'     => $func_latlng,
        'sql_url'        => $func_url,
        'sql_address'    => $func_address,
        'sql_ico_bank'   => $func_ico_bank,
        'sql_url_parser' => $func_url_parser,
        'sql_note'       => $func_note,
    ));
    //$data = $query->fetch(PDO::FETCH_ASSOC);
}

// Функция возвращает имя и id банка
function getbanks()
{
    global $db;
    $query = $db->prepare(
        "SELECT * FROM ((SELECT 
                    b.id, 
                    b.name,
                    b.auto,
                    b.ico,
                    b.status,
                    b.url_parser,
                    b.note,
                    bk.usd_buy,
                    bk.usd_sell,
                    bk.eur_buy,
                    bk.eur_sell,
                    bk.rub_buy,
                    bk.rub_sell,
                    bk.banks_id,
                    DATE_FORMAT(bk.time, '%Y-%m-%d %H:%i:%s') AS time
                FROM banks_kurs AS bk
                LEFT JOIN banks AS b ON b.id = bk.banks_id)
                UNION ALL
                (SELECT id,
                name,
                auto,
                ico,
                status,
                url_parser,
                note,
                0,
                0,
                0,
                0,
                0,
                0,                
                id,
                '0000-00-00 00:00:00'
                FROM banks)
                ORDER BY time DESC
                ) AS bk2
                GROUP BY bk2.banks_id ORDER BY bk2.name
                "
    );
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    //print_r($data);
    return $data;
}

// Редактируем банк
function editbank(
    $func_id, $func_name, $func_auto, $func_latlng, $func_url, $func_address, $func_ico_bank, $func_url_parser,
    $func_note
) {
    //echo $func_name;
    global $db;
    $ico_mysql = '';
    if ($func_ico_bank) {
        $ico_mysql = ', ico = :sql_ico_bank';
    }
    $ico_arr = array();
    if ($func_ico_bank) {
        $ico_arr = array('sql_ico_bank' => $func_ico_bank,);
    }
    $query = $db->prepare(
        "UPDATE banks
                SET name = :sql_name, auto = :sql_auto, latlng = :sql_latlng, url = :sql_url, address = :sql_address, url_parser = :sql_url_parser, note = :sql_note $ico_mysql
                WHERE id = :sql_id"
    );
    $query->execute(array(
                        'sql_name'       => $func_name,
                        'sql_id'         => $func_id,
                        'sql_auto'       => $func_auto,
                        'sql_latlng'     => $func_latlng,
                        'sql_url'        => $func_url,
                        'sql_address'    => $func_address,
                        'sql_url_parser' => $func_url_parser,
                        'sql_note'       => $func_note,
                    ) + $ico_arr);
    //$data = $query->fetch(PDO::FETCH_ASSOC);
}

// Функция получаем информацию о банке
function getbanksinfo($func_id)
{
    global $db;
    $query = $db->prepare(
        "SELECT id, 
                name,
                auto,
                latlng,
                url,
                address,
                ico,
                url_parser,
                note
                FROM banks 
                WHERE id = :sql_id"
    );
    $query->execute(array(
        'sql_id' => $func_id,
    ));
    $data = $query->fetch(PDO::FETCH_ASSOC);

    return $data;
}

function delbank($func_dell_bank)
{
    global $db;
    $query2 = $db->prepare(
        "DELETE FROM banks
                WHERE id = :sql_func_db"
    );
    $query2->execute(array(
        'sql_func_db' => $func_dell_bank,
    ));;
}

//заносит курсы с проверкой

function addkurs($data)
{

    //Сравнение курсов со средним значением.

    $filePath = __DIR__ . '/../js/widget.json';

    $arr_news = file_get_contents($filePath);

    $arr_news = json_decode($arr_news, true);

    //var_dump($arr_news);

    $rate = 0.2;

    $avg_usd_buy = $arr_news["current_rate_usd_buy"];
    $avg_usd_sell = $arr_news["current_rate_usd_sell"];
    $avg_eur_buy = $arr_news["current_rate_eur_buy"];
    $avg_eur_sell = $arr_news["current_rate_eur_sell"];
    $avg_rub_buy = $arr_news["current_rate_rub_buy"];
    $avg_rub_sell = $arr_news["current_rate_rub_sell"];

    $avg_usd_buy_min = $avg_usd_buy * (1 - $rate);
    $avg_usd_sell_min = $avg_usd_sell * (1 - $rate);
    $avg_eur_buy_min = $avg_eur_buy * (1 - $rate);
    $avg_eur_sell_min = $avg_eur_sell * (1 - $rate);
    $avg_rub_buy_min = $avg_rub_buy * (1 - $rate);
    $avg_rub_sell_min = $avg_rub_sell * (1 - $rate);

    $avg_usd_buy_max = $avg_usd_buy * (1 + $rate);
    $avg_usd_sell_max = $avg_usd_sell * (1 + $rate);
    $avg_eur_buy_max = $avg_eur_buy * (1 + $rate);
    $avg_eur_sell_max = $avg_eur_sell * (1 + $rate);
    $avg_rub_buy_max = $avg_rub_buy * (1 + $rate);
    $avg_rub_sell_max = $avg_rub_sell * (1 + $rate);

    global $db;
    foreach ($data as $parser_data) {

        if (isset($parser_data['result']) && $parser_data['result'] == "error") {
            continue;
        }

        $query = $db->prepare(
            "UPDATE banks
                    SET status = :sql_status
                    WHERE id = :sql_banks_id"
        );
        $query->execute(array(
            'sql_status'   => $parser_data['status'],
            'sql_banks_id' => $parser_data['banks_id'],
        ));

        $html = $parser_data['html'];
        $id_bank = $parser_data['banks_id'];

        if ($_SERVER['SCRIPT_FILENAME'] == "/var/www/kurs.bobr.by/admin/cron.php" && $parser_data['status'] == 1) {
            $html = 'Курсы получены';
        }
        if ($_SERVER['SCRIPT_FILENAME'] == "/var/www/kurs.bobr.by/admin/cron.php" && $parser_data['status'] == 0) {
            $html = 'Ошибка получения курсов';
        }

        writeLog($id_bank, $html, 2);

        if ($parser_data['usd_buy'] == 0
            && $parser_data['eur_buy'] == 0
            && $parser_data['rub_buy'] == 0
            && $parser_data['usd_sell'] == 0
            && $parser_data['eur_sell'] == 0
            && $parser_data['rub_sell'] == 0) {
            continue;
        }

        $text = "Курс USD: {$parser_data['usd_buy']} / {$parser_data['usd_sell']}.  Курс EUR: {$parser_data['eur_buy']} / {$parser_data['eur_sell']}.  Курс RUB: {$parser_data['rub_buy']} / {$parser_data['rub_sell']}. ";

        if (($parser_data['usd_buy'] <= $avg_usd_buy_min || $parser_data['usd_buy'] >= $avg_usd_buy_max) ||
            ($parser_data['usd_sell'] <= $avg_usd_sell_min || $parser_data['usd_sell'] >= $avg_usd_sell_max) ||
            ($parser_data['eur_buy'] <= $avg_eur_buy_min || $parser_data['eur_buy'] >= $avg_eur_buy_max) ||
            ($parser_data['eur_sell'] <= $avg_eur_sell_min || $parser_data['eur_sell'] >= $avg_eur_sell_max) ||
            ($parser_data['rub_buy'] <= $avg_rub_buy_min || $parser_data['rub_buy'] >= $avg_rub_buy_max) ||
            ($parser_data['rub_sell'] <= $avg_rub_sell_min || $parser_data['rub_sell'] >= $avg_rub_sell_max)) {

            writeLog($id_bank, $text, 1);

            $telegram_msg = new TelegramBot();
            $telegram_msg->sendMessageTelegramBot("Банк прислал курсы, выходящие за пределы среднего курса:\n$text\nВставка некорректных значений отменена\n<a href='https://kurs.bobr.by/admin/'>Посмотреть</a>");

            continue;
        }

        $query2 = $db->prepare(
            "SELECT usd_buy, usd_sell, eur_buy, eur_sell, rub_buy, rub_sell          
                FROM banks_kurs
                WHERE banks_id = :sql_banks_id
                ORDER BY time DESC"
        );
        $query2->execute(array(
            'sql_banks_id' => $parser_data['banks_id'],
        ));
        $data2 = $query2->fetch(PDO::FETCH_ASSOC);
        if ($data2['usd_buy'] != $parser_data['usd_buy']
            || $data2['eur_buy'] != $parser_data['eur_buy']
            || $data2['rub_buy'] != $parser_data['rub_buy']
            || $data2['usd_sell'] != $parser_data['usd_sell']
            || $data2['eur_sell'] != $parser_data['eur_sell']
            || $data2['rub_sell'] != $parser_data['rub_sell']) {
            $query = $db->prepare(
                "INSERT INTO 
              banks_kurs (banks_id, usd_buy, usd_sell, eur_buy, eur_sell, rub_buy, rub_sell) 
              VALUES (:sql_banks_id, 
              :sql_usd_buy, 
              :sql_usd_sell, 
              :sql_eur_buy, 
              :sql_eur_sell, 
              :sql_rub_buy, 
              :sql_rub_sell);"
            );
            $query->execute(array(
                'sql_banks_id' => $parser_data['banks_id'],
                'sql_usd_buy'  => $parser_data['usd_buy'],
                'sql_usd_sell' => $parser_data['usd_sell'],
                'sql_eur_buy'  => $parser_data['eur_buy'],
                'sql_eur_sell' => $parser_data['eur_sell'],
                'sql_rub_buy'  => $parser_data['rub_buy'],
                'sql_rub_sell' => $parser_data['rub_sell'],
            ));
        }
    }
    //print_r($parser_data);
    //fetch нужен только при SELECT!!!
    //$data = $query->fetch(PDO::FETCH_ASSOC);
}

function writeLog($id_bank, $html, $type_log)
{
    global $db;

    /**
     * 1 - limits exceeded (превышены лимиты)
     * 2 - regular log (обычный лог)
     */

    $query = $db->prepare(
        "INSERT INTO 
              banks_kurs_log (id_bank, html, type_log) 
              VALUES (
              :sql_id_bank, 
              :sql_html, 
              :sql_type_log);"
    );
    $query->execute(array(
        'sql_id_bank'  => $id_bank,
        'sql_html'     => $html,
        'sql_type_log' => $type_log,
    ));
}

// Функция получаем все банки
function getbankslist()
{
    global $db;
    $query = $db->prepare(
        "SELECT id, 
                name,
                auto,
                ico    
                FROM banks
                ORDER BY name"
    );
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

// Функция возвращает список курсов в зависимости от периода
function getstats($id_bank, $start, $end)
{
    global $db;
    $query = $db->prepare(
        "SELECT id, 
                DATE_FORMAT(time, '%d.%m.%Y %H:%i:%s') AS time,
                usd_buy,
                usd_sell,  
                eur_buy,
                eur_sell,
                rub_buy,
                rub_sell
                FROM banks_kurs
                WHERE banks_id = :sql_banks_id AND time BETWEEN :sql_start AND :sql_end
                ORDER BY time"
    );
    $query->execute(array(
        'sql_banks_id' => $id_bank,
        'sql_start'    => $start,
        'sql_end'      => $end,
    ));
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    //print_r($data);
    return $data;
}

// Функция возвращает среднесуточное значение курса в зависимости от периода
function getstatsavg($start, $end)
{
    global $db;
    $query = $db->prepare(
        "SELECT DATE_FORMAT(time, '%d.%m') AS time,
                AVG(usd_buy) AS usd_buy,
                AVG(usd_sell) AS usd_sell,  
                AVG(eur_buy) AS eur_buy,
                AVG(eur_sell) AS eur_sell,
                AVG(rub_buy) AS rub_buy,
                AVG(rub_sell) AS rub_sell
                FROM banks_kurs
                WHERE time BETWEEN :sql_start AND :sql_end 
                AND usd_buy <> '0'
                AND usd_sell <> '0'
                AND eur_buy <> '0'
                AND eur_sell <> '0'
                AND rub_buy <> '0'
                AND rub_sell <> '0'
                GROUP BY DATE_FORMAT(time, '%Y-%m-%d')"
    );
    $query->execute(array(
        'sql_start' => $start,
        'sql_end'   => $end,
    ));
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    //print_r($data);
    return $data;
}

function bash()
{
    error_reporting(E_ALL);
    header('Content-Type: text/html; charset=utf-8');

    $html = file_get_contents("http://bash.im/random");
    $html = iconv('cp1251', 'utf-8', $html);
    preg_match("/div class=\"text\">(.*?)<\/div>/ms", $html, $valuta);

    //print_r($valuta[1]);

    return $valuta[1];
}

// Функция возвращает количество изменинй курса за текущие сутки
function statscount($start, $end)
{
    global $db;
    $query = $db->prepare(
        "SELECT COUNT(*)
                FROM banks_kurs
                WHERE time BETWEEN :sql_start AND :sql_end 
               "
    );
    $query->execute(array(
        'sql_start' => $start,
        'sql_end'   => $end,
    ));
    $data = $query->fetch(PDO::FETCH_ASSOC);
    //print_r($data);
    return $data;
}

function getCurrencyRatesWidget($start, $end)
{
    global $db;
    $query = $db->prepare(
        "SELECT DATE_FORMAT(time, '%d.%m') AS time,
                AVG(usd_buy) AS usd_buy,
                AVG(usd_sell) AS usd_sell,  
                AVG(eur_buy) AS eur_buy,
                AVG(eur_sell) AS eur_sell,
                AVG(rub_buy) AS rub_buy,
                AVG(rub_sell) AS rub_sell
                FROM banks_kurs
                WHERE time BETWEEN :sql_start AND :sql_end 
                AND usd_buy <> '0'
                AND usd_sell <> '0'
                AND eur_buy <> '0'
                AND eur_sell <> '0'
                AND rub_buy <> '0'
                AND rub_sell <> '0'
                GROUP BY DATE_FORMAT(time, '%Y-%m-%d')"
    );

    $query->execute(array(
        'sql_start' => $start,
        'sql_end'   => $end,
    ));

    $result = $query->fetchALL(PDO::FETCH_ASSOC);

    if ($result === false) {
        return [];
    }

    return $result;
}

function getBanksRatesTable()
{

    $number_days = 1;
    if (date("N") == 7) {
        $number_days = 2;
    } elseif (date("N") == 1) {
        $number_days = 3;
    }

    global $db;
    $query = $db->prepare(
        "SELECT * FROM ((SELECT 
                    b.id, 
                    b.name,
                    b.ico,
                    b.url,
                    b.latlng,
                    b.address,
                    b.status,
                    bk.usd_buy,
                    bk.usd_sell,
                    bk.eur_buy,
                    bk.eur_sell,
                    bk.rub_buy,
                    bk.rub_sell,
                    bk.banks_id,
                    DATE_FORMAT(bk.time, '%Y-%m-%d %H:%i') AS time
                FROM banks_kurs AS bk
                LEFT JOIN banks AS b ON b.id = bk.banks_id
				where  bk.time >= DATE_SUB(NOW(), INTERVAL :sql_number_days DAY))
                UNION ALL
                (SELECT id,
                name,
                ico,
                url,
                latlng,
                address,
                status,
                0,
                0,
                0,
                0,
                0,
                0,                
                id,
                '0000-00-00 00:00:00'
                FROM banks WHERE status = 1)
                ORDER BY time DESC
                ) AS bk2 WHERE status = 1 AND name <> 'Банк для тестирования' AND  bk2.TIME <> '0000-00-00 00:00:00'
                GROUP BY bk2.banks_id"
    );

    $query->execute(array(
        'sql_number_days' => $number_days,
    ));

    $result = $query->fetchALL(PDO::FETCH_ASSOC);

    if ($result === false) {
        return [];
    }

    return $result;
}

// Функция получаем все сообщения
function getMessageList()
{
    global $db;
    $query = $db->prepare(
        "SELECT  messages.id, 
                          time,
                          text,
                          ip,
                          banks_id,
                          banks.name,   
                          banks.ico   
                            FROM messages INNER JOIN banks ON messages.banks_id = banks.id
                            ORDER BY time DESC LIMIT 50"
    );
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

// Функция получаем все сообщения определенного банка
function getMessageBank($id)
{
    global $db;
    $query = $db->prepare(
        "SELECT  messages.id, 
                          time,
                          text,
                          ip
                            FROM messages INNER JOIN banks ON messages.banks_id = banks.id WHERE banks_id = $id
                            ORDER BY time DESC LIMIT 20"
    );
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

// Функция получаем лог ошибок (курсов, выходящих за пределы среднего курса)
function getLogErrorsList()
{
    global $db;
    $query = $db->prepare(
        "SELECT  banks_kurs_log.id, 
                          time,
                          html,
                          id_bank,
                          banks.name,   
                          banks.ico   
                            FROM banks_kurs_log INNER JOIN banks ON banks_kurs_log.id_bank = banks.id
                            WHERE type_log = 1
                            ORDER BY time DESC LIMIT 50"
    );
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

// Функция получаем список всех пользователей
function getUsersList()
{
    global $db;
    $query = $db->prepare(
        "SELECT id, login, name, avatar, role, logined_at FROM user ORDER BY id"
    );
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

// Функция получаем все сообщения определенного банка
function getLogErrorsBank($id)
{
    global $db;
    $query = $db->prepare(
        "SELECT  banks_kurs_log.id, 
                          time,
                          html
                            FROM banks_kurs_log INNER JOIN banks ON banks_kurs_log.id_bank = banks.id WHERE id_bank = $id AND type_log = 1
                            ORDER BY time DESC LIMIT 20"
    );
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}


// Функция получаем курсы валют по ID банка
function getCoursesBank($id)
{
    global $db;
    $query = $db->prepare(
        "SELECT    id,
                            usd_buy,
                            usd_sell,
                            eur_buy,
                            eur_sell,
                            rub_buy,
                            rub_sell,
                            DATE_FORMAT(time, '%Y-%m-%d %H:%i') AS time 
                                FROM banks_kurs WHERE banks_id = $id
                                ORDER BY time DESC LIMIT 20"
    );
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

// Функция получаем последнее ID из таблицы messages
function getLastIdMessage()
{
    global $db;
    $query = $db->prepare(
        "SELECT id FROM messages ORDER BY id DESC LIMIT 1;"
    );
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
    return $data;
}

// Функция получаем последнее ID из таблицы banks_kurs
function getLastIdCurrency()
{
    global $db;
    $query = $db->prepare(
        "SELECT id FROM banks_kurs ORDER BY id DESC LIMIT 1;"
    );
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
    return $data;
}

// Функция получаем последние 3 новости
function parseExchangeRates()
{

    $html = file_get_contents("https://bobr.by/service/feeds/rss-exchange-rates.php");

    if (preg_match_all("/<title>([^<]+)<\/title>.*?<link>([^<]+)<\/link>.*?<img>([^<]+)<\/img>.*?<pubDate>([^<]+)<\/pubDate>/ms",
        $html, $arr_news, PREG_SET_ORDER)) {

    } else {

        return;
    }

    $arr_news_new = [];
    $i = 0;
    foreach ($arr_news as $arr_news_clean) {
        unset($arr_news_clean[0]);
        array_values($arr_news_clean);
        $arr_news_clean[4] = date("Y-m-d\TH:i:sP", strtotime($arr_news_clean[4]));
        $arr_news_new[$i++] = $arr_news_clean;
    }

    if (!$arr_news_new) {
        return;
    }

    saveExchangeRates($arr_news_new);
}
