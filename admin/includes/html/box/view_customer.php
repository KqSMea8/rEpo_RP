<?
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix . "classes/filter.class.php");
	require_once($Prefix . "classes/lead.class.php"); // added by karishma 21 jan 2016 for multiple edit
	include_once("includes/FieldArray.php");
      	$objFilter = new filter();
       	(empty($_GET['module']))?($_GET['module'] = "Customer"):("");
	$objCustomer=new Customer();
	$objLead=new lead();

	$ModuleName = "Customer";
	$RedirectUrl = "viewCustomer.php?curP=".$_GET['curP'];
	(empty($_GET['CatID']))?($_GET['CatID']=""):("");	
	 

/***********************/
if(!empty($_POST)) {
	CleanPost();
    if(sizeof($_POST['Cid'] > 0)) {
        $customerid = implode(",", $_POST['Cid']);	 

        if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
		if($_POST['RowColor']=='None') $_POST['RowColor']='';
           	$_SESSION['mess_cust'] = ROW_HIGHLIGHTED;
		$objCustomer->setRowColorCust($customerid,$_POST['RowColor']);
        }    
	
	if(!empty($_POST['DeleteButton'])){//added by chetan on 8Aug//
		$_SESSION['mess_cust'] = CUSTOMER_REMOVE_MULTIPLE;
		$objCustomer->deleteCustomer($_POST['Cid']);
	}
  
        header("location:" . $RedirectUrl);
        exit;
    }
}
/***********************/
	

        
      /* * ******************************************** */

if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:".$ThisPageName);
    exit;
}

/*********************Set Defult ************/
$arryDefult = $objFilter->getDefultView($_GET['module']);
 
if(!empty($arryDefult[0]['setdefault']) && $_GET['customview'] == "" ){ 
    
  $_GET['customview']=  $arryDefult[0]['cvid']; 
    
}elseif($_GET['customview'] != "All" && $_GET['customview'] >0){
    
    $_GET['customview'] = $_GET['customview'];
    
}else{
    
  $_GET["customview"] = 'All';  
}
    
    
    
if ($_GET["customview"] != 'All' ) {

    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);
	#echo $arryfilter[0]['status']; exit;
    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"], $_GET['module']);

    $arryQuery = $objFilter->getFileter($_GET["customview"]);

	$colValue = $colRule = ''; 
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
 	$Config['rule'] =  $colRule;
        $Config['val'] =  $colValue;
         //$arryCustomer = $objCustomer->CustomCustomer($colValue, $colRule); //Not required
       

    }
}  
        
        $Config['rows'] = (!empty($_GET['rows'])) ? $_GET['rows'] :'';  
	$id = (!empty($id)) ? $id :'';  
	(empty($_GET['status']))?($_GET['status']=""):(""); 
	/*****************************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$Config['addTp'] = 'billing';
	$arryCustomer=$objCustomer->getCustomers($id,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);

	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
	$arryCount=$objCustomer->getCustomers($id,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$arryCount[0]['NumCount'];	

	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*****************************/	


// Added by karishma for editable field on 21 Jan 2016
//echo '<pre>';
//print_r($tableFielsDes);
$CustomFieldLists=$objLead->getCustomField('Customer');
$FieldTypeArray=array();
$FieldEditableArray=array();
$SelectboxEditableArray=array();
$labelArray = array('LeadSource'=>'lead_source','LeadStatus'=>'lead_status','LeadIndustry'=>'Industry','SalesStage'=>'SalesStage','Type'=>'OpportunityType',
    'TicketStatus'=> 'Status','Priority'=>'priority','TicketCategory'=>'category','PaymentMethod'=>'PaymentMethod',
    'ShippingMethod'=>'carrier','ActivityStatus'=> 'status','ActivityType'=>'activityType','expectedresponse'=>'expectedresponse','campaigntype'=>'campaigntype','campaignstatus'=>'campaignstatus');

