<?php

	require_once("../includes/settings.php");
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase = new purchase();
	
	$OrderTotal = 0;


	if(!empty($_GET["f"]) && !empty($_GET["t"])){

		$FromYear = date("Y",strtotime($_GET['f']));
		$ToYear = date("Y",strtotime($_GET['t']));
	
		$module = $_GET['module'];
		$ModuleName = "Purchase ".$_GET['module'];

		for($i=$FromYear;$i<=$ToYear;$i++) {
			$arryNumOrder = $objPurchase->GetNumPOByYear($i,$_GET['f'],$_GET['t'],$_GET['s'],$_GET['st']);
			#$rand = rand(10,100);
			$arryYear[] = $i;
			$arryVal[] = $arryNumOrder[0]['TotalOrder'];
			$OrderTotal +=  $arryNumOrder[0]['TotalOrder']; 
		}

	}else{
		exit;
	}
		//echo '<pre>';		print_r($arryVal);

/*****************************/
set_time_limit(100);

define('GRAPH_WIDTH',  750);
define('GRAPH_HEIGHT', 500);

include_once ('../includes/classes/Plot.php');
include_once ('../includes/classes/CubicSplines.php');

$yname='Number of '.$ModuleName;//y-axis name

$iPoints = sizeof($arryYear);
$dx = (GRAPH_WIDTH - 40) / ($iPoints - 1);
$x = GRAPH_WIDTH / $iPoints ;

for ($i = 0; $i < $iPoints; $i++) {
	//$rand = rand(0,100);
    $aCoords[$x] = $arryVal[$i]*5;
	$ArryYear[$x] = $arryYear[$i];
    $x+= $dx;
	$yr--;
}

//echo '<pre>'; print_r($aCoords);print_r($ArryYear); exit;


$vImagegHeight = GRAPH_HEIGHT + 60;
$vImage = imagecreatetruecolor(GRAPH_WIDTH + 50, $vImagegHeight);


$vBgColor = imagecolorallocate($vImage, 255, 255, 255);
$vTextColor = imagecolorallocate($vImage, 227,113,39);
$vAxisColor = imagecolorallocate($vImage, 135,135,135);
$vDotColor  = imagecolorallocate($vImage,123,172,172);

imagefill($vImage, 0, 0, $vBgColor);


$oPlot = new Plot($aCoords);
$oPlot->drawDots($vImage, $vDotColor, 10, GRAPH_HEIGHT, 8);

$oCurve = new CubicSplines();
$vColor = imagecolorallocate($vImage, 135,135,135);

$iStart = microtime(1);
if ($oCurve) {
    $oCurve->setInitCoords($aCoords, 1);
    $r = $oCurve->processCoords();
    if ($r)
        $curveGraph = new Plot($r);
    else
        continue;
} else {
    $curveGraph = $oPlot;
}

$curveGraph->drawLine($vImage, $vColor, 10, GRAPH_HEIGHT);

// unset($oCurve);
$sTime = sprintf("%1.4f", microtime(1) - $iStart);

$count=0;
for($i=GRAPH_HEIGHT;$i>0;$i=$i-50){
	$count++;
	$rem = ($count*10);
	//$xPos = $i - ($rem);
	//echo $i.' '.$rem.'<br>'; 
	imagestring($vImage,0,20,$i-50,$rem,$vTextColor);

}
//exit;
foreach($ArryYear as $key=>$values){
	imagestringup($vImage,4,$key,540,$values,$vTextColor);
}

imagestringup($vImage,5,0,380, $yname, $vTextColor);

//imagefilledrectangle($vImage, 0, GRAPH_HEIGHT, GRAPH_WIDTH + 50, $vImagegHeight, $vBgColor);
$oPlot->drawAxis($vImage, $vAxisColor, 40, GRAPH_HEIGHT);
$iPanelY = GRAPH_HEIGHT;

//imagefilledrectangle($vImage, 10, $iPanelY + 10, 20, $iPanelY + 20, $vColor);
//imagerectangle($vImage, 10, $iPanelY + 10, 20, $iPanelY + 20, $vAxisColor);
//imagettftext($vImage, 10, 0, 30, $iPanelY + 20, $vTextColor, 'Ds-digib.ttf', 'Cubic splines in PHP for graphs:         ' . $sTime . ' sec');

header("Content-type: image/png");
imagepng($vImage);
imagedestroy($vImage);

?>