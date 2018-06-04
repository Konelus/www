<?php
/* - - - - - - - - - - ↓ Подключение к БД ↓ - - - - - - - - - - */
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/use.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/class.php");
    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');
/* - - - - - - - - - - ↑ Подключение к БД ↑ - - - - - - - - - - */

$lim = 27;
if (isset ($_POST['lim_btn'])) { $lim = $_POST['lim_text'] + 2; }


    $log_count = 0;

    $DB->select("*","log_info","","`id` DESC","{$lim}");
    $select = $DB->sql_query_select;
    if ($select != null)
    {
        while ($row = mysqli_fetch_array($select))
        {
            $log_info[$log_count][1] = trim($row[1]);

            $fio = explode(" ","{$log_info[$log_count][1]}");
            for ($count = 1; $count <= 2; $count++)
            {
                if (mb_substr($fio[$count],"0","1") != '')
                { $fio[$count] = mb_substr($fio[$count],"0","1").'.'; }
            }
            $log_info[$log_count][1] = "{$fio[0]} {$fio[1]}{$fio[2]}";
            $log_info[$log_count][2] = $row[2];
            $log_info[$log_count][3] = $row[3];
            $log_info[$log_count][4] = $row[4];
            $log_info[$log_count][5] = $row[5];

            $id = $row[6];
            $DB->select("id_obekta_skup","{$log_info[$log_count][5]}","`id` = '{$id}'");
            if ($DB->sql_query_select != null)
            {
                while ($row_100 = mysqli_fetch_array($DB->sql_query_select))
                { $log_info[$log_count][6] = $row_100[0]; }
            }
            else { $log_info[$log_count][6] = $row[6]; }

            $tr = $row[7];

            $DB->select("name","{$log_info[$log_count][5]}_table","`sql_name` = '{$tr}'");
            if ($DB->sql_query_select != null)
            { while ($row_100 = mysqli_fetch_array($DB->sql_query_select)) { $log_info[$log_count][7] = $row_100[0]; } }
            else { $log_info[$log_count][7] = $row[7]; }

            $log_info[$log_count][8] = $row[8];
            $log_info[$log_count][9] = $row[9];
            $log_count++;
        }

    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="/img/favicon.png" type="image/png">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
    </head>
    <body>
        <div class = 'container-fluid'>
            <div class = 'row' style = 'text-align: center; height: 40px;'>
                <!-- ↓ Форма установки лимита ↓ -->
                <form method="post">
                    <div class='col-lg-12' style = 'margin-bottom: 5px; margin-top: 2px;'>
                        <div style = 'width: 610px; margin: auto;'>
                            <div style = 'float: left; cursor: default; margin-right: 4px; font-size: 20px; margin-top: 5px;'>Количество выводимых записей</div>
                            <div style = 'float: left;'><input type='text' value = '<?= ($lim - 2) ?>' style = 'width: 200px; color: black; margin-top: 4px; border: solid 1px black; padding-left: 5px; padding-right: 5px;' class = 'form-control text_box_border' autocomplete='off' name='lim_text'></div>
                            <div style = 'float: left;'><input class = 'table_small_add_btn btn' type='submit' value='Применить' name='lim_btn' style = 'color: white; background: black; margin-left: 5px; margin-top: 4px; border: solid 1px grey;'></div>
                        </div>
                    </div>
                </form>
                <!-- ↑ Форма установки лимита ↑ -->
            </div>
        </div>


        <table class = 'table table-bordered table-striped'>
            <tr style = 'text-align: center; background: black; color: white; cursor: default; border: 0;'>
                <td>ФИО</td>
                <td>IP</td>
                <td>Дата</td>
                <td>Время</td>
                <td>Проект</td>
                <td>СКУП</td>
                <td>Столбец</td>
                <td>Исходный текст</td>
                <td>Новый текст</td>
            </tr>
            <?php
            for ($log_info_count_1 = 0; $log_info_count_1 < $log_count; $log_info_count_1++)
            {
                $logs_style = '';
                echo "<tr>";
                for ($log_info_count_2 = 1; $log_info_count_2 <= 9; $log_info_count_2++)
                {
                    echo "<td style = 'font-size: 12px; {$logs_style}' title = '{$log_info[$log_info_count_1][$log_info_count_2]}'>";
                    echo mb_strimwidth($log_info[$log_info_count_1][$log_info_count_2],"0","30");
                    if (mb_strlen($log_info[$log_info_count_1][$log_info_count_2]) > 30) { echo '...'; }
                    echo '</td>';
                    $logs_style = 'text-align: center;';
                }
                echo '</tr>';
            }
            ?>
        </table>
    </body>
</html>