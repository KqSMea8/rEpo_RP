
<script language="JavaScript1.2" type="text/javascript">


function validatePrefix(frm){


	if( ValidateForSimpleBlank(frm.adjustmentPrefix, "Stock Adjustment Prefix ")
		&& ValidateForSimpleBlank(frm.ToP, "Transfer Order Prefix")
        && ValidateForSimpleBlank(frm.bom_prefix, "Bills of Material Prefix")
&& Va
		
	){
		
	
        
        return true;

	}else{
		return false;	
	}	



	
     	
		
}
</script>


<div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_prefix'])){?>
								 <div align="center" class="red"><b><? echo $_SESSION['mess_prefix']; unset($_SESSION['mess_prefix']); ?></b>
								 </div>
								 <? }?>

                                <table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0" class="borderall">
                                 <form name="form1" id="productBasicInfoForm" action=""  method="post" onSubmit="return validatePrefix(this);"  enctype="multipart/form-data">	

								 
                                         
                                     <tr  class="head">
                                               
                                                <td colspan="2"   align="left">
                                                
                                                    Prefixs	 </td>
                                            </tr>
                                     
                                     <tr style="display:none33;">
                                                <td  align="right"   class="blackbold" >Stock Adjustment Prefix:<span class="red">*</span>   </td>
                                                <td   align="left">
                                                
                                                    <input  name="adjustmentPrefix" id="adjustmentPrefix"  value="<? echo stripslashes($arryPrifix[0]['adjustmentPrefix']); ?>" type="text" class="inputbox" maxlength="30" />	 </td>
                                            </tr>
                                            <tr style="display:none;">
                                                <td  align="right"   class="blackbold" >Next Stock Adjustment Number:<span class="red">*</span>   </td>
                                                <td   align="left">
                                                
                                                    <input  name="adjustPrefixNum" id="adjustPrefixNum"  value="<? echo stripslashes($arryPrifix[0]['adjustPrefixNum']); ?>" type="text" class="inputbox" maxlength="30" />	 </td>
                                            </tr>
                                            <tr style="display:none33;">
                                                <td  align="right"   class="blackbold" >Transfer Order Prefix: <span class="red">*</span>  </td>
                                                <td   align="left">
                                                
                                                    <input  name="ToP" id="ToP"  value="<? echo stripslashes($arryPrifix[0]['ToP']); ?>" type="text" class="inputbox" maxlength="30" />	 </td>
                                            </tr>
                                            <tr style="display:none;">
                                                <td  align="right"   class="blackbold" >Next Transfer Order Number: <span class="red">*</span>  </td>
                                                <td   align="left">
                                                
                                                    <input  name="ToN" id="ToN"  value="<? echo stripslashes($arryPrifix[0]['ToN']); ?>" type="text" class="inputbox" maxlength="30" />	 </td>
                                            </tr>
                                            <tr style="display:none33;">
                                                <td  align="right"   class="blackbold" >Bills of Material Prefix:<span class="red">*</span>   </td>
                                                <td   align="left">
                                                
                                                    <input  name="bom_prefix" id="bom_prefix"  value="<? echo stripslashes($arryPrifix[0]['bom_prefix']); ?>" type="text" class="inputbox" maxlength="30" />	 </td>
                                            </tr>
                                            <tr style="display:none;">
                                                <td  align="right"   class="blackbold" >Bills of Material Number: <span class="red">*</span>  </td>
                                                <td   align="left">
                                                
                                                    <input  name="bom_number" id="bom_number"  value="<? echo stripslashes($arryPrifix[0]['bom_number']); ?>" type="text" class="inputbox" maxlength="30" />	 </td>
                                            </tr>
                                            

                                            <tr> <input type="hidden" name="prefixID" id="prefixID" value="<?=$arryPrifix[0]['prefixID']?>"  />
                                             <td align="center" colspan="2"><input type="submit" name="submit" id="submit" value="Save"  class="button"/>


                                                 <span id="info"></span>
                                             </td></tr>
                                      </form>
                                     </table>
<? echo '<script>SetInnerWidth();</script>'; ?>
