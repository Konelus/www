<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/use.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/class/user.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');

    $substring = $_SERVER['QUERY_STRING'];
    $substring = explode("/","$substring");
    $table = $substring[0];
    $id = $substring[1];
    $string = '';

    if ($_COOKIE['user'] != 'admin')
    {
        $USER->user_permission("{$table}","load_file");
        if ($USER->user_cell_edit != '+') { $status = 'disabled'; $del_style = 'cursor: default; background: #99A0A0; color: black;'; }
        else { $status = ''; $del_style = 'background: #ac2925; color: white;'; }
    }
    else { $status = ''; $del_style = 'background: #ac2925; color: white;'; }




    $DB->select("load_file","{$table}","`id` = '{$id}'");
    while ($row = mysqli_fetch_row($DB->sql_query_select))
    { $filename = $row[0]; }
    $filename = explode("\n","$filename");


    foreach ($_POST as $key => $value)
    {
        if (strripos("{$key}",'file_del') !== false)
        {
            $file_del = explode("_","{$key}");
            $file_del = $file_del[2];

            foreach ($filename as $new_key => $new_value)
            {
                if ($file_del == $new_key)
                { $file_del = $new_value; }
                elseif ($new_value != '')
                {
                    if ($string != '') { $string .= "\n{$new_value}"; }
                    else { $string .= $new_value;  }
                }
            }
            if ($string == "\n") { $string == ''; }

            unlink("{$_SERVER['DOCUMENT_ROOT']}/damp/{$table}/{$id}/{$file_del}");

            $DB->update("{$table}","load_file","{$string}","`id` = '{$id}'");

            $DB->select("load_file","{$table}","`id` = '{$id}'");
            while ($row = mysqli_fetch_row($DB->sql_query_select))
            { $filename = $row[0]; }
            $filename = explode("\n","$filename");
            break;
        }
    }




    $DB->select("*","{$table}","`id` = '$id'");
    while ($array = mysqli_fetch_array($DB->sql_query_select))
    { $title = $array; }



?>

<!DOCTYPE html>

    <html lang="ru">
    <head>
        <title>Работа с файлами</title>
        <link rel="shortcut icon" href="/img/favicon.png" type="image/png">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
    </head>

    <body>
    <br><br><br><br>
    <table style = 'margin: auto;'>
    <?php

    foreach ($title as $key => $value)
    {
        if (!is_numeric($key))
        { unset($title[$key]); }
        else if ($key != '0')
        {
            $DB->select("name","{$table}_table","`sort` = '{$key}'");
            while ($row = mysqli_fetch_row($DB->sql_query_select))
            {
                $title_name[$key] = $row[0];
            }
            echo "<tr><td style = 'border: solid 1px black; padding-left: 5px; padding-right: 5px;'>{$title_name[$key]}</td><td style = 'border: solid 1px black; padding-left: 5px; padding-right: 5px;'>$value</td></tr>";
        }
    }
    ?>
    </table>
    <form method="post">
        <div style = 'margin: auto; width: 400px; margin-top: 20px;'>
            <div style = 'width: 400px; text-align: center; padding-top: 5px; padding-bottom: 5px; border: solid 1px black;'>Вложенные файлы</div>
            <?php


                foreach ($filename as $key => $value)
                {
                    if ($value != '') { ?>
                    <div style = 'width: 250px; float: left; border-bottom: solid 1px black; border-left: solid 1px black;'>
                        <div style = 'width: 100%; height: 5px; background: #9acfea; border-bottom: solid 1px black;'></div>
                        <div style = 'float: left; width: 4px; background: #9acfea; border-right: solid 1px black;'>&nbsp;</div>
                        <div style = 'overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'><?= $value ?></div>
                    </div>
                    <div style = 'width: 75px; float: left; border-bottom: solid 1px black; height: 22px;'>
                        <div style = 'width: 100%; height: 5px; background: #9acfea; border-bottom: solid 1px black;'></div>
                        <a href = "<?= "/damp/{$table}/{$id}/{$value}" ?>">
                            <div style = 'width: 100%; height: 100%; border: 0; border-left: solid 1px black; background: #67b168; text-align: center; color: black;'>Скачать</div>
                        </a>

                    </div>
                    <div style = 'width: 75px; float: left; border-bottom: solid 1px black; height: 22px;'>
                        <div style = 'width: 100%; height: 5px; background: #9acfea; border-bottom: solid 1px black; border-right: solid 1px black;'></div>
                        <input type = 'submit' name = "file_del_<?= $key ?>" <?= $status ?> value = 'Удалить' style = 'width: 100%; height: 100%; border: 0; border-left: solid 1px black; border-right: solid 1px black; <?= $del_style ?>'>
                    </div>
                <?php } else { ?>
                    <div style = 'width: 400px; float: left; border: solid 1px black; border-top: 0;'>
                        <div style = 'width: 100%; height: 5px; background: #9acfea; border-bottom: solid 1px black;'></div>
                        <div style = 'width: 100%; text-align: center; background: #dca7a7;'>
                            Файлы отсутствуют!
                        </div>
                        <div style = 'width: 100%; height: 5px; background: #9acfea;'></div>
                    </div>
                <?php }
                } ?>
        </div>
    </form>
    </body>
</html>
