<? if (!empty($_GET['edit'])) { ?>
<div class="right-search">
  <h4><span class="icon"></span>
    <?php 

$titleImg = stripslashes(ucfirst($arryCustomer[0]['CustomerName']));
 
	
	echo $titleImg;
	 ?>
  </h4>
  <div class="right_box">
    <div id="imgGal">
      <?php 

$PreviewArray['Folder'] = $Config['CustomerDir'];
$PreviewArray['FileName'] = $arryCustomer[0]['Image']; 
$PreviewArray['NoImage'] = $Prefix."images/nouser.gif";
$PreviewArray['FileTitle'] = stripslashes($arryCustomer[0]['CustomerName']);
$PreviewArray['Width'] = "120";
$PreviewArray['Height'] = "120";
$PreviewArray['Link'] = "1";
echo '<div  id="ImageDiv" align="center">'.PreviewImage($PreviewArray).'</div>'; 
if(IsFileExist($Config['CustomerDir'],$arryCustomer[0]['Image'])){
	$DeleteSpan = '<span id="DeleteSpan"><a href="Javascript:void(0);" onclick="Javascript:DeleteFileRefresh(\''.$Config['CustomerDir'].'\',\''.$arryCustomer[0]['Image'].'\', \'DeleteSpan\')">'.$delete.'</a></span>';
	 
	$OldImage = $arryCustomer[0]['Image'];
 }
echo '<div id="ImageEditDiv"><span id="EditSpan"><a class="fancybox" href="#image_uploader_div">'.$edit.'</a></span>'.$DeleteSpan.'</div>';
 





/*
$MainDir = $Config['FileUploadDir'].$Config['CustomerDir'];
if($arryCustomer[0]['Image'] !='' && file_exists($MainDir.$arryCustomer[0]['Image']) ){ 
	$ImageExist = 1;
	$OldImage = $MainDir.$arryCustomer[0]['Image'];*/
$MainDir='';
?>
    <!--  <div  id="ImageDiv" align="center"> <a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arryCustomer[0]['Image']?>"  title="<?=$titleImg?>"> <?php echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryCustomer[0]['Image'].'" border=0 >';?> </a> <br />
      </div>
      <?php	//}else{ ?>
      <div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=$titleImg?>" /></div>
      <?php //} ?>
      <div id="ImageEditDiv"><span id="EditSpan"><a class="fancybox" href="#image_uploader_div">
        <?=$edit?>
        </a></span>
        <?php //if($ImageExist == 1){?>
        <span id="DeleteSpan"><a href="Javascript:void(0);" onclick="Javascript:DeleteFileReload('<?=$MainDir.$arryCustomer[0]['Image']?>','DeleteSpan')">
        <?=$delete?>
        </a></span>
        <?php //} ?>
	-->
      </div>
    </div>

<ul class="rightlink">
	<?  
	include('../includes/html/box/right_edit.php');		

	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],8)==1){ 
		$arryRightMenuSales = $objConfigure->getRightMenuByDepId(8,$MainModuleID,1);
	
    		foreach($arryRightMenuSales as $arryRightM){ $LineRight++; ?>        	
			 <li <?=($_GET['tab']==$arryRightM['Link'])?("class='active'"):("");?> onmouseover="Javascrip:ShowHideEdit(<?=$LineRight?>,1)"  onmouseout="Javascrip:ShowHideEdit(<?=$LineRight?>,0)">

 <a class="fancybox fancysmall fancybox.iframe" style="display:none" href="../editRightMenu.php?ModuleID=<?=$arryRightM['ModuleID']?>&Line=<?=$LineRight?>" id="rename<?=$arryRightM['ModuleID']?>" id="rename<?=$arryRightM['ModuleID']?>"><?=$rename?></a>

<a href="<?=$EditUrl?><?=$arryRightM['Link'];?>" id="caption<?=$LineRight?>"><?=$arryRightM['Module'];?></a>
			 
			
			 
			 </li>    
   		<?php } ?>
	<? } ?>
	 
	<!--
	<li <?=($_GET['tab']=="general")?("class='active'"):("");?>><a href="<?=$EditUrl?>general">General Information</a></li>
	<li <?=($_GET['tab']=="contacts")?("class='active'"):("");?>><a href="<?=$EditUrl?>contacts">Contacts</a></li>
	<li <?=($_GET['tab']=="bank")?("class='active'"):("");?>><a href="<?=$EditUrl?>bank">Bank Details</a></li>
	 <li <?=($_GET['tab']=="card")?("class='active'"):("");?>><a href="<?=$EditUrl?>card">Credit Cards</a></li>
	<li <?=($_GET['tab']=="billing")?("class='active'"):("");?>><a href="<?=$EditUrl?>billing">Billing Address</a></li>
	<li <?=($_GET['tab']=="shipping")?("class='active'"):("");?>><a href="<?=$EditUrl?>shipping">Shipping Address</a></li>
	<li <?=($_GET['tab']=="slaesPerson")?("class='active'"):("");?>><a href="<?=$EditUrl?>slaesPerson">Sales Person</a></li>
	<li <?=($_GET['tab']=="markup")?("class='active'"):("");?>><a href="<?=$EditUrl?>markup">Markup/Discount</a></li>
	<li <?=($_GET['tab']=="LoginPermission")?("class='active'"):("");?>><a href="<?=$EditUrl?>LoginPermission">Login/Permission Detail</a></li>
 	<li <?=($_GET['tab']=="merge")?("class='active'"):("");?>><a href="<?=$EditUrl?>merge">Merge Customer</a></li>

<? if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],8)==1){ ?>
	<li <?=($_GET['tab']=="so")?("class='active'"):("");?>><a href="<?=$EditUrl?>so">Sales Orders</a></li>
	<li <?=($_GET['tab']=="invoice")?("class='active'"):("");?>><a href="<?=$EditUrl?>invoice">Invoices</a></li>
	<li <?=($_GET['tab']=="linkvendor")?("class='active'"):("");?>><a href="<?=$EditUrl?>linkvendor">Link Vendor</a></li>
<? } ?>
	-->


<?php if($Config['CurrentDepID'] ==5){ ?>
	<li>WebSite Management
		<ul>
		<li><a href="viewMenus.php?CustomerID=<?php echo $_GET["edit"]?>">Menu</a></li>
		<li>Form
		<ul>
		<li><a href="viewForms.php?CustomerID=<?php echo $_GET["edit"]?>">Form</a></li>
		<li><a href="viewFormFields.php?CustomerID=<?php echo $_GET["edit"]?>">Form Fields</a></li>
		<li><a href="viewFormData.php?CustomerID=<?php echo $_GET["edit"]?>">Customer Form Data</a></li>

		</ul>
		</li>
		<li><a href="viewContents.php?CustomerID=<?php echo $_GET["edit"]?>">Page</a></li>
		<li><a href="template.php?CustomerID=<?php echo $_GET["edit"]?>">Template</a></li>
		<li><a href="setting.php?CustomerID=<?php echo $_GET["edit"]?>">Global Setting</a></li>
		</ul>
	</li>
<? }?>





    </ul>
  </div>
</div>




<? 

}else{
	$SetInnerWidth=1;
}

include("../includes/html/box/upload_image.php");

?>
