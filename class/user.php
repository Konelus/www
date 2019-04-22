<?php

    abstract class ABSTRACT_USER
    {
        abstract function user_access();
        abstract function user_group();
        abstract function user_table();
        abstract function user_permission($substring);
        abstract function user_vision($substring);
        abstract function user_fio();
        abstract function current_table_permissions($substring);
    }

    class USER extends ABSTRACT_USER
    {

        private $mysqli;
        public $user_group;             // Получение группы пользователя
        public $user_access_status;     // Доступ пользователя к сайту
        public $user_table;
        public $user_status;
        public $user_cell_vision;
        public $user_cell_vision_name;
        public $user_cell_edit;
        public $user_row_vision;        // Видимость строк пользователем
        public $user_fio;               // ФИО пользователя

        function __construct()
        {
            $this->mysqli = new DB;
            $this->mysqli->mysqli();

            unset($this->user_group, $this->user_access_status, $this->user_table, $this->user_status, $this->user_cell_vision,
                $this->user_cell_vision_name, $this->user_cell_edit, $this->user_row_vision, $this->user_fio);
        }

        function user_access()
        {
            $this->mysqli->select("status","!sys_users","`login` = '{$_COOKIE['user']}'");
            $this->user_access_status = implode(mysqli_fetch_row($this->mysqli->sql_query_select));
        }

        function user_group()
        {
            //echo '<div style = "background: black; color: red;">-- -- -- user_group -- -- --</div>';
            if ($_COOKIE['user'] != 'admin')
            {
                $this->mysqli->select("table_group","!sys_users","`login` = '{$_COOKIE['user']}'");
                $this->user_group = implode(mysqli_fetch_row($this->mysqli->sql_query_select));
            }
            //echo '<div style = "background: black; color: red;">-- -- -- user_group -- -- --</div><br>';
        }

        function user_table()
        {
            //echo '<div style = "background: black; color: red;">-- -- -- user_table -- -- --</div>';
            $this->user_group();
            $this->mysqli->select("*","!sys_group_namespace","`name` = '{$this->user_group}'");
            $array = mysqli_fetch_array($this->mysqli->sql_query_select);
            if ($array != null)
            {
                foreach ($array as $key => $value)
                {
                    if (is_numeric($key)) { unset($array[$key]); }
                    if (($key != 'id') && ($key != 'name') && (!is_numeric($key)) && ($value != '') && ($value != '-'))
                    {
                        if ($value == '+') { $this->user_table[] = $key; }
                        elseif (($value != '+') && ($value != '-') && ($value != '')) { $this->user_status[$key] = $value; }
                    }
                }
                unset($array);
            }
            //echo '<div style = "background: black; color: red;">-- -- -- user_table -- -- -- </div><br>';
        }

        function current_table_permissions($substring)
        {
            if ($_COOKIE['user'] != 'admin')
            {
                $this->user_group();
                $this->mysqli->select("{$substring}_status","!sys_group_namespace","`name` = '{$this->user_group}'");
                while ($row = mysqli_fetch_row($this->mysqli->sql_query_select))
                { $result = $row[0]; }
                //pre(implode(mysqli_fetch_array($this->mysqli->sql_query_select)));
                //$result = implode(mysqli_fetch_array($this->mysqli->sql_query_select));
                return $result;
            }
            else { return 'superuser'; }
        }

        function user_permission($substring, $cell = '*')
        {
            //echo '<div style = "background: black; color: red;">-- -- -- user_permission -- -- -- </div>';
            //$this->user_group();

            /** ↓ dump macros ↓ **/
            if (stripos("{$substring}","_dump") !== false)
            { list($substring) = explode("_dump",$substring); }
            /** ↑ dump macros ↑ **/

            unset($this->user_cell_vision);
            unset($this->user_cell_vision_name);
            unset($this->user_cell_edit);

            if ($_COOKIE['user'] != 'admin')
            {
                $this->mysqli->select("{$cell}","{$substring}_permission","`{$substring}_group` = '{$this->user_group}'");
                $array = mysqli_fetch_array($this->mysqli->sql_query_select);
                foreach ($array as $key => $value)
                {
                    if (($key != "{$substring}_group") && (!is_numeric($key)) && ($value != '') && ($value != '-'))
                    {
                        $this->user_cell_vision[$key] = $array[$key];
                        $this->mysqli->select("{$key}","{$substring}","`id` = '1'");
                        if ($this->mysqli->sql_query_select != '')
                        {
                            while ($row =  mysqli_fetch_row($this->mysqli->sql_query_select))
                            {
                                if ($key == 'id') { $this->user_cell_vision_name['id'] =  $row[0]; }
                                elseif ($key != 'id') { $this->user_cell_vision_name[] = $row[0]; }

                            }
                        }
                    }
                }
                unset($array);

                $this->mysqli->select("{$cell}","{$substring}_permission","`{$substring}_group` = '{$this->user_group}_edit'");
                $array = mysqli_fetch_array($this->mysqli->sql_query_select);
                if ($array != '')
                {
                    foreach ($array as $key => $value)
                    {
                        if (($key != 'id') && ($key != "{$substring}_group") && (!is_numeric($key)) && ($value != '') && ($value != '-'))
                        { $this->user_cell_edit[$key] = $array[$key]; }
                    }
                    unset($array);
                }

            }
            else
            {
                $this->mysqli->show("{$substring}");
                while ($array = mysqli_fetch_array($this->mysqli->sql_query_show)) { $temp_cell_array[] = $array; }

                $this->mysqli->select("*","{$substring}", "`id` = '1'");
                $temp_cell_name = mysqli_fetch_array($this->mysqli->sql_query_select);

                foreach ($temp_cell_array as $key => $value)
                {
                    //if ($value[0] != 'id')
                    //{

                        $this->user_cell_vision[$value[0]] = '+';
                        $this->user_cell_vision_name[$key] = $temp_cell_name[$value[0]];
                        $this->user_cell_edit[$value[0]] = '+';
                    //}
                }

                //pre($this->user_cell_vision_name);
                //pre($this->user_cell_edit);
                //pre($this->user_cell_vision_name);
                //pre($temp_cell_array);
            }
            //echo '<div style = "background: black; color: red;">-- -- -- user_permission -- -- --</div><br>';
        }

        /***
         * @param $substring
         * user_vision не используется
         */
        function user_vision($substring)
        {
            //echo '<div style = "background: black; color: red;">-- -- -- user_vision -- -- -- </div>';
            $this->user_group();
            $this->mysqli->select("id_tr","{$substring}_vision","`{$this->user_group}` = '+'");
            while ($row = mysqli_fetch_row($this->mysqli->sql_query_select))
            { $this->user_row_vision[] = $row[0]; }
            unset($row);
            //echo '<div style = "background: black; color: red;">-- -- -- user_vision -- -- -- </div><br>';
        }

        function user_fio()
        {
            //echo '<div style = "background: black; color: red;">-- -- -- user_fio -- -- -- </div>';
            $this->mysqli->select("fio","!sys_users","`login` = '{$_COOKIE['user']}'");
            $fio = implode(mysqli_fetch_row($this->mysqli->sql_query_select));

            $fio = explode(" ","{$fio}");

            for ($count = 0; $count < count($fio); $count++)
            {
                if ($count > 0)
                { $fio[$count] = mb_substr($fio[$count], '0', '1', 'UTF-8').'.'; }
            }

            $this->user_fio = "{$fio[0]} {$fio[1]}{$fio[2]}";
            //echo '<div style = "background: black; color: red;">-- -- -- user_fio -- -- -- </div><br>';
        }

    }

    $USER = new USER;
    $USER->user_group;
?>