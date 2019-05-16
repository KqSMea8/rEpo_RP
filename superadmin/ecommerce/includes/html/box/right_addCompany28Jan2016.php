<?php if(!$_GET['edit']==""){ ?>
<div class="right-search">
	<!--<h4><span class="icon"></span>Agrinde Trading LLC</h4>-->
	<div class="right_box">
      <?php $userID = $_GET['edit'];
  // echo $userID."rajan";?>        
<div id="imgGal">
<div align="center" id="ImageDiv"><img title="" src="../resizeimage.php?w=120&amp;h=120&amp;img=images/nologo.gif"></div>
</div>	
<div id="main_menu" class="rightlink">
    <ul>   
          <li><a href="addCompany.php?edit=<?php echo $userID;?>&curP=1">Company Details</a></li>
		  <li><a href="addCompany.php?edit=<?php echo $userID;?>&tab=compuserlist">Company User List</a></li>
		  <li><a href="addCompany.php?edit=<?php echo $userID;?>&tab=packagelist">Package List </a></li>
		  <li><a href="addCompany.php?edit=<?php echo $userID;?>&tab=paymenthistory">Payment History </a></li>
   </ul>
</div>
    </div>          
</div>
<?php } ?>