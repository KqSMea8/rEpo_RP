<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>
 <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<div class="had" style="margin-bottom:5px;">Currency Log</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
  <tr>
    <td align="right" width="13%">
	Module : 
</td>
	<td align="left"> <strong> <? echo $_GET["mod"]; ?></strong>
	 </td>
</tr>
  <tr>
    <td align="right">
   Currency : 

</td>
<td align="left"> <strong><? echo $_GET["cur"]; ?></strong>
	 </td>
</tr>

 

  <tr>
    <td align="right">
	Base Currency : 

</td>
<td ><strong><?  
echo $Config['Currency'];
 ?>  </strong>
	 </td>
</tr>

 


  <tr>
    <td align="left" colspan="2">
			
			<table width="100%" id="list_table" border="0" align="center" cellpadding="3" cellspacing="1" >  
			 
				<tr align="left">  
					<td  width="20%"  class="head1">Updated Date</td>
					<td width="18%" class="head1">Updated By </td>					
					<td width="15%" class="head1">IP Address</td>
					<td width="10%"  class="head1">Type</td>
					<td class="head1">Date <!--Range--></td>					 
					
					<td width="15%"  class="head1" align="right">Conversion Rate</td>
					 
				</tr>
				
<?php 				
			if($num>0){
			$flag='';
			foreach($arryCurrencyLog as $key=>$values){
				$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
				 
				
				/*if($values['FromDate']>0 && $values['ToDate']>0){
					$Type = 'Range';					 
					$Date = date($Config['DateFormat'], strtotime($values['FromDate'])) . ' - '.date($Config['DateFormat'], strtotime($values['ToDate']));
				}else*/ if($values['FromDate']>0){
					$Type = 'Date';
					$Date = date($Config['DateFormat'], strtotime($values['FromDate']));
				}else{
					$Type = 'Open';
					$Date = '';
				}

				 
				if($values["AdminType"]=='employee') {
					$PostedBy = '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
				}else {
					$PostedBy = $values["PostedBy"];
				}

				echo '<tr align="left" bgcolor="'.$bgcolor.'"> 
					  <td>'.date($Config['DateFormat'].' '.$Config['TimeFormat'], strtotime($values['UpdatedDate'])).'</td>	        
				        <td>'.$PostedBy.'</td>
				       <td>'.$values['IPAddress'].'</td>
					 <td>'.$Type.'</td>
					  <td>'.$Date.'</td>
				        
					  <td align="right">'.$values['ConversionRate'].'</td>
				       					
				        
				 </tr>';
			}
		}else{
			echo '<tr> 
					 <td align="center" class="red" colspan="10">'.NO_RECORD.'</td>	
			  </tr>';
		}
 
			
?>



</table>

<? } ?>
