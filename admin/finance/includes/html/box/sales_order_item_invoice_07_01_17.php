<?php 
 $TaxRateOption = "<option value='0'>None</option>";
 for($i=0;$i<sizeof($arrySaleTax);$i++) {
	$TaxRateOption .= "<option value='".$arrySaleTax[$i]['RateId'].":".$arrySaleTax[$i]['TaxRate']."'>
	".$arrySaleTax[$i]['RateDescription']." : ".$arrySaleTax[$i]['TaxRate']."</option>";
 } 
if($arryCompany[0]['TrackInventory'] !=1){
		$style ='style="display:none;"';
		$numTd = 13;
	}else{
	       $numTd = 13;
	}
?>	
<input type="hidden" name="TaxRateOption" id="TaxRateOption" value="<?=$TaxRateOption?>" readonly />

<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	var TaxRateOption = $("#TaxRateOption").val();

	$("table.order-list").on("keyup", 'input[name^="price"],input[name^="DropshipCost"],input[name^="qty"],input[name^="discount"]', function (event) {
		calculateRow($(this).closest("tr"));
		calculateGrandTotal();
	});

	/*$("table.order-list").on("change", 'input[name^="tax"]', function (event) {
		calculateRow($(this).closest("tr"));
		calculateGrandTotal();
	});*/


	$("table.order-list").on("click", "#ibtnDel", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var id = row.find('input[name^="id"]').val(); 
		if(id>0){
			var DelItemVal = $("#DelItem").val();
			if(DelItemVal!='') DelItemVal = DelItemVal+',';
			$("#DelItem").val(DelItemVal+id);
		}
		/*****************************/
		$(this).closest("tr").remove();
		calculateGrandTotal();

	});
        
        
         $("table.order-list").on("click", "#addItem", function(event) {

            /********Edited by pk **********/
            var row = $(this).closest("tr");
            var qty = row.find('input[name^="qty"]').val();
            var serial_sku = row.find('input[name^="sku"]').val();
            var serial_value_sel = row.find('input[name^="serial_value"]').val();
             
            if (qty > 0) {
                var linkhref = $(this).attr("href") + '&total=' + qty + '&sku=' + serial_sku +'&serial_value_sel='+serial_value_sel;
                 
                $(this).attr("href", linkhref);
            }
            /*****************************/

        });

	});

	function calculateRow(row) {
		var taxRate = 0;
		if(document.getElementById("TaxRate") != null){
			taxRate = document.getElementById("TaxRate").value;
		}
		//var taxRate = row.find('input[name^="tax"]').val();
		var price = +row.find('input[name^="price"]').val();
		var qty = +row.find('input[name^="qty"]').val();
		var item_taxable = row.find('input[name^="item_taxable"]').val();
		var discount = +row.find('input[name^="discount"]').val();
		var TotalDisCount = discount*qty;
<?php if ($_SESSION['SelectOneItem']!='1'){?>	
                var DropshipCost = +row.find('input[name^="DropshipCost"]').val();
<? }else{?>
var DropshipCost =0;
<? }?>
                
               
                
		//var SubTotal = price*qty+DropshipCost*qty;
var SubTotal = price*qty;
		if(TotalDisCount > 0){
				SubTotal = SubTotal-TotalDisCount;
			}
		var tax_add = 0;

		if(taxRate!=0 && item_taxable=="Yes"){
			var arrField = taxRate.split(":");
			var taxRate = arrField[2];
			tax_add = (SubTotal*taxRate)/100;
			//SubTotal += tax_add;
		}

		row.find('input[name^="amount"]').val(SubTotal.toFixed(2));
	}

	function calculateGrandTotal() {		
		var subtotal=0, TotalAmount=0 , taxAmnt=0;		
		var item_taxable = ''; 		
		var taxRate = 0; var tax = 0; var amount = 0; 
               
		if(document.getElementById("TaxRate") != null){
			taxRate = document.getElementById("TaxRate").value;
		}
		if(taxRate!=0){
			var arrField = taxRate.split(":");
			tax = arrField[2];			
		}


		$("table.order-list").find('input[name^="amount"]').each(function () {
			amount = $(this).val();
			subtotal += +amount;			
			item_taxable = $(this).closest("tr").find('input[name^="item_taxable"]').val();
			if(tax>0 && item_taxable=="Yes"){
				taxAmnt += (amount*tax)/100;	
			}
			
		});
 

		/********************************************/
if(document.getElementById("freightTxSet") != null){
	var fr =	$("#Freight").val();
	freightTaxSet = document.getElementById("freightTxSet").value;
	//alert(freightTaxSet);
	 console.log(freightTaxSet);
	if(fr!='' && tax>0 && freightTaxSet =='Yes'){		
		FrtaxAmnt = (fr*tax)/100;	
		FrtaxAmnt = taxAmnt+FrtaxAmnt;
		taxAmnt  = FrtaxAmnt;
	}
}
/********************************************/
		taxAmnt = roundNumber(taxAmnt,2);	

		$("#subtotal").val(subtotal.toFixed(2));
		$("#taxAmnt").val(taxAmnt.toFixed(2));


		subtotal += +$("#Freight").val();
		subtotal += +$("#taxAmnt").val();
		subtotal += -$("#TDiscount").val();
		if(document.getElementById("ShipFreight") != null){
			subtotal += +$("#ShipFreight").val();
		}



		 var MDAmount = document.getElementById("MDAmount").value;
                var MDType = document.getElementById("MDType").value;
		var CustDisType = document.getElementById("CustDisType").value;
                var totDiscountAmt =0;
		var totDiscountCal =0;

		if(MDType !=null){

			if(MDType =='Discount'){

				
                               if(CustDisType == "Percentage"){
					totDiscountCal = subtotal*MDAmount/100;
                                        totDiscountAmt = subtotal-totDiscountCal;
                                        $("#CustDiscount").val(totDiscountCal.toFixed(2));
				 }else{
                                          totDiscountAmt = subtotal - MDAmount; 
                                          document.getElementById("CustDiscount").value = MDAmount;
				}
                             
			
			}else{

				 totDiscountCal = subtotal*MDAmount/100;   
                                 totDiscountAmt = subtotal+totDiscountCal;
				$("#CustDiscount").val(totDiscountCal.toFixed(2));
			
			}
                     
                     $("#TotalAmount").val(totDiscountAmt.toFixed(2));
		  }else{

	      		$("#TotalAmount").val(subtotal.toFixed(2));
		}
    
	}

