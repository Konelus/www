<?php
/* - - - - - - - - - - ↓ Добавление строки ↓ - - - - - - - - - - */
    if (isset ($_POST['add']))
    {
        $str = "null";
        for ($count = 0; $count  < $max_td_count; $count++)
        { $str .= ", '{$_POST['textBox'.$count]}'"; }

        $DB->insert("{$substring}","{$str}");

        // ↓ Добавление видимости новой строки ↓
        $DB->select("*","{$substring}","","","id");
        //$SQL_QUERY_id = $mysqli->query("select * from `{$substring}` ORDER BY `id` ASC ");
        while ($row = mysqli_fetch_row($DB->sql_query_select)) { $id = $row[0]; }

        $DB->show("{$substring}_vision");
        //$SQL_QUERY_td_count = $mysqli->query("SHOW COLUMNS FROM `{$substring}_vision`");
        $td_count = mysqli_num_rows($DB->sql_query_show) - 1;

        $str = "null, '{$id}'";
        for ($count = 0; $count <= ($td_count - 2); $count++)
        { $str .= ", ''"; }

        $DB->insert("{$substring}_vision","{$str}");

        //if ($_COOKIE['user'] != 'admin')
        //{
            while ($row = mysqli_fetch_row($DB->sql_query_show))
            {
                if (($row[0] != 'id') && ($row[0] != 'id_tr'))
                { $DB->update("{$substring}_vision","{$row[0]}","+","`id_tr` = '{$id}'"); }
            }
        //}
        // ↑ Добавление видимости новой строки ↑
        header ("Location: /?{$substring}");
    }
/* - - - - - - - - - - ↑ Добавление строки ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Добавление столбца ↓ - - - - - - - - - - */
    if (isset ($_POST['add_td']))
    {
        if ($_POST['new_td'] != '')
        {
            $DB->select("sort","{$substring}_table");
            while ($row = mysqli_fetch_row($DB->sql_query_select))
            { $table_sort[] = $row[0]; }
            asort($table_sort);

            foreach ($table_sort as $key => $value)
            { $sort_id = $value; }
            $sort_id++;


            $DB->insert("{$substring}_table","null, '{$_POST['new_td']}', '".translit($_POST['new_td'])."', {$sort_id}");
            $DB->alter_add("{$substring}","".translit($_POST['new_td']),"TEXT CHARACTER SET utf8 NOT NULL");
            $DB->alter_add("{$substring}_permission","".translit($_POST['new_td']),"TEXT CHARACTER SET utf8 NOT NULL");
            //$strSQL1 = $mysqli->query("ALTER TABLE {$substring} ADD `".translit($_POST['new_td'])."` TEXT CHARACTER SET utf8 NOT NULL");
            //$strSQL1 = $mysqli->query("ALTER TABLE {$substring}_permission ADD `".translit($_POST['new_td'])."` TEXT CHARACTER SET utf8 NOT NULL");
            if ($_COOKIE['user'] != 'admin')
            {
                $DB->update("{$substring}_permission","".translit($_POST['new_td']),"+","`{$substring}_group` = '{$current_users_group}'");
                $DB->update("{$substring}_permission","".translit($_POST['new_td']),"+","`{$substring}_group` = '{$current_users_group}_edit'");
                $DB->update("{$substring}_permission","".translit($_POST['new_td']),"-","`{$substring}_group` != '{$current_users_group}' AND  `{$substring}_group` != '{$current_users_group}_edit'");
            }
            else if ($_COOKIE['user'] == 'admin')
            { $DB->update($substring."_permission`","".translit($_POST['new_td']),"-",""); }
            header ("Location: /?".$substring);
        }
        else { ?> <script>alert('Невозможно добавить пустой столбец!');</script> <?php }
    }
/* - - - - - - - - - - ↑ Добавление столбца ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Удаление строки ↓ - - - - - - - - - - */
    if (isset ($_POST['del_td']))
    {
        $sql_name = sql_name("{$substring}","{$_POST['old_td']}");
        $DB->delete("{$substring}_table","`sql_name` = '{$sql_name}'");
        $DB->alter_drop("{$substring}","{$sql_name}");
        $DB->alter_drop("{$substring}_permission","{$sql_name}");

        //$strSQL1 = $mysqli->query("ALTER TABLE {$substring} DROP `{$sql_name}`");
        //$strSQL1 = $mysqli->query("ALTER TABLE {$substring}_permission DROP `{$sql_name}`");

        $DB->select("sort","{$substring}_table");
        while ($row = mysqli_fetch_row($DB->sql_query_select))
        { $sort_array[$row[0]] = $row[0]; }
        ksort($sort_array);

        foreach ($sort_array as $key => $value)
        {
            if (($value != ($sort_array[$key - 1] + 1)) && ($value > 1))
            {
                $sort_array[$key]--;
                $DB->update("{$substring}_table","sort","{$sort_array[$key]}","`sort` = {$key}");
            }
        }


        header ("Location: /?".$substring);
    }
/* - - - - - - - - - - ↑ Удаление строки ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Выход пользователя ↓ - - - - - - - - - - */
    // ↓ Выход пользователя ↓
    if (isset ($_POST['exit'])) { setcookie('user', '', time() - 3600); header ("Location: /"); }
/* - - - - - - - - - - ↑ Выход пользователя ↑ - - - - - - - - - -  */


    if (isset ($_POST['lim_btn']))
    { $lim = $_POST['lim_text'] + 2; }

?>