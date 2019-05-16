<?php
	require_once("includes/header.php");

	if(empty($_SESSION['LicenseKey'])){		
		header('location: index.php');
		exit;
	}

	/************************/
	 if(!empty($_POST['DbHost']) && !empty($_POST['DbUser']) && !empty($_POST['DbPassword']) && !empty($_POST['DbName'])) {
		$dbLink = mysql_connect($_POST['DbHost'], $_POST['DbUser'], $_POST['DbPassword']);
		if(!$dbLink){
		 	$_SESSION['mess_db'] = "Could not connect to host. <br>" . mysql_error();

		}else{ //connected to host
			$DbName = $Config['DbMain']."_".$_POST['DbName'];
			if(mysql_select_db($Config['DbMain'],$dbLink)){
				$ErrorDb[0] = $Config['DbMain'];
			}
			if(mysql_select_db($DbName,$dbLink)){
				$ErrorDb[1] = $DbName;
			}
			
			if(sizeof($ErrorDb)>0){
				$DbExist = implode($ErrorDb,", ");
				$_SESSION['mess_db'] = str_replace('[DB_EXIST]', $DbExist, ERROR_MAIN_DB_EXIST);
			}

			if(empty($_SESSION['mess_db'])){				
				
				/*********Main DB**************/
				$sql_dbmain = 'CREATE Database IF NOT EXISTS '.$Config['DbMain'];
				mysql_query($sql_dbmain) or die (mysql_error());
				ImportDatabase($_POST['DbHost'],$Config['DbMain'],$_POST['DbUser'],$_POST['DbPassword'],'sql/erp.sql');
				ImportDatabase($_POST['DbHost'],$Config['DbMain'],$_POST['DbUser'],$_POST['DbPassword'],'sql/erp_data.sql');
				
				/*********Company DB**************/
				$sql_db = 'CREATE Database IF NOT EXISTS '.$DbName;
				mysql_query($sql_db) or die (mysql_error());
				ImportDatabase($_POST['DbHost'],$DbName,$_POST['DbUser'],$_POST['DbPassword'],'sql/erp_company.sql');
				

				$_SESSION['DisplayDbName'] = $_POST['DbName'];
				$_SESSION['DbHost'] = $_POST['DbHost'];				
				$_SESSION['DbUser'] = $_POST['DbUser'];
				$_SESSION['DbPassword'] = $_POST['DbPassword'];				

				header('location: cmpSetup.php');
				exit;
				
			}

			
		}
	
	}
	/************************/
	
	unset($_SESSION['DisplayDbName']);
	unset($_SESSION['DbHost']);
	unset($_SESSION['DbUser']);
	unset($_SESSION['DbPassword']);
	unset($_SESSION['mess_installed']);

	require_once("includes/footer.php"); 
  ?>