/*********BY Chetan 6JAn	 ******/
      //For changing qty of all component item on main item qty change(if type is Kit)//
    $(function(){
            $(document).on('input','.itembg td input[data-qty="y"]',function(){

                 QtyVAl      = $(this).val().replace(/[^0-9\.]/g, '');
                 IndexRow    = (parseInt($(this).attr('id').replace(/[^0-9\.]/g, ''))); 
                 type        = $('#item_type'+IndexRow+'').val();
                 if(type == 'Yes' && typeof(type) !='undefined')
                 {
                     selItemId = $('#item_id'+IndexRow+'').val();

                     $(this).closest('tr').nextAll().find('td input[data-qty="y"]').each(function(i){

                             Indexing = parseInt($(this).attr('id').replace(/[^0-9\.]/g, '')); 
                             if($('#parent_ItemID'+Indexing+'').val() == selItemId)   
                             {    
																		$res = QtyVAl * ($('#ordered_qty'+Indexing+'').val().replace(/[^0-9\.]/g, ''));
                        					$(this).val($res);
                                 //$(this).val(QtyVAl);
                                 $(this).addClass('disabled');
                                 $(this).attr('readonly', 'readonly');
                             }
                     });

                 }    

            })
    });
//End///


function pop(div) {

				document.getElementById(div).style.display = 'block';
			}
			function hide(div) {
				document.getElementById(div).style.display = 'none';
			}
			//To detect escape button
			document.onkeydown = function(evt) {
				evt = evt || window.event;
				if (evt.keyCode == 27) {
					hide('mrgn');
				}
			};

	jQuery(document).ready(function(){
		
		jQuery(".close-mgn").click(function(){
			//alert("hiii");
			jQuery("div#mrgn").css({"display":"none"});
		});
	});


function RecurringCheck(lin){
if($("#RecurringCheck"+lin).is(':checked')){   $('a#controle'+lin).trigger('click');}else{



$('#EntryType'+lin).val('');
$('#EntryDate'+lin).val('');
$('#EntryInterval'+lin).val('');
$('#EntryMonth'+lin).val('');
$('#EntryWeekly'+lin).val('');
$('#EntryFrom'+lin).val('');
$('#EntryTo'+lin).val('');


}


}
</script>

