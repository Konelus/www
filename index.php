<!DOCTYPE html>

<?php
    /* - - - - - - - - - - ↓ Подключение к БД ↓ - - - - - - - - - - */
    $link = '';
    $descriptor = fopen($_SERVER['DOCUMENT_ROOT'].'/link.txt', 'r');
    if ($descriptor)
    { while (($string = fgets($descriptor)) !== false) { $link = $link.$string; } fclose($descriptor); }

    $localhost = "localhost";
    $user = "root";
    $password = $link;
    $db = "rtk_01";
    $mysqli = new mysqli($localhost, $user, $password, $db);
    mysqli_set_charset($mysqli, 'utf8');
    /* - - - - - - - - - - ↑ Подключение к БД ↑ - - - - - - - - - - */

    $cat_name = end(explode("=", ('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])));
    $podcat_name = explode('?', $cat_name);

    require_once($_SERVER['DOCUMENT_ROOT']."/body/sys/translit.php");


    // ↓ Получение группы пользователя ↓
    $SQL_QUERY_current_group = $mysqli->query("select `table_group` from `users` where `login` = '".$_COOKIE['user']."' ");
    while ($row = mysqli_fetch_row($SQL_QUERY_current_group))
    { $current_users_group[0] = $row[0]; }
    // ↑ Получение группы пользователя ↑

    // ↓ Получение группы пользователя ↓
    //$perm_count = 1;
    $SQL_QUERY_tables_access = $mysqli->query("select * from `group_namespace` where `name` = '".$current_users_group[0]."' ");
    while ($row = mysqli_fetch_array($SQL_QUERY_tables_access))
    { $current_users_access = $row; $perm_count++; }
    // ↑ Получение группы пользователя ↑


    $SQL_QUERY_ver = $mysqli->query("select `ver` from `ver` ");
    while ($row = mysqli_fetch_row($SQL_QUERY_ver))
    { $ver = $row[0]; }

    if ($_COOKIE['user'] == 'admin')
    { $lim = 27; }
    else { $lim = 50002; }

    $SQL_QUERY_ver = $mysqli->query("select `ver` from `ver` ");
    while ($row = mysqli_fetch_row($SQL_QUERY_ver))
    { $ver = $row[0]; }


?>

<html lang="ru">
    <head>
        <title>TEST</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  
        <script src="dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    </head>

    <body>
        <?php
            $status = '';
            $descriptor = fopen($_SERVER['DOCUMENT_ROOT'].'/status.txt', 'r');
            if ($descriptor)
            {
                while (($string = fgets($descriptor)) !== false)
                { $status = $status.$string; }
                fclose($descriptor);
            }

            if (isset ($_COOKIE['user']))
            {
                if (($_COOKIE['user'] != 'admin') && ($status == 'enable'))
                {
                    if ($podcat_name[1] == '') {require_once("home/home.php");}

                    else if (($podcat_name[1] == 'vibory') && ($current_users_access['vibory'] == '+')) { require_once("body/body.php"); }
                    else if (($podcat_name[1] == 'schools') && ($current_users_access['schools'] == '+')) {require_once("body/body.php");}
                    else {require_once("home/home.php");}
                }
                else if (($_COOKIE['user'] != 'admin') && ($status == 'disable')) {require_once("break.php");}


                else if ($_COOKIE['user'] == 'admin')
                {
                    if ($podcat_name[1] == '') {require_once("home/home.php");}
                    else if ($podcat_name[1] == 'vibory') { require_once("body/body.php"); }
                    else if ($podcat_name[1] == 'schools') {require_once("body/body.php"); }
                    else {require_once("home/home.php");}
                }

            }
            else if ($status == 'disable') { require_once("break.php"); }
            else if ($status == 'enable') { require_once("login/login.php"); }
            //exec('q.exe');
         ?>
    </body>
</html>

