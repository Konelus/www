<?php
    if ($bool_chb == false)
    {
        if (isset ($_POST['chb_'.$tr.'_1']))
        {
            $SQL_update_00 = $mysqli->query("UPDATE " . $podcat_name[1] . " SET `kamera_zaregistrirovanna` = 'да'  WHERE id = " . $title[$tr][0] . " ");
            ?><script>
                var current_tr = 0; this_tr = '';
                this_tr = <?php echo json_encode($tr); ?>;
                current_tr = (parseInt(this_tr - 5) * <?php echo $scroll ?>);
            </script><?php
            echo "<script>window.onload = function(){window.scrollTo( 50000, current_tr );}</script>";
            // ↓ Обновление данных в таблице ↓
            require($_SERVER['DOCUMENT_ROOT'] . "/body/sort.php");
            require($_SERVER['DOCUMENT_ROOT'] . "/body/data.php");
            // ↑ Обновление данных в таблице ↑
            $bool_chb = true;
        }

        if (isset ($_POST['chb_'.$tr.'_2']))
        {
            $SQL_update_00 = $mysqli->query("UPDATE " . $podcat_name[1] . " SET `kamera_zaregistrirovanna` = 'нет'  WHERE id = " . $title[$tr][0] . " ");
            ?><script>
                var current_tr = 0; this_tr = '';
                this_tr = <?php echo json_encode($tr); ?>;
                current_tr = (parseInt(this_tr - 5) * <?php echo $scroll ?>);
            </script><?php
            echo "<script>window.onload = function(){window.scrollTo( 50000, current_tr );}</script>";
            // ↓ Обновление данных в таблице ↓
            require($_SERVER['DOCUMENT_ROOT'] . "/body/sort.php");
            require($_SERVER['DOCUMENT_ROOT'] . "/body/data.php");
            // ↑ Обновление данных в таблице ↑
            $bool_chb = true;
        }
    }
?>