<?
if(!empty($_GET['edit'])){
	//$HideCol = 'style="display:none"';
}

?>

 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td  class="heading" width="10%" >SKU</td>
              <? if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){?>
                <td  width="8%" class="heading">Condition</td>
		<?}?>
<td width="5%" class="heading">Recurring</td>
		<td  class="heading">Description</td>
		<td width="8%" class="heading">Qty Ordered</td>
		<td width="9%" class="heading" <?=$HideCol?>>Already Invoiced</td>
		<td width="9%" class="heading">Total Qty Invoice</td>
		<td width="10%"  class="heading">Unit Price</td>
<?php //if ($_SESSION['SelectOneItem']!='1'){?>	
                <td width="4%" class="heading" align="center">Dropship</td>
                <td width="8%" class="heading">Cost</td>
<? //}?>
		<!--td width="8%"  class="heading">Discount</td-->
<?php if ($_SESSION['SelectOneItem']!='1'){?>
		<!--td width="6%" class="heading" align="center">Taxable</td-->
<? }?>
		<td width="10%" class="heading" align="right" >Amount</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		  

		#if($arrySale[0]['Taxable']=='Yes' && $arrySale[0]['Reseller']!='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
		if($arrySale[0]['tax_auths']=='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
                    $TaxShowHide = 'inline';
		}else{
			$TaxShowHide = 'none';
		}

		$ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');
                
                 if($arrySaleItem[$Count]["DropshipCheck"] == 1){
                    $DropshipCheck = 'Yes';
                }else{
                    $DropshipCheck = 'No';
                }
		  if(empty($arrySaleItem[$Count]['Taxable'])) $arrySaleItem[$Count]['Taxable']='No';

$total_received = $objSale->GetQtyInvoiced($arrySaleItem[$Count]["id"]);
		$total_received = $total_received[0]['QtyInvoiced'];
                  /*$NumSerial = $objSale->CountSkuSerialNo($arrySaleItem[$Count]["sku"]);
                  $SerialNoAndQtyInvoiced = $objSale->CountSkuSerialNoAndQtyInvoiced($arrySaleItem[$Count]["sku"]);
                  $SerialNoAndQtyInvoiced = explode("#",$SerialNoAndQtyInvoiced);
                  $TotalSerial = $SerialNoAndQtyInvoiced[0];
                  $QtyInvoiced = $SerialNoAndQtyInvoiced[1];*/
                 //echo "=>".$TotalSerial."=>>>".$QtyInvoiced;

	$qty_received='';
	$amount='';
	$dd = "textbox";
	$rd = "";
	if(!empty($_GET['edit'])){
		$qty_received = $arrySaleItem[$Count]['qty_received'];
		$amount = $arrySaleItem[$Count]['amount'];		
		$SerialNumbers = preg_replace('/\s+/', ' ', $arrySaleItem[$Count]["SerialNumbers"]);		
		$qtyinvoiced = $objSale->GetReceivedQty($arrySaleItem[$Count]["ref_id"]) - $qty_received;
#echo $qty_received."==>";
#echo $qtyinvoiced ."==>";
#echo $arrySaleItem[$Count]["qty"];
		$remainQty = $arrySaleItem[$Count]["qty"] - $qtyinvoiced;
	}else{
		  if($arrySaleItem[$Count]["qty_received"] == $arrySaleItem[$Count]["qty"]){
			  $dd = "disabled";
			  $rd = "readonly";
		  }
		  $qtyinvoiced = $arrySaleItem[$Count]['qty_received'];
		  $remainQty = $arrySaleItem[$Count]["qty"]-$qtyinvoiced;
		  $SerialNumbers='';


	}


	?>
     <tr class='itembg'>
		<td> <?=stripslashes($arrySaleItem[$Count]['sku'])?>
		 <input type="hidden" name="sku<?=$Line?>" id="sku<?=$Line?>" class="disabled" readonly size="10" maxlength="10"  value="<?=stripslashes($arrySaleItem[$Count]['sku'])?>"/>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="../sales/reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" style="display: none;" border="0" title="Additional Items"></a>
		 <input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]["item_id"])?>" readonly maxlength="20"  />
		 <input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]["id"])?>" readonly maxlength="20"  />
		 <input type="hidden" name="remainQty<?=$Line?>" id="remainQty<?=$Line?>" value="<?=$remainQty?>" readonly maxlength="20"  />

