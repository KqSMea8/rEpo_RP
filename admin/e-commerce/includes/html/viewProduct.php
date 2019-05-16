<div class="had">   Manage Products <?= $MainParentCategory ?>  <span><?= $ParentCategory ?></span></div>
<div class="message"><? if (!empty($_SESSION['mess_product'])) {    echo $_SESSION['mess_product'];    unset($_SESSION['mess_product']);} ?></div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>

                    <?php if($_SESSION['MarketPlace']==1){?>
                   <td width="40%">
                   <?php $url = $_SERVER["SCRIPT_NAME"];
						 $break = Explode('/', $url);
						 $file = $break[count($break) - 1];
						 $a = $b = $c = 'background-color: #FBBC2F !important;';
						 if($file=='viewProduct.php'){
						 	$a = '';
						 }elseif($file=='AmazonEditProduct.php'){
						 	$b = '';
						 }elseif($file=='EbayEditProduct.php'){
						 	$c = '';
						 }
						 
                   ?>
						<a style="<?=$a?>width: 55px;font-weight: bold;padding: 5px 10px;" class="Active" href="viewProduct.php" >All Listing</a>
						<a style="<?=$b?>width: 55px;font-weight: bold;padding: 5px 10px;" class="Active" href="AmazonEditProduct.php?tab=ActiveItems" >Amazon</a>
						<a style="<?=$c?>width: 55px;font-weight: bold;padding: 5px 10px;" class="Active" href="EbayEditProduct.php" > Ebay </a>
					</td>
					<?php }?>

                    <td align="right"> 
					<?php  if (is_array($arryProduct) && $num > 0) {?>
					<input type="button" class="export_button" style="float: right;"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_product.php?<?=$QueryString?>';" />
					<?php }?>
					<a class="fancybox add_quick fancybox.iframe" href="addProd.php">Quick Entry</a>
					<a href="editProduct.php?curP=<?= $_GET['curP'] ?>&tab=basic" class="add">Add Product</a>
					 <? if($_GET['search']!='') {?>
						<a href="viewProduct.php" class="grey_bt">View All</a>
						<? }?>
					<?php if( $_SESSION['sync_items']=='E2I' ||$_SESSION['sync_items']=='both' ){?>
				<input type="button" class="sync_button" name="sync_items"
					value="Sync Item" onclick="Javascript:selectitems();" /> <?php }?>

					<?php if($_SESSION['MarketPlace']==1){?>
					<a href="#cancelOrder" class="fancybox sync_button add" id="AmazonBatch"> Amazon </a>
					<a href="#ebaySyncProduct" class="fancybox sync_button add" id="EbayBatch"> Ebay </a>
					<?php }?>

					</td>

                </tr>

            </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td id="ProductsListing">
            <form action="" method="post" name="form1" id="form1">
                <table <?= $table_bg ?>>
                    <tr align="left">
                        <td width="5%" class="head1" align="center">
                        <input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ProductID','<?= sizeof($arryProduct) ?>');" /></td>
                        <td width="10%" class="head1" align="center">Image</td>
                        <td   class="head1" >Product Name</td>
			<td width="12%" class="head1" align="center">Listing </td>
                        <td width="10%"  class="head1" align="center">Product Sku</td>
                        <td class="head1" width="8%" align="center">Price</td>
                        <td width="5%" class="head1" align="center">Stock </td>
                        <td width="5%" class="head1" align="center">Featured</td>
                        <td width="8%"  class="head1"align="center">Status</td>
                        <td width="10%"  align="center" class="head1 head1_action">Action</td>
                    </tr>

                    <?php



                    if (is_array($arryProduct) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryProduct as $key => $values) {
                            $flag = !$flag;
                            //$bgcolor=($flag)?(""):("#F3F3F3");
                            $Line++;

                            //if($values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <td align="center"><input type="checkbox" name="ProductID[]" id="ProductID<?= $Line ?>" value="<?= $values['ProductID']; ?>"></td>
                                <td align="center">  

				<? 
 
//if(!empty($values['Image']) && IsFileExist($Config['Products'],$values['Image'])){ 
	$PreviewArray['Folder'] = $Config['Products'];
	$PreviewArray['FileName'] = $values['Image']; 
	$PreviewArray['FileTitle'] = stripslashes($values['ProductSku']);
	$PreviewArray['NoImage'] = $Prefix."images/no.jpg";
	$PreviewArray['Width'] = "80";
	$PreviewArray['Height'] = "80";
	$PreviewArray['Link'] = "1";
	echo '<div id="ImageDiv">'.PreviewImage($PreviewArray).'</div>';
//}

?>
                                     <? 
 
 					$Ecolor = $Acolor = '#B0B0B0 !important';
					$onclick = $amazonUrl =  $Eonclick = $ebayUrl =  '';
                                if($values["AmazonFeedProcessingStatus"]=='Active'){ 
                                	$Acolor = '#81bd82 !important';
                                	$amazonUrl = "#";
                                }elseif(!empty($values["AmazonFeedProcessingStatus"])){ 
                                	$amazonUrl = "editProduct.php?edit=".$values["ProductID"]."&curP=".$_GET["curP"]."&tab=SendAmazon";
                                }else{
									$onclick = "return confSubmit('item on amazon')";
                                	$amazonUrl = "viewProduct.php?id=".$values["ProductID"]."&curP=".$_GET["curP"]."&marketplace=inlineAmazon";
                                }

								if($values["EbayFeedProcessingStatus"]=='Active'){
                                	$Ecolor = '#81bd82 !important';
                                	$ebayUrl = "#";
                                }elseif(!empty($values["EbayFeedProcessingStatus"])){
                                	$ebayUrl = "editProduct.php?edit=".$values["ProductID"]."&curP=".$_GET["curP"]."&tab=SendEbay";
                                }else{
                                	$Eonclick = "return confSubmit('item on ebay')";
                                	$ebayUrl = "viewProduct.php?id=".$values["ProductID"]."&curP=".$_GET["curP"]."&marketplace=inlineEbay";
                                }
									?>
                                </td>
                                <td><?=stripslashes($values['Name']); ?></td>
								<td align="center">
                                    <a href="<?=$amazonUrl?>" class="Active" style="background:<?=$Acolor?>;width: 55px;padding: 2px 5px;" onclick="<?=$onclick?>">amazon</a>&nbsp;&nbsp;
                                    <a href="<?=$ebayUrl?>" class="Active" style="background:<?=$Ecolor?>;width: 55px;padding: 2px 5px;" onclick="<?=$Eonclick?>">ebay</a> 
                                </td>
                                <td align="center"><?=stripslashes($values['ProductSku']); ?></td>
                                <td align="center"><?= number_format($values['Price'],2);?></td>
                                <td align="center">
                                   <?php if ($values['Quantity'] > 0) { ?>
                                    <?=$values['Quantity'];?>
                                    <?php }else{?>
                                     -
                                    <?php }  ?></td>
                                 <td align="center">
                                    <?
                                    if($values['Featured'] == "Yes")
                                    {$featured = "Yes"; $status = 'Active';}else{$featured = "No"; $status = 'InActive';}
                                    echo '<a href="editProduct.php?featured_id=' . $values["ProductID"] . '&curP=' . $_GET["curP"] . '&CatID=' . $values["CategoryID"]. '" class='.$status.'  alt="Click to Change Featured Status" title="Click to Change Featured Status">' .$featured. '</a>';
                                    ?>


                                </td>
                                  <td align="center"><?
                                    if ($values['Status'] == 1) {
                                        $status = 'Active';
                                    } else {
                                        $status = 'InActive';
                                    }

                               

                                    echo '<a href="editProduct.php?active_id=' . $values["ProductID"] . '&curP=' . $_GET["curP"] . '&CatID=' .  $values["CategoryID"] . '" class="'.$status.' alt="Click to Change Status" title="Click to Change Status">' . $status . '</a>';
                                    ?></td>
                                <td  align="center" class="head1_inner" >
                                      <a href="vProduct.php?view=<?=$values['ProductID']?>&curP=<?=$_GET['curP']?>&CatID=<?=  $values["CategoryID"] ?>&tab=basic" ><?=$view?></a>
                                    <a href="editProduct.php?edit=<? echo $values['ProductID']; ?>&curP=<?php echo $_GET['curP']; ?>&CatID=<?= $values["CategoryID"] ?>&tab=basic"><?= $edit ?></a>  <a href="editProduct.php?del_id=<? echo $values['ProductID']; ?>&CategoryID=<?php echo $values['CategoryID']; ?>&curP=<?php echo $_GET['curP']; ?>&MemberID=<?= $_GET['MemberID'] ?>&CatID=<?=  $values["CategoryID"] ?>" onClick="return confDel('Product')"  ><?= $delete ?></a>	</td>
                            </tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="10" class="no_record">No products found.</td>
                        </tr>

                    <?php }


