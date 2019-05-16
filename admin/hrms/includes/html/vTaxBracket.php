
<a href="<?=$RedirectUrl?>" class="back">Back</a>

<a href="<?=$EditUrl?>" class="edit">Edit</a>

<div class="had"><?=$MainModuleName?> <span> &raquo;
<? 

echo $ModuleName.' Detail' ;
?>
</span>
</div>
	
 <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
 <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
             
              
                <tr>
                  <td align="center" valign="top" >

<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                  
                    
<tr>
<td  align="right"  class="blackbold" width="10%">
	Year :
</td>
<td >
	<strong><?=$arryBracket[0]['Year']?></strong>
</td>
</tr>				
                  	
<tr>
<td  align="right"  class="blackbold" >
	Payroll Period :
</td>
<td>

<strong><?=$arryBracket[0]['PayrollPeriod']?></strong>
</td>
</tr>	

<tr>
        <td  align="right"   class="blackbold"> Filing Status  : </td>
        <td   align="left" >
		<strong><?=$arryBracket[0]['FilingStatus']?></strong>
    

 </td>
      </tr>


<tr>
	<td colspan="2" align="left" class="head">Tax Bracket</td>
</tr>	
<tr>
	<td colspan="2" align="left">
	<? 
	include("includes/html/box/tax_bracket.php");
	?>
</td>
</tr>	

  
	

                 
                  </table></td>
                </tr>
				
		
				
	
				
             
          </table>



 </form>


