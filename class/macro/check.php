<?php
class CHECK
{

    public $check;
    public $check_list;
    public $check_list_array;
    public $check_fast_list;
    public $check_fast_list_array;
    private $mysqli;


    function __construct()
    {
        $this->mysqli = new DB;
        $this->mysqli->mysqli();
    }

    function check_main($macro = '')
    {
        if ($macro != '')
        {
            foreach ($macro as $key => $value)
            {
                if (stripos("{$key}","check_list") !== false)
                { $this->check = 'true'; break; }
            }
            foreach ($macro as $key => $value)
            {
                if (stripos("{$key}","check_list") !== false)
                { $this->check_list = $value; }
            }
            $this->check_list_array = explode(",","{$value}");

            foreach ($macro as $key => $value)
            {
                if (stripos("{$key}","check_fast_list") !== false)
                { $this->check_fast_list = $value; }
            }
            $this->check_fast_list_array = explode(",","{$value}");

            foreach ($macro as $key => $value)
            {
                if (stripos("{$key}","super_check_list") !== false)
                { $this->check_list = $value; }
            }
            $this->check_list_array = explode(",","{$value}");
        }

    }

    function check_title($super = '')
    {
        if ($super != '')
        { list($_GET['project'], $temp) = explode("%","{$_GET['project']}"); }

        if (stripos($_SERVER['REQUEST_URI'], "stats.php") !== false)
        {
            foreach ($this->check_list_array as $key => $value)
            {
                $this->mysqli->select("{$value}","{$_GET['project']}","`id` = '1'");
                if ($this->mysqli->sql_query_select != '')
                {
                    while ($row = mysqli_fetch_row($this->mysqli->sql_query_select))
                    { $result[] = $row[0]; }
                }
            }
        }
        if (stripos($_SERVER['REQUEST_URI'], "stats_fast.php") == true)
        {
            foreach ($this->check_fast_list_array as $key => $value)
            {
                $this->mysqli->select("{$value}","{$_GET['project']}","`id` = '1'");
                if ($this->mysqli->sql_query_select != '')
                {
                    while ($row = mysqli_fetch_row($this->mysqli->sql_query_select))
                    { $result[] = $row[0]; }
                }
            }
        }
        return $result;
    }


    function check_in($stats, $macro)
    {
        $this->mysqli->select("{$macro['check_add']}","{$_GET['project']}","`id` = '{$stats}'");
        $sql_result = implode(mysqli_fetch_row($this->mysqli->sql_query_select));

        if ($macro['super_check'] == '')
        {
            if ($macro['check_list_add'] != '')
            {
                if (stripos("{$macro['check_list_add']}",","))
                { $chle = explode(",","{$macro['check_list_add']}"); }
                else { $chle[] = $macro['check_list_add']; }
            }

            if ($macro['check_fast_list_add'] != '')
            {
                if (stripos("{$macro['check_fast_list_add']}",","))
                { $chfle = explode(",","{$macro['check_fast_list_add']}"); }
                else { $chfle[] = $macro['check_fast_list_add']; }
            }


            if ($chle != '')
            {
                foreach ($chle as $key => $value)
                {
                    if ($sql_result == $value)
                    { $this->mysqli->insert("{$_GET['project']}_check","{$stats}"); }
                }
            }

            if ($chfle != '')
            {
                foreach ($chfle as $key => $value)
                {
                    if ($sql_result == $value)
                    { $this->mysqli->insert("{$_GET['project']}_check_fast","{$stats}"); }
                }
            }
        }
        elseif ($macro['super_check'] != '')
        { $this->check_in_super($stats); }
    }


    function check_in_auto($macro, $super = '')
    {
        $this->mysqli->select("id","{$_GET['project']}");
        while ($temp_last_id = mysqli_fetch_array($this->mysqli->sql_query_select))
        { $last_id = $temp_last_id; }
        if ($super == '') { $this->check_in($last_id[0],$macro); }
        elseif ($super != '') { $this->check_in_super($last_id[0]); }
    }

