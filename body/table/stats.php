<?php


    $char = '';
    if (stripos("{$_GET['project']}","%") !== false)
    { list($_GET['project'], $char) = explode("%","{$_GET['project']}"); }


        require_once($_SERVER['DOCUMENT_ROOT'].'/class/macro.php');

        if (file_exists($_SERVER['DOCUMENT_ROOT']."/macro/{$_GET['project']}.ini"))
        { $macro = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/macro/{$_GET['project']}.ini"); }
        $CHECK->check_main($macro);
        $check_title = $CHECK->check_title($char);
        $result = $CHECK->check_out("",$char);
        $count = 0;

        foreach($_POST as $key => $value)
        {
            if (stripos("{$key}","edit") !== false)
            { list($temp, $id) = explode("_","{$key}"); }

            elseif (stripos("{$key}","del") !== false)
            {
                list($temp, $del) = explode("_","{$key}");
                $CHECK->check_del($del);
                $result = $CHECK->check_out();
                if ($char != '') { header("Location: /body/table/stats.php/?project={$_GET['project']}%{$char}"); }
                else { header("Location: /body/table/stats.php/?project={$_GET['project']}"); }
            }
        }


    if (isset ($_POST['save']))
    {
        require_once($_SERVER['DOCUMENT_ROOT'].'/class/table.php');
        //pre($_POST);
        $month = ['01' => 'Январь', '02' => 'Февраль', '03' => 'Март', '04' => 'Апрель', '05' => 'Май', '06' => 'Июнь', '07' => 'Июль', '08' => 'Август', '09' => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'];
        foreach ($_POST as $key => $value)
        {
            if (strpos("{$key}","select-") !== false)
            {
                list($s1, $s2, $s3, $s4, $s5) = explode("-",$key);
                $select[$s2][$s3] = $value;
                if ($s3 == 2)
                {
                    foreach ($month as $s_key => $s_value)
                    {
                        if ($select[$s2][$s3] == $s_value)
                        { $select[$s2][$s3] = $s_key; }
                    }
                }

                $_POST["text-{$s5}-{$s4}"] .= $select[$s2][$s3];
                if (($s3 == 1) || ($s3 == 2)) { $_POST["text-{$s5}-{$s4}"] .= '.'; }
                elseif ($s3 == 3) { $_POST["text-{$s5}-{$s4}"] .= ' '; }
                elseif ($s3 == 4) { $_POST["text-{$s5}-{$s4}"] .= ':'; }
                if (($select[$s2][1] == 'День') && ($select[$s2][2] == 'Месяц') && ($select[$s2][4] == 'Час') && ($select[$s2][5] == 'Мин.'))
                { $_POST["text-{$s5}-{$s4}"] = ''; }
            }
        }

        $TABLE->tr_edit($_GET['project'], $_GET['project'],$title, $fio, $macro);
        if ($char == '')
        { header("Location: /body/table/stats.php/?project={$_GET['project']}"); }
        else
        { header("Location: /body/table/stats.php/?project={$_GET['project']}%{$char}"); }
    }

    if ($result != '')
    {
        foreach ($result as $key => $value)
        {
            if ($value[0] == '')
            {
                unset ($result[$key]);
            }
        }
        $result = array_values($result);
    }

    foreach ($_POST as $key => $value)
    {
        if (stripos("{$key}","confirm") !== false)
        {
            $t_text = '';
            list($temp, $confirm) = explode("_","{$key}");
            $DB->select("*","{$_GET['project']}","`id` = 1");
            if ($DB->sql_query_select != '')
            {
                while ($array = mysqli_fetch_array($DB->sql_query_select))
                { $title = $array; }
            }
            foreach ($title as $key2 => $value2)
            {
                if ((is_numeric($key2)) || ($key2 == 'id'))
                { unset($title[$key2]); }
            }

            $DB->select("*","{$_GET['project']}","`id` = '{$confirm}'");
            if ($DB->sql_query_select != '')
            {
                while ($array = mysqli_fetch_array($DB->sql_query_select))
                { $val = $array; }
            }
            foreach ($val as $key2 => $value2)
            {
                if ((is_numeric($key2)) || ($key2 == 'id'))
                { unset($val[$key2]); }
                else
                {
                    $csv[$key2] = $title[$key2].';'.$val[$key2].';';
                    $csv_var .= $csv[$key2].iconv("UTF-8", "windows-1251", "\n");
                }
            }
            $file = $_SERVER['DOCUMENT_ROOT'].'/temp3721/'."file.csv";
            unlink($file);
            $fd = fopen($file, 'w') or die($_SERVER['DOCUMENT_ROOT'].'/temp3721/'."file.csv");
            fwrite($fd, $csv_var);
            fclose($fd);
            file_put_contents($file, "\xEF\xBB\xBF".  $csv_var);
            header("Location: /temp3721/file.csv");

        }
    }


?>

<!DOCTYPE html>

<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
        <style>
            .input { cursor: default; border-radius: 0; font-size: 12px; text-align: center; width: 100%; height: 30px; }
            .input2 { cursor: default; border-radius: 0; font-size: 12px; text-align: center; width: 50%; float: left; height: 30px; }
        </style>
        <title>Мониторинг</title>
    </head>
    <body style = 'background: white;'>
    <div style = 'font-family: "Times New Roman"; cursor: default; width: 100%; z-index: 777; top: 0; left: 0; position: fixed; text-align: center; background: black; color: white; padding-top: 10px; padding-bottom: 10px; font-size: 25px;'>
        <?php
        if ($char == '') { echo "Оперативный мониторинг исполнения заявок по генерации и АВР за текущие сутки"; }
        else { echo 'МЦТЭТ "'.$char.'"'; }
        ?>
    </div>
        <div class = 'container-fluid' style = 'padding-top: 55px;'>
            <div class = 'row'>
                <?php for ($count2 = 0; $count2 <= 3; $count2++) { ?>
                <div class = 'col-lg-12'>
                    <?php for ($count1 = 0; $count1 <= 5; $count1++) { ?>
                    <div class = 'col-lg-2' style = 'text-align: center; margin-top: 15px; margin-bottom: 15px;'>
                        <?php
                            $bg = '';
                            for ($result_count = 1; $result_count <= (count($check_title) - 1); $result_count++)
                            {
                                if (($result[$count][0] != '') && ($result[$count][$result_count] != ''))
                                { $bg[$result_count] = 'background: lightgreen'; }
                                elseif (($result[$count][0] != '') && ($result[$count][$result_count] == ''))
                                { $cursor[] = '';  $val[$count] =  ''; $bg[$result_count] = 'background: orange'; }
                                else { $bg[$result_count] = 'background: lightgrey'; $dis[$count] = 'readonly;'; $cursor[] = 'cursor: default'; }
                            }
                            if ($result[$count] == '') {  $disable[$count] = 'disabled'; }
                            else { $disable[$count] = ''; }

                        ?>

                        <form method = "post">
                            <?php  if ($disable[$count] == '') { ?><div style = 'border: solid 2px navy;'><?php } ?>
                                <?php
                                    for ($i_count = 1; $i_count <= (count($check_title) - 1); $i_count++)
                                    {
                                        if ($i_count == 1) { $border = ''; }
                                        else { $border = 'border-top: solid 2px black;'; }

                                        if (($char != '') && ($disable[$count] == ''))
                                        {
                                            if ($i_count == 1)
                                            { ?>
                                                <div>
                                                    <input placeholder = '<?= $check_title[1] ?>' class = 'form-control input2' style = '<?= $bg[1] ?>; ' type = text value = "<?= $result[$count][1] ?>" title = "<?= $result[$count][1] ?>">
                                                    <input class = 'form-control input2' style = 'color: white; background: #A84FC0;' type = submit value = "Выгрузить" name = 'confirm_<?= $result[$count][0] ?>'>
                                                </div>
                                                <?php
                                            } elseif ($i_count == 3) { ?>
                                                <div>
                                                    <input placeholder = '<?= $check_title[2] ?>' class = 'form-control input2' style = '<?= $bg[2] ?>; ' type = text value = "<?= $result[$count][2] ?>" title = "<?= $result[$count][2] ?>">
                                                    <input placeholder = '<?= $check_title[3] ?>' class = 'form-control input2' style = ' <?= $bg[3] ?>; ' type = text value = "<?= $result[$count][3] ?>" title = "<?= $result[$count][3] ?>">
                                                </div>
                                            <?php }
                                            elseif ($i_count == 4) { ?>
                                                <div>
                                                    <input placeholder = '<?= $check_title[4] ?>' class = 'form-control input2' style = '<?= $bg[4] ?>; ' type = text value = "<?= $result[$count][4] ?>" title = "<?= $result[$count][4] ?>">
                                                    <input placeholder = '<?= $check_title[5] ?>' class = 'form-control input2' style = '<?= $bg[5] ?>; ' type = text value = "<?= $result[$count][5] ?>" title = "<?= $result[$count][5] ?>">
                                                </div>
                                            <?php }
                                            elseif ($i_count == 5) { ?>
                                                <div>
                                                    <input placeholder = '<?= $check_title[6] ?>' class = 'form-control input' style = '<?= $bg[6] ?>;' type = text value = "<?= $result[$count][$i_count] ?>" title = "<?= $result[$count][6] ?>">
                                                </div>
                                            <?php }
                                            elseif ($i_count == 6) { ?>
                                                <div>
                                                    <input placeholder = '<?= $check_title[7] ?>' class = 'form-control input' style = '<?= $bg[7] ?>; ' type = text value = "<?= $result[$count][7] ?>" title = "<?= $result[$count][7] ?>">
                                                </div>
                                            <?php }
                                            elseif ($i_count == 7) { ?>
                                                <div>
                                                    <input placeholder = '<?= $check_title[8] ?>' class = 'form-control input2' style = '<?= $bg[8] ?>; ' type = text value = "<?= $result[$count][8] ?>" title = "<?= $result[$count][8] ?>">
                                                    <input placeholder = '<?= $check_title[9] ?>' class = 'form-control input2' style = '<?= $bg[9] ?>; ' type = text value = "<?= $result[$count][9] ?>" title = "<?= $result[$count][9] ?>">
                                                </div>
                                            <?php }
                                            elseif ($i_count > 9) { ?>
                                                <div>
                                                    <input placeholder = '<?= $check_title[$i_count] ?>' class = 'form-control input' style = '<?= $bg[$i_count] ?>; ' type = text value = "<?= $result[$count][$i_count] ?>" title = "<?= $result[$count][$i_count] ?>">
                                                </div>
                                            <?php }

                                        } elseif (($char == '') && ($disable[$count] == ''))
                                        {
                                        if ($i_count == 1)
                                        { ?>
                                            <div>
                                                <input placeholder = '<?= $ph[$i_count] ?>' class = 'form-control input2' <?= $dis[$count] ?> style = '<?= $cursor[$i_count] ?>; <?= $bg[$i_count] ?>; ' type = text value = "<?= $result[$count][1] ?>" title = "<?= $result[$count][1] ?>">
                                                <input placeholder = '<?= $ph[$i_count] ?>' class = 'form-control input2' <?= $dis[$count] ?> style = '<?= $cursor[$i_count] ?>; <?= $bg[$i_count] ?>; ' type = text value = "<?= $result[$count][2] ?>" title = "<?= $result[$count][2] ?>">
                                            </div>
                                            <?php
                                        } elseif (($i_count != 1) && ($i_count != 2)) { ?>
                                            <div>
                                                <input placeholder = '<?= $ph[$i_count] ?>' class = 'form-control input' <?= $dis[$count] ?> style = '<?= $cursor[$i_count] ?>; <?= $bg[$i_count] ?>; ' type = text value = "<?= $result[$count][$i_count] ?>" title = "<?= $result[$count][$i_count] ?>">
                                            </div>
                                        <?php }
                                        }
                                    }
                                if ($disable[$count] == '') { ?>
                                    <div style = 'border-top: solid 2px black; height: 36px; background: #337AB7;'>
                                        <div style = 'float: left; width: 50%;'>
                                            <input type = 'submit' value = 'Редактировать' name = 'edit_<?= $result[$count][0] ?>' class = 'btn btn-primary' style = 'width: 100%; border-radius: 0;' <?= $disable[$count] ?>>
                                        </div>
                                        <div style = 'float: right; width: 50%;'>
                                            <input type = 'submit' value = 'Закрыть' name = 'del_<?= $result[$count][0] ?>' class = 'btn btn-danger' style = 'width: 100%; border-radius: 0;' <?= $disable[$count] ?>>
                                        </div>
                                    </div>
                            </div>
                                <?php }
                                ?>


                        </form>

                    </div>
                    <?php $count++; } ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php
        if ($id != '')
        {
            require_once($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/check_edit.php');
            ?>
            <script>
                $("#hidden").val("<?= $id ?>");
                $("#edit").modal("show");
            </script>
        <?php } ?>
    </body>
</html>