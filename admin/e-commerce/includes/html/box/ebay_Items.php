<?php 

$arryEbayCredentials=$objItem->GetEbayCredentials();

if($arryEbayCredentials[0]['credential_Type']=='Sandbox'){
	
	$returnPolicy = json_decode($arryEbayCredentials[0]['s_return_policy']);
	$ReturnsWithin = $returnPolicy->s_ReturnsWithin;
	$ReturnsDesc = $returnPolicy->s_ReturnsDesc;
	
	$shippingDetail = json_decode($arryEbayCredentials[0]['s_shipping_details']);
	$ShippingType = $shippingDetail->s_ShippingType;
	$ShippingService = $shippingDetail->s_ShippingService;
	$ShippingServiceCost = $shippingDetail->s_ShippingServiceCost;
	
}else{
	$returnPolicy = json_decode($arryEbayCredentials[0]['p_return_policy']);
	$ReturnsWithin = $returnPolicy->p_ReturnsWithin;
	$ReturnsDesc = $returnPolicy->p_ReturnsDesc;
	
	$shippingDetail = json_decode($arryEbayCredentials[0]['p_shipping_details']);
	$ShippingType = $shippingDetail->p_ShippingType;
	$ShippingService = $shippingDetail->p_ShippingService;
	$ShippingServiceCost = $shippingDetail->p_ShippingServiceCost;
}

if(!is_numeric($ShippingServiceCost) || empty($ReturnsDesc)){
	$_SESSION['CRE_Msg'] = "Shipping or return policy details are empty in ebay settings. Please fill up first!!";
}

require_once("../../ebay/keys.php");
require_once('../../ebay/eBaySession.php');
 //$objProduct->getEbayCategoties($Prefix,0);
$AL = $objProduct->GetAliasbySku($arryProduct[0]['ProductSku']);

if(!empty($_GET['AliasID'])){
	$ebayData = $objProduct->getAliasAmazonData('ebay',(int)$_GET['AliasID']);
	$mid = (!empty($ebayData[0]['Manufacture']))?($ebayData[0]['Manufacture']):('');
}

if(empty($ebayData)){
	$ebayData = $objProduct->getAmazonData((int)$_GET['edit'],'ebay','','','','');
	$arryAlias = $objProduct->GetAliasItem((int)$_GET['AliasID']);
}

if($ebayData){
	$mainImg = $arryProduct[0]['Image'];
	$arryProduct = $ebayData;
	$arryProduct[0]['ProductID'] = $ebayData[0]['itemID'];
	$arryProduct[0]['itemDescription'] = $ebayData[0]['ShortDetail'];
	$arryProduct[0]['Quantity'] = $ebayData[0]['Quantity'];
	$arryProduct[0]['Image'] = $mainImg;
}

if(!isset($arryProduct[0]['FeedProcessingStatus'])) $arryProduct[0]['FeedProcessingStatus']='';

if(($arryProduct[0]['Status']==1) && ($arryProduct[0]['FeedProcessingStatus']=='Active')){
	$productStatus = 'Active';
	$bgColor = 'background-color: #81bd82 !important;';
}else if(!empty($ebayData[0]['Status'])){
	$productStatus = 'Error';
	$bgColor = 'background-color: #d40503 !important;';
}

if(!empty($_GET['AliasID']) && !empty($arryAlias)){
	$AmazonData[0]['ProductID'] = 0;
	$arryProduct[0]['ProductID'] = 0;
	$arryProduct[0]['ProductSku'] = $arryAlias[0]['ItemAliasCode'];
	$mid = $arryAlias[0]['Manufacture'];
	$arryProduct[0]['ShortDetail'] = $arryAlias[0]['description'];
}

 ?>

</form>
<script type="text/javascript">

function validateEbayProduct(frm){
	
	if($("#Category1 option:selected").text()!=''){
		var CH= $("#Category1 option:selected").text()+'#'+$("#primaryCategory option:selected").text()+'#'+$("#primaryCategory2 option:selected").text();
		$("#CatHierarchy").val(CH);
	  }
	  
	if( ValidateForSimpleBlank(frm.SiteName, "Site Name")
		&& ValidateForSimpleBlank(frm.itemTitle, "Item Title")
		&& ValidateForSimpleBlank(frm.itemDescription, "Item Description")
		&& ValidateForSimpleBlank(frm.Quantity, "Quantity")
		&& ValidateForSimpleBlank(frm.startPrice, "Start Price")
		&& ValidateForSimpleBlank(frm.CatHierarchy, "Category")
	  ){
		  
	}else{
		return false;	
	}
}

