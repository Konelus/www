<?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');


    if (isset ($_POST['make_schedule']))
    {
        $str = '';
        $DB->select("ip","ege_temp_schedule");
        while ($array = mysqli_fetch_row($DB->sql_query_select))
        { $schedule[] = $array[0]; }

        foreach ($schedule as $key => $value)
        {
            $DB->select("*", "ege", "`ip_adres_pak_ipcam` = '{$value}'");
            $array = mysqli_fetch_array($DB->sql_query_select);
            if ($str != '') { $str .= ','.$array['rid_pak'].$array['adres_en']; }
            else { $str = $array['rid_pak'].$array['adres_en']; }


        }
        $fstr = "define hostgroup{
        hostgroup_name 0_raspisanie1205;
        alias Тестовый экзамен;
        members {$str};
    }";


        $win_str = iconv("UTF-8", "windows-1251", $fstr);

        $fp = fopen(dirname(__FILE__).'/config/raspisanie.cfg', "w");
        fwrite($fp, $fstr);
        fclose($fp);

        $fp = fopen(dirname(__FILE__).'/config/raspisanie_1251.cfg', "w");
        fwrite($fp, $win_str);
        fclose($fp);
    }
?>

<div style = ''>
    <form method = 'post'>
        <input style = 'border: 0; background: white; color: navy; cursor: pointer;' type = 'submit' name = 'make_schedule' value = 'Расписание ЕГЭ'>
    </form>
</div>