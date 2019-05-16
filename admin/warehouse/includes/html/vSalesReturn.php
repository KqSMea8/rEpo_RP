
<? if($_GET['pop']!=1){ ?>
<a href="<?=$RedirectURL?>" class="back">Back</a>
<div class="had">
<?=$MainModuleName?>  <span>&raquo; <?=$ModuleName?></span>
<ul class="editpdf_menu">
            <li>
                <a href="<?= $DownloadUrl ?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>
                <ul>
                    <?php
                    echo '<li><a class="editpdf download" href="' . $DownloadUrl . '">Default</a></li>';
                    if (sizeof($GetPFdTempalteNameArray) > 0) {
                        foreach ($GetPFdTempalteNameArray as $tempnmval) {
                      
                            echo '<li><a class="editpdf download" href="' . $DownloadUrl . '&tempid=' . $tempnmval['id'] . '">' . $tempnmval['TemplateName'] . '</a></li>';
                        }
                    }
                    ?>

                </ul>
            </li>
        </ul>

	<?php /*<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	<a href="<?=$DownloadUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>*/?>

	 <ul class="editpdf_menu">
            <li><a class="edit" href="javascript:void(0)">Edit PDF</a>
                <ul>
                    <?php
                    echo '<li><a class="add" href="../editcustompdf.php?module=' . $module . '&curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&ModuleDepName=' . $ModuleDepName . '&rcpt='.$_GET['rcpt'].'">Add PDF Template</a></li>';
                    if (sizeof($GetPFdTempalteNameArray) > 0) {
                        foreach ($GetPFdTempalteNameArray as $tempnmval) {
                           echo '<li>';
		 if($tempnmval['AdminID']==$_SESSION['AdminID']){
                            echo '<a class="delete" href="../editcustompdf.php?module=' . $module . '&curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&Deltempid=' . $tempnmval['id'] . '&ModuleDepName=' . $ModuleDepName . '"></a>';
                               }
                            echo '<a class="edit editpdf" href="../editcustompdf.php?module=' . $module . '&curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&tempid=' . $tempnmval['id'] . '&ModuleDepName=' . $ModuleDepName . '">' . $tempnmval['TemplateName'] . '</a></li>';
                        }
                    }
                    ?>

                </ul>
            </li>                               
        </ul>
         <ul class="editpdf_menu">
 <?php 
	echo '<li><a target="_blank" class="edit" href="../pdfCommonhtml.php?module='.$module.'&curP='.$_GET['curP'].'&o='.$_GET["view"].'&editpdftemp=1&tempid='.$tempnmval['id'].'&ModuleDepName='.$ModuleDepName.'">Print</a>
	</li>';
	//'pdfCommonhtml.php?o=9977&module=Order&editpdftemp=1&tempid=&ModuleDepName=Sales'
	?>
</ul>
</div>
<? } ?>
<? if (!empty($errMsg)) {?>
    <div align="center"  class="red"><?=$errMsg?></div>
 <? } 
  

if (!empty($_SESSION['mess_shiment_delete'])) {
	echo '<div class="message" align="center">'.$_SESSION['mess_shiment_delete'].'</div>';
	unset($_SESSION['mess_shiment_delete']);
}



if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


?>


<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
    
     <tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Receipt Information</td>
