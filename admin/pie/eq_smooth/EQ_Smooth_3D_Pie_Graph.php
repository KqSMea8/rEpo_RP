<?php
ob_start();

	include("class_eq_pie.php");

	$eq_pie = new eq_pie;

	?>
	<html>


	<head>

<title>EQ Pie Graphic - Example</title>
</head>

<body>

<?php


	$data[0][0]= "Netherlands";
	$data[0][1]= 80;
	$data[0][2]= "#00ccff";

	$data[1][0]= "Malaysia";
	$data[1][1]= 65;
	$data[1][2]= "#ff00cc";

	$data[2][0]= "Singapore";
	$data[2][1]= 28;
	$data[2][2]= "#ff9900";

	$data[3][0]= "Belgium";
	$data[3][1]= 15;
	$data[3][2]= "#ccff66";

	$eq_pie->MakePie('pie11.png', '200','150','10','#99ccff' ,$data, '1');
	echo "<img src='pie11.png' border=\"0\">";

	echo "<BR><BR><BR><BR>";


	$data[0][0]= "Apples";
	$data[0][1]= 25;
	$data[0][2]= $eq_pie->GetColor(0);

	$data[1][0]= "Grapes";
	$data[1][1]= 15;
	$data[1][2]= $eq_pie->GetColor(1);

	$data[2][0]= "Pears";
	$data[2][1]= 30;
	$data[2][2]= $eq_pie->GetColor(2);

	$data[3][0]= "Durian";
	$data[3][1]= 5;
	$data[3][2]= $eq_pie->GetColor(3);

	$eq_pie->MakePie('pie22.png', '400','300','40','#99ccff' ,$data, '1');
	echo "<img src='pie22.png' border=\"0\">";




?>
</body>
</html>
