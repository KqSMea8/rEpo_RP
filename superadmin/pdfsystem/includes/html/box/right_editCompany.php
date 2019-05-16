
<div class="right-search">
	<h4><span class="icon"></span></h4>
	<div class="right_box">
      <?php $userID = $_REQUEST['edit']; ?>    
<div id="main_menu" class="rightlink">
    <ul>   
          <li><a href="editCompany.php?edit=<?php echo $userID;?>&curP=1">Company Details</a></li>
		  <li><a href="editCompany.php?edit=<?php echo $userID;?>&tab=compuserlist">Company User List</a></li>
		  <li><a href="editCompany.php?edit=<?php echo $userID;?>&tab=packagelist">Plan Details List </a></li>
		  <li><a href="editCompany.php?edit=<?php echo $userID;?>&tab=paymenthistory">Payment History </a></li>
		  <li><a href="editCompany.php?edit=<?php echo $userID;?>&tab=orderlist">Order List </a></li>

<?php  //print_r($setting->status);
if($setting->status =='COMPLETED' ) {  ?>
                  <li><a href="editCompany.php?edit=<?php echo $userID;?>&tab=setting">Setting </a></li>
<?php }?>
   </ul>
</div>
    </div>          
</div>
