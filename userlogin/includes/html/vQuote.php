<? if($_GET['pop']!=1){ ?>

	<a href="<?=$RedirectURL?>" class="back">Back</a>

	<? if(empty($ErrorMSG)){?>
	<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	<a href="<?=$EditUrl?>" class="edit">Edit</a>
	<a href="<?=$DownloadUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>

<? } ?>

	<div class="had">
	<?=$MainModuleName?>    <span>&raquo;
		<?=$_GET['tab']?> Detail
			
			</span>
	</div>
		
	  <? 

}	


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	

  if($_GET['tab'] == 'Quote'){

 
?>




	

<table  border="0" class="borderall" cellpadding="0" cellspacing="0" width="100%">
									   

	<?php      
$head = 1;
//By chetan 2DEc//
if(!empty($arryQuote[0])  && !empty($arryQuoteAdd[0]))
{
    $NewArr = array_merge($arryQuote[0],$arryQuoteAdd[0]);
}elseif(!empty($arryQuote[0]) && empty($arryQuoteAdd[0]))    
{
    $NewArr = $arryQuote[0];
}elseif(empty($arryQuote[0]) && !empty($arryQuoteAdd[0]))   
{
    $NewArr = $arryQuoteAdd[0];
}

//End// 

$arrayVal = $NewArr;
for($h=0;$h<sizeof($arryHead);$h++){?>
    <tr>
        <td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
    </tr>

<?php 

$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
if($arryHead[$h]['head_value'] == 'Ship Address Information'){
    if($arryQuote[0]['Reseller'] == 'No')
    {
        $Narry = array_map(function($arr){
                    if($arr['fieldname'] == 'Reseller' || $arr['fieldname'] == 'ResellerNo')
                    {
                        unset($arr);
                    }
                    else{
                        return $arr;
                    }  
                }, $arryField);
    }else{
        
        $Narry = array_map(function($arr){
                    if($arr['fieldname'] == 'Reseller')
                    {
                        unset($arr);
                    }
                    else{
                        return $arr;
                    }  
                }, $arryField);
    }
    
    $arryField = array_values(array_filter($Narry));
    
    $arrRate = explode(":",$arryQuote[0]['TaxRate']);
    if(!empty($arrRate[0])){
            $TaxVal = $arrRate[2].' %';
            $TaxName = '[ '.$arrRate[1].' ]';
    }else{
            $TaxVal = 'None';
    }
}    
if($arryHead[$h]['head_value'] == 'Quote Information')
{ 
    //Recurring Start//
    $arryRecurr = $arryQuote;
    include("includes/html/box/recurring_2column_sales_view.php");    //Recurring End//
}

include("includes/html/box/viewCustomFieldsNew.php");
 }
 //End//
?>
																				 
								
</table>

</td>
</tr>



<tr>
	 <td align="right">&nbsp;
<?

$Currency = (!empty($arryQuoteAdd[0]['CustomerCurrency']))?($arryQuoteAdd[0]['CustomerCurrency']):($Config['Currency']); 
//echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>	 
	 </td>
</tr>


<tr>
    <td  align="center" valign="top" >
	

		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
		<tr>
			 <td colspan="4" align="left" class="head_lineitem" >Line Item</td>
		</tr>
		<tr>
			<td align="left" colspan="4">
				<? 	include("includes/html/box/sales_quote_item_view.php");?>
			</td>
		</tr>
		</table>	
    
	
	</td>
   </tr>

  

  
</table>



<?} } ?>
<? if($_GET['tab']=="Document"){
include("box/document.php");
}?>
  
