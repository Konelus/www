<tr>
    <?php
        $status = $current_users_access["{$substring}_status"];
        if ($_COOKIE['user'] == 'admin') { $bag_2 = 0; } else if ($status == 'superuser') { $bag_2 = 1; }

        foreach ($table as $key => $value)
        { ?>
            <td style = 'min-width: 100px;' class = 'table_head_bg'>
                <div style = 'width: 100%; border-bottom: solid 1px black; padding-bottom: 5px; padding-top: 5px;'>
                    <input class = 'table_head_submit_bg' type = 'submit' name = '<?= str_replace(".","", "{$table[$key]}") ?>_asc' value = '↑'>
                    <input class = 'table_head_submit_bg' type = 'submit' name = '<?= str_replace(".","", "{$table[$key]}") ?>_desc' value = '↓'>
                </div>
                <div><?= $value ?></div>
            </td>
        <?php }
        if (($_COOKIE['user'] == 'admin') || ($status == 'superuser'))
        { ?>
            <td class = 'table_head_sys'>edit</td>
            <td class = 'table_head_sys'>del</td>
        <?php } elseif ($status == 'user')
        { ?>
            <td class = 'table_head_sys'>edit</td>
        <?php } ?>
</tr>
<?php //pre(get_defined_vars()); ?>