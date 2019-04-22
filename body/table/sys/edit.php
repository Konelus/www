<?php
    if (($permission_status != 'readonly') && ((isset ($macro)) && ($macro['additional_autocomplete'] == 'true')))
    {
        $DB->show("{$_GET['project']}_additional_autocomplete");
        while ($array = mysqli_fetch_array($DB->sql_query_show))
        { $temp_additional_title[] = $array; }
        foreach ($temp_additional_title as $key => $value)
        {
            if ($value[0] != 'id')
            { $additional_title[] = $value[0]; }
        }
    }

?>

<div class = 'modal fade' id = 'edit' style = 'color: black; margin-top: 40px; margin-bottom: 36px;'>
    <div class = 'modal-dialog'>
        <div class = 'modal-content'>
            <form method = "post" id = 'myform'>
                <div class = 'modal-header'>
                    <div style = 'font-size: 20px; font-weight: bold; text-align: center; cursor: default;'>
                        <?php
                        if ($edit != '')
                        {
                            echo 'Редактирование';
                            if ($permission_status == 'readonly')
                            { ?><span style = 'color: red;'> (запрещено)</span><?php }
                        } else { echo 'Добавление строки'; } ?>
                    </div>
                    <?php
                        if ((isset ($macro)) && ($macro['additional_autocomplete'] == 'true') && ($edit == ''))
                        {
                            if (isset ($_POST['autocomplete'])) { $checked = 'checked disabled'; $text = true; } else { $checked = ''; $text = false; }
                            ?>
                            <div style = 'text-align: center;'>
                                <label for = "checkbox">Ручной ввод</label>
                                <input <?= $checked ?> name="autocomplete" type="checkbox" id="checkbox" onchange="$('#myform').submit();">
                            </div>
                            <?php
                            if ($text == true) { echo "<div style = 'text-align: center; color: red; font-weight: bold;'>Для снятия выделения переоткройте данную форму!</div>"; }
                        }
                    ?>
                </div>
                <div class = 'modal-body' style = 'text-align: left;'>
                    <?php
                    if ($edit != '')
                    { require_once ($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/edit_parts/edit.php'); }
                    else
                    { require_once ($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/edit_parts/add.php'); }
                    ?>
                </div>
                <div class = 'modal-footer'>
                    <input type = 'hidden' id = 'hidden' name = 'hidden'>
                    <?php
                    if ($edit != '')
                    {
                        if ($permission_status != 'readonly') { ?>
                            <input type = 'submit' class = 'btn btn-success' value = 'Сохранить' name = 'edit'>
                        <?php }
                        if ($permission_status == 'superuser') {
                            if ($macro['dump'] == 'true') { ?>
                            <input type = 'submit' class = 'btn' style = 'background: gold; border: solid 1px black' value = 'В архив' name = 'arch'> <?php } ?>
                            <input type = 'submit' class = 'btn btn-danger' value = 'Удалить' name = 'del'>
                        <?php }
                    } else { ?><input type = 'submit' class = 'btn btn-success' value = 'Добавить' name = 'add_tr'><?php }
                    ?>
                    <button type = 'button' class = 'btn btn-default' data-dismiss = 'modal'>Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>