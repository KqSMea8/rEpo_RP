<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}

   function filterLead(id)
    {
        location.href = "viewPoCreditNote.php?customview=" + id;
        LoaderSearch();
    }


$(function() {
        $("#Post_to_GL").click(function(e) {

            var number_of_checked_checkbox = $(".posttogl:checked").length;
            if (number_of_checked_checkbox == 0) {
                alert("Please select atleast one credit memo.");
                return false;
            } else {
		 ShowHideLoader('1','P');
                return true;
            }

        });
    })


function ChangePostToGlDate() {	
    	
	var CountCheck = document.getElementById("CountCheck").value;

	var orderno="";	var j=0;	
	for(var i=1; i<=CountCheck; i++){
		if(window.parent.document.getElementById("posttogl"+i).checked){
			j++;
			var posttogl =window.parent.document.getElementById("posttogl"+i).value;
			orderno+=posttogl+',';
		}
	}

	if(j>0){
		if((document.getElementById("gldaterow").style.display == 'none')){ 
			document.getElementById("gldaterow").style.display = '' ;	
		}
        }else{
		document.getElementById("gldaterow").style.display = 'none';  	
	}
    	
    }


function SelectCheck(MainID,ToSelect)
{	
	var flag,i;
	var Num = document.getElementById("CountCheck").value;
	if(document.getElementById(MainID).checked){
		flag = true;
	}else{
		flag = false;
	}
	
	for(i=1; i<=Num; i++){
		document.getElementById(ToSelect+i).checked=flag;
	}
	ChangePostToGlDate();
}

//bysachin
 function makepdffile(url){
            $.ajax({
            url: url,
        });
    }
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><?php
        if (!empty($_SESSION['mess_Sale'])) {
            echo $_SESSION['mess_Sale'];
            unset($_SESSION['mess_Sale']);
        }
        ?><? if(!empty($_SESSION['mess_credit'])) {echo $_SESSION['mess_credit']; unset($_SESSION['mess_credit']); }?></div>


<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
?>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<form action="" method="post" name="form1">
	<tr>
        <td align="right" valign="top">
			<a href="<?=$AddUrl?>" class="add">Add <?=$ModuleName?></a>
	
		   <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_po_credit_note.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
	
	 
		

		 <? if($_GET['search']!='') {?>
	  	<a href="viewPoCreditNote.php" class="grey_bt">View All</a>
		<? }?>


		</td>
      </tr>
	 

<? if($num > 0 && $ModifyLabel==1){ ?> 	 
<tr>
	  <td  valign="top" align="right">
 <input type="submit" class="button" name="Post_to_GL" id="Post_to_GL" value="Post to GL" style="font-weight: normal; height: 22px;">


	</td>
      </tr>
 


<tr id="gldaterow"  style="display:none">
        
                  
 <td align="right" valign="top"><span class="posttogl">Post to GL Date: </span><script>
$(function() {
$( "#PostToGLDate" ).datepicker({ 
		
	
		showOn: "both",
	yearRange: '<?=date("Y")-10?>:<?=date("Y")?>', 


	dateFormat: 'yy-mm-dd',

	changeMonth: true,
	changeYear: true
	
	});
});
</script>
<? 
$todatdate=$Config['TodayDate'];
$todatdate = explode(" ", $todatdate);
//echo $todatdate[0];exit;

?>
   
<input id="PostToGLDate" name="PostToGLDate" readonly="" class="datebig" value="<?=$todatdate[0]?>"  type="text" >
               
                  
        
          
              
                      </td>
        </tr>

<? }?>

	<tr>
	  <td  valign="top">
	


