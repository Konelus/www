<?php

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
    }

?>

<div style = 'width: 45%; float: left; margin-left: 5%;'>
    <form method = 'post'>
        <input style = 'margin: auto; width: 100%; height: 40px; background: gold; border-radius: 5px; border: solid 1px black;' type = 'submit' name = 'find' value = 'Заполнить ЕГЭ'>
    </form>
</div>