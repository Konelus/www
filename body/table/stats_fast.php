<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/class/macro.php');


    if (file_exists($_SERVER['DOCUMENT_ROOT']."/macro/{$_GET['project']}.ini"))
    { $macro = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/macro/{$_GET['project']}.ini"); }
    $CHECK->check_main($macro);
    $check_title = $CHECK->check_title();
    $result = $CHECK->check_out(1);
    $count = 0;



    foreach($_POST as $key => $value)
    {
        if (stripos("{$key}","edit") !== false)
        { list($temp, $id) = explode("_","{$key}"); }

        elseif (stripos("{$key}","del") !== false)
        {
            list($temp, $del) = explode("_","{$key}");
            $CHECK->check_del($del);
            $result = $CHECK->check_out(1);
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
        header("Location: /body/table/stats_fast.php/?project={$_GET['project']}");
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
        <title>Текущий план ОР</title>
    </head>
    <body style = 'background: white;'>
    <div style = 'font-family: "Times New Roman"; cursor: default; width: 100%; z-index: 777; top: 0; left: 0; position: fixed; text-align: center; background: black; color: white; padding-top: 10px; padding-bottom: 10px; font-size: 25px;'>Текущий план оперативных работ на БС Теле2</div>
        <div class = 'container-fluid' style = 'padding-top: 55px;'>
            <div class = 'row'>
                <?php for ($count2 = 0; $count2 <= 3; $count2++) { ?>
                <div class = 'col-lg-12'>
                    <?php for ($count1 = 0; $count1 <= 5; $count1++) { ?>
                    <div class = 'col-lg-2' style = 'text-align: center; margin-top: 15px; margin-bottom: 15px;'>
                        <?php
                            $bg = '';
                            for ($result_count = 1; $result_count <= 9; $result_count++)
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
                            <div style = 'border: solid 2px navy;'>
                                <?php
                                    for ($i_count = 1; $i_count <= 9; $i_count++)
                                    {
                                        if ($disable[$count] != 'disabled') { $ph[$i_count] = $check_title[$i_count]; }
                                        else { $ph[$i_count] = ''; }
                                        if ($i_count == 1)
                                        {
                                        ?>
                                            <div>
                                                <input placeholder = '<?= $ph[$i_count] ?>' class = 'form-control input2' <?= $dis[$count] ?> style = '<?= $cursor[$i_count] ?>; <?= $bg[$i_count] ?>; ' type = text value = "<?= $result[$count][1] ?>" title = "<?= $result[$count][1] ?>">
                                                <input placeholder = '<?= $ph[$i_count] ?>' class = 'form-control input2' <?= $dis[$count] ?> style = '<?= $cursor[$i_count] ?>; <?= $bg[$i_count] ?>; ' type = text value = "<?= $result[$count][2] ?>" title = "<?= $result[$count][2] ?>">
                                            </div>
                                        <?php
                                        } elseif (($i_count != 1) && ($i_count != 2)) { ?>
                                            <div>
                                                <input placeholder = '<?= $ph[$i_count] ?>' class = 'form-control input' <?= $dis[$count] ?> style = '<?= $cursor[$i_count] ?>; <?= $bg[$i_count] ?>; ' type = text value = "<?= $result[$count][$i_count] ?>" title = "<?= $result[$count][$i_count] ?>">
                                            </div>
                                            <?php
                                        }
                                    }
                                ?>
                                <div style = 'border-top: solid 2px black; height: 36px; background: #337AB7;'>
                                    <div style = 'float: left; width: 50%;'>
                                        <input type = 'submit' value = 'Редактировать' name = 'edit_<?= $result[$count][0] ?>' class = 'btn btn-primary' style = 'width: 100%; border-radius: 0;' <?= $disable[$count] ?>>
                                    </div>
                                    <div style = 'float: right; width: 50%;'>
                                        <input type = 'submit' value = 'Закрыть' name = 'del_<?= $result[$count][0] ?>' class = 'btn btn-danger' style = 'width: 100%; border-radius: 0;' <?= $disable[$count] ?>>
                                    </div>
                                </div>
                            </div>
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