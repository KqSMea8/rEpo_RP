<?php
 require_once("header.php");
 
if(!empty($Base) && $Base=='2e5bda28ac98653b0c5ec52b9906845a'){ 
	//93e42d4acf46

 	$link=mysql_connect ($Config['DbHost'],mydecrypt($Config['DbUser']),mydecrypt($Config['DbPassword']),TRUE);
	if(!$link){die("Could not connect to MySQL");}
	mysql_select_db($Config['DbName'],$link) or die ("could not open db".mysql_error());
	
 
	$sql = "select ".$ColAuto." as AutoID,  ".$ColFile." as FileName from ".$Table." where ".$ColFile."!='' order by ".$ColAuto." asc ";

	$q=mysql_query($sql,$link) or die (mysql_error()); 
	$Count=0;
	 
	//echo $sql;die;
	$ErrorMsg='';
	$MovedArray=array();
	while($row = mysql_fetch_array($q)) {	
	

			  $FromDir = $UploadDir.$Config['CmpID'].'/'.$Folder; 
			if($row['FileName'] !='' && file_exists($FromDir.$row['FileName']) ){ 
				 
				$ResponseArray = $objFunction->MoveObjStorage($FromDir , $Folder, $row['FileName']);
				if($ResponseArray['Success']=="1"){				 
					 if(!empty($ResponseArray['Success'])){
							$MovedArray[] =  $row['FileName'];	
						}
	
				}else{
					echo $ErrorMsg = $ResponseArray['ErrorMsg'];
				}

				 
			}
			
			/***************/ 
	
 
	}	
	

	
 	pr($MovedArray,0);
	require_once("footer.php"); 
 	pr($ErrorMsg,1);


}

exit;
 
?>
 
