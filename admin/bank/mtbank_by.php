<?php

function mtbank_by($banks_id)
{
	//header('Content-Type: text/html; charset=utf-8');

		$xml = simplexml_load_file('https://www.mtbank.by/currxml.php?ver=2');

		//print_r($xml);


	//echo "<H1>«МТБанк» РКЦ-14 и РКЦ-38. Адрес: Бобруйск, ул. Комсомольская д. 47</H1>";
	//echo "<table border='1'>";
	foreach ($xml->department as $tmp) {
		if ($tmp->attributes()['city'] == 'Бобруйск') {
			$usd = '';
			$rub = '';
			$eur = '';
			foreach ($tmp->currency as $tmp2) {
				if ($tmp2->code == 'BYN' && $tmp2->codeTo == 'USD') {
					$usd = array(
						'purchase' => $tmp2->purchase,
						'sale' => $tmp2->sale,
					);
				} elseif ($tmp2->code == 'BYN' && $tmp2->codeTo == 'EUR') {
					$eur = array(
						'purchase' => $tmp2->purchase,
						'sale' => $tmp2->sale,
					);
				} elseif ($tmp2->code == 'BYN' && $tmp2->codeTo == 'RUB') {
					$rub = array(
						'purchase' => $tmp2->purchase,
						'sale' => $tmp2->sale,
					);
				}
			}
			/*echo "<tr>
				<td>{$tmp->attributes()['label']}</td>
				<td>{$tmp->attributes()['address']}</td>
	
				<td>USD</td>
				<td>{$usd['purchase']}</td>
				<td>{$usd['sale']}</td>
	
				<td>EUR</td>
				<td>{$eur['purchase']}</td>
				<td>{$eur['sale']}</td>
	
				<td>RUB</td>
				<td>{$rub['purchase']}</td>
				<td>{$rub['sale']}</td>
			</tr>";*/

           //global $banks_id;


		}
	}


    if (!isset($usd['purchase'])) {
        $usd['purchase'] = 0;
    }
    if (!isset($usd['sale'])) {
        $usd['sale'] = 0;
    }
    if (!isset($eur['purchase'])) {
        $eur['purchase'] = 0;
    }
    if (!isset($eur['sale'])) {
        $eur['sale'] = 0;
    }
    if (!isset($rub['purchase'])) {
        $rub['purchase'] = 0;
    }
    if (!isset($rub['sale'])) {
        $rub['sale'] = 0;
    }

    if (
        $usd['purchase'] == 0 && $usd['sale'] == 0
		&& $eur['purchase'] == 0 && $eur['sale'] == 0
        && $rub['purchase'] == 0 && $rub['sale'] == 0
    ) {
        $status = 0;
    } else {
        $status = 1;
    }

    $data = array(array(
        'usd_buy' => (string)$usd['sale'],
        'usd_sell' => (string)$usd['purchase'],
        'eur_buy' => (string)$eur['sale'],
        'eur_sell' => (string)$eur['purchase'],
        'rub_buy' => (string)$rub['sale'],
        'rub_sell' => (string)$rub['purchase'],
        'banks_id' => (string)$banks_id,
        'status' => $status,
    ));

    //print_r($data);
    return $data;
//	echo "</table>";
//	echo "<BR><b><A HREF=\"https://www.mtbank.by/private/currency\">Веб страница курсов</A> (ПОСТОЯННО шалят. меняют местами поизиции в xml. Надо понаблюдать)</b><BR><BR><b><A HREF=\"https://www.mtbank.by/currxml.php?ver=2\">Файл курсов</A></b>";


}

?>
