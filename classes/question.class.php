<?php

class question extends dbClass
{

     function getQuestion() {
		global $Config;
		$strAddQuery = '';
		if($Config['GetNumRecords']==1){
			$Columns = " count(QuestionID) as NumCount ";				
		}else{				
			$Columns = " * ";
			if($Config['RecordsPerPage']>0){
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}
		
		}

		 $sql = "SELECT ".$Columns." from question  ORDER BY QuestionID ASC ".$strAddQuery;
		return $this->query($sql, 1);
	}


	function changeQuestionStatus($QuestionID) {
			$sql = "select * from question where QuestionID = '" . mysql_real_escape_string($QuestionID) . "'";
			$rs = $this->query($sql);
			if (sizeof($rs)) {
				if ($rs[0]['Status'] == '1')
				$Status = '0';
				else
				$Status = '1';

				 $sql = "update question set Status='" . mysql_real_escape_string(strip_tags($Status)) . "' where QuestionID = '" . mysql_real_escape_string($QuestionID) . "'";
				$this->query($sql, 0);
				return true;
			}
		}


	function deleteQuestion($QuestionID) {
			if(!empty($QuestionID)){
				
				$sql = "DELETE from question where QuestionID = '" . mysql_real_escape_string($QuestionID) . "'";
				$this->query($sql, 0);    
			}
			return 1;
		}

