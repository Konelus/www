<?php
    $sort = '';
    $sql_text = '';
    $c = 1;

    $status = $current_users_access["{$substring}_status"];

?>
    <script>
        var max_td_count = '';
        var title_tr_count = 1;
        max_td_count = <?= json_encode($table_count); ?>;
    </script>

    <script>document.write("<tr>");</script>
    <?php
        if (($_COOKIE['user'] == 'admin') || ($status == 'superuser'))
        {
            if ($_COOKIE['user'] == 'admin') { $bag_2 = 0; } else if ($status == 'superuser') { $bag_2 = 1; }
     ?>

        <script>
            table_count = 0 + <?= $bag_2 ?>;
            if (title_tr_count === 1)
            {
                while (table_count <= (max_td_count + 2 + <?= $bag_2 ?>))
                {
                    if (table_count <= max_td_count - 1 + <?= $bag_2 ?>)
                    {
                        if (table_count == 0) { document.write("" +
                            "<td style = 'width: 150px; background: gold;' class = 'table_head_bg'><div style = 'width: 150px; margin-top: 10px; font-size: 14px;'>Добавление пользователей</div></td>" +
                            "<td style = 'width: 150px; background: gold;' class = 'table_head_bg'><div style = 'width: 150px; margin-top: 10px; font-size: 14px;'>Привязанные пользователи</div></td>"); }
                        document.write("<td style = 'min-width: 100px;' class = 'table_head_bg'>" +
                            "<div style = 'width: 100%; border-bottom: solid 1px black; padding-bottom: 5px;'>" +
                            "<input class = 'table_head_submit_bg' type = 'submit' name = '" + table_mass[table_count].split(' ').join('_').replace(/[.]/g, "") + "_asc' value = '↑'>" +
                            "<input class = 'table_head_submit_bg' type = 'submit' name = '" + table_mass[table_count].split(' ').join('_').replace(/[.]/g, "") + "_desc' value = '↓'>" +
                            "</div>" + table_mass[table_count] + "</td>"
                        );
                    }
                    else if (table_count === max_td_count + <?= $bag_2 ?>) { document.write("<td class = 'table_head_sys'>edit</td>"); }
                    else if (table_count === (max_td_count + 1 + <?= $bag_2 ?>)) { document.write("<td class = 'table_head_sys'>del</td>"); }
                    else if (table_count === (max_td_count + 2 + <?= $bag_2 ?>)) { document.write("<td class = 'table_head_sys'>load</td>"); }
                    table_count++;
                }
            }
        </script>
    <?php } else if (($_COOKIE['user'] != 'admin') && ($status == 'user')) {  ?>
        <script>
            table_count = 1;
            while (table_count <= (max_td_count + 1))
            {
                if (table_count <= (max_td_count))
                {
                    document.write("<td style = 'min-width: 100px;' class = 'table_head_bg'>" +
                        "<div style = 'width: 100%; border-bottom: solid 1px black; padding-bottom: 5px;'>" +
                        "<input class = 'table_head_submit_bg' type = 'submit' name = '" + table_mass[table_count].split(' ').join('_').replace(/[.]/g, "") + "_asc' value = '↑'>" +
                        "<input class = 'table_head_submit_bg' type = 'submit' name = '" + table_mass[table_count].split(' ').join('_').replace(/[.]/g, "") + "_desc' value = '↓'>" +
                        "</div>" + table_mass[table_count] + "</td>"
                    );
                }
                else if (table_count === (max_td_count + 1)) { document.write("<td class = 'table_head_sys'>edit</td>"); }
                table_count++;
            }
        </script>
    <?php } else if (($_COOKIE['user'] != 'admin') && ($status == 'readonly')) { ?>
        <script>
            table_count = 1;
            while (table_count <= (max_td_count + 1))
            {
                if (table_count <= (max_td_count))
                {
                    document.write("<td style = 'min-width: 100px;' class = 'table_head_bg'>" +
                        "<div style = 'width: 100%; border-bottom: solid 1px black; padding-bottom: 5px;'>" +
                        "<input class = 'table_head_submit_bg' type = 'submit' name = '" + table_mass[table_count].split(' ').join('_').replace(/[.]/g, "") + "_asc' value = '↑'>" +
                        "<input class = 'table_head_submit_bg' type = 'submit' name = '" + table_mass[table_count].split(' ').join('_').replace(/[.]/g, "") + "_desc' value = '↓'>" +
                        "</div>" + table_mass[table_count] + "</td>"
                    );
                }
                table_count++;
            }
        </script>
    <?php } ?>
<script>document.write("</tr>");</script>