<div class = 'modal fade' id = 'edit' style = 'color: black; margin-top: 40px; margin-bottom: 36px;'>
    <div class = 'modal-dialog'>
        <div class = 'modal-content'>
            <form method = "post">
                <div class = 'modal-header'>
                    <div style = 'font-size: 20px; font-weight: bold; text-align: center; cursor: default;'>
                        <?php if ($edit != '') { ?>Редактирование <?php if (!isset ($permissions)) { ?><span style = 'color: red;'>(запрещено)</span>
                        <?php } } else { ?>Добавление строки<?php } ?>
                    </div>
                </div>
                <div class = 'modal-body' style = 'text-align: left;'>
                    <?php
                    if ($edit != '')
                    {
                        if ($data[$edit] != '')
                        {
                            foreach ($data[$edit] as $key => $value)
                            {
                                if (isset ($permissions)) { if ($permissions[$key] == '+') { $enable = 'enabled'; } else { $enable = 'disabled'; } }
                                else { $enable = 'readonly'; }
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
                                                        <div class = 'col-lg-2' style = 'padding-left: 0; padding-right: 6px;'>
                                                            <select class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
                                                                echo "<option>Год</option>";
                                                                for ($count = 2018; $count >= 2017; $count--)
                                                                {
                                                                    if ($count == (2000 + $year_select)) { $selected = 'selected'; } else { $selected = ''; }
                                                                    echo "<option {$selected}>$count</option>";
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                                            <select class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
                                                                echo "<option>Месяц</option>";
                                                                for ($count = 1; $count <= 12; $count++)
                                                                {
                                                                    if ($count < 10) { $count = '0'.$count; }
                                                                    if ($count == $month_select) { $selected = 'selected'; } else { $selected = '';  }
                                                                    echo "<option {$selected}>$month[$count]</option>";
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                                            <select class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
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
                                                            <select class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
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
                                                            <select class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
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
                                                            <select disabled class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><option>Сек.</option></select>
                                                        </div>
                                                    </div>
                                                </div><?php $foreach_check = true;
                                            }
                                            elseif (($foreach_check == false) && ($foreach_count == count($date_and_time_cell)))
                                            { ?><input <?= $enable ?> type = 'text' name = 'text-<?= $edit.'-'.$key ?>' value = '<?= $value ?>' autocomplete = 'off' class = 'form-control' style = 'margin-bottom: 5px;'><?php }
                                        }
                                    } else { ?>
                                        <input <?= $enable ?> type = 'text' name = 'text-<?= $edit.'-'.$key ?>' value = '<?= $value ?>' autocomplete = 'off' class = 'form-control' style = 'margin-bottom: 5px;'>
                                    <?php }
                                }
                            }
                        }
                    }
                    else
                    {
                        $title = $TABLE->all_title($_GET['project']);
                        if ($title != '')
                        {
                            foreach ($title as $key => $value)
                            {
                                if ($key != 'id')
                                { ?>
                                    <label style = 'font-size: 12px; margin-top: 5px; margin-bottom: 0; margin-left: 2px;'><?= $value ?></label>
                                    <div style = '100%;'>
                                    <?php
                                    $select_width = ''; $text_width = '';
                                    if ($macro['autocomplete'] == 'true')
                                    {
                                        if ($key == $macro['autocomplete_cell'])
                                        {
                                            $select_width = 'width: 100px; float: left;';
                                            $text_width = 'margin-left: 10px; width: calc(100% - 110px); float: left;';
                                            $list = explode(",","{$macro['autocomplete_text']}");
                                            echo "<select  name = 'select- -{$key}' style = '{$select_width}' class = 'form-control'>";
                                            foreach ($list as $n_key => $n_value)
                                            { echo "<option>{$n_value}</option>"; }
                                            echo "</select>";
                                        }
                                    }
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
                                                ?>
                                                <div class = 'container-fluid'>
                                                    <div class = 'row'>
                                                        <div class = 'col-lg-2' style = 'padding-left: 0; padding-right: 6px;'>
                                                            <select class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
                                                                echo "<option>Год</option>";
                                                                for ($count = 2018; $count >= 2017; $count--)
                                                                {
                                                                    if ($count == 2018) { $selected = 'selected'; } else { $selected = ''; }
                                                                    echo "<option {$selected}>$count</option>";
                                                                }
                                                                ?></select>
                                                        </div>
                                                        <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                                            <select class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
                                                                echo "<option>Месяц</option>";
                                                                for ($count = 1; $count <= 12; $count++)
                                                                {
                                                                    if ($count < 10) { $count = '0'.$count; }
                                                                    echo "<option>$month[$count]</option>";
                                                                }
                                                                ?></select>
                                                        </div>
                                                        <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                                            <select class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
                                                                echo "<option>День</option>";
                                                                for ($count = 1; $count <= 31; $count++)
                                                                {
                                                                    if ($count < 10) { $count = '0'.$count; }
                                                                    echo "<option>$count</option>";
                                                                }
                                                                ?></select>
                                                        </div>
                                                        <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                                            <select class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
                                                                echo "<option>Час</option>";
                                                                for ($count = 0; $count <= 23; $count++)
                                                                {
                                                                    if ($count < 10) { $count = '0'.$count; }
                                                                    echo "<option>$count</option>";
                                                                }
                                                                ?></select>
                                                        </div>
                                                        <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                                            <select class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><?php
                                                                echo "<option>Мин.</option>";
                                                                for ($count = 0; $count <= 55; $count = $count + $interval_m)
                                                                {
                                                                    if ($count < 10) { $count = '0'.$count; }
                                                                    echo "<option>$count</option>";
                                                                }
                                                                ?></select>
                                                        </div>
                                                        <div class = 'col-lg-2' style = 'padding-left: 3px; padding-right: 3px;'>
                                                            <select disabled class = 'form-control' style = 'padding-left: 5px; padding-right: 5px;'><option>Сек.</option></select>
                                                        </div>
                                                    </div>
                                                </div><?php $foreach_check = true;
                                            }
                                            elseif (($foreach_check == false) && ($foreach_count == count($date_and_time_cell)))
                                            { ?>
                                                <input type = 'text' name = 'text-<?= '-'.$key ?>' autocomplete = 'off' class = 'form-control' style = 'margin-bottom: 5px; <?= $text_width ?>'>
                                            <?php }
                                        }
                                    }
                                    else { ?>
                                        <input type = 'text' name = 'text-<?= '-'.$key ?>' autocomplete = 'off' class = 'form-control' style = 'margin-bottom: 5px; <?= $text_width ?>'>
                                    <?php } echo '</div>';
                                }
                            }
                        }
                    }
                    ?>
                </div>
                <div class = 'modal-footer'>
                    <input type = 'hidden' id = 'hidden' name = 'hidden'>
                    <?php
                    if ($edit != '')
                    {
                        if (isset ($permissions)) { ?><input type = 'submit' class = 'btn btn-success' value = 'Сохрантить' name = 'edit'><?php }
                        if ($permission_status == 'superuser') { ?><input type = 'submit' class = 'btn btn-danger' value = 'Удалить' name = 'del'><?php }
                    } else { ?><input type = 'submit' class = 'btn btn-success' value = 'Добавить' name = 'add_tr'><?php }
                    ?>
                    <button type = 'button' class = 'btn btn-default' data-dismiss = 'modal'>Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>