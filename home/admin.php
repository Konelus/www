<script>
    var all_users = <?= json_encode($all_users); ?>;
    var users_permission = <?= json_encode($users_permission); ?>;
    var all_users_group = <?= json_encode($all_users_group); ?>;
    var all_group = <?= json_encode($all_group); ?>;

    var all_users_count = <?= json_encode($all_user_count); ?>;
    var users_permission_count = <?= json_encode($ege_user_count); ?>;
    var all_user_group_count = <?= json_encode($all_user_group_count); ?>;
    var all_group_count = <?= json_encode($all_group_count); ?>;
</script>

<?php
    $table_count = 0;
    $SQL_QUERY_select_table = $mysqli->query("SELECT * FROM  `tables_namespace` WHERE `released` = '+' ");
    while ($row = mysqli_fetch_row($SQL_QUERY_select_table))
    {
        $table_name[$table_count] = $row[1];
        $table_description[$table_count] = $row[2];
        $table_count++;
    }


?>

<script src="/home/sys/users.js"></script>

        <div class = 'container-fluid text_cursor'>
            <div class = 'row'>
                <div class = 'col-lg-2'></div>
                <div class = 'col-lg-6 table_margin'>
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
                <div class = 'col-lg-2'>
                    <form method = "post">
                        <table class = 'table table_margin'>
                            <tbody>
                                <tr><td class = 'users_main_td' colspan = '2'>Удаление пользователя</td><tr>
                                <tr><td class = 'users_td_label'>Логин</td>
                                    <td class = 'users_td_text_align'><select  name = 'del_user_name' class = 'form-control select_cursor'><script>users();</script></select></td></tr>
                                <tr><td colspan = '2'><input name = 'del_user' value = 'Удалить' class = 'btn button' type = 'submit'></td></tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class = 'col-lg-2'></div>
            </div>
        </div>
        <div class = 'container-fluid text_cursor'>
            <div class = 'row'>
                <div class = 'col-lg-2'></div>
                <div class = 'col-lg-2'>
                    <form method = "post">
                        <table class = 'table'>
                            <tr><td class = 'users_main_td' colspan = '2'>Добавление группы</td><tr>
                            <tr><td class = 'users_td_label'>Название</td>
                                <td class = 'users_td_text_align'><input autocomplete = "off"  name = 'group_name' type = 'text' class = 'form-control text_box_border'></td></tr>
                            <tr><td colspan = '2'><input name = 'add_group' value = 'Добавить' class = 'btn button' type = 'submit'></td></tr>
                        </table>
                    </form>
                    <form method = "post">
                        <table class = 'table'>
                            <tr><td class = 'users_main_td' colspan = '2'>Удаление группы</td><tr>
                            <tr><td class = 'users_td_label'>Название</td>
                                <td class = 'users_td_text_align'><select name = 'del_group_name' class = 'form-control select_cursor'><script>groups();</script></select></td></tr>
                            <tr><td colspan = '2'><input name = 'del_group' value = 'Удалить' class = 'btn button' type = 'submit'></td></tr>
                        </table>
                    </form>
                </div>
                <div class = 'col-lg-2'>
                    <form method = "post">
                        <table class = 'table'>
                            <tr><td class = 'users_main_td' colspan = '2'>Группы пользователей</td>
                            <tr>
                                <td class = 'users_td_label'>Логин</td>
                                <td><select name = 'selected_user' class = 'form-control select_cursor'><script>users();</script></select></td>
                            </tr>
                            <tr>
                                <td class = 'users_td_label'>Группа</td>
                                <td><select name = 'selected_group' class = 'form-control select_cursor'><script>groups();</script></select></td>
                            </tr>
                            <tr><td colspan = '2'><input name = 'edit_users_group' value = 'Изменить' class = 'btn button' type = 'submit'></td></tr>
                        </table>
                    </form>
                </div>
                <div class = 'col-lg-2'>
                    <form method = "post">
                        <table class = 'table'>
                            <tr><td class = 'users_main_td' colspan = '2'>Привязка группы к таблице</td>
                            <tr>
                                <td class = 'users_td_label'>Группа</td>
                                <td><select name = 'selected_group' class = 'form-control select_cursor'><script>groups();</script></select></td>
                            </tr>
                            <tr>
                                <td class = 'users_td_label'>Таблицы</td>
                                <td><select name = 'selected_table' class = 'form-control select_cursor'>
                                        <?php
                                            foreach ($table_name_array as $key => $table_name)
                                            { echo "<option>{$table_name[0]}</option>"; }
                                        ?>
                                    </select></td>
                            </tr>
                            <tr>
                                <td class = 'users_td_label'>Права</td>
                                <td><select name = 'selected_type' class = 'form-control select_cursor'><option>user</option><option>superuser</option><option>readonly</option></select></td>
                            </tr>
                            <tr><td colspan = '2'><input name = 'group_to_table' value = 'Изменить' class = 'btn button' type = 'submit'></td></tr>
                        </table>
                    </form>
                </div>
                <div class = 'col-lg-2'>
                    <form method = "post">
                        <table class = 'table'>
                            <tr><td class = 'users_main_td' colspan = '2'>Отвязка группы от таблицы</td>
                            <tr>
                                <td class = 'users_td_label'>Группа</td>
                                <td><select name = 'selected_del_group' class = 'form-control select_cursor'><script>groups();</script></select></td>
                            </tr>
                            <tr>
                                <td class = 'users_td_label'>Таблицы</td>
                                <td><select name = 'selected_del_table' class = 'form-control select_cursor'>
                                    <?php
                                        foreach ($table_name_array as $key => $table_name)
                                        { echo "<option>{$table_name[0]}</option>"; }
                                    ?>
                                    </select></td>
                            </tr>
                            <tr><td colspan = '2'><input name = 'group_to_table_del' value = 'Изменить' class = 'btn button' type = 'submit'></td></tr>
                        </table>
                    </form>
                </div>
                <div class = 'col-lg-2'></div>
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

<div class = 'container-fluid text_cursor div_margin div_padding'>
    <div class = 'row'>
        <div class = 'col-lg-4'></div>
        <div class = 'col-lg-4' style = 'padding-top: 20px;'>
            <div style = 'border: solid 1px black;'>
                <div style = 'height: 35px; background: black; text-align: center; color: white; padding-top: 5px;'>Скрипты</div>
                <div style = 'width: 80%; margin: auto; height: 60px;'>
                    <?php
                        require_once ($_SERVER['DOCUMENT_ROOT'].'/scripts/config_script/script.php');
                        require_once ($_SERVER['DOCUMENT_ROOT'].'/scripts/clone_script/script.php');
                    ?>
                </div>
            </div>
            <div style = 'text-align: center; font-weight: bold; color: lightgreen; width: 100%;'><?= $text ?></div>
        </div>
        <div class = 'col-lg-4'></div>
    </div>
</div>



