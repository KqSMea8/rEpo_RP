<? if (!empty($_GET['view'])) { ?>
<div class="right-search">
    <h4><span class="icon"></span>
    <?php 
/*
if($arryCustomer[0]['CustomerType'] == "Individual"){
	$titleImg = stripslashes(ucfirst($arryCustomer[0]['FirstName']))." ".stripslashes(ucfirst($arryCustomer[0]['LastName']));
} else {
	$titleImg = stripslashes(ucfirst($arryCustomer[0]['Company']));
}
*/
 
	$titleImg = stripslashes(ucfirst($arryCustomer[0]['FullName']));
	echo $titleImg;
	 ?>
	
	
	</h4>
<div class="right_box">




  <div id="imgGal">

  <?php 
$MainDir = "../upload/customer/".$_SESSION['CmpID']."/";
if($arryCustomer[0]['Image'] !='' && file_exists($MainDir.$arryCustomer[0]['Image']) ){ 	$ImageExist = 1;
?>
    <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arryCustomer[0]['Image']?>"  title="<?=$titleImg?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryCustomer[0]['Image'].'" border=0 >';?></a> <br />
    </div>
    <?	}else{ ?>
    <div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=$titleImg?>" /></div>
    <? } ?>

	  
	  
    </div>
	
	
	<ul class="rightlink">	
    <li <?=($_GET['tab']=="general")?("class='active'"):("");?>><a href="<?=$ViewUrl?>general">General Information</a></li>  
	<li <?=($_GET['tab']=="contacts")?("class='active'"):("");?>><a href="<?=$ViewUrl?>contacts">Contacts</a></li>
	<li <?=($_GET['tab']=="bank")?("class='active'"):("");?>><a href="<?=$ViewUrl?>bank">Bank Details</a></li>
    <li <?=($_GET['tab']=="billing")?("class='active'"):("");?>><a href="<?=$ViewUrl?>billing">Billing Address</a></li>
	<li <?=($_GET['tab']=="shipping")?("class='active'"):("");?>><a href="<?=$ViewUrl?>shipping">Shipping Address</a></li>
	






<? if($Config['CurrentDepID']==5){?>

<li <?=($_GET['tab']=="comment")?("class='active'"):("");?>><a href="<?=$ViewUrl?>comment">Comments</a></li>

<? if(in_array('104',$arryMainMenu)){?>
<li <?=($_GET['tab']=="ticket")?("class='active'"):("");?>><a href="<?=$ViewUrl?>ticket">Tickets</a></li>
<? } if(in_array('136',$arryMainMenu)){?>
<li <?=($_GET['tab']=="event")?("class='active'"):("");?>><a href="<?=$ViewUrl?>event">Event / Task</a></li>
<? } if(in_array('105',$arryMainMenu)){?>
<li <?=($_GET['tab']=="document")?("class='active'"):("");?>><a href="<?=$ViewUrl?>document">Documents</a></li>
<? } if(in_array('108',$arryMainMenu)){?>
<li <?=($_GET['tab']=="quote")?("class='active'"):("");?>><a href="<?=$ViewUrl?>quote">Quotes</a></li>
<li <?=($_GET['tab']=="so")?("class='active'"):("");?>><a href="<?=$ViewUrl?>so">Sales Orders</a></li>
<li <?=($_GET['tab']=="invoice")?("class='active'"):("");?>><a href="<?=$ViewUrl?>invoice">Invoices</a></li>
<? }?>

<? } 




if(empty($arryCompany[0]["Department"]) || substr_count($arryCompany[0]['Department'],6)==1){
?>
<li <?=($_GET['tab']=="purchase")?("class='active'"):("");?>><a href="<?=$ViewUrl?>purchase">Purchase History</a></li>
<? } ?>





	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
