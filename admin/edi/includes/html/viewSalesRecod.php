<div class="had">
<?=$MainModuleName?>   
</div>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_Page'])) {
    echo stripslashes($_SESSION['mess_Page']); 
    unset($_SESSION['mess_Page']);
} ?></div>
        
			 <form action="" method="post" name="form1" id="form1">
            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="20%" height="20"  class="head1">Order Date </td> 
                    <td width="20%" height="20"  class="head1"><?= $module ?> Number </td> 
                    <td width="20%" height="20"  class="head1"><?=$NameAgent?></td> 
                    <td width="15%" height="20"  class="head1">Amount </td> 
                    <td width="15%" height="20"  class="head1">Posted By </td>
                   
                    <td width="20%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryCompanies, $RecordsPerPage, $_GET['curP']);
                (count($arryCompanies) > 0) ? ($arryCompanies = $objPager->getPageRecords()) : ("");
                if (is_array($arryCompanies) && $num > 0) {
                    $flag = true;
					
                    foreach ($arryCompanies as $key => $values) {
                    								 	
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?php if ($values['ReqDate'] > 0)
                                                echo date($Config['DateFormat'], strtotime($values['ReqDate']));  ?></td>
						                      	<td height="26"><?= $values[$ModuleID] ?></td>
                            <td height="26"><? if($module='SO'){ ?><a class="fancybox fancybox.iframe" href="../purchasing/suppInfo.php?view=<?=$values['SuppCode']?>" ><?=stripslashes($values["SuppCompany"])?></a>
<? }else{?><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?= $values['CustCode'] ?>" ><?= stripslashes($values["CustomerName"]) ?></a><? }?></td>
                            <td height="26"><?= $values['Amount'] ?></td>
                           
                            <td height="26" >
<?  
if($values["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
}else {
	echo $values["PostedBy"];
}
 ?>  
</td>
                            <td height="26" align="right"  valign="top"> 
                            <a href="<?= $EditUrl . '&del_id=' . $values['OrderID'] ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"><?= $delete ?></a> 
                            </td>
                        </tr>
                    <?php } // foreach end //?>
<?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="7"  class="no_record">No Pages found. </td>
                    </tr>
<?php } ?>

                <tr>  
                    <td height="20" colspan="7" >Total Record(s) : &nbsp;<?php echo $num; ?>    
<?php if (count($arryCompanies) > 0) { ?>&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
} ?>       
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div style="display:none;">
    <div id="dialogContent">
    	<input type="radio" name="EDIType" value="Customer" checked="checked" onclick="chosevalue(this.value); ">Customer <br>
    	<input type="radio" name="EDIType" value="Vendor" onclick="chosevalue(this.value);" >Vendor <br>
    	<input type="radio" name="EDIType" value="Both" onclick="chosevalue(this.value);" >Both
    </div>
</div>
<input type="hidden" name="request_CmpID" id="request_CmpID" value=""  >
<input type="hidden" name="name" id="name" value=""  >
<input type="hidden" name="EDITypeSelected" id="EDITypeSelected" value=""  >
</form>
<script type="text/javascript">

function chosevalue(selectedval){
	var request_CmpID=$('#request_CmpID').val();
	var name=$('#name').val();
	$('#EDITypeSelected').val(selectedval);
	$("#form1").submit();
	
	 $.fancybox.close();
	 
}

function selectitems(request_CmpID,name){
	$('#request_CmpID').val(request_CmpID);
	$('#name').val(name);
	$.fancybox({
        'type': 'inline',
        'href': '#dialogContent',
       'afterClose':function () {
		  
    		}
    }); 
		
	
	
}


</script>
