<?php

/* - - - - - - - - - - ↓ Добавление группы ↓ - - - - - - - - - - */
    if (isset ($_POST['add_group']))
    {
        $SQL_QUERY_add_to_table_select = $mysqli->query("SELECT * FROM `group_namespace` ");
        $sql_str = "null, '".$_POST['group_name']."'";
        for ($count = 1; $count <= ((mysqli_num_fields($SQL_QUERY_add_to_table_select) - 2 )); $count++)
        { $sql_str = $sql_str.", ''"; }
        $strSQL1 = $mysqli->query("INSERT INTO `group_namespace` VALUES (".$sql_str.")");
        header ("Location: /");
    }
/* - - - - - - - - - - ↑ Добавление группы ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Удаление группы ↓ - - - - - - - - - - */
    if (isset ($_POST['del_group']))
    {

        //$SQL_QUERY_select_group_users = $mysqli->query("SELECT `login` FROM `users` WHERE `table_group` = '".$_POST['del_group_name']."' ");
        //while ($row = mysqli_fetch_row($SQL_QUERY_select_group_users))
        //{
            //$SQL_QUERY_add_vision_users = $mysqli->query("ALTER TABLE `".$_POST['selected_del_table']."_vision` DROP `".$row[0]."` ");
            //echo "ALTER TABLE `".$_POST['selected_del_table']."_vision` DROP `".$row[0]."` ";
        //}

        $strSQL1 = $mysqli->query("DELETE FROM `group_namespace` WHERE name = '".$_POST['del_group_name']."'");
        $SQL_QUERY_del_users_group = $mysqli->query("UPDATE `users` SET `table_group` = '' WHERE `table_group` = '".$_POST['del_group_name']."' ");




        $SQL_QUERY_add_permissions_1 = $mysqli->query("DELETE FROM `".$_POST['selected_del_table']."_permission` WHERE `".$_POST['selected_del_table']."_group` = '".$_POST['del_group_name']."' ");
        $SQL_QUERY_add_permissions_2 = $mysqli->query("DELETE FROM `".$_POST['selected_del_table']."_permission` WHERE `".$_POST['selected_del_table']."_group` = '".$_POST['del_group_name']."_edit' ");
        //header ("Location: /");
    }
/* - - - - - - - - - - ↑ Удаление группы ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Привязка группы к таблице ↓ - - - - - - - - - - */
    if (isset ($_POST['group_to_table']))
    {
        $SQL_QUERY_add_to_table = $mysqli->query("UPDATE `group_namespace` SET `".$_POST['selected_table']."` = '+' WHERE `name` = '".$_POST['selected_group']."' ");
        $SQL_QUERY_add_to_table = $mysqli->query("UPDATE `group_namespace` SET `".$_POST['selected_table']."_status` = '".$_POST['selected_type']."' WHERE `name` = '".$_POST['selected_group']."' ");

        $SQL_QUERY_select_group_users = $mysqli->query("SELECT `login` FROM `users` WHERE `table_group` = '".$_POST['selected_group']."' ");
        while ($row = mysqli_fetch_row($SQL_QUERY_select_group_users))
        { $SQL_QUERY_add_vision_users = $mysqli->query("ALTER TABLE `".$_POST['selected_table']."_vision` ADD `".$row[0]."` TEXT CHARACTER SET utf8 NOT NULL"); }


        $SQL_QUERY_select_permission = $mysqli->query("SELECT * FROM `".$_POST['selected_table']."_permission` WHERE `".$_POST['selected_table']."_group` = '".$_POST['selected_group']."' ");

        $SQL_QUERY_select_table_count = $mysqli->query("SELECT * FROM `".$_POST['selected_table']."_permission` ");
        $sql_str_1 = "null, '".$_POST['selected_group']."'";
        $sql_str_2 = "null, '".$_POST['selected_group']."_edit'";
        for ($count = 1; $count <= (mysqli_num_fields($SQL_QUERY_select_table_count) - 2); $count++)
        {
            if ($_POST['selected_type'] == 'superuser')
            { $sql_str_1 = $sql_str_1.", '+'"; $sql_str_2 = $sql_str_2.", '+'"; }
            else { $sql_str_1 = $sql_str_1.", '-'"; $sql_str_2 = $sql_str_2.", '-'"; }
        }

        if (mysqli_num_rows($SQL_QUERY_select_permission) == 0)
        {
            $SQL_QUERY_add_permissions_1 = $mysqli->query("INSERT INTO `".$_POST['selected_table']."_permission` VALUE (".$sql_str_1.")");
            $SQL_QUERY_add_permissions_2 = $mysqli->query("INSERT INTO `".$_POST['selected_table']."_permission` VALUE (".$sql_str_2.")");
        }
        else if (mysqli_num_rows($SQL_QUERY_select_permission) > 0)
        {
            $strSQL1 = $mysqli->query("DELETE FROM `".$_POST['selected_table']."_permission` WHERE `".$_POST['selected_table']."_group` = '".$_POST['selected_group']."'");
            $strSQL1 = $mysqli->query("DELETE FROM `".$_POST['selected_table']."_permission` WHERE `".$_POST['selected_table']."_group` = '".$_POST['selected_group']."_edit'");
            $SQL_QUERY_add_permissions_1 = $mysqli->query("INSERT INTO `".$_POST['selected_table']."_permission` VALUE (".$sql_str_1.")");
            $SQL_QUERY_add_permissions_2 = $mysqli->query("INSERT INTO `".$_POST['selected_table']."_permission` VALUE (".$sql_str_2.")");
        }
    }
/* - - - - - - - - - - ↑ Привязка группы к таблице ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Отвязка группы от таблицы ↓ - - - - - - - - - - */
    if (isset ($_POST['group_to_table_del']))
    {
        $SQL_QUERY_del_to_table = $mysqli->query("UPDATE `group_namespace` SET `".$_POST['selected_del_table']."` = '' WHERE `name` = '".$_POST['selected_del_group']."' ");
        $SQL_QUERY_del_to_table = $mysqli->query("UPDATE `group_namespace` SET `".$_POST['selected_del_table']."_status` = '' WHERE `name` = '".$_POST['selected_del_group']."' ");

        $SQL_QUERY_select_group_users = $mysqli->query("SELECT `login` FROM `users` WHERE `table_group` = '".$_POST['selected_del_group']."' ");
        while ($row = mysqli_fetch_row($SQL_QUERY_select_group_users))
        { $SQL_QUERY_add_vision_users = $mysqli->query("ALTER TABLE `".$_POST['selected_del_table']."_vision` DROP `".$row[0]."` "); }

        $SQL_QUERY_add_permissions_1 = $mysqli->query("DELETE FROM `".$_POST['selected_del_table']."_permission` WHERE `".$_POST['selected_del_table']."_group` = '".$_POST['selected_del_group']."' ");
        $SQL_QUERY_add_permissions_2 = $mysqli->query("DELETE FROM `".$_POST['selected_del_table']."_permission` WHERE `".$_POST['selected_del_table']."_group` = '".$_POST['selected_del_group']."_edit' ");
    }
/* - - - - - - - - - - ↑ Отвязка группы от таблицы ↑ - - - - - - - - - - */
?>