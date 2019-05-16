<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewCompany.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewCompany.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>
<div class="had">Manage Company</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" >
		
		<? if($_GET['key']!='') {?>
		  <input type="button" class="view_button"  name="view" value="View All" onclick="Javascript:window.location='viewCompany.php';" />
		<? }?>
		
		<? if($_SESSION['AdminType']=="admin"){?>
		<a href="editCompany.php" class="add">Add Company</a>
		<? }?>



</td>
      </tr>
	<tr>
	  <td  valign="top">
	  
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table id="list_table" cellspacing="1" cellpadding="3" width="100%" align="center">
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CmpID','<?=sizeof($arryCompany)?>');" /></td>-->
      <td width="15%"  class="head1" >Company Name</td>
      <td width="8%"  class="head1" >Company ID</td>
       <td width="12%" class="head1" >Display Name</td>
     <td  class="head1" >Email</td>
	<td width="8%" class="head1" >Package</td>
	<td width="15%" class="head1" >Expiry Date</td>
	
      <td width="6%"  align="center" class="head1" >Status</td>
      <td width="6%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 

$deleteCmp = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Confirm Delete</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';

$resend = '<img src="'.$Config['Url'].'admin/images/email.png" border="0"  onMouseover="ddrivetip(\'<center>Re-Send Activation Email</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';

  if(is_array($arryCompany) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCompany as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }


	//$AdminUrl = $Config['Url'].$values["DisplayName"].'/'.$Config['AdminFolder']."/";


  ?>
    <tr align="left"  bgcolor="#ffffff">
      <!--<td ><input type="checkbox" name="CmpID[]" id="CmpID<?=$Line?>" value="<?=$values['CmpID']?>" /></td>-->
     
      <td height="50" >
	  <a href="editCompany.php?edit=<?=$values['CmpID']?>&curP=<?=$_GET['curP']?>" ><strong><?=stripslashes($values["CompanyName"])?></strong></a> 

		 </td>
		  

		   <td ><?=$values["CmpID"]?></td>
		    <td><?=$values["DisplayName"]?></td>   
      <td><?  echo '<a href="mailto:'.$values['Email'].'">'.$values['Email'].'</a>'; ?></td>
<td><?=ucfirst($values["PaymentPlan"])?></td>   
     <td ><?  if($values['ExpiryDate']>0){
		echo date("j F, Y",strtotime($values['ExpiryDate']));
	      }
	      
	?></td>


 
    <td align="center"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editCompany.php?active_id='.$values["CmpID"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
		
	 ?></td>
      <td  align="center"  class="head1_inner"><a href="editCompany.php?edit=<?=$values['CmpID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
	  
	<!--a href="editCompany.php?del_id=<?php echo $values['CmpID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confDel('<?=$ModuleName?>')"  ><?=$delete?></a-->   

<a href="deleteCompany.php?del_id=<?php echo $values['CmpID'];?>&amp;curP=<?php echo $_GET['curP'];?>"   ><?=$deleteCmp?></a> 




</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCompany)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryCompany)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','CmpID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','CmpID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','CmpID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
