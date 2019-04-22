<?php
$data = $CHECK->check_select($id);
$title = $CHECK->check_select_title();




    if ($data != '')
    {
        foreach ($data as $key => $value)
        {

            if ($key != 'id')
            {?>
                <label style = 'font-size: 12px; margin-top: 5px; margin-bottom: 0; margin-left: 2px;'><?= $title[$key] ?></label>
                <?php
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
                        {
                            list($dmy, $hm) = explode(" ",trim($value));
                            list($day_select, $month_select, $year_select) = explode(".","{$dmy}");
                            list($hour_select, $minute_select) = explode(":","{$hm}"); ?>
                            <div class = 'container-fluid'>
                            <div class = 'row'>
                                <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                    <select <?= $enable ?> name = 'select-<?= $a_key ?>-1-<?= $key ?>-<?= $id ?>' class = 'form-control' style = 'cursor: pointer; padding-left: 5px; padding-right: 5px;'><?php
                                        echo "<option>День</option>";
                                        for ($count = 1; $count <= 31; $count++)
                                        {
                                            if ($count < 10) { $count = '0'.$count; }
                                            if ($count == $day_select) { $selected = 'selected'; } else { $selected = '';  }
                                            echo "<option {$selected}>$count</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                    <select <?= $enable ?> name = 'select-<?= $a_key ?>-2-<?= $key ?>-<?= $id ?>' class = 'form-control' style = 'cursor: pointer; padding-left: 5px; padding-right: 5px;'><?php
                                        echo "<option>Месяц</option>";
                                        for ($count = 1; $count <= 12; $count++)
                                        {
                                            if ($count < 10) { $count = '0'.$count; }
                                            if ($count == $month_select) { $selected = 'selected'; } else { $selected = '';  }
                                            echo "<option {$selected}>$month[$count]</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class = 'col-lg-2' style = 'padding-left: 0; padding-right: 6px;'>
                                    <select <?= $enable ?> name = 'select-<?= $a_key ?>-3-<?= $key ?>-<?= $id ?>' class = 'form-control' style = 'cursor: pointer; padding-left: 5px; padding-right: 5px;'><?php
                                        echo "<option>Год</option>";
                                        for ($count = 2019; $count >= 2018; $count--)
                                        {
                                            if ($count == $year_select) { $selected = 'selected'; } else { $selected = ''; }
                                            echo "<option {$selected}>$count</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                    <select <?= $enable ?> name = 'select-<?= $a_key ?>-4-<?= $key ?>-<?= $id ?>' class = 'form-control' style = 'cursor: pointer; padding-left: 5px; padding-right: 5px;'><?php
                                        echo "<option>Час</option>";
                                        for ($count = 0; $count <= 23; $count++)
                                        {
                                            if ($count < 10) { $count = '0'.$count; }
                                            if ($count == $hour_select) { $selected = 'selected'; } else { $selected = '';  }
                                            echo "<option {$selected}>$count</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                    <select <?= $enable ?> name = 'select-<?= $a_key ?>-5-<?= $key ?>-<?= $id ?>' class = 'form-control' style = 'cursor: pointer; padding-left: 5px; padding-right: 5px;'><?php
                                        echo "<option>Мин.</option>";
                                        $count_check = false;
                                        for ($count = 0; $count <= 55; $count = $count + $interval_m)
                                        {
                                            if ($count < 10) { $count = '0'.$count; }
                                            if ($count == $minute_select)
                                            { $selected = 'selected'; $count_check = true; } else { $selected = ''; }
                                            echo "<option {$selected}>$count</option>";
                                        }
                                        if (($count_check == false) && ($minute_select != '')) { echo "<option selected>$minute_select</option>"; } ?>
                                    </select>
                                </div>
                                <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                    <select <?= $enable ?> disabled class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><option>Сек.</option></select>
                                </div>
                            </div>
                            </div><?php $foreach_check = true;
                        }
                        elseif (($foreach_check == false) && ($foreach_count == count($date_and_time_cell)))
                        { ?><input <?= $enable ?> type = 'text' name = 'text-<?= $id.'-'.$key ?>' value = '<?= $value ?>' autocomplete = 'off' class = 'form-control' style = 'cursor: text; margin-bottom: 5px;'><?php }
                    }
                } else { ?>
                    <input <?= $enable ?> type = 'text' name = 'text-<?= $id.'-'.$key ?>' value = '<?= $value ?>' autocomplete = 'off' class = 'form-control' style = 'cursor: text; margin-bottom: 5px;'>
                <?php }
            }
        }
    }
?>