<?php
	/* * *********************************************** */
	include_once("../includes/FieldArrayFinance.php");
	/* * *********************************************** */
 	include_once("../includes/header.php");
        include("../editCustomFilter.php");
        
        
        if($_GET['type'] =='Receipt'){
            $modType= 'Cash Receipt';
        }elseif($_GET['type'] == 'Customer'){
            $modType= 'Manage Customer'; 
        }elseif($_GET['type'] == 'Note'){
            $modType= 'Credit Note'; 
        }elseif($_GET['type'] == 'Invoice'){
            $modType= 'Invoices'; 
        }elseif($_GET['type'] =='POPayments'){
            $modType= 'Payments';
        }elseif($_GET['type'] == 'Vendor'){
            $modType= 'Manage Vendor'; 
        }elseif($_GET['type'] == 'PoNote'){
            $modType= 'Credit Note'; 
        }elseif($_GET['type'] == 'PoInvoice'){
            $modType= 'Invoices'; 
        }elseif($_GET['type'] == 'Journal'){
            $modType= 'General Journal'; 
        }elseif($_GET['type'] == 'Transfer'){
            $modType= 'Transfer'; 
        }elseif($_GET['type'] == 'Deposit'){
            $modType= 'Bank Deposit'; 
        }
        
        ?>
        
<div class="had"> <?= $modType ?>   <span> &raquo; 
        <? echo (!empty($_GET['edit'])) ? ("Edit Custom view ") : ("New " . $_GET["parent_type"] . " " . $ModuleName); ?></span>
</div>   
<?     
	include("../includes/html/editCustomFilter.php");
   	require_once("../includes/footer.php"); 
 ?>