<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SetCustCode(Custid,email){
	ResetSearch();
	window.parent.document.getElementById("paypalemail").value=email;
	parent.jQuery.fancybox.close();
	ShowHideLoader('1','P');
}




</script>

<div class="had">Select Paypal Email</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
    <tr align="left"  > 
      <td width="2%"  class="head1" >S.N.</td>    
       <td width="15%" class="head1" >Email</td>      
    </tr>
   
    <?php 
    
  if(is_array($arryCustomeremails) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCustomeremails as $key=>$values){
 
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	if(empty($values["Taxable"])) $values["Taxable"]="No";
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <td><?php echo $Line;?></td>
    <td>
	<a href="Javascript:void(0)" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" onclick="Javascript:SetCustCode('<?=$values["cusomer_id"]?>','<?php echo $values["email"]?>');"><?=stripslashes($values["email"])?></a>
	</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="2" class="no_record"><?=NO_CUSTOMER?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td   colspan="2" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?></td>
  </tr>
  </table>

  </div> 

  
</form>
</td>
	</tr>
</table>
