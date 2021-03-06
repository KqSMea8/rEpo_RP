<?  ob_start();
	session_start();
$Prefix='../../';
require_once($Prefix."includes/config.php");
require_once($Prefix."classes/dbClass.php");
require_once($Prefix."classes/configure.class.php");
require_once($Prefix."classes/employee.class.php");
$objEmployee=new employee();
$objConfigure=new configure();
$arryDepartment = $objConfigure->GetDepartment();

$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfigure->dbName = $Config['DbName'];
$objConfigure->connect();

$arryTotalEmployee = $objEmployee->GetNumEmployee('');
$TotalNumEmployee = $arryTotalEmployee[0]['TotalEmployee'];


$graphtitle='Employees By Department';//Graph Title
$xname='Department'; //X-axis Name
$yname='Number of Employee';//y-axis name
$img_width=400;//image height
$img_height=300;//image width 
$margins=70;
$ymargin=4;
$graph_width=$img_width - $margins * 2;
$graph_height=$img_height - $margins * 2; 
$bar_width=25;
$total_bars = sizeof($arryDepartment);

$gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1);
$img=imagecreate($img_width,$img_height);



$bag_color=imagecolorallocate($img,246,246,246);//Baground color
$xyline_color=imagecolorallocate($img,135,135,135);//XY-axis color
$bar_color=imagecolorallocate($img,172,212,123);//Bar color
$values_color=imagecolorallocate($img,2,2,2);//values color
$txt_color=imagecolorallocate($img,227,113,39);//text color
$line_color=imagecolorallocate($img,220,220,220); 


$LineMargin = 70;

imagefilledrectangle($img,0,0,0,0,$bag_color);
imageline($img,$margins,$img_height-$LineMargin,$img_width-20,$img_height-$LineMargin,$xyline_color);
imageline($img,$margins,$ymargin,$margins,$img_height-$LineMargin,$xyline_color);

$max_value=($TotalNumEmployee>50)?($TotalNumEmployee):(50); 
$ratio=$graph_height/$max_value;

$horizontal_lines=10;
$horizontal_gap=($img_height+20)/$horizontal_lines;
for($j=1;$j<=$horizontal_lines;$j++)
{
        $y=($img_height-($LineMargin+10)) - $horizontal_gap * $j ;
        imageline($img,$margins+1,$y,$img_width-20,$y,$line_color);
        $v=intval($horizontal_gap * $j /$ratio);
        imagestring($img,2,$margins-30,$y-2,$v,$values_color);
}
$i=0;
/*
while($inf = mysql_fetch_array($result)) 
  {
      $x1=($margins+10) + ($gap+5) + $i * ($gap+$bar_width) ;
      $x2=$x1+$bar_width;
      $y1=($img_height-46)- ceil($inf[1] * $ratio) ; 
      $y2=($img_height-46); 
      imagestring($img,2,$x1+1,$y1-15,$inf[1],$values_color); 
      imagestring($img,2,$x2-23,$img_height-43,$inf[0],$values_color);  
      imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color); // Draw bar
   $i++;   
  }
  */
  $LineMargin = $LineMargin+1;
for($k=0;$k<sizeof($arryDepartment);$k++) {
	$arryNumEmployee = $objEmployee->GetNumEmployee($arryDepartment[$k]['depID']);
	$Department = $arryDepartment[$k]['Department'];
	$TotalEmployee = $arryNumEmployee[0]['TotalEmployee'];

      $x1=($margins+10) + ($gap+5) + $i * ($gap+$bar_width) ;
      $x2=$x1+$bar_width;
      $y1=($img_height-$LineMargin)- ceil($TotalEmployee * $ratio) ; 
      $y2=($img_height-$LineMargin); 
      imagestring($img,2,$x1+1,$y1-15,$TotalEmployee,$values_color); 
      imagestringup($img,2,$x2-23,$img_height-7,$Department,$values_color);  
      imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color); // Draw bar
   $i++;   
}

//imagestring($img,8, 120, 0, $graphtitle, $txt_color);
imagestring($img,5, ($img_width-$margin)/2, $img_height-($ymargin+10), $xname, $txt_color);
imagestringup($img,5,10,200, $yname, $txt_color);
//header('Content-type: image/png');
imagepng($img, 'barchart.jpg');
echo "<div style='border:0px solid #d8d8d8;width:$img_width'><img src='barchart.jpg'></div>";
?>
