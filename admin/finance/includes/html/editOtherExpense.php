<a href="<?=$ListUrl?>" class="back">Back</a>
<div class="had"><?=$MainModuleName?>&nbsp;<span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span></div>
<!--<p>Other Expenses are cash purchases and other money you have paid. It can be used if you don't want to record the full invoice details, and just want to record the expense when it is paid, e.g. petrol. </p>-->
<div class="message" align="center">
 <?php //if(!empty($_SESSION['mess_add_expense'])) {echo $_SESSION['mess_add_expense']; unset($_SESSION['mess_add_expense']); }?></div>
	<? if (!empty($errMsg)) {?>
	<div align="center"  class="red" ><?php echo $errMsg;?></div>
	<?php }
    else{  
                
        //if ($currentDate >= $INVOICE_ENTRYFROM && $currentDate <= $INVOICE_ENTRYTO) { 
        
         if ($FiscalYearStartDate == "" && $FiscalYearEndDate == "") {
          
          echo '<div class="red" style="font-size: 15px;text-align: center">'.SETUP_FISCAL_YEAR.'</div>';
           
                
         }else{
           include("includes/html/box/other_expense_form.php");
            }        
		
	}	
 ?>
