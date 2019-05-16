<?php

class industry extends dbClass
{

function addIndustry($arryDetails) {
		@extract($arryDetails);

		$sql = "INSERT INTO  industry_type SET IndustryName ='". mysql_real_escape_string(strip_tags($IndustryName)) ."', Description = '" . mysql_real_escape_string(strip_tags($Description)) . "',Status='" . mysql_real_escape_string(strip_tags($Status)) . "',Parent='" . mysql_real_escape_string(strip_tags($Parent)) . "'";
		$this->query($sql, 0);
		return $this->lastInsertId();
	}


function updateIndustry($arryDetails) {  
		@extract($arryDetails);

        $sql = "UPDATE  industry_type SET IndustryName ='". mysql_real_escape_string(strip_tags($IndustryName)) ."',Description = '". mysql_real_escape_string(strip_tags($Description)) ."',Status='" . mysql_real_escape_string(strip_tags($Status)) . "',Parent='" .  mysql_real_escape_string($Parent) . "' WHERE IndustryID = '" .  mysql_real_escape_string($IndustryID) . "' ";
		$this->query($sql, 0);
               
	}

function getIndustryById($IndustryID) {
		 $sql = "SELECT * FROM industry_type WHERE IndustryID = '" . mysql_real_escape_string($IndustryID) . "'";
		return $this->query($sql, 1);
	}


 function changeIndustryStatus($IndustryID) {
		$sql = "SELECT * FROM industry_type WHERE IndustryID = '" . mysql_real_escape_string($IndustryID) . "'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == '1')
			$Status = '0';
			else
			$Status = '1';

			 $sql = "UPDATE industry_type SET Status='" . mysql_real_escape_string(strip_tags($Status)) . "' WHERE IndustryID = '" . mysql_real_escape_string($IndustryID) . "'";
			$this->query($sql, 0);
			return true;
		}
	}


function deleteIndustry($IndustryID) {
		if(!empty($IndustryID)){
			$sql = "DELETE FROM industry_type WHERE IndustryID = '" . mysql_real_escape_string($IndustryID) . "'";
			$this->query($sql, 0);    
		}
		return 1;
	}


function isIndustryNameExists($IndustryName,$IndustryID=0)
		{  
			$strSQLQuery = (!empty($IndustryID))?(" and IndustryID != '".$IndustryID."'"):("");
		        $strSQLQuery = "SELECT IndustryName FROM industry_type WHERE LCASE(IndustryName)='".strtolower(trim($IndustryName))."'".$strSQLQuery; 
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['IndustryName'])) {
				return true;
			} else { 
				return false;
			}
		}

  function GetIndustryName($IndustryID){
      	       $strSQLQuery = "SELECT IndustryName,IndustryID FROM industry_type  WHERE IndustryID<=99";
			   return $this->query($strSQLQuery, 1);
      	       
      }


function getIndustry() {
		global $Config;
		$strAddQuery ='';
		if($Config['GetNumRecords']==1){
			$Columns = " count(IndustryID) as NumCount ";				
		}else{				
			$Columns = " * ";
			if($Config['RecordsPerPage']>0){
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}
		
		}

		// $sql = "SELECT ".$Columns." from industry_type  ORDER BY IndustryID DESC ".$strAddQuery;
		$sql = "SELECT ".$Columns." FROM industry_type WHERE IndustryName NOT IN ('Distribution') ORDER BY IndustryName ASC ".$strAddQuery;
		
		return $this->query($sql, 1);
	}
	
	/*function GetAccountIndustry($IndustryID,$Parent){ //echo $Parent;die;
		if($IndustryID>100){
			
			 $sql = "SELECT * from industry_account WHERE IndustryID='".$Parent."'";
			return $this->query($sql, 1);
			
		}else{
		
		 $sql ="SELECT * FROM industry_account WHERE IndustryID='".$IndustryID."'";
		return $this->query($sql, 1);
		}
	}
	*/
function GetAccountIndustry($IndustryID,$Parent) {
		global $Config;

		if($Config['GetNumRecords']==1){
			$Columns = " count(AccountID) as NumCount ";				
		}else{				
			$Columns = " * ";
			if($Config['RecordsPerPage']>0){
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}
		
		}

		// $sql = "SELECT ".$Columns." from industry_type  ORDER BY IndustryID DESC ".$strAddQuery;
		/*$sql = "SELECT ".$Columns." FROM industry_type WHERE IndustryName NOT IN ('Distribution') ORDER BY IndustryID DESC ".$strAddQuery;
		
		return $this->query($sql, 1);
		*/
		
if($IndustryID>100){
			
			 $sql = "SELECT ".$Columns." from industry_account WHERE IndustryID='".$Parent."'";
			 
			
		}else{
		
		 $sql ="SELECT ".$Columns." FROM industry_account WHERE IndustryID='".$IndustryID."'";
		 
		}
		 
		return $this->query($sql, 1);
	}


}

?>
