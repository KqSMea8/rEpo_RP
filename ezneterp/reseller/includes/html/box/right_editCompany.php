<style text="">
.rightlink > li{
list-style: unset !important;
}
</style>
<? if (!empty($_GET['edit'])) { ?>
<div class="right-search">
	<h4><span class="icon"></span><?=stripslashes($arryCompany[0]['CompanyName'])?></h4>
	<div class="right_box">
  
<div id="imgGal">
		<? if($arryCompany[0]['Image'] !='' && file_exists($Prefix.'upload/company/'.$arryCompany[0]['Image']) ){ ?>
						
			<div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$Prefix?>upload/company/<?=$arryCompany[0]['Image']?>"  title="<?=stripslashes($arryCompany[0]['CompanyName'])?>"><? echo '<img src="'.$Prefix.'resizeimage.php?w=120&h=120&img=upload/company/'.$arryCompany[0]['Image'].'" border=0 >';?></a>
			<br />
			
			<!--</h1><a class="fancybox fancybox.iframe" href="includes/iframe/company_img.php">Change Photo</a>-->
			
			<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$Prefix?>upload/company/<?=$arryCompany[0]['Image']?>','ImageDiv')"><?=$delete?></a>
			
			
				</div>
		<?	}else{ ?>
		
		<div  id="ImageDiv" align="center"><img src="<?=$Prefix?>resizeimage.php?w=120&h=120&img=images/nologo.gif" title="<?=$arryCompany[0]['UserName']?>" /></div>
		<? } ?>
	</div>	
	

<ul class="rightlink">	
	<li <?=($_GET['tab']=="company")?("class='active'"):("");?>><a href="<?=$EditUrl?>company">Company Details</a></li>
	<li <?=($_GET['tab']=="account")?("class='active'"):("");?>><a href="<?=$EditUrl?>account">Account Details</a></li>
	
	<li <?=($_GET['tab']=="currency")?("class='active'"):("");?>><a href="<?=$EditUrl?>currency">Currency Details</a></li>
	<li <?=($_GET['tab']=="DateTime")?("class='active'"):("");?>><a href="<?=$EditUrl?>DateTime">DateTime Settings</a></li>
	<li <?=($_GET['tab']=="UserInfo")?("class='active'"):("");?>><a href="<?=$EditUrl?>UserInfo">User Details</a></li>
	<li <?=($_GET['tab']=="Call")?("class='active'"):("");?>><a href="<?=$EditUrl?>Call">Call Server</a></li>
	<li <?=($_GET['tab']=="UserLog")?("class='active'"):("");?>><a href="<?=$EditUrl?>UserLog">Session Log</a></li>
	<li <?=($_GET['tab']=="UserProfileLog")?("class='active'"):("");?>><a href="<?=$EditUrl?>UserProfileLog">User Profile Log</a></li>
	<li <?=($_GET['tab']=="ip")?("class='active'"):("");?>><a href="<?=$EditUrl?>ip">IP Restriction</a></li>

</ul>
	

	
				
    </div>          
</div>
<? }else{
	$SetInnerWidth=1;
} ?>


	

