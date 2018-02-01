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
    $files = glob($_SERVER['DOCUMENT_ROOT'].'/config_script/config/1251/*');
    foreach($files as $file)
    { if(is_file($file)) { unlink($file); } }

    $files = glob($_SERVER['DOCUMENT_ROOT'].'/config_script/config/1251/1251/*');
    foreach($files as $file)
    { if(is_file($file)) { unlink($file); } }

    $count = 0;
    $SQL_QUERY_select = $mysqli->query("SELECT * FROM `vibory`");
    while ($row = mysqli_fetch_array($SQL_QUERY_select))
    {
        if ($count >= 2)
        {
            $var = $row;

            $str = 'define hostgroup{
    hostgroup_name '.$var['description'].';
    alias '.$var['naimenovanie_uik_tik'].' '.$var['adres_uik_tik'].';
}



define host{
    use generic-vib2018_SW;
    host_name '.$var['description'].'_SW;
    alias Swith '.$var['naimenovanie_uik_tik'].' '.$var['adres_uik_tik'].';
    address '.$var['ip_adres_kommutatora_v_shkafu_uik_tik'].';
    hostgroups '.$var['description'].',ViborySwith,'.$var['hostgroups'].';
    contact_groups '.$var['contact_groups'].';
}
        
define host{
    use generic-vib2018_CAM;
    host_name '.$var['description'].'_CAM1;
    alias CAM1 Комисия '.$var['naimenovanie_uik_tik'].' '.$var['adres_uik_tik'].';
    address '.$var['ip_adres_cam1'].';
    parents '.$var['description'].'_SW;
    hostgroups '.$var['description'].',DS-2CD2432F'.','.$var['hostgroups'].';
    contact_groups '.$var['contact_groups'].';
}
define host{
    use generic-vib2018_CAM;
    host_name '.$var['description'].'_CAM2;
    alias CAM2 Урна '.$var['naimenovanie_uik_tik'].' '.$var['adres_uik_tik'].';
    address '.$var['ip_adres_cam2'].';
    parents '.$var['description'].'_SW;
    hostgroups '.$var['description'].',DS-2CD2432F'.','.$var['hostgroups'].';
    contact_groups '.$var['contact_groups'].';
}';


            $win_str = iconv("UTF-8", "windows-1251", $str);

            $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/config_script/config/'.str_replace(',', '_', str_replace('/', '-', $var['description'])).".cfg", "w");
            fwrite($fp, $str);
            fclose($fp);

            $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/config_script/config/1251/'.str_replace(',', '_', str_replace('/', '-', $var['description'])).".cfg", "w");
            fwrite($fp, $win_str);
            fclose($fp);
        }
        $count++;
    }
    echo "<div style = 'font-weight: bold; color: lightgreen;'>Создание cfg-файлов завершено!</div>";
}
?>