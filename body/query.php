<?php
    $current_users_group = '';
    $title1 = '';
    $table_count = 0;
    $table_count1 = 2;  // ← Счетчик шапки
    $table_count_sql = 0;


    // ↓ Получение числа строк ↓
    $max_tr_query = $mysqli->query("select * from `".$podcat_name[1]."` ");
    if ($max_tr_query != null)
    { $max_count = mysqli_num_rows($max_tr_query); }
    // ↑ Получение числа строк ↑


    // ↓ Получение группы пользователя ↓
    $qq = $mysqli->query("select `table_group` from `users` where `login` = '".$_COOKIE['user']."' ");
    while ($row = mysqli_fetch_row($qq))
    { $current_users_group[0] = $row[0]; }
    // ↑ Получение группы пользователя ↑


    // ↓ Получение информации о правах пользователя ↓
    if ($_COOKIE['user'] != 'admin')
    { $permissions_query = $mysqli->query("select * from `" . $podcat_name[1] . "_permission` where `".$podcat_name[1]."_group` = '" . $current_users_group[0] . "' "); }
    if ($permissions_query != null)
    { $title1 = mysqli_fetch_array($permissions_query); }
    // ↑ Получение информации о правах пользователя ↑


    $bool_var = 0;
    $bool_var_2 = 0;
    if (isset ($_POST['hide']))
    { $bool_var = 1; }


    $table_query_1 = $mysqli->query("select `name` from `".$podcat_name[1]."_table`");
    if ($table_query_1 != null)
    {
        $max_td_count = mysqli_num_rows($table_query_1);

        while ($row = mysqli_fetch_row($table_query_1))
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


    // ↓ Запись в переменные названий всех столбцов таблицы ↓
    $table_query_2 = $mysqli->query("select `sql_name` from `".$podcat_name[1]."_table`");
    if ($table_query_2 != null)
    {
        while ($row = mysqli_fetch_row($table_query_2))
        { $table_sql[$table_count_sql] = $row[0]; $table_count_sql++; }
    }
    // ↑ Запись в переменные названий всех столбцов таблицы ↑

    // ↓ Получение группы пользователя ↓
    $SQL_QUERY_tables_access = $mysqli->query("select * from `group_namespace` where `name` = '".$current_users_group[0]."' ");
    while ($row = mysqli_fetch_array($SQL_QUERY_tables_access))
    { $current_users_access = $row; }
    //print_r($current_users_access);
    // ↑ Получение группы пользователя ↑
?>