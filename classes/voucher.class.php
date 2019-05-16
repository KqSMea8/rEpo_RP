<?
class voucher extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function voucher(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addVoucher($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into voucher (code,detail,Discount,DiscountOver,Status,StartDate,EndDate) values('".addslashes($code)."', '".addslashes($detail)."','".$Discount."', '".$DiscountOver."' , '".$Status."', '".$StartDate."', '".$EndDate."')";
	
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}
	function updateVoucher($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "update voucher set code = '".addslashes($code)."', detail = '".addslashes($detail)."', Discount = '".$Discount."', DiscountOver = '".$DiscountOver."', Status = '".$Status."', StartDate = '".$StartDate."', EndDate = '".$EndDate."'  where voucherID = '".$voucherID."'"; 
		$rs = $this->query($sql,0);
			
		if(sizeof($rs))
			return true;
		else
			return false;

	}



	function getVoucher($id=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($id))?(" and voucherID = '".$id."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		$sql = "select * from voucher ".$sql." order by Discount desc" ;
		return $this->query($sql, 1);
	}

	function changeVoucherStatus($voucherID)
	{
		$sql="select * from voucher where voucherID='".$voucherID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update voucher set Status='$Status' where voucherID='".$voucherID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function deleteVoucher($voucherID)
	{
		
		$sql = "delete from voucher where voucherID = '".$voucherID."'";
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}
	
	function  ListVoucher($id=0,$SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = ' where 1 ';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and voucherID='".$id."'"):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (code like '".$SearchKey."%' )"):("");
		}


		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by voucherID ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

		$strSQLQuery = "select * from voucher ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}

	function GetVoucherCode($code)
	{
		$sql = "select * from voucher where code='".$code."' and Status='1' " ;
		return $this->query($sql, 1);
	}

	function isVoucherExists($code,$voucherID)
	{

		$strSQLQuery ="select * from voucher where LCASE(code)='".strtolower(trim($code))."'";

		$strSQLQuery .= (!empty($voucherID))?(" and voucherID != '".$voucherID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['voucherID'])) {
			return true;
		} else {
			return false;
		}


	}


}
?>
