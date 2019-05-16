<?php
$AL = $objProduct->GetAliasbySku($arryProduct[0]['ProductSku']);

if(!empty($_GET['AliasID'])){
	$AmazonData = $objProduct->getAliasAmazonData('amazon',(int)$_GET['AliasID']);
	$mid = (!empty($AmazonData[0]['Manufacture']))?($AmazonData[0]['Manufacture']):('');
	if(empty($AmazonData))
		$arryAlias = $objProduct->GetAliasItem((int)$_GET['AliasID']);
}

if(empty($AmazonData)){
	if(!empty($_GET['pid'])){
		$AmazonData = $objProduct->getAmazonData((int)$_GET['edit'],'amazon','','','',(int)$_GET['pid']);
	}else{
	$AmazonData = $objProduct->getAmazonData((int)$_GET['edit'],'amazon','','','','');
	}
}


$bgColor = 'display: none;';
if(!empty($AmazonData)){
	$AmazonData[0]['ProductID'] = $AmazonData[0]['itemID'];
	//$AmazonData[0]['Name'] = $arryProduct[0]['Name'];
	//$AmazonData[0]['ProductSku'] = $arryProduct[0]['ProductSku'];
	$AmazonData[0]['Mid'] = $arryProduct[0]['Mid'];
	$arryProduct = $AmazonData;
	
	if($AmazonData[0]['Status']==false && !empty($AmazonData[0]['FeedSubmissionId'])){ 
		$Amazonservice = $objProduct->AmazonSettings($Prefix,true,$AmazonData[0]['AmazonAccountID']);
	
		if($Amazonservice)
			$data = $objProduct->getFeedSubmissionHistory($Amazonservice,$AmazonData[0]['FeedSubmissionId']);
			
			$productStatus = (!empty($data['status']))?$data['status']:$data['FeedProcessingStatus'];
			$productMsg = (!empty($data['feedmsg']))?$data['feedmsg']:$data['FeedProcessingSMsg'];
	}
	
	$objProduct->AmazonSettings($Prefix,true,$AmazonData[0]['AmazonAccountID']);	
	if(($AmazonData[0]['Status']==true && $AmazonData[0]['FeedProcessingStatus']=='Active') || $productStatus=='Active'){
		$productStatus = 'Active';
		$bgColor = 'background-color: #81bd82 !important;';
	}else if(($AmazonData[0]['Status']==true && $AmazonData[0]['FeedProcessingStatus']=='Error') || $productStatus=='Error'){
		$productStatus = 'Error';
		$productMsg = $AmazonData[0]['FeedProcessingSMsg'];
		$bgColor = 'background-color: #d40503 !important;';
	}else if ($productStatus=='In Process' || $AmazonData[0]['FeedProcessingStatus']=='In Process'){
		$productStatus = 'In Process'; 
		$bgColor = 'background-color: #535353 !important;';
	}
}


for ($i = 0; $i < sizeof($arryManufacturer); $i++) {                                                                   
               if ($arryManufacturer[$i]['Mid'] == $arryProduct[0]['Mid']) {
                $mid = stripslashes($arryManufacturer[$i]['Mname']);
               }
            }

if(isset($AmazonData[0]['Features'])){
	$Features = unserialize($AmazonData[0]['Features']);
}
if(isset($AmazonData[0]['Keywords'])){
	$Keywords = unserialize($AmazonData[0]['Keywords']);
}

/*********** Validations *****************/
if(!isset($_POST['submitAmazon']) && isset($_GET['quickAmazon'])){
$vS = true;
if(empty($arryProduct[0]['Name'])) { echo '<div class="message" align="center">Product Name is empty.</div>'; $vS = false;  }
if(empty($arryProduct[0]['ProductSku'])) { echo '<div class="message" align="center">Product Sku is empty.</div>'; $vS = false;  }
if(empty($arryProduct[0]['Quantity'])) { echo '<div class="message" align="center">Quantity is empty.</div>'; $vS = false;  }
//if(empty($ItemCondition)) { echo '<div class="message" align="center">Item Condition is set in amazon setting.</div>'; $vS = false;  }
if(empty($arryProduct[0]['Price'])) { echo '<div class="message" align="center">Price is 0.</div>'; $vS = false;  }
if(empty($arryProduct[0]['Price2'])) { echo '<div class="message" align="center">Sale Price is 0.</div>'; $vS = false;  }
if(empty($mid)) { echo '<div class="message" align="center">Product Manufacturer is empty.</div>'; $vS = false;  }
if(!$vS) exit;
}
/*********** Validations End *****************/
if(!empty($_GET['AliasID']) && !empty($arryAlias)){
	$AmazonData[0]['ProductID'] = 0;
	$arryProduct[0]['ProductID'] = 0;
	$arryProduct[0]['ProductSku'] = $arryAlias[0]['ItemAliasCode'];
	$mid = $arryAlias[0]['Manufacture'];
}

 
if(!isset($arryProduct[0]['ProductType'])) $arryProduct[0]['ProductType']='';
?>
</form>

<script type="text/javascript">

function closeFancyboxAndRedirectToUrl(url){
    $.fancybox.close();
    parent.window.location = url;
}

