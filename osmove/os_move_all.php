<?php
$Prefix = '../';
require_once($Prefix."includes/config.php"); 
require_once($Prefix."includes/function.php");
require_once($Prefix."admin/includes/common.php");
require_once($Prefix."classes/function.class.php");
$objFunction=new functions();


/************/
$RootDir = '../../upload/';  
$Folder = $Config['CmpDir'];

$Base = md5($_GET['pk']);  
/************/
if(!empty($Base) && $Base=='2e5bda28ac98653b0c5ec52b9906845a'){ 
	//93e42d4acf46

 	$link=mysql_connect ($Config['DbHost'],mydecrypt($Config['DbUser']),mydecrypt($Config['DbPassword']),TRUE);
	if(!$link){die("Could not connect to MySQL");}
	mysql_select_db($Config['DbName'],$link) or die ("could not open db".mysql_error());
	
	if(!empty($_GET['cmp']))$addSql = " and CmpID='".$_GET['cmp']."'";
	$sql = "select CmpID,DisplayName,Image from company where 1 ".$addSql." order by CmpID asc ";

	$q=mysql_query($sql,$link) or die (mysql_error()); 
	$Count=0;
	 


	//echo $sql;die;
	while($row = mysql_fetch_array($q)) {		
		if($row['CmpID']>0){  
			$Config['CmpID'] = $row['CmpID'];

			$FromDir = $RootDir.$row['CmpID'].'/'.$Folder;
			if($row['Image'] !='' && file_exists($FromDir.$row['Image']) ){ 
				
				$ResponseArray = $objFunction->MoveObjStorage($FromDir , $Folder, $row['Image']);
				if($ResponseArray['Success']=="1"){				 
					echo '<br>Copied for : '.$row['DisplayName']." : ".$row['CmpID'].'<br>';	


					/***Update FileExist in DB*************/
					 
					$sqlF = "update company set FileExist='1' where CmpID='".$Config['CmpID']."'";
					
					mysql_query($sqlF);
					
					/*********************************/
	
				}else{
					echo $ErrorMsg = $ResponseArray['ErrorMsg'];
				}

				
				 
				$Count++;
			}
			
			/***************/ 
		}

		#if($Count==5) die;
	}	
	

	
 


}

exit;
 
?>
 
