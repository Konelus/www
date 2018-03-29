<!DOCTYPE html>

<?php
/* - - - - - - - - - - ↓ Подключение к БД ↓ - - - - - - - - - - */
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/use.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/class.php");
    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');
/* - - - - - - - - - - ↑ Подключение к БД ↑ - - - - - - - - - - */

$lim = 27;
if (isset ($_POST['lim_btn'])) { $lim = $_POST['lim_text'] + 2; }


    $log_count = 0;

    $DB->select("*","log_info","","DESC","id","{$lim}");
    $select = $DB->sql_query_select;
    if ($select != null)
    {
        while ($row = mysqli_fetch_array($select))
        {
            $log_info[$log_count][1] = $row[1];
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

<html lang="ru">
<head>
    <title>Логи</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
</head>
<body>
    <div class = 'container-fluid'>
        <div class = 'row' style = 'color: white; background: black; text-align: center; height: 40px;'>
            <div class = 'col-lg-4'></div>
            <div class = 'col-lg-4' style = 'font-size: 25px;'>История действий пользователей</div>
            <div class = 'col-lg-3'></div>
            <!-- ↓ Форма установки лимита ↓ -->
            <form method="post">
                <div class='col-lg-1' style = 'margin-top: 5px;'>
                    <input type='text' value = '<?= ($lim - 2) ?>' style = 'width: 70%; float: left; color: black; margin-top: 4px; border: black;' autocomplete='off' name='lim_text'>
                    <input class = 'table_small_add_btn' type='submit' value='!' name='lim_btn' style = 'color: white; background: black; border: grey; margin-left: 5px; width: 20%; float: left; margin-top: 4px; border: solid 1px grey;'>
                </div>
            </form>
            <!-- ↑ Форма установки лимита ↑ -->
        </div>
    </div>

    <div class = 'container-fluid'>
        <div class = 'row'>
            <div class = 'col-lg-12'>
                <table class = 'table table-condensed table-striped' border = 1>
                    <tr style = 'text-align: center; background: black; color: white; cursor: default;'>
                        <td>ФИО</td>
                        <td>IP</td>
                        <td>Дата</td>
                        <td>Время</td>
                        <td>Таблица</td>
                        <td>СКУП</td>
                        <td>Столбец</td>
                        <td>Исходный текст</td>
                        <td>Новый текст</td>
                    </tr>
                    <?php
                        for ($log_info_count_1 = 0; $log_info_count_1 < $log_count; $log_info_count_1++)
                        {
                            echo '<tr>';
                            for ($log_info_count_2 = 1; $log_info_count_2 <= 9; $log_info_count_2++)
                            { echo '<td>'.$log_info[$log_info_count_1][$log_info_count_2].'</td>'; }
                            echo '</tr>';
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>