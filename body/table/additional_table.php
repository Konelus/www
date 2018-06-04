<?php
    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/use.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/body/table/monitoring_sys/monitoring_func.php');



    $get_name = explode('/',$substring);


    $DB->select("*","vibory","`id` = '{$get_name[1]}'");
    while ($row = mysqli_fetch_array($DB->sql_query_select))
    { $uik_monitoring = $row; }

    $uik_master = "<span style = 'color: gold; font-weight: bold'>Ответственный: </span>".$uik_monitoring['fio_osnovnogo_otvetstvennogo_za_uik'].' - '.$uik_monitoring['kontaktnyy_telefon_sluzhebnyy_sotovyy_osnovnogo'];
    $uik_ex_master = "<span style = 'color: gold; font-weight: bold'>Заместитель: </span>".$uik_monitoring['fio_zamestitelya_na_vremya_otsutstviya_osnovnogo'].' - '.$uik_monitoring['kontaktnyy_telefon_sluzhebnyy_sotovyy_zamestitelya'];


    if (isset ($_POST['confirm']))
    {
        $load_time = '';
        $DB->select("*","vibory_monitoring","`uik` = '{$uik_monitoring['naimenovanie_uik_tik']}'");
        while ($row = mysqli_fetch_array($DB->sql_query_select)) { $current_var = $row; }
        $time_1 = explode(':', date("H:i:s"));
        $time_2 = explode(':', $current_var['time']);

        if (((($time_1[1] - $time_2[1]) >= 1) || ($time_1[0] > $time_2[0])) || (date("d.m.y") != $current_var['date']))
        {
            $output_ping_gateway =  shell("check_pingOnline","{$uik_monitoring['ip_shlyuza']}");
            $output_ping =          shell("check_pingOnline", "{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}");
            $ping_gateway =         status("{$output_ping_gateway}");
            $ping =                 status("{$output_ping}");


            if (mb_strtolower("$uik_monitoring[hostgroups]","UTF-8") == 'да')
            {
                $output_ping_controller = shell("check_pingOnline","{$uik_monitoring['ip_adres_kontrollera']}");
                $ping_controller = status("{$output_ping_controller}");
            }



            if ($ping == 'success')
            {
                $output_snmp =          str_replace('"', '\'', shell("check_Vendor","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}"));
                $output_port_status_1 = shell("check_port1Status","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                $output_port_status_2 = shell("check_port1Er","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                $output_port_status_8 = shell("check_port8Status","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                $output_error_1 =       shell("check_port1Er","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}");
                $output_error_2 =       shell("check_port2Er","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}");


                if ($uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik'] == '10.234.9.62') { $output_error_8 = 'SNMP OK - Проверка не производилась'; }
                else { $output_error_8 = shell("check_port8Er","{$uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik']}"); }
            }
            else
            {
                $output_port_status_1 = $output_error_1 = $output_port_status_2 = $output_error_2 = $output_port_status_8 = $output_error_8 = 'Устройство недоступно!';
                $port_status_1 = $error_1 = $port_status_2 = $error_2 = $port_status_8 = $error_8 = 'danger';
            }

            $output_ping_cam_1 =    shell("check_pingOnline","{$uik_monitoring['ip_adres_cam1']}");
            $output_ping_cam_2 =    shell("check_pingOnline","{$uik_monitoring['ip_adres_cam2']}");
            $ping_cam_1 =           status("{$output_ping_cam_1}");
            $ping_cam_2 =           status("{$output_ping_cam_2}");


            if ($ping_cam_1 == 'success')
            { $output_status_cam_1 = shell("check_ipCAM_UTF8","{$uik_monitoring['ip_adres_cam1']}"); }
            else { $output_status_cam_1 = 'Устройство недоступно!'; $status_cam_1 = 'danger'; }



            if ($ping_cam_2 == 'success')
            { $output_status_cam_2 = shell("check_ipCAM_UTF8","{$uik_monitoring['ip_adres_cam2']}"); }
            else { $output_status_cam_2 = 'Устройство недоступно!'; $status_cam_2 = 'danger'; }
        }
        else
        {
            $output_ping_gateway        = $current_var['gateway'];
            $output_ping                = $current_var['ping'];
            $output_snmp                = $current_var['snmp'];
            $output_port_status_1       = $current_var['port_1_status'];
            $output_error_1             = $current_var['port_1_errors'];
            $output_port_status_2       = $current_var['port_2_status'];
            $output_error_2             = $current_var['port_2_errors'];
            $output_port_status_8       = $current_var['port_8_status'];
            $output_error_8             = $current_var['port_8_errors'];
            $output_ping_cam_1          = $current_var['ping_cam_1'];
            $output_status_cam_1        = $current_var['status_cam1'];
            $output_ping_cam_2          = $current_var['ping_cam_2'];
            $output_status_cam_2        = $current_var['status_cam2'];
            $output_ping_controller     = $current_var['controller'];
            $alarm                      = $current_var['alarm'];
            $load_time                  = "<tr><td colspan = '3' style = 'text-align: center;'>Данные актуальны на {$current_var['time']}</td></tr>";
        }




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


        if (($ping == 'success') && ($port_status_1 == 'success') && ($port_status_2 == 'success') && ($port_status_8 == 'success') && ($error_1 == 'success') && ($error_2 == 'success') && ($error_8 == 'success'))
        { $commutator = 'success'; } else { $commutator = 'danger'; }

        if (($ping_cam_1 == 'success') && ($status_cam_1 == 'success'))
        { $cam1 = 'success'; } else { $cam1 = 'danger'; }

        if (($ping_cam_2 == 'success') && ($status_cam_2 == 'success'))
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
                $DB->insert("{$get_name[0]}_monitoring",'null, "'.$uik_monitoring['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_status_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_status_cam_2.'", "'.$output_ping_controller.'", "'.date("d.m.y").'", "'.date("H:i:s").'", "success"');
                $DB->update("{$get_name[0]}","contact_groups","success","`naimenovanie_uik_tik` = '{$uik_monitoring['naimenovanie_uik_tik']}'");
            }

            else if (($commutator != 'success') || ($cam1 != 'success') || ($cam2 != 'success'))
            {
                $ex_alarm =     explode(" ","{$current_var['alarm']}");
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
                        $DB->update("{$get_name[0]}","contact_groups","warning","`naimenovanie_uik_tik` = '{$uik_monitoring['naimenovanie_uik_tik']}'");
                    }
                }
                else
                {
                    $DB->insert("{$get_name[0]}_monitoring",'null, "'.$uik_monitoring['naimenovanie_uik_tik'].'", "'.$output_ping_gateway.'", "'.$output_ping.'", "'.$output_snmp.'", "'.$output_port_status_1.'", "'.$output_error_1.'", "'.$output_port_status_2.'", "'.$output_error_2.'", "'.$output_port_status_8.'", "'.$output_error_8.'", "'.$output_ping_cam_1.'", "'.$output_status_cam_1.'", "'.$output_ping_cam_2.'", "'.$output_status_cam_2.'", "'.$output_ping_controller.'", "'.date("d.m.y").'", "'.date("H:i:s").'", "'.date("d.m.y H:i:s").'"');
                    $DB->update("{$get_name[0]}","contact_groups","warning","`naimenovanie_uik_tik` = '{$uik_monitoring['naimenovanie_uik_tik']}'");
                }
            }
        }
    }
