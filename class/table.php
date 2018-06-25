<?php
    abstract class table_interface
    {
        abstract function table_list();
        abstract function current_table($name, $cell_array);
        abstract function tr_delete($table, $id);
        abstract function tr_edit();
    }

    class TABLE extends table_interface
    {

        private $mysqli;
        public $table_list;
        public $table_data;

        function __construct()
        {
            $this->mysqli = new DB;
            $this->mysqli->mysqli();

            unset($this->table_list, $this->table_data);
        }

        function table_list($released = "")
        {
            unset($this->table_list);
            if ($released != '') { $where = "`released` = '{$released}'"; }
            $this->mysqli->select("*","!sys_tables_namespace", "{$where}");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select)) { $this->table_list[] = $array; }
            foreach ($this->table_list as $key => $value)
            {
                foreach ($value as $n_key => $n_value) { $this->table_list[$value[1]][$n_key] = $n_value; }
                unset($this->table_list[$key]);
            }

            if ($released == '')
            { foreach ($this->table_list as $key => $value) { foreach ($value as $t_key => $t_value) { if ((is_numeric($t_key)) || (($t_key == '0'))) { unset($this->table_list[$key][$t_key]); } } } }
            elseif ($released != '')
            { foreach ($this->table_list as $key => $value) { foreach ($value as $t_key => $t_value) { if ((is_numeric($t_key)) || (($t_key === 'id'))) { unset($this->table_list[$key][$t_key]); } } } }
        }


        function current_table($name, $cell_array)
        {
            unset($this->table_data, $table_data);
            //echo '<div style = "background: black; color: red;">-- -- -- current_table -- -- -- </div>';
            foreach ($cell_array as $key => $value)
            {
                $this->mysqli->select("{$key}","{$name}");
                while ($row = mysqli_fetch_row($this->mysqli->sql_query_select))
                { $table_data[$key][] = $row[0]; }
                $temp = array_keys($cell_array);
            }

            for ($count = 0; $count <= count($table_data['id']); $count++)
            {
                if ($count >= 2)
                {
                    foreach ($temp as $n_key => $n_value)
                    {
                        if ($n_key != 'id') { $this->table_data[$table_data['id'][$count]][$n_value] = $table_data[$n_value][$count]; }
                    }
                }
            }
            //pre($this->table_data);
            //echo '<div style = "background: black; color: red;">-- -- -- current_table -- -- -- </div>';
        }

        function tr_delete($table, $id)
        {
            $this->mysqli->delete("{$table}","`id` = '{$id}'");
        }

        function tr_edit()
        {
            //pre($_POST);
        }

    }

    $TABLE = new TABLE;
?>