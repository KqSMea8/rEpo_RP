<?

class filter extends dbClass {

    var $tables;

    // consturctor 
    function brand() {
        global $configTables;
        $this->tables = $configTables;
        $this->dbClass();
    }

    function addCustomView($arryDetails) {
        global $Config;
	$setDefault = $setMetrics = $entitytype = '';
        @extract($arryDetails);
        if (!empty($setDefault)) {
            $UpdateSql = "update c_customview set  setdefault = '0'  where userid ='" . $_SESSION['UserID'] . "' and ModuleType = '" . $ModuleType . "' ";
            $this->query($UpdateSql, 0);
        }
        $sql = "insert into c_customview (viewname,setdefault,setmetrics,entitytype,status,userid,ModuleType,department) values('" . addslashes($viewName) . "', '" . $setDefault . "','" . $setMetrics . "', '" . $entitytype . "','" . $setStatus . "','" . $_SESSION['UserID'] . "','" . $ModuleType . "','".$Config['CurrentDepID']."')";

        $this->query($sql, 0);
        $lastInsertId = $this->lastInsertId();
        return $lastInsertId;
    }

    function updateCustomView($arryDetails) {
        global $Config;
	$setDefault = $setMetrics = $entitytype = $setStatus= '';

        @extract($arryDetails);
       if (!empty($setDefault)) {
            $UpdateSql = "update c_customview set  setdefault = '0'  where userid ='" . $_SESSION['UserID'] . "' and ModuleType = '" . $ModuleType . "' and department = '".$Config['CurrentDepID']."' ";
            $this->query($UpdateSql, 0);
        }

        $sql = "update c_customview set viewname='" . addslashes($viewName) . "', setdefault = '" . addslashes($setDefault) . "', setmetrics = '" . addslashes($setMetrics) . "',status = '" . $setStatus . "',ModuleType = '" . $ModuleType . "',department = '".$Config['CurrentDepID']."'  where cvid = '" . $cvid . "' and department = '".$Config['CurrentDepID']."'";
        $rs = $this->query($sql, 0);
 
        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function addColumnView($arryDetails) {
        @extract($arryDetails);


        for ($i = 1; $i <= 6; $i++) {

            if (!empty($arryDetails['column' . $i])) {
                $colum = explode(":", $arryDetails['column' . $i]);

                $sql = "insert into c_column(cvid,colindex,colname,colvalue) values('" . $cid . "','" . $i . "', '" . $colum[0] . "','" . $colum[2] . "')";

                $this->query($sql, 0);
            }
        }

        return 1;
    }

    function updateColumnView($arryDetails) {
        @extract($arryDetails);

        $sql3 = "delete from c_column where cvid = '" . $cvid . "'";
        $rs = $this->query($sql3, 0);
        for ($i = 1; $i <= 6; $i++) {

            if (!empty($arryDetails['column' . $i])) {
                $colum = explode(":", $arryDetails['column' . $i]);

                $sql = "insert into c_column(cvid,colindex,colname,colvalue) values('" . $cvid . "','" . $i . "', '" . $colum[0] . "','" . $colum[2] . "')";

                $this->query($sql, 0);
            }
        }

        return 1;
    }

    function addRule($arryDetails) {
        @extract($arryDetails);



        for ($i = 0; $i <= sizeof($fcol); $i++) {
		
		$addcolum = array();
		$addcolum[2]='';
		$addvalue='';
		if(!empty($fcol[$i])){
		    $addcolum = explode(":", $fcol[$i]);
		    $addvalue = $fval[$i];
		}



            /*             * ******************************************** */
            if ($addcolum[2] == 'AssignedTo' ||  $addcolum[2] == 'AssignTo' || $addcolum[2] == 'assignTo' || $addcolum[2] == 'assignedTo' || $addcolum[2] == 'created_id') {
                   $StrSql = "select EmpID from h_employee where LCASE(UserName) like '%" . strtolower($addvalue) . "%' "; 
                $rs = $this->query($StrSql, 1);
                if (!empty($rs[0]['EmpID'])) {
                    $addvalue = $rs[0]['EmpID'];
                } else if (!empty($fval[$i])) {
                    $addvalue = $fval[$i];
                }else{
		     $addvalue = '';
		}
            }
            /*             * ********************************************* */
 
            $addOperator = (!empty($fop[$i]))?($fop[$i]):('');
            $addCondition = "and";
            if (!empty($addcolum) && !empty($addOperator)) {
                $sql = "insert into c_advfilter(cvid,columnindex,columnname,value,comparator,column_condition) values('" . $cid . "','" . $i . "', '" . $addcolum[2] . "','" . $addvalue . "','" . $addOperator . "','" . $addCondition . "')";

                $this->query($sql, 0);
            }
        }
 
        return 1;
    }

    function UpdateRule($arryDetails) {
        @extract($arryDetails);

        $sql2 = "delete from c_advfilter where cvid = '" . $cvid . "'";
        $rs = $this->query($sql2, 0);

        for ($i = 0; $i <= sizeof($fcol); $i++) {
		$addcolum = array();
		$addcolum[2]='';
		$addvalue='';

	    if(!empty($fcol[$i])){
            	$addcolum = explode(":", $fcol[$i]);
		 $addvalue = $fval[$i];
	    }
           
            if ($addcolum[2] == 'AssignedTo' || $addcolum[2] == 'AssignTo' || $addcolum[2] == 'assignTo' || $addcolum[2] == 'assignedTo' || $addcolum[2] == 'created_id') {
                $StrSql = "select EmpID from h_employee where LCASE(UserName) like '%" . strtolower($addvalue). "%' "; 
                $rs = $this->query($StrSql, 1);
                if (!empty($rs[0]['EmpID'])) {
                    $addvalue = $rs[0]['EmpID'];
                } else {
                    $addvalue = $fval[$i];
                }
            }
 
            $addOperator = (!empty($fop[$i]))?($fop[$i]):('');
            $addCondition = "and";
            if (!empty($addcolum) && !empty($addOperator)) {
                $sql = "insert into c_advfilter(cvid,columnindex,columnname,value,comparator,column_condition) values('" . $cvid . "','" . $i . "', '" . $addcolum[2] . "','" . $addvalue . "','" . $addOperator . "','" . $addCondition . "')";

                $this->query($sql, 0);
            }
        }
 
        return 1;
    }

    function RuleEmp($EmpID) {
          global $Config;
        $StrSql = "select UserName,EmpID from h_employee where EmpID = '" . $EmpID . "' ";
        $rs = $this->query($StrSql, 1);
        if (!empty($rs[0]['EmpID'])) {
            return $addvalue = $rs[0]['UserName'];
        } else {
            return $addvalue = '';
        }
    }

    function getColumnsListByCvid($cvid, $ModuleType='') {
           global $Config;

        $sSQL = "select c_column.* from c_column";
        $sSQL .= " inner join c_customview on c_customview.cvid = c_column.cvid";
        $sSQL .= " where c_customview.cvid ='" . $cvid . "'";
        $sSQL .= (!empty($ModuleType)) ? (" and ModuleType = '" . $ModuleType . "'") : (""); 
        $sSQL .= " and c_customview.department = '".$Config['CurrentDepID']."'";
        $sSQL .= " order by c_column.colindex asc";
        return $this->query($sSQL, 1);
    }

    function getCustomView($cvid, $ModuleType) {
        global $Config;
        $sql = " where 1";
        $sql .= (!empty($cvid)) ? (" and cvid = '" . $cvid . "'") : ("");
        $sql .= (!empty($ModuleType)) ? (" and ModuleType = '" . $ModuleType . "'") : ("");
        $sql .= " and department = '".$Config['CurrentDepID']."'";
        $sql .= " and (status='1' or userid = '" . $_SESSION['UserID'] . "')";

        $sql = "select * from c_customview " . $sql . " order by cvid asc"; 
        return $this->query($sql, 1);
    }

    function getDefultView($ModuleType) {
        global $Config;
        $sql = " where 1 and setdefault = '1' ";
 
        $sql .= (!empty($Config['CurrentDepID'])) ? (" and department = '".$Config['CurrentDepID']."'") : ("");
        $sql .= (!empty($ModuleType)) ? (" and ModuleType = '" . $ModuleType . "'") : ("");

        //$sql .= " and (userid = '" . $_SESSION['UserID'] . "' or)";
				//$sql .= " and (userid = '" . $_SESSION['UserID'] . "' or)";
	 

	$sql .= (!empty($Config['CurrentDepID'])) ? (" and department = '".$Config['CurrentDepID']."'") : ("");

        $sql .= " and (status='1' or userid = '" . $_SESSION['UserID'] . "')";
        $sql = "select * from c_customview " . $sql . " order by cvid asc";
        return $this->query($sql, 1);
    }

    function getFileter($cvid) {
        global $Config;
        $sql = " where 1";
        $sql .= (!empty($cvid)) ? (" and cvid = '" . $cvid . "'") : ("");

        $sql = "select * from c_advfilter " . $sql . " order by cvid asc";
        return $this->query($sql, 1);
    }

    function getRuleView($cvid) {
        global $Config;
        $sql = " where 1";
        $sql .= (!empty($cvid)) ? (" and cvid = " . $cvid) : ("");
        $sql .= " and department = '".$Config['CurrentDepID']."'";

        $sql = "select * from c_customview " . $sql . " order by cvid desc";
        return $this->query($sql, 1);
    }

   

    function deleteFilter($cvid) {

  global $Config;
        $sql1 = "delete from c_customview where cvid = '" . $cvid . "' and department = '".$Config['CurrentDepID']."'";
        $rs = $this->query($sql1, 0);
        $sql2 = "delete from c_advfilter where cvid = '" . $cvid . "'";
        $rs = $this->query($sql2, 0);
        $sql3 = "delete from c_column where cvid = '" . $cvid . "'";
        $rs = $this->query($sql3, 0);


        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function isFilterExists($viewName, $cvid) {
            global $Config;
        $strSQLQuery = "select * from c_customview where LCASE(viewname)='" . strtolower(trim($viewName)) . "' and department = '".$Config['CurrentDepID']."'";

        $strSQLQuery .= (!empty($brandID)) ? (" and cvid != '" . $cvid . "'") : ("");

        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['cvid'])) {
            return true;
        } else {
            return false;
        }
    }

}

?>
