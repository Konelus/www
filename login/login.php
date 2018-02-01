<?php

    $link = '';
    $descriptor = fopen($_SERVER['DOCUMENT_ROOT'].'/link.txt', 'r');
    if ($descriptor)
    {
        while (($string = fgets($descriptor)) !== false)
        { $link = $link.$string; }
        fclose($descriptor);
    }

    if (isset ($_POST['enter']))
    {
        $localhost = "localhost";
        $user = "root";
        $password = $link;
        $db = "rtk_01";
        $mysqli = new mysqli($localhost, $user, $password, $db);
        mysqli_set_charset($mysqli, 'utf8');

        $login = $_POST["login"];
        //$password_P = md5($_POST["Password_p"]);  Хэш, если понадобится
        $password = $_POST["password"];
        $sql_enter = $mysqli->query("select * from `users` where login = '".$login."' and password = '".$password."'");
        if ($row = mysqli_fetch_row($sql_enter))
        {
            setcookie("user", $login,  time() + 60 * 60 * 24 * 365, "/");
            header ("Location: /");
        }
    }
?>

<div class = 'container-fluid' style = 'margin-top: 150px;'>
    <div class = 'row'>
        <div class = 'col-lg-4'></div>
        <form method = 'post'>
            <div class = 'col-lg-4' style = 'text-align: center;'>
                <div style = 'font-size: 20px; margin-bottom: 20px;'>Для работы на сервисе введите Ваши учетные данные</div>
                <div>
                    <div><label for = 'login' style = 'margin-right: 5px;'>Логин</label></div>
                    <div style = 'margin: auto; width: 60%'><input name = 'login' class = 'form-control' type = 'text' id = 'login'></div>
                </div>
                <div>
                    <div><label for = 'password' style = 'margin-right: 5px;'>Пароль</label></div>
                    <div style = 'margin: auto; width: 60%'><input name = 'password' class = 'form-control' type = 'password' id = 'password'></div>
                </div>
                <div style = 'margin-top: 10px;'>
                    <input name = 'enter' type = 'submit' class="btn" style = 'width: 25%; border: solid 1px black;' value = 'Вход'>
                </div>
            </div>
        </form>
        <div class = 'col-lg-4'></div>
    </div>
</div>