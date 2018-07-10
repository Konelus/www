<?php

    foreach ($_POST as $key => $value)
    {
        if (stripos("{$key}","edit") !== false)
        { list($temp, $edit) = explode("_","{$key}"); }
    }


    list($data, $total_tr_count, $tr_count, $permissions, $title, $permission_status, $fio) = $MODEL->body();
    //pre($data);
    //pre($permissions);
    //pre($title);

    //$edit_true_bool = false;
    //$status_warning = $status_danger = $status_success = $status_empty = 0;


    if (file_exists($_SERVER['DOCUMENT_ROOT']."/macro/{$_GET['project']}.ini"))
    { $macro = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/macro/{$_GET['project']}.ini"); }
    //pre($macro);

    if (isset ($_POST['del']))
    {
        $TABLE->tr_delete("{$sub_page_value}","{$_POST['hidden']}");
        list($data, $total_tr_count, $tr_count, $permissions, $title, $permission_status, $fio) = $MODEL->body();
    }
    elseif (isset ($_POST['edit']))
    {
        $TABLE->tr_edit($sub_page_value, $page_title,$title, $fio);
        list($data, $total_tr_count, $tr_count, $permissions, $title, $permission_status, $fio) = $MODEL->body();
    }
    elseif (isset ($_POST['add_tr']))
    {
        $TABLE->add_tr($sub_page_value,$macro);
        list($data, $total_tr_count, $tr_count, $permissions, $title, $permission_status, $fio) = $MODEL->body();
    }
    elseif (isset ($_POST['add_cell_btn']))
    {
        $DB->alter_add("{$_GET['project']}",mb_substr(translit($_POST['add_cell_text']), "0","25","UTF-8"));
        $DB->update("{$_GET['project']}",mb_substr(translit($_POST['add_cell_text']), "0","25","UTF-8"),"{$_POST['add_cell_text']}","`id` = '1'");
        $DB->alter_add("{$_GET['project']}_permission",mb_substr(translit($_POST['add_cell_text']), "0","25","UTF-8"));
        list($data, $total_tr_count, $tr_count, $permissions, $title, $permission_status, $fio) = $MODEL->body();
    }
    elseif (isset ($_POST['rename_cell']))
    {
        $TABLE->rename_cell($sub_page_value,"{$_POST['old_cell_name']}","{$_POST['new_cell_name']}");
        list($data, $total_tr_count, $tr_count, $permissions, $title, $permission_status, $fio) = $MODEL->body();
    }
    elseif (isset ($_POST['del_cell']))
    {
        $TABLE->delete_cell($_GET['project'], $_POST['del_cell_name']);
        list($data, $total_tr_count, $tr_count, $permissions, $title, $permission_status, $fio) = $MODEL->body();
    }
    elseif (isset ($_POST['replace_cell']))
    {
        $TABLE->replace_cell($_GET['project'], $_POST['replace_current_cell'], $_POST['replace_after_cell']);
        list($data, $total_tr_count, $tr_count, $permissions, $title, $permission_status, $fio) = $MODEL->body();
    }

    require_once($_SERVER['DOCUMENT_ROOT']."/body/pre_table/pre_table_query.php");


//    foreach ($_POST as $key => $value)
//    {
//        if (strpos($key,'_true_'))
//        {
//            $edit_true_bool = true;
//            $edit_true_count = explode("_","{$key}");
//            $edit_true_count = $edit_true_count[2];
//            //echo $edit_true_count.'<br>';
//        }
//    }

    //if (isset ($_POST['refresh'])) { header("Location: /?{$substring}"); }





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
        $DB->update("!sys_tables_namespace", "testing", "{$testing_status[1]}", "`name` = '{$substring}'");
    }
}

    if ($_COOKIE['user'] == 'admin') { $DB->select("*","!sys_tables_namespace"); }
    elseif ($_COOKIE['user'] != 'admin') { $DB->select("*","!sys_tables_namespace", "`released` = '1'"); }
    while ($row = mysqli_fetch_row($DB->sql_query_select))
    {
        $released_table[$count][1] = $row[1];
        $testing[$released_table[$count][1]] = $row[4];
        $count++;
    }
    //pre($testing);

$hid = 'hidden';
?>

<link rel="stylesheet" href="/body/sys/ege.css">

