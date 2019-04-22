<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/class/connection.php');

    $DB->select("*","!temp");
    while ($row = mysqli_fetch_row($DB->sql_query_select))
    { $no[] = $row[1]; }

    foreach ($no as $key => $value)
    {
        $DB->select("*","tele2","`null123` = '{$value}'");
        while ($array = mysqli_fetch_array($DB->sql_query_select))
        { $list[] = $array; }
        foreach ($list as $key2 => $value2)
        {
            foreach ($value2 as $key3 => $value3)
            {
                if (!is_numeric($key3))
                { unset ($list[$key2][$key3]); }
            }
        }
    }

    foreach ($list as $key => $value)
    {
        $DB->insert("tele2_dump","null, '{$value[1]}', '{$value[2]}', '{$value[3]}', '{$value[4]}', '{$value[5]}', '{$value[6]}', '{$value[7]}', '{$value[8]}', '{$value[9]}', '{$value[10]}', '{$value[11]}', '{$value[12]}', '{$value[13]}', '{$value[14]}', '{$value[15]}', '{$value[16]}', '{$value[17]}', '{$value[18]}', '{$value[19]}', '{$value[20]}', '{$value[21]}', '{$value[22]}', '{$value[23]}'");
        $DB->delete("tele2","`null123` = '{$value[1]}'");
    }
    pre($list);
?>