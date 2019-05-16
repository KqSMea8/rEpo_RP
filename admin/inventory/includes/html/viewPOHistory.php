<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){   
    $("#prv_msg_div").show();
    $("#frmSrch").hide();
    $("#preview_div").hide();
    $("#msg_div").html("");
}

function ShowList(){   
    $("#prv_msg_div").hide();
    $("#frmSrch").show();
    $("#preview_div").show();
}


</script>


<div class="had">
    PO History
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
		
    <tr>
       <td align="center" height="20">
               <div id="msg_div" class="redmsg"></div>
               </td>
     </tr> 
 
    <tr>
               <td id="ProductsListing" height="400" valign="top">

            <form action="" method="post" name="form1">
				<div id="prv_msg_div" style="display:none"><img src="../images/ajaxloader.gif"></div>
				<div id="preview_div">

               <table <?= $table_bg ?>>


				<tr align="left"  >
					<td width="22%" class="head1">Vendor Name</td>
					<td width="12%"  class="head1" align="center">PO Number</td>
					<td width="12%"  class="head1" align="center">Qty</td>
					<td width="9%"  class="head1" align="center" >Price</td>
<!--td width="9%"  class="head1" align="center" >Landed Cost</td-->
<td width="9%"  class="head1" align="center" > Landed Cost</td>
					<td width="12%"  align="center" class="head1">Order Date</td>

				</tr>

                    <?php
                    if (is_array($arryPOHistory) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryPOHistory as $key => $values) {
                            $flag = !$flag;
                            //$bgcolor=($flag)?(""):("#F3F3F3");
                            $Line++;
if($values['freight_cost']>0){

$freight_cost = $values['freight_cost']/$values["qty_received"];
$cost = $values['price']+$freight_cost;

}

     if($values['Currency'] != $Config['Currency']){  		
				//$ConversionRate = CurrencyConvertor(1,$Currency,$Config['Currency'],'AP',$PostedDate);
				$cost = round(GetConvertedAmount($values['ConversionRate'], $cost),2);
				$freight_cost = round(GetConvertedAmount($values['ConversionRate'], $freight_cost),2);
				$price = round(GetConvertedAmount($values['ConversionRate'], $values['price']),2);
			}else{   
			$cost =  $cost;
			$freight_cost = $freight_cost;
			$price = $values['price'];
			}


                            ?>
                            <tr align="left" valign="middle" bgcolor="<?=$bgcolor?>">
	  
 <td> <a class="fancybox fancybox.iframe" href="../purchasing/suppInfo.php?view=<?=$values['SuppCode']?>"><?=stripslashes($values["SuppCompany"])?></a> </td> 
       <td align="center"><?=$values["PurchaseID"]?></td>

	<td align="center"><?=$values["qty_received"]?></td>
         <td align="center"><?=$price?></td>
<!--td align="center"><?=$freight_cost?></td-->
<td align="center"><?=number_format($cost,2)?></td>
	
 <td align="center">
	   <? if($values['OrderDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
		?>
	   
	   </td>

   
      
    </tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="7" class="no_record"><?=NO_RECORD?></td>
                        </tr>

                    <?php } ?>



                    <tr >  <td  colspan="10" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryPOHistory) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>
				</div>
               


            </form>
        </td>
    </tr>

</table>

