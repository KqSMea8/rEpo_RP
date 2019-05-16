<? 
$arryDefaultCompany = $objCompany->GetDefaultCompany();
if($arryDefaultCompany[0]['CmpID']>0){
	/********Connecting to main database*********/
	$CmpDatabase = $Config['DbMain']."_".$arryDefaultCompany[0]['DisplayName'];
	$Config['DbName2'] = $CmpDatabase;
	if(!$objConfig->connect_check()){
		$ErrorMsg = ERROR_NO_DB;
	}else{
		$Config['DbName'] = $CmpDatabase;
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
	}
}else{
	$ErrorMsg = ERROR_NO_DEFAULT_CMP;
}
?>
