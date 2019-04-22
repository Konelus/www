<?php

    setlocale(LC_ALL, '');

    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/use.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/hidden.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/class/connection.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/class/other.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/class/route.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/del_null_vars.php');

    $ver = $OTHER->ver();
    $page_title = $OTHER->table_title();

    $ROUTE->page_model();
    list($status, $tables, $user_fio, $page, $sub_page_key, $sub_page_value) = $ROUTE->return;


    if (isset ($_POST['enter']))
    {
        $login = $_POST["login"];
        //$password_P = md5($_POST["Password_p"]);  Хэш, если понадобится
        $password = $_POST["password"];
        $DB->select("*","!sys_users","`login` = '{$login}' and `password` = '{$password}'");
        if ($row = mysqli_fetch_row($DB->sql_query_select))
        {
            setcookie("user", $login, time() + 60 * 60 * 24 * 365, "/");
            header("Location: /");
        }
    }

    if (isset ($_POST['refresh'])) { header ("Location: /?project={$_GET['project']}"); }

    if (isset ($_POST['exit']))
    {
        setcookie('user', '', time() - 3600);
        header ("Location: /");
    }

//    if ((($site_status == 'enable') && (isset ($_COOKIE['user']))) || ($_COOKIE['user'] == 'admin'))
//    {
//        $table_isset = false;
//        $load_file_bool = false;
//        require_once($_SERVER['DOCUMENT_ROOT'].'/sys/query_index.php');
//    }

?>

<!DOCTYPE html>

<html lang="ru">
    <head>
        <title><?= strip_tags($page_title) ?></title>
        <link rel="shortcut icon" href="/img/favicon.png" type="image/png">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  
        <script src="/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
    </head>
    <body><?php require_once ($_SERVER['DOCUMENT_ROOT']."/{$page}.php"); del_null_vars(); ?></body>
</html>