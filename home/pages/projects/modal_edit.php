<div class = 'modal fade' id = 'modal_edit'>
    <div class = "modal-dialog">
        <div class = 'modal-content'>
            <form method = "post">
                <div class = 'modal-header'>
                    <div style = 'cursor: default; text-align: center; font-size: 20px; font-weight: bold;' class = 'modal-title' id = 'title'></div>
                </div>
                <div class = 'modal-body'>
                    <div class = 'container-fluid'>
                        <div class = 'row'>
                            <div class = 'col-lg-4' style = 'margin-bottom: 10px;'><label style = 'font-size: 15px; padding-top: 5px;'>Название проекта</label></div>
                            <div class = 'col-lg-8' style = 'margin-bottom: 10px;'><input name = 'proj_name' id = 'proj_name' type = 'text' class = 'form-control'></div>

                            <div class = 'col-lg-4' style = 'margin-bottom: 10px;'><label style = 'font-size: 15px; padding-top: 5px;'>Статус проекта</label></div>
                            <div class = 'col-lg-8' style = 'margin-bottom: 10px;'>
                                <select name = 'access' id = 'access' class = 'form-control'>
                                    <option id = 'true'>Доступно</option>
                                    <option id = 'false'>Недоступно</option>
                                </select>
                            </div>
                            <div class = 'col-lg-4' style = 'margin-bottom: 10px;'><label style = 'font-size: 15px; padding-top: 5px;'>Тестирование</label></div>
                            <div class = 'col-lg-8' style = 'margin-bottom: 10px;'>
                                <select name = 'additional' id = 'additional' class = 'form-control'>
                                    <option id = 'monitoring'>Мониторинг</option>
                                    <option id = 'sync'>Синхронизация</option>
                                    <option id = 'null'></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = 'modal-footer'>
                    <input type = 'hidden' name = 'hidden' id = 'hidden'>
                    <input type = 'submit' class = 'btn btn-success' value = 'Сохранить' name = 'save'>
                    <input type = 'submit' class = 'btn btn-danger' value = 'Удалить' name = 'del'>
                    <button type = 'button' class = 'btn btn-default' data-dismiss = 'modal'>Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>