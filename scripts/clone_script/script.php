<?php
    if (isset ($_POST['clone']))
    {
        //$q = $mysqli->query("DELETE FROM `vibory_sys`");
        $SQL_QUERY_select_table1 = $mysqli->query("SELECT * FROM `vibory_sys`");
        while ($query_array = mysqli_fetch_array($SQL_QUERY_select_table1))
        {
            $sys_td[$query_array[0]][1] = $query_array['id_obekta_skup'];
            $sys_td[$query_array[0]][2] = $query_array['adres_uik_tik'];
        }

        $SQL_QUERY_select_table2 = $mysqli->query("SELECT * FROM `vibory`");
        while ($query_table_array = mysqli_fetch_row($SQL_QUERY_select_table2))
        {
            if ($sys_td[$query_table_array[0]][1] != $query_table_array[1])
            { $SQL_QUERY_update_sys = $mysqli->query("UPDATE `vibory_sys` SET `id_obekta_skup` = '".$query_table_array[1]."' WHERE `id` = $query_table_array[0] "); }

            if ($sys_td[$query_table_array[0]][2] != $query_table_array[2])
            { $SQL_QUERY_update_sys = $mysqli->query("UPDATE `vibory_sys` SET `adres_uik_tik` = '".$query_table_array[2]."' WHERE `id` = $query_table_array[0] "); }

            //$SQL_QUERY_update_sys = $mysqli->query("INSERT INTO `vibory_sys` values ('".$query_table_array[0]."', '".$query_table_array[1]."', '".$query_table_array[2]."', '".$query_table_array[39]."', '".$query_table_array[40]."') ");
        }
        $text = 'Клонирование vibory завершено!';
    }
?>

<div style = 'margin-top: 10px; margin-bottom: 10px; width: 45%; float: left; margin-left: 5%;'>
    <form method = 'post'>
        <input style = 'margin: auto; width: 100%; height: 40px; background: gold; border-radius: 5px; border: solid 1px black;' type = 'submit' name = 'clone' value = 'Клонировать vibory'>
    </form>
</div>