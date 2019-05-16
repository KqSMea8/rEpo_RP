<?
class role extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function role(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	
	function  ListRoleGroup($id=0, $SearchKey,$SortBy,$AscDesc)
	{	
		$strAddQuery = " where 1";
		$SearchKey   = strtolower(trim($SearchKey));
		if($SearchKey=="Active" && ($SortBy=="Status" || $SortBy=="") ){
				$strAddQuery .= " and Status='1'"; 
		}else if($SearchKey=="Inactive" && ($SortBy=="Status" || $SortBy=="") ){
				$strAddQuery .= " and Status='0'";
		}else if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (group_name like '%".$SearchKey."%' or GroupID like '%".$SearchKey."%' )"):("");
		}


		$strAddQuery .= (!empty($SortBy))?(" order by '".$SortBy."' "):(" order by group_name ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

		$strSQLQuery = "select * from h_role_group ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}
	
	
	
	function AddRoleGroup($arryDetails)
	{
		global $Config;
		@extract($arryDetails);	
		$sql = "insert into h_role_group (group_name, description, Status, AddedDate) values('".addslashes($group_name)."', '".addslashes($description)."','".addslashes($Status)."','".$Config['TodayDate']."' )";
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}
	
	
	function UpdateRoleGroup($arryDetails)
	{
		global $Config;
		@extract($arryDetails);	
		$sql = "update h_role_group set group_name='".addslashes($group_name)."', description = '".addslashes($description)."' ,Status = '".$Status."',AddedDate = '".$Config['TodayDate']."'  where GroupID = '".$GroupID."'"; 
		$rs = $this->query($sql,0);
			
		if(sizeof($rs))
			return true;
		else
			return false;

	}
	
	
	function getRoleGroup($id=0,$Status=0)
	{
		$sql = " where 1";
		$sql .= (!empty($id))?(" and GroupID = '".$id."'"):("");
		//$sql .= (!empty($EmpID))?(" and EmpID = '".$EmpID."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");
		 $sql = "select * from h_role_group ".$sql." order by GroupID desc" ; 
		return $this->query($sql, 1);
	}
	
	

	
	
	
	function changeRoleGroupStatus($GroupID)
	{
		$sql="select * from h_role_group where GroupID='".$GroupID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{

			if($rs[0]['Status']==1){
				$Status=0;  
			}else{
				$Status=1; 
			}
				
			$sql="update h_role_group set Status='$Status' where GroupID='".$GroupID."'";
			$this->query($sql,0);
			return true;
		}			
	}
	
	
	
		function RemoveRoleGroup($GroupID)
		{
	
			
			$sqlPermittion = "delete from permission_group where GroupID='".$GroupID."' "; 
		    $this->query($sqlPermittion,0);
			
			$sql = "delete from h_role_group where GroupID = '".$GroupID."'";
			$rs = $this->query($sql,0);
	
			if(sizeof($rs))
				return true;
			else
				return false;
	
		}
		
		function isGroupNameExists($GroupName,$GroupID)
		{
			$strSQLQuery="select GroupID,group_name from h_role_group where LCASE(group_name)='".strtolower(trim($GroupName))."'";
			$strSQLQuery .= (!empty($GroupID))?(" and GroupID != '".$GroupID."'"):("");
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['GroupID'])) {
				return true;
			} else {
				return false;
			}
		}
		
	
		
		
        function getMainModulesGroup($groupID,$Parent,$DepID){

			$OuterADD = (!empty($groupID))?(" and p.GroupID='".$groupID."'"):("");

			$strSQLQuery ="select m.*,p.GroupID,p.ViewLabel,p.ModifyLabel,p.FullLabel from admin_modules m left outer join permission_group p on (m.ModuleID=p.ModuleID ".$OuterADD.") where m.Parent='".$Parent."' and m.Default='0' and m.Status='1' and m.DepID='".$DepID."' group by m.ModuleID order by m.ModuleID asc";

			return $this->query($strSQLQuery, 1);
		}
		
		function getParentModuleIDVal($GroupID,$ModuleID){
        	
        		$OuterADD = (!empty($GroupID))?(" and pm.GroupID='".$GroupID."'"):("");
			$strSQLQuery = "select am.*,pm.GroupID, pm.ViewLabel, pm.ViewAllLabel, pm.ModifyLabel, pm.FullLabel, pm.AddLabel,pm.EditLabel, pm.DeleteLabel,pm.AssignLabel ,pm.ApproveLabel from admin_modules am left outer join permission_group pm on (am.ModuleID=pm.ModuleID ".$OuterADD.") where am.Status='1' and am.Parent = '".$ModuleID."'  Order by Case When am.OrderBy>0 Then 0 Else 1 End,am.OrderBy,am.ModuleID";


			return $this->query($strSQLQuery, 1);
		 }

		
		function UpdateGroupRolePermission($arryDetails)
		{
			global $Config;	
			extract($arryDetails);
			$Role = "Admin";

			$sql = "delete from permission_group where GroupID='".$GroupID."' "; 
			$rs = $this->query($sql,0);
			
			if($Role=="Admin"){

				if($Line>0){
					for($i=1;$i<=$Line; $i++){
						$ViewFlag = 0; $ModifyFlag = 0; $FullFlag = 0;$ModuleID=0;
						$ViewLabel = $arryDetails["ViewLabel".$i];
						$ModifyLabel = $arryDetails["ModifyLabel".$i];
						$FullLabel = $arryDetails["FullLabel".$i];

						if($ModifyLabel>0){
							$ModuleID = $ModifyLabel;
							$ModifyFlag = 1;
						}
						if($ViewLabel>0){
							$ModuleID = $ViewLabel;
							$ViewFlag = 1;
						}
						if($FullLabel>0){
							$ModuleID = $FullLabel;
							$FullFlag = 1;
						}
						
						if($ModuleID>0){
							$sql = "insert ignore into permission_group(GroupID,ModuleID,ViewLabel,ModifyLabel,FullLabel) values('".$GroupID."', '".$ModuleID."', '".$ViewFlag."', '".$ModifyFlag."', '".$FullFlag."')";
							$rs = $this->query($sql,0);
							$PermissionGiven = 1;
						}

					}
				}
			}
		
			return 1;

		}
		
		function UpdateGroupRolePermissionNew($arryDetails)
		{
			global $Config;	
			extract($arryDetails);
			$Role = "Admin";

			$sql = "delete from permission_group where GroupID='".$GroupID."' "; 
			$rs = $this->query($sql,0);
			
			if($Role=="Admin"){
 
				if($Line>0){
					for($i=1;$i<=$Line; $i++){
						$AddFlag = 0;$EditFlag = 0;$DeleteFlag = 0;$ApproveFlag = 0;$ViewFlag = 0; $ViewAllFlag = 0;  $AssignFlag = 0; $FullFlag = 0; $ModuleID=0;
						$AddLabel = $arryDetails["AddLabel".$i];
						$EditLabel = $arryDetails["EditLabel".$i];
						$DeleteLabel = $arryDetails["DeleteLabel".$i];
						$ApproveLabel = $arryDetails["ApproveLabel".$i];
						$ViewLabel = $arryDetails["ViewLabel".$i];
						$ViewAllLabel = $arryDetails["ViewAllLabel".$i];
						$AssignLabel = $arryDetails["AssignLabel".$i];
						$FullLabel = $arryDetails["FullLabel".$i];

					        if($AddLabel>0){
							$ModuleID = $AddLabel;
							$AddFlag = 1;
						}
						if($EditLabel>0){
							$ModuleID = $EditLabel;
							$EditFlag = 1;
						}
						if($DeleteLabel>0){
							$ModuleID = $DeleteLabel;
							$DeleteFlag = 1;
						}
						if($ApproveLabel>0){
							$ModuleID = $ApproveLabel;
							$ApproveFlag = 1;
						}
				
						if($ViewLabel>0){
							$ModuleID = $ViewLabel;
							$ViewFlag = 1;
						}
						if($ViewAllLabel>0){
							$ModuleID = $ViewAllLabel;
							$ViewAllFlag = 1;
						}
						if($AssignLabel>0){
							$ModuleID = $AssignLabel;
							$AssignFlag = 1;
						}
						if($FullLabel>0){
							$ModuleID = $FullLabel;
							$FullFlag = 1;
						}
						
						if($ModuleID>0){
							$sql = "insert ignore into permission_group(GroupID, ModuleID, AddLabel, EditLabel, DeleteLabel, ApproveLabel, ViewLabel, ViewAllLabel, AssignLabel,FullLabel) values('".$GroupID."', '".$ModuleID."','".$AddFlag."', '".$EditFlag."', '".$DeleteFlag."', '".$ApproveFlag."', '".$ViewFlag."', '".$ViewAllFlag."', '".$AssignFlag."', '".$FullFlag."')";
							$rs = $this->query($sql,0);
							$PermissionGiven = 1;
						}

					}
				}
			}
		
			return 1;

		}

}
?>
