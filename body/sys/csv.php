<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/class/connection.php");

    $substring = $_GET['project'];


$td_td = 1;
$count = 0;

$DB->select("*","{$substring}");
if ($DB->sql_query_select != null)
{
    while ($row = mysqli_fetch_row($DB->sql_query_select))
    {
        for ($i = 0; $i <= count($row); $i++) { $title[$count][$i] = $row[$i]; }
        $tr_new_count[$count] = $row[0];
        $count++;
    }
}


    $max_count = mysqli_num_rows($DB->sql_query_select);
    $max_td = mysqli_num_fields($DB->sql_query_select);



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
                $bool_query = false;
                $bool_var_2 = false;
                $td_td = 1;
            }
        //}
    }


    $file = $_SERVER['DOCUMENT_ROOT'].'/temp3721/'.$substring.".csv";
    unlink($file);
    $fd = fopen($file, 'w') or die($_SERVER['DOCUMENT_ROOT'].'/temp3721/'.$substring.".csv");
    fwrite($fd, $csv_var);
    fclose($fd);
?>

<!DOCTYPE html>

<head>
    <meta charset = "UTF-8">
    <title>Выгрузка CSV</title>
</head>
<body>
    <div style = 'text-align: center;'>Выгрузка успешно сформирована.</div><div style = 'text-align: center;'>Нажмите на <a style = 'color: red;' href = '/temp3721/<?= $substring.".csv" ?>'>ссылку</a>, чтобы скачать</div>
</body>