?>



<!DOCTYPE html>
<html lang="ru">
    <head>
        <title><?= $uik_monitoring['naimenovanie_uik_tik'] ?> (Мониторинг)</title>
        <link rel="shortcut icon" href="/img/favicon.png" type="image/png">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/body/table/monitoring_sys/monitoring_style.css">
    </head>

    <body>
        <div class = 'title_all fs_26'><?= $uik_monitoring['naimenovanie_uik_tik'] ?></div>
        <div class = 'title_all fs_22'><?= $uik_monitoring['adres_uik_tik'] ?></div>
        <div class = 'title_all fs_22'><?= "Network: {$uik_monitoring['vydelennaya_set']}" ?></div>
        <div class = 'title_all fs_22'><?= "Оператор ПМ: {$uik_monitoring['naimenovanie_operatora_pm']}" ?></div>
        <div class = 'title_all fs_16'><?= $uik_master ?></div>
        <div class = 'title_all fs_16'><?= $uik_ex_master ?></div>

        <table class = 'table'>
            <tr class = '<?= $ready_class ?>'>
                <td colspan = '2' class = 'table_title' style = 'text-align: center; font-weight: bold; border-bottom: solid 2px black;'>Готовность объекта</td>
                <td style = 'border-bottom: solid 2px black;'><?= $ready ?></td>
            </tr>
            <tr class = '<?= $ping_gateway ?>'>
                <td class = 'table_title'>Шлюз<br><?= $uik_monitoring['ip_shlyuza'] ?></td>
                <td class = 'table_title'>Ping</td>
                <td><?= $output_ping_gateway ?></td>
            </tr>
            <tr>
                <td class = 'table_title <?= $commutator ?>' rowspan = '8'>Коммутатор<br><?= $uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik'] ?></td>
                <td class = 'table_title <?= $ping ?>'>Ping</td>
                <td class = '<?= $ping ?>'><?= $output_ping ?></td>
            </tr>
            <tr class = '<?= $snmp ?>'>
                <td class = 'table_title'>SNMP</td>
                <td><?= $output_snmp ?></td>
            </tr>
            <tr class = '<?= $port_status_1 ?>'>
                <td class = 'table_title'>Port 1 - status UP/DOWN</td>
                <td><?= $output_port_status_1 ?></td>
            </tr>
            <tr class = '<?= $error_1 ?>' style = 'border-bottom: solid 1px lightgrey;'>
                <td class = 'table_title'>Port 1 - Error</td>
                <td><?= $output_error_1 ?></td>
            </tr>
            <tr class = '<?= $port_status_2 ?>'>
                <td class = 'table_title'>Port 2 - status UP/DOWN</td>
                <td><?= $output_port_status_2 ?></td>
            </tr>
            <tr class = '<?= $error_2 ?>'>
                <td class = 'table_title'>Port 2 - Error</td>
                <td><?= $output_error_2 ?></td>
            </tr>
            <tr class = '<?= $port_status_8 ?>'>
                <td class = 'table_title'>Port 8 - status UP/DOWN</td>
                <td><?= $output_port_status_8 ?></td>
            </tr>
            <tr class = '<?= $error_8 ?>'>
                <td class = 'table_title'>Port 8 - Error</td>
                <td><?= $output_error_8 ?></td>
            </tr>

            <tr>
                <td class = 'table_title <?= $cam1 ?>' rowspan = '2'>Камера 1<br><?= "RID: {$uik_monitoring['rid_obekta']}<br>{$uik_monitoring['ip_adres_cam1']}" ?></td>
                <td class = 'table_title <?= $ping_cam_1 ?>'>Ping</td>
                <td class = '<?= $ping_cam_1 ?>' ><?= $output_ping_cam_1 ?></td>
            </tr>
            <tr class = '<?= $status_cam_1 ?>' style = 'border-bottom: solid 1px lightgrey;'>
                <td class = 'table_title'>Status</td>
                <td><?= $output_status_cam_1 ?></td>
            </tr>
            <tr>
                <td class = 'table_title <?= $cam2 ?>' rowspan = '2'>Камера 2<br><?= "RID: {$uik_monitoring['rid_obekta']}<br>{$uik_monitoring['ip_adres_cam2']}" ?></td>
                <td class = 'table_title <?= $ping_cam_2 ?>'>Ping</td>
                <td class = '<?= $ping_cam_2 ?>'><?= $output_ping_cam_2 ?></td>
            </tr>
            <tr class = '<?= $status_cam_2 ?>' style = 'border: solid 1px lightgrey;'>
                <td class = 'table_title'>Status</td>
                <td><?= $output_status_cam_2 ?></td>
            </tr>
            <tr class = '<?= $ping_controller ?>' style = 'border: solid 1px lightgrey;'>
                <td class = 'table_title'>Контроллер<br><?= $uik_monitoring['ip_adres_kontrollera'] ?></td>
                <td claSS = 'table_title'>Ping</td>
                <td><?= $output_ping_controller ?></td>
            </tr>
            <?= $load_time; ?>

        </table>
        <form method = "post">
            <div style = 'width: 150px; height: 40px; margin: auto;'><input type = 'submit' style = 'width: 100%; height: 100%; border: solid 1px black; background: gold; font-size: 20px;' value = 'Начать тест' name = 'confirm'></div>
        </form>


        <?php if ((isset($_POST['confirm'])) && ($_COOKIE['user'] = 'user123')) { ?>
        <div style = 'width: 100%; margin-top: 20px; margin-bottom: 20px; font-family: "Times New Roman";'>
            <div style = 'width: 90%; margin: auto; border: solid 1px grey;'>
                <div style = 'text-align: center; padding-top: 5px;'><?= $uik_monitoring['naimenovanie_uik_tik'] ?></div>
                <div style = 'text-align: center; padding-bottom: 5px;'><?= $uik_monitoring['adres_uik_tik'] ?></div>
                <div style = 'text-align: center; padding-bottom: 5px;'><?= 'Network: '.$uik_monitoring['vydelennaya_set'] ?></div>
                <div style = 'text-align: center; padding-bottom: 5px;'><?= 'Оператор ПМ: '.$uik_monitoring['naimenovanie_operatora_pm'] ?></div>
                <div style = 'text-align: center; padding-bottom: 5px;'>
                    <?= "Ответсвтенный: {$uik_monitoring['fio_osnovnogo_otvetstvennogo_za_uik']} - {$uik_monitoring['kontaktnyy_telefon_sluzhebnyy_sotovyy_osnovnogo']}"; ?>
                </div>
                <div style = 'text-align: center; padding-bottom: 5px; font-size: 16px;'>
                    <?= "Заместитель: {$uik_monitoring['fio_zamestitelya_na_vremya_otsutstviya_osnovnogo']} - {$uik_monitoring['kontaktnyy_telefon_sluzhebnyy_sotovyy_zamestitelya']}"; ?>
                </div>

                <table style = 'margin: auto; border-top: solid 1px black;'>
                    <tr>
                        <td colspan = '2' style = 'width: 200px; text-align: center;'>Готовность объекта</td>
                        <td><?= $ready ?></td>
                    </tr>
                    <tr>
                        <td style = 'width: 200px;'>Шлюз<br><?= $uik_monitoring['ip_shlyuza'] ?></td>
                        <td style = 'width: 200px;'>Ping</td>
                        <td><?= $output_ping_gateway ?></td>
                    </tr>
                    <tr>
                        <td rowspan = '8' style = 'width: 200px;'>Коммутатор<br><?= $uik_monitoring['ip_adres_kommutatora_v_shkafu_uik_tik'] ?></td>
                        <td style = 'width: 200px;'>Ping</td>
                        <td><?= $output_ping ?></td>
                    </tr>
                    <tr>
                        <td style = 'width: 200px;'>SNMP</td>
                        <td><?= $output_snmp ?></td>
                    </tr>
                    <tr>
                        <td style = 'width: 200px;'>Port 1 - status UP/DOWN</td>
                        <td><?= $output_port_status_1 ?></td>
                    </tr>
                    <tr>
                        <td style = 'width: 200px;'>Port 1 - Error</td>
                        <td><?= $output_error_1 ?></td>
                    </tr>
                    <tr>
                        <td style = 'width: 200px;'>Port 2 - status UP/DOWN</td>
                        <td><?= $output_port_status_2 ?></td>
                    </tr>
                    <tr>
                        <td style = 'width: 200px;'>Port 2 - Error</td>
                        <td><?= $output_error_2 ?></td>
                    </tr>
                    <tr>
                        <td style = 'width: 200px;'>Port 8 - status UP/DOWN</td>
                        <td><?= $output_port_status_8 ?></td>
                    </tr>
                    <tr>
                        <td style = 'width: 200px;'>Port 8 - Error</td>
                        <td><?= $output_error_8 ?></td>
                    </tr>

                    <tr>
                        <td rowspan = '2' style = 'width: 200px;'>Камера 1<br><?= "RID: {$uik_monitoring['rid_obekta']}<br>{$uik_monitoring['ip_adres_cam1']}" ?></td>
                        <td style = 'width: 200px;'>Ping</td>
                        <td><?= $output_ping_cam_1 ?></td>
                    </tr>
                    <tr'>
                        <td style = 'width: 200px;'>Status</td>
                        <td><?= $output_status_cam_1 ?></td>
                    </tr>
                    <tr>
                        <td  class = '<?= $cam2 ?>' rowspan = '2' style = 'width: 200px;'>Камера 2<br><?= "RID: {$uik_monitoring['rid_obekta']}<br>{$uik_monitoring['ip_adres_cam2']}" ?></td>
                        <td class = '<?= $ping_cam_2 ?>' style = 'width: 200px;'>Ping</td>
                        <td class = '<?= $ping_cam_2 ?>'><?= $output_ping_cam_2 ?></td>
                    </tr>
                    <tr>
                        <td style = 'width: 200px;'>Status</td>
                        <td><?= $output_status_cam_2 ?></td>
                    </tr>
                    <tr>
                        <td style = 'width: 200px;'>Контроллер<br><?= $uik_monitoring['ip_adres_kontrollera'] ?></td>
                        <td style = 'width: 200px;'>Ping</td>
                        <td><?= $output_ping_controller ?></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php } ?>

    </body>
</html>