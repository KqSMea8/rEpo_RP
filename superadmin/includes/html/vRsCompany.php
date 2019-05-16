


<div ><a href="<?=$RedirectURL?>" class="back">Back</a></div>


<div class="had">
Manage Reseller    <span> &raquo; Companies</span>
</div>
<? if (!empty($errMsg)) {?>
<div height="2" align="center"  class="red" ><?php echo $errMsg;?></div>

<? }else{ ?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<tr>
  <td  valign="top" align="left">

<table width="38%" border="0" cellpadding="5" cellspacing="0" class="borderall" style="margin:0;">
  <tr>
        <td  align="right"   class="blackbold" width="30%" > Reseller Name  : </td>
        <td   align="left" >
<strong><?php echo stripslashes($arryReseller[0]['FullName']); ?></strong>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Reseller ID  :</td>
        <td   align="left" >
<?php echo stripslashes($arryReseller[0]['RsID']); ?>
           </td>
      </tr>
  
<tr>
	 <td  align="right">Email : </td>
 <td  align="left">
<?php echo stripslashes($arryReseller[0]['Email']); ?>
</td>
</tr>

<tr>
        <td  align="right"   class="blackbold"  > Company Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryReseller[0]['CompanyName']); ?>
           </td>
      </tr>
</table>

</td>
</tr>

<tr>
  <td  valign="top" align="left">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CmpID','<?=sizeof($arryCompany)?>');" /></td>-->
      <td width="18%"  class="head1" >Company Name</td>
      <td width="8%"  class="head1" >Company ID</td>
       <td width="12%" class="head1" >Display Name</td>
     <td  class="head1" >Email</td>
	<td width="12%" class="head1" >Package</td>
	<td width="15%" class="head1" >Expiry Date</td>

	
      <td width="6%"  align="center" class="head1" >Status</td>
      <!--td width="6%"  align="center" class="head1" >Action</td-->
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
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="CmpID[]" id="CmpID<?=$Line?>" value="<?=$values['CmpID']?>" /></td>-->
     
      <td height="50" >
	  <a href="editCompany.php?edit=<?=$values['CmpID']?>&curP=<?=$_GET['curP']?>" target="_blank" ><strong><?=stripslashes($values["CompanyName"])?></strong></a> 
	  	

  <? if($values["DefaultCompany"]==1){
	     echo '<img src="../images/HomeIcon.png" border="0" style="float:right" onMouseover="ddrivetip(\'<center>Default Company</center>\', 120,\'\')"; onMouseout="hideddrivetip()" >';
   }?>



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
			  $status = 'Active';  $statusCls = 'green';
		 }else{
			  $status = 'InActive';  $statusCls = 'red';
		 }
	
	 

	echo '<span class="'.$statusCls.'">'.$status.'</span>';
		
	 ?></td>
      <!--td  align="center"  class="head1_inner"><a href="editCompany.php?edit=<?=$values['CmpID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
	  
	

<a href="deleteCompany.php?del_id=<?php echo $values['CmpID'];?>&amp;curP=<?php echo $_GET['curP'];?>"   ><?=$deleteCmp?></a> 

<? if($values['Status'] !=1){?>
<a class="fancybox fancybox.iframe" href="resendActivationEmail.php?CmpId=<?=$values['CmpID']?>"><?=$resend?></a> 	
<? }?>


</td-->
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





</td>
</tr>
</table>
<? } ?>
 

	

