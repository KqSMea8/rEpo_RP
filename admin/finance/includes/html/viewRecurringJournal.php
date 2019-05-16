<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch() {
	ShowHideLoader('1','F');
      
    }

function SetRecType(EntryInterval){	
	var url = 'viewRecurringJournal.php?intv='+EntryInterval;
	ShowHideLoader('1','F');
	window.location = url;

}
/*
$(function() {
	$( "#EntryInterval" ).selectmenu({
	  change: function( event, ui ) {
             console.log(ui);
               var vals = ui.item.value;		
           	SetRecType(vals);
         }

     });
      
});*/

 
</script>

<div class="had"><?= $MainModuleName ?></div>
<div class="message" align="center"><?
    if(!empty($_SESSION['mess_rec_journal'])) {
        echo $_SESSION['mess_rec_journal'];
        unset($_SESSION['mess_rec_journal']);
    }
    ?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
  <tr>
        <td  valign="top">

<table id="search_table" cellspacing="0" cellpadding="0" border="0" style="margin:0">
<form name="frmSrch" id="frmSrch" action="" method="get" onsubmit="return ValidateSearch();">
<tr>
<td align="left">
<select name="intv" class="textbox" id="intv" >
	<option value="" <?php if($_GET['intv'] == ""){echo "selected";}?>>ALL</option>
	<? foreach($arryInterval as $interval){ 
		$sel = ($_GET['intv'] == $interval)?("selected"):("");
		$intervalLabel = str_replace("_"," ",$interval);
		echo '<option value="'.$interval.'" '.$sel.'>'.ucfirst($intervalLabel).'</option>';
	}?>

	</select>
</td>

<td align="left">
<select name="status" class="textbox" id="status"> 
	<option value="Active" <?php if($_GET['status'] == "Active"){echo "selected";}?>>Active</option>
	<option value="InActive" <?php if($_GET['status'] == "InActive"){echo "selected";}?>>InActive</option>
</select>
</td>
<td align="left">
  <input type="submit" value="Go" class="search_button" name="s">
</td>


</tr>


</form>
</table>



 </td>
    </tr>


    <tr>
        <td  valign="top">


            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
                       
                            <tr align="left"  >
                                <td width="7%" class="head1">Journal No</td>
				<td width="8%" class="head1">Journal Date</td>                              
                                <td width="8%" class="head1">Memo</td>                              
                                <td width="8%"  class="head1">Debit</td>
                                <td width="8%" class="head1">Credit</td>
				<td width="8%"  class="head1" >Currency</td>
				<td width="10%" class="head1">Interval</td>
                                <td width="8%" class="head1">Entry Date</td>
                                <td  width="8%"  class="head1" >Every</td>
                                <td  width="8%"  class="head1" >Entry From</td>
                                <td  width="8%"  class="head1" >Entry To</td>
                                <td width="7%"  align="center" class="head1 head1_action" >Action</td>
                            </tr>
                       
                        <?php

$cancel = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Cancel</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';


if (is_array($arryGerenalJournal) && $num > 0) { 
    $flag = true;
    $Line = 0;
    
    foreach ($arryGerenalJournal as $key => $values) {
        $flag = !$flag;
        $Line++;
                
  ?>
       <tr align="left"  bgcolor="<?= $bgcolor ?>">

                 
	<td><?=$values['JournalNo']?></td>
<td><? if($values['JournalDate']>0) 
	echo date($Config['DateFormat'], strtotime($values['JournalDate']));
	?></td>
	<td><?= $values['JournalMemo'] ?></td>
	<td><?= $values['TotalDebit'] ?></td>
	<td><?= $values['TotalCredit'] ?></td>
	<td><?= $values['Currency'] ?> </td>
		            
        <td>
	    <?php 
		if(!empty($values['JournalInterval'])){
			$_GET['intv'] = $values['JournalInterval'];
		}else{
			$_GET['intv'] = "Monthly";
		}
		if($_GET['intv'] == "semi_monthly"){ $_GET['intv'] = "Semi Monthly";  }

		echo ucfirst($_GET['intv']);
	    ?>
       </td>

      <td>

		 <? if($values['JournalInterval'] != 'biweekly' && $values['JournalInterval'] != 'semi_monthly'){
			echo $values['JournalStartDate'];

		 }?> 

      </td>

      <td>
		<? if($values['JournalInterval'] == "yearly"){ 
				        $monthNum  = $values['JournalMonth'];
				        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
				        $monthName = $dateObj->format('F'); 
			echo $monthName;
		  } else if($values['JournalInterval'] == "biweekly"){ 
			echo $values['EntryWeekly'];
		  }
		?>

     </td>
 
     <td>
		<?php  if($values['JournalDateFrom']>0)echo date($Config['DateFormat'], strtotime($values['JournalDateFrom']));?>
     </td>

     <td>
		<?php  if($values['JournalDateTo']>0)echo date($Config['DateFormat'], strtotime($values['JournalDateTo']));?>

     </td>

                                       

                                    
     <td  align="center" class="head1_inner">

		 <? if($ModifyLabel == 1){ ?>                                 
		 <a class="fancybox fancybox.iframe" href="<?= $EditUrl . '&pop=1&edit=' . $values['JournalID'] ?>" ><?= $edit ?></a>
				                                                           
		 <!--a href="viewRecurringJournal.php?cancel_id=<?=$values['JournalID']?>" onclick="return confirmAction(this, 'Cancel <?= $ModuleName ?>','Are you sure you want to cancel this <?= $ModuleName ?>?')"><?= $cancel ?></a-->  


		 <a href="Javascript:void(0);" onclick="Javascript:RemoveRecord(this,'<?=$values['JournalID']?>','<?=$ModuleName?>','cancel')" ><?= $cancel ?></a>
                                    

		<? } ?>


      </td>
   </tr>
<?php 

} // foreach end // ?>

<?php }else { ?>
                            <tr align="center" >
                                <td  colspan="13" class="no_record"><?= NO_RECORD ?> </td>
                            </tr>
<?php } ?>

                        <tr>  <td  colspan="13" id="td_pager">Total Record(s) : <span id="recordCount"><?=$num?></span>   
				</td>
				
                        </tr>
                    </table>

                </div> 


                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
            </form>
        </td>
    </tr>
</table>

