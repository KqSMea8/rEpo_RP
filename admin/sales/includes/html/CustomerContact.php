<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();	
	$("#preview_div").hide();
}
function SetCustomerContact(Line){
	ResetSearch();
	window.parent.document.getElementById("ContactDiv").innerHTML=document.getElementById("ContactInfoStrip"+Line).value;
	window.parent.document.getElementById("SpiffContact").value= document.getElementById("ContactInfo"+Line).value;    
	parent.jQuery.fancybox.close();
	ShowHideLoader('1','P');
}




</script>
<? if($_GET['CustID']>0){ ?>
<div class="had">Select Customer Contact</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table id="myTable" cellspacing="1" cellpadding="10" width="100%" align="center">
       <?php 
  if(is_array($arryContact) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryContact as $key=>$values){
	$flag=!$flag;
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;


	$ContactInfo = stripslashes($values["FullName"]).'
	<br>|'.nl2br(stripslashes($values["Address"])).',
	<br>|'.htmlentities($values["CityName"], ENT_IGNORE).', |'.stripslashes($values["StateName"]).',
	<br>|'.stripslashes($values["CountryName"]).' - |'.stripslashes($values["ZipCode"]);

	$ContactInfo .=	'<br>|Mobile : |'.stripslashes($values["Mobile"]);
	$ContactInfo .=	'<br>|Landline : |'.stripslashes($values["Landline"]);
	$ContactInfo .=	'<br>|Fax : |'.stripslashes($values["Fax"]);
	$ContactInfo .=	'<br>|Email : |'.stripslashes($values["Email"]);  

	#$arry = explode("|",$ContactInfo); echo '<pre>';print_r($arry);exit;

	$ContactInfoStrip = str_replace("|","",$ContactInfo);
  ?>
    <tr align="left" class="<?=$class?>" >
      <td>
	
<a href="Javascript:void(0);" class="action_bt" style="float:right;" onclick="Javascript:SetCustomerContact('<?=$Line?>')" ><?=CLICK_TO_SELECT?></a>
<?=$Line.'.'.$ContactInfoStrip?>
<input type="hidden" id="ContactInfo<?=$Line?>" value="<?=$ContactInfo?>">	  	  
<input type="hidden" id="ContactInfoStrip<?=$Line?>" value="<?=$ContactInfoStrip?>">	 

	 </td>
  
     </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_CUSTOMER_CONTACT?></td>
    </tr>
    <?php } ?>
  
	
  </table>

  </div> 

  
</form>
</td>
	</tr>
</table>
<? } ?>
