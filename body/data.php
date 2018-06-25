<?php
    //exit;
    $count =  $tr = 0;

    if (((!isset ($_POST['search_btn'])) && ($_POST['hidden_sort_5'] == '') && ($_POST['hidden_sort_6'] == '')))
    {
        $DB->select("*","{$substring}","", "{$sort}");
        $SQL_QUERY_select_data = $DB->sql_query_select;
        //selected_data("{$substring}","","{$sort}");
        //$tr = 2;
    }
    else if (((isset ($_POST['search_btn']))) || (($_POST['hidden_sort_5'] != '') && ($_POST['hidden_sort_6'] != '')))
        {
        //$tr = 0;
        $searched_td = sql_name("{$substring}","{$_POST['selected_td']}");

        $caption = $_POST['caption'];
        if (isset ($_POST['search_btn']))
        {
            //$tr = 1;
            $searched_tr = 1;
            if ( isset ($_POST['inversion']))
            {?><script>$('#cb').prop('checked', true);</script><?php } ?>
            <script>
                $('input[name = "hidden_sort_5"]').val("<?= $searched_td ?>");
                $('input[name = "hidden_sort_6"]').val("<?= trim($caption) ?>");
                $('input[name = "caption"]').val("<?= trim($caption) ?>");
            </script><?php
        }
        else if (!isset ($_POST['search_btn']))
        {
            //$tr = 2;
            $searched_tr = 1;
            $searched_td = $_POST['hidden_sort_5'];
            $caption = $_POST['hidden_sort_6'];
        }

        if (isset ($_POST['inversion']))
        {
            $DB->select("*","{$substring}","`{$searched_td}` !=  '".trim($caption)."'", "{$sort}");
            $SQL_QUERY_select_data = $DB->sql_query_select;
            //selected_data("{$substring}","`{$searched_td}` !=  '".trim($caption)."'","{$sort}");
        }
        else if (!isset ($_POST['inversion']))
        {
            $DB->select("*","{$substring}","`{$searched_td}` LIKE  '%".trim($caption)."%'", "{$sort}");
            $SQL_QUERY_select_data = $DB->sql_query_select;
            //selected_data("{$substring}","`{$searched_td}` LIKE  '%".trim($caption)."%'","{$sort}");

        }
    }

    // ↓ Вывод данных для мониторинга ↓
    if ($substring == 'vibory')
    {
        if ($testing[$substring] == 'monitoring')
        {
            if (isset ($_POST['success_btn']))
            { monitoring_search("{$substring}","success", "contact_groups"); }
            else if (isset ($_POST['warning_btn']))
            { monitoring_search("{$substring}","warning","contact_groups"); }
            else if (isset ($_POST['danger_btn']))
            { monitoring_search("{$substring}","danger","contact_groups"); }
            else if (isset ($_POST['empty_btn']))
            { monitoring_search("{$substring}","монтаж не произведён","gotovnost_obekta_da"); }
        }
        else if ($testing[$substring] == 'sync')
        {
            if (isset ($_POST['success_btn']))
            { monitoring_search("{$substring}","Cинхронизация завершена. Оборудование можно демонтировать", "cinhronizaciya"); }
            else if (isset ($_POST['warning_btn']))
            { monitoring_search("{$substring}","в процессе","cinhronizaciya"); }
            else if (isset ($_POST['danger_btn']))
            { monitoring_search("{$substring}","Необходима синхронизация на стенде","cinhronizaciya"); }
            else if (isset ($_POST['empty_btn']))
            { monitoring_search("{$substring}","в очереди","cinhronizaciya"); }
        }
    }
    // ↑ Вывод данных для мониторинга ↑

    foreach ($substring_table as $key => $value)
    {
        if (($value == 'contact_groups') && ($substring == 'vibory')) { $status_key = $key; }
        else if (($value == 'monitoring') && ($substring != 'vibory')) { $status_key = $key; }
        if ($value == 'cinhronizaciya') { $sync_key = $key; }
    }


//    if ($SQL_QUERY_select_data != null)
//    {
//        $tr_max = mysqli_num_rows($SQL_QUERY_select_data);
//        while ($row = mysqli_fetch_row($SQL_QUERY_select_data))
//        {
//            $title[$count][0] = $row[0];
//            $title[$count][1] = $row[1];
//            if ($substring == 'vibory')
//            {
//                $title[$count]['status'] = $row[$status_key];
//                $title[$count]['sync'] = $row[$sync_key];
//            }
//
//            for ($i = 0; $i <= count($row); $i++)
//            {
//                if (($title[$count][0] != 1) && ($title[$count][0] != 2))
//                {
//                    if ($_COOKIE['user'] != 'admin')
//                    {
//                        foreach ($new_td as $key => $value)
//                        {
//                            if ($value == $i) { $title[$count][$i] = $row[$i]; }
//                        }
//                    }
//                    else if ($_COOKIE['user'] == 'admin') { $title[$count][$i] = $row[$i]; }
//                }
//                else { unset($title[$count][0], $title[$count][1], $title[$count]['status'], $title[$count]['sync']); }
//            }
//
//            if (($row[0] == 1) || ($row[0] == 2)) { $tr++; }
//            $count++;
//        }
    //}
?>