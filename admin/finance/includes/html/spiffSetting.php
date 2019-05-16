<div class="had"><?=$MainModuleName; ?></div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
              <form name="form1" action="" method="post"  enctype="multipart/form-data"> 
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" class="message">
                            <?php if (!empty($_SESSION['mess_setting'])) { ?><?= $_SESSION['mess_setting'];
                               unset($_SESSION['mess_setting']); ?><?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" >
                         
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">

                                <tr>
                                    <td align="center" valign="top">
                                            <table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                                    <tr>
                                                        <td  align="right" class="blackbold" width="45%">GL Account :</td>
                                                        <td  align="left">
                                                          
                                                            <select name="GLAccountTo" class="inputbox" id="GLAccountTo">
                                                            <option value="">&nbsp;--- Select ---</option>
                                                            <? for($i=0;$i<sizeof($arryExpenseType);$i++) {?>
                                                            <option value="<?=$arryExpenseType[$i]['BankAccountID']?>" <?php if($arrySpiffSettings[0]['GLAccountTo'] == $arryExpenseType[$i]['BankAccountID']){echo "selected";}?>>
                                                            &nbsp;<?=$arryExpenseType[$i]['AccountName']?> [<?=$arryExpenseType[$i]['AccountNumber']?>]
                                                            </option>
                                                            <? } ?>
                                                           
                                                            </select> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  align="right"   class="blackbold"> Paid From A/C :</td>
                                                        <td   align="left" >
                                                         <select name="GLAccountFrom" class="inputbox" id="GLAccountFrom">
                                                                        <option value="">--- Select ---</option>
                                                                        <? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
                                                                         <option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?php if($arrySpiffSettings[0]['GLAccountFrom'] == $arryBankAccount[$i]['BankAccountID']){echo "selected";}?>>
                                                                         <?=stripslashes(ucfirst($arryBankAccount[$i]['AccountName']))?> [<?=stripslashes(ucfirst($arryBankAccount[$i]['AccountNumber']))?>]</option>
                                                                                <? } ?>
                                                                </select> 
                                                        </td>
                                                    </tr>
                                                   
                                                    






<tr>
        <td  align="right" class="blackbold">Payment Term :</td>
        <td   align="left">
<select name="PaymentTerm" class="inputbox" id="PaymentTerm">
<option value="">--- Select ---</option>
	 <? for($i=0;$i<sizeof($arryPaymentTerm);$i++) { 
				$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']);
			?>
				<option value="<?=$PaymentTerm?>" <?  if($PaymentTerm==$arrySpiffSettings[0]['PaymentTerm']){echo "selected";}?>><?=$PaymentTerm?></option>
			<? } ?>
</select> 
		</td>
  </tr>


                                            </table>
                                      
                                    </td>
                                </tr>
                            </table>
                         

                        </td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <input name="Submit" type="submit" class="button" value="Save" />&nbsp;
                        </td>   
                    </tr>

                </table>
               </form>
            </td>
        </tr>

</table>
