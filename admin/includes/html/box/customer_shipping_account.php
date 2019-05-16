<?  
if($CustID>0){


	$ShipCareers = explode(',', $arryCompany[0]['ShippingCareerVal']);
	 

	if(empty($ShipCareers[0])){
		echo $ErrorMsg = '<div class="redmsg" align="center">'.SHIPP_CAREER_NOT_MAPPED.'</div>';

	}else{

		if(empty($_GET['tp'])) $_GET['tp'] = $ShipCareers[0];

		$Type=$_GET['tp'];
		$arryShipAccount=$objCustomer->ListCustShipAccount($Type,$CustID);

	
	if($_GET['edit']>0){
		$ParentUrl = 'editCustomer.php?edit='.$_GET['edit'].'&tab='.$_GET['tab'];
	}else{
		$ParentUrl = 'vCustomer.php?view='.$_GET['view'].'&tab='.$_GET['tab'];
	}

	 
?>


<script>
    $(function(){
      // bind change event to select
     	 $('#ShipCareer').on('change', function () {
          var Career = $(this).val(); // get selected value
          if (Career) { // require a URL
		ShowHideLoader('1','F');
		window.location = '<?php echo $ParentUrl;?>&tp='+Career; 
          }
          return false;
      });
    });
</script>

<table id="search_table" cellspacing="0" cellpadding="0" border="0"
	style="margin: 0">
	<?php if($arryCompany[0]['ShippingCareer']==1 && $arryCompany[0]['ShippingCareerVal']!=''){?>
	<form name="frmSrch" id="frmSrch" action="accountHistory.php"
		method="get">
	<tr>
		<td align="left"><select id="ShipCareer" name="ShipCareer" class="textbox"
			style="width: 82px;">
			<?php
			
			foreach($ShipCareers as $ShipCareer){?>
			<option value="<?=$ShipCareer;?>"
			<?php if($ShipCareer==$_GET['tp']){echo "selected";}?>><?=$ShipCareer;?></option>
			<?php } ?>
		</select>




</td>
	</tr>
	</form>
	<?php } ?>
</table>

<br>
<? if($_GET['edit']>0){ ?>	
<br>
<a class="fancybox add fancybox.iframe" href="../editCustShippingAccount.php?CustID=<?=$CustID?>&type=<?=$Type?>">Add Shipping Account</a>
<br><br>
<? } ?>


<table id="myTable" cellspacing="1" cellpadding="10" width="100%" align="center">
   
<?
 
if($_GET['tp']=='UPS'){ //UPS
	$MeterLable = 'Account Number';
	$Username = 'Account Number'; //$Username = 'Username';
}else{ //Fedex
	$MeterLable = 'Meter Number';
	$Username = 'Account Number';
}


if($_GET['tp']=='DHL'){ //DHL
 	$ApiKeyLable = 'Site ID';
	$HideMeter = 'Style="display:none"';
}else{ //Other
	$ApiKeyLable = 'API Key';
}

?>


<tr align="left">
				<td class="head1"><?=$Username?></td>				 
				<td class="head1">Shipping Carrier</td>
				<td class="head1">Default Account</td>
				<? if($_GET['edit']>0){ ?> <td align="center" class="head1 head1_action">Action</td><?}?>
			</tr>



<?
 if(sizeof($arryShipAccount)>0){ 
  	$flag=true;
	$Line=0;
  	foreach($arryShipAccount as $key=>$values){
	$flag=!$flag;
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;
	
  ?>
    <tr align="left" class="<?=$class?>" >
		<td><?=$values["api_account_number"]?></td>
		 
		<td><?=$values["api_name"]?></td>
		<td><?=($values['defaultVal']=='1')?('Yes'):('')?></td>
     <? if($_GET['edit']>0){ ?> 
<td  align="center" class="head1_inner">
  
<a href="../editCustShippingAccount.php?edit=<?=$values['ID']?>&CustID=<?=$CustID?>&type=<?=$values['api_name']?>"  class="fancybox fancybox.iframe"><?=$edit?></a>
 
<a href="editCustomer.php?del_account=<?=$values['ID']?>&CustID=<?=$CustID?>&type=<?=$values['api_name']?>" onclick="return confirmDialog(this, 'Shipping Account')"  ><?=$delete?></a>   </td>
<? } ?>

  
     </tr>
    <?php 
	

} // foreach end //

	



?>

		 


  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record" colspan="4"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  </table>
<input type="hidden" name="CurrentDivision" id="CurrentDivision" value="<?=strtolower($CurrentDepartment)?>">		  	 
		
<? }

}

 ?>
