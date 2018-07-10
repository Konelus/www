<?php
    abstract class table_interface
    {
        abstract function table_list();
        abstract function current_table($name, $cell_array);
        abstract function tr_delete($table, $id);
        abstract function tr_edit($table, $page_title, $title, $fio);
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
            if ($_COOKIE['user'] == 'admin')
            {
                $this->mysqli->show("{$name}");
                while ($array = mysqli_fetch_array($this->mysqli->sql_query_show)) { $temp_cell_array[] = $array; }
                foreach ($temp_cell_array as $key => $value) { $cell_array[$value[0]] = '+'; }
            }

            foreach ($cell_array as $key => $value)
            {
                $this->mysqli->select("{$key}","{$name}");
                if ($this->mysqli->sql_query_select != '')
                {
                    while ($row = mysqli_fetch_row($this->mysqli->sql_query_select))
                    { $table_data[$key][] = $row[0]; }
                    $temp = array_keys($cell_array);
                }
            }

            for ($count = 0; $count <= count($table_data['id']); $count++)
            {
                if ($count >= 2)
                {
                    foreach ($temp as $n_key => $n_value)
                    { $return[$table_data['id'][$count]][$n_value] = $table_data[$n_value][$count]; }
                }
            }
            return $return;
        }

        function total_tr_count($project)
        {
            $count = 0;
            $this->mysqli->select("id","{$project}");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
            { $count++; }

            return ($count - 2);
        }

        function tr_delete($table, $id)
        {
            $this->mysqli->delete("{$table}","`id` = '{$id}'");
        }


        function tr_edit($table, $page_title, $title, $fio)
        {
            foreach ($_POST as $key => $value)
            {
                if (stripos($key,"text-") !== false)
                { list($temp, $row, $cell[]) = explode("-", $key); }
            }


            foreach ($cell as $key => $value)
            {
                $this->mysqli->select("{$value}","{$table}","`id` = '{$row}'");
                if ($this->mysqli->sql_query_select != '')
                { $fetch = implode(mysqli_fetch_row($this->mysqli->sql_query_select)); }
                if ($_POST["text-{$row}-{$value}"] != $fetch)
                {
                    $this->mysqli->insert("!sys_log_info","null, '{$fio}', '{$_SERVER['REMOTE_ADDR']}', '".date("d.m.Y")."', '".date("H:i:s")."', '{$page_title}', '{$row}', '{$title[$value]}', '{$fetch}', '".htmlspecialchars($_POST["text-{$row}-{$value}"])."'");
                    $this->mysqli->update("{$table}","{$value}",htmlspecialchars($_POST["text-{$row}-{$value}"]),"`id` = '{$row}'");
                }
            }
        }

        function add_tr($table)
        {
            $val = 'null';
            foreach ($_POST as $key => $value)
            {
                $check = false;
                if (stripos($key,"select-") !== false)
                { $temp = "{$value}"; $check = true; }
                if (($temp != '') && ($check != true))
                {
                    if (stripos($key,"text-") !== false)
                    { $val .= ", '{$temp}{$value}'"; }
                    $temp = '';
                }
                elseif (stripos($key,"text-") !== false)
                { $val .= ", '{$value}'"; }
            }
            $this->mysqli->insert("{$table}","{$val}");

        }

        function search($caption, $cell)
        {
            if (!isset ($_POST['inversion']))
            {
                if (trim($caption) != '') { $text = "LIKE '%".trim($caption)."%'"; }
                else { $text = "= ''"; }
            }
            else { $text = "!= '".trim($caption)."'"; }

            $this->mysqli->select("*","{$_GET['project']}","`{$cell}` {$text}");
            if ($this->mysqli->sql_query_select != '')
            {
                while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
                {
                    if (($array['id'] != 1) && ($array['id'] != 2))
                    { $data[$array['id']] = $array; }
                }
            }
            return $data;
        }

        function all_title($table)
        {
            $this->mysqli->select("*","{$table}","`id` = '1'");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
            { $title = $array; }
            if ($title != '')
            {
                foreach ($title as $key => $value)
                {
                    if (is_numeric($key)) { unset($title[$key]); }
                }
            }
            return $title;
        }

        function rename_cell($table, $cell, $value)
        {
            $this->mysqli->select("*","{$table}","`id` = '1'");
            $temp = mysqli_fetch_array($this->mysqli->sql_query_select);

            foreach ($temp as $a_key => $a_value)
            {
                if (($cell == $a_value) && (!is_numeric($a_key)))
                { $cell = $a_key; break; }
            }
            $this->mysqli->update("{$table}","{$cell}","{$value}","`id` = '1'");
        }

        function delete_cell($table, $cell)
        {
            $this->mysqli->select("*","{$table}","`id` = '1'");
            $temp = mysqli_fetch_array($this->mysqli->sql_query_select);
            foreach ($temp as $a_key => $a_value)
            {
                if (($cell == $a_value) && (!is_numeric($a_key)))
                { $cell = $a_key; break; }
            }
            $this->mysqli->alter_drop("{$table}","{$cell}");
            $this->mysqli->alter_drop("{$table}_permission","{$cell}");
        }

        function replace_cell($table, $cell, $after)
        {
            if ($after == 'ID') { $after = 'id'; }
            $this->mysqli->select("*","{$table}","`id` = '1'");
            $temp = mysqli_fetch_array($this->mysqli->sql_query_select);
            foreach ($temp as $a_key => $a_value)
            {
                if (($cell == $a_value) && (!is_numeric($a_key))) { $cell = $a_key; }
                if (($after == $a_value) && (!is_numeric($a_key))) { $after = $a_key; }
            }
            $this->mysqli->alter_replace("{$table}","{$cell}","{$after}");
            if ($after == 'id') { $after = "{$table}_group"; }
            $this->mysqli->alter_replace("{$table}_permission","{$cell}","{$after}");

        }
    }

    $TABLE = new TABLE;
?>