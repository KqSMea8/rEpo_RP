<?	session_start();
	$Prefix = "../../"; 
    	require_once($Prefix."includes/config.php");
	require_once($Prefix."classes/dbClass.php");
   	require_once($Prefix."includes/function.php");
	
	require_once($Prefix."classes/admin.class.php");	
	
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."classes/webcms.class.php");
	
	$objConfig=new admin();

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
 
	switch($_GET['action']){
		case 'delete_file':
			if($_GET['file_path']!=''){
				$objConfigure=new configure();
				$objConfigure->UpdateStorage($_GET['file_path'],0,1);
				unlink($_GET['file_path']);
				$webcmsObj=new webcms();
				$webcmsObj->UpdateLogo();
				echo "1";
			}else{
				echo "0";
			}
			break;
			exit;
				
	}
	
	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

?>
