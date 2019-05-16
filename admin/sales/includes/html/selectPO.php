<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}


function SelectPO(PurchaseID){	
	ResetSearch();
	window.parent.document.getElementById("PONumber").value=PurchaseID;
	parent.jQuery.fancybox.close();
	ShowHideLoader('1','P');

}
function SelectFromPO(PurchaseID,PorderID,Edi='',InvID=''){	
	ResetSearch();
var CustCode = window.parent.document.getElementById("CustCode").value;
var CustomerName = window.parent.document.getElementById("CustomerName").value;
//alert("Do you want to Genrate invoice and apply serial numbers from the PO.  ");
	//window.parent.document.getElementById("PONumber").value=PurchaseID;
	if(Edi!=''){
	
	var EdiConfirm =1; 
	}
	if(EdiConfirm==1 && InvID!=''){
	if(confirm("Do you want to Genrate invoice and apply serial numbers from the PO.")) {
	
	parent.window.location.href = 'editSalesQuoteOrder.php?POID='+PorderID+'&po='+PurchaseID+'&module=Order&CustCode='+CustCode+'&CustomerName='+CustomerName+'&EdiConfirm=1&InvID='+InvID;
	
	}else{
  parent.window.location.href = 'editSalesQuoteOrder.php?POID='+PorderID+'&po='+PurchaseID+'&module=Order&CustCode='+CustCode+'&CustomerName='+CustomerName+'';
  }
  }else{
  
  parent.window.location.href = 'editSalesQuoteOrder.php?POID='+PorderID+'&po='+PurchaseID+'&module=Order&CustCode='+CustCode+'&CustomerName='+CustomerName+'';
  }
	parent.jQuery.fancybox.close();
	ShowHideLoader('1','P');

}
</script>

<div class="had">Select Purchase Order</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="selectPO.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
<? if(!empty($_GET['FromPO'])){?>
<input type="hidden" name="FromPO" id="FromPO" value="<?=$_GET['FromPO']?>">
<? }?>
	 <input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
</form>



		</td>
      </tr>
	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
      <td width="12%"  class="head1" >PO Number</td>
       <td width="12%" class="head1" >Order Date</td>
	 <td width="10%" class="head1" >Order Type</td>
     <td class="head1" >Vendor</td>
      <td width="10%" align="center" class="head1" >Amount</td>
      <td width="10%" align="center" class="head1" >Currency</td>
     <td width="10%"  align="center" class="head1" >Status</td>
       <td width="8%"  align="center" class="head1" >Approved</td>
    </tr>
   
    <?php 
    #pr($arryPurchase);
  if(is_array($arryPurchase) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryPurchase as $key=>$values){
	$flag=!$flag;
	$Line++;
	
	$arryPOinvoice = $objPurchase->GetPurchase('',$values["PurchaseID"],'Invoice');
	
	 $InvoiceID = $arryPOinvoice[0]['InvoiceID'];
  ?>
    <tr align="left" >
       <td>
           
           <!--<a href="Javascript:void(0)" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" target="_parent" onclick="Javascript:SelectPO('<?=$values["PurchaseID"]?>');"><?=$values['PurchaseID']?></a>-->
 <a href="Javascript:void(0)" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" target="_parent" onclick="<?php if($_GET['FromPO']==1){?>Javascript:SelectFromPO('<?=$values["PurchaseID"]?>','<?=$values["OrderID"]?>','<?=$values["EDIRefNo"]?>','<?=$InvoiceID?>');<?php } else{?>Javascript:SelectPO('<?=$values["PurchaseID"]?>');<?php }?>"><?=$values['PurchaseID']?></a>
       </td>
	   <td>
	   <? /*if($values['OrderDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['OrderDate']));*/
		   echo $values['OrderDate'];
		?>
	   
	   </td>
	  <td><?=$values['OrderType']?></td>
      <td><?=stripslashes($values["SuppCompany"])?></td> 
       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['Currency']?></td>
     <td align="center">	
	 <?  $OrderIsOpen = 0;
		 if($values['Status'] == 'Cancelled' || $values['Status'] == 'Rejected'){
			 $StatusCls = 'red';
		 }else if($values['Status'] == 'Completed'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = '';
			 $OrderIsOpen = 1;
		 }

		echo '<span class="'.$StatusCls.'">'.$values['Status'].'</span>';
		
	 ?></td>


    <td align="center"><? 
		 if($values['Approved'] ==1){
			  $Approved = 'Yes';  $ApprovedCls = 'green';
		 }else{
			  $Approved = 'No';  $ApprovedCls = 'red';
		 }

		echo '<span class="'.$ApprovedCls.'">'.$Approved.'</span>';
		
	 ?></td>

    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_PO?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  
	 <td colspan="8"  id="td_pager">
	 Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryPurchase)>0){?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}?></td>
	 </tr>
  </table>

  </div> 


  
</form>
</td>
	</tr>
</table>

