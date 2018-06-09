<?php

    ver();

/* - - - - - - - - - - ↓ Отключение сайта ↓ - - - - - - - - - - - */
    if (isset ($_POST['break']))
    {
        function write_status ($status)
        {
            $file = "{$_SERVER['DOCUMENT_ROOT']}/sys.txt";
            $lines = file("{$file}", FILE_IGNORE_NEW_LINES);
            $lines[0]  = "status = '{$status}';";
            file_put_contents("{$file}", implode(PHP_EOL, $lines));
        }

        if ($site_status == 'enable')
        {
            write_status("disable");
            $site_status = 'disable';
        }
        else if ($site_status == 'disable')
        {
            write_status("enable");
            $site_status = 'enable';

        }
        header("Location: /");
    }
/* - - - - - - - - - - ↑ Отключение сайта ↑ - - - - - - - - - - - */



/* - - - - - - - - - - ↓ Получение прав пользователя ↓ - - - - - - - - - - - */
    if (isset ($_COOKIE['user']))
    {
        if ($_COOKIE['user'] == 'admin')
        {
            // ↓ Получение списка всех таблиц ↓
            $count = 1;
            $DB->select("*", "tables_namespace");
            while ($row = mysqli_fetch_row($DB->sql_query_select))
            {
                $all_tables_array[$count][1] = $row[1];
                $all_tables_array[$count][2] = $row[2];
                $all_tables_array[$count][3] = $row[3];
                $count++;
            }
            unset ($count);
            // ↑ Получение списка всех таблиц ↑
        }
        else if ($_COOKIE['user'] != 'admin')
        {
            $USER->user_group();
            $USER->user_table();
            $user_status = $USER->user_access_status;  // Получение прав пользователя на доступ к сайту
            $current_users_group = $USER->user_group;  // Получение группы пользователя
            $current_users_access = $USER->user_table; // Получение списка таблиц доступных пользователю
        }
        $USER->user_fio();
        $user_fio = $USER->user_fio;               // Получение ФИО пользователя
    }
/* - - - - - - - - - - ↑ Получение прав пользователя ↑ - - - - - - - - - - - */



    /* ↓ Название страницы ↓ */
    if (($substring != '') && (strpos("$substring","/") == false))
    {
        $DB->select("description","tables_namespace","`name` = '{$substring}'");
        $page_title = implode(mysqli_fetch_row($DB->sql_query_select));
    }
    else { $page_title = 'ELASTIC 2'; }
    /* ↑ Название страницы ↑ */



/* - - - - - - - - - - ↓ Получение данных до Body ↓ - - - - - - - - - - - */
    if ($substring != '')
    {
//        /* ↓ Скрытие столбцов для Read Only ↓ */
//        foreach ($_POST as $key => $value)
//        {
//            if ($value == 'Скрыть столбец')
//            {
//                $DB->update("{$substring}_permission","{$key}","!","`{$substring}_group` = '{$current_users_group}'");
//                header("Location: /?{$substring}");
//                break;
//            }
//        }
//        /* ↑ Скрытие столбцов для Read Only ↑ */
//
//
//        /* ↓ Открытие столбцов для Read Only ↓ */
//        //echo $current_users_group;
//        if ((isset ($_POST['refresh'])) && ($current_users_group == 'ALLRO'))
//        {
//            $DB->select("*","{$substring}_permission","`{$substring}_group` = '$current_users_group'");
//            while ($array = mysqli_fetch_array($DB->sql_query_select)) { $perm_array = $array; }
//            foreach ($perm_array as $key => $value)
//            {
//                if (!is_numeric($key)) { unset($perm_array[$key]); }
//                if ($value == '!')
//                { $DB->update("{$substring}_permission","{$key}","+","`{$substring}_group` = '{$current_users_group}'"); }
//            }
//        }
//        //else if ((isset ($_POST['refresh'])) && ($current_users_group != 'ALLRO'))
//        //{
//        //}
//        /* ↑ Открытие столбцов для Read Only ↑ */


        /* ↓ Загрузка файлов ↓ */
        if (($substring != '') && (strpos("$substring","/") == false))
        {
            $DB->show("{$substring}");
            while ($row = mysqli_fetch_row($DB->sql_query_show))
            { $substring_table[] = $row[0]; }

            foreach ($substring_table as $key => $value)
            { if ($value == 'load_file') { $load_file_bool = true; break; } }

            $DB->select("*","{$substring}");
            while ($array = mysqli_fetch_array($DB->sql_query_select))
            { if($array['load_file'] != '') { $load_file[$array['id']] = $array['load_file']; } }
            $max_count = mysqli_num_rows($DB->sql_query_select);
        }

        /* ↑ Загрузка файлов ↑ */
    }
/* - - - - - - - - - - ↑ Получение данных до Body ↑ - - - - - - - - - - - */
?>