<div class="left_box">&nbsp;</div>



<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

<?php if($_GET['tab']=="Document"){?>
    <tr>
    <td  align="center" valign="top" > 
     
    <? include("document.php"); ?>
    </td></tr>
     
 <?php } if($_GET['tab']=="Campaign") { ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


    

<?php      
//By Chetan 26Aug//

$head = 1;
$arrayVal= $arryCampaign[0];
for($h=0;$h<sizeof($arryHead);$h++){?>

	<tr>
		<td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
	</tr>

<?php 

$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
include("includes/html/box/viewCustomFieldsNew.php");


}
 //End//
?>   
    
    
 
<tr>
       		 <td colspan="8" align="left"   ><?php include("includes/html/box/comment.php");?></td>
        </tr>

	

	

		
	

</table>	


	
	  
	
	</td>
   </tr>

 <? }?> 

   <tr>
    <td  align="center" >
	







<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />



</td>
   </tr>
   
</table>
</div>

<?php  if($_GET['tab']=="MCampaign") {
    
    
	   $MassMailCampaignId=array();
	   $arryMassMailCampaign=$massmail->GetMailChampCompaignDataInCrmCampaign($_GET['view'],$_GET['module'],$_GET['tab']);
           //echo '<pre>'; print_r($arryMassMailCampaign);die;
           $massCampaignId = $mailMassCmdId = '';$MassmailType = array();
           foreach($arryMassMailCampaign as $mvalues){
               
               $massCampaignId.=$mvalues['compaignID'].",";
               $mailMassCmdId=$mailMassCmdId."'".$mvalues['compaignID']."',";
               //$MassMailCampaignId['id']=$mvalues['compaignID'];
           }
           //echo '<pre>';print_r($mailMassCmdId);
           //echo '<pre>';print_r($massCampaignId);die;
           
           
           //extract($MassMailCampaignId)
           $massCampaignId=  strlen($massCampaignId)?substr($massCampaignId, 0,strlen($massCampaignId)-1):$massCampaignId;
           /*select type function*/
           $mailMassCmdId=  strlen($mailMassCmdId)?substr($mailMassCmdId, 0,strlen($mailMassCmdId)-1):$mailMassCmdId;
           if(!empty($arryMassMailCampaign)){
           $MassmailType=$massmail->GetMassMailType($mailMassCmdId);
           //echo '<pre>';print_r($MassmailType);
           }
           /*select type function*/
           $filter = array('campaign_id'=>$massCampaignId);
           
           //echo '<pre>'; print_r($filter);die;
           $listCampaign = $Mailchimp_Campaigns->getList($filter);
         //echo "<pre>";print_r($listCampaign);die;
         //$filattr=array('id','folder_id','status');
         $filattr = array('title','subject','status','from_email','from_name','create_time','send_time','emails_sent','summary','folder_id','id');
         $MassMailupdatelistcmp = $massmail->filterArray($filattr, $listCampaign['data']);
         
         //echo '<pre>'; print_r($MassMailupdatelistcmp);
         /*Start code for merge Array*/
         for($i=1;$i<sizeof($MassMailupdatelistcmp);$i++){
             
             if(!empty($MassmailType)){
             	$fresults[$i] =  array_merge($MassMailupdatelistcmp[$i],$MassmailType[$i-1]);
             }else{
				$fresults[$i] =  $MassMailupdatelistcmp[$i];
			 }
             
         }
         //echo '<pre>';print_r($fresults);
         /*End code for merge Array*/
         
           //echo $massCampaignId;die;
	if(empty($fresults)) $fresults = array();
	$numMassMail=$massmail->numRows();
	$pagerLink=$objPager->getPager($fresults,$RecordsPerPage,$_GET['curP']);
	(count($fresults)>0)?($fresults=$objPager->getPageRecords()):("");
	   ?>

	<div id="preview_div">
          
  <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        <a class="button" style="font-size:12px; color:#FFFFFF;" href="javascript:void(0)" onclick="return window.open('Mass_mail_Compaign.php?module=<?=$_GET['tab']?>&amp;return_module=<?=$_GET['module']?>&amp;parent_type=<?=$_GET['module']?>&amp;parentID=<?=$_GET['view']?>','test','width=640,height=602,resizable=0,scrollbars=0');" ><b>Select Mass Mail Campaign</b></a>
               
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
    <table <?=$table_bg?>>  

	 <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CampaignID','<?=sizeof($arryCampaign)?>');" /></td>-->
      <td width="18%"  class="head1" >Campaign Name</td>
      <td width="14%"  class="head1" >Campaign Type</td>
      <td width="12%"  class="head1" >Campaign Status</td>
       <!--<td width="12%" class="head1" >Expected Revenue</td>-->
      <td width="13%" class="head1" >Send Campaign Date</td>
      <td width="15%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
	
					  
  if(is_array($fresults) && (!empty($arryMassMailCampaign))){
  	$flag=true;
	$Line=0;
    $i=0;
	$num2 = count($fresults);
	if($num2 > 0){
  	foreach($fresults as $values){ 
            
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
            //echo '<pre>';print_r($values);die;
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <!-- <td ><input type="checkbox" name="CampaignID[]" id="CampaignID<?=$Line?>" value="<?=$values2['campaignID']?>" /></td>-->
      <td ><?php echo $values['title'];?></td>
      <td> <?php echo $values['type'];?>	 </td>
	    <td> <?php echo $values["status"]?>	 </td>
			
		<!--<td></td>-->
        <td> 
	<?php  	if(!empty($values["send_time"])){//echo $Config['DateFormat'];
		echo date($Config['DateFormat'] , strtotime($values["send_time"])); }
                else{
                    echo '<span class="red">Not specified.</span>';
                }
                ?> </td>
     
	  
	  
   
      <td  align="center">
          <?php if($values["status"]=='sent'){ ?>
	   <a href="javascript:void(0)" onclick="return window.open('Mass_mail_Compaign_Report.php?MassCampaignID=<?php echo $values['id'];?>','test','width=640,height=602,resizable=no,scrollbars=yes,toolbar=no,menubar=no,titlebar=no,top=100,left=100');"><?=$view?></a>
          <?php } ?>
	  <!--<a href="editCampaign.php?edit=<?php echo $values['campaignID'];?>&module=Campaign&amp;curP=<?php echo $_GET['curP'];?>&tab=Edit" ><?=$edit?></a>-->
	  
	<a href="editCampaign.php?Mdel_id=<?php echo $values['id'];?>&module=Campaign&amp;curP=<?php echo $_GET['curP'];?>&parent_type=<?php echo $_GET['module']; ?>&parentID=<?php echo $_GET['view'];?>&mode_type=<?php echo $_GET['tab'];?>" onclick="return confirmDialog(this, 'Campaign')"  ><?=$delete?></a></td>
    </tr>
    <?php  $i++; // foreach end //?>
  
        <?php }	}else{ ?> 

 <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>

		<? } }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo isset($num2) ? $num2 : '';?>      <?php if(count($fresults)>0 && !empty($arryMassMailCampaign)){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>      </td>
        </tr>
        
        </TABLE>
        
      </div> 
<?php } ?>





