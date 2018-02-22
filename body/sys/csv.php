<?php

    /* - - - - - - - - - - ↓ Подключение к БД ↓ - - - - - - - - - - */
    $link = '';
    $descriptor = fopen($_SERVER['DOCUMENT_ROOT'].'/link.txt', 'r');
    if ($descriptor)
    { while (($string = fgets($descriptor)) !== false) { $link = $link.$string; } fclose($descriptor); }

    $localhost = "localhost";
    $user = "root";
    $password = $link;
    $db = "rtk_01";
    $mysqli = new mysqli($localhost, $user, $password, $db);
    mysqli_set_charset($mysqli, 'utf8');
    /* - - - - - - - - - - ↑ Подключение к БД ↑ - - - - - - - - - - */


    $cat_name = end(explode("=", ('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])));
    $podcat_name = explode('?', $cat_name);



    $SQL_select_td_name = $mysqli->query("SELECT * FROM `".$podcat_name[1]."_table`");
    while ($row = mysqli_fetch_row($SQL_select_td_name))
    {
        $SQL_QUERY_str_replace = $mysqli->query("UPDATE `vibory` SET `".$row[2]."` = REPLACE(`".$row[2]."`, '\\n', ' ')");
        $SQL_QUERY_str_replace = $mysqli->query("UPDATE `vibory` SET `".$row[2]."` = REPLACE(`".$row[2]."`, '\\r', ' ')");
        $SQL_QUERY_str_replace = $mysqli->query("UPDATE `vibory` SET `".$row[2]."` = REPLACE(`".$row[2]."`, '\;', '')");
        //echo "UPDATE `vibory` SET `".$row[2]."` = REPLACE(`".$row[2]."`, ';', ' ')";
    }


$td_td = 1;
$count = 0;
$SQL_QUERY_select_data = $mysqli->query("select * from `".$podcat_name[1]."` ");
if ($SQL_QUERY_select_data != null)
{
    while ($row = mysqli_fetch_row($SQL_QUERY_select_data))
    {
        for ($i = 0; $i <= count($row); $i++) { $title[$count][$i] = $row[$i]; }
        $tr_new_count[$count] = $row[0];
        $count++;
    }
}


    $max_count = mysqli_num_rows($SQL_QUERY_select_data);
    $max_td = mysqli_num_fields($SQL_QUERY_select_data);

//        $table_query_1 = $mysqli->query("select `name` from `".$podcat_name[1]."_table`");
//        if ($table_query_1 != null)
//        {
//            $max_td_count = mysqli_num_rows($table_query_1);
//
//            while ($row = mysqli_fetch_row($table_query_1))
//            {
//                if (($title1[$table_count1] == '+') && ($_COOKIE['user'] != 'admin'))
//                {
//                    $new_td[$table_count + 1] = ($table_count1 - 1);
//                    $table[$table_count + 1] = $row[0];
//                    $table_count++;
//                    $max_td_count_1 = $table_count;
//                }
//                else if ($_COOKIE['user'] == 'admin')
//                {
//                    $new_td[$table_count + 1] = ($table_count1 - 1);
//                    $table[$table_count] = $row[0];
//                    $table_count++;
//                }
//                $table_count1++;
//            }
//        }


    for ($tr = 0; $tr <= $max_count; $tr++)
    {
        if ($csv_var != '')
        { $csv_var = $csv_var.iconv("UTF-8", "windows-1251", "\n"); }

//        if ($_COOKIE['user'] != 'admin')
//        {
//            $SQL_QUERY_tr_vision = $mysqli->query("select `id_tr` from `" . $podcat_name[1] . "_vision` where `".$_COOKIE['user']."` = '+' ");
//            { if ($SQL_QUERY_tr_vision != null) { while ($row = mysqli_fetch_array($SQL_QUERY_tr_vision))  { $tr_vision[$row[0]] = $row[0]; } } }
//        }

        //if ((($tr_vision[$title[$tr][0]]) == ($title[$tr][0])) || ($_COOKIE['user'] == 'admin'))
        //{
            if ($title[$tr][0] != '')
            {
                for ($td = 1; $td <= ($max_td + 3); $td++)
                { $csv_var = $csv_var.iconv("UTF-8", "windows-1251", $title[$tr][$td]).';'; }
                $tr_count++;
                $bool_query = 0;
                $bool_var_2 = 0;
                $td_td = 1;
            }
        //}
    }


    $file = $_SERVER['DOCUMENT_ROOT'].'/temp3721/'.$podcat_name[1].".csv";
    unlink($file);
    $fd = fopen($file, 'w') or die($_SERVER['DOCUMENT_ROOT'].'/temp3721/'.$podcat_name[1].".csv");
    fwrite($fd, $csv_var);
    fclose($fd);
?>

<!DOCTYPE html>

<head>
    <meta charset = "UTF-8">
    <title>Выгрузка CSV</title>
</head>
<body>
    <div style = 'text-align: center;'>Выгрузка успешно сформирована.</div><div style = 'text-align: center;'>Нажмите на <a style = 'color: red;' href = '/temp3721/<?= $podcat_name[1].".csv" ?>'>ссылку</a>, чтобы скачать</div>
</body>