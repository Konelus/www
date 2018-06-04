<?php
    $substring = $_SERVER['QUERY_STRING'];


    $arr = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/instructions.ini');

    if ($arr['status'] == 'enable') { $arr['status'] = 'disable'; }
    elseif ($arr['status'] == 'disable') { $arr['status'] = 'enable'; }

    $file = $_SERVER['DOCUMENT_ROOT'].'/instructions.ini';
    $descriptor = fopen($file,"w+");

    if ($descriptor)
    {
        foreach ($arr as $key => $value)
        { fwrite($descriptor,"{$key} = '{$value}';\n"); }
        fclose($descriptor);
    }

    header("Location: /?{$substring}");

?>