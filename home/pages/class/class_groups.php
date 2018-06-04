<?php

    require_once($_SERVER['DOCUMENT_ROOT']."/sys/class.php");

    abstract class ABSTRACT_ADM_GROUPS
    {
        abstract function tables_list();
        abstract function groups_list();
        abstract function add_group($group_name);
        abstract function group_access($group_name);
    }

    class ADM_GROUPS extends ABSTRACT_ADM_GROUPS
    {
        private $mysqli;
        public $columns_rus;
        public $cell_value;
        private $group_cells_count;
        public $group_access;

        public function __construct()
        {
            $this->mysqli = new DB();
            $this->mysqli->mysqli();
        }

        function tables_list()
        {
            $this->mysqli->select("*","tables_namespace");
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
            $this->mysqli->select("*","group_namespace");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
            { $temporary_cell_value[] = $array; }

            foreach ($temporary_cell_value as $key => $value)
            {
                $this->group_cells_count = 0;
                foreach ($value as $v_key => $v_value)
                {
                    if (!is_numeric($v_key))
                    { unset($temporary_cell_value[$key][$v_key], $v_key); }
                    if ($v_key != 0)
                    {
                        if ($v_key > 1) { $this->cell_value[$key][$v_key - 1] = "<div style = 'background: lightgreen;'>{$temporary_cell_value[$key][$v_key]}</div>"; }
                        else { $this->cell_value[$key][$v_key - 1] = $temporary_cell_value[$key][$v_key]; }
                        unset($temporary_cell_value[$key][$v_key]);
                    }
                    if ((($v_key - 1) % 2) != 0)
                    { unset($this->cell_value[$key][$v_key - 1]); }
                }
            }
        }

        function add_group($group_name)
        {
                $this->groups_list();
                $sql_str = "null, '{$group_name}'";
                for ($count = 1; $count <= ($this->group_cells_count - 2); $count++)
                { $sql_str .= ", ''"; }
                $this->mysqli->insert("group_namespace","{$sql_str}");
        }

        function group_access($group_name)
        {
            $this->mysqli->select("*","group_namespace","`name` = '{$group_name}'");
            $this->group_access = mysqli_fetch_array($this->mysqli->sql_query_select);
            unset ($this->group_access['id'], $this->group_access['name']);
            foreach ($this->group_access as $a_key => $a_value)
            { if ((is_numeric($a_key)) || (stripos("{$a_key}","_status") === false)) { unset($this->group_access[$a_key]); } }
        }
    }

    $ADM_GROUPS = new ADM_GROUPS();
?>