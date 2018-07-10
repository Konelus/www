<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/class/connection.php');

    abstract class ABSTRACT_ADM_GROUPS
    {
        abstract function tables_list();
        abstract function groups_list();
        abstract function add_group($group_name);
        abstract function group_access($group_name);
        abstract function del_group($group_name);
        abstract function edit_group($group_name);
    }

    class ADM_GROUPS extends ABSTRACT_ADM_GROUPS
    {
        private $mysqli;
        public $columns_rus;
        public $cell_value;
        public $group_access;

        public function __construct()
        {
            $this->mysqli = new DB();
            $this->mysqli->mysqli();
        }

        function tables_list()
        {
            $this->mysqli->select("*","!sys_tables_namespace");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
            { $temporary_columns_rus[] = $array; }

            foreach ($temporary_columns_rus as $key => $value)
            {
                $this->columns_rus[$key][0] = $temporary_columns_rus[$key][1];
                $this->columns_rus[$key][1] = $temporary_columns_rus[$key][2];
                $this->columns_rus[$key][2] = $temporary_columns_rus[$key][3];
            }
        }

        function groups_list()
        {
            $this->mysqli->select("*","!sys_group_namespace");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
            { $temporary_cell_value[] = $array; }

            if ($temporary_cell_value != '')
            {
                foreach ($temporary_cell_value as $key => $value)
                {
                    foreach ($value as $v_key => $v_value)
                    {
                        if (!is_numeric($v_key))
                        { unset($temporary_cell_value[$key][$v_key], $v_key); }
                        if ($v_key != 0)
                        {
                            if ($v_key > 1) { $this->cell_value[$key][$v_key - 1] = "<div style = 'background: lightgreen;'>{$temporary_cell_value[$key][$v_key]}</div>"; }
                            else { $this->cell_value[$key][$v_key - 1] = $temporary_cell_value[$key][$v_key]; }
                            unset($this->cell_value[$key][$v_key]);
                        }
                        if ((($v_key - 1) % 2) != 0)
                        { unset($this->cell_value[$key][$v_key - 1]); }
                    }
                }
            }
        }

        function add_group($group_name)
        {
                $this->mysqli->show("!sys_group_namespace");
                while ($array = mysqli_fetch_array($this->mysqli->sql_query_show))
                { $show[] = $array; }
                $sql_str = "null, '{$group_name}'";
                for ($count = 1; $count <= (count($show) - 2); $count++)
                { $sql_str .= ", ''"; }
                $this->mysqli->insert("!sys_group_namespace","{$sql_str}");
        }

        function group_access($group_name)
        {
            $this->mysqli->select("*","!sys_group_namespace","`name` = '{$group_name}'");
            $this->group_access = mysqli_fetch_array($this->mysqli->sql_query_select);
            unset ($this->group_access['id'], $this->group_access['name']);
            foreach ($this->group_access as $a_key => $a_value)
            { if ((is_numeric($a_key)) || (stripos("{$a_key}","_status") === false)) { unset($this->group_access[$a_key]); } }
        }

        function del_group($group_name)
        {
            $this->mysqli->delete("!sys_group_namespace","`name` = '{$group_name}'");
            $this->mysqli->update("!sys_users","table_group","","`table_group` = '{$group_name}'");
        }

        function edit_group($group_name)
        {
            $this->tables_list();
            foreach ($_POST as $key => $value)
            {
                if (($key != 'hidden') && ($key != 'edit_btn'))
                {

                    $this->mysqli->select("id","{$key}_permission","`{$key}_group` = '{$group_name}'");
                    if ($this->mysqli->sql_query_select != '') { $check = mysqli_fetch_array($this->mysqli->sql_query_select); }
                    else { $check = ''; }
                    //echo "$key";
                    //pre($check);
                    if ($value == '') { $val = ''; }
                    elseif ($value != '') { $val = '+'; }

                    if (($value == '') && ($check != ''))
                    {
                        $this->mysqli->delete("{$key}_permission","`{$key}_group` = '{$group_name}'");
                        $this->mysqli->delete("{$key}_permission","`{$key}_group` = '{$group_name}_edit'");
                    }
                    elseif (($value != '') && ($check == ''))
                    {



                            $this->mysqli->show("{$key}_permission");
                            if ($this->mysqli->sql_query_show != '')
                            {
                                $count = 0;
                                while ($temp = mysqli_fetch_array($this->mysqli->sql_query_show)) { $count++; }
                                $str = $str_edit = '';
                                for ($str_count = 0; $str_count < $count; $str_count++)
                                {
                                    if ($str_count == 0) { $str = $str_edit = 'null, '; }
                                    elseif ($str_count == 1)
                                    { $str .= "'{$group_name}'"; $str_edit .= "'{$group_name}_edit'"; }
                                    else
                                    {
                                        $str .= ", '+'";
                                        if ($value == 'superuser') { $str_edit .= ", '+'"; }
                                        else { $str_edit .= ", '-'"; }
                                    }
                                }
                                $this->mysqli->insert("{$key}_permission","{$str}");
                                $this->mysqli->insert("{$key}_permission","{$str_edit}");
                            }
                    }

                    $this->mysqli->update("!sys_group_namespace", "{$key}", "{$val}", "`name` = '{$group_name}'");
                    $this->mysqli->update("!sys_group_namespace", "{$key}_status", "{$value}", "`name` = '{$group_name}'");
                }
            }
        }
    }

    $ADM_GROUPS = new ADM_GROUPS();
?>