<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/db.php');

    $DB->select("number","temp2");
    while ($row = mysqli_fetch_row($DB->sql_query_select))
    {
        $number .= str_replace("+7", "",
                str_replace("-","",
                    str_replace("(","",
                        str_replace(")","", $row[0])
                    )))."\n";
    }

    $file = fopen($_SERVER['DOCUMENT_ROOT']."/description.txt", "a");
    fwrite ($file, "$number");
?>
