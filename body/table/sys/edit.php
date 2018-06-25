<div class = 'modal fade' id = 'edit'>
    <div class = 'modal-dialog'>
        <div class = 'modal-content'>
            <form method = "post">
                <div class = 'modal-header'><div style = 'font-size: 20px; font-weight: bold; text-align: center;'>Редактирование</div></div>
                <div class = 'modal-body'>
                    <?php
                    foreach ($data[$edit] as $key => $value)
                    {
                        if ($permissions[$key] == '+') { $enable = 'enabled'; } else { $enable = 'disabled'; }
                        if ($key != 'id') { ?>
                        <label style = 'font-size: 12px; margin-top: 5px; margin-bottom: 0; margin-left: 2px;'><?= $title[$key] ?></label>
                        <input <?= $enable ?> type = 'text' name = 'text_<?= $data[$edit][0].'_'.$key ?>' value = '<?= $value ?>' class = 'form-control' style = 'margin-bottom: 5px;'><?php
                    } }
                    ?>
                </div>
                <div class = 'modal-footer'>
                    <input type = 'hidden' id = 'hidden' name = 'hidden'>
                    <input type = 'submit' class = 'btn btn-success' value = 'Сохрантить' name = 'edit'>
                    <input type = 'submit' class = 'btn btn-danger' value = 'Удалить' name = 'del'>
                    <button type = 'button' class = 'btn btn-default' data-dismiss = 'modal'>Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>