<?php
    if ($searched_tr == 0) { $searched_tr++; }

    if (($td == ($max_td_count + 2)) && ($bool_var_2 == 1))
    { ?><td class='table_head_sys'><button name='edit_true_<?= ($tr + $searched_tr); ?>' type="submit" style='margin-top: 33px;' class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button></td><?php }

    if ($td == ($max_td_count + 3))
    { ?>
        <td class='table_head_sys'>
            <div style = 'margin-top: 33px;'>
                <a href='/body/sys/del.php?<?= "{$podcat_name[1]}/{$title[$tr][0]}" ?>'>
                    <div style='border: solid 1px black;' class="btn btn-danger"><span style='color: black; ' class="glyphicon glyphicon glyphicon-remove"></span></div>
                </a>
            </div>
        </td>
    <?php }

//    if ($td == ($max_td_count + 4))
//    { ?>
<!--        <td class='table_head_sys'>-->
<!--            <button name='edit_true_--><?//= ($tr + $searched_tr + $add_tr); ?><!--' type="submit" style = 'height: 30px; width: 40px; border: solid 1px black;' class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk"></span></button>-->
<!--            <button name='edit_true_--><?//= ($tr + $searched_tr + $add_tr); ?><!--' type="submit" style = 'height: 30px; width: 40px; margin-top: 10px; border: solid 1px black;' class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span></button>-->
<!--            <button name='edit_true_--><?//= ($tr + $searched_tr + $add_tr); ?><!--' type="submit" style = 'height: 30px; width: 40px; margin-top: 10px; border: solid 1px black;' class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>-->
<!--        </td>-->
<!--    --><?php //}

    if (($td === ($max_td_count + 2)) && ($bool_var_2 === 0))
    { ?>
        <td class='table_head_sys'>
            <button name='edit_<?= ($tr + $searched_tr); ?>' type="submit" style='border: solid 1px black; margin-top: 33px;'
                    class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></button>
        </td>
    <?php }

?>