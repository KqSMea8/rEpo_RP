<?php

/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * 
 */

class common extends dbClass {
    /*
     * Name: headermenu
     * Description: For Superadmin  header menu
     * @param: 
     * @return: 
     */

    function headermenu($arr = array()) {
        global $Config;
        $strAddQuery = '';
        extract($arr);       
        if(!empty($AdminID))
        {
        $strAddQuery = "SELECT * FROM admin_modules WHERE Status='1'  and Parent='0'  Order by OrderBy  asc";
        return $this->get_results($strAddQuery);
        }
        return false;
    }
    
    /*
     * Name: GetHdMenuAdmin
     * Description: For Superadmin  header menu
     * @param: 
     * @return: 
     */   
    
    function GetHdMenuAdmin($Parent=0)
	 {
	$strAddQuery ="SELECT M.* FROM admin_modules as M  WHERE M.Parent!='2' and  Parent='".$Parent."' Order by OrderBy  asc"; 
         return $this->get_results($strAddQuery);
	 
	 }

	function GetStSettings($ConfigID=1){
	 	$strAddQuery = (!empty($ConfigID))?(" where ConfigID='".$ConfigID."'"):("");
		 $strSQLQuery ="select * from configuration".$strAddQuery;
		return $this->get_results($strSQLQuery);
	}

	function GetAdminSt($id=0){
	 	$strAddQuery = (!empty($id))?(" where AdminID='".mysql_real_escape_string($id)."'"):("");
		$strSQLQuery ="select * from admin".$strAddQuery;
		return $this->get_results($strSQLQuery);
	 }

	function GetSignatureSt($PageID=0,$Status=0){
		$sql = " where 1 ";
		$sql .= (!empty($PageID))?(" and PageID = '".mysql_real_escape_string($PageID)."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		$sql = "select * from contents ".$sql." order by PageID asc" ; 
		return $this->query($sql, 1);
	}

	function  GetFieldNameVal($Table)
		{
			$sql = "DESCRIBE ".$Table;
			return $this->query($sql, 1);
		}

	function GetDefaultArrayField($TableName){
		if(!empty($TableName)){	
			$arryTable = explode(",",$TableName);	
			if(!empty($arryTable[0])){
				foreach($arryTable as $Table){
					if(!empty($Table)){
						$ArrayFieldName = $this->GetFieldNameVal($Table);
						foreach($ArrayFieldName as $key=>$values){
							$arryCommanField[0][$values['Field']] = "";
						}
					}
				}
				return $arryCommanField;
			}
		}
	}

}

?>
