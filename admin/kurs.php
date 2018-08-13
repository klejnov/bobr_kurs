<?php
/**
 * Created by PhpStorm.
 * User: PETROvich
 * Date: 27.08.2017
 * Time: 13:18
 */

require "config.php";

$db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] ,$config['username'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

function authuser($func_login, $func_password) {
    global $db;
    $query = $db->prepare(
        "SELECT id,
                    role,
                    name,
                    avatar         
                FROM user
                WHERE login = :sql_login
                AND password = :sql_password"
    );
    $query->execute(array(
        'sql_login' => $func_login,
        'sql_password' => md5($func_password),
    ));
    $data = $query->fetch(PDO::FETCH_ASSOC);

    if ($data['id'] > 0) {
        return $data;
    } else {
        return false;
    }
}

// Функция возвращает имя, avatar и id
function userinfo ($func_id) {
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
function edituser ($func_id, $func_login, $func_name, $func_avatar) {
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
        'sql_id' => $func_id,
    ));
    $data = $query->fetch(PDO::FETCH_ASSOC);
    //При одинаковых логинах в data запишется одномерный массив с id пользователя.
    //При разных логинах вернется null
    //Далее делаю условие если не массив, то выполняю update.
    if (!$data)  {
        $query = $db->prepare(
            "UPDATE user
                    SET name = :sql_name, login = :sql_login $avatar_mysql
                    WHERE id = :sql_id"
        );
        $query->execute(array(
            'sql_name' => $func_name,
            'sql_login' => $func_login,
            'sql_id' => $func_id,
        )+$avatar_arr);
        //$data = $query->fetch(PDO::FETCH_ASSOC);
        return true;
    } else {
         return false;
    }
}

// Функция добавляем банк
function addbank ($func_name, $func_auto, $func_latlng, $func_url, $func_address, $func_ico_bank, $func_url_parser, $func_note) {
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
              banks (name, auto, latlng, url, address, ico) 
              VALUES (:sql_name, :sql_auto, :sql_latlng, :sql_url, :sql_address, :sql_ico_bank, :sql_url_parser, :sql_note);"
    );
    $query->execute(array(
        'sql_name' => $func_name,
        'sql_auto' => $func_auto,
        'sql_latlng' => $func_latlng,
        'sql_url' => $func_url,
        'sql_address' => $func_address,
        'sql_ico_bank' => $func_ico_bank,
        'sql_url_parser' => $func_url_parser,
        'sql_note' => $func_note,
    ));
    //$data = $query->fetch(PDO::FETCH_ASSOC);
}

// Функция возвращает имя и id банка
function getbanks () {
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
                GROUP BY bk2.banks_id
                "
    );
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    //print_r($data);
    return $data;

}

// Редактируем банк
function editbank ($func_id, $func_name, $func_auto, $func_latlng, $func_url, $func_address, $func_ico_bank, $func_url_parser, $func_note) {
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
        'sql_name' => $func_name,
        'sql_id' => $func_id,
        'sql_auto' => $func_auto,
        'sql_latlng' => $func_latlng,
        'sql_url' => $func_url,
        'sql_address' => $func_address,
        'sql_url_parser' => $func_url_parser,
        'sql_note' => $func_note,
    )+$ico_arr);
    //$data = $query->fetch(PDO::FETCH_ASSOC);
}

// Функция получаем информацию о банке
function getbanksinfo ($func_id) {
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

function delbank($func_dddddeelll_bank) {
    global $db;
    $query2 = $db->prepare(
        "DELETE FROM banks
                WHERE id = :sql_func_db"
    );
    $query2->execute(array(
        'sql_func_db' => $func_dddddeelll_bank,
    ));
    ;
}

//заносит курсы с проверкой

function addkurs ($data) {
    //echo $func_name;
    global $db;
    foreach ($data as $parser_data) {
        $query = $db->prepare(
            "UPDATE banks
                    SET status = :sql_status
                    WHERE id = :sql_banks_id"
        );
        $query->execute(array(
            'sql_status' => $parser_data['status'],
            'sql_banks_id' => $parser_data['banks_id'],
        ));
        if ($parser_data['usd_buy'] == 0
            && $parser_data['eur_buy'] == 0
            && $parser_data['rub_buy'] == 0
            && $parser_data['usd_sell'] == 0
            && $parser_data['eur_sell'] == 0
            && $parser_data['rub_sell'] == 0) {
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
                'sql_usd_buy' => $parser_data['usd_buy'],
                'sql_usd_sell' => $parser_data['usd_sell'],
                'sql_eur_buy' => $parser_data['eur_buy'],
                'sql_eur_sell' => $parser_data['eur_sell'],
                'sql_rub_buy' => $parser_data['rub_buy'],
                'sql_rub_sell' => $parser_data['rub_sell'],
            ));
        }
    }
    //print_r($parser_data);
    //fetch нужен только при SELECT!!!
    //$data = $query->fetch(PDO::FETCH_ASSOC);
}

// Функция получаем все банки
function getbankslist () {
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
function getstats($id_bank, $start, $end) {
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
        'sql_start' => $start,
        'sql_end' => $end,
    ));
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    //print_r($data);
    return $data;
}

// Функция возвращает среднесуточное значение курса в зависимости от периода
function getstatsavg($start, $end) {
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
        'sql_end' => $end,
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
function statscount($start, $end) {
    global $db;
    $query = $db->prepare(
        "SELECT COUNT(*)
                FROM banks_kurs
                WHERE time BETWEEN :sql_start AND :sql_end 
               "
    );
    $query->execute(array(
        'sql_start' => $start,
        'sql_end' => $end,
    ));
    $data = $query->fetch(PDO::FETCH_ASSOC);
    //print_r($data);
    return $data;
}