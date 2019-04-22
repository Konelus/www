<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/class/connection.php');

    $DB->select("null123","tele2_temp");
    while ($row = mysqli_fetch_row($DB->sql_query_select))
    { $array[] = $row[0]; }

    $count = 0;
    foreach ($array as $key => $value)
    {
        $DB->select("*","tele2", "`null123` = '{$value}'");
        while ($arr = mysqli_fetch_array($DB->sql_query_select))
        { $array2[] = $arr; }
    }

    foreach ($array2 as $key => $value)
    {
        foreach ($value as $key2 => $value2)
        {
            if ((is_numeric($key2)) || ($key2 == 'id'))
            { unset($array2[$key][$key2]); }
            else
            {
                if ($string[$key] == '') { $string[$key] = "null, '{$value2}'"; }
                else { $string[$key] .= ", '{$value2}'"; }
            }
        }
    }

    foreach ($string as $key => $value)
    { $DB->insert("tele2_dump","{$value}"); }

    foreach ($array as $key => $value)
    { $DB->delete("tele2","`null123` = '{$value}'"); }


    echo 'Well done!';
?>