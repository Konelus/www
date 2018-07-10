<?php


    //echo '<br><br><br>';



    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/use.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');



    $table_count = 0;
    $DB->select("*","!sys_tables_namespace", "`released` = '1'");
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
    <input type = 'hidden' name = 'vision'>
    <input type = 'hidden' name = 'perm'>



    <?php
    if ((isset ($_POST['edit_users_permissions'])) || (isset ($_POST['confirm'])) || (isset($_POST['vision_plus'])) || (isset($_POST['vision_minus'])) || (isset($_POST['perm_plus'])) || (isset($_POST['perm_minus'])))
    {
        $selected_table_name = $_POST['table_name'];
        $selected_table_description = $_POST['table_description'];
        //$selected_vision = $_POST['vision'];
        //$selected_perm = $_POST['perm'];

        if (isset ($_POST['vision_plus']))
        {
            ?><script>
                $('input[name = "vision"]').val("+");
                $('input[name = "perm"]').val("<?= $_POST['perm'] ?>");
            </script><?php
            $selected_vision = '+';
            if ($_POST['perm'] != '') { $selected_perm = $_POST['perm']; }
        }
        else if (isset ($_POST['vision_minus']))
        {
            ?><script>
                $('input[name = "vision"]').val("-");
                $('input[name = "perm"]').val("<?= $_POST['perm'] ?>");
            </script><?php
            $selected_vision = '-';
            if ($_POST['perm'] != '') { $selected_perm = $_POST['perm']; }
        }

        if (isset ($_POST['perm_plus']))
        {
            ?><script>
                $('input[name = "perm"]').val("+");
                $('input[name = "vision"]').val("<?= $_POST['vision'] ?>");
            </script><?php
            $selected_perm = '+';
            if ($_POST['vision'] != '') { $selected_vision = $_POST['vision']; }
        }
        else if (isset ($_POST['perm_minus']))
        { ?><script>
                $('input[name = "perm"]').val("-");
                $('input[name = "vision"]').val("<?= $_POST['vision'] ?>");
            </script><?php
            $selected_perm = '-';
            if ($_POST['vision'] != '') { $selected_vision = $_POST['vision']; }
        }


        //$group = $_POST['group'];
        ?>
            <script>$('input[name = "table_name"]').val("<?= $selected_table_name ?>");</script>
            <script>$('input[name = "table_description"]').val("<?= $selected_table_description ?>");</script>
            <script>$('input[name = "group"]').val("<?= $_POST['group_for_edit'] ?>");</script>

        <?php
        $selected_table_name = $_POST['table_name'];
        $selected_table_description = $_POST['table_description'];
        $group = $_POST['group_for_edit'];
        //$selected_vision = $_POST['vision'];
        //$selected_perm = $_POST['perm'];




        $DB->select("name","!sys_group_namespace","{$selected_table_name} = '+'");
        $SQL_QUERY_select_users = $DB->sql_query_select;
        while ($row = mysqli_fetch_row($SQL_QUERY_select_users))
        { $table_user[] = $row[0]; }
    }
