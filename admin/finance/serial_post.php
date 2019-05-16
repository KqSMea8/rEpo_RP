<?php	

session_start();
$Prefix = "../../";
require_once($Prefix . "includes/config.php");
require_once($Prefix . "includes/function.php");
require_once($Prefix . "classes/dbClass.php");
require_once($Prefix . "classes/region.class.php");
require_once($Prefix . "classes/admin.class.php");
require_once($Prefix . "classes/leave.class.php");
require_once($Prefix . "classes/time.class.php");
require_once($Prefix . "classes/bom.class.php");
require_once($Prefix . "classes/warehouse.class.php");
require_once($Prefix."classes/rma.sales.class.php"); 
$objrmasale = new rmasale();                        
$objConfig = new admin();
if(empty($_SERVER['HTTP_REFERER'])){
		#echo 'Protected.';exit;
	}

/* * ******Connecting to main database******** */
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/* * **************************************** */


	//For Importing Vendor Excel 21Sep. 2016//
	if($_POST['SerialNumber']!=' ' && $_POST['action']=='Add'){
$objWarehouse = new warehouse();



$SelSerialNo = explode(',',$_POST['SerialNumber']);
$reslt= $objWarehouse->GetSerialnoArray($SelSerialNo,$_POST['Sku'],$_POST['Condition']);	
if($_POST['TotQty']>1){
 $reslt=$reslt[0]['sum']/$_POST['TotQty'];
}else{

 $reslt=$reslt[0]['sum'];
}
$rest[0]['UnitCost'] = $reslt;
$objWarehouse->UpdateSalesSerialno($SelSerialNo,$_POST['Sku'],$_POST['Condition'],1,$_POST['LineID']);
$rest[0]['SerialNumber'] =$_POST['SerialNumber'];

		/*if($allserials!=''){
			$SelSerialNo = explode(',',$_POST['SerialNumber']); 
			//print_R($SelSerialNo);die;
			$reslt= $objWarehouse->GetSerialnoArray($SelSerialNo,$_POST['Sku'],$_POST['Condition']);									
			$reslt=$reslt[0]['sum'];						
	$rest[0]['UnitCost'] = $reslt;        
	}*/
	echo $rest[0]['UnitCost'];
        //echo json_encode($rest[0]);
         exit;
	}

if($_POST['SerialNumber']!=' ' && $_POST['action']=='Clear'){
$objWarehouse = new warehouse();



$SelSerialNo = explode(',',$_POST['SerialNumber']);
$reslt= $objWarehouse->GetSerialnoArray($SelSerialNo,$_POST['Sku'],$_POST['Condition']);	
 $reslt=$reslt[0]['sum']/$_POST['TotQty'];
$rest[0]['UnitCost'] = $reslt;
$objWarehouse->DeleteSalesSerialno($SelSerialNo,$_POST['Sku'],$_POST['Condition'],0,$_POST['LineID']);
$rest[0]['SerialNumber'] =$_POST['SerialNumber'];

		/*if($allserials!=''){
			$SelSerialNo = explode(',',$_POST['SerialNumber']); 
			//print_R($SelSerialNo);die;
			$reslt= $objWarehouse->GetSerialnoArray($SelSerialNo,$_POST['Sku'],$_POST['Condition']);									
			$reslt=$reslt[0]['sum'];						
	$rest[0]['UnitCost'] = $reslt;        
	}*/
	echo $rest[0]['UnitCost'];
       // echo json_encode($rest[0]);
         exit;
	}

?>
