<div class="had">&nbsp;</div>
<div class="message" align="center"></div>

 
<script language="JavaScript1.2" type="text/javascript">
	
function confirmPrint()
{
    $("#dialog-modal").html("Check already Printed. Reprint ?");
    $("#dialog-modal").dialog(
    {
        title: "Reprint Check",
		modal: true,
		width: 400,
		buttons: {
			"Ok": function() { 
				window.print();
				 $(this).dialog("close");
			},
			"Cancel": function() {
				 $(this).dialog("close");
			}
		}

     });	
    return false;
}

</script>

<style>

#toolbar img{ margin:5px;}

.draggable{border:0px solid #aaa;color:#333; font-size:12px;}
/*.draggable:hover{border:1px dashed #aaa;}*/

.draggablestub{border:0px solid #aaa;color:#333; font-size:12px;}
/*.draggablestub:hover{border:1px dashed #aaa;}*/
.draggable2stub{border:0px solid #aaa;color:#333; font-size:12px;}
.inputtext{background: none;border-bottom:1px solid #888;font-size:12px;color:#232323; padding: 1px; font-weight:500}
.inputamnt{background: #e7f0f5; border:1px solid #e7f0f5;font-size:12px;color:#232323; padding: 1px; font-weight:500}
</style>


<?  if (!empty($ErrorMsg)) {   ?>
<div class="redmsg" align="center"><?=$ErrorMsg?></div>
<?php } else {


?>






<table width="700" border="0" cellpadding="0" cellspacing="0">
<tr>
	
	 <td align="left" valign="top" width="50">
		&nbsp;	
	 </td>
 	 <td align="left" valign="top" >
<? if($arryTransaction[0]['PostToGL']!='Yes'){
	$PrintClick = 'onclick="Javascript:window.print();"';
   }else{	
	$PrintClick = 'onclick="Javascript:return window.confirmPrint();"';
   }
?>
<input type="button" class="print_button" name="Print" id="Print" value="Print" <?=$PrintClick?> >
 
	 </td>
	
	</tr>	

<?
$BoxStyle = !empty($arryTemplate[0]['BoxStyle'])?($arryTemplate[0]['BoxStyle']):('padding-top:1px;padding-bottom:1px;');
$NumChunk = 6;
$NumChunkBreak = $NumChunk+1;
foreach($arryVendorData as $keyven=>$valuesven){ //Vendor	
	$CheckAmount=0;
	$VendorName = '';
	$VendorAddress = '';
	foreach($valuesven as $key2=>$values2){  //Vendor Amount	
		if(empty($VendorName))$VendorName = $values2['VendorName'];	
		$VendorAddress = $values2['VendorAddress'];
 
		$CheckAmount += $values2["Amount"];
	}

	
	unset($arrChunk);
	$arrChunk = array_chunk($valuesven,$NumChunk); 

	 $i=0;
	 if($CheckFormat=='Check, Stub, Stub'){ 
		
		include("includes/html/box/check.php");			
		include("includes/html/box/stub.php");
		include("includes/html/box/stub.php");	
				 
	 }else if($CheckFormat=='Stub, Check, Stub'){	
	
		include("includes/html/box/stub.php");
		include("includes/html/box/check.php");	
		include("includes/html/box/stub.php");	
	
	 }else if($CheckFormat=='Stub, Stub, Check'){	

		include("includes/html/box/stub.php");	
		include("includes/html/box/stub.php");	
		include("includes/html/box/check.php");	

	 }

	  for($i=1;$i<sizeof($arrChunk);$i++){		
			include("includes/html/box/stub.php");	
	  }

}




?>



	</table>


<? } ?>





 


