<tr>
    <?php
    //pre($title);


            $status = $current_users_access["{$substring}_status"];
            if ($_COOKIE['user'] == 'admin') { $bag_2 = 0; } else if ($status == 'superuser') { $bag_2 = 1; }
            if ($title != '')
            {
            foreach ($title as $key => $value)
            {
                if ($key != 'id')
                {
                    if ((($title[$key] == $_POST['selected_td']))) { $bg = 'background: #F6EEA9;'; }
                    else { $bg = ''; }
                    ?>
                <td style = '<?= $bg ?>min-width: 100px;' class = 'table_head_bg'>
    <!--                --><?php //if ($_COOKIE['user'] == 'Vlasov@south.rt.ru') { ?>
    <!--                <div style = 'width: 100%; padding-bottom: 5px; padding-top: 5px;'>-->
    <!--                    <input style = 'width: 100%; background: #9acfea; border: solid 1px black; height: 25px;' type = 'submit' name = '--><?//= str_replace(".","", "{$table_sql[$key]}") ?><!--' value = 'Скрыть столбец'>-->
    <!--                </div>-->
    <!--                --><?php //} ?>
    <!--                <div style = 'width: 100%; border-bottom: solid 1px black; padding-bottom: 5px; padding-top: 5px;'>-->
                        <input class = 'table_head_submit_bg' type = 'submit' name = '<?= str_replace(".","", "{$table[$key]}") ?>_asc' value = '↑'>
                        <input class = 'table_head_submit_bg' type = 'submit' name = '<?= str_replace(".","", "{$table[$key]}") ?>_desc' value = '↓'>
                    <div><?= $value ?></div>
                </td>
            <?php } } } if ($current_users_access["{$substring}_status"] != 'readonly') { ?>
            <td class = 'table_head_sys' colspan = '2'><div style = 'width: 120px; font-size: 20px;'>Изменить</div></td>
        <?php }  ?>
</tr>