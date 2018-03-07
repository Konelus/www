<?php

    $mysqli = new mysqli("localhost", "root", "".$link, "rtk_01");
    mysqli_set_charset($mysqli, 'utf8');

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

    $count = -1;
    $SQL_QUERY_select_old = $mysqli->query("SELECT `id_obekta_skup` FROM `vibory`");
    while ($row1 = mysqli_fetch_row($SQL_QUERY_select_old))
    { $old_vib[$count] = $row1; $count++; }
    $count = 1;
    $SQL_QUERY_select_new = $mysqli->query("SELECT `id_obekta_skup` FROM `vibory_temp`");
    while ($row2 = mysqli_fetch_row($SQL_QUERY_select_new))
    { $new_vib[$count] = $row2; $count++; }

    $old_count = 1;
    $new_count = 1;

    while ($old_count <= mysqli_num_rows($SQL_QUERY_select_old))
    {
        while ($new_count <= mysqli_num_rows($SQL_QUERY_select_new))
        {
            if ($old_vib[$old_count][0] == $new_vib[$new_count][0])
            { echo $new_vib[$new_count][0].' ||<br>'; $SQL_QUERY_update = $mysqli->query("UPDATE `vibory` SET `uchet_oborudovaniya` = '5 очередь' WHERE `id_obekta_skup` = ".$new_vib[$new_count][0]." "); break; }
            $new_count++;
        }
        $new_count = 1;
        $old_count++;
    }
?>