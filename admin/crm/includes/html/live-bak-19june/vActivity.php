
 
<? if($HideNavigation !=1){?>


<?
	/*********************/
	/*********************/
	$startDate = $arryActivity[0]["startDate"];
	$startTime = $arryActivity[0]["startTime"];
   	$NextID = $objActivity->NextPrevActivity($_GET['view'],$startDate,$startTime,1);
	$PrevID = $objActivity->NextPrevActivity($_GET['view'],$startDate,$startTime,2);
	$NextPrevUrl = "vActivity.php?module=".$_GET["module"]."&curP=".$_GET["curP"];
	include("includes/html/box/next_prev.php");
	/*********************/
	/*********************/
?>





<a class="back" href="<?=$RedirectURL?>">Back</a><a class="edit" href="<?=$EditUrl?>">Edit</a>


<a href="outlookEvent.php?activityID=<?=$_GET['view']?>" class="download" style="float:right;margin-left:5px;">Save to outlook</a>

<a class="download" style="float:right;" target="_blank" href="pdfEventView.php?activityID=<?=$_GET['view']?>">Download</a>

<div class="had">
Manage Activity   &raquo; <span>
	<? 	echo (!empty($_GET['view']))?($_GET['tab']) :($ModuleName); ?>
		
		</span>
</div>
<? }?>




<? if($_GET['tab']!="Activity"){?>
<h2><font color="darkred"> Activity [<?=$arryActivity[0]['activityID']?>] :  <?=stripslashes($arryActivity[0]['subject'])?></h2>
<? }?>

