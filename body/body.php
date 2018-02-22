<?php
    // Добавление строки
    // Вывод строк
    // Вывод столбцов

    $status_warning = $status_danger = $status_success = $status_empty = 0;
    require_once($_SERVER['DOCUMENT_ROOT']."/body/query.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/body/pre_table/pre_table_query.php");
         //require($_SERVER['DOCUMENT_ROOT']."/body/sys/temporary_form.php");



    $group_query_1 = $mysqli->query("select `table_group` from `users` where `login` = '".$_COOKIE['user']."' ");
    while ($row = mysqli_fetch_row($group_query_1))
    { $users_group = $row[0]; $count++; }

    //if (isset ($_POST['success_btn'])) {}
    //else if (isset ($_POST['warning_btn'])) {}
    //else if (isset ($_POST['danger_btn'])) {}
    //else if (isset ($_POST['empty_btn'])) {}


?>

<link rel="stylesheet" href="/body/sys/ege.css">

<script>
    var table_count = 0;                                          // +
    var table_mass = <?= json_encode($table); ?>;          // +
    var bool_var = <?= json_encode($bool_var); ?>;         // +
    var max_td_count = <?= json_encode($table_count); ?>;  // +

    var bool_var_2 = <?= json_encode($bool_var_2); ?>;
    var max_tr_count = <?= json_encode($max_count); ?>;
    var table = <?= json_encode($title); ?>;
</script>




<form method = "post" id = 'form'>
    <input type = 'hidden' name = 'hidden_sort_5'> <!--  -->
    <input type = 'hidden' name = 'hidden_sort_6' > <!--  -->
    <!-- ↓ Шапка таблицы ↓ -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/body/pre_table/tables_head.php'); ?>
    <!-- ↑ Шапка таблицы ↑ -->

    <input type = 'hidden' name = 'ver' value = '<?= $ver; ?>'>

    <div class = 'container-fluid' style = 'margin-top: -30px;'>
        <div class = 'row'>
            <div class = 'col-lg-12' style = 'padding-left: 0px; padding-right: 0px;'>

                    <table class = 'table table-condensed table-striped main_table' border = 1>

                        <!-- ↓ Заголовок таблицы ↓ -->
                        <thead><?php require("pre_table/tables_title.php"); ?></thead>

                        <!-- ↑ Заголовок таблицы ↑ -->

                        <input type = 'hidden' name = 'hidden_sort_1'> <!-- Название столбца SQL -->
                        <input type = 'hidden' name = 'hidden_sort_2'> <!-- Тип сортировки -->
                        <input type = 'hidden' name = 'hidden_sort_3'> <!-- Номер столбца -->
                        <input type = 'hidden' name = 'hidden_sort_4' value = '<?= $lim ?>'> <!--  -->


                        <?php
                        if (!isset ($_POST['edit_true_'.$tr]))
                        {
                            require($_SERVER['DOCUMENT_ROOT'] . "/body/sort.php");
                            require($_SERVER['DOCUMENT_ROOT'] . "/body/data.php");
                        }
                        ?>



                        <!-- ↓ Форма добавления строки ↓ -->
                        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/body/pre_table/add_tr.php'); ?>
                        <!-- ↑ Форма добавления строки ↑ -->


                        <!-- ↓ Таблица ↓ -->
                        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/body/table/table.php'); ?>
                        <!-- ↑ Таблица ↑ -->

                    </table>

            </div>
        </div>
    </div>

    <?php
        if ($podcat_name[1] == 'vibory')
        { $status_count = "<input type = 'submit' name = 'success_btn' class = 'monitoring_btn' style = 'margin-left: 4px; background: forestgreen; width: 44px;  ' value = '{$status_success}'><input type = 'submit' name = 'warning_btn' class = 'monitoring_btn' style = 'background: orange;' value = '{$status_warning}'><input type = 'submit' name = 'danger_btn'  class = 'monitoring_btn' style = 'background: red;' value = '{$status_danger}'><input type = 'submit' name = 'empty_btn'   class = 'monitoring_btn' style = 'background: white;' value = '{$status_empty}'>"; }

        if (($caption != '') && ($_POST['inversion'] == false))
        { ?>
            <div style = 'height: 30px; position: fixed; bottom: 0; left: 0; width: 100%; padding-top: 5px; background: black; color: white; text-align: center;'>
                <?= "Показано записей: ".($tr_count - 2)." ({$max_count}) {$status_count}" ?></div>
        <?php }
        else if (($caption != '') && ($_POST['inversion'] == true))
        { ?>
            <div style = 'height: 30px; position: fixed; bottom: 0; left: 0; width: 100%; padding-top: 5px; background: black; color: white; text-align: center;'><?= 'Показано записей: '.($tr_count - 2).' ('.($max_count - 2).')'.$status_count ?></div>
        <?php }
        else { ?>
            <div style = 'height: 30px; position: fixed; bottom: 0; left: 0; width: 100%; padding-top: 5px; background: black; color: white; text-align: center;'><?= 'Показано записей: '.($tr_count).' ('.($max_count - 2).')'.$status_count ?></div>
        <?php }
    ?>

</form>