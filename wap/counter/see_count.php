<?php
include "count.php";

$file = file("dat/hit.dat");
$hit = count($file);
$file = file("dat/host.dat");
$host = count($file);
include "config.php";
$im = ImageCreateFromGif("pics/".$civ);
imagestring ($im , 1, 44, 16, $host, 0);
imagestring ($im , 1, 44, 6, $hit, 0);
header("Content-type: image/vnd.wap.wbmp");
ImageWBMP($im);
