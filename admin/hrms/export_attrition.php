<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/employee.class.php");
include_once("includes/FieldArray.php");
$objEmployee=new employee();

/*************************/
/*************************/

if(!empty($_GET['f']) && !empty($_GET['t'])){

	if(!empty($_GET['f']) && !empty($_GET['t'])){ 
		$From = $_GET['f']; $To = $_GET['t'];
		$filename = "AttritionReport_".$_GET['f']."_to_".$_GET['t'].".xls";
	}


	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	$header = "Year\tAttrition Ratio";

	$data = '';
	for($y=$From;$y<=$To;$y++){

		$PrevY = $y-1;
		/*$arryOpeningBalance = $objEmployee->GetEmpByYear('',$PrevY);
		$OpeningBalance = $arryOpeningBalance[0]['TotalEmployee'];*/

		$arryTotalEmployee = $objEmployee->GetEmpByYear('',$y);
		$TotalEmployee = $arryTotalEmployee[0]['TotalEmployee'];

		$arryResignation = $objEmployee->GetResignation('',$y);
		$TotalResignation = $arryResignation[0]['TotalEmployee'];
		
		if($TotalResignation>=0 && $TotalEmployee>0){
			$Attrition = ($TotalResignation / $TotalEmployee) * 100;
		}
		$Attrition = round($Attrition,2);

		$line = $y."\t".$Attrition." %";

		$data .= trim($line)."\n";
	}




	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