$( window ).load(function() {
<?php if( ($arryProduct[0]['ProductType']=='ASIN') && (strlen($arryProduct[0]['ProductCode'])>8) && ($productStatus!='Active') ){?>
setTimeout(function(){
	searchProduct('<?=$arryProduct[0]['ProductCode']?>');
},100);
<?php } ?>
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

function validateAmazonProduct(frm){ 
	if( ValidateForSimpleBlank(frm.AmazonAccountID, "Account Name")
		&& ValidateForSimpleBlank(frm.Name, "Item Title")
		&& ValidateForSimpleBlank(frm.ProductSku, "Product Sku")
		&& ValidateForSimpleBlank(frm.Cat, "Category")
		&& ValidateForSimpleBlank(frm.ProductType, "Product Type")
		&& ValidateForSimpleBlank(frm.ProductCode, "Product Code")
		&& ValidateForSimpleBlank(frm.Quantity, "Quantity")
		&& ValidateForSimpleBlank(frm.Price, "Price")
		&& ValidateForSimpleBlank(frm.ItemCondition, "Product Condition")
		&& ValidateForSimpleBlank(frm.Mid, "Product Manufacturer:")
	  ){
		  
	}else{
		return false;	
	}
}

function searchProduct(ASIN){ 
		acctID = $("#amazonAccountID").val();
		if(acctID==''){ alert("Please Select account name First!!"); return false; }
		ShowHideLoader('1','P');
		
		 if(ASIN!='') { 
			 queryStr = ASIN; 
			 $("#ProductCode").val(queryStr);
		 }else{
			queryStr = $("#queryStr").val();
			ASIN = '';
		}
		 var itemID = '<?=(!empty($arryProduct[0]['ProductID']))?$arryProduct[0]['ProductID']:0?>';
		 var cat = $("#queryCat").val();
		 $.ajax({
	        url : "ajax.php",
	        type: "GET",
	        data : { action: 'searchProduct', Query: queryStr, Category: cat, ASIN:ASIN, AccountID: acctID, itemID:itemID  },
	        success: function(data)
	        {	 
				 $("#ResultData").html(data);
				 ShowHideLoader('2','P');
				 if(ASIN!='') { 
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
$(document).ready(function(){
    // bind change event to select
    $('#AliasList').on('change', function () {
        var url = $(this).val(); // get selected value
        if (url) { // require a URL
            window.location = url; // redirect
        }
        return false;
    });
  });
</script>
<style>
<!--
.breakhead{
color: #636262;
font-size: 12px;
    display: block;
    border-bottom: 1px solid #E1E1E1;
    margin-bottom: 15px;
    padding-bottom: 3px;
    font-weight: bold;
    width: 65%;
}
.breakhead-up{
    color: #37a000;
    font-size: 12px;
    display: block;
    border-top: 1px solid #E1E1E1;
    margin-bottom: 5px;
    font-weight: bold;
    padding-top: 10px;
    width: 65%;
    cursor: pointer;
    text-decoration: underline;
}
-->
</style>
<div class="had">Manage Amazon Products</span>  
<?php 
if(!empty($AL)){ 
	$Aurl = "editProduct.php?edit=".$_GET['edit']."&curP=".$_GET['curP']."&tab=SendAmazon";
?>
<div style="float:right;">
Alias: <select class="inputbox" id="AliasList" name="AliasList" title="Alias List" required="">
			<option value="<?=$Aurl?>">-- Please Select --</option>
			<?php foreach ($AL as $als){?>
			<option value="<?=$Aurl."&AliasID=".$als['AliasID']?>" <?php if($_GET['AliasID']==$als['AliasID']) echo "selected";?>><?=$als['ItemAliasCode']?></option>
			<?php }?>
	</select>
</div>
<div style="clear:both;"></div>
<?php }?>
</div>

<div class="message" align="center"><? if(!empty($_SESSION['CRE_Msg'])) {echo $_SESSION['CRE_Msg']; unset($_SESSION['CRE_Msg']); } if($productStatus=='Error'){echo $productMsg;}?></div>

<?
if(!isset($arryProduct[0]['pid'])) $arryProduct[0]['pid']='';
if(!isset($arryProduct[0]['ProductCode'])) $arryProduct[0]['ProductCode']='';
?>
<table width="100%" border="0" cellpadding="5" cellspacing="0">

	<input type="hidden" name="itemID" value="<?php echo $arryProduct[0]['ProductID']; ?>"/>
	<input type="hidden" name="pid" value="<?php echo $arryProduct[0]['pid']; ?>"/>
	<input type="hidden" name="ProductType" id="ProductType" value="ASIN"/>
	<input type="hidden" name="ProductCode" id="ProductCode" value="<?php echo $arryProduct[0]['ProductCode']; ?>"/>
	
	<tr>
		<td align="right" class="blackbold" colspan="4" ><a class="active" style="<?=$bgColor?>width: 55px;font-weight: bold;padding: 5px 10px;    text-decoration: initial;"><?=$productStatus;?> </a></td>
	</tr>
	
	<tr>
		<td align="left" class="blackbold" width="15%">Account Name:<span
			class="red">*</span></td>
		<td align="left"><select class="inputbox" id="amazonAccountID" name="AmazonAccountID"  >
		    <option value="" >-- Select Account --</option>
 		<?php $amazonAccounts = $objProduct->getAccountAll();
 		if(!empty($amazonAccounts)){

if(!isset($arryProduct[0]['AmazonAccountID'])) $arryProduct[0]['AmazonAccountID']='';


		foreach($amazonAccounts as $amazonAccount){
		?>
		<option <?php if($arryProduct[0]['AmazonAccountID']==$amazonAccount['id']){echo "selected";} ?> value="<?=$amazonAccount['id']?>"><?=$amazonAccount['title']?></option>					
		<?php }}?>			    
		</select>
		</td>
		<?php if(($productStatus=='Active' || $productStatus=='In Process') ){ ?>
		<td align="right" class="blackbold" width="15%">ASIN:<span
			class="red">*</span></td>
		<td align="left"> <a href="https://<?=$objProduct->URL?>/gp/product/<?=$arryProduct[0]['ProductCode']?>" target="_blank"><?=$arryProduct[0]['ProductCode']?></a>
		</td>
		<?php }?>
	</tr>
	<?php if(($productStatus!='Active') ){ ?>
	<tr>
		<td colspan="4" align="left" class="head">Amazon Product Lookup</td>
	</tr>
	<tr>
	    <td align="left" class="blackbold" colspan="4" style="padding: 10px 5px;">
	    <div style="float: left;width: 50%" id="ProductsearchBox">
	     <span class="breakhead">Find this product in the Amazon catalog.</span>
		<input name="queryStr" type="text" class="inputbox" id=queryStr placeholder=" e.g., ASIN, SKU, Title or others" value="">
		<input class="button" type="button" name="Search" value="Search" tittle="Search" onclick="searchProduct('');">
		<!--  <img alt="" src="http://localhost/erp/admin/images/loading.gif" style="margin-left: 150px;"> -->
		<br/>
		<select  class="inputbox" name="queryCat" id="queryCat">
			<option label="All Categories" value="All" selected="selected">All Categories</option>
			<option label="Apparel" value="Apparel">Apparel</option>
			<option label="Appliances" value="Appliances">Appliances</option>
			<option label="Arts &amp; Crafts" value="ArtsAndCrafts">Arts &amp; Crafts</option>
			<option label="Automotive" value="Automotive">Automotive</option>
			<option label="Baby" value="Baby">Baby</option>
			<option label="Books" value="Books">Books</option>
			<option label="Cameras &amp; Photo" value="Photo">Cameras &amp; Photo</option>
			<option label="Classical" value="Classical">Classical</option>
			<option label="Computers" value="PCHardware">Computers</option>
			<option label="DVD" value="DVD">DVD</option>
			<option label="Electronics" value="Electronics">Electronics</option>
			<option label="Goumet Food" value="Grocery">Goumet Food</option>
			<option label="Health &amp; Personal Care" value="HealthPersonalCare">Health &amp; Personal Care</option>
			<option label="Home &amp; Garden" value="HomeGarden">Home &amp; Garden</option>
			<option label="Industrial" value="Industrial">Industrial</option>
			<option label="Jewelry" value="Jewelry">Jewelry</option>
			<option label="Kitchen &amp; Housewares" value="Kitchen">Kitchen &amp; Housewares</option>
			<option label="Miscellaneous" value="Miscellaneous">Miscellaneous</option>
			<option label="Music" value="Music">Music</option>
			<option label="Musical Instruments" value="MusicalInstruments">Musical Instruments</option>
			<option label="Office Products" value="OfficeProducts">Office Products</option>
			<option label="Pet Supplies" value="PetSupplies">Pet Supplies</option>
			<option label="Shoes" value="Shoes">Shoes</option>
			<option label="Software" value="Software">Software</option>
			<option label="Sporting Goods" value="SportingGoods">Sporting Goods</option>
			<option label="Tools &amp; Hardware" value="Tools">Tools &amp; Hardware</option>
			<option label="Toys &amp; Games" value="Toys">Toys &amp; Games</option>
			<option label="Video" value="Video">Video</option>
			<option label="Video Games" value="VideoGames">Video Games</option>
			<option label="Watches" value="Watches">Watches</option>
			<option label="Wireless" value="Wireless">Wireless</option>
			<option label="Wireless Accessories" value="WirelessAccessories">Wireless Accessories</option>
		</select>
		</div>
		<div style="float: left;width: 50%" id="ResultData">
		</div> 
		<div style="clear: both;"></div>
		<div style="float: left;width: 50%;display: none;" id="linkBox" onclick="resetSearch();">
	    	<span class="breakhead-up">Search for a different Amazon product</span>
	    </div>
	 </td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="4" align="left" class="head">Basic Details</td>
	</tr>
	
	<tr>
		<td align="right" class="blackbold" width="15%">Item Title:<span
			class="red">*</span></td>
		<td align="left"><input name="Name" type="text" class="inputbox"
			id="Name" value="<?php echo $arryProduct[0]['Name']; ?>"  readonly style="border:none;"/>
		</td>
		
		<td align="right" class="blackbold" width="15%">SKU:<span
			class="red">*</span></td>
		<td align="left"><input name="ProductSku" type="text" class="inputbox"
			id="ProductSku" value="<?php echo $arryProduct[0]['ProductSku']; ?>" readonly style="border:none;"/>
		</td>
	</tr>
	
	
	<tr>
		<td align="right" class="blackbold" width="15%">Quantity:<span
			class="red">*</span></td>
		<td align="left"><input name="Quantity" type="text" class="inputbox"
			id="Quantity" value="<?php echo $arryProduct[0]['Quantity']; ?>" required/>
		</td>
		
		<td align="right" class="blackbold" width="15%">Price:<span
			class="red">*</span></td>
		<td align="left"><input name="Price" type="text" class="inputbox"
			id="Price" value="<?php echo number_format((float)$arryProduct[0]['Price'], 2, '.', ''); ?>" required/> <?= $Config['Currency'] ?>
		</td>
	</tr>

	<tr>
		<td align="right" class="blackbold">Condition:<span class="red">*</span>
		</td>
		<td align="left"><select class="inputbox"
			id="ItemCondition" name="ItemCondition" title="Condition" required>
			<option value="New" <?=($arryProduct[0]['ProductType']=='New') ? 'selected' : ''?>>New</option>
			<option value="Used; Like_new" <?=($arryProduct[0]['ProductType']=='Used; Like_new') ? 'selected' : ''?>>Used - Like New</option>
			<option value="Used; Very_good" <?=($arryProduct[0]['ProductType']=='Used; Very_good') ? 'selected' : ''?>>Used - Very Good</option>
			<option value="Used; Good" <?=($arryProduct[0]['ProductType']=='Used; Good') ? 'selected' : ''?>>Used - Good</option>
			<option value="Used; Acceptable" <?=($arryProduct[0]['ProductType']=='Used; Acceptable') ? 'selected' : ''?>>Used - Acceptable</option>
			<option value="Collectible, Like_new" <?=($arryProduct[0]['ProductType']=='Collectible, Like_new') ? 'selected' : ''?>>Collectible - Like New</option>
			<option value="Collectible, Very_good" <?=($arryProduct[0]['ProductType']=='Collectible, Very_good') ? 'selected' : ''?>>Collectible - Very Good</option>
			<option value="Collectible, Good" <?=($arryProduct[0]['ProductType']=='Collectible, Good') ? 'selected' : ''?>>Collectible - Good</option>
			<option value="Collectible, Acceptable" <?=($arryProduct[0]['ProductType']=='Collectible, Acceptable') ? 'selected' : ''?>>Collectible - Acceptable</option>
			<option value="Refurbished, Refurbished" <?=($arryProduct[0]['ProductType']=='Refurbished, Refurbished') ? 'selected' : ''?>>Refurbished</option>
		</select>
		
		</td>
		 
		<td align="right" class="blackbold" width="15%">Condition Note:</td>
		<td align="left"><textarea name="ItemConditionNote" type="text" class="inputbox" id="ItemConditionNote"><?php if(isset($arryProduct[0]['ItemConditionNote']))  echo trim(strip_tags($arryProduct[0]['ItemConditionNote'])); ?> </textarea>
		</td>
	</tr>
	<tr>
		<td align="right" class="blackbold" width="15%">Fulfilled By:</td>
		<td align="left">
<? if(!isset($arryProduct[0]['FulfilledBy'])) $arryProduct[0]['FulfilledBy']=''; ?>
<select class="inputbox"
			id="FulfilledBy" name="FulfilledBy" title="Fulfilled By" required>
			<option value="AMAZON_NA" <?=($arryProduct[0]['FulfilledBy']=='AMAZON_NA') ? 'selected' : ''?>>Amazon</option>
			<option value="DEFAULT" <?=($arryProduct[0]['FulfilledBy']=='DEFAULT') ? 'selected' : ''?>>Merchant</option>
		</select>
		</td>
		<td align="right" class="blackbold" width="15%">Item Description:</td>
		<td align="left"><textarea name="ShortDetail" type="text" class="inputbox" id="ShortDetail"><?php if(!empty($arryAlias[0]['description'])){echo $arryAlias[0]['description'];}else{ echo (!empty($arryProduct[0]['Name']))?strip_tags($arryProduct[0]['Name']):''; }?> </textarea>
		</td>
	</tr>
	<tr>
		<td align="right" class="blackbold" width="15%">Tax Code:<span class="red">*</span></td>
		<td align="left"><select class="inputbox"
			id="TaxCode" name="TaxCode" title="Condition" required>
			<option label="A_BABY_BRSTPUMP" value="A_BABY_BRSTPUMP">A_BABY_BRSTPUMP</option>
			<option label="A_BABY_CARSEAT" value="A_BABY_CARSEAT">A_BABY_CARSEAT</option>
			<option label="A_BABY_CLOTH" value="A_BABY_CLOTH">A_BABY_CLOTH</option>
			<option label="A_BABY_DIAPER" value="A_BABY_DIAPER">A_BABY_DIAPER</option>
			<option label="A_BOOKS_GEN" value="A_BOOKS_GEN">A_BOOKS_GEN</option>
			<option label="A_BOOKS_RELIG" value="A_BOOKS_RELIG">A_BOOKS_RELIG</option>
			<option label="A_BUNDLE_PERDCL" value="A_BUNDLE_PERDCL">A_BUNDLE_PERDCL</option>
			<option label="A_CLSFD_52W-4Q" value="A_CLSFD_52W-4Q">A_CLSFD_52W-4Q</option>
			<option label="A_CLSFD_52WKLY" value="A_CLSFD_52WKLY">A_CLSFD_52WKLY</option>
			<option label="A_CLSFD_ANNUAL" value="A_CLSFD_ANNUAL">A_CLSFD_ANNUAL</option>
			<option label="A_CLSFD_SEMIANNL" value="A_CLSFD_SEMIANNL">A_CLSFD_SEMIANNL</option>
			<option label="A_CLTH_ATHL" value="A_CLTH_ATHL">A_CLTH_ATHL</option>
			<option label="A_CLTH_BATH" value="A_CLTH_BATH">A_CLTH_BATH</option>
			<option label="A_CLTH_BOOKBAG" value="A_CLTH_BOOKBAG">A_CLTH_BOOKBAG</option>
			<option label="A_CLTH_BUCKLS" value="A_CLTH_BUCKLS">A_CLTH_BUCKLS</option>
			<option label="A_CLTH_COMPON" value="A_CLTH_COMPON">A_CLTH_COMPON</option>
			<option label="A_CLTH_CSTUMS" value="A_CLTH_CSTUMS">A_CLTH_CSTUMS</option>
			<option label="A_CLTH_FORMAL" value="A_CLTH_FORMAL">A_CLTH_FORMAL</option>
			<option label="A_CLTH_FUR" value="A_CLTH_FUR">A_CLTH_FUR</option>
			<option label="A_CLTH_GEN" value="A_CLTH_GEN">A_CLTH_GEN</option>
			<option label="A_CLTH_HANDKE" value="A_CLTH_HANDKE">A_CLTH_HANDKE</option>
			<option label="A_CLTH_HBAGS" value="A_CLTH_HBAGS">A_CLTH_HBAGS</option>
			<option label="A_CLTH_IFUR" value="A_CLTH_IFUR">A_CLTH_IFUR</option>
			<option label="A_COLLECTIBLE_COIN" value="A_COLLECTIBLE_COIN">A_COLLECTIBLE_COIN</option>
			<option label="A_COMP_COMPUTER" value="A_COMP_COMPUTER">A_COMP_COMPUTER</option>
			<option label="A_COMP_EDUSOFT" value="A_COMP_EDUSOFT">A_COMP_EDUSOFT</option>
			<option label="A_COMP_GAMPER" value="A_COMP_GAMPER">A_COMP_GAMPER</option>
			<option label="A_COMP_PDA" value="A_COMP_PDA">A_COMP_PDA</option>
			<option label="A_COMP_PERIPH" value="A_COMP_PERIPH">A_COMP_PERIPH</option>
			<option label="A_COMP_PRINT" value="A_COMP_PRINT">A_COMP_PRINT</option>
			<option label="A_COMP_PRTSUP" value="A_COMP_PRTSUP">A_COMP_PRTSUP</option>
			<option label="A_COMP_SOFTOP" value="A_COMP_SOFTOP">A_COMP_SOFTOP</option>
			<option label="A_COMP_SOFTRC" value="A_COMP_SOFTRC">A_COMP_SOFTRC</option>
			<option label="A_EGOODS_DIGITALAUDIOBOOKS" value="A_EGOODS_DIGITALAUDIOBOOKS">A_EGOODS_DIGITALAUDIOBOOKS</option>
			<option label="A_EGOODS_DIGITALBOOKS" value="A_EGOODS_DIGITALBOOKS">A_EGOODS_DIGITALBOOKS</option>
			<option label="A_EGOODS_DIGITALBOOK_RENTAL" value="A_EGOODS_DIGITALBOOK_RENTAL">A_EGOODS_DIGITALBOOK_RENTAL</option>
			<option label="A_EGOODS_DIGITALGAMES" value="A_EGOODS_DIGITALGAMES">A_EGOODS_DIGITALGAMES</option>
			<option label="A_EGOODS_DIGITALMUSIC" value="A_EGOODS_DIGITALMUSIC">A_EGOODS_DIGITALMUSIC</option>
			<option label="A_EGOODS_DIGITALNEWS" value="A_EGOODS_DIGITALNEWS">A_EGOODS_DIGITALNEWS</option>
			<option label="A_EGOODS_DIGITALNEWSSUBS" value="A_EGOODS_DIGITALNEWSSUBS">A_EGOODS_DIGITALNEWSSUBS</option>
			<option label="A_EGOODS_DIGITALPERDCL" value="A_EGOODS_DIGITALPERDCL">A_EGOODS_DIGITALPERDCL</option>
			<option label="A_EGOODS_DIGITALPERDCLSUBS" value="A_EGOODS_DIGITALPERDCLSUBS">A_EGOODS_DIGITALPERDCLSUBS</option>
			<option label="A_EGOODS_MISC1" value="A_EGOODS_MISC1">A_EGOODS_MISC1</option>
			<option label="A_EGOODS_ONLINEGAMINGSUBS" value="A_EGOODS_ONLINEGAMINGSUBS">A_EGOODS_ONLINEGAMINGSUBS</option>
			<option label="A_EGOODS_SOFT" value="A_EGOODS_SOFT">A_EGOODS_SOFT</option>
			<option label="A_FOOD_BKTCDY50-90" value="A_FOOD_BKTCDY50-90">A_FOOD_BKTCDY50-90</option>
			<option label="A_FOOD_BKTGN50-75" value="A_FOOD_BKTGN50-75">A_FOOD_BKTGN50-75</option>
			<option label="A_FOOD_BKTGN76-90" value="A_FOOD_BKTGN76-90">A_FOOD_BKTGN76-90</option>
			<option label="A_FOOD_CARBSFTDK" value="A_FOOD_CARBSFTDK">A_FOOD_CARBSFTDK</option>
			<option label="A_FOOD_CARBWTR" value="A_FOOD_CARBWTR">A_FOOD_CARBWTR</option>
			<option label="A_FOOD_CNDY" value="A_FOOD_CNDY">A_FOOD_CNDY</option>
			<option label="A_FOOD_CNDYFL" value="A_FOOD_CNDYFL">A_FOOD_CNDYFL</option>
			<option label="A_FOOD_GEN" value="A_FOOD_GEN">A_FOOD_GEN</option>
			<option label="A_FOOD_JUICE0-50" value="A_FOOD_JUICE0-50">A_FOOD_JUICE0-50</option>
			<option label="A_FOOD_JUICE51-99" value="A_FOOD_JUICE51-99">A_FOOD_JUICE51-99</option>
			<option label="A_FOOD_NCARBWTR" value="A_FOOD_NCARBWTR">A_FOOD_NCARBWTR</option>
			<option label="A_FOOD_WINE" value="A_FOOD_WINE">A_FOOD_WINE</option>
			<option label="A_GEN_NOTAX" value="A_GEN_NOTAX" selected="selected">A_GEN_NOTAX</option>
			<option label="A_GEN_TAX" value="A_GEN_TAX">A_GEN_TAX</option>
			<option label="A_HLTH_BABYSUPPLS" value="A_HLTH_BABYSUPPLS">A_HLTH_BABYSUPPLS</option>
			<option label="A_HLTH_BANDKIT" value="A_HLTH_BANDKIT">A_HLTH_BANDKIT</option>
			<option label="A_HLTH_CONTACTSOLN" value="A_HLTH_CONTACTSOLN">A_HLTH_CONTACTSOLN</option>
			<option label="A_HLTH_CONTRCEPV" value="A_HLTH_CONTRCEPV">A_HLTH_CONTRCEPV</option>
			<option label="A_HLTH_DIABSUPPLS" value="A_HLTH_DIABSUPPLS">A_HLTH_DIABSUPPLS</option>
			<option label="A_HLTH_DIETSUPMT" value="A_HLTH_DIETSUPMT">A_HLTH_DIETSUPMT</option>
			<option label="A_HLTH_FAMPLANTEST" value="A_HLTH_FAMPLANTEST">A_HLTH_FAMPLANTEST</option>
			<option label="A_HLTH_FEMHYG" value="A_HLTH_FEMHYG">A_HLTH_FEMHYG</option>
			<option label="A_HLTH_INCONT" value="A_HLTH_INCONT">A_HLTH_INCONT</option>
			<option label="A_HLTH_MOBILITY" value="A_HLTH_MOBILITY">A_HLTH_MOBILITY</option>
			<option label="A_HLTH_MONITOR" value="A_HLTH_MONITOR">A_HLTH_MONITOR</option>
			<option label="A_HLTH_OTCMED" value="A_HLTH_OTCMED">A_HLTH_OTCMED</option>
			<option label="A_HLTH_PROSTHETIC" value="A_HLTH_PROSTHETIC">A_HLTH_PROSTHETIC</option>
			<option label="A_HLTH_SPFCORALHYG" value="A_HLTH_SPFCORALHYG">A_HLTH_SPFCORALHYG</option>
			<option label="A_HLTH_SPFCOTCMED" value="A_HLTH_SPFCOTCMED">A_HLTH_SPFCOTCMED</option>
			<option label="A_HLTH_SUNSCRN" value="A_HLTH_SUNSCRN">A_HLTH_SUNSCRN</option>
			<option label="A_HLTH_THRMTR" value="A_HLTH_THRMTR">A_HLTH_THRMTR</option>
			<option label="A_HLTH_TISSUETOW" value="A_HLTH_TISSUETOW">A_HLTH_TISSUETOW</option>
			<option label="A_NEWS_104PLUS" value="A_NEWS_104PLUS">A_NEWS_104PLUS</option>
			<option label="A_NEWS_12MTHLY" value="A_NEWS_12MTHLY">A_NEWS_12MTHLY</option>
			<option label="A_NEWS_26BIWKLY" value="A_NEWS_26BIWKLY">A_NEWS_26BIWKLY</option>
			<option label="A_NEWS_4QTLY" value="A_NEWS_4QTLY">A_NEWS_4QTLY</option>
			<option label="A_NEWS_52WKLY" value="A_NEWS_52WKLY">A_NEWS_52WKLY</option>
			<option label="A_PERDCL_104PLUS" value="A_PERDCL_104PLUS">A_PERDCL_104PLUS</option>
			<option label="A_PERDCL_52W-4Q" value="A_PERDCL_52W-4Q">A_PERDCL_52W-4Q</option>
			<option label="A_PERDCL_52WKLY" value="A_PERDCL_52WKLY">A_PERDCL_52WKLY</option>
			<option label="A_PERDCL_ANNUAL" value="A_PERDCL_ANNUAL">A_PERDCL_ANNUAL</option>
			<option label="A_PERDCL_SEMIANNL" value="A_PERDCL_SEMIANNL">A_PERDCL_SEMIANNL</option>
			<option label="A_SCHL_SUPPLS" value="A_SCHL_SUPPLS">A_SCHL_SUPPLS</option>
			<option label="A_SERV_INSTALL" value="A_SERV_INSTALL">A_SERV_INSTALL</option>
			<option label="A_SPORT_ASUPPORT" value="A_SPORT_ASUPPORT">A_SPORT_ASUPPORT</option
			><option label="A_SPORT_ATHLSHOES" value="A_SPORT_ATHLSHOES">A_SPORT_ATHLSHOES</option>
			<option label="A_SPORT_BIKEHLMT" value="A_SPORT_BIKEHLMT">A_SPORT_BIKEHLMT</option>
			<option label="A_SPORT_MISCSPORTS1" value="A_SPORT_MISCSPORTS1">A_SPORT_MISCSPORTS1</option>
			<option label="A_SPORT_SKISUIT" value="A_SPORT_SKISUIT">A_SPORT_SKISUIT</option>
			<option label="A_WARR_PARTSNSVCE" value="A_WARR_PARTSNSVCE">A_WARR_PARTSNSVCE</option>
		</select>
		</td>
	</tr>
	
	<tr>
		<td colspan="4" align="left" class="head">Advanced Details</td>
	</tr>
	
	<tr>
		<td align="right" class="blackbold">Launch Date:
		</td>
		<td align="left" >
	
			<script type="text/javascript">
				$(function() { 
				$('#LaunchDate,#SaleStartDate,#SaleEndDate,#RestockDate').datepicker(
					{
					showOn: "both",
					dateFormat: 'yy-mm-dd', 
					yearRange: '2015:2025', 
					changeMonth: true,
					changeYear: true
			
					}
				);
				//$("#time_LaunchDate, #time_SaleStartDate, #time_SaleEndDate").timepicker({'timeFormat': 'H:i:s'});
				});
			</script>
			<input id="LaunchDate" name="LaunchDate" class="datebox" readonly=""  value="<? if(isset($arryProduct[0]['LaunchDate'])) echo $arryProduct[0]['LaunchDate'];?>" type="text">
				<!--<input id="time_LaunchDate" type="text" class="inputbox" style="width:100px;" value="" />-->
			
		
			<td align="right" class="blackbold" width="20%">Is Gift Message Available:</td>
			<td align="left" width="40%"> <input class="inputbox" type="checkbox"
				name="GiftMessage" value="1" <?php if(!empty($arryProduct[0]['GiftMessage'])) echo "checked";?> />
		
			</td>
		</td>
	</tr>

	<tr>
		<td align="right" class="blackbold" width="20%">Sale Start Date</td>
			<td align="left" width="40%"> 
			<input id="SaleStartDate" name="SaleStartDate" readonly="" class="datebox" value="<? if(isset($arryProduct[0]['SaleStartDate'])) echo $arryProduct[0]['SaleStartDate'];?>" type="text">
			<!--<input id="time_SaleStartDate" type="text" class="inputbox" style="width:100px;" value="" />-->
		</td>
		
		<td align="right" class="blackbold" width="20%">Is Gift Wrap Available:</td>
			<td align="left" width="40%"> <input class="inputbox" type="checkbox"
				name="GiftWrap" value="1" <?php if(!empty($arryProduct[0]['GiftWrap'])) echo "checked";?>>
			</td>
	</tr>

	<tr>
		<td align="right" class="blackbold" width="20%">Sale End Date:</td>
			<td align="left" width="40%"> 
			<input id="SaleEndDate" name="SaleEndDate" class="datebox" value="<? if(isset($arryProduct[0]['SaleEndDate'])) echo $arryProduct[0]['SaleEndDate']; ?>" type="text">
			<!--<input id="time_SaleEndDate" type="text" class="inputbox" style="width:100px;" value="" />-->
			</td>
			
			<td align="right" class="blackbold" width="20%">Product Manufacturer:<span class="red">*</span></td>
			<td align="left"> <input type="text" name="Mid" class="inputbox" id="Mid" required="" placeholder="select from other properties section" value="<? if(isset($mid)) echo $mid; ?>"/>
			</td>
			
	</tr>

	<tr>
		<td align="right" class="blackbold" width="20%">Restock Date:</td>
		<td align="left" > 
		<input id="RestockDate" name="RestockDate" class="datebox" value="<? if(isset($arryProduct[0]['RestockDate'])) echo $arryProduct[0]['RestockDate']; ?>" type="text">
		</td>
		
		<td align="right" class="blackbold" width="15%">Sale Price:</td>
		<td align="left" width="40%"><input class="inputbox" type="text"
			name="Price2" value="<?php echo number_format((float)$arryProduct[0]['Price2'], 2, '.', ''); ?>"> <?= $Config['Currency'] ?></td>
	</tr>
	
	<tr>
		<?php //(!empty($arryProduct[0]['Brand']) && empty($AmazonData)) ? $arryProduct[0]['Brand'] :$mid;?>
		<td align="right" class="blackbold" width="15%">Brand:</td>
		<td align="left"><input name="Brand" type="text" class="inputbox"
			id="Brand" placeholder="Your own registered brand name only" value="<? if(isset($arryProduct[0]['Brand'])) echo $arryProduct[0]['Brand'];  ?>"  />
		</td>
		
		<td align="right" class="blackbold" width="15%">Manufacturer Part No. :</td>
		<td align="left">
<? if(!isset($arryProduct[0]['MfrPartNumber'])) $arryProduct[0]['MfrPartNumber']='';?>

<input name="MfrPartNumber" type="text" class="inputbox"
			id="MfrPartNumber" value="<?=(!empty($AmazonData)) ? $arryProduct[0]['MfrPartNumber'] :$arryProduct[0]['ProductSku']; ?>"/>
		</td>
	</tr>
	
<!-- Features  Start-->
	<tr>
		<td colspan="4" align="left" class="head">Product Features</td>
	</tr>
	<tr>
		<td align="right" class="blackbold" width="15%">Product Feature 1:</td>
		<td align="left"><input name="Features[]" type="text" class="inputbox"
			id="Features" value="<?php if(isset($Features[0])) echo $Features[0]; ?>"  />
		</td>
	</tr>
	<tr>
		<td align="right" class="blackbold" width="15%">Product Feature 2:</td>
		<td align="left"><input name="Features[]" type="text" class="inputbox"
			id="Features" value="<?php if(isset($Features[1])) echo $Features[1]; ?>"  />
		</td>
	</tr>
	<tr>
		<td align="right" class="blackbold" width="15%">Product Feature 3:</td>
		<td align="left"><input name="Features[]" type="text" class="inputbox"
			id="Features" value="<?php if(isset($Features[2])) echo $Features[2]; ?>"  />
		</td>
	</tr>
	<tr>
		<td align="right" class="blackbold" width="15%">Product Feature 4:</td>
		<td align="left"><input name="Features[]" type="text" class="inputbox"
			id="Features" value="<?php if(isset($Features[3])) echo $Features[3]; ?>"  />
		</td>
	</tr>
<!-- Features  Start-->

<!-- Keywords  Start-->
	<tr>
		<td colspan="4" align="left" class="head">Search Term</td>
	</tr>
	<tr>
		<td align="right" class="blackbold" width="15%">Search Term 1:</td>
		<td align="left"><input name="Keywords[]" type="text" class="inputbox"
			id="Keywords" value="<?php if(isset($Keywords[0])) echo $Keywords[0]; ?>"  />
		</td>
	</tr>
	<tr>
		<td align="right" class="blackbold" width="15%">Search Term 2:</td>
		<td align="left"><input name="Keywords[]" type="text" class="inputbox"
			id="Keywords" value="<?php if(isset($Keywords[1])) echo $Keywords[1]; ?>"  />
		</td>
	</tr>
	<tr>
		<td align="right" class="blackbold" width="15%">Search Term 3:</td>
		<td align="left"><input name="Keywords[]" type="text" class="inputbox"
			id="Keywords" value="<?php if(isset($Keywords[2])) echo $Keywords[2]; ?>"  />
		</td>
	</tr>
	<tr>
		<td align="right" class="blackbold" width="15%">Search Term 4:</td>
		<td align="left"><input name="Keywords[]" type="text" class="inputbox"
			id="Keywords" value="<?php if(isset($Keywords[3])) echo $Keywords[3]; ?>"  />
		</td>
	</tr>
<!-- Keywords  Start-->
	<tr>
		<td align="right" class="blackbold"></td>
		<td align="left"><input class="button" type="submit" name="submitAmazon" style="display:<?=(!empty($_GET['quickAmazon'])) ? 'none;' : '';?>"
			value="AddItem" tittle="AddItem"></td>

	</tr>
	<tr>
		<td align="right" class="blackbold"></td>
		<td align="left"></td>

	</tr>

</table>



		<?php
		if(isset($_POST['submitAmazon']))
		{ 	CleanPost($_POST);
			
			$Name       = $_POST['Name'];
			$ProductSku      = $_POST['ProductSku'];
			$ProductType 	 = $_POST['ProductType'];
			$ProductCode     = $_POST['ProductCode'];
			$Quantity        = $_POST['Quantity'];
			$Price 			 = $_POST['Price'];
			$ItemCondition   = $_POST['ItemCondition'];
			$ShortDetail     = $_POST['ShortDetail'];
			if($_POST['SaleStartDate']<=0 || empty($_POST['SaleStartDate'])){
				$_POST['LaunchDate'] = $_POST['SaleStartDate'] = date('Y-m-d');
			}
			$LaunchDate      = date('Y-m-d',strtotime($_POST['LaunchDate'])).'T'.'00:01:00';//date(DATE_FORMAT);//$_POST['LaunchDate'];
			$SaleStartDate   = date('Y-m-d',strtotime($_POST['SaleStartDate'])).'T'.'00:01:00';//$_POST['SaleStartDate'];
			$SaleEndDate     = ($_POST['SaleEndDate']>0) ? date('Y-m-d',strtotime($_POST['SaleEndDate'])).'T'.'00:01:00' : '';//$_POST['SaleEndDate'];
			$Price2          = $_POST['Price2'];
			$RestockDate      = $_POST['RestockDate'];
			$GiftMessage     = ($_POST['GiftMessage']) ? 'true' : 'false';
			$GiftWrap        = ($_POST['GiftWrap']) ? 'true' : 'false';
			$Brand 			 = $_POST['Brand'];
			$Manufacturer    = $_POST['Mid'];
			$MfrPartNumber   = $_POST['MfrPartNumber'];
			$Cat 			 = $_POST['Cat'];
			$TaxCode		 = $_POST['TaxCode'];
			$ProductTypeName = $_POST['ProductTypeName'];
			$ItemConditionNote=$_POST['ItemConditionNote'];
			$Features = $_POST['Features'];
			$Keywords = $_POST['Keywords'];
			$_POST['AliasID'] = ((int)$_GET['AliasID']>0)?(int)$_GET['AliasID']:0;
			$FeaturesXML = '';
			foreach ($Features as $Feature){
				if(!empty($Feature)) $FeaturesXML .= '<BulletPoint>'.$Feature.'</BulletPoint>';
			}
			$KeywordsXML = '';
			foreach ($Keywords as $Keyword){
				if(!empty($Keyword)) $KeywordsXML .= '<SearchTerms>'.$Keyword.'</SearchTerms>';
			}
			
			if(!empty($Brand)) '<Brand>'.$Brand.'</Brand>';
			
			/*********** Validations *****************/
			$vS = true;
			if(empty($ProductCode)) { $emptyName = 'Product Code'; $vS = false;  }
			if(empty($LaunchDate)) { $emptyName = 'Launch Date'; $vS = false;  }
			if(empty($ProductTypeName)) { $emptyName = 'Product Type '; $vS = false;  }
			if(!$vS) { echo $emptyName.' mandatory field(s) are missing. Please try again!'; exit;} 
			/*********** Validations End *****************/
			
			
			//[USD, GBP, EUR, JPY, CAD, CNY, INR, AUD, BRL, MXN, DEFAULT];
			$submitType = '_POST_PRODUCT_DATA_';

						
$Amazonservice = $objProduct->AmazonSettings($Prefix,true,$_POST['AmazonAccountID']);
 		
$feed = '<?xml version="1.0" encoding="iso-8859-1"?>
<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
<Header>
<DocumentVersion>1.01</DocumentVersion>
<MerchantIdentifier>'.$objProduct->MERCHANT_ID.'</MerchantIdentifier>
</Header>
<MessageType>Product</MessageType>
<PurgeAndReplace>false</PurgeAndReplace>
<Message>
	<MessageID>1</MessageID>
	<OperationType>Update</OperationType>
	<Product>
		<SKU>'.$ProductSku.'</SKU>
		<StandardProductID>
			<Type>'.$ProductType.'</Type>
			<Value>'.$ProductCode.'</Value>
		</StandardProductID>
		<ProductTaxCode>'.$TaxCode.'</ProductTaxCode>
		<LaunchDate>'.$LaunchDate.'</LaunchDate>
		            <Condition>
		                <ConditionType>'.$ItemCondition.'</ConditionType>
					 	<ConditionNote>'.$ItemConditionNote.'</ConditionNote>
		            </Condition>
		<DescriptionData>
			<Title>'.$Name.'</Title>
    		<Brand>'.$Brand.'</Brand>
			<Description>'.$ShortDetail.'</Description>
			'.$FeaturesXML.'
			<MSRP currency="USD">'.$Price.'</MSRP>
			<Manufacturer>'.$Manufacturer.'</Manufacturer>
			<MfrPartNumber>'.$MfrPartNumber.'</MfrPartNumber>
		    '.$KeywordsXML.'
    		<ItemType>'.$ProductTypeName.'</ItemType>
			<IsGiftWrapAvailable>'.$GiftWrap.'</IsGiftWrapAvailable>
			<IsGiftMessageAvailable>'.$GiftMessage.'</IsGiftMessageAvailable>
		</DescriptionData>
	</Product>
	</Message>
</AmazonEnvelope>';

//pr($feed,1); 
// after manufaturepart 
//<RecommendedBrowseNode>60583031</RecommendedBrowseNode>

$objProduct->CreateAmazonProduct($feed, $Amazonservice, '_POST_PRODUCT_DATA_','add');
//pr($_POST);
//$objProduct->saveAmazonData($_POST);

if(isset($_POST['FeedProcessingStatus']) && !($_POST['FeedProcessingStatus']=='_FAILED_' || $_POST['FeedProcessingStatus']=='Error')){
	$post_data = array();
	$post_data[] = urlencode('CmpID') . '=' . urlencode($_SESSION['CmpID']);
	$post_data[] = urlencode('AdminID') . '=' . urlencode($_SESSION['AdminID']);
	$post_data[] = urlencode('AdminType') . '=' . urlencode($_SESSION['AdminType']);
	$post_data[] = urlencode('ProductID') . '=' . urlencode($_POST['itemID']);
	/*foreach ($_POST as $k => $v)
	   {
		   $post_data[] = urlencode($k) . '=' . urlencode($v);
	   }*/
	$post_data = implode('&', $post_data);///opt/lampp/htdocs/
	//pr($post_data,1);
	$pid = exec('php /var/www/html/erp/cron/AmazonProductUpdate.php "'.$post_data.'" > /dev/null & echo $!;', $output, $return);
	
	if (!$return) {
		$ErrorMsg = "Process is running";
	} else {
		$ErrorMsg = "Failed! Please try again.";
	} 
}

 $EditUrl = "editProduct.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&CatID=".$categoryIdGetPost."&tab=";
 $EditUrl= $EditUrl.$_GET["tab"];
 
 if(!empty($_GET['AliasID'])) $EditUrl = $EditUrl."&AliasID=".$_GET['AliasID'];
 
 header("Location:".$EditUrl);
}


		?>
