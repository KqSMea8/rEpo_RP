<script language="JavaScript1.2" type="text/javascript">
$(function() {
        $("#RemoveFromBatch").click(function(e) {

            var number_of_checked_checkbox = $(".TransactionID:checked").length;
            if (number_of_checked_checkbox == 0) {
                alert("Please select atleast one record to remove from batch.");
                return false;
            } else {		 
		 ShowHideLoader('1','P');
                return true;
            }

        });
    })


function PrintBatch(){ 		
	var BatchID = $("#BatchID").val();

	if(BatchID>0){		
		var SendUrl ='batch.php?BatchID='+BatchID;	
 
		$.fancybox({
		 'href' : SendUrl,
		 'type' : 'iframe',
		 'width': '800',
		 'height': '700'
		 });

	} 
} 



</script>

<div><a href="<?= $RedirectURL ?>"  class="back">Back</a>

<?  if($arryBatch[0]['Status'] == 1 && $num>0){ 
	$printcheck = '<img src="'.$Config['Url'].'admin/images/print.png" border="0"  onMouseover="ddrivetip(\'<center>Print Batch</center>\', 70,\'\')"; onMouseout="hideddrivetip()" >';
	#echo ' <a class="fancybox fancybox.iframe" href="batch.php?BatchID='.$_GET['view'].'" style="float:right">'.$printcheck.' </a>';
?>
<input type="button" class="print_button" name="Print" id="Print"   value="Print Batch" onclick="Javascript:PrintBatch();">
 <? } ?>
</div>

<div class="had">
    <?= $MainModuleName ?>    <span> &raquo;
        <? echo $ModuleName.' Details'; ?>

    </span>
</div>

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>

 

<div class="message" align="center"><? if(!empty($_SESSION['mess_batch'])) {echo $_SESSION['mess_batch']; unset($_SESSION['mess_batch']); }?></div>

     
  <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
   <tbody>
       <tr>
            <td valign="top" align="center">
                <table width="100%" cellspacing="0" cellpadding="5" border="0" class="borderall">
                <tbody>
                    
                   
		 <tr>
                        <td  align="right"   class="blackbold" width="45%"> Batch Name  :  </td>
                        <td   align="left" >
                            <?php echo stripslashes($arryBatch[0]['BatchName']); ?>          </td>
                    
                    </tr>
                    
                                   
  
                    <tr>
                        <td  align="right"  valign="top" class="blackbold" >   Description  : </td>
                        <td  align="left"  >                            
                         <?php echo stripslashes($arryBatch[0]['Description']); ?>

                        </td>
                    </tr>
                    
                  
                   
                    <tr>
                        <td align="right">Status : </td>
                    
                    <td   align="left" >

<?
 if($arryBatch[0]['Status'] == 1){
	  $status = 'Closed';
	  $statusCls = 'red';
 }else{
	  $status = 'Open';
	  $statusCls = 'green';
 }
	     
	echo '<span class="'.$statusCls.'"><strong>'.$status.'</strong></span>';

?>
                   </td>
                    </tr> 


		<?  if($ModifyLabel==1 && $arryBatch[0]['Status'] != 1){?>
		  <tr>
                        <td align="right"> </td>
                    
                    <td   align="left" >
<a class="fancybox action_bt fancybox.iframe" href="moveBatch.php?batch=<?=$arryBatch[0]['BatchID']?>" >Move Checks to Batch</a>
 
                   </td>
                    </tr>     
		<? } ?>
  
                    
                </tbody>
                </table>	
	</td>
   </tr>
   
   
</tbody>
</table>
         <input type="hidden" name="BatchID" id="BatchID" value="<?= $_GET['view'] ?>" />
     
<? if($num>0){ ?>
	<form action="" method="post" name="form1">
    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
   
	<? if($ModifyLabel==1 && $arryBatch[0]['Status'] == 0){ 

		$CheckBox=1;
?>
 	<tr>
            <td align="left" valign="top">  
                    <input type="submit" class="button" name="RemoveFromBatch" id="RemoveFromBatch"  value="Remove" >              
            </td>
        </tr>  
	<? } ?>

        <tr>
            <td  valign="top">

 

                    <? include("includes/html/box/vendor_payment_list.php"); ?>

                

            </td>
        </tr>
    </table>
</form>  
<? } ?>




 <? } ?>




