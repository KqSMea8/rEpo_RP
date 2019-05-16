<script language="JavaScript1.2" type="text/javascript">
function SelectCheck(MainID,ToSelect)
{	
	var flag,i;
	var Num = document.getElementById("CountCheck").value;
	if(document.getElementById(MainID).checked){
		flag = true;
	}else{
		flag = false;
	}
	
	for(i=1; i<=Num; i++){
		document.getElementById(ToSelect+i).checked=flag;
	}
	
}
</script>

<table <?= $table_bg ?>>

                            <tr align="left" >
				 <? if($CheckBox==1){?>
				<td width="1%" align="center" class="head1"><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'TransactionID');" /></td>
				 <? } ?>
				<td width="20%" class="head1" >Payment No#</td>
				<td   class="head1" >Payment Date</td>
				<td  width="20%" class="head1">Posted By</td>
				<td width="15%" align="center" class="head1">Amount (<?= $Config['Currency'] ?>)</td>
                                
                            </tr>


                            <?
                           
                        if (is_array($arryPaymentInvoice) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                           $CountCheck = 0;
                            foreach ($arryPaymentInvoice as $key => $values) {
                                $flag = !$flag;
                                
                                $Line++;
 				$CountCheck++;
                                ?>


                                <tr align="left"   >
                                      <? if($CheckBox==1){?>
                                        <td align="center"> 
                                            <input type="checkbox"   name="TransactionID[]" id="TransactionID<?=$CountCheck?>" class="TransactionID" value="<?php echo $values['TransactionID']; ?>" <?=($values['BatchID']==$_GET['batch'])?("checked"):("")?>>
         				 </td>
					<? } ?>
					 
                                        <td height="20">
                                        <? echo $values["ReceiptID"];    ?>
                                        </td>
                                       
                                        <td height="20">
                                            <?
                                            if ($values['PaymentDate'] > 0)
                                                echo date($Config['DateFormat'], strtotime($values['PaymentDate']));
                                            ?>

                                        </td>

<td>
 <?  
if($values["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
}else {
	echo $values["PostedBy"];
}
 ?>  </td>

                                  

<td align="center">
  <a class="fancybox vSalesPayWidth fancybox.iframe"  href="vVendorPayment.php?view=<?=$values['TransactionID']?>" onMouseover="ddrivetip('<center>View Payment Summary</center>', 140,'')"; onMouseout="hideddrivetip()" ><strong><?=number_format($values['TotalAmount'],2)?></strong></a>
</td>

      
 



                                
                                   

                                </tr>



                                <?php
                                 
                            } // foreach end //
                            ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="7" class="no_record"><?= NO_RECORD ?> </td>
                            </tr>
                                <?php } ?>

                        <tr>  <td  colspan="7"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>  
 
</td>
                        </tr>
                    </table>
			
			 <input type="hidden" name="CountCheck" id="CountCheck" value="<?php echo $CountCheck; ?>">
