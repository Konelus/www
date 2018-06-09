<?php
    $title1 = '';
    $table_count = 0;
    $table_count1 = 2;  // ← Счетчик шапки


    // ↓ Получение информации о правах пользователя ↓
    if ($_COOKIE['user'] != 'admin')
    {
        $USER->user_permission($substring);
        $vision = $USER->user_cell_vision;
        $permission = $USER->user_cell_edit;
        $title = $USER->user_cell_vision_name;
        $data = $TABLE->table_data;
        //pre($vision);
    }

    $TABLE->current_table($substring,$vision);


    //pre($vision);
    //pre($permission);
    //exit;
    // ↑ Получение информации о правах пользователя ↑






    $bool_var = 0;
    //$bool_var_2 = false;
    if (isset ($_POST['hide']))
    { $bool_var = 1; }


    // ↓ Получение списка отображаемых столбцах ↓
//    $DB->select("*","{$substring}_table");
//    if ($DB->sql_query_select != null)
//    {
//        $max_td_count = mysqli_num_rows($DB->sql_query_select);
//
//        //echo "<span style = 'color: red;'>{$max_td_count}</span><br>";
//        while ($row = mysqli_fetch_row($DB->sql_query_select))
//        {
//            if (($title1[$table_count1] == '+') && ($_COOKIE['user'] != 'admin'))
//            {
//                $new_td[$table_count + 1] = ($table_count1 - 1);
//                $table[$row[3]] = $row[1];
//                $table_count++;
//                $max_td_count_1 = $table_count;
//            }
//            else if ($_COOKIE['user'] == 'admin')
//            {
//                $new_td[$table_count + 1] = ($table_count1 - 1);
//                $table[$row[3]] = $row[1];
//                $table_count++;
//            }
//            $table_count1++;
//        }
//    }
    //pre($table);
    //ksort($table);

    //pre($table);
//    $count = 1;
//    foreach ($table as $key => $value)
//    {
//        unset($table[$key]);
//        $table[$count] = $value;
//        $count++;
//    }
    //pre($table);
    // ↑ Получение списка отображаемых столбцах ↑


    // ↓ Запись в переменные названий всех столбцов таблицы ↓
//    $DB->select("*","{$substring}_table");
//    if ($DB->sql_query_select != null)
//    {
//        $count = 0;
//        while ($row = mysqli_fetch_row($DB->sql_query_select))
//        {
//            if (($title1[$count + 2] == '+') && ($_COOKIE['user'] != 'admin'))
//            { $table_sql[$row[3]] = $row[2]; }
//            else if ($_COOKIE['user'] == 'admin')
//            { $table_sql[$row[3]] = $row[2]; }
//            $count++;
//        }
//        unset ($count);
//        ksort($table_sql);
//    }
    //pre(get_defined_vars());
    // ↑ Запись в переменные названий всех столбцов таблицы ↑
?>