<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
  
    <tr align="left"  >
	    <? if ($_GET["customview"] == 'All') { ?>	
            <td width="8%" class="head1" >Posted Date</td>
	    <td width="11%" class="head1" >GL Posting Date</td>
            <td width="11%"  class="head1" >Credit Memo ID#</td>
            <!--td width="10%" class="head1" >Expiry Date</td-->
            <td class="head1" >Vendor</td>
		 <td width="10%"   class="head1" >Posted By</td>
            <td width="10%" align="center" class="head1" >Amount</td>
            <td width="5%" align="center" class="head1" >Currency</td>
            <td width="5%"  align="center" class="head1" >Status</td>
            <td width="5%"  align="center" class="head1" >Approved</td>
           
    	    <? }else{
		foreach ($arryColVal as $key => $values) { ?>
		<td width=""  class="head1" ><?= $values['colname'] ?></td>
		<? } 
	   } ?>

	  <td width="11%"  align="center" class="head1 head1_action" >Action</td>
	<? if($ModifyLabel==1){ ?> <td width="1%" align="center" class="head1">
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'posttogl');" /></td>
	<? } ?>

    </tr>

    <?php 

 $PdfDir = $Config['FilePreviewDir'].$Config['P_Credit'];

  if(is_array($arryPurchase) && $num>0){
  	$flag=true;
	$Line=0;$CountCheck=$separator=0;
  	foreach($arryPurchase as $key=>$values){
	$flag=!$flag;
	$Line++;

	if($values['PostToGL'] == "1" && $separator!=1 ) {
		echo '<tr align="center"><td  colspan="12" class="selectedbg">&nbsp;</td></tr>';
		$separator=1;
	}
	
	$EmailIcon = ($values['MailSend']!=1)?('emailgreen.png'):('emailred.png');
	$sendemail = '<img src="' . $Config['Url'] . 'admin/images/'.$EmailIcon.'" border="0"  onMouseover="ddrivetip(\'<center>Send '.$ModuleName.'</center>\', 120,\'\')"; onMouseout="hideddrivetip()" >';

	if(!empty($values["VendorName"])){ 
            $SupplierName = $values["VendorName"];
        }else{
            $SupplierName = $values["SuppCompany"];
        }


/********************/
	$PdfResArray = GetPdfLinks(array('Module' => 'Credit',  'ModuleID' => $values["CreditID"], 'ModuleDepName' => "PurchaseCreditMemo", 'OrderID' => $values['OrderID'], 'PdfFolder' => $Config['P_Credit'], 'PdfFile' => $values['PdfFile']));

/********************/
  ?>
    <tr align="left" >
          <? if ($_GET["customview"] == 'All') { ?> 

	   <td height="20">
	   <? if($values['PostedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PostedDate']));
		?>
	   
	   </td>
<td>
            <?
            if ($values['PostToGLDate'] > 0)
                echo date($Config['DateFormat'], strtotime($values['PostToGLDate']));
            ?>

        </td>
      <td><?=$values["CreditID"]?></td>
	  <!--td>
	   <? if($values['ClosedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['ClosedDate']));
		?>
	   
	   </td-->
      <td><a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?=$values['SuppCode']?>" ><?=stripslashes($SupplierName)?></a></td> 

<td >
<?  
if($values["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
}else {
	echo $values["PostedBy"];
}
 ?>  
</td>

 <td align="center">

<? 
	echo $values['TotalAmount'];  
		
	/***********/			
 	if($values['PostToGL'] == "1" && $values['Status']=='Part Applied'){   
		$paidOrderAmnt = $objBankAccount->GetTotalPaymentCredit($values['CreditID'],"Purchase");  
	     	if(!empty($paidOrderAmnt)){ 	
		      $Balance =  $values['TotalAmount'] - $paidOrderAmnt; 
 		      if($Balance>0)echo '<div class=redmsg>Balance: '.number_format($Balance,'2').'</div>'; 
		}
	}
	/***********/				    

 ?>


</td>
     <td align="center"><?=$values['Currency']?></td>
     <td align="center">
	 <? 
		 if($values['Status'] =='Completed'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = 'red';
		 }

		echo '<span class="'.$StatusCls.'">'.$values['Status'].'</span>';
		
	 ?>
	 
	</td>


    <td align="center"><? 
		 if($values['Approved'] ==1){
			  $Approved = 'Yes';  $ApprovedCls = 'green';
		 }else{
			  $Approved = 'No';  $ApprovedCls = 'red';
		 }

		echo '<span class="'.$ApprovedCls.'">'.$Approved.'</span>';
		
	 ?></td>
     <?
                                        } else {

                                            foreach ($arryColVal as $key => $cusValue) {
                                                echo '<td>';

                                                if ($cusValue['colvalue'] == 'SuppCompany') {
                                                    
                                                    echo '<a class="fancybox fancybox.iframe" href="suppInfo.php?view=' . $values['SuppCode'] . '" >' . stripslashes($values["SuppCompany"]) . '</a>';
                                                } elseif ($cusValue['colvalue'] == 'SalesPerson') {
                                                    echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view=' . $values['SalesPersonID'] . '" >' . stripslashes($values["SalesPerson"]) . '</a>';
                                                } elseif ($cusValue['colvalue'] == 'Approved') {
                                                    #echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view=' . $values['SalesPersonID'] . '" >' . stripslashes($values["SalesPerson"]) . '</a>';

                                                    if ($values['Approved'] == 1) {
                                                        $Approved = 'Yes';
                                                        $ApprovedCls = 'green';
                                                    } else {
                                                        $Approved = 'No';
                                                        $ApprovedCls = 'red';
                                                    }

                                                    echo '<span class="' . $ApprovedCls . '">' . $Approved . '</span>';
                                                } elseif ($cusValue['colvalue'] == 'Status') {

                                                    if ($values['Status'] == 'Completed') {
                                                        $StatusCls = 'green';
                                                    } else {
                                                        $StatusCls = 'red';
                                                    }

                                                    echo '<span class="' . $StatusCls . '">' . $values['Status'] . '</span>';
                                                } elseif ($cusValue['colvalue'] == 'PostedDate' || $cusValue['colvalue'] == 'ClosedDate') {
                                                    if ($values[$cusValue['colvalue']] > 0)
                                                        echo date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']]));
                                                } elseif ($cusValue['colvalue'] == 'EntryType') {
                                                    if ($values[$cusValue['colvalue']] == 'one_time') {

                                                        $Entry = explode('_', $values[$cusValue['colvalue']]);

                                                        $EntryType = ucfirst($Entry[0]) . " " . ucfirst($Entry[1]);
                                                        ?>
                                                        <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($EntryType)) : (NOT_SPECIFIED) ?>

                                                    <? } else { ?>

                                                        <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes(ucfirst($values[$cusValue['colvalue']]))) : (NOT_SPECIFIED) ?>

                                                    <?
                                                    }
                                                } else {
                                                    ?>

                                                    <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                                                    <?
                                                }

                                                echo '</td>';
                                            }
                                        }
                                        ?>
      <td  align="center" class="head1_inner">

<a href="<?=$ViewUrl.'&view='.$values['OrderID']?>" ><?=$view?></a>
  <? if($values['PostToGL'] != "1" && $values['Status'] != 'Completed'){  	 ?>
<a href="<?=$EditUrl.'&edit='.$values['OrderID']?>" ><?=$edit?></a>
<a href="<?=$EditUrl.'&del_id='.$values['OrderID']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a>
<? } ?>
 
 
<a target="_blank" href="<?=$PdfResArray['DownloadUrl']?>" ><?=$download?></a>
<a <?=$PdfResArray['MakePdfLink']?>  class="fancybox fancybox.iframe" href="<?= $SendUrl . '&view=' . $values['OrderID'] ?>" ><?= $sendemail ?></a>
 
<? echo '<ul class="print_menu" style="width:60px;"><li class="print" ><a target="_blank" class="edit" href="'.$PdfResArray['PrintUrl'].'">&nbsp;</a></li></ul>'; ?>

</td>


<? if($ModifyLabel==1){ ?> 
 <td align="center">
<?php if($values['PostToGL'] != "1" && $values['Status'] == 'Open' && $values['Approved'] == 1){ 	
	$CountCheck++; ?>
    <input type="checkbox" name="posttogl[]" id="posttogl<?=$CountCheck?>" onchange="return ChangePostToGlDate();" class="posttogl" value="<?php echo $values['OrderID']; ?>">
<?php

} ?>
 </td>
<? } ?>
 


	
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="12" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="12"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryPurchase)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
		  <input type="hidden" name="CountCheck" id="CountCheck" value="<?php echo $CountCheck; ?>">

</td>
	</tr>
</form>
</table>

<? } ?>
