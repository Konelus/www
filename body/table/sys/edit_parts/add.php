<?php
    $title = $TABLE->all_title($_GET['project']);
    if ($title != '')
    {
        if ($macro['autocomplete'] == 'true')
        {
            $DB->select("{$additional_title[0]}","{$_GET['project']}_additional_autocomplete");
            if ($DB->sql_query_select != '')
            {
                while ($row = mysqli_fetch_row($DB->sql_query_select))
                { $additional_ac_title[] = $row[0]; }
            }


            for ($count = 1; $count <= $macro['autocomplete_count']; $count++)
            {
                $autocomplete[$macro["autocomplete_{$count}"]]['name'] = $macro["autocomplete_{$count}"];
                $autocomplete[$macro["autocomplete_{$count}"]]['store'] = $macro["autocomplete_{$count}_store"];
                $autocomplete[$macro["autocomplete_{$count}"]]['value'] = $macro["autocomplete_{$count}_value"];
                $autocomplete[$macro["autocomplete_{$count}"]]['type'] = $macro["autocomplete_{$count}_type"];
            }
        }


        foreach ($title as $key => $value)
        {
            if ($key != 'id')
            { ?>
                <label style = 'font-size: 12px; margin-top: 5px; margin-bottom: 0; margin-left: 2px;'><?= $value ?></label>
                <div style = '100%;'>
                <?php

                if (($macro['additional_autocomplete'] == 'true') && (!isset ($_POST['autocomplete'])))
                {
                    foreach ($additional_title as $k_kay => $k_value)
                    {
                         if ($additional_title[0] != $k_value)
                         {
                              if ($key == $k_value)
                              {
                                   $enable = 'disabled';
                                   $val = 'Поле будет заполнено автоматически';
                                   break;
                              }
                              else
                              { $val = ''; $enable = 'enabled'; }
                         }
                    }
                }

                $select_width = ''; $text_width = '';


                if ($macro['date_and_time'] == 'true')
                {
                    $date_and_time_cell = explode(",","{$macro['date_and_time_cell']}");
                    $month = ['01' => 'Январь', '02' => 'Февраль', '03' => 'Март', '04' => 'Апрель', '05' => 'Май', '06' => 'Июнь', '07' => 'Июль', '08' => 'Август', '09' => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'];
                    list($interval_h, $interval_m) = explode(".","{$macro['time_interval']}");
                    $foreach_count = 0;
                    $foreach_check = false;
                    foreach($date_and_time_cell as $a_key => $a_value)
                    {
                        $foreach_count++;
                        if ($a_value == $key)
                        { ?>
                            <div class = 'container-fluid'>
                                <div class = 'row'>
                                    <div class = 'col-lg-1' style = 'padding-left: 3px; padding-right: 3px;'></div>
                                    <div class = 'col-lg-2' style = 'padding-left: 0; padding-right: 6px;'>
                                        <select <?= $enable ?> name = 'select-<?= $a_key ?>-1-<?= $key ?>' class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
                                        echo "<option>День</option>";
                                        for ($count = 1; $count <= 31; $count++)
                                        {
                                            if ($count < 10) { $count = '0'.$count; }
                                            echo "<option>$count</option>";
                                        }
                                        ?></select>
                                    </div>
                                    <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                        <select <?= $enable ?> name = 'select-<?= $a_key ?>-2-<?= $key ?>' class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
                                        echo "<option>Месяц</option>";
                                        for ($count = 1; $count <= 12; $count++)
                                        {
                                            if ($count < 10) { $count = '0'.$count; }
                                            echo "<option>$month[$count]</option>";
                                        }
                                        ?></select>
                                    </div>
                                    <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                        <select <?= $enable ?> name = 'select-<?= $a_key ?>-3-<?= $key ?>' class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
                                        echo "<option>Год</option>";
                                        for ($count = 2019; $count >= 2018; $count--)
                                        {
                                            if ($count == 2019) { $selected = 'selected'; } else { $selected = ''; }
                                            echo "<option {$selected}>$count</option>";
                                        }
                                        ?></select>
                                    </div>
                                    <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                        <select <?= $enable ?> name = 'select-<?= $a_key ?>-4-<?= $key ?>' class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
                                        echo "<option>Час</option>";
                                        for ($count = 0; $count <= 23; $count++)
                                        {
                                            if ($count < 10) { $count = '0'.$count; }
                                            echo "<option>$count</option>";
                                        }
                                        ?></select>
                                    </div>
                                    <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                        <select <?= $enable ?> name = 'select-<?= $a_key ?>-5-<?= $key ?>' class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
                                        echo "<option>Мин.</option>";
                                        for ($count = 0; $count <= 55; $count = $count + $interval_m)
                                        {
                                            if ($count < 10) { $count = '0'.$count; }
                                            echo "<option>$count</option>";
                                        }
                                        ?></select>
                                    </div>
                                    <div class = 'col-lg-1' style = 'padding-left: 3px; padding-right: 3px;'></div>
                                </div>
                            </div><?php $foreach_check = true;
                        }
                    }
                }
                if ($macro['autocomplete'] == 'true')
                {
                    $ac_check = false;
                    foreach ($autocomplete as $zz_key => $zz_value)
                    {
                        //echo $key.' == '.$zz_value['name'].'<br>';
                        if ($zz_value['name'] == $key)
                        { $ac_check = true; }
                    }


                    if ($ac_check == true)
                    {
                        if ($autocomplete[$key]['type'] == 'datalist')
                        { ?>
                            <div class="input-group">
                                <input autocomplete = "off" list="list" name = 'text-<?= '-'.$key ?>' type="text" class="form-control" aria-describedby="basic">
                                <span class="input-group-addon" id="basic">Поле выбора</span>
                            </div>
                            <datalist id="list">
                        <?php }
                        elseif ($autocomplete[$key]['type'] == 'select')
                        {
                            $select = explode(",","{$autocomplete[$key]['value']}");
                            ?><select name = 'text-<?= '-'.$key ?>' class = 'form-control'><?php
                        }

                        if ($autocomplete[$key]['store'] == 'sql')
                        {
                            foreach ($additional_ac_title as $q_key => $q_value)
                            {
                                if ($q_value != '')
                                echo "<option>{$q_value}</option>";
                            }
                        }
                        elseif ($autocomplete[$key]['store'] == 'this')
                        {
                            $select = explode(",","{$autocomplete[$key]['value']}");
                            foreach ($select as $qz_key => $qz_value)
                            {
                                echo "<option>{$qz_value}</option>";
                            }
                        }

                        if ($autocomplete[$key]['type'] == 'datalist')
                        { echo '</datalist>'; }
                        elseif ($autocomplete[$key]['type'] == 'select')
                        { echo '</select>'; }

                    }
                    else
                    {
                        if ($date_and_time_cell != '')
                        {
                            $check_time = false;
                            foreach ($date_and_time_cell as $n_key => $n_value)
                            {
                                //echo "{$key} == {$n_value}<br>";
                                if ($key == $n_value) { $check_time = false; break; }
                                else { $check_time = true; }
                            }
                            //pre($check_time);
                        }
                        //pre($check_time);
                        else { $check_time = true; }

                        if ($check_time == true)
                        { ?><input value = '<?= $val ?>' <?= $enable ?> type = 'text' name = 'text-<?= '-'.$key ?>' autocomplete = 'off' class = 'form-control' style = 'margin-bottom: 5px; <?= $text_width ?>'><?php } }

                }
                else
                { //pre($enable);?>
                <input value = '<?= $val ?>' <?= $enable ?> type = 'text' name = 'text-<?= '-'.$key ?>' autocomplete = 'off' class = 'form-control' style = 'margin-bottom: 5px; <?= $text_width ?>'>
            <?php } echo '</div>';

            }
        }
    }
?>