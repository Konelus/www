<?php
    if (isset ($_POST['clone']))
    {
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

        }
        $text = 'Клонирование vibory завершено!';
    }
?>


<div>
    <form method = 'post'>
        <input style = 'border: 0; background: white; color: navy; cursor: pointer;' type = 'submit' name = 'clone' value = 'Клонировать vibory'>
    </form>
</div>