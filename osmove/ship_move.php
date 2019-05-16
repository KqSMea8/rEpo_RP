<?php
 require_once("header.php");

 $ShipType = 'dhl'; //fedex, ups dhl


 $ColFile = 'Label'; //label, sendingLabel, LabelChild

 $Table = 'standalone_shipment'; //standalone_shipment Label SendingLabel LabelChild

 $ColFile2 = 'ShippingCarrier';

 


 $Folder = $ShipType.'/';
 $ShippDir = "../admin/shipping/upload/".$Folder;
 
if(!empty($Base) && $Base=='2e5bda28ac98653b0c5ec52b9906845a'){ 
 

	/**************************/
	/**************************/
 	$link=mysql_connect ($Config['DbHost'],mydecrypt($Config['DbUser']),mydecrypt($Config['DbPassword']),TRUE);
	if(!$link){die("Could not connect to MySQL");}
	mysql_select_db($Config['DbName'],$link) or die ("could not open db".mysql_error());
	
	 
	$sql = "select CmpID,DisplayName from company where CmpID in (31,76) ".$addSql." order by CmpID asc ";

	$q=mysql_query($sql,$link) or die (mysql_error()); 
	$Count=0;
	 
 
	/**************************/
	/**************************/
	$ErrorMsg='';
	$MovedArray=array();
	while($row = mysql_fetch_array($q)) {	
		 
		$Config['CmpID'] = $row['CmpID'];
		$CmpDatabase = $Config['DbName']."_".$row['DisplayName'];
		$FromDir = $ShippDir.$Config['CmpID']."/";
		/**************************/ 
		$sql_inner = "select ".$ColFile." as FileName from ".$CmpDatabase.".".$Table." where LCASE(".$ColFile2.")='".strtolower(trim($ShipType))."' and ".$ColFile."!='' order by ShipmentID asc ";	
		$q2=mysql_query($sql_inner,$link) or die (mysql_error()); 
		if(!empty($_GET['debug'])){
			echo $sql_inner; die;
		}
		/**************************/
		while($row2 = mysql_fetch_array($q2)) {
			$PdfFileName='';
			 

			if($ColFile == 'LabelChild'){
				$LabelChildArry = explode("#",$row2['FileName']);
 
				foreach($LabelChildArry as $PdfFileName){
					if($PdfFileName !='' && file_exists($FromDir.$PdfFileName) ){  
		 				$ResponseArray = $objFunction->MoveObjStorage($FromDir , $Folder, $PdfFileName);			
					  	if(!empty($ResponseArray['Success'])){
							$MovedArray[] =  $PdfFileName;	
						}
					}
				}
			}else{	
				$PdfFileName = $row2['FileName'];					
				if($PdfFileName !='' && file_exists($FromDir.$PdfFileName) ){  
	 				$ResponseArray = $objFunction->MoveObjStorage($FromDir , $Folder, $PdfFileName);				
					if(!empty($ResponseArray['Success'])){
						$MovedArray[] =  $PdfFileName;	 
					}
				}
			}


		}			
		/**************************/	 
		
		 
	}	
	
	pr($MovedArray,0);
	require_once("footer.php"); 
 	pr($ErrorMsg,1);


}

exit;
 
?>
 
