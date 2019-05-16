<script language="javascript1.2" type="text/javascript">
    function filterLead(id)
    {
        location.href = "viewDeposit.php?customview=" + id;
        LoaderSearch();
    }
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center">
<?php if(!empty($_SESSION['mess_deposit'])) {echo $_SESSION['mess_deposit']; unset($_SESSION['mess_deposit']); }?></div>
 
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="top">
		<a  class="add" href="editDeposit.php">Deposit</a>
		 
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
    <? if ($_GET["customview"] == 'All') { ?>
    <tr align="left"  >
	<td width="10%"  class="head1">Deposit Date</td>
	<td width="15%" class="head1">Deposit To</td>
	<td width="15%" class="head1">Customer</td>
	<td width="8%" class="head1" align="right">Amount (<?=$Config['Currency']?>)</td>
	<!--<td width="8%" class="head1" align="center">Currency</td>-->	
	<td width="20%" class="head1">Reference No</td>
	<td width="8%" class="head1" align="center">Action</td>
    </tr>
   <? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

                            <? } ?>
                                <td width="8%" class="head1" align="center">Action</td>
                            </tr>

                        <?
                        }
  if(is_array($arryDeposit) && $num>0){
  	$flag=true;
	$Line=0;
	
  	foreach($arryDeposit as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	 
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
        <? if ($_GET["customview"] == 'All') { ?> 
	<td><?=date($Config['DateFormat'], strtotime($values['DepositDate']));?></td>
	<td><?=stripslashes($values["AccountName"])?></td> 
	<td><?=stripslashes($values["Customer"])?></td> 
	<td align="right"><strong><?=$values["Amount"]?></strong></td> 
	<!--<td align="center"><//?=$values["Currency"];?></td> -->
	<td><?=stripslashes($values["ReferenceNo"])?></td> 
             <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';
                                            if ($cusValue['colvalue'] == 'DepositDate') {

                                                if ($values[$cusValue['colvalue']] > 0){
                                                    echo date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']]));
                                                }else{
                                                    echo NOT_SPECIFIED;
                                                }
                                                
                                            } else if ($cusValue['colvalue'] == 'ReceivedFrom') {

                                                if (!empty($values[$cusValue['colvalue']])){
                                                    echo stripslashes($values["Customer"]);
                                                }else{
                                                    echo NOT_SPECIFIED;
                                                }
                                                
                                            }else {?>

                                                <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                                                <? }
                                            echo '</td>';
                                        }
                                    }
                                    ?>
	<td height="26" align="center" class="head1_inner">
	<a href="vDeposit.php?view=<?=$values['DepositID']?>&curP=<?=$_GET['curP']?>"><?=$view?></a>
	<!--<a href="editDeposit.php?edit=<?php echo $values['DepositID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>-->
	<a href="editDeposit.php?del_id=<?php echo $values['DepositID']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('Deposit')" class="Blue" ><?= $delete ?></a>
	&nbsp;
	</td>
      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	 <tr><td colspan="6" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?><?php if(count($arryDeposit)>0){?>&nbsp;&nbsp;&nbsp;Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 

  
</form>
</td>
	</tr>
</table>
