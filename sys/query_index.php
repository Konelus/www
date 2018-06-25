<?php

/* - - - - - - - - - - ↓ Получение прав пользователя ↓ - - - - - - - - - - - */
//    if (isset ($_COOKIE['user']))
//    {
//        if ($_COOKIE['user'] == 'admin')
//        {
//            $TABLE->table_list();
//            $table_list = $TABLE->table_list;           // Получение списка всех таблиц
//        }
//        else if ($_COOKIE['user'] != 'admin')
//        {
//            $USER->user_group();
//            $USER->user_table();
//            $user_status = $USER->user_access_status;   // Получение прав пользователя на доступ к сайту
//            $current_users_group = $USER->user_group;   // Получение группы пользователя
//            $current_users_access = $USER->user_table;  // Получение списка таблиц доступных пользователю
//        }
//        $USER->user_fio();
//        $TABLE->table_list('1');
//        $user_fio = $USER->user_fio;                    // Получение ФИО пользователя
//        $released_table = $TABLE->table_list;           // Получение списка доступных таблиц
//
//        // БАГ! Переделать структуру. Сейчас выводится список всех доступных, потом список необходимых и сопастовление. Нужно на оборот!
//
//    }
/* - - - - - - - - - - ↑ Получение прав пользователя ↑ - - - - - - - - - - - */



/* - - - - - - - - - - ↓ Получение данных до Body ↓ - - - - - - - - - - - */
    if ($substring != '')
    {
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