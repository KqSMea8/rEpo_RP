<?
	$HideNavigation = 1;
	 include_once("../includes/header.php");
	require_once("../../classes/product.class.php");
	require_once("../../classes/item.class.php");
	$objProduct=new product();
	$objItem = new items();
	
	$arryEbayCredentials=$objItem->GetEbayCredentials();
	$userToken = $arryEbayCredentials[0]['p_userToken'];
	$arryProduct = $objProduct->getAmazonData('','ebay','','','',(int)$_GET['edit']);
	
	if(($arryProduct[0]['Status']==1) && ($arryProduct[0]['FeedProcessingStatus']=='Active')){
		$productStatus = 'Active';
		$bgColor = 'background-color: #81bd82 !important;';
	}else if($ebayData[0]['Status']==1){
		$productStatus = 'Error';
		$bgColor = 'background-color: #d40503 !important;';
	}
	
	if(empty($arryProduct) || empty($_GET['edit'])) die('details not found');
	//pr($arryProduct,1);
	
?>	
	
	
	
	
	
	
<div class="message" align="center"><? if(!empty($_SESSION['CRE_Msg'])) {echo $_SESSION['CRE_Msg']; unset($_SESSION['CRE_Msg']); }else if(!empty($arryProduct[0]['FeedProcessingSMsg'])){echo $arryProduct[0]['FeedProcessingSMsg']; }?></div>
	
<form name="form1" action="" method="post" enctype="multipart/form-data">	
<table width="100%" border="0" cellpadding="5" cellspacing="0">

  	<tr>
		<td colspan="2" class="head" align="left">Update ebay Item Details  
		<?php if(!empty($arryProduct[0]['FulfilledBy'])){ ?>
		 <a href="<?=$arryProduct[0]['FulfilledBy']?>" target="_blank" style="float: right;font-weight: bold;">View Item Url</a>
		<?php } ?>
		</td>
	</tr>
   <tr>
        <td  align="right"   class="blackbold" width="15%">Item Title:<span class="red">*</span> </td>
        <td   align="left" >
			<input name="itemTitle" type="text" class="inputbox" id="itemTitle" value="<?php echo $arryProduct[0]['Name']; ?>"/>            
		</td>
   </tr>

	<tr>
        <td  align="right"  class="blackbold">Item Description: </td>
        <td   align="left" >
			<input name="itemDescription" type="text" class="inputbox" id="itemDescription" value="<?php echo (!empty($arryProduct[0]['ShortDetail']))?trim(strip_tags($arryProduct[0]['ShortDetail'])):''; ?>"/> 
		</td>
	</tr>	  
		<!-- 
      <tr>
        <td  align="right"   class="blackbold" >Condition:<span class="red">*</span> </td>
        <td   align="left" colspan="3">
		<select class="inputbox" id="itemCondition" name="itemCondition" title="Condition">
				<option value="1000" <?php if($arryProduct[0]['ItemCondition']==1000) echo 'selected';?> >New</option>
				<option value="3000" <?php if($arryProduct[0]['ItemCondition']==3000) echo 'selected';?>>Used</option>
				<option value="1500" <?php if($arryProduct[0]['ItemCondition']==1500) echo 'selected';?>>New other</option>
				<option value="1750" <?php if($arryProduct[0]['ItemCondition']==1750) echo 'selected';?>>New with defects</option>
				<option value="2000" <?php if($arryProduct[0]['ItemCondition']==2000) echo 'selected';?>>Manufacturer refurbished</option>
				<option value="2500" <?php if($arryProduct[0]['ItemCondition']==2500) echo 'selected';?>>Seller refurbished</option>
				<option value="4000" <?php if($arryProduct[0]['ItemCondition']==4000) echo 'selected';?>>Very Good</option>
				<option value="5000" <?php if($arryProduct[0]['ItemCondition']==5000) echo 'selected';?>>Good</option>
				<option value="6000" <?php if($arryProduct[0]['ItemCondition']==6000) echo 'selected';?>>Acceptable</option>
			</select>
	 	</td>
	</tr>
	-->
	 <tr>
        <td  align="right"   class="blackbold" width="15%">Product SKU: </td>
        <td   align="left" >
			<input name="SKU" type="text" class="inputbox" id="SKU" value="<?php echo $arryProduct[0]['ProductSku']; ?>"/>            
		</td>
    </tr>
	
 	<tr>
        <td  align="right"   class="blackbold" >Listing Type:<span class="red">*</span> </td>
        <td   align="left" colspan="3">
		 <select class="inputbox" name="listingType">
		 <option value="StoresFixedPrice" <?php if($arryProduct[0]['ProductType']=='StoresFixedPrice') echo 'selected';?>>Stores Fixed Price</option>
         <option value="FixedPriceItem" <?php if($arryProduct[0]['ProductType']=='FixedPriceItem') echo 'selected';?>>Fixed Price Item</option>
         <option value="Chinese" <?php if($arryProduct[0]['ProductType']=='Chinese') echo 'selected';?>>Chinese</option>
         <option value="Half" <?php if($arryProduct[0]['ProductType']=='Half') echo 'selected';?>>Half</option>
       </select>
      </td>
   </tr>

 	 <tr>
	      <td  align="right"   class="blackbold" width="20%">Listing Duration:<span class="red">*</span> </td>
	      <td   align="left" width="40%">
  				<select class="inputbox" name="listingDuration">
  					<option value="GTC" <?php if($arryProduct[0]['ProductTypeName']=='GTC') echo 'selected';?>>(GTC) Good Til Cancelled</option>
  					<option value="Days_3" <?php if($arryProduct[0]['ProductTypeName']=='Days_3') echo 'selected';?>>3 days</option>
  					<option value="Days_5" <?php if($arryProduct[0]['ProductTypeName']=='Days_5') echo 'selected';?>>5 days</option>
  				 	<option value="Days_7" <?php if($arryProduct[0]['ProductTypeName']=='Days_7') echo 'selected';?>>7 days</option>
		            <option value="Days_30" <?php if($arryProduct[0]['ProductTypeName']=='Days_30') echo 'selected';?>>30 days</option>
		             <option value="Days_180" <?php if($arryProduct[0]['ProductTypeName']=='Days_180') echo 'selected';?>>180 days</option>
		             <option value="Days_360" <?php if($arryProduct[0]['ProductTypeName']=='Days_360') echo 'selected';?>>360 days</option>
	          </select>             
		  </td>
      </tr>
	  
	  <tr>
        <td  align="right"   class="blackbold" width="15%">Quantity:<span class="red">*</span> </td>
        <td   align="left" >
			<input class="inputbox" required type="text" name="Quantity" value="<?php echo $arryProduct[0]['Quantity']; ?>">            
		</td>
     </tr>
	  
	  <tr>
        <td  align="right"   class="blackbold" width="15%">Price:<span class="red">*</span> </td>
        <td   align="left" >
			<input class="inputbox" required type="text" name="startPrice" value="<?php echo number_format((float)$arryProduct[0]['Price'], 1, '.', ''); ?>">            
		</td>
     </tr>
	 
   <tr>
	    <td  align="right"  class="blackbold"></td>
	    <td   align="left" >
		<input  class="button" type="submit" name="submit"  value="Update On Ebay" onclick="$('#load_div').css('display','block');" tittle="Update On Ebay">
		</td>
   </tr>
    
