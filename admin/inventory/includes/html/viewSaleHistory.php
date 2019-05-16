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
    SO History
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
					<td width="22%" class="head1">Customer Name</td>
					<td width="12%"  class="head1" align="center">So Number</td>
					<td width="12%"  class="head1" align="center">Qty</td>
					<td width="9%"  class="head1" align="center" >Unit Cost</td>


					<td width="12%"  align="center" class="head1">Order Date</td>

				</tr>

                    <?php
                    if (is_array($arrySaleHistory) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arrySaleHistory as $key => $values) {
                            $flag = !$flag;
                            //$bgcolor=($flag)?(""):("#F3F3F3");
                            $Line++;

if($values['CustomerCurrency']!=$Config['Currency']){ 


$Pr = round(GetConvertedAmount($values['ConversionRate'], $values["price"]) ,2)." ".$Config['Currency'];

}else{
$Pr = $values["price"];
}

                            ?>
                            <tr align="left" valign="middle" bgcolor="<?=$bgcolor?>">
	  
 <td> <a class="fancybox fancybox.iframe" href="../sales/custInfo.php?view=<?=$values['CustCode']?>"><?=stripslashes($values["CustomerName"])?></a> </td> 
       <td align="center"><?=$values["SaleID"]?></td>

	<td align="center"><?=$values["qty"]?></td>
         <td align="center"><?=$Pr?></td>
	
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



                    <tr >  <td  colspan="10" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arrySaleHistory) > 0) { ?>
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