<input type="hidden" name="req_item<?=$Line?>" id="req_item<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['req_item'])?>" readonly />
 <!-- By Chetan 6Jan ---->
	<input data-parent='y' type="hidden" name="parent_ItemID<?=$Line?>" id="parent_ItemID<?=$Line?>" value="<?=$arrySaleItem[$Count]['parent_item_id']?>" readonly=""/>
        <?php 
        if(!empty($arrySaleItem[$Count]["item_id"])){
            $ItemDt = $objItem->GetItemById($arrySaleItem[$Count]["item_id"]);
            if($ItemDt[0]['itemType']=='Kit' && $Config['TrackInventory']=='1'){?>
                
<input data-Kit='y' type="hidden" name="item_type<?=$Line?>" id="item_type<?=$Line?>" value="Yes" readonly/>
  
        <?php }else{?>

<input data-Kit='y' type="hidden" name="item_type<?=$Line?>" id="item_type<?=$Line?>" value="No" readonly/>
 <? } } ?>        
        <!-- end ---->
		</td>
<? if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){?>
 <td><div <?=$style?>><?=stripslashes($arrySaleItem[$Count]["Condition"])?>
		<input type="hidden" name="Condition<?=$Line?>" id="Condition<?=$Line?>" class="textbox" style="width:150px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["Condition"])?>"/></div>
		</td>
<? }?>


<td><input type="checkbox" name="RecurringCheck<?=$Line?>" id="RecurringCheck<?=$Line?>" <?php if($arrySaleItem[$Count]["RecurringCheck"] == 'on'){echo "checked";}?> onchange="return RecurringCheck(<?=$Line?>);">
<?php if($_GET['edit']!='' && $arrySaleItem[$Count]["RecurringCheck"] == 'on' ){   $RecDis =''; }else{ $RecDis ='display:none;'; } ?>
<a class="fancybox reqbox  fancybox.iframe" style="<?=$RecDis?>" href="../EntryType.php?line=<?=$Line?>&edit=<?=$arrySaleItem[$Count]['id']?>" id="controle<?=$Line?>" class="controle" ><?=$edit?></a>


<input type="hidden" name="EntryType<?=$Line?>" id="EntryType<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryType"])?>"/>
<input type="hidden" name="EntryDate<?=$Line?>" id="EntryDate<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryDate"])?>"/>
<input type="hidden" name="EntryInterval<?=$Line?>" id="EntryInterval<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryInterval"])?>"/>
<input type="hidden" name="EntryMonth<?=$Line?>" id="EntryMonth<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryMonth"])?>"/>
<input type="hidden" name="EntryWeekly<?=$Line?>" id="EntryWeekly<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryWeekly"])?>"/>
<input type="hidden" name="EntryFrom<?=$Line?>" id="EntryFrom<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryFrom"])?>"/>
<input type="hidden" name="EntryTo<?=$Line?>" id="EntryTo<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arrySaleItem[$Count]["EntryTo"])?>"/>

</td>

        <td><?=stripslashes($arrySaleItem[$Count]["description"])?>
		<input type="hidden" name="description<?=$Line?>" id="description<?=$Line?>" class="textbox" style="width:150px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["description"])?>"/>
		
               
		  <input type="hidden" name="PFromDate<?=$Line?>" id="PFromDate<?=$Line?>" class="textbox" value="<?php echo $arrySaleItem[$Count]["FromDate"];?>"/> <br />
<?php if(!empty($arrySaleItem[$Count]["FromDate"]) && $arrySaleItem[$Count]["FromDate"]>0){?>
            <span class="heading">From Date:</span>&nbsp;
          <?php  echo stripslashes($arrySaleItem[$Count]["FromDate"]);?><br>
            <input type="hidden" name="PToDate<?=$Line?>" id="PToDate<?=$Line?>" class="textbox" value="<?=$arrySaleItem[$Count]["ToDate"];?>"/><? }?>
