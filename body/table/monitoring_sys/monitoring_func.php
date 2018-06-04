<?php
    function status ($output)
    {
        if (strpos($output, 'OK')) { $result = 'success'; }
        else if (strpos($output, 'CRITICAL')) { $result = 'danger'; }
        else if (strpos($output, 'WARNING')) { $result = 'warning'; }
        else if ($output == 'Устройство недоступно!') { $result = 'danger'; }
        return $result;
    }



    function shell($check, $column)
    {
        //$node = '10.234.255.41';
        //$node = '10.153.29.134';
        $node = '127.0.0.1';
        $result = shell_exec("{$_SERVER['DOCUMENT_ROOT']}/sys/check_nrpe -H {$node} -t 90 -c {$check} -a {$column}");
        return $result;
    }
?>