<div class="had">Select Sales Order</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_salr'])) {echo $_SESSION['mess_sale']; unset($_SESSION['mess_sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	<td align="right" valign="bottom">

	<form name="frmSrch" id="frmSrch" action="SoList.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	<input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
	</form>



	</td>
	</tr>
	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
    <tr align="left">
		<td width="12%"  class="head1" >SO Number</td>
		<td width="12%" class="head1" >Order Date</td>
		<td class="head1" >Customer Name</td>
		<td class="head1">Sales Person</td>
		<td width="10%" align="center" class="head1" >Amount</td>
		<td width="10%" align="center" class="head1" >Currency</td>
		<td width="10%"  align="center" class="head1" >Status</td>
		<td width="8%"  align="center" class="head1" >Approved</td>
    </tr>
   
	<?php 
	if(is_array($arrySale) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arrySale as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	?>
	     <tr align="left"  bgcolor="<?=$bgcolor?>">
			<td><a href="InvoiceList.php?key=<?=$values['SaleID']?>&link=editReturn.php" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()"><?=$values['SaleID']?></a></td>
			<td>
			<? /*if($values['OrderDate']>0) 
			echo date($Config['DateFormat'], strtotime($values['OrderDate']));*/
			echo $values['OrderDate'];
			?>

			</td>
			<td><?=stripslashes($values["CustomerName"])?></td> 
			<td><?=stripslashes($values['SalesPerson'])?></td>
			<td align="center"><?=$values['TotalAmount']?></td>
			<td align="center"><?=$values['CustomerCurrency']?></td>
			<td align="center">	
			<? 
		 if($values['Status'] =='Completed'){
			 $Status = ST_CLR_CREDIT;
			 $StatusCls = 'green';
		 }else{
			$StatusCls = 'red';

			 if($values['Status'] =='Open'){
				if($values['Approved'] != 1) {
					$Status = ST_CREDIT_HOLD; $StatusCls = 'red';
				}else{
					$Status = ST_CREDIT_APP; $StatusCls = 'green';
					if(!empty($values['PaymentTerm'])){
						$arryTerm = explode("-",$values['PaymentTerm']);
						if($arryTerm[1]==''){
							$Status = ST_CREDIT_HOLD; $StatusCls = 'red';
						}
					}
				}
			}else{
				$Status = $values['Status'];		
			}	
		 }

		echo '<span class="'.$StatusCls.'">'.$Status.'</span>';
		
	 ?></td>


			<td align="center"><? 
				 if($values['Approved'] ==1){
					  $Approved = 'Yes';  $ApprovedCls = 'green';
				 }else{
					  $Approved = 'No';  $ApprovedCls = 'red';
				 }

				echo '<span class="'.$ApprovedCls.'">'.$Approved.'</span>';
				
			 ?></td>

    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_SO?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  
	 <td colspan="8"  id="td_pager">
	 Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arrySale)>0){?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}?></td>
	 </tr>
  </table>

  </div> 


  
</form>
</td>
	</tr>
</table>