<? if($_GET['tab']=="Event"){?>


        
  <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

 <? if (!empty($_SESSION['mess_Event'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_Event'])) {echo $_SESSION['mess_Event']; unset($_SESSION['mess_Event']); }?>	
</td>
</tr>
<? } ?>
	<tr>
        <td align="right">
        
           <a class="fancybox fancybox.iframe add"  href="addActivity.php?module=<?=$_GET['module']?>&parent_type=<?=$_GET['module']?>&parentID=<?=$_GET['view']?>" >Add Event</a>
      
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
    <table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="5%" class="head1" >
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','activityID','<?=sizeof($arryActivity)?>');" /></td>-->
 
      <td width="15%"  class="head1" >Title</td>
	  <td width="13%" class="head1"> Activity Type </td>
	  <td width="12%" class="head1" >Priority</td>
	  <td width="19%" class="head1" > Start Date</td>
 <td width="19%" class="head1" > Close Date</td>
      <td width="11%"  align="center" class="head1" >  Status</td>
      <td width="12%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryActivity) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryActivity as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="activityID[]" id="activityID<?=$Line?>" value="<?=$values['activityID']?>" /></td>-->
      
      <td height="22" > 
	<a class="fancybox fancybox.iframe" href="vActivity.php?view=<?=$values['activityID']?>&pop=1"> <? echo  stripslashes($values["subject"]);?></a> 	       </td>
		   <td><?=$values['activityType']?></td>
      <td>
<?=(!empty($values['priority']))?(stripslashes($values['priority'])):(NOT_SPECIFIED)?>
 </td>
	 
      <td>
      <?php  
	   $stdate= $values["startDate"]." ".$values["startTime"];
	 echo date($Config['DateFormat']." ".$Config['TimeFormat'] , strtotime($stdate));?>
      </td>
        <td>
      <?php  
	   $cldate= $values["closeDate"]." ".$values["closeTime"];
	 echo date($Config['DateFormat']." ".$Config['TimeFormat'] , strtotime($cldate));?>
      </td>
    <td align="center"><? $status = $values['status']; echo $status;?></td>
	<td  align="center" >
	<a href="vQuote.php?act_id=<?php echo $values['activityID'];?>&view=<?=$_GET['view']?>&module=<?php echo $_GET['module'];?>&amp;curP=<?php echo $_GET['curP'];?>&tab=Event" onclick="return confirmDialog(this, 'Event')"  ><?=$delete?></a> </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
 <tr>  
 <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryActivity)>0){?>&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink; }?></td>
  </tr>
  </table> 
  </td>
  </tr>  
 </TABLE>
        
        <? }?>
        
        
       <?  if($_GET['tab']=="Campaign"){?>

	<div id="preview_div">
          
  <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        <a class="button" style="font-size:12px; color:#FFFFFF;" href="#" onclick="return window.open('leadCompaign.php?module=<?=$_GET['tab']?>&amp;return_module=<?=$_GET['module']?>&amp;parent_type=<?=$_GET['module']?>&amp;parentID=<?=$_GET['view']?>','test','width=640,height=602,resizable=0,scrollbars=0');" ><b>Select Campaign</b></a>
        
         
     
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
    <table <?=$table_bg?>>
   
    

	 <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CampaignID','<?=sizeof($arryCampaign)?>');" /></td>-->
      <td width="18%"  class="head1" >Campaign Name</td>
      <td width="14%"  class="head1" >Campaign Type</td>
      <td width="12%"  class="head1" >Campaign Status</td>
       <td width="12%" class="head1" >Expected Revenue</td>
     <td width="13%" class="head1" >Expected Close Date</td>
     
      <td width="16%"  align="center" class="head1" >Assign To</td>
      <td width="15%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryCampaign) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCampaign as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <!-- <td ><input type="checkbox" name="CampaignID[]" id="CampaignID<?=$Line?>" value="<?=$values['campaignID']?>" /></td>-->
      <td ><?=stripslashes($values["campaignname"])?></td>
      <td height="20" > <?=stripslashes($values["campaigntype"])?>	 </td>
	    <td height="20" > <?=stripslashes($values["campaignstatus"])?>	 </td>
			
		<td><?=$values['expectedrevenue']?> <?=$Config['Currency']?></td>
        <td height="20" > 
	<?  	if($values["closingdate"]!="0000-00-00"){//echo $Config['DateFormat'];
		echo date($Config['DateFormat'] , strtotime($values["closingdate"])); }?> </td>
     
	  <td><?=$values['AssignTo']?>(<?=$values['Department']?>)</td>
	  
   
      <td  align="center"  >
	   <a href="vCampaign.php?view=<?=$values['campaignID']?>&module=Campaign&curP=<?=$_GET['curP']?>" ><?=$view?></a>
	 
	  <a href="editCampaign.php?edit=<?php echo $values['campaignID'];?>&module=Campaign&amp;curP=<?php echo $_GET['curP'];?>&tab=Edit" ><?=$edit?></a>
	  
	<a href="editCampaign.php?del_id=<?php echo $values['campaignID'];?>&module=Campaign&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCampaign)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>      </td>
        </tr>
        
        </TABLE>
        
      </div> 
        <? }?>
     <? if($_GET['tab']=='Comments'){ include("comment.php");  }?>
	
