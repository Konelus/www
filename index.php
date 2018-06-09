<?php

    setlocale(LC_ALL, '');

    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/use.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/body/sys/translit.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/class/user.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/class/table.php');


    $page_title = 'ELASTIC 2';


    if ((($site_status == 'enable') && (isset ($_COOKIE['user']))) || ($_COOKIE['user'] == 'admin'))
    {
        $table_isset = false;
        $load_file_bool = false;
        require_once($_SERVER['DOCUMENT_ROOT'].'/sys/query_index.php');
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
        <script src="/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
    </head>

    <body>
        <?php
            //pre($user_status);
            //pre($current_users_group);
            //pre($current_users_access);
        $TABLE->table_list(); $table_list = $TABLE->table_list;
        $TABLE->table_list('1'); $released_table = $TABLE->table_list;


            if (isset ($_COOKIE['user']))
            {
//                if ((($_COOKIE['user'] == 'admin') && ($substring == '')) || ($_COOKIE['user'] != 'admin'))
//                {
//                    $count = 1;
//                    if ($_COOKIE['user'] == 'admin') { $DB->select("*","tables_namespace"); }
//                    elseif ($_COOKIE['user'] != 'admin') { $DB->select("*","tables_namespace", "`released` = '1'"); }
//
//                    while ($row = mysqli_fetch_row($DB->sql_query_select))
//                    {
//                        $released_table[$count][1] = $row[1];
//                        $released_table[$count][2] = $row[2];
//                        $testing[$released_table[$count][1]] = $row[4];
//                        $count++;
//                    }
//                    unset ($count);
//                }
                if (($_COOKIE['user'] != 'admin') && ($site_status == 'enable'))
                {
                    if ($substring == '') {require_once("home/home.php");}
                    else if ($substring != '')
                    {
                        foreach ($released_table as $key => $value) { if (($value['name'] == $substring) && ($user_status == '+')) { $table_isset = true; } }
                        if ($table_isset == true) { require_once("body/body.php"); }
                        else { require_once("home/home.php"); }
                    }
                }
                else if (($_COOKIE['user'] != 'admin') && ($site_status == 'disable')) {require_once("break.php");}


                else if ($_COOKIE['user'] == 'admin')
                {
                    if ($substring == '') {require_once("home/home.php");}
                    else if ($substring != '')
                    {
                        foreach ($table_list as $key => $value)
                        { if ($value[1] == $substring) { $table_isset = true; } }

                        if ($table_isset == true) { require_once("body/body.php"); }
                        else { require_once("home/home.php"); }
                    }
                }
            }
            else if ($site_status == 'disable') { require_once("break.php"); }
            else if ($site_status == 'enable')  { require_once("login/login.php"); }

            // ↓ Отладка переменных ↓

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

