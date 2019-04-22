<?php

    abstract class abstract_other
    {
        abstract function ver();
        abstract function table_title();
    }

    class OTHER extends abstract_other
    {

        private $mysqli;
        private $view;

        function __construct()
        {
            $this->mysqli = new DB;
            $this->mysqli->mysqli();

            foreach ($_GET as $key => $value)
            {
                /** ↓ dump macros ↓ **/
                $this->view['key'] = $key;
                if (stripos("{$value}","_dump") !== false)
                { list($this->view['value']) = explode("_dump","{$value}"); }
                /** ↑ dump macros ↑ **/
                else { $this->view['value'] = $value; }
            }
        }

        function ver()
        {
            $this->mysqli->select("ver","!sys_ver");
            $ver = implode(mysqli_fetch_row($this->mysqli->sql_query_select));
            return $ver;
            //$current_ver = explode('.', "{$ver}");
        }

        function table_title()
        {
            if (($this->view['key'] == 'project') && (stripos($_SERVER['QUERY_STRING'],"_dump") === false))
            {
                $this->mysqli->select("description","!sys_tables_namespace","`name` = '{$this->view['value']}'");
                $return = implode(mysqli_fetch_row($this->mysqli->sql_query_select));
            }
            elseif (($this->view['key'] == 'project') && (stripos($_SERVER['QUERY_STRING'],"_dump") !== false))
            {
                $this->mysqli->select("description","!sys_tables_namespace","`name` = '{$this->view['value']}'");
                $return = implode(mysqli_fetch_row($this->mysqli->sql_query_select))." - <span style = 'color: gold;'>ARCHIVE</span>";
            }
            else { $return = 'ELASTIC 2'; }
            return $return;
        }
    }

    $OTHER = new OTHER;
?>