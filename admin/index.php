<?php

session_start();

header('Content-Type: text/html; charset=utf-8');

require_once 'kurs.php';
//print_r($_SESSION);
if (isset($_GET['action']) and $_GET['action'] == 'authpost'){
    $login = $_POST['login'];
    $password = $_POST['password'];
    $a = authuser($login, $password);

    if ($a['id'] > 0) {
        $_SESSION['sessionauth'] = true;
        $_SESSION['id'] = $a['id'];
        $_SESSION['role'] = $a['role'];
        setcookie ("user", "", time() + (86400 * 30));
        setcookie ("avatar", "", time() + (86400 * 30));
        setcookie("user", $a['name'], time() + (86400 * 30), '/');
        setcookie("avatar", $a['avatar'], time() + (86400 * 30), '/');
        echo json_encode(array('result' => true));
    } else {
        echo json_encode(array('result' => false));
    }
    exit;
} else if (isset($_GET['action']) and $_GET['action'] == 'editkurs'){
    if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
        echo json_encode(array('result' => false));
        exit;
    } else if ($_SESSION['role'] == 0 ){
        exit;
    }
    $id_bank = $_POST['id_bankphp'];
    $usd_buy = $_POST['usd_buyphp'];
    $usd_sell = $_POST['usd_sellphp'];
    $eur_buy = $_POST['eur_buyphp'];
    $eur_sell = $_POST['eur_sellphp'];
    $rub_buy = $_POST['rub_buyphp'];
    $rub_sell = $_POST['rub_sellphp'];
    $kurs = array(array(
        'banks_id' => $id_bank,
        'usd_buy' => $usd_buy,
        'usd_sell' => $usd_sell,
        'eur_buy' => $eur_buy,
        'eur_sell' => $eur_sell,
        'rub_buy' => $rub_buy,
        'rub_sell' => $rub_sell,
        'html' => 'Ручное изменение курсов',
        'status' => 1,
    ));
    addkurs($kurs);
    echo json_encode(array('result' => true));
    exit;
} else if (isset($_GET['action']) and $_GET['action'] == 'delbank'){
    if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
        echo json_encode(array('result' => false));
        exit;
    } else if ($_SESSION['role'] == 0 ){
        exit;
    }
    $idbank = $_POST['del_id_bankphp'];
    delbank($idbank);
    echo json_encode(array('result' => true));
    exit;
} else if (isset($_GET['action']) and $_GET['action'] == 'editbankpost'){
    if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
        echo json_encode(array('result' => false));
        exit;
    } else if ($_SESSION['role'] == 0 ){
        exit;
    }
    $name3 = $_POST['name_bankjs'];
    $id = $_POST['id'];
    $auto = $_POST['auto'];
    $latlng = $_POST['latlng_bankjs'];
    $url = $_POST['url_bankjs'];
    $address = $_POST['address_bankjs'];
    $url_parser = $_POST['url_parser_bankjs'];
    $note = $_POST['note_bankjs'];
    $file_ico_bank = null;
    $ico_select = $_POST['icojs'];
    if ($ico_select == 1){
        if (isset($_FILES["file"])) {
           move_uploaded_file($_FILES["file"]["tmp_name"], __DIR__ . "/files/img/ico/".$_FILES['file']['name']);
           $file_ico_bank = $_FILES['file']['name'];
         }
    } else {
        $file_ico_bank = $ico_select;
    }
    if ($auto == 'true') {
        $auto = 1;
    } else {
        $auto = 0;
    }
    if ($id > 0) {
        $user_data = editbank($id, $name3, $auto, $latlng, $url, $address, $file_ico_bank, $url_parser, $note);
    } else {
        $user_data = addbank($name3, $auto, $latlng, $url, $address, $file_ico_bank, $url_parser, $note);
    }
    echo json_encode(array('result' => true));
    exit;
}  else if (isset($_GET['action']) and $_GET['action'] == 'polzovatel'){
    if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
        echo json_encode(array('result' => false));
        exit;
    }
    //print_r($_POST);
    //print_r($_FILES);
    $id = $_SESSION['id'];
    $login_user = $_POST['login_user_js'];
    $name_user = $_POST['name_user_js'];
    $file_user_avatars = '';
    //echo $new_name_file;
    if (isset($_FILES["file"])) {
        $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $new_name_file = $id.'.'.$extension;
        move_uploaded_file($_FILES["file"]["tmp_name"], __DIR__ . "/files/img/avatars/".$new_name_file);
        $file_user_avatars = $new_name_file;
    }
    $user_data = edituser($id, $login_user, $name_user, $file_user_avatars);
    if ($user_data == true) {
        echo json_encode(array('result' => true));
    } else {
        echo json_encode(array('result' => false));
    }
    exit;
}

$active_home = '';
$active_stats = '';
$active_banks = '';
$active_statsavr = '';
$active_edituser = '';
$active_message = '';
$active_log_errors = '';

