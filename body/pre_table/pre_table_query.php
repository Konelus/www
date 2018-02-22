<?php
/* - - - - - - - - - - ↓ Добавление строки ↓ - - - - - - - - - - */
    if (isset ($_POST['add']))
    {
        $new_count = 0;
        $str = "null";
        while ($new_count < $max_td_count)
        { $str = $str.", '".$_POST['textBox'.$new_count]."'"; $new_count++; }

        $DB->insert("".$podcat_name[1],"".$str);

        // ↓ Добавление видимости новой строки ↓
        $SQL_QUERY_id = $mysqli->query("select * from `".$podcat_name[1]."` ORDER BY `id` ASC ");
        while ($row = mysqli_fetch_row($SQL_QUERY_id)) { $id = $row[0]; }

        $SQL_QUERY_td_count = $mysqli->query("SHOW COLUMNS FROM `".$podcat_name[1]."_vision`");
        $td_count = mysqli_num_rows($SQL_QUERY_td_count);

        $str = "null, '".($id)."'";
        for ($count = 1; $count <= ($td_count - 2); $count++)
        { $str = $str.", ''"; }

        $DB->insert($podcat_name[1]."_vision","".$str);

        if ($_COOKIE['user'] != 'admin')
        { $DB->update($podcat_name[1]."_vision`","".$_COOKIE['user'],"+","`id_tr` = '".$id."'"); }
        // ↑ Добавление видимости новой строки ↑
        header ("Location: /?".$podcat_name[1]);
    }
/* - - - - - - - - - - ↑ Добавление строки ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Добавление столбца ↓ - - - - - - - - - - */
    if (isset ($_POST['add_td']))
    {
        $DB->insert($podcat_name[1]."_table","null, '".$_POST['new_td']."', '".translit($_POST['new_td'])."'");
        $strSQL1 = $mysqli->query("ALTER TABLE ".$podcat_name[1]." ADD `".translit($_POST['new_td'])."` TEXT CHARACTER SET utf8 NOT NULL");
        $strSQL1 = $mysqli->query("ALTER TABLE ".$podcat_name[1]."_permission ADD `".translit($_POST['new_td'])."` TEXT CHARACTER SET utf8 NOT NULL");
        if ($_COOKIE['user'] != 'admin')
        {
            $DB->update($podcat_name[1]."_permission`","".translit($_POST['new_td']),"+","`".$podcat_name[1]."_group` = '" . $current_users_group[0] . "'");
            $DB->update($podcat_name[1]."_permission`","".translit($_POST['new_td']),"+","`".$podcat_name[1]."_group` = '" . $current_users_group[0] . "_edit'");
            $DB->update($podcat_name[1]."_permission`","".translit($_POST['new_td']),"-","`".$podcat_name[1]."_group` != '" . $current_users_group[0] . "' AND  `".$podcat_name[1]."_group` != '" . $current_users_group[0] . "_edit'");
        }
        else if ($_COOKIE['user'] == 'admin')
        { $DB->update($podcat_name[1]."_permission`","".translit($_POST['new_td']),"-",""); }
        header ("Location: /?".$podcat_name[1]);
    }

/* - - - - - - - - - - ↑ Добавление столбца ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Удаление строки ↓ - - - - - - - - - - */
    if (isset ($_POST['del_td']))
    {
        $SQL_QUERY_sql_name = $mysqli->query("select `sql_name` from `".$podcat_name[1]."_table` where `name` = '".$_POST['old_td']."' ");
        if ($SQL_QUERY_sql_name != null)
        {
            while ($row = mysqli_fetch_row($SQL_QUERY_sql_name))
            { $sql_name = $row[0]; }
        }

        $DB->delete($podcat_name[1]."_table","`sql_name` = '".$sql_name."'");
        $strSQL1 = $mysqli->query("ALTER TABLE ".$podcat_name[1]." DROP `".$sql_name."`");
        $strSQL1 = $mysqli->query("ALTER TABLE ".$podcat_name[1]."_permission DROP `".$sql_name."`");
        //echo "ALTER TABLE ".$podcat_name[1]." DROP `".$sql_name."`<br>";
        //echo "ALTER TABLE ".$podcat_name[1]."_permission DROP `".$sql_name."`";
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