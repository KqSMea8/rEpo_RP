<?
/*****Variable Define & Default Array for empty edit********/
/****************************/  
(empty($_GET['link']))?($_GET['link']=""):("");
(empty($_GET['rs']))?($_GET['rs']=""):("");
(empty($_GET['tab']))?($_GET['tab']=""):("");
(empty($_GET['mode']))?($_GET['mode']=""):("");
(empty($_GET['d']))?($_GET['d']=""):("");
(empty($HideModule))?($HideModule=""):("");
(empty($MainPrefix))?($MainPrefix=""):("");
(empty($ModuleName))?($ModuleName=""):("");



#echo $MainModuleID;		
 

if($EditPage==1 && empty($_GET['edit'])){
	switch ($MainModuleID) {
	 	 	 
		case '7': 
			$arryLicense = $objConfigure->GetDefaultArrayValue('z_iocube_license_key'); 				break;
		case '73': 
			$arryeditIndustry = $objConfigure->GetDefaultArrayValue('industry_type'); 				break;	
		 	
	}
	 
}

/****************************/
/****************************/

?>
