<?php
    if ($searched_tr == 0) { $searched_tr++; }
    if ($substring != 'vibory') { $kostil_3 = 1; $kostil_4 = 0; } else { $kostil_3 = 2; $kostil_4 = 1; }

    if (($td == ($max_td_count)) && ($bool_var_2 == true))
    { ?>
        <td class='table_head_sys'>
            <button name='edit_true_<?= ($tr + $searched_tr); ?>' type="submit" style='margin-top: 33px;' class="btn btn-success"><span
                    class="glyphicon glyphicon glyphicon-ok"><?= $td; ?></span></button>
        </td>
    <?php }
    if ($td == ($max_td_count + $kostil_3))
    { ?>
        <td class='table_head_sys'>
            <div style = 'margin-top: 33px;'>
                <a href='/body/sys/del.php?<?= $substring ?>/<?= $title[$tr][0] ?>'>
                    <div style='border: solid 1px black;' class="btn btn-danger"><span style='color: black; ' class="glyphicon glyphicon glyphicon-remove"><?= $td; ?></span></div>
                </a>
            </div>
        </td>
    <?php }

    if ($td == ($max_td_count + 4))
    { ?>
        <td class='table_head_sys'>
            <!--            <button name='edit_true_--><?//= ($tr + $searched_tr + $add_tr); ?><!--' type="submit" style = 'height: 30px; width: 40px; border: solid 1px black;' class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk"></span></button>-->
            <button name='edit_true_<?= ($tr + $searched_tr + $add_tr); ?>' type="submit" style = 'height: 35px; width: 40px; margin-top: 10px; border: solid 1px black;' class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span></button>
            <button name='edit_true_<?= ($tr + $searched_tr + $add_tr); ?>' type="submit" style = 'height: 35px; width: 40px; margin-top: 10px; border: solid 1px black;' class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>
        </td>
    <?php }

    if (($td === ($max_td_count + $kostil_4)) && ($bool_var_2 === false))
    { ?>
        <td class='table_head_sys'>
            <button onclick="" name='edit_<?= ($tr + $searched_tr); ?>' type="submit" style='border: solid 1px black; margin-top: 33px;'
                    class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></button>
        </td>
    <?php }
?>