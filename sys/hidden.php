<?php
function hidden_search($bool = 0)
{
    if ($bool != 0) { ?>
<script>
    $('input[name = "hidden_sort_5"]').val("<?= $_POST['selected_td'] ?>");
    $('input[name = "hidden_sort_6"]').val("<?= trim($_POST['caption']) ?>");
    $('input[name = "caption"]').val("<?= trim($_POST['caption']) ?>");
</script>
<?php
    }
    $_POST['hidden_sort_5'] = $_POST['selected_td'];
    $_POST['hidden_sort_6'] = trim($_POST['caption']);
    $_POST['caption'] = trim($_POST['caption']);
}

function hidden_other()
{

    $hs5 = $_POST['hidden_sort_5'];
    $hs6 = $_POST['hidden_sort_6'];
    ?>
<script>
    $('input[name = "hidden_sort_5"]').val("<?= $hs5 ?>");
    $('input[name = "hidden_sort_6"]').val("<?= trim($hs6) ?>");
    $('input[name = "caption"]').val("<?= trim($hs6) ?>");
</script>
<?php
}
?>