<form method = "post" enctype = "multipart/form-data">
    <input type = "<?= $hid ?>" name = 'hidden_sort_1' placeholder = 'hidden_sort_1'> <!-- Название столбца SQL -->
    <input type = "<?= $hid ?>" name = 'hidden_sort_2' placeholder = 'hidden_sort_2'> <!-- Тип сортировки -->
    <input type = "<?= $hid ?>" name = 'hidden_sort_3' placeholder = 'hidden_sort_3'> <!-- Номер столбца -->
    <input type = "<?= $hid ?>" name = 'hidden_sort_4' placeholder = 'hidden_sort_4'> <!--  -->
    <input type = "<?= $hid ?>" name = 'hidden_sort_5' placeholder = 'hidden_sort_5'> <!--  -->
    <input type = "<?= $hid ?>" name = 'hidden_sort_6' placeholder = 'hidden_sort_6' > <!--  -->
    <!-- ↓ Шапка таблицы ↓ -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/body/pre_table/tables_head.php'); ?>
    <!-- ↑ Шапка таблицы ↑ -->

    <input type = 'hidden' name = 'ver' value = '<?= $ver; ?>'>

    <div class = 'container-fluid' style = 'margin-top: -30px;'>
        <div class = 'row'>
            <div class = 'col-lg-12' style = 'padding-left: 0; padding-right: 0;'>

                <table class = 'table table-condensed table-striped table-bordered table-hover main_table' border = 1 style = 'margin-bottom: 36px;'>

                    <!-- ↓ Заголовок таблицы ↓ -->
                    <thead><?php require("pre_table/tables_title.php"); ?></thead>
                    <!-- ↑ Заголовок таблицы ↑ -->

                    <?php
                    if ($edit_true_bool == true)
                    {
                        $bool_edit = true;
                        $bool_query = true;

                        // ↓ Обновление данных в таблице ↓
                        require($_SERVER['DOCUMENT_ROOT'].'/body/sort.php');
                        require($_SERVER['DOCUMENT_ROOT'].'/body/data.php');
                    } ?>

                    <!-- ↓ Таблица ↓ -->
                    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/body/table/table.php'); ?>
                    <!-- ↑ Таблица ↑ -->

                </table>
            </div>
        </div>
    </div>



    <?php //if ($edit == '') { ?>
    <div class = 'container' style = 'height: 36px; position: fixed; bottom: 0; left: 0; width: 100%; padding-top: 5px;  cursor: default; background: black; color: white; text-align: center;'>
        <?php
        //if (($_COOKIE['user'] == 'admin') || ($current_users_access["{$substring}_status"] == 'superuser'))
        //{ require_once($_SERVER['DOCUMENT_ROOT'].'/body/pre_table/sys/admin_head.php'); } ?>
        <div class = 'row'>
            <div class = 'col-lg-4' style = 'padding-left: 8px;'>
                <?php if ($permission_status == 'superuser') { ?>
                <form method = "post">
                    <div style = 'float: left;'>
                        <button type = 'submit' name = 'show_adm_panel' style = 'background: black; float: left; border: solid 1px gold;'>
                            <div>
                            <span style = 'font-size: 18px; padding-top: 2px;' class = 'glyphicon glyphicon-cog'></span>
                            <div style = 'padding-left: 5px; padding-top: 3px; float: right; font-size: 12px;'>Администрирование</div>
                            </div>
                        </button>
                    </div>
                    <div style = 'margin-left: 10px; float: left;'>
                        <button type = 'submit' name = 'show_add_tr' style = 'background: black; float: left; border: solid 1px gold;'>
                            <div>
                            <span style = 'font-size: 18px; padding-top: 2px;' class = 'glyphicon glyphicon-plus'></span>
                            <div style = 'padding-left: 5px; padding-top: 3px; float: right; font-size: 12px;'>Добавление строки</div>
                            </div>
                        </button>
                    </div>
                </form>
                <?php }

                if (isset ($_POST['show_add_tr']))
                {
                    require_once($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/edit.php');
                    ?><script>$("#edit").modal("show");</script><?php
                }


                if ((isset ($_POST['show_adm_panel'])) || (isset ($_POST['add_new_tr'])))
                {
                    require_once ($_SERVER['DOCUMENT_ROOT'].'/body/sys/adm_panel.php');
                    ?><script>$("#adm_panel").modal("show");</script><?php
                }



                ?>
            </div>
            <div class = 'col-lg-4' style = 'padding-top: 3px;'>
                <?php



                if ((($_POST['hidden_sort_6'] != '') && ($_POST['hidden_sort_6'])) && ($_POST['inversion'] == false) || (isset ($_POST['search_btn'])))
                { echo "Показано записей: {$total_tr_count}".' ('.($tr_count + 1).')'; }
                else if ((($_POST['hidden_sort_6'] != '') && ($_POST['hidden_sort_6'])) && ($_POST['inversion'] == true) || (isset ($_POST['search_btn'])))
                { echo "Показано записей: {$total_tr_count}".' ('.($tr_count).')'; }
                else { echo "Показано записей: {$total_tr_count}".' ('.($tr_count).')'; }


                if (($testing[$substring] == 'monitoring') || ($testing[$substring] == 'sync')) { ?>
                    <input type = 'submit' name = 'success_btn' class = 'monitoring_btn' style = 'margin-left: 4px; background: forestgreen; width: 44px;' value = '<?= "{$status_success}" ?>'>
                    <input type = 'submit' name = 'warning_btn' class = 'monitoring_btn' style = 'background: orange;' value = '<?= "{$status_warning}" ?>'>
                    <input type = 'submit' name = 'danger_btn'  class = 'monitoring_btn' style = 'background: red;' value = '<?= "{$status_danger}" ?>'>
                    <input type = 'submit' name = 'empty_btn'   class = 'monitoring_btn' style = 'background: white;' value = '<?= "{$status_empty}" ?>'>
                <?php //} ?>
            </div>
            <div class = 'col-lg-4'></div>
        </div>
    </div>
<?php } ?>
</form>