//print_r($CustomFieldLists);
foreach($CustomFieldLists as $val){
	$FieldTypeArray[$val['fieldname']]=$val['type'];
	$FieldEditableArray[$val['fieldname']]=1;
	$key=array_search($val['fieldname'], $labelArray);

	if(false !== $key){
		$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$key,'selectfieldType'=>'text');
	}else{
		if($val['dropvalue']!='' && $val['dropvalue']!='0'){
			$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldid'],'selectfieldType'=>'text');

		}else{

			if($val['fieldname']=='country_id' || $val['fieldname']=='product'){
				$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldname'],'selectfieldType'=>'int');
			}else{
				$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldname'],'selectfieldType'=>'text');
			}

		}

	}
}
$FieldTypeArray['FullName']='text';
$FieldEditableArray['FullName']='1';
$FieldTypeArray['assignedTo']='multiselect';
$FieldEditableArray['assignedTo']='1';
$FieldEditableArray['CustCode']='0';
//$FieldEditableArray['LandlineNumber']='0';
//echo '<pre>';
//print_r($FieldEditableArray);
$SelectboxEditableArray['Currency']=array('selecttbl'=>'Currency','selectfield'=>'Currency','selectfieldType'=>'text');

// end by karishma for editable field on 21 Jan 2016
        
	/*
	$arryCustomer=$objCustomer->getCustomers($id,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objCustomer->numRows(); 
	$pagerLink = $objPager->getPager($arryCustomer, $RecordsPerPage, $_GET['curP']);
	(count($arryCustomer) > 0) ? ($arryCustomer = $objPager->getPageRecords()) : ("");
	*/
?>
<script language="javascript1.2" type="text/javascript">


    function filterLead(id)
    {
        location.href = "viewCustomer.php?customview=" + id;
        LoaderSearch();
    }

//By Rajan 21 Jan 2016//
    $(document).ready(function(){
        
    	  $('#highlight select#RowColor').attr('onchange','javascript:showColorRowsbyFilter(this)');
          $('#highlight select#RowColor option').each(function() {
              $val = $(this).val();
              $text = $(this).text();
              $val = $val.replace('#', '');
    		  $(this).val($val);
          });
          
    });


    var showColorRowsbyFilter = function(obj)
    { 
        if(obj.value !='')
        {
            $url = window.location.href.split("?rows")[0]; 
            window.location.href = $url+'?rows='+obj.value;
        }
    }
    //End Rajan 21 Jan 2016//
//End Rajan 21 Jan 2016//
</script>

<div class="had"><?=$MainModuleName?></div>
 <div class="message"><? if (!empty($_SESSION['mess_cust'])) {  echo stripslashes($_SESSION['mess_cust']);   unset($_SESSION['mess_cust']);} ?></div>
 <form action="" method="post" name="form1">
<table width="100%"   border=0 align="center" cellpadding=0 cellspacing=0 >
	<tr>
        <td align="right" valign="top">


		<?php  if (is_array($arryCustomer) && $num > 0) {?>


<ul class="export_menu">
<li><a class="hide" href="#">Export Customer</a>
<ul>
<li class="excel" ><a href="../export_customer.php?<?=$QueryString?>&flage=1" ><?=EXPORT_EXCEL?></a></li>
<li class="pdf" ><a href="pdfCustomer.php?<?=$QueryString?>" ><?=EXPORT_PDF?></a></li>	
<li class="csv" ><a href="../export_customer.php?<?=$QueryString?>&flage=2" ><?=EXPORT_CSV?></a></li>
<li class="doc" ><a href="../export_todoc_Customer.php?<?=$QueryString?>" ><?=EXPORT_DOC?></a></li>
</ul>
</li>
</ul>

		<?php }?>

<input type="button" class="export_button"  name="imp" value="Import Customer" onclick="Javascript:window.location='importCustomer.php';" />


		<a class="fancybox add_quick fancybox.iframe" href="addCust.php">Quick Entry</a>

		<ul class="export_menu" style="margin-right:5px;">
<li><a href="#" class="hide" style="background:#d40503 url('../../admin/images/plus.gif') no-repeat scroll 5px 5px; !important;" >Add Customer</a>
<ul>
<li  ><a href="addCustomer.php" style="background:#d40503 url('../../admin/images/plus.gif') no-repeat scroll 5px 5px; !important; margin-bottom:2px; margin-top:2px;">Add  New Customer</a></li>
<li  > <a class="fancybox  fancybox.iframe" href="VenderList.php" style="background:#d40503 url('../../admin/images/plus.gif') no-repeat scroll 5px 5px; !important; ">Add From Vendor</a></li>	

</ul>
</li>
</ul>
		 <? if($_GET['search']!='') {?>
	  	<a href="viewCustomer.php" class="grey_bt">View All</a>
		<? }?>




		</td>
      </tr>
