<td style='min-width: 150px; <?php echo $height ?>' class='<?php echo $class_color ?>'><?php
    // ↓ Заполнение таблицы данными ↓
    if ($bool_var_2 == 0)
    {
        if ($title[$tr][$new_td[$td_td]] == 'Online Test')
        { $parsed_title = "<a target = '_blank' href = '/body/table/additional_table.php/?".$title[$tr][0]."'>".$title[$tr][$new_td[$td_td]]."</a>"; }
        else if ($title[$tr][$new_td[$td_td]] != 'Online Test')
        { $parsed_title = $title[$tr][$new_td[$td_td]]; }
        ?><div style = 'min-width: 150px; <?php echo $height ?> max-height: 100px; overflow: hidden;'><?php echo $parsed_title; ?></div><?php $td_td++;
    }
    // ↑ Заполнение таблицы данными ↑


    // ↓ Создание textarea для обычного пользователя ↓
    else if ($bool_var_2 == 1)
    { ?><textarea <?php echo $ro[$new_td[$td_td]] ?>
            name = 'editBox_<?php echo $tr . "_" . $new_td[$td_td] ?>'
            style = 'height: 100px; padding: 0; font-size: 10px; text-align: center; border: solid 1px black; width: 100%;'
            class = 'form-control'
            autocomplete = 'off'><?php echo $title[$tr][$new_td[$td_td]] ?></textarea>
        <?php $td_td++;
    }
    // ↑ Создание textarea для обычного пользователя ↑
    ?></td>