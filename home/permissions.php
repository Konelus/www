<?php


    //echo '<br><br><br>';



    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/use.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');



    $table_count = 0;
    $DB->select("*","tables_namespace", "`released` = '+'");
    $SQL_QUERY_select_table = $DB->sql_query_select;
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



        $user_count = 0;
        $DB->select("name","group_namespace","{$selected_table_name} = '+'");
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

        $DB->select("name","tables_namespace","`description` = '{$selected_table_description}'");
        while ($row = mysqli_fetch_row($DB->sql_query_select))
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
                                    echo "<option {$selected_table}>{$table_description[$count]}</option>";
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


    <?php
        if ($selected_table_name != '')
        {
            $DB->select("*","{$selected_table_name}_table");
            while ($array = mysqli_fetch_row($DB->sql_query_select))
            { $title_array[] = $array; }
        }
        require_once ($_SERVER['DOCUMENT_ROOT'].'/home/sys/query.php');


        if (((isset ($_POST['select_table'])) && ($_POST['selected_table'] != '')) || (isset ($_POST['edit_users_permissions']) || (isset ($_POST['confirm']))) ) { ?>

    <div class = 'permission_div_margin'>

            <table class = 'table table-condensed table-striped main_table'>
                <tr><td class = 'table_head_sys' colspan = 2 rowspan = 2>Группа</td></tr>
                <tr>
                    <?php for ($count = 0; $count < count($title_array); $count++) { echo "<td class = 'table_head_bg'>{$title_array[$count][1]}</td>"; } ?>
                    <td class = 'table_head_sys' colspan = 2>edit</td>
                </tr>
                <tr>
                    <td class = 'table_head_sys' colspan = 2 rowspan = 5>
                        <div>
                            <select name = 'group_for_edit' class = 'textBox_group'>
                                <?php
                                    if ($group == null) { echo '<option></option>'; }
                                    for ($count = 0; $count < mysqli_num_rows($SQL_QUERY_select_users); $count++)
                                    {
                                        if ($table_user[$count] == $group) { $selected_group = 'selected'; } else { $selected_group = ''; }
                                        echo "<option {$selected_group}>{$table_user[$count]}</option>";
                                    }

                                ?>
                            </select>
                        </div>
                        <div><input style = 'width: 120px;' type = 'submit' name = 'edit_users_permissions' value = 'Выбрать' class = 'add_submit'></div>
                    </td>
                    <td class = 'table_head_info' colspan = <?= count($title_array) ?>></td>
                    <td class = 'table_head_sys' rowspan = 4>
                        <div class = 'add_submit_div'><div class = 'add_input_div_margin'><input type = 'submit' value = 'Сохранить' class = 'add_submit' name = 'confirm'></div></div>
                    </td>
                </tr>
                <?php
                    for ($count = 0; $count < count($title_array); $count++)
                    {
                        if ($permission == null) { $option[$count] = '<option selected></option><option>+</option><option>-</option>'; }
                        else if (($permission[($count + 2)] != '+') && ($permission[($count + 2)] != '-')) { $option[$count] = '<option>+</option><option selected>-</option>'; }
                        else if ($permission[($count + 2)] === '+') { $option[$count] = '<option selected>+</option><option>-</option>'; }
                        else if ($permission[($count + 2)] === '-') { $option[$count] = '<option>+</option><option selected>-</option>'; }
                        if ($count <= count($title_array)) { echo "<td><select name = 'listBox_{$count}' class = 'form-control select'>{$option[$count]}{$count}</select></td>"; }
                    }
                ?>

                <tr><td class = 'table_head_info' colspan = <?= count($title_array) ?>></td></tr>
                <?php
                for ($count = 0; $count < count($title_array); $count++)
                {
                    if ($permission_edit == null) { $option[$count] = '<option selected></option><option>+</option><option>-</option>'; }
                    else if (($permission_edit[($count + 2)] != '+') && ($permission_edit[($count + 2)] != '-')) { $option[$count] = '<option>+</option><option selected>-</option>'; }
                    else if ($permission_edit[($count + 2)] === '+') { $option[$count] = '<option selected>+</option><option>-</option>'; }
                    else if ($permission_edit[($count + 2)] === '-') { $option[$count] = '<option>+</option><option selected>-</option>'; }
                    if ($count <= count($title_array)) { echo "<td><select name = 'edit_listBox_{$count}' class = 'form-control select'>{$option[$count]}</select></td>"; }
                }
                ?>

            </table>
    </div>
</form>
<?php } //pre(get_defined_vars()); ?>
</body>