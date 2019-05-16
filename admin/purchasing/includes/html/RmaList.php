<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SelectPO(InvoiceID,OrderID){	
	ResetSearch();
	window.parent.location.href = document.getElementById("link1").value+"?Inv="+OrderID;

	
}
function GetInvoices(str){
	ResetSearch();
	location.href = "RmaList.php?SuppCompany="+str; 	
	 
}


 

</script>

<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<div class="had">Search Invoice by Vendor</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>


<table cellspacing="0" cellpadding="0" width="100%" border="0" align="center">
    <tr>
        <td valign="top">
       
        <table cellspacing="0" cellpadding="3" border="0" style="margin: 0" id="search_table">
            <tr>
                <td valign="bottom"> 
               
	 <select name="SuppCompany" class="inputbox" id="SuppCompany" onChange="Javascript: GetInvoices(this.value);">
	 	<option value="">--- Select Vendor ---</option>
			 <?php foreach($arryVendorList as $Suppvalues) { ?> 
			 <option value="<?=$Suppvalues['SuppCode']?>" <?php if($Suppvalues['SuppCode']== $_GET['SuppCompany']){ echo "selected='selected'";}?>><?php echo stripslashes($Suppvalues['VendorName']);?> </option>  
		     <?php } ?>

   </select>
            
<script>
$("#SuppCompany").select2();
</script> 
    
                </td>
               
            </tr>

        </table>
     
        
        </td>
    </tr>
   
</table>



<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
 
	<tr>
        <td align="right" valign="bottom">
<?php if(!empty($_GET['SuppCompany'])){?>
<form name="frmSrch" id="frmSrch" action="RmaList.php" method="get" onSubmit="return ResetSearch();">
<table   border="0" cellpadding="0" cellspacing="0" id="search_table" style="margin: 0">			
			<tr>
			<td >
<select name="sortby" id="sortby" class="textbox">
			<option value=""> All </option>
			<option value="o.InvoiceID" <? if($_GET['sortby']=='o.InvoiceID') echo 'selected';?>>Invoice Number</option>
			<option value="vo.sku" <? if($_GET['sortby']=='vo.sku') echo 'selected';?>>Sku Number</option>
			<option value="o.SuppCompany" <? if($_GET['sortby']=='o.SuppCompany') echo 'selected';?>>Vendor</option>
			<option value="o.TotalAmount" <? if($_GET['sortby']=='o.TotalAmount') echo 'selected';?>>Amount</option>
						
</select>
	</td ><td >
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	 <input type="hidden" name="link1" id="link1" value="editRma.php">
	  <input type="hidden" name="SuppCompany" id="SuppCompany" value="<?=urldecode($_GET['SuppCompany']);?>">
	  </td>
			
			</tr>

		</table>
</form>
<? } ?>
     </td>
      </tr>
      
  
	
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">
<?php if(!empty($_GET['SuppCompany'])){?>
<table <?=$table_bg?>>
   
    <tr align="left"  >
      <td width="12%"  class="head1" >Invoice Number</td>
       <td width="12%" class="head1" >Invoice Date</td>
       
	 <td width="10%" class="head1" >Order Type</td>
     <td class="head1" width="10%">Vendor</td>
      <td width="10%" align="center" class="head1" >Amount</td>
      <td width="10%" align="center" class="head1" >Currency</td>
    
    </tr>
   
    <?php 
  if(is_array($arryPurchase) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryPurchase as $key=>$values){
	$flag=!$flag;
	$Line++;
	
	if(!empty($values["VendorName"])){
		$VendorName = $values["VendorName"];
	}else{
		$VendorName = $values["SuppCompany"];
	}
  ?>
    <tr align="left" >
       <td><a href="Javascript:void(0);" onclick="Javascript:SelectPO('<?=$values['InvoiceID']?>','<?=$values['OrderID']?>')" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()"><?=$values['InvoiceID']?></a></td>
	   <td>
	   <?
		   echo date($Config['DateFormat'], strtotime($values['PostedDate']));
		?>
	   
	   </td>
	   
	  <td><?=$values['OrderType']?></td>
      <td><?=stripslashes($VendorName)?></td> 
       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['Currency']?></td>
 



    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_INVOICE?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  
	 <td colspan="8"  id="td_pager">
	 Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryPurchase)>0){?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}?></td>
	 </tr>
  </table>
   <?php } ?> 
  </div> 


  
</form>
</td>
	</tr>
</table>

