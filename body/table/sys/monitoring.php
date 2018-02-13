<?php

    $cat_name = end(explode("=", ('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])));
    $podcat_name = explode('?', $cat_name);

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

    if ($podcat_name[1] == 'vibory')
    {

        $SQL_QUERY_select_data = $mysqli->query("select * from `".$podcat_name[1]."` ");
        if ($SQL_QUERY_select_data != null)
        { $max_count = mysqli_num_rows($SQL_QUERY_select_data); }




if ($SQL_QUERY_select_data != null)
{
    while ($row = mysqli_fetch_row($SQL_QUERY_select_data))
    {
        if (($podcat_name[1] == 'vibory') && (is_numeric($row[1])))
        {
            for ($i = 0; $i <= count($row); $i++)
            { $title[$count][$i] = str_replace('^M', '', $row[$i]); }
        }
        else if ($podcat_name[1] != 'vibory')
        {
            for ($i = 0; $i <= count($row); $i++)
            { $title[$count][$i] = str_replace('^M', '', $row[$i]); }
        }
        $tr_new_count[$count] = $row[0];
        $count++;
    }
}

//echo $title[1][0];


        require_once($_SERVER['DOCUMENT_ROOT']."/sys/class.php");
        //require_once($_SERVER['DOCUMENT_ROOT']."/body/query.php");
        //require_once($_SERVER['DOCUMENT_ROOT']."/body/pre_table/pre_table_query.php");
        //require($_SERVER['DOCUMENT_ROOT'] . "/body/sort.php");
        //require($_SERVER['DOCUMENT_ROOT'] . "/body/data.php");



        for ($tr = 2; $tr <= $max_count; $tr++)
        {
            if ($title[$tr][18] != 'монтаж не произведён')
            {
                //echo $title[$tr][18].' --> '.$tr.'<br>';
                $node = '10.234.255.42';

                $SQL_QUERY_monitoring = $mysqli->query("SELECT * FROM `vibory` WHERE `id` = '".$title[$tr][0]."' ");
                while ($row = mysqli_fetch_array($SQL_QUERY_monitoring)) { $uik_monitoring = $row; }


                $output_ping_gateway = shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_pingOnline -a '.$uik_monitoring['ip_shlyuza'].' ');
                if (strpos($output_ping_gateway, 'OK')) { $ping_gateway = 'success'; } else if (strpos($output_ping_gateway, 'CRITICAL')) { $ping_gateway = 'danger'; }

                $output_ping = shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_pingOnline -a '.$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik'].' ');
                if (strpos($output_ping, 'OK')) { $ping = 'success'; } else if (strpos($output_ping, 'CRITICAL')) { $ping = 'danger'; }


                if ($ping == 'success')
                {
                    $output_snmp = str_replace('"', '\'', shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_Vendor -a '.$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']));
                    $output_port_status_1 = shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_port1Status -a '.$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']);
                    $output_error_1 = shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_port1Er -a '.$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']);
                    $output_port_status_2 = shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_port2Status -a '.$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']);
                    $output_error_2 = shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_port2Er -a '.$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']);
                    $output_port_status_8 = shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_port8Status -a '.$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']);
                    $output_error_8 = shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_port8Er -a '.$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']);
                }
                else
                {
                    $output_port_status_1 = 'Устройство недоступно!'; $port_status_1 = 'danger';
                    $output_error_1 = 'Устройство недоступно!'; $error_1 = 'danger';
                    $output_port_status_2 = 'Устройство недоступно!'; $port_status_2 = 'danger';
                    $output_error_2 = 'Устройство недоступно!'; $error_2 = 'danger';
                    $output_port_status_8 = 'Устройство недоступно!'; $port_status_8 = 'danger';
                    $output_error_8 = 'Устройство недоступно!'; $error_8 = 'danger';
                }


                $output_ping_cam_1 = shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_pingOnline -a '.$uik_monitoring['ip_adres_cam1'].' ');
                if (strpos($output_ping_cam_1, 'OK')) { $ping_cam_1 = 'success'; } else if (strpos($output_ping_cam_1, 'CRITICAL')) { $ping_cam_1 = 'danger'; }


                if ($ping_cam_1 == 'success')
                { $output_ststus_cam_1 = shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_ipCAM_UTF8 -a '.$uik_monitoring['ip_adres_cam1'].' '); }
                else { $output_ststus_cam_1 = 'Устройство недоступно!'; $ststus_cam_1 = 'danger'; }


                $output_ping_cam_2 = shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_pingOnline -a '.$uik_monitoring['ip_adres_cam2'].' ');
                if (strpos($output_ping_cam_2, 'OK')) { $ping_cam_2 = 'success'; } else if (strpos($output_ping_cam_2, 'CRITICAL')) { $ping_cam_2 = 'danger'; }


                if ($ping_cam_2 == 'success')
                { $output_ststus_cam_2 = shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_ipCAM_UTF8 -a '.$uik_monitoring['ip_adres_cam2'].' '); }
                else { $output_ststus_cam_2 = 'Устройство недоступно!'; $ststus_cam_2 = 'danger'; }


                //if ($current_var['uik'] == $uik_monitoring['naimenovanie_uik_tik'])
                //{ $DB->delete("vibory_monitoring","`uik` = '".$current_var['uik']."'"); }
                //$SQL_QUERY_insert_monitoring = $mysqli->query('INSERT INTO `vibory_monitoring` VALUES (null, "'.$uik_monitoring['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_ststus_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_ststus_cam_2.'", "'.date("d.m.y").'", "'.date("H:i:s").'") ');



                if (strpos($output_ping, 'OK')) { $ping = 'success'; } else if (strpos($output_ping, 'CRITICAL')) { $ping = 'danger'; }
                else if (strpos($output_ping, 'WARNING')) { $ping = 'warning'; }

                if (strpos($output_ping_gateway, 'OK')) { $ping_gateway = 'success'; } else if (strpos($output_ping_gateway, 'CRITICAL')) { $ping_gateway = 'danger'; }
                else if (strpos($output_ping_gateway, 'WARNING')) { $ping_gateway = 'warning'; }

                if (strpos($output_port_status_1, '=1')) { $port_status_1 = 'success'; }
                else if (strpos($output_port_status_1, '=2') || strpos($output_port_status_1, 'недоступно')) { $port_status_1 = 'danger'; }
                else if (strpos($output_port_status_1, 'WARNING')) { $port_status_1 = 'warning'; }
                if (strpos($output_error_1, 'OK')) { $error_1 = 'success'; }
                else if (strpos($output_error_1, 'CRITICAL') || strpos($output_error_1, 'недоступно')) { $error_1 = 'danger'; }
                else if (strpos($output_error_1, 'WARNING')) { $error_1 = 'warning'; }
                if (strpos($output_port_status_2, '=1')) { $port_status_2 = 'success'; }
                else if (strpos($output_port_status_2, '=2') || strpos($output_port_status_2, 'недоступно')) { $port_status_2 = 'danger'; }
                else if (strpos($output_port_status_2, 'WARNING')) { $port_status_2 = 'warning'; }
                if (strpos($output_error_2, 'OK')) { $error_2 = 'success'; }
                else if (strpos($output_error_2, 'CRITICAL ') || strpos($output_error_2, 'недоступно')) { $error_2 = 'danger'; }
                else if (strpos($output_error_2, 'WARNING')) { $error_2 = 'warning'; }
                if (strpos($output_port_status_8, 'OK')) { $port_status_8 = 'success'; }
                else if (strpos($output_port_status_8, 'CRITICAL ') || strpos($output_port_status_8, 'недоступно')) { $port_status_8 = 'danger'; }
                else if (strpos($output_port_status_8, 'WARNING')) { $port_status_8 = 'warning'; }
                if (strpos($output_error_8, 'OK')) { $error_8 = 'success'; }
                else if (strpos($output_error_8, 'CRITICAL ') || strpos($output_error_8, 'недоступно')) { $error_8 = 'danger'; }
                else if (strpos($output_error_8, 'WARNING')) { $error_8 = 'warning'; }

                if (($port_status_1 == 'success') && ($error_1 == 'success') && ($port_status_2 == 'success') && ($error_2 == 'success') && ($port_status_8 == 'success') && ($error_8 == 'success'))
                { $commutator = 'success'; } else { $commutator = 'danger'; }

                if (strpos($output_ping_cam_1, 'OK')) { $ping_cam_1 = 'success'; }
                else if (strpos($output_ping_cam_1, 'CRITICAL') || strpos($output_ping_cam_1, 'недоступно')) { $ping_cam_1 = 'danger'; }
                else if (strpos($output_ping_cam_1, 'WARNING')) { $ping_cam_1 = 'warning'; }
                if (strpos($output_ststus_cam_1, 'OK')) { $ststus_cam_1 = 'success'; }
                else if (strpos($output_ststus_cam_1, 'CRITICAL') || strpos($output_ststus_cam_1, 'недоступно')) { $ststus_cam_1 = 'danger'; }
                else if (strpos($output_ststus_cam_1, 'WARNING')) { $ststus_cam_1 = 'warning'; }
                if (strpos($output_ping_cam_2, 'OK')) { $ping_cam_2 = 'success'; }
                else if (strpos($output_ping_cam_2, 'CRITICAL') || strpos($output_ping_cam_2, 'недоступно')) { $ping_cam_2 = 'danger'; }
                else if (strpos($output_ping_cam_2, 'WARNING')) { $ping_cam_2 = 'warning'; }

                if (strpos($output_ststus_cam_2, 'OK')) { $ststus_cam_2 = 'success'; }
                else if (strpos($output_ststus_cam_2, 'CRITICAL') || strpos($output_ststus_cam_2, 'недоступно')) { $ststus_cam_2 = 'danger'; }
                else if (strpos($output_ststus_cam_2, 'WARNING')) { $ststus_cam_2 = 'warning'; }

                if (($ping_cam_1 == 'success') && ($ststus_cam_1 == 'success'))
                { $cam1 = 'success'; } else { $cam1 = 'danger'; }

                if (($ping_cam_2 == 'success') && ($ststus_cam_2 == 'success'))
                { $cam2 = 'success'; } else { $cam2 = 'danger'; }
                $snmp = 'info';

                $ready_class = '';
                $ready = $uik_monitoring['gotovnost_obekta_da'];
                $ready_ex = explode(' ', $ready);
                if (($ready_ex[0] == 'монтаж') && (($ready_ex[1] == 'не'))) { $ready_class = 'danger'; }
                else if (($ready_ex[0] != 'монтаж') && (($ready_ex[0] != 'не'))) { $ready_class = 'success'; }

                if (($commutator == 'success') && ($cam1 == 'success') && ($cam2 == 'success'))
                { $ready = 'success'; }
                else { $ready = 'danger'; }
                echo $title[$tr][0]." --> ".$title[$tr][1].' --> '.$ready.'<br>';
            }
            else { $ready = ''; }
        }
    }
?>