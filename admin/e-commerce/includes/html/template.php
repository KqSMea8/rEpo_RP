<?

//$TempDir = $Config['SaUrl']."template/";

$TempDir = $Prefix."template/";

?>
<div class="had"><?=$MainModuleName?> </div>

<form name="form1" id="form1" action="" method="post"  enctype="multipart/form-data">
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
			
            <div class="message"><? if (!empty($_SESSION['mess_Page'])) {
				echo stripslashes($_SESSION['mess_Page']);
				unset($_SESSION['mess_Page']);
			} ?></div>
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            
							<?php
							
							$numCols = 3;
							
							echo "<table width=\"100%\"  border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"borderall\">\n";
							echo "\t<tr>\n";
							   
							foreach( $arryTemplates as $i => $values )
							{
								if ( $i != 0 && $i++ % $numCols == 0 )
								{
									echo "\t</tr>\n\t<tr>\n";
								}
								
								if($values['TemplatePrice']>0){
									$Priceval='$'.$values['TemplatePrice'];
								}else {
									$Priceval='Free';
								}
								echo "\t\t<td class=\"blackbold\"><div class=\"template-thumb\" id=\"thumb".$values['TemplateId']."\"><img width=\"205px;\" height=\"150px;\" src=\"".$TempDir.$values['TemplateName']."/".$values['Thumbnail']."\" ></div>
								<div>".$Priceval." <div>
								<div id=\"templatediv".$values['TemplateId']."\"><input type=\"button\"   onclick=\"addtopurchase('".$values['TemplateId']."')\" name=\"activate\" value=\"Buy\" class=\"apply\"></div>
								<div style=\"display:none;\"><input type=\"checkbox\" name=\"templateId[]\" id=\"templateId".$values['TemplateId']."\" value=\"".$values['TemplateId']."\" ></div>
								</td>\n";
								
								
								$TemplateId .=$values['TemplateId'].',';
								$TemplatePrice .=$values['TemplatePrice'].',';
								
							}
							
							echo "\t</tr>\n";
							echo '</table>';
							?>
							
							
							
							</td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                           <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall" style="display:none;" id="amounttbl">
                           <tr>
                           <td><b>Total</b> :</td>
                           <td id="totalamount">$0</td>
                           <td><input type="submit" class="button" value="Make Payment" ></td>
                           </tr>
                           </table>
                           
                           
                        </td> 
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
function submitform(templateId){
	
	$('#TemplateId').val(templateId);
	$( "#form1" ).submit();
}

function addtopurchase(templateId){	
	document.getElementById("templateId"+templateId).checked=true; 
	document.getElementById("templatediv"+templateId).innerHTML = '<input type="button"   onclick="substracttopurchase('+templateId+')" name="activate" value="Added" class="activate">';	 
	calculatetotal();
	jQuery('#thumb'+templateId).addClass('active');
}
function substracttopurchase(templateId){	
	document.getElementById("templateId"+templateId).checked=false; 
	document.getElementById("templatediv"+templateId).innerHTML = '<input type="button"   onclick="addtopurchase('+templateId+')" name="activate" value="Buy" class="apply">';	 
	calculatetotal();
	jQuery('#thumb'+templateId).removeClass('active');
}
function calculatetotal(){	
	
	var Ids = [<?php echo $TemplateId?>];  
	var prices = [<?php echo $TemplatePrice?>];

	var totalPrice=0;
	var count=0
	$('input[name="templateId[]"]:checked').each(function(index,val) {
		 
		 var arraykey=$.inArray( parseInt($(this).val()) , Ids );
		 totalPrice =parseFloat(parseFloat(totalPrice)+parseFloat(prices[arraykey])).toFixed(2);
		 count++;
		 
	});
	
	document.getElementById("totalamount").innerHTML = '$'+totalPrice;
	
	if(count>0){
		$("#amounttbl").show();
	}else{
		$("#amounttbl").hide();
	}	 
	
}
</script>
