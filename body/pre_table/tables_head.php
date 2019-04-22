<?php if (isset ($_POST['search_btn'])) { hidden_search(0); } ?>
    <div class='container-fluid' style = 'margin-bottom: 70px;'>
        <div class='row main_div_margin'>
            <div class = 'col-lg-12 col-md-12 col-sm-12 affix' style = 'padding-left: 0; padding-right: 0; z-index: 1'>
                <!-- ↓ Форма поиска записей в таблице ↓ -->
                <div class='col-lg-4 col-md-4 col-sm-4 table_title_div table_search_input_div'>
                    <?php if (isset ($_POST['inversion'])) { $ch = 'checked'; } else { $ch = ''; } ?>
                    <div style = 'margin-top: 2px; width: 10%; float: left; margin-right: 5px;'><label for = 'cb'>не </label><div style = 'float: right; margin-top: 2px;'><input <?= $ch ?> id = 'cb' type = 'checkbox' name = 'inversion'></div></div>
                    <div style = 'width: 30%; float: left; margin-right: 5px;'><input style = 'padding-left: 5px; padding-right: 5px;' class = 'form-control table_search_input' autocomplete='off' type = 'text' name = 'caption'></div>
                    <div style = 'width: 35%; float: left; margin-right: 5px;'>
                        <select class = 'form-control table_search_input' name = 'selected_td' style = 'padding-top: 4px;'>
                            <?php
                            foreach ($title as $key => $value)
                            {
                                if ($key != 'id')
                                {
                                    if ($_POST['hidden_sort_5'] == $value) { $selected = 'selected'; } else { $selected = ''; }
                                    echo "<option $selected>$value</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div style = 'width: 20%; float: left;' class = 'second_bar_div'><input value = 'Поиск' type = 'submit' name = 'search_btn' class = 'table_search_btn'></div>
                </div>

                <!-- ↑ Форма поиска записей в таблице ↑ -->
                <div class = 'col-lg-4 col-md-4 col-sm-3 table_title_div'>
                    <?php $status = $current_users_access[$substring.'_status'];
                    if ((isset($macro['unload'])) && ($macro['unload'] == 'true')) { $temp_unload_users = explode(",",$macro['unload_users']); }

                    /** ↓ dump_macros ↓ **/
//                    if (stripos("{$_GET['project']}","_dump") !== false) { $dump_value = ' - <span style = "color: gold;">ARCHIVE</span>'; }
//                    else { $dump_value = ''; }
                    /** ↑ dump_macros ↑ **/

                    $unload_users = '';
                    $check_link = false;
                    if (isset ($temp_unload_users))
                    {
                        foreach ($temp_unload_users as $key => $value)
                        {
                            if (($_COOKIE['user'] == 'admin') || ($permission_status == 'superuser') || ($_COOKIE['user'] == $value))
                            {
                                echo "<a target = '_blank' style = 'color: white; border: 0; background: black;' href = '/body/sys/csv.php/?{$substring}'>{$page_title}{$dump_value} (выгрузка)</a>";
                                $check_link = true;
                                break;
                            }
                        }
                    }
                    elseif (($_COOKIE['user'] == 'admin') || ($permission_status == 'superuser'))
                    { echo "<a target = '_blank' style = 'color: white; border: 0; background: black;' href = '/body/sys/csv.php/?{$substring}'>{$page_title}{$dump_value} (выгрузка)</a>"; $check_link = true; }
                    if ($check_link == false) {  echo "<span style = 'cursor: default;'>{$page_title}{$dump_value}</span>"; } ?>
                </div>

                <!-- ↓ Кнопки home и exit ↓ -->
                <div class='col-lg-4 col-md-4 col-sm-5 table_title_div table_bar_div' style = 'float: right;'>
                    <div class = 'second_bar_div' style = 'margin-right: 10px;'><div class = 'exit_div' style = 'width: 70px;'><input name = 'exit' class = 'exit_btn' type = 'submit' value = 'Выход' style = 'font-size: 15px;'></div></div>
                    <div class = 'second_bar_div' style = 'margin-right: 30px;'><a style = 'font-size: 15px;' href='/' class='table_add_href'>Главная</a></div>
                    <div class = 'second_bar_div' style = 'float: right; margin-right: 30px;'>
                        <input class = 'table_add_href' type = 'submit' name = 'refresh' style = 'font-size: 15px; background: black; border: 0; text-decoration: underline; color: white;' value = 'Обновить'>
                    </div>


                </div>
                <!-- ↑ Кнопки home и exit ↑ -->
            </div>
        </div>
    </div>
<?php if (isset ($_POST['search_btn'])) { hidden_search(1); } ?>