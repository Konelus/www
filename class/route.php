<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/class/model.php');

    abstract class abstract_route
    {
        abstract function page_model();
    }

    class ROUTE extends abstract_route
    {
        private $mysqli;
        private $view;
        private $MODEL;
        public $return;

        function __construct()
        {
            $this->mysqli = new DB;
            $this->mysqli->mysqli();

            foreach ($_GET as $key => $value)
            {
                $this->view['key'] = $key;
                $this->view['value'] = $value;
            }

            $this->MODEL = new MODEL;
        }


        function page_model()
        {
            $parse = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/instructions.ini');
            if (($parse['status'] == 'enable') || ($_COOKIE['user'] == 'admin'))
            {
                if ($_COOKIE['user'] != '')
                {
                    if ($this->view['value'] == '')
                    {
                        $array = $this->MODEL->main();
                        array_push($array,'home/home');
                        $this->return = $array;
                    }
                    elseif ($this->view['value'] != '')
                    {
                        if (($_COOKIE['user'] == 'admin') && ($this->view['key'] == 'bar'))
                        {
                            list($temp, $temp, $fio) = $this->MODEL->main();
                            $this->return = ['','',"{$fio}",'home/home',"{$this->view['key']}","{$this->view['value']}"];
                        }
                        elseif ($this->view['key'] == 'project') { $this->return = ['','','','body/body',"{$this->view['key']}","{$this->view['value']}"]; }
                    }
                }
                else {$this->return = ['','','','login/login']; }
            }
            elseif (($parse['status'] == 'disable'))
            { $this->return = ['','','','break']; }
        }
    }


    $ROUTE = new ROUTE;
?>