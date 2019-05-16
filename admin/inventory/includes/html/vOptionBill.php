<? if($HideNavigation != 1){?>
<a href="<?=$RedirectURL?>" class="back">Back</a>
<? }?>
<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['optionID']))?("view ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>
	


<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Option Bill</td>
</tr>

<tr>
	 <td colspan="2" align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
 
      
      <tr>
                        <td width="20%"  align="right"   class="blackbold" > Option Code:    </td>
                        <td   align="left">
                            
                      
                          <?=$arryOption[0]['option_code']?>
 

</td>
                  
		
	
                      
                        <td align="right"   class="blackbold" > Description :   </td>
                        <td   align="left">
                            
                      
                           <?=stripslashes($arryOption[0]['description1'])?>
 

</td>
                   
                    </tr> 
                   




</table>

	 </td>
</tr>






<tr>
	 <td colspan="2" align="right">
<?

//$Currency = (!empty($arryPurchase[0]['Currency']))?($arryPurchase[0]['Currency']):($Config['Currency']); 
//echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>	 
	 </td>
</tr>
<tr>
	 <td colspan="2" align="left" class="head" >Component Item</td>
</tr>

<tr>
	<td align="left" colspan="2">
		<? 	include("includes/html/box/bom_option_item_view.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>


   
  
</table>

 </form>





<? #echo '<script>SetInnerWidth();</script>'; ?>


