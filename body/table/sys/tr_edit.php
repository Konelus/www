<?php
    $SQL_QUERY_ver = $mysqli->query("select `ver` from `ver` ");
    while ($row = mysqli_fetch_row($SQL_QUERY_ver))
    { $current_ver = $row[0]; }
    $version = $_POST['ver'];
    //echo $current_ver.' --> '.$version;


    $DB->select("description","tables_namespace","`name` = '".$podcat_name[1]."' ");
    while ($row = mysqli_fetch_row($DB->sql_query_select)) { $table_name = $row[0]; }

    $DB->select("fio","users","`login` = '".$_COOKIE['user']."'");
    while ($row = mysqli_fetch_row($DB->sql_query_select)) { $user_fio = $row[0]; }



    for ($td_count = 2; $td_count <= $max_td_count + 2; $td_count++)
    {
        if (($title1[$td_count] == '+') && $_COOKIE['user'] != 'admin')
        {
            if ($current_ver == $version)
            {
                $SQL_select_td = $mysqli->query("select " . $table_sql[$td_count - 2] . " from " . $podcat_name[1] . " WHERE id = " . $title[$tr][0] . "  ");
                if ($SQL_select_td != null)
                {
                    while ($row_0 = mysqli_fetch_array($SQL_select_td))
                    {

                        if ($row_0[0] != $_POST['editBox_' . $tr . '_' . ($td_count - 1)])
                        {
                            $DB->select("name",$podcat_name[1]."_table","`sql_name` = '".$table_sql[$td_count - 2]."' ");
                            while ($row = mysqli_fetch_row($DB->sql_query_select)) { $cell_name = $row[0]; }
                            $DB->insert("log_info","null, '" . $user_fio . "', '".$_SERVER['REMOTE_ADDR']."', '" . date("d.m.Y") . "', '" . date("H:i:s") . "', '" . $table_name . "', '" . $title[$tr][1] . "', '" . $cell_name . "', '" . $title[$tr][($td_count - 1)] . "', '" . $_POST['editBox_' . $tr . '_' . ($td_count - 1)] . "'");
                        }
                    }
                }

                if ($table_sql[$td_count - 2] != '')
                { $DB->update("".$podcat_name[1],"".$table_sql[$td_count - 2],"". $_POST['editBox_' . $tr . '_' . ($td_count - 1)],"`id` = '" . $title[$tr][0] . "'"); }
            }
            else
            {
                echo "<div style = 'background: navy; width: 100%; position: fixed; top: 40px; left: 0; padding-top: 20px; padding-bottom: 20px; text-align: center; color: red; font-weight: bold;'>Внимание! Ваша последняя правка не сохранена! Пожалуйста, обновите страницу и отредактируйте строку вновь!</div>";
                break;
            }
        }
        else if ($_COOKIE['user'] == 'admin')
        { $DB->update("".$podcat_name[1],"".$table_sql[$td_count - 2],"".$_POST['editBox_'.$tr.'_'.($td_count - 1)],"`id` = '".$title[$tr][0]."'"); }
    }
?>