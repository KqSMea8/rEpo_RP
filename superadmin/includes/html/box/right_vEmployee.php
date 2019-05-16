
<? if (!empty($_GET['view'])) { ?>
<div class="right-search">
<h4><span class="icon"></span><?=stripslashes($arryEmployee[0]['UserName'])?></h4>
<div class="right_box">

  <div id="imgGal">

    <? 
    $MainDir = "../admin/hrms/upload/employee/".$_GET['cmp']."/";
    if($arryEmployee[0]['Image'] !='' && file_exists($MainDir.$arryEmployee[0]['Image']) ){ 
	$ImageExist = 1;
   ?>
    <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arryEmployee[0]['Image']?>"  title="<?=$arryEmployee[0]['UserName']?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryEmployee[0]['Image'].'" border=0 >';?></a> <br />
    </div>
    <?	}else{ ?>
    <div  id="ImageDiv" align="center"><img src="../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=$arryEmployee[0]['UserName']?>" /></div>
    <? } ?>
    </div>
	
	
	<ul class="rightlink">	
    <li <?=($_GET['tab']=="personal")?("class='active'"):("");?>><a href="<?=$ViewUrl?>personal">Personal Details</a></li>
	<li <?=($_GET['tab']=="contact")?("class='active'"):("");?>><a href="<?=$ViewUrl?>contact">Contact Details</a></li>
	<!-- <li <?=($_GET['tab']=="education")?("class='active'"):("");?>><a href="<?=$ViewUrl?>education">Education</a></li>--> 
	<!--  <li <?=($_GET['tab']=="id")?("class='active'"):("");?>><a href="<?=$ViewUrl?>id">ID Proof</a></li> -->
	<li <?=($_GET['tab']=="account")?("class='active'"):("");?>><a href="<?=$ViewUrl?>account">Login Details</a></li>
		<!--  <li <?=($_GET['tab']=="emergency")?("class='active'"):("");?>><a href="<?=$ViewUrl?>emergency">Emergency Contacts</a></li>-->
	<li <?=($_GET['tab']=="job")?("class='active'"):("");?>><a href="<?=$ViewUrl?>job">Job Details</a></li>
 <?if($Config['SalesCommission']==1){ ?>
 	<!-- <li <?=($_GET['tab']=="sales")?("class='active'"):("");?>><a href="<?=$ViewUrl?>sales">Sales Commission</a></li> -->
	<!--  <li <?=($_GET['tab']=="territory")?("class='active'"):("");?>><a href="<?=$ViewUrl?>territory">Territory</a></li>-->
 <? }?>


	<!--<li <?=($_GET['tab']=="employment")?("class='active'"):("");?>><a href="<?=$ViewUrl?>employment">Employment History</a></li>
	<li <?=($_GET['tab']=="family")?("class='active'"):("");?>><a href="<?=$ViewUrl?>family">Family Details</a></li>
	<!--li <?=($_GET['tab']=="bank")?("class='active'"):("");?>><a href="<?=$ViewUrl?>bank">Bank Details</a></li-->
	<li <?=($_GET['tab']=="resume")?("class='active'"):("");?>><a href="<?=$ViewUrl?>resume">Resume</a></li>
	<!--<li <?=($_GET['tab']=="supervisor")?("class='active'"):("");?>><a href="<?=$ViewUrl?>supervisor">Supervisor</a></li> -->
	<!-- <li <?=($_GET['tab']=="role")?("class='active'"):("");?>><a href="<?=$ViewUrl?>role">Role/Permission</a></li> -->
	<!-- <li <?=($_GET['tab']=="exit")?("class='active'"):("");?>><a href="<?=$ViewUrl?>exit">Employee Exit</a></li> -->

	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
