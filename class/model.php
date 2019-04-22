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
            if (!isset ($_GET['bar']))
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
                            if ($user_tables != '')
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
            }

            $this->USER->user_fio();
            $return = [$this->USER->user_access_status, $released_user_tables, $this->USER->user_fio];
            return ($return);
        }

        function body($macro = null)
        {
            $this->USER->user_fio();
            $fio = $this->USER->user_fio;

            foreach ($_GET as $key => $value) { $project = $value; }

            $this->USER->user_group();
            $this->USER->user_permission($project);
            $vision = $this->USER->user_cell_vision;                  // Список видимых пользователю полей (по ключу)
            $permission = $this->USER->user_cell_edit;                // Список полей, доступных для редактирования

            foreach ($vision as $key => $value) { if ($key != 'id') { $temp[] = $key; } }
            if ($temp != '') { array_unshift($temp, "id"); }
            if ($this->USER->user_cell_vision_name != '')
            {
                foreach (array_values($this->USER->user_cell_vision_name) as $key => $value)
                {
                    if ($temp[$key] != '')
                    { $title[$temp[$key]] = $value; }
                }
            }


            if ((isset ($_POST['search_btn'])) || ($_POST['hidden_sort_5'] != ''))
            {
                $temp_title = array_flip($title);

                if (isset ($_POST['search_btn'])) { $caption = $_POST['caption']; $cell = $temp_title[$_POST['selected_td']]; }
                elseif ((!isset ($_POST['search_btn'])) && ($_POST['hidden_sort_5'] != '')) { $caption = $_POST['hidden_sort_6']; $cell = $temp_title[$_POST['hidden_sort_5']]; }

                $table_data = $this->TABLE->search($caption, $cell);
                if ($table_data != '')
                {
                    foreach ($table_data as $n_key => $n_value)
                    {
                        foreach ($n_value as $key => $value)
                        {
                            if (is_numeric($key))
                            { unset ($table_data[$n_key][$key]); }
                        }
                    }

                    foreach ($table_data as $key => $value)
                    {
                        foreach ($value as $a_key => $a_value)
                        {
                             if (!isset ($title[$a_key]))
                             { unset ($table_data[$key][$a_key]); }
                        }
                    }
                    unset($table_data[0]);
                }
            }
            else { $table_data = $this->TABLE->current_table($project, $vision, $macro); }
            $total_tr_count = $this->TABLE->total_tr_count($project);
            $permission_status = $this->USER->current_table_permissions($project);


            $return = [$table_data, $total_tr_count, (count($table_data) - 1), $permission, $title, $permission_status, $fio];
            //pre($return);
            return $return;
        }
    }

    $MODEL = new MODEL;
?>