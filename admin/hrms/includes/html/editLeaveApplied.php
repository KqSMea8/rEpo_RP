<div><a href="<?=$RedirectUrl?>" class="back">Back</a></div>
<div class="had"> <?=$MainModuleName?>  <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Assign ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>

<? 	include("includes/html/box/leave_form.php"); ?>

