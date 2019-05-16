
<? if (!empty($errMsg)) { ?>
    <div align="center"  class="red" ><?php echo $errMsg; ?></div>
    <?
}

if ($HideForm != 1) {
    include("box/filter_form.php");
}
?>


<? echo '<script>SetInnerWidth();</script>'; ?>





