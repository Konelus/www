<?php
    $status = '';
    $descriptor_r = fopen($_SERVER['DOCUMENT_ROOT'].'/status.txt', 'r');
    if ($descriptor_r)
    {
        while (($string = fgets($descriptor_r)) !== false)
        { $status = $status.$string; }
        fclose($descriptor_r);

        if ($status == 'enable')
        { $value = 'Выключить'; }
        else if ($status == 'disable')
        { $value = 'Включить'; }
    }

    if (isset ($_POST['break']))
    {
        if ($status == 'enable')
        {
            $descriptor_w = fopen($_SERVER['DOCUMENT_ROOT'] . '/status.txt', 'w+');
            fwrite($descriptor_w, 'disable');
            fclose($descriptor_w);
        }
        else if ($status == 'disable')
        {
            $descriptor_w = fopen($_SERVER['DOCUMENT_ROOT'] . '/status.txt', 'w+');
            fwrite($descriptor_w, 'enable');
            fclose($descriptor_w);

            $SQL_QUERY_ver = $mysqli->query("select `ver` from `ver` ");
            while ($row = mysqli_fetch_row($SQL_QUERY_ver))
            { $ver = $row[0]; }
            $ver_update = explode('.', $ver);
            $SQL_QUERY_ver_update = $mysqli->query("UPDATE ver SET `ver` = '" . $ver_update[0].'.'.$ver_update[1].'.'.($ver_update[2] + 1) . "' ");
        }
        echo "<script>window.location.href = window.location.href;</script>";
    }

    // ↓ Список таблиц ↓
    $tables_count = 1;
    $MYSQL_QUERY_tables = $mysqli->query("SELECT `description` FROM `tables_namespace` WHERE `name` = '".$podcat_name[1]."' ");
    while ($row = mysqli_fetch_row($MYSQL_QUERY_tables))
    { $table_name = $row[0]; }
    // ↑ Список таблиц ↑

    if (isset ($_POST['search_btn']))
    {
        $SQL_QUERY_sql_name = $mysqli->query("select `sql_name` from `".$podcat_name[1]."_table` where `name` = '".$_POST['selected_td']."' ");
        if ($SQL_QUERY_sql_name != null)
        {
            while ($row = mysqli_fetch_row($SQL_QUERY_sql_name))
            { $searched_td = $row[0]; }
        }
        $row_count = 0;
        $qqzz = $mysqli->query("select * from `".$podcat_name[1]."` where `".$searched_td."` =  '".$_POST['caption']."' ");
        $max_count_searched = mysqli_num_rows($qqzz);
        $max_count = $max_count_searched;

    //}
        //echo "select * from `".$podcat_name[1]."` where `".$searched_td ."` =  '".$_POST['caption']."' ".$sort." ";
    }



?>

