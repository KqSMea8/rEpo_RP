<style>
<!--
.to-block a{
  display: none;
  position: absolute;
  background: #e9e9e9;
  padding: 5px 24px;
    margin-left: -1px;
    margin-top: -5px;
    color:#005dbd;
      border: 1px solid gray;
  border-radius: 5px;
  }
  
  .flag_e:hover{
      cursor:pointer; 
      
  }
  
  
  -->

.flag_e > a {
    display: block;
    float: left;
    width: 0;
}

</style>
<script type="text/javascript" language="JavaScript1.2">
function filterLead(id)
	{
		location.href = "viewOrder.php?customview=" + id + "&search=Search";
		LoaderSearch();
	}

$(document).ready(function(){

		$(".to-block").hover(
		function() { 
			$(this).find("a").show(300);
		  },
		  function() {
			 // if($(this).attr('class')!='add-edit-email')
				$(this).find("a").hide();
		
		});
                
                
                $(".flag_white").hide();
                $(".flag_red").show();
                $('.evenbg').hover(function() { 
			$(this).find(".flag_white").show();
                        //$(this).find(".flag_e").css('display','block');
		  },
		  function() {
			 
				$(this).find(".flag_white").hide();
                                //$(this).find(".flag_e").css('display','none');
                });
                $('.oddbg').hover(function() { 
			$(this).find(".flag_white").show();
                        //$(this).find(".flag_e").css('display','block');
		  },
		  function() {
			 
				 $(this).find(".flag_white").hide();
                                 //$(this).find(".flag_e").css('display','none');
                });
                
                
                
                 //By chetan 24 DEC//
                $('#highlight select#RowColor').attr('onchange','javascript:showColorRowsbyFilter(this)');
                $('#highlight select#RowColor option').each(function() {
                    $val = $(this).val();
                    $text = $(this).text();
                    $val = $val.replace('#', '');
                    $(this).val($val);
                });
                //End//

});
  var showColorRowsbyFilter = function(obj)
    {
        if(obj.value !='')
        {
            $url = window.location.href.split("&rows")[0];
            window.location.href = $url+'&rows='+obj.value;
        }
    }
</script>

<div class="had">Manage <?=$ListTitle;?> </div>
<form action="" method="post" name="form1">
<table width="100%" border=0 align="center" cellpadding=0 cellspacing=0 >
    <tr>
        <td>
            <div class="message">
             <? if (!empty($_SESSION['mess_order'])) { echo stripslashes($_SESSION['mess_order']);unset($_SESSION['mess_order']); } ?>
           </div>
		     
		    <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
					<td width="39%" align="right">     <?php  if (is_array($arrayOrders) && $num > 0) {?>
					<input type="button" class="export_button" style="float: right;"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_order.php?<?=$QueryString?>';" />
					<? if($_GET['search']!='') {?>
					<a href="viewOrder.php" class="grey_bt">View All</a>
					<? }?>
					<?php }?>  
<?php if($_SESSION['MarketPlace']==1 || $_GET['sanjiv']=='sanjiv'){?>
<ul style="margin-right:5px;" class="export_menu">
<li><a style="background:#d40503 !important; width: 96px;" class="hide" href="#">Sync Orders</a>
<ul>
<li><a style="background:#d40503 !important; margin-bottom:2px; margin-top:2px; width: 96px;" href="viewOrder.php?synctype=sync_amazon&curP=<?=$_GET['curP']?>">Sync Amazon</a></li>
<li> <a style="background:#d40503 !important;width: 96px;margin-bottom:2px; "  href="viewOrder.php?synctype=sync_ebay&curP=<?=$_GET['curP']?>" >Sync Ebay</a></li>	
<li> <a style="background:#d40503 !important;width: 96px; "  href="viewOrder.php?synctype=sync_magento&curP=<?=$_GET['curP']?>" >Sync Magento</a></li>	

</ul>
</li>
</ul>
<? }?>
	
    </td>
</tr>

<tr>
<td width="61%" >
	<a style="background-color: #81bd82 !important;width: 55px;font-weight: bold;padding: 5px 10px;" class="Active" href="viewOrder.php?curP=1&customview=<?=$_GET["customview"]?>" >Active</a>
	<a style="background-color: #FBBC2F !important;width: 55px;font-weight: bold;padding: 5px 10px;" class="Active" href="viewOrder.php?OrderStatus=Pending&customview=<?=$_GET["customview"]?>&curP=1" >Pending</a>
	<a style="background:#d40503 !important;width: 55px;font-weight: bold;padding: 5px 10px; " class="Active" href="viewOrder.php?OrderStatus=Cancelled&customview=<?=$_GET["customview"]?>&curP=1" >Cancelled</a>
