<?php
    $sql = '';
    $sort = '';
    $sql_text = '';
    $c = 1;
    $button_count = 1;


    $qq01 = $mysqli->query("select * from `".$podcat_name[1]."_table`");
    while ($row = mysqli_fetch_row($qq01))
    {
        $sql_text[$c] = $row[1];
        $str1[$c] = str_replace(' ', '_', $sql_text[$c]);
        $str[$c] = str_replace('.', '', $str1[$c]);
        $sql[$c] = $row[2];

        if (isset($_POST[$str[$c].'_asc']))
        {
            $lim = $_POST['hidden_sort_4'];
            ?><script>
                $('input[name = "hidden_sort_1"]').val("<?php echo $row[2] ?>");
                $('input[name = "hidden_sort_2"]').val("ASC");
                $('input[name = "hidden_sort_3"]').val("<?php echo $c ?>");
                $('input[name = "hidden_sort_4"]').val("<?php echo $lim ?>");
                $('input[name = "lim_text"]').val("<?php echo $lim - 2 ?>");
            </script><?php
            $class_count = $c;
            $sort = 'ORDER BY `'.$row[2].'` ASC';
        }
        if (isset($_POST[$str[$c].'_desc']))
        {
            $lim = $_POST['hidden_sort_4'];
            ?><script>
                $('input[name = "hidden_sort_1"]').val("<?php echo $row[2] ?>");
                $('input[name = "hidden_sort_2"]').val("DESC");
                $('input[name = "hidden_sort_3"]').val("<?php echo $c ?>");
                $('input[name = "hidden_sort_4"]').val("<?php echo $lim ?>");
                $('input[name = "lim_text"]').val("<?php echo $lim - 2 ?>");
            </script><?php
            $sort = 'ORDER BY `'.$row[2].'` DESC';
            $class_count = $c;
        }

        $c++;
    }


    //$hid = '';
    //$sort = '';
    //$sql_text = '';
    //$c = 1;
    //$qq01 = $mysqli->query("select * from `".$podcat_name[1]."_table`");
    //while ($row = mysqli_fetch_row($qq01))
    //{
    //    $sql_text[$c] = $row[1];
    //    $str1[$c] = str_replace(' ', '_', $sql_text[$c]);
    //    $str[$c] = str_replace('.', '', $str1[$c]);
    //    $c++;
    //}



    if ((isset ($_POST['search_btn'])))
    {
        $qq01 = $mysqli->query("select sql_name from `".$podcat_name[1]."_table` where `name` = '".$_POST['selected_td']."' ");
        while ($row = mysqli_fetch_row($qq01))
        { $sql_td = $row[0]; }
        $qq = $mysqli->query("select * from `".$podcat_name[1]."` where `".$sql_td."` LIKE '%".$_POST['caption']."%' ");
        $count++;
        $max_count = mysqli_num_rows($qq) + 1;
    }


    while ($button_count <= $max_count)
    {
        if ((isset($_POST['edit_'.$button_count])) || (isset($_POST['edit_true_'.$button_count])))
        {
            $hid_1 = $_POST['hidden_sort_1'];
            $hid_2 = $_POST['hidden_sort_2'];
            $hid_3 = $_POST['hidden_sort_3'];
            $lim = $_POST['hidden_sort_4'];
            $class_count = $hid_3;
            $searched_td =  $_POST['hidden_sort_5'];
            $caption =  $_POST['hidden_sort_6'];

            ?><script>
                $('input[name = "hidden_sort_1"]').val("<?php echo $hid_1 ?>");
                $('input[name = "hidden_sort_2"]').val("<?php echo $hid_2 ?>");
                $('input[name = "hidden_sort_3"]').val("<?php echo $hid_3 ?>");
                $('input[name = "hidden_sort_4"]').val("<?php echo $lim ?>");
                $('input[name = "lim_text"]').val("<?php echo $lim - 2 ?>");
                $('input[name = "hidden_sort_5"]').val("<?php echo $searched_td ?>");
                $('input[name = "hidden_sort_6"]').val("<?php echo trim($caption) ?>");
                $('input[name = "caption"]').val("<?php echo trim($caption) ?>");
            </script><?php

            if (($hid_1 != '') || ($hid_2 != ''))
            { $sort = 'ORDER BY `'.$hid_1.'` '.$hid_2.' '; }
        }
        $button_count++;
    }





?>