<div class='container-fluid' style = 'margin-bottom: 40px;'>
    <div class='row main_div_margin'>
        <div class = 'col-lg-12 col-md-12 col-sm-12 affix' style = 'padding-left: 0; padding-right: 0; z-index: 1'>
        <?php if (($_COOKIE['user'] == 'admin') || ($current_users_access[$podcat_name[1].'_status'] == 'superuser')) { if ($_COOKIE['user'] != 'admin') { $bag_1 = 1; } else { $bag_1 = 0; } ?>


            <div class='col-lg-5 col-md-6 table_title_div table_bar_div'>

                <!-- ↓ Кнопки home и exit ↓ -->
                <div style = 'float: left; margin-left: 20px;' class = 'second_bar_div'><div class = 'exit_div'><input name = 'exit' class = 'exit_btn' type = 'submit' value = 'exit'></div></div>
                <div style = 'float: left; margin-left: 20px;' class = 'second_bar_div'><a href='/' class='table_add_href'>Home</a></div>
                <!-- ↑ Кнопки home и exit ↑ -->
                <?php if ($_COOKIE['user'] == 'admin') { ?>
                <div style = 'float: left; margin-left: 20px; margin-right: 10px;' class = 'second_bar_div'><div style = 'width: 100px; border: solid 1px gold;'><input name = 'break' class = 'exit_btn' type = 'submit' value = '<?php echo $value ?>'></div></div>
                <?php } ?>


                <!-- ↓ Форма поиска записей в таблице ↓ -->
                <div style = 'width: 15%; float: left; margin-right: 5px;'><input class = 'form-control table_search_input' autocomplete='off' type = 'text' name = 'caption'></div>
                <div style = 'width: 15%; float: left; margin-right: 5px;'>
                    <select class = 'form-control table_search_input' name = 'selected_td'>
                        <script> while (table_count <= (max_td_count - 1)) { document.write("<option>" + table_mass[table_count + <?php echo $bag_1 ?>] + "</option>"); table_count++; } table_count = 0; </script>
                    </select></div>
                <div style = 'width: 12%; float: left;' class = 'second_bar_div'><input value = 'search' type = 'submit' name = 'search_btn' class = 'table_search_btn'></div>
                <!-- ↑ Форма поиска записей в таблице ↑ -->
            </div>


            <div class='col-lg-2 col-md-2 table_title_div'>
                <div style = 'margin-top: 2px;'>
                    <?php $status = $current_users_access[$podcat_name[1].'_status'];
                    if (($_COOKIE['user'] == 'admin') || ($status == 'superuser')) { ?>
                        <input style = 'color: white; border: 0; background: black;' name = 'csv' type = 'submit' value = '<?php echo $table_name." (".($max_count).")"; ?>'>
                    <?php } ?>
                </div>
            </div>

            <div class='col-lg-5 col-md-4 table_title_div table_input_padding'>
            <!-- ↓ Форма установки лимита ↓ -->
                <div style = 'float: left; width: 25%;'>
                    <?php if ($_COOKIE['user'] == 'admin') { ?>
                    <input type='text' class = 'table_add_new_td_btn' value = '<?php echo ($lim - 2) ?>' style = 'width: 60%; float: left;' autocomplete='off' name='lim_text'>
                    <input class = 'table_small_add_btn' type='submit' value='!' name='lim_btn' style = 'width: 15%; float: left; margin-top: 4px; border: solid 1px grey;'>
                    <?php } ?>
                </div>
            <!-- ↑ Форма установки лимита ↑ -->


            <!-- ↓ Форма добавления столбца таблицы ↓ -->
                <div style = 'float: left; width: 25%;'>
                    <input type='text' class = 'table_add_new_td_btn' style = 'width: 60%; float: left;' autocomplete='off' name='new_td'>
                    <input class = 'table_small_add_btn' type='submit' value='+' name='add_td' style = 'width: 15%; float: left; margin-top: 4px; border: solid 1px grey;'>
                </div>
            <!-- ↑ Форма добавления столбца таблицы ↑ -->


            <!-- ↓ Форма удаления столбца таблицы ↓ -->
                <div style = 'float: left; width: 25%;'>
                    <select class = 'table_add_new_td_btn' name='old_td' style = 'width: 60%; float: left;'>
                        <script> while (table_count <= (max_td_count - 1)) { document.write("<option>" + table_mass[table_count + <?php echo $bag_1 ?> ] + "</option>"); table_count++; } table_count = 0; </script>
                    </select>
                    <input class = 'table_small_add_btn' type='submit' value='-' name='del_td' style = 'width: 15%; float: left; margin-top: 4px; border: solid 1px grey;'>
                </div>
            <!-- ↑ Форма удаления столбца таблицы ↑ -->


            <!-- ↓ Кнопка добавления новой записи ↓ -->
                <div style = 'float: right; margin-right: 10px; width: 20%;' class = 'table_add_div border_g'>
                    <input class = 'table_small_add_btn' type='submit' value='add' name='hide'>
                </div>
            <!-- ↑ Кнопка добавления новой записи ↑ -->
            </div>


        <?php } else if (($_COOKIE['user'] != 'admin') && ($current_users_access[$podcat_name[1].'_status'] != 'superuser')) {?>

            <!-- ↓ Форма поиска записей в таблице ↓ -->

                <div class='col-lg-3 col-md-4 col-sm-4 table_title_div table_search_input_div'>
                    <div style = 'width: 35%; float: left; margin-right: 5px;'><input class = 'form-control table_search_input' autocomplete='off' type = 'text' name = 'caption'></div>
                    <div style = 'width: 35%; float: left; margin-right: 5px;'><select class = 'form-control table_search_input' name = 'selected_td'>
                            <script> while (table_count <= (max_td_count - 1)) { document.write("<option>" + table_mass[table_count + 1] + "</option>"); table_count++; } table_count = 0; </script>
                        </select></div>
                    <div style = 'width: 20%; float: left;' class = 'second_bar_div'><input value = 'search' type = 'submit' name = 'search_btn' class = 'table_search_btn'></div>
                </div>

            <!-- ↑ Форма поиска записей в таблице ↑ -->

            <div class = 'col-lg-6 col-md-4 col-sm-3 table_title_div'><?php echo $table_name." (".($max_count).")"; ?></div>

            <!-- ↓ Кнопки home и exit ↑↓ -->
            <div class='col-lg-3 col-md-4 col-sm-5 table_title_div table_bar_div' style = 'float: right;'>
                <div class = 'second_bar_div'><div class = 'exit_div'><input name = 'exit' class = 'exit_btn' type = 'submit' value = 'exit' style = ''></div></div>
                <div class = 'second_bar_div' style = 'margin-left: 20px; margin-right: 30px;'><a href='/' class='table_add_href'>Home</a></div>
                <div class = '' style = 'margin-top: 1px; width: 160px; float: right;'><div class = '' style = 'width: 100%;'><a href = '<?php echo $cat_name ?>' style = 'background: black; border: 0; text-decoration: underline; color: white;'>Отмена сортировки</a></div></div>
            </div>
            <!-- ↑ Кнопки home и exit ↑ -->
        <?php } ?></div>
    </div>
</div>