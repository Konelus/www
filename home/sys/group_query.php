<?php

/* - - - - - - - - - - ↓ Добавление группы ↓ - - - - - - - - - - */
    if (isset ($_POST['add_group']))
    {
        $SQL_QUERY_add_to_table_select = $mysqli->query("SELECT * FROM `group_namespace` ");
        $sql_str = "null, '".$_POST['group_name']."'";
        for ($count = 1; $count <= ((mysqli_num_fields($SQL_QUERY_add_to_table_select) - 2 )); $count++)
        { $sql_str = $sql_str.", ''"; }
        $DB->insert("group_namespace","".$sql_str);
        header ("Location: /");
    }
/* - - - - - - - - - - ↑ Добавление группы ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Удаление группы ↓ - - - - - - - - - - */
    if (isset ($_POST['del_group']))
    {
        $DB->delete("group_namespace","`name` = '".$_POST['del_group_name']."'");
        $DB->update("users","table_group","","`table_group` = '".$_POST['del_group_name']."'");
        $DB->delete($_POST['selected_del_table']."_permission`","`".$_POST['selected_del_table']."_group` = '".$_POST['del_group_name']."'");
        $DB->delete($_POST['selected_del_table']."_permission`","`".$_POST['selected_del_table']."_group` = '".$_POST['del_group_name']."_edit'");
        header ("Location: /");
    }
/* - - - - - - - - - - ↑ Удаление группы ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Привязка группы к таблице ↓ - - - - - - - - - - */
    if (isset ($_POST['group_to_table']))
    {
        $DB->update("group_namespace","{$_POST['selected_table']}","+","`name` = '{$_POST['selected_group']}'");
        $DB->update("group_namespace","{$_POST['selected_table']}_status","{$_POST['selected_type']}","`name` = '{$_POST['selected_group']}'");

        $SQL_QUERY_select_group_users = $mysqli->query("SELECT `login` FROM `users` WHERE `table_group` = '{$_POST['selected_group']}' ");
        while ($row = mysqli_fetch_row($SQL_QUERY_select_group_users))
        {
            $DB->alter_add("{$_POST['selected_table']}_vision","{$row[0]}","TEXT CHARACTER SET utf8 NOT NULL");
            $DB->update("{$_POST['selected_table']}_vision","{$row[0]}","+","");
        }


        $SQL_QUERY_select_permission = $mysqli->query("SELECT * FROM `{$_POST['selected_table']}_permission` WHERE `{$_POST['selected_table']}_group` = '{$_POST['selected_group']}'");

        $SQL_QUERY_select_table_count = $mysqli->query("SELECT * FROM `{$_POST['selected_table']}_permission`");
        $sql_str_1 = "null, '{$_POST['selected_group']}'";
        $sql_str_2 = "null, '{$_POST['selected_group']}_edit'";
        for ($count = 1; $count <= (mysqli_num_fields($SQL_QUERY_select_table_count) - 2); $count++)
        {
            if ($_POST['selected_type'] == 'superuser')
            { $sql_str_1 .= ", '+'";      $sql_str_2 .= ", '+'"; }
            else { $sql_str_1 .= ", '-'"; $sql_str_2 .= ", '-'"; }
        }

        if (mysqli_num_rows($SQL_QUERY_select_permission) == 0)
        {
            $DB->insert("{$_POST['selected_table']}_permission","{$sql_str_1}");
            $DB->insert("{$_POST['selected_table']}_permission","{$sql_str_2}");
        }
        else if (mysqli_num_rows($SQL_QUERY_select_permission) > 0)
        {
            $DB->delete("{$_POST['selected_table']}_permission","`{$_POST['selected_table']}_group` = '{$_POST['selected_group']}'");
            $DB->delete("{$_POST['selected_table']}_permission","`{$_POST['selected_table']}_group` = '{$_POST['selected_group']}_edit'");
            $DB->insert("{$_POST['selected_table']}_permission","{$sql_str_1}");
            $DB->insert("{$_POST['selected_table']}_permission","{$sql_str_2}");
        }
    }
/* - - - - - - - - - - ↑ Привязка группы к таблице ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Отвязка группы от таблицы ↓ - - - - - - - - - - */
    if (isset ($_POST['group_to_table_del']))
    {
        $DB->update("group_namespace","{$_POST['selected_del_table']}","","`name` = '{$_POST['selected_del_group']}'");
        $DB->update("group_namespace","{$_POST['selected_del_table']}_status`","","`name` = '{$_POST['selected_del_group']}'");

        $SQL_QUERY_select_group_users = $mysqli->query("SELECT `login` FROM `users` WHERE `table_group` = '{$_POST['selected_del_group']}'");
        while ($row = mysqli_fetch_row($SQL_QUERY_select_group_users))
        { $SQL_QUERY_add_vision_users = $mysqli->query("ALTER TABLE `{$_POST['selected_del_table']}_vision` DROP `{$row[0]}`"); }

        $DB->delete($_POST['selected_del_table']."_permission`","`{$_POST['selected_del_table']}_group` = '{$_POST['selected_del_group']}'");
        $DB->delete($_POST['selected_del_table']."_permission`","`{$_POST['selected_del_table']}_group` = '{$_POST['selected_del_group']}_edit'");
    }
/* - - - - - - - - - - ↑ Отвязка группы от таблицы ↑ - - - - - - - - - - */
?>