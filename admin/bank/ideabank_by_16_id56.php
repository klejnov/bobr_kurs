<?php

function ideabank_by_16_id56($banks_id)
{
//header('Content-Type: text/html; charset=utf-8');
    $databank = date('d-m-Y');
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest"));
    curl_setopt($curl, CURLOPT_URL, 'https://www.ideabank.by/o-banke/kursy-valyut/');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, "date=$databank&id=56");
    $json = curl_exec($curl);
    curl_close($curl);
    //print_r($json);
//$json = file_get_contents("json16_id56.txt");
$arr = json_decode($json, true);

//echo "<H1>Идея Банк РКЦ №16 Адрес:ул. 50 лет ВЛКСМ, 33 (ТЦ «Корона»)</H1>";

//echo "<table border='1'>";
if (isset($arr['data']['rates'])) {
    $status = 1;
	foreach ($arr['data']['rates'] as $date => $tmp) {
		/*echo "<tr>
			<td>{$date}</td>
			<td>{$tmp['1 USD'][1]['Currency']}</td>
			<td>{$tmp['1 USD'][1]['Value']}</td>
			<td>{$tmp['1 USD'][2]['Value']}</td>
			<td>{$tmp['1 EUR'][1]['Currency']}</td>
			<td>{$tmp['1 EUR'][1]['Value']}</td>
			<td>{$tmp['1 EUR'][2]['Value']}</td>
			<td>{$tmp['100 RUB'][1]['Currency']}</td>
			<td>{$tmp['100 RUB'][1]['Value']}</td>
			<td>{$tmp['100 RUB'][2]['Value']}</td>
		</tr>
		";*/
	}
} else {
    $status = 0;
	/*echo "<tr>
			<td>" . date('H:i:s') . "</td>
			<td>USD</td>
			<td>0</td>
			<td>0</td>
			<td>EUR</td>
			<td>0</td>
			<td>0</td>
			<td>RUB</td>
			<td>0</td>
			<td>0</td>
		</tr>";*/
}
		//echo "</table>";

   		//возвращает первый ключ массива
    	$first_key = array_keys($arr['data']['rates'])[0];
		//global $banks_id;
    	$data = array(array(
			'usd_buy' => (string)$arr['data']['rates'][$first_key]['1 USD'][1]['Value'],
			'usd_sell' => (string)$arr['data']['rates'][$first_key]['1 USD'][2]['Value'],
			'eur_buy' => (string)$arr['data']['rates'][$first_key]['1 EUR'][1]['Value'],
			'eur_sell' => (string)$arr['data']['rates'][$first_key]['1 EUR'][2]['Value'],
			'rub_buy' => (string)$arr['data']['rates'][$first_key]['100 RUB'][1]['Value'],
			'rub_sell' => (string)$arr['data']['rates'][$first_key]['100 RUB'][2]['Value'],
			'banks_id' => (string)$banks_id,
            'status' => $status,
		));
    	//print_r($data);
		//print_r($arr['data']['rates']);
   		return $data;

		}
//ideabank_by_16_id56();
?>
