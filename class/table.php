<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/class/macro.php');

    abstract class table_interface
    {
        abstract function table_list();
        abstract function current_table($name, $cell_array, $macro);
        abstract function tr_delete($table, $id, $page_title, $title, $fio, $macro);
        abstract function tr_edit($table, $page_title, $title, $fio, $macro);
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


        function current_table($name, $cell_array, $macro = null)
        {
            unset($this->table_data, $table_data);
            if ($_COOKIE['user'] == 'admin')
            {
                $this->mysqli->show("{$name}");
                if ($this->mysqli->sql_query_show != '')
                {
                    while ($array = mysqli_fetch_array($this->mysqli->sql_query_show)) { $temp_cell_array[] = $array; }
                    foreach ($temp_cell_array as $key => $value) { $cell_array[$value[0]] = '+'; }
                }
            }

            foreach ($cell_array as $key => $value)
            {
                $this->mysqli->select("{$key}","{$name}");
                if ($this->mysqli->sql_query_select != '')
                {
                    $n_count = 0;
                    while ($row = mysqli_fetch_row($this->mysqli->sql_query_select))
                    { $table_data[$key][] = $row[0]; $n_count++; }
                    $temp = array_keys($cell_array);
                }
            }

            /** Макрос формул */
            if ($macro['formula'] == 'true')
            {
                foreach($macro as $m_key => $m_value)
                {
                    if (stripos("$m_key","formula_") !== false)
                    {
                        list($new_macro, $macro_result) = explode(" = ",$m_value);
                        $new_macro = trim($new_macro);
                        $macro_result = trim($macro_result);

                        if (stripos("$macro_result"," ") === false)
                        {
                            for ($new_count = 0; $new_count <= $n_count - 1; $new_count++)
                            {

                                $table_data[$new_macro][$new_count] = $table_data[$macro_result][$new_count];
                                //echo $table_data.'['.$macro_result.']['.$new_count.']<br>';
                            }
                        }
                        if (stripos("$macro_result"," ") !== false)
                        {
                            list($wg_1, $sign_1, $wg_2, $sign_2, $wg_3) = explode(" ","{$macro_result}");
                            //pre($macro_result);
                            for ($new_count = 0; $new_count <= $n_count - 1; $new_count++)
                            {
                                if ($sign_1 == '+')     { $res[$new_count] = $table_data[$wg_1][$new_count] + $wg_2; }
                                elseif ($sign_1 == '-') { $res[$new_count] = $table_data[$wg_1][$new_count] - $wg_2; }
                                elseif ($sign_1 == '*') { $res[$new_count] = $table_data[$wg_1][$new_count] * $wg_2; }
                                elseif ( $wg_2 != 0)
                                {
                                    if ($sign_1 == '/') { $res[$new_count] = $table_data[$wg_1][$new_count] / $wg_2; }
                                    else { $res[$new_count] = ''; }
                                }

                                //pre($res);
                                //echo $wg_1.' '.$sign_1.' '.$wg_2.'<br>';



                                if ($sign_2 == '+')     { $table_data[$new_macro][$new_count] = $res[$new_count] + table_data[$wg_3][$new_count]; }
                                elseif ($sign_2 == '-') { $table_data[$new_macro][$new_count] = $res[$new_count] - table_data[$wg_3][$new_count]; }
                                elseif ($sign_2 == '*') { $table_data[$new_macro][$new_count] = $res[$new_count] * table_data[$wg_3][$new_count]; }
                                elseif (($table_data[$wg_3][$new_count] != 0) && ($res[$new_count] != ''))
                                {
                                    if ($sign_2 == '/') { $table_data[$new_macro][$new_count] = $res[$new_count] / $table_data[$wg_3][$new_count]; }
                                    else { $table_data[$new_macro][$new_count] = ''; }
                                }

                                //$table_data[$new_macro][] = $table_data[$macro_result][$new_count];
                                //echo $table_data.'['.$macro_result.']['.$new_count.']<br>';
                            }
                        }

                    }
                }

            }
           // pre(count($n_count));
            //pre($table_data);
            /** Макрос формул */
            //pre($table_data);

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
            /** ↓ dump macros ↓ **/
            if (stripos("{$project}","_dump") !== false)
            { list($project) = explode("_dump",$project); }
            /** ↑ dump macros ↑ **/

            $count = 0;
            $this->mysqli->select("id","{$project}");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
            { $count++; }

            return ($count - 2);
        }

        function logs($page_title, $title, $fio, $macro, $status)
        {
            if (isset ($macro['logs_id']))
            {
                $tr = '';
                foreach ($_POST as $key => $value)
                {
                    if (stripos("{$key}","{$macro['logs_id']}") !== false)
                    {
                        list($temp, $temp, $check) = explode('-',$key);
                        if ($check == $macro['logs_id'])
                        { $tr .= $value; }
                    }
                }
                $this->mysqli->insert("!sys_log_add_del","null, '".trim($fio)."', '{$_SERVER['REMOTE_ADDR']}', '".date("d.m.Y")."', '".date("H:i:s")."', '{$page_title}', '".$title[$macro['logs_id']]."', '".htmlspecialchars($tr)."', '{$status}'");
            }
        }

        function tr_arch($table, $tr)
        {
            $value = '';
            $this->mysqli->select("*","{$table}","`id` = '{$tr}'");
            while($array = mysqli_fetch_array($this->mysqli->sql_query_select))
            { $val[] = $array; }
            foreach ($val as $key => $temp_value)
            {
                foreach ($temp_value as $n_key => $n_value)
                {
                    if (!is_numeric($n_key))
                    {
                        if ($value == '') { $value = "'{$n_value}'"; }
                        else { $value .= ", '{$n_value}'"; }
                    }
                }
            }
            $this->mysqli->insert("{$table}_dump","{$value}");
            $this->mysqli->delete("{$table}","`id` = '{$tr}'");
        }

        function tr_delete($table, $id, $page_title, $title, $fio, $macro)
        {
            $this->logs($page_title, $title, $fio, $macro, 'deleted');
            $this->mysqli->delete("{$table}","`id` = '{$id}'");
        }


        function tr_edit($table, $page_title, $title, $fio, $macro)
        {

            if ((isset ($macro)) && ($macro['additional_autocomplete'] == 'true'))
            {
                $this->mysqli->show("{$table}_additional_autocomplete");
                while ($array = mysqli_fetch_array($this->mysqli->sql_query_show))
                { $temp_additional_title[] = $array; }
                foreach ($temp_additional_title as $key => $value)
                {
                    if ($value[0] != 'id')
                    { $additional_title[] = $value[0]; }
                }
            }

            foreach ($_POST as $key => $value)
            {
                if (stripos($key,"text-") !== false)
                { list($temp, $row, $cell[]) = explode("-", $key); }
            }


            foreach ($cell as $key => $value)
            {

                if ($additional_title[0] == $value)
                {
                    $this->mysqli->select("*","{$table}_additional_autocomplete","`{$value}` = '{$_POST["text-{$row}-{$value}"]}'");
                    while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
                    { $temp_add_complete = $array; }

                    if ($temp_add_complete != '')
                    {
                        foreach ($temp_add_complete as $kk_key => $kk_value)
                        {
                            if ((is_numeric($kk_key) || ($kk_key == 'id')) || ($kk_key == $value))
                            { unset($temp_add_complete[$kk_key]); }
                            else { $_POST["text-{$row}-{$kk_key}"] = $kk_value; }
                        }
                    }
                }
            }
            unset($cell);
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
                    if (isset ($macro['logs_id']))
                    {
                        $this->mysqli->select("{$macro['logs_id']}","{$table}","`id` = '1'");
                        $cell_id_name = implode(mysqli_fetch_row($this->mysqli->sql_query_select));
                        $this->mysqli->select("{$macro['logs_id']}","{$table}","`id` = '{$row}'");
                        $cell_id = implode(mysqli_fetch_row($this->mysqli->sql_query_select));
                        $this->mysqli->insert("!sys_log_info","null, '{$fio}', '{$_SERVER['REMOTE_ADDR']}', '".date("d.m.Y")."', '".date("H:i:s")."', '{$page_title}', '{$cell_id_name}', '{$cell_id}', '{$title[$value]}', '{$fetch}', '".htmlspecialchars($_POST["text-{$row}-{$value}"])."'");
                    }
                    else
                    { $this->mysqli->insert("!sys_log_info","null, '{$fio}', '{$_SERVER['REMOTE_ADDR']}', '".date("d.m.Y")."', '".date("H:i:s")."', '{$page_title}', 'ID', '{$row}', '{$title[$value]}', '{$fetch}', '".htmlspecialchars($_POST["text-{$row}-{$value}"])."'"); }
                    $this->mysqli->update("{$table}","{$value}",htmlspecialchars(trim($_POST["text-{$row}-{$value}"])),"`id` = '{$row}'");
                }
            }
        }

        function add_tr($table, $page_title, $title, $fio, $macro, $status)
        {
            //pre($_POST);
            if ((isset ($macro)) && ($macro['additional_autocomplete'] == 'true'))
            {
                $this->mysqli->show("{$table}_additional_autocomplete");
                while ($array = mysqli_fetch_array($this->mysqli->sql_query_show))
                { $temp_additional_title[] = $array; }
                foreach ($temp_additional_title as $key => $value)
                {
                    if ($value[0] != 'id')
                    { $additional_title[] = $value[0]; }
                }
            }

            foreach ($_POST as $key => $value)
            {
                if (stripos($key,"text-") !== false)
                { list($temp, $row, $cell[]) = explode("-", $key); }
            }

            for ($count = 1; $count <= $macro['autocomplete_count']; $count++)
            {
                $autocomplete[$macro["autocomplete_{$count}"]]['name'] = $macro["autocomplete_{$count}"];
                $autocomplete[$macro["autocomplete_{$count}"]]['store'] = $macro["autocomplete_{$count}_store"];
                $autocomplete[$macro["autocomplete_{$count}"]]['value'] = $macro["autocomplete_{$count}_value"];
            }

            if ($autocomplete != '')
            {
                foreach ($autocomplete as $k_key => $k_value)
                {
                    if ($k_value['store'] == 'sql')
                    { $name = $k_value['name']; }
                }

                $this->mysqli->select("*","{$table}_additional_autocomplete","`{$additional_title[0]}` = '{$_POST['text--'.$name]}'");
                if ($this->mysqli->sql_query_select)
                {
                    while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
                    { $temp_add_complete = $array; }

                    if ($temp_add_complete != '')
                    {
                        foreach ($temp_add_complete as $kk_key => $kk_value)
                        {
                            if (($kk_key == $temp_add_complete[0]) || ($kk_key == 'id') || (is_numeric($kk_key)))
                            { unset($temp_add_complete[$kk_key]); }
                            elseif (!isset ($_POST["text--{$kk_key}"])) { $_POST["text--{$kk_key}"] = $kk_value; }
                        }
                    }
                    else
                    {
                        foreach ($additional_title as $kk_key => $kk_value)
                        {
                            if (($kk_value != $additional_title[0]) && ($_POST["text--{$kk_value}"] == ''))
                            { $_POST["text--{$kk_value}"] = ''; }
                        }
                    }
                }




            }



            $str = 'null';
            foreach ($_POST as $key => $value)
            {
                if (stripos($key,"text-") !== false)
                { $str .= ", ''"; }
            }

            $this->mysqli->insert("{$table}","{$str}");
            $this->mysqli->select("id","{$table}");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
            { $id = $array[0]; }

            foreach ($_POST as $key => $value)
            {
                if (stripos($key, "selectac-") !== false)
                {
                    list($temp, $temp, $add) = explode("-",$key);
                    $add_val = $value;
                }
                if ((stripos($key,"text-") !== false) && ($value != ''))
                {
                    list($temp, $temp, $cell) = explode("-",$key);
                    if ($add == $cell) { $value = $add_val.trim($value); }
                    $this->mysqli->update("{$table}","{$cell}",htmlspecialchars(trim($value)),"`id` = '{$id}'");
                }
            }
            $this->logs($page_title, $title, $fio, $macro, 'added');
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
                    if (is_numeric($key))
                    { unset($title[$key]); }
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
                if (!is_numeric($a_key))
                {
                    $a_value = trim($a_value);
                    if ($cell == $a_value)
                    { $cell = $a_key; break; }
                }
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