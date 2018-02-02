<div class='col-lg-5 col-md-6 col-sm-7 table_title_div table_input_padding'>
        <div style = 'float: left; width: 195px; padding-left: 5px;'>
            <input type='text' class = 'table_add_new_td_btn' style = 'width: 120px; float: left;' autocomplete='off' name='new_td'>
            <input class = 'table_small_add_btn' type='submit' value='+' name='add_td' style = 'height: 28px; width: 50px; float: left; border: solid 1px grey;'>
        </div>
        <!-- ↑ Форма добавления столбца таблицы ↑ -->


        <!-- ↓ Форма удаления столбца таблицы ↓ -->
        <div style = 'float: left; width: 190px;'>
            <select class = 'table_add_new_td_btn' name='old_td' style = 'width: 120px; float: left;'>
                <script> while (table_count <= (max_td_count - 1)) { document.write("<option>" + table_mass[table_count + <?php echo $bag_1 ?> ] + "</option>"); table_count++; } table_count = 0; </script>
            </select>
            <input class = 'table_small_add_btn' type='submit' value='-' name='del_td' style = 'height: 28px; width: 50px; float: left; border: solid 1px grey;'>
        </div>
        <!-- ↑ Форма удаления столбца таблицы ↑ -->


        <!-- ↓ Кнопка добавления новой записи ↓ -->
        <div style = 'float: left; width: 80px;'>
            <input class = 'table_small_add_btn' type='submit' value='add' name='hide' style = 'height: 28px; width: 80px; float: left; border: solid 1px grey;'>
        </div>
</div>
<div class='col-lg-4 col-md-2 col-sm-1 table_title_div table_input_padding'>


</div>
<div class='col-lg-3 col-md-4 col-sm-4 table_title_div table_bar_div'>

    <?php if ($_COOKIE['user'] == 'admin') { ?>

        <div style = 'float: right;'>
            <div style = 'float: left;  margin-right: 10px;' class = 'second_bar_div'>
                <div style = 'width: 100px; border: solid 1px gold;'>
                    <input name = 'break' class = 'exit_btn' type = 'submit' value = '<?php echo $value ?>'>
                </div>
            </div>


            <div style = 'float: left; width: 150px;'>
                <input type='text' class = 'table_add_new_td_btn' value = '<?php echo ($lim - 2) ?>' style = 'width: 90px; float: left;' autocomplete='off' name='lim_text'>
                <input class = 'table_small_add_btn' type='submit' value='limit' name='lim_btn' style = 'width: 50px; float: left; height: 28px; border: solid 1px grey;'>
            </div>
        </div>
    <?php } ?>
</div>

