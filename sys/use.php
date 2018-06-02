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


    $instructions = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/instructions.ini');
    $site_status = $instructions['status'];
    $link = $instructions['alias'];



    if ($_GET != null) { $substring = $_SERVER['QUERY_STRING']; }
?>