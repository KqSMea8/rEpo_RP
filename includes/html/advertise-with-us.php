<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> <?=ADVERTISE_WITH_US?>
         
              </td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=ADVERTISE_WITH_US?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      
	 
	   <tr>
	     <td height="32" class="generaltxt_inner">
		 
<form action="" method="post" name="form1" id="form1" onSubmit="return ValidateForm(this);" >
		 
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="generaltxt_inner" >
             <? if(sizeof($arryDuration)>0) { ?>
             <tr>
               <td class="graybox">
                 <strong><?=SELECT_DURATION?> </strong></td>
             </tr>
             <tr>
               <td valign="top">
			   
				   <table width="99%" border="0" cellspacing="0" cellpadding="5" class="blacktxt" align="right">
					   
					   <? 

					   foreach($arryDuration as $key=>$values){ ?> 
					   <tr>
						 <td>
	 
<input type="radio" name="PackageOption"  value="<?=$values['PackageID']?>-Duration" />

<? echo stripslashes($values['Name']).' <span class=greentxt>( '.$Config['Currency'].' '.$values['Price'].' for '.$values['Validity'].' days )</span>'; ?>
						 </td>
					   </tr>
					   
					    <? } ?> 
					   
				   </table>			   </td>
             </tr>
             <? } ?>
             <? if(sizeof($arryImpression)>0) { ?>
			  <tr>
               <td >&nbsp;</td>
             </tr>
             <tr>
               <td class="graybox">
                 &nbsp;<strong><?=SELECT_IMPRESSION?></strong></td>
             </tr>
             <tr>
               <td>
			   
			   
				 <table width="99%" border="0" cellspacing="0" cellpadding="5" class="blacktxt" align="right">
					   <? foreach($arryImpression as $key=>$values2){ ?> 
					   <tr>
						 <td>
					<input type="radio" name="PackageOption"  value="<?=$values2['PackageID']?>-Impression" />
							 <? echo stripslashes($values2['Name']).' <span class=greentxt>( '.$Config['Currency'].' '.$values2['Price'].' for '.$values2['Impression'].' Impressions )</span>'; ?>		
							 
							 </td>
					   </tr>
					   	<? } ?> 
					   
				   </table>			   </td>
             </tr>
             <? } ?>
           </table>		 
		 
		 
 <? if(sizeof($arryDuration)>0 || sizeof($arryImpression)>0) { ?>
 
 <div align="center" style="margin-top:40px;"><input type="image" name="SubmitButton"  id="SubmitButton" src="images/continue.jpg" width="112" height="30" value=" "  alt="Continue" title="Continue"/>
 </div>
 <? }else{  ?>
<div class="redtxt" align="center"><?=NO_PACKAGE_FOUND?></div>
 <? } ?>		 

		  	 
		 </form>		 </td>
        </tr>
	  
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
