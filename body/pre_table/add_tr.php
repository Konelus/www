<script>
    table_count = 0;
    var tr_count = 0;

    while (tr_count <= 2)
    {
        document.write('<tr class = "tr_' + tr_count + '">');
        while (table_count <= (max_td_count + 1))
        {
            if (tr_count === 0)
            {
                if (bool_var === 1)
                {
                    if (table_count <= (max_td_count - 1))
                    {
                        document.write("<td class = 'table_title_bg'><div class = 'text_box_div'>" +
                            "<input class = 'form-control table_title_input' autocomplete = 'off' name = 'textBox" + table_count + "' type = 'text'>" +
                            "</div></td>");
                    }
                    else if (table_count === max_td_count)
                    { document.write("<td colspan = '2' class = 'table_title_bg'><div class = 'add_submit_div'><input type = 'submit' value = 'Send' class = 'add_submit' name = 'add'></div></td>"); }
                }
            }
            table_count++;
        }
        document.write('</tr>');
        tr_count++;
    }
</script>