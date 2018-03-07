<?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/use.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/body/sys/translit.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');


    $status = '';
    $descriptor = fopen($_SERVER['DOCUMENT_ROOT'].'/status.txt', 'r');
    if ($descriptor)
    {
        while (($string = fgets($descriptor)) !== false)
        { $status = $status.$string; }
        fclose($descriptor);
    }

    $page_title = 'ELASTIC 2';


    if (($status == 'enable') && (isset ($_COOKIE['user'])))
    {
        // ↓ Получение списка всех таблиц ↓
        $all_tables_count = 1;
        $DB->select("*","tables_namespace");
        while ($row = mysqli_fetch_row($DB->sql_query_select))
        {
            $all_tables_array[$all_tables_count][1] = $row[1];
            $all_tables_array[$all_tables_count][2] = $row[2];
            $all_tables_count++;
        }
        // ↑ Получение списка всех таблиц ↑

        $table_isset = false;

        // ↓ Получение группы пользователя ↓
        if ($_COOKIE['user'] != 'admin')
        {
            $DB->select("table_group","users", "`login` = '{$_COOKIE['user']}'");
            while ($row = mysqli_fetch_row($DB->sql_query_select))
            { $current_users_group = $row[0]; }
        }
        // ↑ Получение группы пользователя ↑


        // ↓ Получение группы пользователя ↓
        user_table("{$current_users_group}");
        $array = mysqli_fetch_array($DB->sql_query_select);
        foreach ($array as $key => $val)
        {
            if ((!is_numeric($key)) && ($val != ''))
            { $current_users_access[$key] = $val; }
        }
        // ↑ Получение группы пользователя ↑



        ver();


        if ($substring != '')
        {
            $DB->select("description","tables_namespace","`name` = '{$substring}'");
            while ($row = mysqli_fetch_row($DB->sql_query_select)) { $page_title = $row[0]; }
        }
       else { $page_title = 'ELASTIC 2'; }

        $DB->select("name","tables_namespace","`released` = '+'");
        while ($row = mysqli_fetch_row($DB->sql_query_select))
        { $table_name_array[] = $row[0]; }
    }

?>


<!DOCTYPE html>

<html lang="ru">
    <head>
        <title><?= $page_title ?></title>
        <link rel="shortcut icon" href="/img/favicon.png" type="image/png">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  
        <script src="dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    </head>

    <body>
        <?php

            if (isset ($_COOKIE['user']))
            {
                if (($_COOKIE['user'] != 'admin') && ($status == 'enable'))
                {
                    if ($substring == '') {require_once("home/home.php");}
                    else if ($substring != '')
                    {
                        foreach ($table_name_array as $key => $table_name)
                        { if ($table_name == $substring) { $table_isset = true; } }

                        if ($table_isset == true) { require_once("body/body.php"); }
                        else { require_once("home/home.php"); }
                    }
                }
                else if (($_COOKIE['user'] != 'admin') && ($status == 'disable')) {require_once("break.php");}


                else if ($_COOKIE['user'] == 'admin')
                {
                    if ($substring == '') {require_once("home/home.php");}
                    else if ($substring != '')
                    {
                        foreach ($table_name_array as $key => $table_name)
                        { if ($table_name == $substring) { $table_isset = true; } }

                        if ($table_isset == true) { require_once("body/body.php"); }
                        else { require_once("home/home.php"); }
                    }
                }

            }
            else if ($status == 'disable') { require_once("break.php"); }
            else if ($status == 'enable') { require_once("login/login.php"); }
            //exec('q.exe');

        unset ($row, $array, $key, $val);
            //pre(get_defined_vars());
         ?>
    </body>
</html>

