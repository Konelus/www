<tr>
    <?php
    $status = $current_users_access["{$substring}_status"];
    if ($_COOKIE['user'] == 'admin') { $bag_2 = 0; } else if ($status == 'superuser') { $bag_2 = 1; }

    if (($current_users_access["{$substring}_status"] != 'readonly') && ((isset($macro['edit_bar_position'])) && ($macro['edit_bar_position'] == 'start')))
    { echo "<td class = 'table_head_sys' colspan = '1'><div style = 'width: 120px; font-size: 20px;'>Изменить</div></td>"; }

    if ($title != '')
    {
        foreach ($title as $key => $value)
        {
            if ($key != 'id')
            {
                //if ((($title[$key] == $_POST['selected_td']))) { $bg = 'background: #F6EEA9;'; }
                //else { $bg = ''; }
                ?>
                <td style = '<?= $bg ?>min-width: 100px;' class = 'table_head_bg'>
                    <input class = 'table_head_submit_bg' type = 'submit' name = '<?= str_replace(".","", "{$table[$key]}") ?>_asc' value = '↑'>
                    <input class = 'table_head_submit_bg' type = 'submit' name = '<?= str_replace(".","", "{$table[$key]}") ?>_desc' value = '↓'>
                    <div><?= $value ?></div>
                </td>
            <?php }
        }
    }
    if ((stripos($_SERVER['QUERY_STRING'],"_dump") === false) && ($current_users_access["{$substring}_status"] != 'readonly')  && ((!isset($macro['edit_bar_position'])) || ($macro['edit_bar_position'] == 'end'))) { ?>
        <td class = 'table_head_sys' colspan = '1'><div style = 'width: 120px; font-size: 20px;'>Изменить</div></td>
    <?php }  ?>
</tr>