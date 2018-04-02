<?php


if (isset ($_POST['replace_column']))
{
    $DB->select("sql_name","{$substring}_table","`name` = '{$_POST['current']}'");
    while ($row = mysqli_fetch_row($DB->sql_query_select)) { $current = $row[0]; }
    if ($_POST['other'] != 'id')
    {
        $DB->select("sql_name", "{$substring}_table", "`name` = '{$_POST['other']}'");
        while ($row = mysqli_fetch_row($DB->sql_query_select)) { $other = $row[0]; }
    }
    else { $other = 'id'; }

    $DB->alter_replace("{$substring}","{$current}", "{$other}");
    if ($other == 'id') { $other = "{$substring}_group"; }
    $DB->alter_replace("{$substring}_permission","{$current}", "{$other}");




    $DB->select("sort","{$substring}_table","sql_name = '$current'");
    while ($row = mysqli_fetch_row($DB->sql_query_select)) { $current_id = $row[0]; }

    $DB->select("sort","{$substring}_table","sql_name = '$other'");
    while ($row = mysqli_fetch_row($DB->sql_query_select)) { $other_id = $row[0]; }

    if (($other == 'sort') || ($other == "{$substring}_group")) { $other_id = 0; }
    //echo "$current_id --> $other_id";

    if ($current_id < $other_id)
    {
        //echo "{($current_id + 1)} <= {$other_id}<br>";
        $DB->update("{$substring}_table","sort","temp{$current_id}", "`sort` = '{$current_id}'");
        for ($count = $current_id + 1; $count <= $other_id; $count++)
        {
            $DB->update("{$substring}_table","sort","".($count - 1), "`sort` = '$count'");
        }
        $DB->update("{$substring}_table","sort","".($other_id),"`sort` = 'temp{$current_id}'");
    }
    else if ($current_id > $other_id)
    {
        //echo $current_id.'<br>';
        $DB->update("{$substring}_table","sort","temp{$current_id}", "`sort` = '{$current_id}'");
        for ($count = $current_id - 1; $count > $other_id; $count--)
        {
            $DB->update("{$substring}_table","sort","".($count + 1), "`sort` = '$count'");
        }
        $DB->update("{$substring}_table","sort","".($other_id + 1),"`sort` = 'temp{$current_id}'");
    }

    unset($table, $title1);
    // ↓ Получение информации о правах пользователя ↓
    if ($_COOKIE['user'] != 'admin')
    {
        //$count = 0;
        $DB->select("*","{$substring}_permission","`{$substring}_group` = '{$current_users_group}'");
        if ($DB->sql_query_select != null)
        { $title1 = mysqli_fetch_row($DB->sql_query_select); }
    }
    // ↑ Получение информации о правах пользователя ↑

    $table_count1 = 2;
    $DB->select("*","{$substring}_table");
    if ($DB->sql_query_select != null)
    {
        //$max_td_count = mysqli_num_rows($DB->sql_query_select);

        //echo "<span style = 'color: red;'>{$max_td_count}</span><br>";
        while ($row = mysqli_fetch_row($DB->sql_query_select))
        {
            if (($title1[$table_count1] == '+') && ($_COOKIE['user'] != 'admin'))
            {
                //$new_td[$table_count + 1] = ($table_count1 - 1);
                $table[$row[3]] = $row[1];
                //$table_count++;
                //$max_td_count_1 = $table_count;
            }
            else if ($_COOKIE['user'] == 'admin')
            {
                //$new_td[$table_count + 1] = ($table_count1 - 1);
                $table[$row[3]] = $row[1];
                //$table_count++;
            }
            $table_count1++;
        }
    }
    ksort($table);


}





//    $status = '';
//    $descriptor_r = fopen($_SERVER['DOCUMENT_ROOT'].'/status.txt', 'r');
//
//
//
//    if ($descriptor_r)
//    {
//        while (($string = fgets($descriptor_r)) !== false)
//        { $status = $status.$string; }
//        fclose($descriptor_r);
//
//        if ($status == 'enable')
//        { $value = 'Выключить'; }
//        else if ($status == 'disable')
//        { $value = 'Включить'; }
//    }
//
//    if (isset ($_POST['break']))
//    {
//        if ($status == 'enable')
//        {
//            $descriptor_w = fopen($_SERVER['DOCUMENT_ROOT'] . '/status.txt', 'w+');
//            fwrite($descriptor_w, 'disable');
//            fclose($descriptor_w);
//        }
//        else if ($status == 'disable')
//        {
//            $descriptor_w = fopen($_SERVER['DOCUMENT_ROOT'].'/status.txt', 'w+');
//            fwrite($descriptor_w, 'enable');
//            fclose($descriptor_w);
//
//            ver();
//            $DB->update("ver","ver","".$current_ver[0].'.'.$current_ver[1].'.'.($current_ver[2] + 1));
//        }
//        echo "<script>window.location.href = window.location.href;</script>";
//    }

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