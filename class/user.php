<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');

    interface user_interface
    {
        public function user_group();
        public function user_table();
        public function user_permission($substring);
        public function user_vision($substring);
        public function user_fio();
    }

    class USER implements user_interface
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
        }

        function user_group()
        {
            echo '<div style = "background: black; color: red;">-- -- -- user_group -- -- --</div>';
            $this->mysqli->select("table_group","users","`login` = '{$_COOKIE['user']}'");
            $this->user_group = implode(mysqli_fetch_row($this->mysqli->sql_query_select));
            $this->mysqli->select("status","users","`login` = '{$_COOKIE['user']}'");
            $this->user_access_status = implode(mysqli_fetch_row($this->mysqli->sql_query_select));
            echo '<div style = "background: black; color: red;">-- -- -- user_group -- -- --</div><br>';
        }

        function user_table()
        {
            echo '<div style = "background: black; color: red;">-- -- -- user_table -- -- --</div>';
            //$this->user_group();
            $this->mysqli->select("*","group_namespace","`name` = '{$this->user_group}'");
            $array = mysqli_fetch_array($this->mysqli->sql_query_select);
            if ($array != null)
            {
                foreach ($array as $key => $value)
                {
                    if (($key != 'id') && ($key != 'name') && (!is_numeric($key)) && ($value != '') && ($value != '-'))
                    {
                        if ($value == '+') { $this->user_table[$key] = $array[$key]; }
                        else { $this->user_status[$key] = $array[$key]; }
                    }
                }
                unset($array);
            }
            echo '<div style = "background: black; color: red;">-- -- -- user_table -- -- -- </div><br>';
        }

        function user_permission($substring, $cell = '*')
        {
            echo '<div style = "background: black; color: red;">-- -- -- user_permission -- -- -- </div>';
            //$this->user_group();

            $this->mysqli->select("{$cell}","{$substring}_permission","`{$substring}_group` = '{$this->user_group}'");
            $array = mysqli_fetch_array($this->mysqli->sql_query_select);
            foreach ($array as $key => $value)
            {
                if (($key != 'id') && ($key != "{$substring}_group") && (!is_numeric($key)) && ($value != '') && ($value != '-'))
                {
                    $this->user_cell_vision[$key] = $array[$key];
                    $this->mysqli->select("{$key}","{$substring}","`id` = '1'");
                    while ($row =  mysqli_fetch_row($this->mysqli->sql_query_select))
                    { $this->user_cell_vision_name[] = $row[0]; }
                }
            }
            unset($array);

            $this->mysqli->select("{$cell}","{$substring}_permission","`{$substring}_group` = '{$this->user_group}_edit'");
            $array = mysqli_fetch_array($this->mysqli->sql_query_select);
            foreach ($array as $key => $value)
            {
                if (($key != 'id') && ($key != "{$substring}_group") && (!is_numeric($key)) && ($value != '') && ($value != '-'))
                { $this->user_cell_edit[$key] = $array[$key]; }
            }
            unset($array);
            echo '<div style = "background: black; color: red;">-- -- -- user_permission -- -- --</div><br>';
        }

        function user_vision($substring)
        {
            echo '<div style = "background: black; color: red;">-- -- -- user_vision -- -- -- </div>';
            $this->user_group();
            $this->mysqli->select("id_tr","{$substring}_vision","`{$this->user_group}` = '+'");
            while ($row = mysqli_fetch_row($this->mysqli->sql_query_select))
            { $this->user_row_vision[] = $row[0]; }
            unset($row);
            echo '<div style = "background: black; color: red;">-- -- -- user_vision -- -- -- </div><br>';
        }

        function user_fio()
        {
            echo '<div style = "background: black; color: red;">-- -- -- user_fio -- -- -- </div>';
            $this->mysqli->select("fio","users","`login` = '{$_COOKIE['user']}'");
            $fio = implode(mysqli_fetch_row($this->mysqli->sql_query_select));

            $fio = explode(" ","{$fio}");
            for ($count = 1; $count <= 2; $count++)
            {
                if (mb_substr($fio[$count],"0","1") != '')
                { $fio[$count] = mb_substr($fio[$count],"0","1").'.'; }
            }
            $this->user_fio = "{$fio[0]} {$fio[1]}{$fio[2]}";
            echo '<div style = "background: black; color: red;">-- -- -- user_fio -- -- -- </div><br>';
        }

    }

    $USER = new USER;
    $USER->user_group;
?>