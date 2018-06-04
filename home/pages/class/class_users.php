<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');


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
            $this->mysqli->select("*","users");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select)) { $this->users[] = $array; }
        }

        function groups_list()
        {
            $this->mysqli->select("name","group_namespace");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select)) { $this->groups[] = $array; }
            unset($this->users[0]);
        }

        function delete_user($user)
        {
            $this->mysqli->delete("users","`login` = '{$user}'");
        }

        function update_user($user)
        {
            $td = array('fio' => 'ФИО', 'login' => 'Логин', 'password' => 'Пароль', 'table_group' => 'Группа', 'position' => 'Должность', 'phone' => 'Телефон', 'mail' => 'Почта', 'status' => 'Доступ');
            $this->mysqli->select("*","users","`login` = '{$user}'");
            while ($array = mysqli_fetch_array($this->mysqli->sql_query_select)) { $arr[] = $array; }
            foreach ($td as $key => $value)
            {
                if ($arr[$key] != $_POST[$key])
                {
                    if ($_POST['status'] == 'True') { $_POST['status'] = '+'; }
                    else if ($_POST['status'] == 'False') { $_POST['status'] = '-'; }
                    $this->mysqli->update("users","{$key}","{$_POST[$key]}","`login` = '{$user}'");
                }
            }
        }

        function add_user()
        {
            $this->mysqli->insert("users","null, '".$_POST['login']."','".$_POST['password']."', '', '', '".$_POST['fio']."','".$_POST['position']."', '".$_POST['phone']."','".$_POST['mail']."','+'");
        }
    }

    $ADM_USER = new ADM_USER();
?>