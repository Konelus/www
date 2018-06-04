<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/use.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/class.php");
    require_once($_SERVER['DOCUMENT_ROOT'].'/sys/db_func.php');

    $substring = $_SERVER['QUERY_STRING'];
    $ch = curl_init($substring);
    pre($ch);
    $json = file_get_contents($ch);
    pre($json);
    echo '132';
    $n_json = json_decode($json,true);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>json</title>
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
                <div class = 'col-lg-12'>
                    <div class = 'col-lg-2'></div>
                    <div class = 'col-lg-8'>
                    <table class = 'table' style = 'border: solid 1px lightgrey;'>
                        <?php
                            foreach ($n_json as $key => $value)
                            {
                                //if ($value == null) { $style = ''; } else { $style = 'border-bottom: solid 1px grey;'; }
                                ?>
                                <tr>
                                    <td style = 'color: navy;'><?= $key ?></td>
                                    <td style = 'color: darkmagenta;'>

                                        <?php
                                        if (is_array($value))
                                        {
                                            foreach ($value as $n_key => $n_value)
                                            {
                                                foreach ($n_value as $t_key => $t_value)
                                                if (is_numeric($n_key)) { echo "{$t_key} → {$t_value}<br>"; }
                                                elseif (is_numeric($t_key)) { echo "{$n_key} → {$t_value}<br>"; }
                                            }
                                        }
                                        else { echo $value; }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        ?>
                    </table>
                    </div>
                        <div class = 'col-lg-2'></div>
                </div>
            </div>
        </div>
    </body>
</html>
