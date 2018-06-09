<?php
    // Добавление строки
    // Вывод строк
    // Вывод столбцов
    $edit_true_bool = false;
    $status_warning = $status_danger = $status_success = $status_empty = 0;
    require_once($_SERVER['DOCUMENT_ROOT']."/body/query.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/body/pre_table/pre_table_query.php");


    foreach ($_POST as $key => $value)
    {
        if (strpos($key,'_true_'))
        {
            $edit_true_bool = true;
            $edit_true_count = explode("_","{$key}");
            $edit_true_count = $edit_true_count[2];
            //echo $edit_true_count.'<br>';
        }
    }

    if (isset ($_POST['refresh'])) { header("Location: /?{$substring}"); }





foreach ($_POST as $key => $value)
{
    if (strripos("{$key}",'file_save') !== false)
    {
        $file_save = explode("_","{$key}");
        $file_save = $file_save[2];

        //$DB->select("{$file_array[1][0]}","{$substring}", "`{$file_array[1][0]}` = '{$title[$file_save - 1][1]}'");
        //$alias = mysqli_fetch_row($DB->sql_query_select);


        if ((isset ($_POST["file_save_{$file_save}"])) && ($_FILES["file_{$file_save}"]['tmp_name'] != ''))
        {
            if (!is_dir($_SERVER['DOCUMENT_ROOT']."/damp/{$substring}/{$file_save}"))
            { mkdir($_SERVER['DOCUMENT_ROOT']."/damp/{$substring}/{$file_save}", 0700); }

            move_uploaded_file("{$_FILES["file_{$file_save}"]['tmp_name']}",$_SERVER['DOCUMENT_ROOT'].'/damp/'.$substring.'/'.$file_save.'/'.$_FILES["file_{$file_save}"]['name']);
            $DB->select("load_file","{$substring}","`id` = '{$file_save}'");
            while ($row = mysqli_fetch_row($DB->sql_query_select))
            {
                if ($row[0] != ''){ $row[0] .= "\n{$_FILES["file_{$file_save}"]['name']}"; }
                else { $row[0] .= "{$_FILES["file_{$file_save}"]['name']}"; }

                $DB->update("{$substring}","load_file","{$row[0]}","`id` = '$file_save'");
            }
        }
    }

    if (strripos("{$key}",'status_') !== false)
    {
        $testing_status = explode("_","{$key}");
        if ($testing_status[1] == 'null') { $testing_status[1] = '-'; }
        $DB->update("tables_namespace", "testing", "{$testing_status[1]}", "`name` = '{$substring}'");
    }
}

    if ($_COOKIE['user'] == 'admin') { $DB->select("*","tables_namespace"); }
    elseif ($_COOKIE['user'] != 'admin') { $DB->select("*","tables_namespace", "`released` = '1'"); }
    while ($row = mysqli_fetch_row($DB->sql_query_select))
    {
        $released_table[$count][1] = $row[1];
        $testing[$released_table[$count][1]] = $row[4];
        $count++;
    }
    //pre($testing);


?>

<link rel="stylesheet" href="/body/sys/ege.css">