</td>
<? if ($num > 0 && $ModifyLabel==1) { ?>
  <td align="right" colspan="2"  >
<?
$ToSelect = 'OrderID';
include_once("../includes/FieldArrayRow.php");
echo $RowColorDropDown;
?>
</td>
<? }?> 
</tr>
            

            </table>
            
             <table <?= $table_bg ?>>

                <tr align="left" >
 <? if ($_GET["customview"] == 'All') { ?>
                    <!--td width="8%" height="20"  class="head1" align="center">Order ID</td-->      
                    <td width="20%" height="20"  class="head1">Customer's Name</td>
                    <td width="10%" height="20"  class="head1" align="center">Order Type</td>     
                    <td width="10%" height="20"  class="head1" align="center">Amount</td>
                    <td width="8%" height="20"  class="head1" align="center">Order Status</td>      
                    <td width="8%" height="20"  class="head1" align="center">Payment Status</td>      
                    <td width="8%" height="20"  class="head1" align="center">Order Date</td>  

<? } else { ?>
                            
														<? foreach ($arryColVal as $key => $values) { ?>
															     <td width=""  class="head1" height="20" ><?= $values['colname'] ?></td>

														<? } } ?>

    
                    <td width="9%" height="20" align="center" class="head1">Action&nbsp;&nbsp;</td>
 <? if($ModifyLabel==1){ ?>  <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'OrderID', '<?= sizeof($arrayOrders) ?>');" /></td><?}?>
                </tr>
                <?php
                //$pagerLink = $objPager->getPager($arrayOrders, $RecordsPerPage, $_GET['curP']);
                //(count($arrayOrders) > 0) ? ($arrayOrders = $objPager->getPageRecords()) : ("");
                if ($num > 0) {
                   $flag = true;
                            $Line = 0;
                    foreach ($arrayOrders as $key => $values) {
                        $Line++;
                         $CurrencySymbol=$values['Currency'];
                        if(!empty($values['CurrencySymbol'])) $CurrencySymbol=$values['CurrencySymbol'];
                        
                        if($values['PaymentStatus'] == "1")
                            $bgcolor = "#ffffff";
                            else
                             $bgcolor = "#e9e8e8";
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>" <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?>>
<? if ($_GET["customview"] == 'All') { ?>
                            <!--td align="center">
                                <?= $values['OrderID']; ?>  </td-->
                             <td height="26">



<?= ( $values['OrderType']=='Amazon' || $values['OrderType']=='Ebay') ? $values['BillingName'] : $values['FirstName']." ".$values['LastName']; ?>     </td>
 			     <!--<td align="center"><?= ( !empty($values['OrderType']) ) ? $values['SellerChannel'] : 'Web'; ?>     </td>-->
                            <td align="center"><?php if( !empty($values['OrderType']) ) { 
                            	switch ($values['SellerChannel']){
                            		case 'Amazon.com':
                            			$logo = 'amazon_com.gif';
                            		break;
                            		case 'Amazon.ca':
                            			$logo = 'amazon_ca.gif';
                            		break;
                            		case 'Amazon.co.jp':
                            			$logo = 'amazon_co.jp.gif';
                            		break;
                            		case 'Amazon.es':
                            			$logo = 'amazon_es.jpg';
                            		break;
                            		case 'Amazon.com.mx':
                            			$logo = 'amazon_com.mx.jpg';
                            		break;
                            		case 'Amazon.it':
                            			$logo = 'amazon_it.gif';
                            		break;
                            		case 'Amazon.fr':
                            			$logo = 'amazon_fr.gif';
                            		break;
                            		case 'Amazon.de':
                            			$logo = 'amazon_de.gif';
                            		break;
                            		case 'Amazon.co.uk':
                            			$logo = 'amazon_co.uk.gif';
                            		break;
                            		case 'Amazon.in':
                            			$logo = 'amazon_in.gif';
                            		break;
                            		case 'Ebay.com':
                            			$logo = 'ebay.png';
									break;
									case 'magento':	
									  $logo = 'mgt.png';
                            		break;
                            	} 
                            ?>
                            <img alt="" src="../upload/orderTypeLogo/<?=$logo?>" height="15">
                            <?php }else{ ?>
                            	<img alt="" src="../../images/logo.png" height="13">
                           <?php } ?>     </td>
                          <td align="center"><?= display_price_symbol($values['TotalPrice'],'');//display_price_symbol($values['TotalPrice'],$CurrencySymbol) ?></td>
                             <td align="center">
<?php 
/*   if ($values['OrderStatus'] == "Completed") {
echo "Completed";
} else if ($values['OrderStatus'] == "Cancelled") {
echo "Cancelled";
} else {
echo "Process";
}*/

if ($values['OrderStatus'] == "Shipped" || $values['OrderStatus'] == "Completed" ) {
	$status = 'Active';
	$Design ='width: 55px;display: block;text-decoration: none;cursor: default;';				
	$StatusText = 'Shipped';
}else if ($values['OrderStatus'] == "Active" || $values['OrderStatus'] == "Pending") {

			$status = 'Active';
			$Design ='background-color: #FBBC2F !important;width: 55px;display: block;text-decoration: none;cursor: default;';				
			//$StatusText = $values['OrderStatus'];
$StatusText = 'Unshipped';

}else if ($values['OrderStatus'] == "Cancelled" ) {

	$status = 'InActive';
	$Design ='width: 65px;display: block;text-decoration: none;cursor: default;';				
	$StatusText = 'Cancelled';

}else{
	if(empty($values['OrderStatus'])) $values['OrderStatus']='Unshipped';
	$status = 'InActive';
	$Design ='width: 65px;display: block;text-decoration: none;cursor: default;';
	$StatusText = $values['OrderStatus'];
}



echo '<a style="'.$Design.'" class=' . $status . '><b>' . $StatusText . '</b></a>';


//echo  $values['OrderStatus'];
?>        

                            </td>
                           <td align="center">
                                <?php  if($values['OrderType']=='Amazon' || $values['OrderType']=='Ebay'){
                                		echo 'Paid';
		                                }else{
		                                        if($values['PaymentStatus'] == "1") { echo "Received";}
		                                        else if($values['PaymentStatus'] == "2") { echo "Refunded";}
		                                        else if($values['PaymentStatus'] == "3") { echo "Cancelled";}
		                    					else if($values['PaymentStatus'] == "5") { echo "Failed";}
		                                        else{echo "Pending"; }
		                                }
                                        ?>
                                
                            </td>
                            <td align="center" >
<?  
            if ($values['OrderDate'] > 0)
                echo date($Config['DateFormat'].' '.$Config['TimeFormat'], strtotime($values['OrderDate']));
            ?>



  </td>
<?} else{

foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';
                                            if ($cusValue['colvalue'] == 'PaymentStatus') {
	if($values['OrderType']=='Amazon' || $values['OrderType']=='Ebay'){
	echo 'Paid';
	}else{
	if($values['PaymentStatus'] == "1") { echo "Received";}
	else if($values['PaymentStatus'] == "2") { echo "Refunded";}
	else if($values['PaymentStatus'] == "3") { echo "Cancelled";}
	else if($values['PaymentStatus'] == "5") { echo "Failed";}
	else{echo "Pending"; }
	}
           } if ($cusValue['colvalue'] == 'OrderType') {

/***************/
if( !empty($values['OrderType']) ) { 
                            	switch ($values['SellerChannel']){
                            		case 'Amazon.com':
                            			$logo = 'amazon_com.gif';
                            		break;
                            		case 'Amazon.ca':
                            			$logo = 'amazon_ca.gif';
                            		break;
                            		case 'Amazon.co.jp':
                            			$logo = 'amazon_co.jp.gif';
                            		break;
                            		case 'Amazon.es':
                            			$logo = 'amazon_es.jpg';
                            		break;
                            		case 'Amazon.com.mx':
                            			$logo = 'amazon_com.mx.jpg';
                            		break;
                            		case 'Amazon.it':
                            			$logo = 'amazon_it.gif';
                            		break;
                            		case 'Amazon.fr':
                            			$logo = 'amazon_fr.gif';
                            		break;
                            		case 'Amazon.de':
                            			$logo = 'amazon_de.gif';
                            		break;
                            		case 'Amazon.co.uk':
                            			$logo = 'amazon_co.uk.gif';
                            		break;

                            		case 'Amazon.in':
                            			$logo = 'amazon_in.gif';
                            		break;
                            		case 'Ebay.com':
                            			$logo = 'ebay.png';
                            		break;
									case 'magento':	
									  $logo = 'mgt.png';
                            		break;
                            	} ?>
<img alt="" src="../upload/orderTypeLogo/<?=$logo?>" height="15">
                            <?php }else{ ?>
                            	<img alt="" src="../../images/logo.png" height="13">
                           <?php } /***************/ ?> 


<? }else if($cusValue['colvalue'] == 'TotalPrice') {



echo $TotalPrice = display_price_symbol($values['TotalPrice'],'');


}else if($cusValue['colvalue'] == 'OrderStatus') {

if ($values['OrderStatus'] == "Shipped" || $values['OrderStatus'] == "Completed" ) {
		$status = 'Active';
		$Design ='width: 55px;display: block;text-decoration: none;cursor: default;';				
		$StatusText = 'Shipped';
}else if ($values['OrderStatus'] == "Active" || $values['OrderStatus'] == "Pending") {

		$status = 'Active';
		$Design ='background-color: #FBBC2F !important;width: 55px;display: block;text-decoration: none;cursor: default;';				
		$StatusText = 'Unshipped';

}else if ($values['OrderStatus'] == "Cancelled" ) {

		$status = 'InActive';
		$Design ='width: 65px;display: block;text-decoration: none;cursor: default;';				
		$StatusText = 'Cancelled';

}else{
		$status = 'InActive';
		$Design ='width: 65px;display: block;text-decoration: none;cursor: default;';
		$StatusText = $values['OrderStatus'];
}



                        echo '<a style="'.$Design.'" class=' . $status . '>' . $StatusText . '</a>';




}else if($cusValue['colvalue'] == 'DelivaryDate' || $cusValue['colvalue'] == 'OrderDate' || $cusValue['colvalue'] == 'ShipDate') {
				
				if($values[$cusValue['colvalue']]>0)
				echo date($Config['DateFormat'] , strtotime($values[$cusValue['colvalue']]));

                        } else {
                                            ?>

                    <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                <?
                }

                echo '</td>';
            }
        }
        ?>
                            <td height="26" class="head1_inner" align="center"  valign="top">
                                <a href="vOrder.php?view=<?=$values['OrderID']?>&cid=<?=$values['Cid']?>&curP=<?=$_GET['curP']?>"><?=$edit?></a>&nbsp;
                    
                                <a class="fancybox fancybox.iframe" href="orderInvoice.php?invoice=<?=$values['OrderID']?>&cid=<?=$values['Cid']?>&curP=<?=$_GET['curP']?>" target="_blank"><img src="../images/print.png" border="0" onmouseout="hideddrivetip()" onmouseover="ddrivetip('&lt;center&gt;Print Order&lt;/center&gt;', 80,'')"></a>&nbsp;

  <? if ( $values['OrderType']=='Amazon' && !($values['OrderStatus'] == "Shipped" || $values['OrderStatus'] == "Completed") ) { //|| $values['OrderStatus'] == "Cancelled" ?>
                                <a href="viewOrder.php?customEOID=<?=$values['OrderID']?>&CustID=<?=$values['Cid']?>&CustomerPO=<?=$values['AmazonOrderId']?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confirmAction(this,'Create Sales Order For Amazon','Are you sure you want to create SO ?' )" class="Blue" >
                                	<img src="../images/addsoo.png" width="16" border="0" onmouseover="ddrivetip('<center>Create sales order </center>', 140,'')" ;="" onmouseout="hideddrivetip()">
                                </a>
                                <?}elseif( $values['OrderType']=='Ebay' && !($values['OrderStatus'] == "Shipped" || $values['OrderStatus'] == "Completed") ){?>
                                	<a href="viewOrder.php?customEOID=<?=$values['OrderID']?>&CustID=<?=$values['Cid']?>&CustomerPO=<?=$values['AmazonOrderId']?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confirmAction(this,'Create Sales Order For Ebay','Are you sure you want to create SO ?' )" class="Blue" >
                                	<img src="../images/addsoo.png" width="16" border="0" onmouseover="ddrivetip('<center>Create sales order </center>', 140,'')" ;="" onmouseout="hideddrivetip()">
                                </a>
                                <?}?>

                                <?php if($ModifyLabel == 1){ 


if($status != 'Active'){?>
                                <a href="viewOrder.php?del_id=<?php echo $values['OrderID']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('Order')" class="Blue" ><?= $delete ?></a>              
                                <?php } }?>
                                &nbsp;
                            </td>
<? if($ModifyLabel==1){ ?>
 <td ><input type="checkbox" name="OrderID[]" id="OrderID<?= $Line ?>" value="<?= $values['OrderID'] ?>" /></td>
<?}?>
                            </tr>
                            <?php } // foreach end // ?>
                            <?php } else { ?>
                            <tr align="center" >
                            <td height="20" colspan="9"  class="no_record">No Order found. </td>
                            </tr>
                            <?php } ?>

                        <tr>  <td height="20" colspan="9" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arrayOrders) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                echo $pagerLink;
                            }
                        ?>

<input type="hidden" name="NumField" id="NumField" value="<?= sizeof($arrayOrders) ?>">



</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</form>
