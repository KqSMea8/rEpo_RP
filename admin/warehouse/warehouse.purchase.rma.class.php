<?php

class warehouse extends dbClass {

    //constructor
    function warehouse() {
        $this->dbClass();
    }

    function ListWarehouse($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {

        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where  w.WID=" . $id) : (" where 1 ");
        $strAddQuery .= (!empty($Status)) ? (" and w.Status=" . $Status) : (" ");


        if ($SearchKey == 'active' && ($SortBy == 'w.Status' || $SortBy == '')) {
            $strAddQuery .= " and w.Status=1";
        } else if ($SearchKey == 'inactive' && ($SortBy == 'w.Status' || $SortBy == '')) {
            $strAddQuery .= " and w.Status=0";
        } else
        if ($SortBy == 'WID') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (w.WID = '" . $SearchKey . "')") : ("");
        } else {

            if ($SortBy != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( w.warehouse_name like '%" . $SearchKey . "%' or w.warehouse_code like '%" . $SearchKey . "%' or l.City like '%" . $SearchKey . "%' or w.ContactName like '%" . $SearchKey . "%' or l.State like '%" . $SearchKey . "%' or l.City like '%" . $SearchKey . "%'   ) " ) : ("");
            }
        }

        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by w.WID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

        $strSQLQuery = "select w.*,l.ZipCode,l.City,l.State,l.Country, l.Address,l.country_id,l.city_id,l.state_id,l.OtherState,l.OtherCity from w_warehouse w left outer join  w_warehouse_location  l on l.WID=w.WID  " . $strAddQuery;


        return $this->query($strSQLQuery, 1);
    }

    function GetWarehouseBrief($WID) {

        $strAddQuery .= (!empty($WID)) ? (" and w.WID='" . $WID . "'") : (" ");
        $strSQLQuery = "select w.WID,w.warehouse_code,w.warehouse_name from w_warehouse w where w.Status=1 " . $strAddQuery . " order by w.warehouse_name asc";
        return $this->query($strSQLQuery, 1);
    }

    function ListInStock($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {

        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($Status)) ? (" where w.status=" . $Status) : (" ");


        if ($SearchKey == 'active' && ($SortBy == 'w.status' || $SortBy == '')) {
            $strAddQuery .= " and w.status=1";
        } else if ($SearchKey == 'inactive' && ($SortBy == 'w.status' || $SortBy == '')) {
            $strAddQuery .= " and w.status=0";
        } else
        if ($SortBy == 'stockin_id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (w.stockin_id = '" . $SearchKey . "')") : ("");
        } else {

            if ($SortBy != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( w.warehouse_name like '%" . $SearchKey . "%' or w.receiving_date like '%" . $SearchKey . "%')") : ("");
            }
        }
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by w.stockin_id ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

        //$strSQLQuery = "select w.*,l.ZipCode,l.City,l.State,l.Country, l.Address,l.country_id,l.city_id,l.state_id,l.OtherState,l.OtherCity from w_warehouse w left outer join  w_warehouse_location  l on l.WID=w.WID  ".$strAddQuery;	
        $strSQLQuery = "select w.* from w_stock_in w " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }

    /*     * ************************ Employee List ************************ */

    /* 	function  ListEmployee($id=0,$SearchKey,$SortBy,$AscDesc)
      {
      $strAddQuery = '';
      $SearchKey   = strtolower(trim($SearchKey));
      $strAddQuery .= (!empty($id))?(" where e.EmpID=".$id):(" where e.locationID=".$_SESSION['locationID']);

      if($SearchKey=='active' && ($SortBy=='e.Status' || $SortBy=='') ){
      $strAddQuery .= " and e.Status=1";
      }else if($SearchKey=='inactive' && ($SortBy=='e.Status' || $SortBy=='') ){
      $strAddQuery .= " and e.Status=0";
      }else if($SortBy != ''){
      $strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
      }else{
      $strAddQuery .= (!empty($SearchKey))?(" and (e.UserName like '%".$SearchKey."%'  or e.Email like '%".$SearchKey."%' or e.EmpID like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%' or e.Role like '%".$SearchKey."%' or e2.UserName like '%".$SearchKey."%' ) " ):("");			}

      $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by e.EmpID ");
      $strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

      $strSQLQuery = "select e.EmpID,e.Status,e.UserName,e.Email,e.Role,e.Image,d.Department,e2.UserName as SupervisorName from h_employee e left outer join  department d on e.Department=d.depID left outer join  h_employee e2 on e.Supervisor=e2.EmpID ".$strAddQuery;


      return $this->query($strSQLQuery, 1);

      }
     */
    /*     * ************************************************* */

    function ListSearchWarehouse($id = 0, $SearchKey, $SortBy, $AscDesc) {
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where l.WID=" . $id) : (" where 1 ");
        $strAddQuery .= ($_SESSION['AdminType'] != "admin") ? (" and l.AssignTo='" . $_SESSION['AdminID'] . "' ") : ("");


        $strAddQuery .= (!empty($SearchKey)) ? (" and ( l.FirstName like '%" . $SearchKey . "%' ) " ) : ("");

        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by l.WID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

        $strSQLQuery = "select l.WID,l.primary_email,l.FirstName,l.LastName,l.AssignTo,l.lead_status,l.description,l.company,d.Department,e.Role,e.UserName as AssignTo from w_warehouse l left outer join  h_employee e on e.EmpID=l.AssignTo left outer join  department d on e.Department=d.depID " . $strAddQuery;



        return $this->query($strSQLQuery, 1);
    }

    function GetDashboardWarehouse($AdminType, $EmpID) {
        $strSQLQuery = "select l.WID,l.FirstName,l.LastName,l.company,l.AssignTo from w_warehouse l ";


        $strSQLQuery .= ($AdminType != "admin") ? (" where l.AssignTo=" . $EmpID) : (" where 1 ");
        $strAddQuery .= ($_SESSION['AdminType'] != "admin") ? (" and l.AssignTo='" . $_SESSION['AdminID'] . "' ") : ("");

        $strSQLQuery .= " order by l.WID limit 0,7 ";

        //echo $strSQLQuery;

        return $this->query($strSQLQuery, 1);
    }

    function GetWarehouse($WID) {
        $strSQLQuery = "select w.*,l.ZipCode, l.Address,l.country_id,l.city_id,l.state_id,l.OtherState,l.OtherCity,l.City,l.State,l.Country from w_warehouse w left outer join  w_warehouse_location  l on l.WID=w.WID";

        $strSQLQuery .= (!empty($WID)) ? (" where w.WID=" . $WID) : (" where 1 ");
        //$strSQLQuery .= ($Opportunity>0)?(" and l.Opportunity=".$Opportunity):("");
        ///$strAddQuery .= ($_SESSION['AdminType']!="admin")?(" and l.AssignTo='".$_SESSION['AdminID']."' "):("");

        return $this->query($strSQLQuery, 1);
    }

    function GetWarehousesForprimary_email($WID) {
        $strSQLQuery = "select WID,primary_email from w_warehouse where 1";
        $strSQLQuery .= (!empty($WID)) ? (" and WID!=" . $WID) : ("");
        return $this->query($strSQLQuery, 1);
    }

    function AllWarehouses($warehouse_code) {
        $strSQLQuery = "select WID,warehouse_name,warehouse_code from w_warehouse where 1  ";

        $strSQLQuery .= (!empty($warehouse_code)) ? (" and warehouse_code='" . $warehouse_code . "'") : ("");


        $strSQLQuery .= " order by warehouse_code Asc";

        #echo $strSQLQuery; exit;


        return $this->query($strSQLQuery, 1);
    }

    function GetWarehouseDetail($id = 0) {
        $strAddQuery = '';
        $strAddQuery .= (!empty($id)) ? (" where w.WID=" . $id) : (" where 1 ");
        //$strAddQuery .= ($_SESSION['AdminType']!="admin")?(" and l.AssignTo='".$_SESSION['AdminID']."' "):("");

        $strAddQuery .= " order by w.CreateDate Desc ";

        $strSQLQuery = "select w.*,a.ZipCode,a.Address,a.country_id,a.city_id,a.state_id,a.OtherState,a.OtherCity from w_warehouse w left outer join  w_warehouse_location  a on a.WID=w.WID   " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }

    function AddWarehouse($arryDetails) {

        global $Config;

        extract($arryDetails);
        if ($main_state_id > 0)
            $OtherState = '';
        if ($main_city_id > 0)
            $OtherCity = '';
        //if(empty($Status)) $Status=1;
        //$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);

        $ipaddress = $_SERVER["REMOTE_ADDR"];
        $JoiningDatl = $Config['TodayDate'];

        $strSQLQuery = "insert into w_warehouse (warehouse_name,warehouse_code,ContactName,phone_number,mobile_number,`Default`,description,location,CreateDate,ipaddress,created_by,created_id,Status)values('" . addslashes($warehouse_name) . "','" . addslashes($warehouse_code) . "', '" . addslashes($ContactName) . "','" . addslashes($phone_number) . "','" . addslashes($mobile_number) . "','" . addslashes($Default) . "','" . addslashes($description) . "','" . $_SESSION['locationID'] . "', '" . $JoiningDatl . "', '" . $ipaddress . "', '" . addslashes($_SESSION['AdminType']) . "','" . $_SESSION['AdminID'] . "','" . $Status . "' )";

        //(WID,Address,city_id, state_id, ZipCode, country_id)values('".addslashes($warehouse_name)."' '".$main_city_id."', '".$main_state_id."','".addslashes($ZipCode)."', '".$country_id."' )";

        $this->query($strSQLQuery, 0);



        $WID = $this->lastInsertId();

        if ($WID > 0) {
            $strQuery = "insert into w_warehouse_location (WID,Address,city_id, state_id, ZipCode, country_id,OtherState,OtherCity)values('" . $WID . "','" . addslashes($Address) . "', '" . $main_city_id . "', '" . $main_state_id . "','" . addslashes($ZipCode) . "', '" . $country_id . "','" . $OtherState . "','" . $OtherCity . "' )";
            $this->query($strQuery, 0);
        }


        return $WID;
    }

    function UpdateWarehouse($arryDetails) {

        global $Config;

        extract($arryDetails);




        if ($main_city_id > 0)
            $OtherCity = '';
        if ($main_state_id > 0)
            $OtherState = '';
        //if(empty($Status)) $Status=1;type,ProductID,product_price

			$strSQLQuery = "update w_warehouse set  warehouse_name='" . addslashes($warehouse_name) . "',
			ContactName='" . addslashes($ContactName) . "',
			phone_number='" . addslashes($phone_number) . "',
			mobile_number='" . addslashes($mobile_number) . "',
			description='" . addslashes($description) . "',
			Status='" . addslashes($Status) . "',
			description='" . addslashes($description) . "',
			email='" . addslashes($email) . "'
			where WID=" . $WID;

        $this->query($strSQLQuery, 0);


 $sql = "select * from w_warehouse_location where WID='" . $WID."'";
        $rs = $this->query($sql);

                    if($rs[0]['WID'] == $WID){

			$strQuery = "update w_warehouse_location set  Address='" . addslashes($Address) . "',
			city_id='" . $main_city_id . "',
			state_id='" . $main_state_id . "',
			ZipCode='" . addslashes($ZipCode) . "',
			country_id='" . $country_id . "',
			OtherState='" . addslashes($OtherState) . "',
			OtherCity='" . addslashes($OtherCity) . "'
		        where WID='" . $WID."'"; 

}else{

 $strQuery = "insert into w_warehouse_location (WID,Address,city_id, state_id, ZipCode, country_id,OtherState,OtherCity)values('" . $WID . "','" . addslashes($Address) . "', '" . $main_city_id . "', '" . $main_state_id . "','" . addslashes($ZipCode) . "', '" . $country_id . "','" . $OtherState . "','" . $OtherCity . "' )";
            

}
                       $this->query($strQuery, 0);








        return 1;
    }

    function UpdateCountyStateCity($arryDetails, $WID) {
        extract($arryDetails);

         $strSQLQuery = "update  w_warehouse_location set Country='" . addslashes($Country) . "',  State='" . addslashes($State) . "',  City='" . addslashes($City) . "' where WID='" . $WID."'"; 
        $this->query($strSQLQuery, 0);
        return 1;
    }

    function RemoveWarehouse($WID) {

        $strSQLQuery = "delete from w_warehouse where WID=" . $WID;
        $this->query($strSQLQuery, 0);

        $strSQLQuery2 = "delete from w_warehouse_location where WID=" . $WID;
        $this->query($strSQLQuery2, 0);

        return 1;
    }

    function changeWarehouseStatus($WID) {
        $sql = "select * from w_warehouse where WID=" . $WID;
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 1)
                $Status = 0;
            else
                $Status = 1;

            $sql = "update w_warehouse set Status='$Status' where WID=" . $WID;
            $this->query($sql, 0);

