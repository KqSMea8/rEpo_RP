<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/jquery.mCustomScrollbar.css" />
<script type="text/javascript" src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
<? 

require_once("../classes/sales.quote.order.class.php");
$objSale = new sale();
$CartItem=$objSale->getCartItem();

$LogoStyle = '';

if(IsFileExist($Config['CmpDir'],$arryCompany[0]['Image'])){//cmp logo
 	$LogoStyle = "style='margin-bottom:10px;'";
	$arrayFileInfo = GetFileInfo($Config['CmpDir'],$arryCompany[0]['Image']);
	if($arrayFileInfo[0]>350 || $arrayFileInfo[1]>150){	
		$PreviewArray['Width'] = "150";
		$PreviewArray['Height'] = "150"; 
		$LogoStyle = '';
	} 
	$PreviewArray['Folder'] = $Config['CmpDir'];
	$PreviewArray['FileName'] = $arryCompany[0]['Image']; 
	$PreviewArray['FileTitle'] = stripslashes($Config['SiteName']); 
	$SiteLogo = PreviewImage($PreviewArray); 
}else if(!empty($_SESSION['CmpLogin'])){
	$SiteLogo = '<div class="logotext">'.$Config['SiteName'].'</div>>' ; /*'<img src="'.$Config['DefaultLogoCrm'].'" border="0" alt="'.$Config['SiteName'].'" title="'.$Config['SiteName'].'" >';*/	 	
}else{
	/*$Config['CmpID'] = $Config['SuperCmpID'];
	if(IsFileExist($Config['SiteLogoDir'],$arrayConfig[0]['SiteLogo'])){  //site logo	
		$PreviewArray['Folder'] = $Config['SiteLogoDir'];
		$PreviewArray['FileName'] = $arrayConfig[0]['SiteLogo']; 
		$PreviewArray['FileTitle'] = stripslashes($Config['SiteName']);
		$PreviewArray['Width'] = "150";
		$PreviewArray['Height'] = "150"; 
		$SiteLogo = PreviewImage($PreviewArray); 			

		 
	}else{  //default logo	 
		$SiteLogo = '<img src="'.$Config['DefaultLogo'].'" border="0" alt="'.$Config['SiteName'].'" title="'.$Config['SiteName'].'" >';
	}
	$Config['CmpID'] = $_SESSION['CmpID']; */
	$SiteLogo = '<div class="logotext">'.$Config['SiteName'].'</div>' ;
}

 
?>
<div class="header-container header-container-cart">
    <div class="logo" id="logo" <?=$LogoStyle?>><a href="<?=$MainPrefix?>dashboard.php"><?=$SiteLogo?></a></div>
    <? #echo (!empty($CurrentDepartment)?('<div class="crm">'.$CurrentDepartment.'</div>'):('')); ?>
    <div class="top-right-nav">
      <ul class="clearfix log_link" style="margin-bottom:0px;">
	  
		 <li class="cart-box"><a href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="cart-item"><?php echo count($CartItem); ?></span></a>
            <ul>
                <li>Shoping cart</li>
                <ul>
                	<?php
                	
								if (!empty($CartItem)) {
									foreach ($CartItem as $value) {
										?>
										<li><a href="cart.php">
												<?php
												$MainDir = "../admin/inventory/upload/items/images/".$_SESSION['CmpID']."/";
												if ($value['Image'] != '' && file_exists($MainDir . $value['Image'])) {
													?>
													<span class="img-cart"><img src="resizeimage.php?w=100&h=150&img=<?php echo $MainDir . $value['Image']; ?>" border=0  ></span>
				
							<?php } ?>
							<span class="cart-content"><?php echo substr($value['Sku'], 0, 30); ?></span><span class="item-count"><?php echo $value['Quantity'] ?></span></a></li>
							<?php }
                                                } else{ ?>
                                                        <li style="text-align:center;color:#d33e3d;font-weight: bold;">Cart is Empty</li>
                                                    
                                                <?php } ?>
                    </ul>
                <li><a href="cart.php">View Cart</a></li>
            </ul>
        </li>	
		<li class="logout"><a href="<?=$MainPrefix?>logout.php" onclick="Javascript:ShowHideLoader('2','P');"><span>Log Out</span></a></li>
		<li class="chpassword"><a class="fancybox fancybox.iframe" href="<?=$MainPrefix?>chPassword.php"><span>Change Password</span></a></li>







	</ul>
	
	<ul class="clearfix" >	
		<li class="welcome">Welcome <span><?=$_SESSION['UserName']?>!</span></li>

<?

$ArryEmail = $objCustomerSupplier->GetCustomerEmail($_SESSION['UserName']);
$Emailcount = count($ArryEmail);
 
if($Emailcount>1){
	echo "<li><select name='selcmp' id='selcmp'>";
	for($i=0;$i<$Emailcount;$i++) {
		$sel = ($ArryEmail[$i]->comId==$_SESSION['CmpID'])?("selected"):("");
		echo "<option value='".$ArryEmail[$i]->comId."' ".$sel.">".$ArryEmail[$i]->CompanyName."</option>";
	}
	echo "</select></li>";
}

?>


	  	<? if($SelfPage!="dashboard.php"){ ?>
	 <li class="dash-back"><a href="<?=$MainPrefix?>dashboard.php">Back to <span>Main Dashboard</span></a></li>
	 <?php if(!empty($arryCurrentLocation[0]['City']) && !empty($arryCurrentLocation[0]['State'])) {?>
        <li class="location"><span>Location:</span> <? echo stripslashes($arryCurrentLocation[0]['City']).", ".stripslashes($arryCurrentLocation[0]['State']).", ".stripslashes($arryCurrentLocation[0]['Country']); ?></li>
       <? } ?>
        
		<? } 

		?>
              </ul>



    </div>
</div>

<script type="text/javascript">

jQuery('document').ready(function(){
	$('#selcmp').change(function(){
		var CmpID = Trim(document.getElementById("selcmp")).value;
		var url = 'dashboard.php?CmpID='+CmpID;	 
		window.location = url;
	});
});

 
</script>