<? if($num>0){?>
	<tr>
        <td align="right">

<?
$ToSelect = 'Cid';
include_once("../includes/FieldArrayRow.php");
echo $RowColorDropDown;
?>
<input type="submit" name="DeleteButton" class="button" value="Delete" onclick="javascript: return ValidateMultiple('customer', 'delete', 'NumField', 'Cid');">
 </td>
      </tr>
<? } ?>  


    <tr>
        <td>
           
            <table <?= $table_bg ?>>
                <? if ($_GET["customview"] == 'All') { ?>
                <tr align="left" >
			    	<td width="12%" height="20"  class="head1">Customer Code</td>
                    <td width="15%" height="20"  class="head1">Customer</td>    
                    <td height="20"  class="head1">Email Address</td>  
                      
                    <td width="10%" height="20"  class="head1" >Country</td> 
                    <td width="10%" height="20"  class="head1" >State</td> 
			<td width="10%" height="20"  class="head1" >Phone</td>  
                    <td width="10%" height="20"  class="head1" align="center">Status</td>
                    <td width="8%" height="20" align="left" class="head1">Action</td>
<? if($ModifyLabel==1){ ?>  <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'Cid', '<?=sizeof($arryCustomer)?>');" /></td><?}?>
                </tr>
              <? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

                            <? } ?>
                                <td width="8%" height="20" align="left" class="head1">Action</td>
<? if($ModifyLabel==1){ ?>  <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'Cid', '<?=sizeof($arryCustomer)?>');" /></td><?}?>
                            </tr>

                        <?
                        }            
               
