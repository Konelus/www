<?php
    require_once  ($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');

    $count = -1;
    $SQL_QUERY_select_old = $mysqli->query("SELECT `id_obekta_skup` FROM `vibory`");
    while ($row1 = mysqli_fetch_row($SQL_QUERY_select_old))
    { $old_vib[$count] = $row1; $count++; }

    $old_count = 1;
    $new_count = 1;
?>

<!DOCTYPE html>

<head>
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
                if ($old_vib[$old_count][0] == $_POST['text_'.$new_count])
                {
                    echo $_POST['text_'.$new_count].' - OK!<br>';
                    $DB->update("vibory","kanal_propisan_rcuss","".$_POST['family'],"`id_obekta_skup` = '".$_POST['text_'.$new_count]."' ");
                }
                $new_count++;
            }
            $new_count = 1;
            $old_count++;
        }
    }
    ?>
