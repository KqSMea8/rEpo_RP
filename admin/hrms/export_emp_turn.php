<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/employee.class.php");
include_once("includes/FieldArray.php");
$objEmployee=new employee();

/*************************/
/*************************/

if( !empty($_GET['y']) || (!empty($_GET['f']) && !empty($_GET['t']))){ 

	if(!empty($_GET['y'])){
		$From = $_GET['y']; $To = $_GET['y'];
		$filename = "EmployeeTurnOver_".$_GET['y'].".xls";
	}else if(!empty($_GET['f']) && !empty($_GET['t'])){ 
		$From = $_GET['f']; $To = $_GET['t'];
		$filename = "EmployeeTurnOver_".$_GET['f']."_to_".$_GET['t'].".xls";
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

	$header = "Department";
	for($y=$From;$y<=$To;$y++){
		$header .= "\t".$y;
	}

	$data = '';
	for($i=0;$i<sizeof($arrySubDepartment);$i++) { 

		$line = stripslashes($arrySubDepartment[$i]['Department']);
		for($y=$From;$y<=$To;$y++){
			if(empty($TotalEmp[$y])) $TotalEmp[$y] ='0';

			$arryNumEmployee = $objEmployee->GetEmpByYear($arrySubDepartment[$i]['depID'],$y);
			$TotalEmp[$y] += $arryNumEmployee[0]['TotalEmployee'];
			$line .= "\t".$arryNumEmployee[0]['TotalEmployee'];
		}

		$data .= trim($line)."\n";
	}

	$line = "Total : ";
	for($y=$From;$y<=$To;$y++){
		$line .= "\t".$TotalEmp[$y];
	}

	$data .= "\n".trim($line)."\n";





	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

