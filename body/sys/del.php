<?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');

    if ($_GET != null) { $substring = $_SERVER['QUERY_STRING']; }

    //$podcat_name_2 = explode('/', $cat_name);
    $substring_id = explode('/', $substring);

    $DB->delete("".$substring_id[0],"`id` = '".$substring_id[1]."'");
    $DB->delete("".$substring_id[0],"`id_tr` = '".$substring_id[1]."'");

    header ("Location: /?".$substring_id[0]);
?>