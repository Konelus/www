<?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');

    $substring = $_SERVER['QUERY_STRING'];

    $podcat_name_2 = explode('/', $cat_name);
    $podcat_name_3 = explode('/', $substring);

    $DB->delete("".$podcat_name_3[0],"`id` = '".$podcat_name_3[1]."'");
    $DB->delete("".$podcat_name_3[0],"`id_tr` = '".$podcat_name_3[1]."'");

    header ("Location: /?".$podcat_name_3[0]);
?>