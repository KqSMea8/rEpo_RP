<script language="JavaScript1.2" type="text/javascript">
function ResetDiv(){
	$("#prv_msg_div").show();
	$("#preview_div").hide();	
	$(".message").hide();	
	$(".add").hide();
	$(".had").hide();		
}
</script>
<div class="had">Bank Details</div>
<? if(!empty($_SESSION['mess_bank'])) {echo '<div class="message" align="center">'.$_SESSION['mess_bank'].'</div>'; unset($_SESSION['mess_bank']); }?>


<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">

	<tr>
	  <td>
<a href="editBank.php?emp=<?=$_GET['emp']?>"  onclick="Javascript:ResetDiv();" class="add">Add <?=$ModuleName?></a>

	  </td>
	  </tr>

 <tr>
	  <td  valign="top">

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div" >
<table <?=$table_bg?> >
   
    <tr align="left"  >
       <td class="head1" >Bank Name</td>
        <td width="20%" class="head1" >Account Name</td>
	 <td width="20%" class="head1" >Account Number</td>

       <td width="15%"  class="head1" >Routing Number </td>
       <td width="12%"  class="head1">Default Account </td>

      <td width="8%"  align="center"  class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryBank) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryBank as $key=>$values){
	$flag=!$flag;
	$Line++;



  ?>
    <tr align="left" <? if($values['DefaultAccount']==1){ echo 'style="background-color:#CAFFCA"'; }?>>
	<td><?=stripslashes($values["BankName"])?></td>

	<td><?=stripslashes($values["AccountName"])?></td>
       <td><?=stripslashes($values["AccountNumber"])?></td>

	<td><?=stripslashes($values["IFSCCode"])?></td>
	<td><?=($values["DefaultAccount"]==1)?("<span class=green>Yes</span>"):("")?></td>

      <td  align="center" class="head1_inner">
  
<a href="editBank.php?edit=<?=$values['BankID']?>&emp=<?=$_GET['emp']?>"  onclick="Javascript:ResetDiv();"><?=$edit?></a>
 
<a href="editBank.php?del_id=<?=$values['BankID']?>&emp=<?=$_GET['emp']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="8" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  
  </td>
  </tr>
  </table>
  </div>
  

</form>

</td>
</tr>
</table>

</div>
<script language="JavaScript1.2" type="text/javascript">
SetDefaultBank('<?=$BankDivHtml?>');
function SetDefaultBank(BankDivHtml){	
	window.parent.document.getElementById("BankDiv").innerHTML= BankDivHtml;
}

</script>
