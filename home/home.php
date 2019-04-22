<?php
    //require_once ($_SERVER['DOCUMENT_ROOT'].'/home/sys/query.php');

//    if (isset ($_POST['add_table']))
//    {
//        $DB->create($_POST['table_name']);
//        header ("Location: /");
//    }



    if ($_COOKIE['user'] == 'admin')
    {
        if ($site_status == 'enable')
        { $value = 'Выключить'; }
        else if ($site_status == 'disable')
        { $value = 'Включить'; }

        $label_array = parse_ini_file($_SERVER["DOCUMENT_ROOT"]."/sys/main_title.ini");
        if (isset ($_GET['bar']))
        {
            if ($_GET['bar'] != '') { $label_key = $_GET['bar']; }
            else { $label_key = 'void'; }
            if (($_COOKIE['user'] == 'admin') && ($_GET['bar'] != '')) { $title_label = $label_array[$label_key]; }
        }
        elseif (!isset ($_GET['bar'])) {$title_label = $label_array['void']; }
    }

?>


<link rel="stylesheet" href="/home/sys/style.css">


<div class = 'container-fluid'>
    <div class = 'row' style= 'margin-right: 0;'>
        <div class = 'row main_header'>
            <div class = 'col-lg-2 col-md-2 col-sm-2'>
                <div class = 'col-lg-8'>
                    <div style = 'width: 110px; margin: auto;'>
                        <div style = 'float: left; padding-top: 10px;'>
                            <?php if ($site_status == 'enable') { $press_label = 'Выключить'; ?><img style = 'height: 40px;' src = '/img/logo.png'><?php }
                            else if ($site_status == 'disable') { $press_label = 'Включить'; ?><img style = 'height: 40px;' src = '/img/logo_grey.png'><?php }?>
                        </div>
                        <div style = 'padding-top: 24px; font-size: 17px; cursor: default;'><span style = 'color: white;'>ELASTIC<span style = 'color: #ffdf5e;'>2</span></span></div>
                    </div>
                </div>
                <div class = col-lg-4></div>

            </div>
            <div class = 'col-lg-1 col-md-2 col-sm-2'></div>
            <div class = 'col-lg-6 col-md-4 col-sm-4'>
                <?php if (($_COOKIE['user'] != 'admin') && ($status != '+')) { ?>
                <div style = 'color: red; padding-top: 10px; width: 100%; font-size: 30px; font-weight: bold; text-align: center; background: black;'>
                    Внимание! Доступ по Вашей учётной записи запрещён!
                </div>
                <?php } else { ?><div style = 'font-size: 22px; text-align: center; margin-top: 15px;'><?= $title_label ?></div><?php } ?>
            </div>
            <div class = 'col-lg-3 col-md-4 col-sm-4' style = 'text-align: center; margin-top: 12px; padding-right: 30px;'>
                <div style = 'float: right;'>
                    <form method = "post">
                            <img style = 'width: 30px; height: 30px; float: left;' src = '/img/icons/user.png'>
                            <div style = 'cursor: default; font-size: 20px; margin-top: 5px; float: left;'><?= $user_fio ?></div>
                            <button title = 'Выход' name = 'exit' type = 'submit' style = 'margin-top: 5px; background: black; border: 0; margin-left: 10px; float: left;'>
                                <img style = 'float: left; width: 30px; height: 30px; margin-left: -10px; margin-right: -10px;' src = '/img/icons/exit.png'>
                            </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    if ($_COOKIE['user'] == 'admin')
    { require_once ($_SERVER['DOCUMENT_ROOT'].'/home/sys/admin_sys.php'); }
    $link = ['users' => 'Пользователи', 'groups' => 'Группы', 'temp' => 'Права групп', 'projects' => 'Проекты', 'scripts' => 'Скрипты'];
?>


<div class = 'container-fluid text_cursor'>
    <div class = 'row'>
        <div class = 'col-lg-12 col-md-12 col-sm-12' style = 'padding-left: 0; padding-right: 0;'>
            <div class = 'col-lg-2 col-md-2 col-sm-2' style = ' padding-left: 0; padding-right: 0;'>
                <?php if ($_COOKIE['user'] == 'admin') { ?>
                <div class = 'col-lg-8 col-md-8 col-sm-8' style = 'background: black; color: white; height: calc(100vh - 115px); padding-left: 5px; padding-top: 10px; padding-right: 5px; border-top:solid 1px white; border-bottom: solid 1px white;'>
                    <a href = '/' class = 'adm_menu_link'><div class = 'adm_menu_div'>Главное меню</div></a>
                    <div style = 'margin-top: 40px;'></div>
                    <?php foreach ($link as $key => $value)
                    {
                        if ($_GET['bar'] == $key) { $bg = 'background: grey;'; } else { $bg = ''; } ?>
                        <a href = '/?bar=<?= $key ?>' class = 'adm_menu_link'><div style = '<?= $bg ?>' class = 'adm_menu_div'><?= $value ?></div></a>
                    <?php } ?>

                    <div style = 'margin-top: 40px;'></div>
                    <a href = '/?bar=logs_edit' class = 'adm_menu_link'><div class = 'adm_menu_div'>Логи редактирования</div></a>
                    <a href = '/?bar=logs_tr' class = 'adm_menu_link'><div class = 'adm_menu_div'>Логи строки</div></a>
                    <div style = 'margin-top: 40px;'></div>
                    <a href = '/home/pages/press.php?<?= $substring ?>' class = 'adm_menu_link'><div class = 'adm_menu_div'><?= $press_label ?> сайт</div></a>
                </div>
                <div class = 'col-lg-4 col-md-4 col-sm-4'></div>
                <?php } ?>
            </div>
            <div class = 'col-lg-8 col-md-8 col-sm-8' style ='padding-left: 0; padding-right: 0;'>
                <?php
                    if ($_COOKIE['user'] == 'admin')
                    {
                        if (($_COOKIE['user'] == 'admin') && ($sub_page_key == 'bar'))
                        { echo "<iframe style = 'width: 100%; height: calc(100vh - 115px); border: 0;' src = '/home/pages/{$sub_page_value}.php'></iframe>"; }
                        else { require_once ($_SERVER['DOCUMENT_ROOT']."/home/pages/main.php"); }
                    }
                    else { require_once ($_SERVER['DOCUMENT_ROOT']."/home/pages/main.php"); }

                ?>
            </div>
            <div class = 'col-lg-2 col-md-2 col-sm-2'></div>
        </div>
    </div>

<div class = 'ver' style = 'margin-bottom: 25px;'><span style = 'color: red;'>Внимание!</span> Для корректной работы с сервисом необходим экран с разрешением <span style = 'color: red;'>1920x1080</span> и выше!</div>
<div class = 'ver'>Версия продукта <span style = 'color: red;'><?= $ver ?></span></div>
