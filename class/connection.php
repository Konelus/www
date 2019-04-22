<?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/body/sys/translit.php');
    class DB
    {
        public $sql_query_select;
        public $sql_query_show;
        public $mysqli;

        function mysqli($link = '')
        {
            $mysqli = new mysqli("localhost", "root", "".$link, "rtk_01");
            $this->mysqli = $mysqli;
            mysqli_set_charset($mysqli, 'utf8');
        }

        function select($value, $table, $where = '', $order = '', $limit = '')
        {
            if ($value != '*') { $value = "`{$value}` "; }
            if ($where != null) { $where = " WHERE {$where} "; }
            if (($order != null) && ($order == '`rid_obekta` ASC')) { $order = " ORDER BY {$order} "; }
            elseif ($order != null) { $order = " ORDER BY {$order} "; }
            if ($limit != null) { $limit = " LIMIT {$limit}"; }
            $this->sql_query_select = $this->mysqli->query("SELECT {$value} FROM `{$table}`{$where}{$order}{$limit}");
            //echo "<div style = 'background: darkblue; color: yellow;'>SELECT {$value} FROM `{$table}`{$where}{$order}{$limit}</div>";
        }


        function insert($table, $values)
        {
            $this->mysqli->query("INSERT INTO `{$table}` VALUES ({$values})");
            //echo "INSERT INTO `{$table}` VALUES ({$values})<br>";
        }

        function update($table, $cell, $value, $where = '')
        {
            if ($where != null) { $where = " WHERE {$where}"; }
            $this->mysqli->query("UPDATE `{$table}` SET `{$cell}` = '{$value}'{$where}");
            //echo "UPDATE `{$table}` SET `{$cell}` = '{$value}'{$where}<br>";
        }

        function delete($table, $where = '')
        {
            if ($where != null) { $where = " WHERE {$where}"; }
            $this->mysqli->query("DELETE FROM `{$table}`{$where}");
            //echo "DELETE FROM `{$table}`{$where}<br>";
        }

        function alter_add($table, $cell, $datatype = ' TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ')
        {
            $this->mysqli->query("ALTER TABLE `{$table}` ADD `{$cell}` {$datatype}");
            //echo "ALTER TABLE `{$table}` ADD `{$cell}` {$datatype}<br>";
        }

        function alter_drop($table, $cell)
        {
            $this->mysqli->query("ALTER TABLE `{$table}` DROP `{$cell}`");
            //echo "ALTER TABLE `{$table}` DROP `{$cell}`<br>";
        }

        function alter_replace($table, $cell_current, $cell_other)
        {
            $this->mysqli->query("ALTER TABLE `{$table}` MODIFY COLUMN `{$cell_current}` TEXT AFTER `{$cell_other}`");
            //echo "ALTER TABLE `{$table}` MODIFY COLUMN `{$cell_current}` TEXT AFTER `{$cell_other}`<br>";
        }

        function drop($table)
        {
            $this->mysqli->query("DROP TABLE `{$table}`");
        }

        function show($table = 'TABLES', $t_var = '')
        {
            if ($table == 'TABLES') { $t_var =  $table; }
            else { $t_var = "COLUMNS FROM `{$table}`"; }
            $this->sql_query_show = $this->mysqli->query("SHOW {$t_var}");
            //echo "SHOW {$t_var}<br>";
        }

        function create($table)
        {
            if ($table != '')
            {
                $this->mysqli->query("CREATE TABLE `".translit($table)."`               (`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT)");
                $this->mysqli->query("CREATE TABLE `".translit($table)."_permission`    (`id` INT NOT NULL AUTO_INCREMENT, `".translit($table)."_group` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB");
                $this->mysqli->query("CREATE TABLE `".translit($table)."_vision`        (`id` INT NOT NULL AUTO_INCREMENT, `id_tr` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB");
                $this->select("id","!sys_tables_namespace","`description` = '{$table}'");
                $check = mysqli_fetch_row($this->sql_query_select);
                if ($check == '')
                { $this->insert("!sys_tables_namespace","null, '".translit($table)."', '$table', '1', '0', '0'"); }
                else { echo "<script>alert('Проект уже существует')</script>"; }
                $this->alter_add("!sys_group_namespace",translit($table));
                $this->alter_add("!sys_group_namespace",translit($table).'_status');
                $this->insert(translit($table),"null");
            }
        }
    }


    $DB = new DB;
    $DB->mysqli();

    function pre($array)
    {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
?>