(empty($country_code))?($country_code=""):("");
(empty($country_prefix))?($country_prefix=""):("");


			if($num > 0) {
					$flag=true;   
					$Line = 0;                
					foreach ($arryCustomer as $key => $values) {
					$flag=!$flag;	
					$Line++;                      
					
					$Customer = stripslashes(ucfirst($values['CustomerName']));	
					$Namefield='FullName';

					if($values['CustomerType']=='Company' && $values['CustomerType']!='Company'){
					$Namefield='Company';

					}		
                        ?>
                        <tr align="left" <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?>>
                             <? if ($_GET["customview"] == 'All') { ?>
			<td><a class="fancybox fancybox.iframe"
					href="../custInfo.php?view=<?=$values['CustCode']?>"><?=$values['CustCode']?></a></td>
				<td	onmouseover="mouseoverfun('<?php echo $Namefield; ?>','<?php echo $values['Cid']; ?>')"	onmouseout="mouseoutfun('<?php echo $Namefield; ?>','<?php echo $values['Cid']; ?>')">
				<span id="<?php echo $Namefield; ?><?php echo $values['Cid']; ?>"><?=$Customer?>
				</span> <?php if($ModifyLabel==1 && $FieldEditableArray[$Namefield]==1){ ?>
				<span class="editable_evenbg"
					id="field_<?php echo $Namefield; ?><?php echo $values['Cid']; ?>"></span>
				<span
					id="edit_<?php echo $Namefield; ?><?php echo $values['Cid']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('s_customers','<?php echo $Namefield; ?>','Cid','<?php echo $values['Cid']; ?>','<?php echo $FieldTypeArray[$Namefield]?>');"><?= $edit ?></span>
					<?php }?></td>
				<td><?=$values['Email']?></td>

				<td><?=stripslashes($values['CountryName'])?></td>
				<td><?=stripslashes($values['StateName'])?></td>
				<td
					onmouseover="mouseoverfun('Landline','<?php echo $values['Cid']; ?>')"
					onmouseout="mouseoutfun('Landline','<?php echo $values['Cid']; ?>');">
				<span id="Landline<?php echo $values['Cid']; ?>"><?=stripslashes($values['Landline'])?></span>
				<?php  if(!empty($values['Landline'])){?> <a
					href="javascript:void(0);"
					onclick="call_connect('call_form','to','<?=stripslashes($values['Landline'])?>','<?=$values['Cid']?>','<?=$country_code?>','<?=$country_prefix?>','Customer')"
					class="call_icon"> <span class="phone_img"></span></a> <?php } ?> <?php if($ModifyLabel==1 && $FieldEditableArray['Landline']==1){ ?>
				<span class="editable_evenbg"
					id="field_Landline<?php echo $values['Cid']; ?>"></span> <span
					id="edit_Landline<?php echo $values['Cid']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('s_customers','Landline','Cid','<?php echo $values['Cid']; ?>','<?php echo $FieldTypeArray['Landline']?>','<?php echo $SelectboxEditableArray['Landline']['selecttbl']?>','<?php echo $SelectboxEditableArray['Landline']['selectfield']?>','<?php echo $SelectboxEditableArray['Landline']['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?></td>

				<td align="center"><?php
				if ($values['Status'] == 'Yes') {
					$status = 'Active';
				} else {
					$status = 'InActive';
				}

				echo '<a href="editCustomer.php?active_id=' . $values["Cid"] . '&curP=' . $_GET["curP"] . '" class="'.$status.'"  onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>';
				?></td>
                               <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                           echo '<td onmouseover="mouseoverfun(\''.$cusValue['colvalue'].'\',\''.$values['Cid'].'\');"  onmouseout="mouseoutfun(\''.$cusValue['colvalue'].'\',\''.$values['Cid'].'\');" >';

						if ($cusValue['colvalue'] == 'CustomerSince') {

							if ($values[$cusValue['colvalue']] > 0){
								echo '<span id="'.$cusValue['colvalue'].$values['Cid'].'">'.date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']])).'</span>';
							}else{
								echo '<span id="'.$cusValue['colvalue'].$values['Cid'].'">'.NOT_SPECIFIED.'</span>';
							}

						} else {?>

						<?= (!empty($values[$cusValue['colvalue']]) ) ? ('<span id="'.$cusValue['colvalue'].$values['Cid'].'">'.stripslashes($values[$cusValue['colvalue']]).'</span>') : ('<span id="'.$cusValue['colvalue'].$values['Cid'].'">'.NOT_SPECIFIED.'</span>') ?>
						<? }?>
						<?php if($ModifyLabel==1 && $FieldEditableArray[$cusValue['colvalue']]==1){ 
$val1 = (!empty($SelectboxEditableArray[$cusValue['colvalue']]['selecttbl'])) ? $SelectboxEditableArray[$cusValue['colvalue']]['selecttbl'] : '';
$val2 = (!empty($SelectboxEditableArray[$cusValue['colvalue']]['selectfield'])) ? $SelectboxEditableArray[$cusValue['colvalue']]['selectfield'] : '';
$val3 = (!empty($SelectboxEditableArray[$cusValue['colvalue']]['selectfieldType'])) ? $SelectboxEditableArray[$cusValue['colvalue']]['selectfieldType']  : '';

?>
		<span class="editable_evenbg" id="field_<?php echo $cusValue['colvalue'].$values['Cid']; ?>"></span>
<span id="edit_<?php echo $cusValue['colvalue'].$values['Cid']; ?>" style="cursor: pointer; display: none;"	onclick="getField('s_customers','<?php echo $cusValue['colvalue'];?>','Cid','<?php echo $values['Cid']; ?>','<?php echo $FieldTypeArray[$cusValue['colvalue']]?>' ,'<?php echo $val1;?>','<?php echo $val2;?>','<?php echo $val3;?>');"><?= $edit ?></span>
					<?php }?>
					<?php
					echo '</td>';
                                        }
                                    }
                                    ?>
                            <td height="20" align="left" class="head1_inner">
                                   <a href="vCustomer.php?view=<?=$values['Cid']?>&curP=<?=$_GET['curP']?>&tab=general"><?=$view?></a>
                                   <a href="editCustomer.php?edit=<?php echo $values['Cid']; ?>&curP=<?php echo $_GET['curP']; ?>&tab=general" class="Blue"><?= $edit ?></a>
			<?  if(!$objCustomer->isCustomerTransactionExist($values['CustCode'])){ ?>
                              <a href="editCustomer.php?del_id=<?php echo $values['Cid']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')" ><?=$delete?></a>       
			<? } ?>       
                                &nbsp;
                            </td>
<? if($ModifyLabel==1){ ?>
 <td ><input type="checkbox" name="Cid[]" id="Cid<?=$Line?>" value="<?=$values['Cid']?>" /></td>
<?}?>
                        </tr>
                    <?php } // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="9"  class="no_record"><?=NO_CUSTOMER?></td>
                    </tr>
                <?php } ?>

                <tr >  <td height="20" colspan="9" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryCustomer) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                }
                ?></td>
                </tr>
            </table>
  <input type="hidden" name="NumField" id="NumField"	value="<?=sizeof($arryCustomer)?>">
		<input type="hidden" name="opentd"	id="opentd" value="">
        </td>
    </tr>
</table>
 </form>
