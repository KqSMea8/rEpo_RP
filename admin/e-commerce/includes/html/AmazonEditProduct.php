<?
if($_GET['tab']=='SubmissionHistory'){
	include("includes/html/box/SubmissionHistory.php");
}elseif($_GET['tab']=='SendAmazon'){
	include("includes/html/box/amazon_Items.php");
}else{
$processImg = '<img src="../images/processing.gif" style="display: inline-block;transform: translate(-34%,13%);"> Lowest price update for all Items (200 items per hours) is in process...';
	$processDetails = $objConfig->getPID('e-commerce','lowestPrice');
?>
<div class="had">Manage Amazon Products</span></div>
<div class="message"><? if (!empty($_SESSION['CRE_Update'])) {    echo $_SESSION['CRE_Update'];    unset($_SESSION['CRE_Update']);} if(isset($processDetails[0])){echo $processImg; } ?></div>
<form action="" method="post" name="Amazon">
		<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
                    <td width="40%" >&nbsp;</td>
					<td width="" align="right">  
					<button type="button" id="Update_PQ" style="background-color: #535353 !important;color:#fff;width: 90px;font-weight: bold;padding: 5px 10px; cursor:pointer; display: none;" class="Active" onclick="submitPQ();"> Update All </button>
			    	</td>
				</tr>
				
				
                <tr>
                    <td width="40%">
						 <?php 
	                    $url = $_SERVER["SCRIPT_NAME"];
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
                    <td align="right">
                     <input type="submit" id="Update_PQ" style="background-color: #535353 !important;color: #fff;width: 90px;font-weight: bold;padding: 5px 10px; display: none;" name="Update_PQ" value="Update All" > &nbsp;&nbsp;
                     
<? $select_lowestPrice = (!empty($_POST['select_lowestPrice']))?($_POST['select_lowestPrice']):(''); ?>

                    <select class="textbox" id="select_lowestPrice" name="select_lowestPrice">
						   <option value="1" <?php if($select_lowestPrice==1){echo "selected";} ?> > Update Current Page </option>
						   <option value="2" <?php if($select_lowestPrice==2 || isset($processDetails[0])){echo "selected";} ?> > Update All Product </option>
					</select>
					<input type="submit" id="update_lowestPrice" class="search_button" name="update_lowestPrice" value="Lowest Price" onclick="return updateAllLowestRecord();" <?php if(isset($processDetails[0])){ echo "disabled "; echo "style='background-color: #9AAB9C;'"; }?>>
					
					<select class="textbox" id="AmazonAcc" name="AmazonAcc">
						   <option value="" >-- Select Account --</option>
					 		<?php $amazonAccounts = $objProduct->getAccountAll();
					 		if(!empty($amazonAccounts)){


$AmazonAcc = (!empty($_REQUEST['AmazonAcc']))?($_REQUEST['AmazonAcc']):('');

							foreach($amazonAccounts as $amazonAccount){
							?>
							<option <?php if($AmazonAcc==$amazonAccount['id']){echo "selected";} ?> value="<?=$amazonAccount['id']?>"><?=$amazonAccount['title']?></option>					
							<?php }}?>		
					</select>
					<input type="submit" id="sync_amazon" class="search_button" name="sync_amazon" value="Sync Amazon" onclick="return validateSyncProduct();">
					</td>
                </tr>
          </table>
</form>

<form name="form3" action=""  method="post" onSubmit="return" id="form3" >
<input type="hidden" name="AccountID" id="AccountID" value="" />
<input type="hidden" name="channel" id="channel" value="" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="myTable">
      <tr>
        <td id="ProductsListing">
            <form action="" method="post" name="form1">
                <table <?= $table_bg ?>>
                    <tr align="left">
                        <td width="10%" class="head1" align="left">Sku</td>
                        <td width="20%"  class="head1" >Title</td>
                        <td class="head1" width="8%" align="left">Quantity</td>
						<td class="head1" width="8%" align="left">Price</td>
						<td class="head1" width="8%" align="left">Lowest Price + Shipping</td>
						<td class="head1" width="8%" align="left">Channel</td>
						<td width="10%" class="head1" align="left">Status</td>
						<td class="head1" width="8%" align="left">Action</td>
                       
                    </tr>

                    <?php
                    if (is_array($arryEbay) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryEbay as $key => $values) {
                            $flag = !$flag;
                            //$bgcolor=($flag)?(""):("#F3F3F3");
                            $Line++;
							if($values['Status']!=1){
								$Amazonservice = $objProduct->AmazonSettings($Prefix,true,$values['AmazonAccountID']);
								if($Amazonservice)
								$data = $objProduct->getFeedSubmissionHistory($Amazonservice,$values['FeedSubmissionId']);
							}
                            //if($values['Status']<=0){ $bgcolor="#000000"; }
							$status = (!empty($data))? (is_numeric($data['status'])) ? 'Failed': $data['status'] : stripslashes($values['FeedProcessingStatus']);
                            ?>
                            
                             <!--   <input type="hidden" name="ProductSKU[]" id="ProductSKU<?= $Line ?>" conditiontype="<?=$values['ItemCondition']?>" aid="<?=$values['AmazonAccountID']?>" value="<?= $values['pid']; ?>"> -->
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <td align="left"><?=stripslashes($values['ProductSku']); ?></td>
                                <td align="left"><?=stripslashes($values['Name']); ?></td>

                                <td onmouseover="mouseoverfun('UpdateQuantity','<?php echo $values['ProductSku']; ?>')"
									onmouseout="mouseoutfun('UpdateQuantity','<?php echo $values['ProductSku']; ?>')">
									<span id="edit_UpdateQuantity<?php echo $values['ProductSku']; ?>" style="cursor: pointer; display: none;" onclick="getAmazonField('Quantity','<?=$values['ProductSku']?>',this,'UpdateQuantity','<?=$values['AmazonAccountID']?>');"><?= $edit ?></span>
                                <div class="editable_inputdiv1">
                               	 	<?= stripslashes($values['Quantity']);?>
                                </div>
                                
								</td>
                                
                                <td onmouseover="mouseoverfun('UpdatePrice','<?php echo $values['ProductSku']; ?>')"
									onmouseout="mouseoutfun('UpdatePrice','<?php echo $values['ProductSku']; ?>')">
									<span id="edit_UpdatePrice<?php echo $values['ProductSku']; ?>" style="cursor: pointer; display: none;" onclick="getAmazonField('Price','<?=$values['ProductSku']?>',this,'UpdatePrice','<?=$values['AmazonAccountID']?>');"><?= $edit ?></span>
                                <div class="editable_inputdiv1">
                               	 	<?= stripslashes($values['Price']);?>
                                </div>
                                
								</td>
								 
                                   <?php $lowestPricePlusShipping = $values['ListingPrice']+$values['Shipping'];?>
								 <td align="left">
                                   <?= ($values['Price']<=$lowestPricePlusShipping && $values['FeedProcessingStatus']=='Active')?'<span style="color:#0061b4;font-weight:bold;font-size:12px;">Lowest</span>':number_format((float)$lowestPricePlusShipping, 2, '.', '');?></td>
                                  <td align="left" id="channel<?php echo $values['ProductSku']; ?>">
                                   <?= stripslashes($values['Channel']);?></td>
                                <td align="center"><?php 
	                               if ($status == "Active") {
	                               	$status1 = 'Active';
	                               	$Design ='text-align: center;width: 35px;display: block;text-decoration: none;cursor: default;';
	                               }else {
	                               	$status1 = 'InActive';
	                               	$Design ='text-align: center;width: 46px;display: block;text-decoration: none;cursor: default;';
	                               }
	                              	echo '<a style="'.$Design.'" class=' . $status1 . '><b>' . $status . '</b></a>';
                               ?></td>
                                <td  align="left">
                                   <?php if(!empty($values['itemID']) || !empty($values['AliasID'])) { ?> <a href="editProduct.php?edit=<? echo $values['itemID']; ?>&curP=<?php echo $_GET['curP']; ?>&tab=SendAmazon"><?= $edit ?></a> <?php }?>
									<a href="AmazonEditProduct.php?del_id=<? echo $values['pid']; ?>&curP=<?php echo $_GET['curP']; ?>&ProductSku=<? echo $values['ProductSku']; ?>&AmazonAccountID=<? echo $values['AmazonAccountID']; ?>" onclick="return confirmDialog(this, 'Product from Amazon')"><?= $delete ?></a> 
								</td>
                            
							
							
							</tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="9" class="no_record">No products found.</td>
                        </tr>

                    <?php } ?>



                    <tr >  
                    <td  colspan="9" >Total Product(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryEbay) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;  } ?>
                    </td>
                    </tr>
                </table>

                

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
            </form>
 
        </td>
    </tr>
