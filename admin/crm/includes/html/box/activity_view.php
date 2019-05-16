



<div class="right_box">
<table width="100%" id="table1"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post">
  
 


   <tr>
    <td  align="center" valign="top" >


<table width="100%" id="table4"   border="0" cellpadding="5" cellspacing="0" class="borderall">


  

<? if($_GET["tab"]=="Activity"){ ?>

<tr>
	 <td  colspan="2" align="left" class="head"><? if($arryActivity[0]['activityType']!='Task'){?>Event Details<? }else{?> Task Details <? }?></td>
	 
</tr>

<tr>
        <td  align="right"   class="blackbold" width="20%" valign="top"> Subject  :</td>
        <td   align="left" width="25%" valign="top">
        <?php echo stripslashes($arryActivity[0]['subject']); ?>            </td>
       
        <td  align="right"   class="blackbold" width="25%" valign="top"> Assigned To  : </td>
        <td   align="left" valign="top">

<? if($arryActivity[0]['AssignType'] == 'Group'){ ?>
            <?=$AssignName ?> <br>
<? }?>
<div> <? foreach($arryAssignee as $values) {

?>
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$values['EmpID']?>" ><?=$values['UserName']?></a>,
<? } ?>



     </td>
      </tr>

	  

	  <tr>
        <td  align="right"   class="blackbold">Start Date & Time : </td>
        <td   align="left" >

  <?php  
	   $stdate= $arryActivity[0]["startDate"]." ".$arryActivity[0]["startTime"];
	 echo date($Config['DateFormat']." H:i:s" , strtotime($stdate));?>
		
                    </td>
      </tr>
      
      <tr>
        <td  align="right"   class="blackbold">Close Date & Time : </td>
        <td   align="left" >
<?php  
	   $ctdate= $arryActivity[0]["closeDate"]." ".$arryActivity[0]["closeTime"];
	 echo date($Config['DateFormat']." H:i:s" , strtotime($ctdate));?>
		
                    </td>
      </tr>
       <tr>
        <td  align="right"   class="blackbold">  Status  : </td>
        <td   align="left" >

		<?php echo stripslashes($arryActivity[0]['status']);?>
            </td>
      </tr>
<? if($arryActivity[0]['activityType']!='Task'){?>
      <tr>
        <td  align="right"   class="blackbold"> Activity Type : </td>
        <td   align="left" >
<?=(!empty($arryActivity[0]['activityType']))?(stripslashes($arryActivity[0]['activityType'])):(NOT_SPECIFIED)?>
		
                     </td>
      </tr>
	  
	
 <tr>
<td  align="right"   class="blackbold"> Send Notification : </td>
<td   align="left" >
<?php if($arryActivity[0]['Notification']==1){ $Notification="Yes";}else{$Notification="No";}echo stripslashes($Notification); ?>  </td>
 </tr>
	
<tr>
<td  align="right"   class="blackbold"> Location : </td>
<td   align="left" >
<?=(!empty($arryActivity[0]['location']))?(stripslashes($arryActivity[0]['location'])):(NOT_SPECIFIED)?>
</td>
</tr>
<? }?>
<tr>
<td  align="right"   class="blackbold"> Priority : </td>
<td   align="left" >
<?=(!empty($arryActivity[0]['priority']))?(stripslashes($arryActivity[0]['priority'])):(NOT_SPECIFIED)?>
</td>
</tr>
<? if($arryActivity[0]['activityType']!='Task'){?>
<tr>
<td  align="right"   class="blackbold"> Visibility : </td>
<td   align="left" >
<?=(!empty($arryActivity[0]['visibility']))?(stripslashes($arryActivity[0]['visibility'])):(NOT_SPECIFIED)?>
</td>
</tr>
  <? }?>    
 <tr>
	 <td colspan="2" align="left" class="head">Reminder</td>
</tr>
       <tr>
        <td  align="right"   class="blackbold"> Reminder : </td>
        <td   align="left" >
        <?php if($arryActivity[0]['reminder']==1){

$reminder="Yes";
}else{
$reminder="No";
}

echo stripslashes($reminder);?> </td>
      </tr>
<? if($arryActivity[0]['activityType']!='Task'){?>
 <tr>
        <td  align="right"   class="blackbold"> Invite Users : </td>
        <td   align="left" ><?=$ActUrl?>
        </td>
      </tr>
 
      <tr>
	 <td colspan="2" align="left" class="head">Related To</td>
</tr>
       <tr>
        <td  align="right"   class="blackbold"> Related Type : </td>
        <td   align="left" >


<?php if($arryActivity[0]['RelatedType']!=''){


echo $arryActivity[0]['RelatedType'];
}


?> </td>
      </tr>
<tr>
<td align="right"   class="blackbold">
<?php if($arryActivity[0]['RelatedType']=='Opportunity'){ echo 'Opportunity:';} else if($arryActivity[0]['RelatedType']=='Lead'){
echo 'Lead :';} else if($arryActivity[0]['RelatedType']=='Campaign'){ echo 'Campaign :';}else{ echo NOT_SPECIFIED;}

?> 
</td>
<td align="left">
<?php 

if($arryActivity[0]['RelatedType']=='Opportunity'){
	$arryOpportunity = $objLead->GetOpportunity($arryActivity[0]['OpprtunityID'],1);
	echo "<a class='fancybox fancybox.iframe' href='vOpportunity.php?view=".$arryActivity[0]['OpprtunityID']."&&pop=1'>".$arryOpportunity[0]['OpportunityName']."</a>";
}else if($arryActivity[0]['RelatedType']=='Lead'){
	$arryLead = $objLead->GetLead($arryActivity[0]['LeadID'],'');
$leadName = $arryLead[0]['FirstName']." ".$arryLead[0]['LastName'];
	echo "<a class='fancybox fancybox.iframe' href='vLead.php?view=".$arryActivity[0]['LeadID']."&pop=1'>".$leadName."</a>";
}else if($arryActivity[0]['RelatedType']=='Campaign'){

	$arryCampaign= $objLead->GetCampaign($arryActivity[0]['CampaignID'],1);

	echo "<a class='fancybox fancybox.iframe' href='vCampaign.php?view=".$arryActivity[0]['CampaignID']."&pop=1'>". $arryCampaign[0]['campaignname']."</a>";
}else{
echo NOT_SPECIFIED;
}

?> 
</td>
</tr>
    <? }?>  

	 <tr>
       		 <td colspan="2" align="left"   class="head">Description Details</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" >
            <? echo stripslashes($arryActivity[0]['description']); ?>

	          </td>
        </tr>

	
 
 
<? if( $HideNavigation!=1){?>
<tr>
       		 <td colspan="2" align="left"   ><?php include("includes/html/box/comment.php");?></td>
        </tr>
<? }?>
 
<? }?>


