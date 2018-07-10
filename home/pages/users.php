<?php
    require_once ($_SERVER['DOCUMENT_ROOT'].'/home/pages/class/class_users.php');

    $td = array('fio' => 'ФИО', 'login' => 'Логин', 'password' => 'Пароль', 'table_group' => 'Группа', 'position' => 'Должность', 'phone' => 'Телефон', 'mail' => 'Почта', 'status' => 'Доступ');

    if (isset ($_POST['del_btn']))
    { $ADM_USER->delete_user($_POST['login']); }
    elseif (isset ($_POST['edit_btn']))
    { $ADM_USER->update_user($_POST['login']); }
    elseif (isset ($_POST['add_user']))
    { $ADM_USER->add_user(); }

    $ADM_USER->users_list();
    $ADM_USER->groups_list();

    $users = $ADM_USER->users;
    $groups = $ADM_USER->groups;

    if ((isset ($_POST)) && ($_POST != null))
    {
        foreach ($_POST as $key => $value)
        {
            if (stripos("{$key}","show_modal") !== false)
            {
                $str_explode = explode("_","{$key}");
                $count = $str_explode[2];
                $post = 'modal';
            }
            elseif (stripos("{$key}","show_edit") !== false)
            {
                $str_explode = explode("_","{$key}");
                $count = $str_explode[2];
                $post = 'edit';
            }
        }
    }
?>





<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="/img/favicon.png" type="image/png">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
        <style type="text/css">
            .lab {
                -ms-user-select: none;
                -moz-user-select: none;
                -khtml-user-select: none;
                -webkit-user-select: none;
                cursor: default;
            }
        </style>
    </head>
    <body>
        <div class = 'container-fluid'>
            <div class = 'row'>
                <form method = "post">
                <div class = 'col-lg-12' style = 'height: 110px; margin-top: 5px; margin-bottom: 5px;'>
                    <div style = 'height: 110px;'>
                        <div style = 'text-align: center; margin-bottom: 10px; font-size: 20px;'>Добавление пользователя</div>
                        <div class = 'col-lg-10 col-md-10 col-sm-10' style = 'text-align: center; margin-bottom: 10px;'>
                            <div class = 'col-lg-2 col-md-2 col-sm-2'>
                                <div>Логин</div>
                                <div><input autocomplete = "off" name = 'login' type = 'text' class = 'form-control text_box_border'></div>
                            </div>
                            <div class = 'col-lg-2 col-md-2 col-sm-2'>
                                <div>Пароль</div>
                                <div><input autocomplete = "off" name = 'password' type = 'text' class = 'form-control text_box_border'></div>
                            </div>
                            <div class = 'col-lg-2 col-md-2 col-sm-2'>
                                <div>ФИО</div>
                                <div><input autocomplete = "off" name = 'fio' type = 'text' class = 'form-control text_box_border'></div>
                            </div>
                            <div class = 'col-lg-2 col-md-2 col-sm-2'>
                                <div>Должность</div>
                                <div><input autocomplete = "off" name = 'position' type = 'text' class = 'form-control text_box_border'></div>
                            </div>
                            <div class = 'col-lg-2 col-md-2 col-sm-2'>
                                <div>Телефон</div>
                                <div><input autocomplete = "off" name = 'phone' type = 'text' class = 'form-control text_box_border'></div>
                            </div>
                            <div class = 'col-lg-2 col-md-2 col-sm-2'>
                                <div>Почта</div>
                                <div><input autocomplete = "off" name = 'mail' type = 'text' class = 'form-control text_box_border'></div>
                            </div>
                        </div>
                        <div class = 'col-lg-2 col-md-2 col-sm-2' style = 'margin-top: 10px;'><input style = 'background: black;' type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong" name = 'add_user' value = 'Добавить'></div>
                    </div>
                </div>
            </form>
                <div class = 'col-lg-12'>
                    <table class = 'table table-bordered table-striped'>
                        <tr style = 'background: black; color: white; text-align: center; cursor: default;'>
                            <?php foreach ($td as $key => $value) { echo "<td>$value</td>"; } ?>
                            <td>Ред</td>
                        </tr>
                        <?php
                        foreach ($users as $key => $value)
                        {
                            foreach ($value as $v_key => $v_value) { if (is_numeric($v_key)) { unset($users[$key][$v_key]); } }

                            $login_explode = explode("@","{$users[$key]['login']}");
                            if ($login_explode[1] != '') { $users[$key]['login'] = "{$login_explode[0]}<br>@{$login_explode[1]}"; }

                            $mail_explode = explode("@","{$users[$key]['mail']}");
                            if ($mail_explode[1] != '') { $users[$key]['mail'] = "{$mail_explode[0]}<br>@{$mail_explode[1]}"; } ?>
                            <tr>
                                <td><?= $users[$key]['fio'] ?></td>
                                <td><?= $users[$key]['login'] ?></td>
                                <td>
                                    <form method = "post">
                                        <input style = 'background: black;' type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong" name = 'show_modal_<?= $key ?>' value = 'Показать'>
                                    </form>
                                    <?php
                                    echo '</td>';
                                    echo "<td>{$users[$key]['table_group']}</td>";
                                    echo "<td title = '{$users[$key]['position']}'>";

                                    if (strlen($users[$key]['position']) > 55)
                                    { echo mb_substr($users[$key]['position'],"0","55", 'UTF-8').'...'; }

                                    echo '</td>';
                                    echo "<td>{$users[$key]['phone']}</td>";
                                    echo "<td>{$users[$key]['mail']}</td>";
                                    if ($users[$key]['status'] == '+') { echo "<td><div style = 'width: 15px; margin: auto;'><img style = 'width: 100%;' src = '/img/icons/projects/status/green.png'></div></td>"; }
                                    else { echo "<td><div style = 'width: 15px; margin: auto;'><img style = 'width: 100%;' src = '/img/icons/projects/status/red.png'></div></td>"; }
                                    ?>
                                <td>
                                    <form method = "post">
                                        <input type = 'submit' value = 'Ред' class='btn btn-primary' style = 'background: black;' name = 'show_edit_<?= $key ?>'>
                                    </form>
                                </td>
                                <?php
                            echo '</tr>';
                        } ?>
                    </table>
                </div>
            </div>
        </div>
            <?php

            if ((!isset ($_POST['del_btn'])) && (!isset ($_POST['edit_btn'])))
            {
                require_once($_SERVER['DOCUMENT_ROOT'].'/home/pages/users/modal_show.php');
                require_once($_SERVER['DOCUMENT_ROOT'].'/home/pages/users/modal_edit.php');
            }

            if ($post == 'modal')
            { ?>
                <script>$("#log").html("<?= "<span class = 'lab'>Логин: &nbsp;&nbsp;&nbsp;</span><span style = 'color: darkmagenta;'>".strip_tags($users[$count]['login']."</span>") ?>");</script>
                <script>$("#pass").html("<?= "<span class = 'lab'>Пароль: </span><span style = 'color: darkmagenta;'>".strip_tags($users[$count]['password']."</span>") ?>");</script>
                <script>$("#modal").modal('show');</script><?php
            }
            elseif ($post == 'edit')
            {
            foreach ($td as $key => $value){ ?><script>$("#<?= $key ?>").val("<?= strip_tags($users[$count][$key]) ?>");</script><?php } ?>
                <script>$("#hidden").val("<?= strip_tags($users[$count]['login']) ?>");</script>
                <script>$("#edit").modal('show');</script><?php
            } ?>
    </body>
</html>