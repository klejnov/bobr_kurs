<?php

function priorbank_by()
{
    //global $banks_id;
    $json = file_get_contents("https://www.priorbank.by/?p_p_id=exchangeliferayspringmvcportlet_WAR_exchangeliferayspringmvcportlet&p_p_lifecycle=2&p_p_state=normal&p_p_mode=view&p_p_resource_id=ajaxGetReportForMainPageAjax&p_p_cacheability=cacheLevelPage&p_p_col_id=_118_INSTANCE_7La20uxMthb5__column-2&p_p_col_count=1");
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
            'html'     => $json,
        );
    };
    //print_r($data);
    return $data;
}

//priorbank_by();
?>

