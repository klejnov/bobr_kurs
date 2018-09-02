<?php

function belveb_by_i($banks_id)
{
    //header('Content-Type: text/html; charset=utf-8');

    $data2 = array();
    if (($handle = fopen("http://www.bveb.by/tutby/Curs_Main.csv", "r")) !== false) {
        while (($data = fgetcsv($handle, 10000, "\n")) !== false) {
            $num = count($data);
            for ($c = 0; $c < $num; $c++) {
                $line = explode(';', $data[$c]);
                $data2[] = $line;
            }
        }
        fclose($handle);
    }

    $arr = array();
    foreach ($data2 as $data3) {
        if ($data3[1] == 65910 && in_array($data3[2], array('EUR', 'RUR', 'USD'))) {
            if ($data3[2] == 'RUR') {
                $data3[4] *= 100;
                $data3[5] *= 100;
            }
            $arr[$data3[2]] = array($data3[4], $data3[5], $data3[0]);
        }
    }


    if ($arr) {
        $status = 1;
    } else {
        $status = 0;
    }

    $data = array(
        array(
            'usd_buy'  => (string)$arr['USD'][0],
            'usd_sell' => (string)$arr['USD'][1],
            'eur_buy'  => (string)$arr['EUR'][0],
            'eur_sell' => (string)$arr['EUR'][1],
            'rub_buy'  => (string)$arr['RUR'][0],
            'rub_sell' => (string)$arr['RUR'][1],
            'banks_id' => (string)$banks_id,
            'status'   => $status,
            'html'     => '«Банк БелВЭБ» Адрес: Бобруйск,  ул. Интернациональная, 49',
        )
    );

    //print_r($data);
    return $data;

//    echo "</table>";
//    echo "<BR><b><A HREF=\"http://www.bveb.by/individual/currency-exchange/exchange/bveb/?type=bveb&office=65910\">Веб страница курсов</A></b> (Редко обновляют курсы на своем сайте)<BR><BR><b><A HREF=\"http://www.bveb.by/tutby/Curs_Main.csv\">Файл курсов</A></b>";

}

//belveb_by_i();

?>
