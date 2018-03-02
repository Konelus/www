<!DOCTYPE html>

<?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');
    //$node = '10.234.255.41';
    //$node = '10.153.29.134';
    $node = '127.0.0.1';

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

    $cat_name = end(explode("=", ('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])));
    $podcat_name = explode('?', $cat_name);
    $get_name = explode('/',$podcat_name[1]);

    $SQL_QUERY_monitoring = $mysqli->query("SELECT * FROM `vibory` WHERE `id` = ".$get_name[1]." ");
    while ($row = mysqli_fetch_array($SQL_QUERY_monitoring))
    { $uik_monitoring = $row; }

    $uik_master = "<span style = 'color: gold; font-weight: bold'>Ответсвтенный: </span>".$uik_monitoring['fio_osnovnogo_otvetstvennogo_za_uik'].' - '.$uik_monitoring['kontaktnyy_telefon_sluzhebnyy_sotovyy_osnovnogo'];
    $uik_ex_master = "<span style = 'color: gold; font-weight: bold'>Заместитель: </span>".$uik_monitoring['fio_zamestitelya_na_vremya_otsutstviya_osnovnogo'].' - '.$uik_monitoring['kontaktnyy_telefon_sluzhebnyy_sotovyy_zamestitelya'];


    if (isset ($_POST['confirm']))
    {
        $load_time = '';
        $SQL_QUERY_select_monitoring = $mysqli->query("SELECT * FROM `vibory_monitoring` WHERE `uik` = '".$uik_monitoring['naimenovanie_uik_tik']."' ");
        while ($row = mysqli_fetch_array($SQL_QUERY_select_monitoring)) { $current_var = $row; }
        $time_1 = explode(':', date("H:i:s"));
        $time_2 = explode(':', $current_var['time']);

        if (((($time_1[1] - $time_2[1]) >= 1) || ($time_1[0] > $time_2[0])) || (date("d.m.y") != $current_var['date']))
        {
            $output_ping_gateway = shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_pingOnline -a '.$uik_monitoring['ip_shlyuza'].' ');
            if (strpos($output_ping_gateway, 'OK')) { $ping_gateway = 'success'; } else if (strpos($output_ping_gateway, 'CRITICAL')) { $ping_gateway = 'danger'; }


            if (mb_strtolower("$uik_monitoring[hostgroups]","UTF-8") == 'да')
            {
                $output_ping_controller = shell_exec($_SERVER['DOCUMENT_ROOT'].'/sys/check_nrpe -H '.$node.' -t 90 -c check_pingOnline -a '.$uik_monitoring['ip_adres_kontrollera'].' ');
                if (strpos($output_ping_controller, 'OK')) { $ping_controller = 'success'; } else if (strpos($output_ping_controller, 'CRITICAL')) { $ping_controller = 'danger'; }
            }



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
        }
        else
        {
            $output_ping_gateway = $current_var['gateway'];
            $output_ping = $current_var['ping'];
            $output_snmp = $current_var['snmp'];
            $output_port_status_1 = $current_var['port_1_status'];
            $output_error_1 = $current_var['port_1_errors'];
            $output_port_status_2 = $current_var['port_2_status'];
            $output_error_2 = $current_var['port_2_errors'];
            $output_port_status_8 = $current_var['port_8_status'];
            $output_error_8 = $current_var['port_8_errors'];
            $output_ping_cam_1 = $current_var['ping_cam_1'];
            $output_ststus_cam_1 = $current_var['status_cam1'];
            $output_ping_cam_2 = $current_var['ping_cam_2'];
            $output_ststus_cam_2 = $current_var['status_cam2'];
            $output_ping_controller = $current_var['controller'];
            $alarm = $current_var['alarm'];
            $load_time = "<tr><td colspan = '3' style = 'text-align: center;'>Данные актуальны на ".$current_var['time']."</td></tr>";
        }

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

        if (strpos($output_ping_controller, 'OK')) { $ping_controller = 'success'; } else if (strpos($output_ping_controller, 'CRITICAL')) { $ping_controller = 'danger'; }

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



        if (((($time_1[1] - $time_2[1]) >= 1) || ($time_1[0] > $time_2[0])) || (date("d.m.y") != $current_var['date']))
        {
            if (($commutator == 'success') && ($cam1 == 'success') && ($cam2 == 'success'))
            {
                if ($current_var['alarm'] != '')
                { $DB->delete("{$get_name[0]}_monitoring","`uik` = '{$uik_monitoring['naimenovanie_uik_tik']}'"); }
                $DB->insert("{$get_name[0]}_monitoring",'null, "'.$uik_monitoring['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_ststus_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_ststus_cam_2.'", "'.$output_ping_controller.'", "'.date("d.m.y").'", "'.date("H:i:s").'", "success"');
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
                        $DB->insert("{$get_name[0]}_monitoring",'null, "'.$uik_monitoring['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_ststus_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_ststus_cam_2.'", "'.$output_ping_controller.'", "'.date("d.m.y").'", "'.date("H:i:s").'", "'.$current_var['alarm'].'"');


                        if (((date("d") == ($current_date[0] + 1)) && (date("H") > (int)$current_time[0])) || (date("d") > $current_date[0]) || ($current_date[1] < date("m")))
                        { $DB->update("{$get_name[0]}","contact_groups","danger","`naimenovanie_uik_tik` = '{$uik_monitoring['naimenovanie_uik_tik']}'"); }
                        else { $DB->update("{$get_name[0]}","contact_groups","warning","`naimenovanie_uik_tik` = '{$uik_monitoring['naimenovanie_uik_tik']}'"); }
                    }
                    else if  ($current_var['alarm'] == 'success')
                    {
                        $DB->insert("{$get_name[0]}_monitoring",'null, "'.$uik_monitoring['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_ststus_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_ststus_cam_2.'", "'.$output_ping_controller.'", "'.date("d.m.y").'", "'.date("H:i:s").'", "'.date("d.m.y H:i:s").'"');
                        $DB->update("{$get_name[0]}","contact_groups","warning","`naimenovanie_uik_tik` = '{$uik_monitoring['naimenovanie_uik_tik']}'");
                    }
                }
                else
                {
                    $DB->insert("{$get_name[0]}_monitoring",'null, "'.$uik_monitoring['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_ststus_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_ststus_cam_2.'", "'.$output_ping_controller.'", "'.date("d.m.y").'", "'.date("H:i:s").'", "'.date("d.m.y H:i:s").'"');
                    $DB->update("{$get_name[0]}","contact_groups","warning","`naimenovanie_uik_tik` = '{$uik_monitoring['naimenovanie_uik_tik']}'");
                }
            }
        }
    }
?>



<html lang="ru">
    <head>
        <title><?= $uik_monitoring['naimenovanie_uik_tik'] ?> (Мониторинг)</title>
        <link rel="shortcut icon" href="/img/favicon.png" type="image/png">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
    </head>

    <body>
        <div style = 'background: black; color: white; text-align: center; padding-top: 5px; font-size: 26px;'><?= $uik_monitoring['naimenovanie_uik_tik'] ?></div>
        <div style = 'background: black; color: white; text-align: center; padding-bottom: 5px; font-size: 22px;'><?= $uik_monitoring['adres_uik_tik'] ?></div>
        <div style = 'background: black; color: white; text-align: center; padding-bottom: 5px; font-size: 22px;'><?= 'Network: '.$uik_monitoring['vydelennaya_set'] ?></div>
        <div style = 'background: black; color: white; text-align: center; padding-bottom: 5px; font-size: 16px;'>
            <?= $uik_master ?>
        </div>
        <div style = 'background: black; color: white; text-align: center; padding-bottom: 5px; font-size: 16px;'>
            <?= $uik_ex_master ?>
        </div>

        <table class = 'table'>
            <tr class = '<?= $ready_class ?>'>
                <td colspan = '2' style = 'width: 200px; border-right: solid 1px lightgrey; text-align: center; font-weight: bold; border-bottom: solid 2px black;'>Готовность объекта</td>
                <td style = 'border-bottom: solid 2px black;'><?= $ready ?></td>
            </tr>
            <tr class = '<?= $ping_gateway ?>'>
                <td style = 'width: 200px; border-right: solid 1px lightgrey;'>Шлюз<br><?= $uik_monitoring['ip_shlyuza'] ?></td>
                <td style = 'width: 200px; border-right: solid 1px lightgrey;'>Ping</td>
                <td><?= $output_ping_gateway ?></td>
            </tr>
            <tr>
                <td class = '<?= $commutator ?>' rowspan = '8' style = 'width: 200px; border-right: solid 1px lightgrey;'>Коммутатор<br><?= $uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik'] ?></td>
                <td class = '<?= $ping ?>' style = 'width: 200px; border-right: solid 1px lightgrey;'>Ping</td>
                <td class = '<?= $ping ?>'><?= $output_ping ?></td>
            </tr>
            <tr class = '<?= $snmp ?>'>
                <td style = 'width: 200px; border-right: solid 1px lightgrey;'>SNMP</td>
                <td><?= $output_snmp ?></td>
            </tr>
            <tr class = '<?= $port_status_1 ?>'>
                <td style = 'width: 200px; border-right: solid 1px lightgrey;'>Port 1 - status UP/DOWN</td>
                <td><?= $output_port_status_1 ?></td>
            </tr>
            <tr class = '<?= $error_1 ?>' style = 'border-bottom: solid 1px lightgrey;'>
                <td style = 'width: 200px; border-right: solid 1px lightgrey;'>Port 1 - Error</td>
                <td><?= $output_error_1 ?></td>
            </tr>
            <tr class = '<?= $port_status_2 ?>'>
                <td style = 'width: 200px; border-right: solid 1px lightgrey;'>Port 2 - status UP/DOWN</td>
                <td><?= $output_port_status_2 ?></td>
            </tr>
            <tr class = '<?= $error_2 ?>'>
                <td style = 'width: 200px; border-right: solid 1px lightgrey;'>Port 2 - Error</td>
                <td><?= $output_error_2 ?></td>
            </tr>
            <tr class = '<?= $port_status_8 ?>'>
                <td style = 'width: 200px; border-right: solid 1px lightgrey;'>Port 8 - status UP/DOWN</td>
                <td><?= $output_port_status_8 ?></td>
            </tr>
            <tr class = '<?= $error_8 ?>'>
                <td style = 'width: 200px; border-right: solid 1px lightgrey;'>Port 8 - Error</td>
                <td><?= $output_error_8 ?></td>
            </tr>

            <tr>
                <td class = '<?= $cam1 ?>' rowspan = '2' style = 'width: 200px; border-right: solid 1px lightgrey;'>Камера 1<br><?= 'RID: '.$uik_monitoring['rid_obekta'].'<br>'.$uik_monitoring['ip_adres_cam1'] ?></td>
                <td class = '<?= $ping_cam_1 ?>' style = 'width: 200px; border-right: solid 1px lightgrey;'>Ping</td>
                <td class = '<?= $ping_cam_1 ?>' ><?= $output_ping_cam_1 ?></td>
            </tr>
            <tr class = '<?= $ststus_cam_1 ?>' style = 'border-bottom: solid 1px lightgrey;'>
                <td style = 'width: 200px; border-right: solid 1px lightgrey;'>Status</td>
                <td><?= $output_ststus_cam_1 ?></td>
            </tr>
            <tr>
                <td  class = '<?= $cam2 ?>' rowspan = '2' style = 'width: 200px; border-right: solid 1px lightgrey;'>Камера 2<br><?= 'RID: '.$uik_monitoring['rid_obekta'].'<br>'.$uik_monitoring['ip_adres_cam2'] ?></td>
                <td class = '<?= $ping_cam_2 ?>' style = 'width: 200px; border-right: solid 1px lightgrey;'>Ping</td>
                <td class = '<?= $ping_cam_2 ?>'><?= $output_ping_cam_2 ?></td>
            </tr>
            <tr class = '<?= $ststus_cam_2 ?>' style = 'border: solid 1px lightgrey;'>
                <td style = 'width: 200px; border-right: solid 1px lightgrey;'>Status</td>
                <td><?= $output_ststus_cam_2 ?></td>
            </tr>
            <tr class = '<?= $ping_controller ?>' style = 'border: solid 1px lightgrey;'>
                <td style = 'width: 200px; border-right: solid 1px lightgrey;'>Контроллер<br><?= $uik_monitoring['ip_adres_kontrollera'] ?></td>
                <td style = 'width: 200px; border-right: solid 1px lightgrey;'>Ping</td>
                <td><?= $output_ping_controller ?></td>
            </tr>
            <?= $load_time; ?>

        </table>
        <form method = "post">
            <div style = 'width: 150px; height: 40px; margin: auto;'><input type = 'submit' style = 'width: 100%; height: 100%; border: solid 1px black; background: gold; font-size: 20px;' value = 'Начать тест' name = 'confirm'></div>
        </form>
    </body>
</html>