<?php

function priorbank_by()
{
    //global $banks_id;
    $url = 'https://www.priorbank.by/?p_p_id=exchangeliferayspringmvcportlet_WAR_exchangeliferayspringmvcportlet&p_p_lifecycle=2&p_p_resource_id=ajaxGetReportForMainPageAjax';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest"));
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

    if (curl_exec($ch) === false) {
        //echo 'Ошибка curl: ' . curl_error($ch);
        $result = "error";
    } else {
        //echo 'Операция завершена без каких-либо ошибок';
        $result = "";
    }

    $json = curl_exec($ch);
    curl_close($ch);

    $arr = json_decode($json, true);

    $data = [];
    $array_banks_id = [4, 54];

    $usd_buy = $arr['fullListAjax'][0]['viewVOList'][0]['buy'];
    $usd_sell = $arr['fullListAjax'][0]['viewVOList'][0]['sell'];
    $eur_buy = $arr['fullListAjax'][1]['viewVOList'][0]['buy'];
    $eur_sell = $arr['fullListAjax'][1]['viewVOList'][0]['sell'];
    $rub_buy = $arr['fullListAjax'][2]['viewVOList'][0]['buy'];
    $rub_sell = $arr['fullListAjax'][2]['viewVOList'][0]['sell'];

    if (
        $usd_buy == '' && $usd_sell == '' && $eur_buy == '' && $eur_sell == '' && $rub_buy == '' && $rub_sell == ''
    ) {
        $status = 0;
    } else {
        $status = 1;
    }

    foreach ($array_banks_id as $banks_id) {
        $data[] = array(
            'usd_buy'  => $usd_buy,
            'usd_sell' => $usd_sell,
            'eur_buy'  => $eur_buy,
            'eur_sell' => $eur_sell,
            'rub_buy'  => $rub_buy,
            'rub_sell' => $rub_sell,
            'banks_id' => $banks_id,
            'status'   => $status,
            'html'     => $json, //json
            'result'   => $result
        );
    };
    //print_r($data);
    return $data;
}

//priorbank_by();
?>

