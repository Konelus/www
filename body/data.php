<?php
    $title = '';
    $count = 0;

    if (((!isset ($_POST['search_btn'])) && ($_POST['hidden_sort_5'] == '') && ($_POST['hidden_sort_6'] == '')))
    { selected_data("{$substring}","","{$sort}"); }
    else if (((isset ($_POST['search_btn']))) || (($_POST['hidden_sort_5'] != '') && ($_POST['hidden_sort_6'] != '')))
    {
        sql_name("{$substring}","{$_POST['selected_td']}"); $searched_td = $result;

        $caption = $_POST['caption'];
        if (isset ($_POST['search_btn']))
        {
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
            $searched_tr = 1;
            $searched_td = $_POST['hidden_sort_5'];
            $caption = $_POST['hidden_sort_6'];
        }

        if (isset ($_POST['inversion']))
        { selected_data("{$substring}","`{$searched_td}` !=  '".trim($caption)."'","{$sort}"); }
        else if (!isset ($_POST['inversion']))
        { selected_data("{$substring}","`{$searched_td}` LIKE  '%".trim($caption)."%'","{$sort}"); }
    }


    // ↓ Вывод данных для мониторинга ↓
    if (isset ($_POST['success_btn']))
    { monitoring_search("{$substring}","success"); }
    else if (isset ($_POST['warning_btn']))
    { monitoring_search("{$substring}","warning"); }
    else if (isset ($_POST['danger_btn']))
    { monitoring_search("{$substring}","danger"); }
    else if (isset ($_POST['empty_btn']))
    { monitoring_search("{$substring}",""); }
    // ↑ Вывод данных для мониторинга ↑


    if ($SQL_QUERY_select_data != null)
    {
        while ($row = mysqli_fetch_row($SQL_QUERY_select_data))
        {
            if (($substring == 'vibory') && (is_numeric($row[1])))
            {
                for ($i = 0; $i <= count($row); $i++)
                {
                    if ($_COOKIE['user'] != 'admin')
                    {
                        $title[$count]['status'] = $row[40];
                        foreach ($new_td as $key => $value)
                        {
                            if ($value == $i) { $title[$count][$i] = $row[$i]; }
                        }
                    }
                    else if ($_COOKIE['user'] == 'admin') { $title[$count][$i] = $row[$i]; }
                }
            }
            else if ($substring != 'vibory')
            {
                for ($i = 0; $i <= count($row); $i++)
                { $title[$count][$i] = $row[$i]; }
            }
            $tr_new_count[$count] = $row[0];
            $count++;
        }
    }

?>