</table>	
  




	
	  
	
	</td>
   </tr>

   

   </form>
</table></div>

<? if($_GET['tab']=="Document"){
include("document.php");
}?>

        
      
        
     
     <? //if($_GET['tab']=='Comments'){ include("comment.php");  }?>
	
<? if($_GET['tab']=='Ticket'){
$arryTicket=$objLead->GetTicketData($_GET['view'],$_GET['module'],$_GET['tab']);
						 $num=$objLead->numRows();
						$pagerLink=$objPager->getPager($arryTicket,$RecordsPerPage,$_GET['curP']);
						(count($arryTicket)>0)?($arryTicket=$objPager->getPageRecords()):("");
?>
 

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
        <a href="editTicket.php?module=Ticket&parent_type=<?=$_GET['module']?>&parentID=<?=$arryLead[0]['leadID']?>&mode_type=<?=$_GET['module']?>" class="add" >Add  Ticket</a>
        <a class="button" style="font-size:12px; color:#FFFFFF; padding: 3px 5px 4px 20px;font-size: 12px;line-height: normal;border-radius: 2px 2px 2px 2px;" href="#" onclick="return window.open('leadCompaign.php?module=<?=$_GET['tab']?>&amp;return_module=<?=$_GET['module']?>&amp;parent_type=<?=$_GET['module']?>&amp;parentID=<?=$_GET['view']?>','test','width=640,height=602,resizable=0,scrollbars=0');" ><b>Select Ticket</b></a>
        
         
     
        
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
      <td  align="center"  ><a href=" vTicket.php?view=<? echo $values['TicketID']?>&module=<?php echo $_GET['tab'];?>&curP=<?php echo $_GET['curP'];?>&tab=Information" ><?=$view?></a>&nbsp;
	 &nbsp;&nbsp; <a href="editTicket.php?edit=<?php echo $values['TicketID'];?>&curP=<?php echo $_GET['curP'];?>&module=<?php echo $_GET['tab'];?>&tab=Information" ><?=$edit?></a>
	  
	&nbsp;&nbsp;<a href="vLead.php?view=<?php echo $_GET["view"];?>&select_del_id=<?php echo $values['sid'];?>&module=<?=$_GET['module']?>&amp;curP=<?php echo $_GET['curP'];?>&tab=<?=$_GET['tab']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
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
  </TABLE>
  
  </div> 

<? }?>



