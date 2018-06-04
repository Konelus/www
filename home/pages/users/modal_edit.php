<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method = "post">
            <div class="modal-content">
                <div class="modal-header">
                    <div style = 'text-align: center; font-size: 20px; font-weight: bold;' class="modal-title">Редактирование данных пользователя</div>
                </div>
                <form method = "post">
                    <div class="modal-body">
                        <?php
                        foreach ($td as $key => $value)
                        { ?>
                            <div>
                                <label style = 'margin-left: 5px; margin-bottom: 0;' for = "<?= $key ?>"><?= $value ?></label>
                                <span>
                                    <?php
                                    if (($key != 'status') & ($key != 'table_group'))
                                    { ?><input autocomplete="off" name = '<?= $key ?>' style = 'margin-bottom: 5px;' type = '<?= $type ?>' id = '<?= $key ?>' class = 'form-control text_box_border'><?php }
                                    elseif ($key == 'table_group')
                                    {
                                        echo "<select name = '{$key}' class = 'form-control'>";
                                        $group_bool = false;
                                        foreach ($groups as $g_key => $g_value)
                                        {
                                            if (is_numeric($g_key)) { unset($groups[$g_key]); }
                                            foreach ($g_value as $ng_key => $ng_value)
                                            {
                                                if (is_numeric($ng_key)) { unset($groups[$g_key][$ng_key]); }
                                                else
                                                {
                                                    if ($users[$count]['table_group'] == $ng_value) { $sel = 'selected'; } else { $sel = ''; }
                                                    if (($users[$count]['table_group'] == '') && ($group_bool == false)) { echo "<option selected></option>"; $group_bool = true; }
                                                    echo "<option {$sel}>$ng_value</option>";
                                                }
                                            }
                                        }
                                        echo "</select>";
                                    }
                                    elseif ($key == 'status')
                                    {
                                        if ($users[$count]['status'] == '+') { $sel1 = 'selected'; $sel2 = ''; }
                                        else { $sel = ''; $sel2 = 'selected'; } ?>
                                        <select  name = '<?= $key ?>' class = 'form-control'><option <?= $sel1 ?>>True</option><option <?= $sel2 ?>>False</option></select>
                                    <?php } ?>
                                </span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <input type = 'hidden' name = 'hidden' id = 'hidden'>
                    <div class="modal-footer">
                            <input type = 'submit' value = 'Сохранить изменения' class = 'btn btn-success' name = 'edit_btn'>
                            <input type = 'submit' value = 'Удалить пользователя' class = 'btn btn-danger' name = 'del_btn'>
                        <button style = 'border: solid 1px grey;' type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    </div>
                </form>
            </div>
        </form>
    </div>
</div>