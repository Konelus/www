<div style = ''>
    <form method = 'post'>
        <input style = 'border: 0; background: white; color: navy; cursor: pointer;' type = 'submit' name = 'make_schedule' value = 'Расписание ЕГЭ'>
    </form>
</div>

<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/class/connection.php");
    $count1 = 0;
    $count2 = 0;
    $count_all1 = '';
    $count_all2 = '';
    $all_note = 0;
    $text = "Ожидает запуска!";
    if (isset ($_POST['make_schedule']))
    {

        $str = '';
        $DB->select("rid_pak","ege_temp_schedule");
        while ($array = mysqli_fetch_row($DB->sql_query_select))
        {
            $schedule[] = $array[0];
            $all_note++;
        }


        foreach ($schedule as $key => $value)
        {
            $DB->select("rid_pak", "ege", "`rid_pak` = '{$value}'");
            if ($DB->sql_query_select != '')
            {
                while ($array = mysqli_fetch_array($DB->sql_query_select))
                {
                    $test[] = $array[0];
                    if ($arr == '') { $arr = "`rid_pak` != '{$array[0]}'"; }
                    else { $arr .= " AND `rid_pak` != '{$array[0]}'"; }
                }
            }
        }
        $DB->select("rid_pak", "ege_temp_schedule", "{$arr}");
        while ($array = mysqli_fetch_array($DB->sql_query_select))
        {
            $err_count++;
            $error[$err_count] = $array[0];
        }



        foreach ($schedule as $key => $value)
        {
            $DB->select("*", "ege", "`usb_ipcam` = 'USB' AND `rid_pak` LIKE '%H01%' AND `rid_pak` = '{$value}'");
            if ($DB->sql_query_select != '')
            {
                $array = mysqli_fetch_array($DB->sql_query_select);
                if (($array['rid_pak'] != '') && ($array['adres_en'] != ''))
                {
                    $count1++;
                    if ($str != '') { $str .= ','.$array['rid_pak'].$array['adres_en']; }
                    else { $str = $array['rid_pak'].$array['adres_en']; }
                }
            }
        }


        foreach ($schedule as $key => $value)
        {
            $DB->select("*", "ege", "`usb_ipcam` != 'USB' AND `rid_pak` = '{$value}'");
            if ($DB->sql_query_select != '')
            {
                $array = mysqli_fetch_array($DB->sql_query_select);
                if (($array['rid_pak'] != '') && ($array['adres_en'] != ''))
                {
                    $count2++;
                    if ($str != '') { $str .= ','.$array['rid_pak'].$array['adres_en']; }
                    else { $str = $array['rid_pak'].$array['adres_en']; }
                }
            }
        }

        $all_note = $all_note - 1;
        $count_all = $count1 + $count2;
        echo "<pre>Всего строк: {$all_note}</pre>";
        echo "<pre>Всего обработано: {$count_all}</pre>";
        echo "<pre>USB: {$count1}</pre>";
        echo "<pre>Не USB: {$count2}</pre>";
        echo "<pre>↓ Ошибки ({$err_count}) ↓</pre>";
        pre($error);
        //echo "<pre>Ошибки: {$error}</pre>";


        $fstr = "define hostgroup{
        hostgroup_name 0_raspisanie;
        alias Предварительно ;
        members {$str};
        hostgroup_members 0_rcoi;
    }";


        $win_str = iconv("UTF-8", "windows-1251", $fstr);

        $fp = fopen(dirname(__FILE__).'/config/raspisanie.cfg', "w");
        fwrite($fp, $fstr);
        fclose($fp);

        $fp = fopen(dirname(__FILE__).'/config/raspisanie_1251.cfg', "w");
        fwrite($fp, $win_str);
        fclose($fp);
        $text = "<div style = 'width: 50px; float: right; color: green; margin-right: 20px;'>Успешно!</div>";
   }
?>