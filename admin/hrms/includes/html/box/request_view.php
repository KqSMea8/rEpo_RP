<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
        <td  align="right"   class="blackbold"  valign="top" width="45%">Posted By Employee  : </td>
        <td   align="left">
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryRequest[0]['EmpID']?>"><?=stripslashes($arryRequest[0]['UserName'])?></a>   
					

	</td>
</tr>

  
   <tr>
          <td align="right"   class="blackbold" valign="top">Posted Date  :</td>
          <td  align="left" >
		<? if($arryRequest[0]['RequestDate']>0) echo date($Config['DateFormat'], strtotime($arryRequest[0]['RequestDate'])); ?>
		   
		   
		   </td>
        </tr>

	<tr>
		<td  align="right"   valign="top" class="blackbold" >Subject : </td>
		<td   align="left"  >
	<?=(!empty($arryRequest[0]['Subject']))?(nl2br(stripslashes($arryRequest[0]['Subject']))):(NOT_SPECIFIED)?>
	   </td>
	  </tr>




 <tr>
        <td align="right"   class="blackbold" valign="top">Message :</td>
        <td  align="left"  >
	<?=(!empty($arryRequest[0]['Message']))?(nl2br(stripslashes($arryRequest[0]['Message']))):(NOT_SPECIFIED)?>

		</td>
      </tr>



</table>	
  



