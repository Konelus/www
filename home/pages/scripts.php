<?php
    $script_tables = scandir($_SERVER['DOCUMENT_ROOT'].'/scripts/bar');
    foreach ($script_tables as $key => $value)
    {
        if (($value == '.') || ($value == '..')) { unset($script_tables[$key]); }
        else
        {
            $script_tables[$key - 2] = $script_tables[$key];
            unset($script_tables[$key]);
            $scripts[$key - 2] = scandir($_SERVER['DOCUMENT_ROOT']."/scripts/bar/{$value}");
            for ($count = 0; $count <= ($key - 2); $count++)
            {
                foreach ($scripts[$count] as $s_key => $s_value)
                {
                    if (($s_value == '.') || ($s_value == '..')) { unset($scripts[$count][$s_key]); }
                    if ($s_value == 'info.ini')
                    {
                        $scripts_info = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/scripts/bar/{$value}/{$s_value}");
                        $table_name[] = $scripts_info['project'];
                    }
                }
            }
        }
    }

?>


<!DOCTYPE html>

<html>
    <head>
        <link rel="shortcut icon" href="/img/favicon.png" type="image/png">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
    </head>
    <body>
        <div class = 'container'>
            <div class = 'row'>
                <?php foreach ($scripts as $require_key => $require_value)
                { ?>
                <div class = 'col-lg-6'>
                    <div style = 'margin-top: 10px; width: 100%; padding-top: 2px; padding-bottom: 2px; background: #F8EFC0; text-align: center; border-top: solid 1px black; border-bottom: solid 1px black;'><?= $table_name[$require_key] ?></div>
                    <?php foreach ($scripts[$require_key] as $n_key => $n_value)
                    {
                        if ($n_value != 'info.ini')
                        {
                            echo "<div class = 'col-lg-6'>";
                            require_once($_SERVER['DOCUMENT_ROOT']."/scripts/bar/{$script_tables[$require_key]}/{$n_value}/script.php");
                            echo "</div><div class = 'col-lg-6'>&nbsp;{$text}</div>";
                            $text = '';
                        }
                    }
                 ?></div><?php
                } ?>
                </div>
            </div>
        </div>
    </body>
</html>

