<div class = 'modal fade' id = 'adm_panel' style = 'color: black;' data-backdrop="static">
    <div class = 'modal-dialog'>
        <div class = 'modal-content'>
            <form method = "post">
                <div class = 'modal-header' style = 'font-size: 20px;'>Администрирование</div>
                <div class = 'modal-body' style = 'text-align: left;'>
                    <div class = 'container-fluid'>
                        <div class = 'row'>
                            <div class = 'col-lg-12'>
                                <div class = 'col-lg-12'><label style = 'margin-top: 8px; margin-bottom: 0;'>Добавление столбца</label></div>
                                <div class = 'col-lg-8'><input name = 'add_cell_text' autocomplete = "off" class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;' type = 'text'></div>
                                <div class = 'col-lg-4'><input name = 'add_cell_btn' class = 'btn btn-success' style = 'width: 100%;' type = 'submit' value = 'Добавить'></div>
                            </div>
                            <div class = 'col-lg-12'>
                                <div class = 'col-lg-12'><label style = 'margin-top: 8px; margin-bottom: 0;'>Удаление столбца</label></div>
                                <div class = 'col-lg-8'>
                                    <select name = 'del_cell_name' autocomplete = "off" class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'>
                                        <?php
                                        foreach ($title as $key => $value)
                                        {
                                            if ($key != 'id')
                                            { echo "<option>{$value}</option>"; }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class = 'col-lg-4'><input name = 'del_cell' class = 'btn btn-danger' style = 'width: 100%;' type = 'submit' value = 'Удалить'></div>
                            </div>
                            <div class = 'col-lg-12'>
                                <div class = 'col-lg-12'><label style = 'margin-top: 8px; margin-bottom: 0;'>Перемещение столбца</label></div>
                                <div class = 'col-lg-8'>
                                    <div style = 'float: left; width: calc(50% - 30px);'>
                                        <select name = 'replace_current_cell' class = 'form-control' style = 'width: 100%; padding-left: 5px; padding-right: 5px;'>
                                            <?php
                                            foreach ($title as $key => $value)
                                            {
                                                if ($key != 'id')
                                                { echo "<option>{$value}</option>"; }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <span style = 'float: left; width: 60px; text-align: center; margin-top: 5px;'><label>после</label></span>
                                    <div style = 'float: right; width: calc(50% - 30px);'>
                                        <select name = 'replace_after_cell' class = 'form-control' style = 'width: 100%; padding-left: 5px; padding-right: 5px;'>
                                            <?php
                                            foreach ($title as $key => $value)
                                            {
                                                if ($value == '1') { $value = 'ID'; }
                                                { echo "<option>{$value}</option>"; }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class = 'col-lg-4'><input name = 'replace_cell' class = 'btn btn-success' style = 'width: 100%;' type = 'submit' value = 'Переместить'></div>
                            </div>
                            <div class = 'col-lg-12'>
                                <div class = 'col-lg-12'><label style = 'margin-top: 8px; margin-bottom: 0;'>Переименование столбца</label></div>
                                <div class = 'col-lg-8'>
                                    <div style = 'float: left; width: 50%; padding-right: 10px;'>
                                        <select name = 'old_cell_name' class = 'form-control' style = 'width: 100%; padding-left: 5px; padding-right: 5px;'>
                                            <?php
                                            foreach ($title as $key => $value)
                                            {
                                                if ($key != 'id')
                                                { echo "<option>{$value}</option>"; }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div style = 'float: left; width: 50%; padding-left: 10px;'><input name = 'new_cell_name' autocomplete = "off" class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;' type = 'text'></div>
                                </div>
                                <div class = 'col-lg-4'><input name = 'rename_cell' class = 'btn btn-success' style = 'width: 100%;' type = 'submit' value = 'Изменить'></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = 'modal-footer'><button type = 'submit' class = 'btn btn-default'>Закрыть</button></div>
            </form>
        </div>
    </div>
</div>