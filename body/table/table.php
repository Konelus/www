<?php
    $bool_edit = false;
    $tr_count = 2;


    if ($substring == 'vibory')
    { $height = 'height: 100px;'; $scroll = 111; }
    else if ($substring == 'schools')
    { $height = 'height: 60px;'; $scroll = 78;}


    if ($_COOKIE['user'] == 'admin') { $max_td = $max_td_count; }
    else if ($_COOKIE['user'] != 'admin') { $max_td = $max_td_count_1; }


    // ↓ Readonly для textarea ↓
    if ($_COOKIE['user'] != 'admin')
    {
        permission("{$substring}", "{$current_users_group}_edit");
        $permission_edit = mysqli_fetch_row($DB->sql_query_select);
        foreach ($title1 as $key => $value)
        {
            if ($value == '+')
            {
                if ($permission_edit[$key] == '-') { $ro[$key - 1] = 'readonly'; }
                else if ($permission_edit[$key] == '+') { $ro[$key - 1] = ''; }
            }
        }
        unset($permission_edit);

        for ($td_0 = 1; $td_0 <= $max_td_count + 2; $td_0++)
        {
            if ($title1[$td_0] == '+')
            {
                if ($permission_edit[$td_0] == '-') { $ro[$td_0 - 1] = 'readonly'; }
                else if ($permission_edit[$td_0] == '+') { $ro[$td_0 - 1] = ''; }
            }
        }
    }
    // ↑ Readonly для textarea ↑

    $bool_edit = false;
    $td_td = 1;
    $bool_query = false;
    $tr_vision_count = 2;


    if ($_COOKIE['user'] != 'admin')
    {
        $DB->select("id_tr","{$substring}_vision","`{$_COOKIE['user']}` = '+'");
        {
            if ($DB->sql_query_select != null)
            { while ($row = mysqli_fetch_array($DB->sql_query_select))  { $tr_vision[$row[0]] = $row[0]; } }
        }
    }


