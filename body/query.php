<?php
    //$current_users_group = '';
    $title1 = '';
    $table_count = 0;
    $table_count1 = 2;  // ← Счетчик шапки





    // ↓ Получение информации о правах пользователя ↓
    if ($_COOKIE['user'] != 'admin')
    {
        $DB->select("*","{$substring}_permission","`{$substring}_group` = '{$current_users_group}'");
        if ($DB->sql_query_select != null)
        { $title1 = mysqli_fetch_row($DB->sql_query_select); }
    }
    // ↑ Получение информации о правах пользователя ↑


    $bool_var = 0;
    $bool_var_2 = 0;
    if (isset ($_POST['hide']))
    { $bool_var = 1; }


    // ↓ Получение списка отображаемых столбцах ↓
    $DB->select("name","{$substring}_table","");
    if ($DB->sql_query_select != null)
    {
        $max_td_count = mysqli_num_rows($DB->sql_query_select);

        while ($row = mysqli_fetch_row($DB->sql_query_select))
        {
            if (($title1[$table_count1] == '+') && ($_COOKIE['user'] != 'admin'))
            {
                $new_td[$table_count + 1] = ($table_count1 - 1);
                $table[$table_count + 1] = $row[0];
                $table_count++;
                $max_td_count_1 = $table_count;
            }
            else if ($_COOKIE['user'] == 'admin')
            {
                $new_td[$table_count + 1] = ($table_count1 - 1);
                $table[$table_count] = $row[0];
                $table_count++;
            }
            $table_count1++;
        }
    }
    // ↑ Получение списка отображаемых столбцах ↑


    // ↓ Запись в переменные названий всех столбцов таблицы ↓
    $DB->select("sql_name","{$substring}_table");
    if ($DB->sql_query_select != null)
    {
        $count = 0;
        while ($row = mysqli_fetch_row($DB->sql_query_select))
        {
            if (($title1[$count + 2] == '+') && ($_COOKIE['user'] != 'admin'))
            { $table_sql[$count] = $row[0]; }
            else if ($_COOKIE['user'] == 'admin')
            { $table_sql[] = $row[0]; }
            $count++;
        }
        unset ($count);
    }
    // ↑ Запись в переменные названий всех столбцов таблицы ↑


    // ↓ Получение доступных таблиц пользователя ↓
    //user_table("{$current_users_group}");
    //while ($array = mysqli_fetch_array($DB->sql_query_select))
    //{ $current_users_access = $array; }
    // ↑ Получение доступных таблиц пользователя ↑

?>