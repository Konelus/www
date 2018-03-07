<?php

    class DB
    {
        public $sql_query_select;
        public $sql_query_show;
        public $mysqli;

        public function mysqli()
        {
            $link = '';
            $descriptor = fopen($_SERVER['DOCUMENT_ROOT'].'/link.txt', 'r');
            if ($descriptor) { while (($string = fgets($descriptor)) !== false) { $link = $link.$string; } fclose($descriptor); }
            $mysqli = new mysqli("localhost", "root", "".$link, "rtk_01");
            $this->mysqli = $mysqli;
            mysqli_set_charset($mysqli, 'utf8');
        }

        public function select($value, $table, $where = '', $sort = '', $order = '', $limit = '')
        {
            if ($value != '*') { $value = "`{$value}`"; }
            if ($where != null) { $where = " WHERE {$where}"; }
            if ($order != null) { $order = " ORDER BY `{$order}`"; }
            if ($limit != null) { $limit = " LIMIT {$limit}"; }
            $this->sql_query_select = $this->mysqli->query("SELECT {$value} FROM `{$table}`{$where}{$order}{$sort}{$limit}");
            //echo "SELECT {$value} FROM `{$table}`{$where}{$order}{$sort}{$limit}<br>";
        }

        public function insert($table, $values)
        {
            $this->mysqli->query("INSERT INTO `{$table}` VALUES ({$values})");
            //echo "INSERT INTO `{$table}` VALUES ({$values})<br>";
        }

        public function update($table, $cell, $value, $where = '')
        {
            if ($where != null) { $where = " WHERE {$where}"; }
            $this->mysqli->query("UPDATE `{$table}` SET `{$cell}` = '{$value}'{$where}");
            //echo "UPDATE `{$table}` SET `{$cell}` = '{$value}'{$where}<br>";
        }

        public function delete($table, $where = '')
        {
            if ($where != null) { $where = " WHERE {$where}"; }
            $this->mysqli->query("DELETE FROM `{$table}`{$where}");
            //echo "DELETE FROM `{$table}`{$where}<br>";
        }

        public function alter_add($table, $cell, $datatype = '')
        {
            $this->mysqli->query("ALTER TABLE `{$table}` ADD `{$cell}` {$datatype}");
            //echo "ALTER TABLE `{$table}` ADD `{$cell}` {$datatype}<br>";
        }

        public function alter_drop($table, $cell)
        {
            $this->mysqli->query("ALTER TABLE `{$table}` DROP `{$cell}`");
            //echo "ALTER TABLE `{$table}` ADD `{$cell}`<br>";
        }

        public function show($table)
        {
            $this->sql_query_show = $this->mysqli->query("SHOW COLUMNS FROM `{$table}`");
        }
    }


    $DB = new DB;
    $DB->mysqli();
?>