<form method = "post" enctype = "multipart/form-data">
    <input type = 'hidden' name = 'hidden_sort_5' placeholder = 'hidden_sort_5'> <!--  -->
    <input type = 'hidden' name = 'hidden_sort_6' placeholder = 'hidden_sort_6' > <!--  -->
    <!-- ↓ Шапка таблицы ↓ -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/body/pre_table/tables_head.php'); ?>
    <!-- ↑ Шапка таблицы ↑ -->

    <input type = 'hidden' name = 'ver' value = '<?= $ver; ?>'>

    <div class = 'container-fluid' style = 'margin-top: -30px;'>
        <div class = 'row'>
            <div class = 'col-lg-12' style = 'padding-left: 0px; padding-right: 0px;'>

                    <table class = 'table table-condensed table-striped main_table' border = 1 style = 'margin-bottom: 60px;'>

                        <!-- ↓ Заголовок таблицы ↓ -->
                        <thead><?php require("pre_table/tables_title.php"); ?></thead>
                        <!-- ↑ Заголовок таблицы ↑ -->

                        <input type = 'hidden' name = 'hidden_sort_1' placeholder = 'hidden_sort_1'> <!-- Название столбца SQL -->
                        <input type = 'hidden' name = 'hidden_sort_2' placeholder = 'hidden_sort_2'> <!-- Тип сортировки -->
                        <input type = 'hidden' name = 'hidden_sort_3' placeholder = 'hidden_sort_3'> <!-- Номер столбца -->
                        <input type = 'hidden' name = 'hidden_sort_4' placeholder = 'hidden_sort_4'> <!--  -->


                        <?php
                        //if ($edit_true_bool == false)
                        //{
                            require($_SERVER['DOCUMENT_ROOT'].'/body/sort.php');
                            require($_SERVER['DOCUMENT_ROOT'].'/body/data.php');
                        //}
                        if ($edit_true_bool == true)
                        {
                            $bool_edit = true;
                            $bool_query = true;


                            // ↓ Редактирование строки ↓
                            require_once ($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/tr_edit.php');
                            // ↑ Редактирование строки ↑


                            // ↓ Обновление данных в таблице ↓
                            require($_SERVER['DOCUMENT_ROOT'].'/body/sort.php');
                            require($_SERVER['DOCUMENT_ROOT'].'/body/data.php');
                        }
                        ?>



                        <!-- ↓ Форма добавления строки ↓ -->
                        <?php
                            if (($_COOKIE['user'] == 'admin') || ($current_users_access[$substring.'_status'] == 'superuser'))
                            { require_once($_SERVER['DOCUMENT_ROOT'].'/body/pre_table/add_tr.php'); }
                        ?>
                        <!-- ↑ Форма добавления строки ↑ -->


                        <!-- ↓ Таблица ↓ -->
                        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/body/table/table.php'); ?>
                        <!-- ↑ Таблица ↑ -->

                    </table>

            </div>
        </div>
    </div>
</form>
<form method = "post">
    <?php if (($_COOKIE['user'] == 'admin') || ($current_users_access["{$substring}_status"] == 'superuser')) { $height = '70px'; } else { $height = '30px'; } ?>
    <div class = 'container' style = 'height: <?= $height ?>; position: fixed; bottom: 0; left: 0; width: 100%; padding-top: 5px;  cursor: default; background: black; color: white; text-align: center;'>
        <?php if (($_COOKIE['user'] == 'admin') || ($current_users_access["{$substring}_status"] == 'superuser')) { require_once($_SERVER['DOCUMENT_ROOT'].'/body/pre_table/sys/admin_head.php'); } ?>
        <div class = 'row'>
            <div class = 'col-lg-4'></div>
            <div class = 'col-lg-4'>
                <?php



                if (($caption != '') && ($_POST['inversion'] == false))     { echo "Показано записей: ".($tr_count - 2).' ('.($max_count - 1).')'; }
                else if (($caption != '') && ($_POST['inversion'] == true)) { echo 'Показано записей: '.($tr_count - 2).' ('.($max_count - 2).')'; }
                else                                                        { echo 'Показано записей: '.($tr_count - 2).' ('.($max_count - 2).')'; }


                if (($testing[$substring] == 'monitoring') || ($testing[$substring] == 'sync')) { ?>
                    <input type = 'submit' name = 'success_btn' class = 'monitoring_btn' style = 'margin-left: 4px; background: forestgreen; width: 44px;' value = '<?= "{$status_success}" ?>'>
                    <input type = 'submit' name = 'warning_btn' class = 'monitoring_btn' style = 'background: orange;' value = '<?= "{$status_warning}" ?>'>
                    <input type = 'submit' name = 'danger_btn'  class = 'monitoring_btn' style = 'background: red;' value = '<?= "{$status_danger}" ?>'>
                    <input type = 'submit' name = 'empty_btn'   class = 'monitoring_btn' style = 'background: white;' value = '<?= "{$status_empty}" ?>'>
                <?php } ?>
            </div>
            <div class = 'col-lg-4'>
                <?php if ($_COOKIE['user'] == 'admin')
                {
                    if (($testing[$substring] != 'monitoring') && ($testing[$substring] != 'sync')) { $border_1 = 'border: solid 1px gold;'; $border_2 = 'border: solid 1px white;'; $border_3 = 'border: solid 1px white;'; }
                    else if ($testing[$substring] == 'monitoring') { $border_1 = 'border: solid 1px white;'; $border_2 = 'border: solid 1px gold;'; $border_3 = 'border: solid 1px white;'; }
                    else if ($testing[$substring] == 'sync') { $border_1 = 'border: solid 1px white;'; $border_2 = 'border: solid 1px white;'; $border_3 = 'border: solid 1px gold;'; }
                    ?>
                    <input name = '<?= "status_sync" ?>' type = 'submit' value = 'Синхронизация' class = 'monitoring_btn' style = 'float: right; width: auto; margin-right: 5px;background: black; color: white; <?= $border_3 ?>'>
                    <input name = '<?= "status_monitoring" ?>' type = 'submit' value = 'Мониторинг' class = 'monitoring_btn' style = 'float: right; width: auto; margin-right: 5px; background: black; color: white; <?= $border_2 ?>'>
                    <input name = '<?= "status_null" ?>' type = 'submit' value = 'Просмотр' class = 'monitoring_btn' style = 'float: right; width: auto; margin-right: 5px; background: black; color: white; <?= $border_1 ?>'>
                <?php } ?>
            </div>
        </div>
    </div>
</form>