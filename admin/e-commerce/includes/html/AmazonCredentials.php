<?php $marketlists = $objProduct->getAmazonMarketList();
$marketurl = array();
foreach ($marketlists as $marketlist){
	$marketurl[$marketlist['id']] = $marketlist['url'];	
}

$developerEurope = 'Virtualstacks';
$AccountEurope = '3650-6131-9130';
$developerAmerica = 'Virtualstacks LLC';
$AccountAmerica = '8053-9081-8811';

if(!empty($_GET['edit']) && $arryAmazons[0]['group_title']=='Europe'){
	$DID = $developerEurope;
	$AID = $AccountEurope;
}else{
	$DID = $developerAmerica;
	$AID = $AccountAmerica;
}

?>
<script language="JavaScript1.2" type="text/javascript">
$( document ).ready(function() {
	$("#market_id").change(function(){
		if($( this ).val()!=''){
			$(".account_details").show();
			var marketurl = <?=json_encode($marketurl) ?>;
			var Aurl = 'https://sellercentral.'+ marketurl[$( this ).val()] +'/gp/mws/registration/register.html?ie=UTF8&*Version*=1&*entries*=0';
			$("#amazonurl").attr('href',Aurl);

			if($( this ).val()=='25' || $( this ).val()=='26' || $( this ).val()=='28' || $( this ).val()=='30' || $( this ).val()=='31'){
				$("#developerID").text('<?=$developerEurope?>');
				$("#accountID").text('<?=$AccountEurope?>');
			}else{
				$("#developerID").text('<?=$developerAmerica?>');
				$("#accountID").text('<?=$AccountAmerica?>');
			}
			
		}else{
			$(".account_details").hide();
		}
	});

	$("#sync_orders").change(function(){
		if($( this ).val() =='1'){
			$("#syncDate").show();
		}else{
			$("#syncDate").hide();
		}
	});

	$("#sync_product").change(function(){
		if($( this ).val() =='1'){
			$(".sync_product").show();
		}else{
			$(".sync_product").hide();
		}
	});

	$('#from_date,#to_date').datepicker(
			{
			showOn: "both",
			dateFormat: 'yy-mm-dd',  
			changeMonth: true,
			changeYear: true
	
			}
		);
});

function validateAccount(frm){
	if( ValidateForSimpleBlank(frm.title, "Title")
		&& ValidateForSimpleBlank(frm.market_id, "Amazon Marketplace")
		&& ValidateForSimpleBlank(frm.merchant_id, "Merchant ID")
		&& ValidateForSimpleBlank(frm.marketplace_id, "Marketplace ID")
		&& ValidateForSimpleBlank(frm.mws_auth_token, "MWS Auth Token")
	  ){
		  
	}else{
		return false;	
	}
}

