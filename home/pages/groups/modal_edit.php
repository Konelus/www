<div class = "modal fade" id = "modal_edit">
    <div class = "modal-dialog" role = "document">
        <div class = "modal-content">
            <form method = "post">
                <div class = "modal-header">
                    <div style = 'cursor: default; text-align: center; font-size: 20px; font-weight: bold;' class = 'modal-title' id = 'title'></div>
                </div>
                <div class = "modal-body">
                    <?php
                        foreach ($columns_rus as $c_key => $c_value)
                        { ?>
                            <div class = 'container-fluid'>
                                <div class = 'row'>
                                        <div style = 'margin-bottom: 10px;' class = 'col-lg-2 col-md-2 col-sm-2'></div>
                                        <div style = 'margin-bottom: 10px;' class = 'col-lg-4 col-md-4 col-sm-4'>
                                            <label for = 'select' style = 'float: left; margin-top: 5px;'><?= $c_value[1] ?></label>
                                        </div>
                                        <div style = 'margin-bottom: 10px;' class = 'col-lg-4 col-md-4 col-sm-4'>
                                            <select id = 'select' style = 'width: 200px; float: left;' class = 'form-control'>
                                                <option id = '<?= $c_value[0] ?>_user'>user</option>
                                                <option id = '<?= $c_value[0] ?>_superuser'>superuser</option>
                                                <option id = '<?= $c_value[0] ?>_readonly'>readonly</option>
                                                <option id = '<?= $c_value[0] ?>_none'></option>
                                            </select>
                                        </div>
                                        <div style = 'margin-bottom: 10px;' class = 'col-lg-2 col-md-2 col-sm-2'></div>
                                    </div>

                            </div>
                    <?php } ?>


                </div>
                <div class = "modal-footer">
                    <input type = 'hidden' id = 'hidden' name = 'hidden'>
                    <button type = 'button' style = 'border: solid 1px grey;' class = "btn btn-default" data-dismiss = "modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>