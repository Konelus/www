<?php
    $title = '';
    $count = 0;

    if (((!isset ($_POST['search_btn'])) && ($_POST['hidden_sort_5'] == '') && ($_POST['hidden_sort_6'] == '')))
    {
        $searched_tr = 0;
        $SQL_QUERY_select_data = $mysqli->query("select * from `".$podcat_name[1]."`".$sort." ");
        if ($SQL_QUERY_select_data != null)
        { $max_count = mysqli_num_rows($SQL_QUERY_select_data); }
    }

    else if (((isset ($_POST['search_btn']))) || (($_POST['hidden_sort_5'] != '') && ($_POST['hidden_sort_6'] != '')))
    {
        $SQL_QUERY_sql_name = $mysqli->query("select `sql_name` from `".$podcat_name[1]."_table` where `name` = '".$_POST['selected_td']."' ");
        if ($SQL_QUERY_sql_name != null)
        {
            while ($row = mysqli_fetch_row($SQL_QUERY_sql_name))
            { $searched_td = $row[0]; }
        }
        //$searched_td = ;
        $caption = $_POST['caption'];
        if (isset ($_POST['search_btn']))
        {
            $searched_tr = 1;
            //$inversion  = ;
            if ( isset ($_POST['inversion']))
            {?>
                <script>
                    $('#cb').prop('checked', true);
                </script>
            <?php }
        ?>
        <script>
            $('input[name = "hidden_sort_5"]').val("<?= $searched_td ?>");
            $('input[name = "hidden_sort_6"]').val("<?= trim($caption) ?>");
            $('input[name = "caption"]').val("<?= trim($caption) ?>");
        </script><?php } else if (!isset ($_POST['search_btn']))
        {
            $searched_tr = 1;
            $searched_td = $_POST['hidden_sort_5'];
            $caption = $_POST['hidden_sort_6'];
        }
        //$SQL_QUERY_select_data = $mysqli->query("select * from `".$podcat_name[1]."` where `".$_POST['hidden_sort_5'] ."` LIKE  '%".$_POST['hidden_sort_6']."%' ".$sort." LIMIT  ".$lim." ");
//        $max_count = mysqli_num_rows($SQL_QUERY_select_data);
        if (isset ($_POST['inversion']))
        { $SQL_QUERY_select_data = $mysqli->query("select * from `".$podcat_name[1]."` where `".$searched_td ."` !=  '".trim($caption)."' ".$sort." "); }
        else if (!isset ($_POST['inversion']))
        { $SQL_QUERY_select_data = $mysqli->query("select * from `".$podcat_name[1]."` where `".$searched_td ."` LIKE  '%".trim($caption)."%' ".$sort." "); }
        if ($SQL_QUERY_select_data != null)
        { $max_count = mysqli_num_rows($SQL_QUERY_select_data); }
        //echo "select * from `".$podcat_name[1]."` where `".$searched_td ."` LIKE  '%".$caption."%' ".$sort." LIMIT  ".$lim." ";
        //echo "select * from `".$podcat_name[1]."` where `".$searched_td ."` =  '".$caption."' ".$sort." LIMIT  ".$lim." ";
        //echo '123';
    }


    if ($SQL_QUERY_select_data != null)
    {
        while ($row = mysqli_fetch_row($SQL_QUERY_select_data))
        {
            if (($podcat_name[1] == 'vibory') && (is_numeric($row[1])))
            {
                for ($i = 0; $i <= count($row); $i++)
                { $title[$count][$i] = str_replace('^M', '', $row[$i]); }
            }
            else if ($podcat_name[1] != 'vibory')
            {
                for ($i = 0; $i <= count($row); $i++)
                { $title[$count][$i] = str_replace('^M', '', $row[$i]); }
            }
            $tr_new_count[$count] = $row[0];
            $count++;
        }
    }
    //print_r($title);

?>