<?php
    require_once ($_SERVER['DOCUMENT_ROOT'].'/home/sys/admin_sys.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/home/sys/group_query.php');
?>

<div class = 'container-fluid text_cursor'>
    <div class = 'row'>
        <div class = 'col-lg-12'>
            <div class = 'col-lg-1'></div>
            <div class = 'col-lg-6' style ='padding-left: 0; padding-right: 0;'>
                <div class = 'col-lg-12 table_margin'>
                    <form method = "post">
                        <table class = 'table'>
                            <tr><td class = 'users_main_td' colspan = '7'>Добавление пользователя</td><tr>
                                <td class = 'users_td_label'>Логин</td>
                                <td class = 'users_td_label'>Пароль</td>
                                <td class = 'users_td_label'>ФИО</td>
                                <td class = 'users_td_label'>Должность</td>
                                <td class = 'users_td_label'>Телефон</td>
                                <td class = 'users_td_label'>mail</td>
                                <td rowspan = '2'><div class = 'div_margin'><input style = 'width: 100px;' name = 'add_user' value = 'Добавить' class = 'btn button' type = 'submit'></div>
                            </tr>
                            <tr>
                                <td class = 'users_td_text_align'><input autocomplete = "off" name = 'login' type = 'text' class = 'form-control text_box_border'></td>
                                <td class = 'users_td_text_align'><input autocomplete = "off" name = 'password' type = 'text' class = 'form-control text_box_border'></td>
                                <td class = 'users_td_text_align'><input autocomplete = "off" name = 'fio' type = 'text' class = 'form-control text_box_border'></td>
                                <td class = 'users_td_text_align'><input autocomplete = "off" name = 'position' type = 'text' class = 'form-control text_box_border'></td>
                                <td class = 'users_td_text_align'><input autocomplete = "off" name = 'phone' type = 'text' class = 'form-control text_box_border'></td>
                                <td class = 'users_td_text_align'><input autocomplete = "off" name = 'mail' type = 'text' class = 'form-control text_box_border'></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class = 'col-lg-12' style = 'margin-top: 15px;'>
                    <div class = 'col-lg-4' style = 'padding-left: 0;'>
                        <form method = "post">
                            <table class = 'table'>
                                <tr><td class = 'users_main_td' colspan = '2'>Добавление группы</td><tr>
                                <tr>
                                    <td class = 'users_td_label'>Название</td>
                                    <td class = 'users_td_text_align'><input autocomplete = "off"  name = 'group_name' type = 'text' class = 'form-control text_box_border'></td>
                                </tr>
                                <tr><td colspan = '2'><input name = 'add_group' value = 'Добавить' class = 'btn button' type = 'submit'></td></tr>
                            </table>
                        </form>
                        <form method = "post">
                            <table class = 'table'>
                                <tr><td class = 'users_main_td' colspan = '2'>Удаление группы</td><tr>
                                <tr>
                                    <td class = 'users_td_label'>Название</td>
                                    <td class = 'users_td_text_align'><select name = 'del_group_name' class = 'form-control select_cursor'><?php foreach ($all_group as $key => $value) { echo "<option>$value</option>"; } ?></select></td>
                                </tr>
                                <tr><td colspan = '2'><input name = 'del_group' value = 'Удалить' class = 'btn button' type = 'submit'></td></tr>
                            </table>
                        </form>
                    </div>
                    <div class = 'col-lg-4' style = 'padding-left: 5px; padding-right: 5px;'>
                        <form method = "post">
                            <table class = 'table'>
                                <tr><td class = 'users_main_td' colspan = '2'>Группы пользователей</td>
                                <tr>
                                    <td class = 'users_td_label'>Логин</td>
                                    <td><select name = 'selected_user' class = 'form-control select_cursor'><?php foreach ($all_users as $key => $value) { if ($value != 'admin') { echo "<option>$value</option>"; } } ?></select></td>
                                </tr>
                                <tr>
                                    <td class = 'users_td_label'>Группа</td>
                                    <td><select name = 'selected_group' class = 'form-control select_cursor'><?php foreach ($all_group as $key => $value) { echo "<option>$value</option>"; } ?></select></td>
                                </tr>
                                <tr><td colspan = '2'><input name = 'edit_users_group' value = 'Изменить' class = 'btn button' type = 'submit'></td></tr>
                            </table>
                        </form>
                    </div>
                    <div class = 'col-lg-4' style = 'padding-right: 0;'>
                        <form method = "post">
                            <table class = 'table'>
                                <tr><td class = 'users_main_td' colspan = '2'>Привязка группы к таблице</td>
                                <tr>
                                    <td class = 'users_td_label'>Группа</td>
                                    <td><select name = 'selected_group' class = 'form-control select_cursor'><?php foreach ($all_group as $key => $value) { echo "<option>$value</option>"; } ?></select></td>
                                </tr>
                                <tr>
                                    <td class = 'users_td_label'>Таблицы</td>
                                    <td>
                                        <select name = 'selected_table' class = 'form-control select_cursor'>
                                            <?php foreach ($released_table as $key => $value) { echo "<option>{$value[2]}</option>"; } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class = 'users_td_label'>Права</td>
                                    <td><select name = 'selected_type' class = 'form-control select_cursor'><option>user</option><option>superuser</option><option>readonly</option></select></td>
                                </tr>
                                <tr><td colspan = '2'><input name = 'group_to_table' value = 'Изменить' class = 'btn button' type = 'submit'></td></tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class = 'col-lg-2' style ='padding-left: 5px; padding-right: 5px;'>
                <div class = 'col-lg-12' style ='padding-left: 0; padding-right: 0;'>
                    <form method = "post">
                        <table class = 'table table_margin'>
                            <tbody>
                            <tr><td class = 'users_main_td' colspan = '2'>Удаление пользователя</td><tr>
                            <tr>
                                <td class = 'users_td_label'>Логин</td>
                                <td class = 'users_td_text_align'><select  name = 'del_user_name' class = 'form-control select_cursor'><?php foreach ($all_users as $key => $value) { if ($value != 'admin') { echo "<option>$value</option>"; } } ?></select></td>
                            </tr>
                            <tr><td colspan = '2'><input name = 'del_user' value = 'Удалить' class = 'btn button' type = 'submit'></td></tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class = 'col-lg-12' style ='padding-left: 0; padding-right: 0; margin-top: 2px;'>
                    <form method = "post">
                        <table class = 'table'>
                            <tr><td class = 'users_main_td' colspan = '2'>Отвязка группы от таблицы</td>
                            <tr>
                                <td class = 'users_td_label'>Группа</td>
                                <td><select name = 'selected_del_group' class = 'form-control select_cursor'><?php foreach ($all_group as $key => $value) { echo "<option>$value</option>"; } ?></select></td>
                            </tr>
                            <tr>
                                <td class = 'users_td_label'>Таблицы</td>
                                <td><select name = 'selected_del_table' class = 'form-control select_cursor'><?php foreach ($released_table as $key => $value) { echo "<option>{$value[2]}</option>"; } ?></select></td>
                            </tr>
                            <tr><td colspan = '2'><input name = 'group_to_table_del' value = 'Изменить' class = 'btn button' type = 'submit'></td></tr>
                        </table>
                    </form>
                </div>
            </div>
            <div class = 'col-lg-2' style ='padding-left: 15px; padding-right: 0;'>
                <div class = 'users_main_td' style = 'margin-top: 25px; padding-top: 8px; padding-bottom: 8px; border-left: solid 1px black; border-right: 1px;'>Скрипты</div>
                <div style = 'width: 100%; margin: auto; border: solid 1px black; border-top: 0;'>
                    <?php
                        $script_tables = scandir($_SERVER['DOCUMENT_ROOT'].'/scripts/bar');
                        foreach ($script_tables as $key => $value)
                        {
                            if (($value == '.') || ($value == '..')) { unset($script_tables[$key]); }
                            else
                            {
                                $script_tables[$key - 2] = $script_tables[$key];
                                unset($script_tables[$key]);
                                $scripts[$key - 2] = scandir($_SERVER['DOCUMENT_ROOT']."/scripts/bar/{$value}");
                                for ($count = 0; $count <= ($key - 2); $count++)
                                {
                                    foreach ($scripts[$count] as $s_key => $s_value)
                                    {
                                        if (($s_value == '.') || ($s_value == '..')) { unset($scripts[$count][$s_key]); }
                                        if ($s_value == 'description.txt')
                                        {
                                            $description = fopen($_SERVER['DOCUMENT_ROOT']."/scripts/bar/{$value}/{$scripts[$count][$s_key]}","r");
                                            $table_name[$count] = fread($description,"100");
                                            fclose($description);
                                            unset($scripts[$count][$s_key]);
                                        }
                                    }
                                }
                            }
                        }
                        foreach ($scripts as $require_key => $require_value)
                        {
                            echo "<div style = 'width: 100%; padding-top: 2px; padding-bottom: 2px; background: #F8EFC0; text-align: center; border-top: solid 1px black; border-bottom: solid 1px black;'>{$table_name[$require_key]}</div>";
                            foreach ($scripts[$require_key] as $n_key => $n_value)
                            { require_once($_SERVER['DOCUMENT_ROOT']."/scripts/bar/{$script_tables[$require_key]}/{$n_value}/script.php"); }
                        }
                    ?>
                </div>
            </div>
            <div class = 'col-lg-1'></div>
        </div>
    </div>
</div>

<div class = 'container div_margin'>
    <div class = 'row'>
        <div class = 'col-lg-4'></div>
        <div class = 'col-lg-4'>
            <div style = 'font-size: 16px; text-align: center;'><a href = '/home/permissions.php' target = '_blank'>→ <span style = 'text-decoration: underline;'>Редактирование прав групп</span> ←</a></div>
            <div style = 'font-size: 16px; margin-top: 5px; text-align: center;'><a href = '/home/log.php' target = '_blank'>→ <span style = 'text-decoration: underline;'>История действий пользователей</span> ←</a></div>
        </div>
        <div class = 'col-lg-4'></div>
    </div>
</div>




