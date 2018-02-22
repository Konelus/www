<?php
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
//    $count = 1;
//    $SQL_QUERY_select_new = $mysqli->query("SELECT `id_obekta_skup` FROM `vibory_temp`");
//    while ($row2 = mysqli_fetch_row($SQL_QUERY_select_new))
//    { $new_vib[$count] = $row2; $count++; }

    $old_count = 1;
    $new_count = 1;
?>

<!DOCTYPE html>

<head>
    <meta charset = "UTF-8">
    <title>Канал прописан РЦУСС</title>
</head>
<body>
    <form method = "post">
        <script>
            for (count = 1; count <= 10; count++)
            { document.write("<div style = 'height: 30px;'><input style = 'border: solid 1px black;' type = 'text' autocomplete = 'off' placeholder = 'ID объекта СКУП № " + count + "' name = 'text_" + count + "'></div>"); }
        </script>
        <div style = 'height: 30px;'><input style = 'border: solid 1px black;' type = 'text' autocomplete = 'off' placeholder = 'Фамилия' name = 'family'></div>
        <div style = 'height: 30px;'><input type = 'submit' name = 'send'></div>
    </form>
</body>

<?php
    if (isset ($_POST['send']))
    {
        while ($old_count <= mysqli_num_rows($SQL_QUERY_select_old))
        {
            while ($new_count <= 10)
            {
                //echo $_POST['text_'.$new_count];
                if ($old_vib[$old_count][0] == $_POST['text_'.$new_count])
                { echo $_POST['text_'.$new_count].' - OK!<br>'; $SQL_QUERY_update = $mysqli->query("UPDATE `vibory` SET `kanal_propisan_rcuss` = '".$_POST['family']."' WHERE `id_obekta_skup` = ".$_POST['text_'.$new_count]." "); break; }
                $new_count++;
            }
            $new_count = 1;
            $old_count++;
        }
    }
    ?>
