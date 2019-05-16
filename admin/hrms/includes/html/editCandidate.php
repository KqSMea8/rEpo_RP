<script language="JavaScript1.2" type="text/javascript">
function ShowOther(FieldId){
	if(document.getElementById(FieldId).value=='Other'){
		document.getElementById(FieldId+'Span').style.display = 'inline'; 
	}else{
		document.getElementById(FieldId+'Span').style.display = 'none'; 
	}
}
</script>


<div><a href="<?=$RedirectURL?>"  class="back">Back</a></div>


<div class="had">
<?=$MainModuleName?>    <span> &raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>

	<? if (!empty($errMsg)) {?>
    <div  class="red" ><?php echo $errMsg;?></div>
  <? } ?>


	<? include("includes/html/box/candidate_form.php"); ?>

