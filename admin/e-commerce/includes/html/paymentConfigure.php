<div class="had"> <?= $ModuleTitle; ?></div>
    <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <div  align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;</div><br>  
                                        <table cellspacing="0" width="100%" cellpadding="0" border="0" class="borderall paymentConfiguration">
                                            <tbody>
                                                <tr valign="top">
                                                    <td width="275" class="left"> Supported Payment Methods :  </td>
                                                      
                                                    <td>
                                                        <form id="payment_method_form" method="post" action="">
                                                            <div class="sel-wrap-friont">
                                                            <select id="payment_method_id_dropdown" style="width:375px;" name="payment_method_id">
                                                                <option value="">Please choose your payment solution...</option>
                                                                <?php foreach($arryPaymentMethods as $method){?>
                                                                <option value="<?=$method['PaymetMethodId']?>##<?=$method['PaymentCofigure']?>"><?=$method['PaymentMethodName']?><?php if($method['PaymentCofigure']=="Yes"){?> (active)<?php }?></option>
                                                                <?php }?>
                                                            </select>
                                                            </div>
                                                            <input type="button" value="Activate" id="btnActivatePayment" class="button"><br>
                                                           
                                                        </form>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    
                                     </td>
                                </tr>
                           
                            </table>
                        </td>
                    </tr> 
                </table>
         