</script>
<div class="had">   Amazon Settings &raquo; Amazon Accounts 
<?php if(!empty($_GET['edit'])) {?><a href="AmazonCredentials.php" class="back">Back</a> <?php }?>
</div>
<?php if(empty($_GET['edit'])) {  ?>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
<?php if (!empty($_SESSION['amazon_Update'])) { ?>
  <tr>
    <td height="2" align="center"  class="red" ><? if (!empty($_SESSION['amazon_Update'])) { echo stripslashes($_SESSION['amazon_Update']);unset($_SESSION['amazon_Update']); } ?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">
                                                    <tr>
                                                        <td colspan="2">
                                                            <table width="100%" cellspacing="1" cellpadding="3" align="center" id="list_table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="head1">Account</td>
                                                                        <td class="head1">Site</td>
                                                                        <td class="head1">Markets</td>
                                                                        <td class="head1" align="center" width="10%">Default</td>
                                                                        <td class="head1" align="center" width="10%">Status</td>
                                                                        <td class="head1">Action</td>
                                                                    </tr>
    <?php if (count($arryAmazons) > 0) {
        foreach ($arryAmazons as $arryAmazon) {
            ?>
                                                                            <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                                <td><?= $arryAmazon['title']; ?></td>
                                                                                <td><?= $arryAmazon['code']; ?></td>
                                                                                <td><?= $arryAmazon['group_title']; ?></td>
                                                                                <td align="center">
                                                                                <?php if($arryAmazon['set_default']){?>
                                                                                <a href="<?=$ListUrl?>?default_id=<? echo $arryAmazon['id']; ?>&status=0&sync_product=<?=$arryAmazon['sync_product']?>" class="Active">Yes</a>
                                                                                <?php }else{?>
                                                                                <a href="<?=$ListUrl?>?default_id=<? echo $arryAmazon['id']; ?>&status=1&sync_product=<?=$arryAmazon['sync_product']?>" class="InActive" style="padding: 1px 11px;">No</a>
                                                                                <?php }?>
                                                                                </td>
                                                                                <td align="center">
                                                                                <?php if($arryAmazon['active']){?>
                                                                                <a href="<?=$ListUrl?>?active_id=<? echo $arryAmazon['id']; ?>&status=0" class="Active">Active</a>
                                                                                <?php }else{?>
                                                                                <a href="<?=$ListUrl?>?active_id=<? echo $arryAmazon['id']; ?>&status=1" class="InActive">InActive</a>
                                                                                <?php }?>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="<?=$ListUrl?>?edit=<? echo $arryAmazon['id']; ?>"><?= $edit ?></a>  
                                                                                    
                                                                                    </td>
                                                                            </tr>
            <?php
        }
    } else {
        ?>
                                                                        <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                            <td class="no_record" colspan="6">No Account Added.</td>

                                                                        </tr>
    <?php } ?>
                                                                </tbody>
                                                            </table> 
                                                        </td>
                                                    </tr>
	
     </td>
    </tr>
</table>

<br/><br/>
<?php }

$display = $displayOldDate = $display1 = 'display:none';
if(!empty($_GET['edit'])) {
	$editData = $arryAmazons[0];
	$display = "";
	if($editData['sync_orders']) $displayOldDate = '';
	if($editData['sync_product']) $display1 = '';
}else{
	$arryAmazons = $objConfigure->GetDefaultArrayValue('amazon_accounts');
	$editData = $arryAmazons[0];
}
 
?>
<form name="form1" action=""  method="post" onSubmit="return validateAccount(this);" >
<table width="60%"  border="0" align="left" cellpadding="0" cellspacing="0" class="borderall">
<input name="acc_id" type="hidden" value="<?=$editData['id']?>" />
	<tr>
		 <td colspan="4" align="left" class="head">Add Amazon Account</td>
	</tr>
	
	<tr>
        <td  align="left"   class="blackbold" width="20%">Title:<span class="red">*</span> </td>
        <td   align="left" width="40%">
			<input name="title" type="text" class="inputbox" id="title" value="<?=$editData['title']?>" />            
		</td>
    </tr>
    
    <tr>
        <td  align="left"   class="blackbold" width="20%">Amazon Marketplace:<span class="red">*</span> </td>
        <td   align="left" width="40%">
			<select class=" inputbox select" title="Site" name="market_id" id="market_id">
					<option value="">-- Please select --</option>
					 <?php 
			        	foreach($marketlists as $marketlist){
			        ?>
					<option <?php if($editData['market_id']==$marketlist['id']){echo "selected";} ?> value="<?=$marketlist['id']?>" <?php if(!$marketlist['enabled']) {echo 'disabled="disabled"';}?>><?=$marketlist['title']?></option>					
					<?php }?>				
			</select>            
		</td>
    </tr>
    
    <tr style="<?=$display?>" class="account_details">
        <td  align="left"   class="blackbold" colspan="2">
        	<p style="padding-left:0.2em;">
					In order to add a new Amazon account to E-Commerce you need to:
					</p>
					<!--<ol>
						<li> 1. Click on "Sign in with Amazon" and sign into your account.</li>
						<li> 2. Select "I want to access my own Amazon seller account with MWS."</li>
						<li> 3. Accept the Amazon MWS License Agreement.</li>
						<li> 4. Copy the generated Merchant ID, Marketplace ID, AWS Access Key ID, and Secret Key and paste it in the corresponding fields below.</li>
						<li> 5. Click "Add new account" to add the new account to E-Commerce.</li>
					</ol>
					--><ol>
						<li> 1. Click on "Sign in with Amazon" and sign into your account.</li>
						<li> 2. Select the 3rd option: "I want to give a developer access to my Amazon seller account with MWS".</li>
						<li> 3. Enter the Developer Name: <b id="developerID"><?=$DID?></b> and Developer Account Number: <b id="accountID"><?=$AID?></b></li>
						<li> 4. Click Submit and copy the Seller ID, Marketplace ID and the MWS Auth Token and enter them in the above fields.</li>
						<li> 5. Click "Add new account" to add the new account to E-Commerce.</li>
					</ol>
				
				<p></p>
        </td>
    </tr>
    <tr style="<?=$display?>" class="account_details">
        <td  align="left"   class="blackbold" width="20%">Seller ID:<span class="red">*</span> </td>
        <td   align="left" width="40%">
			<input name="merchant_id" type="text" class="inputbox" id="merchant_id" value="<?=$editData['merchant_id']?>" />            
		</td>
    </tr>
    <tr style="<?=$display?>" class="account_details">
        <td  align="left"   class="blackbold" width="20%">Marketplace ID:<span class="red">*</span> </td>
        <td   align="left" width="40%">
			<input name="marketplace_id" type="text" class="inputbox" id="marketplace_id" value="<?=$editData['marketplace_id']?>" />            
		</td>
    </tr>
    <tr style="<?=$display?>" class="account_details">
        <td  align="left"   class="blackbold" width="20%">MWS Auth Token:<span class="red">*</span> </td>
        <td   align="left" width="40%">
			<input name="mws_auth_token" type="text" class="inputbox" id="mws_auth_token" value="<?=$editData['mws_auth_token']?>" />            
		</td>
    </tr>
    <tr style="<?=$display?>" class="account_details">
        <td  align="left"   class="blackbold" width="20%">Sync Oders: </td>
        <td   align="left" width="40%">
			<select class=" inputbox select" title="sync_orders" name="sync_orders" id="sync_orders">
					<option value="0" <?php if($editData['sync_orders']==0) echo "selected";?> >New Orders Only</option>
					<option value="1" <?php if(isset($editData['sync_orders']) && $editData['sync_orders']==1) echo "selected";?>>All Orders</option> 			
			</select> 
			<span id="syncDate" style="<?=$displayOldDate?>"> From: <input id="from_date" name="from_date" class="datebox" readonly=""  value="<?=($editData['from_date']>0) ? date('Y-m-d', strtotime($editData['from_date'])):''?>" type="text"></span>             
		</td>
    </tr>
    <tr style="<?=$display?>" class="account_details">
        <td  align="left"   class="blackbold" width="20%">Status: </td>
        <td   align="left" width="40%">
			<select class=" inputbox select" title="active" name="active" id="active">
					<option value="1" <?php if($editData['active']==1) echo "selected";?> >Active</option>
					<option value="0" <?php if(isset($editData['active']) && $editData['active']==0) echo "selected";?>>Inactive</option> 			
			</select>              
		</td>
    </tr>

	<!-- sync product -->
	<tr style="<?=$display?>" class="account_details">
        <td  align="left" colspan="2"  class="blackbold" width=""> <b>Sync Products: </b> <br> (Set defaults for product addition as a batch or direct submit)</td>
        
    </tr>   
    <tr style="<?=$display?>" class="account_details">
    <td  align="left"   class="blackbold" width="20%"> </td>
        <td   align="left" width="40%">
        	<a href="#cancelOrder" class="fancybox"> Mapped amazon fields</a>            
		</td>
    </tr>   
    <tr style="<?=$display?>" class="account_details">
        <td  align="left"   class="blackbold" width="20%">List item under condition in the category with the lowest price? </td>
        <td   align="left" width="40%">
        	 <select class=" inputbox select" title="sync_product" name=sync_product id="sync_product">
					<option value="0" <?php if(isset($editData['sync_product']) && $editData['sync_product']==0) echo "selected";?>>No</option> 			
					<option value="1" <?php if($editData['sync_product']==1) echo "selected";?> >Yes</option>
			</select>            
		</td>
    </tr>    
    <tr style="<?=$display1?>" class="sync_product">
        <td  align="left"   class="blackbold" width="20%">Set Description: </td>
        <td   align="left" width="40%">
        	 <select class=" inputbox select" title="active" name="set_desc" id="set_desc">
					<option value="0" <?php if($editData['set_desc']=='0') echo "selected";?> >Amazon Defined</option>
					<option value="1" <?php if($editData['set_desc']=='1') echo "selected";?> >Your Own</option>
			</select>            
		</td>
    </tr>  
    <tr style="<?=$display1?>" class="sync_product">
        <td  align="left"   class="blackbold" width="20%">Category: </td>
        <td   align="left" width="40%">
        	 <select class=" inputbox select" title="Default_cat" name="Default_cat" id="Default_cat">
					
					<?php foreach (AmazonCategories() as $value){?>
					<option value="<?=$value?>" <?php if($editData['Default_cat']==$value) echo "selected";?> ><?=$value?></option>
					<?php }?>
			</select>            
		</td>
    </tr>
	<tr style="<?=$display1?>" class="sync_product">
	<td align="left" class="blackbold" width="15%">Fulfilled By:</td>
	 <td   align="left" width="40%">
	<select class="inputbox" id="fulfilled_by" name="fulfilled_by" title="Fulfilled By" required="">
			<option value="DEFAULT" <?=($editData['fulfilled_by']=='DEFAULT') ? 'selected' : ''?>>Merchant</option>
			<option value="AMAZON_NA" <?=($editData['fulfilled_by']=='AMAZON_NA') ? 'selected' : ''?>>Amazon</option>
		</select>
	</td>
	</tr>   
	<tr style="<?=$display1?>" class="sync_product">
	<td align="left" class="blackbold" width="15%">Condition:</td>
	 <td   align="left" width="40%">
			<select class="inputbox" id="set_condition" name="set_condition" title="set condition" required="">
				<option value="New" <?=($editData['set_condition']=='New') ? 'selected' : ''?>>New</option>
			<option value="Used; Like_new" <?=($editData['set_condition']=='Used; Like_new') ? 'selected' : ''?>>Used - Like New</option>
			<option value="Used; Very_good" <?=($editData['set_condition']=='Used; Very_good') ? 'selected' : ''?>>Used - Very Good</option>
			<option value="Used; Good" <?=($editData['set_condition']=='Used; Good') ? 'selected' : ''?>>Used - Good</option>
			<option value="Used; Acceptable" <?=($editData['set_condition']=='Used; Acceptable') ? 'selected' : ''?>>Used - Acceptable</option>
			<option value="Collectible, Like_new" <?=($editData['set_condition']=='Collectible, Like_new') ? 'selected' : ''?>>Collectible - Like New</option>
			<option value="Collectible, Very_good" <?=($editData['set_condition']=='Collectible, Very_good') ? 'selected' : ''?>>Collectible - Very Good</option>
			<option value="Collectible, Good" <?=($editData['set_condition']=='Collectible, Good') ? 'selected' : ''?>>Collectible - Good</option>
			<option value="Collectible, Acceptable" <?=($editData['set_condition']=='Collectible, Acceptable') ? 'selected' : ''?>>Collectible - Acceptable</option>
			<option value="Refurbished, Refurbished" <?=($editData['set_condition']=='Refurbished, Refurbished') ? 'selected' : ''?>>Refurbished</option>
			</select>            
		</td>
	</td>
	</tr>   
	<tr style="<?=$display1?>" class="sync_product">
	<td align="left" class="blackbold" width="15%">Condition Note:</td>
	 <td   align="left" width="40%">
			<input name="condition_note" type="text" class="inputbox" id="condition_note" value="<?=$editData['condition_note']?>" />            
		</td>
	</td>
	</tr>  
	<tr style="<?=$display1?>" class="sync_product">
	<td align="left" class="blackbold" width="15%">Prefill Brand same as Product Manufacture ?:</td>
	 <td   align="left" width="40%">
			 <select class=" inputbox select" title="brand" name=brand id="sync_product">
					<option value="1" <?php if($editData['brand']==1) echo "selected";?> >Yes</option>
					<option value="0" <?php if(isset($editData['brand']) && $editData['brand']==0) echo "selected";?>>No</option> 			
			</select>                 
		</td>
	</td>
	</tr>   
    <!--
    <tr style="<?=$displayOldDate?>" class="account_details" id="syncDate">
     	<td  align="left"   class="blackbold" width="20%"> </td>
        <td   align="left"" width="40%" colspan="2">
			From:</span> <input id="from_date" name="from_date" class="datebox" readonly=""  value="<?=($editData['from_date']>0) ? date('Y-m-d', strtotime($editData['from_date'])):''?>" type="text">
			<div style="display: inline-block;"><span style="display: block;">To:</span> <input id="to_date" name="to_date" class="datebox" readonly=""  value="<?=(isset($editData['to_date'])) ? date('Y-m-d', strtotime($editData['to_date'])):''?>" type="text"></div>            
		</td>
    </tr>
    <tr style="display:none" class="account_details">
        <td  align="left"   class="blackbold" width="20%">AWS Access Key ID:<span class="red">*</span> </td>
        <td   align="left" width="40%">
			<input name="access_key_id" type="text" class="inputbox" id="access_key_id" value="" />            
		</td>
    </tr>
    <tr style="display:none" class="account_details">
        <td  align="left"   class="blackbold" width="20%">Secret Key:<span class="red">*</span> </td>
        <td   align="left" width="40%">
			<input name="secret_key" type="text" class="inputbox" id="secret_key" value="" />            
		</td>
    </tr>
    
    --><tr style="<?=$display?>" class="account_details">
        <td  align="left"   class="blackbold" width="20%">
        	<a style="color: white;font-weight: bold;font-size: 13px;padding: 5px;"href="https://sellercentral.amazon.com/gp/mws/registration/register.html?ie=UTF8&*Version*=1&*entries*=0" target="_black" class="button" id="amazonurl">Sign in with Amazon</a> 
        </td>
        <?php if(!empty($_GET['edit'])) { ?>
         <td   align="right"" width="40%">
			<input name="update_account" type="submit" class="button" id="save_account" value="Update Account" /> 
		</td>
		<?php }else{?>
        <td   align="right"" width="40%">
			<input name="save_account" type="submit" class="button" id="save_account" value="Add New Account" /> 
		</td>
    <?php }?>
    </tr>
</table>
</form>

<div style="display:none">
	<div id="cancelOrder">
		<form name="form2" action=""  method="post" onSubmit="return validateOrderStatus(this);" >
		<table width="100%" align="center" cellpadding="3" cellspacing="1" id="list_table">
			<tr>
				 <td  align="left" class="head">Amazon fields.</td>
				  <td  align="left" class="head">ERP e-Commerce fields.</td>
			</tr>
		     
		    <tr>
		        <td align="left">Title</td>
		        <td align="left">Product Name (Primary properties)</td>
		    </tr>
		    <tr>
		        <td align="left">SKU</td>
		        <td align="left">Product Sku (Primary properties)</td>
		    </tr>
		    <tr>
		        <td align="left">Standard Price</td>
		        <td align="left">Price (Primary properties)</td>
		    </tr>
		    <tr>
		        <td align="left">Sale Price</td>
		        <td align="left">Sale Price (Primary properties)</td>
		    </tr>
		    <tr>
		        <td align="left">Quantity</td>
		        <td align="left">Number of items in inventory (inventory)</td>
		    </tr>
		    <tr>
		        <td align="left">Manufacturer Name</td>
		        <td align="left">Product Manufacturer (Other properties)</td>
		    </tr>
		     <tr>
		        <td align="left">Manufacturer Part No.</td>
		        <td align="left">Product Sku (Primary properties)</td>
		    </tr>
		     <tr>
		        <td align="left">Brand</td>
		        <td align="left">Product Manufacturer (Other properties)</td>
		    </tr>
		    <tr>
		        <td align="left">Description</td>
		        <td align="left">Product Name (Primary properties)</td>
		    </tr>
		    <tr>
		        <td align="left">Main Image</td>
		        <td align="left">Product Image (basic properties)</td>
		    </tr>
		    <tr>
		        <td align="left">Alternative Images(Image2,Image3,Image4...12)</td>
		        <td align="left">Alternative Images (Alternative Images)</td>
		    </tr>
		    
		       
		    </tr>
		</table>
		</form>
	</div>
</div>
<?php
function AmazonCategories(){
return $usCat = array(
'All',
'Apparel',
'Appliances',
'ArtsAndCrafts',
'Automotive',
'Baby',
'Beauty',
'Books',
'Classical',
'DigitalMusic',
'DVD',
'Electronics',
'Grocery',
'HealthPersonalCare',
'HomeGarden',
'Industrial',
'Jewelry',
'KindleStore',
'Kitchen',
'Magazines',
'Miscellaneous',
'MobileApps',
'MP3Downloads',
'Music',
'MusicalInstruments',
'OfficeProducts',
'PCHardware',
'PetSupplies',
'Photo',
'Shoes',
'Software',
'SportingGoods',
'Tools',
'Toys',
'UnboxVideo',
'VHS',
'Video',
'VideoGames',
'Watches',
'Wireless',
'WirelessAccessories'); } ?>

