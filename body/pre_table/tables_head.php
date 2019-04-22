<?php if (isset ($_POST['search_btn'])) { hidden_search(0); } ?>
    <div class='container-fluid' style = 'margin-bottom: 70px;'>
        <div class='row main_div_margin'>
            <div class = 'col-lg-12 col-md-12 col-sm-12 affix' style = 'padding-left: 0; padding-right: 0; z-index: 1'>
                <!-- ↓ Форма поиска записей в таблице ↓ -->
                <div class='col-lg-3 col-md-4 col-sm-4 table_title_div table_search_input_div'>
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
                <div class = 'col-lg-6 col-md-4 col-sm-3 table_title_div'>
                    <?php $status = $current_users_access[$substring.'_status'];
                    if (($_COOKIE['user'] == 'admin') || ($_COOKIE['user'] == 'Aleksandr.Kvasha@south.rt.ru') || ($_COOKIE['user'] == 'Vlasov@south.rt.ru') ||
                        ($_COOKIE['user'] == 'A.Pisarenko@south.rt.ru') || ($_COOKIE['user'] == 'Denis.Osadchiy@south.rt.ru') || ($status == 'superuser')) { ?>
                        <a target = '_blank' style = 'color: white; border: 0; background: black;' href = '/body/sys/csv.php/?<?= $substring ?>'><?= "{$page_title}"; ?> (выгрузка)</a>
                    <?php } else {  echo "<span style = 'cursor: default;'>{$page_title}</span>"; } ?>
                </div>

                <!-- ↓ Кнопки home и exit ↓ -->
                <div class='col-lg-3 col-md-4 col-sm-5 table_title_div table_bar_div' style = 'float: right;'>
                    <div class = 'second_bar_div'><div class = 'exit_div'><input name = 'exit' class = 'exit_btn' type = 'submit' value = 'exit' style = ''></div></div>
                    <div class = 'second_bar_div' style = 'margin-left: 20px; margin-right: 30px;'><a href='/' class='table_add_href'>Home</a></div>
                    <div class = '' style = 'margin-top: 1px; width: 160px; float: right;'>
                        <div style = 'width: 100%;'>
                            <input type = 'submit' name = 'refresh' style = 'background: black; border: 0; text-decoration: underline; color: white;' value = 'Отмена сортировки'>
                        </div>
                    </div>
                </div>
                <!-- ↑ Кнопки home и exit ↑ -->
            </div>
        </div>
    </div>
<?php if (isset ($_POST['search_btn'])) { hidden_search(1); } ?>