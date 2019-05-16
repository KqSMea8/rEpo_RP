<? 
if (!empty($Customer_ID)) { ?>
<div class="right-search">
    <h4><span class="icon"></span>
    <?php 
/*
if($arrySupplier[0]['CustomerType'] == "Individual"){
	$titleImg = stripslashes(ucfirst($arrySupplier[0]['FirstName']))." ".stripslashes(ucfirst($arrySupplier[0]['LastName']));
} else {
	$titleImg = stripslashes(ucfirst($arrySupplier[0]['Company']));
}
*/

	$titleImg = stripslashes(ucfirst($arrySupplier[0]['FirstName'].' '.$arrySupplier[0]['LastName']));
	echo $titleImg;
	 ?>
	
	
	</h4>
<div class="right_box">
  <div id="imgGal">
  <?php   
 // print_r($arrySupplier);
	$MainDir = _SiteUrl."/admin/finance/upload/supplier/".$_SESSION['CmpID']."/";
	$rootDir=_ROOT.'/admin/finance/upload/supplier/'.$_SESSION['CmpID'].'/';
//	echo $MainDir.$arrySupplier[0]['Image'];

if($arrySupplier[0]['Image'] !='' && file_exists($rootDir.$arrySupplier[0]['Image']) ){ 	$ImageExist = 1;
?>
    <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arrySupplier[0]['Image']?>"  title="<?=$titleImg?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arrySupplier[0]['Image'].'" border=0 >';?></a> <br />
    </div>
    <?	}else{ ?>
    <div  id="ImageDiv" align="center"><img src="../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=$titleImg?>" /></div>
    <? } ?> 
    </div>
	
	
	<ul class="rightlink">	
    <li <?=($_GET['tab']=="general")?("class='active'"):("");?>><a href="<?=$ViewUrl?>general">General Information</a></li>  
<?php
	if(!empty($permission) AND !empty($userPermission)){
	foreach($permission as $k=>$menu){
		if(in_array($k, $userPermission)){
		?>
		<li <?=($_GET['tab']==$k)?("class='active'"):("");?>><a href="<?=$ViewUrl.$k?>"><?php echo $menu ?></a></li>
	<?php }}}?>





	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