</table>
</form>
<?php }?>
<script type="text/javascript">

function validateSyncProduct(){
	if($("#AmazonAcc").val()==''){
		alert("Please Select Amazon Account First!");
		return false;
	}
}
var interval;
processCheck = function (){ 
	 $.ajax({
        url : "ajax.php",
        type: "GET",
        data : { action: 'processCheck', taskmsg: 'addProduct' },
        success: function(data)
        {	 
            data = $.parseJSON(data);
            
			 if(data.msgStsus=='2') { 
				$(".message").html('<img src="../images/processing.gif" style="display: inline-block;transform: translate(-34%,13%);"> Amazon product syncing is in process...');
				$('#sync_amazon').prop('disabled', true);
				$("#sync_amazon").css('background-color','#9AAB9C');
			 }else if(data.msgStsus=='1') { 
				 $(".message").html('Amazon product syncing has been completed.');
				 $('#sync_amazon').prop('disabled', false);
				 $("#sync_amazon").css('background-color','#d40503');
			 }

			 if(data.status=='0'){
				 $('#sync_amazon').prop('disabled', false);
				clearInterval(interval);
				return false;
			 }
			 
        },
        error: function( data ){
        	$('#sync_amazon').prop('disabled', false);
        	clearInterval(interval);
			return false;
        }
	 });
	
}

