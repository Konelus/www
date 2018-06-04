<?php
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Expires: ".date("r"));

    $instructions = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/instructions.ini');
    $site_status = $instructions['status'];
    $link = $instructions['alias'];

    if ($_GET != null) { $substring = $_SERVER['QUERY_STRING']; }
?>