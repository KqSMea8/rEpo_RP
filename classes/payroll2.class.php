<?
class payroll extends dbClass
{
		//constructor
		function payroll()
		{
			$this->dbClass();
		} 

		////////// Head Start ///////////////

		function addHead($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	


			$sql = "insert into h_pay_head (locationID, catID, heading, subheading, HeadType, Percentage, Amount, `Default`, Status, updatedDate) values('".$_SESSION['locationID']."', '".addslashes($catID)."', '".addslashes($heading)."', '".addslashes($subheading)."', '".addslashes($HeadType)."', '".addslashes($Percentage)."', '".addslashes($Amount)."', '".$Default."',  '".addslashes($Status)."', '".$Config['TodayDate']."' )";
		
			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;

		}
		function updateHead($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	
			$sql = "update h_pay_head set heading='".addslashes($heading)."', subheading = '".addslashes($subheading)."', Percentage = '".addslashes($Percentage)."', Amount = '".addslashes($Amount)."', HeadType = '".addslashes($HeadType)."' ,Status = '".$Status."', updatedDate = '".$Config['TodayDate']."'  where headID = ".$headID; 
			$rs = $this->query($sql,0);
				
			if(sizeof($rs))
				return true;
			else
				return false;

		}

		function getHead($id=0, $catID=0, $Status=0)
		{
			$sql = " where 1";
			$sql .= (!empty($id))?(" and headID = ".$id):(" and locationID=".$_SESSION['locationID']);
			$sql .= (!empty($catID))?(" and catID = ".$catID):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from  h_pay_head ".$sql." order by headID Asc" ; 
			return $this->query($sql, 1);
		}

		function getDefaultHead($id=0, $catID=0, $Status=0)
		{
			$sql = " where `Default`=1 ";
			$sql .= (!empty($id))?(" and headID = ".$id):(" and locationID=".$_SESSION['locationID']);
			$sql .= (!empty($catID))?(" and catID = ".$catID):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from  h_pay_head ".$sql." order by headID Asc" ; 
			return $this->query($sql, 1);
		}

		function changeHeadStatus($headID)
		{
			$sql="select * from  h_pay_head where headID=".$headID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{

				if($rs[0]['Status']==1){
					$Status=0; 
				}else{
					$Status=1;
				}
					
				$sql="update  h_pay_head set Status='$Status' where headID=".$headID;
				$this->query($sql,0);
				return true;
			}			
		}

		function deleteHead($headID)
		{
			$sql = "delete from  h_pay_head where headID = ".$headID;
			$rs = $this->query($sql,0);

			if(sizeof($rs))
				return true;
			else
				return false;

		}
		
		function  ListHead($id=0, $catID=0, $SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and headID=".$id):(" and locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($catID))?(" and catID=".$catID):("");

