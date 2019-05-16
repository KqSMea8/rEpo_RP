<? include_once("../includes/settings.php");
include_once("../includes/permission.php");
require_once($Prefix."classes/lead.class.php");


$objLead=new lead();
$RecordsPerPage=15;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" rel="stylesheet" href="../../css/admin.css">
<title><?=$_GET['module']?></title>

<script>
function SelectCheckBoxes(MainID,ToSelect,Num)
{	


	var flag,i;
	if(document.getElementById(MainID).checked){
		flag = true;
	}else{
		flag = false;
	}
	
	for(i=1; i<=Num; i++){
		document.getElementById(ToSelect+i).checked=flag;
	}

}
</script>
</head>

<body>

<?php 
if($_POST){
	CleanPost(); 
	$objLead->AddMultipleCompaign($_POST);
	echo '<script type="text/javascript">window.opener.location.reload(true);</script>';
	echo '<script type="text/javascript">window.close();</script>';
}


	
	
	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objLead->RemoveLead($del_id);
					}
					$_SESSION['mess_opp'] = OPP_REMOVE;
					break;
			case 'active':
					$objLead->MultipleLeadStatus($multiple_action_id,1);
					$_SESSION['mess_opp'] = OPP_REMOVE;
					break;
			case 'inactive':
					$objLead->MultipleLeadStatus($multiple_action_id,0);
					$_SESSION['mess_opp'] = OPP_REMOVE;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	?>
    
<div class="wrapper">

<h1> <?=$_GET['module']?></h1>

<? if($_GET['module']=='Campaign'){
$arryCampaign=$objLead->ListCampaign('',$_GET['key'],$_GET['sortby'],'',$_GET['asc']);
	$num=$objLead->numRows();

	$pagerLink=$objPager->getPager($arryCampaign,$RecordsPerPage,$_GET['curP']);
	(count($arryCampaign)>0)?($arryCampaign=$objPager->getPageRecords()):("");

?>
<div id="preview_div">  

<form action="" method="post" name="form1">
<TABLE WIDTH="620"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
        <input type="submit" value=" Select Compaign  " id="SubmitButton" class="button" name="Submit">
        
         <input type="hidden" value="<?=$_GET['parent_type']?>" id="parent_type"  name="parent_type">
          <input type="hidden" value="<?=$_GET['parentID']?> " id="parentID"  name="parentID">
		  <input type="hidden" value="<?=$_GET['module']?> " id="mode_type"  name="mode_type">
        
          
      
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
      
   
   <table id="list_table" width="100%" cellspacing="1" cellpadding="3" align="center">
   
    <tr align="left"  >
    <td width="5%" class="head1" >
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ID','<?=sizeof($arryCampaign)?>');" /></td>

      <td width="22%"  class="head1" >Campaign Name</td>
	  <td width="15%" class="head1"> Campaign Type </td>
	 
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
      <td ><input type="checkbox" name="ID[]" id="ID<?=$Line?>" value="<?=$values['campaignID']?>" /></td>
      <td ><?=stripslashes($values["campaignname"])?></td>
   
	  
		   <td><?=stripslashes($values["campaigntype"])?></td>
     
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
 <tr>  
 <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCampaign)>0){?>&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink; }?></td>
  </tr>
  </table> 
  
  </td>
  </tr>  
 </TABLE>
 </form>
 </div>
 <? }?>

 <? if($_GET['module']=='Ticket'){
	 
	 
	$arryTicket = $objLead->ListTicket($_GET); 
	$num=$objLead->numRows();

	$pagerLink=$objPager->getPager($arryTicket,$RecordsPerPage,$_GET['curP']);
	(count($arryCampaign)>0)?($arryTicket=$objPager->getPageRecords()):("");
	 
	 
	 
	 
	 ?>
<div id="preview_div">  

<form action="" method="post" name="form1">
<TABLE WIDTH="620"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
        <input type="submit" value=" Select Ticket " id="SubmitButton" class="button" name="Submit">
        
         <input type="hidden" value="<?=$_GET['parent_type']?>" id="parent_type"  name="parent_type">
          <input type="hidden" value="<?=$_GET['parentID']?> " id="parentID"  name="parentID">
		  <input type="hidden" value="<?=$_GET['module']?> " id="mode_type"  name="mode_type">
        
          
      
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
      
   
   <table id="list_table" width="100%" cellspacing="1" cellpadding="3" align="center">
   
    <tr align="left"  >
    <td width="5%" class="head1" >
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ID','<?=sizeof($arryTicket)?>');" /></td>

      <td width="22%"  class="head1" >Ticket Name</td>
	  <td width="15%" class="head1"> Ticket Status </td>
	 
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
      <td ><input type="checkbox" name="ID[]" id="ID<?=$Line?>" value="<?=$values['TicketID']?>" /></td>
      <td ><?=stripslashes($values["title"])?></td>
   
	  
		   <td><?=stripslashes($values["Status"])?></td>
     
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
 <tr>  
 <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryTicket)>0){?>&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink; }?></td>
  </tr>
  </table> 
  
  </td>
  </tr>  
 </TABLE>
 </form>
 </div>
 <? }?>
 </div>
</body>
</html>
