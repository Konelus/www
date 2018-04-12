<?php

/* - - - - - - - - - - ↓ Добавление группы ↓ - - - - - - - - - - */
    if (isset ($_POST['add_group']))
    {
        $sql_str = "null, {$_POST['group_name']}";
        $DB->select("*", "group_namespace");
        for ($count = 1; $count <= ((mysqli_num_fields($DB->sql_query_select) - 2 )); $count++)
        { $sql_str .= ", ''"; }
        $DB->insert("group_namespace","{$sql_str}");
        header ("Location: /");
    }
/* - - - - - - - - - - ↑ Добавление группы ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Удаление группы ↓ - - - - - - - - - - */
    if (isset ($_POST['del_group']))
    {
        $DB->delete("group_namespace","`name` = '".$_POST['del_group_name']."'");
        $DB->update("users","table_group","","`table_group` = '".$_POST['del_group_name']."'");
        $DB->delete("{$_POST['selected_del_table']}_permission","`".$_POST['selected_del_table']."_group` = '".$_POST['del_group_name']."'");
        $DB->delete("{$_POST['selected_del_table']}_permission","`".$_POST['selected_del_table']."_group` = '".$_POST['del_group_name']."_edit'");
        header ("Location: /");
    }
/* - - - - - - - - - - ↑ Удаление группы ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Привязка группы к таблице ↓ - - - - - - - - - - */
    if (isset ($_POST['group_to_table']))
    {
        foreach ($released_table as $key => $value)
        {
            if ($value[2] == $_POST['selected_table'])
            { $selected_table = $value[1]; }
        }

        $DB->update("group_namespace","{$selected_table}","+","`name` = '{$_POST['selected_group']}'");
        $DB->update("group_namespace","{$selected_table}_status","{$_POST['selected_type']}","`name` = '{$_POST['selected_group']}'");

        $DB->select("login","users","`table_group` = '{$_POST['selected_group']}'");
        while ($row = mysqli_fetch_row($DB->sql_query_select))
        {
            $DB->alter_add("{$selected_table}_vision","{$row[0]}","TEXT CHARACTER SET utf8 NOT NULL");
            $DB->update("{$selected_table}_vision","{$row[0]}","+");
        }


        $DB->select("*","{$selected_table}_permission","`{$selected_table}_group` = '{$_POST['selected_group']}'");
        $SQL_QUERY_select_permission = $DB->sql_query_select;

        $DB->select("*","{$selected_table}_permission");
        $SQL_QUERY_select_table_count = $DB->sql_query_select;
        $sql_str_1 = "null, '{$_POST['selected_group']}'";
        $sql_str_2 = "null, '{$_POST['selected_group']}_edit'";
        for ($count = 1; $count <= (mysqli_num_fields($SQL_QUERY_select_table_count) - 2); $count++)
        {
            if ($_POST['selected_type'] == 'superuser')
            {       $sql_str_1 .= ", '+'"; $sql_str_2 .= ", '+'"; }
            else {  $sql_str_1 .= ", '-'"; $sql_str_2 .= ", '-'"; }
        }

        if (mysqli_num_rows($SQL_QUERY_select_permission) == 0)
        {
            $DB->insert("{$selected_table}_permission","{$sql_str_1}");
            $DB->insert("{$selected_table}_permission","{$sql_str_2}");
        }
        else if (mysqli_num_rows($SQL_QUERY_select_permission) > 0)
        {
            $DB->delete("{$selected_table}_permission","`{$selected_table}_group` = '{$_POST['selected_group']}'");
            $DB->delete("{$selected_table}_permission","`{$selected_table}_group` = '{$_POST['selected_group']}_edit'");
            $DB->insert("{$selected_table}_permission","{$sql_str_1}");
            $DB->insert("{$selected_table}_permission","{$sql_str_2}");
        }
    }
/* - - - - - - - - - - ↑ Привязка группы к таблице ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Отвязка группы от таблицы ↓ - - - - - - - - - - */
    if (isset ($_POST['group_to_table_del']))
    {

        foreach ($released_table as $key => $value)
        {
            if ($value[2] == $_POST['selected_del_table'])
            { $selected_table = $value[1]; }
        }

        $DB->update("group_namespace","{$selected_table}","","`name` = '{$_POST['selected_del_group']}'");
        $DB->update("group_namespace","{$selected_table}_status","","`name` = '{$_POST['selected_del_group']}'");

        $DB->select("login","users","`table_group` = '{$_POST['selected_del_group']}'");
        while ($row = mysqli_fetch_row($DB->sql_query_select))
        { $DB->alter_drop("{$selected_table}_vision","{$row[0]}"); }

        $DB->delete("{$selected_table}_permission","`{$selected_table}_group` = '{$_POST['selected_del_group']}'");
        $DB->delete("{$selected_table}_permission","`{$selected_table}_group` = '{$_POST['selected_del_group']}_edit'");
    }
/* - - - - - - - - - - ↑ Отвязка группы от таблицы ↑ - - - - - - - - - - */
?>