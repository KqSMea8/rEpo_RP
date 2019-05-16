<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center">
<?php if(!empty($_SESSION['mess_add_expense'])) {echo $_SESSION['mess_add_expense']; unset($_SESSION['mess_add_expense']); }?></div>
 
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="top">
		<a  class="add" href="editOtherExpense.php">Add Invoice Entry</a>
		 
		 <? if($_GET['search']!='') {?>
	  	<a href="<?=$RedirectURL?>" class="grey_bt">View All</a>
		<? }?>


		</td>
      </tr>
	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
    <tr align="left"  >
	<td width="10%"  class="head1">Payment Date</td>
	<td width="20%" class="head1">Vendor</td>
	<td width="15%" class="head1">Category</td>
	<td width="15%" class="head1">Payment Method</td>
	<td width="10%" class="head1">Reference No</td>
	<!--<td width="8%" class="head1" align="center">Currency</td>-->
	<td width="10%" class="head1" align="right">Amount (<?=$Config['Currency']?>)</td>
	<td width="10%" class="head1" align="center">Action</td>
      
    </tr>
   
    <?php 
  if(is_array($arryOtherExpense) && $num>0){
  	$flag=true;
	$Line=0;
	
  	foreach($arryOtherExpense as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	$accountName = $objBankAccount->getBankAccountNameByID($values["ExpenseTypeID"]); 
        

  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td><?=date($Config['DateFormat'], strtotime($values['PaymentDate']));	?></td>
	<td><?=stripslashes(ucfirst($values["supplier"]))?>
	 <?php  if(!empty($values["CompanyName"])){?>(<?=stripslashes(ucfirst($values["CompanyName"]))?>)<?php }?>
	</td> 
	<td><?=stripslashes($accountName)?></td> 
	<td><?=stripslashes($values["PaymentMethod"])?></td> 
    <td><?=stripslashes($values["ReferenceNo"])?></td> 
    
   
	<!--<td align="center"><//?=$values["Currency"];?></td>-->
        <td align="right"><strong><?=$values["TotalAmount"]?></strong></td> 
	<td height="26" align="center" class="head1_inner">
	<a href="vOtherExpense.php?view=<?=$values['ExpenseID']?>&curP=<?=$_GET['curP']?>"><?=$view?></a>
	<a href="editOtherExpense.php?edit=<?php echo $values['ExpenseID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
	<a href="editOtherExpense.php?del_id=<?php echo $values['ExpenseID']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('Transaction')" class="Blue" ><?= $delete ?></a>
	&nbsp;
	</td>
      
    </tr>
        <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="7"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryOtherExpense)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 

  
</form>
</td>
	</tr>
</table>
