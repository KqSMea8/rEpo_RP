<?
class group extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function group(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addGroup($arryDetails)
	{
		global $Config;
		@extract($arryDetails);	
		$sql = "insert into user_group (locationID, group_name,group_user, description, Status, AdminID, AdminType,UserName, AddedDate) values('".$_SESSION['locationID']."', '".addslashes($group_name)."','".$group_user."', '".addslashes($description)."','".addslashes($Status)."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."','".$_SESSION['UserName']."', '".$Config['TodayDate']."' )";
	
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}
	function updateGroup($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "update user_group set group_name='".addslashes($group_name)."',group_user='".addslashes($group_user)."', description = '".addslashes($description)."' ,Status = '".$Status."',AdminID = '".$_SESSION['AdminID']."',UserName = '".$_SESSION['UserName']."',AdminType = '".$_SESSION['AdminType']."',AddedDate = '".$Config['TodayDate']."'  where GroupID = '".$GroupID."'"; 
		$rs = $this->query($sql,0);
			
		if(sizeof($rs))
			return true;
		else
			return false;

	}

	function  getGroupUser($group_user='',$Status=''){
		$sql = " where 1";
		//$sql .= (!empty($id))?(" and GroupID = '".$id."'"):(" and locationID='".$_SESSION['locationID']."'");
		//$sql .= (!empty($EmpID))?(" and EmpID = '".$EmpID."'"):("");
		$sql .= ($group_user!='')?(" and e.EmpID in (".$group_user.") "):("");
                $sql .= (!empty($Status) && $Status == 1)?(" and e.Status = '".$Status."'"):("");
		$sql="select e.*,d.Department as emp_dep,d.depID from h_employee e left outer join  h_department d on e.Department=d.depID ".$sql." order by e.EmpID desc"; 
		return $arryRow = $this->query($sql);
	}

	function getGroup($id=0,$Status=0)
	{
		$sql = " where 1";
		$sql .= (!empty($id))?(" and GroupID = '".$id."'"):(" and locationID='".$_SESSION['locationID']."'");
		//$sql .= (!empty($EmpID))?(" and EmpID = '".$EmpID."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		 $sql = "select * from user_group ".$sql." order by GroupID desc" ; 
		return $this->query($sql, 1);
	}

	function changeGroupPublish($GroupID)
	{
		$sql="select * from user_group where GroupID='".$GroupID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{

			if($rs[0]['Status']==1){
				$Status=0; $_SESSION['mess_group'] = "Group has been Statused successfully.";
			}else{
				$Status=1; $_SESSION['mess_group'] = "Group has been unStatused.";
			}
				
			$sql="update user_group set Status='$Status' where GroupID='".$GroupID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function RemoveGroup($GroupID)
	{

		

		$sql = "delete from user_group where GroupID = '".$GroupID."'";
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}
	
	function  ListGroup($id=0, $SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = " where 1";
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and GroupID='".$id. "'"):(" and locationID='".$_SESSION['locationID']. "'");
		//$strAddQuery .= (!empty($EmpID))?(" and EmpID = '".$EmpID. "'"):("");
                 #if($SearchKey == "Active"){$SearchKey = 1;}else{$SearchKey = 0;}

		if($SearchKey=="Active" && ($SortBy=="Status" || $SortBy=="") ){
				$strAddQuery .= " and Status='1'"; 
		}else if($SearchKey=="Inactive" && ($SortBy=="Status" || $SortBy=="") ){
				$strAddQuery .= " and Status='0'";
		}else if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (group_name like '%".$SearchKey."%' or GroupID like '%".$SearchKey."%' )"):("");
		}


		$strAddQuery .= (!empty($SortBy))?(" order by '".$SortBy."' "):(" order by GroupID ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

		$strSQLQuery = "select * from user_group ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}

	


	function isGroupExists($group_name, $GroupID)
	{

		$strSQLQuery ="select * from user_group where LCASE(group_name)='".strtolower(trim($group_name))."'";

		$strSQLQuery .= (!empty($GroupID))?(" and GroupID != '".$GroupID. "'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['GroupID'])) {
			return true;
		} else {
			return false;
		}


	}


}
?>
