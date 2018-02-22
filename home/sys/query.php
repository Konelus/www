<?php
    //$selected_table_name = 'vibory';

/* - - - - - - - - - - ↓ Получение названий столбцов таблицы ↓ - - - - - - - - - - */
    $table_count = 0;
    $table_query = $mysqli->query("select `name` from `".$selected_table_name."_table`");
    if ($table_query != null)
    {
        while ($row = mysqli_fetch_row($table_query))
        { $table[$table_count] = $row[0]; $table_count++; }
        $max_td_count = mysqli_num_rows($table_query);
    }
/* - - - - - - - - - - ↑ Получение названий столбцов таблицы ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Получение sql-названий столбцов таблицы ↓ - - - - - - - - - - */
    $table_count_sql = 0;
    $table_query_2 = $mysqli->query("select `sql_name` from `".$selected_table_name."_table`");
    if ($table_query_2 != null)
    {
        while ($row = mysqli_fetch_row($table_query_2))
        { $table_sql[$table_count_sql] = $row[0]; $table_count_sql++; }
    }
/* - - - - - - - - - - ↑ Получение sql-названий столбцов таблицы ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Получение числа столбцов таблицы ↓ - - - - - - - - - - */
    //$table_query_1 = $mysqli->query("select `name` from `".$selected_table_name."_table`");
    //if ($table_query_1 != null) { $max_td_count = mysqli_num_rows($table_query_1); }
/* - - - - - - - - - - ↑ Получение числа столбцов таблицы ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Изменение видимости столбцов для пользователя ↓ - - - - - - - - - - */
    $str = "null, '".$_POST['group']."'";
    $str_edit = "null, '".$_POST['group']."_edit'";
    $group_perm_isset = 'false';
    $group_perm_edit_isset = 'false';



    if (isset($_POST['confirm']))
    {

        // ↓ Проверка на существование правила ↓
        $check_count = 0;
        $check_query = $mysqli->query("select `".$selected_table_name."_group` from `".$selected_table_name."_permission` ");
        if ($check_query != null)
        {
            while ($row = mysqli_fetch_row($check_query))
            {
                $check[$check_count] = $row[0];
                if ($check[$check_count] == $_POST['group'])
                { $group_perm_isset = 'true'; }

                if ($check[$check_count] == $_POST['group'].'_edit')
                { $group_perm_edit_isset = 'true'; }
                $check_count++;
            }
        }
        // ↑ Проверка на существование правила ↑


        // ↓ Формирование запроса ↓
        for ($str_count = 0; $str_count < $max_td_count; $str_count++)
        {
            $str = $str.", '".$_POST['textBox'.$str_count]."'";
            $str_edit = $str_edit.", '".$_POST['edit_listBox'.$str_count]."'";
        }
        // ↑ Формирование запроса ↑


        // ↓ Отправка запроса ↓
        if ($_POST['group'] != '')
        {
            if ($group_perm_isset == 'false')
            { $DB->insert($selected_table_name . "_permission","".$str); }
            else if ($group_perm_isset == 'true')
            {
                for ($td_count = 0; $td_count <= $max_td_count - 1; $td_count++)
                { $DB->update($selected_table_name."_permission","".$table_sql[$td_count],"". $_POST['textBox' . $td_count],"`".$selected_table_name."_group` = '" . $_POST['group'] . "'"); }
            }

            if ($group_perm_edit_isset == 'false')
            { $DB->insert($selected_table_name . "_permission","".$str_edit); }
            else if ($group_perm_edit_isset == 'true')
            {
                for ($td_count = 0; $td_count <= $max_td_count - 1; $td_count++)
                { $DB->update($selected_table_name . "_permission","".$table_sql[$td_count],"".$_POST['edit_listBox'.$td_count],"`".$selected_table_name."_group` = '".$_POST['group']."_edit'"); }
            }
        }
        // ↑ Формирование запроса ↑
    }
