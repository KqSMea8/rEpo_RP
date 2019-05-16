<?
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix . "classes/filter.class.php");
      $objFilter = new filter();
       (empty($_GET['module']))?($_GET['module'] = "Customer"):("");
	$objCustomer=new Customer();

	$ModuleName = "Customer";

        
      /* * ******************************************** */

if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:".$ThisPageName);
    exit;
}

/*********************Set Defult ************/
$arryDefult = $objFilter->getDefultView($_GET['module']);

if($arryDefult[0]['setdefault'] == 1 && $_GET['customview'] == "" ){ 
    
  $_GET['customview']=  $arryDefult[0]['cvid']; 
    
}elseif($_GET['customview'] != "All" && $_GET['customview'] >0){
    
    $_GET['customview'] = $_GET['customview'];
    
}else{
    
  $_GET["customview"] = 'All';  
}
    
    
    
    if ($_GET["customview"] == 'All'  ) {
    $arryCustomer=$objCustomer->getCustomers($id,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
   
} else {
    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);
#echo $arryfilter[0]['status']; exit;
    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"], $_GET['module']);


    $arryQuery = $objFilter->getFileter($_GET["customview"]);


    if (!empty($arryColVal)) {
        foreach ($arryColVal as $colVal) {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");

        foreach ($arryQuery as $colRul) {

            if ($colRul['comparator'] == 'e') {
                if ($colRul['columnname'] == 'AssignTo') {
                    $comparator = 'like';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'AssignTo') {
                    $comparator = 'not like';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }





            if ($colRul['comparator'] == 'l') {
                $comparator = '<';

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'in') {
                $comparator = 'in';

                $arrVal = explode(",", $colRul['value']);

                $FinalVal = '';
                foreach ($arrVal as $tempVal) {
                    $FinalVal .= "'" . trim($tempVal) . "',";
                }
                $FinalVal = rtrim($FinalVal, ",");
                $setValue = trim($FinalVal);

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
            }
        }
        $colRule = rtrim($colRule, "  and");
         $arryCustomer = $objCustomer->CustomCustomer($colValue, $colRule);
    }
}  
        
        
        
	#$arryCustomer=$objCustomer->getCustomers($id,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objCustomer->numRows();       


	$pagerLink = $objPager->getPager($arryCustomer, $RecordsPerPage, $_GET['curP']);
	(count($arryCustomer) > 0) ? ($arryCustomer = $objPager->getPageRecords()) : ("");
?>
<script language="javascript1.2" type="text/javascript">


    function filterLead(id)
    {
        location.href = "viewCustomer.php?customview=" + id;
        LoaderSearch();
    }
</script>

<div class="had"><?=$MainModuleName?></div>
 <div class="message"><? if (!empty($_SESSION['mess_cust'])) {  echo stripslashes($_SESSION['mess_cust']);   unset($_SESSION['mess_cust']);} ?></div>
<table width="100%"   border=0 align="center" cellpadding=0 cellspacing=0 >
	<tr>
        <td align="right" valign="top">

<input type="button" class="export_button"  name="imp" value="Import Customer" onclick="Javascript:window.location='importCustomer.php';" />
		<?php  if (is_array($arryCustomer) && $num > 0) {?>



		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='../export_customer.php?<?=$QueryString?>';" />
		<?php }?>
		<a class="fancybox add_quick fancybox.iframe" href="addCust.php">Quick Entry</a>
		<a href="addCustomer.php" class="add">Add Customer</a>
		 <? if($_GET['search']!='') {?>
	  	<a href="viewCustomer.php" class="grey_bt">View All</a>
		<? }?>

		</td>
      </tr>
    <tr>
        <td>
           
            <table <?= $table_bg ?>>
                <? if ($_GET["customview"] == 'All') { ?>
                <tr align="left" >
			    	<td width="12%" height="20"  class="head1">Customer Code</td>
                    <td width="15%" height="20"  class="head1">Customer Name</td>    
                    <td height="20"  class="head1">Email Address</td>  
                    <td width="10%" height="20"  class="head1" >Phone</td>    
                    <td width="10%" height="20"  class="head1" >Country</td> 
                    <td width="10%" height="20"  class="head1" >State</td> 
                    <td width="10%" height="20"  class="head1" align="center">Status</td>
                    <td width="8%" height="20" align="left" class="head1">Action</td>
                </tr>
              <? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

                            <? } ?>
                                <td width="8%" height="20" align="left" class="head1">Action</td>
                            </tr>

                        <?
                        }            
               
                if($num > 0) {
                    $flag=true;                   
                    foreach ($arryCustomer as $key => $values) {
                        $flag=!$flag;	                      
                        $NumInvoice=$objCustomer->CountCustomerOrder($values['CustCode'],'Invoice');
                        ?>
                        <tr align="left">
                             <? if ($_GET["customview"] == 'All') { ?>
			 <td><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$values['CustCode']?>" ><?=$values['CustCode']?></a></td>
                            <td><?=stripslashes($values['FullName'])?></td>
                            <td><?=$values['Email']?></td>
                            <td><?=stripslashes($values['Landline'])?></td>
                            <td><?=stripslashes($values['CountryName'])?></td>
                            <td><?=stripslashes($values['StateName'])?></td>
                            <td align="center" >
			 <?php
				if ($values['Status'] == 'Yes') {
					$status = 'Active';
				} else {
					$status = 'InActive';
				}


                                            echo '<a href="editCustomer.php?active_id=' . $values["Cid"] . '&curP=' . $_GET["curP"] . '" class="'.$status.'"  onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>';
                                            ?>
                            </td>
                               <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';
                                            if ($cusValue['colvalue'] == 'CustomerSince') {

                                                if ($values[$cusValue['colvalue']] > 0){
                                                    echo date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']]));
                                                }else{
                                                    echo NOT_SPECIFIED;
                                                }
                                                
                                            } else {?>

                                                <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                                                <? }
                                            echo '</td>';
                                        }
                                    }
                                    ?>
                            <td height="20" align="left" class="head1_inner">
                                   <a href="vCustomer.php?view=<?=$values['Cid']?>&curP=<?=$_GET['curP']?>&tab=general"><?=$view?></a>
                                   <a href="editCustomer.php?edit=<?php echo $values['Cid']; ?>&curP=<?php echo $_GET['curP']; ?>&tab=general" class="Blue"><?= $edit ?></a>
			<? if($NumInvoice<=0){?>
                              <a href="editCustomer.php?del_id=<?php echo $values['Cid']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')" ><?= $delete ?></a>       <? } ?>       
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="8"  class="no_record"><?=NO_CUSTOMER?></td>
                    </tr>
                <?php } ?>

                <tr >  <td height="20" colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryCustomer) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                }
                ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
