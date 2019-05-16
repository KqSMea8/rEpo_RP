<?php

require_once("../includes/settings.php");
require_once($Prefix."classes/item.class.php");

$objItem=new items();

$arryProduct = $objItem->GetItemById($_GET['id']);

$ProdSku=$arryProduct[0]['Sku'];

$output_dir = "savefiles/";
if(isset($_FILES["myfile"]))
{

	/*for($i=1;$i<=$_POST['MaxProductImage'];$i++){               
						 if($_FILES['Image'.$i]['name'] != ''){
						
							$ImageExtension = GetExtension($_FILES['Image'.$i]['name']);
							$imageName = $ProdSku."_".$i.".".$ImageExtension;	
							$ImageDestination = $Prefix."upload/items/images/secondary/".$imageName;
							$alt_text = $_POST['alt_text'.$i];
							if(@move_uploaded_file($_FILES['Image'.$i]['tmp_name'], $ImageDestination)){
								$objItem->UpdateAlternativeImage($ImageId,$imageName,$alt_text);
							}
							
						}
						
					}*/
	$ret = array();

	$error =$_FILES["myfile"]["error"];
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{

$ImageExtension = GetExtension($_FILES['myfile']['name']);
		$fileName = $ProdSku.".".$ImageExtension;	
 	 	//$fileName = $_FILES["myfile"]["name"];
 		move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
    	$ret[]= $fileName;
	}
	else  //Multiple files, file[]
	{
	  $fileCount = count($_FILES["myfile"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {

		                   
	  	$fileName = $_FILES["myfile"]["name"][$i];
		move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
	  	$ret[]= $fileName;
	  }
	
	}
    echo json_encode($ret);
 }
 ?>


