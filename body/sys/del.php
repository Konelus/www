<?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');


    if ($_GET != null) { $substring = $_SERVER['QUERY_STRING']; }
    //$podcat_name_2 = explode('/', $cat_name);
    $substring_xxx = explode('/', $substring);
    $table = $substring_xxx[0];
    $id = $substring_xxx[1];


    if (isset ($_POST['del']))
    {
        $DB->delete("{$table}", "`id` = '{$id}'");
        $DB->delete("{$table}", "`id_tr` = '{$id}'");
        header("Location: /?{$table}");
    }
    else if (isset ($_POST['cancel']))
    { header("Location: /?{$table}"); }


    $DB->select("*","{$table}","`id` = '{$id}'");
    $array = mysqli_fetch_array($DB->sql_query_select);

    $count = 0;
    ?>
<!DOCTYPE html>

<html lang="ru">
    <head>
        <title>Удаление</title>
        <meta charset="utf-8">
    </head>
    <body>
        <br><br><br><br><br>
        <table style = 'border: solid 1px black; margin: auto;'>
            <?php
            foreach ($array as $key => $value)
            {
                if (!is_numeric($key))
                {
                    $DB->select("name","{$table}_table","`sql_name` = '{$key}'");
                    while ($row = mysqli_fetch_row($DB->sql_query_select))
                    {

                        $title[$count] = $row[0];
                        echo "<tr><td style = 'border-right: solid 1px black; border-bottom: solid 1px black;'>$title[$count]</td><td style = 'border-bottom: solid 1px black;'>$array[$count]</td></tr>";
                    }
                    $count++;

                }
            }
            ?>
            <tr>
                <form method="post">
                    <td colspan = '2'>
                        <div style = 'width: 215px; margin: auto;'>
                            <div style = 'width: 100px; height: 25px; float: left; margin-right: 10px;'>
                                <input type = 'submit' name = 'cancel' value = 'Отмена' style = 'width: 100%; height: 100%; border: solid 1px black; background: #4cae4c;'>
                            </div>
                            <div style = 'width: 100px; height: 25px; float: left;'>
                                <input type = 'submit' name = 'del' value = 'Удалить'style = 'width: 100%; height: 100%; border: solid 1px black; background: #ac2925; color: white;'>
                            </div>
                        </div>
                    </td>
                </form>
            </tr>
        </table>
    </body>
</html>
