<?php
    interface table_interface
    {
        public function t_list();
        public function t_released();
    }

    class TABLE implements table_interface
    {

        private $mysqli;
        public $table_list;
        public $table_released;

        function __construct()
        {
            $this->mysqli = new DB;
            $this->mysqli->mysqli();
        }

        function t_list()
        {
            $this->mysqli->select("*","tables_namespace");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
            { $this->table_list[] = $array; }
            //pre($this->table_list);
        }

        function t_released()
        {
            $this->mysqli->select("*","tables_namespace", "`released` = '1'");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
            { $this->table_released[] = $array; }
            //pre($this->table_released);
        }
    }

    $TABLE = new TABLE;
?>