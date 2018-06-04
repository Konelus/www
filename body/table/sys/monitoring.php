<?php

    require_once($_SERVER['DOCUMENT_ROOT']."/sys/class.php");
    require_once ($_SERVER['DOCUMENT_ROOT'].'/body/table/monitoring_sys/monitoring_func.php');

    $get_name = explode('/',"{$substring}");


    if ($get_name[0] == 'vibory')
    {

        $DB->select("*","{$get_name[0]}");


        if ($DB->sql_query_select != null)
        {
            $max_count = mysqli_num_rows($DB->sql_query_select);

            while ($row = mysqli_fetch_row($DB->sql_query_select))
            {
                if (($get_name[0] == 'vibory') && (is_numeric($row[1])))
                {
                    for ($i = 0; $i <= count($row); $i++)
                    { $title[$count][$i] = str_replace('^M', '', $row[$i]); }
                }
                else if ($get_name[0] != 'vibory')
                {
                    for ($i = 0; $i <= count($row); $i++)
                    { $title[$count][$i] = str_replace('^M', '', $row[$i]); }
                }
                $count++;
            }
        }


        
        echo '--> '.date("H:i:s").'<br>';
        for ($tr = 2; $tr <= $max_count; $tr++)
        {
            if ($title[$tr][18] != 'монтаж не произведён')
            {
                $DB->select("*","vibory","`id` = '{$title[$tr][0]}'");
                while ($row = mysqli_fetch_array($DB->sql_query_select)) { $uik_monitoring = $row; }

                $DB->select("*","{$get_name[0]}_monitoring","`uik` = '{$uik_monitoring['naimenovanie_uik_tik']}");
                while ($row = mysqli_fetch_array($DB->sql_query_select)) { $current_var = $row; }


                $output_ping_gateway =  shell("check_pingOnline","{$uik_monitoring['ip_shlyuza']}");
                $output_ping =          shell("check_pingOnline","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                $ping_gateway =         status("{$output_ping_gateway}");
                $ping =                 status("{$output_ping}");


                if (mb_strtolower("$uik_monitoring[hostgroups]","UTF-8") == 'да')
                {
                    $output_ping_controller = shell("check_pingOnline","{$uik_monitoring['ip_adres_kontrollera']}");
                    $ping_controller = status("{$output_ping_controller}");
                }


                if ($ping == 'success')
                {
                    $output_snmp =              str_replace('"', '\'', shell("check_Vendor","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}"));
                    $output_port_status_1 =     shell("check_port1Status","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                    $output_port_status_2 =     shell("check_port1Er","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                    $output_port_status_8 =     shell("check_port8Status","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                    $output_error_1 =           shell("check_port1Er","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                    $output_error_1 =           shell("check_port2Er","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                    $output_error_1 =           shell("check_port8Er","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}");

                }
                else
                {
                    $output_port_status_1 = $output_error_1 = $output_port_status_2 = $output_error_2 = $output_port_status_8 = $output_error_8 = 'Устройство недоступно!';
                    $port_status_1 = $error_1 = $port_status_2 = $error_2 = $port_status_8 = $error_8 = 'danger';
                }



                $output_ping_cam_1 = shell("check_pingOnline","{$uik_monitoring['ip_adres_cam1']}");
                $ping_cam_1 = status("{$output_ping_cam_1}");


                if ($ping_cam_1 == 'success')
                { $output_status_cam_1 = shell("check_ipCAM_UTF8","{$uik_monitoring['ip_adres_cam1']}"); }
                else { $output_status_cam_1 = 'Устройство недоступно!'; $status_cam_1 = 'danger'; }


                $output_ping_cam_2 = shell("check_pingOnline","{$uik_monitoring['ip_adres_cam2']}");
                $ping_cam_2 = status("{$output_ping_cam_2}");


                if ($ping_cam_2 == 'success')
                { $output_status_cam_2 = shell("check_ipCAM_UTF8","{$uik_monitoring['ip_adres_cam2']}"); }
                else { $output_status_cam_2 = 'Устройство недоступно!'; $status_cam_2 = 'danger'; }



                $alarm = $current_var['alarm'];

                $ping_gateway =     status("{$output_ping_gateway}");
                $ping =             status("{$output_ping}");
                $port_status_1 =    status("{$output_port_status_1}");
                $port_status_2 =    status("{$output_port_status_2}");
                $port_status_8 =    status("{$output_port_status_8}");
                $error_1 =          status("{$output_error_1}");
                $error_2 =          status("{$output_error_2}");
                $error_8 =          status("{$output_error_8}");
                $ping_cam_1 =       status("{$output_ping_cam_1}");
                $ping_cam_2 =       status("{$output_ping_cam_2}");
                $status_cam_1 =     status("{$output_status_cam_1}");
                $status_cam_2 =     status("{$output_status_cam_2}");
                $ping_controller =  status("{$output_ping_controller}");

                if (($ping_cam_1 == 'success') && ($status_cam_1 == 'success'))
                { $cam1 = 'success'; } else { $cam1 = 'danger'; }

                if (($ping_cam_2 == 'success') && ($status_cam_2 == 'success'))
                { $cam2 = 'success'; } else { $cam2 = 'danger'; }
                $snmp = 'info';


                if (($commutator == 'success') && ($cam1 == 'success') && ($cam2 == 'success'))
                {
                    if ($current_var['alarm'] != '')
                    { $DB->delete("{$get_name[0]}_monitoring","`uik` = '{$uik_monitoring['naimenovanie_uik_tik']}'"); }
                    $DB->insert("{$get_name[0]}_monitoring",'null, "'.$uik_monitoring['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_status_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_status_cam_2.'", "'.$output_ping_controller.'", "'.date("d.m.y").'", "'.date("H:i:s").'", "success"');
                    $DB->update("{$get_name[0]}","contact_groups","success","`naimenovanie_uik_tik` = '{$uik_monitoring['naimenovanie_uik_tik']}'");
                }

                else if (($commutator != 'success') || ($cam1 != 'success') || ($cam2 != 'success'))
                {
                    $ex_alarm = explode(" ","{$current_var['alarm']}");
                    $current_date = explode(".","$ex_alarm[0]");
                    $current_time = explode(":","$ex_alarm[1]");

                    if ($current_var['alarm'] != '')
                    {
                        $DB->delete("{$get_name[0]}_monitoring","`uik` = '{$uik_monitoring['naimenovanie_uik_tik']}'");
                        if  ($current_var['alarm'] != 'success')
                        {
                            $DB->insert("{$get_name[0]}_monitoring",'null, "'.$uik_monitoring['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_status_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_status_cam_2.'", "'.$output_ping_controller.'", "'.date("d.m.y").'", "'.date("H:i:s").'", "'.$current_var['alarm'].'"');
                            if (((date("d") >= ($current_date[0] + 1)) && (date("H") >= (int)$current_time[0])) || (date("d") > $current_date[0]) || ($current_date[1] < date("m")))
                            { $DB->update("{$get_name[0]}","contact_groups","danger","`naimenovanie_uik_tik` = '{$uik_monitoring['naimenovanie_uik_tik']}'"); }
                            else { $DB->update("{$get_name[0]}","contact_groups","warning","`naimenovanie_uik_tik` = '{$uik_monitoring['naimenovanie_uik_tik']}'"); }
                        }
                        else if  ($current_var['alarm'] == 'success')
                        {
                            $DB->insert("{$get_name[0]}_monitoring",'null, "'.$uik_monitoring['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_status_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_status_cam_2.'", "'.$output_ping_controller.'", "'.date("d.m.y").'", "'.date("H:i:s").'", "'.date("d.m.y H:i:s").'"');
                            $DB->update("{$get_name[0]}","contact_groups","danger","`naimenovanie_uik_tik` = '{$uik_monitoring['naimenovanie_uik_tik']}'");
                        }
                    }
                    else 
                    {
                        $DB->insert("{$get_name[0]}_monitoring",'null, "'.$uik_monitoring['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_status_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_status_cam_2.'", "'.$output_ping_controller.'", "'.date("d.m.y").'", "'.date("H:i:s").'", "'.date("d.m.y H:i:s").'"');
                        $DB->update("{$get_name[0]}","contact_groups","danger","`naimenovanie_uik_tik` = '{$uik_monitoring['naimenovanie_uik_tik']}'");
                    }
                }
            }
        }
        echo '--> '.date("H:i:s").'<br>';
    }
?>