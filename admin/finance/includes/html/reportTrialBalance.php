<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){	
		ShowHideLoader('1','L');
	}


    function SetDate(str){
        if(str == "Specific Date") {
            	$(".specificdaterange").show();
	     	$(".monthlyyearly").hide();
        }else if(str == "Monthly") {
		$(".specificdaterange").hide()
		$(".monthlyyearly").show();
	}else{
            	$(".specificdaterange").hide();
	    	$(".monthlyyearly").hide();
        }
    }
   
   

</script>

<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>

<?php if($num777 > 0){?>
<a href="<?=$EmailUrl?>" target="_blank" class="fancybox fancybox.iframe email_button" style="float:right;margin-left:5px;">Email</a>

<a href="<?=$DownloadUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>

<input type="button" onclick="Javascript:window.location = '<?=$ExportUrl?>';" value="Export To Excel" name="exp" class="export_button">
<?php }?>
<div class="had"><?=$MainModuleName?> Report</div>

<div class="message" align="center">
 
<? if(!empty($_SESSION['mess_report_email'])) {echo $_SESSION['mess_report_email']; unset($_SESSION['mess_report_email']); }?>
</div>


<table width="100%" border=0 align="center" cellpadding=0 cellspacing=0>
    <?php if($num > 0){?>
	<tr>
        <td align="left" valign="top">
         <form onsubmit="return ValidateSearch();" name="form3" method="get" action="">
	<table cellspacing="0" cellpadding="0" border="0" style="margin:0" id="search_table">
	<tbody>
            <tr>
            <!--td align="left">Transaction Date:</td>
             <td align="left">
 <select onchange="Javascript: SetDate(this.value);" id="TransactionDate" class="textbox" name="TransactionDate">
	<option value="All" <?php if ($_GET['TransactionDate'] == "All") {
	echo "selected";
	} ?>>All</option>
	<option value="Today" <?php if ($_GET['TransactionDate'] == "Today") {
	echo "selected";
	} ?>>Today</option>
	<option value="Last Week" <?php if ($_GET['TransactionDate'] == "Last Week") {
	echo "selected";
	} ?>>Last Week</option>
	<option value="Last Month" <?php if ($_GET['TransactionDate'] == "Last Month") {
	echo "selected";
	} ?>>Last Month</option>
	<option value="Last Three Month" <?php if ($_GET['TransactionDate'] == "Last Three Month") {
	echo "selected";
	} ?>>Last Three Month</option>
	<option value="Specific Date" <?php if ($_GET['TransactionDate'] == "Specific Date") {
	echo "selected";
	} ?>>Specific Date</option>
	<option value="Monthly" <?php if ($_GET['TransactionDate'] == "Monthly") {
	echo "selected";
	} ?>>Monthly</option>
</select>
             </td-->
             
             <td>
                 
                 <!--table cellspacing="0" cellpadding="0" border="0" class="specificdaterange">
                     <tr>
                         <td align="left">From:</td>
             <td align="left">
                     <?php
                     if(!empty($_GET['FromDate']) && $SpecificDate==1){
                      $FromDate = $_GET['FromDate'];
                     }
                     ?>
		<script type="text/javascript">
					$(function() {
						$('#FromDate').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#FromDate").on("click", function () { 
								 $(this).val("");
							}
						);
					});
					</script>
					<input id="FromDate" name="FromDate" readonly="" value="<?=$FromDate?>" class="inputbox" style="width: 120px;" type="text" maxlength="10" > 
		</td>
		
		 
		 <td align="left">To:</td>
                  <?php
                     if(!empty($_GET['ToDate']) && $SpecificDate==1){
                      $ToDate = $_GET['ToDate'];
                     }
                     
                     ?>
		 <td> <script type="text/javascript">
					$(function() {
						$('#ToDate').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#ToDate").on("click", function () { 
								 $(this).val("");
							}
						);

					});
					</script>
					<input id="ToDate" name="ToDate" readonly="" value="<?=$ToDate?>" class="inputbox" style="width: 120px;" type="text" maxlength="10" > 
                 </td>
                         
                     </tr>
                     
                 </table-->

	<table cellspacing="0" cellpadding="0" border="0" class="monthlyyearly">
                <tr>
                    <td align="left"><?=getMonths($_GET['m'],"m","textbox")?></td>
                    <td align="left"><?=getYears($_GET['y'],"y","textbox")?></td>
               </tr>
        </table>


	<script language="JavaScript1.2" type="text/javascript">
	//SetDate('<?=$_GET["TransactionDate"]?>');
	</script>




                 
             </td>
        
             
                 <td>
		 <input type="submit" value="Go" class="search_button" name="s">
		 
		
		 </td>
	 
		
	</tr>
			

