<div class = 'col-lg-12 col-md-12 col-sm-12'>
    <?php if (($_COOKIE['user'] == 'admin') || ($user_status == '+')) { ?>
            <form method = "post">

                    <?php
                    if ($_COOKIE['user'] == 'admin')
                    {
                        foreach ($all_tables_array as $key => $value)
                        { ?>
                            <a href = '<?php if ($value[3] != '') { echo "/?{$value[1]}"; } ?>' style = 'color: black;'>
                                <div class = 'col-lg-3 col-md-6 col-sm-6' style = 'margin-top: 20px;'>
                                    <div class = 'col-lg-1 col-md-1 col-sm-1'></div>
                                    <div style = 'height: 80px; border: dotted 1px black;' class = 'col-lg-10 col-md-10 col-sm-10'>
                                        <div class = 'col-lg-4 col-md-4 col-sm-4' style = 'padding-left: 0; padding-right: 0;'>
                                            <img style = 'width: 100%; margin-top: 10px;' src = '/img/icons/projects/<?= $value[1] ?>.png'>
                                        </div>
                                        <div class = 'col-lg-8 col-md-8 col-sm-8' style = 'text-align: center; font-size: 18px; padding-top: 12px;'><?= $value[2] ?></div>
                                    </div>
                                    <div class = 'col-lg-1 col-md-1 col-sm-1'></div>
                                </div>
                            </a><?php }
                        ?>
<!--                        <input type = 'text' style = 'color: black; margin-left: 10px; height: 30px; border: solid 1px gold; padding-left: 5px;' name = 'table_name' autocomplete="off">-->
<!--                        <input type = 'submit' style = 'color: white; height: 30px; width: 30px; background: black; border: solid 1px gold;' value = '+' name = 'add_table'>-->
                    <?php
                    }
                    else if ($_COOKIE['user'] != 'admin')
                    {
                        foreach ($released_table as $key => $value)
                        {
                            if ($current_users_access[$value[1]] == '+') { ?>
                                <a href = '<?= "/?{$value[1]}"; ?>' style = 'color: black;'>
                                    <div class = 'col-lg-3 col-md-6 col-sm-6' style = 'margin-top: 20px;'>
                                        <div class = 'col-lg-1 col-md-1 col-sm-1'></div>
                                        <div style = 'height: 80px; border: dotted 1px black;' class = 'col-lg-10 col-md-10 col-sm-10'>
                                            <div class = 'col-lg-4 col-md-4 col-sm-4' style = 'padding-left: 0; padding-right: 0;'>
                                                <img style = 'width: 100%; margin-top: 10px;' src = '/img/icons/projects/<?= $value[1] ?>.png'>
                                            </div>
                                            <div class = 'col-lg-8 col-md-8 col-sm-8' style = 'text-align: center; font-size: 18px; padding-top: 12px;'><?= $value[2] ?></div>
                                        </div>
                                        <div class = 'col-lg-1 col-md-1 col-sm-1'></div>
                                    </div>
                                </a>
                            <?php }
                        }
                    }
                    ?>

            </form>
    <?php } else { ?>
        <div style = 'color: red; padding-top: 10px; width: 100%; font-size: 30px; font-weight: bold; text-align: center; background: black;'>
            Внимание! Доступ по Вашей учётной записи запрещён!
        </div>
    <?php } ?>
</div>