            return true;
        }
    }

    function MultipleWarehouseStatus($WIDs, $Status) {
        $sql = "select WID from w_warehouse where WID in (" . $WIDs . ") ";
        $arryRow = $this->query($sql);
        if (sizeof($arryRow) > 0) {
            $sql = "update w_warehouse set Status=" . $Status . " where WID in (" . $WIDs . ")";
            $this->query($sql, 0);
        }
        return true;
    }

    function isCodeExists($warehouse_code, $WID = 0) {
        $strSQLQuery = (!empty($WID)) ? (" and WID != " . $WID) : ("");
        $strSQLQuery = "select WID from w_warehouse where warehouse_code='" . $warehouse_code . "'" . $strSQLQuery;
        $arryRow = $this->query($strSQLQuery, 1);

        if (!empty($arryRow[0]['WID'])) {
            return true;
        } else {
            return false;
        }
    }

    function isWarehouseNameExists($warehouse_name, $WID = 0) {
        $strSQLQuery = (!empty($WID)) ? (" and WID != " . $WID) : ("");
        $strSQLQuery = "select WID from w_warehouse where warehouse_name='" . $warehouse_name . "'" . $strSQLQuery;
        $arryRow = $this->query($strSQLQuery, 1);

        if (!empty($arryRow[0]['WID'])) {
            return true;
        } else {
            return false;
        }
    }

    function isBinExists($binlocation, $binid = 0, $warehouse_id) {
        $strSQLQuery = (!empty($binid)) ? (" AND binid != '" . $binid . "'") : ("");
        $strSQLQuery = "select binid from w_binlocation  where binlocation_name='" . $binlocation . "' AND warehouse_id = '" . $warehouse_id . "'" . $strSQLQuery;

        $arryRow = $this->query($strSQLQuery, 1);

        if (!empty($arryRow[0]['binid'])) {
            return true;
        } else {
            return false;
        }
    }

    function AddBinLocation($arryDetails) {
        extract($arryDetails);

        if ($warehouse_name != ""):

            $arr_data = $this->AllWarehouses($arryDetails['warehouse_name']);

            $BinCode = strtoupper(substr(md5($arryDetails['binlocation']), 0, 6));
            $strSQLQuery = "insert into w_binlocation (binid,warehouse_id,binlocation_name,status,description,warehouse_name,warehouse_code,barcode) values('','" . $arryDetails['warehouse_name'] . "', '" . addslashes($arryDetails['binlocation']) . "','" . $arryDetails['Status'] . "','" . addslashes($arryDetails['description']) . "','" . $arr_data['0']['warehouse_name'] . "','" . $arr_data['0']['warehouse_code'] . "','" . $BinCode . "')";

            $this->query($strSQLQuery, 0);

            return $binid;

        else:

            return "null";

        endif;
    }

    /* function ListStockIn($id=0,$SearchKey,$SortBy,$AscDesc,$Status)
      {
      $strAddQuery = '';
      $SearchKey   = strtolower(trim($SearchKey));
      $strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");


      if($SearchKey=='active' && ($SortBy=='w.Status' || $SortBy=='') ){
      $strAddQuery .= " and w.Status=1";
      }else if($SearchKey=='inactive' && ($SortBy=='w.Status' || $SortBy=='') ){
      $strAddQuery .= " and w.Status=0";
      }else
      if($SortBy == 'binid'){
      $strAddQuery .= (!empty($SearchKey))?(" and (w.OrderID = '".$SearchKey."')"):("");
      }else{

      if($SortBy != ''){
      $strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
      }else{
      $strAddQuery .= (!empty($SearchKey))?(" and ( w.wCode like '%".$SearchKey."%' or w.warehouse_id like '%".$SearchKey."%' ) "  ):("");
      }

      }
      $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by w.OrderID ");
      $strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

      $strSQLQuery = "select w.* from p_order w where 1".$strAddQuery;


      return $this->query($strSQLQuery, 1);

      } */

    function ListManageBin($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($Status)) ? (" and w.Status='" . $Status . "'") : (" ");
        $strAddQuery .= (!empty($id)) ? (" and w.warehouse_id='" . $id . "'") : (" ");


        if ($SearchKey == 'active' && ($SortBy == 'w.Status' || $SortBy == '')) {
            $strAddQuery .= " and w.Status=1";
        } else if ($SearchKey == 'inactive' && ($SortBy == 'w.Status' || $SortBy == '')) {
            $strAddQuery .= " and w.Status=0";
        } else
        if ($SortBy == 'binid') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (w.binid = '" . $SearchKey . "')") : ("");
        } else {

            if ($SortBy != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( w.binlocation_name like '%" . $SearchKey . "%' or w.warehouse_id like '%" . $SearchKey . "%' ) " ) : ("");
            }
        }
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by w.binid ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

        $strSQLQuery = "select w.* from w_binlocation w where 1 " . $strAddQuery;


        return $this->query($strSQLQuery, 1);
    }

    function ListStockIn($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($Status)) ? (" and w.Status=" . $Status) : (" ");


        if ($SearchKey == 'active' && ($SortBy == 'w.Status' || $SortBy == '')) {
            $strAddQuery .= " and w.Status=1";
        } else if ($SearchKey == 'inactive' && ($SortBy == 'w.Status' || $SortBy == '')) {
            $strAddQuery .= " and w.Status=0";
        } else if ($SortBy == 'binid') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (w.binid = '" . $SearchKey . "')") : ("");
        } else {
            if ($SortBy != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( w.binlocation_name like '%" . $SearchKey . "%' or w.warehouse_id like '%" . $SearchKey . "%' ) " ) : ("");
            }
        }
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by w.binid ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

        $strSQLQuery = "select w.* from w_binlocation w where 1" . $strAddQuery;


        return $this->query($strSQLQuery, 1);
    }

    function getWarehousedata($WID) {

        $strAddQuery = "where 1 ";
        $strAddQuery .= (!empty($WID)) ? ("and WID ='" . $WID . "'") : (" ");
        $strSQLQuery = "select warehouse_name,warehouse_code from w_warehouse " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }

    function getBindata($bid) {

        $strAddQuery = "where 1 ";
        $strAddQuery .= (!empty($bid)) ? ("and binid ='" . $bid . "'") : (" ");
        $strSQLQuery = "select * from w_binlocation " . $strAddQuery;


        return $this->query($strSQLQuery, 1);
    }

    function GetWarehouseBin($wCode) {

        $strAddQuery = "where 1 and Status ='1' ";
        $strAddQuery .= ($wCode != '') ? ("and warehouse_code ='" . $wCode . "'") : (" ");
        $strSQLQuery = "select * from w_binlocation " . $strAddQuery;


        return $this->query($strSQLQuery, 1);
    }

    function UpdateBinLocation($arryDetails) {
        extract($arryDetails);



        if ($warehouse_name != "") {

            $arryWarehouse = $this->AllWarehouses($warehouse_name);


            $strSQLQuery = "update  w_binlocation set binlocation_name='" . addslashes($binlocation) . "',warehouse_code = '" . addslashes($warehouse_name) . "' , status='" . addslashes($Status) . "',description = '" . addslashes($description) . "' where binid='" . $binid . "'";
        }
        $this->query($strSQLQuery, 0);
        return 1;
    }

    function RemoveBinLocation($BID) {

        $strSQLQuery = "delete from w_binlocation where binid='" . $BID . "'";
        $this->query($strSQLQuery, 0);
        return 1;
    }

    function changeBinStatus($bid) {

        $sql = "select * from w_binlocation where binid='" . $bid . "'";
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['status'] == 1)
                $Status = 0;
            else
                $Status = 1;

            $sql = "update w_binlocation set status='$Status' where binid='" . $bid . "'";
            $this->query($sql, 0);
            return true;
        }
    }

    /*     * *********************************** */

    function GenerateShipping($InvoiceData) {
        global $Config;
        //$arryDetails = $this->GetSaleOrderForInvoice($InvoiceData['OrderID']);
        //extract($arryDetails);

        $SelectQury = "select InvoiceID,TotalAmount,Freight,ShippedDate,wCode,wName,InvoiceComment,SaleID from s_order where InvoiceID ='" . $InvoiceData['ShipInVoice'] . "' ";
        $rs = $this->query($SelectQury);


        $InvoiceID = $rs['InvoiceID'];
        $SaleID = $rs['SaleID'];
        $TotalInvoiceAmount = $rs['TotalAmount'];
        $Freight = $rs['Freight'];

        $ShippedDate = $rs['ShippedDate'];
        $wCode = $rs['wCode'];
        $wName = $rs['wName'];
        $InvoiceComment = $rs['InvoiceComment'];

        //if(empty($CustomerCurrency)) $CustomerCurrency =  $Config['Currency'];

        $strSQLQuery = "INSERT INTO w_outbound SET Module = 'Invoice',RefID='" . $InvoiceData['ShipInVoice'] . "',  OrderID ='" . $InvoiceData['OrderID'] . "', shipping = '" . $shipping . "',createDate='" . $Config['TodayDate'] . "', CreatedBy = '" . addslashes($_SESSION['UserName']) . "', AdminID='" . $_SESSION['AdminID'] . "',AdminType='" . $_SESSION['AdminType'] . "',OrderType = 'Sales',ShipDate = '" . $InvoiceData['ShipDate'] . "',transport = '" . $InvoiceData['transport'] . "',packageCount = '" . $InvoiceData['packageCount'] . "',PackageType = '" . $InvoiceData['PackageType'] . "',Weight = '" . $InvoiceData['Weight'] . "' ";

        $this->query($strSQLQuery, 0);
        $OrdID = $this->lastInsertId();

        if (empty($shipID)) {
            $ShipInvoiceID = 'SHIP000' . $OrdID;
        }

        $sql = "UPDATE w_outbound SET shipID='" . $ShipInvoiceID . "',order_id='" . $rs['OrderID'] . "' WHERE id='" . $OrdID . "'";
        $this->query($sql, 0);
        return $OrdID;
    }

    function AddShippingItem($order_id, $arryDetails) {
        global $Config;
        extract($arryDetails);

        for ($i = 1; $i <= $NumLine; $i++) {
            if (!empty($arryDetails['pickQty' . $i])) {

                $id = $arryDetails['id' . $i];

                $sql = "insert into w_outbound_item(shipID,InvoiceID,ref_id, item_id, sku, pickQty, qty_invoiced,binid ) values('" . $order_id . "','" . $ShipInVoice . "', '" . $id . "','" . addslashes($arryDetails['item_id' . $i]) . "', '" . addslashes($arryDetails['sku' . $i]) . "','" . addslashes($arryDetails['pickQty' . $i]) . "', '" . addslashes($arryDetails['ordered_qty' . $i]) . "','" . addslashes($arryDetails['bin' . $i]) . "')";
                $this->query($sql, 0);

                /* $sqlSelect = "select qty_received, qty_invoiced from s_order_item where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
                  $arrRow = $this->query($sqlSelect, 1);
                  $qtyreceived = $arrRow[0]['qty_received'];
                  $qtyreceived = $qtyreceived+$arryDetails['qty'.$i];

                  $qtyinvoiced = $arrRow[0]['qty_invoiced'];
                  $qtyinvoiced = $qtyinvoiced+$arryDetails['qty'.$i];

                  $sqlupdate = "update s_order_item set qty_received = '".$qtyreceived."',qty_invoiced = '".$qtyinvoiced."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
                  $this->query($sqlupdate, 0); */
            }
        }

        return true;
    }

    /*     * ************************Transfer Shipping********************** */

    function GenerateTranferShipping($InvoiceData) {
        global $Config;
        //$arryDetails = $this->GetSaleOrderForInvoice($InvoiceData['OrderID']);
        //extract($arryDetails);

        $SelectQury = "select transferNo,to_WID,from_WID,transferDate,transfer_reason,transferID from inv_transfer where transferNo ='" . $InvoiceData['ShipOrder'] . "' ";
        $rs = $this->query($SelectQury);


        $Transfer_No = $rs['transferNo'];
        $transfer_id = $rs['transferID'];
        //$TotalInvoiceAmount = $rs['TotalAmount'];
        //$Freight = $rs['Freight'];

        $transferDate = $rs['transferDate'];
        echo $to_WID = $rs['to_WID'];
        $from_WID = $rs['from_WID'];
        $transfer_reason = $rs['transfer_reason'];

        //if(empty($CustomerCurrency)) $CustomerCurrency =  $Config['Currency'];

        $strSQLQuery = "INSERT INTO w_outbound SET Module = 'Transfer',RefID='" . $InvoiceData['ShipOrder'] . "',  OrderID ='" . $InvoiceData['OrderID'] . "', shipping = '" . $shipping . "',createDate='" . $Config['TodayDate'] . "', CreatedBy = '" . addslashes($_SESSION['UserName']) . "', AdminID='" . $_SESSION['AdminID'] . "',AdminType='" . $_SESSION['AdminType'] . "',OrderType = 'Transfer',ShipDate = '" . $InvoiceData['ShipDate'] . "',transport = '" . $InvoiceData['transport'] . "',packageCount = '" . $InvoiceData['packageCount'] . "',PackageType = '" . $InvoiceData['PackageType'] . "',Weight = '" . $InvoiceData['Weight'] . "' ";
        $this->query($strSQLQuery, 0);
        $OrdID = $this->lastInsertId();

        if (empty($shipID)) {
            $ShipInvoiceID = 'SHIP000' . $OrdID;
        }

        $sql = "UPDATE w_outbound SET shipID='" . $ShipInvoiceID . "',to_warehouse ='" . $to_WID . "',from_warehouse = '" . $from_WID . "',order_id='" . $transfer_id . "' WHERE id='" . $OrdID . "'";
        $this->query($sql, 0);
        return $OrdID;
    }

    function AddTranferShippingItem($order_id, $arryDetails) {
        global $Config;
        extract($arryDetails);

        for ($i = 1; $i <= $NumLine; $i++) {
            if (!empty($arryDetails['pickQty' . $i])) {

                $id = $arryDetails['id' . $i];

                $sql = "insert into w_outbound_item(shipID,InvoiceID,ref_id, item_id, sku, pickQty, qty_invoiced,binid ) values('" . $order_id . "','" . $ShipOrder . "', '" . $id . "','" . addslashes($arryDetails['item_id' . $i]) . "', '" . addslashes($arryDetails['sku' . $i]) . "','" . addslashes($arryDetails['pickQty' . $i]) . "', '" . addslashes($arryDetails['ordered_qty' . $i]) . "','" . addslashes($arryDetails['bin' . $i]) . "')";
                $this->query($sql, 0);

                /* $sqlSelect = "select qty_received, qty_invoiced from s_order_item where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
                  $arrRow = $this->query($sqlSelect, 1);
                  $qtyreceived = $arrRow[0]['qty_received'];
                  $qtyreceived = $qtyreceived+$arryDetails['qty'.$i];

                  $qtyinvoiced = $arrRow[0]['qty_invoiced'];
                  $qtyinvoiced = $qtyinvoiced+$arryDetails['qty'.$i];

                  $sqlupdate = "update s_order_item set qty_received = '".$qtyreceived."',qty_invoiced = '".$qtyinvoiced."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
                  $this->query($sqlupdate, 0); */
            }
        }

        return true;
    }

    function GetShipDetail($arryDetails) {

        global $Config;

        $sql = "SELECT id,shipID,Module,RefID,OrderType,ShipDate,transport,CreatedBy,AdminID,AdminType FROM `w_outbound`  WHERE deleted = '0' order by shipID asc";
        $arryDB = $this->query($sql, 1);

        return $arryDB;
    }

    function RemoveShip($id) {

        $sql = "update `w_outbound` set deleted=1 where id='" . $id . "'";
        $this->query($sql, 0);
        return 1;
    }

    /*     * ******************************************* */

    /*     * *************Sales Return ************************* */

    function AddReceiptOrder($arryDetails) {

        global $Config;

        extract($arryDetails);




        $strSQLQuery = "INSERT INTO w_receipt SET Module = 'Receipt',ModuleType ='Sales', OrderID='" . $OrderID . "', SaleID ='" . $SaleID . "', QuoteID = '" . $QuoteID . "',InvoiceID ='" . $InvoiceID . "',ReturnID = '" . $ReturnID . "',ReceiptStatus = '" . $ReceiptStatus . "' ,packageCount = '" . addslashes($packageCount) . "',transport = '" . addslashes($transport) . "',Weight = '" . $Weight . "', ReceiptComment = '" . addslashes($ReceiptComment) . "',TotalReceiptAmount = '" . addslashes($TotalAmount) . "', CreatedBy = '" . addslashes($_SESSION['UserName']) . "', AdminID='" . $_SESSION['AdminID'] . "',AdminType='" . $_SESSION['AdminType'] . "',PostedDate='" . $Config['TodayDate'] . "',UpdatedDate='" . $Config['TodayDate'] . "',ReceiptDate='" . $ReceiptDate . "', wCode ='" . $warehouse . "'";


        //echo "=>".$strSQLQuery;exit;
        $this->query($strSQLQuery, 0);
        $RECPTID = $this->lastInsertId();

        if (empty($ReceiptNo)) {

            $ReceiptNo = 'RCPT000' . $RECPTID;
        }

        $sql = "UPDATE w_receipt SET ReceiptNo='" . $ReceiptNo . "' WHERE ReceiptID='" . $RECPTID . "'";
        $this->query($sql, 0);

        return $RECPTID;
    }

    function GetReceipt($OrderID, $ReceiptID, $Module) {
        $strAddQuery .= (!empty($OrderID)) ? (" and o.ReceiptID=" . $OrderID) : ("");
        $strAddQuery .= (!empty($ReceiptID)) ? (" and o.ReceiptNo='" . $ReceiptID . "'") : ("");
        $strAddQuery .= (!empty($Module)) ? (" and o.Module='" . $Module . "'") : ("");
        $strSQLQuery = "select o.*,s.* from w_receipt o left outer join s_order s on o.OrderID = s.OrderID  where 1" . $strAddQuery . " order by o.OrderID desc";
        return $this->query($strSQLQuery, 1);
    }

    function GetQtyReturned($id) {
        $sql = "select sum(i.qty_returned) as QtyReturned,sum(i.qty_receipt) as QtyReceipt from s_receipt_item i where i.OrderID='" . $id . "' group by i.ReceiptID";
        $rs = $this->query($sql);
        return $rs;
    }

    function RecieptOrder($arryDetails) {
        global $Config;
        extract($arryDetails);

        $strSQLQuery = "select o.*,e.Email as CreatedByEmail from s_order o left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType!='admin') where 1 and o.OrderID='" . $ReturnOrderID . "' ";
        $arrySale = $this->query($strSQLQuery, 1);


        $arrySale[0]["PrefixSale"] = "RCPT";
        $arrySale[0]["warehouse"] = $warehouse;
        $arrySale[0]["ReceiptDate"] = $ReceiptDate;
        $arrySale[0]["ReceiptStatus"] = $ReceiptStatus;
        $arrySale[0]["packageCount"] = $packageCount;
        $arrySale[0]["transport"] = $transport;
        $arrySale[0]["PackageType"] = $PackageType;
        $arrySale[0]["Weight"] = $Weight;
        $arrySale[0]["ReceiptComment"] = $ReceiptComment;



        $receipt_id = $this->AddReceiptOrder($arrySale[0]);


        /*         * ****** Item Updation for Return *********** */
        #$arryItem = $this->GetSaleItem($ReturnOrderID);

        $strQuery = "select i.*,t.RateDescription,c.valuationType as evaluationType,itm.ItemID from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join inv_items itm on i.item_id=itm.ItemID left outer join inv_categories c on c.CategoryID =itm.CategoryID where 1 and i.OrderID='" . $ReturnOrderID . "' order by i.id asc";
        $arryItem = $this->query($strQuery, 1);



        $NumLine = sizeof($arryItem);

        for ($i = 1; $i <= $NumLine; $i++) {
            $Count = $i - 1;
            $id = $arryDetails['id' . $i];



            $qty_receipt = $arryDetails['qty' . $i];
            $SerialNumbers = $arryDetails['serial_value' . $i];


            if (!empty($id) && $arryDetails['qty' . $i] > 0) {

                if (!empty($Recipt_ID)) {


                    if ($id > 0) {
                        /* $sql = "update w_receipt_item set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', on_hand_qty='".addslashes($arryDetails['on_hand_qty'.$i])."',qty_receipt = qty_receipt+'".addslashes($arryDetails['qty'.$i])."', price='".addslashes($arryDetails['price'.$i])."', tax_id='".$arryTax[0]."', tax='".$arryTax[1]."', amount='".addslashes($arryDetails['amount'.$i])."',Taxable='".addslashes($arryDetails['item_taxable'.$i])."'  where id=".$id; 
                          }else{ */

                        $sql = "insert into w_receipt_item(ReceiptID,OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned,qty_receipt , price, tax_id, tax, amount, Taxable, req_item,SerialNumbers) values('" . $receipt_id . "','" . $arryItem[$Count]["OrderID"] . "', '" . $arryItem[$Count]["item_id"] . "' , '" . $arryDetails['id' . $i] . "', '" . $arryItem[$Count]["sku"] . "', '" . $arryItem[$Count]["description"] . "', '" . $arryItem[$Count]["on_hand_qty"] . "', '" . $arryItem[$Count]["qty"] . "', '" . addslashes($arryDetails['received_qty' . $i]) . "', '" . addslashes($arryDetails['received_qty' . $i]) . "','" . $arryItem[$Count]["qty_returned"] . "','" . $qty_receipt . "', '" . $arryItem[$Count]["price"] . "', '" . $arryItem[$Count]["tax_id"] . "', '" . $arryItem[$Count]["tax"] . "', '" . $arryDetails['amount' . $i] . "', '" . $arryItem[$Count]["Taxable"] . "', '" . addslashes($arryItem[$Count]["req_item"]) . "','" . $SerialNumbers . "')";
                    }
                } else {

                    $sql = "insert into w_receipt_item(ReceiptID,OrderID, item_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned,qty_receipt , price, tax_id, tax, amount, Taxable, req_item,SerialNumbers) values('" . $receipt_id . "','" . $arryItem[$Count]["OrderID"] . "', '" . $arryItem[$Count]["item_id"] . "' ,  '" . $arryItem[$Count]["sku"] . "', '" . $arryItem[$Count]["description"] . "', '" . $arryItem[$Count]["on_hand_qty"] . "', '" . $arryItem[$Count]["qty"] . "', '" . addslashes($arryDetails['received_qty' . $i]) . "', '" . addslashes($arryDetails['received_qty' . $i]) . "','" . $arryItem[$Count]["qty_returned"] . "','" . $qty_receipt . "', '" . $arryItem[$Count]["price"] . "', '" . $arryItem[$Count]["tax_id"] . "', '" . $arryItem[$Count]["tax"] . "', '" . $arryDetails['amount' . $i] . "', '" . $arryItem[$Count]["Taxable"] . "', '" . addslashes($arryItem[$Count]["req_item"]) . "','" . $SerialNumbers . "')";
                }

                $this->query($sql, 0);

                //Update Item
                $sqlSelect = "select qty_receipt from w_receipt_item where OrderID = '" . $ReturnOrderID . "' and item_id = '" . $arryDetails['item_id' . $i] . "'";
                $arrRow = $this->query($sqlSelect, 1);
                $qty_receipt = $arrRow[0]['qty_receipt'];
                $qty_receipt = $qty_receipt + $arryDetails['qty' . $i];
                $sqlupdate = "update w_receipt_item set qty_receipt = '" . $qty_receipt . "' where id = '" . $arrRow[0]['id'] . "' and item_id = '" . $arryDetails['item_id' . $i] . "'";
                $this->query($sqlupdate, 0);
                //end code
            }
        }


        return $order_id;
    }

    function GetSaleReceiptItem($OrderID, $SalesID) {
        $strAddQuery .= (!empty($OrderID)) ? (" and i.ReceiptID='" . $OrderID . "'") : ("");
        $strAddQuery .= (!empty($SalesID)) ? (" and i.OrderID='" . $SalesID . "'") : ("");
        //$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
        $strSQLQuery = "select i.*,itm.ItemID,c.valuationType as evaluationType from w_receipt_item i  left outer join inv_items itm on i.item_id=itm.ItemID left outer join inv_categories c on c.CategoryID =itm.CategoryID where 1" . $strAddQuery . " order by i.id asc";

#echo $strSQLQuery; exit;
        return $this->query($strSQLQuery, 1);
    }

    function GetSumQtyReturned($id) {
        $sql = "select sum(i.qty_returned) as QtyReturned,sum(r.qty_receipt) as QtyReceipt from s_order_item i left outer join w_receipt_item r on i.item_id=r.item_id where i.OrderID='" . $id . "' group by i.OrderID";
        $rs = $this->query($sql);
        return $rs;
    }

    function GetSumQtyReceipt($id, $item_id) {
        $sql = "select sum(r.qty_receipt) as Qty_Receipt from w_receipt_item  r  where r.OrderID='" . $id . "'  and r.item_id = '" . $item_id . "'  group by r.item_id  order by id asc";
        $rs = $this->query($sql);
        return $rs[0]['Qty_Receipt'];
    }

    function ListReceipt($arryDetails) {

        global $Config;
        extract($arryDetails);

        $strAddQuery = "where w.Module='Receipt' ";
        $SearchKey = strtolower(trim($key));

        $strAddQuery .= ($_SESSION['vAllRecord'] != 1) ? (" and (s.SalesPersonID='" . $_SESSION['AdminID'] . "' or s.AdminID='" . $_SESSION['AdminID'] . "') ") : ("");

        $strAddQuery .= (!empty($so)) ? (" and w.SaleID='" . $so . "'") : ("");
        $strAddQuery .= (!empty($FromDateRtn)) ? (" and w.ReceiptDate>='" . $FromDateRtn . "'") : ("");
        $strAddQuery .= (!empty($ToDateRtn)) ? (" and w.ReceiptDate<='" . $ToDateRtn . "'") : ("");

        if ($SearchKey == 'yes' && ($sortby == 's.ReturnPaid' || $sortby == '')) {
            $strAddQuery .= " and s.ReturnPaid='Yes'";
        } else if ($SearchKey == 'no' && ($sortby == 'o.ReturnPaid' || $sortby == '')) {
            $strAddQuery .= " and s.ReturnPaid!='Yes'";
        } else if ($sortby != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '%" . $SearchKey . "%')") : ("");
        } else {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (w.ReceiptStatus like '%" . $SearchKey . "%' or w.ReceiptNo like '%" . $SearchKey . "%' or  s.ReturnID like '%" . $SearchKey . "%'  or s.InvoiceID like '%" . $SearchKey . "%'  or s.SaleID like '%" . $SearchKey . "%'  or s.CustomerName like '%" . $SearchKey . "%' or s.CustCode like '%" . $SearchKey . "%' or s.TotalAmount like '%" . $SearchKey . "%' or s.CustomerCurrency like '%" . $SearchKey . "%' ) " ) : ("");
        }
        $strAddQuery .= (!empty($CustCode)) ? (" and s.CustCode='" . mysql_real_escape_string($CustCode) . "'") : ("");


        $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by w.ReceiptID ");
        $strAddQuery .= (!empty($asc)) ? ($asc) : (" desc");

        $strSQLQuery = "select w.*,s.OrderDate, s.ReturnDate, s.OrderID, s.SaleID,s.ReturnID,s.InvoiceID, s.CustCode, s.CustomerName, s.TotalAmount, s.CustomerCurrency,s.ReturnPaid,s.SalesPerson  from w_receipt w  left outer join s_order s on w.OrderID = s.OrderID " . $strAddQuery;
        #echo $strSQLQuery; exit;
        return $this->query($strSQLQuery, 1);
    }

    function RemoveReceipt($OrderID) {

        $strSQLQuery = "delete from w_receipt where ReceiptID='" . $OrderID . "'";
        $this->query($strSQLQuery, 0);

        $strSQLQuery = "delete from w_receipt_item where ReceiptID='" . $OrderID . "'";
        $this->query($strSQLQuery, 0);

        return 1;
    }

    function UpdateSalesReturn($arryDetails) {
        global $Config;
        extract($arryDetails);

        $strSQLQuery = "update w_receipt set ReceiptStatus='" . $ReceiptStatus . "', ReceiptComment='" . addslashes($ReceiptComment) . "', UpdatedDate = '" . $Config['TodayDate'] . "'
			where ReceiptID=" . $rcptID . "";
        $this->query($strSQLQuery, 0);

        return 1;
    }

    function CheckReceipt($OrderID) {

        $sql = "select ReceiptID from w_receipt  where OrderID='" . $OrderID . "'  ";
        $rs = $this->query($sql);
        if (!empty($rs[0]['ReceiptID'])) {
            $receiptID = $rs[0]['ReceiptID'];
        } else {
            $receiptID = '';
        }
        return $receiptID;
    }

    /*     * ************ Start of Internal Order ************** */

    function getAssemblyItemsIntoWarehouse($warehouseID, $arryDetails, $NumLine, $ArrayWarehouse) {
        global $Config;
        extract($arryDetails);

        for ($i = 1; $i <= $NumLine; $i++) {
            $count = $i - 1;
            extract($arryDetails[$i]);
            //exit;
            /* if($id>0){
              $sql = "update inv_item_assembly set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', wastageQty='".addslashes($arryDetails['Wastageqty'.$i])."', asm_qty='".addslashes($arryDetails['qty'.$i])."', unit_cost='".addslashes($arryDetails['price'.$i])."', total_Assemble_cost='".addslashes($arryDetails['amount'.$i])."'  where id=".$id;
              }else{ */
            $sql = "insert into w_production_item (WP_id,id,asmID,bomID,bom_refID, item_id, sku, description,valuationType,available_qty, qty,unit_cost, total_bom_cost,serial) values('" . $warehouseID . "','" . $arryDetails[$count]['id'] . "','" . $asmID . "','" . $bomID . "','" . $bom_refID . "','" . $item_id . "', '" . $sku . "', '" . $description . "','" . $valuationType . "','" . $available_qty . "', '" . $qty . "','" . $unit_cost . "','" . $total_bom_cost . "','" . $serial . "')";
            //echo $sql . "<br />";

            $this->query($sql, 0);
            /* $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand-'" . $arryDetails['qty' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
              $this->query($strSQLItem, 0);
              /* } */
        }
        //exit;
        //  return true;
    }

    function getAssemblyIntoWarehouse($arryDetails, $formData) {
        global $Config;
        extract($arryDetails);

        if ($formData['Status'] == 0) {

            $Status_name = 'parked';
        } elseif ($formData['Status'] == 1) {
            $Status_name = 'cancelled';
        } elseif ($formData['Status'] == 2) {
            $Status_name = 'completed';
        }

        $arryTime = explode(" ", $Config['TodayDate']);

        if (empty($Currency))
            $Currency = $Config['Currency'];
        $strSQLQuery = "insert into w_production(asmID,asm_code,RecieveNo,warehouse_code,assembly_qty,item_id,Sku,description,unit_cost,total_cost,on_hand_qty,warehouse_qty,packageCount,PackageType,Weight,asmDate,UpdatedDate,created_by,created_id,Status) 
					values('" . $asmID . "','" . $asm_code . "','" . $formData['RecieveNo'] . "','" . $arryDetails['warehouse_code'] . "','" . $assembly_qty . "','" . $item_id . "', '" . $Sku . "','" . $description . "','" . $price . "', '" . $TotalValue . "', '" . $on_hand_qty . "','" . $formData['warehouse_qty'] . "','" . $formData['packageCount'] . "','" . $formData['PackageType'] . "','" . $formData['Weight'] . "','" . $arryDetails['asmDate'] . "','" . $arryTime[0] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['AdminID'] . "','" . $Status . "')";

        $this->query($strSQLQuery, 0);
        $materialID = $this->lastInsertId();
        if ($materialID > 0) {

            //$rs=$this->getPrefix(1);
            //PrefixAD = "REC";
            //$ModuleIDValue = $PrefixAD . '-000' . $materialID;
            $strSQL = "update w_production set Status='" . $formData['Status'] . "',warehouse_code='" . $formData['warehouse'] . "',Status_name='" . $Status_name . "',UpdatedDate='" . $formData['RecieveDate'] . "' where WP_id=" . $materialID;
            $this->query($strSQL, 0);
        }

        if (empty($formData['RecieveNo'])) {
            if ($materialID > 0) {
                $PrefixAD = "REC";
                $ModuleIDValue = $PrefixAD . '-000' . $materialID;
                $strSQL = "update w_production set RecieveNo='" . $ModuleIDValue . "' where WP_id=" . $materialID;
                $this->query($strSQL, 0);
            }
        }

        return $materialID;
    }

    function ListAssemble($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {

        global $Config;
        $arryTime = explode("", $Config['TodayDate']);
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.asmID=" . $id) : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and a.Status='".$Status."'"):(" ");
        if ($SortBy == 'id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (a.asmID = '" . $SearchKey . "')") : ("");
        } else {
            if ($SortBy != '') {
                if ($SortBy == 'a.Status') {
                    if ($SearchKey == 'completed') {
                        $SearchKey = 2;
                    } elseif ($SearchKey == 'parked') {
                        $SearchKey = 0;
                    } elseif ($SearchKey == 'cancel') {
                        $SearchKey = 1;
                    } else {
                        $SearchKey = $SearchKey;
                    }
                    $strAddQuery .= " and a.Status like '%" . $SearchKey . "%'";
                } else {
                    $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
                }
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( a.asm_code like '%" . $SearchKey . "%' or a.Sku like '%" . $SearchKey . "%' or i.description like '%" . $SearchKey . "%' or a.warehouse_code like '%" . $SearchKey . "%' ) " ) : ("");
            }
        }
        $strAddQuery .= (!empty($Status)) ? (" and a.Status=" . $Status) : ("");
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by a.UpdatedDate ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");
        $strSQLQuery = "select a.* from w_production a left outer join  w_production_item  i on i.asmID=a.asmID  " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }

    function ListProduction($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {

        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.asmID=" . $id) : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and a.Status='".$Status."'"):(" ");
        if ($SortBy == 'id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (a.asmID = '" . $SearchKey . "')") : ("");
        } else {
            if ($SortBy != '') {
                if ($SortBy == 'a.Status') {
                    if ($SearchKey == 'completed') {
                        $SearchKey = 2;
                    } elseif ($SearchKey == 'parked') {
                        $SearchKey = 0;
                    } elseif ($SearchKey == 'cancel') {
                        $SearchKey = 1;
                    } else {
                        $SearchKey = $SearchKey;
                    }
                    $strAddQuery .= " and a.Status like '%" . $SearchKey . "%'";
                } else {
                    $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
                }
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( a.asm_code like '%" . $SearchKey . "%' or a.Sku like '%" . $SearchKey . "%' or a.warehouse_code like '%" . $SearchKey . "%' or p.warehouse_name like '%" . $SearchKey . "%' or a.Status_Name like '%" . strtolower($SearchKey) . "%' ) " ) : ("");
            }
        }
        //echo "<br/>".$strAddQuery."<br />";
        $strAddQuery .= (!empty($Status)) ? (" and a.Status=" . $Status) : ("");
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " " . $AscDesc) : (" order by a.UpdatedDate Desc,a.WP_id ");
        //$strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");
        $strSQLQuery = "select a.*,p.warehouse_name,p.warehouse_code from w_production a left outer join w_warehouse p on BINARY a.warehouse_code = BINARY p.warehouse_code " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }

    function checkAssembly($asm_code) {
        //@extract($arryDetails);
        $sql = "select * from w_production where asmID='" . $asm_code . "' and assembly_qty = warehouse_qty";
        return $this->query($sql, 1);
    }

    function GetAssembleStock($asmID) {
        $strAddQuery .= (!empty($asmID)) ? (" and asmID=" . $asmID) : ("");
        $strSQLQuery = "select * from w_production_item where 1" . $strAddQuery . " order by id asc";
        return $this->query($strSQLQuery, 1);
    }

    /* function UpdateInternalOrder($asmID)	{
      $strAddQuery .= (!empty($asmID)) ? (" and asmID=" . $asmID) : ("");
      $strSQLQuery = "select * from w_production_item where 1" . $strAddQuery . " order by id asc";
      return $this->query($strSQLQuery, 1);
      }
     */

    function updateAssemblyItemsIntoWarehouse($arryDetails, $NumLine, $formdata) {
        @extract($arryDetails);
        if ($formdata['Status'] == 0) {
            $Status_name = 'parked';
        } elseif ($formdata['Status'] == 1) {
            $Status_name = 'cancelled';
        } elseif ($formdata['Status'] == 1) {
            $Status_name = 'completed';
        }
        $sqler = "update w_production set Status='" . $formdata['Status'] . "',Status_name='" . $Status_name . "',warehouse_qty='" . $formdata['warehouse_qty'] . "',UpdatedDate='" . $formdata['RecieveDate'] . "',warehouse_code='" . $formdata['warehouse'] . "',packageCount='" . $formdata['packageCount'] . "',PackageType='" . $formdata['PackageType'] . "',Weight='" . $formdata['Weight'] . "' where asmID='" . $asmID . "'";
        $this->query($sqler, 0);
        for ($i = 1; $i <= $NumLine; $i++) {
            $count = $i - 1;
            $id = $arryDetails['id' . $i];
            if ($id > 0) {
                $sql = "update w_production_item set warehouse_qty='" . $arryDetails['warehouse_qty' . $i] . "' where asmID='" . $asmID . "' and id='" . $id . "'";
            }
            $this->query($sql, 0);
        }
    }

    function RemoveAssemble($id) {

        $strSQLQuery = "DELETE FROM w_production WHERE asmID = " . $id;
        $rs = $this->query($strSQLQuery, 0);
        $strSQLQuery2 = "DELETE FROM w_production_item WHERE asmID = " . $id;
        $this->query($strSQLQuery2, 0);
        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function isRecieveExists($RecieveID, $InternalID) {
        $strSQLQuery = (!empty($InternalID)) ? (" and asmID != '" . $InternalID . "'") : ("");
        $strSQLQuery = "select WP_id from w_production where 1 and RecieveNo='" . trim($RecieveID) . "'" . $strSQLQuery;
        $arryRow = $this->query($strSQLQuery, 1);

        if (!empty($arryRow[0]['WP_id'])) {

            return true;
        } else {

            return false;
        }
    }

    function getBinByWarehouse($warehouse_id) {
        $strAddQuery = (!empty($warehouse_id)) ? (" where s.warehouse_id='" . $warehouse_id . "'") : ("");
        $strSQLQuery = "select s.* from w_binlocation s inner join w_warehouse c on s.warehouse_id=c.WID" . $strAddQuery . " ";
        return $this->query($strSQLQuery, 1);
    }

    /*     * ************ End of Internal Order *********** */

    /*     * ******************************Internal Order ---- Pick & Put Quantity ---- ******************************** */

    function getAssemblyIntoBin($arryDetails, $formData) {
        global $Config;
        extract($arryDetails);
        if ($formData['Status'] == 0) {
            $Status_name = 'parked';
        } elseif ($formData['Status'] == 1) {
            $Status_name = 'cancelled';
        } elseif ($formData['Status'] == 2) {
            $Status_name = 'completed';
        }
        $arryTime = explode(" ", $Config['TodayDate']);

        if (empty($Currency))
            $Currency = $Config['Currency'];
        $strSQLQuery = "insert into w_bin(WP_id,warehouse_id,bin_id,bin_qty,Status) 
					values('" . $arryDetails['WP_id'] . "','" . $formData['warehouse_id'] . "','" . $formData['Bin'] . "','" . $formData['bin_qty'] . "','" . $Status . "')";
        $this->query($strSQLQuery, 0);
        $materialID = $this->lastInsertId();
        if ($materialID > 0) {

            //$rs=$this->getPrefix(1);
            //PrefixAD = "REC";
            //$ModuleIDValue = $PrefixAD . '-000' . $materialID;
            $strSQL = "update w_bin set Status='" . $formData['Status'] . "' where id=" . $materialID;
            $this->query($strSQL, 0);
        }

        /*
          if(empty($formData['RecieveNo']))	 {
          if ($materialID > 0)	{
          $PrefixAD = "REC";
          $ModuleIDValue = $PrefixAD . '-000' . $materialID;
          $strSQL = "update w_production set RecieveNo='" . $ModuleIDValue . "' where WP_id=" . $materialID;
          $this->query($strSQL, 0);
          }
          }
         */
        return $materialID;
    }

    function updateAssemblyIntoBin($formdata, $NumLine, $arryDetails, $editID) {

        @extract($arryDetails);
        if ($formdata['Status'] == 0) {
            $Status_name = 'parked';
        } elseif ($formdata['Status'] == 1) {
            $Status_name = 'cancelled';
        } elseif ($formdata['Status'] == 1) {
            $Status_name = 'completed';
        }
        $sqler = "update w_bin set warehouse_id ='" . $formdata['warehouse_id'] . "',bin_id='" . $formdata['main_bin_id'] . "',bin_qty='" . $formdata['bin_qty'] . "',Status='" . $formdata['Status'] . "' where id='" . $editID . "'";
        $this->query($sqler, 0);
    }

    function ListBinProduction($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {

        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.WP_id=" . $id) : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and a.Status='".$Status."'"):(" ");
        if ($SortBy == 'id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (a.WP_id = '" . $SearchKey . "')") : ("");
        } else {
            if ($SortBy != '') {
                if ($SortBy == 'a.Status') {
                    if ($SearchKey == 'completed') {
                        $SearchKey = 2;
                    } elseif ($SearchKey == 'parked') {
                        $SearchKey = 0;
                    } elseif ($SearchKey == 'cancel') {
                        $SearchKey = 1;
                    } else {
                        $SearchKey = $SearchKey;
                    }
                    $strAddQuery .= " and a.Status like '%" . $SearchKey . "%'";
                } else {
                    $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
                }
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( a.asm_code like '%" . $SearchKey . "%' or a.Sku like '%" . $SearchKey . "%' or a.description like '%" . $SearchKey . "%' or a.warehouse_code like '%" . $SearchKey . "%' or p.warehouse_name like '%" . $SearchKey . "%' or s.Status_Name like '%" . strtolower($SearchKey) . "%' or a.RecieveNo like '%" . strtolower($SearchKey) . "%' or a.UpdatedDate like '%" . strtolower($SearchKey) . "%' or a.warehouse_qty like '%" . $SearchKey . "%' or p.warehouse_name like '%" . strtolower($SearchKey) . "%' ) " ) : ("");
            }
        }
        //echo "<br/>".$strAddQuery."<br />";
        $strAddQuery .= (!empty($Status)) ? (" and a.Status=" . $Status) : ("");
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " " . $AscDesc) : (" order by a.UpdatedDate Desc ");
        //$strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");
        $strSQLQuery = "select a.*,s.Status_Name,p.warehouse_name,p.warehouse_code from w_production a left outer join w_status_attribute s on BINARY a.Status= BINARY s.Status left outer join w_warehouse p on BINARY a.warehouse_code = BINARY p.warehouse_code " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }

    function ListBinAssembly($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {

        global $Config;
        $arryTime = explode("", $Config['TodayDate']);
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.id=" . $id) : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and a.Status='".$Status."'"):(" ");
        if ($SortBy == 'id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (a.WP_id = '" . $SearchKey . "')") : ("");
        } else {
            if ($SortBy != '') {
                if ($SortBy == 'a.Status') {
                    if ($SearchKey == 'completed') {
                        $SearchKey = 2;
                    } elseif ($SearchKey == 'parked') {
                        $SearchKey = 0;
                    } elseif ($SearchKey == 'cancel') {
                        $SearchKey = 1;
                    } else {
                        $SearchKey = $SearchKey;
                    }
                    $strAddQuery .= " and a.Status like '%" . $SearchKey . "%'";
                } elseif (!empty($SearchKey)) {
                    if ($SortBy == 'a.Status') {
                        $attr = " , s.Status_Name ";
                        $strINQuery = "left outer join w_status_attribute s on a.Status=s.Status ";
                    } elseif ($SortBy == 'a.warehouse_id') {
                        $attr = " , w.warehouse_name";
                        $strINQuery = "left outer join w_warehouse w on a.warehouse_id=w.WID ";
                        $strAddQuery .= (!empty($SearchKey)) ? (" and ( w.warehouse_name like '%" . $SearchKey . "%') " ) : ("");
                    } elseif ($SortBy == 'a.bin_id') {
                        $attr = " , b.binlocation_name ";
                        $strINQuery = "left outer join w_binlocation b on a.bin_id=b.binid ";
                        $strAddQuery .= (!empty($SearchKey)) ? (" and ( b.binlocation_name like '%" . $SearchKey . "%') " ) : ("");
                    } else {
                        $attr = '';
                        $strINQuery = '';
                    }
                } else {
                    $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
                }
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( p.asm_code like '%" . $SearchKey . "%' or p.RecieveNo like '%" . $SearchKey . "%' or p.Sku like '%" . $SearchKey . "%' or p.description like '%" . $SearchKey . "%') " ) : ("");
            }
        }
        $strAddQuery .= (!empty($Status)) ? (" and a.Status=" . $Status) : ("");
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " " . $AscDesc) : (" order by p.UpdatedDate desc,a.id desc ");
        //$strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");
        $strSQLQuery = "select a.id,a.Status as bin_Status,a.bin_qty,a.warehouse_id,a.bin_id,p.* " . $attr . " from w_bin a " . $strINQuery . " left outer join  w_production p on a.WP_id=p.WP_id " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }

    function RemoveAssembleFromBin($id) {
        $strSQLQuery = "DELETE FROM w_bin WHERE id = " . $id;
        $rs = $this->query($strSQLQuery, 0);
        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function checkAssemblyInBin($WP_id) {
        //@extract($arryDetails);
        $sql = "select * from w_bin where WP_id='" . $WP_id . "'";
        return $this->query($sql, 1);
    }

    function getWarehousebyID($warehouse_id) {
        $strSQLQuery = "select * from w_warehouse where WID=" . $warehouse_id;
        return $this->query($strSQLQuery, 1);
    }

    /*     * ******************************End of Internal Order ---- Pick & Put Quantity ---- ******************************** */
    /*     * ******************************Transportation------Manage Cargo----- ************************* */

    function AddCargo($arryDetails) {

        global $Config;

        extract($arryDetails);
        //if($main_state_id>0) $OtherState = '';
        //if($main_city_id>0) $OtherCity = '';
        //if(empty($Status)) $Status=1;
        //$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);

        $ipaddress = $_SERVER["REMOTE_ADDR"];
        $JoiningDatl = $Config['TodayDate'];

        $strSQLQuery = "insert into w_cargo(SuppCode,ReleaseDate,ReleaseBy,SalesPersonID,ReleaseTo,CustCode,CustID,CarrierName,TransactionRef,TransportMode,PackageMode,ShipmentNo,PackageLoad,FirstName,LastName,LicenseNo,Address,Mobile,Status)values('" . addslashes($SuppCode) . "','" . addslashes($ReleaseDate) . "', '" . addslashes($SalesPerson) . "','" . addslashes($SalesPersonID) . "','" . addslashes($CustCode) . "','" . addslashes($CustID) . "','" . addslashes($CustomerName) . "','" . addslashes($CarrierName) . "','" . addslashes($TransactionRef) . "','" . addslashes($TransportMode) . "','" . addslashes($PackageMode) . "', '" . addslashes($ShipmentNo) . "','" . addslashes($PackageLoad) . "', '" . addslashes($FirstName) . "','" . addslashes($LastName) . "','" . addslashes($LicenseNo) . "','" . addslashes($Address) . "','" . addslashes($Mobile) . "','" . $Status . "' )";
        //echo $strSQLQuery;
        //exit;
        //(WID,Address,city_id, state_id, ZipCode, country_id)values('".addslashes($warehouse_name)."' '".$main_city_id."', '".$main_state_id."','".addslashes($ZipCode)."', '".$country_id."' )";

        $this->query($strSQLQuery, 0);



        $WID = $this->lastInsertId();

        if ($WID > 0) {
            if (empty($SuppCode)) {
                $ReleaseNo = 'RNOOO' . $WID;
                $strQuery1 = "update w_cargo set SuppCode='" . $ReleaseNo . "' where cargo_id=" . $WID;
                $this->query($strQuery1, 0);
            }
        }


        return $WID;
    }

    function ListCargo($arryDetails) {
        extract($arryDetails);

        $strAddQuery = '';
        $SearchKey = strtolower(trim($key));
        #$strAddQuery .= (!empty($id))?(" where s.SuppID='".$id."'"):(" where s.locationID=".$_SESSION['locationID']);
        $strAddQuery .= (!empty($id)) ? (" where s.cargo_id='" . $id . "'") : (" where 1");

        if ($SearchKey == 'active' && ($sortby == 's.Status' || $sortby == '')) {
            $strAddQuery .= " and s.Status=1";
        } else if ($SearchKey == 'inactive' && ($sortby == 's.Status' || $sortby == '')) {
            $strAddQuery .= " and s.Status=0";
        } else if ($sortby != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '%" . $SearchKey . "%')") : ("");
        } else {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (s.SuppCode like '%" . $SearchKey . "%' or s.CompanyName like '%" . $SearchKey . "%' or ab.Country like '%" . $SearchKey . "%' or ab.State like '%" . $SearchKey . "%' or ab.City like '%" . $SearchKey . "%' or s.Currency like '%" . $SearchKey . "%' or s.ReleaseBy like '%" . $SearchKey . "%' or s.ReleaseNo like '%" . $SearchKey . "%' or s.CarrierName like '%" . $SearchKey . "%' or s.ShipmentNo like '%" . $SearchKey . "%' or a.StatusName like '%" . $SearchKey . "%') " ) : ("");
        }
        $strAddQuery .= ($Status > 0) ? (" and s.Status='" . $Status . "'") : ("");

        $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by s.cargo_id ");
        $strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");

        $strSQLQuery = "select * from w_cargo s left outer join w_status_attribute a on s.Status=a.Status" . $strAddQuery;


        return $this->query($strSQLQuery, 1);
    }

    function GetCargo($cargo_id, $SuppCode, $Status) {
        $strSQLQuery = "select s.* from w_cargo s ";

        #$strSQLQuery .= (!empty($SuppID))?(" where s.SuppID='".$SuppID."'"):(" and s.locationID=".$_SESSION['locationID']);
        $strSQLQuery .= (!empty($cargo_id)) ? (" where s.cargo_id='" . mysql_real_escape_string($cargo_id) . "'") : (" where 1");
        $strSQLQuery .= (!empty($SuppCode)) ? (" and s.SuppCode='" . mysql_real_escape_string($SuppCode) . "'") : ("");
        $strSQLQuery .= ($Status > 0) ? (" and s.Status='" . $Status . "'") : ("");

        return $this->query($strSQLQuery, 1);
    }

    function UpdateCargo($arryDetails) {
        global $Config;
        extract($arryDetails);
        //print_r($arryDetails);
        if (!empty($SuppID)) {
            if ($Status == '')
                $Status = 1;
            $UserName = trim($FirstName . ' ' . $LastName);
            $strSQLQuery = "update w_cargo set ReleaseDate='" . addslashes($ReleaseDate) . "', ReleaseBy='" . addslashes($SalesPerson) . "',CustCode='" . addslashes($CustCode) . "',CustID='" . addslashes($CustID) . "',ReleaseTo='" . addslashes($CustomerName) . "', CarrierName='" . addslashes($CarrierName) . "' , PackageLoad='" . addslashes($PackageLoad) . "', FirstName='" . addslashes($FirstName) . "', LastName='" . addslashes($LastName) . "', Address='" . addslashes($Address) . "', Mobile = '" . $Mobile . "',Status='" . $Status . "' where cargo_id='" . mysql_real_escape_string($SuppID) . "'";
            //echo $strSQLQuery;exit;
            $this->query($strSQLQuery, 0);
        }

        return 1;
    }

    function changeCargoStatus($SuppID) {
        if (!empty($SuppID)) {
            $sql = "select cargo_id,Status from w_cargo where cargo_id='" . $SuppID . "'";
            $rs = $this->query($sql);
            if (sizeof($rs)) {
                if ($rs[0]['Status'] == 1)
                    $Status = 0;
                else
                    $Status = 1;

                $sql = "update w_cargo set Status='$Status' where cargo_id='" . mysql_real_escape_string($SuppID) . "'";
                $this->query($sql, 0);

                return true;
            }
        }
    }

    function RemoveCargo($del_id) {
        if ($del_id > 0) {
            $sql = "delete from w_cargo where cargo_id='" . $del_id . "'";

            $this->query($sql, 0);
        }
        return true;
    }

    function isSuppCodeExists($SuppCode, $editID) {
        $strSQLQuery = (!empty($editID)) ? (" and cargo_id != '" . $editID . "'") : ("");
        $strSQLQuery = "select cargo_id from w_cargo where 1 and SuppCode='" . trim($SuppCode) . "'" . $strSQLQuery;
        $arryRow = $this->query($strSQLQuery, 1);

        if (!empty($arryRow[0]['cargo_id'])) {

            return true;
        } else {

            return false;
        }
    }

    function isEmailExists($Email, $editID) {
        $strSQLQuery = (!empty($editID)) ? (" and cargo_id != '" . $editID . "'") : ("");
        $strSQLQuery = "select cargo_id from w_cargo where 1 and LicenseNo='" . trim($Email) . "'" . $strSQLQuery;
        $arryRow = $this->query($strSQLQuery, 1);

        if (!empty($arryRow[0]['cargo_id'])) {

            return true;
        } else {

            return false;
        }
    }
    
    
    
    /*****/
     
    /*********************** RMA Action Query  ***************************/
			
	function getWareHouseByAction($Action) {  
      $strSQLQuery = "select a.id,a.name_id,a.action,b.binid,b.warehouse_id,b.binlocation_name from w_rma_action_value a left join w_binlocation b on a.name_id = b.warehouse_id WHERE a.action='".$Action."'";
	    $results= $this->query($strSQLQuery);
	    return $results;
        
    }   
			
		
			function UpdateRMAAction($arryDetails,$id) {
		
				extract($arryDetails);
		
		
		
				$strSQLQuery = "update  w_rma_action_value set name_id = '" . addslashes($rma) . "' where id='" . $id . "'";
		
				$this->query($strSQLQuery, 0);
				return 1;
		
		
			}
			function getrmadata($id) {
		
				$strAddQuery .= (!empty($id)) ? (" where id ='" . $id . "'") : (" ");
				$strSQLQuery = "select * from w_rma_action_value" . $strAddQuery;
		
				return $this->query($strSQLQuery, 1);
			}
		
			function AllWarehousesaction() {
				//$strSQLQuery = "select * from w_rma_action";
		
				#echo $strSQLQuery; exit;
		
		        $strSQLQuery = "select WID,warehouse_name,warehouse_code from w_warehouse";
				return $this->query($strSQLQuery, 1);
			}
		
			function Allviewaction() {
				$strSQLQuery = "select a.id,a.name_id,a.action,b.warehouse_name from w_rma_action_value a left join w_warehouse b on a.name_id = b.WID";
				return $this->query($strSQLQuery, 1);
			}
			
			
			
         /*********************** End RMA Action Query  ***************************/
    
    

    /*     * ******************************End of Transportation------Manage Cargo----- ************************* */
    
    /*     * ******************************************* */

    /*     * ************* Purchase Return ************************* */

    function AddPurchaseReceiptOrder($arryDetails) {

        global $Config;

        extract($arryDetails);




        $strSQLQuery = "INSERT INTO w_receiptpo SET Module = 'Receipt',ModuleType ='Purchase', OrderID='" . $OrderID . "', PurchaseID ='" . $PurchaseID . "', QuoteID = '" . $QuoteID . "',InvoiceID ='" . $InvoiceID . "',ReturnID = '" . $ReturnID . "',ReceiptStatus = '" . $ReceiptStatus . "' ,packageCount = '" . addslashes($packageCount) . "',transport = '" . addslashes($transport) . "',Weight = '" . $Weight . "', ReceiptComment = '" . addslashes($ReceiptComment) . "',TotalReceiptAmount = '" . addslashes($TotalAmount) . "', CreatedBy = '" . addslashes($_SESSION['UserName']) . "', AdminID='" . $_SESSION['AdminID'] . "',AdminType='" . $_SESSION['AdminType'] . "',PostedDate='" . $Config['TodayDate'] . "',UpdatedDate='" . $Config['TodayDate'] . "',ReceiptDate='" . $ReceiptDate . "', wCode ='" . $warehouse . "'";


        //echo "=>".$strSQLQuery;exit;
        $this->query($strSQLQuery, 0);
        $RECPTID = $this->lastInsertId();

        if (empty($ReceiptNo)) {

            $ReceiptNo = 'RCPT000' . $RECPTID;
        }

        $sql = "UPDATE w_receiptpo SET ReceiptNo='" . $ReceiptNo . "' WHERE ReceiptID='" . $RECPTID . "'";
        $this->query($sql, 0);

        return $RECPTID;
    }

    function GetPurchaseReceipt($OrderID, $ReceiptID, $Module) {
        $strAddQuery .= (!empty($OrderID)) ? (" and o.ReceiptID=" . $OrderID) : ("");
        $strAddQuery .= (!empty($ReceiptID)) ? (" and o.ReceiptNo='" . $ReceiptID . "'") : ("");
        $strAddQuery .= (!empty($Module)) ? (" and o.Module='" . $Module . "'") : ("");
        $strSQLQuery = "select o.*,p.ConversionRate,p.Restocking as RmaRestocking from w_receiptpo o  left outer join p_order p on o.OrderID = p.OrderID  where 1" . $strAddQuery . " order by o.OrderID desc";
        return $this->query($strSQLQuery, 1);
    }
    
    
    function GetPORma($OrderID,$ReturnID, $Module) {
	 $strAddQuery .= (!empty($OrderID)) ? (" and o.OrderID=" . $OrderID) : ("");
        $strAddQuery .= (!empty($ReturnID)) ? (" and o.ReturnID='" . $ReturnID."'") : ("");
        $strAddQuery .= (!empty($Module)) ? (" and o.Module='" . $Module . "'") : ("");
        $strSQLQuery = "select o.* from p_order o where 1" . $strAddQuery . " order by o.OrderID desc";
        return $this->query($strSQLQuery, 1);
    }

    function GetPurchaseQtyReturned($id) {
        $sql = "select sum(i.qty_returned) as QtyReturned,sum(i.qty_receipt) as QtyReceipt from p_receipt_item i where i.OrderID='" . $id . "' group by i.ReceiptID";
        $rs = $this->query($sql);
        return $rs;
    }
    
    /*********************** Old function *****************************/

    function PurchaseRecieptOrder($arryDetails) {
    	//echo "<pre>";print_r($arryDetails);
    	//die;
        global $Config;
        extract($arryDetails);

        $strSQLQuery = "select o.*,e.Email as CreatedByEmail from p_order o left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType!='admin') where 1 and o.OrderID='" . $ReturnOrderID . "' ";
        $arryPurchase = $this->query($strSQLQuery, 1);


        $arryPurchase[0]["PrefixPO"] = "RCPT";
        $arryPurchase[0]["warehouse"] = $warehouse;
        $arryPurchase[0]["ReceiptDate"] = $ReceiptDate;
        $arryPurchase[0]["ReceiptStatus"] = $ReceiptStatus;
        $arryPurchase[0]["packageCount"] = $packageCount;
        $arryPurchase[0]["transport"] = $transport;
        $arryPurchase[0]["PackageType"] = $PackageType;
        $arryPurchase[0]["Weight"] = $Weight;
        $arryPurchase[0]["ReceiptComment"] = $ReceiptComment;



      $receipt_id = $this->AddPurchaseReceiptOrder($arryPurchase[0]);

       
      #echo "<pre>";print_r($receipt_id);exit;

        /*         * ****** Item Updation for Return *********** */
      //$arryItem = $this->GetPurchaseItem($OrderID);

        $strQuery = "select i.*,t.RateDescription,c.valuationType as evaluationType from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join inv_items itm on i.item_id=itm.ItemID left outer join inv_categories c on c.CategoryID =itm.CategoryID where 1 and i.OrderID='" . $ReturnOrderID . "' order by i.id asc";

        $arryItem = $this->query($strQuery, 1);
        
        $NumLine = sizeof($arryItem);

        for ($i = 1; $i <= $NumLine; $i++) {
            $Count = $i - 1;
           $id = $arryDetails['id' . $i];

           //$RecieptID_val = $arryItem[$Count]['ReceiptID'];
            //echo $id;
           //$Rec = $arryDetails['qty_received' . $i];
           //echo $Rec; 
           //exit;
           
            $qty_receipt = $arryDetails['qty' . $i];
            $SerialNumbers = $arryDetails['serial_value' . $i];
            

            if (!empty($id) && $arryDetails['qty' . $i] > 0) {

                if (!empty($receipt_id)) {


                    if ($id > 0) {
                        /* $sql = "update w_receipt_item set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', on_hand_qty='".addslashes($arryDetails['on_hand_qty'.$i])."',qty_receipt = qty_receipt+'".addslashes($arryDetails['qty'.$i])."', price='".addslashes($arryDetails['price'.$i])."', tax_id='".$arryTax[0]."', tax='".$arryTax[1]."', amount='".addslashes($arryDetails['amount'.$i])."',Taxable='".addslashes($arryDetails['item_taxable'.$i])."'  where id=".$id; 
                          
                         }else{ */
                    	
                    

                     $sql = "insert into w_receiptpo_item(ReceiptID,OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned,qty_receipt , price, tax_id, tax, amount, Taxable, req_item,SerialNumbers) values('" . $receipt_id . "','" . $arryItem[$Count]["OrderID"] . "', '" . $arryItem[$Count]["item_id"] . "' , '" . $arryDetails['id' . $i] . "', '" . $arryItem[$Count]["sku"] . "', '" . $arryItem[$Count]["description"] . "', '" . $arryItem[$Count]["on_hand_qty"] . "', '" . $arryItem[$Count]["qty"] . "', '" . addslashes($arryDetails['received_qty' . $i]) . "', '" . addslashes($arryDetails['received_qty' . $i]) . "','" . $arryItem[$Count]["qty_returned"] . "','" . $qty_receipt . "', '" . $arryItem[$Count]["price"] . "', '" . $arryItem[$Count]["tax_id"] . "', '" . $arryItem[$Count]["tax"] . "', '" . $arryDetails['amount' . $i] . "', '" . $arryItem[$Count]["Taxable"] . "', '" . addslashes($arryItem[$Count]["req_item"]) . "','" . $SerialNumbers . "')";
               }
                } else {
                	
                

                  $sql = "insert into w_receiptpo_item(ReceiptID,OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned,qty_receipt , price, tax_id, tax, amount, Taxable, req_item,SerialNumbers) values('" . $receipt_id . "','" . $arryItem[$Count]["OrderID"] . "', '" . $arryItem[$Count]["item_id"] . "' , '".$arryDetails['id' . $i]."' '" . $arryItem[$Count]["sku"] . "', '" . $arryItem[$Count]["description"] . "', '" . $arryItem[$Count]["on_hand_qty"] . "', '" . $arryItem[$Count]["qty"] . "', '" . addslashes($arryDetails['received_qty' . $i]) . "', '" . addslashes($arryDetails['received_qty' . $i]) . "','" . $arryItem[$Count]["qty_returned"] . "','" . $qty_receipt . "', '" . $arryItem[$Count]["price"] . "', '" . $arryItem[$Count]["tax_id"] . "', '" . $arryItem[$Count]["tax"] . "', '" . $arryDetails['amount' . $i] . "', '" . $arryItem[$Count]["Taxable"] . "', '" . addslashes($arryItem[$Count]["req_item"]) . "','" . $SerialNumbers . "')";
                    
                }

                $this->query($sql, 0);

                //Update Item
                $sqlSelect = "select qty_receipt from w_receiptpo_item where OrderID = '" . $ReturnOrderID . "' and item_id = '" . $arryDetails['item_id' . $i] . "'";
                $arrRow = $this->query($sqlSelect, 1);
               //s $qty_receipt = $arrRow[0]['qty_receipt'];
                //$qty_receipt = $qty_receipt + $arryDetails['qty' . $i];
               // $sqlupdate = "update w_receiptpo_item set qty_receipt = '" . $qty_receipt . "' where id = '" . $arrRow[0]['id'] . "' and item_id = '" . $arryDetails['item_id' . $i] . "'";
               // $this->query($sqlupdate, 0);
                //end code
                
                $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand-'" . $arryDetails['qty' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";

               $this->query($strSQLItem, 0);
               
              
                
            }
        }


        return $order_id;
    }
    
    /*************************************/
    
    function RecieptOrderPO($arryDetails) {

        global $Config;
        extract($arryDetails);
        $strSQLQuery = "select o.*,e.Email as CreatedByEmail from p_order o left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType!='admin') where 1 and o.OrderID='" . $ReturnOrderID . "' ";
        $arryPurchase = $this->query($strSQLQuery, 1);

	$arryPurchase[0]["PrefixSale"] = "RCPT";
	$arryPurchase[0]["warehouse"] = $warehouse;
	$arryPurchase[0]["ReceiptDate"] = $ReceivedDate;
	//$arryPurchase[0]["ReceivedDate"] = $ReceivedDate;
	$arryPurchase[0]["ReceiptStatus"] = $ReceiptStatus;
	$arryPurchase[0]["packageCount"] = $packageCount;
	$arryPurchase[0]["transport"] = $transport;
	$arryPurchase[0]["PackageType"] = $PackageType;
	$arryPurchase[0]["Weight"] = $Weight;
	$arryPurchase[0]["ReceiptComment"] = $ReceiptComment;
	$arryPurchase[0]["TotalAmount"] = $TotalAmount;
	$arryPurchase[0]["Freight"] = $Freight;
	$arryPurchase[0]["Restocking_fee"] = $Restocking_fee;
	$arryPurchase[0]["Restocking"] = $ReStocking;
	$arryPurchase[0]["taxAmnt"] = $taxAmnt; 
 
        $receipt_id = $this->AddReceiptOrderPO($arryPurchase[0]);	
	$strQuery = "select i.*,t.RateDescription,c.valuationType as evaluationType from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join inv_items itm on i.item_id=itm.ItemID left outer join inv_categories c on c.CategoryID =itm.CategoryID where 1 and i.OrderID='" . $ReturnOrderID . "' order by i.id asc";    
	$arryItem = $this->query($strQuery, 1);
       
        $NumLine = sizeof($arryItem);
        for ($i = 1; $i <= $NumLine; $i++) {
		$Count = $i - 1;
		$id = $arryDetails['id' . $i];

		$qty_receipt = $arryDetails['qty' . $i];
		$SerialNumbers = $arryDetails['serial_value' . $i];

		$SQ_RECT =  $arryItem[$Count]['qty_received'];            
		$UpdatePurchaseStatus = ($arryDetails['remainQty' . $i])-($arryDetails['qty' . $i]);

		$Type = $arryItem[$Count]['Type'];
		$Action = $arryItem[$Count]['Action'];
		$Reason = $arryItem[$Count]['Reason'];
            if (!empty($id) && $arryDetails['qty' . $i] > 0) {
            	
                if (!empty($receipt_id)) {

                    if ($id > 0) {
                       
                       $sql = "insert into w_receiptpo_item(ReceiptID,OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned,qty_receipt , price, tax_id, tax, amount, Taxable, req_item,SerialNumbers,`Condition`,Type,Action,Reason) values('" . $receipt_id . "','" . $arryItem[$Count]["OrderID"] . "', '" . $arryItem[$Count]["item_id"] . "' , '" . $arryDetails['id' . $i] . "', '" . $arryItem[$Count]["sku"] . "', '" . $arryItem[$Count]["description"] . "', '" . $arryItem[$Count]["on_hand_qty"] . "', '" . $arryItem[$Count]["qty"] . "', '" . $SQ_RECT . "', '" . addslashes($arryDetails['received_qty' . $i]) . "','" . $arryItem[$Count]["qty_returned"] . "','" . $qty_receipt . "', '" . $arryItem[$Count]["price"] . "', '" . $arryItem[$Count]["tax_id"] . "', '" . $arryItem[$Count]["tax"] . "', '" . $arryDetails['amount' . $i] . "', '" . $arryItem[$Count]["Taxable"] . "', '" . addslashes($arryItem[$Count]["req_item"]) . "','" . $SerialNumbers . "' ,'" . addslashes($arryDetails['Condition' . $i]) . "', '" . $Type . "' , '" . $Action . "' , '" . $Reason . "')";
                     // echo "=>".$sql;exit;
                    }
                } else {
                    $sql = "insert into w_receiptpo_item(ReceiptID,OrderID, item_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned,qty_receipt , price, tax_id, tax, amount, Taxable, req_item,SerialNumbers,`Condition`,Type,Action,Reason) values('" . $receipt_id . "','" . $arryItem[$Count]["OrderID"] . "', '" . $arryItem[$Count]["item_id"] . "' ,  '" . $arryItem[$Count]["sku"] . "', '" . $arryItem[$Count]["description"] . "', '" . $arryItem[$Count]["on_hand_qty"] . "', '" . $arryItem[$Count]["qty"] . "', '" . $SQ_RECT . "', '" . addslashes($arryDetails['received_qty' . $i]) . "','" . $arryItem[$Count]["qty_returned"] . "','" . $qty_receipt . "', '" . $arryItem[$Count]["price"] . "', '" . $arryItem[$Count]["tax_id"] . "', '" . $arryItem[$Count]["tax"] . "', '" . $arryDetails['amount' . $i] . "', '" . $arryItem[$Count]["Taxable"] . "', '" . addslashes($arryItem[$Count]["req_item"]) . "','" . $SerialNumbers . "' , ,'" . addslashes($arryDetails['Condition' . $i]) . "', '" . $Type . "' , '" . $Action . "' , '" . $Reason . "')";
                   // echo "=>=>".$sql;exit;
                }
                $this->query($sql, 0);

		/*
                //Update Item
                $sqlSelect = "select id,ReceiptID,qty_receipt from w_receiptpo_item where OrderID = '" . $ReturnOrderID . "' and item_id = '" . $arryDetails['item_id' . $i] . "'";
               
                $arrRow = $this->query($sqlSelect, 1);
                $qty_receipt = $arrRow[0]['qty_receipt'];
               
          
             	if($Type=="C"){
			$arryWhCreditItem[$i]['id']= $arryDetails['id'.$i];
			$arryWhCreditItem[$i]['OrderID']= $arryItem[$Count]['OrderID'];
			$arryWhCreditItem[$i]['item_id'] = $arryItem[$Count]['item_id'];
			$arryWhCreditItem[$i]['ref_id'] = $arryItem[$Count]['ref_id'];
			$arryWhCreditItem[$i]['sku'] = $arryItem[$Count]['sku'];
			$arryWhCreditItem[$i]['description']= $arryItem[$Count]['description'];
			$arryWhCreditItem[$i]['on_hand_qty'] = $arryItem[$Count]['on_hand_qty'];
			$arryWhCreditItem[$i]['qty'] = $arryItem[$Count]['qty'];
			$arryWhCreditItem[$i]['qty_received'] = $SQ_RECT;
			$arryWhCreditItem[$i]['qty_returned'] =$arryDetails['qty'.$i];
			$arryWhCreditItem[$i]['price']= $arryDetails['price'.$i];
			//$arryCreditItem[$i]['tax_id']= $arryItem[$Count]['tax_id'];
			//$arryCreditItem[$i]['tax']= $arryItem[$Count]['tax'];
			$arryWhCreditItem[$i]['amount']= $arryDetails['amount'.$i];
			//$arryCreditItem[$i]['Taxable']= $arryItem[$Count]['Taxable'];
			$arryWhCreditItem[$i]['Condition']= $arryItem[$Count]['Condition'];
			$arryWhCreditItem[$i]['DesComment']= $arryItem[$Count]['DesComment'];
			$arryWhCreditItem[$i]['Type']= $Type;
			$arryWhCreditItem[$i]['Action']=  $Action;
			$arryWhCreditItem[$i]['Reason']= $Reason;
			$TotalWhCreditItem +=$arryDetails['amount'.$i];
	    	}else if($Type=="R"){ 						
			$arryWhReplacementItem[$i]['id']= $arryDetails['id'.$i];
			$arryWhReplacementItem[$i]['OrderID']= $arryItem[$Count]['OrderID'];
			$arryWhReplacementItem[$i]['item_id'] = $arryItem[$Count]['item_id'];
			$arryWhReplacementItem[$i]['ref_id'] = $arryItem[$Count]['ref_id'];
			$arryWhReplacementItem[$i]['sku'] = $arryItem[$Count]['sku'];
			$arryWhReplacementItem[$i]['description']= $arryItem[$Count]['description'];
			$arryWhReplacementItem[$i]['on_hand_qty'] = $arryItem[$Count]['on_hand_qty'];
			$arryWhReplacementItem[$i]['qty'] = $arryItem[$Count]['qty'];
			$arryWhReplacementItem[$i]['qty_received'] = $SQ_RECT;
			$arryWhReplacementItem[$i]['qty_returned'] =$arryDetails['qty'.$i];
			$arryWhReplacementItem[$i]['price']= $arryDetails['price'.$i];
			//$arryReplacementItem[$i]['tax_id']= $arryItem[$Count]['tax_id'];
			//$arryReplacementItem[$i]['tax']= $arryItem[$Count]['tax'];
			$arryWhReplacementItem[$i]['amount']= $arryDetails['amount'.$i];
			//$arryReplacementItem[$i]['Taxable']= $arryItem[$Count]['Taxable'];
			$arryWhReplacementItem[$i]['Condition']= $arryItem[$Count]['Condition'];
			$arryWhReplacementItem[$i]['DesComment']= $arryItem[$Count]['DesComment'];
			$arryWhReplacementItem[$i]['Type']= $Type;
			$arryWhReplacementItem[$i]['Action']=  $Action;
			$arryWhReplacementItem[$i]['Reason']= $Reason;
			$TotalWhReplacementItem +=$arryDetails['amount'.$i];
	  	}          
              
                
                //update inventry strat from here
                $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand-'" . $arryDetails['qty' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";          
               
               $this->query($strSQLItem, 0); 
                
               //Insert data to Inventry Bin Stock 
               
              //$qtyReciept =  $arryDetails['qty_receipt'.$i];
             	$QtyPurchaseData = ($arryDetails['ordered_qty' . $i])-($arryDetails['received_qty'.$i]);
               
               $binStockData=explode("_",$arryDetails['bin'.$i]);
               $sqlbins="INSERT INTO inv_bin_stock (Wcode,Sku,quantity,purchase_qty,bin) VALUES ('" . $binStockData[1] . "','" . $arryDetails['sku' . $i] . "','" . $QtyPurchaseData. "','" . $arryDetails['qty' . $i] . "','" . $binStockData[0] . "')";
                
                $this->query($sqlbins, 0);
		*/
                
               
            }
            
            
        }
        
        
        
        /********************** CreditItem  **************************

	if(sizeof($arryWhCreditItem)>0){ 
			
			$arryPurchase[0]["TotalAmount"] = $TotalWhCreditItem;
			//$arryCrItem['serial_value']
			$CreditID = $this->AddWhPurchaseCreditRMA($arryPurchase[0]);
		    foreach($arryWhCreditItem as $arryCrItem){
		    
			   	  	   $sqls = "insert into p_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, qty_returned, price, tax_id, tax, amount, Taxable,`Condition`, DesComment, Type, Action, Reason, SerialNumbers) values('".$CreditID."', '".$arryCrItem['item_id']."' , '0', '".$arryCrItem['sku']."', '".$arryCrItem['description']."', '".$arryCrItem['on_hand_qty']."', '".$arryCrItem['qty_returned']."', '0', '0', '".$arryCrItem['price']."', '".$arryCrItem['tax_id']."', '".$arryCrItem['tax']."', '".$arryCrItem['amount']."', '".$arryCrItem['Taxable']."','".$arryCrItem['Condition']."','".$arryCrItem['DesComment']."','".$arryCrItem['Type']."','".$arryCrItem['Action']."','".$arryCrItem['Reason']."','".$SerialNumbers."')";
						//echo $sqls;exit;
			   	  	   $this->query($sqls, 0);
						
			}
			   	
				   
			}
			
			
	/********************** ReplacementItem **************************
			
		if(sizeof($arryWhReplacementItem)>0){ //print_r($arryReplacementItem);
		$arryPurchase[0]["TotalAmount"]=$TotalWhReplacementItem;
		$PurchaseID = $this->AddWhPurchaseReplacementRMA($arryPurchase[0]);
		//echo "<pre>";print_r($PurchaseID);
			foreach($arryWhReplacementItem as $arryRpItem){
				//echo "<pre>";print_r($arryRpItem);die;
			 $sqls = "insert into p_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, qty_returned, price, tax_id, tax, amount, Taxable,`Condition`, DesComment, Type, Action, Reason, SerialNumbers) values('".$PurchaseID."', '".$arryRpItem['item_id']."' , '0', '".$arryRpItem['sku']."', '".$arryRpItem['description']."', '".$arryRpItem['on_hand_qty']."', '".$arryRpItem['qty_returned']."', '0', '0', '".$arryRpItem['price']."', '".$arryRpItem['tax_id']."', '".$arryRpItem['tax']."', '".$arryRpItem['amount']."', '".$arryRpItem['Taxable']."','".$arryRpItem['Condition']."','".$arryRpItem['DesComment']."','".$arryRpItem['Type']."','".$arryRpItem['Action']."','".$arryRpItem['Reason']."','".$SerialNumbers."')";
	        // echo $sql;exit;
			 $this->query($sqls, 0);	
	   	  
			}

		
		}
    	/****************************/
                 if ($UpdatePurchaseStatus == 0) {
                 	$Status = "Closed";
                	$OrderID = $arryItem[$Count]["OrderID"];
                 }else{
                 	$Status = "In Reciept";
                 	$OrderID = $arryItem[$Count]["OrderID"];
                 }
        
        	$sqlw="update p_order set Status='".$Status."' where OrderID='".$OrderID."'";
        	$this->query($sqlw,0);
        
        return $receipt_id;
    }
 
 

    function AddReceiptOrderPO($arryDetails) {
        global $Config;
        extract($arryDetails);

        $IPAddress = GetIPAddress();

       $strSQLQuery = "INSERT INTO w_receiptpo SET Module = 'Receipt',ModuleType ='Purchase', 
        OrderID='" . $OrderID . "', PurchaseID ='" . $PurchaseID . "', 
        QuoteID = '" . $QuoteID . "',InvoiceID ='" . $InvoiceID . "', 
        ReturnID = '" . $ReturnID . "',ReceiptStatus = '" . $ReceiptStatus . "' , 
        packageCount = '" . addslashes($packageCount) . "', 
        transport = '" . addslashes($transport) . "', 
        Weight = '" . $Weight . "', 
        ReceiptComment = '" . addslashes($ReceiptComment) . "', 
        TotalReceiptAmount = '" . addslashes($TotalAmount) . "', 
        Freight = '" . $Freight . "',
        Restocking_fee = '" . $Restocking_fee . "',
        Restocking = '" . $ReStocking . "',  
        taxAmnt = '" . $taxAmnt . "', 
        CreatedBy = '" . addslashes($_SESSION['UserName']) . "', 
        AdminID='" . $_SESSION['AdminID'] . "', 
        AdminType='" . $_SESSION['AdminType'] . "', 
        PostedDate='" . $Config['TodayDate'] . "', 
        UpdatedDate='" . $Config['TodayDate'] . "', 
        ReceiptDate='" . $ReceiptDate . "', 
        SuppCode ='" . addslashes($SuppCode) . "',
        SuppCompany ='" . addslashes($SuppCompany) . "',
        SuppContact ='" . addslashes($SuppContact) . "',
        SuppCurrency ='" . addslashes($Currency) . "',
        Address ='" . addslashes($Address) . "',
        City ='" . $City . "',
        State ='" . $State . "',
        Country ='" . $Country . "',
        ZipCode ='" . $ZipCode . "',
        Mobile ='" . $Mobile . "',
        Landline ='" . $Landline . "',
        Email ='" . $Email . "',  
        wCode ='" . $wCode . "',
        wName ='" . $wName . "',
        wAddress ='" . $wAddress . "',
        wCity ='" . $wCity . "',
        wState ='" . $wState . "',
        wCountry ='" . $wCountry . "',
        wZipCode ='" . $wZipCode . "',
        wContact ='" . $wContact . "',
        wMobile ='" . $wMobile . "',
        wLandline ='" . $wLandline . "',
        wEmail ='" . $wEmail . "',
        Taxable ='" . $Taxable . "',
        TaxRate ='" . $TaxRate . "' ,IPAddress = '". $IPAddress."' ";

     // echo "=>".$strSQLQuery;exit;
        $this->query($strSQLQuery, 0);
        $RECPTID = $this->lastInsertId();
        if (empty($ReceiptNo)) {
            $ReceiptNo = 'RCPT000' . $RECPTID;
        }
        $sql = "UPDATE w_receiptpo SET ReceiptNo='" . $ReceiptNo . "' WHERE ReceiptID='" . $RECPTID . "'";
        $this->query($sql, 0);




        return $RECPTID;
    }
    
    
    
    
  function AddCreditPOFromReceipt($ReceiptID) {    
	$arryPurchase = $this->GetPurchaseReceipt($ReceiptID, '', 'Receipt');
	$arryItem = $this->GetPurchaseReceiptItem($ReceiptID,'');
	$NumLine = sizeof($arryItem);
        for($i = 1; $i <= $NumLine; $i++) {
            $Count = $i - 1;          
          
		if($arryItem[$Count]['Type']=="C"){
			$arryCreditItem[$i]['item_id'] = $arryItem[$Count]['item_id'];
			$arryCreditItem[$i]['sku'] = $arryItem[$Count]['sku'];
			$arryCreditItem[$i]['description']= $arryItem[$Count]['description'];
			$arryCreditItem[$i]['on_hand_qty'] = $arryItem[$Count]['on_hand_qty'];
			$arryCreditItem[$i]['qty'] = $arryItem[$Count]['qty_receipt'];	
			$arryCreditItem[$i]['price']= $arryItem[$Count]['price'];
			$arryCreditItem[$i]['amount']= $arryItem[$Count]['amount'];
			$arryCreditItem[$i]['Condition']= $arryItem[$Count]['Condition'];
			$arryCreditItem[$i]['DesComment']= $arryItem[$Count]['DesComment'];
			$arryCreditItem[$i]['SerialNumbers']= $arryItem[$Count]['SerialNumbers'];
			$TotalCreditItem +=$arryItem[$Count]['amount'];
		}else if($arryItem[$Count]['Type']=="R"){ 
			$arryReplacementItem[$i]['item_id'] = $arryItem[$Count]['item_id'];
			$arryReplacementItem[$i]['sku'] = $arryItem[$Count]['sku'];
			$arryReplacementItem[$i]['description']= $arryItem[$Count]['description'];
			$arryReplacementItem[$i]['on_hand_qty'] = $arryItem[$Count]['on_hand_qty'];
			$arryReplacementItem[$i]['qty'] = $arryItem[$Count]['qty_receipt'];
			$arryReplacementItem[$i]['price']= $arryItem[$Count]['price'];
			$arryReplacementItem[$i]['amount']= $arryItem[$Count]['amount'];			   
                 	$arryReplacementItem[$i]['Condition']= $arryItem[$Count]['Condition'];
			$arryReplacementItem[$i]['DesComment']= $arryItem[$Count]['DesComment'];
			$arryReplacementItem[$i]['SerialNumbers']= $arryItem[$Count]['SerialNumbers'];
			$TotalReplacementItem +=$arryItem[$Count]['amount'];		
		}


		//update inventry strat from here
                $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand-'" . $arryItem[$Count]['qty_receipt'] . "' where Sku='" . $arryItem[$Count]['sku'] . "' "; 
               $this->query($strSQLItem, 0);
		$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$arryItem[$Count]['sku']. "' and qty_on_hand<0";
		$this->query($UpdateQtysql2, 0);                
               //Insert data to Inventry Bin Stock 
            
                if(!empty($arryItem[$Count]['bin'])){             
		       $binStockData=explode("_",$arryItem[$Count]['bin']);
		       $sqlbins="INSERT INTO inv_bin_stock (Wcode,Sku,quantity,purchase_qty,bin) VALUES ('" . $binStockData[1] . "','" . $arryItem[$Count]['sku'] . "','" . $arryItem[$Count]['qty_receipt']. "','" . $arryItem[$Count]['qty']. "','" . $binStockData[0] . "')";     
		        $this->query($sqlbins, 0);
		}
		
               
       }
            
          
        
      	/******** Credit  ******/
	if(sizeof($arryCreditItem)>0){
		$arryPurchase[0]["TotalAmount"] = $TotalCreditItem;
		$CreditID = $this->AddWhPurchaseCreditRMA($arryPurchase[0]);
		foreach($arryCreditItem as $arryCrItem){		    
   	  	   $sqlCrd = "insert into p_order_item(OrderID, item_id, sku, description, on_hand_qty, qty, price, amount, `Condition`, DesComment, SerialNumbers) values('".$CreditID."', '".$arryCrItem['item_id']."', '".$arryCrItem['sku']."', '".$arryCrItem['description']."', '".$arryCrItem['on_hand_qty']."', '".$arryCrItem['qty']."', '".$arryCrItem['price']."',  '".$arryCrItem['amount']."', '".$arryCrItem['Condition']."','".$arryCrItem['DesComment']."','".$arryCrItem['SerialNumbers']."')";					
   	  	   $this->query($sqlCrd, 0);
						
	    	}

	}			
			
	/******** Replacement  ********/		
	if(sizeof($arryReplacementItem)>0){ 
		$arryPurchase[0]["TotalAmount"]=$TotalReplacementItem;
		$PurchaseID = $this->AddWhPurchaseReplacementRMA($arryPurchase[0]);
		foreach($arryReplacementItem as $arryRpItem){				
			 $sqlPO = "insert into p_order_item(OrderID, item_id, sku, description, on_hand_qty, qty,  price,  amount, `Condition`, DesComment, SerialNumbers) values('".$PurchaseID."', '".$arryRpItem['item_id']."' , '".$arryRpItem['sku']."', '".$arryRpItem['description']."', '".$arryRpItem['on_hand_qty']."', '".$arryRpItem['qty']."', '".$arryRpItem['price']."', '".$arryRpItem['amount']."', '".$arryRpItem['Condition']."','".$arryRpItem['DesComment']."', '".$arryRpItem['SerialNumbers']."')";		       	
			 $this->query($sqlPO, 0);	
   	  
	    	}				

	}
        
        return $ReceiptID;
    }  
    
    
    
    
    
    
    /***************************************/
    
     function GetPurchaseReceiptItem($OrderID, $PurchaseID) {
        $strAddQuery .= (!empty($OrderID)) ? (" and i.ReceiptID='" . $OrderID . "'") : ("");
        $strAddQuery .= (!empty($PurchaseID)) ? (" and i.OrderID='" . $PurchaseID . "'") : ("");
        //$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
        $strSQLQuery = "select i.*,c.valuationType as evaluationType from w_receiptpo_item i  left outer join inv_items itm on i.item_id=itm.ItemID left outer join inv_categories c on c.CategoryID =itm.CategoryID where 1" . $strAddQuery . " order by i.id asc";
        
//echo $strSQLQuery; exit;
        return $this->query($strSQLQuery, 1);
    }

    function GetPurchaseSumQtyReturned($id) {
        $sql = "select sum(i.qty_returned) as QtyReturned,sum(r.qty_receipt) as QtyReceipt from p_order_item i left outer join w_receiptpo_item r on i.item_id=r.item_id where i.OrderID='" . $id . "' group by i.OrderID";
        $rs = $this->query($sql);
        return $rs;
    }

    function GetPurchaseSumQtyReceipt($id, $item_id) {
       $sql = "select sum(r.qty_receipt) as Qty_Receipt from w_receiptpo_item  r  where r.OrderID='" . $id . "'  and r.item_id = '" . $item_id . "'  group by r.item_id  order by id asc";
        $rs = $this->query($sql);
        return $rs[0]['Qty_Receipt'];
    }
    
   

    function ListPurchaseReceipt($arryDetails) {
//echo "</pre>";print_r($arryDetails);die;
        global $Config;
        extract($arryDetails);

        $strAddQuery = "where w.Module='Receipt' ";
        $SearchKey = strtolower(trim($key));

        $strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.AssignedEmpID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):(""); 

        $strAddQuery .= (!empty($po)) ? (" and w.PurchaseID='" . $po . "'") : ("");
        $strAddQuery .= (!empty($FPostedDate)) ? (" and w.PostedDate>='" . $FPostedDate . "'") : ("");
        $strAddQuery .= (!empty($TPostedDate)) ? (" and w.PostedDate<='" . $TPostedDate . "'") : ("");

	if($SearchKey=='yes' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
		$strAddQuery .= " and o.InvoicePaid='1'"; 
	}else if($SearchKey=='no' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
		$strAddQuery .= " and o.InvoicePaid!='1'";
	}else if($SearchKey != '' && $sortby == 'w.SuppCompany'){
		$strAddQuery .= " and (w.SuppCompany like '%".$SearchKey."%'  or s.UserName like '%".$SearchKey."%' or s.CompanyName like '%".$SearchKey."%' ) ";
	}else if($sortby != ''){
		$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
	}else{
		$strAddQuery .= (!empty($SearchKey))?(" and (w.InvoiceID like '%".$SearchKey."%'  or w.ReceiptNo like '%" . $SearchKey . "%' or w.ReturnID like '%" . $SearchKey . "%' or w.PurchaseID like '%".$SearchKey."%'  or w.SuppCompany like '%".$SearchKey."%' or s.UserName like '%".$SearchKey."%' or s.CompanyName like '%".$SearchKey."%'  or w.TotalReceiptAmount like '%".$SearchKey."%' or w.SuppCurrency like '%".$SearchKey."%' ) " ):("");	
	}
            
        $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by w.ReceiptID ");
        $strAddQuery .= (!empty($asc)) ? ($asc) : (" desc");


	if($Config['GetNumRecords']==1){
		$Columns = " count(w.ReceiptID) as NumCount ";				
	}else{				
		$Columns = "  w.ReceiptID,w.InvoiceID,w.ReturnID,w.ReceiptNo,w.TotalReceiptAmount,w.ReceiptStatus,w.PostedDate,w.InvoiceID,w.OrderID, w.PurchaseID, w.SuppCode, w.SuppCompany, w.SuppContact, w.SuppCurrency, w.Address, w.City, w.State, w.Country, w.ZipCode, w.Mobile, w.Landline, w.Email, w.wCode, w.wName,  w.wAddress, w.wCity,  w.wState, w.wCountry,  w.wZipCode, w.wContact,  w.wMobile, w.wLandline, w.wEmail, w.Taxable, w.TaxRate, o.TotalAmount, o.Currency,o.InvoicePaid  , w.AdminType, w.AdminID, if(w.AdminType='employee',em.UserName,'Administrator') as PostedBy, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName  ";
		if($Config['RecordsPerPage']>0){
			$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
		}
		
	}

        $strSQLQuery = "select ".$Columns." from w_receiptpo w  left outer join p_supplier s on BINARY w.SuppCode = BINARY s.SuppCode left outer join p_order o on w.OrderID = o.OrderID left outer join h_employee em on (w.AdminID=em.EmpID and w.AdminType='employee') " . $strAddQuery;
      
        
        return $this->query($strSQLQuery, 1);
    }

   function changePurchaseReceiptStatus($ReceiptID)
		{
			
			if(!empty($ReceiptID)){
				$sql="select ReceiptID,ReceiptStatus from w_receiptpo where ReceiptID='".mysql_real_escape_string($ReceiptID)."'";
				$rs = $this->query($sql);
				//print_r($rs);exit;
				if(sizeof($rs))
				{
						
				 if($rs[0]['ReceiptStatus'] == "Completed"){
					  $Status = 'Parked';
				 }else{
					  $Status = 'Completed';  
				 }
						
					$sql="update w_receiptpo set ReceiptStatus='$Status' where ReceiptID='".mysql_real_escape_string($ReceiptID)."'";
					$this->query($sql,0);					
				}	
			}

			return true;

		}

    function RemovePurchaseReceipt($OrderID) {

        $strSQLQuery = "delete from w_receiptpo where ReceiptID='" . $OrderID . "'";
        $this->query($strSQLQuery, 0);

        $strSQLQuery = "delete from w_receiptpo_item where ReceiptID='" . $OrderID . "'";
        $this->query($strSQLQuery, 0);

        return 1;
    }

    function UpdatePurchaseReturn($arryDetails) {
        global $Config;
        extract($arryDetails);

        $strSQLQuery = "update w_receiptpo set ReceiptStatus='" . $ReceiptStatus . "',PurchaseID='" . $PurchaseID . "', UpdatedDate = '" . $Config['TodayDate'] . "'
			where ReceiptID=" . $rcptID . "";
        $this->query($strSQLQuery, 0);

        return 1;
    }

    function CheckPurchaseReceipt($OrderID) {

        $sql = "select ReceiptID from w_receiptpo  where OrderID='" . $OrderID . "'  ";
        $rs = $this->query($sql);
        if (!empty($rs[0]['ReceiptID'])) {
            $receiptID = $rs[0]['ReceiptID'];
        } else {
            $receiptID = '';
        }
        return $receiptID;
    }
    
    
   function WHRmaTypeValue($Type){
            switch($Type){
                case 'AC': $typeVal = 'Advance Credit'; break;
                case 'AR': $typeVal = 'Advance Replacement'; break;
                case 'C': $typeVal = 'Credit'; break;
                 case 'R': $typeVal = 'Replacement'; break;
            }
            
            return $typeVal;

        }
        
        
        
