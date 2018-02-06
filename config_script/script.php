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


        <form method = 'post'>
            <input style = 'margin: auto; width: 100%; height: 40px; background: gold; border-radius: 5px; border: solid 1px black;' type = 'submit' name = 'create' value = 'Создать конфиги'>
        </form>

<?php
if (isset ($_POST['create']))
{
    $files = glob($_SERVER['DOCUMENT_ROOT'].'/config_script/config/*');
    foreach($files as $file)
    { if(is_file($file)) { unlink($file); } }

    $files = glob($_SERVER['DOCUMENT_ROOT'].'/config_script/config/1251/*');
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


    for ($count = 2; $count < $sys_count; $count++)
    {
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
                $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/config_script/config/'.str_replace(',', '_', str_replace('/', '-', $vibory_var[$count]['description'])).".cfg", "w");
                fwrite($fp, $str);
                fclose($fp);

                $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/config_script/config/1251/'.str_replace(',', '_', str_replace('/', '-', $vibory_var[$count]['description'])).".cfg", "w");
                fwrite($fp, $win_str);
                fclose($fp);
            }
    }
    echo "<div style = 'font-weight: bold; color: lightgreen;'>Создание cfg-файлов завершено!</div>";
}
?>