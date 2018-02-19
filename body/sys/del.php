<?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');

    $cat_name = end(explode("=", ('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])));
    $podcat_name = explode('?', $cat_name);

    $podcat_name_2 = explode('/', $cat_name);
    $podcat_name_3 = explode('/', $podcat_name[1]);

    $DB->delete("".$podcat_name_3[0],"`id` = '".$podcat_name_3[1]."'");
    $DB->delete("".$podcat_name_3[0],"`id_tr` = '".$podcat_name_3[1]."'");

    header ("Location: /?".$podcat_name_3[0]);
?>