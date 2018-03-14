<?php



    // ↓ Получение списка пользователей ↓
    $DB->select("login","users");
    while ($row = mysqli_fetch_row($DB->sql_query_select))
    { $all_users[] = $row[0]; }
    // ↑ Получение списка пользователей ↑


    // ↓ Получение пользовательских групп ↓
//    $DB->select("table_group","users");
//    while ($row = mysqli_fetch_row($DB->sql_query_select))
//    { $all_users_group[] = $row[0]; }
    // ↑ Получение пользовательских групп ↑


    // ↓ Получение списка всех групп ↓
    $DB->select("name","group_namespace");
    while ($row = mysqli_fetch_row($DB->sql_query_select))
    { $all_group[] = $row[0]; }
    // ↑ Получение списка всех групп  ↑


/* - - - - - - - - - - ↓ Получение названий столбцов таблицы ↓ - - - - - - - - - - */
$DB->select("name","{$selected_table_name}_table","");
if ($DB->sql_query_select != null)
{
    while ($row = mysqli_fetch_row($DB->sql_query_select))
    { $table[] = $row[0]; }
    $max_td_count = mysqli_num_rows($DB->sql_query_select);
}
/* - - - - - - - - - - ↑ Получение названий столбцов таблицы ↑ - - - - - - - - - - */


/* - - - - - - - - - - ↓ Получение sql-названий столбцов таблицы ↓ - - - - - - - - - - */
sql_name("{$selected_table_name}","","2"); $table_sql = $result;
/* - - - - - - - - - - ↑ Получение sql-названий столбцов таблицы ↑ - - - - - - - - - - */


// ↓ Изменение группы пользователя ↓
if (isset ($_POST['edit_users_group']))
{
    $DB->update("users","table_group","{$_POST['selected_group']}","`login` = '{$_POST['selected_user']}'");
    $DB->select("*","group_namespace","`name` = '{$_POST['selected_group']}'");
    while ($array = mysqli_fetch_array($DB->sql_query_select)) { $group_array = $array; }
    foreach ($group_array as $key => $value)
    {
        if (($value == '+') && ($key === (string)$key))
        {
            $DB->alter_add("{$key}_vision","{$_POST['selected_user']}","TEXT CHARACTER SET utf8 NOT NULL");
            $DB->update("{$key}_vision","{$_POST['selected_user']}","+","");
        }
    }

    header ("Location: /");
}
// ↑ Изменение группы пользователя ↑


?>