</tr>
 <tr>
	<td  align="right"   class="blackbold" valign="top" width="20%"> Receipt No# : </td>
	<td align="left" width="30%" valign="top">
	<?php if(!empty($_GET['rcpt'])){?>
	 <?=$arrySale[0]['ReceiptNo'];?>
	<?php } else {?>
	<input name="ReceiptNo" type="text" class="datebox" id="ReceiptNo" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','ReceiptNo','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<div id="MsgSpan_ModuleID"></div>
	<?php }?>
	</td>
  
        <td  align="right"   class="blackbold" width="20%">Receipt Date  :</td>
        <td   align="left" >
	<?php if(!empty($_GET['rcpt'])){?>
	
	<?=($arrySale[0]['ReceiptDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['ReceiptDate']))):(NOT_SPECIFIED)?>
	
	<?php } else {?>
		<script type="text/javascript">
		$(function() {
			$('#ReceiptDate').datepicker(
				{
				showOn: "both",
				yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true

				}
			);
		});
</script>

<? 	
$arryTime = explode(" ",$Config['TodayDate']);
$ReturnDate = ($arrySale[0]['ReceiptDate']>0)?($arrySale[0]['ReceiptDate']):($arryTime[0]); 
?>
<input id="ReceiptDate" name="ReceiptDate" readonly="" class="datebox" value="<?=$ReturnDate?>"  type="text" > 
<?php }?>

</td>
      </tr>
 
	<tr>
				<td  align="right" class="blackbold"> Warehouse Code :</td>
				<td   align="left" >
				<?=$arrySale[0]['wCode']?>
                                  
                     
				</td>
			
         <td  align="right"   class="blackbold"> Mode of Transport  : </td>
		 <td   align="left" >
                               <?=$arrySale[0]['transport']?>
                                 </td>
          </tr>	
          
             <tr>
              
         <td  align="right"   class="blackbold"> Status : </td>
		 <td   align="left" >
                      <?=$arrySale[0]['ReceiptStatus']?>
                 </td>
         
		  		<td align="right"   class="blackbold" valign="top">Package Count :</td>
		  		<td  align="left" >
		    			<?=$arrySale[0]['packageCount']?><!--span>	<a class="fancybox add fancybox.iframe"  href="Package.php"> Add</a></span-->		          
				</td>
			</tr> 
<tr>
		  		<td align="right"   class="blackbold" valign="top">Package Type :</td>
		  		<td  align="left" >
				 <?=$arrySale[0]['PackageType']?>
                           	          
				</td>
				
		  		<td align="right"   class="blackbold" valign="top">Weight :</td>
		  		<td  align="left" >
		    		<?=$arrySale[0]['Weight']?>	          
				</td>
			</tr>
                        <tr>
		
	
		<td  align="right" class="blackbold"> Comments  : </td>
		<td align="left">
		<?php echo stripslashes($arrySale[0]['ReceiptComment']); ?>        
		</td>
	</tr>
 <tr>
	 <td colspan="4" align="left" class="head">RMA Information</td>
</tr>
 <tr>
	<td  align="right"   class="blackbold" width="20%"> RMA No# : </td>
	<td align="left" width="30%"> <?=$arrySale[0]['ReturnID'];?></td>
 
		<td  align="right"   class="blackbold" width="20%">Item RMA Date  :</td>
		<td   align="left" >
<?=($arrySale[0]['ReceiptDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['ReceiptDate']))):(NOT_SPECIFIED)?>



		</td>
	</tr>
 
	<tr>
	
	
		<td  align="right" class="blackbold" valign="top"> Comments  : </td>
		<td align="left" valign="top">
		<?php echo stripslashes($arrySale[0]['ReturnComment']); ?>
		</td>


		  <td  align="right" class="blackbold" valign="top"> Re-Stocking  : </td>
		<td align="left" valign="top">
		<?php if($arrySale[0]['ReSt']==1){echo "Yes";}else{echo "No";}?>
		</td>

	</tr>
 

</table>

	 </td>
</tr>
<tr>
	 <td align="left"><? include("includes/html/box/return_order_view.php");?></td>
</tr>
<tr>
	<td align="left">
	<?
	$arryShipStand['ModuleType'] = 'SalesRMA';
	$arryShipStand['RefID'] = $RmaOrderID; 
	$HideVoid=1;
	include("../includes/html/box/shipping_info_standalone.php");
	?>
	</td>
</tr>

<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/sale_order_billto_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/sale_order_shipto_view.php");?></td>
		</tr>
	</table>

</td>
</tr>


<tr>
	 <td align="right">
<?php
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 

echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>	 
	 </td>
</tr>


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



<tr>
	 <td  align="left" class="head" >Line Item
	 <div style="float:right;display:none;"><a class="fancybox fancybox.iframe" href="../sales/vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$SaleID?>" ><?=VIEW_ORDER_DETAIL?></a></div>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybox").fancybox({
			'width'         : 900
		 });

});

</script>



	 </td>
</tr>

<tr>
	<td align="left" >
		<?php include("includes/html/box/so_item_return_view.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

	<tr>
	<td  align="center">

		<? if($HideSubmit!=1){ ?>	
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Process"  />
		<? } ?>
		<?php if(empty($_GET['rtn'])){?>
		<input type="hidden" name="ReturnOrderID" id="ReturnOrderID" value="<?=$_GET['edit']?>" readonly />
		<?php }?>
		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />
		

	</td>
	</tr>
  
</table>

 </form>

<? } ?>



