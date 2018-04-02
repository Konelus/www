<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/use.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/body/sys/translit.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');


    $page_title = 'ELASTIC 2';


    if ((($site_status == 'enable') && (isset ($_COOKIE['user']))) || ($_COOKIE['user'] == 'admin'))
    {


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

                ver();
                $DB->update("ver","ver","".$current_ver[0].'.'.$current_ver[1].'.'.($current_ver[2] + 1));
            }
            //echo "<script>window.location.href = window.location.href;</script>";
            header("index.php");
        }



        $DB->select("status","users","`login` = '{$_COOKIE['user']}'");
        if ($row = mysqli_fetch_row($DB->sql_query_select))
        { $user_status = $row[0]; }

        $table_isset = false;

        if ($_COOKIE['user'] == 'admin')
        {
            // ↓ Получение списка всех таблиц ↓
            $count = 1;
            $DB->select("*","tables_namespace");
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
        // ↓ Получение группы пользователя ↓

            $DB->select("table_group","users", "`login` = '{$_COOKIE['user']}'");
            while ($row = mysqli_fetch_row($DB->sql_query_select))
            { $current_users_group = $row[0]; }

        // ↑ Получение группы пользователя ↑


        // ↓ Получение группы пользователя ↓
            if ($_COOKIE['user'] != 'deactivated')
            {
                $DB->select("*","group_namespace","`name` = '{$current_users_group}'");
                $array = mysqli_fetch_array($DB->sql_query_select);
                foreach ($array as $key => $value)
                {
                    if ((!is_numeric($key)) && ($value != ''))
                    { $current_users_access[$key] = $value; }
                }
            }
        }
        // ↑ Получение группы пользователя ↑



        ver();


        if ($substring != '')
        {
            $DB->select("description","tables_namespace","`name` = '{$substring}'");
            while ($row = mysqli_fetch_row($DB->sql_query_select)) { $page_title = $row[0]; }
        }
       else { $page_title = 'ELASTIC 2'; }


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
                if ((($_COOKIE['user'] == 'admin') && ($substring == '')) || ($_COOKIE['user'] != 'admin'))
                {
                    $count = 1;
                    $DB->select("*","tables_namespace", "`released` = '+'");
                    while ($row = mysqli_fetch_row($DB->sql_query_select))
                    {
                        $released_table[$count][1] = $row[1];
                        $released_table[$count][2] = $row[2];
                        $count++;
                    }
                    unset ($count);
                }
                if (($_COOKIE['user'] != 'admin') && ($site_status == 'enable'))
                {
                    if ($substring == '') {require_once("home/home.php");}
                    else if ($substring != '')
                    {
                        foreach ($released_table as $key => $value)
                        {
                            if (($value[1] == $substring) && ($user_status == '+')) { $table_isset = true; }
                        }
                        if ($table_isset == true) { require_once("body/body.php"); }
                        else { require_once("home/home.php"); }
                    }
                }
                else if (($_COOKIE['user'] != 'admin') && ($site_status == 'disable')) {require_once("break.php");}


                else if ($_COOKIE['user'] == 'admin')
                {
                    // ↓ Получение списка актуальных таблиц ↓
//                    $DB->select("name","tables_namespace");
//                    while ($row = mysqli_fetch_row($DB->sql_query_select))
//                    { $table_name_array[] = $row[0]; }
                    // ↑ Получение списка актуальных таблиц ↑

                    if ($substring == '') {require_once("home/home.php");}
                    else if ($substring != '')
                    {
                        foreach ($all_tables_array as $key => $value)
                        { if ($value[1] == $substring) { $table_isset = true; } }

                        if ($table_isset == true) { require_once("body/body.php"); }
                        else { require_once("home/home.php"); }
                    }
                }
            }
            else if ($site_status == 'disable') { require_once("break.php"); }
            else if ($site_status == 'enable')  { require_once("login/login.php"); }

            // ↓ Отладка переменных ↓
        //pre(get_defined_vars());
            unset ($row, $array, $key, $value);
            if ($_GET == null) { unset ($_GET); }
            if ($_POST == null) { unset ($_POST); }
            if ($_FILES == null) { unset ($_FILES); }
            if ($_REQUEST == null) { unset ($_REQUEST); }
            if ($_ENV == null) { unset ($_ENV); }
            if ($_COOKIE == null) { unset ($_COOKIE); }
            unset($_SERVER, $DB);
			
            //new dBug(get_defined_vars());
            //pre(get_defined_vars());
            // ↑ Отладка переменных ↑

         ?>
    </body>
</html>

