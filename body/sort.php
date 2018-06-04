<?php
    $sort = $sql_text = '';
    //$c = 1;

    $DB->select("*","{$substring}_table");
    if ($DB->sql_query_select != null)
    {
        $count = 1;
        while ($row = mysqli_fetch_row($DB->sql_query_select))
        {
            if (($title1[$count + 1] == '+') && ($_COOKIE['user'] != 'admin'))
            {
                $sql_text[$count] = $row[1];
                $str1[$count] = str_replace(' ', '_', $sql_text[$count]);
                $str[$count] = str_replace('.', '', $str1[$count]);

            }
            else if ($_COOKIE['user'] == 'admin')
            {
                $sql_text[$count] = $row[1];
                $str1[$count] = str_replace(' ', '_', $sql_text[$count]);
                $str[$count] = str_replace('.', '', $str1[$count]);

            }


            if ((isset($_POST[$str[$count].'_asc'])) || (isset($_POST[$str[$count].'_desc'])))
            {
                ?><script>
                    $('input[name = "hidden_sort_1"]').val("<?= $row[2] ?>");
                    $('input[name = "hidden_sort_3"]').val("<?= $count ?>");
                 </script><?php
                $class_count = $count;

                if (isset($_POST[$str[$count].'_asc']))
                { ?><script>$('input[name = "hidden_sort_2"]').val("ASC");</script><?php $sort = "`{$row[2]}` ASC"; }
                if (isset($_POST[$str[$count].'_desc']))
                { ?><script>$('input[name = "hidden_sort_2"]').val("DESC");</script><?php $sort = "`{$row[2]}` DESC"; }
            }
            $count++;
        }
        unset ($count,$sql_text,$str1);
    }


    if (((isset ($_POST['search_btn'])) && ($_POST['inversion'] == false)))
    {
        $DB->select("sql_name","{$substring}_table","`name` = '{$_POST['selected_td']}'");
        while ($row = mysqli_fetch_row($DB->sql_query_select))
        { $sql_td = $row[0]; }
        $DB->select("*","{$substring}","`{$sql_td}` LIKE '%{$_POST['caption']}%'");
        //$count++;
        $max_count = mysqli_num_rows($DB->sql_query_select) + 1;
    }


    for ($button_count = 0; $button_count <= $max_count; $button_count++)
    {
        if ((isset($_POST["edit_{$button_count}"])) || (isset($_POST["edit_true_{$button_count}"])))
        {
            $hid_1 = $_POST['hidden_sort_1'];
            $hid_2 = $_POST['hidden_sort_2'];
            $hid_3 = $_POST['hidden_sort_3'];
            $lim = $_POST['hidden_sort_4'];
            $class_count = $hid_3;
            $searched_td =  $_POST['hidden_sort_5'];
            $caption =  $_POST['hidden_sort_6'];

            ?><script>
                $('input[name = "hidden_sort_1"]').val("<?= $hid_1 ?>");
                $('input[name = "hidden_sort_2"]').val("<?= $hid_2 ?>");
                $('input[name = "hidden_sort_3"]').val("<?= $hid_3 ?>");
                $('input[name = "hidden_sort_5"]').val("<?= $searched_td ?>");
                $('input[name = "hidden_sort_6"]').val("<?= trim($caption) ?>");
                $('input[name = "caption"]').val("<?= trim($caption) ?>");
            </script><?php

            if (($hid_1 != '') || ($hid_2 != ''))
            { $sort = "`{$hid_1}` {$hid_2}"; }
            if ($lim != '')
            { $lim = " LIMIT {$lim}"; }
            //if (isset($_POST["edit_{$button_count}"]))
            //{ $bool_var_2 = true; }
            //else if (isset($_POST["edit_true_{$button_count}"]))
            //{ $bool_var_2 = false; }
        }
    }
?>