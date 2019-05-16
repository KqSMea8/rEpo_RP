<? 
if($_GET['CustID']>0){
	$arryQuote=$objQuote->GetCustomerQuote($_GET['CustID']);
?>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
	<tr>
		 <td colspan="2" align="left" >
		 
<div id="preview_div" >
<table id="myTable" cellspacing="1" cellpadding="5" width="100%" align="center">
<? if(sizeof($arryQuote)>0){ ?>
<tr align="left"  >
	<td   class="head1" >Subject</td>
	<td width="15%" class="head1"> Quote Stage </td>
	<!--td  class="head1" >Opportunity Name</td-->
	<td width="15%" class="head1" align="center">Valid Till</td>
	<td  class="head1" width="15%" align="center"> Total [<?=$Config['Currency']?>]</td>
	<td width="18%"   class="head1" align="center"> Created Date</td>
</tr>
<?
  	$flag=true;
	$Line=0;
  	foreach($arryQuote as $key=>$values){
	$flag=!$flag;
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;	
  ?>
<tr align="left"  class="<?=$class?>">
	<td height="22" ><a href="vQuote.php?view=<?=$values['quoteid']?>&module=Quote" target="_blank"><?=stripslashes($values["subject"])?></a></td>
          
	<td><?=$values['quotestage']?></td>
          
           <td align="center"> <?  	if($values["validtill"]>0){
		echo date($Config['DateFormat'] , strtotime($values["validtill"])); }?></td>
           <td align="center"><?  echo $values['TotalAmount'];?> </td>
      
	  <td align="center">
	<?  	if($values["PostedDate"]>0){
		echo date($Config['DateFormat'] , strtotime($values["PostedDate"])); }?>
	 </td>
      
       
    
</tr>

 <?
} // foreach end //

?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  </table>
</div>
	 
		 </td>
	</tr>	
	

</table>
<? } ?>
