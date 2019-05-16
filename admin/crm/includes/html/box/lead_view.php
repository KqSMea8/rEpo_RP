<?php 
/* start calling */
     require_once(_ROOT."/admin/crm/includes/html/callBlock.php"); 
/* -- end call -- */

?>

<script type="text/javascript">
function setTable(what){
if(document.getElementById(what).style.display=="none"){
document.getElementById(what).style.display="block";
}
else if(document.getElementById(what).style.display=="block"){
document.getElementById(what).style.display="none";
}
}
</script>


<?php  if($arryLead[0]['type']=='Individual'){?> 

<script type="text/javascript">
//document.getElementById('com').style.display = 'block';
$(function(){
$( "#table4 tr td:contains(Company Name)").hide().next().hide();
});
</script>

<?php }?>	




<div class="right_box">
<table width="100%" id="table1"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?php //echo $ActionUrl?>"  method="post">
  
  <? if (!empty($_SESSION['mess_lead'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_lead'])) {echo $_SESSION['mess_lead']; unset($_SESSION['mess_lead']); }?>	
</td>
</tr>
<? } ?>
 



   <tr>
    <td  align="center" valign="top" >


<table width="100%" id="table4"   border="0" cellpadding="5" cellspacing="0" class="borderall">


  

<?php if($_GET["tab"]=="Lead"){ ?>

<?php
//By Chetan//
$head=1;
$arrayVal= $arryLead[0];
for($h=0;$h<sizeof($arryHead);$h++){?>
    <tr>
        <td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
    </tr>
<?php if($h == 0){?>    
    <tr>
        <td  align="right"   class="blackbold"> Created Date : </td>
        <td   align="left" colspan="3">
            <?php
            if ($arryLead[0]['UpdatedDate'] > 0)
                echo date($Config['DateFormat'], strtotime($arryLead[0]['UpdatedDate']));
            else
                echo NOT_SPECIFIED;
            ?>
        </td>
    </tr>

 <?php } $arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
include("includes/html/box/viewCustomFieldsNew.php");
 }
 //End//
?>        
                    
        
        
        
        
        
<tr>
       		 <td colspan="8" align="left"   ><?php include("includes/html/box/comment.php");  ?></td>
        </tr>

<? if(isset($_GET['popLead']) && $_GET['popLead'] ==1){?>
<tr>
       		 <td colspan="8" align="left"   ><?php include("includes/html/box/commentLead.php");  ?></td>
        </tr>
<? }?>
 
<?php }?>


</table>	
  




	
	  
	
	</td>
   </tr>

   

   </form>
</table></div>

<?php if($_GET['tab']=='Email'){ // this condition is added for showing emails of user
		$SubHeading = 'Email'; 
                
                //print_r($arryLead[0]);
		//$IncludePage = 'combinedEmail.php';
                $EmailForInbox = $arryLead[0]['primary_email'];
                include("../includes/html/box/combinedEmail.php");
                
	}?>

<?php if($_GET['tab']=="Comments"){ include("includes/html/box/comment.php"); }?>
<? if($_GET['tab']=="Document"){
include("document.php");
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
        
           <a class="fancybox fancybox.iframe add"  href="addActivity.php?module=Lead&parent_type=<?=$_GET['module']?>&parentID=<?=$_GET['view']?>" >Add Event</a>
      
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
    <table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="5%" class="head1" >
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','activityID','<?=sizeof($arryActivityEvent)?>');" /></td>-->
 
      <td width="15%"  class="head1" >Title</td>
	  <td width="13%" class="head1"> Activity Type </td>
	  <td width="12%" class="head1" >Priority</td>
	  <td width="19%" class="head1" > Start Date</td>
 <td width="19%" class="head1" > Close Date</td>
      <td width="11%"  align="center" class="head1" >  Status</td>
      <td width="12%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryActivityEvent) && $numEvent>0){
  	$flag=true;
	$Line=0;
  	foreach($arryActivityEvent as $key=>$values){
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
	<a href="vLead.php?act_id=<?php echo $values['activityID'];?>&view=<?=$_GET['view']?>&module=<?php echo $_GET['module'];?>&amp;curP=<?php echo $_GET['curP'];?>&tab=Event" onclick="return confirmDialog(this, 'Event')"  ><?=$delete?></a> </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
 <tr>  
 <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryActivityEvent)>0){?>&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink; }?></td>
  </tr>
  </table> 
  </td>
  </tr>  
 </TABLE>
        
        <? }?>
        
        
        <? 
		
if($_GET['tab']=="Task"){?>

	<div id="preview_div">
          
  <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        <a class="add" href="<?=$AddRef?>" >Add Task</a>
        
         
      
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
    <table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="5%" class="head1" >
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','activityID','<?=sizeof($arryActivity)?>');" /></td>-->
  <td width="6%"  class="head1" >ID</td>
      <td width="15%"  class="head1" >Title</td>
	  <td width="13%" class="head1"> Activity Type </td>
	  <td width="12%" class="head1" >Priority</td>
      <td width="12%" class="head1" >Assign To</td>
	  <td width="19%" class="head1" > Add Date</td>
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
      <td ><?=$values["activityID"]?></td>
      <td height="22" > 
	  <?
		  echo  stripslashes($values["subject"]); 
		  
		  
		  ?>		       </td>
		   <td><?=$values['activityType']?></td>
      <td><?  echo $values['priority'];?> </td>
	  <td><?=$values['AssignTo']?> (<?=$values['Department']?>)</td>
      <td>
      <?php  
	   $stdate= $values["startDate"]." ".$values["startTime"];
	 echo date($Config['DateFormat']." ".$Config['TimeFormat'] , strtotime($stdate));?>
      </td>
       
    <td align="center"><? $status = $values['status']; echo $status;?></td>
	<td  align="center" ><a href="vActivity.php?view=<?php echo $values['activityID'];?>&amp;curP=<?php echo $_GET['curP'];?>&module=<?php echo $_GET['module'];?>"><?=$view?></a>
	<a href="editActivity.php?edit=<?php echo $values['activityID'];?>&module=<?php echo $_GET['module'];?>&amp;curP=<?php echo $_GET['curP'];?>&tab=Activity" ><?=$edit?></a>
	<a href="editActivity.php?del_id=<?php echo $values['activityID'];?>&module=<?php echo $_GET['module'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> </td>
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
  </table>      </td>
        </tr>
        
        </TABLE>
        
      </div> 
        <? }?>
        
        
       <?  if($_GET['tab']=="Campaign"){
	   
	   $arryCampaign=$objLead->GetCompaignData($_GET['view'],$_GET['module'],$_GET['tab']);
	
	$num2=$objLead->numRows();
	$pagerLink=$objPager->getPager($arryCampaign,$RecordsPerPage,$_GET['curP']);
	(count($arryCampaign)>0)?($arryCampaign=$objPager->getPageRecords()):("");
	   ?>

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
     
      <td width="16%"  class="head1" >Assign To</td>
      <td width="15%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
	
	
						
					  
  if(is_array($arryCampaign) && $num2>0 ){
  	$flag=true;
	$Line=0;
  	foreach($arryCampaign as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <!-- <td ><input type="checkbox" name="CampaignID[]" id="CampaignID<?=$Line?>" value="<?=$values2['campaignID']?>" /></td>-->
      <td ><?=stripslashes($values["campaignname"])?></td>
      <td> <?=stripslashes($values["campaigntype"])?>	 </td>
	    <td> <?=stripslashes($values["campaignstatus"])?>	 </td>
			
		<td><?=$values['expectedrevenue']?> <?=$Config['Currency']?></td>
        <td> 
	<?  	if($values["closingdate"]!="0000-00-00"){//echo $Config['DateFormat'];
		echo date($Config['DateFormat'] , strtotime($values["closingdate"])); }?> </td>
     
	  <td><a class="fancybox fancybox.iframe" href="../hrms/empInfo.php?view=<?=$values["EmpID"]?>">

<?=$values['AssignTo']?></a></td>
	  
   
      <td  align="center"  >
	   <a href="vCampaign.php?view=<?=$values['campaignID']?>&module=Campaign&curP=<?=$_GET['curP']?>" ><?=$view?></a>
	 
	  <a href="editCampaign.php?edit=<?php echo $values['campaignID'];?>&module=Campaign&amp;curP=<?php echo $_GET['curP'];?>&tab=Edit" ><?=$edit?></a>
	  
	<a href="editCampaign.php?del_id=<?php echo $values['campaignID'];?>&module=Campaign&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, 'Campaign')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num2;?>      <?php if(count($arryCampaign)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>      </td>
        </tr>
        
        </TABLE>
        
      </div> 
        <? }?>
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

<!--  start call history -->
<?php  if($_GET['tab']=='call'){ 
include("includes/html/vCalldetails.php");
  } ?>
<!--  end call history -->


