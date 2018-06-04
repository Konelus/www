<?php
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Expires: ".date("r"));


    function parse_txt($string)
    {
        $result = explode("=","{$string}");
        $result = $result[1];
        $result = str_replace(";","","{$result}");
        $result = str_replace("'","","{$result}");
        $result = str_replace(" ","","{$result}");
        $result = str_replace("\n","","{$result}");
        $result = str_replace("\r","","{$result}");
        return $result;

    }


    $descriptor = fopen($_SERVER['DOCUMENT_ROOT'].'/sys.txt', 'r');
    if ($descriptor)
    {
        while (($string = fgets($descriptor)) !== false)
        {
            if (strpos($string, 'status') !== false)
            { $site_status = parse_txt($string); }
            else if (strpos($string, 'alias') !== false)
            { $link = parse_txt($string); }
        }
        fclose($descriptor);
    }


    if ($_GET != null) { $substring = $_SERVER['QUERY_STRING']; }
?>