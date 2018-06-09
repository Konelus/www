<?php

    $text = "Ожидает запуска!";
    if (isset ($_POST['find']))
    {
        $count = 0;
        $DB->update("ege","podtverzhdenie_ustanovki","","`podtverzhdenie_ustanovki` != 'Подтверждение установки' AND `podtverzhdenie_ustanovki` != 'Столбец 27'");
        $DB->select("*","ege_temp");
        while ($row = mysqli_fetch_row($DB->sql_query_select))
        {
            $rid = $row[1];
            $date = explode(" ",$row[3]);
            $date = $date[0];
            $DB->update("ege","podtverzhdenie_ustanovki","{$date}","`rid_pak` = '{$rid}'");
        }
        $text = "<div style = 'width: 50px; float: right; color: green; margin-right: 20px;'>Успешно!</div>";
    }
?>

<div style = ''>
    <form method = 'post'>
        <input style = 'border: 0; background: white; color: navy; cursor: pointer;' type = 'submit' name = 'find' value = 'Заполнить ЕГЭ'>
    </form>
</div>