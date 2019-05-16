<?php if(!$_GET['edit']==""){ 
	$userID = $_GET['edit'];
?>
<div class="right-search">
 
<div id="main_menu" class="rightlink">
    <ul>   
	<li><a href="addCompany.php?edit=<?php echo $userID;?>&curP=1">Company Details</a></li>
	<!--<li><a href="addCompany.php?edit=<?php echo $userID;?>&tab=compuserlist">Company User List</a></li>
	<li><a href="addCompany.php?edit=<?php echo $userID;?>&tab=packagelist">Package List </a></li>-->
	<li><a href="addCompany.php?edit=<?php echo $userID;?>&tab=paymenthistory">Payment History </a></li>
   </ul>
</div>
    </div>          
</div>
<?php } ?>
