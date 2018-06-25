<?php
    function del_null_vars()
    {
        unset ($row, $array, $key, $value);
        if ($_GET == null) { unset ($_GET); }
        if ($_POST == null) { unset ($_POST); }
        if ($_FILES == null) { unset ($_FILES); }
        if ($_REQUEST == null) { unset ($_REQUEST); }
        if ($_ENV == null) { unset ($_ENV); }
        if ($_COOKIE == null) { unset ($_COOKIE); }
        unset($_SERVER, $DB);
    }
?>