function AddWhPurchaseCreditRMA($arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			if(empty($Currency)) $Currency =  $Config['Currency'];
			//if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];
			$Status = 'Open';
			$Approved = 'No';
			$IPAddress = GetIPAddress();
			$Taxable = '';
             		$taxAmnt = 0;
			$MainTaxRate = '';

                        if($OrderType == 'Dropship'){ $CustCode=$CustCode;} else{ $CustCode = ''; }
            $Crmodule = "Credit";   
			/*if($Currency != $Config['Currency']){  
				$ConversionRate = CurrencyConvertor(1,$Currency,$Config['Currency'],'AP');
			}else{   
				$ConversionRate=1;
			}*/

      
			$strSQLQuery = "insert into p_order(Module, OrderType, OrderDate,  PurchaseID, QuoteID, InvoiceID, CreditID, wCode, Approved, Status, DropShip, DeliveryDate, ClosedDate, Comment, SuppCode, SuppCompany, SuppContact, Address, City, State, Country, ZipCode, Currency, SuppCurrency, Mobile, Landline, Fax, Email, wName, wContact, wAddress, wCity, wState, wCountry, wZipCode, wMobile, wLandline, wEmail, TotalAmount, Freight, CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, ReceivedDate, ExpiryDate, InvoicePaid, InvoiceComment, PaymentMethod, ShippingMethod, PaymentTerm, AssignedEmpID, AssignedEmp, Taxable, SaleID, taxAmnt , tax_auths, TaxRate,CustCode,ReturnID,ConversionRate, IPAddress) values('".$Crmodule."', '".$OrderType."', '".$OrderDate."',  '".$PurchaseID."', '".$QuoteID."', '".$InvoiceID."', '".$CreditID."', '".$wCode."', '".$Approved."','".$Status."', '".$DropShip."', '".$DeliveryDate."', '', '".addslashes(strip_tags($Comment))."', '".addslashes($SuppCode)."', '".addslashes($SuppCompany)."', '".addslashes($SuppContact)."', '".addslashes($Address)."' ,  '".addslashes($City)."', '".addslashes($State)."', '".addslashes($Country)."', '".addslashes($ZipCode)."',  '".$Currency."', '".addslashes($SuppCurrency)."', '".addslashes($Mobile)."', '".addslashes($Landline)."', '".addslashes($Fax)."', '".addslashes($Email)."' , '".addslashes($wName)."', '".addslashes($wContact)."', '".addslashes($wAddress)."' ,  '".addslashes($wCity)."', '".addslashes($wState)."', '".addslashes($wCountry)."', '".addslashes($wZipCode)."', '".addslashes($wMobile)."', '".addslashes($wLandline)."',  '".addslashes($wEmail)."', '".addslashes($TotalAmount)."', '0', '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$ReceivedDate."', '".$ExpiryDate."', '".$InvoicePaid."', '".addslashes(strip_tags($InvoiceComment))."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".addslashes($EmpID)."', '".addslashes($EmpName)."', '".addslashes($Taxable)."', '".addslashes($SaleID)."', '".addslashes($taxAmnt)."', '".addslashes($tax_auths)."', '".addslashes($MainTaxRate)."','".$CustCode."','".$ReturnID."', '".$ConversionRate."' ,'".$IPAddress."')";
            //echo $strSQLQuery;exit;
			
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();
			
		

			$objConfigure = new configure();
			$objConfigure->UpdateModuleAutoID('p_order','Credit',$OrderID,''); 
			


		/*********CreditLimit Updation***********/
		$strSQl = "select PaymentTerm from p_supplier WHERE SuppCode='".$SuppCode."'";
		$arrSupp = $this->query($strSQl, 1);			
		if(!empty($arrSupp[0]['PaymentTerm'])){
			$arryTerm = explode("-",$arrSupp[0]['PaymentTerm']);
			$TermDays = (int)trim($arryTerm[1]);
			if($TermDays > 0){
				$sql="UPDATE p_supplier SET CreditLimit=CreditLimit-".$TotalAmount." WHERE SuppCode='".$SuppCode."' and CreditLimit>0";
				$this->query($sql,0);
				$sql2="UPDATE p_supplier SET CreditLimit='0' WHERE SuppCode='".$SuppCode."' and CreditLimit<0";
				$this->query($sql2,0);
			}
		}
		/*****************************************/




			return $OrderID;

		}
		
      function AddWhPurchaseReplacementRMA($arryDetails)
		{  
			//echo "<pre>";print_r($arryDetails);
			global $Config;
			extract($arryDetails);

			if(empty($Currency)) $Currency =  $Config['Currency'];
			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];
			
			$Status = 'Draft';
			$Approved = 'No';
			$Taxable = '';
			$taxAmnt = 0;
			$MainTaxRate = '';
			$IPAddress = GetIPAddress();


                        if($OrderType == 'Dropship'){ $CustCode=$CustCode;} else{ $CustCode = ''; }
            $Remodule = "Order";  
            $OrderDateRep = $Config['TodayDate'];

			/*if($Currency != $Config['Currency']){  
				$ConversionRate = CurrencyConvertor(1,$Currency,$Config['Currency'],'AP');
			}else{   
				$ConversionRate=1;
			}*/


			$strSQLQuery = "insert into p_order(Module, OrderType, OrderDate,  PurchaseID, QuoteID, InvoiceID, CreditID, wCode, Approved, Status, DropShip, DeliveryDate, ClosedDate, Comment, SuppCode, SuppCompany, SuppContact, Address, City, State, Country, ZipCode, Currency, SuppCurrency, Mobile, Landline, Fax, Email, wName, wContact, wAddress, wCity, wState, wCountry, wZipCode, wMobile, wLandline, wEmail, TotalAmount, Freight, CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, ReceivedDate, ExpiryDate, InvoicePaid, InvoiceComment, PaymentMethod, ShippingMethod, PaymentTerm, AssignedEmpID, AssignedEmp, Taxable, SaleID, taxAmnt , tax_auths, TaxRate,CustCode,ReturnID,ConversionRate,IPAddress) values('".$Remodule."', '".$OrderType."', '".$OrderDateRep."',  '".$PurchaseID."', '".$QuoteID."', '".$InvoiceID."', '".$CreditID."', '".$wCode."', '".$Approved."','".$Status."', '".$DropShip."', '".$DeliveryDate."', '".$ClosedDate."', '".addslashes(strip_tags($Comment))."', '".addslashes($SuppCode)."', '".addslashes($SuppCompany)."', '".addslashes($SuppContact)."', '".addslashes($Address)."' ,  '".addslashes($City)."', '".addslashes($State)."', '".addslashes($Country)."', '".addslashes($ZipCode)."',  '".$Currency."', '".addslashes($SuppCurrency)."', '".addslashes($Mobile)."', '".addslashes($Landline)."', '".addslashes($Fax)."', '".addslashes($Email)."' , '".addslashes($wName)."', '".addslashes($wContact)."', '".addslashes($wAddress)."' ,  '".addslashes($wCity)."', '".addslashes($wState)."', '".addslashes($wCountry)."', '".addslashes($wZipCode)."', '".addslashes($wMobile)."', '".addslashes($wLandline)."',  '".addslashes($wEmail)."', '".addslashes($TotalAmount)."', '0', '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$ReceivedDate."', '".$ExpiryDate."', '".$InvoicePaid."', '".addslashes(strip_tags($InvoiceComment))."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".addslashes($EmpID)."', '".addslashes($EmpName)."', '".addslashes($Taxable)."', '".addslashes($SaleID)."', '".addslashes($taxAmnt)."', '".addslashes($tax_auths)."', '".addslashes($MainTaxRate)."','".$CustCode."','".$ReturnID."','".$ConversionRate."','".$IPAddress."')";
            //echo $strSQLQuery;exit;
			
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();
			
			/*	
				$PurchaseID = 'PO000'.$OrderID;				
				$strSQL = "update p_order set PurchaseID='".$PurchaseID."' where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);
			}*/


			$objConfigure = new configure();
			$objConfigure->UpdateModuleAutoID('p_order','Order',$OrderID,'');
             
			return $OrderID;

		}
    
    

	/****************************************/
	/****************************************/
	function VendorRmaPostToGL($ReceiptID){
		global $Config;		 
	 	if($ReceiptID>0){
			$ipaddress = GetIPAddress(); 
	
			$objConfigure = new configure();
			 
			$AccountPayable = $objConfigure->getSettingVariable('AccountPayable');
			$ApRestocking = $objConfigure->getSettingVariable('ApRestocking');	
 
			$arryRow = $this->GetPurchaseReceipt($ReceiptID, '', 'Receipt');
		 		 	 
			$Date = $arryRow[0]['PostedDate'];
			$Restocking = $arryRow[0]['RmaRestocking'];
			$ConversionRate=1;
			$PaymentType = 'Vendor RMA (Re-Stocking)';
			if($Restocking==1){
				$RestockingFee = $arryRow[0]['Restocking_fee'];
				$OriginalRestockingFee = $RestockingFee;
				if($arryRow[0]['SuppCurrency']!=$Config['Currency']){					 
					$ConversionRate = $arryRow[0]['ConversionRate'];
					$RestockingFee = round(GetConvertedAmount($ConversionRate, $RestockingFee) ,2); 	 
				}
			}	
 			//pr($arryRow);exit;
			/**************************************/
			if(!empty($AccountPayable) && !empty($ApRestocking) && !empty($RestockingFee)){		 
				
				$DebitAccount = $ApRestocking;
				$CreditAccount = $AccountPayable;
	 
				//Debit Restocking
				$strSQLQuery = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$ReceiptID."',   SuppCode = '".$arryRow[0]['SuppCode']."', PurchaseID = '".$arryRow[0]['PurchaseID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', ReferenceNo='".$arryRow[0]['ReceiptNo']."', DebitAmnt  = ENCODE('".$RestockingFee."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$DebitAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['SuppCurrency']."' , OriginalAmount=ENCODE('".$OriginalRestockingFee. "','".$Config['EncryptKey']."'), TransactionType='D' ";		
				$this->query($strSQLQuery, 1);
				$PID = $this->lastInsertId();
				//Credit AP
				$strSQLQueryPay = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', PID='".$PID."', CreditAmnt = ENCODE('".$RestockingFee."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'),  ReferenceNo='".$arryRow[0]['ReceiptNo']."', AccountID = '".$CreditAccount."',   SuppCode = '".$arryRow[0]['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= 1, IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['SuppCurrency']."' , OriginalAmount=ENCODE('".$OriginalRestockingFee. "','".$Config['EncryptKey']."'), TransactionType='C'";
				$this->query($strSQLQueryPay, 0);
				
			}
			/**************************************/
	      			
 
		}
		 
		return true;
			
	}


    
}

?>