</tbody>
        </table>
                 </form>
	
		</td>
      </tr>
      <?php }?>
	 <tr>
             <td  valign="top">&nbsp;</td>
         </tr>
	<tr>
	  <td  valign="top">
	


<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
    <table cellspacing="1" cellpadding="3" width="600" align="center">
     <?php if($num > 0){?>    
      <tr align="left">
        <td width="10%"  align="center">
           
            <span class="font18"><?=strtoupper($Config['SiteName']);?></span><br>
            <span class="font16">Trial Balance</span><br>
            <!--span class="font16">Balance as on <?=date($Config['DateFormat'], strtotime(date('Y-m-d')));?></span><br-->
            <span class="font16">
                <?php if($_GET['TransactionDate'] == "All"){?>
                 For All Dates
            <?php } else if($_GET['TransactionDate'] == "Today"){?>
                  
                 For <?=date($Config['DateFormat'], strtotime($FromDate));?>
		 <?php } else if($_GET['TransactionDate'] == "Monthly"){?>
                  
                 For <?=date("F, Y", strtotime($FromDate));?>
            <?php } else {?>  
                 For the period From
            <?=date($Config['DateFormat'], strtotime($FromDate));?> To <?=date($Config['DateFormat'], strtotime($ToDate));?>
            <?php }?>
           
           </span>
            
        </td>
		
		
    </tr>
    
    <tr><td class="border_bottom">&nbsp;</td></tr>  
     <?php } else { ?>
    <tr><td class="red">This report contains no data.</td></tr>  
     <?php }?>
    </table>
