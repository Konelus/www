<?php
    if ($searched_tr == 0) { $searched_tr++; }
<<<<<<< HEAD
    if ($substring != 'vibory') { $kostil_3 = 2; } else { $kostil_3 = 1; }


    if (($td == ($td_td + $kostil_3)) && ($bool_var_2 == true))
=======
    if ($podcat_name[1] != 'vibory') { $kostil_3 = 1; } else { $kostil_3 = 0; }


    if (($td == ($td_td + $kostil_3)) && ($bool_var_2 == 1))
>>>>>>> 48fa31c38613c885e95021083a26ab15ea06d4e6
    { ?>
        <td class='table_head_sys'>
            <button name='edit_true_<?= ($tr + $searched_tr); ?>' type="submit" style='margin-top: 33px;' class="btn btn-success"><span
                    class="glyphicon glyphicon glyphicon-ok"></span></button>
        </td>
    <?php }



    if (($td === ($td_td + $kostil_3)) && ($bool_var_2 === false)) { ?>
        <td class='table_head_sys'>
        <button name='edit_<?= ($tr + $searched_tr); ?>' type="submit" style='border: solid 1px black; margin-top: 25px;'
                class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></button>
        </td><?php }
?>