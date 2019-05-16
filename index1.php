<?php   


include("config.php");
require_once("includes/function.php");

$DbName = 'erp';
ImportDatabase($Config['DbHost'],$DbName,$Config['DbUser'],$Config['DbPassword'],'sql/admin.sql');

echo 'Success.';
exit;

if(!empty($_GET["c"])){
	$arrCmp = explode("/",$_GET["c"]);
	if($arrCmp[1]=="admin"){
		$AdminUrl = $Config['Url']."admin/?c=".$arrCmp[0];
		header("location:".$AdminUrl);
		exit;
	}
}


print_r($_GET); 



?>
