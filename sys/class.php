<?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/body/sys/translit.php');
    class DB
    {
        public $sql_query_select;
        public $sql_query_show;
        public $mysqli;

        public function mysqli()
        {
            $descriptor = fopen($_SERVER['DOCUMENT_ROOT'].'/sys.txt', 'r');
            if ($descriptor)
            {
                while (($string = fgets($descriptor)) !== false)
                {

                    if (strpos($string, 'alias') !== false)
                    {
                        $link = explode("=","{$string}");
                        $link = $link[1];
                        $link = str_replace(";","","{$link}");
                        $link = str_replace("'","","{$link}");
                        $link = str_replace(" ","","{$link}");
                        $link = str_replace("\n","","{$link}");
                        $link = str_replace("\r","","{$link}");
                    }

                }
                fclose($descriptor);
            }
            $mysqli = new mysqli("localhost", "root", "".$link, "rtk_01");
            $this->mysqli = $mysqli;
            mysqli_set_charset($mysqli, 'utf8');
        }

        public function select($value, $table, $where = '', $order = '', $limit = '')
        {
            if ($value != '*') { $value = "`{$value}` "; }
            if ($where != null) { $where = " WHERE {$where} "; }
            if (($order != null) && ($order == '`rid_obekta` ASC')) { $order = " ORDER BY {$order} "; }
            elseif ($order != null) { $order = " ORDER BY `{$order}` "; }
            if ($limit != null) { $limit = " LIMIT {$limit}"; }
            $this->sql_query_select = $this->mysqli->query("SELECT {$value} FROM `{$table}`{$where}{$order}{$limit}");
            //echo "SELECT {$value} FROM `{$table}`{$where}{$order}{$limit}<br>";
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
            //echo "ALTER TABLE `{$table}` DROP `{$cell}`<br>";
        }

        public function alter_replace($table, $cell_current, $cell_other)
        {
            $this->mysqli->query("ALTER TABLE `{$table}` MODIFY COLUMN `{$cell_current}` TEXT AFTER `{$cell_other}`");
            //echo "ALTER TABLE `{$table}` MODIFY COLUMN `{$cell_current}` TEXT AFTER `{$cell_other}`<br>";
        }

        public function show($table)
        {
            $this->sql_query_show = $this->mysqli->query("SHOW COLUMNS FROM `{$table}`");
            //echo "SHOW COLUMNS FROM `{$table}`<br>";
        }

        public function create($table)
        {
            $this->mysqli->query("CREATE TABLE `".translit($table)."`               (`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT)");
            $this->mysqli->query("CREATE TABLE `".translit($table)."_permission`    (`id` INT NOT NULL AUTO_INCREMENT, `".translit($table)."_group` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB");
            $this->mysqli->query("CREATE TABLE `".translit($table)."_table`         (`id` INT NOT NULL AUTO_INCREMENT, `name` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `sql_name` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB");
            $this->mysqli->query("CREATE TABLE `".translit($table)."_vision`        (`id` INT NOT NULL AUTO_INCREMENT, `id_tr` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB");
            $this->insert("tables_namespace","null, '".translit($table)."', '$table', '+'");
        }
    }


    $DB = new DB;
    $DB->mysqli();
?>