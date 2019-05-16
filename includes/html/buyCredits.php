<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> 
         <?=$Nav_MemberPortal?>
          </span>
              <?=$PaymentFor?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=$PaymentFor?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	  <? if($_GET['tp']=='sms'){ ?>
	   <tr>
     <td >Current <?=SMS_CREDITS?>: <?=$arryMember[0]['MaxSms']?></td>
  
   </tr>
   <? }else{ ?>
      <tr>
		 <td >Current <?=EMAIL_CREDITS?>: <?=$arryMember[0]['MaxEmail']?></td>
  	 </tr>
	 <? } ?>
  
	   <tr>
        <td height="15"></td>
      </tr>
	  
	  
	   <tr>
	     <td height="32" class="generaltxt_inner">
		 <form action="" method="post" name="form1" id="form1">
		 
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="generaltxt_inner" >
             
             <? if(sizeof($arryImpression)>0) { ?>
             <tr>
               <td class="graybox"><input type="hidden" name="PackageType" id="PackageType" value="Impression" />
                 &nbsp;<strong>Select Package</strong></td>
             </tr>
             <tr>
               <td>
			   
			   
				 <table width="100%" border="0" cellspacing="0" cellpadding="5" class="blacktxt" align="right">
					  
					   <tr>
						 <td valign="top">
						 

		<table border="0" cellspacing="0" cellpadding="0">


		 <? foreach($arryImpression as $key=>$values2){ ?>
						
			<tr>
			<td><input type="radio" name="PackageID" value="<?=$values2['PackageID']?>" />  </td>
			<td>&nbsp;</td>
			<td class="generaltxt_inner"> <? echo stripslashes($values2['Name']).' <span class=greentxt>('.$Config['Currency'].' '.$values2['Price'].' for '.$values2['Impression'].' Credits)</span>'; ?> </td>
		  </tr>			 
			
							 
		<? } ?> 
							
							</table>
						
							 
							 </td>
					   </tr>
					   
				   </table>		   
			   
			   
			   
			   
			   </td>
             </tr>
             <? } ?>
           </table>		 
		 
		 
 <? if(sizeof($arryDuration)>0 || sizeof($arryImpression)>0) {    
		include("includes/html/box/payment_box.php");
		
 }else{  ?>
 <div class="redtxt" align="center"><?=NO_PACKAGE_FOUND?></div>
 <? } ?>		 
		 
		   <input type="hidden" name="MemberID" id="MemberID" value="<?=$_SESSION['MemberID']?>" />
		  <input type="hidden" name="CreditType" id="CreditType" value="<?=$_GET['tp']?>" />
		 </form>
		 
		 
		 </td>
        </tr>
	  
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