$('document').ready(function(){

	<?php if($productStatus == 'Active') {
		echo '$("#form4 :input").prop("disabled", true);
		' ; }?>
	
	$('#SiteName').change(function(){
		searchCategories();
	});
	
	$(document.body).on('change','#Category1',function(){
		var cat = $(this).val();
		var level = $("#level").val();
		searchSubCategories(cat,level);
	});

	$(document.body).on('change','#primaryCategory',function(){
		var cat = $(this).val();
		var level = $("#level").val();
		searchSubCategories(cat,level);
	});

	    $('#AliasList').on('change', function () {
	        var url = $(this).val(); // get selected value
	        if (url) { // require a URL
	            window.location = url; // redirect
	        }
	        return false;
	    });
	/*$(document.body).on('change','#primaryCategory',function(){
		if(level==3){
			var cat = $(this).val();
			var level = $("#level").val();
			searchSubCategories(cat,level);
		}
	});*/
});
function check()
{
	var inp = document.getElementById('imageInput');
	var numFiles = inp.files.length;
    if(numFiles > 12)
	{
    	alert('Please do not choose images more than 12');
    	document.getElementById('imageInput').value = '';
    }
}

function searchCategories(){ 
	SiteID = $("#SiteName").val();
	if(SiteID==''){ alert("Please Select Site name First!!"); return false; }
	ShowHideLoader('1','P');
	 
	 $.ajax({
        url : "ajax.php",
        type: "GET",
        data : { action: 'getCategories', SiteID: SiteID },
        success: function(data)
        {	 
        	var response=jQuery.parseJSON(data);
        	if(typeof response =='object'){ 
             data = '<select class="inputbox" name="Category1" id="Category1">';
             data += '<option value="">-- Select --</option>';
             jQuery.each( response.Category, function( i) { 
             data += '<option value="'+response.Category[i].CategoryID+'">'+response.Category[i].CategoryName+'</option>';
             });
	         data += '</select>';
			 $("#catData").html(data);
			 $("#pc1").show('8000');
        	}else if(typeof response === 'string'){ 
        		ShowHideLoader('2','P');
            	alert(response);
            	return false;
        	}else{
        		ShowHideLoader('2','P');
        		alert('server error');
            	return false;
        	}
			 ShowHideLoader('2','P');
        },
        error: function( data ){
        	 ShowHideLoader('2','P');
            alert('failed! Server Error, Try again.');
        }
	 });
	
}


function searchSubCategories(PCat,Level){
	if(Level==''){ alert("Please Select Main Category First!!"); return false; }
	ShowHideLoader('1','P');
	 
	 $.ajax({
        url : "ajax.php",
        type: "GET",
        data : { action: 'getCategories', SiteID: SiteID, ParentID: PCat, Level: Level },
        success: function(data)
        {	 
        	var response=jQuery.parseJSON(data);
        	var name = 'primaryCategory';
        	 if(Level==3) name = 'primaryCategory2';
        	if(typeof response =='object'){ 
             data = '<select class="inputbox" name="'+name+'" id="'+name+'">';
             data += '<option value="">-- Select --</option>';
             jQuery.each( response.Category, function( i) { 
             data += '<option value="'+response.Category[i].CategoryID+'">'+response.Category[i].CategoryName+'</option>';
             });
	         data += '</select>';
	         
	         if(Level==3){
	        	 $("#catData2").html(data);
				 $("#pc3").show('8000');
	         }else{
			 	$("#catData1").html(data);
				$("#pc2").show('8000');
	         }
	         
	         if(Level==2) $("#level").val(3);
	         
        	}else if(typeof response === 'string'){ 
        		ShowHideLoader('2','P');
            	alert(response);
            	return false;
        	}else{
        		ShowHideLoader('2','P');
        		alert('server error');
            	return false;
        	}
			 ShowHideLoader('2','P');
        },
        error: function( data ){
        	 ShowHideLoader('2','P');
            alert('failed! Server Error, Try again.');
        }
	 });
	
}

function searchProduct(productId){ 
	SiteID = $("#SiteName").val();
	if(SiteID==''){ alert("Please Select Site name First!!"); return false; }
	ShowHideLoader('1','P');
	
	//queryStr = $("#queryStr").val();
	cat = $("#primaryCategory").val();
	 if(productId!='') { 
		 queryStr = productId; 
		 $("#ProductCode").val(queryStr);
	 }else{
		queryStr = $("#queryStr").val();
		productId = '';
	}
	 var cat = $("#queryCat").val();
	 $.ajax({
        url : "ajax.php",
        type: "GET",
        data : { action: 'searchEbayProduct', SiteID: SiteID, Query: queryStr, Category: cat, productId:productId },
        success: function(data)
        {	 
			 $("#ResultData").html(data);
			 ShowHideLoader('2','P');
			 if(productId!='') { 
				 $("#ProductsearchBox").hide(); 
				 $("#linkBox").show(); 
			 }else{
				 $("#ProductsearchBox").show(); 
				 $("#linkBox").hide(); 
			 }
        },
        error: function( data ){
        	 ShowHideLoader('2','P');
            alert('fail');
        }
	 });
	
}

function resetSearch(){
	$("#ProductsearchBox").show(); 
	 $("#linkBox").hide(); 
}
</script>

<div class="message" align="center"><? if(!empty($_SESSION['CRE_Msg'])) {echo $_SESSION['CRE_Msg']; unset($_SESSION['CRE_Msg']); }else if(!empty($arryProduct[0]['FeedProcessingSMsg'])){echo $arryProduct[0]['FeedProcessingSMsg']; }?></div>
	
	<!-- <input type="hidden" name="itemID" value="<?php echo $arryProduct[0]['ProductID']; ?>"/>
	<input type="hidden" name="pid" value="<?php if(isset($arryProduct[0]['pid'])) echo $arryProduct[0]['pid']; ?>"/>
	<input type="hidden" name="ProductType" id="ProductType" value=""/>
	
	-->
	<input type="hidden" name="itemID" value="<?php echo $arryProduct[0]['ProductID']; ?>"/>
	<input type="hidden" name="ProductCode" id="ProductCode" value="<?php if(isset($arryProduct[0]['ProductCode'])) echo $arryProduct[0]['ProductCode']; ?>"/>
	<input type="hidden" name="level" id="level" value="2"/>
	<input type="hidden" name="Image" id="Image" value="<?php echo $arryProduct[0]['Image']; ?>"/>

<? if(!isset($arryProduct[0]['CatHierarchy'])) $arryProduct[0]['CatHierarchy']='';
if(!isset($arryProduct[0]['Cat'])) $arryProduct[0]['Cat']='';
?>

	<input type="hidden" name="CatHierarchy" id="CatHierarchy" value="<?= (strlen($arryProduct[0]['CatHierarchy'])>5) ? $arryProduct[0]['CatHierarchy'] : $arryProduct[0]['Cat']; ?>"/>
<table width="100%" border="0" cellpadding="5" cellspacing="0">
	<tr>
		 <td align="left" class="head">Post Items On Ebay </td>
		<td align="right" class="head">
		<div style="float:right;">
		 <?php 
		if(!empty($AL)){ 
			$Aurl = "editProduct.php?edit=".$_GET['edit']."&curP=".$_GET['curP']."&tab=SendEbay";
		?>
		Alias: <select class="inputbox" id="AliasList" name="AliasList" title="Alias List" required="">
					<option value="<?=$Aurl?>">-- Please Select --</option>
					<?php foreach ($AL as $als){?>
					<option value="<?=$Aurl."&AliasID=".$als['AliasID']?>" <?php if($_GET['AliasID']==$als['AliasID']) echo "selected";?>><?=$als['ItemAliasCode']?></option>
					<?php }?>
			</select>
		<?php }?>
		
		<?php if(!empty($arryProduct[0]['FulfilledBy'])){ ?>
		 <a href="<?=$arryProduct[0]['FulfilledBy']?>" target="_blank">View Item Url</a>
		<?php } ?>

		 <?php
 if(!isset($ebayData[0]['Status'])) $ebayData[0]['Status']='';
 if($ebayData[0]['Status']==true){ ?>
		 <a class="active" style="<?=$bgColor?>width: 55px;font-weight: bold;padding: 5px 10px;text-decoration: initial;"><?=$productStatus;?> </a>
		 <?php }?>
		 
		<div style="clear:both;"></div>
		</div>

		 </td>
	</tr>
	
	<tr>
        <td  align="right"   class="blackbold" width="20%">Site Name:<span class="red">*</span> </td>
        <td   align="left" width="40%">

<? if(!isset($arryProduct[0]['browserNode'])) $arryProduct[0]['browserNode']='';?>
			 <select class="inputbox" name="SiteName" id="SiteName">
			 	<option value="">-- Select --</option>
			 	<?php foreach($objProduct->ebaySiteList() as $siteID=>$siteName):?>
	         	<option value="<?=$siteID?>" <?php if($arryProduct[0]['browserNode']==$siteID && $arryProduct[0]['Cat']>0) echo 'selected'; ?>><?=$siteName?></option>
	         	<?php endforeach;?>
	       	</select>            
		</td>
   </tr>
	
	<tr id="pc1" style="display: none;">
        <td  align="right"   class="blackbold" width="20%">Primary Category:<span class="red">*</span> </td>
        <td   align="left" width="40%" id="catData">
			<input name="Category1" type="text" class="inputbox" id="Category1" value=""/>            
		</td>
   </tr>
   
   <tr id="pc2" style="display: none;">
        <td  align="right"   class="blackbold" width="20%">Sub Category:<span class="red">*</span> </td>
        <td   align="left" width="40%" id="catData1">
			<input name="primaryCategory" type="text" class="inputbox" id="primaryCategory" value="<?php echo $arryProduct[0]['Cat']; ?>"/>
		</td>
   </tr>
   
   <tr id="pc3" style="display: none;">
        <td  align="right"   class="blackbold" width="20%">Sub Category (optional):<span class="red">*</span> </td>
        <td   align="left" width="40%" id="catData2">
			<input name="primaryCategory2" type="text" class="inputbox" id="primaryCategory2" value=""/>
		</td>
   </tr>
   
   <?php 
 if(!isset($arryProduct[0]['CatHierarchy'])) $arryProduct[0]['CatHierarchy']='';
if(strlen($arryProduct[0]['CatHierarchy'])>5 || !empty($arryProduct[0]['Cat'])){?>
   <tr>
        <td  align="right"   class="blackbold" width="20%">Category:<span class="red">*</span> </td>
        <td   align="left" width="40%" id="catData">
			<a><?=(!is_numeric($arryProduct[0]['CatHierarchy'])) ? $arryProduct[0]['Cat']:'';?></a>
			<a><?=str_replace(" => -- Select --", "",str_replace("#", " => ", $arryProduct[0]['CatHierarchy']))?></a>
		</td>
   </tr>
	<?php }?>
	 <!-- <tr>
 
 
	<td  align="right"   class="blackbold" width="20%">Ebay Product Lookup </td>
	    <td align="left" class="blackbold" colspan="4" style="padding: 10px 5px;">
	    <div style="float: left;width: 50%" id="ProductsearchBox">
	     <span class="breakhead">Find this Item in the Ebay catalog.</span>
		<input name="queryStr" type="text" class="inputbox" id="queryStr" value="">
		<input class="button" type="button" name="Search" value="Search" tittle="Search" onclick="searchProduct('');">
		 <!--  <img alt="" src="http://localhost/erp/admin/images/loading.gif" style="margin-left: 150px;">-->
	 <!--	</div>
		<div style="float: left;width: 50%" id="ResultData">
		</div> 
		<div style="clear: both;"></div>
		<div style="float: left;width: 50%;display: none;" id="linkBox" onclick="resetSearch();">
	    	<span class="breakhead-up">Search for a different Amazon product</span>
	    </div>
	 </td>
	</tr> -->

   <tr>
        <td  align="right"   class="blackbold" width="15%">Item Title:<span class="red">*</span> </td>
        <td   align="left" >
			<input name="itemTitle" type="text" class="inputbox" id="itemTitle" value="<?php echo $arryProduct[0]['Name']; ?>"/>            
		</td>
   </tr>

	<tr>
        <td  align="right"  class="blackbold">Item Description:<span class="red">*</span> </td>
        <td   align="left" >
			<input name="itemDescription" type="text" class="inputbox" id="itemDescription" value="<?php echo (!empty($arryProduct[0]['ShortDetail']))?trim(strip_tags($arryProduct[0]['ShortDetail'])):''; ?>"/> 
		</td>
	</tr>	  
		
      <tr>
        <td  align="right"   class="blackbold" >Condition:<span class="red">*</span> </td>
        <td   align="left" colspan="3">
<? if(!isset($arryProduct[0]['ItemCondition'])) $arryProduct[0]['ItemCondition']='';?>
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
	
	 <tr>
        <td  align="right"   class="blackbold" width="15%">Product SKU: </td>
        <td   align="left" >
			<input name="SKU" type="text" class="inputbox" id="SKU" value="<?php echo $arryProduct[0]['ProductSku']; ?>"/>            
		</td>
   </tr>
	
 	<tr>
        <td  align="right"   class="blackbold" >Listing Type:<span class="red">*</span> </td>
        <td   align="left" colspan="3">
<? if(!isset($arryProduct[0]['ProductType'])) $arryProduct[0]['ProductType']='';?>
		 <select class="inputbox" name="listingType">
         <option value="FixedPriceItem" <?php if($arryProduct[0]['ProductType']=='FixedPriceItem') echo 'selected';?>>Fixed Price Item</option>
         <option value="Chinese" <?php if($arryProduct[0]['ProductType']=='Chinese') echo 'selected';?>>Chinese</option>
         <option value="Half" <?php if($arryProduct[0]['ProductType']=='Half') echo 'selected';?>>Half</option>
       </select>
      </td>
	 </tr>

 	 <tr>
	      <td  align="right"   class="blackbold" width="20%">Listing Duration:<span class="red">*</span> </td>
	      <td   align="left" width="40%">
<? if(!isset($arryProduct[0]['ProductTypeName'])) $arryProduct[0]['ProductTypeName']='';?>
  				<select class="inputbox" name="listingDuration">
		             <option value="Days_30" <?php if($arryProduct[0]['ProductTypeName']=='Days_30') echo 'selected';?>>30 days</option>
  				 	<option value="Days_7" <?php if($arryProduct[0]['ProductTypeName']=='Days_7') echo 'selected';?>>7 days</option>
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
	 
<?php if($productStatus!='Active') {?> 
   <tr>
        <td  align="right"  class="blackbold"></td>
        <td   align="left" >
		<input  class="button" type="submit" name="submit"  value="AddItem" tittle="AddItem">
		</td>
   </tr> 
<?php } ?>   
</table>	
</form>


<?php
    if(isset($_POST['submit']))
	{ 
		
		if($productStatus == 'Active'){
			$_SESSION['CRE_Msg'] = 'Can not change any thing from here.';
			return ;
		}
		
		if(!is_numeric($ShippingServiceCost) || empty($ReturnsDesc)){
			$_SESSION['CRE_Msg'] = "Shipping or return policy details are empty in ebay settings. Please fill up first!!";
			return;
		}
		
	
	//pr($_POST,1);

       	$siteID = (isset($_POST['SiteName']))?$_POST['SiteName']:0;
       
        $siteNames = $objProduct->ebaySiteName();
        $country = $siteNames[$siteID];
        
        //$cat2 = (!empty($_POST['primaryCategory2']))? '#'.$_POST['primaryCategory2']:''; 
        //$_POST['CatHierarchy'] = $_POST['Category1'].'#'.$_POST['primaryCategory'].$cat2;
        if(!empty($_POST['primaryCategory2'])) $_POST['primaryCategory'] = $_POST['primaryCategory2'];
        
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
		$verb = 'AddItem';
	
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
    if(!empty($arryProduct[0]['Mid']) && !empty($arryManufacturer) && empty($arryProduct[0]['Brand'])){
        foreach($arryManufacturer as $mname){
            if($arryProduct[0]['Mid']==$mname['Mid']) { $ManufrName = $mname['Mname']; break;}
        }
    }else{
			$ManufrName = $arryProduct[0]['Brand'];
		}

    if(!empty($ManufrName)){
         $BrandName = 
'<ProductListingDetails>
	    <UPC>Does not apply</UPC>
	</ProductListingDetails>
 <ItemSpecifics>
 <NameValueList>
     <Name>Brand</Name>
     <Value>'.$ManufrName.'</Value>
 </NameValueList>
 <NameValueList>
     <Name>MPN</Name>
     <Value>'.$SKU.'</Value>
 </NameValueList>
</ItemSpecifics>';
    }



$requestXmlBody  = '<?xml version="1.0" encoding="utf-8"?>
<AddItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  <RequesterCredentials>
    <eBayAuthToken>'.$userToken.'</eBayAuthToken>
  </RequesterCredentials>
	<ErrorLanguage>en_US</ErrorLanguage>
	<WarningLevel>High</WarningLevel>
  <Item>
    <Title>'.$itemTitle.'</Title>
    <Description>'.$itemDescription.'</Description>
    <PrimaryCategory>
      <CategoryID>'.$primaryCategory.'</CategoryID>
    </PrimaryCategory>
    <StartPrice>'.$startPrice.'</StartPrice>
    <CategoryMappingAllowed>true</CategoryMappingAllowed>
    <Country>'.$country.'</Country>
    <Currency>'.$Config['Currency'].'</Currency>
    <ConditionID>'.$itemCondition.'</ConditionID>
    <DispatchTimeMax>3</DispatchTimeMax>
    <ListingDuration>'.$listingDuration.'</ListingDuration>
    <ListingType>'.$listingType.'</ListingType>
    <PaymentMethods>PayPal</PaymentMethods>
    <PayPalEmailAddress>'.$paypalEmailAddress.'</PayPalEmailAddress>
    '.$PictureURL.'
    <PostalCode>95125</PostalCode>
		'.$BrandName.'
    <Quantity>'.(int)$Quantity.'</Quantity>
    <ReturnPolicy>
      <ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>
      <RefundOption>MoneyBack</RefundOption>
      <ReturnsWithinOption>'.$ReturnsWithin.'</ReturnsWithinOption>
      <Description>'.$ReturnsDesc.'</Description>
      <ShippingCostPaidByOption>Buyer</ShippingCostPaidByOption>
    </ReturnPolicy>
    <ShippingDetails>
      <ShippingType>'.$ShippingType.'</ShippingType>
      <ShippingServiceOptions>
        <ShippingServicePriority>1</ShippingServicePriority>
        <ShippingService>'.$ShippingService.'</ShippingService>
		<ShippingServiceAdditionalCost>'.$ShippingServiceCost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$ShippingServiceCost.'</ShippingServiceCost>
      </ShippingServiceOptions>
    </ShippingDetails>
    <Site>US</Site>
	<SKU>'.$SKU.'</SKU>
 </Item>
</AddItemRequest>';
		
		//echo ($requestXmlBody);exit;
	
        $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
		
		$responseXml = $session->sendHttpRequest(utf8_encode($requestXmlBody));
		if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
			die('<P>Error sending request');
		
		$responseDoc = new DomDocument();
		$responseDoc->loadXML($responseXml);
			
		//pr($responseDoc,1);
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
		{ //no errors
			$FeedProcessingStatus = 'Active';
			$Status = 1;
			$_POST['FeedProcessingSMsg'] = '';
            $responses = $responseDoc->getElementsByTagName("AddItemResponse");
            $itemID = "";
            foreach ($responses as $response) {
              $acks = $response->getElementsByTagName("Ack");
              $ack   = $acks->item(0)->nodeValue;
              echo "Ack = $ack <BR />\n";   
              
              $endTimes  = $response->getElementsByTagName("EndTime");
              $endTime   = $endTimes->item(0)->nodeValue;
              echo "endTime = $endTime <BR />\n";
              
              $itemIDs  = $response->getElementsByTagName("ItemID");
              $_POST['ProductCode'] = $itemID  = $itemIDs->item(0)->nodeValue;
              echo "itemID = $itemID <BR />\n";
              
              $linkBase = "http://cgi.sandbox.ebay.com/ws/eBayISAPI.dll?ViewItem&item=";
              $_POST['ViewItemURL'] = $linkBase . $itemID ;
              echo "<a href=$linkBase" . $itemID . ">$itemTitle</a> <BR />";
              
              $feeNodes = $responseDoc->getElementsByTagName('Fee');
              foreach($feeNodes as $feeNode) 
			  {
                $feeNames = $feeNode->getElementsByTagName("Name");
                if ($feeNames->item(0)) {
                    $feeName = $feeNames->item(0)->nodeValue;
                    $fees = $feeNode->getElementsByTagName('Fee');  // get Fee amount nested in Fee
                    $fee = $fees->item(0)->nodeValue;
                } // if feeName
              } // foreach $feeNode
            
            } // foreach response
          //  echo $responseXml;
		} 
		 
		$_POST['FeedProcessingStatus'] = $FeedProcessingStatus;
		$_POST['Status'] = $Status;
		$objProduct->saveEbayData($_POST);
		$EditUrl = "editProduct.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&CatID=".$categoryIdGetPost."&tab=";
		$EditUrl= $EditUrl.$_GET["tab"];
		
		if(!empty($_GET['AliasID'])) $EditUrl = $EditUrl."&AliasID=".$_GET['AliasID'];
		
		header("Location:".$EditUrl);
		exit;
		
	}
	
?>
