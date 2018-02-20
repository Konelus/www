<?php

    $cat_name = end(explode("=", ('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])));
    $podcat_name = explode('?', $cat_name);
    $get_name = explode('/',$podcat_name[1]);

    /* - - - - - - - - - - ↓ Подключение к БД ↓ - - - - - - - - - - */
    $link = '';
    $descriptor = fopen($_SERVER['DOCUMENT_ROOT'].'/link.txt', 'r');
    if ($descriptor)
    { while (($string = fgets($descriptor)) !== false) { $link = $link.$string; } fclose($descriptor); }

    $localhost = "localhost";
    $user = "root";
    $password = $link;
    $db = "rtk_01";
    $mysqli = new mysqli($localhost, $user, $password, $db);
    mysqli_set_charset($mysqli, 'utf8');
    /* - - - - - - - - - - ↑ Подключение к БД ↑ - - - - - - - - - - */
    if ($get_name[0] == 'vibory')
    {

        $SQL_QUERY_select_data = $mysqli->query("select * from `".$get_name[0]."` ");
        if ($SQL_QUERY_select_data != null)
        { $max_count = mysqli_num_rows($SQL_QUERY_select_data); }



        if ($SQL_QUERY_select_data != null)
        {
            while ($row = mysqli_fetch_array($SQL_QUERY_select_data))
            {
                if (($get_name[0] == 'vibory') && (is_numeric($row[1])))
                {
                    for ($i = 0; $i <= count($row); $i++)
                    { $main_table_array[$count] = $row; }
                }
                else if ($get_name[0] != 'vibory')
                {
                    for ($i = 0; $i <= count($row); $i++)
                    { $main_table_array[$count] = $row; }
                }
                $tr_new_count[$count] = $row[0];
                $count++;
            }
        }
        //print_r($main_table_array);

//echo $main_table_array[1][0];


        require_once($_SERVER['DOCUMENT_ROOT']."/sys/class.php");
        //require_once($_SERVER['DOCUMENT_ROOT']."/body/query.php");
        //require_once($_SERVER['DOCUMENT_ROOT']."/body/pre_table/pre_table_query.php");
        //require($_SERVER['DOCUMENT_ROOT'] . "/body/sort.php");
        //require($_SERVER['DOCUMENT_ROOT'] . "/body/data.php");



        //while (true)
        //{
            for ($tr = 2; $tr <= 10; $tr++)
            {
                if ($main_table_array[$tr]['gotovnost_obekta_da'] != 'монтаж не произведён')
                {
                    //echo $main_table_array[$tr][18].' --> '.$tr.'<br>';
                    //$node = '10.234.255.42';
                    $node = '10.153.29.134';

                    //$DB->select("*","{$get_name[0]}","`id` = '{$main_table_array[$tr][0]}'");
                    //while ($row = mysqli_fetch_array($DB->sql_query_select))
                    //{ $main_table_array = $row; }


                    $DB->select("*","{$get_name[0]}_monitoring","`uik` = '{$main_table_array[$tr]['naimenovanie_uik_tik']}'");
                    while ($row = mysqli_fetch_array($DB->sql_query_select))
                    { $current_var = $row; }


                    $output_ping_gateway = shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c check_pingOnline -a {$main_table_array[$tr]['ip_shlyuza']}");
                    if (strpos($output_ping_gateway, 'OK')) { $ping_gateway = 'success'; } else if (strpos($output_ping_gateway, 'CRITICAL')) { $ping_gateway = 'danger'; }


                    if (mb_strtolower("{$main_table_array[$tr]['hostgroups']}","UTF-8") == 'да')
                    {
                        $output_ping_controller = shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c check_pingOnline -a {$main_table_array[$tr]['ip_adres_kontrollera']}");
                        if (strpos($output_ping_controller, 'OK')) { $ping_controller = 'success'; } else if (strpos($output_ping_controller, 'CRITICAL')) { $ping_controller = 'danger'; }
                    }


                    $output_ping = shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c check_pingOnline -a {$main_table_array[$tr]['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                    if (strpos($output_ping, 'OK')) { $ping = 'success'; } else if (strpos($output_ping, 'CRITICAL')) { $ping = 'danger'; }


                    if ($ping == 'success')
                    {
                        $output_snmp = str_replace('"', '\'', shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c check_Vendor -a {$main_table_array[$tr]['ip_adres_kommutatora_v_shkafu_uik_tik']}"));
                        $output_port_status_1 = shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c check_port1Status -a {$main_table_array[$tr]['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                        $output_error_1 =       shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c check_port1Er -a {$main_table_array[$tr]['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                        $output_port_status_2 = shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c check_port2Status -a {$main_table_array[$tr]['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                        $output_error_2 =       shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c check_port2Er -a {$main_table_array[$tr]['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                        $output_port_status_8 = shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c check_port8Status -a {$main_table_array[$tr]['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                        $output_error_8 =       shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c check_port8Er -a {$main_table_array[$tr]['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                    }
                    else
                    {
                        $output_port_status_1   = 'Устройство недоступно!'; $port_status_1 = 'danger';
                        $output_error_1         = 'Устройство недоступно!'; $error_1 = 'danger';
                        $output_port_status_2   = 'Устройство недоступно!'; $port_status_2 = 'danger';
                        $output_error_2         = 'Устройство недоступно!'; $error_2 = 'danger';
                        $output_port_status_8   = 'Устройство недоступно!'; $port_status_8 = 'danger';
                        $output_error_8         = 'Устройство недоступно!'; $error_8 = 'danger';
                    }



                    $output_ping_cam_1 = shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c check_pingOnline -a {$main_table_array[$tr]['ip_adres_cam1']}");
                    if (strpos($output_ping_cam_1, 'OK')) { $ping_cam_1 = 'success'; } else if (strpos($output_ping_cam_1, 'CRITICAL')) { $ping_cam_1 = 'danger'; }


                    if ($ping_cam_1 == 'success')
                    { $output_ststus_cam_1 = shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c check_ipCAM_UTF8 -a {$main_table_array[$tr]['ip_adres_cam1']}"); }
                    else { $output_ststus_cam_1 = 'Устройство недоступно!'; $ststus_cam_1 = 'danger'; }


                    $output_ping_cam_2 = shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c check_pingOnline -a {$main_table_array[$tr]['ip_adres_cam2']}");
                    if (strpos($output_ping_cam_2, 'OK')) { $ping_cam_2 = 'success'; } else if (strpos($output_ping_cam_2, 'CRITICAL')) { $ping_cam_2 = 'danger'; }


                    if ($ping_cam_2 == 'success')
                    { $output_ststus_cam_2 = shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c check_ipCAM_UTF8 -a {$main_table_array[$tr]['ip_adres_cam2']}"); }
                    else { $output_ststus_cam_2 = 'Устройство недоступно!'; $ststus_cam_2 = 'danger'; }


                    //if ($current_var['uik'] == $main_table_array[$tr]['naimenovanie_uik_tik'])
                    //{ $DB->delete("vibory_monitoring","`uik` = '".$current_var['uik']."'"); }
                    //$SQL_QUERY_insert_monitoring = $mysqli->query('INSERT INTO `vibory_monitoring` VALUES (null, "'.$main_table_array[$tr]['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_ststus_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_ststus_cam_2.'", "'.date("d.m.y").'", "'.date("H:i:s").'") ');


                    $alarm = $current_var['alarm'];

                    if (strpos($output_ping, 'OK')) { $ping = 'success'; } else if (strpos($output_ping, 'CRITICAL')) { $ping = 'danger'; }
                    else if (strpos($output_ping, 'WARNING')) { $ping = 'warning'; }

                    if (strpos($output_ping_gateway, 'OK')) { $ping_gateway = 'success'; } else if (strpos($output_ping_gateway, 'CRITICAL')) { $ping_gateway = 'danger'; }
                    else if (strpos($output_ping_gateway, 'WARNING')) { $ping_gateway = 'warning'; }

                    if      (strpos($output_port_status_1, 'OK')) { $port_status_1 = 'success'; }
                    else if (strpos($output_port_status_1, 'CRITICAL') || strpos($output_port_status_1, 'недоступно')) { $port_status_1 = 'danger'; }
                    else if (strpos($output_port_status_1, 'WARNING')) { $port_status_1 = 'warning'; }

                    if      (strpos($output_error_1, 'OK')) { $error_1 = 'success'; }
                    else if (strpos($output_error_1, 'CRITICAL') || strpos($output_error_1, 'недоступно')) { $error_1 = 'danger'; }
                    else if (strpos($output_error_1, 'WARNING')) { $error_1 = 'warning'; }

                    if      (strpos($output_port_status_2, 'OK')) { $port_status_2 = 'success'; }
                    else if (strpos($output_port_status_2, 'CRITICAL') || strpos($output_port_status_2, 'недоступно')) { $port_status_2 = 'danger'; }
                    else if (strpos($output_port_status_2, 'WARNING')) { $port_status_2 = 'warning'; }

                    if      (strpos($output_error_2, 'OK')) { $error_2 = 'success'; }
                    else if (strpos($output_error_2, 'CRITICAL ') || strpos($output_error_2, 'недоступно')) { $error_2 = 'danger'; }
                    else if (strpos($output_error_2, 'WARNING')) { $error_2 = 'warning'; }

                    if      (strpos($output_port_status_8, 'OK')) { $port_status_8 = 'success'; }
                    else if (strpos($output_port_status_8, 'CRITICAL ') || strpos($output_port_status_8, 'недоступно')) { $port_status_8 = 'danger'; }
                    else if (strpos($output_port_status_8, 'WARNING')) { $port_status_8 = 'warning'; }

                    if      (strpos($output_error_8, 'OK')) { $error_8 = 'success'; }
                    else if (strpos($output_error_8, 'CRITICAL ') || strpos($output_error_8, 'недоступно')) { $error_8 = 'danger'; }
                    else if (strpos($output_error_8, 'WARNING')) { $error_8 = 'warning'; }

                    if (($port_status_1 == 'success') && ($error_1 == 'success') && ($port_status_2 == 'success') && ($error_2 == 'success') && ($port_status_8 == 'success') && ($error_8 == 'success'))
                    { $commutator = 'success'; }
                    else //if (($port_status_1 != 'success') || ($error_1 != 'success') || ($port_status_2 != 'success') || ($error_2 != 'success') || ($port_status_8 != 'success') || ($error_8 != 'success'))
                    { $commutator = 'danger'; }

                    if      (strpos($output_ping_cam_1, 'OK')) { $ping_cam_1 = 'success'; }
                    else if (strpos($output_ping_cam_1, 'CRITICAL') || strpos($output_ping_cam_1, 'недоступно')) { $ping_cam_1 = 'danger'; }
                    else if (strpos($output_ping_cam_1, 'WARNING')) { $ping_cam_1 = 'warning'; }
                    if      (strpos($output_ststus_cam_1, 'OK')) { $ststus_cam_1 = 'success'; }
                    else if (strpos($output_ststus_cam_1, 'CRITICAL') || strpos($output_ststus_cam_1, 'недоступно')) { $ststus_cam_1 = 'danger'; }
                    else if (strpos($output_ststus_cam_1, 'WARNING')) { $ststus_cam_1 = 'warning'; }
                    if      (strpos($output_ping_cam_2, 'OK')) { $ping_cam_2 = 'success'; }
                    else if (strpos($output_ping_cam_2, 'CRITICAL') || strpos($output_ping_cam_2, 'недоступно')) { $ping_cam_2 = 'danger'; }
                    else if (strpos($output_ping_cam_2, 'WARNING')) { $ping_cam_2 = 'warning'; }

                    if      (strpos($output_ststus_cam_2, 'OK')) { $ststus_cam_2 = 'success'; }
                    else if (strpos($output_ststus_cam_2, 'CRITICAL') || strpos($output_ststus_cam_2, 'недоступно')) { $ststus_cam_2 = 'danger'; }
                    else if (strpos($output_ststus_cam_2, 'WARNING')) { $ststus_cam_2 = 'warning'; }

                    if (($ping_cam_1 == 'success') && ($ststus_cam_1 == 'success'))
                    { $cam1 = 'success'; } else { $cam1 = 'danger'; }

                    if (($ping_cam_2 == 'success') && ($ststus_cam_2 == 'success'))
                    { $cam2 = 'success'; } else { $cam2 = 'danger'; }
                    $snmp = 'info';

                    if (strpos($output_ping_controller, 'OK')) { $ping_controller = 'success'; } else if (strpos($output_ping_controller, 'CRITICAL')) { $ping_controller = 'danger'; }


                    $ready_class = '';
                    $ready = $main_table_array[$tr]['gotovnost_obekta_da'];
                    $ready_ex = explode(' ', $ready);
                    if (($ready_ex[0] == 'монтаж') && (($ready_ex[1] == 'не'))) { $ready_class = 'danger'; }
                    else if (($ready_ex[0] != 'монтаж') && (($ready_ex[0] != 'не'))) { $ready_class = 'success'; }





                    if (($commutator == 'success') && ($cam1 == 'success') && ($cam2 == 'success'))
                    {
                        //$ready = 'success';
                        //$DB->select("alarm","{$get_name[0]}_monitoring","`uik` = '{$main_table_array[$tr]['naimenovanie_uik_tik']}'");
                        if ($current_var['alarm'] != '')
                        { $DB->delete("{$get_name[0]}_monitoring","`uik` = '{$main_table_array[$tr]['naimenovanie_uik_tik']}'"); }
                        $DB->insert("{$get_name[0]}_monitoring",'null, "'.$main_table_array[$tr]['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_ststus_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_ststus_cam_2.'", "'.$output_ping_controller.'", "'.date("d.m.y").'", "'.date("H:i:s").'", "success"');
                    }

                    else if (($commutator != 'success') || ($cam1 != 'success') || ($cam2 != 'success'))
                    {
                        //$ready = 'danger';
                        //$DB->select("alarm","{$get_name[0]}_monitoring","`uik` = '{$main_table_array[$tr]['naimenovanie_uik_tik']}'");
                        if ($current_var['alarm'] != '')
                        {
                            $DB->delete("{$get_name[0]}_monitoring","`uik` = '{$main_table_array[$tr]['naimenovanie_uik_tik']}'");
                            if  ($current_var['alarm'] != 'success')
                            { $DB->insert("{$get_name[0]}_monitoring",'null, "'.$main_table_array[$tr]['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_ststus_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_ststus_cam_2.'", "'.$output_ping_controller.'", "'.date("d.m.y").'", "'.date("H:i:s").'", "'.$current_var['alarm'].'"'); }
                            else if  ($current_var['alarm'] == 'success')
                            { $DB->insert("{$get_name[0]}_monitoring",'null, "'.$main_table_array[$tr]['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_ststus_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_ststus_cam_2.'", "'.$output_ping_controller.'", "'.date("d.m.y").'", "'.date("H:i:s").'", "'.date("d.m.y H:i:s").'"'); }
                        }
                        else { $DB->insert("{$get_name[0]}_monitoring",'null, "'.$main_table_array[$tr]['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_ststus_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_ststus_cam_2.'", "'.$output_ping_controller.'", "'.date("d.m.y").'", "'.date("H:i:s").'", "'.date("d.m.y H:i:s").'"'); }
                    }
                    echo '<hr>';




                }
                //else { $ready = ''; }
            }
        //}
    }
?>