
<div class="had"> <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?></div>

<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD  align="center" valign="top"><table width="100%"   border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
	
		  <div  align="right"><a href="viewVoucher.php" class="Blue">List <?=$ModuleName?>s</a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top">
				  <br /> <br />
				  
				  <table width="70%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="43%" align="right" valign="top" =""  class="blackbold">
					   Voucher Code <span class="red">*</span> </td>
                      <td  align="left" valign="top">
					<input  name="code" id="code" value="<?=stripslashes($arryVoucher[0]['code'])?>" type="text" class="inputbox"  size="30" maxlength="30" />					    </td>
                    </tr>
					
					
				
					
					
                    <tr >
                      <td align="right" valign="top"  class="blackbold">Discount Over the Amount <span class="red">*</span></td>
                      <td align="left" class="blacknormal"><input  name="DiscountOver" id="DiscountOver" value="<?=stripslashes($arryVoucher[0]['DiscountOver'])?>" type="text" class="inputbox"  size="4" maxlength="10"/> $</td>
                    </tr>
                    <tr >
                      <td align="right" valign="top"  class="blackbold">Discount <span class="red">*</span></td>
                      <td align="left" class="blacknormal"><input  name="Discount" id="Discount" value="<?=stripslashes($arryVoucher[0]['Discount'])?>" type="text" class="inputbox"  size="4" maxlength="5" /> %</td>
                    </tr>
					  <tr >
                      <td align="right" valign="middle"  class="blackbold">Start Date <span class="red">*</span></td>
                      <td align="left" class="blacknormal">
                        <? 
						$StartDate = $arryVoucher[0]['StartDate'];
						if($StartDate < 1) $StartDate = ''; echo date_picker($StartDate,'StartDate');?>
                      </td>
                    </tr>
					
					 <tr >
                      <td align="right" valign="middle"  class="blackbold">End Date <span class="red">*</span></td>
                      <td align="left" class="blacknormal">
                        <? 
						$EndDate = $arryVoucher[0]['EndDate'];
						if($EndDate < 1) $EndDate = ''; echo date_picker($EndDate,'EndDate');?>
                      </td>
                    </tr>
					
                    <tr >
                      <td align="right" valign="top"  class="blackbold">Description</td>
                      <td align="left" class="blacknormal">
<textarea  name="detail" id="detail" class="inputbox" cols="40" rows="3"><?=stripslashes($arryVoucher[0]['detail'])?></textarea></td>
                    </tr>
                 
                    <tr >
                      <td align="right" valign="top"  class="blackbold">Status  </td>
                      <td align="left" class="blacknormal">
        <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                                            </td>
                    </tr>	
                  </table></td>
                </tr>
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>" />
			  <input type="hidden" name="voucherID" id="voucherID"  value="<?=$_GET['edit']?>" />
			  <input type="reset" name="Reset" value="Reset" class="Button" />
				    <br>  <br>  <br>
				  
				  </td></tr> 
				
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>

<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if(  ValidateForBlank(frm.code, "Voucher Code")
		&& ValidateMandRange(frm.code, "Voucher Code",3,30)
		&& ValidateMandDecimalField(frm.DiscountOver, "Discount Over Amount")
		&& ValidateMandDecimalField(frm.Discount, "Discount")
		&& ValidateForSelect(frm.StartDate, "Start Date")
		&& ValidateForSelect(frm.EndDate, "End Date")
		){
			
	
			var Url = "isRecordExists.php?VoucherCode="+escape(document.getElementById("code").value)+"&editID="+document.getElementById("voucherID").value;
			SendExistRequest(Url,"code","Voucher Code");
			
			
			return false;
			
		}else{
			return false;	
		}
		
}



</SCRIPT>