			if($SearchKey=='active' && ($SortBy=='Status' || $SortBy=='') ){
					$strAddQuery .= " and Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='Status' || $SortBy=='') ){
					$strAddQuery .= " and Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (heading like '%".$SearchKey."%' or subheading like '%".$SearchKey."%' or Percentage like '%".$SearchKey."%' )"):("");
			}


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by headID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

			$strSQLQuery = "select * from  h_pay_head ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}

		function isHeadExists($heading, $catID, $headID)
		{

			$strSQLQuery = "select headID from h_pay_head where LCASE(heading)='".strtolower(trim($heading))."' and locationID=".$_SESSION['locationID']." and catID=".$catID;

			$strSQLQuery .= (!empty($headID))?(" and headID != ".$headID):("");
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['headID'])) {
				return true;
			} else {
				return false;
			}

		}
		/***************************/

		////////// Head Start ///////////////

		function addDecHead($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	


			$sql = "insert into h_dec_head (locationID, catID, heading, subheading, `Default`, Status, updatedDate) values('".$_SESSION['locationID']."', '".addslashes($catID)."', '".addslashes($heading)."', '".addslashes($subheading)."', '".$Default."',  '".addslashes($Status)."', '".$Config['TodayDate']."' )";
		
			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;

		}
		function updateDecHead($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	
			$sql = "update h_dec_head set heading='".addslashes($heading)."', subheading = '".addslashes($subheading)."',Status = '".$Status."', updatedDate = '".$Config['TodayDate']."'  where headID = ".$headID; 
			$rs = $this->query($sql,0);
				
			if(sizeof($rs))
				return true;
			else
				return false;

		}

		function getDecHead($id=0, $catID=0, $Status=0)
		{
			$sql = " where 1";
			$sql .= (!empty($id))?(" and headID = ".$id):(" and locationID=".$_SESSION['locationID']);
			$sql .= (!empty($catID))?(" and catID = ".$catID):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from  h_dec_head ".$sql." order by headID Asc" ; 
			return $this->query($sql, 1);
		}

		function getDefaultDecHead($id=0, $catID=0, $Status=0)
		{
			$sql = " where `Default`=1 ";
			$sql .= (!empty($id))?(" and headID = ".$id):(" and locationID=".$_SESSION['locationID']);
			$sql .= (!empty($catID))?(" and catID = ".$catID):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from  h_dec_head ".$sql." order by headID Asc" ; 
			return $this->query($sql, 1);
		}

		function changeDecHeadStatus($headID)
		{
			$sql="select * from  h_dec_head where headID=".$headID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{

				if($rs[0]['Status']==1){
					$Status=0; 
				}else{
					$Status=1;
				}
					
				$sql="update  h_dec_head set Status='$Status' where headID=".$headID;
				$this->query($sql,0);
				return true;
			}			
		}

		function deleteDecHead($headID)
		{
			$sql = "delete from  h_dec_head where headID = ".$headID;
			$rs = $this->query($sql,0);

			if(sizeof($rs))
				return true;
			else
				return false;

		}
		
		function  ListDecHead($id=0, $catID=0, $SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and headID=".$id):(" and locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($catID))?(" and catID=".$catID):("");

			if($SearchKey=='active' && ($SortBy=='Status' || $SortBy=='') ){
					$strAddQuery .= " and Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='Status' || $SortBy=='') ){
					$strAddQuery .= " and Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (heading like '%".$SearchKey."%' or subheading like '%".$SearchKey."%' )"):("");
			}


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by headID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

			$strSQLQuery = "select * from  h_dec_head ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}

		function isDecHeadExists($heading, $catID, $headID)
		{

			$strSQLQuery = "select headID from h_dec_head where LCASE(heading)='".strtolower(trim($heading))."' and locationID=".$_SESSION['locationID']." and catID=".$catID;

			$strSQLQuery .= (!empty($headID))?(" and headID != ".$headID):("");
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['headID'])) {
				return true;
			} else {
				return false;
			}

		}
		/***************************/	


		function getPayCategory($catID=0,$Status)
		{
			$addsql = (!empty($catID))?(" and catID=".$catID):("");
			$addsql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");
			$sql = "select * from  h_pay_cat where 1 ".$addsql." order by catID Asc" ; 
			return $this->query($sql, 1);
		}

		function getDecCategory($catID=0,$Status)
		{
			$addsql = (!empty($catID))?(" and catID=".$catID):("");
			$addsql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");
			$sql = "select * from  h_dec_cat where 1 ".$addsql." order by catID Asc" ; 
			return $this->query($sql, 1);
		}

		/********** Salary Management *********/
		/*******************************************/
		function  ListSalary($id=0,$SearchKey,$SortBy,$AscDesc){
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where s.salaryID=".$id):(" where e.locationID=".$_SESSION['locationID']);

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (s.EmpID like '".$SearchKey."'  or e.UserName like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%'  or e.JobTitle like '%".$SearchKey."%') " ):("");			
			}			

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." ".$AscDesc):(" order by d.depID asc, e.EmpID asc ");

			$strSQLQuery = "select s.*,e.UserName,e.Email,e.JobTitle, d.Department from h_salary s inner join h_employee e on s.EmpID=e.EmpID left outer join department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function  getSalary($id=0,$EmpID){
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where s.salaryID=".$id):(" where e.locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($EmpID))?(" and s.EmpID=".$EmpID):("");

			$strSQLQuery = "select s.*,e.UserName,e.Email,e.JobTitle, d.Department from h_salary s inner join h_employee e on s.EmpID=e.EmpID left outer join department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function deleteSalary($salaryID){
			$sql = "delete from h_salary where salaryID = ".$salaryID;
			$rs = $this->query($sql,0);
			if(sizeof($rs))
				return true;
			else
				return false;
		}


		function addSalary($arryDetails){ 
			global $Config;
			/********************/
			$SalaryData='';
			foreach($arryDetails as $key=>$values){
				if(substr_count($key, 'Field')>0){
					$headID = str_replace("Field","",$key);
					$SalaryData .= $headID.':'.$values.'#';
				}
			}
			$SalaryData = rtrim($SalaryData,"#");
			/********************/
			@extract($arryDetails);	 
			$sql = "insert into h_salary(EmpID, CTC, Gross, NetSalary, SalaryData, updatedDate, BankName, AccountName, AccountNumber, IFSCCode) values('".$EmpID."', '".$CTC."', '".$Gross."', '".$NetSalary."', '".$SalaryData."', '".$Config['TodayDate']."', '".addslashes($BankName)."', '".addslashes($AccountName)."', '".addslashes($AccountNumber)."', '".addslashes($IFSCCode)."')";
			$this->query($sql,0);
			return true;
		}

		function updateSalary($arryDetails){
			global $Config;
			/********************/
			$SalaryData='';
			foreach($arryDetails as $key=>$values){
				if(substr_count($key, 'Field')>0){
					$headID = str_replace("Field","",$key);
					$SalaryData .= $headID.':'.$values.'#';
				}
			}
			$SalaryData = rtrim($SalaryData,"#");
			/********************/
			@extract($arryDetails);	
			$sql = "update h_salary set CTC='".$CTC."', Gross = '".$Gross."', NetSalary = '".$NetSalary."', SalaryData = '".$SalaryData."', updatedDate = '".$Config['TodayDate']."', BankName='".addslashes($BankName)."'		,AccountName='".addslashes($AccountName)."'	, AccountNumber='".addslashes($AccountNumber)."', IFSCCode='".addslashes($IFSCCode)."' where salaryID = ".$salaryID; 
			$rs = $this->query($sql,0);
				
			return true;
		}

		function isSalaryExists($EmpID,$salaryID)
		{
			$strSQLQuery = "select salaryID from h_salary where EmpID='".trim($EmpID)."' ";

			$strSQLQuery .= (!empty($salaryID))?(" and salaryID != ".$salaryID):("");
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['salaryID'])) {
				return $arryRow[0]['salaryID'];
			} else {
				return false;
			}

		}

		/**********Generated Salary Management *********/
		/*******************************************/
		function  ListPaySalary($EmpID,$Year,$Month,$SearchKey,$SortBy,$AscDesc){
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= ($EmpID>0)?(" where p.EmpID=".$EmpID):(" where e.locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($Year))?(" and p.Year='".$Year."'"):("");
			$strAddQuery .= (!empty($Month))?(" and p.Month='".$Month."'"):("");

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (p.EmpID like '".$SearchKey."'  or e.UserName like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%'  or e.JobTitle like '%".$SearchKey."%') " ):("");			
			}			

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." ".$AscDesc):(" order by p.Year desc, p.Month desc ");

			$strSQLQuery = "select p.*,e.UserName,e.Email,e.JobTitle, d.Department from h_pay_salary p inner join h_employee e on p.EmpID=e.EmpID left outer join department d on e.Department=d.depID ".$strAddQuery;
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function deletePaySalary($payID){
			$sql = "delete from h_pay_salary where payID = ".$payID;
			$rs = $this->query($sql,0);
			if(sizeof($rs))
				return true;
			else
				return false;
		}

		function isPaySalaryExists($EmpID,$Year,$Month)
		{
			$strSQLQuery = "select payID from h_pay_salary where EmpID='".trim($EmpID)."' and Year='".trim($Year)."' and Month='".trim($Month)."'";

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['payID'])) {
				return $arryRow[0]['payID'];
			} else {
				return false;
			}

		}

		function addPaySalary($arryDetails){ 
			global $Config;
			/********************/
			$SalaryData='';
			
			foreach($arryDetails as $key=>$values){
				if(substr_count($key, 'Field')>0){
					$headID = str_replace("Field","",$key);
					$SalaryData .= $headID.':'.$values.'#';
				}
			}
			$SalaryData = rtrim($SalaryData,"#");
			
			/********************/
			@extract($arryDetails);	 
			$sql = "insert into h_pay_salary(EmpID, Year, Month, CTC, Gross, NetSalary, CurrentSalary, SalaryData, addedDate, updatedDate, SubTotalA, SubTotalB, SubTotalC, SubTotalD, LeaveTaken, LeaveDeduction) values('".$EmpID."', '".$Year."', '".$Month."', '".$CTC."', '".$Gross."', '".$NetSalary."', '".$CurrentSalary."', '".$SalaryData."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$SubTotalA."', '".$SubTotalB."', '".$SubTotalC."', '".$SubTotalD."', '".$LeaveTaken."', '".$LeaveDeduction."')";
			$this->query($sql,0);
			return true;
		}

		function updatePaySalary($arryDetails){
			global $Config;
			/********************/
			$SalaryData='';
			foreach($arryDetails as $key=>$values){
				if(substr_count($key, 'Field')>0){
					$headID = str_replace("Field","",$key);
					$SalaryData .= $headID.':'.$values.'#';
				}
			}
			$SalaryData = rtrim($SalaryData,"#");
			/********************/
			@extract($arryDetails);	
			$sql = "update h_pay_salary set CTC='".$CTC."', Gross = '".$Gross."', NetSalary = '".$NetSalary."', CurrentSalary = '".$CurrentSalary."', SalaryData = '".$SalaryData."', updatedDate = '".$Config['TodayDate']."', SubTotalA = '".$SubTotalA."', SubTotalB = '".$SubTotalB."', SubTotalC = '".$SubTotalC."', SubTotalD = '".$SubTotalD."', LeaveTaken = '".$LeaveTaken."', LeaveDeduction = '".$LeaveDeduction."' where payID = ".$payID; 
			$rs = $this->query($sql,0);
				
			return true;
		}


		function  getPaySalary($id=0,$EmpID,$Year,$Month){
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where p.payID=".$id):(" where e.locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($EmpID))?(" and p.EmpID=".$EmpID):("");
			$strAddQuery .= (!empty($Year))?(" and p.Year='".$Year."'"):("");
			$strAddQuery .= (!empty($Month))?(" and p.Month=".$Month."'"):("");

			$strSQLQuery = "select p.*,e.UserName,e.Email,e.JobTitle, d.Department from h_pay_salary p inner join h_employee e on p.EmpID=e.EmpID left outer join department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}


		/********** Employee Declaration Management *********/
		/*******************************************/
		function  ListDeclaration($EmpID=0,$Year,$SearchKey,$SortBy,$AscDesc){
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($EmpID))?(" where s.EmpID=".$EmpID):(" where e.locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($Year))?(" and s.Year='".$Year."'"):("");

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (s.EmpID like '".$SearchKey."'  or e.UserName like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%'  or e.JobTitle like '%".$SearchKey."%' or s.Year like '%".$SearchKey."%') " ):("");			
			}			

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." ".$AscDesc):(" order by d.depID asc, s.decID asc ");

			$strSQLQuery = "select s.*,e.UserName,e.Email,e.JobTitle, d.Department from h_declaration s inner join h_employee e on s.EmpID=e.EmpID left outer join department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function  getDeclaration($id=0,$EmpID){
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where s.decID=".$id):(" where e.locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($EmpID))?(" and s.EmpID=".$EmpID):("");

			$strSQLQuery = "select s.*,e.UserName,e.Email,e.JobTitle, d.Department from h_declaration s inner join h_employee e on s.EmpID=e.EmpID left outer join department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function deleteDeclaration($decID){

			$strSQLQuery = "select document from h_declaration where decID=".$decID; 
			$arryRow = $this->query($strSQLQuery, 1);
			
			$DecDir = 'upload/declaration/';

			if($arryRow[0]['document'] !='' && file_exists($DecDir.$arryRow[0]['document']) ){									
				unlink($DecDir.$arryRow[0]['document']);	
			}

			$sql = "delete from h_declaration where decID = ".$decID;
			$rs = $this->query($sql,0);
			if(sizeof($rs))
				return true;
			else
				return false;
		}


		function addDeclaration($arryDetails){ 
			global $Config;

			@extract($arryDetails);	 
			$sql = "insert into h_declaration(EmpID, Year, updatedDate) values('".$EmpID."', '".$Year."', '".$Config['TodayDate']."')";

			$this->query($sql, 0);
			$decID = $this->lastInsertId();

			return $decID;
		}

		function updateDeclaration($arryDetails){
			global $Config;
			@extract($arryDetails);	
			$sql = "update h_declaration set Year='".$Year."', updatedDate = '".$Config['TodayDate']."' where decID = ".$decID; 
			$rs = $this->query($sql,0);
				
			return true;
		}

		function updateDeclarationFile($document,$decID)
		{

			$strSQLQuery = "select document from h_declaration where decID=".$decID; 
			$arryRow = $this->query($strSQLQuery, 1);
			
			$DecDir = 'upload/declaration/';

			if($arryRow[0]['document'] !='' && file_exists($DecDir.$arryRow[0]['document']) ){									
				unlink($DecDir.$arryRow[0]['document']);	
			}



			$strSQLQuery = "update h_declaration set document='".$document."' where decID=".$decID;
			return $this->query($strSQLQuery, 0);
		}

		function isDeclarationExists($EmpID,$Year,$decID)
		{
			$strSQLQuery = "select decID from h_declaration where EmpID='".trim($EmpID)."' and Year='".$Year."' ";

			$strSQLQuery .= (!empty($decID))?(" and decID != ".$decID):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['decID'])) {
				return $arryRow[0]['decID'];
			} else {
				return false;
			}

		}




}

?>
