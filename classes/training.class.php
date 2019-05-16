<?
class training extends dbClass
{
		//constructor
		function training()
		{
			$this->dbClass();
		} 
		
		function  ListTraining($arryDetails){
			extract($arryDetails);
			global $Config;
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" where t.trainingID='".$id."'"):(" where t.locationID='".$_SESSION['locationID']."'");

			if($sortby != ''){
					$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (t.trainingID like '%".$SearchKey."%'  or t.CourseName like '%".$SearchKey."%'  or t.Company like '%".$SearchKey."%' or e.UserName like '%".$SearchKey."%'    ) " ):("");	
			}


			/**************/
			$FromDate = DefaultDateFormat($FromDate);
			$ToDate = DefaultDateFormat($ToDate);		 
			/**************/



			$strAddQuery .= (!empty($FromDate))?(" and t.trainingDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and t.trainingDate<='".$ToDate."'"):("");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by t.trainingID ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");

			if($Config['GetNumRecords']==1){
				$Columns = " count(t.trainingID) as NumCount ";				
			}else{				
				$Columns = " t.*,e.UserName as CoordinatorName   ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

			$strSQLQuery = "select ".$Columns." from h_training t left outer join h_employee e on t.Coordinator=e.EmpID  ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	

		function  GetTraining($trainingID,$Status)
		{

			$strAddQuery = '';
			$strAddQuery .= (!empty($trainingID))?(" where t.trainingID='".mysql_real_escape_string($trainingID)."'"):(" where t.locationID='".$_SESSION['locationID']."'");
			$strAddQuery .= ($Status>0)?(" and t.Status='".$Status."'"):("");

			$strSQLQuery = "select t.*,e.Department,e.UserName as CoordinatorName from h_training t left outer join h_employee e on t.Coordinator=e.EmpID ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}		
			
		function  TrainingListing($SearchKey,$Status)
		{
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery = " where t.locationID='".$_SESSION['locationID']."'";
			$strAddQuery .= ($Status>0)?(" and t.Status='".$Status."'"):("");

			$strAddQuery .= (!empty($SearchKey))?(" and (t.trainingID like '%".$SearchKey."%'  or t.CourseName like '%".$SearchKey."%'  or t.Company like '%".$SearchKey."%' or e.UserName like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%'  or t.trainingDate like '%".$SearchKey."%') " ):("");

			$strAddQuery .= " order by t.trainingDate  Desc ";

			$strSQLQuery = "select t.*,d.Department,e.UserName as CoordinatorName from h_training t left outer join h_employee e on t.Coordinator=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}


		function AddTraining($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "insert into h_training (locationID, CourseName, Company, trainingDate, Address, trainingTime, Status, Coordinator, Cost, Topic, detail, UpdatedDate ) values(  '".$_SESSION['locationID']."', '".addslashes($CourseName)."', '".addslashes($Company)."', '".$trainingDate."', '".addslashes($Address)."', '".addslashes($trainingTime)."',  '".$Status."', '".$Coordinator."',  '".addslashes($Cost)."', '".addslashes($Topic)."', '".addslashes($detail)."',  '".$Config['TodayDate']."')";

			$this->query($strSQLQuery, 0);

			$trainingID = $this->lastInsertId();
			
			return $trainingID;

		}


		function UpdateTraining($arryDetails){
			global $Config;
			extract($arryDetails);
			if(!empty($trainingID)){
				$strSQLQuery = "update h_training set CourseName='".addslashes($CourseName)."', Company='".addslashes($Company)."', trainingDate='".$trainingDate."', trainingTime='".addslashes($trainingTime)."',Coordinator='".addslashes($Coordinator)."'	, Address='".addslashes($Address)."',  Status='".$Status."'  ,Cost='".addslashes($Cost)."', Topic='".addslashes($Topic)."'	,detail='".addslashes($detail)."'	, UpdatedDate = '".$Config['TodayDate']."' where trainingID='".mysql_real_escape_string($trainingID)."'"; 
				$this->query($strSQLQuery, 0);
			}

			return 1;
		}

					
		
		function RemoveTraining($trainingID)
		{
			global $Config;
			$objConfigure=new configure();
			$objFunction=new functions();
			$trainingID = mysql_real_escape_string($trainingID);
			if(!empty($trainingID)){
				$strSQLQuery = "select document from h_training where trainingID='".$trainingID."'"; 
				$arryRow = $this->query($strSQLQuery, 1);

 			 
				if($arryRow[0]['document'] !=''   ){			
					$objFunction->DeleteFileStorage($Config['TrainingDir'],$arryRow[0]['document']);	
				}			

				
				$strSQLQuery = "delete from h_training where trainingID='".$trainingID."'"; 
				$this->query($strSQLQuery, 0);	
			}

			return 1;

		}

		function UpdateDocument($document,$trainingID)
		{
			if(!empty($trainingID) && !empty($document)){

				$strSQLQuery = "update h_training set document='".$document."' where trainingID='".$trainingID."'";
				$this->query($strSQLQuery, 0);
			}
			return true;
		}

		function changeTrainingStatus($trainingID)
		{
			$trainingID = mysql_real_escape_string($trainingID);
			if(!empty($trainingID)){
				$sql="select * from h_training where trainingID='".$trainingID."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_training set Status='$Status' where trainingID='".$trainingID."'";
					$this->query($sql,0);				

				}	
			}
			return true;

		}
		

		function MultipleTrainingStatus($trainingIDs,$Status)
		{
			$sql="select trainingID from h_training where trainingID in (".$trainingIDs.") and Status!='".$Status."'"; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update h_training set Status='".$Status."' where trainingID in (".$trainingIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}

		

		function isCourseExists($CourseName,$trainingID=0)
		{
			$strSQLQuery = (!empty($trainingID))?(" and trainingID != '".$trainingID."'"):("");
			$strSQLQuery = "select trainingID from h_training where LCASE(CourseName)='".strtolower(trim($CourseName))."'".$strSQLQuery; 
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['trainingID'])) {
				return true;
			} else {
				return false;
			}
		}

		
		/**********Participants Functions *******/
		/****************************************/
		function  GetParticipant($partID, $trainingID)
		{
			$strAddQuery = 'where 1 ';

			$strAddQuery .= (!empty($trainingID))?(" and p.trainingID='".mysql_real_escape_string($trainingID)."'"):("");
			$strAddQuery .= (!empty($partID))?(" and p.partID='".mysql_real_escape_string($partID)."'"):("");
			$strSQLQuery = "select p.*,e.UserName,e.Email,e.JobTitle, d.Department from h_participant p inner join h_employee e on p.EmpID=e.EmpID left outer join  h_department d on e.Department=d.depID ".$strAddQuery." order by e.UserName asc";

			return $this->query($strSQLQuery, 1);
		}

		function RemoveParticipant($partID)
		{
			if(!empty($partID)){
				$strSQLQuery = "delete from h_participant where partID='".mysql_real_escape_string($partID)."'"; 
				$this->query($strSQLQuery, 0);		
			}
			return 1;
		}

		function AddParticipant($arryDetails)
		{
			global $Config;
			extract($arryDetails);

			foreach($arryDetails['EmpID'] as $EmpID){

				$sql = "insert ignore into h_participant(EmpID, trainingID, AddedDate) values('".$EmpID."', '".$trainingID."', '".$Config['TodayDate']."')";
				$rs = $this->query($sql,0);
			}
			return 1;
		}

		function UpdateParticipantFeedback($arryDetails){
			global $Config;
			extract($arryDetails);
			if(!empty($partID)){
				$strSQLQuery = "update h_participant set Feedback='".addslashes(strip_tags($Feedback))."' where partID='".$partID."'"; 
				$this->query($strSQLQuery, 0);
			}

			return 1;
		}

}
?>
