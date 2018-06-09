<?php
    interface table_interface
    {
        public function table_list();
        public function current_table($name, $cell_array);

    }

    class TABLE implements table_interface
    {

        private $mysqli;
        public $table_list;
        public $table_data;

        function __construct()
        {
            $this->mysqli = new DB;
            $this->mysqli->mysqli();
        }

        function table_list($released = "")
        {
            unset($this->table_list);
            if ($released != '') { $where = "`released` = '{$released}'"; }
            $this->mysqli->select("*","tables_namespace", "{$where}");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select)) { $this->table_list[] = $array; }
            foreach ($this->table_list as $key => $value)
            {
                foreach ($value as $n_key => $n_value) { $this->table_list[$value[1]][$n_key] = $n_value; }
                unset($this->table_list[$key]);
            }

            if ($released == '')
            { foreach ($this->table_list as $key => $value) { foreach ($value as $t_key => $t_value) { if ((!is_numeric($t_key)) || (($t_key == '0'))) { unset($this->table_list[$key][$t_key]); } } } }
            elseif ($released != '')
            { foreach ($this->table_list as $key => $value) { foreach ($value as $t_key => $t_value) { if ((is_numeric($t_key)) || (($t_key === 'id'))) { unset($this->table_list[$key][$t_key]); } } } }
            //pre($this->table_list);
        }


        function current_table($name, $cell_array)
        {
            //pre($cell_array);
            echo '<div style = "background: black; color: red;">-- -- -- current_table -- -- -- </div>';
            foreach ($cell_array as $key => $value)
            {
                $this->mysqli->select("{$key}","{$name}");
                while ($array = mysqli_fetch_row($this->mysqli->sql_query_select))
                { $this->table_data[$key][] = $array[0]; }
            }
            unset($array);

            echo '<div style = "background: black; color: red;">-- -- -- current_table -- -- -- </div>';
        }
    }

    $TABLE = new TABLE;
?>