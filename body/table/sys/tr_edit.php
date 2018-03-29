<?php

    ver();
    $version = explode('.', "{$_POST['ver']}");


    //$DB->select("description","tables_namespace","`name` = '{$substring}' ");
    //while ($row = mysqli_fetch_row($DB->sql_query_select)) { $table_name = $row[0]; }

    $DB->select("fio","users","`login` = '{$_COOKIE['user']}'");
    while ($row = mysqli_fetch_row($DB->sql_query_select)) { $user_fio = $row[0]; }

    $DB->select("description","tables_namespace", "`name` = '{$substring}'");
    while ($row = mysqli_fetch_row($DB->sql_query_select)) { $table_name = $row[0]; }



//pre($table_sql);


    for ($td_count = 1; $td_count <= $max_td_count + 1; $td_count++)
    {
        //echo $td_count.' / '.$max_td_count.'<br>';
        if (($title1[$td_count] == '+') && $_COOKIE['user'] != 'admin')
        {
            if ($current_ver[2] == $version[2])
            {
                $DB->select("{$table_sql[$td_count - 2]}","{$substring}","`id` = '{$title[$edit_true_count - 1][0]}'");
                if ($DB->sql_query_select != null)
                {
                    while ($row_0 = mysqli_fetch_array($DB->sql_query_select))
                    {
                        if ($row_0[0] != $_POST["editBox_".($edit_true_count - 1)."_".($td_count - 1)])
                        {
                            $DB->select("name",$substring."_table","`sql_name` = '{$table_sql[$td_count - 2]}' ");
                            while ($row = mysqli_fetch_row($DB->sql_query_select)) { $cell_name = $row[0]; }
                            $DB->insert("log_info","null, '{$user_fio}', '{$_SERVER['REMOTE_ADDR']}', '" . date("d.m.Y") . "', '" . date("H:i:s") . "', '{$table_name}', '{$title[$edit_true_count - 1][1]}', '{$cell_name}', '{$title[$edit_true_count - 1][($td_count - 1)]}', '{$_POST['editBox_'.($edit_true_count - 1).'_'.($td_count - 1)]}'");
                        }
                    }
                }

                if ($table_sql[$td_count - 2] != '')
                {
                    $DB->update("{$substring}","".$table_sql[$td_count - 2],"". $_POST["editBox_".($edit_true_count - 1)."_".($td_count - 1)],"`id` = '{$title[$edit_true_count - 1][0]}'");
                }
            }
            else
            {
                echo "<div style = 'background: navy; width: 100%; position: fixed; top: 40px; left: 0; padding-top: 20px; padding-bottom: 20px; text-align: center; color: red; font-weight: bold;'>Внимание! Ваша последняя правка не сохранена! Пожалуйста, обновите страницу и отредактируйте строку вновь!</div>";
                break;
            }
        }
        else if ($_COOKIE['user'] == 'admin')
        {
            $DB->update("{$substring}","".$table_sql[$td_count - 1],"".$_POST["editBox_".($edit_true_count - 1)."_".($td_count - 1)],"`id` = '{$title[$edit_true_count - 1][0]}'");

        }
    }
    //pre($title);
?>
