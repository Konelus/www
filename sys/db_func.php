<?php
    require_once ($_SERVER['DOCUMENT_ROOT'].'/class/connection.php');
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
?>