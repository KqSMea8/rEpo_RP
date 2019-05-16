<a class="back" href="<?=$RedirectURL?>">Back</a>

<div class="had"><?=$MainModuleName?> &raquo;

<span>
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Create ");
echo $MemberTitle." Custom Report";
?>
</span>

</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  
	if(!empty($_GET['edit'])){
		include("includes/html/box/edit_report_form.php");
	}else{

               include("includes/html/box/create_report_form.php");

        }
	?>
	







