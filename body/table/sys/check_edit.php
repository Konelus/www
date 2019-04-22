<?php
    if ((isset ($permissions)) && ((isset ($macro)) && ($macro['additional_autocomplete'] == 'true')))
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

<div class = 'modal fade' id = 'edit' style = 'color: black; height: 100vh;'>
    <div class = 'modal-dialog'>
        <div class = 'modal-content'>
            <form method = "post" id = 'myform'>
                <div class = 'modal-header'>
                    <div style = 'font-size: 20px; font-weight: bold; text-align: center; cursor: default;'>Редактирование</div>
                </div>
                <div class = 'modal-body' style = 'text-align: left;'>
                    <?php require_once ($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/edit_parts/check_edit.php'); ?>
                </div>
                <div class = 'modal-footer'>
                    <input type = 'hidden' id = 'hidden' name = 'hidden'>
                    <input type = 'submit' class = 'btn btn-success' value = 'Сохрантить' name = 'save'>
                    <button type = 'button' class = 'btn btn-default' data-dismiss = 'modal'>Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>