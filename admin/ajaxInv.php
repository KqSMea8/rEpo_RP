<?	session_start();
	$Prefix = "../../"; 
    	require_once("../includes/config.php");
	require_once("../classes/dbClass.php");
    	require_once("../includes/function.php");

	require_once("../classes/admin.class.php");	
	require_once("../classes/item.class.php");

		$objConfig=new admin();
		$objItem=new items();
	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}

	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
		
	
	
if(!empty($_POST['WID']) && $_POST['WID']!=''){
		
		CleanPost();

		$arrayBin = $objItem->BinLocationByWarehouse($_POST['WID']);
		

 if(count($arrayBin) > 0){
        echo '<option value="">Select Bin</option>';
        foreach($arrayBin as $key=>$values){
            echo '<option value="'.$values['binid'].'">'.$values['binlocation_name'].'</option>';
        }
    }else{
        echo '<option value="">Bin not available</option>';
    }



		//echo $AjaxHtml = rtrim(stripslashes($AjaxHtml),'"'); exit;

		}

?>
