<?
class tax extends dbClass
{
	//constructor
	function tax()
	{
		$this->dbClass();
	} 
		
	////////////Filing Management Start ///// 

	function getFiling($filingID=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($filingID))?(" and filingID = '".mysql_real_escape_string($filingID)."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		$sql = "select * from h_filing ".$sql." order by filingID asc";
		return $this->query($sql, 1);
	}

	function changeFilingStatus($filingID)
	{
		if(!empty($filingID)){
			$sql="select * from h_filing where filingID='".mysql_real_escape_string($filingID)."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update h_filing set Status='".$Status."' where filingID='".mysql_real_escape_string($filingID)."'";
				$this->query($sql,0);
			}	
		}

		return true;

	}
	function updateFiling($arryDetails)
	{
		@extract($arryDetails);	
		if(!empty($filingID)){
			$sql = "update h_filing set filingStatus = '".mysql_real_escape_string($filingStatus)."'  where filingID = '".mysql_real_escape_string($filingID)."'"; 
			$rs = $this->query($sql,0);
		}
			
		return true;

	}


	function isfilingStatusExists($filingStatus,$filingID)
	{

		$strSQLQuery ="select * from h_filing where LCASE(filingStatus)='".strtolower(trim($filingStatus))."'";

		$strSQLQuery .= (!empty($filingID))?(" and filingID != '".$filingID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['filingID'])) {
			return true;
		} else {
			return false;
		}


	}

	////////////Payroll Period Start ///// 

	function getPayPeriod($periodID=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($periodID))?(" and periodID = '".mysql_real_escape_string($periodID)."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		$sql = "select * from h_pay_period ".$sql." order by periodID asc";
		return $this->query($sql, 1);
	}

	function changePayPeriodStatus($periodID)
	{
		if(!empty($periodID)){
			$sql="select * from h_pay_period where periodID='".mysql_real_escape_string($periodID)."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update h_pay_period set Status='".$Status."' where periodID='".mysql_real_escape_string($periodID)."'";
				$this->query($sql,0);
			}	
		}

		return true;

	}
	function updatePayPeriod($arryDetails)
	{
		@extract($arryDetails);	
		if(!empty($periodID)){
			$sql = "update h_pay_period set periodName = '".mysql_real_escape_string($periodName)."'  where periodID = '".mysql_real_escape_string($periodID)."'"; 
			$rs = $this->query($sql,0);
		}
			
		return true;

	}


	function isPayPeriodStatusExists($periodName,$periodID)
	{

		$strSQLQuery ="select * from h_pay_period where LCASE(periodName)='".strtolower(trim($periodName))."'";

		$strSQLQuery .= (!empty($periodID))?(" and periodID != '".$periodID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['periodID'])) {
			return true;
		} else {
			return false;
		}


	}

	function addTaxBracket($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into h_tax_bracket (Year, periodID, FilingStatus) values( '".mysql_real_escape_string($Year)."', '".mysql_real_escape_string($periodID)."', '".mysql_real_escape_string($FilingStatus)."' )";		
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;
	}

	function updateTaxBracket($arryDetails)
	{
		@extract($arryDetails);	
		if(!empty($bracketID)){
			$sql = "update h_tax_bracket set Year = '".mysql_real_escape_string($Year)."', periodID = '".mysql_real_escape_string($periodID)."', FilingStatus = '".mysql_real_escape_string($FilingStatus)."' where bracketID='".mysql_real_escape_string($bracketID)."'";
			$rs = $this->query($sql,0);
		}
			
		return true;

	}

	function getTaxBracket($id=0,$Year)
	{
		$sql = " where 1 ";
		$sql .= (!empty($id))?(" and b.bracketID = '".mysql_real_escape_string($id)."'"):("");
		$sql .= (!empty($Year))?(" and b.Year = '".mysql_real_escape_string($Year)."'"):("");
		$sql = "select b.*,p.periodName as PayrollPeriod from h_tax_bracket b left outer join h_pay_period p on b.periodID=p.periodID ".$sql." order by b.periodID asc,b.FilingStatus desc";
		return $this->query($sql, 1);
	}

	function changeTaxBracketStatus($bracketID)
	{

		if(!empty($bracketID)){
			$sql="select * from h_tax_bracket where bracketID='".mysql_real_escape_string($bracketID)."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update h_tax_bracket set Status='$Status' where bracketID='".mysql_real_escape_string($bracketID)."'";
				$this->query($sql,0);
			}	
		}

		return true;

	}

	function deleteTaxBracket($bracketID)
	{
		if(!empty($bracketID)){
			$sql = "delete from h_tax_bracket where bracketID = '".mysql_real_escape_string($bracketID)."'";
			$rs = $this->query($sql,0);
			$sql = "delete from h_tax_bracket_line where bracketID = '".mysql_real_escape_string($bracketID)."'";
			$rs = $this->query($sql,0);
		}

		return true;

	}
		
	
	function isTaxBracketExists($periodID,$Year,$FilingStatus,$bracketID)
	{

		$strSQLQuery ="select * from h_tax_bracket where periodID='".trim($periodID)."' and Year='".trim($Year)."' and FilingStatus='".trim($FilingStatus)."'";

		$strSQLQuery .= (!empty($bracketID))?(" and bracketID != '".$bracketID."'"):("");
		//echo $strSQLQuery;exit;
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['bracketID'])) {
			return true;
		} else {
			return false;
		}


	}
		
	function GetTaxBracketLine($bracketID, $id) {
		$strAddQuery='';
		$strAddQuery .= (!empty($bracketID)) ? (" and l.bracketID='" . $bracketID . "'") : ("");		   
		$strAddQuery .= (!empty($id)) ? (" and l.id='" . $id . "'") : ("");
		$strSQLQuery = "select l.* from h_tax_bracket_line l inner join h_tax_bracket t on l.bracketID = t.bracketID where 1 " . $strAddQuery . " order by l.id asc";
		return $this->query($strSQLQuery, 1);
	}


