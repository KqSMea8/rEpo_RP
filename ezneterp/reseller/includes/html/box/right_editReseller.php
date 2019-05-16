<? if (!empty($_GET['edit'])) { ?>
<div class="right-search">
	<h4><span class="icon"></span><?=stripslashes($arryReseller[0]['FullName'])?></h4>
	<div class="right_box">
               
<div id="imgGal">
		<? if($arryReseller[0]['Image'] !='' && file_exists($Prefix.'upload/reseller/'.$arryReseller[0]['Image']) ){ ?>
						
			<div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$Prefix?>upload/reseller/<?=$arryReseller[0]['Image']?>"  title="<?=stripslashes($arryReseller[0]['FullName'])?>"><? echo '<img src="'.$Prefix.'resizeimage.php?w=120&h=120&img=upload/reseller/'.$arryReseller[0]['Image'].'" border=0 >';?></a>
			<br />
			
			<!--</h1><a class="fancybox fancybox.iframe" href="includes/iframe/reseller_img.php">Change Photo</a>-->
			
			<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$Prefix?>upload/reseller/<?=$arryReseller[0]['Image']?>','ImageDiv')"><?=$delete?></a>
			
			
				</div>
		<?	}else{ ?>
		
		<div  id="ImageDiv" align="center"><img src="<?=$Prefix?>resizeimage.php?w=120&h=120&img=images/no.jpg" title="<?=$arryReseller[0]['UserName']?>" /></div>
		<? } ?>
	</div>	
	

	<ul class="rightlink">	

<li <?=($_GET['tab']=="personal")?("class='active'"):("");?>><a href="<?=$EditUrl?>personal">Personal Details</a></li>
<li <?=($_GET['tab']=="login")?("class='active'"):("");?>><a href="<?=$EditUrl?>login">Login Details</a></li>
<li <?=($_GET['tab']=="discount")?("class='active'"):("");?>><a href="<?=$EditUrl?>discount">Package Discount</a></li>		
<li <?=($_GET['tab']=="term")?("class='active'"):("");?>><a href="<?=$EditUrl?>term">Payment Term</a></li>	
<li <?=($_GET['tab']=="comm")?("class='active'"):("");?>><a href="<?=$EditUrl?>comm">Commission Structure</a></li>
<li <?=($_GET['tab']=="sales")?("class='active'"):("");?>><a href="<?=$EditUrl?>sales">Sales Report</a></li>
<li <?=($_GET['tab']=="report")?("class='active'"):("");?>><a href="<?=$EditUrl?>report">Commission Report</a></li>

	</ul>
	<?
	
	

?>

				
    </div>          
</div>
<? }else{
	$SetInnerWidth=1;
} ?>


	

