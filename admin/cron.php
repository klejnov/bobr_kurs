<?php
header('Content-Type: text/html; charset=utf-8');

require_once 'kurs.php';

$banks_id = 1;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/paritetbank_by_parser3.php';
    $paritetbank3 = paritetbank_by_parser3($banks_id);
    addkurs($paritetbank3);
}

$banks_id = 2;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/paritetbank_by_parser4.php';
    $paritetbank4 = paritetbank_by_parser4($banks_id);
    addkurs($paritetbank4);
}

$banks_id = 3;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/paritetbank_by_parser12.php';
    $paritetbank12 = paritetbank_by_parser12($banks_id);
    addkurs($paritetbank12);
}

$banks_id = 4;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/priorbank_by.php';
    $priorbank = priorbank_by($banks_id);
    addkurs($priorbank);
}

$banks_id = 5;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/rbank_by.php';
    $rbank_by = rbank_by($banks_id);
    addkurs($rbank_by);
}


$banks_id = 6;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/mtbank_by.php';
    $mtbank_by = mtbank_by($banks_id);
    addkurs($mtbank_by);
}

$banks_id = 7;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/belveb_by_s.php';
    $belveb_by_s = belveb_by_s($banks_id);
    addkurs($belveb_by_s);
}

$banks_id = 8;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/belveb_by_i.php';
    $belveb_by_i = belveb_by_i($banks_id);
    addkurs($belveb_by_i);
}

$banks_id = 9;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/ideabank_by_16_id56.php';
    $ideabank_by_16_id56 = ideabank_by_16_id56($banks_id);
    addkurs($ideabank_by_16_id56);
}

$banks_id = 10;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/ideabank_by_27_id79.php';
    $ideabank_by_27_id79 = ideabank_by_27_id79($banks_id);
    addkurs($ideabank_by_27_id79);
}

$banks_id = 11;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/ideabank_by_39_id40.php';
    $ideabank_by_39_id40 = ideabank_by_39_id40($banks_id);
    addkurs($ideabank_by_39_id40);
}

$banks_id = 12;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/ideabank_by_44_id113.php';
    $ideabank_by_44_id113 = ideabank_by_44_id113($banks_id);
    addkurs($ideabank_by_44_id113);
}

//Удаляет из массива $belarusbank_by банки для которых установлено ручное обновление
require 'bank/belarusbank_by.php';
$belarusbank_by = belarusbank_by();
foreach ($belarusbank_by as $key => $belarusbank_by2) {
    $bank_data = getbanksinfo($belarusbank_by2['banks_id']);
    if ($bank_data['auto'] == 0) {
        unset($belarusbank_by[$key]);
    }
}
//print_r($belarusbank_by);
addkurs($belarusbank_by);

$banks_id = 35;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
require 'bank/alfabank_by.php';
$alfabank_by = alfabank_by($banks_id);
addkurs($alfabank_by);
}

$banks_id = 36;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/mmbank_by.php';
    $mmbank_by = mmbank_by($banks_id);
    addkurs($mmbank_by);
}

$banks_id = 37;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/belgazprombank_by.php';
    $belgazprombank_by = belgazprombank_by($banks_id);
    addkurs($belgazprombank_by);
}

$banks_id = 38;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/belinvestbank_by.php';
    $belinvestbank_by = belinvestbank_by($banks_id);
    addkurs($belinvestbank_by);
}

$banks_id = 39;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/bps_sberbank_by.php';
    $bps_sberbank_by = bps_sberbank_by($banks_id);
    addkurs($bps_sberbank_by);
}

$banks_id = 40;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/rrb_by.php';
    $rrb_by = rrb_by($banks_id);
    addkurs($rrb_by);
}

$banks_id = 41;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/stbank_by_1.php';
    $stbank_by_1 = stbank_by_1($banks_id);
    addkurs($stbank_by_1);
}

$banks_id = 43;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/vtb_bank_by.php';
    $vtb_bank_by = vtb_bank_by($banks_id);
    addkurs($vtb_bank_by);
}

$banks_id = 34;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/belapb_by.php';
    $belapb_by = belapb_by($banks_id);
    addkurs($belapb_by);
}
