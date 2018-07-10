<?php

    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/use.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/class.php');
    require_once ($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');

    $count = 1;
    $const_count = 1;
    $DB->select("*","vibory_temp");
    $temp_array = $DB->sql_query_select;
    while ($row = mysqli_fetch_row($temp_array))
    {
        $temp[$count][2] = $row[2];
        if (($count % 2) == 0)
        {
            $vibory_temp[$const_count][1] = $row[1];


            if (($temp[$count][2] == $temp[$count - 1][2]) && ($temp[$count][2] != 'требуется проверка'))
            { $vibory_temp[$const_count][2] = $temp[$count][2]; }

            else if (
                (($temp[$count][2] == 'в процессе')     && ($temp[$count - 1][2] == 'в процессе'))  ||
                (($temp[$count][2] == 'в процессе')     && ($temp[$count - 1][2] == 'в очереди'))   ||
                (($temp[$count][2] == 'в очереди')      && ($temp[$count - 1][2] == 'в процессе'))  ||
                (($temp[$count][2] == 'в процессе')     && ($temp[$count - 1][2] == 'закончен'))    ||
                (($temp[$count][2] == 'в очереди')      && ($temp[$count - 1][2] == 'закончен'))    ||
                (($temp[$count][2] == 'закончен')       && ($temp[$count - 1][2] == 'в процессе'))  ||
                (($temp[$count][2] == 'закончен')     	&& ($temp[$count - 1][2] == 'в очереди'))	||
				($temp[$count][2] == 'требуется проверка') || ($temp[$count - 1][2] == 'требуется проверка')
            )
            { $vibory_temp[$const_count][2] = 'в процессе'; }

            else if (
                ($temp[$count][2] == 'в очереди')   && ($temp[$count - 1][2] == 'в очереди') ||
                ($temp[$count][2] == '')            && ($temp[$count - 1][2] == 'в очереди') ||
                ($temp[$count][2] == 'в очереди')   && ($temp[$count - 1][2] == '')
            )
            { $vibory_temp[$const_count][2] = 'в очереди'; }

            $DB->select("cinhronizaciya","vibory","`ip_adres_cam2` = '{$row[1]}'");
            $sync = mysqli_fetch_row($DB->sql_query_select);

            if (($vibory_temp[$const_count][2] != 'закончен') && ($sync[0] != 'Необходима синхронизация на стенде'))
            {
                $DB->update("vibory","cinhronizaciya","{$vibory_temp[$const_count][2]}","`ip_adres_cam2` = '{$vibory_temp[$const_count][1]}'");
               //echo '1. '.$vibory_temp[$const_count][1].' '.$sync[0].' --> '.$vibory_temp[$const_count][2].'<br>';
            }
            elseif ($vibory_temp[$const_count][2] == 'закончен')
            {
                $DB->update("vibory","cinhronizaciya","Cинхронизация завершена. Оборудование можно демонтировать","`ip_adres_cam2` = '{$vibory_temp[$const_count][1]}'");
                //echo '2. '.$vibory_temp[$const_count][1].' '.$sync[0].' --> '.$vibory_temp[$const_count][2].'<br>';
            }
            $const_count++;
        }
        $count++;
    }

    $DB->update("vibory_table","name","Синхронизация (".date("H:i").")","`sql_name` = 'cinhronizaciya'");
?>