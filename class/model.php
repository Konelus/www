<?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/class/user.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/class/table.php');

    class MODEL
    {
        private $USER;
        private $TABLE;

        function __construct()
        {
            $this->USER     = new USER;
            $this->TABLE    = new TABLE;
        }

        function main()
        {
            $this->USER->user_access();
            if ($this->USER->user_access_status == '+')
            {
                $this->USER->user_table();
                $user_tables = $this->USER->user_table;
                $this->TABLE->table_list();
                $all_tables = $this->TABLE->table_list;
                $this->TABLE->table_list('1');
                $released_tables = $this->TABLE->table_list;
                $count = 0;
                if ($_COOKIE['user'] != 'admin')
                {
                    foreach ($released_tables as $key1 => $value1)
                    {
                       foreach ($user_tables as $key2 => $value2)
                       {
                           if ($key1 == $value2)
                           {
                               $released_user_tables[$count]['name'] = $value1['name'];
                               $released_user_tables[$count]['description'] = $value1['description'];
                           }
                           $count++;
                       }
                    }
                }
                elseif ($_COOKIE['user'] == 'admin')
                {
                    foreach ($all_tables as $key1 => $value1)
                    {
                        $released_user_tables[$count] = $value1;
                        $count++;
                    }
                }
            }
            $this->USER->user_fio();
            $return = [$this->USER->user_access_status, $released_user_tables, $this->USER->user_fio];
            return ($return);
        }

        function body()
        {

            foreach ($_GET as $key => $value) { $project = $value; }

            if ($_COOKIE['user'] != 'admin')
            {
                $this->USER->user_group();
                $this->USER->user_permission($project);
                $vision = $this->USER->user_cell_vision;                  // Список видимых пользователю полей (по ключу)
                $permission = $this->USER->user_cell_edit;                // Список полей, доступных для редактирования


                foreach ($vision as $key => $value) { if ($key != 'id') { $temp[] = $key; } }
                foreach ($this->USER->user_cell_vision_name as $key => $value) { if ($temp[$key] == '') { $temp[$key] = 'id'; } $title[$temp[$key]] = $value; }
            }

            $this->TABLE->current_table($project, $vision);
            $return = [$this->TABLE->table_data, $permission, $title];
            return $return;
        }
    }

    $MODEL = new MODEL;
?>