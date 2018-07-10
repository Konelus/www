<?php
    require_once ($_SERVER['DOCUMENT_ROOT'].'/class/connection.php');
    $substring = $_SERVER['QUERY_STRING'];


    $arr = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/instructions.ini');

    if ($arr['status'] == 'enable') { $arr['status'] = 'disable'; }
    elseif ($arr['status'] == 'disable')
    {
        $DB->select("ver","!sys_ver");
        $ver = implode(mysqli_fetch_row($DB->sql_query_select));
        list($ver1, $ver2, $ver3) = explode(".","{$ver}");
        $arr['status'] = 'enable'; $DB->update("!sys_ver", "ver", "{$ver1}.{$ver2}.".($ver3 + 1));
    }

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