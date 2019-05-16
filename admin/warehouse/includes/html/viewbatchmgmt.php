<script type="text/javascript">

$(function(){
 
    $(".mov").fancybox({
        'width':500,
        'height':300,
        'autoSize' : false,
        'afterClose':function(){
            parent.location.reload(true); 
        }, 
    });	
    
 
});
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><?php if(!empty($_SESSION['mess_batch'])) {echo $_SESSION['mess_batch']; unset($_SESSION['mess_batch']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

     <tr>   
     
	  <td  valign="top" align="right">


		   <?php if($num>0){?>
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <?php } ?>
      
      <a href="editbatchmgmt.php" class="add" >Add Batch</a>
      
        <?php if($_GET['key']!='') {?>
		  <a class="grey_bt"  href="viewWarehouse.php">View All</a>
		<?php }?>
        	</td>
      </tr>
  <tr>   
     
	  <td  valign="top" align="right">
	  <?php if($_GET['Sale_srch']!='') {?>
		  <a class="grey_bt"  href="viewbatchmgmt.php">View All</a>
		<?php }?>
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">

<input type="text" name="Sale_srch" id="" value="<?=$_GET['Sale_srch']?>" class="textbox" size="10" placeholder="Search Sales Order" />

<input name="sb" type="submit" class="search_button" value="Go"  />



</form>

		  
        	</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
   <tr align="left"  >
      <td width="10%"  class="head1" >Batch Name</td>
      <td class="head1" width="10%"> No of Sale Entries</td>
      <td class="head1" width="15%"> No of Invoice Entries</td>
      <td class="head1" width="10%"> Created By</td>
      <td class="head1" width="10%"> Modified By</td>
	<td class="head1" width="15%"> Created On</td>
      <td class="head1" width="10%"> Total Amount</td>
      <td width="5%"  align="center" class="head1" > Status</td>
      <td width="5%"  align="center" class="head1" > Move Invoice</td>
      <td width="10%" align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
   
  if(is_array($arryBatch) && $num>0){
  	$flag=true;
	$Line=0;
$CountCheck = 0;
$separator=0;
  	foreach($arryBatch as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

if($values['status'] == "Closed"){
$CountCheck ++;
}
	
if($values['status'] == "Closed" && $separator!=1 && $CountCheck>0) {
					echo '<tr align="left"><td  colspan="11" class="selectedbg"><b>Closed Batch</b></td></tr>';
echo '<tr align="center"><td  colspan="11" class="selectedbg">&nbsp;</td></tr>';
					$separator=1;
				}


	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
        <td > <?php echo  stripslashes($values["batchname"]); ?></td>
        <td > <?php echo $ContSaleID	=  	$objShipment->CountSaleBatches($values['batchId']);
			 ?></td>
        <td > <?php echo $ContInvoiceID	=  	$objShipment->CountInvoiceBatches($values['batchId']); ?></td>
        <td > <?php echo  stripslashes($values["createdby"]); ?></td>
        <td ><?php echo  stripslashes($values["modifiedby"]); ?> </td>
	<td > <? if($values['createdon']>0) 

$arryTime = explode(" ",$values['createdon']);
echo date($Config['DateFormat'], strtotime($arryTime[0]))." ".$arryTime[1];
		   //echo date('d F, Y h:i A', strtotime($values['createdon'])); 
	   ?> </td>
        <td>
           <?php 
            
            $EntriesArr	=  $objSale->ListbatchEntries($values['batchId']);
            if(!empty($EntriesArr))
            {   $total = '';
                foreach($EntriesArr as $val){
            
                    if($val['CustomerCurrency']!=$Config['Currency'] && $val['ConversionRate']>0){
                        $ConversionPrice = round($val['TotalAmount']*$val['ConversionRate'],2); 
                        $total += $ConversionPrice;
                    }else{ 
                        $total += $val['TotalAmount'];
                    } 
                
                }
                
                 echo $total." ".$Config['Currency'];
            }else{
                echo "N\A";
            }    
            ?>
        
        </td>
        
        
        
                             <?php  if ($values['status'] == 'Open') {
                                        $class = 'Active';
                                    } else {
                                        $class = 'InActive';
                 //Added by chetan 7June//                  
 }
                $result = $objShipment -> GetShippStatusByBatchIds($values['batchId']);
                ?>
        <td align="center">
            
        <a <?php   if($result){?>  href="javascript:;"  class="<?=$class?>" <?php }else{ if($class=='Active'){?> href="batchclose.php?active_id=<?=$values["batchId"]?>&curP=<?=$_GET["curP"]?> " <? }else{?> href="javascript:;"<? }?>  class="<?=$class?> <? if($class=='Active'){ ?> batchclose fancybox fancybox.iframe mov<?}?>" <?php } //End// }else{?>  ><?=$values["status"]?></a>
        
        </td>



        <td align="center"> <?php if($class == 'Active'){?> 
            <a  href="movebatchInvoice.php?batchId=<?=$values["batchId"]?>" class="Active fancybox fancybox.iframe">Move</a>
        
        <?php }else{?> <a  href="javascript:;" class="InActive">Closed</a>  <?php }?>
        </td>
           
        <td  align="center" class="head1_inner">
        <a href="vbatchmgmt.php?view=<?php echo $values['batchId'];?>" ><?=$view?></a>
        
        <?php if($values['status'] == "Open"){?>
        <a href="editbatchmgmt.php?edit=<?php echo $values['batchId'];?>&amp;curP=<?php echo $_GET['curP'];?>"><?=$edit?></a>  
        <?php } if(empty($ContSaleID)){ ?>
        <a href="editbatchmgmt.php?del_id=<?php echo $values['batchId'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 
        <?php }?>
 <a href="../pdfWarehousehtml.php?batchId=<?= $values['batchId']; ?>&ModuleDepName=warehouse&curP=<?=$_GET['curP']?>"><?= $download ?></a>
        </td>
    </tr>
    <?php




 } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="10" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	

  <tr>  <td  colspan="11"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryBatch) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                                }
                                ?></td>
                        </tr>

  </table>
 
  </div> 

</td>
	</tr>
<tr>
	  <td  valign="top">
	</td>
</tr>
 </table>


</td>
	</tr>
</table>