<? if($_GET['tab']=="Activity" && $RelatedType!=''){?>
<h2><font color="darkred"> <?=$RelatedType?> [<?=$RelatedID?>] : <?=$RelatedTitle?></h2>
<? }?>


  
 <? if (!empty($_SESSION['mess_Event'])) {?>

<div  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_Event'])) {echo $_SESSION['mess_Event']; unset($_SESSION['mess_Event']); }?>	
</div>
<? } ?>
  
  
<? if($_GET['tab']=='Activity'){?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  


<tr>
	 <td colspan="4" align="left" class="head_event"><? if($arryActivity[0]['activityType']!='Task'){?>Event Details<? }else{?> Task Details <? }?></td>
</tr>


<!---Recurring Start-->

<?php   
        $arryRecurr = $arryActivity;

        include("../includes/html/box/recurring_2column_daily_view.php");
        ?>  
       
        <!--Recurring End-->
     <tr>
        <td  align="right"   class="blackbold" width="20%"> Subject  :</td>
        <td   align="left"  width="25%">
        <?php echo stripslashes($arryActivity[0]['subject']); ?>            </td>
        
        <td  align="right"   class="blackbold" valign="top"  width="25%"> Assigned To  : </td>
        <td   align="left" >

<? 

if(!empty($arryActivity[0]['assignedTo'])){

if($arryActivity[0]['AssignType'] == 'Group'){ ?>
            <?=$AssignName ?> <br>
<? }?>
<div> <? foreach($arryAssignee as $values) {

?>
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$values['EmpID']?>" ><?=$values['UserName']?></a>,
<? } } else{  echo NOT_SPECIFIED;}?>



     </td>
      </tr>

	  

	  <tr>
        <td  align="right"   class="blackbold">Start Date & Time : </td>
        <td   align="left" >

  <?php  
	   $stdate= $arryActivity[0]["startDate"]." ".$arryActivity[0]["startTime"];
	 echo date($Config['DateFormat']." ".$Config['TimeFormat'] , strtotime($stdate));?>
		
                    </td>
    
        <td  align="right"   class="blackbold">Close Date & Time : </td>
        <td   align="left" >
<?php  
	   $ctdate= $arryActivity[0]["closeDate"]." ".$arryActivity[0]["closeTime"];
	 echo date($Config['DateFormat']." ".$Config['TimeFormat'] , strtotime($ctdate));?>
		
                    </td>
      </tr>
       <tr>
        <td  align="right"   class="blackbold">  Status  : </td>
        <td   align="left" >

		<?php echo stripslashes($arryActivity[0]['status']);?>
            </td>
      
        <td  align="right"   class="blackbold">  Customer : </td>
        <td   align="left" >
<? if(!empty($arryCustomer[0]['FullName'])){?><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arryCustomer[0]['CustCode']?>"><?=(stripslashes($arryCustomer[0]['FullName']))?> </a> <?} else { echo NOT_SPECIFIED;?> <? }?>	    

            </td>
            </tr>

      <tr>
        <td  align="right"   class="blackbold"> Activity Type : </td>
        <td   align="left" >
<?=(!empty($arryActivity[0]['activityType']))?(stripslashes($arryActivity[0]['activityType'])):(NOT_SPECIFIED)?>
		
                     </td>
	 
<td  align="right"   class="blackbold"> Priority : </td>
<td   align="left" >
<?=(!empty($arryActivity[0]['priority']))?(stripslashes($arryActivity[0]['priority'])):(NOT_SPECIFIED)?>
</td>
</tr>


<? if($arryActivity[0]['activityType']!='Task'){?>

   <tr>  
<td  align="right"   class="blackbold"> Send Notification : </td>
<td   align="left" >
<?php if($arryActivity[0]['Notification']==1){ $Notification="Yes";}else{$Notification="No";}echo stripslashes($Notification); ?>  </td>

	<? if($_GET['pop']!=1){?>	

	<td  align="right"   class="blackbold"> Location : </td>
	<td   align="left" >
	<?=(!empty($arryActivity[0]['location']))?(stripslashes($arryActivity[0]['location'])):(NOT_SPECIFIED)?>
	</td>

	<? }?>

 </tr>



<? if($_GET['pop']!=1){?>
<tr>
<td  align="right"   class="blackbold"> Visibility : </td>
<td   align="left" >
<?=(!empty($arryActivity[0]['visibility']))?(stripslashes($arryActivity[0]['visibility'])):(NOT_SPECIFIED)?>
</td>
</tr>
  <? }?> 




<? }?>




    
      <tr>
	 <td colspan="4" align="left" class="head_reminder">Reminder</td>
</tr>
       <tr>
        <td  align="right"   class="blackbold"> Reminder : </td>
        <td   align="left" colspan="3">
        <?php if($arryActivity[0]['reminder']==1){

$reminder="Yes";
}else{
$reminder="No";
}

echo stripslashes($reminder);?> </td>
      </tr>
<? if($arryActivity[0]['activityType']!='Task'){?>
 <tr>
        <td  align="right"  class="blackbold"> Invite Users : </td>
        <td   align="left" colspan="3"><?=(!empty($ActUrl))?($ActUrl):(NOT_SPECIFIED)?>
        </td>
      </tr>
 <? if($HideNavigation !=1){?>


<? if($RelatedType!=''){?>
      <tr>
	 <td colspan="4" align="left" class="head_related">Related To</td>
</tr>
       <tr>
        <td  align="right"   class="blackbold"> Related Type : </td>
        <td   align="left" colspan="3"><?=$RelatedType?> </td>
      </tr>
<tr>
<td align="right"   class="blackbold">
	<?=$RelatedType?> :
</td>
<td align="left" colspan="3">
	<?=$RelatedHTML?> 
</td>
</tr>
<? } ?>



    <? } }?>  

	 <tr>
       		 <td colspan="4" align="left"   class="head_desc">Description Details</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" colspan="3">
            <? echo stripslashes($arryActivity[0]['description']); ?>

	          </td>
        </tr>

	
 

<? if($HideNavigation !=1){?>
  <tr>
       		 <td colspan="4" align="left"   ><?php include("includes/html/box/comment.php");?></td>
        </tr> 
<?}?>



</table>	
  
<? }?>
	<?php if($_GET['tab']=='Comments'){ include("includes/html/box/comment.php"); }?>
   <? if($_GET['tab']=="Document"){ 
       
              include("includes/html/box/document.php");
   
 }?>
	
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
   
    

	 <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CampaignID','<?=sizeof($arryCampaign)?>');" /></td-->
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
        
        
        

<? if($_GET['tab']=='Ticket'){?>
 

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
        <a href="<?=$AddUrl?>" class="add" >Add  Ticket</a>
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
	 &nbsp;&nbsp; <a href="<?=$editTicket?><?php echo $values['TicketID'];?>&curP=<?php echo $_GET['curP'];?>&tab=Information" ><?=$edit?></a>
	  
	&nbsp;&nbsp;<a href="<?=$DelTicket?><?php echo $values['TicketID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
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

