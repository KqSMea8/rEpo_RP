
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Demo - Import Excel file data in mysql database using PHP, Upload Excel file data in database</title>
<meta name="description" content="This tutorial will learn how to import excel sheet data in mysql database using php. Here, first upload an excel sheet into your server and then click to import it into database. All column of excel sheet will store into your corrosponding database table."/>
<meta name="keywords" content="import excel file data in mysql, upload ecxel file in mysql, upload data, code to import excel data in mysql database, php, Mysql, Ajax, Jquery, Javascript, download, upload, upload excel file,mysql"/>
</head>
<body>

<form method="post" enctype="multipart/form-data">
<input type="file" name="inputfile"/>
<input type="submit" name="submit"/>
</form>

<?php
if(isset($_POST['submit']))
{	
	if ($_FILES["inputfile"]["error"] > 0)
	{
		echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	}
	else 
	{
		if (file_exists($_FILES["inputfile"]["name"]))
		{
			//unlink($_FILES["inputfile"]["name"]);
		}
		$storagename = "upload/mailchaimpexcel.xlsx";
		//copy($_FILES["inputfile"]["tmp_name"],  $storagename);
		move_uploaded_file($_FILES["inputfile"]["tmp_name"],  $storagename);
		$uploadedStatus = 1;
		$inputFileName = $storagename;
		set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
		include 'PHPExcel/IOFactory.php';
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
		echo "<pre>"; print_r($allDataInSheet); print_r($arrayCount);		
	}
}
?>
<body>
</html>
