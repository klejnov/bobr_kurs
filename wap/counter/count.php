<?php
$date = date("d.m.Y H:i:s: ");
$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
$ip = $date . $REMOTE_ADDR . "\r\n";

$forw = getenv(HTTP_X_FORWARDED_FOR);
if (($forw != "") && ($forw != $REMOTE_ADDR)) {
    $ip = $REMOTE_ADDR;
    $ip = $date . 'прокси:' . $ip . '/ реальный IP:' . $forw . "\r\n";
}
$hit = fopen(__DIR__ . '/dat/hit.dat', "a");
fwrite($hit, $ip);
fclose($hit);
$file = file(__DIR__ . '/dat/host.dat');

$file_ip = [];

foreach ($file as $file_str) {
    $file_ip[] = preg_split('/: /', $file_str)[1];
}

if (in_array(preg_split('/: /', $ip)[1], $file_ip)) {
    fclose($hit);
} else {
    $host = fopen(__DIR__ . '/dat/host.dat', "a");
    fwrite($host, $ip);
    fclose($host);
}

