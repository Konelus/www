<?php

    $link = '';
    $descriptor = fopen($_SERVER['DOCUMENT_ROOT'].'/link.txt', 'r');
    if ($descriptor)
    {
        while (($string = fgets($descriptor)) !== false)
        { $link = $link.$string; }
        fclose($descriptor);
    }

    $localhost = "localhost";
    $user = "root";
    $password = $link;
    $db = "rtk_01";
    $mysqli = new mysqli($localhost, $user, $password, $db);

    $cat_name = end(explode("=", ('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])));
    $podcat_name = explode('?', $cat_name);

    //$cat_name_2 = end(explode("=", ('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])));
    $podcat_name_2 = explode('/', $cat_name);
    $podcat_name_3 = explode('/', $podcat_name[1]);

    $SQL_QUERY_del_in_table = $mysqli->query("DELETE FROM ".$podcat_name_3[0]." WHERE id = '".$podcat_name_3[1]."' ");
    $SQL_QUERY_del_in_vision = $mysqli->query("DELETE FROM ".$podcat_name_3[0]."_vision WHERE id_tr = '".$podcat_name_3[1]."' ");
    echo "DELETE FROM ".$podcat_name_3[0]." WHERE id = '".$podcat_name_3[1]."' <br>";
    echo "DELETE FROM ".$podcat_name_3[0]."_vision WHERE id = '".$podcat_name_3[1]."' ";
    header ("Location: /?".$podcat_name_3[0]);
?>