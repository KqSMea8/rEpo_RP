<script language="JavaScript1.2" type="text/javascript">

    function ValidateSearch(SearchBy) {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';

    }

    function filterwarehouse(id)
    {
        LoaderSearch();
        if(id>0){
        location.href = "viewManageBin.php?warehouse=" + id + "&asc=Desc";
        }else{
            
           location.href = "viewManageBin.php"; 
        }
    }
 function popSn(vl) {
//alert(vl);
				document.getElementById(vl).style.display = 'block';
			}
			function hide(vl) {
				document.getElementById(vl).style.display = 'none';
			}
			//To detect escape button
			document.onkeydown = function(evt) {
				evt = evt || window.event;
				if (evt.keyCode == 27) {
					hide(vl);
				}
			};
function closeSN(vl){
//alert(vl);

			//alert("hiii");
			document.getElementById(vl).style.display = 'none';
		

}
//viewManageBin.php?sortby=w.warehouse_name&key=W004&asc=Desc&module=&search=Search
//http://localhost/erp/admin/warehouse/viewManageBin.php?sortby=w.warehouse_name&key=+%09TESTER&asc=Desc&module=&search=Search
</script>

<div class="had"><?= $MainModuleName ?></div>
<div class="message" align="center"><? if (!empty($_SESSION['mess_warehouse'])) {
    echo $_SESSION['mess_warehouse'];
    unset($_SESSION['mess_warehouse']);
} ?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

    <tr>   

        

        WareHouse Name : <select name="warehouse_name" id="warehouse_name" class="textbox" onchange="return filterwarehouse(this.value);">
        <option value="">--Select--</option>
<?php foreach ($warehouse_listted as $warehouse_data): ?>
            <option value="<?php echo $warehouse_data['WID']; ?>" <?=($warehouse_data['WID'] == $_GET['warehouse'])?("selected"):("")?>><?php echo $warehouse_data['warehouse_name']; ?></option>
<?php endforeach; ?>
    </select>                 				



    <td  valign="top" align="right">

<? if ($num > 0) { ?>                


            <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_binlocation.php?<?= $QueryString ?>';" />
            <input type="button" class="print_button"  name="exp" value="Print" onclick="window.open('binPrint.php', 'windowname', 'width=600,height=500,scrollbars=yes');"/><!-- Javascript:window.print(); -->
        <? } ?>

        <a href="editManageBin.php" class="add" >Add Bin Location</a>

<? if ($_GET['key'] != '') { ?>
            <a class="grey_bt"  href="viewManageBin.php">View All</a>
<? } ?>
    </td>
</tr>

<tr>
    <td  valign="top">


        <form action="" method="post" name="form1">
            <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
            <div id="preview_div">

                <table <?= $table_bg ?>>

                    <tr align="left"  >
                        <!--<td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','WID','<?= sizeof($arryWarehouse) ?>');" /></td>-->
                        <td width="15%"  class="head1" >Warehouse Code</td>
                        <td width="11%"  class="head1" >Warehouse Name</td>
                        <td class="head1" width="12%"> Bin Location</td> 
                        <td class="head1" width="12%"> Description</td> 

                        <td class="head1" align="center" width="12%"> Status</td> 
 <td class="head1" width="12%"> Sku</td> 
                        <td width="10%"  align="center" class="head1 head1_action" >Action</td>
                    </tr>

                    <?php
                    if (is_array($arryWarehouse) && $num > 0) {
                        $flag = true;
                        $Line = 0;

                        foreach ($arryWarehouse as $key => $values) {
                            $flag = !$flag;
                            $Line++;
                            $widval = $values["warehouse_id"];
                            $dataval = $objWarehouse->getWarehousedata($widval);
                            ?>
                            <tr align="left"  bgcolor="<?= $bgcolor ?>">			
                                    <!--<td ><input type="checkbox" name="binid[]" id="binid<?= $Line ?>" value="" /></td>-->
                                <td ><?= $dataval[0]['warehouse_code'] ?></td>
                                <td> <?= $dataval['0']['warehouse_name'] ?></td>		 
                                <td > <? echo stripslashes($values["binlocation_name"]); ?></td> 
                                <td ><? echo stripslashes($values["description"]); ?> </td>       
                                <td align="center">
                                    <?
                                    if ($values['status'] == 1)
                                        $status = "Active";
                                    else
                                        $status = "InActive";
                                    if ($values["binid"] > 1) {
                                        ?>		 
                                        <a href="editManageBin.php?active_id=<?php echo $values['binid']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" class="<?= $status ?>" ><?= $status ?></a>
                                    <?
                                    } else {
                                        echo $status;
                                    }
                                    ?>

                                </td>
<td   align="left" ><?php 

$ArryBinSku 	= 	$objWarehouse->getBinSku($values['binid']);

 if(!empty($ArryBinSku[0]['Sku'])){  echo $ArryBinSku[0]['Sku']; ?><br /><a id="showpopup" style="cursor:pointer;" onclick ="popSn('mrgn<?=$Line?>');">View More</a>


<div id="mrgn<?=$Line?>" style="display:none;  background-attachment: scroll;background-clip: border-box;background-color: rgba(0, 0, 0, 0.45); background-image: none;background-origin: padding-box;background-position: 0 0;background-repeat: repeat;background-size: auto auto;bottom: 0;box-sizing: border-box;    left: 0;opacity: 1;position: fixed;right: 0;top: 0;"  class="ontop" >

<div class="inner-mrgn">
<div class="close-mgn" ><i class="fa fa-times" onclick="closeSN('mrgn<?=$Line?>');" aria-hidden="true"></i></div>
<div class="popup-header">Serial Number List</div>
<div style="width: 317px; height: 376px; overflow-y: scroll;">
<table width="100%" id="myTable" class="order-list"   cellpadding="0" cellspacing="1">

<?php 
if(sizeof($ArryBinSku)>0){
for($s=0;$s<sizeof($ArryBinSku);$s++){
echo '<tr class="itembg"><td>';
echo $ArryBinSku[$s]['Sku']."<br>";
echo '</td></tr>';
}

}else{
echo '<tr><td>';
echo 'No Records';
echo '</td></tr>';
}

?>
</table>
</div></div> </div>
<? }else{ echo NOT_SPECIFIED;} ?>
</td>
                                <td  align="center" class="head1_inner"  >

                                    <? if ($values["binid"] > 1) { ?>
                                        <a href="vManageBin.php?view=<?php echo $values['binid']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" ><?= $view ?></a>
                                        <a href="editManageBin.php?edit=<?php echo $values['binid']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&amp;tab=Warehouse" ><?= $edit ?></a>

                                        <a href="editManageBin.php?del_id=<?php echo $values['binid']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a>   
        <? } else { ?>
                                        <a href="editManageBin.php?edit=<?php echo $values['binid']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&amp;tab=Warehouse" ><?= $edit ?></a>
                            <? } ?>

                                </td>
                            </tr>
                        <?php } // foreach end //?>

    <?php
} else {
    ?>
                        <tr align="center" >
                            `<td  colspan="8" class="no_record">No record found. </td>
                        </tr>
    <?php }
?>

                    <tr >  
                        <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryWarehouse) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                    </tr>
                </table>

            </div> 
<?
if (sizeof($arryWarehouse)) {
    ?>
                <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                    <tr align="center" > 
                        <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'binid', 'editManageBin.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');">
                            <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'binid', 'editManageBin.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');" />
                            <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'binid', 'editManageBin.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');" /></td>
                    </tr>
                </table><? }
?>  

            <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
            <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
        </form>
    </td>
</tr>
</table>
