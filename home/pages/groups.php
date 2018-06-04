<?php
    require_once ($_SERVER['DOCUMENT_ROOT'].'/home/pages/class/class_groups.php');

    if ((isset ($_POST['add_group'])) && ($_POST['group_name'] != '')) { $ADM_GROUPS->add_group(trim($_POST['group_name'])); }

    $ADM_GROUPS->tables_list();
    $columns_rus = $ADM_GROUPS->columns_rus;
    $ADM_GROUPS->groups_list();
    $cell_value = $ADM_GROUPS->cell_value;

    if (isset ($_POST) && ($_POST != null))
    {
        $edit = false;
        foreach ($_POST as $key => $value)
        {
            if (stripos("{$key}","edit_btn") !== false)
            {
                $edit_explode = explode("_","{$key}");
                $show_count = $edit_explode[2];
                $edit = true;
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
    </head>
    <body>
        <div class = 'container'>
            <div class = 'row'>
                <form method="post">
                    <div class = 'col-lg-12' style = 'padding-bottom: 5px; padding-top: 2px;'>

                            <div style = 'width: 490px; margin: auto;'>
                                <div style = 'float: left; cursor: default; margin-right: 4px; font-size: 20px; margin-top: 5px;'>Добавление группы</div>
                                <div style = 'float: left; margin-left: 2px;'><input type='text' style = 'width: 200px; color: black; margin-top: 4px; border: solid 1px black; padding-left: 5px; padding-right: 5px;' class = 'form-control text_box_border' autocomplete='off' name='group_name'></div>
                                <div style = 'float: left;'><input class = 'table_small_add_btn btn' type='submit' value='Добавить' name='add_group' style = 'color: white; background: black; margin-left: 5px; margin-top: 4px; border: solid 1px grey;'></div>
                            </div>

                    </div>
                    <div class = 'col-lg-12'>
                        <table class = 'table table-bordered table-striped' style = 'cursor: default;'>
                            <tr>
                                <td style = 'color: white; background: black; font-size: 15px; text-align: center;'>Группа</td>
                                <?php foreach ($columns_rus as $key => $value)
                                {
                                    if ($value[2] != 1) { $table_status[$key] = 'background: #cf3434;'; } else { $table_status[$key] = ''; }
                                    echo "<td style = 'color: white; background: black; font-size: 15px; text-align: center;'>{$value[1]}</td>";
                                } ?>
                                <td style = 'color: white; background: black; font-size: 15px; text-align: center;'>Ред</td>
                            </tr>
                                <?php
                                $n_count = 0;
                                foreach ($cell_value as $key => $value)
                                {
                                    echo "<tr style = 'font-size: 15px;'>";
                                    $count = 0;
                                    foreach ($value as $nv_key => $nv_value)
                                    {
                                        if ($nv_key !== 0) { echo "<td style = '{$table_status[$count]} text-align: center;'>{$nv_value}</td>"; $count++;  }
                                        elseif ($nv_key === 0) { echo "<td>{$nv_value}</td>"; }
                                    }
                                    ?><td><input name = 'edit_btn_<?= $n_count ?>' type = 'submit' class = 'btn' style = 'padding-top: 2px; height: 26px; color: white; background: black;' value = 'Ред'></td><?php $n_count++;
                                    echo "</tr>";
                                } ?>
                        </table>
                    </div>
                </form>
            </div>
        </div>

        <?php
            if (!isset ($_POST['add_group'])) { require_once($_SERVER['DOCUMENT_ROOT'].'/home/pages/groups/modal_edit.php');}
            if ($edit == true)
            {
                $ADM_GROUPS->group_access($cell_value[$show_count][0]);
                $group_access = $ADM_GROUPS->group_access;

                foreach ($columns_rus as $c_key => $c_value)
                {
                    if ($group_access["{$c_value[0]}_status"] == 'user') { $option = "$c_value[0]_user"; }
                    elseif ($group_access["{$c_value[0]}_status"] == 'superuser') { $option = "$c_value[0]_superuser"; }
                    elseif ($group_access["{$c_value[0]}_status"] == 'readonly') { $option = "$c_value[0]_readonly"; echo $cell_value[$show_count][0].' --> '.$group_access["{$c_value[0]}_status"].'<br>'; }
                    else { $option = "$c_value[0]_none"; }
                    ?><script>$("#select #<?= $option ?>").prop("selected", true)</script><?php
                } ?>

                <script>$("#hidden").val("<?= $show_count ?>");</script>



                <script>$("#title").html("Редактирование группы <span style = 'color: navy; text-decoration: underline;'><?= $cell_value[$show_count][0] ?></span>")</script>
                <script>$("#modal_edit").modal("show");</script>
            <?php }
        ?>

    </body>
</html>