	function AddQuestion($arryDetails) {
			@extract($arryDetails);
		  // echo $sql = "INSERT INTO question (Question,Option,Status)values('".$Question."','".$Option."','".$Status."')";
                           $sql="INSERT INTO question SET Question='".$Question."',ColumnName='".$ColumnName."',Status='".$Status."'";
			$this->query($sql, 0);
		}


function getQuestionById($QuestionID) {
		global $Config;	
		 $sql = "SELECT * from ".$Config['DbMain'].".question WHERE QuestionID = '" . mysql_real_escape_string($QuestionID) . "'";
		return $this->query($sql, 1);
	}
	
	
  function updateQuestion($arryDetails) {
		@extract($arryDetails);

             $sql = "UPDATE  question SET Question ='". mysql_real_escape_string(strip_tags($Question)) ."',ColumnName = '". mysql_real_escape_string(strip_tags($ColumnName)) ."',Status='" . mysql_real_escape_string(strip_tags($Status)) . "' WHERE QuestionID = '" .  mysql_real_escape_string($QuestionID) . "' ";
		$this->query($sql, 0);
               
	}

	
function isQuestionExists($Question,$QuestionID=0)
		{  
			$strSQLQuery = (!empty($QuestionID))?(" and QuestionID != '".$QuestionID."'"):("");
		    $strSQLQuery = "select Question from question where LCASE(Question)='".strtolower(trim($Question))."'".$strSQLQuery; 
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['Question'])) {
				return true;
			} else { 
				return false;
			}
		}

	
	   function GetSecurityQuestionRandom(){
		global $Config;		
		 $sql = "SELECT * FROM ".$Config['DbMain'].".question where Status='1' ORDER BY RAND() ";
		// $sql = "SELECT * FROM ".$Config['DbMain'].".question WHERE Status='1' ORDER BY Question asc ";
		return $this->query($sql, 1);
	}



	function ValidateAnswer($QuestionID,$Answer){ 	
		global $Config;		
		$arryRow = $this->getQuestionById($QuestionID);
		
		$arrData=explode("#",$arryRow[0]['ColumnName']);
 	    	$columnName=$arrData[0];
		$tableName=$arrData[1];

		$sql = "select EmpID from ".$tableName." where  LCASE(".$columnName.") = '".strtolower(trim($Answer))."' AND EmpID='".$_SESSION['AdminID'] ."'";
		return $this->query($sql, 1); 		 
	}

	function ValidateSecurityProfile($QuestionID,$Answer){ 	
		global $Config;	
		$RefID = $_SESSION['UserID'];
		$UserType = $_SESSION['AdminType'];
	
		for($i=1;$i<=5;$i++){
			$sql = "select Question".$i." as Question from user_secure where Question".$i."='".$QuestionID."' AND RefID='".$RefID."' AND UserType='".$UserType."'";
			$arryRow = $this->query($sql, 1);
			if(!empty($arryRow[0]['Question'])){
				$Line = $i;break;
			}
		}
 	
		if($Line>0){
			 $sqlquery = "select ID from user_secure where  Question".$Line."='".$QuestionID."' AND LCASE(Answer".$Line.")='".strtolower(trim($Answer))."' AND RefID='".$RefID."' and UserType='".$UserType."'";
			return $this->query($sqlquery, 1); 
		}		 
	}

	function IsSecurityProfileExist(){			
		$strSQLQuery = "select * from user_secure where RefID='".$_SESSION['UserID']."' and UserType='".$_SESSION['AdminType']."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
		if(!empty($arryRow[0]['ID'])){
			return true;
		}
	}


	function AddUpdateSecurityProfile($arryDetails){   
		global $Config;	
		extract($arryDetails);
		 
		$RefID = $_SESSION['UserID'];
		$UserType = $_SESSION['AdminType'];

		for($i=0;$i<$NumLine;$i++){	
			$Line=$i+1;		 
			$QuestionID = $QuestionUser[$i];
			$AnswerVal = $Answer[$i];
			if($QuestionID>0 && !empty($AnswerVal)){
				$addsql .= " Question".$Line." = '".$QuestionID."', Answer".$Line." = '".$AnswerVal."',";
			}
		}
		$addsql = rtrim($addsql,",");


		if($this->IsSecurityProfileExist()){
			$sql = "UPDATE user_secure SET ".$addsql." where RefID='".$RefID."' and UserType='".$UserType."'"; 		
		}else{
			$sql = "INSERT INTO user_secure SET ".$addsql." , RefID='". $RefID."', UserType = '". $UserType."' ";	
		}		
		$this->query($sql, 1);		
			 
		return true;
	}

	function GetSecureProfileQuestion(){	
		global $Config;				
		$strSQLQuery = "select * from user_secure where RefID='".$_SESSION['UserID']."' and UserType='".$_SESSION['AdminType']."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
		$Questions='';
		for($i=1;$i<=5;$i++){
			$QuestionID = $arryRow[0]['Question'.$i];
			if($QuestionID>0){
				$Questions .= $QuestionID.',';
				$QuestionFlag=1;
			}
		}

		if($QuestionFlag==1 && !empty($Questions)){
			$Questions = rtrim($Questions,",");
			$sql = "SELECT * FROM ".$Config['DbMain'].".question where Status='1' and QuestionID in (".$Questions.") ORDER BY RAND() LIMIT 3";
		 	return $this->query($sql, 1);
		}
	}


	function DeleteSecurityProfile($RefID,$UserType) {
		if(!empty($RefID) && !empty($UserType)){			
			$sql = "DELETE from user_secure  where RefID='".$RefID."' and UserType='".$UserType."'"; 
			
			$this->query($sql, 0);    
		}
		return 1;
	}


	/*************************Superadmin Security Start *******************/
 	 function IsSecurityProfileExistSA(){			
		$strSQLQuery = "select * from user_secure where RefID='".$_SESSION['AdminID']."' and UserType='".$_SESSION['AdminType']."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
		if($arryRow[0]['ID']>0){
			return true;
		}
	}

	function ValidateSecurityProfileSA($QuestionID,$Answer){ 	
		global $Config;	
		$RefID = $_SESSION['AdminID'];
		$UserType = $_SESSION['AdminType'];
	
		for($i=1;$i<=5;$i++){
			$sql = "select Question".$i." as Question from user_secure where Question".$i."='".$QuestionID."' AND RefID='".$RefID."' AND UserType='".$UserType."'";
			$arryRow = $this->query($sql, 1);
			if(!empty($arryRow[0]['Question'])){
				$Line = $i;break;
			}
		}
 	
		if($Line>0){
			 $sqlquery = "select ID from user_secure where  Question".$Line."='".$QuestionID."' AND LCASE(Answer".$Line.")='".strtolower(trim($Answer))."' AND RefID='".$RefID."' and UserType='".$UserType."'";
			return $this->query($sqlquery, 1); 
		}		 
	}

	function GetSecureProfileQuestionSA(){	
		global $Config;	
		$strSQLQuery = "select * from user_secure where RefID='".$_SESSION['AdminID']."' and UserType='".$_SESSION['AdminType']."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
		for($i=1;$i<=5;$i++){
			$QuestionID = $arryRow[0]['Question'.$i];
			if($QuestionID>0){
				$Questions .= $QuestionID.',';
				$QuestionFlag=1;
			}
		}

		if($QuestionFlag==1 && !empty($Questions)){
			$Questions = rtrim($Questions,",");
			$sql = "SELECT * FROM question where Status='1' and QuestionID in (".$Questions.") ORDER BY RAND() LIMIT 3";
		 	return $this->query($sql, 1);
		}
	}

	function AddUpdateSecurityProfileSA($arryDetails){   
		global $Config;	
		extract($arryDetails);
		 
		$RefID = $_SESSION['AdminID'];
		$UserType = $_SESSION['AdminType'];

		for($i=0;$i<$NumLine;$i++){	
			$Line=$i+1;		 
			$QuestionID = $QuestionUser[$i];
			$AnswerVal = $Answer[$i];
			if($QuestionID>0 && !empty($AnswerVal)){
				$addsql .= " Question".$Line." = '".$QuestionID."', Answer".$Line." = '".$AnswerVal."',";
			}
		}
		$addsql = rtrim($addsql,",");


		if($this->IsSecurityProfileExist()){
			$sql = "UPDATE user_secure SET ".$addsql." where RefID='".$RefID."' and UserType='".$UserType."'"; 		
		}else{
			$sql = "INSERT INTO user_secure SET ".$addsql." , RefID='". $RefID."', UserType = '". $UserType."' ";	
		}		
		$this->query($sql, 1);		
			 
		return true;
	}


}
?>
