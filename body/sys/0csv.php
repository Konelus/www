<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/class/connection.php");

    $substring = $_GET['project'];

    $DB->select("*","{$substring}","`id` = '1'");
    if ($DB->sql_query_select)
    {
        while ($array = mysqli_fetch_array($DB->sql_query_select))
        { $show = $array; }

        foreach ($show as $key => $value)
        {
            if (is_numeric($key)) { unset($show[$key]); }
            if ($key == 'id') { unset($show[$key]); }
        }
    }

    $td_td = 1;
    $count = 0;


    if (!isset ($_POST['sort']))
    { $DB->select("*","{$substring}"); }
    else
    {
        $show_flip = array_flip($show);
        $DB->select("*","{$substring}", "`{$show_flip[$_POST['table']]}` LIKE '%{$_POST['value']}%' OR `id` = '1' OR `id` = '1'");
    }

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

        if ($title[$tr][0] != '')
        {
            for ($td = 1; $td <= ($max_td + 3); $td++)
            {
                $csv_var = $csv_var.iconv("UTF-8", "windows-1251", $title[$tr][$td]).';';
                if (stripos("{$csv_var}","&quot;") !== false)
                { $csv_var = str_replace("&quot;",'"',"{$csv_var}"); }
            }
            $tr_count++;
            $bool_query = false;
            $bool_var_2 = false;
            $td_td = 1;
        }
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
    <div>
        <form method = "post">
            <div style = 'margin-top: 40px; text-align: center; font-weight: bold;'>Умная выгрузка <span style = 'color: red;'>(тест)</span></div>
            <div style = 'margin-top: 5px;'>
                <div style = 'width: 400px; margin: auto;'>
                    <div style = 'float: left; width: 45%'>
                        <select class = 'form-control' style = 'width: 100%; height: 28px;' name = 'table'>
                            <?php foreach ($show as $key => $value)
                            { if ($_POST['table'] == $value) { $selected = 'selected'; } else { $selected = ''; } ?>
                            <option <?= $selected ?>><?= $value ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div style = 'float: right; width: 45%'>
                        <input type = 'text' class = 'form-control' style = 'width: 100%; height: 22px;' name = 'value' autocomplete = 'off' required value = '<?= $_POST['value'] ?>'>
                    </div>
                </div>
            </div>
            <div style = 'width: 300px; margin: auto;'>
                <div style = 'width: 100%; margin-top: 40px;'><input type = 'submit' class = 'btn btn-default' style = 'width: 100%; height: 30px;' value = 'Сформировать' name = 'sort'></div>
            </div>
        </form>
        <?php if ((isset ($_POST['sort'])) && ($_POST['value'] != '')) { ?>
            <div style = 'text-align: center; color: red; font-weight: bold; margin-top: 5px;'>Успешно!</div>
        <?php } ?>
    </div>
    <div style = 'margin-top: 50px;'>
        <div style = 'text-align: center;'>Выгрузка успешно сформирована.</div>
        <div style = 'text-align: center;'>Нажмите на <a style = 'color: red;' href = '/temp3721/<?= $substring.".csv" ?>'>ссылку</a>, чтобы скачать</div>
    </div>
</body>