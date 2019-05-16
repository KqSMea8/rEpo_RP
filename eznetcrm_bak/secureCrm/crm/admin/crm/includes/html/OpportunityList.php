<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SelectOpp(OppName,OppID,LeadID){
	ResetSearch();
	window.parent.document.getElementById("Taxable").value='';
	window.parent.document.getElementById('opportunityID').value=OppID;
	window.parent.document.getElementById('opportunityName').value=OppName;	


	window.parent.document.getElementById("bill_street").value='';
	window.parent.document.getElementById("bill_city").value='';
	window.parent.document.getElementById("bill_state").value='';			
	window.parent.document.getElementById("bill_code").value='';
	window.parent.document.getElementById("bill_country").value='';
	/*
	window.parent.document.getElementById("ship_street").value='';
	window.parent.document.getElementById("ship_city").value='';
	window.parent.document.getElementById("ship_state").value='';
	window.parent.document.getElementById("ship_code").value='';
	window.parent.document.getElementById("ship_country").value='';
	*/

	if(LeadID>0){
		
		var SendUrl = "&action=LeadAddressInfo&LeadID="+escape(LeadID)+"&r="+Math.random();
		
		$.ajax({
			type: "GET",
			url: "ajax.php",
			data: SendUrl,
			dataType : "JSON",
			success: function (responseText) {
	

window.parent.document.getElementById("bill_street").value=responseText["Address"];
window.parent.document.getElementById("bill_city").value=responseText["CityName"];
window.parent.document.getElementById("bill_state").value=responseText["StateName"];
window.parent.document.getElementById("bill_country").value=responseText["CountryName"];
window.parent.document.getElementById("bill_code").value=responseText["ZipCode"];	
/*
window.parent.document.getElementById("ship_street").value=responseText["sAddress"];
window.parent.document.getElementById("ship_city").value=responseText["sCityName"];
window.parent.document.getElementById("ship_state").value=responseText["sStateName"];
window.parent.document.getElementById("ship_country").value=responseText["sCountryName"];
window.parent.document.getElementById("ship_code").value=responseText["sZipCode"];
*/


	parent.ProcessTotal();
	/************************************/


			parent.jQuery.fancybox.close();				
					
							   
			}
		});

	}else{
		parent.jQuery.fancybox.close();
	}

	
	
}

</script>

<div class="had">Select Opportunity</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="OpportunityList.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	 <input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
</form>



		</td>
      </tr>
	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
<td width="22%"  class="head1" >Opportunity Name</td>
	  <td width="15%" class="head1"> Sales Stage  </td>
      <td width="15%" class="head1"> Expected Close Date  </td>
	 
    </tr>
   
    <?php 
  if(is_array($arryOpportunity) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryOpportunity as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
 <td><a href="Javascript:void(0);" onclick="Javascript:SelectOpp('<?=$values['OpportunityName']?>','<?=$values['OpportunityID']?>','<?=$values['LeadID']?>')" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()"><?=$values['OpportunityName']?></a></td>
     
     
   
	  
		   <td><?=stripslashes($values["SalesStage"])?></td>
            <td><?=date($Config['DateFormat'],strtotime($values["CloseDate"]))?></td>
      
     
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="3" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  

 <tr>  
 <td  colspan="3" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryOpportunity)>0){?>&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink; }?></td>
  </tr>
  </table> 







   
    

  </div> 


  
</form>
</td>
	</tr>
</table>

