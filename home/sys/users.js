function users ()
{
    var count_1 = 1;
    while (count_1 < all_users_count)
    { document.write("<option>" + all_users[count_1] + "</option>"); count_1++; }
}

function groups ()
{
    var count_1 = 0;
    while (count_1 < all_group_count)
    { document.write("<option>" + all_group[count_1] + "</option>"); count_1++; }
}

function tables ()
{
    var count_1 = 0;
    while (count_1 < 6)
    { document.write("<option>" +  header_lable[count_1] + "</option>"); count_1++; }
}
