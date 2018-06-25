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
                $this->view['key'] = $key;
                $this->view['value'] = $value;
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
            if ($this->view['value'] != '')
            {
                $this->mysqli->select("description","!sys_tables_namespace","`name` = '{$this->view['value']}'");
                $return = implode(mysqli_fetch_row($this->mysqli->sql_query_select));
            }
            else { $return = 'ELASTIC 2'; }
            return $return;
        }
    }

    $OTHER = new OTHER;
?>