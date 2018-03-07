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
            $descriptor_w = fopen($_SERVER['DOCUMENT_ROOT'].'/status.txt', 'w+');
            fwrite($descriptor_w, 'enable');
            fclose($descriptor_w);

            ver();
            $DB->update("ver","ver","".$current_ver[0].'.'.$current_ver[1].'.'.($current_ver[2] + 1));
        }
        echo "<script>window.location.href = window.location.href;</script>";
    }

    // ↓ Список таблиц ↓
    //$DB->select("description","tables_namespace","`name` = '{$substring}'");
    //while ($row = mysqli_fetch_row($DB->sql_query_select))
    //{ $table_name = $row[0]; }
    // ↑ Список таблиц ↑

    if (isset ($_POST['search_btn']))
    { sql_name("{$substring}","{$_POST['selected_td']}"); $searched_td = $result; }

    $DB->select("*","{$substring}");
    $max_count = mysqli_num_rows($DB->sql_query_select);

    if (($_COOKIE['user'] == 'admin') || ($current_users_access["{$substring}_status"] == 'superuser'))
    { $margin = 'margin-bottom: 110px;'; }
    else if (($_COOKIE['user'] != 'admin') && ($current_users_access["{$substring}_status"] != 'superuser'))
    { $margin = 'margin-bottom: 70px;'; }


?>

<div class='container-fluid' style = '<?= $margin; ?>'>
    <div class='row main_div_margin'>
        <div class = 'col-lg-12 col-md-12 col-sm-12 affix' style = 'padding-left: 0; padding-right: 0; z-index: 1'>

        <?php
        if ($_COOKIE['user'] != 'admin') { $bag_1 = 1; } else { $bag_1 = 0; }
        if (($_COOKIE['user'] == 'admin') || ($current_users_access[$substring.'_status'] == 'superuser'))
        {
            require_once ($_SERVER['DOCUMENT_ROOT'].'/body/pre_table/sys/user_head.php');
            require_once ($_SERVER['DOCUMENT_ROOT'].'/body/pre_table/sys/admin_head.php');
         }
         else if (($_COOKIE['user'] != 'admin') && ($current_users_access[$substring.'_status'] != 'superuser'))
         { require_once ($_SERVER['DOCUMENT_ROOT'].'/body/pre_table/sys/user_head.php'); } ?>
        </div>
    </div>
</div>