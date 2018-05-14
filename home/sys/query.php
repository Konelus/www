<?php

    if ($_COOKIE['user'] == 'admin')
    {


    /* - - - - - - - - - - ↓ Изменение видимости столбцов для пользователя ↓ - - - - - - - - - - */
        $str = "null, '{$_POST['group']}'";
        $str_edit = "null, '".$_POST['group']."_edit'";
        $group_perm_isset = false;
        $group_perm_edit_isset = 'false';



        if (isset($_POST['confirm']))
        {
            // ↓ Проверка на существование правила ↓
            $DB->select("{$selected_table_name}_group","{$selected_table_name}_permission");
            if ($DB->sql_query_select != null)
            {
                while ($row = mysqli_fetch_row($DB->sql_query_select))
                {$check[] = $row[0];}

                foreach ($check as $key => $value)
                {
                    if ($check[$key] == $_POST['group'])
                    { $group_perm_isset = true; }

                    if ($check[$key] == "{$_POST['group']}_edit")
                    { $group_perm_edit_isset = 'true'; }
                }
            }
            // ↑ Проверка на существование правила ↑


            // ↓ Формирование запроса ↓
            for ($str_count = 0; $str_count < count($title_array); $str_count++)
            {
                $str .= ", '{$_POST["listBox_{$str_count}"]}'";
                $str_edit .= ", '{$_POST["edit_listBox_{$str_count}"]}'";
            }
            // ↑ Формирование запроса ↑


            // ↓ Отправка запроса ↓
            if ($_POST['group'] != '')
            {
                //$DB->select("sql_name","{$selected_table_name}_table");
                //while ($row = mysqli_fetch_row($DB->sql_query_select))
                //{ $table_sql[] = $row[0]; }
                if ($group_perm_isset == false)
                { $DB->insert("{$selected_table_name}_permission","{$str}"); }
                else if ($group_perm_isset == true)
                {
                    for ($td_count = 0; $td_count <= count($title_array) - 1; $td_count++)
                    { $DB->update("{$selected_table_name}_permission","{$title_array[$td_count][2]}","{$_POST["listBox_{$td_count}"]}","`{$selected_table_name}_group` = '{$_POST['group']}'"); }
                }

                if ($group_perm_edit_isset == 'false')
                { $DB->insert("{$selected_table_name}_permission","{$str_edit}"); }
                else if ($group_perm_edit_isset == 'true')
                {
                    for ($td_count = 0; $td_count <= count($title_array) - 1; $td_count++)
                    { $DB->update("{$selected_table_name}_permission","{$title_array[$td_count][2]}","{$_POST["edit_listBox_{$td_count}"]}","`{$selected_table_name}_group` = '{$_POST['group']}_edit'"); }
                }
            }
            // ↑ Формирование запроса ↑
        }
    /* - - - - - - - - - - ↑ Изменение видимости столбцов для пользователя ↑ - - - - - - - - - - */







        // ↓ Получение информации о правах пользователя ↓
        if ((isset ($_POST['edit_users_permissions'])) || (isset ($_POST['confirm'])))
        {


            if (isset($_POST['confirm']))
            {
                $group_name = $_POST['group'];
                ?> <script>$('input[name = "group"]').val("<?= $group_name ?>");</script><?php
                $group_name = $_POST['group'];

                permission("{$selected_table_name}", "{$_POST['group']}");
                $permissions_query = $DB->sql_query_select;
                permission("{$selected_table_name}", "{$_POST['group']}_edit");
                $permissions_edit_query = $DB->sql_query_select;
            }
            else
            {
                if ($_POST['group_for_edit'] == '')
                { $group_name = $_POST['group']; }
                else { $group_name = $_POST['group_for_edit']; }
                ?> <script>$('input[name = "group"]').val("<?= $group_name ?>");</script><?php

                permission("{$selected_table_name}","{$_POST['group_for_edit']}");
                $permissions_query = $DB->sql_query_select;
                permission("{$selected_table_name}", "{$_POST['group_for_edit']}_edit");
                $permissions_edit_query = $DB->sql_query_select;
            }

            if ($permissions_query != null)
            {
                $permission = mysqli_fetch_array($permissions_query);
                $permission_edit = mysqli_fetch_array($permissions_edit_query);
            }
        }
        // ↑ Получение информации о правах пользователя ↑












        // ↓ Добавление пользователя ↓
        if (isset ($_POST['add_user']))
        {
            $DB->insert("users","null, '{$_POST['login']}','{$_POST['password']}', '', '', '{$_POST['fio']}','{$_POST['position']}', '{$_POST['phone']}','{$_POST['mail']}', '+'");
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
    }









    // ↓ Выход ↓
    if (isset ($_POST['exit']))
    {
        setcookie('user', '', time() - 3600);
        header ("Location: /");
    }
    // ↑ Выход ↑


    // ↓ Отправка письма ↓
    if (isset ($_POST['send_mail']))
    { mail("rtk.tech.mail@yandex.ru", "{$_COOKIE['user']}", "{$_POST['mail_text']}"); }
    // ↑ Отправка письма ↑
?>