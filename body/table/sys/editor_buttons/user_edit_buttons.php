<?php
    if ($podcat_name[1] != 'vibory') { $kostil_3 = 1; } else { $kostil_3 = 0; }

    if (($td == ($td_td + $kostil_3)) && ($bool_var_2 == 1))
    { ?>
        <td class='table_head_sys'>
            <button name='edit_true_<?php echo ($tr + $searched_tr); ?>' type="submit" style='margin-top: 33px;' class="btn btn-success"><span
                    class="glyphicon glyphicon glyphicon-ok"></span></button>
        </td>
    <?php }
    if (($td === ($td_td + $kostil_3)) && ($bool_var_2 === 0)) { ?>
        <td class='table_head_sys'>
        <button name='edit_<?php echo ($tr + $searched_tr); ?>' type="submit" style='border: solid 1px black; margin-top: 25px;'
                class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></button>
        </td><?php }
?>