    function check_out($fast = '', $char = '')
    {

        if ($fast == '')
        { $this->mysqli->select("*","{$_GET['project']}_check"); }
        elseif ($fast != '')
        { $this->mysqli->select("*","{$_GET['project']}_check_fast"); }
        if ($this->mysqli->sql_query_select != '')
        {
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
            { $temp_cell[] = $array; }
        }


        if ($temp_cell != '')
        {
            foreach ($temp_cell as $key => $value)
            {
                foreach ($value as $key2 => $value2)
                {
                    if (($char != '') && ($value['type'] == $char))
                    { $id[$value['id_num']] = $value['id_num']; }
                    elseif ($char == '') { $id[$key] = $value2; }
                }
            }
        }

        if (stripos($_SERVER['REQUEST_URI'], "stats.php") == true) { $cells = explode(",","{$this->check_list}"); }
        elseif (stripos($_SERVER['REQUEST_URI'], "stats_fast.php") == true) { $cells = explode(",","{$this->check_fast_list}"); }

        if ($id != '')
        {
            foreach ($id as $key => $value)
            {
                if ($cells != '')
                {
                    foreach ($cells as $key2 => $value2)
                    {
                        $this->mysqli->select("$value2","{$_GET['project']}","`id` = '{$value}'");
                        if ($this->mysqli->sql_query_select != '')
                        { $temp_result[$key][$key2] = mysqli_fetch_row($this->mysqli->sql_query_select); }
                    }
                }
            }
        }



        if ($temp_result != '')
        {
            foreach ($temp_result as $key => $value)
            {
                foreach ($value as $key2 => $value2)
                { $result[$key][$key2] = $value2[0]; }
            }
        }

        return $result;


    }


    function check_in_super($stats)
    {
        $this->mysqli->select("ctet","{$_GET['project']}","`id` = '{$stats}'");
        while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
        { $ctet = $array[0]; }
        if ($ctet == 'Азов МЦТЭТ') { $add = 'A'; }
        elseif ($ctet == 'Волгодонск МЦТЭТ') { $add = 'B'; }
        elseif ($ctet == 'Каменск МЦТЭТ') { $add = 'K'; }
        elseif ($ctet == 'Новочеркасск МЦТЭТ') { $add = 'H'; }
        elseif ($ctet == 'Ростов ГЦТЭТ') { $add = 'P'; }
        elseif ($ctet == 'Таганрог ГЦТЭТ') { $add = 'T'; }
        elseif ($ctet == 'ТЦТЭТ-09850') { $add = ''; }
        elseif ($ctet == 'РЦУССИИС-09850') { $add = ''; }
        $this->mysqli->insert("{$_GET['project']}_check","null, '{$stats}', '{$add}'");
    }

    function check_del($id)
    {
        if (stripos($_SERVER['REQUEST_URI'], "stats.php") == true)
        {
            if (stripos($_SERVER['REQUEST_URI'], "%") !== false)
            { $id_n = 'id_num'; }
            else { $id_n = 'id'; }
            $this->mysqli->delete("{$_GET['project']}_check","`{$id_n}` = '{$id}'");
        }
        elseif (stripos($_SERVER['REQUEST_URI'], "stats_fast.php") == true)
        { $this->mysqli->delete("{$_GET['project']}_check_fast","`id` = '{$id}'"); }
    }

    function check_select($id)
    {

        if (stripos("{$_GET['project']}","%") !== false)
        { list($_GET['project'], $temp) = explode("%","{$_GET['project']}"); }

        $this->mysqli->select("*","{$_GET['project']}","`id` = '{$id}'");
        while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
        { $temp_result[] = $array; }

        foreach ($temp_result[0] as $key => $value)
        {
            if (!is_numeric($key)) { $result[$key] = $value; }
        }
        return $result;
    }

    function check_select_title()
    {
        $this->mysqli->select("*","{$_GET['project']}","`id` = '1'");
        while ($array = mysqli_fetch_array($this->mysqli->sql_query_select))
        { $temp_result[] = $array; }

        foreach ($temp_result[0] as $key => $value)
        {
            if (!is_numeric($key)) { $result[$key] = $value; }
        }
        return $result;
    }


}

$CHECK = new CHECK;
?>