//    if ((isset($_POST['vision_plus'])) || (isset($_POST['vision_minus'])))
//    {
//        $selected_vision = $_POST['vision'];
//    }
//    if ((isset($_POST['perm_plus'])) || (isset($_POST['perm_minus'])))
//    {
//        $selected_perm = $_POST['perm'];
//    }





    if ((isset ($_POST['select_table'])) && ($_POST['selected_table'] != ''))
    {
        $selected_table_description = $_POST['selected_table'];

        $DB->select("name","!sys_tables_namespace","`description` = '{$selected_table_description}'");
        while ($row = mysqli_fetch_row($DB->sql_query_select))
        { $selected_table_name = $row[0]; }
        ?>
            <script>$('input[name = "table_name"]').val("<?= $selected_table_name ?>");</script>
            <script>$('input[name = "table_description"]').val("<?= $selected_table_description ?>");</script>
        <?php
        $user_count = 0;
        $DB->select("name","!sys_group_namespace",$selected_table_name." = '+'");
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

            foreach ($title_array as $key => $value) { $title_sort[] = $value[3]; }


            //$title_sort = $title_array;
            sort($title_sort);

            foreach ($title_sort as $key => $value)
            {
                for ($count = 0; $count <= count($title_sort); $count++)
                {
                    if ($title_array[$count][3] == $value)
                    {
                        $title_array["0_{$key}"][0] = $title_array[$count][0];
                        $title_array["0_{$key}"][1] = $title_array[$count][1];
                        $title_array["0_{$key}"][2] = $title_array[$count][2];
                        $title_array["0_{$key}"][3] = $title_array[$count][3];
                        unset($title_array[$count]);
                    }
                }
            }
            foreach ($title_array as $key => $value)
            {
                $new_key = explode("_","{$key}");
                $new_key = $new_key[1];
                $title_array[$new_key] = $title_array[$key];
                unset($title_array[$key]);
            }

        }

        require_once ($_SERVER['DOCUMENT_ROOT'].'/home/sys/query.php');


        if (((isset ($_POST['select_table'])) && ($_POST['selected_table'] != '')) || (isset ($_POST['edit_users_permissions']) || (isset ($_POST['confirm'])) || (isset($_POST['vision_plus'])) || (isset($_POST['vision_minus'])) || (isset($_POST['perm_plus'])) || (isset($_POST['perm_minus']))) ) { ?>

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
                    <td class = 'table_head_info' colspan = <?= count($title_array) ?>>
                        <div style = 'float: left;'>
<!--                            <input type = 'submit' style = 'border: solid 1px black; background: gold; height: 20px; width: 30px;' value = '+' name = 'vision_plus'>-->
<!--                            <input type = 'submit' style = 'border: solid 1px black; background: gold; height: 20px; width: 30px;' value = '-' name = 'vision_minus'>-->
                        </div>
                    </td>
                    <td class = 'table_head_sys' rowspan = 4>
                        <div class = 'add_submit_div'><div class = 'add_input_div_margin'><input type = 'submit' value = 'Сохранить' class = 'add_submit' name = 'confirm'></div></div>
                    </td>
                </tr>
                <?php
                    for ($count = 0; $count < count($title_array); $count++)
                    {
                        if (!isset ($selected_vision))
                        {
                            if ($permission == null) { $option[$count] = '<option selected></option><option>+</option><option>-</option>'; }
                            else if (($permission[($count + 2)] != '+') && ($permission[($count + 2)] != '-')) { $option[$count] = '<option>+</option><option selected>-</option>'; }
                            else if ($permission[($count + 2)] === '+') { $option[$count] = '<option selected>+</option><option>-</option>'; }
                            else if ($permission[($count + 2)] === '-') { $option[$count] = '<option>+</option><option selected>-</option>'; }
                        }
                        elseif ($selected_vision == '+') { $option[$count] = '<option selected>+</option><option>-</option>'; }
                        elseif ($selected_vision == '-') { $option[$count] = '<option>+</option><option selected>-</option>'; }
                        if ($count <= count($title_array)) { echo "<td><select name = 'listBox_{$count}' class = 'form-control select'>{$option[$count]}{$count}</select></td>"; }
                    }
                ?>

                <tr>
                    <td class = 'table_head_info' colspan = <?= count($title_array) ?>>
                        <div style = 'float: left;'>
<!--                            <input type = 'submit' style = 'border: solid 1px black; background: gold; height: 20px; width: 30px;' value = '+' name = 'perm_plus'>-->
<!--                            <input type = 'submit' style = 'border: solid 1px black; background: gold; height: 20px; width: 30px;' value = '-' name = 'perm_minus'>-->
                        </div>
                    </td>
                </tr>
                <?php
                for ($count = 0; $count < count($title_array); $count++)
                {
                    if (!isset ($selected_perm))
                    {
                        if ($permission_edit == null) { $option[$count] = '<option selected></option><option>+</option><option>-</option>'; }
                        else if (($permission_edit[($count + 2)] != '+') && ($permission_edit[($count + 2)] != '-')) { $option[$count] = '<option>+</option><option selected>-</option>'; }
                        else if ($permission_edit[($count + 2)] === '+') { $option[$count] = '<option selected>+</option><option>-</option>'; }
                        else if ($permission_edit[($count + 2)] === '-') { $option[$count] = '<option>+</option><option selected>-</option>'; }
                    }
                    elseif ($selected_perm == '+') { $option[$count] = '<option selected>+</option><option>-</option>'; }
                    elseif ($selected_perm == '-') { $option[$count] = '<option>+</option><option selected>-</option>'; }
                    if ($count <= count($title_array)) { echo "<td><select name = 'edit_listBox_{$count}' class = 'form-control select'>{$option[$count]}</select></td>"; }
                }
                ?>

            </table>
    </div>
</form>
<?php }
?>
</body>