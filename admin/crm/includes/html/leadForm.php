<!--div class="back"><a class="back" href="<?=$RedirectURL?>">Back</a></div-->

<div class="had"><?php echo empty($_GET['view'])?"Create":'Update'; ?> Lead Form</div>
<?php  if (!empty($errMsg)) {?>
<div align="center"  class="red" ><?php echo $errMsg;?></div>
<?php } 


include("includes/html/box/create_lead_form.php");


(empty($leadSelectedColumn))?($leadSelectedColumn=""):(""); 
(empty($editData[0]['RoleGroupNew']))?($editData[0]['RoleGroupNew']=""):(""); 
?>
<script>
$(document).ready(function(){
	var leadStr = "<?php echo $leadSelectedColumn; ?>";
	var leadArry = leadStr.split(",");
	$("#columnFrom").val(leadArry);
	$("#add").trigger("click");
	
	var roleStr = "<?php echo $editData[0]['RoleGroupNew']; ?>";
	$("#columnFrom1").val(roleStr.split(","));
	$("#add1").trigger("click");
});
</script>