$( window ).load(function() {
	setTimeout(function(){
		processCheck();
	},100);
	interval = setInterval(processCheck,6000);
});

/*function getLowestPrice(){ 
$('[name="ProductSKU[]"]').each(function(i,e) { 
		
	var SKU = e.value;
	var AccID = e.aid;
	var Condition = e.conditiontype;
	
	 $.ajax({
	       url : "ajax.php",
	       type: "GET",
	       data : { action: 'lowestPrice', Sku: SKU, ItemCondition: Condition, AccountID: AccID },
	       success: function(data)
	       {	 
		       console.log(data);
	           data = $.parseJSON(data);
	           $("#"+data.Sku).html(data.lowestPrice);
	       },
	       error: function( data ){
	       	
	       }
		 });
	 
	});
}*/


function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	return true;
}
function mouseoverfun(fieldname, id) {
	if (!$('#save_' + fieldname + id).length) {
		$('#edit_' + fieldname + id).show();
	}

}
function mouseoutfun(fieldname, id) {
	if (!$('#save_' + fieldname + id).length) {
		$('#edit_' + fieldname + id).hide();
	}
}


function getAmazonField(type,sku,this1,fieldname,AccountID){
	
	var count = $('#myTable tr input').length;
	if(count>1) $("#Update_PQ").show("slow");
	else $("#Update_PQ").hide("slow");
		
	var qnt = $(this1).next().text();
	if(type=='Price') qnt = parseFloat(qnt).toFixed(2);
	else qnt = parseInt(qnt);

	$("#AccountID").val(AccountID);
	
	var channel = $("#channel").val();
	channel = $.trim(channel);
	c = $("#channel"+sku).text();
	c = $.trim(c);
	if(channel!=''){
		if(channel!=c) { alert('Please select same channel.'); return false;}
	}else{
		$("#channel").val(c);
	}
			
	var inputbox = '<input type="text" name='+type+'_'+sku+' id='+type+' class="inputbox" style="width:50px;" value='+qnt+'>'; 
	    inputbox +='<span onclick=updateAmazonQP("'+type+'","'+(qnt)+'",this,"'+ sku +'","'+fieldname+'","'+AccountID+'"); id="save_'+fieldname + sku +'" style="cursor: pointer;"><img src="../images/save.png" border="0" onmouseover="" onmouseout="hideddrivetip()" style="position: absolute;margin-top: 3px;margin-left: 3px;" ></span>';
		
	    $(this1).next().html(inputbox);
	    $('#edit_' + fieldname + sku).hide();
}

function updateAmazonQP(type,preVal,this1,sku,fieldname,AccountID){ 
	
		var count = $('#myTable tr input').length; 
		if(count<=3) $("#Update_PQ").hide("slow");
	
		ShowHideLoader('1', 'P');
		
		var val = $(this1).prev('input').val();
		if(type=='Price') val = parseFloat(val).toFixed(2);
		else val = parseInt(val);
		
		SendUrl = 'action=updateAmazonQntPrice&Type=' + type + '&Sku=' + sku + '&Val=' + val +'&AccountID='+AccountID;
		if(val!=preVal){ 
			$.ajax( {
				type : "GET",
				url : "ajax.php",
				data : SendUrl,
				dataType : "JSON",
				success : function(responseText) { 
					if (responseText == 1) {
						$(this1).closest('.editable_inputdiv1').html(val);
						 $(".message").html('It will take 10 to 15 minutes to update on amazon.');
					} else {
						alert('unable to update');
						$(this1).closest('.editable_inputdiv1').html(preVal);
					}

					ShowHideLoader('2', 'P');

				}
			});
			$(this1).closest('.editable_inputdiv1').html(val);
		}else{
			ShowHideLoader('2', 'P');
			alert('Denied! You are trying to update same value.');
			$(this1).closest('.editable_inputdiv1').html(preVal);
		}
		
}

 function submitPQ(){ 
	 $("#form3").submit();
 }

function updateAllLowestRecord(){
$(".message").html('<img src="../images/processing.gif" style="display: inline-block;transform: translate(-34%,13%);"> Lowest price update for current page items is in process...');
	 //$('#update_lowestPrice').prop('disabled', true);
	 $("#update_lowestPrice").css('background-color','#9AAB9C');
}

</script>