<? if($_GET['tab']=='Ticket'){?>
 

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
        <a href="editTicket.php?module=Ticket&parent_type=<?=$_GET['module']?>&parentID=<?=$arryLead[0]['leadID']?>&mode_type=<?=$_GET['module']?>" class="add" >Add  Ticket</a>
        <a class="red_bt" style="display: inline-block;" href="#" onclick="return window.open('leadCompaign.php?module=<?=$_GET['tab']?>&amp;return_module=<?=$_GET['module']?>&amp;parent_type=<?=$_GET['module']?>&amp;parentID=<?=$_GET['view']?>','test','width=640,height=602,resizable=0,scrollbars=0');" >Select Ticket</a>
        
         
     
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">



<table <?=$table_bg?>>
   
    <tr align="left"  >
      <!--<td width="0%"  class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','TicketID','<?=sizeof($arryTicket)?>');" /></td>-->
      <td width="13%"  class="head1" >Ticket ID</td>
      <td width="25%"  class="head1" >Title</td>
      <td width="14%" class="head1" > Add Date</td>
	  <td width="16%" class="head1" > Assign To</td>
    
      <td width="12%"  align="center" class="head1" >Status</td>
      <td width="20%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryTicket) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryTicket as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <!-- <td ><input type="checkbox" name="TicketID[]" id="TicketID<?=$Line?>" value="<?=$values['TicketID']?>" /></td>-->
      <td ><?=$values["TicketID"]?></td>
      <td > 
	  <?
		  echo stripslashes($values['title']);
		  
		  
		  ?>		       </td>
        <td> <? echo date($Config['DateFormat']  , strtotime($values["ticketDate"]));?></td>
     
	  <td><?=$values['AssignTo']?>(<?=$values['Department']?>)</td>
       
    <td align="center">
	
	 

	<? echo $values['Status'];
		
	 ?></td>
      <td  align="center"  ><a href="vTicket.php?view=<? echo $values['TicketID']?>&module=<?php echo $_GET['tab'];?>&curP=<?php echo $_GET['curP'];?>&tab=Information" ><?=$view?></a>&nbsp;
	 &nbsp;&nbsp; <a href="editTicket.php?edit=<?php echo $values['TicketID'];?>&module=<?php echo $_GET['tab'];?>&curP=<?php echo $_GET['curP'];?>&tab=Information" ><?=$edit?></a>
	  
	&nbsp;&nbsp;<a href="vLead.php?view=<?php echo $values['TicketID'];?>&select_del_id=<?php echo $values['sid'];?>&module=<?=$_GET['module']?>&amp;curP=<?php echo $_GET['curP'];?>&tab=<?=$_GET['tab']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryTicket)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>


	 </td>
      </tr>
  
  </table>

  </div> 

<? }?>


