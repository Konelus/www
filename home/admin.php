<script>
    var all_users = <?php echo json_encode($all_users); ?>;
    var users_permission = <?php echo json_encode($users_permission); ?>;
    var all_users_group = <?php echo json_encode($all_users_group); ?>;
    var all_group = <?php echo json_encode($all_group); ?>;

    var all_users_count = <?php echo json_encode($all_user_count); ?>;
    var users_permission_count = <?php echo json_encode($ege_user_count); ?>;
    var all_user_group_count = <?php echo json_encode($all_user_group_count); ?>;
    var all_group_count = <?php echo json_encode($all_group_count); ?>;
</script>

<?php
    require_once ($_SERVER['DOCUMENT_ROOT'].'/home/sys/group_query.php');

    if (isset ($_POST['clone']))
    {
        //$q = $mysqli->query("DELETE FROM `vibory_sys`");
        $SQL_QUERY_select_table1 = $mysqli->query("SELECT * FROM `vibory_sys`");
        while ($query_array = mysqli_fetch_array($SQL_QUERY_select_table1))
        {
            echo $query_array[0].' / ';
            $sys_td[$query_array[0]][1] = $query_array['id_obekta_skup'];
            $sys_td[$query_array[0]][2] = $query_array['adres_uik_tik'];
        }
        //print_r($sys_td);

        $SQL_QUERY_select_table2 = $mysqli->query("SELECT * FROM `vibory`");
        while ($query_table_array = mysqli_fetch_row($SQL_QUERY_select_table2))
        {
            //echo $sys_td[1][1].$query_table_array[0].' != '.$query_table_array[1];
            //break;

            if ($sys_td[$query_table_array[0]][1] != $query_table_array[1])
            { $SQL_QUERY_update_sys = $mysqli->query("UPDATE `vibory_sys` SET `id_obekta_skup` = '".$query_table_array['id_obekta_skup']."' WHERE `id` = $query_table_array[0] "); }

            if ($sys_td[$query_table_array[0]][2] != $query_table_array[2])
            { $SQL_QUERY_update_sys = $mysqli->query("UPDATE `vibory_sys` SET `adres_uik_tik` = '".$query_table_array['adres_uik_tik']."' "); }

            //$SQL_QUERY_update_sys = $mysqli->query("INSERT INTO `vibory_sys` values ('".$query_table_array[0]."', '".$query_table_array[1]."', '".$query_table_array[2]."', '".$query_table_array[39]."', '".$query_table_array[40]."') ");
        }
    }
?>

<script src="/home/sys/users.js"></script>

        <div class = 'container-fluid'>
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
                                    <td class = 'users_td_text_align'><select  name = 'del_user_name' class = 'form-control'><script>users();</script></select></td></tr>
                                <tr><td colspan = '2'><input name = 'del_user' value = 'Удалить' class = 'btn button' type = 'submit'></td></tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class = 'col-lg-2'></div>
            </div>
        </div>
        <div class = 'container-fluid'>
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
                                <td class = 'users_td_text_align'><select name = 'del_group_name' class = 'form-control'><script>groups();</script></select></td></tr>
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
                                <td><select name = 'selected_user' class = 'form-control'><script>users();</script></select></td>
                            </tr>
                            <tr>
                                <td class = 'users_td_label'>Группа</td>
                                <td><select name = 'selected_group' class = 'form-control'><script>groups();</script></select></td>
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
                                <td><select name = 'selected_group' class = 'form-control'><script>groups();</script></select></td>
                            </tr>
                            <tr>
                                <td class = 'users_td_label'>Таблицы</td>
                                <td><select name = 'selected_table' class = 'form-control'><option>vibory</option><option>schools</option></select></td>
                            </tr>
                            <tr>
                                <td class = 'users_td_label'>Права</td>
                                <td><select name = 'selected_type' class = 'form-control'><option>user</option><option>superuser</option><option>readonly</option></select></td>
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
                                <td><select name = 'selected_del_group' class = 'form-control'><script>groups();</script></select></td>
                            </tr>
                            <tr>
                                <td class = 'users_td_label'>Таблицы</td>
                                <td><select name = 'selected_del_table' class = 'form-control'><option>vibory</option><option>schools</option></select></td>
                            </tr>
                            <tr><td colspan = '2'><input name = 'group_to_table_del' value = 'Изменить' class = 'btn button' type = 'submit'></td></tr>
                        </table>
                    </form>
                    <div>
                        <?php require_once ($_SERVER['DOCUMENT_ROOT'].'/config_script/script.php') ?>
                    </div>
                    <div style = 'margin-top: 5px;'>
                        <form method = 'post'>
                            <input style = 'margin: auto; width: 100%; height: 40px; background: gold; border-radius: 5px; border: solid 1px black;' type = 'submit' name = 'clone' value = 'hostgroups & contact_groups'>
                        </form>
                    </div>
                </div>
                <div class = 'col-lg-2'></div>
            </div>
        </div>




    <div class = 'container' style = 'margin-top: 20px;'>
        <div class = 'row'>
            <div class = 'col-lg-4'></div>
            <div class = 'col-lg-4'>
                <div style = 'font-size: 16px; text-align: center;'><a href = '/home/permissions.php' target = '_blank'>→ <span style = 'text-decoration: underline;'>Редактирование прав групп</span> ←</a></div>
                <div style = 'font-size: 16px; margin-top: 5px; text-align: center;'><a href = '/home/log.php' target = '_blank'>→ <span style = 'text-decoration: underline;'>История действий пользователей</span> ←</a></div>
            </div>
            <div class = 'col-lg-4'></div>
        </div>
    </div>

<div class = 'container' style = 'margin-top: 20px; border-top: solid 2px red; padding-bottom: 30px;'>
    <div class = 'row'>
        <div class = 'col-lg-12' style = 'font-weight: bold; padding-top: 20px;'>
            <div><span style = 'color: navy;'>Пункт 1.</span> Для начала нужно создать пользователей, указав всю необходимую информацию.</div>
            <div><span style = 'color: navy;'>Пункт 2.</span> Создать новую группу для пользователей.</div>
            <div><span style = 'color: navy;'>Пункт 3.</span> Добавить пользователей в группу. <span style = 'color: red;'>(пользователь может находиться только в одной группе)</span></div>
            <div><span style = 'color: navy;'>Пункт 4.</span> Привязать группу к таблице. <span style = 'color: red;'>(группу можно привязать к неограниченному числу таблиц)</span></div>
            <div style = 'padding-top: 10px; color: red;'>
                <div>При удалении пользователя, в БД удаляется вся информация о нем.</div>
                <div>При удалении группы, в БД удаляется вся информация, связанная с ней.</div>
                <div>При отвязке от таблицы происходит удаление всех связей пользователя с таблицей.</div>
            </div>
        </div>
    </div>
</div>



