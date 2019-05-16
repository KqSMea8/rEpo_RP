<?php
$output_dir = "uploads/";
 
if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']))
{
	$fileName =$_POST['name'];

        $fileName=str_replace("[","",$fileName);
        $fileName=str_replace("]","",$fileName);
        $fileName=str_replace('"','',$fileName);
     
	$filePath = $output_dir. $fileName; 
        
	if (file_exists($filePath)) 
	{
         
         unlink($filePath);
        }
        
	echo "Deleted File ".$fileName."<br>";
}

?>