<?php if(!empty($arrySaleItem[$Count]["ToDate"])  && $arrySaleItem[$Count]["ToDate"]>0){?>
            <span class="heading">To Date:</span>&nbsp;<?php echo stripslashes($arrySaleItem[$Count]["ToDate"]);?>
<? }?>

		</td>
        <td><input type="text" value="<?=$arrySaleItem[$Count]['qty']?>" size="5" readonly="" class="disabled" id="ordered_qty<?=$Line?>" name="ordered_qty<?=$Line?>"></td>
        <td <?=$HideCol?>><input type="text" value="<?=$total_received?>" size="5" readonly="" class="disabled" id="received_qty<?=$Line?>" name="received_qty<?=$Line?>"></td>
         <?php //By Chetan 6Jan//
        if(!empty($arrySaleItem[$Count]['parent_item_id']) && $Config['TrackInventory']=='1')
        {
             $ItemEvType = $objItem->checkItemSku($arrySaleItem[$Count]["sku"]);
         $disable = 'class = "disabled" readonly="readonly"';
        }else{
            
                $disable = "";
        }
?>        
<td>



<input <?=$disable?> type="text" value="" data-qty="y" name="qty<?=$Line?>" id="qty<?=$Line?>" onkeypress="return isNumberKey(event);" maxlength="6" size="5" <?=$rd;?> class="<?=$dd;?>">

<input type="hidden" value="<?=$qty_received?>" name="oldqty<?=$Line?>" id="oldqty<?=$Line?>" onkeypress="return isNumberKey(event);" maxlength="6" size="5" readonly  >
<? //echo $arrySaleItem[$Count]["evaluationType"];?>
            <br>
    
  <?    
//($arrySaleItem[$Count]["DropshipCheck"] != 1 && (
 if($_SESSION['TrackInventory'] !=1 && $_SESSION['SelectOneItem']!='1'){
  if(($arrySaleItem[$Count]["evaluationType"] == 'Serialized' || $arrySaleItem[$Count]["evaluationType"] == 'Serialized Average')
           || (!empty($ItemEvType) && $ItemEvType[0]["evaluationType"] == 'Serialized')){
        //End//
?>
        <a  class="fancybox slnoclass fancybox.iframe" href="addSerial.php?id=<?= $Line ?>" id="addItem" ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a>
        <?php }?>


<input type="hidden" name="serial_value<?= $Line ?>" id="serial_value<?= $Line ?>" value="<?=$SerialNumbers?>"  />
<input type="hidden" name="evaluationType<?= $Line ?>" id="evaluationType<?= $Line ?>" value="<?=$arrySaleItem[$Count]["evaluationType"]?>"  />

<?}?>
         
        </td>
        <td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" readonly="" class="disabled"  size="10" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["price"])?>"/></td>
<?php //if ($_SESSION['SelectOneItem']!='1'){?>
        <td align="center"><?=$DropshipCheck;?>
        <input type="hidden" name="DropshipCheck<?=$Line?>" id="DropshipCheck<?=$Line?>" class="textbox" value="<?=$arrySaleItem[$Count]["DropshipCheck"];?>"/>
        </td>
       <td>


          <input type="text" <? if($arrySaleItem[$Count]["DropshipCheck"] == 1){?>style="display:none;"<?php }?> name="avgCost<?=$Line?>" id="avgCost<?=$Line?>" value="<?=$arrySaleItem[$Count]["avgCost"]?>" class="disabled textbox avgCost" maxlength="6" size="6" readonly>
           <input  <?php if($arrySaleItem[$Count]["DropshipCheck"] != 1 || $disable){?>style="display:none;"<?php }?> type="text" name="DropshipCost<?=$Line?>" id="DropshipCost<?=$Line?>"  class="textbox" size="6" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["DropshipCost"])?>">



<!--input type="text" name="DropshipCost<?=$Line?>" id="DropshipCost<?=$Line?>" readonly="" class="disabled" size="6" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["DropshipCost"])?>"/-->



</td>
<? //}?>
       <!--td><input type="text" name="discount<?=$Line?>" id="discount<?=$Line?>" readonly="" class="disabled"  size="6" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["discount"])?>"/></td>-->
<?php if ($_SESSION['SelectOneItem']!='1'){?>
       <!--td align="center"><?=stripslashes($arrySaleItem[$Count]['Taxable'])?> <input type="hidden" class="normal" name="item_taxable<?=$Line?>" id="item_taxable<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['Taxable'])?>" readonly size="2" maxlength="20"  /-->
		<!--span style="display:<?=$TaxShowHide?>">
		<input type="text" name="tax<?=$Line?>" id="tax<?=$Line?>" size="6" readonly="" class="disabled" class="textbox" value="<?=$arrySaleItem[$Count]['tax'];?>">
		<input type="hidden" name="tax_id<?=$Line?>" id="tax_id<?=$Line?>" readonly="" class="disabled" class="textbox" value="<?=$arrySaleItem[$Count]['tax_id'];?>">
		</span-->

	   <!--/td-->
<? }?>
       <td align="right">
	   <input type="hidden" name="discount<?=$Line?>" id="discount<?=$Line?>" readonly="" class="disabled"  size="6" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["discount"])?>"/>