<table cellspacing="1" cellpadding="3" width="600" align="center">
  <?php if($num > 0){?>   
 <tr>
        <td colspan="3" height="30" align="right"><b>All amounts stated in <?=$Config['Currency']?></b></td>
 </tr>
 <tr>
        <td align="right" width="300"> &nbsp;</td>
        <td align="right" style="padding-top: 10px;"><b>Debit</b></td>
        <td align="right" style="padding-top: 10px;"><b>Credit</b></td>
 </tr>
        <?php } 
        
        
        $PreviousDbtCrd=$objBankAccount->PreviousDebtCrdAmount($FromDate);
        


  

  if(is_array($arryAccountType) && $num>0){
      
      $netDebitAmt="";
      $netCreditAmt="";
      
  	foreach($arryAccountType as $key=>$values){
            
            
         $AccountTypeID = $values['AccountTypeID']; 
         $Rangefromm=$values['RangeFrom'];
         //$ArryDbtCrdAmount=$objBankAccount->TotalDebitCreditByAccountType($AccountTypeID,$FromDate,$ToDate);
         
         $ArryDbtCrdAmount=$objBankAccount->NetDebitCreditByAccountType($Rangefromm,$FromDate,$ToDate);

	if($values['RangeFrom']!=1000)echo '<tr><td>&nbsp;</td></tr>';
  ?>
   
  <tr align="left"> 
    <td height="20" class="border_top font13"><b><?=stripslashes($values['AccountType'])?></b></td>
    <td align="right" class="border_top font13"><b><?=number_format($ArryDbtCrdAmount["DbAmnt"],2)?></b></td>
    <td align="right" class="border_top font13"><b><?=number_format($ArryDbtCrdAmount["CrAmnt"],2)?></b></td>
    </tr>
  
    <?php
    
      $netDebitAmt+=$ArryDbtCrdAmount["DbAmnt"];
      $netCreditAmt+=$ArryDbtCrdAmount["CrAmnt"];
      $rootBankAccountName=$objBankAccount->getBankAccountWithRoot($Rangefromm);
      
       foreach($rootBankAccountName as $key=>$values){
           
          $account_data=$objBankAccount->getTotalDebitCreditAmount($values['BankAccountID'],'',$FromDate,$ToDate);
     ?>
    
    <tr align="left"> 
        <td height="20" >&nbsp;&nbsp;&nbsp;<?=strtoupper($values['AccountName']);?> </td>
        <?php
        if($account_data[0]['DbAmnt'] > $account_data[0]['CrAmnt'])
        {
            $DbtAmt=(($account_data[0]['DbAmnt']) - ($account_data[0]['CrAmnt']));
            $CrdAmt=0;
        }else if($account_data[0]['CrAmnt'] > $account_data[0]['DbAmnt']) {
            $CrdAmt=(($account_data[0]['CrAmnt']) - ($account_data[0]['DbAmnt']));
            $DbtAmt=0;
        }else if($account_data[0]['CrAmnt'] == $account_data[0]['DbAmnt'])
        {
           $CrdAmt=0; 
           $DbtAmt=0;
        }
        ?>
        <td align="right"  ><?=number_format($DbtAmt,2)?></td>
        <td align="right" ><?=number_format($CrdAmt,2)?></td>
    </tr>
       <?php }
    
       $groupAccountName=$objBankAccount->getGroupByAccountType($AccountTypeID);
       foreach($groupAccountName as $key=>$values){
           $ArryDbtCrdAmount=$objBankAccount->NetDebitCreditByGroup($values['GroupID'],$FromDate,$ToDate);
     ?>
     <tr align="left"> 
        <td height="20" >&nbsp;&nbsp;&nbsp;<b><?=ucwords($values['GroupName']);?></b></td>
        <td    align="right"><? //number_format($ArryDbtCrdAmount["DbAmnt"],2)?></td>
        <td align="right" ><? //number_format($ArryDbtCrdAmount["CrAmnt"],2)?></td>
    </tr>
    
    <?php 
     $AccountNamee1=$objBankAccount->getBankAccountWithGroupID($values['GroupID']);
     
     foreach($AccountNamee1 as $key=>$values4){
         $account_data=$objBankAccount->getTotalDebitCreditAmount($values4['BankAccountID'],'',$FromDate,$ToDate);
     ?>
    
    
    <?php
        if($account_data[0]['DbAmnt'] > $account_data[0]['CrAmnt'])
        {
            $DbtAmt=(($account_data[0]['DbAmnt']) - ($account_data[0]['CrAmnt']));
            $CrdAmt=0;
            
            
        }else if($account_data[0]['CrAmnt'] > $account_data[0]['DbAmnt']) {
            $CrdAmt=(($account_data[0]['CrAmnt']) - ($account_data[0]['DbAmnt']));
            $DbtAmt=0;
            
        }else if($account_data[0]['CrAmnt'] == $account_data[0]['DbAmnt'])
        {
           $CrdAmt=0; 
           $DbtAmt=0;
        }
        ?>
     <tr align="left"> 
        <td height="20" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=strtoupper($values4['AccountName']);?></td>
        <td width="" align="right"><?=number_format($DbtAmt,2)?></td>
        <td align="right" ><?=number_format($CrdAmt,2)?>    </td>
    </tr>
     <?php }
     $objBankAccount->getSubGroupAccount($values['GroupID'],0,$FromDate,$ToDate);
      
    ?>
      
        <?php }   ?> 
    
  
    
    <?php } // foreach end //?>
    
    <tr><td  colspan="3">&nbsp;</td></tr>
    <tr>
    <td height="20" class="border_top_bottom font15"><b>Grand Total</b></td>
    <td align="right" class="border_top_bottom font15"><b><?=number_format($netDebitAmt,2)?></b></td>
    <td align="right" class="border_top_bottom font15"><b><?=number_format($netCreditAmt,2)?></b></td>
    </tr>
    <?php } ?>
    
  
   
  </table>
  </div> 

</td>
</tr>
</table>





