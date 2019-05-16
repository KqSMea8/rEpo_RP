<div><a href="<?=$RedirectUrl?>" class="back">Back</a></div>
<div class="had"> Manage Leave  <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Assign ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>

<? 	include("includes/html/box/leave_form.php"); ?>

