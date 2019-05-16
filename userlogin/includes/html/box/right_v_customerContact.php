<? if (!empty($Customer_ID)) { 
	?>
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
  
$MainDir = "../admin/upload/customer/".$_SESSION['CmpID']."/";

if($arryCustomer[0]['Image'] !='' && file_exists($MainDir.$arryCustomer[0]['Image']) ){ 	$ImageExist = 1;
?>
    <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arryCustomer[0]['Image']?>"  title="<?=$titleImg?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryCustomer[0]['Image'].'" border=0 >';?></a> <br />
    </div>
    <?	}else{ ?>
    <div  id="ImageDiv" align="center"><img src="../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=$titleImg?>" /></div>
    <? } ?>

	  
	  
    </div>
	
	
	<ul class="rightlink">	
        <li <?=($_GET['tab']=="general")?("class='active'"):("");?>><a href="<?=$ViewUrl?>general"><?php if(!empty($vgeneral)){echo $vgeneral;}else{echo "General Information";}?></a></li>

<?php 
	
	if(!empty($permission) AND !empty($userPermission)){
	
	foreach($permission as $k=>$menu){
		if(in_array($k, $userPermission)){
		if($k=='website'){ ?>
		<li <?=($_GET['tab']==$k)?("class='active'"):("");?>><?php echo $menu ?>
     	<ul>
     	<li><a href="viewMenus.php?CustomerID=<?php echo $arryCustomer[0]['CustID'];?>">Menu</a></li>
     	<li>Form
     	<ul>
     	<li><a href="viewForms.php?CustomerID=<?php echo $arryCustomer[0]['CustID'];?>">Form</a></li>
     	<li><a href="viewFormFields.php?CustomerID=<?php echo $arryCustomer[0]['CustID'];?>">Form Fields</a></li>
     	<li><a href="viewFormData.php?CustomerID=<?php echo $arryCustomer[0]['CustID'];?>">Customer Form Data</a></li>
     
     	</ul>
     	</li>
     	<li><a href="viewContents.php?CustomerID=<?php echo $arryCustomer[0]['CustID'];?>">Page</a></li>
     	<li><a href="template.php?CustomerID=<?php echo $arryCustomer[0]['CustID'];?>">Template</a></li>
     	<li><a href="setting.php?CustomerID=<?php echo $arryCustomer[0]['CustID'];?>">Global Setting</a></li>
     	</ul>
     </li>
		<?php }else{	
		?>
		<li <?=($_GET['tab']==$k)?("class='active'"):("");?>><a href="<?=$ViewUrl.$k?>"><?php echo $menu ?></a></li>
	<?php } }}}?>





	</ul>
  </div>
</div>

<? }else{
	$SetInnerWidth=1;
} ?>
