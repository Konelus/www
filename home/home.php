<?php
    require_once("sys/query.php");
    $log = explode('@', $_COOKIE["user"]);


?>


<script src="/home/sys/head.js"></script>
<link rel="stylesheet" href="/home/sys/style.css">


<div class = 'container-fluid'>
    <div class = 'row' style= 'margin-right: 0;'>
        <div class = 'row main_header'>
            <div class = 'col-lg-2 col-md-2 col-sm-3'>
                <div style = 'float: left; padding-top: 10px; margin-left: 10px;'><img style = 'height: 40px;' src = '/img/logo.png'></div>
                <div style = 'float: left; padding-top: 24px; font-size: 17px; cursor: default;'><span style = 'color: white;'>ELASTIC<span style = 'color: #ffdf5e;'>2</span></span></div>
            </div>
                <script>var header_lable = <?= json_encode($mass); ?>;</script>
            <div class = 'col-lg-7 col-md-7 col-sm-4'>
                <div class="collapse navbar-collapse" id="navbar-main">
                    <ul class="nav navbar-nav" style = 'margin-top: 5px;'>
                        <?php if (($current_users_access[$mass[1][1]] == '+') || ($_COOKIE['user'] == 'admin')) { ?><li><a href = '/?<?= $mass[1][1] ?>' class = 'header_href_color'><?= $mass[1][2] ?></a></li><?php } ?>
                        <?php if (($current_users_access[$mass[2][1]] == '+') || ($_COOKIE['user'] == 'admin')) { ?><li><a href = '/?<?= $mass[2][1] ?>' class = 'header_href_color'><?= $mass[2][2] ?></a></li><?php } ?>
                        <?php if (($current_users_access[$mass[3][1]] == '+') || ($_COOKIE['user'] == 'admin')) { ?><li><a href = '/?<?= $mass[3][1] ?>' class = 'header_href_color'><?= $mass[3][2] ?></a></li><?php } ?>
                        <?php if (($current_users_access[$mass[4][1]] == '+') || ($_COOKIE['user'] == 'admin')) { ?><li><a href = '/?<?= $mass[4][1] ?>' class = 'header_href_color'><?= $mass[4][2] ?></a></li><?php } ?>
                        <?php if (($current_users_access[$mass[5][1]] == '+') || ($_COOKIE['user'] == 'admin')) { ?><li><a href = '/?<?= $mass[5][1] ?>' class = 'header_href_color'><?= $mass[5][2] ?></a></li><?php } ?>
                        <?php if (($current_users_access[$mass[6][1]] == '+') || ($_COOKIE['user'] == 'admin')) { ?><li><a href = '/?<?= $mass[6][1] ?>' class = 'header_href_color'><?= $mass[6][2] ?></a></li><?php } ?>
                        <?php if (($current_users_access[$mass[7][1]] == '+') || ($_COOKIE['user'] == 'admin')) { ?><li><a href = '/?<?= $mass[7][1] ?>' class = 'header_href_color'><?= $mass[7][2] ?></a></li><?php } ?>
                    </ul>
                </div>
            </div>
            <div class = 'col-lg-1 col-md-1 col-sm-1'></div>
            <div class = 'col-lg-2 col-md-3 col-sm-4' style = 'text-align: center; margin-top: 8px; padding-right: 30px;'>
                <div style = 'cursor: default;'>Вы авторизованы, как</div>
                <div>
                    <form method = "post"><span class = 'login_div' style = 'padding-left: 15px; cursor: default;'><?= $log[0] ?></span>
                        <input name = 'exit' class = 'exit_button' type = 'submit' value = '(Выход)'>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if ($_COOKIE['user'] == 'admin') { require_once($_SERVER['DOCUMENT_ROOT']."/home/admin.php"); }
    else if ($_COOKIE['user'] != 'admin') { require_once($_SERVER['DOCUMENT_ROOT']."/home/user.php"); }
?>
<div class = 'ver' style = 'margin-bottom: 25px;'><span style = 'color: red;'>Внимание!</span> Для корректной работы с сервисом необходим экран с минимальной шириной <span style = 'color: red;'>1000px</span>!</div>
<div class = 'ver'>Версия продукта <?= $ver ?></div>
