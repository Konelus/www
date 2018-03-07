<?php
    if ($tr == 0) { $searched_tr = 1; }
    if ($substring != 'vibory') { $kostil_3 = 1; } else { $kostil_3 = 0; }


    if (($td == ($td_td + $kostil_3)) && ($bool_var_2 == 1))
    { ?>
        <td class='table_head_sys'>
            <button name='edit_true_<?= ($tr + $searched_tr); ?>' type="submit" style='margin-top: 33px;' class="btn btn-success"><span
                    class="glyphicon glyphicon glyphicon-ok"></span></button>
        </td>
    <?php }

    if ($td == ($td_td + $kostil_3 + 1))
    { ?>
        <td class='table_head_sys'>
            <!--            <button name='edit_true_--><?//= ($tr + $searched_tr + $add_tr); ?><!--' type="submit" style = 'height: 30px; width: 40px; border: solid 1px black;' class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk"></span></button>-->
            <button name='edit_true_<?= ($tr + $searched_tr + $add_tr); ?>' type="submit" style = 'height: 35px; width: 40px; margin-top: 10px; border: solid 1px black;' class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span></button>
            <button name='edit_true_<?= ($tr + $searched_tr + $add_tr); ?>' type="submit" style = 'height: 35px; width: 40px; margin-top: 10px; border: solid 1px black;' class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>
        </td>
    <?php }

    if (($td === ($td_td + $kostil_3)) && ($bool_var_2 === 0)) { ?>
        <td class='table_head_sys'>
        <button name='edit_<?= ($tr + $searched_tr); ?>' type="submit" style='border: solid 1px black; margin-top: 25px;'
                class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></button>
        </td><?php }
?>