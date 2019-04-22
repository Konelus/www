<?php
    $DB->select("{$macro['choice_cell']}","{$_GET['project']}","`id` != '1' AND `id` != '2'");
    if ($DB->sql_query_select != '')
    {
        while ($array = mysqli_fetch_array($DB->sql_query_select))
        { $temp_choice[] = $array; }
        foreach ($temp_choice as $key => $value)
        {
            $pre_choice[$key] = $temp_choice[$key][0];
            if ($macro['choice_parse'] != '')
            {
                list($pre_choice[$key], $temp) = explode("{$macro['choice_parse']}","{$pre_choice[$key]}");
                $pre_choice[$key] .= $macro['choice_parse'];
            }
        }
        foreach ($pre_choice as $key => $value)
        {
            if ($pre_choice[$key - 1] != $value)
            { $choice[] = $value; }
        }

        $temp_choice_alias = explode(",","{$macro['choice_alias']}");
        foreach ($temp_choice_alias as $key => $value)
        {
            $temp_choice_alias[$key] = trim($value);
            $temp_choice_alias_2[$key] = explode(" = ","{$temp_choice_alias[$key]}");
            $choice_alias[$temp_choice_alias_2[$key][0]] = $temp_choice_alias_2[$key][1];
        }
    }
?>

<div class = 'modal fade' id = 'choice' style = 'color: black; margin-top: 40px; margin-bottom: 36px;'>
    <div class = 'modal-dialog'>
        <div class = 'modal-content'>
            <form method = "post" id = 'myform'>
                <div class = 'modal-header'>
                    <div style = 'text-align: center; font-weight: bold; font-size: 20px;'>Сортировка</div>
                </div>
                <div class = 'modal-body' style = 'height: 65px;'>
                    <div class = 'col-lg-12'>
                        <div class = 'col-lg-6'>
                            <label style = 'font-size: 18px;'><?= $macro['choice_title'] ?></label>
                        </div>
                        <div class = 'col-lg-6'>
                            <select class = 'form-control' name = 'caption'>
                                <option hidden selected></option>
                                <?php foreach ($choice as $key => $value)
                                {
                                    if ($key == (count($choice) - 1)) { break; } // Костыль из-за конфига
                                    echo "<option>{$choice_alias[$value]}</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class = 'modal-footer' style = 'padding-right: 45px;'>
                    <input type = 'submit' name = 'search_btn' class = 'btn btn-success' value = 'Выбрать'>
                    <input type = 'submit' name = 'search_tmp' class = 'btn btn-default' value = 'Закрыть'>
                </div>
            </form>
        </div>
    </div>
</div>