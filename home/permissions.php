<?php
    /* - - - - - - - - - - ↓ Подключение к БД ↓ - - - - - - - - - - */
    $link = '';
    $descriptor = fopen($_SERVER['DOCUMENT_ROOT'].'/link.txt', 'r');
    if ($descriptor)
    { while (($string = fgets($descriptor)) !== false) { $link = $link.$string; } fclose($descriptor); }

    $mysqli = new mysqli('localhost', 'root', $link, 'rtk_01');
    mysqli_set_charset($mysqli, 'utf8');
    /* - - - - - - - - - - ↑ Подключение к БД ↑ - - - - - - - - - - */

    require_once($_SERVER['DOCUMENT_ROOT']."/sys/class.php");
    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');



$table_count = 0;
    $SQL_QUERY_select_table = $mysqli->query("SELECT * FROM  `tables_namespace` WHERE `released` = '+' ");
    while ($row = mysqli_fetch_row($SQL_QUERY_select_table))
    {
        $table_name[$table_count] = $row[1];
        $table_description[$table_count] = $row[2];
        $table_count++;
    }



?>


<!DOCTYPE html>

<html lang="ru">
<head>
    <title>Права пользователей</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/home/sys/style.css">
    <!--<script src="/home/sys/users.js"></script>-->
</head>



