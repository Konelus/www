<?php
    $status = '';
    $descriptor_r = fopen($_SERVER['DOCUMENT_ROOT'].'/status.txt', 'r');
    if ($descriptor_r)
    {
        while (($string = fgets($descriptor_r)) !== false)
        { $status = $status.$string; }
        fclose($descriptor_r);

        if ($status == 'enable')
        { $value = 'Выключить'; }
        else if ($status == 'disable')
        { $value = 'Включить'; }
    }

    if (isset ($_POST['break']))
    {
        if ($status == 'enable')
        {
            $descriptor_w = fopen($_SERVER['DOCUMENT_ROOT'] . '/status.txt', 'w+');
            fwrite($descriptor_w, 'disable');
            fclose($descriptor_w);
        }
        else if ($status == 'disable')
        {
            $descriptor_w = fopen($_SERVER['DOCUMENT_ROOT'] . '/status.txt', 'w+');
            fwrite($descriptor_w, 'enable');
            fclose($descriptor_w);

            $SQL_QUERY_ver = $mysqli->query("select `ver` from `ver` ");
            while ($row = mysqli_fetch_row($SQL_QUERY_ver))
            { $ver = $row[0]; }
            $ver_update = explode('.', $ver);
            $DB->update("ver","ver","".$ver_update[0].'.'.$ver_update[1].'.'.($ver_update[2] + 1),"");
        }
        echo "<script>window.location.href = window.location.href;</script>";
    }

    // ↓ Список таблиц ↓
    $tables_count = 1;
    $MYSQL_QUERY_tables = $mysqli->query("SELECT `description` FROM `tables_namespace` WHERE `name` = '".$podcat_name[1]."' ");
    while ($row = mysqli_fetch_row($MYSQL_QUERY_tables))
    { $table_name = $row[0]; }
    // ↑ Список таблиц ↑

    if (isset ($_POST['search_btn']))
    {
        $SQL_QUERY_sql_name = $mysqli->query("select `sql_name` from `".$podcat_name[1]."_table` where `name` = '".$_POST['selected_td']."' ");
        if ($SQL_QUERY_sql_name != null)
        {
            while ($row = mysqli_fetch_row($SQL_QUERY_sql_name))
            { $searched_td = $row[0]; }
        }
        $row_count = 0;

        //$max_count = $max_count_searched;

    //}
        //echo "select * from `".$podcat_name[1]."` where `".$searched_td ."` =  '".$_POST['caption']."' ".$sort." ";
    }
    $qqzz = $mysqli->query("select * from `".$podcat_name[1]."` ");
    //echo "select * from `".$podcat_name[1]."` ";
    //echo "select * from `".$podcat_name[1]."` where `".$searched_td."` =  '".$_POST['caption']."' ";
    $max_count_title = mysqli_num_rows($qqzz);

    if (($_COOKIE['user'] == 'admin') || ($current_users_access[$podcat_name[1].'_status'] == 'superuser'))
    { $margin = 'margin-bottom: 110px;'; }
    else if (($_COOKIE['user'] != 'admin') && ($current_users_access[$podcat_name[1].'_status'] != 'superuser'))
    { $margin = 'margin-bottom: 70px;'; }


?>

<div class='container-fluid' style = '<?= $margin; ?>'>
    <div class='row main_div_margin'>
        <div class = 'col-lg-12 col-md-12 col-sm-12 affix' style = 'padding-left: 0; padding-right: 0; z-index: 1'>

        <?php
        if ($_COOKIE['user'] != 'admin') { $bag_1 = 1; } else { $bag_1 = 0; }
        if (($_COOKIE['user'] == 'admin') || ($current_users_access[$podcat_name[1].'_status'] == 'superuser'))
        {
            require_once ($_SERVER['DOCUMENT_ROOT'].'/body/pre_table/sys/user_head.php');
            require_once ($_SERVER['DOCUMENT_ROOT'].'/body/pre_table/sys/admin_head.php');
         }
         else if (($_COOKIE['user'] != 'admin') && ($current_users_access[$podcat_name[1].'_status'] != 'superuser'))
         { require_once ($_SERVER['DOCUMENT_ROOT'].'/body/pre_table/sys/user_head.php'); } ?>
        </div>
    </div>
</div>