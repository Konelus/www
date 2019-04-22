<?php

    if (isset ($_POST))
    {
        foreach ($_POST as $key => $value)
        {
            if (stripos("{$key}","edit") !== false)
            { list($temp, $edit) = explode("_","{$key}"); }
        }
    }
//    require_once($_SERVER['DOCUMENT_ROOT'].'/class/macro.php');
    if ($edit != '') { hidden_other(); }

    if ($data != '')
    {
        foreach ($data as $key => $value)
        {
            if ($value['id'] != '')
            {
                echo '<tr>';
                if ((isset($macro['edit_bar_position'])) && $macro['edit_bar_position'] == 'start') { ?>
                    <td class = 'table_head_sys'>
                        <div style = 'margin-top: 5px; margin-bottom: 5px;'>
                            <button type = 'submit' name = 'edit_<?= $value['id'] ?>' class = 'btn btn-default' style = 'border: solid 1px black;'><span class = 'glyphicon glyphicon-pencil'></span></button>
                            <?php if ($CHECK->check == 'true') { ?>
                                <button type = 'submit' name = 'stats_<?= $value['id'] ?>' class = 'btn btn-warning' style = 'margin-left: 10px; border: solid 1px black;'><span class = 'glyphicon glyphicon-stats'></span></button>
                            <?php } ?>
                        </div>
                    </td>
                <?php }
                foreach ($value as $n_key => $n_value)
                {
                    if ($n_key != 'id')
                    { ?><td style = 'min-width: 200px; cursor: default;' title = '<?= $title[$n_key] ?>'><?= $n_value ?></td><?php }
                }
                if ((stripos($_SERVER['QUERY_STRING'],"_dump") === false) && (!isset($macro['edit_bar_position'])) || $macro['edit_bar_position'] == 'end') { ?>
                    <td class = 'table_head_sys'>
                        <div style = 'margin-top: 5px; margin-bottom: 5px;'>
                            <button type = 'submit' name = 'edit_<?= $value['id'] ?>' class = 'btn btn-default' style = 'border: solid 1px black;'><span class = 'glyphicon glyphicon-pencil'></span></button>
                            <?php if ($CHECK->check == 'true') { ?>
                                <button type = 'submit' name = 'stats_<?= $value['id'] ?>' class = 'btn btn-warning' style = 'margin-left: 10px; border: solid 1px black;'><span class = 'glyphicon glyphicon-stats'></span></button>
                            <?php } ?>
                        </div>
                    </td>
                <?php }
                echo '</tr>';
            }
        }


        if ($edit != '')
        {
            require_once($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/edit.php');
            ?>
            <script>
                $("#hidden").val("<?= $edit ?>");
                $("#edit").modal("show");
            </script>
        <?php }
    }
    if ((isset ($_POST['del'])) || (isset ($_POST['edit']))) { hidden_other(); }
?>
