<?php require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');


    function permission($table, $group)
    {
        global $DB;
        $DB->select("*","{$table}_permission","`{$table}_group` = '{$group}'");
    }


//    function ver()
//    {
//        global $DB;
//        $DB->select("ver","!sys_ver");
//        global $ver, $current_ver;
//        $ver = mysqli_fetch_row($DB->sql_query_select);
//        $ver = $ver[0];
//        $current_ver = explode('.', "{$ver}");
//    }


    function sql_name($table, $name = '', $arr_count = 1)
    {
        global $DB;
        if ($name != '') { $name = "`name` = '{$name}'"; }
        $DB->select("sql_name","{$table}_table","{$name}");
        if ($DB->sql_query_select != null)
        {
            while ($row = mysqli_fetch_row($DB->sql_query_select))
            {
                if ($arr_count == 1) { $result = $row[0]; }
                if ($arr_count == 2) { $result[] = $row[0]; }
            }
        }
        return $result;
    }

    function monitoring_search($table, $status, $column)
    {
        global $DB;
        ?><script>
            $('input[name = "hidden_sort_5"]').val("<?= 'contact_groups' ?>");
            $('input[name = "hidden_sort_6"]').val("<?= "{$status}" ?>");
        </script><?php
        $DB->select("*","{$table}","`{$column}` =  '{$status}'");
        global $SQL_QUERY_select_data;
        $SQL_QUERY_select_data = $DB->sql_query_select;
    }

//    function selected_data($table, $where = '', $sort = '', $search_tr = 0)
//    {
//        global $DB;
//        global $searched_tr, $SQL_QUERY_select_data, $max_count;
//        $searched_tr = $search_tr;
//
//        $DB->select("*","{$table}","{$where}", "{$sort}");
//        $SQL_QUERY_select_data = $DB->sql_query_select;
//        //if ($SQL_QUERY_select_data != null)
//        //{ $max_count = mysqli_num_rows($SQL_QUERY_select_data); }
//    }

?>