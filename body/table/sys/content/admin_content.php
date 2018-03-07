<?php
if ($td == 1)
{ ?>
     <td style = 'width: 150px;'>
         <div style = 'text-align: center; margin-top: 10px;'>
             <input name = 'add_in_vision_text_<?= $tr0 ?>' type = 'text' style = 'border: solid 1px black; width: 120px;'>
             <input name = 'add_in_vision_submit_<?= $tr0 ?>' type = 'submit' value = 'Добавить' style = 'border: solid 1px black; background: gold;margin-top: 5px; height: 24px;'>
         </div>
     </td>
     <td style = 'width: 150px;'>
         <div style = 'text-align: center; width: 150px;'></div>
     </td>
<?php }
else if ($td > 1) { ?>
<td style='min-width: 150px; <?= $height ?>' class='<?= "{$class_color} {$ready}" ?>'><?php
    // ↓ Заполнение таблицы данными ↓
    if ($bool_var_2 == 0)
    {
        if ($title[$tr][$new_td[$td_td]] == 'Online Test')
        { $parsed_title = "<a target = '_blank' href = '/body/table/additional_table.php/?{$substring}/{$title[$tr][0]}'>{$title[$tr][$new_td[$td_td]]}</a>"; }
        else if ($title[$tr][$new_td[$td_td]] != 'Online Test')
        { $parsed_title = $title[$tr][$new_td[$td_td]]; }
        ?><div style = '<?= $height ?> max-height: 100px; overflow: hidden;'><?= $parsed_title; ?></div><?php
        $td_td++;
    }
    // ↑ Заполнение таблицы данными ↑


    // ↓ Создание textarea ↓

    else if ($bool_var_2 == 1)
    { ?>
<!--        <div style = 'height: 0px; background: black; color: white; margin-bottom: 2px;'>--><?//= $title_array[$td - 2][0] ?><!--</div>-->
        <textarea
            name = 'editBox_<?= $tr.'_'.($td - 1) ?>'
            style = 'height: 100px; padding: 0; font-size: 10px; text-align: center; border: solid 1px black; width: 100%;'
            class = 'form-control <?= $ready ?>'
            autocomplete = 'off'><?= $title[$tr][$new_td[$td_td]] ?></textarea><?php $td_td++;
    }
    // ↑ Создание textarea ↑
    }
?></td>
