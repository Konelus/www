<?php
/* - - - - - - - - - - ↓ Добавление строки ↓ - - - - - - - - - - */
    if (isset ($_POST['add']))
    {
        $str = "null";
        for ($count; $count  < $max_td_count; $count++)
        { $str .= ", '{$_POST['textBox'.$count]}'"; }

        $DB->insert("{$substring}","{$str}");

        // ↓ Добавление видимости новой строки ↓
        $SQL_QUERY_id = $mysqli->query("select * from `{$substring}` ORDER BY `id` ASC ");
        while ($row = mysqli_fetch_row($SQL_QUERY_id)) { $id = $row[0]; }

        $SQL_QUERY_td_count = $mysqli->query("SHOW COLUMNS FROM `{$substring}_vision`");
        $td_count = mysqli_num_rows($SQL_QUERY_td_count);

        $str = "null, '{$id}'";
        for ($count = 1; $count <= ($td_count - 2); $count++)
        { $str .= ", ''"; }

        $DB->insert("{$substring}_vision","{$str}");

        if ($_COOKIE['user'] != 'admin')
        { $DB->update("{$substring}_vision`","{$_COOKIE['user']}","+","`id_tr` = '{$id}'"); }
        // ↑ Добавление видимости новой строки ↑
        header ("Location: /?{$substring}");
    }
/* - - - - - - - - - - ↑ Добавление строки ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Добавление столбца ↓ - - - - - - - - - - */
    if (isset ($_POST['add_td']))
    {
        $DB->insert($podcat_name[1]."_table","null, '".$_POST['new_td']."', '".translit($_POST['new_td'])."'");
        $strSQL1 = $mysqli->query("ALTER TABLE {$substring} ADD `".translit($_POST['new_td'])."` TEXT CHARACTER SET utf8 NOT NULL");
        $strSQL1 = $mysqli->query("ALTER TABLE {$substring}_permission ADD `".translit($_POST['new_td'])."` TEXT CHARACTER SET utf8 NOT NULL");
        if ($_COOKIE['user'] != 'admin')
        {
            $DB->update("{$podcat_name[1]}_permission`","".translit($_POST['new_td']),"+","`{$podcat_name[1]}_group` = '{$current_users_group[0]}'");
            $DB->update("{$podcat_name[1]}_permission`","".translit($_POST['new_td']),"+","`{$podcat_name[1]}_group` = '{$current_users_group[0]}_edit'");
            $DB->update("{$podcat_name[1]}_permission`","".translit($_POST['new_td']),"-","`{$podcat_name[1]}_group` != '{$current_users_group[0]}' AND  `{$podcat_name[1]}_group` != '{$current_users_group[0]}_edit'");
        }
        else if ($_COOKIE['user'] == 'admin')
        { $DB->update($podcat_name[1]."_permission`","".translit($_POST['new_td']),"-",""); }
        header ("Location: /?".$podcat_name[1]);
    }
/* - - - - - - - - - - ↑ Добавление столбца ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Удаление строки ↓ - - - - - - - - - - */
    if (isset ($_POST['del_td']))
    {
        sql_name("{$substring}","{$_POST['old_td']}"); $sql_name = $result;

        $DB->delete("{$podcat_name[1]}_table","`sql_name` = '{$sql_name}'");
        $strSQL1 = $mysqli->query("ALTER TABLE {$podcat_name[1]} DROP `{$sql_name}`");
        $strSQL1 = $mysqli->query("ALTER TABLE {$podcat_name[1]}_permission DROP `{$sql_name}`");
        header ("Location: /?".$podcat_name[1]);
    }
/* - - - - - - - - - - ↑ Удаление строки ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Выход пользователя ↓ - - - - - - - - - - */
    // ↓ Выход пользователя ↓
    if (isset ($_POST['exit'])) { setcookie('user', '', time() - 3600); header ("Location: /"); }
/* - - - - - - - - - - ↑ Выход пользователя ↑ - - - - - - - - - -  */


    if (isset ($_POST['lim_btn']))
    { $lim = $_POST['lim_text'] + 2; }

?>