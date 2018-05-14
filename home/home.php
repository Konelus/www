<?php
    require_once ($_SERVER['DOCUMENT_ROOT'].'/home/sys/query.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/home/sys/group_query.php');
    $log = explode('@', $_COOKIE["user"]);
    $log = $log[0];
    if ($_COOKIE["user"] == 'admin') { $header = "style = 'height: 110px;'"; } else { $header = ''; }


    if (isset ($_POST['add_table']))
    {
        $DB->create($_POST['table_name']);
        header ("Location: /");
    }



    if ($site_status == 'enable')
    { $value = 'Выключить'; }
    else if ($site_status == 'disable')
    { $value = 'Включить'; }

?>


<link rel="stylesheet" href="/home/sys/style.css">


<div class = 'container-fluid'>
    <div class = 'row' style= 'margin-right: 0;'>
        <div class = 'row main_header' <?= $header ?>>
            <div class = 'col-lg-2 col-md-2 col-sm-3'>
                <div style = 'float: left; padding-top: 10px; margin-left: 10px;'>
                    <?php if ($site_status == 'enable') { ?><img style = 'height: 40px;' src = '/img/logo.png'><?php }
                    else if ($site_status == 'disable') { ?><img style = 'height: 40px;' src = '/img/logo_grey.png'><?php }?>
                </div>
                <div style = 'padding-top: 24px; font-size: 17px; cursor: default;'><span style = 'color: white;'>ELASTIC<span style = 'color: #ffdf5e;'>2</span></span></div>

                <?php if ($_COOKIE['user'] == 'admin') { ?>
                    <form method = "post">
                        <div style = 'margin-top: 8px; margin-left: 27px;' class = 'second_bar_div'>
                            <div style = 'width: 100px; border: solid 1px gold;'>
                                <input name = 'break' style = 'width: 100%; border: solid 0; color: white; background: black;' type = 'submit' value = '<?= $value ?>'>
                            </div>
                        </div>
                    </form>
                <?php } ?>

            </div>
            <div class = 'col-lg-8 col-md-8 col-sm-5'>
                <?php if (($_COOKIE['user'] == 'admin') || ($user_status == '+')) { ?>
                <div class="collapse navbar-collapse" id="navbar-main">
                    <form method = "post">
                    <ul class="nav navbar-nav" style = 'margin-top: 5px;'>
                        <?php
                        if ($_COOKIE['user'] == 'admin')
                        {
                            foreach ($all_tables_array as $key => $value)
                            { ?><li><a href = '<?php if ($value[3] != '') { echo "/?{$value[1]}"; } ?>' class = 'header_href_color'><?= $value[2] ?></a></li><?php }
                            ?><li style = 'margin-top: 10px;'>
                                <input type = 'text' style = 'color: black; margin-left: 10px; height: 30px; border: solid 1px gold; padding-left: 5px;' name = 'table_name' autocomplete="off">
                                <input type = 'submit' style = 'color: white; height: 30px; width: 30px; background: black; border: solid 1px gold;' value = '+' name = 'add_table'>
                            </li><?php
                        }
                        else if ($_COOKIE['user'] != 'admin')
                        {
                            foreach ($released_table as $key => $value)
                            {
                                if ($current_users_access[$value[1]] == '+') { ?><li><a href = '<?= "/?{$value[1]}" ?>' class = 'header_href_color'><?= $value[2] ?></a></li><?php }
                            }
                        }
                        ?>
                    </ul>
                    </form>
                </div>
                <?php } else { ?>
                <div style = 'color: red; padding-top: 10px; width: 100%; font-size: 30px; font-weight: bold; text-align: center; background: black;'>
                    Внимание! Доступ по Вашей учётной записи запрещён!
                </div>
                <?php } ?>
            </div>
            <div class = 'col-lg-2 col-md-3 col-sm-4' style = 'text-align: center; margin-top: 8px; padding-right: 30px;'>
                <div style = 'cursor: default;'>Вы авторизованы, как</div>
                <div>
                    <form method = "post"><span class = 'login_div' style = 'padding-left: 15px; cursor: default;'><?= $log ?></span>
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
<div class = 'ver'>Версия продукта <span style = 'color: red;'><?= $ver ?></span></div>
