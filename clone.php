<?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/class/connection.php');

    $DB->select("*","!temp");
    while ($array = mysqli_fetch_array($DB->sql_query_select))
    {
        $arr[] = $array;
    }

    foreach ($arr as $key => $value)
    {
        foreach ($value as $key2 => $value2)
        {
            if ((is_numeric($key2)) || ($key2 == 'id'))
            { unset($arr[$key][$key2]); }
        }
    }


    foreach ($arr as $key => $value)
    {
        //pre($value);
        echo $value["ap_ip"]."<br>".$value["address"]."<br><br>";

        $DB->update("ucn","address","{$value["address"]}","`ap_ip` = '{$value['ap_ip']}'");

    }

?>