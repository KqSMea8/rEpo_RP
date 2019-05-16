<?
$arryDocument = $objCommon->getActiveDocument(8);
?>
<div class="rows clearfix" >
          <div class="first_col" style="<?=$WidthRow1?>">
            <div class="block reporting">
				
              <h3>Reporting</h3>
			   <div class="bgwhite">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <? if(!empty($arrySupervisor[0]['UserName'])){ ?>
				<tr>
                  <td>Report To:</td>
                  <td><span class="reo_name"></span>			
		   	  <?=$arrySupervisor[0]['UserName']?>
		    
			</td>
                </tr>
				
				<tr>
                  <td>Designation:</td>
                  <td><?=stripslashes($arrySupervisor[0]['JobTitle'])?></td>
                </tr>
				
				<tr>
                  <td>Department:</td>
                  <td><?=$arrySupervisor[0]['Department']?> </td>
                </tr>
				<? }else{ ?>
				<tr>
                  <td>Report To:</td>
                  <td>
				<?=NOT_ASSIGNED?>
				</td>
                </tr>
				<? } ?>
				
              <? if(!empty($arryEmployee[0]['ReportingMethod'])){ ?>
                <tr class="bord_none">
                  <td>Reporting Method:</td>
                  <td><?=$arryEmployee[0]['ReportingMethod']?> </td>
                </tr>
				<? } ?>
              </table>
			  </div>
			
            </div>
          </div>
          <div class="second_col" style="<?=$WidthRow2?>">
            <div class="block thingstodo">
			
              <h3>Leave Summary</h3>
	 <div class="bgwhite"  	>		  
   <table width="100%" border="0" cellspacing="0" cellpadding="0" >
    <tr >
		<td>Type</td>
		<td width="20%">Entitlements</td>
		<td width="20%">Pending</td>
		<td width="20%">Approved</td>
		<td width="16%">Balance</td>
    </tr>
   
    <?php 
  if(is_array($arryLeave)){
	$flag=true;
	$Line=0;
	$TotalEntitle=0; $TotalPending=0; $TotalApproved=0; $TotalBalance=0;
	foreach($arryLeave as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	$EntitleDays = $objLeave->getLeaveEntitle($_GET['emp'],$values["attribute_value"]);
 	$PendingLeave = $objLeave->getLeaveByStatus($_GET['emp'],"'Pending'",$values["attribute_value"]);
  	$ApprovedLeave = $objLeave->getLeaveByStatus($_GET['emp'],"'Approved','Taken'",$values["attribute_value"]);
	$Balance = 0;
	//if($EntitleDays>0){
		$Balance = $EntitleDays - $ApprovedLeave;
		//if($Balance<=0) $Balance = 0;
	//}
?>
    <tr align="left"  bgcolor="<?=$bgcolor55?>">
      <td ><?=$values["attribute_value"]?></td>
      <td ><?=$EntitleDays?></td>
      <td ><?=$PendingLeave?></td>
      <td><?=$ApprovedLeave?></td>
      <td ><?=$Balance?></td>
    </tr>
    <?php 
	$TotalEntitle += $EntitleDays;
	$TotalPending += $PendingLeave;
	$TotalApproved += $ApprovedLeave;
	$TotalBalance += $Balance;
	} // foreach end //?>
  
   <tr >
	<td>Total :</td>
	<td><?=$TotalEntitle?></td>   
	<td><?=$TotalPending?></td>
	<td><?=$TotalApproved?></td>   
	<td><?=$TotalBalance?></td>   
  </tr>
  
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="5" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  

  </table>
</div>

			  
            </div>
          </div>
          <div class="third_col" style="<?=$WidthRow3?>">
            <div class="block today_task">
              <h3>Documents</h3>
               <div class="bgwhite" style="height:270px;overflow-y:auto;">
			  	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <? $DocExist=0;
			if(sizeof($arryDocument)>0){
                                         
				foreach($arryDocument as $key=>$values){
					 $document = stripslashes($values['document']);                                         
					if(IsFileExist($Config['H_DocumentDir'],$document) ){ 
					$DocExist=1;
				?>
				<tr>
                  <td><a href="../download.php?file=<?=$document?>&folder=<?=$Config['H_DocumentDir']?>" alt="Download" title="Download"><img src="../images/download.png"  border="0">&nbsp;<?=stripslashes($values['heading'])?></a></td>
                </tr>  
				<? } }} 
				if($DocExist!=1){
				?>
				 <tr>
                  <td><?=NO_DOCUMENT?></td>
                </tr>
				<? } ?>
              </table>
			
              </div>
            </div>
          </div>
        </div>
