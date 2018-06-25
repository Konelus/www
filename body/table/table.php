<?php
    foreach ($_POST as $key => $value)
    {
        if (stripos("{$key}","edit") !== false)
        {
            list($temp, $edit) = explode("_","{$key}");
        }
    }


    foreach ($data as $key => $value)
    {
        echo '<tr>';
        foreach ($value as $n_key => $n_value)
        {
            if ($n_key != 'id') { echo "<td style = 'min-width: 200px; cursor: default;' title = '{$title[$n_key - 1]}'>{$n_value}</td>"; }
        } ?>
            <td class = 'table_head_sys'>
                <div style = 'margin-top: 5px; margin-bottom: 5px;'>
                    <form method = "post">
                        <button type = 'submit' name = 'edit_<?= $key ?>' class = 'btn btn-default' style = 'border: solid 1px black;'><span class = 'glyphicon glyphicon-pencil'></span></button>
                    </form>
                </div>
            </td>
        <?php
        echo '</tr>';
    }

    require_once($_SERVER['DOCUMENT_ROOT'].'/body/table/sys/edit.php');
    if ($edit != '')
    { ?>
        <script>
            $("#hidden").val("<?= $edit ?>");
            $("#edit").modal("show");
        </script>
    <?php }
?>