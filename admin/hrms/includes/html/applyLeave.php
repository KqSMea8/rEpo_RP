<a href="<?=$RedirectUrl?>" class="back">Back</a>
<div class="had">Apply For Leave
</div>


<? if(!empty($ErrorMSG)){ ?> 
	  <div align="center" id="ErrorMsg" class="redmsg">
	  <br><?=$ErrorMSG?>
	  </div>
<? }else{
	include("includes/html/box/leave_form.php");
   }

 ?>

