<?php
    if ($podcat_name[1] != 'vibory') { $kostil_3 = 1; $kostil_4 = 0; } else { $kostil_3 = 2; $kostil_4 = 1; }

    if (($td == ($max_td_count)) && ($bool_var_2 == 1))
    { ?>
        <td class='table_head_sys'>
            <button name='edit_true_<?php echo ($tr + $searched_tr); ?>' type="submit" style='margin-top: 33px;' class="btn btn-success"><span
                    class="glyphicon glyphicon glyphicon-ok"><?php echo $td; ?></span></button>
        </td>
    <?php }
    if ($td == ($max_td_count + $kostil_3))
    { ?>
        <td class='table_head_sys'>
            <div style = 'margin-top: 33px;'>
                <a href='/body/sys/del.php?<?php echo $podcat_name[1] ?>/<?php echo $title[$tr][0] ?>'>
                    <div style='border: solid 1px black;' class="btn btn-danger"><span style='color: black; ' class="glyphicon glyphicon glyphicon-remove"><?php echo $td; ?></span></div>
                </a>
            </div>
        </td>
    <?php }
    if (($td === ($max_td_count + $kostil_4)) && ($bool_var_2 === 0))
    { ?>
        <td class='table_head_sys'>
            <button onclick="" name='edit_<?php echo ($tr + $searched_tr); ?>' type="submit" style='border: solid 1px black; margin-top: 33px;'
                    class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></button>
        </td>
    <?php }
?>