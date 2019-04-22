<?php
    require_once ($_SERVER['DOCUMENT_ROOT'].'/class/user.php');
    $USER->user_table();
    $user_status = $USER->user_status;
?>

<div id = 'modal' class = 'modal fade'>
    <div class = 'modal-content'>
        <div class = 'modal-dialog'>
            <div class = 'modal-header'>Выберите раздел проекта</div>
            <div class = 'modal-body'>
                <?php
                    $temp_array = explode(",", $temp_tale['several']);
                    pre($temp_array);
                ?>
            </div>
            <div class = 'modal-footer'>

            </div>
        </div>
    </div>
</div>


<div class = 'col-lg-12 col-md-12 col-sm-12'>
    <?php if (($_COOKIE['user'] == 'admin') || ($status == '+')) { ?>
            <form method = "post">
                    <?php
                    if ($_COOKIE['user'] == 'admin')
                    {
                        foreach ($tables as $key => $value)
                        { ?>
                                <div class = 'col-lg-3 col-md-6 col-sm-6' style = 'margin-top: 20px;'>
                                    <div class = 'col-lg-1 col-md-1 col-sm-1'></div>
                                    <?php if ($value['several'] == 0) { ?>
                                    <a href = '<?php if ($value['released'] == 1) { echo "/?project={$value['name']}"; } ?>' style = 'color: black;'>
                                    <?php } elseif ($value['several'] != 0) { $temp_tale['several'] = $value['several']; ?>
                                        <script>$("#modal").show("modal");</script>
                                    <?php } ?>
                                    <div style = 'height: 80px; border: dotted 1px black; padding-right: 0; padding-left: 0;' class = 'col-lg-10 col-md-10 col-sm-10'>
                                        <div class = 'col-lg-4 col-md-4 col-sm-4' style = 'border-right: dotted 1px black; padding: 0 0 0 0;'>
                                            <div style = 'margin-top: 2px; margin-bottom: 2px;  padding-left: 12px; padding-right: 12px;'>
                                                <img style = 'width: 50px;' src = '/img/icons/projects/<?= $value['name'] ?>.png'>
                                            </div>
                                            <div style = 'border-top: dotted 1px black;'>
                                                <?php if ($value['released'] == 1)  { ?>
                                                    <img style = 'width: 15px; margin-left: 15px;' src = '/img/icons/projects/status/green.png'>
                                                    <span><?= 'Вкл'; ?></span>
                                                <?php } elseif ($value['released'] == 0) { ?>
                                                    <img style = 'width: 15px; margin-left: 10px;' src = '/img/icons/projects/status/red.png'>
                                                    <span><?= 'Выкл'; ?></span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class = 'col-lg-8 col-md-8 col-sm-8' style = 'text-align: center; font-size: 18px; padding-top: 12px;'>
                                            <div style = 'height: 52px; padding-left: 2px; padding-right: 2px; margin-left: -15px; margin-right: -15px;'><?= $value['description'] ?></div>
                                        </div>
                                    </div>
                                    </a>
                                    <div class = 'col-lg-1 col-md-1 col-sm-1'></div>
                                </div>
                            <?php }
                        ?>
<!--                        <input type = 'text' style = 'color: black; margin-left: 10px; height: 30px; border: solid 1px gold; padding-left: 5px;' name = 'table_name' autocomplete="off">-->
<!--                        <input type = 'submit' style = 'color: white; height: 30px; width: 30px; background: black; border: solid 1px gold;' value = '+' name = 'add_table'>-->
                    <?php
                    }
                    elseif (($_COOKIE['user'] != 'admin') && ($tables != ''))
                    {
                        foreach ($tables as $key => $value)
                        { ?>
                            <div class = 'col-lg-3 col-md-6 col-sm-6' style = 'margin-top: 20px;'>
                                <div class = 'col-lg-1 col-md-1 col-sm-1'></div>

                                    <div style = 'height: 80px; border: dotted 1px black; padding-left: 0; padding-right: 0;' class = 'col-lg-10 col-md-10 col-sm-10'>
                                        <div class = 'col-lg-4 col-md-4 col-sm-4' style = 'padding-left: 0; padding-right: 0; height: 75px; margin-top: 2px;'>
                                            <div style = 'position relative; height: 100%;'>
                                                <?php  if ($user_status[$value['name'].'_status'] == 'superuser') { ?>
                                                <a href = '<?= "/?project={$value['name']}"; ?>' style = 'color: black;'>
                                                    <img class = 'hidden-md hidden-sm form' style = 'width: 70%; position: absolute; margin: auto; left: 0; top: 0; right: 0;' src = '/img/icons/projects/<?= $value['name'] ?>.png'>
                                                </a>
                                                    <div style = 'padding-top: 56px; border-right: dotted 1px black;'>
                                                        <input class = 'gold_btn' type = 'submit' value = 'SU'>
                                                    </div>
                                                <?php } else { ?>
                                                <a href = '<?= "/?project={$value['name']}"; ?>' style = 'color: black;'>
                                                    <img class = 'form' style = 'width: 100%; padding: 0 5px 0 5px; position: absolute; margin: auto; left: 0; top: 0; bottom: 0; right: 0;' src = '/img/icons/projects/<?= $value['name'] ?>.png'>
                                                </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <a href = '<?= "/?project={$value['name']}"; ?>' style = 'color: black;'>
                                            <div class = 'col-lg-8 col-md-8 col-sm-8 font' style = 'text-align: center; font-size: 18px; padding-top: 12px; padding-left: 0; padding-right: -30px;'><?= $value['description'] ?></div>
                                        </a>
                                    </div>

                                <div class = 'col-lg-1 col-md-1 col-sm-1'></div>
                            </div>
                            <?php
                        }
                    }
                    ?>

            </form>
    <?php }  ?>
</div>

<script>
    if ($('html').width() <= 1280)
    {
        $(".font").css({fontSize: '12px'});
        $(".font").css({padding: '30px 0 0 0'});
    }

</script>