<?php

    if ($edit != '') { hidden_other(); }

    if ($data != '')
    {
        foreach ($data as $key => $value)
        {
            if ($value['id'] != '')
            {
                echo '<tr>';
                foreach ($value as $n_key => $n_value)
                {
                    if ($n_key != 'id')
                    { ?><td style = 'min-width: 200px; cursor: default;' title = '<?= $title[$n_key] ?>'><?= $n_value ?></td><?php }
                } ?>
                    <td class = 'table_head_sys'>
                        <div style = 'margin-top: 5px; margin-bottom: 5px;'>
                            <button type = 'submit' name = 'edit_<?= $value['id'] ?>' class = 'btn btn-default' style = 'border: solid 1px black;'><span class = 'glyphicon glyphicon-pencil'></span></button>
                        </div>
                    </td>
                <?php
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
