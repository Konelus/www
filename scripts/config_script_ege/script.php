<div style = 'float: left; width: 45%; margin-right: 5%;'>
    <form method = 'post'>
        <input style = 'margin: auto; width: 100%; height: 40px; background: gold; border-radius: 5px; border: solid 1px black;' type = 'submit' name = 'create_ege' value = 'Создать конфиги EGE'>
    </form>
</div>

<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');

    if (isset ($_POST['create_ege']))
    {
        $files = glob($_SERVER['DOCUMENT_ROOT'].'/scripts/config_script_ege/config/*');
        foreach($files as $file)
        { if(is_file($file)) { unlink($file); } }

        $files = glob($_SERVER['DOCUMENT_ROOT'].'/scripts/config_script_ege/config/1251/*');
        foreach($files as $file)
        { if(is_file($file)) { unlink($file); } }

        $files = glob($_SERVER['DOCUMENT_ROOT'].'/scripts/config_script_ege/config/new/*');
        foreach($files as $file)
        { if(is_file($file)) { unlink($file); } }
        $str = '';
        $rid = '';
        $count = 1;
        $count_bool = false;


        $DB->select("*","ege","","`rid_obekta` ASC","");
        while ($array = mysqli_fetch_array($DB->sql_query_select))
        {
            if (($array['adres_en'] != 'Адрес EN') && ($array['adres_en'] != 'Столбец 8'))
            {
                if ($rid == '') { $rid = $array['rid_obekta']; }


                if (($rid != $array['rid_obekta']) && ($rid != '') || (($count == 131) && ($count_bool == false)))
                {
                    $str[$count] =
"define hostgroup{
    hostgroup_name {$arr['adres_en']};
    alias ".trim($arr['adres_ru']).";
    notes Представитель ППЭ: {$array['predstavitel_ppe_telefon_e_mail']};
}
".$str[$count];
                    //echo "{$count} <pre>{$str[$count]}</pre>";
                    if ($count < 131) { $count++; } else { $count_bool = true; }
                }
                $rid = $array['rid_obekta'];




                if ($array['usb_ipcam'] == 'USB')
                {
                    if ($array['online_offline'] == 'online')
                    {
                        $str[$count] .=
"define host{
    use generic-ege-usbpac,host-pnp;
    host_name {$array['rid_pak']}{$array['adres_en']};
    alias ".trim($array['adres_ru'])." каб. {$array['mesto_ustanovki']};
    address {$array['ip_adres_pak_ipcam']};
    hostgroups {$array['adres_en']},z_USBPAC,{$array['hostgroups']};
    contact_groups EGE,{$array['contact_groups']};
    notes Ответственный Ростелеком: {$array['fio_osnovnogo_otvetstvennogo_za_ppe']} {$array['e_mail_osnovnogo_otvetstvennogo_za_ppe']} {$array['kontaktnyy_telefon_123']};
    contact_groups EGE,nvch;^M
}
";
                    }
                }
                elseif ($array['usb_ipcam'] == 'IPCAM')
                {
                    $str[$count] .=
"define host{
    use generic-ege-ipcam,host-pnp;
    host_name {$array['rid_pak']}{$array['adres_en']};
    alias ".trim($array['adres_ru'])." каб. {$array['mesto_ustanovki']};
    address {$array['ip_adres_pak_ipcam']};
    hostgroups {$array['adres_en']},z_IPCAM,{$array['hostgroups']};
    contact_groups EGE,{$array['contact_groups']};
    notes Ответственный Ростелеком: {$array['fio_osnovnogo_otvetstvennogo_za_ppe']} {$array['fio_osnovnogo_otvetstvennogo_za_ppe']} {$array['fio_osnovnogo_otvetstvennogo_za_ppe']};
}
";
                }
                $arr['adres_en'] = $array['adres_en'];
                $arr['adres_ru'] = $array['adres_ru'];
                $arr['rid_obekta'] = $array['rid_obekta'];
                $arr_name['adres_en'][$count] = $array['adres_en'];
                $arr_name['adres_ru'][$count] = $array['adres_ru'];
                $arr_name['rid_obekta'][$count] = $array['rid_obekta'];

                //$count++;
                //echo '<pre>'.$count.' - '.$str[$count].'</pre><br><hr>';
            }
        }
        foreach ($str as $key => $value)
        {
            $win_str = iconv("UTF-8", "windows-1251", $value);
            //echo $arr['rid_obekta'].' - '.$arr['adres_ru'].'<br>';

            $fp = fopen($_SERVER['DOCUMENT_ROOT']."/scripts/config_script_ege/config/{$arr_name['adres_en'][$key]}.cfg", "w");
            fwrite($fp, $value);
            fclose($fp);

            $fp = fopen($_SERVER['DOCUMENT_ROOT']."/scripts/config_script_ege/config/1251/{$arr_name['adres_en'][$key]}.cfg", "w");
            fwrite($fp, $win_str);
            fclose($fp);

            //$str = '';
            //$rid = $array['rid_obekta'];
            //echo '<pre>'.$key.' -> '.$value.'</pre><br><hr>';

        }

        $text = 'Создание cfg-файлов завершено!';
    }
?>