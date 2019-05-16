<script>
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script> 


<div class="had">
    <?=$MainModuleName?>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

 
    <tr>
        <td  align="right" >
            
               <? if($num>0){?>
	<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_bom.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
            <a href="editBOM.php?curP=<?= $_GET['curP'] ?>" class="add">Add New BOM</a>	
            <? if($_GET['key']!='') {?>
		  <a href="viewBOM.php?curP=<?= $_GET['curP'] ?>" class="grey_bt">View All</a>
		<? }?>
            		
        </td>
    </tr>	
    <tr>
        <td  >
            <div class="message"><? if (!empty($_SESSION['mess_bom'])) {    echo $_SESSION['mess_bom'];    unset($_SESSION['mess_bom']);
} ?>
            </div>
        </td>
    </tr>		

    <tr>
        <td >

            <form action="" method="post" name="form1">
                
                <div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
                <table <?= $table_bg ?>>


                    <tr align="left">
                     
			<td width="10%" class="head1" ><?=BOM_NO?></td>
			<td   class="head1" >Description</td>
			<td width="15%" class="head1" >Bill With Option</td>
			<!--td width="10%"  class="head1" ><?=BOM_ITEM_CURRENCY?></td-->
			<td width="12%"  class="head1" ><?=BOM_DATE?></td>
			<!--<td width="10%" class="head1" align="center"><?=VIEW_STATUS?></td>-->
			<td width="7%"  align="center" class="head1 head1_action" ><?=Action?></td>
                  </tr>

                    <?php
                    if (is_array($arryBOM) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryBOM as $key => $values) {
                           $flag=!$flag;
	                  $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	                  $Line++;
			
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
				<td><?= stripslashes($values['Sku']); ?></td>
				<td><?= stripslashes($values['description']); ?></td>
				<td><?= stripslashes($values['bill_option']); ?></td>
				<td><?= date($Config['DateFormat'] , strtotime($values['bomDate'])); ?></td>
                               
		<td  align="center"  class="head1_inner" >

		<a href="vBom.php?view=<?=$values['bomID']?>&curP=<?=$_GET['curP']?>&tab=bill_Information" ><?=$view?></a>


                <a href="editBOM.php?edit=<? echo $values['bomID']; ?>&curP=<?php echo $_GET['curP']; ?>&tab=bill_Information"><?= $edit ?></a> 


               
<? if(!$objItem->isBOMTransactionExist($values['Sku'])){ 
//if($values['AsmCount'] == 0 && $values['DsmCount'] == 0){?>
		 
		<a href="editBOM.php?del_id=<? echo $values['bomID']; ?>&curP=<?php echo $_GET['curP']; ?>&tab=bill_Information" onClick="return confDel('Product')"  ><?=$delete?></a>	
                <? //} 

}?>
                
                </td>
                  </tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr>
                            <td  colspan="5" class="no_record"><?=NO_RECORD?></td>
                        </tr>

                    <?php } ?>



                    <tr >  <td  colspan="5" ><?=TOTAL_ADJUST_RECORD?> : &nbsp;<?php echo $num; ?>      <?php if (count($arryBOM) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>
</div>
              
                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">


            </form>
        </td>
    </tr>

</table>