function AddUpdateTaxBracketLine($bracketID, $arryDetails) {
        global $Config;
	//echo '<pre>'; print_r($arryDetails);exit;
        extract($arryDetails);

        if(!empty($DelItem)) {
            $strSQLQuery = "delete from h_tax_bracket_line where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }

        for ($i = 1; $i <= $NumLine; $i++) {

            if(!empty($arryDetails['FromAmount' . $i]) || !empty($arryDetails['ToAmount' . $i])) {

                $id = $arryDetails['id' . $i];

		if ($id > 0) {
			$sql = "update h_tax_bracket_line set FromAmount='" . $arryDetails['FromAmount' . $i] . "', ToAmount='" . addslashes($arryDetails['ToAmount' . $i]) . "' , TaxAmount='" . addslashes($arryDetails['TaxAmount' . $i]) . "', TaxPercentage='" . addslashes($arryDetails['TaxPercentage' . $i]) . "' where id='" . $id . "'";
			$this->query($sql, 0);
		} else {
			$sql = "insert into h_tax_bracket_line (bracketID, FromAmount, ToAmount, TaxAmount, TaxPercentage) values('" . $bracketID . "','" . $arryDetails['FromAmount' . $i] . "', '" . addslashes($arryDetails['ToAmount' . $i]) . "','" . addslashes($arryDetails['TaxAmount' . $i]) . "','" . addslashes($arryDetails['TaxPercentage' . $i]) . "')";
			$this->query($sql, 0);
		}

            }
        }
	
        return true;
    }



	/*********************************/

	function addDeduction($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into h_deduction (Type, Heading, AccountID, Mandatory, Status) values( '".mysql_real_escape_string($Type)."', '".mysql_real_escape_string($Heading)."', '".mysql_real_escape_string($AccountID)."', '".mysql_real_escape_string($Mandatory)."', '".mysql_real_escape_string($Status)."')";		
		$this->query($sql, 0);
		return true;
	}

	function updateDeduction($arryDetails)
	{
		@extract($arryDetails);	
		if(!empty($dedID)){
			$sql = "update h_deduction set Type = '".mysql_real_escape_string($Type)."', Heading = '".mysql_real_escape_string($Heading)."', AccountID = '".mysql_real_escape_string($AccountID)."', Mandatory = '".mysql_real_escape_string($Mandatory)."', Status = '".mysql_real_escape_string($Status)."'  where dedID = '".mysql_real_escape_string($dedID)."'"; 
			$rs = $this->query($sql,0);
		}
			
		return true;

	}

	function deleteDeduction($dedID)
	{
		if(!empty($dedID)){
			$sql = "delete from h_deduction where dedID = '".mysql_real_escape_string($dedID)."'";
			$rs = $this->query($sql,0);
		}

		return true;

	}

	function getDeduction($id=0,$Status=0)
	{
		$sql = " where 1";
		$sql .= (!empty($id))?(" and d.dedID = '".mysql_real_escape_string($id)."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and d.Status = '".$Status."'"):("");

		$sql = "select d.*,f.AccountName,t.AccountType,f.AccountNumber from h_deduction d left outer join f_account f on d.AccountID=f.BankAccountID left outer join f_accounttype t on t.RangeFrom = f.RangeFrom ".$sql." order by d.Heading asc" ; 
		return $this->query($sql, 1);
	}

	function isDeductionHeadingExists($Heading,$dedID)
	{

		$strSQLQuery ="select * from h_deduction where LCASE(Heading)='".strtolower(trim($Heading))."'";

		$strSQLQuery .= (!empty($dedID))?(" and dedID != '".$dedID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['dedID'])) {
			return true;
		} else {
			return false;
		}


	}

	function changeDeductionStatus($dedID)
	{

		if(!empty($dedID)){
			$sql="select * from h_deduction where dedID='".mysql_real_escape_string($dedID)."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update h_deduction set Status='$Status' where dedID='".mysql_real_escape_string($dedID)."'";
				$this->query($sql,0);
			}	
		}

		return true;

	}


	/*********************************/

	function addDeductionRule($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into h_deduction_rule (Year, filingID, Heading, dedID, bracketID, Status) values( '".mysql_real_escape_string($Year)."', '".mysql_real_escape_string($filingID)."', '".mysql_real_escape_string($Heading)."', '".mysql_real_escape_string($dedID)."', '".mysql_real_escape_string($MainbracketID)."', '".mysql_real_escape_string($Status)."')";		
		$this->query($sql, 0);
		return true;
	}

	function updateDeductionRule($arryDetails)
	{
		@extract($arryDetails);	
		if(!empty($ruleID)){
			$sql = "update h_deduction_rule set Year = '".mysql_real_escape_string($Year)."', filingID = '".mysql_real_escape_string($filingID)."', Heading = '".mysql_real_escape_string($Heading)."', dedID = '".mysql_real_escape_string($dedID)."', bracketID = '".mysql_real_escape_string($MainbracketID)."', Status = '".mysql_real_escape_string($Status)."'  where ruleID = '".mysql_real_escape_string($ruleID)."'"; 
			$rs = $this->query($sql,0);
		}
			
		return true;

	}

	function deleteDeductionRule($ruleID)
	{
		if(!empty($ruleID)){
			$sql = "delete from h_deduction_rule where ruleID = '".mysql_real_escape_string($ruleID)."'";
			$rs = $this->query($sql,0);
		}

		return true;

	}



	function getDeductionRule($id=0,$Status=0)
	{
		$sql = " where 1";
		$sql .= (!empty($id))?(" and r.ruleID = '".mysql_real_escape_string($id)."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and r.Status = '".$Status."'"):("");

		#$sql = "select d.*,f.AccountName,t.AccountType from h_deduction_rule d left outer join f_account f on d.AccountID=f.BankAccountID left outer join f_accounttype t on t.AccountTypeID = f.AccountType ".$sql." order by d.Heading asc,d.Heading asc" ; 
		$sql = "select r.*, f.filingStatus, d.Heading as Deduction, p.periodName as PayrollPeriod, b.FilingStatus from h_deduction_rule r left outer join h_filing f on r.filingID=f.filingID left outer join h_deduction d on r.dedID=d.dedID left outer join h_tax_bracket b on r.bracketID=b.bracketID left outer join h_pay_period p on b.periodID=p.periodID ".$sql." order by r.Heading asc" ; 

		return $this->query($sql, 1);
	}

	function isDeductionRuleExists($Heading,$ruleID)
	{

		$strSQLQuery ="select * from h_deduction_rule where LCASE(Heading)='".strtolower(trim($Heading))."'";

		$strSQLQuery .= (!empty($ruleID))?(" and ruleID != '".$ruleID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['ruleID'])) {
			return true;
		} else {
			return false;
		}


	}

	function changeDeductionRuleStatus($ruleID)
	{

		if(!empty($ruleID)){
			$sql="select * from h_deduction_rule where ruleID='".mysql_real_escape_string($ruleID)."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update h_deduction_rule set Status='$Status' where ruleID='".mysql_real_escape_string($ruleID)."'";
				$this->query($sql,0);
			}	
		}

		return true;

	}


	/**********Tax Deduction*************/

	function addTaxDeduction($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into h_taxdeduction (SocialSecurity, Heading, Medicare, FUTA, SUTA, state_id, StateName, country_id, CountryName, TaxRate, AccountID, Status) values( '".mysql_real_escape_string($SocialSecurity)."', '".mysql_real_escape_string($Heading)."', '".mysql_real_escape_string($Medicare)."', '".mysql_real_escape_string($FUTA)."', '".mysql_real_escape_string($SUTA)."', '".mysql_real_escape_string($state_id)."', '".mysql_real_escape_string($StateName)."', '".mysql_real_escape_string($country_id)."', '".mysql_real_escape_string($CountryName)."', '".mysql_real_escape_string($TaxRate)."', '".mysql_real_escape_string($AccountID)."', '".mysql_real_escape_string($Status)."')";		
		$this->query($sql, 0);
		return true;
	}

	function updateTaxDeduction($arryDetails)
	{
		@extract($arryDetails);	
		if(!empty($dedID)){
			$sql = "update h_taxdeduction set SocialSecurity = '".mysql_real_escape_string($SocialSecurity)."', Heading = '".mysql_real_escape_string($Heading)."', Medicare = '".mysql_real_escape_string($Medicare)."', FUTA = '".mysql_real_escape_string($FUTA)."', SUTA = '".mysql_real_escape_string($SUTA)."', state_id = '".mysql_real_escape_string($state_id)."', StateName = '".mysql_real_escape_string($StateName)."', country_id = '".mysql_real_escape_string($country_id)."', CountryName = '".mysql_real_escape_string($CountryName)."', AccountID = '".mysql_real_escape_string($AccountID)."', TaxRate = '".mysql_real_escape_string($TaxRate)."', Status = '".mysql_real_escape_string($Status)."'  where dedID = '".mysql_real_escape_string($dedID)."'"; 
			$rs = $this->query($sql,0);
		}
			
		return true;

	}

	function deleteTaxDeduction($dedID)
	{
		if(!empty($dedID)){
			$sql = "delete from h_taxdeduction where dedID = '".mysql_real_escape_string($dedID)."'";
			$rs = $this->query($sql,0);
		}

		return true;


	}

	function getTaxDeduction($id=0,$Status=0)
	{
		$sql = " where 1";
		$sql .= (!empty($id))?(" and d.dedID = '".mysql_real_escape_string($id)."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and d.Status = '".$Status."'"):("");

	
		$sql = "select d.*,f.AccountName,t.AccountType from h_taxdeduction d left outer join f_account f on d.AccountID=f.BankAccountID left outer join f_accounttype t on t.RangeFrom = f.RangeFrom ".$sql." order by d.Heading asc" ; 


		return $this->query($sql, 1);
	}

	function isTaxDeductionExists($Heading,$dedID)
	{

		$strSQLQuery ="select * from h_taxdeduction where LCASE(Heading)='".strtolower(trim($Heading))."'";

		$strSQLQuery .= (!empty($dedID))?(" and dedID != '".$dedID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['dedID'])) {
			return true;
		} else {
			return false;
		}


	}

	function changeTaxDeductionStatus($dedID)
	{

		if(!empty($dedID)){
			$sql="select * from h_taxdeduction where dedID='".mysql_real_escape_string($dedID)."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update h_taxdeduction set Status='$Status' where dedID='".mysql_real_escape_string($dedID)."'";
				$this->query($sql,0);
			}	
		}

		return true;

	}






}

?>
