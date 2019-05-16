<?
	require_once($Prefix."classes/item.class.php");	
	include_once("includes/FieldArray.php");	
	$objItem=new items();
     	$ModuleName = "Item";
        $ViewUrl = "viewItem.php?curP=".$_GET['curP'];
	
	$arryItem=$objItem->GetItemsView($_GET);
	
	$num=$objItem->numRows();
        

	$pagerLink=$objPager->getPager($arryItem,$RecordsPerPage,$_GET['curP']);
	(count($arryItem)>0)?($arryItem=$objPager->getPageRecords()):(""); 
	 

?>
<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>


<div class="had"> <?=$MainModuleName?> </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_item'])) { echo $_SESSION['mess_item']; unset($_SESSION['mess_item']);} ?>
            </div>
        </td>
    </tr>
 
    <tr>
        <td  align="right" >

<a href="editItem.php" class="add">Add New Item</a>
            <? if($_GET['key']!='') {?>
		  <a href="<?=$ViewUrl?>" class="grey_bt">View All</a>
		<? }?>

<input type="button" class="export_button"  name="imp" value="Import Item" onclick="Javascript:window.location='importItem.php';" />

            <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='../export_item.php?<?=$QueryString?>&proc=<?=$_GET['proc']?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
            
        </td>
    </tr>	
   		

    <tr>
        <td id="ProductsListing">

            <form action="" method="post" name="form1">
                
                <div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
                <table <?= $table_bg ?>>


                    <tr align="left">
                        <!--<td width="4%" class="head1 head1_action" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ItemID','<?= sizeof($arryItem) ?>');" /></td>-->
                      <td width="9%" class="head1" >SKU</td>
                      <td class="head1" >Item Name</td>
                     
        	      <td width="15%" class="head1" >Price [<?=$Config['Currency']?>]</td>
           
                      <td width="10%" class="head1" >Qty on Hand</td>
             
                           <td width="9%"  class="head1"align="center">Status</td>
                      <td width="12%"  align="center" class="head1 head1_action" >Action</td>
                  </tr>

                    <?php
                    if (is_array($arryItem) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryItem as $key => $values) {
                            $flag = !$flag;
                             $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
                            $Line++;

                            //if($values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <!--<td class="head1_inner"><input type="checkbox" name="ItemID[]" id="ItemID<?= $Line ?>" value="<?= $values['ItemID']; ?>"></td>-->
                                <td>  
                                    <?= stripslashes($values['Sku']); ?>
                                </td>
                                <td><?= stripslashes($values['description']); ?></td>
								
                              
                             
                               	 <td><?=$values['sell_price'];?></td>
                                 <td><?=$values['qty_on_hand'];?></td>
                               
                             
                                  <td align="center"><?
                                    if ($values['Status'] == 1) {
                                        $status = 'Active';
                                    } else {
                                        $status = 'InActive';
                                    }

                               

                                    echo '<a href="editItem.php?active_id=' . $values["ItemID"] . '&curP=' . $_GET["curP"] . '" class="'.$status.' alt="Click to Change Status" title="Click to Change Status" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>';
                                    ?></td>
                                   
                                <td  align="center" class="head1_inner"  >
                                      <a href="vItem.php?view=<?=$values['ItemID']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>
                                    <a href="editItem.php?edit=<? echo $values['ItemID']; ?>&curP=<?php echo $_GET['curP']; ?>"><?= $edit ?></a>  <a href="editItem.php?del_id=<? echo $values['ItemID']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?= $delete ?></a>	</td>
                            </tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="10" class="no_record"><?=NO_RECORD?></td>
                        </tr>

                    <?php } ?>



                    <tr >  <td  colspan="10" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryItem) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>
</div>
                <? if (sizeof($arryItem)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0">
                        <tr align="center" > 
                            <td height="30" align="left" >
                               <!-- <input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('product','delete','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET[curP] ?>&dCatID=<?=$_GET['CatID']?>');">-->
                                <!--<input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('product','active','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET[curP] ?>&dCatID=<?=$_GET['CatID']?>');" />-->
                                <!--<input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('product','inactive','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET[curP] ?>&dCatID=<?=$_GET['CatID']?>');" />--></td>
                        </tr>
                    </table>
                <? } ?>

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">


            </form>
        </td>
    </tr>

</table>