if (isset($_GET['action']) and $_GET['action'] == 'auth') {

    if(isset($_COOKIE['user'])) {
        $privet_name = "Привет, ". $_COOKIE['user'] .". Пожалуйста, авторизуйся.";
        $privet_avatar = $_COOKIE['avatar'];
    } else {
        $privet_name = '';
        $privet_avatar = 'img_avatar.png';
    }
    require 'templates/auth.tpl';
    // Вставлено для шаблона средней статистики на главной
} else if (isset($_GET['action']) and $_GET['action'] == 'logout'){
    session_destroy();
    header('location:index.php?action=auth');
    exit;

} else if (isset($_GET['action']) and $_GET['action'] == 'closed'){
    if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
        header('location:index.php?action=auth');
        exit;
    }
    $user_data2 = userinfo($_SESSION['id']);
    $bash = bash();
    ob_start();
    require "templates/closed.tpl";
    $content = ob_get_clean();
    require 'templates/main.tpl';

} else if (isset($_GET['action']) and $_GET['action'] == 'bank'){
    if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
        header('location:index.php?action=auth');
        exit;
    } else if ($_SESSION['role'] == 0 ){
        header('location:index.php?action=closed');
        exit;
    }
    $user_data2 = userinfo($_SESSION['id']);
    $banks = getbankslist();
    $active_banks = ' class="active"';
    //print_r($banks);
    ob_start();
    require "templates/bank.tpl";
    $content = ob_get_clean();
    require 'templates/main.tpl';
} else if (isset($_GET['action']) and $_GET['action'] == 'editbank'){
    if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
        header('location:index.php?action=auth');
        exit;
    } else if ($_SESSION['role'] == 0 ){
        header('location:index.php?action=closed');
        exit;
    }
    $user_data2 = userinfo($_SESSION['id']);
    $bank_data = getbanksinfo($_GET['id']);

    $dir_ico = __DIR__ . "/files/img/ico/";
    $files_ico = scandir($dir_ico);
    //print_r($files_ico);

    $select_ico = '';
    foreach($files_ico as $ico) {
        if ($ico == '.' or $ico == '..') {
            continue;
        }
       $select_ico = $select_ico . "<option class='imagebacked' style=\"background-image: url(files/img/ico/$ico)\"" . ($bank_data['ico'] == $ico ? " selected" : "") . " value='{$ico}'>{$ico}</option>\n";
    }

    if ($bank_data['ico'] == "") {
        $display_none = '';
    } else {
    $display_none = ' style="display: none"';
        }

    $messages = getMessageBank($_GET['id']);

    $courses = getCoursesBank($_GET['id']);

    $log_errors_bank = getLogErrorsBank($_GET['id']);

    ob_start();
    require "templates/editbank.tpl";
    $content = ob_get_clean();
    require 'templates/main.tpl';
} else if (isset($_GET['action']) and $_GET['action'] == 'edituser'){
    if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
        header('location:index.php?action=auth');
        exit;
    }
    $active_edituser = ' class="active"';
    $user_data2 = userinfo($_SESSION['id']);

    setcookie ("user", "", time() + (86400 * 30));
    setcookie ("avatar", "", time() + (86400 * 30));
    setcookie("user", $user_data2['name'], time() + (86400 * 30), '/');
    setcookie("avatar", $user_data2['avatar'], time() + (86400 * 30), '/');

    //print_r($user_data);
    ob_start();
    require "templates/edituser.tpl";
    $content = ob_get_clean();
    require 'templates/main.tpl';
} else if (isset($_GET['action']) and $_GET['action'] == 'stats'){
    if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
        header('location:index.php?action=auth');
        exit;
    } else if ($_SESSION['role'] == 0 ){
        header('location:index.php?action=closed');
        exit;
    }

    $banks = getbankslist();
    //print_r($banks);
    $id_bank_select = isset($_GET['bank']) ? $_GET['bank'] : $banks[0]['id'];
    $period_bank_select = isset($_GET['period']) ? $_GET['period'] : 'day';
    $start_time = new DateTime();
    $end_time = new DateTime();
    if ($period_bank_select == 'day') {
        $start_time->modify('-1 day');
    }else if ($period_bank_select == 'week') {
        $start_time->modify('-7 day');
    } else if ($period_bank_select == 'month') {
        $start_time->modify('-30 day');
    }
    $user_data2 = userinfo($_SESSION['id']);

    $stats_period = getstats(
        $id_bank_select,
        $start_time->format('Y-m-d H:i:s'),
        $end_time->format('Y-m-d H:i:s')
    );
    $time_arr = array('x');
    $usd_buy_arr = array('Покупка USD');
    $usd_sell_arr = array('Продажа USD');
    $eur_buy_arr = array('Покупка EUR');
    $eur_sell_arr = array('Продажа EUR');
    $rub_buy_arr = array('Покупка RUB');
    $rub_sell_arr = array('Продажа RUB');
    foreach($stats_period as $stat){
        $time_arr[] = $stat['time'];
        $usd_buy_arr[] = $stat['usd_buy'];
        $usd_sell_arr[] = $stat['usd_sell'];
        $eur_buy_arr[] = $stat['eur_buy'];
        $eur_sell_arr[] = $stat['eur_sell'];
        $rub_buy_arr[] = $stat['rub_buy'];
        $rub_sell_arr[] = $stat['rub_sell'];
    };

    //print_r($usd_buy_arr);

    $active_stats = ' class="active"';

    ob_start();
    require "templates/stats.tpl";
    $content = ob_get_clean();
    require 'templates/main.tpl';
} else if (isset($_GET['action']) and $_GET['action'] == 'statsavr') {
    if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
        header('location:index.php?action=auth');
        exit;
    }

    $user_data2 = userinfo($_SESSION['id']);

    $active_statsavr = ' class="active"';

    $start_time = new DateTime();
    $end_time = new DateTime();

    $start_time->modify('-14 day');
    $end_time->modify('+1 day');

    $stats_period = getstatsavg(
        $start_time->format('Y-m-d'),
        $end_time->format('Y-m-d')
    );
    //print_r($stats_period);

    $time_arr = array();

    foreach($stats_period as $stat){
        $time_arr[] = $stat['time'];
        $usd_buy_arr[] = round((float)$stat['usd_buy'], 3);
        $usd_sell_arr[] = round((float)$stat['usd_sell'], 3);
        $eur_buy_arr[] = round((float)$stat['eur_buy'], 3);
        $eur_sell_arr[] = round((float)$stat['eur_sell'], 3);
        $rub_buy_arr[] = round((float)$stat['rub_buy'], 3);
        $rub_sell_arr[] = round((float)$stat['rub_sell'], 3);
    };
    $data_graph = json_encode($time_arr);
    $data_graph_usd_buy = json_encode($usd_buy_arr);
    $data_graph_usd_sell = json_encode($usd_sell_arr);
    $data_graph_eur_buy = json_encode($eur_buy_arr);
    $data_graph_eur_sell = json_encode($eur_sell_arr);
    $data_graph_rub_buy = json_encode($rub_buy_arr);
    $data_graph_rub_sell = json_encode($rub_sell_arr);
    //print_r($usd_buy_arr);
    //print_r($stat);

    ob_start();
    require "templates/statsavr.tpl";
    $content = ob_get_clean();
    require 'templates/main.tpl';
}  else if (isset($_GET['action']) and $_GET['action'] == 'cron') {
    if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
        header('location:index.php?action=auth');
        exit;
    } else if ($_SESSION['role'] == 0 ){
        header('location:index.php?action=closed');
        exit;
    }
    require "cron.php";
    header('location:index.php');
} else if (isset($_GET['action']) and $_GET['action'] == 'message'){
    if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
        header('location:index.php?action=auth');
        exit;
    } else if ($_SESSION['role'] == 0 ){
        header('location:index.php?action=closed');
        exit;
    }
    $user_data2 = userinfo($_SESSION['id']);
    $messages = getMessageList();
    $active_message = ' class="active"';
    //print_r($banks);
    ob_start();
    require "templates/message.tpl";
    $content = ob_get_clean();
    require 'templates/main.tpl';
} else if (isset($_GET['action']) and $_GET['action'] == 'log-errors'){
    if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
        header('location:index.php?action=auth');
        exit;
    } else if ($_SESSION['role'] == 0 ){
        header('location:index.php?action=closed');
        exit;
    }
    $user_data2 = userinfo($_SESSION['id']);
    $log_errors = getLogErrorsList();
    $active_log_errors = ' class="active"';
    //print_r($log_errors);
    ob_start();
    require "templates/log-errors.tpl";
    $content = ob_get_clean();
    require 'templates/main.tpl';
} else if (isset($_POST['AjaxAction']) and $_POST['AjaxAction'] == 'lastIdMessage'){
    if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
        header('location:index.php?action=auth');
        exit;
    } else if ($_SESSION['role'] == 0 ){
        header('location:index.php?action=closed');
        exit;
    }
    $id = getLastIdMessage();
    $id = json_encode($id);

    print_r($id);

    exit();
}
else {
   if (!isset($_SESSION['sessionauth']) or $_SESSION['sessionauth'] == false) {
       header('location:index.php?action=auth');
       exit;
   } else if ($_SESSION['id'] == 4 or $_SESSION['id'] == 5){
       header('location:index.php?action=closed');
       exit;
   }
    $user_data2 = userinfo($_SESSION['id']);

    //print_r($user_data2);

    $start_time = new DateTime();
    $end_time = new DateTime();

    $end_time->modify('+1 day');

    $stats_count = statscount(
        $start_time->format('Y-m-d'),
        $end_time->format('Y-m-d')
    );

    $banks = getbanks();

    foreach ($banks as $key => $bank){
        $days = floor((strtotime($start_time->format('Y-m-d H:i:s')) - strtotime($banks[$key]['time']))/(60*60*24));
        $banks[$key]['alarm_time'] = $days;
    }
    ob_start();
    //print_r($banks);
    require "templates/home.tpl";
    $content = ob_get_clean();
    require 'templates/main.tpl';

}

?>