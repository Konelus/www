<?php

//    $varrr = 'edit_true_231';
//    if (strpos('edit_true_231', 'edit_'))
//    { echo 'cerrrrrf'; }


//    $post = array_keys($_POST);
//    //print_r($post);
//    foreach ($post as $key)
//    {
//
//
//
//        //echo $val.'<br>';
//        //if (strpos("$key", 'ver'))
//        //{ echo $key.'!!'; }
//        //else { echo "$key<br>"; }
//    }


    $tr_count = 2;

    if ($podcat_name[1] == 'vibory')
    { $height = 'height: 100px;'; $scroll = 111; }


    else if ($podcat_name[1] == 'schools')
    { $height = 'height: 60px;'; $scroll = 78;}

    if ($_COOKIE['user'] == 'admin') { $max_td = $max_td_count; }
    else if ($_COOKIE['user'] != 'admin') { $max_td = $max_td_count_1; }


    // ↓ Readonle для textarea ↓
    if ($_COOKIE['user'] != 'admin')
    {
        $permissions_edit_query = $mysqli->query("select * from `" . $podcat_name[1] . "_permission` where `" . $podcat_name[1] . "_group` = '" . $current_users_group[0] . "_edit' ");
        $permission_edit = mysqli_fetch_row($permissions_edit_query);

        for ($td_0 = 1; $td_0 <= $max_td_count + 2; $td_0++)
        {
            if ($title1[$td_0] == '+')
            {
                if ($permission_edit[$td_0] == '-') { $ro[$td_0 - 1] = 'readonly'; }
                else if ($permission_edit[$td_0] == '+') { $ro[$td_0 - 1] = ''; }
            }
        }
    }
    // ↑ Readonle для textarea ↑

    $bool_chb = false;
    $bool_edit = false;
    $td_td = 1;
    //$tr_count = 0;
    $bool_query = 0;
    $tr_vision_count = 2;

    //$tr_class = '';

    if ($_COOKIE['user'] != 'admin')
    {
        $SQL_QUERY_tr_vision = $mysqli->query("select `id_tr` from `" . $podcat_name[1] . "_vision` where `".$_COOKIE['user']."` = '+' ");
        {
            if ($SQL_QUERY_tr_vision != null)
            { while ($row = mysqli_fetch_array($SQL_QUERY_tr_vision))  { $tr_vision[$row[0]] = $row[0]; } }
        }
        //echo "select `id_tr` from `" . $podcat_name[1] . "_vision` where `".$_COOKIE['user']."` = '+' ";

    }

    $vision_permission_count = 0;
    $SQL_QUERY_vision_login = $mysqli->query("SHOW COLUMNS FROM `".$podcat_name[1]."_vision`");
    if ($SQL_QUERY_vision_login != null) {
        {
            while ($row = mysqli_fetch_array($SQL_QUERY_vision_login)) {
                $vision_login[$vision_permission_count] = $row[0];
                $vision_permission_count++;
            }
        }
    }

    if ($_COOKIE['user'] == 'admin') { $additional_td = 1; }
    else { $additional_td = 0; }





    if ($max_count >= 1)
    {
        for ($tr = 0; $tr <= $max_count; $tr++)
        {
            if ((($tr_vision[$title[$tr][0]]) == ($title[$tr][0])) || ($_COOKIE['user'] == 'admin'))
            {
                if ($title[$tr][0] != '')
                {

                    $tr_count++;

                    if (isset ($_POST['add_in_vision_submit_'.$tr]))
                    { $DB->update($podcat_name[1]."_vision`","".$_POST['add_in_vision_text_'.$tr],"+","`id_tr` = '".$title[$tr][0]."'"); }

                    $ready_date = '';
                    $DB->select("alarm",$podcat_name[1]."_monitoring","`uik` = '".$title[$tr][3]."'");
                    $alarm_query = $DB->sql_query_select;
                    while ($row = mysqli_fetch_row($alarm_query))
                    { $ready_date = $row[0]; }


                    ?><tr style='<?php echo $height ?>' id = '<?php echo $tr ?>'><?php
                    for ($td = 1; $td <= ($max_td + 3); $td++)
                    {

                        // ↓ Скроллинг при нажатии кнопки редактирования ↓
                        if (isset ($_POST['edit_' . ($tr + $searched_tr)]))
                        {
                            $bool_var_2 = 1; ?>
                            <script>var current_tr = 0, this_tr = '';
                                this_tr = <?php echo json_encode($tr_count); ?>;
                                current_tr = (parseInt(this_tr - 5) * <?php echo $scroll ?>);
                                window.onload = function(){ window.scrollTo( 0, current_tr ); }
                            </script><?php
//                            $searched_td = $_POST['hidden_sort_5'];
//                            $caption = $_POST['hidden_sort_6'];

                        }
                        // ↑ Скроллинг при нажатии кнопки редактирования ↑



        /*  ↓ - - - - - - - - - - ↓ Сохранение отредактированной строки ↓ - - - - - - - - - - */
                        if ((isset ($_POST['edit_true_' . ($tr + $searched_tr)])) && ($bool_query == 0) && ($bool_edit == false))
                        {
                            $bool_edit = true;
                            $bool_query = 1;
//                            $searched_td = $_POST['hidden_sort_5'];
//                            $caption = $_POST['hidden_sort_6'];

                            // ↓ Скроллинг при нажатии кнопки редактирования ↓
                            if (isset ($_POST['edit_true_' . ($tr + $searched_tr)]))
                            {
                                $bool_var_2 = 0; ?>
                                <script>var current_tr = 0, this_tr = '';
                                    this_tr = <?php echo json_encode($tr_count); ?>;
                                    current_tr = (parseInt(this_tr - 5) * <?php echo $scroll ?>);
                                    window.onload = function(){ window.scrollTo( 0, current_tr ); }
                                </script><?php
                            }
                            // ↑ Скроллинг при нажатии кнопки редактирования ↑


                            // ↓ Редактирование строки ↓
                            require_once ($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/tr_edit.php');

                            // ↑ Редактирование строки ↑


                            // ↓ Обновление данных в таблице ↓
                            require($_SERVER['DOCUMENT_ROOT'] . "/body/sort.php");
                            require($_SERVER['DOCUMENT_ROOT'] . "/body/data.php");
                             // ↑ Обновление данных в таблице ↑
                        }
        /*  ↑ - - - - - - - - - - ↑ Сохранение отредактированной строки ↑ - - - - - - - - - - */


        /*  ↑ - - - - - - - - - - ↓ Формирование таблицы ↓ - - - - - - - - - - */

                        if ($td <= $max_td + $additional_td)
                        {



                            if ($new_td[$td_td] == $class_count)
                            { $class_color = 'table_head_bg2'; }
                            else if ((isset ($_POST['search_btn']) || ($_POST['hidden_sort_5'] != '')))
                            {
                                if (isset ($_POST['search_btn']))
                                { $SQL_QUERY_select_searched_id = $mysqli->query("SELECT `id` FROM `".$podcat_name[1]."_table` where `name` = '".$_POST['selected_td']."' "); }
                                else if ($_POST['hidden_sort_5'] != '')
                                { $SQL_QUERY_select_searched_id = $mysqli->query("SELECT `id` FROM `".$podcat_name[1]."_table` where `sql_name` = '".$_POST['hidden_sort_5']."' "); }
                                while ($row = mysqli_fetch_row($SQL_QUERY_select_searched_id))
                                { $td_title_count = $row[0]; }
                                if ($new_td[$td_td] == $td_title_count)
                                { $class_color = 'table_bg_search'; }
                                else { $class_color = ''; }
                            }
                            else { $class_color = ''; }






                            if (($title[$tr][18] != 'монтаж не произведён') && ($class_color == ''))
                            {
                                if (($ready_date != 'success') && ($ready_date != ''))
                                {
                                    $alarm_date = explode(".","{$ready_date}");
                                    $today = date("d");
                                    if ($today == $alarm_date[0]) { $ready = 'warning'; }
                                    else if ($today > $alarm_date[0]) { $ready = 'danger'; }
                                }
                                else if (($ready_date == 'success') && ($ready_date != '')) { $ready = 'success'; }
                                else { $ready = ''; }
                            }
                            else if (($title[$tr][18] != 'монтаж не произведён') || ($class_color == ''))
                            { $ready = ''; }






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
                        else if ((($_COOKIE['user'] != 'admin') && ($current_users_access[$podcat_name[1].'_status'] == 'superuser'))) { require ($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/editor_buttons/superuser_edit_buttons.php'); }
                        // ↑ Для суперюзера ↑


                        // ↓ Для юзера ↓
                        else if (($_COOKIE['user'] != 'admin') && ($current_users_access[$podcat_name[1].'_status'] == 'user'))  { require ($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/editor_buttons/user_edit_buttons.php'); }
                        // ↑ Для рюзера ↑

        /*  ↑ - - - - - - - - - - ↑ Формирование кнопок edit и del ↑ - - - - - - - - - - */

                    }
                    //$tr_count++;
                    $bool_query = 0;
                    $bool_var_2 = 0;
                    $td_td = 1;
                }
            }


             ?></tr><?php

        }
    }

    ?>


