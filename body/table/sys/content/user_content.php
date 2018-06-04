<td style='min-width: 150px; <?= $height ?>' class='<?= "{$class_color} {$ready}" ?>'><?php
    // ↓ Заполнение таблицы данными ↓
    if ($bool_var_2 == false)
    {
        if ($title[$tr][$new_td[$td_td]] == 'Online Test')
<<<<<<< HEAD
        { $parsed_title = "<a target = '_blank' href = '/body/table/additional_table.php/?{$substring}/{$title[$tr][0]}'>{$title[$tr][$new_td[$td_td]]}</a>"; }
=======
        { $parsed_title = "<a target = '_blank' href = '/body/table/additional_table.php/?{$podcat_name[1]}/{$title[$tr][0]}'>{$title[$tr][$new_td[$td_td]]}</a>"; }
>>>>>>> 48fa31c38613c885e95021083a26ab15ea06d4e6
        else if ($title[$tr][$new_td[$td_td]] != 'Online Test')
        { $parsed_title = $title[$tr][$new_td[$td_td]]; }
        ?><div style = 'min-width: 150px; ; overflow: hidden;'>
        <?php if ($substring_table[$new_td[$td_td]] == 'load_file')
    {
        if ($parsed_title != '')
        {
            $parsed_title_array = explode("\n","{$parsed_title}");
            $count = 0;
            foreach ($parsed_title_array as $key => $value)
            { $count++; }
            $parsed_title = "<a href = '/body/sys/file.php?{$substring}/{$title[$tr][0]}' target = '_blank'>Прикрепелнные файлы ({$count})</a>";
        }
        if ($load_permissions == '+') {
        ?>
        <div style = 'margin-bottom: 5px; padding: 2px; border: solid 1px black; background: #5DE100;'>
            <input type = 'file' name = 'file_<?= $title[$tr][0] ?>'>
            <input type = 'submit' value = 'Сохранить' style = 'border: solid 1px black;' name = "file_save_<?= $title[$tr][0] ?>">
        </div>
    <?php } } echo $parsed_title ?>
        </div><?php $td_td++;
    }
    // ↑ Заполнение таблицы данными ↑



    // ↓ Создание textarea для обычного пользователя ↓
<<<<<<< HEAD
    else if ($bool_var_2 == true)
    {
        if ($substring_table[$new_td[$td_td]] == 'load_file')
        { $ro[$new_td[$td_td]] = 'readonly'; }
        ?>
=======
    else if ($bool_var_2 == 1)
    { ?>
>>>>>>> 48fa31c38613c885e95021083a26ab15ea06d4e6
<!--        <div style = 'height: 0px; background: black; color: white; margin-bottom: 2px;'>--><?//= $title_array[$td - 1][0] ?><!--</div>-->
        <textarea <?= $ro[$new_td[$td_td]] ?>
            name = 'editBox_<?= "{$tr}_{$new_td[$td_td]}" ?>'
            style = 'height: 100px; padding: 0; font-size: 10px; text-align: center; border: solid 1px black; width: 100%;'
            class = 'form-control <?= $ready ?>'
            autocomplete = 'off'><?= $title[$tr][$new_td[$td_td]] ?></textarea>
        <?php $td_td++;
    }
    // ↑ Создание textarea для обычного пользователя ↑
   ?></td>