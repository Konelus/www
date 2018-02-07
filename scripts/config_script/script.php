<?php
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
?>

    <div style = 'margin-top: 10px; float: left; width: 45%; margin-right: 5%;'>
        <form method = 'post'>
            <input style = 'margin: auto; width: 100%; height: 40px; background: gold; border-radius: 5px; border: solid 1px black;' type = 'submit' name = 'create' value = 'Создать конфиги'>
        </form>
    </div>

<?php
if (isset ($_POST['create']))
{
    $files = glob($_SERVER['DOCUMENT_ROOT'].'/scripts/config_script/config/*');
    foreach($files as $file)
    { if(is_file($file)) { unlink($file); } }

    $files = glob($_SERVER['DOCUMENT_ROOT'].'/scripts/config_script/config/1251/*');
    foreach($files as $file)
    { if(is_file($file)) { unlink($file); } }

    $files = glob($_SERVER['DOCUMENT_ROOT'].'/scripts/config_script/config/new/*');
    foreach($files as $file)
    { if(is_file($file)) { unlink($file); } }

    //$count = 0;
    $vibory_count = 0;
    $SQL_QUERY_select_vibory = $mysqli->query("SELECT * FROM `vibory`");
    while ($row = mysqli_fetch_array($SQL_QUERY_select_vibory))
    { $vibory_var[$vibory_count] = $row; $vibory_count++; }


    $sys_count = 0;
    $SQL_QUERY_select_sys = $mysqli->query("SELECT * FROM `vibory_sys`");
    while ($row = mysqli_fetch_array($SQL_QUERY_select_sys))
    { $sys_var[$sys_count] = $row; $sys_count++; }

    $host_1 = ''; $host_2 = ''; $host_3 = ''; $host_4 = ''; $host_5 = ''; $host_6 = ''; $host_7 = '';
    $host_8 = ''; $host_9 = ''; $host_10 = ''; $host_11 = ''; $host_12 = ''; $host_13 = ''; $host_14 = '';
    $host_15 = ''; $host_16 = ''; $host_17 = ''; $host_18 = ''; $host_19 = ''; $host_20 = '';

    for ($count = 2; $count < $sys_count; $count++)
    {
        $hostgroups = explode(',', $sys_var[$count]['hostgroups']);

//
//        if ($hostgroups[1] == '0_AZV') { $host_1 = $host_1.$hostgroups[1]; }
//        else if ($hostgroups[1] == '0_KSH') { $host_2 = $host_2.$hostgroups[1]; }
//        else if ($hostgroups[1] == '0_NVCH') { $host_3 = $host_3.$hostgroups[1]; }
//        if ($hostgroups[1] == '0_RND')
//        {
//            $host_4 = $host_4.$hostgroups[1];
//            if ($hostgroups[2] == '0_USTP1') { $host_5 = $host_5.$hostgroups[2]; }
//            else if ($hostgroups[2] == '0_USTP2') { $host_6 = $host_6.$hostgroups[2]; }
//            else if ($hostgroups[2] == '0_USTP3') { $host_7 = $host_7.$hostgroups[2]; }
//            else if ($hostgroups[2] == '0_USTP4') { $host_8 = $host_8.$hostgroups[2]; }
//            else if ($hostgroups[2] == '0_USTP5') { $host_9 = $host_9.$hostgroups[2]; }
//            else if ($hostgroups[2] == '0_USTP6') { $host_10 = $host_10.$hostgroups[2]; }
//            else if ($hostgroups[2] == '0_USTP7')
//            { $host_11 = $host_11.$hostgroups[2]; }
//        }
//
//        else if ($hostgroups[1] == '0_TG')  { $host_12 = $host_12.$hostgroups[1]; }
//        else if ($hostgroups[1] == '0_VGD')  { $host_13 = $host_13.$hostgroups[1]; }
//
//
//        if ($hostgroups[2] == '0_AISS_R') { $host_14 = $host_14.$hostgroups[2]; }
//        if (($hostgroups[2] == '0_USTP1') || ($hostgroups[2] == '0_USTP2') || ($hostgroups[2] == '0_USTP4') || ($hostgroups[2] == '0_USTP5'))
//        { if ($hostgroups[3] == '0_AISS_R') { $host_15 = $host_15.$hostgroups[3]; } }
//        if (($hostgroups[1] == '0_VGD') || ($hostgroups[1] == '0_TG') || ($hostgroups[1] == '0_NVCH'))
//        {
//            if ($hostgroups[2] == '0_AISS_R') { $host_16 = $host_16.$hostgroups[2]; }
//            if ($hostgroups[2] == '0_ARK') { $host_17 = $host_17.$hostgroups[2]; }
//        }
//        if (($hostgroups[2] == '0_USTP1') || ($hostgroups[2] == '0_USTP3') || ($hostgroups[2] == '0_USTP5'))
//        { if ($hostgroups[3] == '0_ARK') { $host_18 = $host_18.$hostgroups[3]; } }
//        if (($hostgroups[1] == '0_AZV') || ($hostgroups[1] == '0_NVCH') || ($hostgroups[2] == '0_USTP1') || ($hostgroups[2] == '0_USTP2') || ($hostgroups[2] == '0_USTP6') || ($hostgroups[2] == '0_USTP7') || ($hostgroups[1] == '0_VGD'))
//        {
//            if ($hostgroups[2] == '0_Donsv') { $host_19 = $host_19.$hostgroups[2]; }
//            if ($hostgroups[3] == '0_Donsv') { $host_20 = $host_20.$hostgroups[3]; }
//        }



        if ($hostgroups[1] == '0_AZV') { $host_gr_1 = '0_AZV'; $host_1 = $host_1.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        else if ($hostgroups[1] == '0_KSH') { $host_gr_2 = '0_KSH'; $host_2 = $host_2.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        else if ($hostgroups[1] == '0_NVCH') { $host_gr_3 = '0_NVCH'; $host_3 = $host_3.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        else if ($hostgroups[1] == '0_RND') { $host_gr_4 = '0_RND'; $host_4 = $host_4.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        else if ($hostgroups[1] == '0_TG')  { $host_gr_5 = '0_TG'; $host_5 = $host_5.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        else if ($hostgroups[1] == '0_VGD')  { $host_gr_6 = '0_VGD'; $host_6 = $host_6.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }

        if ($hostgroups[2] == '0_USTP1') { $host_gr_7 = '0_USTP1'; $host_7 = $host_7.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        else if ($hostgroups[2] == '0_USTP2') { $host_gr_8 = '0_USTP2'; $host_8 = $host_8.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        else if ($hostgroups[2] == '0_USTP3') { $host_gr_9 = '0_USTP3'; $host_9 = $host_9.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        else if ($hostgroups[2] == '0_USTP4') { $host_gr_10 = '0_USTP4'; $host_10 = $host_10.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        else if ($hostgroups[2] == '0_USTP5') { $host_gr_11 = '0_USTP5'; $host_11 = $host_11.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        else if ($hostgroups[2] == '0_USTP6') { $host_gr_12 = '0_USTP6'; $host_12 = $host_12.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        else if ($hostgroups[2] == '0_USTP7') { $host_gr_13 = '0_USTP7'; $host_13 = $host_13.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        else if ($hostgroups[2] == '0_AISS_R') { $host_gr_14 = '0_AISS_R'; $host_14 = $host_14.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        //else if ($hostgroups[2] == '0_AISS_R') { $host_15 = $host_15.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }

        if (($hostgroups[2] == '0_ARK') || ($hostgroups[3] == '0_ARK')) { $host_gr_15 = '0_ARK'; $host_15 = $host_15.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        if (($hostgroups[2] == '0_Donsv') || ($hostgroups[3] == '0_Donsv')) { $host_gr_16 = '0_Donsv'; $host_16 = $host_16.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }
        if ($hostgroups[3] == '0_AISS_R') { $host_gr_17 = '0_AISS_R'; $host_17 = $host_17.$vibory_var[$count]['description'].'_SW,'.$vibory_var[$count]['description'].'_CAM1,'.$vibory_var[$count]['description'].'_CAM2;'; }

            $str = 'define hostgroup{
    hostgroup_name '.$vibory_var[$count]['description'].';
    alias '.$vibory_var[$count]['naimenovanie_uik_tik'].' '.$vibory_var[$count]['adres_uik_tik'].';
}



define host{
    use generic-vib2018_SW;
    host_name '.$vibory_var[$count]['description'].'_SW;
    alias Swith '.$vibory_var[$count]['naimenovanie_uik_tik'].' '.$vibory_var[$count]['adres_uik_tik'].';
    address '.$vibory_var[$count]['ip_adres_kommutatora_v_shkafu_uik_tik'].';
    hostgroups '.$vibory_var[$count]['description'].',ViborySwith,'.$sys_var[$count]['hostgroups'].';
    contact_groups '.$sys_var[$count]['contact_groups'].';
}

define host{
    use generic-vib2018_CAM;
    host_name '.$vibory_var[$count]['description'].'_CAM1;
    alias CAM1 Комисия '.$vibory_var[$count]['naimenovanie_uik_tik'].' '.$vibory_var[$count]['adres_uik_tik'].';
    address '.$vibory_var[$count]['ip_adres_cam1'].';
    parents '.$vibory_var[$count]['description'].'_SW;
    hostgroups '.$vibory_var[$count]['description'].',node1,DS-2CD2432F'.','.$sys_var[$count]['hostgroups'].';
    contact_groups '.$sys_var[$count]['contact_groups'].';
}
define host{
    use generic-vib2018_CAM;
    host_name '.$vibory_var[$count]['description'].'_CAM2;
    alias CAM2 Урна '.$vibory_var[$count]['naimenovanie_uik_tik'].' '.$vibory_var[$count]['adres_uik_tik'].';
    address '.$vibory_var[$count]['ip_adres_cam2'].';
    parents '.$vibory_var[$count]['description'].'_SW;
    hostgroups '.$vibory_var[$count]['description'].',node2,DS-2CD2432F'.','.$sys_var[$count]['hostgroups'].';
    contact_groups '.$sys_var[$count]['contact_groups'].';
}';


            $win_str = iconv("UTF-8", "windows-1251", $str);
            if ($vibory_var[$count]['description'] != null)
            {
                //echo $_SERVER['DOCUMENT_ROOT'].'/scripts/config_script/config/'.str_replace(',', '_', str_replace('/', '-', $vibory_var[$count]['description'])).".cfg";
                $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/scripts/config_script/config/'.str_replace(',', '_', str_replace('/', '-', $vibory_var[$count]['description'])).".cfg", "w");
                fwrite($fp, $str);
                fclose($fp);

                $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/scripts/config_script/config/1251/'.str_replace(',', '_', str_replace('/', '-', $vibory_var[$count]['description'])).".cfg", "w");
                fwrite($fp, $win_str);
                fclose($fp);
            }
    }

    $str_2 = 'define hostgroup{
    hostgroup_name '.$vibory_var[$count]['description'].';
    hostgroup_members '.$host_gr_1.','.$host_gr_2.','.$host_gr_3.','.$host_gr_4.','.$host_gr_5.','.$host_gr_6.','.$host_gr_7.','.$host_gr_8.','.$host_gr_9.','. $host_gr_10.','.$host_gr_11.','.$host_gr_12.','.$host_gr_13.','.$host_gr_14.','.$host_gr_15.','.$host_gr_16.','.$host_gr_17.';
    alias '.$vibory_var[$count]['naimenovanie_uik_tik'].' '.$vibory_var[$count]['adres_uik_tik'].';
}
        
        define hostgroup{
hostgroup_name '.$host_gr_1.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_1.'
}

        define hostgroup{
hostgroup_name '.$host_gr_2.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_2.'
}

        define hostgroup{
hostgroup_name '.$host_gr_3.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_3.'
}

        define hostgroup{
hostgroup_name '.$host_gr_4.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_4.'
}

        define hostgroup{
hostgroup_name '.$host_gr_5.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_5.'
}

        define hostgroup{
hostgroup_name '.$host_gr_6.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_6.'
}

        define hostgroup{
hostgroup_name '.$host_gr_7.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_7.'
}

        define hostgroup{
hostgroup_name '.$host_gr_8.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_8.'
}

        define hostgroup{
hostgroup_name '.$host_gr_9.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_9.'
}

        define hostgroup{
hostgroup_name '.$host_gr_10.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_10.'
}

        define hostgroup{
hostgroup_name '.$host_gr_11.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_11.'
}

        define hostgroup{
hostgroup_name '.$host_gr_12.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_12.'
}

        define hostgroup{
hostgroup_name '.$host_gr_13.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_13.'
}

        define hostgroup{
hostgroup_name '.$host_gr_14.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_14.'
}

        define hostgroup{
hostgroup_name '.$host_gr_15.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_15.'
}

        define hostgroup{
hostgroup_name '.$host_gr_16.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_16.'
}

        define hostgroup{
hostgroup_name '.$host_gr_17.';
alias Объекты принятые в эксплуатации в зоне ответственности;
members '.$host_17.'
}
        ';

    $win_str_2 = iconv("UTF-8", "windows-1251", $str_2);
    //if ($vibory_var[$count]['description'] != null)
    //{
        //echo $_SERVER['DOCUMENT_ROOT'].'/scripts/config_script/config/'.str_replace(',', '_', str_replace('/', '-', $vibory_var[$count]['description'])).".cfg";
        $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/scripts/config_script/config/new/UTF-8.cfg', "w");
        fwrite($fp, $str_2);
        fclose($fp);

        $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/scripts/config_script/config/new/1251.cfg', "w");
        fwrite($fp, $win_str_2);
        fclose($fp);
    //}


    $text = 'Создание cfg-файлов завершено!';
}
//echo '<br><br><br><br>'.$host_1.'<br>'.$host_2.'<br>'.$host_3.'<br>'.$host_4.'<br>'.$host_5.'<br>'.$host_6.'<br>'.$host_7.'<br>'.$host_8.'<br>'.$host_9.'<br>'.$host_10;
//echo '<br>'.$host_11.'<br>'.$host_12.'<br>'.$host_13.'<br>'.$host_14.'<br>'.$host_15.'<br>'.$host_16.'<br>'.$host_17.'<br>'.$host_18.'<br>'.$host_19.'<br>'.$host_20;
?>