<body>
<form method = 'post'>

    <input type = 'hidden' name = 'table_name'>
    <input type = 'hidden' name = 'table_description'>
    <input type = 'hidden' name = 'group'>


    <?php if ((isset ($_POST['edit_users_permissions'])) || (isset ($_POST['confirm'])))
    {
        $selected_table_name = $_POST['table_name'];
        $selected_table_description = $_POST['table_description'];
        //$group = $_POST['group'];
        ?>
            <script>$('input[name = "table_name"]').val("<?= $selected_table_name ?>");</script>
            <script>$('input[name = "table_description"]').val("<?= $selected_table_description ?>");</script>
            <script>$('input[name = "group"]').val("<?= $_POST['group_for_edit'] ?>");</script>

        <?php
        $selected_table_name = $_POST['table_name'];
        $selected_table_description = $_POST['table_description'];
        $group = $_POST['group_for_edit'];

        //$kostil = $hid;

        $user_count = 0;
        $DB->select("name","group_namespace",$selected_table_name." = '+'");
        $SQL_QUERY_select_users = $DB->sql_query_select;
        while ($row = mysqli_fetch_row($SQL_QUERY_select_users))
        {
            $table_user[$user_count] = $row[0];
            $user_count++;
        }
    }




    if ((isset ($_POST['select_table'])) && ($_POST['selected_table'] != ''))
    {
        $selected_table_description = $_POST['selected_table'];

        $SQL_QUERY_select_table_name = $mysqli->query("SELECT `name` FROM `tables_namespace` WHERE `description` = '".$selected_table_description."' ");
        while ($row = mysqli_fetch_row($SQL_QUERY_select_table_name))
        { $selected_table_name = $row[0]; }
        ?>
            <script>$('input[name = "table_name"]').val("<?= $selected_table_name ?>");</script>
            <script>$('input[name = "table_description"]').val("<?= $selected_table_description ?>");</script>
        <?php
        $user_count = 0;
        $DB->select("name","group_namespace",$selected_table_name." = '+'");
        $SQL_QUERY_select_users = $DB->sql_query_select;
        while ($row = mysqli_fetch_row($SQL_QUERY_select_users))
        {
            $table_user[$user_count] = $row[0];
            $user_count++;
        }
    }


    ?>




    <div class = 'container-fluid'>
        <div class = 'row'>
            <div class = 'col-lg-12 table_title_div'>
                <div style = 'width: 300px; margin: auto;'>
                    <div style = 'width: 200px; float: left; margin-top: 3px;'>
                        <select name = 'selected_table' class = 'form-control' style = 'text-align: center; width: 190px; height: 30px;'>
                            <?php
                                if ($selected_table_description == null) { echo '<option></option>'; }
                                for ($count = 0; $count < mysqli_num_rows($SQL_QUERY_select_table); $count++)
                                {
                                    if ($selected_table_description == $table_description[$count]) { $selected_table = 'selected'; } else { $selected_table = ''; }
                                    echo "<option ".$selected_table.">".$table_description[$count]."</option>";
                                }
                            ?>
                            <input type = 'hidden' name = 'hid0'>
                        </select>
                    </div>
                    <div style = 'width: 100px; height: 30px; float: left; margin-top: 3px;'><input style = 'height: 100%; border: solid 1px grey; background: black; color: white;' name = 'select_table' type = 'submit' value = 'Выбрать'></div>
                </div>
            </div>
        </div>
    </div>






    <?php  require_once("sys/query.php"); ?>
    <script>
        var all_users = <?= json_encode($all_users); ?>;
        var users_permission = <?= json_encode($users_permission); ?>;
        var all_users_group = <?= json_encode($all_users_group); ?>;
        var all_group = <?= json_encode($all_group); ?>;

        var all_users_count = <?= json_encode($all_user_count); ?>;
        var users_permission_count = <?= json_encode($ege_user_count); ?>;
        var all_user_group_count = <?= json_encode($all_user_group_count); ?>;
        var all_group_count = <?= json_encode($all_group_count); ?>;

        var table_mass = <?= json_encode($table); ?>;
        var max_td_count = <?= json_encode($max_td_count); ?>;
        var permission = <?= json_encode($permission); ?>;
        var permission_edit = <?= json_encode($permission_edit); ?>;

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
                                <?php
                                    if ($group == null) { echo '<option></option>'; }
                                    $user_count = 0;
                                    while ($user_count < mysqli_num_rows($SQL_QUERY_select_users))
                                    {
                                        if ($table_user[$user_count] == $group) { $selected_group = 'selected'; } else { $selected_group = ''; }
                                        echo "<option ".$selected_group.">".$table_user[$user_count]."</option>";
                                        $user_count++;
                                    }
                                ?>
                            </select>
                        </div>
                        <div><input style = 'width: 120px;' type = 'submit' name = 'edit_users_permissions' value = 'Выбрать' class = 'add_submit'></div>
                    </td>

                    <script>document.write("<td class = 'table_head_info' colspan = " + (max_td_count) + "></td>");</script>
                    <td class = 'table_head_sys' rowspan = 4>
                        <div class = 'add_submit_div'><div class = 'add_input_div_margin'><input type = 'submit' value = 'Сохранить' class = 'add_submit' name = 'confirm'></div></div>
                    </td>
                </tr>
                <script>
                    for (table_count = 0; table_count <= (max_td_count - 1); table_count++)
                    {
                        if (permission == null) { option[table_count] = '<option selected></option><option>+</option><option>-</option>'; }
                        else if ((permission[(table_count + 2)] != '+') && (permission[(table_count + 2)] != '-')) { option[table_count] = '<option>+</option><option selected>-</option>'; }
                        else if (permission[(table_count + 2)] === '+') { option[table_count] = '<option selected>+</option><option>-</option>'; }
                        else if (permission[(table_count + 2)] === '-') { option[table_count] = '<option>+</option><option selected>-</option>'; }
                        if (table_count <= max_td_count) { document.write("<td><select name = 'textBox" + table_count + "' class = 'form-control select'>" +
                            option[table_count] + "</select></td>"); }
                    }
                </script>
                <tr><script>document.write("<td class = 'table_head_info' colspan = " + (max_td_count) + "></td>");</script></tr>
                <script>
                    for (table_count = 0; table_count <= (max_td_count - 1); table_count++)
                    {
                        if (permission_edit == null) { option_edit[table_count] = '<option selected></option><option>+</option><option>-</option>'; }
                        else if ((permission_edit[(table_count + 2)] != '+') && (permission_edit[(table_count + 2)] != '-')) { option_edit[table_count] = '<option>+</option><option selected>-</option>'; }
                        else if ((permission_edit[(table_count + 2)] === '+') && ((permission[(table_count + 2)] === '+'))) { option_edit[table_count] = '<option>+</option><option>-</option>'; }
                        else if ((permission_edit[(table_count + 2)] === '-') || ((permission[(table_count + 2)] === '-'))) { option_edit[table_count] = '<option>+</option><option selected>-</option>'; }
                        if (table_count <= max_td_count) { document.write("<td><select name = 'edit_listBox" + table_count + "' class = 'form-control select'>" +
                            option_edit[table_count] + "</select></td>"); }
                    }
                </script>
            </table>
    </div>
</form>
<?php } ?>
</body>