//pre($title);

    if ($_COOKIE['user'] == 'admin') { $additional_td = 1; }
    else { $additional_td = 0; }


    if (count($title) >= 1)
    {
        for ($tr; $tr <= $tr_max; $tr++)
        {
            if ((($tr_vision[$title[$tr][0]]) == ($title[$tr][0])) || ($_COOKIE['user'] == 'admin'))
            {

                if (($substring == 'vibory') && (isset ($title[$tr]['status'])))
                {
                    if ($monitoring_view == 'monitoring')
                    {
                        if ($title[$tr]['status'] == 'success')
                        { $status_success++; }
                        else if ($title[$tr]['status'] == 'warning')
                        { $status_warning++; }
                        else if ($title[$tr]['status'] == 'danger')
                        { $status_danger++; }
                        if (($title[$tr][18] == 'монтаж не произведён'))
                        { $status_empty++; }
                    }
                    else if ($monitoring_view == 'sync')
                    {
                        if ($title[$tr]['sync'] == 'Cинхронизация завершена. Оборудование можно демонтировать')
                        { $status_success++; }
                        else if ($title[$tr]['sync'] == 'в процессе')
                        { $status_warning++; }
                        else if ($title[$tr]['sync'] == 'Необходима синхронизация на стенде')
                        { $status_danger++; }
                        else if ($title[$tr]['sync'] == 'в очереди')
                        { $status_empty++; }
                    }
                }



                if ($title[$tr] != '')
                {
                    $tr_count++;


                    ?><tr style='<?= $height ?>'><?php
                    $bool_var_2 = false;
                    if ((isset ($_POST['search_btn'])) && ($tr == 0)) { $searched_tr = 1; }
                    else { $searched_tr = 1;  }


                    // ↓ Скроллинг при нажатии кнопки редактирования ↓
                    if (isset ($_POST['edit_'.($tr + $searched_tr)]))
                    {
                        $bool_var_2 = true;
                        if ($_POST['hidden_sort_5'] != '') { $max_count--; }
                        ?>
                        <script>var current_tr = 0, this_tr = '';
                            this_tr = <?= json_encode($tr_count); ?>;
                            current_tr = (parseInt(this_tr - 5) * <?= $scroll ?>);
                            window.onload = function(){ window.scrollTo( 0, current_tr ); }
                        </script><?php
                    }
                    // ↑ Скроллинг при нажатии кнопки редактирования ↑


                    // ↓ Скроллинг при нажатии кнопки редактирования ↓
                    if (isset ($_POST['edit_true_' . ($tr + $searched_tr)]))
                    {
                        $bool_var_2 = false;
                        if ($_POST['hidden_sort_5'] != '') { $max_count--; }
                        ?>
                        <script>var current_tr = 0, this_tr = '';
                            this_tr = <?= json_encode($tr_count); ?>;
                            current_tr = (parseInt(this_tr - 5) * <?= $scroll ?>);
                            window.onload = function(){ window.scrollTo( 0, current_tr ); }
                        </script><?php
                    }
                    // ↑ Скроллинг при нажатии кнопки редактирования ↑

                    for ($td = 1; $td <= ($max_td + 3); $td++)
                    {

        /*  ↓ - - - - - - - - - - ↓ Сохранение отредактированной строки ↓ - - - - - - - - - - */
                        if ((isset ($_POST['edit_true_'.($tr + $searched_tr)])) && ($bool_query == false) && ($bool_edit == false))
                        {
//                            $bool_edit = true;
//                            $bool_query = true;
//
//                            //echo $tr.' --> 1';
//
//                            // ↓ Редактирование строки ↓
//                            require_once ($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/tr_edit.php');
//                            // ↑ Редактирование строки ↑
//
//
//                            //unset($title);
//                            // ↓ Обновление данных в таблице ↓
//                            require($_SERVER['DOCUMENT_ROOT'].'/body/sort.php');
//                            require($_SERVER['DOCUMENT_ROOT'].'/body/data.php');

                             // ↑ Обновление данных в таблице ↑
                        }
        /*  ↑ - - - - - - - - - - ↑ Сохранение отредактированной строки ↑ - - - - - - - - - - */


        /*  ↑ - - - - - - - - - - ↓ Формирование таблицы ↓ - - - - - - - - - - */

                        if ($td <= $max_td)
                        {


                            if ($new_td[$td_td] == $class_count)
                            { $class_color = 'table_head_bg2'; }
                            else if ((isset ($_POST['search_btn']) || ($_POST['hidden_sort_5'] != '')))
                            {
                                if ($new_td[$td_td] == $td_title_count)
                                { $class_color = 'table_bg_search'; }
                                else { $class_color = ''; }

                            }
                            else { $class_color = ''; }


                            if ($substring == 'vibory')
                            {
                                if ($monitoring_view == 'monitoring')
                                {
                                    if (($title[$tr][18] != 'монтаж не произведён') && ($class_color == ''))
                                    { $ready = $title[$tr]['status']; }
                                    else if (($title[$tr][18] != 'монтаж не произведён') || ($class_color == '')) { $ready = ''; }
                                    if ($class_color != '') { $ready = ''; }
                                }
                                else if ($monitoring_view == 'sync')
                                {
                                    if ($title[$tr]['sync'] == '') { $ready = ''; }
                                    else if (($title[$tr]['sync'] == 'Cинхронизация завершена. Оборудование можно демонтировать') && ($class_color == '')) { $ready = 'success'; }
                                    else if (($title[$tr]['sync'] == 'в процессе') && ($class_color == '')) { $ready = 'warning'; }
                                    else if (($title[$tr]['sync'] == 'Необходима синхронизация на стенде') && ($class_color == '')) { $ready = 'danger'; }
                                    else if (($title[$tr]['sync'] == 'в очереди') && ($class_color == '')) { $ready = ''; }
                                    if ($class_color != '') { $ready = ''; }
                                }
                            }



                            // ↓ Для админа ↓
                            if ($_COOKIE['user'] == 'admin')
                            { require ($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/content/admin_content.php'); }
                            // ↑ Для админа ↑


                            // ↓ Для обычного пользователя ↓
                            else if ($_COOKIE['user'] != 'admin')
                            { require ($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/content/user_content.php'); }
                            // ↑ Для обычного пользователя ↑
                        }
         /*  ↑ - - - - - - - - - - ↑ Формирование таблицы ↑ - - - - - - - - - - */


         /*  ↑ - - - - - - - - - - ↓ Формирование кнопок edit и del ↓ - - - - - - - - - - */

                        // ↓ Для админа ↓
                        if ($_COOKIE['user'] == 'admin') { require ($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/editor_buttons/admin_edit_buttons.php'); }
                        // ↑ Для админа ↑


                        // ↓ Для суперюзера ↓
                        else if ((($_COOKIE['user'] != 'admin') && ($current_users_access[$substring.'_status'] == 'superuser'))) { require ($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/editor_buttons/superuser_edit_buttons.php'); }
                        // ↑ Для суперюзера ↑


                        // ↓ Для юзера ↓
                        else if (($_COOKIE['user'] != 'admin') && ($current_users_access[$substring.'_status'] == 'user'))  { require ($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/editor_buttons/user_edit_buttons.php'); }
                        // ↑ Для рюзера ↑

        /*  ↑ - - - - - - - - - - ↑ Формирование кнопок edit и del ↑ - - - - - - - - - - */

                    }
                    $bool_query = false;
                    $td_td = 1;
                }
            }
            ?></tr><?php
        }
    }


    ?>


