<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> 
         <?=$Nav_MemberPortal?>
          </span>
              <?=UPGRADE_FEATURED_WEBSITE?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=UPGRADE_FEATURED_WEBSITE?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32" class="generaltxt_inner">
		<?
	if($arrayContents[0]['PageContent'] != ''){
	 	echo  stripslashes($arrayContents[0]['PageContent']); 
	}
	
	?>        </td>
      </tr>
	   <tr>
        <td height="15"></td>
      </tr>
	  
	  
	   <tr>
	     <td height="32" class="generaltxt_inner">
		 <form action="" method="post" name="form1" id="form1">
		 
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="generaltxt_inner" >
             <? if(sizeof($arryDuration)>0) { ?>
             <tr>
               <td class="graybox"><input type="radio" name="PackageType" id="PackageType" value="Duration" />
                 <strong><?=SELECT_DURATION?></strong></td>
             </tr>
             <tr>
               <td valign="top">
			   
				   <table width="99%" border="0" cellspacing="0" cellpadding="5" class="blacktxt" align="right">
					   
					   <tr>
						 <td>
					<select name="Duration" id="Duration" style="width:320px;" class="txt-feild">
					
					 <? foreach($arryDuration as $key=>$values){ ?>
	 
						<option value="<?=$values['PackageID']?>">
						 <?=stripslashes($values['Name'])?>
							 <? echo ' <span class=greentxt>( '.$Config['Currency'].' '.$values['Price'].' for '.$values['Validity'].' days )</span>'; ?> </option>
							 
							  <? } ?> 
							  
					</select>		  
							 </td>
					   </tr>
					 
				   </table>
			   
			   </td>
             </tr>
             <? } ?>
             <? if(sizeof($arryImpression)>0) { ?>
             <tr>
               <td class="graybox"><input type="radio" name="PackageType" id="PackageType" value="Impression" />
                 &nbsp;<strong><?=SELECT_IMPRESSION?></strong></td>
             </tr>
             <tr>
               <td>
			   
			   
				 <table width="99%" border="0" cellspacing="0" cellpadding="5" class="blacktxt" align="right">
					  
					   <tr>
						 <td>
						 
						 <select name="Impression" id="Impression" style="width:320px;" class="txt-feild">
						  <? foreach($arryImpression as $key=>$values2){ ?>
						 
						 <option value="<?=$values2['PackageID']?>">
						 <?=stripslashes($values2['Name'])?>
							 <? echo ' <span class=greentxt>( '.$Config['Currency'].' '.$values2['Price'].' for '.$values2['Impression'].' Impressions )</span>'; ?> 
						</option> 
							 
							<? } ?> 
							
							
						</select>	 
							 
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