/* - - - - - - - - - - ↑ Изменение видимости столбцов для пользователя ↑ - - - - - - - - - - */


    $all_user_count = 0;
    $ege_user_count = 0;
    $all_user_group_count = 0;
    $all_group_count = 0;


    // ↓ Получение информации о правах пользователя ↓
    if ((isset ($_POST['edit_users_permissions'])) || (isset ($_POST['confirm'])))
    {


        if (isset($_POST['confirm']))
        {
            $group_name = $_POST['group'];
            ?> <script>$(document).ready(function () { $('input[name = "group"]').val("<?= $group_name ?>"); }); </script><?php
            $group_name = $_POST['group'];
            $permissions_query = $mysqli->query("select * from `" . $selected_table_name . "_permission` where `" . $selected_table_name . "_group` = '" . $_POST['group'] . "' ");
            $permissions_edit_query = $mysqli->query("select * from `" . $selected_table_name . "_permission` where `" . $selected_table_name . "_group` = '" . $_POST['group'] . "_edit' ");
        }
        else
        {
            if ($_POST['group_for_edit'] == '')
            { $group_name = $_POST['group']; }
            else { $group_name = $_POST['group_for_edit']; }
            ?> <script>$(document).ready(function () { $('input[name = "group"]').val("<?= $group_name ?>"); }); </script><?php
            $permissions_query = $mysqli->query("select * from `" . $selected_table_name . "_permission` where `" . $selected_table_name . "_group` = '" . $_POST['group_for_edit'] . "' ");
            $permissions_edit_query = $mysqli->query("select * from `" . $selected_table_name . "_permission` where `" . $selected_table_name . "_group` = '" . $_POST['group_for_edit'] . "_edit' ");
        }
        if ($permissions_query != null)
        {
            $permission = mysqli_fetch_array($permissions_query);
            $permission_edit = mysqli_fetch_array($permissions_edit_query);
        }
    }


    // ↑ Получение информации о правах пользователя ↑


    // ↓ Получение списка пользователей ↓
    $users = $mysqli->query("select `login` from `users`");
    while ($row = mysqli_fetch_row($users))
    { $all_users[$all_user_count] = $row[0]; $all_user_count++; }
    // ↑ Получение списка пользователей ↑


    // ↓ Получение пользовательских групп ↓
    $users_group = $mysqli->query("select `table_group` from `users`");
    while ($row = mysqli_fetch_row($users_group))
    { $all_users_group[$all_user_group_count] = $row[0]; $all_user_group_count++; }
    // ↑ Получение пользовательских групп ↑


    // ↓ Получение списка всех групп ↓
    $users_group = $mysqli->query("select `name` from `group_namespace`");
    while ($row = mysqli_fetch_row($users_group))
    { $all_group[$all_group_count] = $row[0]; $all_group_count++; }
    // ↑ Получение списка всех групп  ↑





    // ↓ Добавление пользователя ↓
    if (isset ($_POST['add_user']))
    {
        $DB->insert("users","null, '".$_POST['login']."','".$_POST['password']."', '', '', '".$_POST['fio']."','".$_POST['position']."', '".$_POST['phone']."','".$_POST['mail']."'");
        header ("Location: /");
    }
    // ↑ Добавление пользователя ↑


    // ↓ Удаление пользователя ↓
    if (isset ($_POST['del_user']))
    {
        $DB->delete("users","`login` = '".$_POST['del_user_name']."'");
        header ("Location: /");
    }
    // ↑ Удаление пользователя ↑





    // ↓ Изменение группы пользователя ↓
    if (isset ($_POST['edit_users_group']))
    {
        $DB->update("users","table_group","".$_POST['selected_group'],"`login` = '".$_POST['selected_user']."'");
        header ("Location: /");
    }
    // ↑ Изменение группы пользователя ↑



    // ↓ Выход ↓
    if (isset ($_POST['exit']))
    {
        setcookie('user', '', time() - 3600);
        header ("Location: /");
    }
    // ↑ Выход ↑


    // ↓ Отправка письма ↓
    if (isset ($_POST['send_mail']))
    { mail("rtk.tech.mail@yandex.ru", "".$_COOKIE['user'], "".$_POST['mail_text']); }
    // ↑ Отправка письма ↑


    $mass_count = 1;
    $MYSQL_QUERY_all_tables = $mysqli->query("select * from `tables_namespace`");
    while ($row = mysqli_fetch_row($MYSQL_QUERY_all_tables))
    {
        $mass[$mass_count][1] = $row[1];
        $mass[$mass_count][2] = $row[2];
        $mass_count++;
    }

?>