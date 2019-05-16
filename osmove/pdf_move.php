<?php
 require_once("header.php");


if(!empty($Base) && $Base=='2e5bda28ac98653b0c5ec52b9906845a'){ 
 

	/**************************/
	/**************************/
 	$link=mysql_connect ($Config['DbHost'],mydecrypt($Config['DbUser']),mydecrypt($Config['DbPassword']),TRUE);
	if(!$link){die("Could not connect to MySQL");}
	mysql_select_db($Config['DbName'],$link) or die ("could not open db".mysql_error());
	
	if(!empty($_GET['cmp']))$addSql = " and CmpID='".$_GET['cmp']."'";
	$sql = "select CmpID,DisplayName from company where CmpID>0 ".$addSql." order by CmpID asc ";

	$q=mysql_query($sql,$link) or die (mysql_error()); 
	$Count=0;
	 
 
	/**************************/
	/**************************/
	$ErrorMsg='';

	while($row = mysql_fetch_array($q)) {	
		 
		$Config['CmpID'] = $row['CmpID'];
		$CmpDatabase = $Config['DbName']."_".$row['DisplayName'];
		$FromDir = $UploadDir.$Config['CmpID'].'/'.$Folder;
		/**************************/
		if(!empty($Module)) $add_sql = " and Module='".$Module."'";
		$sql_inner = "select ".$ColAuto." as AutoID,  ".$ColFile." as FileName,PdfFile from ".$CmpDatabase.".".$Table." where ".$ColFile."!=''  ".$add_sql."  order by ".$ColAuto." asc ";		
		$q2=mysql_query($sql_inner,$link) or die (mysql_error()); 
		if(!empty($_GET['debug'])){
			echo $sql_inner; die;
		}
		/**************************/
		while($row2 = mysql_fetch_array($q2)) {

			$PdfFileName = $ModDepName . '-' . $row2['FileName'] . '.pdf';   //in s_order, p_order, c_quotes, w_receipt, w_receiptpo, dynamic_pdf_template

			if($row2['FileName'] !='' && file_exists($FromDir.$PdfFileName) ){ 
 
				$ResponseArray = $objFunction->MoveObjStorage($FromDir , $Folder, $PdfFileName);
				#echo $PdfFileName; pr($ResponseArray,1);
				if($ResponseArray['Success']=="1"){				 
					echo '<br>Copied for '.$row['DisplayName'].' : '.$row2['AutoID'].'<br>';
					

					/***Update PdfFile in DB*************/ 
					$OrderID = $row2['AutoID'];
					$FileExist =1 ;//in c_document, company;
					if(!empty($Table) && !empty($ColAuto) && !empty($OrderID) && !empty($PdfFileName)){
						 
					 	$sqlPdf = "update ".$CmpDatabase.".".$Table." set PdfFile='".$PdfFileName."' where ".$ColAuto."='".$OrderID."'";
						mysql_query($sqlPdf);
						 
 
						
					}
					/*********************************/

					 #echo $PdfFileName;exit;
	
				}else{
					$ErrorMsg[] = $row['DisplayName'].' : '.$row2['AutoID'].' : '.$ResponseArray['ErrorMsg']; 
				}

 
				
				$Count++;
			}
		}			
		/**************************/	 
		
		 
	}	
	

	require_once("footer.php"); 
 	pr($ErrorMsg,1);


}

exit;
 
?>
 
