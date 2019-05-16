
 
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

<? if($_GET['tab']=="Activity" && (isset($RelatedType) && $RelatedType!='')){?>
<h2><font color="darkred"> <?=$RelatedType?> [<?=$RelatedID?>] : <?=$RelatedTitle?></h2>
<? }?>


  
 <? if (!empty($_SESSION['mess_Event'])) {?>

<div  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_Event'])) {echo $_SESSION['mess_Event']; unset($_SESSION['mess_Event']); }?>	
</div>
<? } ?>
  
  
<? if($_GET['tab']=='Activity'){?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<?php      
//By Chetan26Aug//
$head =1;
$arrayVal= $arryActivity[0];
if($_GET['pop']==1 || $_GET['mode'] == 'Task'){

 $headarry = array_map(function($arr){

    if($arr['head_value'] == 'Related To')
    {
        unset($arr);
    }else{
       return $arr;
    }
}, $arryHead);

$arryHead = array_values(array_filter($headarry));
}
for($h=0;$h<sizeof($arryHead);$h++){
    
    if($arryHead[$h]['head_value']== 'Details'){    
?>
    <tr>
	 <td colspan="8" align="left" class="head"><?php if($arryActivity[0]['activityType']!='Task'){?>Event Details<? }else{?> Task Details <? }?></td>
    </tr>

        <!---Recurring Start-->
        <?php   
        $arryRecurr = $arryActivity;
        include("../includes/html/box/recurring_2column_daily_view.php");
        ?>  
        <!--Recurring End-->
<?php }else{?>
    <tr>
        <td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
    </tr>
                    
<?php }

$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
if($arryActivity[0]['activityType']=='Task'){
    
    if($arryHead[$h]['head_value']== 'Details')
    {
        $Narry = array_map(function($arr){

            if($arr['fieldname']== 'Notification' || $arr['fieldname']== 'visibility' || $arr['fieldname']== 'location')
            {
                unset($arr);
            }else{
               return $arr;
            }
        }, $arryField);
        
        $arryField = array_values(array_filter($Narry));
    }
   
    if($arryHead[$h]['head_value']== 'Reminder Details')
    {
        $N3arry = array_map(function($arr){

            if($arr['fieldname']== 'EmpID')
            {
                unset($arr);
            }else{
               return $arr;
            }
        }, $arryField);
        
        $arryField = array_values(array_filter($N3arry));
    }
    
}    
if($_GET['pop']==1 && $arryHead[$h]['head_value']== 'Details'){

 $N2arry = array_map(function($arr){

    if($arr['fieldname']== 'visibility' || $arr['fieldname']== 'location')
    {
        unset($arr);
    }else{
       return $arr;
    }
}, $arryField);

$arryField = array_values(array_filter($N2arry));

} 

include("includes/html/box/viewCustomFieldsNew.php");

}
 //End//
?>

	
 

<? if($HideNavigation !=1){?>
  <tr>
       		 <td colspan="8" align="left"   ><?php include("includes/html/box/comment.php");?></td>
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