if(!empty($_GET['pk3'])) die;

 ?>



                    <tr >  <td  colspan="10" >Total Product(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryProduct) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>

                <? if (sizeof($arryProduct)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0">
                        <tr align="center" > 
                            <td height="30" align="left">
                                <input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('product','delete','<?= $Line ?>','ProductID','editProduct.php?curP=<?= $_GET['curP'] ?>&dCatID=<?=$_GET['CatID']?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('product','active','<?= $Line ?>','ProductID','editProduct.php?curP=<?= $_GET['curP'] ?>&dCatID=<?=$_GET['CatID']?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('product','inactive','<?= $Line ?>','ProductID','editProduct.php?curP=<?= $_GET['curP'] ?>&dCatID=<?=$_GET['CatID']?>');" />
                            </td>
                        </tr>
                    </table>
                <? } ?>

                

<div style="display:none;">
    <div id="dialogContent">
    	<input type="radio" name="synctype" value="one" checked="checked" onclick="chosevalue(this.value); ">sycn this page items
    	<input type="radio" name="synctype" value="all" onclick="chosevalue(this.value);" >sync all item
    	
    </div>
</div>
<input type="hidden" name="synctypeselected" id="synctypeselected" value=""  >
            </form>
        </td>
    </tr>
</table>


<div style="display:none">
	<div id="cancelOrder">
	<form name="form2" id="form2" action=""  method="post" onSubmit="return validateAmazonProduct(this);" >
		<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="borderall">
			<tr>
		<td colspan="2" align="left" class="head">Amazon Basic</td>
	</tr>
	<tr>
		<td align="left" class="blackbold" width="25%">Account Name:<span class="red">*</span></td>
		<td align="left"><select class="inputbox" id="amazonAccountID" name="AmazonAccountID"  >
		    <option value="" >-- Select Account --</option>
 		<?php $amazonAccounts = $objProduct->getAccountAll();
 		if(!empty($amazonAccounts)){
		
		$AmazonAccountID = (!empty($arryProduct[0]['AmazonAccountID']))?($arryProduct[0]['AmazonAccountID']):('');
			
		foreach($amazonAccounts as $amazonAccount){
		?>
		<option <?php if($AmazonAccountID==$amazonAccount['id']){echo "selected";} ?> value="<?=$amazonAccount['id']?>"><?=$amazonAccount['title']?></option>					
		<?php }}?>			    
		</select>
		</td>
	</tr>
	<tr>
		<td align="right" class="blackbold">Condition:<span class="red">*</span>
		</td>
		<td align="left">

		<? $ProductType = (!empty($arryProduct[0]['ProductType']))?($arryProduct[0]['ProductType']):('');  ?>
<select class="inputbox"
			id="ItemCondition" name="ItemCondition" title="Condition" required>
			<option value="New" <?=($ProductType=='New') ? 'selected' : ''?>>New</option>
			<option value="Used; Good" <?=($ProductType=='Used') ? 'selected' : ''?>>Used</option>
			<option value="Collectible, Like_new" <?=($ProductType=='Collectible') ? 'selected' : ''?>>Collectible</option>
			<option value="Refurbished, Refurbished" <?=($ProductType=='Refurbished') ? 'selected' : ''?>>Refurbished</option>
		</select>
		
		</td>
	</tr>
	<tr>
		<td align="right" class="blackbold" width="25%">Brand:</td>
		<td align="left"><input name="Brand" type="text" class="inputbox" id="Brand" value="<? if(isset($arryProduct[0]['Brand'])) echo $arryProduct[0]['Brand'];?>"></td>
	</tr>
	<tr>
		<td align="right" class="blackbold" width="25%">Condition Note:</td>
		<td align="left"><textarea name="ItemConditionNote" type="text" class="inputbox" id="ItemConditionNote"><?php if(isset($arryProduct[0]['ItemConditionNote'])) echo trim(strip_tags($arryProduct[0]['ItemConditionNote'])); ?></textarea></td>
	</tr>
		    <input type="hidden" name="AddToAmazon" id="AddToAmazon" value=""  >
		    <tr>
		    <td align="left"> </td>
		        <td align="left"><input type="submit" class="search_button" id="sync_amazon" name="add_amazon" value="Amazon" onclick="sendtoAddAmazon();"></td>
		    </tr>
		</table>
		
	</form>
	</div>
</div>


<div style="display:none">
	<div id="ebaySyncProduct">
	<form name="form3" id="form3" action=""  method="post" onSubmit="return validateEbayProduct(this);" >
		<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="borderall">
			<tr>
		<td colspan="2" align="left" class="head">Ebay Basic</td>
	</tr>
	
	<tr>
        <td  align="right"   class="blackbold" width="20%">Site Name:<span class="red">*</span> </td>
        <td   align="left" width="40%">
			 <select class="inputbox" name="SiteName" id="SiteName">
			 	<option value="">-- Select --</option>
			 	<?php foreach($objProduct->ebaySiteList() as $siteID=>$siteName):?>
	         	<option value="<?=$siteID?>"><?=$siteName?></option>
	         	<?php endforeach;?>
	       	</select>            
		</td>
   </tr>
   
	<tr>
        <td  align="right"   class="blackbold" >Condition:<span class="red">*</span> </td>
        <td   align="left" colspan="3">

<? $ItemCondition = (!empty($arryProduct[0]['ItemCondition']))?($arryProduct[0]['ItemCondition']):('');  ?>


		<select class="inputbox" id="ItemCondition" name="ItemCondition" title="Condition">
				<option value="1000" <?php if($ItemCondition==1000) echo 'selected';?> >New</option>
				<option value="3000" <?php if($ItemCondition==3000) echo 'selected';?>>Used</option>
				<option value="1500" <?php if($ItemCondition==1500) echo 'selected';?>>New other</option>
				<option value="1750" <?php if($ItemCondition==1750) echo 'selected';?>>New with defects</option>
				<option value="2000" <?php if($ItemCondition==2000) echo 'selected';?>>Manufacturer refurbished</option>
				<option value="2500" <?php if($ItemCondition==2500) echo 'selected';?>>Seller refurbished</option>
				<option value="4000" <?php if($ItemCondition==4000) echo 'selected';?>>Very Good</option>
				<option value="5000" <?php if($ItemCondition==5000) echo 'selected';?>>Good</option>
				<option value="6000" <?php if($ItemCondition==6000) echo 'selected';?>>Acceptable</option>
			</select>
	 	</td>
	</tr>
	
	<tr>
        <td  align="right"   class="blackbold" >Listing Type:<span class="red">*</span> </td>
        <td   align="left" colspan="3">
<? $ProductType = (!empty($arryProduct[0]['ProductType']))?($arryProduct[0]['ProductType']):('');  ?>

		 <select class="inputbox" name="listingType">
         <option value="FixedPriceItem" <?php if($ProductType=='FixedPriceItem') echo 'selected';?>>Fixed Price Item</option>
         <option value="Chinese" <?php if($ProductType=='Chinese') echo 'selected';?>>Chinese</option>
         <option value="Half" <?php if($ProductType=='Half') echo 'selected';?>>Half</option>
       </select>
      </td>
	</tr>
	 
	 <tr>
	      <td  align="right"   class="blackbold" width="20%">Listing Duration:<span class="red">*</span> </td>
	      <td   align="left" width="40%">
<? $ProductTypeName = (!empty($arryProduct[0]['ProductTypeName']))?($arryProduct[0]['ProductTypeName']):('');  ?>
<select class="inputbox" name="listingDuration">
<option value="Days_7" <?php if($ProductTypeName=='Days_7') echo 'selected';?>>7 days</option>
<option value="Days_30" <?php if($ProductTypeName=='Days_30') echo 'selected';?>>30 days</option>
<option value="Days_180" <?php if($ProductTypeName=='Days_180') echo 'selected';?>>180 days</option>
<option value="Days_360" <?php if($ProductTypeName=='Days_360') echo 'selected';?>>360 days</option>
</select>             
		  </td>
      </tr>
      
	<tr>
		<td align="right" class="blackbold" width="25%">Condition Note:</td>
		<td align="left"><textarea name="ItemConditionNote" type="text" class="inputbox" id="EbayItemConditionNote"><?php if(isset($arryProduct[0]['ItemConditionNote'])) echo trim(strip_tags($arryProduct[0]['ItemConditionNote'])); ?></textarea></td>
	</tr>
		    <input type="hidden" name="AddToEbay" id="AddToEbay" value="">
		    <tr>
		    <td align="left"> </td>
		        <td align="left"><input type="submit" class="search_button" id="add_ebay" name="add_ebay" value="Ebay" onclick="sendtoAddEbay();"></td>
		    </tr>
		</table>
		
	</form>
	</div>
</div>

<script type="text/javascript">
function confSubmit(p_Name){
	if(confirm("Are you sure you want to list this "+p_Name+"?")){
		return true;
	}else{
		return false;
	}
	return false;
}

function chosevalue(selectedval){
	
	$('#synctypeselected').val(selectedval);
	 sendtosync();
	 $.fancybox.close();
	 
}


function sendtosync(){
	var selectedItemID=new Array();
	$('[name="ProductID[]"]:checked').each(function(i,e) {
		
		selectedItemID.push(e.value);
	});
	if(selectedItemID.length==0){
		alert('Please select item first');
	}
	else{
		var selecttype='';
		selecttype=$('#synctypeselected').val();
			
		document.form1.action ="syncItem.php";
		$("#form1").submit();
		//Items=$("input[name='ProductID[]']:checked").serialize();
		//window.location='syncItem.php?'+Items+'&selecttype='+selecttype;
	}
	
}

function selectitems(){
	var selectedItemID=new Array();
	$('[name="ProductID[]"]:checked').each(function(i,e) {
		
		selectedItemID.push(e.value);
	});
	if(selectedItemID.length==0){
		alert('Please select item first');
	}
	else{
		var selecttype='';
		if($('#SelectAll').is(":checked")){
			 
			selecttype='all';
			
			$.fancybox({
		        'type': 'inline',
		        'href': '#dialogContent',
		       'afterClose':function () {
				sendtosync();
	        		}
		    }); 
			//Items=$("input[name='ProductID[]']:checked").serialize();
			//window.location='syncItem.php?'+Items+'&selecttype='+selecttype;
		 } 
		else{
			document.form1.action ="syncItem.php";
			$("#form1").submit();
			//Items=$("input[name='ProductID[]']:checked").serialize();
			//window.location='syncItem.php?'+Items+'&selecttype='+selecttype;
		}
		
	}
	
}


function sendtoAddAmazon(){
	var selectedItemID=new Array();
	$('[name="ProductID[]"]:checked').each(function(i,e) {
		
		selectedItemID.push(e.value);
	});
	if(selectedItemID.length==0){
		alert('Please select item first');
		$.fancybox.close();
		return false;
	}
	else{
		var selecttype='';
		selecttype=$('#AddToAmazon').val(selectedItemID);
		$("#form2").submit();
	}
	
}

function sendtoAddEbay(){
	var selectedItemID=new Array();
	$('[name="ProductID[]"]:checked').each(function(i,e) {
		
		selectedItemID.push(e.value);
	});
	if(selectedItemID.length==0){
		alert('Please select item first');
		$.fancybox.close(); 
	}
	else{
		var selecttype='';
		selecttype=$('#AddToEbay').val(selectedItemID);
		$("#form3").submit();
	}
	
}

function validateAmazonProduct(frm){ 
	if( ValidateForSimpleBlank(frm.AmazonAccountID, "Account Name")
		&& ValidateForSimpleBlank(frm.ItemCondition, "Product Condition")
		&& ValidateForSimpleBlank(frm.ItemConditionNote, "Condition Note")
	  ){
		  
	}else{
		return false;	
	}
}

function validateEbayProduct(frm){ 
	if( ValidateForSimpleBlank(frm.SiteName, "Site Name")
		&& ValidateForSimpleBlank(frm.ItemCondition, "Product Condition")
		&& ValidateForSimpleBlank(frm.listingType, "Listing Type")
		&& ValidateForSimpleBlank(frm.listingDuration, "Listing Duration")
	  ){
		  
	}else{
		return false;	
	}
}

var interval;
processCheck = function (){ 
	 $.ajax({
        url : "ajax.php",
        type: "GET",
        data : { action: 'processCheck', taskmsg: 'batch' },
        success: function(data)
        {	 
            data = $.parseJSON(data);
            
			 if(data.msgStsus=='2') { 
				$(".message").html('<img src="../images/processing.gif" style="display: inline-block;transform: translate(-34%,13%);"> Amazon batch listing is processing...');
				$("#AmazonBatch").removeClass('fancybox');
				$("#AmazonBatch").css('background-color','#9AAB9C');
			 }else if(data.msgStsus=='1') { 
				$(".message").html('Amazon batch listing process has been completed.');
				$("#AmazonBatch").addClass('fancybox');
				$("#AmazonBatch").css('background-color','#d40503');
			 }

			 if(data.status=='0'){
				clearInterval(interval);
				return false;
			 }
			 
        },
        error: function( data ){
        	clearInterval(interval);
			return false;
        }
	 });
	
}

var interval;
EbayprocessCheck = function (){ 
	 $.ajax({
        url : "ajax.php",
        type: "GET",
        data : { action: 'processCheck', taskmsg: 'ebayBatch' },
        success: function(data)
        {	 
            data = $.parseJSON(data);
            
			 if(data.msgStsus=='2') { 
				$(".message").html('<img src="../images/processing.gif" style="display: inline-block;transform: translate(-34%,13%);"> Ebay batch listing is processing...');
				$("#EbayBatch").removeClass('fancybox');
				$("#EbayBatch").css('background-color','#9AAB9C');
			 }else if(data.msgStsus=='1') { 
				 $(".message").html('Ebay batch listing process has been completed.');
				 $("#EbayBatch").addClass('fancybox');
				 $("#EbayBatch").css('background-color','#d40503');
			 }

			 if(data.status=='0'){
				clearInterval(interval);
				return false;
			 }
			 
        },
        error: function( data ){
        	clearInterval(interval);
			return false;
        }
	 });
	
}

//$( window ).load(function() {
$(document).ready(function(){
	setTimeout(function(){
		processCheck();
		EbayprocessCheck();
	},100);
	interval = setInterval(processCheck,6000);
});
</script>
