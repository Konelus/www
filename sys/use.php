<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Expires: ".date("r"));

$link = '';
$descriptor = fopen($_SERVER['DOCUMENT_ROOT'].'/link.txt', 'r');
if ($descriptor)
{ while (($string = fgets($descriptor)) !== false) { $link = $link.$string; } fclose($descriptor); }



//$mysqli = new mysqli("localhost", "root", "{$link}", "rtk_01");
//mysqli_set_charset($mysqli, 'utf8');


$substring = $_SERVER['QUERY_STRING'];
?>