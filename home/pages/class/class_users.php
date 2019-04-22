<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/class/connection.php');


    abstract class ABSTRACT_ADM_CLASS
    {
        abstract function users_list();
        abstract function groups_list();
        abstract function delete_user($user);
        abstract function update_user($user);
        abstract function add_user();
    }

    class ADM_USER extends ABSTRACT_ADM_CLASS
    {
        private $mysqli;
        public $users;
        public $groups;

        public function __construct()
        {
            $this->mysqli = new DB();
            $this->mysqli->mysqli();
        }

        function users_list()
        {
            $this->mysqli->select("*","!sys_users");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select)) { $this->users[] = $array; }
        }

        function groups_list()
        {
            $this->mysqli->select("name","!sys_group_namespace");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select)) { $this->groups[] = $array; }
            unset($this->users[0]);
        }

        function delete_user($user)
        {
            $this->mysqli->delete("!sys_users","`login` = '{$user}'");
        }

        function update_user($user)
        {
            $td = array('fio' => 'ФИО', 'login' => 'Логин', 'password' => 'Пароль', 'table_group' => 'Группа', 'position' => 'Должность', 'phone' => 'Телефон', 'mail' => 'Почта', 'status' => 'Доступ');
            $this->mysqli->select("*","!sys_users","`login` = '{$user}'");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select)) { $arr[] = $array; }
            foreach ($td as $key => $value)
            {
                if ($arr[$key] != $_POST[$key])
                {
                    if ($key == 'fio') { $this->mysqli->update("!sys_users","{$key}","{$_POST['fio']}","`login` = '{$_POST['hidden']}'"); }
                    elseif ($key == 'login') { $this->mysqli->update("!sys_users","{$key}","{$_POST['login']}","`login` = '{$_POST['hidden']}'"); }
                    else
                    {
                        if ($_POST['status'] == 'True') { $_POST['status'] = '+'; }
                        else if ($_POST['status'] == 'False') { $_POST['status'] = '-'; }
                        $this->mysqli->update("!sys_users","{$key}","{$_POST[$key]}","`login` = '{$user}'");
                    }
                }
            }
        }

        function add_user()
        {
            $this->mysqli->insert("!sys_users","null, '".trim($_POST['login'])."','".$_POST['password']."', '', '', '".trim($_POST['fio'])."','".trim($_POST['position'])."', '".trim($_POST['phone'])."','".trim($_POST['mail'])."','+'");
        }
    }

    $ADM_USER = new ADM_USER();
?>