
<? if (!empty($_GET['edit'])) { ?>
<div class="right-search">
	<h4><span class="icon"></span>
	<?='&nbsp;'.$arryUser->userFname .' '.$arryUser->userLname?> 
	</h4>
	<div class="right_box">
      <?php $userID = $_GET['edit'];
    
  // echo $userID."rajan";?>        
<!--div id="imgGal">
<div align="center" id="ImageDiv"><!--img title="" src="../resizeimage.php?w=120&amp;h=120&amp;img=images/nologo.gif">
</div-->	
<div id="main_menu" class="rightlink">
    <ul>   
          <li><a href="addCompany.php?edit=<?=$userID?>&curP=1">Company Details</a></li>
		  <li><a href="addCompany.php?edit=<?=$userID?>&tab=compuserlist">Company User List</a></li>
		  <li><a href="addCompany.php?edit=<?=$userID?>&tab=packagelist">Package List </a></li>
		  <li><a href="addCompany.php?edit=<?=$userID?>&tab=paymenthistory">Payment History </a></li>
   </ul>
</div>
    </div>          
</div>

<? }else{
	$SetInnerWidth=1;
}  ?>
