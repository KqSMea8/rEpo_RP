<script language="JavaScript1.2" type="text/javascript">
   


    function submitThisForm(frm){	
        if(document.getElementById("ProductsListing") != null){
            document.getElementById("ProductsListing").innerHTML= '<img src="images/loading.gif"><br><br><br><br>';
        }
        document.topForm.submit();
    }

</script> 


<div class="had">
    <?=$MainModuleName?> <?= $MainParentCategory ?>  <span><?= $ParentCategory ?></span>
</div>



<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

<tr>
		<td align="right" height="22" valign="bottom">

		<? if($num>0){?>
		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_transfer.php?<?=$QueryString?>';" />
		<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
		<? } ?>

	
		 <a href="editTransfer.php?curP=<?= $_GET['curP'] ?>" class="add">Add New Transfer</a>
		

		<? if($_GET['search']!='') {?>
		<a href="<?=$RedirectURL?>" class="grey_bt">View All</a>
		<? } ?>


		</td>
	</tr>
 
   	
    <tr>
        <td  >
            <div class="message"><? if (!empty($_SESSION['mess_transfer'])) {
    echo $_SESSION['mess_transfer'];
    unset($_SESSION['mess_transfer']);
} ?>
            </div>
        </td>
    </tr>		

    <tr>
        <td>
  <div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
            <form action="" method="post" name="form1">
                <table <?= $table_bg ?>>


                    <tr align="left">
                     
                      <td width="10%" class="head1" >Transfer No</td>
                      <td width="12%"  class="head1" >Transfer Date</td>
                      <td  class="head1">From Warehosue</td>
                      <td  class="head1" >To Warehosue</td>
                     
                      <td width="10%"  class="head1" align="center" >Status</td>
                          
                      <td width="10%"  align="center" class="head1 head1_inner" >Action</td>
                  </tr>

                    <?php
                    if (is_array($arryTransfer) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryTransfer as $key => $values) {
                           $flag=!$flag;
	                  $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	                  $Line++;

                            //if($values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                               <!-- <td><input type="checkbox" name="transferID[]" id="transferID<?= $Line ?>" value="<?= $values['transferID']; ?>"></td>-->
                                <td ><?= stripslashes($values['transferNo']); ?></td>
                                <td >

<? if($values['transferDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['transferDate']));
		?>


</td>
                                
                                <td><?= stripslashes($values['from_warehouse']); ?></td>
                                <td> <?= stripslashes($values['to_warehouse']); ?></td>
                               
                                <!--<td> </td>-->
                               <!-- <td> </td>-->
                                
				<td width="10%" align="center" ><?
                                    if ($values['Status'] == 1) {
                                        $cls = 'green';
                                       $status = 'Parked';
                                    } else if($values['Status'] == 2) {
                                        $cls = 'green';
                                       $status = 'Completed';
                                    }else{
                                        
                                      $cls = 'red';
                                        $status = 'Canceled';  
                                    }

                               

                                    echo '<span class="'.$cls.'"  >' . $status . '</span>';
                                    ?></td>
                          
                                 
                                   
                        <td  align="center" class="head1_inner" >
                                      <a href="vTransfer.php?view=<?=$values['transferID']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>
                                   
<? if ( $values['Status']!='2') {?>
 <a href="editTransfer.php?edit=<? echo $values['transferID']; ?>&curP=<?php echo $_GET['curP']; ?>"><?= $edit ?></a> 
                                    <a href="editTransfer.php?del_id=<? echo $values['transferID']; ?>&curP=<?php echo $_GET['curP']; ?>" onClick="return confDel('Product')"  ><?= $delete ?></a>	
<? }?>
</td>
                  </tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="9" class="no_record">No Transfer Stock found.</td>
                        </tr>

                    <?php } ?>



                    <tr >  <td class="head1_inner"   colspan="9" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryTransfer) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>



                <? if (sizeof($arryTransfer)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0">
                        <tr align="center" > 
                            <td height="30" align="left" >
                                <!--input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('product','delete','<?= $Line ?>','transferID','editTransfer.php?curP=<?= $_GET['curP'] ?>&dCatID=<?=$_GET['CatID']?>');">
                                <!--<input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('product','active','<?= $Line ?>','transferID','editTransfer.php?curP=<?= $_GET['curP'] ?>&dCatID=<?=$_GET['CatID']?>');" />-->
                                <!--<input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('product','inactive','<?= $Line ?>','transferID','editTransfer.php?curP=<?= $_GET['curP'] ?>&dCatID=<?=$_GET['CatID']?>');" />--></td>
                        </tr>
                    </table>
                <? } ?>

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">


            </form>
</div>
        </td>
    </tr>

</table>
