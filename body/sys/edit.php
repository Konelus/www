<?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/class/user.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');


    if ($_GET != null) { $substring = $_SERVER['QUERY_STRING']; }
    $substring = explode('/', $substring);
    $table  = $substring[0];
    $id     = $substring[1];


    $DB->select("description","!sys_tables_namespace","`name` = '{$table}'");
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


//    if ($_COOKIE['user'] != 'admin')
//    {
//        $USER->user_group();
//        $users_status = $USER->user_access_status;
//        $USER->user_permission($table);
//        $vision = $USER->user_cell_vision;
//        $permission = $USER->user_cell_edit;
//    }







if (isset ($_POST['edit']))
{
    $DB->select("fio", "!sys_users", "`login` = '{$_COOKIE['user']}'");
    $user_fio = implode(mysqli_fetch_row($DB->sql_query_select));

    foreach ($array as $key => $value)
    {
        unset($array[0]);
        $post_value[$key] = htmlspecialchars($_POST["edit_{$key}"]);
        $post_value[$key] = trim($post_value[$key]);
        $post_value[$key] = str_replace("'", "", "{$post_value[$key]}");
        $post_value[$key] = str_replace('&quot;', "", "{$post_value[$key]}");
        if ($array[$key] != $_POST["edit_{$key}"])
        {
            if ($_COOKIE['user'] != 'admin')
            {
                $DB->insert("!sys_log_info","null, '{$user_fio}', '{$_SERVER['REMOTE_ADDR']}', '" . date("d.m.Y") . "', '" . date("H:i:s") . "', '{$table_name}', '{$array[1]}', '{$title_array[$key]}', '{$array[$key]}', '{$post_value[$key]}', 'new'");
            }
            $DB->update("{$table}","{$title_sql[$key]}","{$post_value[$key]}","`id` = '{$id}'");
        }
    }
    echo "<script>window.close()</script>";
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
                if (($permission[$title_sql[$key]] == '+') || ($_COOKIE['user'] == 'admin'))
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
                    <?php if (($users_status == 'superuser') || ($_COOKIE['user'] == 'admin')) { ?>
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
