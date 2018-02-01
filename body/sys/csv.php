<?php
if (isset ($_POST['csv']))
{
    $fd = fopen($_SERVER['DOCUMENT_ROOT'].'/sys/'.$podcat_name[1].".csv", 'w') or die($_SERVER['DOCUMENT_ROOT'].'/sys/'.$podcat_name[1].".csv");
    fwrite($fd, $csv_var);
    fclose($fd);
    header ("Content-Type: application/octet-stream");
    header ("Accept-Ranges: bytes");
    header ("Content-Length: ".filesize($csv_var));
    header ("Content-Disposition: attachment; filename=".$csv_var);
}
?>