<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/class.php");
    function pre0($array)
    {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }


    if (isset ($_POST['del'])) { $DB->delete("tables_namespace","`id` = '{$_POST['hidden']}'"); }
    elseif (isset ($_POST['save']))
    {
        if ($_POST['access'] == 'Доступно') { $access = '1'; }
        elseif ($_POST['access'] == 'Недоступно') { $access = '0'; }
        if ($_POST['additional'] == '') { $additional = '0'; }
        elseif ($_POST['additional'] == 'Мониторинг') { $additional = 'monitoring'; }
        elseif ($_POST['additional'] == 'Синхронизация') { $additional = 'sync'; }

        $DB->update("tables_namespace","description","{$_POST['proj_name']}","`id` = {$_POST['hidden']}");
        $DB->update("tables_namespace","released","{$access}","`id` = {$_POST['hidden']}");
        $DB->update("tables_namespace","testing","{$additional}","`id` = {$_POST['hidden']}");
    }

    $column = [1 => 'Проект', 2 => 'Изображение', 3 => 'Статус', 4 => 'Тест'];

    $DB->select("*","tables_namespace");
    while ($array = mysqli_fetch_array($DB->sql_query_select))
    { $project[] = $array; }

    foreach ($project as $key => $value)
    {
        foreach ($value as $a_key => $a_value)
        { if (is_numeric($a_key)) { unset($project[$key][$a_key]); } }
    }

    $edit_bool = false;
    if (isset ($_POST))
    {
        foreach ($_POST as $key => $value)
        {
            if (stripos("{$key}","show_edit") !== false)
            {
                $temp = explode("_","{$key}");
                $count = $temp[2];
                $edit_bool = true;
            }
        }
    }


?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
    </head>
    <body>
    <form method = "post">
        <div class = 'container'>
            <div class = 'row'>
                <div class = 'col-lg-12' style = 'margin-top: 2px; margin-bottom: 6px;'>
                    <div style = 'width: 500px; margin: auto;'>
                        <div style = 'float: left; cursor: default; margin-right: 4px; font-size: 20px; margin-top: 5px;'>Добавление проекта</div>
                        <div style = 'float: left; margin-left: 2px;'><input type='text' style = 'width: 200px; color: black; margin-top: 4px; border: solid 1px black; padding-left: 5px; padding-right: 5px;' class = 'form-control text_box_border' autocomplete='off' name='group_name'></div>
                        <div style = 'float: left;'><input class = 'table_small_add_btn btn' type='submit' value='Добавить' name='add_group' style = 'color: white; background: black; margin-left: 5px; margin-top: 4px; border: solid 1px grey;'></div>
                    </div>
                </div>
                <div class = 'col-lg-12'>
                    <table class = 'table table-striped table-bordered'>
                        <tr><?php
                            foreach ($column as $key => $value) { echo "<td style = 'color: white; background: black; font-size: 15px; text-align: center;'>{$value}</td>"; } ?>
                            <td style = 'color: white; background: black; font-size: 15px; text-align: center;'>Ред</td>
                        </tr>
                        <?php
                            foreach ($project as $key => $value)
                            {
                                echo "<tr>";
                                foreach ($value as $v_key => $v_value)
                                {
                                    if ($v_value === '0') { $v_value = "<div style = 'width: 20px; margin: auto;'><img style = 'width: 100%;' src = '/img/icons/projects/status/red.png'></div>"; }
                                    elseif ($v_value == '1') { $v_value = "<div style = 'width: 20px; margin: auto;'><img style = 'width: 100%;' src = '/img/icons/projects/status/green.png'></div>"; }
                                    elseif ($v_value == 'monitoring') { $v_value = "<div style = 'width: 20px; margin: auto;'><img style = 'width: 100%;' src = '/img/icons/projects/status/monitoring.png'></div>"; }
                                    elseif ($v_value == 'sync') { $v_value = "<div style = 'width: 20px; margin: auto;'><img style = 'width: 100%;' src = '/img/icons/projects/status/sync.png'></div>"; }

                                    if (($v_key != 'id') && ($v_key != 'name')) { echo "<td><div style = 'padding-top: 5px;'>{$v_value}</div></td>"; }

                                    if ($v_key == 'description') { echo "<td><div style = 'padding-top: 5px;'><img alt = ''style = 'width: 20px;' src = '/img/icons/projects/{$value['name']}.png'> {$value['name']}.png</div></td>"; }
                                }
                                ?>
                        <td>
                            <div style = 'width: 80%; margin: auto;'>
                                <input name = 'show_edit_<?= $key ?>' type = 'submit' value = 'Ред' class = 'btn' style = 'background: black; color: white; width: 100%;'>
                            </div>
                        </td>
                                <?php echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </form>
    <?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/home/pages/projects/modal_edit.php');

    if ($edit_bool == true)
    {
        if ($project[$count]['released'] == '0') { $prop[0] = 'false'; }
        elseif ($project[$count]['released'] == '1') { $prop[0] = 'true'; }

        if ($project[$count]['testing'] == 'monitoring') { $prop[1] = 'monitoring'; }
        elseif ($project[$count]['testing'] == 'sync') { $prop[1] = 'sync'; }
        else { $prop[1] = 'null'; }
        ?>
    <script>
        $("#hidden").val("<?= $project[$count]['id'] ?>");
        $("#access #<?= $prop[0] ?>").prop("selected", true);
        $("#additional #<?= $prop[1] ?>").prop("selected", true);
        $("#proj_name").val("<?= $project[$count]['description'] ?>");
        $("#title").html("Редактирование проекта <span style = 'color: navy; text-decoration: underline;'><?= $project[$count]['description'] ?></span>");
        $("#modal_edit").modal("show");
    </script>
    <?php } ?>


    </body>
</html>