<!DOCTYPE html>

<?php
    /* - - - - - - - - - - ↓ Подключение к БД ↓ - - - - - - - - - - */
    $link = '';
    $descriptor = fopen($_SERVER['DOCUMENT_ROOT'].'/link.txt', 'r');
    if ($descriptor)
    { while (($string = fgets($descriptor)) !== false) { $link = $link.$string; } fclose($descriptor); }

    $localhost = "localhost";
    $user = "root";
    $password = $link;
    $db = "rtk_01";
    $mysqli = new mysqli($localhost, $user, $password, $db);
    mysqli_set_charset($mysqli, 'utf8');
    /* - - - - - - - - - - ↑ Подключение к БД ↑ - - - - - - - - - - */
?>

<html lang="ru">
<head>
    <title>Права пользователей</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/home/sys/style.css">
    <script src="/home/sys/users.js"></script>
</head>



<body>
<form method = 'post'>
    <div class = 'container-fluid'>
        <div class = 'row'>
            <div class = 'col-lg-12 table_title_div'>
                <div style = 'width: 300px; margin: auto;'>
                    <div style = 'width: 200px; float: left; margin-top: 3px;'>
                        <select name = 'selected_table' class = 'form-control' style = 'width: 190px; height: 30px;'>
                            <option></option>
                            <option>vibory</option>
                            <option>schools</option>
                            <input type = 'hidden' name = 'hid0'>
                        </select>
                    </div>
                    <div style = 'width: 100px; height: 30px; float: left; margin-top: 3px;'><input style = 'height: 100%; border: solid 1px grey; background: black; color: white;' name = 'select_table' type = 'submit' value = 'Выбрать'></div>
                </div>
            </div>
        </div>
    </div>



    <input type = 'hidden' name = 'hid'>

    <?php if ((isset ($_POST['edit_users_permissions'])) || (isset ($_POST['confirm'])))
    {
        $hid = $_POST['hid']; ;?>
        <script>$('input[name = "hid"]').val("<?php echo $hid ?>");</script><?php
        $kostil = $hid;
    }
    if ((isset ($_POST['select_table'])) && ($_POST['selected_table'] != ''))
    {
        $kostil = $_POST['selected_table'];
        ?><script>$('input[name = "hid"]').val("<?php echo $_POST['selected_table'] ?>");</script><?php
    } ?>


    <?php  require_once("sys/query.php"); ?>
    <script>
        var all_users = <?php echo json_encode($all_users); ?>;
        var users_permission = <?php echo json_encode($users_permission); ?>;
        var all_users_group = <?php echo json_encode($all_users_group); ?>;
        var all_group = <?php echo json_encode($all_group); ?>;

        var all_users_count = <?php echo json_encode($all_user_count); ?>;
        var users_permission_count = <?php echo json_encode($ege_user_count); ?>;
        var all_user_group_count = <?php echo json_encode($all_user_group_count); ?>;
        var all_group_count = <?php echo json_encode($all_group_count); ?>;

        var table_mass = <?php echo json_encode($table); ?>;
        var max_td_count = <?php echo json_encode($max_td_count); ?>;
        var permission = <?php echo json_encode($permission); ?>;
        var permission_edit = <?php echo json_encode($permission_edit); ?>;

        var option = new Array();
        var option_edit = new Array();
    </script>






<?php if (((isset ($_POST['select_table'])) && ($_POST['selected_table'] != '')) || (isset ($_POST['edit_users_permissions']) || (isset ($_POST['confirm']))) ) { ?>

    <div class = 'permission_div_margin'>

            <table class = 'table table-condensed table-striped main_table'>
                <tr><td class = 'table_head_sys' colspan = 2 rowspan = 2>Группа</td></tr>
                <tr>
                    <script>
                        for (table_count = 0; table_count <= (max_td_count - 1); table_count++)
                        { document.write("<td class = 'table_head_bg'>" + table_mass[table_count] + "</td>"); }
                    </script>
                    <td class = 'table_head_sys' colspan = 2>edit</td>
                </tr>
                <tr>
                    <td class = 'table_head_sys' colspan = 2 rowspan = 5>
                        <div>
                            <select name = 'group_for_edit' class = 'textBox_group'>
                                <option></option><script>groups();</script>
                            </select>
                        </div>
                        <div><button type = 'submit' name = 'edit_users_permissions'>Выбрать</button></div>
                        <input type = 'hidden' name = 'gr_name'>
                        <div style = 'background: gold; margin-top: 10px;'><?php echo $kostil; ?></div>
                        <div style = 'background: gold; height: 16px;'><?php echo $group_name; ?></div>
                    </td>
                <tr>
                    <script>document.write("<td class = 'table_head_info' colspan = " + (max_td_count) + ">Права пользователей на простомтр столбцов таблицы</td>");</script>
                    <td class = 'table_head_sys' rowspan = 4><div class = 'add_submit_div'><input type = 'submit' value = 'Сохранить' class = 'add_submit' name = 'confirm'></div></td>
                </tr>
                <script>
                    for (table_count = 0; table_count <= (max_td_count - 1); table_count++)
                    {
                        if (permission == null) { option[table_count] = '<option></option><option>+</option><option>-</option>'; }
                        else if ((permission[(table_count + 2)] != '+') && (permission[(table_count + 2)] != '-')) { option[table_count] = '<option></option><option>+</option><option>-</option>'; }
                        else if (permission[(table_count + 2)] === '+') { option[table_count] = '<option>+</option><option>-</option>'; }
                        else if (permission[(table_count + 2)] === '-') { option[table_count] = '<option>-</option><option>+</option>'; }
                        if (table_count <= max_td_count) { document.write("<td><select name = 'textBox" + table_count + "' class = 'form-control select'>" +
                            option[table_count] + "</select></td>"); }
                    }
                </script>
                <tr><script>document.write("<td class = 'table_head_info' colspan = " + (max_td_count) + ">Права пользователей на редактирование ячеек таблицы</td>");</script></tr>
                <script>
                    for (table_count = 0; table_count <= (max_td_count - 1); table_count++)
                    {
                        if (permission_edit == null) { option_edit[table_count] = '<option></option><option>+</option><option>-</option>'; }
                        else if ((permission_edit[(table_count + 2)] != '+') && (permission_edit[(table_count + 2)] != '-')) { option_edit[table_count] = '<option></option><option>+</option><option>-</option>'; }
                        else if ((permission_edit[(table_count + 2)] === '+') && ((permission[(table_count + 2)] === '+'))) { option_edit[table_count] = '<option>+</option><option>-</option>'; }
                        else if ((permission_edit[(table_count + 2)] === '-') || ((permission[(table_count + 2)] === '-'))) { option_edit[table_count] = '<option>-</option><option>+</option>'; }
                        if (table_count <= max_td_count) { document.write("<td><select name = 'edit_listBox" + table_count + "' class = 'form-control select'>" +
                            option_edit[table_count] + "</select></td>"); }
                    }
                </script>
            </table>

    </div>
</form>
<?php } ?>
</body>