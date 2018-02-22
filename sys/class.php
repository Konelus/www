<?php
    class DB
    {
        public $sql_query_select;
        public $sql_query_select_plus;
        public $mysqli;

        function mysqli()
        {
            $link = '';
            $descriptor = fopen($_SERVER['DOCUMENT_ROOT'].'/link.txt', 'r');
            if ($descriptor) { while (($string = fgets($descriptor)) !== false) { $link = $link.$string; } fclose($descriptor); }
            $mysqli = new mysqli("localhost", "root", "".$link, "rtk_01");
            $this->mysqli = $mysqli;
            mysqli_set_charset($mysqli, 'utf8');

        }

        function select($value, $table, $where)
        {
            if ($where != null) { $where = ' WHERE '.$where; }
            $this->sql_query_select = $this->mysqli->query("SELECT `{$value}` FROM `{$table}`{$where}");
            //echo "SELECT `".$value."` FROM `".$table."`".$where.'<br>';
        }

        function select_plus($value, $table, $where, $order, $sort, $limit)
        {
            if ($where != null) { $where = " WHERE {$where}"; }
            if ($order != null) { $order = " ORDER BY `{$order}`"; }
            if ($limit != null) { $limit = " LIMIT {$limit}"; }
            $this->sql_query_select_plus = $this->mysqli->query("SELECT `{$value}` FROM `{$table}`{$where}{$order}{$sort}{$limit}");
        }

        function insert($table, $values)
        {
            $this->mysqli->query("INSERT INTO `{$table}` VALUES ({$values})");
            //echo "INSERT INTO `{$table}` VALUES ({$values})<br>";
        }

        function update($table, $cell, $value, $where)
        {
            if ($where != null) { $where = " WHERE {$where}"; }
            $this->mysqli->query("UPDATE `{$table}` SET `{$cell}` = '{$value}'{$where}");
            //echo "UPDATE `{$table}` SET `{$cell}` = '{$value}'{$where}<br>";
        }

        function delete($table, $where)
        {
            if ($where != null) { $where = " WHERE {$where}"; }
            $this->mysqli->query("DELETE FROM `{$table}`{$where}");
            //echo "DELETE FROM `{$table}`{$where}<br>";
        }
    }

    $DB = new DB;
    $DB->mysqli();
?>