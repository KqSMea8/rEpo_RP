<?
class archive extends dbClass{ 

	var $tables;
	
	function archive(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

 	function AddToArchiveSO($OrderID){ 
	
		$ArchivePrefix = "archive_";
		global $Config;

		$MoveToArchive = 1;

		//Sales Order, Line Item Invoice, Gl Invoice, Credit Memo
		if(!empty($OrderID) && !empty($MoveToArchive) &&  $_SESSION['CmpID']=='37'){
			/********Sale Order*********/ 
			$Table = 's_order'; 
			$ArchiveTable = $ArchivePrefix.$Table;

			$sql = "select s.OrderID,s.Module,s.InvoiceEntry,s.IncomeID,s.AccountID,w.ShippedID,s.CreditID,i.GlEntryType, so.CardID, so.CardNumber from ".$Table." s left outer join f_income i on (s.IncomeID=i.IncomeID and s.IncomeID>0 and s.Module='Invoice') left outer join s_order_card so on (s.OrderID=so.OrderID and so.OrderID>0 ) left outer join w_shipment w on (s.OrderID=w.ShippedID and w.ShippedID>0 and s.Module='Shipment' )  where s.OrderID='".$OrderID."' ";
			$arryOrder = $this->query($sql, 1);
			//pr($arryOrder,1);
			$Module = $arryOrder[0]['Module'];
			$InvoiceEntry = $arryOrder[0]['InvoiceEntry'];
			$income_id = $arryOrder[0]['IncomeID'];
			$GlEntryType = $arryOrder[0]['GlEntryType'];
			$CreditID = $arryOrder[0]['CreditID'];
			$ShippedID = $arryOrder[0]['ShippedID'];
			$AccountID = $arryOrder[0]['AccountID'];
			$CardID = $arryOrder[0]['CardID'];
			$CardNumber = $arryOrder[0]['CardNumber'];

			/**************/

			$ArrayFieldName = $this->GetFieldName($ArchiveTable);			
			foreach($ArrayFieldName as $key=>$values){
				if($values['Key'] != 'PRI' && $values['Field']!='ArchiveDate'){
					$FeildAndValuesArray[] = "`".$values['Field']."`";
				} 	 
			}
			$FeildAndValues = implode(", ",$FeildAndValuesArray); 
			 $strSQLQuery = "insert into ".$ArchiveTable." (".$FeildAndValues.") select ".$FeildAndValues."  FROM ".$Table."  where OrderID = '".$OrderID."'";
			$this->query($strSQLQuery, 0);
			$ArchiveID = $this->lastInsertId();
			if(!empty($ArchiveID)){
				$strSQL = "update ".$ArchiveTable." set  ArchiveDate='".$Config['TodayDate']."' where ArchiveID='" .$ArchiveID. "'";	
				$this->query($strSQL, 0);
			}
 			/*******************/
			if( $InvoiceEntry=='0' || $InvoiceEntry=='1' ){   //Start Line Item 
				/*******************/
				$Table = 's_order_item'; 
				$ArchiveTable = $ArchivePrefix.$Table;

				$ArrayFieldName2 = $this->GetFieldName($ArchiveTable);	
				foreach($ArrayFieldName2 as $key=>$val){
					if($val['Key'] != 'PRI'){
						$FeildAndValuesArray2[] = "`".$val['Field']."`";
					} 	 
				}
				$FeildAndValue = implode(", ",$FeildAndValuesArray2);
				 
				$strSQLQuery = "insert into ".$ArchiveTable." (".$FeildAndValue.") select ".$FeildAndValue."  FROM ".$Table." where OrderID = '".$OrderID."'";
				$this->query($strSQLQuery, 0);
				
			}else if($Module=='Invoice' && $income_id>0 && ($InvoiceEntry=='2' || $InvoiceEntry=='3')){  //Start GL Invoice 
				/*******************/
				$Table = 'f_income'; 
				$ArchiveTable = $ArchivePrefix.$Table;

				$ArrayFieldName2 = $this->GetFieldName($ArchiveTable);
				foreach($ArrayFieldName2 as $key=>$val){
					if($val['Key'] != 'PRI'){
						$FeildAndValuesArray2[] = "`".$val['Field']."`";
					} 	 
				}
				$FeildAndValue = implode(", ",$FeildAndValuesArray2);
				 
				$strSQLQuery = "insert into ".$ArchiveTable." (".$FeildAndValue.") select ".$FeildAndValue."  FROM ".$Table." where IncomeID = '".$income_id."'";
				$this->query($strSQLQuery, 0);
				 
				if(!empty($GlEntryType) && $GlEntryType == "Multiple"){	
					$Table = 'f_multi_account'; 
					$ArchiveTable = $ArchivePrefix.$Table;

					$ArrayFieldName3 = $this->GetFieldName($ArchiveTable);	

					foreach($ArrayFieldName3 as $key=>$val){
						if($val['Key'] != 'PRI'){
							$FeildAndValuesArray3[] = "`".$val['Field']."`";
						} 	 
					}
					$FeildAndValue = implode(", ",$FeildAndValuesArray3);
					 
					$strSQLQuery = "insert into ".$ArchiveTable." (".$FeildAndValue.") select ".$FeildAndValue."  FROM ".$Table." where IncomeID = '".$income_id."'";
					$this->query($strSQLQuery, 0);	
				}
				/*******************/
			}

		        if($Module=='Shipment' && !empty($ShippedID) ){
				$Table = 'w_shipment';
				$ArchiveTable = $ArchivePrefix.$Table;

				$ArrayFieldName4 = $this->GetFieldName($ArchiveTable);	

				foreach($ArrayFieldName4 as $key=>$val){
					if($val['Key'] != 'PRI'){
						$FeildAndValuesArray4[] = "`".$val['Field']."`";
					} 	 
				}
				$FeildAndValue = implode(", ",$FeildAndValuesArray4);
				$strSQLQuery = "insert into ".$ArchiveTable." (".$FeildAndValue.") select ".$FeildAndValue."  FROM ".$Table." where ShippedID = '".$ShippedID."'";
				$this->query($strSQLQuery, 0);
			
			}

			if(!empty($CardID) && !empty($CardNumber)){ 
				$Table = 's_order_card'; 
				$ArchiveTable = $ArchivePrefix.$Table;

				$ArrayFieldName5 = $this->GetFieldName($ArchiveTable);	
 
				foreach($ArrayFieldName5 as $key=>$val){
					if($val['Key'] != 'PRI'){
						$FeildAndValuesArray5[] = "`".$val['Field']."`";
					} 	 
				}

				$FeildAndValue = implode(", ",$FeildAndValuesArray5);
 
				$strSQLQuery = "insert into ".$ArchiveTable." (".$FeildAndValue.") select ".$FeildAndValue."  FROM ".$Table." where OrderID = '".$OrderID."'";
				$this->query($strSQLQuery, 0);

				/*******************/
			}

		}
		return 1;

	}


	 



}
?>
