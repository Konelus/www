<?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');


    if ($_GET != null) { $substring = $_SERVER['QUERY_STRING']; }
    //$podcat_name_2 = explode('/', $cat_name);
    $substring_xxx = explode('/', $substring);
    $table = $substring_xxx[0];
    $id = $substring_xxx[1];


    $DB->select("description","tables_namespace","`name` = '{$table}'");
    $table_name = implode(mysqli_fetch_row($DB->sql_query_select));


    $DB->select("*","{$table}","`id` = '{$id}'");
    $array = mysqli_fetch_array($DB->sql_query_select);
    if ($array != null)
    {
        foreach ($array as $key => $value)
        { if (!is_numeric($key)) { unset($array[$key]); } }
    }


    $count = 1;
    $DB->select("sort","{$table}_table");
    while ($title_arr = mysqli_fetch_row($DB->sql_query_select))
    {
        $title_sort[$count] = $title_arr[0];
        $count++;
    }
    asort($title_sort);

    foreach ($title_sort as $key => $value)
    {
        $DB->select("*","{$table}_table", "`sort` = '{$value}'");
        while ($title_arr = mysqli_fetch_row($DB->sql_query_select))
        {
            $title_array[$value] = $title_arr[1];
            $title_sql[$value] = $title_arr[2];
        }
    }



    $DB->select("table_group","users", "`login` = '{$_COOKIE['user']}'");
    $current_users_group = implode(mysqli_fetch_row($DB->sql_query_select));

    if ($_COOKIE['user'] != 'admin')
    {
        $DB->select("{$table}_status","group_namespace","`name` = '{$current_users_group}'");
        $users_status = implode(mysqli_fetch_row($DB->sql_query_select));

        $DB->select("*","{$table}_permission","`{$table}_group` = '{$current_users_group}'");
        if ($DB->sql_query_select != null)
        { $vision = mysqli_fetch_row($DB->sql_query_select); }

        $DB->select("*","{$table}_permission","`{$table}_group` = '{$current_users_group}_edit'");
        if ($DB->sql_query_select != null)
        { $permission = mysqli_fetch_row($DB->sql_query_select); }

        unset($permission[0]);
        foreach ($permission as $key => $value)
        {
            $permission[$key] = $permission[$key + 1];
            if ($permission[$key] == '') { unset($permission[$key]); }
        }



        foreach ($vision as $key => $value)
        {
            if ($key >= 1)
            {
                if ($value != '+')
                {
                    unset($array[$key - 1], $title_array[$key - 1], $title_sql[$key - 1], $permission[$key - 1]);
                }
            }
        }

    }







if (isset ($_POST['edit']))
{
    $DB->select("fio", "users", "`login` = '{$_COOKIE['user']}'");
    $user_fio = implode(mysqli_fetch_row($DB->sql_query_select));

    foreach ($array as $key => $value)
    {
        if ($array[$key] != $_POST["edit_{$key}"])
        {
            if ($_COOKIE['user'] != 'admin')
            {
                $DB->insert("log_info","null, '{$user_fio}', '{$_SERVER['REMOTE_ADDR']}', '" . date("d.m.Y") . "', '" . date("H:i:s") . "', '{$table_name}', '{$array[1]}', '{$title_array[$key]}', '{$array[$key]}', '{$_POST["edit_{$key}"]}', 'new'");
            }
            $DB->update("{$table}","{$title_sql[$key]}","{$_POST["edit_{$key}"]}","`id` = '{$id}'");
            $array[$key] = $_POST["edit_{$key}"];
        }
    }
}

if (isset ($_POST['del']))
{
    $DB->delete("{$table}", "`id` = '{$id}'");
    $DB->delete("{$table}", "`id_tr` = '{$id}'");
    echo "<script>window.close()</script>";
}

    ?>
<!DOCTYPE html>

<html lang="ru">
    <head>
        <title>Редактирование</title>
        <meta charset="utf-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="/dist/css/bootstrap.min.css">

    </head>
    <body>
    <?php if ($array != null) { ?>
        <br>
        <table class = 'table' style = 'margin: auto; width: 800px;'>
            <form method="post">
            <?php
            foreach ($title_array as $key => $value)
            {
                if (($permission[$key] == '+') || ($_COOKIE['user'] == 'admin'))
                { $ro = ''; $style = ''; }
                else
                {
                    $ro = 'readonly';
                    $style = 'background: lightgrey; cursor: default;';
                }

                echo "<tr style = 'border: solid 1px lightgrey;'>";
                echo "<td style = 'background: #FFDB26;'>$title_array[$key]</td>";
                echo "<td style = 'width: 600px;'><input {$ro} type = 'text' name = 'edit_{$key}' value = '{$array[$key]}' style = '{$style} width: 100%; padding-right: 5px; padding-left: 5px; border: dashed 1px navy;' autocomplete = 'off'></td>";
                echo "</tr>";
            }

            ?>
            <tr>
                <td colspan = '2'>
                    <?php if ($users_status == 'superuser') { ?>
                    <div style = 'width: 305px; height: 30px; margin: auto;'>
                        <div style = 'width: 150px; margin-right: 5px; float: left;'>
                            <input type = 'submit' name = 'edit' value = 'Редактировать' style = 'width: 150px; height: 30px; border: solid 1px black; background: gold;'>
                        </div>
                        <div style = 'width: 150px; float: left;'>
                            <input type = 'submit' name = 'del' value = 'Удалить' style = 'width: 150px; height: 30px; border: solid 1px black; background: red; color: white;'>
                        </div>
                    </div>
                    <?php } else { ?>
                        <div style = 'width: 150px; margin: auto;'>
                            <input type = 'submit' name = 'edit' value = 'Редактировать' style = 'width: 150px; height: 30px; border: solid 1px black; background: gold;'>
                        </div>
                    <?php } ?>
                </td>
            </tr>
            </form>
        </table>
    <?php } ?>
    </body>
</html>