</table>	
</form>




<?php

require_once("../../ebay/keys.php");
require_once('../../ebay/eBaySession.php');

    if(isset($_POST['submit']))
	{ 
		
		/*if($productStatus == 'Active'){
			$_SESSION['CRE_Msg'] = 'Can not change any thing from here.';
			return ;
		}
		
		if(!is_numeric($ShippingServiceCost) || empty($ReturnsDesc)){ die('dgfddf');
			$_SESSION['CRE_Msg'] = "Shipping or return policy details are empty in ebay settings. Please fill up first!!";
			return;
		}
		*/
		

       	$siteID = 0;
       
        $siteNames = $objProduct->ebaySiteName();
        $country = $siteNames[$siteID];
        
        //$cat2 = (!empty($_POST['primaryCategory2']))? '#'.$_POST['primaryCategory2']:''; 
        //$_POST['CatHierarchy'] = $_POST['Category1'].'#'.$_POST['primaryCategory'].$cat2;
        if(!empty($_POST['primaryCategory2'])) $_POST['primaryCategory'] = $_POST['primaryCategory2'];
        
        $itemId          = $arryProduct[0]['ProductCode'];        
        $primaryCategory = $_POST['primaryCategory'];
        $itemTitle       = $_POST['itemTitle'];
        $itemDescription = $_POST['itemDescription'];
        $itemCondition   = $_POST['itemCondition']; 
        $listingType     = $_POST['listingType'];
        $listingDuration = $_POST['listingDuration'];
		$Quantity      	 = $_POST['Quantity'];
        $startPrice      = $_POST['startPrice'];
        $SKU 			 = $_POST['SKU'];
        $_POST['AliasID'] = (int)$_GET['AliasID'];
		$verb = 'ReviseItem';
	
		if(!empty($_POST['Image']) || !empty($MaxProductImageArr)){ 
			$PictureURL = '<PictureDetails>';
			
			$basicUrl = 'https://'.$_SERVER['SERVER_NAME'].'/erp/upload/products/images/'.$_SESSION['CmpID'].'/';
			$altrUrl = 'https://'.$_SERVER['SERVER_NAME'].'/erp/upload/products/images/secondary/'.$_SESSION['CmpID'].'/';
			
			if(!empty($_POST['Image']))
			$PictureURL .=  '<PictureURL>'.$basicUrl.$_POST['Image'].'</PictureURL>';
			
			if(!empty($MaxProductImageArr)){
				foreach($MaxProductImageArr as $image){
					$PictureURL .='<PictureURL>'.$altrUrl.$image['Image'].'</PictureURL>';
				}
			}
			
			$PictureURL .= '</PictureDetails>';
		}

		$ManufrName = $BrandName = '';
		if(!empty($arryProduct[0]['Mid']) && !empty($arryManufacturer)){
			foreach($arryManufacturer as $mname){ 
				if($arryProduct[0]['Mid']==$mname['Mid']) { $ManufrName = $mname['Mname']; break;}
			}
		}
		
		if(!empty($ManufrName)){
			$BrandName = '<ProductListingDetails><BrandMPN><Brand>'.$ManufrName.'</Brand><MPN>'.$SKU.'<MPN></BrandMPN></ProductListingDetails>';
		}
		
		if(!empty($itemDescription)){
			$itemDescription = '<Description>'.$itemDescription.'</Description>';
		}
//<ConditionID>'.$itemCondition.'</ConditionID>

$requestXmlBody  = '<?xml version="1.0" encoding="utf-8"?>
<ReviseItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  <RequesterCredentials>
    <eBayAuthToken>'.$userToken.'</eBayAuthToken>
  </RequesterCredentials>
	<ErrorLanguage>en_US</ErrorLanguage>
	<WarningLevel>High</WarningLevel>
	<DeletedField>Item.ApplicationData</DeletedField>
  <Item>
    <ItemID>'.$itemId.'</ItemID>
    <Title>'.$itemTitle.'</Title>
    '.$itemDescription.'
    <StartPrice>'.$startPrice.'</StartPrice>
    <DispatchTimeMax>3</DispatchTimeMax>
    <ListingDuration>'.$listingDuration.'</ListingDuration>
    <ListingType>'.$listingType.'</ListingType>
    '.$PictureURL.'
    <Quantity>'.(int)$Quantity.'</Quantity>
    <SKU>'.$SKU.'</SKU>
    <Site>US</Site>
 </Item>
</ReviseItemRequest>';
		
		#echo utf8_encode($requestXmlBody);exit;
	
        $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
		
		$responseXml = $session->sendHttpRequest(utf8_encode($requestXmlBody));
		if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
			die('<P>Error sending request');
		
		$responseDoc = new DomDocument();
		$responseDoc->loadXML($responseXml);
			
		$errors = $responseDoc->getElementsByTagName('Errors');
		
		if($errors->length >0)
		{
			$FeedProcessingStatus = 'Error';
			$Status = 1;

			$x = '<P><B>eBay returned the following error(s):</B><br/>';
			$code     = $errors->item(0)->getElementsByTagName('ErrorCode');
			$shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
			$longMsg  = $errors->item(0)->getElementsByTagName('LongMessage');
			
			$x .=  $_POST['FeedProcessingSMsg'] = $shortMsg->item(0)->nodeValue.'<br/>';
			
			if(count($longMsg) > 0)
				$x .= $_POST['FeedProcessingSMsg'] = $longMsg->item(0)->nodeValue;
				
		$_SESSION['CRE_Msg'] =$x;
		
		}
		else 
		{
			$set = " Name='".$itemTitle."', ShortDetail='".$_POST['itemDescription']."', Price='".$startPrice."', ProductTypeName='".$listingDuration."', ProductType='".$listingType."', Quantity='".$Quantity."', ProductSku='".$SKU."' " ;
			$objProduct->query("update amazon_items set $set where ProductCode='".$itemId."' and channel='ebay' ",0);
			$_SESSION['CRE_Msg'] ="Details are updated successfully."; 
			
		} 
		
		header("Location: ebay_update.php?edit=".$_GET['edit']);
		exit;		
	}
	
?>



<?php 
	require_once("../includes/footer.php");  
?>
