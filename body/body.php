<?php
    // Добавление строки
    // Вывод строк
    // Вывод столбцов

    require_once($_SERVER['DOCUMENT_ROOT']."/body/query.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/body/pre_table/pre_table_query.php");



    $group_query_1 = $mysqli->query("select `table_group` from `users` where `login` = '".$_COOKIE['user']."' ");
    while ($row = mysqli_fetch_row($group_query_1))
    { $users_group = $row[0]; $count++; }

?>

<link rel="stylesheet" href="/body/sys/ege.css">

<script>
    var table_count = 0;                                          // +
    var table_mass = <?php echo json_encode($table); ?>;          // +
    var bool_var = <?php echo json_encode($bool_var); ?>;         // +
    var max_td_count = <?php echo json_encode($table_count); ?>;  // +

    var bool_var_2 = <?php echo json_encode($bool_var_2); ?>;
    var max_tr_count = <?php echo json_encode($max_count); ?>;
    var table = <?php echo json_encode($title); ?>;
</script>




<form method = "post" id = 'form'>
    <input type = 'hidden' name = 'hidden_sort_5'> <!--  -->
    <input type = 'hidden' name = 'hidden_sort_6' > <!--  -->
    <!-- ↓ Шапка таблицы ↓ -->
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/body/pre_table/tables_head.php'); ?>
    <!-- ↑ Шапка таблицы ↑ -->

    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/body/sys/csv.php'); ?>

    <input type = 'hidden' name = 'ver' value = '<?php echo $ver; ?>'>
<div class = 'container-fluid'>
    <div class = 'row'>
        <div class = 'col-lg-12' style = 'padding-left: 0px; padding-right: 0px;'>

                <table class = 'table table-condensed table-striped main_table' border = 1>

                    <!-- ↓ Заголовок таблицы ↓ -->
                    <thead><?php require("pre_table/tables_title.php"); ?></thead>
                    <!-- ↑ Заголовок таблицы ↑ -->

                    <input type = 'hidden' name = 'hidden_sort_1'> <!-- Название столбца SQL -->
                    <input type = 'hidden' name = 'hidden_sort_2'> <!-- Тип сортировки -->
                    <input type = 'hidden' name = 'hidden_sort_3'> <!-- Номер столбца -->
                    <input type = 'hidden' name = 'hidden_sort_4' value = '<?php echo $lim ?>'> <!--  -->


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

</form>