<input type="hidden" class="normal" name="item_taxable<?=$Line?>" id="item_taxable<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['Taxable'])?>" readonly size="2" maxlength="20"  /-->
	   <input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled" readonly size="13" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=$amount?>"/></td>
       
    </tr>
	<? 
$costofgood += $arrySaleItem[$Count]["DropshipCost"] * $qty_received; 
		$subtotal += $arrySaleItem[$Count]["amount"];
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="<?=$numTd?>" align="right">

		 <!--<a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>-->
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?
		
$TDiscount = $arrySale[0]['TDiscount'];
		if(!empty($_GET['edit'])){	
			$subtotal = number_format($subtotal,2,".","");
			$taxAmnt = $arrySale[0]['taxAmnt'];
			$Freight = $arrySale[0]['Freight']; 
			$ShipFreight = $arrySale[0]['ShipFreight']; 
			
			$TotalAmount = $subtotal+$taxAmnt+$Freight+$ShipFreight;

			if($arrySale[0]['MDType']=='Markup'){
				$TotalAmount = $TotalAmount + $arrySale[0]['CustDisAmt'];
			}else if($arrySale[0]['MDType']=='Discount'){
				$TotalAmount = $TotalAmount - $arrySale[0]['CustDisAmt'];
			}
			$TotalAmount = number_format($TotalAmount,2,".","");
		}else{
			$subtotal = '';
			$taxAmnt = '';
			$Freight = $arrySale[0]['Freight']; 
			 

			$TotalAmount = '';
		}
if($TotalAmount!=''){
			$TotalAmount = $TotalAmount -$TDiscount;

 $TotalAmount = number_format($TotalAmount,2,".","");

 }
			
			
	if($arrySale[0]['CustDisAmt']!='') $displayBlock ="style=display:block;"; else $displayBlock ="style=display:none;";
		   
		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly size="13" style="text-align:right;" value="<?=$subtotal?>"/>
		<br><br>

		
<div id="DisType" <?=$displayBlock?>><span id="LevelType"><?=$arrySale[0]['MDType']?></span>

<input type="hidden" align="right" name="MDType" id="MDType" readonly class="disabled"  value="<?=$arrySale[0]['MDType']?>" />: 
<input type="text" align="right" name="CustDiscount" id="CustDiscount" readonly class="disabled"  value="<?=$arrySale[0]['CustDisAmt']?>" size="13" style="text-align:right;"/>

<input type="hidden" align="right" name="MDAmount" id="MDAmount" readonly class="disabled"  value="<?=$arrySale[0]['MDAmount']?>" size="13" style="text-align:right;"/>



<input type="hidden" align="right" name="CustDisType" id="CustDisType" class="disabled"  value="<?=$arrySale[0]['CustDisType']?>" />
<br><br>

</div>

<?=$TaxCaption?> : <input type="text" align="right" name="taxAmnt" id="taxAmnt" class="disabled" value="<?=$taxAmnt?>" readonly size="13" style="text-align:right;"/><br><br>


		Freight : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>

		<?  if($ShipFreight>0){ ?>
		Actual Freight : <input type="text" align="right" name="ShipFreight" id="ShipFreight" class="disabled" readonly value="<?=$ShipFreight?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);"  style="text-align:right;"/>
		<br><br>
		<? } ?>

Add'l Discount : <input type="text" align="right" name="TDiscount" id="TDiscount" class="textbox" value="<?=$TDiscount?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>
		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="13" style="text-align:right;"/>
		<br><br>
        </td>
    </tr>
</tfoot>
</table>


<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".reqbox").fancybox({
			'width'         : 500
		 });
                 
                 $(".slnoclass").fancybox({
			'width'         : 300
		 });
                 
    $(".controle").fancybox({
        'width':300,
        'height':500,
        'autoSize' : false,
        'afterClose':function(){
            
        }, 
    });	              

});

</script>

<? //echo '<script>SetInnerWidth();</script>'; ?>
