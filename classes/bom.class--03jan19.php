<?

class bom extends dbClass {

    //constructor
    function bom() {
        $this->dbClass();
    }

    function ListBOM($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {
	global $Config;
        $strAddQuery = $LeftJoin = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where b.bomID='" . $id."'") : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and w.Status='".$Status."'"):(" ");

        if ($SortBy == 'id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (b.bomID = '" . $SearchKey . "')") : ("");
        } else {

            if ($SortBy != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
            }else if(!empty($SearchKey)){
                $strAddQuery .= " and ( b.bom_code like '%" . $SearchKey . "%' or b.Sku like '%" . $SearchKey . "%' or b.bill_option like '%" . $SearchKey . "%' or i.description like '%" . $SearchKey . "%'  or a1.ItemAliasCode like '%" . $SearchKey . "%' )  group by b.bomID ";
		$LeftJoin = ' left  join inv_item_alias a1 on i.Sku=a1.sku';
            }
        }

        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by b.bomID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");
	$strAddQuery .= (!empty($Config['RecordsPerPage'])) ? (" limit " . $Config['$start_from'] . ",".$Config['RecordsPerPage']." ") : ("  ");

 //$strSQLQuery = "select b.Sku,b.bill_option,i.Sku,i.description from inv_bill_of_material b left  join  inv_items  i on i.Sku=b.Sku  " .$LeftJoin. $strAddQuery;

        //$strSQLQuery = "select b.*,i.description from inv_bill_of_material b left  join  inv_items  i on i.Sku=b.Sku  " .$LeftJoin. $strAddQuery;
 $strSQLQuery = "select b.*,i.description,c1.valuationType from inv_bill_of_material b left  join  inv_items  i on i.Sku=b.Sku left outer join inv_categories c1 on i.CategoryID = c1.CategoryID " .$LeftJoin. $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }



/***********************************************/

 function ListBOMListing($arryDetails) {
	global $Config;
	extract($arryDetails);

	(empty($SortBy))?($SortBy=""):("");

        $strAddQuery = '';
	$LeftJoin = '';
        $SearchKey = strtolower(trim($key));
        $strAddQuery .= (!empty($id)) ? (" where b.bomID='" . $id."'") : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and w.Status='".$Status."'"):(" ");

        if ($SortBy == 'id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (b.bomID = '" . $SearchKey . "')") : ("");
        } else {

            if ($sortby != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '%" . $SearchKey . "%')") : ("");
            }else if(!empty($SearchKey)){
                $strAddQuery .= " and ( b.bom_code like '%" . $SearchKey . "%' or b.description like '%" . $SearchKey . "%' or b.Sku like '%" . $SearchKey . "%' or b.bill_option like '%" . $SearchKey . "%' )  group by b.bomID ";
		$LeftJoin = ' left  join inv_item_alias a1 on b.Sku=a1.sku';
            }
        }

        $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by b.bomID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc ");


if($Config['GetNumRecords']==1){
		$Columns = " count(*) as NumCount ";				
	}else{

    $Columns = " b.Sku,b.bill_option,b.bomDate,b.description,b.bomID "; //update by chetan 23Feb//
		if($Config['RecordsPerPage']>0){
			$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
		}
		
	}

 $strSQLQuery = "select ". $Columns." from inv_bill_of_material b   " .$LeftJoin. $strAddQuery;
	//$strAddQuery .= (!empty($Config['RecordsPerPage'])) ? (" limit " . $Config['$start_from'] . ",".$Config['RecordsPerPage']." ") : ("  ");

 //$strSQLQuery = "select b.Sku,b.bill_option,b.bomDate,b.description,b.bomID from inv_bill_of_material b   " .$LeftJoin. $strAddQuery;

        ///$strSQLQuery = "select b.*,i.description from inv_bill_of_material b left  join  inv_items  i on i.Sku=b.Sku  " .$LeftJoin. $strAddQuery;
  	//echo $strSQLQuery;  
        return $this->query($strSQLQuery, 1);
    }


/**********************************************/
    function RemoveBOM($id) {

        $strSQLQuery = "DELETE FROM inv_bill_of_material WHERE bomID = '" . $id."'";
        $rs = $this->query($strSQLQuery, 0);

        $strSQLQuery2 = "DELETE FROM inv_item_bom WHERE bomID = '" . $id."'";
        $this->query($strSQLQuery2, 0);

        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function AddBOM($arryDetails) {
        global $Config;
	$bom_code=$Status='';
        extract($arryDetails);

        if (empty($Currency))
            $Currency = $Config['Currency'];

        $strSQLQuery = "insert into inv_bill_of_material(bom_code,item_id,Sku,description,unit_cost,total_cost,on_hand_qty,bomDate,created_by,created_id,Status,bill_option,bomCondition) 
                         values('" . $bom_code . "','" . $bom_item_id . "', '" . $bom_Sku . "', '".$bom_description."' ,'" . $bom_price . "', '" . $TotalValue . "', '" . $bom_on_hand_qty . "', '" . $Config['TodayDate'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['AdminID'] . "','" . $Status . "','" . $bill_option . "','".$bomCondition."')";


        $this->query($strSQLQuery, 0);
         $materialID = $this->lastInsertId(); 
        /*  if($materialID>0){
          $rs=$this->getPrefix(1);

          $PrefixAD=$rs[0]['bom_prefix'];


          $ModuleIDValue = $PrefixAD.'-000'.$materialID;
          $strSQL = "update inv_bill_of_material set bom_code='".$ModuleIDValue."' where bomID=".$materialID;
          $this->query($strSQL, 0);
          } */

        return $materialID;
    }


 
	//By chetan 26Nov//
    function GetBOMStock($bomID, $optionID) {
	$strAddQuery = '';
        $strAddQuery .= (!empty($optionID)) ? (" and b.optionID='" . $optionID."'") : ("and b.optionID = '0'");
        $strAddQuery .= (!empty($bomID)) ? (" and b.bomID='" . $bomID."'") : ("");
       $strSQLQuery = "select b.*,i.Condition from inv_item_bom b left outer join inv_items i on b.Sku = i.sku  where 1 " . $strAddQuery . " order by b.orderby,b.id asc";
        return $this->query($strSQLQuery, 1);
    }

    function UpdateBOM($arryDetails) {
        global $Config;
        extract($arryDetails);

        $strSQLQuery = "update inv_bill_of_material set 
					item_id='" . $bom_item_id . "',
					Sku='" . $bom_Sku . "', 
					unit_cost='" . $bom_price . "',
					bill_option = '" . $bill_option . "', 
					total_cost='" . $TotalValue . "',
					on_hand_qty='" . $on_hand_qty . "',
                                        bomCondition='" . $bomCondition . "',
					Status='" . $Status . "',UpdatedDate = '" . $Config['TodayDate'] . "'
			where bomID='" . $bomID."'";

        $this->query($strSQLQuery, 0);

        return 1;
    }

    function AddUpdateBOMItembakkkkbhoo($BID, $opId, $arryDetails) {
        global $Config;
        extract($arryDetails);

        #echo $BID; exit;


        if (!empty($DelItem)) {
            $strSQLQuery = "delete from inv_item_bom where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }
        if ($opId == '') {
            $strUpSQLQuery = "update inv_bill_of_material set 
				total_cost='" . $TotalValue . "',
				UpdatedDate = '" . $Config['TodayDate'] . "'
				where bomID='" . $BID."'";

            $this->query($strUpSQLQuery, 0);
        }
        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);

                $id = $arryDetails['id' . $i];
                if ($id > 0) {
                    $sql = "update inv_item_bom set item_id='" . $arryDetails['item_id' . $i] . "', sku='" . addslashes($arryDetails['sku' . $i]) . "', description='" . addslashes($arryDetails['description' . $i]) . "', wastageQty='" . addslashes($arryDetails['Wastageqty' . $i]) . "', bom_qty='" . addslashes($arryDetails['qty' . $i]) . "', unit_cost='" . addslashes($arryDetails['price' . $i]) . "', total_bom_cost='" . addslashes($arryDetails['amount' . $i]) . "',`Condition`='" . addslashes($arryDetails['Condition' . $i]) . "',req_item='" . addslashes($arryDetails['req_item' . $i]) . "'  where id='" . $id."'";
                    $this->query($sql, 0);
                } else {

                    $sql = "insert into inv_item_bom (bomID,optionID, item_id, sku, description, wastageQty, bom_qty, unit_cost, total_bom_cost,`Condition`,req_item) values('" . $BID . "','" . $opId . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "', '" . addslashes($arryDetails['Wastageqty' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['Condition' . $i]) . "','" . addslashes($arryDetails['req_item' . $i] ). "')";

                    $this->query($sql, 0);
                }
            }
        }

        return true;
    }
//By chetan 26Nov//
function AddUpdateBOMItem($BID, $opId, $arryDetails,$option_code) {
        global $Config;
        extract($arryDetails);

        if (!empty($DelItem)) {
            
           if(strstr($delOptId, ','))
           {
               $Ids = explode(',', $delOptId);
               foreach($Ids as $id){
                    $strSQLQuery = "delete from inv_item_bom where id in(" . $id . ")";
                    $this->query($strSQLQuery, 0);
               }
           }else{
               $strSQLQuery = "delete from inv_item_bom where id in(" . $DelItem . ")";
               $this->query($strSQLQuery, 0);
           }
            
        }
        if ($opId == '') {
            $strUpSQLQuery = "update inv_bill_of_material set 
				total_cost='" . $TotalValue . "',
				UpdatedDate = '" . $Config['TodayDate'] . "'
				where bomID='" . $BID."'";
            //echo $strUpSQLQuery ;die;

            $this->query($strUpSQLQuery, 0);
        }
        
        for ($i = 1; $i <= $numberLine; $i++) {
         
          
           
            if (!empty($arryDetails['sku' . $i])) {
             
                $id = $arryDetails['id' . $i];
             
                if ($id > 0) {
                  
                   $sql = "update inv_item_bom set orderby = '".$arryDetails['orderby' . $i]."', item_id='" . $arryDetails['item_id' . $i] . "', sku='" . addslashes($arryDetails['sku' . $i]) . "',`Primary`='".addslashes($arryDetails['Primary' . $i])."', description='" . addslashes($arryDetails['description' . $i]) . "', wastageQty='" . addslashes($arryDetails['Wastageqty' . $i]) . "', bom_qty='" . addslashes($arryDetails['qty' . $i]) . "', unit_cost='" . addslashes($arryDetails['price' . $i]) . "', total_bom_cost='" . addslashes($arryDetails['amount' . $i]) . "',`Condition`='" . addslashes($arryDetails['Condition' . $i]) . "',req_item='" . addslashes($arryDetails['req_item' . $i]) . "'  where id='" . $id."'"; 
                    $this->query($sql, 0);
                   
                } else {
                   

                   $sql = "insert into inv_item_bom (bomID,optionID, item_id, sku, description, wastageQty, bom_qty, unit_cost, total_bom_cost,`Condition`,req_item,orderby,`Primary`) values('" . $BID . "','" . $opId . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "', '" . addslashes($arryDetails['Wastageqty' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['Condition' . $i]) . "','" . addslashes($arryDetails['req_item' . $i] ). "','".$arryDetails['orderby' . $i]."','".addslashes($arryDetails['Primary' . $i]) ."')";
                  $this->query($sql, 0);
                   
        
        }
                    
                }
               
            

        }
         
        return true;
    }

    function UpdateOptionBillbakbhoodev($arryDetails) {
        global $Config;
        extract($arryDetails);

        $strSQLQuery = "update inv_bom_cat set 
					option_cat='" . $option_cat . "',
					option_price='" . $option_price . "', 
					TotalValue='" . $TotalValue . "',
					req_status = '" . $req_status . "',
                                        qty = '" . $option_qty . "',
                                        TotalValue='" . $TotalValue . "',
					description1='" . $description_one . "',
					description2='" . $description_two . "'
					
			where optionID='" . $optionID."'";

        $this->query($strSQLQuery, 0);

        return 1;
    }
function UpdateOptionBill($arryDetails) {
        global $Config;
        extract($arryDetails);
        //echo '<pre>';print_r($arryDetails);//die;
        if($delOptId)
        {
           if(strstr($delOptId, ','))
           {
               $Ids = explode(',', $delOptId);
               foreach($Ids as $id){
                   $this->RemoveOptionBOM($id);
               }
           }else{
               $this->RemoveOptionBOM($delOptId);
           }
        }
        
        if (!empty($newDelItem)) {
            
         
            
           if(strstr($newDelItem, ','))
           { 
           
               $Ids = explode(',', $newDelItem);
               foreach($Ids as $id){
                   
                    $strSQLQuery = "delete from inv_item_bom where id ='" . $id . "'";
                    $this->query($strSQLQuery, 0);
                }
           
            }
           else
           {
            
                $strSQLQuery = "delete from inv_item_bom where id ='" . $newDelItem . "'";
                $this->query($strSQLQuery, 0);
           } 
            
            
        }//die;
        
        for ($i = 1; $i<=$optionNumLine; $i++) {
       
            if($arryDetails['option_code'.$i] !='')
            {
         
                if($arryDetails['optionId'.$i] !='')
                {
                   $strSQLQuery = "update inv_bom_cat set 
                                        option_code='" . $arryDetails['option_code' . $i] . "',
                                        description1='". $arryDetails['description_one' . $i] . "'
                                    where 
                                    optionID='". $arryDetails['optionId'. $i] . "' "; 
                    $this->query($strSQLQuery, 0);
                    $opID = $arryDetails['optionId'. $i];
                }else{ 

                    $strSQLQuery = "insert into inv_bom_cat (option_code,description1) values
                           ('" . $arryDetails['option_code'.$i] . "', '" . $arryDetails['description_one'.$i] . "')";
                    $this->query($strSQLQuery, 0);
                    $opID = $this->lastInsertId();
                    if ($opID > 0) {
                        $Upsql = "update inv_bom_cat set bomID='" . $bomID . "'  where optionID='" . $opID."'";
                        $this->query($Upsql, 0);
                    }    
                }                

                $this->AddUpdateOptionBOMItem($bomID,$opID,$arryDetails,$i);
            }    
        }
            //die;
            return 1;
    }

    function RemoveOptionBOM($id) {

        $strSQLQuery = "DELETE FROM inv_bom_cat WHERE optionID = '" . $id."'";
        $rs = $this->query($strSQLQuery, 0);
        $strSQLQuery2 = "DELETE FROM inv_item_bom WHERE optionID = '" . $id."'";
        $this->query($strSQLQuery2, 0);
        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function AddOptionCatbakbhoodev($bom_id, $arryDetails) {
        global $Config;
        extract($arryDetails);


        $sql = "insert into inv_bom_cat (option_cat, option_code, option_price,TotalValue,qty, req_status, description1, description2) values('" . $option_cat . "','" . addslashes($option_code) . "', '" . addslashes($option_price) . "','" . $TotalValue . "','" . $option_qty . "', '" . addslashes($req_status) . "', '" . addslashes($description_one) . "', '" . addslashes($description_two) . "')";
        $this->query($sql, 0);
        $opID = $this->lastInsertId();

        if ($opID > 0) {
            $Upsql = "update inv_bom_cat set bomID='" . $bom_id . "'  where optionID='" . $opID."'";
            $this->query($Upsql, 0);
        }



        return $opID;
    }

 function AddOptionCat($bom_id, $arryDetails) {
        global $Config;
        extract($arryDetails);
        
          
       for ($i = 1; $i<=$optionNumLine; $i++) {
           
        $sql = "insert into inv_bom_cat (option_cat, option_code, option_price,TotalValue,qty, req_status, description1, description2) values('" . $option_cat . "','" . $arryDetails['option_code'.$i] . "', '" . addslashes($option_price) . "','" . $TotalValue . "','" . $option_qty . "', '" . addslashes($req_status) . "', '" . $arryDetails['description_one'.$i] . "', '" . addslashes($description_two) . "')";
        $this->query($sql, 0);
        $opID = $this->lastInsertId();

        if ($opID > 0) {
            $Upsql = "update inv_bom_cat set bomID='" . $bom_id . "'  where optionID='" . $opID."'";
            $this->query($Upsql, 0);
            
            $this->AddUpdateOptionBOMItem($bom_id,$opID,$arryDetails,$i);
        }


              // }
        //return $opID;
    }//die;
    }
	
	//By chetan 26Nov//
    function GetOptionStock($bomID, $optionID) {
	$strAddQuery = '';
        $strAddQuery .= (!empty($optionID)) ? (" and optionID='" . $optionID."'") : ("");
        $strAddQuery .= (!empty($bomID)) ? (" and bomID='" . $bomID."'") : ("");
        $strSQLQuery = "select * from inv_item_bom  where 1 " . $strAddQuery . " order by orderby asc";
        return $this->query($strSQLQuery, 1);
    }

    function getTotalQtySum($ItemID) {

        $strSQLQuery = "Select SUM(qty) as totalQty from `inv_stock_adjustment`";
        $strSQLQuery .= "where 1";
        $strSQLQuery .= ($ItemID > 0) ? (" and `item_id` ='" . $ItemID . "'") : ("");

        $rs = $this->query($strSQLQuery, 1);
        if ($rs[0]['totalQty']) {
            return $rs[0]['totalQty'];
        }
    }

    function updateStockQty($arryDetails) {

        global $Config;
        extract($arryDetails);



        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['item_id' . $i])) {


                $totalQTY = $this->getTotalQtySum($arryDetails['item_id' . $i]);


                $id = $arryDetails['id' . $i];
                if ($arryDetails['Status'] == 2) {
                    $sql = "update inv_items set qty_on_hand='" . $totalQTY . "',average_cost='" . $arryDetails['price' . $i] . "'  where ItemID='" . $arryDetails['item_id' . $i]. "'";
                } else if ($arryDetails['Status'] == 1) {

                    $sql = "update inv_items set allocated_qty='" . $totalQTY . "',average_cost='" . $arryDetails['price' . $i] . "'  where ItemID='" . $arryDetails['item_id' . $i]. "'";
                }
                $this->query($sql, 0);
            }
        }




        //$exequery = mysql_fetch_array($strSQLQuery);
    }

    function isBomSkuExists($BomSku, $edit) {
        $strSQLQuery = "select bomID from inv_bill_of_material where LCASE(Sku)='" . strtolower(trim($BomSku)) . "' ";
        $strSQLQuery .= ($edit > 0) ? (" and bomID != '" . $edit . "'") : ("");
        //echo $strSQLQuery;exit;
        $arryRow = $this->query($strSQLQuery, 1);
	#echo $bomID  = $arryRow[0]['bomID']; exit;
	//$item_id  = $arryRow[0]['item_id'];
       if (!empty($arryRow[0]['bomID'])) {
            return true;
	
        } else {
            return false;
        }
    }

    function isOptionCodeExists($OptionCode, $edit) {
        $strSQLQuery = "select optionID from inv_bom_cat where LCASE(option_code)='" . strtolower(trim($OptionCode)) . "'";
        $strSQLQuery .= ($edit > 0) ? (" and optionID != '" . $edit . "'") : ("");
        #echo $strSQLQuery;exit; 
        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['optionID'])) {
            return true;
        } else {
            return false;
        }
    }

    function isBomCodeExists($bom_code, $edit) {
        $strSQLQuery = "select bomID from inv_bill_of_material where LCASE(bom_code)='" . strtolower(trim($bom_code)) . "'";
        $strSQLQuery .= ($edit > 0) ? (" and bomID != '" . $edit . "'") : ("");
        #echo $strSQLQuery;exit; 
        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['bomID'])) {
            return true;
        } else {
            return false;
        }
    }

    /*     * *************** End BOM ********************** */

    function GetSerialNumberCount($Sku, $identifier) {
        $strSQLQuery = "Select count( serialID ) as totalSerial from `inv_serial_item`";
        $strSQLQuery .= "where 1";
        $strSQLQuery .= (!empty($Sku)) ? (" and `Sku` ='" . $Sku . "'") : ("");
        $strSQLQuery .= ($identifier > 0) ? (" and `identifier` ='" . $identifier . "'") : ("");


        $rs = $this->query($strSQLQuery, 1);

        return $rs[0]['totalSerial'];
    }

    function getPrefix($prefixID) {

        $strSQLQuery = "SELECT * FROM inv_prefix where prefixID= '" . $prefixID . "'";
        //echo $strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    /*     * **************** Assembly*************** */

    function ListAssemble($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.asmID='" . $id. "'") : (" where 1 ");
        $strAddQuery .= (!empty($Status)) ? (" and a.Status='" . $Status . "'") : (" ");
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
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by a.asmID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");
        $strSQLQuery = "select a.*,i.Sku,i.Condition,i.description,i.itemType,i.evaluationType,w.warehouse_name,w.warehouse_code from inv_assembly a left outer join  inv_items  i on i.Sku=a.Sku left outer join  w_warehouse  w on a.warehouse_code=w.WID   " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }

    /*
      function LastAssembleID() {

      $strSQLQuery = "SELECT MAX( id ) FROM subscription";
      $rs = $this->query($strSQLQuery, 0);
      $strSQLQuery2 = "DELETE FROM inv_item_assembly WHERE asmID = '" . $id. "'";
      $this->query($strSQLQuery2, 0);
      if (sizeof($rs))
      return true;
      else
      return false;
      } */

    function RemoveAssemble($id) {

        $strSQLQuery = "DELETE FROM inv_assembly WHERE asmID = '" . $id. "'";
        $rs = $this->query($strSQLQuery, 0);
        $strSQLQuery2 = "DELETE FROM inv_item_assembly WHERE asmID = '" . $id. "'";
        $this->query($strSQLQuery2, 0);
        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function AddAssemble($arryDetails) {
        global $Config;
        extract($arryDetails);
        
       

        if (empty($Currency))
            $Currency = $Config['Currency'];

        $strSQLQuery = "insert into inv_assembly(warehouse_code,assembly_qty,item_id,Sku,unit_cost,total_cost,on_hand_qty,asmDate,created_by,created_id,Status,serial_name,serial_qty,bomCondition,serial_Price,serial_desc,Comment,binlocation) 
				values('" . $warehouse . "','" . $assembly_qty . "','" . $item_id . "', '" . $Sku . "',  '" . $price . "', '" . $TotalValue . "', '" . $on_hand_qty . "', '" . $Config['TodayDate'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['AdminID'] . "','" . $Status . "','" . $serial_value . "','" . $serial_qty . "','".$bomCondition."','".$serial_Price."','".addslashes($serial_desc)."','" . addslashes($Comment) . "','".addslashes($binlocation)."')";
//Comment='" . addslashes($Comment) . "',

        $this->query($strSQLQuery, 0);
        $materialID = $this->lastInsertId();
        if ($materialID > 0) {
            //$rs=$this->getPrefix(1);

            $PrefixAD = "ASM";


            $ModuleIDValue = $PrefixAD . '-000' . $materialID;
            $strSQL = "update inv_assembly set asm_code='" . $ModuleIDValue . "' where asmID='" . $materialID. "'";
            $this->query($strSQL, 0);
            
            
           
            

            if ($Status == 2) {
                
                
                    //SET TRANSACTION DATA

                        $arryTransaction['TransactionOrderID'] = $materialID;
                        $arryTransaction['TransactionInvoiceID'] = $ModuleIDValue;
                        $arryTransaction['TransactionDate'] = $Config['TodayDate'];
                        $arryTransaction['TransactionType'] = 'Assemble';

                        $objItem = new items();
                        $objItem->addItemTransaction($arryTransaction,$arryDetails,$type='ASM');


                    //END TRANSACTION DATA


                /************** Add Serial Number ************************ */
                if ($arryDetails['serial_value'] != '') {
                    //$serial_no = explode(",", $arryDetails['serial_Num']);
										$serial_no_add = explode("|", $arryDetails['serial_value']);
										$serial_price = explode("|", $arryDetails['serialPrice']);
                    $serial_des = explode("|", $arryDetails['serialdesc']);
$SRP = $TotalValue/$assembly_qty;
//$arryDetails['warehouse'] =1;
                    for ($j = 0; $j <= sizeof($serial_no_add); $j++) {
                       // $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,disassembly)  values ('" . $warehouse . "','" . $serial_no[$j] . "','" . $Sku . "','" . $materialID . "')";
 $strSQLQuery = "insert into inv_serial_item (adjustment_no,warehouse,serialNumber,Sku,assembleID,`Condition`,description,type,UnitCost,ReceiptDate,binid)  values ('".$adjustID."','" . $arryDetails['warehouse'] . "','" . $serial_no_add[$j] . "','" . $Sku . "','" . $materialID . "','".$bomCondition."','" . addslashes($serial_desc[$j]) . "','Assemble', '".$SRP."','".$Config['TodayDate']."','" . addslashes($binlocation) . "')";


                        $this->query($strSQLQuery, 0);
                        //echo   $serial_no[$i]."<br/>"; 
                    }
                }
            

                $strAsmSQL = "update inv_bill_of_material set AsmCount = AsmCount+1 where sku='" . $Sku . "'";
                $this->query($strAsmSQL, 0);
                /****************Update Bin Location**************/
                 $strSQLBinItem = "update `inv_bin_stock` set quantity = quantity+" . $assembly_qty . " where Wcode ='".$warehouse."' and Sku='" . $Sku . "' order by id LIMIT 1";
                 $this->query($strSQLBinItem, 0);
                /****************End Bin Location**************/
                 /****************Update Item Qty**************/
                $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand+" . $assembly_qty . " where Sku='" . $Sku . "'";
                $this->query($strSQLItem, 0);
           /****************End Item Qty**************/
    /*********Added By karishma based on Condition 6 Jan 2016*********************/
					//if($bomCondition!=''){
$strAddQueryQty .= (!empty($arryDetails['warehouse'])) ? (" and WID='".$arryDetails['warehouse']."'") : ("");
$strAddQueryQty .= (!empty($bomCondition)) ? (" and `condition`='".$bomCondition."'") : ("");
$strAddQueryQty .= (!empty($binlocation)) ? (" and binid='".$binlocation."'") : ("");

						 /*$sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($Sku) . "' and ItemID='" . addslashes($item_id) . "'
						and `condition`='".addslashes($bomCondition)."' and WID = '" . $arryDetails['warehouse'] . "' ";*/
 $sql="select count(*) as total from inv_item_quanity_condition where Sku='" . addslashes($Sku) . "' and ItemID='" . addslashes($item_id) . "' ".$strAddQueryQty." ";

						$restbl=$this->query($sql, 1);
						if($restbl[0]['total']==0){
							//If not find insert in tbl
							$strSQLQuery = "insert into inv_item_quanity_condition 
							(ItemID,`condition`,Sku,type,condition_qty,WID,binid)  
							values ('" . addslashes($item_id) . "',
							'" . addslashes($bomCondition) . "',
							'" . addslashes($Sku) . "','Assembly',
							'" . addslashes($assembly_qty) . "','" . $arryDetails['warehouse'] . "','".addslashes($binlocation)."')";
							$this->query($strSQLQuery, 0);
						}else{
							// update in tbl
						//	$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $assembly_qty . "  where Sku='" . $Sku . "' and `condition` = '".$bomCondition."' and WID='" . $arryDetails['warehouse'] . "'";
$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $assembly_qty . "  where Sku='" . $Sku . "' ".$strAddQueryQty."";
							$this->query($UpdateQtysql, 0);
							
						}
					//}
					
					
					/*********End By karishma based on Condition*********************/
        }
      }

        return $materialID;
    }

    function UpdateAssemble($arryDetails) {
        global $Config;
        extract($arryDetails);



        /* if($Closed==1){
          $Status="Closed"; $ClosedDate=$Config['TodayDate'];
          }else{
          $Status="In Process"; $ClosedDate='';
          }
         */

        $strSQLQuery = "update inv_assembly set warehouse_code='" . addslashes($warehouse) . "',
			item_id='" . $item_id . "', 
			Sku='" . $Sku . "', 
			unit_cost='" . $price . "',
			total_cost='" . $TotalValue . "',
			on_hand_qty='" . $on_hand_qty . "', 
			description='" . addslashes($description) . "', 
			Comment='" . addslashes($Comment) . "', 
			UpdatedDate = '" . $Config['TodayDate'] . "',
			Status      = '" . $Status . "',
      bomCondition      = '" . $bomCondition . "',
			assembly_qty = '" . $assembly_qty . "',binlocation ='".$binlocation."'
			where asmID='" . $asmID. "'";

        $this->query($strSQLQuery, 0);

        if ($Status == 2) {
            $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand+'" . $assembly_qty . "' where Sku='" . $Sku . "'";
            $this->query($strSQLItem, 0);
            

 /*********Added By karishma based on Condition 6 Jan 2016*********************/
					//if($bomCondition!=''){
	            $strAddQueryQty .= (!empty($arryDetails['warehouse'])) ? (" and WID='".$arryDetails['warehouse']."'") : ("");
							$strAddQueryQty .= (!empty($bomCondition)) ? (" and `condition`='".$bomCondition."'") : ("");
							$strAddQueryQty .= (!empty($binlocation)) ? (" and binid='".$binlocation."'") : ("");

						 /*$sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($Sku) . "' and ItemID='" . addslashes($item_id) . "'
						and `condition`='".addslashes($bomCondition)."'  and WID = '".$arryDetails['warehouse']."' ";*/
$sql="select count(*) as total from inv_item_quanity_condition where 	Sku='" . addslashes($Sku) . "' and ItemID='" . addslashes($item_id) . "'
						".$strAddQueryQty." ";

						$restbl=$this->query($sql, 1);

						if($restbl[0]['total']==0){
							//If not find insert in tbl
							$strSQLQuery = "insert into inv_item_quanity_condition 
							(ItemID,`condition`,Sku,type,condition_qty,WID,binid)  
							values ('" . addslashes($item_id) . "',
							'" . addslashes($bomCondition) . "',
							'" . addslashes($Sku) . "','Assembly',
							'" . addslashes($assembly_qty) . "','".$arryDetails['warehouse']."','".$binlocation."')";
							$this->query($strSQLQuery, 0);
						}else{
							// update in tbl
							//$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $assembly_qty . "  where Sku='" . $Sku . "' and `condition` = '".$bomCondition."' and WID = '".$arryDetails['warehouse']."'";

$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $assembly_qty . "  where Sku='" . $Sku . "' ".$strAddQueryQty."";

							$this->query($UpdateQtysql, 0);
							
						}
					//}
					
	/**********************update 10-12-2017*************/			
	$serial_noum = explode("|", $arryDetails['serial_value']);
	$serial_desc = explode("|", $arryDetails['serial_desc']);
	$serial_price = explode("|", $arryDetails['serial_Price']);
	//if($arryDetails['valuationType']=='Serialized Average' || $arryDetails['valuationType']=='Serialized'){	
//$warehouse=$arryDetails['warehouse'];
	if($arryDetails['serial_value' ]!=''){						
				for ($j = 0; $j <= sizeof($serial_noum) - 1; $j++) {
if($serial_noum[$j]!=''){
				$TotCost = $TotalValue/$assembly_qty;
				$srPrice = $TotCost;

				$SQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,assembleID,`Condition`,description,type,UnitCost,ReceiptDate,binid)  values ('" . $warehouse . "','" . $serial_noum[$j] . "','" . addslashes($Sku) . "','" . $asmID . "','".$bomCondition."','" . addslashes($serial_desc[$j]) . "','Assemble', '".$srPrice."','".$Config['TodayDate']."','".$binlocation."')";
				$this->query($SQLQuery, 0);
}
				//echo   $serial_no[$i]."<br/>"; 
				}

	/**********************update 10-12-2017*************/
 }


					/*********End By karishma based on Condition*********************/





            $strSQLBinItem = "update `inv_bin_stock` set quantity = quantity+" . $assembly_qty . " where Wcode ='".$warehouse."' and Sku='" . $Sku . "' order by id LIMIT 1";
                 $this->query($strSQLBinItem, 0);
                 
                 
                 //SET TRANSACTION DATA

                        $arryTransaction['TransactionOrderID'] = $asmID;
                        $arryTransaction['TransactionInvoiceID'] = $ModuleIDValue;
                        $arryTransaction['TransactionDate'] = $Config['TodayDate'];
                        $arryTransaction['TransactionType'] = 'Assemble';

                        $objItem = new items();
                        $objItem->addItemTransaction($arryTransaction,$arryDetails,$type='ASM');


                    //END TRANSACTION DATA
        }

        return 1;
    }

    function AddAssembleItem($AID, $arryDetails) {
        global $Config;
        extract($arryDetails);




        if (!empty($DelItem)) {
            $strSQLQuery = "delete from inv_item_assembly where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }

        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);
if($arryDetails['WID' . $i]==''){ $arryDetails['WID' . $i]=1;}
                $id = $arryDetails['id' . $i];
                /* if($id>0){
                  $sql = "update inv_item_assembly set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', wastageQty='".addslashes($arryDetails['Wastageqty'.$i])."', asm_qty='".addslashes($arryDetails['qty'.$i])."', unit_cost='".addslashes($arryDetails['price'.$i])."', total_Assemble_cost='".addslashes($arryDetails['amount'.$i])."'  where id=".$id;
                  }else{ */
                $sql = "insert into inv_item_assembly (asmID,bomID,bom_refID, item_id, sku, description,valuationType,available_qty, qty, unit_cost, total_bom_cost,serial,`Condition`,req_item,serialPrice,serialdesc,binloc,WID) values('" . $AID . "','" . $bomID . "','" . $id . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "','" . addslashes($arryDetails['valuationType' . $i]) . "','" . addslashes($arryDetails['on_hand' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['serial_value' . $i]) . "', '" . addslashes($arryDetails['Condition' . $i]) . "','" . addslashes($arryDetails['req_item' . $i]) . "','" . addslashes($arryDetails['serialPrice' . $i]) . "','" . addslashes($arryDetails['serialdesc' . $i]) . "','" . addslashes($arryDetails['binloc' . $i]) . "','" . addslashes($arryDetails['WID' . $i]) . "')";

                //}
                $this->query($sql, 0);
   if ($arryDetails['Status'] == 2) {
                    $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand-'" . $arryDetails['qty' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($strSQLItem, 0);

/*********Added By karishma based on Condition 6 Jan 2016*********************/
					//if($arryDetails['Condition' . $i]!=''){
            $strAddQueryQty .= (!empty($arryDetails['WID' . $i])) ? (" and WID='".$arryDetails['WID' . $i]."'") : ("");
						$strAddQueryQty .= (!empty($arryDetails['Condition' . $i])) ? (" and `Condition`='".$arryDetails['Condition' . $i]."'") : ("");
						$strAddQueryQty .= (!empty($arryDetails['binloc' . $i])) ? (" and binloc='".$arryDetails['binloc' . $i]."'") : ("");


            $strAddQueryQtySerial .= (!empty($arryDetails['WID' . $i])) ? (" and warehouse='".$arryDetails['WID' . $i]."'") : ("");
						$strAddQueryQtySerial .= (!empty($arryDetails['Condition' . $i])) ? (" and `Condition`='".$arryDetails['Condition' . $i]."'") : ("");
						$strAddQueryQtySerial .= (!empty($arryDetails['binloc' . $i])) ? (" and binid='".$arryDetails['binloc' . $i]."'") : ("");


						 /*$sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['sku' . $i]) . "' and ItemID='" . addslashes($arryDetails['item_id' . $i]) . "'
						and `condition`='".addslashes($arryDetails['Condition' . $i])."' and WID = '".$arryDetails['warehouse']."' "; */
          $sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['sku' . $i]) . "' and ItemID='" . addslashes($arryDetails['item_id' . $i]) . "'
							".$strAddQueryQty." ";
						$restbl=$this->query($sql, 1);
						if($restbl[0]['total']>0){
							// update in tbl
							//$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "' and `condition` = '".$arryDetails['Condition' . $i]."' and WID = '".$arryDetails['warehouse']."'";
$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "' ".$strAddQueryQty."";

							$this->query($UpdateQtysql, 0);
						}
					
	
	$serial_no = explode(",",trim($arryDetails['serial_value' . $i]));
	//$resultSr = "'" . implode ( "', '", $serial_no ) . "'";
	for ($k = 0; $k < sizeof($serial_no); $k++) {

	//$strSQL = "update inv_serial_item set UsedSerial = '1' where serialNumber='".$serial_no[$k]."' and Sku ='" . addslashes($arryItem[$Count]["sku"]) ."' and `Condition` = '".addslashes($arryItem[$Count]["Condition"])."' and warehouse = '".$arryDetails['WID' . $i]."'"; 
	$strSQL = "update inv_serial_item set UsedSerial = '1',Status=0,OrderID='".$AID."',SelectType='Dassemble' where serialNumber='".trim($serial_no[$k])."' and Sku ='" . addslashes($arryDetails['sku' . $i]) ."' and `Condition`='".$arryDetails['Condition' . $i]."' and warehouse = '".$arryDetails['warehouse']."'  "; 

	//$strSQL = "update inv_serial_item set UsedSerial = '1',assembleID='".$AID."',OrderID ='".$AID."',SelectType='ASM where serialNumber IN(".trim($resultSr).") and Sku ='" . addslashes($arryDetails['sku' . $i]) ."' ".$strAddQueryQtySerial."  "; 

	$this->query($strSQL, 0);

				}
					
					/*********End By karishma based on Condition*********************/
                }
            }
        }

        return true;
    }

    function AddUpdateAssembleItem($AID, $arryDetails) {
        global $Config;
        extract($arryDetails);




        if (!empty($DelItem)) {
            $strSQLQuery = "delete from inv_item_assembly where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }

        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);
if($arryDetails['WID' . $i]==''){ $arryDetails['WID' . $i]=1;}
                $id = $arryDetails['id' . $i];
                if ($id > 0) {
                    $sql = "update inv_item_assembly set item_id='" . $arryDetails['item_id' . $i] . "', sku='" . addslashes($arryDetails['sku' . $i]) . "', description='" . addslashes($arryDetails['description' . $i]) . "', qty='" . addslashes($arryDetails['qty' . $i]) . "', unit_cost='" . addslashes($arryDetails['price' . $i]) . "', total_bom_cost='" . addslashes($arryDetails['amount' . $i]) . "' ,serial='" . addslashes($arryDetails['serial_value' . $i]) . "',`Condition` = '" . addslashes($arryDetails['Condition' . $i]) . "',req_item='" . addslashes($arryDetails['req_item' . $i]) . "',binloc='" . addslashes($arryDetails['binloc' . $i]) . "',WID='" . addslashes($arryDetails['WID' . $i]) . "'  where id='" . $id. "'";
                } else {

                    $sql = "insert into inv_item_assembly (asmID,bomID,bom_refID, item_id, sku, description,valuationType,available_qty, qty, unit_cost, total_bom_cost,serial,`Condition`,req_item,binloc,WID) values('" . $AID . "','" . $bomID . "','" . $id . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "','" . addslashes($arryDetails['valuationType' . $i]) . "','" . addslashes($arryDetails['on_hand' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['serial_value' . $i]) . "','" . addslashes($arryDetails['Condition' . $i]) . "','" . addslashes($arryDetails['req_item' . $i]) . "','" . addslashes($arryDetails['binloc' . $i]) . "','" . addslashes($arryDetails['WID' . $i]) . "')";
                }
                $this->query($sql, 0);
                if ($arryDetails['Status'] == 2) {
                    $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand-'" . $arryDetails['qty' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($strSQLItem, 0);

/*********Added By karishma based on Condition 6 Jan 2016*********************/
					//if($arryDetails['Condition' . $i]!=''){
            $strAddQueryQty .= (!empty($arryDetails['WID' . $i])) ? (" and WID='".$arryDetails['WID' . $i]."'") : ("");
						$strAddQueryQty .= (!empty($arryDetails['Condition' . $i])) ? (" and `Condition`='".$arryDetails['Condition' . $i]."'") : ("");
						$strAddQueryQty .= (!empty($arryDetails['binloc' . $i])) ? (" and binid='".$arryDetails['binloc' . $i]."'") : ("");

            $strAddQueryQtySerial .= (!empty($arryDetails['WID' . $i])) ? (" and warehouse='".$arryDetails['WID' . $i]."'") : ("");
						$strAddQueryQtySerial .= (!empty($arryDetails['Condition' . $i])) ? (" and `Condition`='".$arryDetails['Condition' . $i]."'") : ("");
						$strAddQueryQtySerial .= (!empty($arryDetails['binloc' . $i])) ? (" and binid='".$arryDetails['binloc' . $i]."'") : ("");

						 /*$sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['sku' . $i]) . "' and ItemID='" . addslashes($arryDetails['item_id' . $i]) . "'
						and `condition`='".addslashes($arryDetails['Condition' . $i])."' and WID ='".$arryDetails['warehouse']."' "; */

$sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['sku' . $i]) . "' and ItemID='" . addslashes($arryDetails['item_id' . $i]) . "'
						".$strAddQueryQty." "; 

						$restbl=$this->query($sql, 1);
						if($restbl[0]['total']>0){
							// update in tbl
							//$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "' and `condition` = '".$arryDetails['Condition' . $i]."'  and WID ='".$arryDetails['warehouse']."' ";
$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "' ".$strAddQueryQty." ";

							$this->query($UpdateQtysql, 0);
						}
					//}
					//echo "Subtract"; exit;
	
				$serial_no = explode(",",trim($arryDetails['serial_value' . $i]));
        //$resultSr = "'" . implode ( "', '", $serial_no ) . "'";
			for ($k = 0; $k < sizeof($serial_no); $k++) {
							 
				//$strSQL = "update inv_serial_item set UsedSerial = '1' where serialNumber='".$serial_no[$j]."' and Sku ='" . addslashes($arryItem[$Count]["sku"]) ."' and `Condition` = '".addslashes($arryItem[$Count]["Condition"])."' and warehouse='".$arryDetails['WID' . $i]."'"; 
				//$strSQL = "update inv_serial_item set UsedSerial = '1' where serialNumber IN(".trim($resultSr).") and Sku ='" . addslashes($arryDetails['sku' . $i]) ."' and `Condition`='".$arryDetails['Condition' . $i]."' and warehouse='".$arryDetails['warehouse']."' "; 

	//$strSQL = "update inv_serial_item set UsedSerial = '1',assembleID='".$AID."',OrderID ='".$AID."',SelectType='ASM' where serialNumber IN(".trim($resultSr).") and Sku ='" . addslashes($arryDetails['sku' . $i]) ."' ".$strAddQueryQtySerial." "; 



$strSQL = "update inv_serial_item set UsedSerial = '1',Status=1,OrderID='".$AID."',SelectType='Dassemble' where serialNumber='".trim($serial_no[$k])."' and Sku ='" . addslashes($arryDetails['sku' . $i]) ."' and `Condition`='".$arryDetails['Condition' . $i]."' and warehouse = '".$arryDetails['warehouse']."'  ";


								$this->query($strSQL, 0);

				}
					
					/*********End By karishma based on Condition*********************/
                }
            }
        }

        return true;
    }

    function GetAssembleStock($asmID) {
	$strAddQuery = '';
        $strAddQuery .= (!empty($asmID)) ? (" and asmID='" . $asmID. "'") : ("");
        $strSQLQuery = "select * from inv_item_assembly  where 1" . $strAddQuery . " order by id asc";
        return $this->query($strSQLQuery, 1);
    }

    function isSkuNameExists($Sku, $asmID) {


        $strSQLQuery = "select asmID from inv_assembly where LCASE(Sku)='" . strtolower(trim($Sku)) . "'";

        $strSQLQuery .= ($asmID > 0) ? (" and asmID != '" . $asmID . "'") : ("");


        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['asmID'])) {
            return true;
        } else {
            return false;
        }
    }

    function ListOptionBill($arryDetails) {
        extract($arryDetails);
        $strAddQuery = '';
        $SearchKey = strtolower(trim($key));
        $strAddQuery = "where 1 ";
        $strAddQuery .= (!empty($optionID)) ? (" and o.optionID='" . $optionID. "'") : ("  ");
        $strAddQuery .= (!empty($edit)) ? (" and o.bomID='" . $edit. "'") : ("  ");
        $strAddQuery .= (!empty($view)) ? (" and o.bomID='" . $view. "'") : ("  ");
        $strAddQuery .= (!empty($bc)) ? (" and o.bomID='" . $bc. "'") : ("  ");


        $strAddQuery .= (!empty($SearchKey)) ? (" and ( o.option_code like '%" . $SearchKey . "%'   ) " ) : ("");


        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by o.optionID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

        $strSQLQuery = "select o.* from  `inv_bom_cat` o  " . $strAddQuery;
#echo $strSQLQuery;

        return $this->query($strSQLQuery, 1);
    }

    function GetOptionBill($optionID, $bom) {
        $strAddQuery = "where 1 ";
        $strAddQuery .= (!empty($optionID)) ? (" and o.optionID='" . $optionID. "'") : ("  ");
        $strAddQuery .= (!empty($bom)) ? (" and o.bomID='" . $bom. "'") : ("  ");
        $strSQLQuery = "select o.* from  `inv_bom_cat` o  " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }

///// Disassembly


    function ListDisassemble($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.DsmID='" . $id. "'") : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and a.Status='".$Status."'"):(" ");
        if ($SortBy == 'id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (a.DsmID = '" . $SearchKey . "')") : ("");
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
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( a.DsmCode like '%" . $SearchKey . "%' or a.Sku like '%" . $SearchKey . "%' or i.description like '%" . $SearchKey . "%' or a.WarehouseCode like '%" . $SearchKey . "%' or w.warehouse_name like '%" . $SearchKey . "%' ) " ) : ("");
            }
        }
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by a.DsmID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");
        $strSQLQuery = "select a.*,i.Sku,i.description,i.itemType,i.evaluationType,w.warehouse_name,w.warehouse_code from inv_disassembly a left outer join  inv_items  i on i.Sku=a.Sku left outer join  w_warehouse  w on a.WarehouseCode=w.WID " . $strAddQuery;
#echo $strSQLQuery; exit;
        return $this->query($strSQLQuery, 1);
    }

    function RemoveDisassemble($id) {

        $strSQLQuery = "DELETE FROM inv_disassembly WHERE DsmID = '" . $id . "'";
        $rs = $this->query($strSQLQuery, 0);
        $strSQLQuery2 = "DELETE FROM inv_item_disassembly WHERE DsmID = '" . $id . "'";
        $this->query($strSQLQuery2, 0);
        if (sizeof($rs))
            return true;
        else
            return false;
    }

 function UpdateDisassemble($arryDetails) {
        global $Config;
        extract($arryDetails);



        /* if($Closed==1){
          $Status="Closed"; $ClosedDate=$Config['TodayDate'];
          }else{
          $Status="In Process"; $ClosedDate='';
          }
         */

          $strSQLQuery = "update inv_disassembly set WarehouseCode='" . addslashes($warehouse) . "',
																										item_id='" . $item_id . "', 
																										Sku='" . $Sku . "', 
																										unit_cost='" .$price."',
																										total_cost='" . $TotalValue . "',
																										total_dis_cost ='".$total_dis_cost."',
																										on_hand_qty='" . $on_hand_qty . "', 
																										description='" . addslashes($description) . "', 
																										UpdatedDate = '" . $Config['TodayDate'] . "',
																										Status      = '" . $Status . "',
																										serial_Num = '" . $serial_Num . "',
																										bomCondition = '".$bomCondition."',
																										binlocation = '".$binlocation."',
																										disassembly_qty = '" . $disassembly_qty . "'
																										where DsmID='" . $DsmID. "'";

        $this->query($strSQLQuery, 0);


        if ($Status == 2) {

            $strAddQueryQty .= (!empty($arryDetails['warehouse'])) ? (" and WID='".$arryDetails['warehouse']."'") : ("");
						$strAddQueryQty .= (!empty($bomCondition)) ? (" and `condition`='".$bomCondition."'") : ("");
						$strAddQueryQty .= (!empty($binlocation)) ? (" and binid='".$binlocation."'") : ("");

           /*********Added By karishma based on Condition 6 Jan 2016*********************/
					//if($arryDetails['bomCondition']!=''){
						 /*$sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['Sku']) . "' and ItemID='" . addslashes($arryDetails['item_id']) . "'
						and `condition`='".addslashes($arryDetails['bomCondition'])."' "; */

 $sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['Sku']) . "' and ItemID='" . addslashes($arryDetails['item_id']) . "'
						".$strAddQueryQty."  "; 

						$restbl=$this->query($sql, 1);
						if($restbl[0]['total']>0){
							// update in tbl
							 //$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['disassembly_qty'] . "  where Sku='" . $arryDetails['Sku'] . "' and `condition` = '".$arryDetails['bomCondition']."' ";

$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['disassembly_qty'] . "  where Sku='" . $arryDetails['Sku'] . "' ".$strAddQueryQty." ";

							$this->query($UpdateQtysql, 0);
						}
					//}
					//echo "Subtract"; exit;
if($arryDetails['serial_value']!=''){
				$serial_no = explode(",",trim($arryDetails['serial_value']));
$resultSr = "'" . implode ( "', '", $serial_no ) . "'";

            $strAddQuerySerial .= (!empty($arryDetails['warehouse'])) ? (" and warehouse='".$arryDetails['warehouse']."'") : ("");
						$strAddQuerySerial .= (!empty($bomCondition)) ? (" and `Condition`='".$bomCondition."'") : ("");
						$strAddQuerySerial .= (!empty($binlocation)) ? (" and binid='".$binlocation."'") : ("");

				//for ($k = 0; $k < sizeof($serial_no); $k++) {
							 
				//$strSQL = "update inv_serial_item set UsedSerial = '1' where serialNumber='".$serial_no[$j]."' and Sku ='" . addslashes($arryItem[$Count]["sku"]) ."' and `Condition` = '".addslashes($arryItem[$Count]["Condition"])."'"; 
				//$strSQL = "update inv_serial_item set UsedSerial = '1' where serialNumber='".trim($serial_no[$k])."' and Sku ='" . addslashes($arryDetails['Sku']) ."' and `Condition`='".$arryDetails['bomCondition']."' and warehouse=1 "; 

echo $strSQL = "update inv_serial_item set UsedSerial = '1',OrderID='".$materialID."',SelectType='DSM' where serialNumber IN(".trim($resultSr).") and Sku ='" . addslashes($arryDetails['Sku']) ."' ".$strAddQuerySerial." "; 

								$this->query($strSQL, 0);

				//}

}
            /**                 * *********** Exit; ********************************** */
                $strDsmSQL = "update inv_bill_of_material set DsmCount = DsmCount+1 where sku='" . $Sku . "'";
                $this->query($strDsmSQL, 0);
                 /****************Update Bin Location**************/
                 $strSQLBinItem = "update `inv_bin_stock` set quantity = quantity-" . $disassembly_qty . " where Wcode ='".$warehouse."' and Sku='" . $Sku . "' and quantity!='0'  order by id LIMIT 1";
                 $this->query($strSQLBinItem, 0);
                /****************End Bin Location**************/
                $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand-'" . $disassembly_qty . "' where Sku='" . $Sku . "'";
                $this->query($strSQLItem, 0);
                /****************End Bin Location**************/
                 
            //SET TRANSACTION DATA

                    $arryTransaction['TransactionOrderID'] = $DsmID;
                    $arryTransaction['TransactionInvoiceID'] = $ModuleIDValue;
                    $arryTransaction['TransactionDate'] = $Config['TodayDate'];
                    $arryTransaction['TransactionType'] = 'Disassemble';

                    $objItem = new items();
                    $objItem->addItemTransaction($arryTransaction,$arryDetails,$type='DSM');


                    //END TRANSACTION DATA     
                 
        }

        return 1;
    }




    function AddDisassemble($arryDetails) {
        global $Config;
        extract($arryDetails);

        if (empty($Currency))
            $Currency = $Config['Currency'];

        $strSQLQuery = "insert into inv_disassembly  (WarehouseCode,disassembly_qty,item_id,Sku,unit_cost,`total_cost`,`on_hand_qty`,disassemblyDate,created_by,created_id,Status,serial_Num,bomCondition,total_dis_cost,binlocation) 
		        values('".addslashes($warehouse)."','".addslashes($disassembly_qty)."','".addslashes($item_id)."','".addslashes($Sku)."',  '" . addslashes($price) . "', '" . addslashes($TotalValue) . "', '" . $on_hand_qty . "', '" . $Config['TodayDate'] . "','" . $_SESSION['AdminType'] . "','".$_SESSION['AdminID']."','".$Status."','".addslashes($serial_Num)."','".addslashes($bomCondition)."','".addslashes($total_dis_cost)."','".$binlocation."')";


        $this->query($strSQLQuery, 0);
        $materialID = $this->lastInsertId();
        if ($materialID > 0) {
            //$rs=$this->getPrefix(1);




            $PrefixAD = "DSM";


            $ModuleIDValue = $PrefixAD . '-000' . $materialID;
            $strSQL = "update inv_disassembly set DsmCode='" . $ModuleIDValue . "' where DsmID='" . $materialID . "'";
            $this->query($strSQL, 0);




            if ($Status == 2) {
                
                
                
                 //SET TRANSACTION DATA

                    $arryTransaction['TransactionOrderID'] = $materialID;
                    $arryTransaction['TransactionInvoiceID'] = $ModuleIDValue;
                    $arryTransaction['TransactionDate'] = $Config['TodayDate'];
                    $arryTransaction['TransactionType'] = 'Disassemble';

                    $objItem = new items();
                    $objItem->addItemTransaction($arryTransaction,$arryDetails,$type='DSM');


                    //END TRANSACTION DATA


                /************** Add Serial Number ************************ *
                if ($arryDetails['serial_Num'] != '') {
                    $serial_no = explode(",", $arryDetails['serial_Num']);
                    for ($j = 0; $j <= sizeof($serial_no); $j++) {
                        $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,disassembly)  values ('" . $warehouse . "','" . $serial_no[$j] . "','" . $Sku . "','" . $materialID . "')";
                        $this->query($strSQLQuery, 0);
                        //echo   $serial_no[$i]."<br/>"; 
                    }
                }*/


/*********Added By karishma based on Condition 6 Jan 2016*********************/
					//if($arryDetails['bomCondition']!=''){

            $strAddQueryQty .= (!empty($arryDetails['warehouse'])) ? (" and WID='".$arryDetails['warehouse']."'") : ("");
						$strAddQueryQty .= (!empty($bomCondition)) ? (" and `condition`='".$bomCondition."'") : ("");
						$strAddQueryQty .= (!empty($binlocation)) ? (" and binid='".$binlocation."'") : ("");

						 /*$sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['Sku']) . "' and ItemID='" . addslashes($arryDetails['item_id']) . "'
						and `condition`='".addslashes($arryDetails['bomCondition'])."' and WID=1 "; */

 $sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['Sku']) . "' and ItemID='" . addslashes($arryDetails['item_id']) . "'
						".$strAddQueryQty."  "; 



						$restbl=$this->query($sql, 1);
						if($restbl[0]['total']>0){
							// update in tbl
							// $UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['disassembly_qty'] . "  where Sku='" . $arryDetails['Sku'] . "' and `condition` = '".$arryDetails['bomCondition']."' and WID=1 ";

 $UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['disassembly_qty'] . "  where Sku='" . $arryDetails['Sku'] . "' ".$strAddQueryQty." ";


							$this->query($UpdateQtysql, 0);
						}
					//}
					//echo "Subtract"; exit;
if($arryDetails['serial_value']!=''){

$strAddQuerySrQty .= (!empty($arryDetails['warehouse'])) ? (" and warehouse='".$arryDetails['warehouse']."'") : ("");
						$strAddQuerySrQty .= (!empty($bomCondition)) ? (" and `Condition`='".$bomCondition."'") : ("");
						$strAddQuerySrQty .= (!empty($binlocation)) ? (" and binid='".$binlocation."'") : ("");

				$serial_no = explode(",",trim($arryDetails['serial_value']));
 $resultSr = "'" . implode ( "', '", $serial_no ) . "'";
				//for ($k = 0; $k < sizeof($serial_no); $k++) {
							 
				//$strSQL = "update inv_serial_item set UsedSerial = '1' where serialNumber='".$serial_no[$j]."' and Sku ='" . addslashes($arryItem[$Count]["sku"]) ."' and `Condition` = '".addslashes($arryItem[$Count]["Condition"])."'"; 
				$strSQL = "update inv_serial_item set UsedSerial = '1' where serialNumber IN(".trim($resultSr).") and Sku ='" . addslashes($arryDetails['Sku']) ."'  ".$strAddQuerySrQty." "; 
								$this->query($strSQL, 0);

				//}

}





                /**                 * *********** Exit; ********************************** */
                $strDsmSQL = "update inv_bill_of_material set DsmCount = DsmCount+1 where sku='" . $Sku . "'";
                $this->query($strDsmSQL, 0);
                 /****************Update Bin Location**************/
                 $strSQLBinItem = "update `inv_bin_stock` set quantity = quantity-" . $disassembly_qty . " where Wcode ='".$warehouse."' and Sku='" . $Sku . "' and quantity!='0'  order by id LIMIT 1";
                 $this->query($strSQLBinItem, 0);
                /****************End Bin Location**************/
                $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand-'" . $disassembly_qty . "' where Sku='" . $Sku . "'";
                $this->query($strSQLItem, 0);

  
                
                
            }
        }

        return $materialID;
    }

    function AddDisassembleItem($AID, $arryDetails) {
        global $Config;
        extract($arryDetails);

        if (!empty($DelItem)) {
            $strSQLQuery = "delete from inv_item_disassembly where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }

        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);
if($arryDetails['WID' . $i]==''){ $arryDetails['WID' . $i]=1;}
                $id = $arryDetails['id' . $i];
                /* if($id>0){
                  $sql = "update inv_item_disassembly set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', wastageQty='".addslashes($arryDetails['Wastageqty'.$i])."', asm_qty='".addslashes($arryDetails['qty'.$i])."', unit_cost='".addslashes($arryDetails['price'.$i])."', total_Assemble_cost='".addslashes($arryDetails['amount'.$i])."'  where id=".$id;
                  }else{ */

                $sql = "insert into inv_item_disassembly (dsmID,bomID,bom_refID, item_id, sku, description,valuationType,available_qty, qty, unit_cost, total_bom_cost,serial_value,`Condition`,req_item,binloc,WID) values('" . $AID . "','" . $bomID . "','" . $id . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "','" . addslashes($arryDetails['valuationType' . $i]) . "','" . addslashes($arryDetails['on_hand' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['serial_value' . $i]) . "','" . addslashes($arryDetails['Condition' . $i]) . "','" . addslashes($arryDetails['req_item' . $i]) . "','" . addslashes($arryDetails['binloc' . $i]) . "','".$arryDetails['WID' . $i]."')";





                /*                 * ************ Update Qty **************************** */
                if ($arryDetails['Status'] == 2) {

                    /*                     * ************ Add Serial Number ************************ */
                    if ($arryDetails['serial_value' . $i] != '') {
                        $serial_noum = explode(",", $arryDetails['serial_value' . $i]);
												$serial_des = explode(",", $arryDetails['serialdesc' . $i]);
//$arryDetails['warehouse']=1;
                        for ($j = 0; $j <= sizeof($serial_noum) - 1; $j++) {
                            $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,disassembly,`Condition`,type,description,UnitCost,binid)  values ('" . $arryDetails['WID' . $i] . "','" . $serial_noum[$j] . "','" . addslashes($arryDetails['sku' . $i]) . "','" . $AID . "','" . addslashes($arryDetails['Condition' . $i]) . "','disassemble',addslashes($serial_des[$j]),'". addslashes($arryDetails['price' . $i])."','" . addslashes($arryDetails['binloc' . $i]) . "')";
                            $this->query($strSQLQuery, 0);
                            //echo   $serial_no[$i]."<br/>"; 
                        }
                    }
                    /*                     * ************ Exit; ********************************** */



                    $UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+'" . $arryDetails['qty' . $i] . "'  where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($UpdateQtysql, 0);



            $strAddQueryQty .= (!empty($arryDetails['WID' . $i])) ? (" and WID='".$arryDetails['WID' . $i]."'") : (" ");
						$strAddQueryQty .= (!empty($arryDetails['Condition' . $i])) ? (" and `condition`='".$arryDetails['Condition' . $i]."'") : ("");
						$strAddQueryQty .= (!empty($arryDetails['binloc' . $i])) ? (" and binid='".$arryDetails['Condition' . $i]."'") : ("");


 /*********Added By karishma based on Condition 6 Jan 2016*********************/
					//if($arryDetails['Condition' . $i]!=''){
						/* $sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['sku' . $i]) . "' and ItemID='" . addslashes($arryDetails['item_id' . $i]) . "'
						and `condition`='".addslashes($arryDetails['Condition' . $i])."' and WID=1 "; */

 $sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['sku' . $i]) . "' and ItemID='" . addslashes($arryDetails['item_id' . $i]) . "'
						".$strAddQueryQty." ";


						$restbl=$this->query($sql, 1);
						if($restbl[0]['total']==0){
							//If not find insert in tbl
							$strSQLQuery = "insert into inv_item_quanity_condition 
							(ItemID,`condition`,Sku,type,condition_qty,binid,WID)  
							values ('" . addslashes($arryDetails['item_id' . $i]) . "',
							'" . addslashes($arryDetails['Condition' . $i]) . "',
							'" . addslashes($arryDetails['sku' . $i]) . "','Disassembly',
							'" . addslashes($arryDetails['qty' . $i]) . "','" . addslashes($arryDetails['binloc' . $i]) . "','" . addslashes($arryDetails['WID' . $i]) . "')";
							$this->query($strSQLQuery, 0);
						}else{
							// update in tbl
							//$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "' and `condition` = '".$arryDetails['Condition' . $i]."' and WID=1";

$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "' ".$strAddQueryQty."";

							$this->query($UpdateQtysql, 0);
						}
					//}
					
					
					/*********End By karishma based on Condition*********************/

                    $UpdateCostItem = "update inv_item_bom set unit_cost = '" . $arryDetails['price' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($UpdateCostItem, 0);

                    /*                     * ************ Update Unit Cost ************************ */
                    $strSQLItem = "update inv_items set purchase_cost = '" . $arryDetails['price' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($strSQLItem, 0);
                    /*                     * ************ Exit; ********************************** */
                }
                /*                 * ************ Exit; ********************************** */



                /* $sql = "insert into inv_item_disassembly (DsmID, item_id, sku, description, wastageQty, bom_qty, unit_cost, total_bom_cost) values('" . $AID . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "', '" . addslashes($arryDetails['Wastageqty' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "')"; */

                //}
                $this->query($sql, 0);
            }
        }

        return true;
    }

    function AddUpdateDisassembleItem($AID, $arryDetails) {
        global $Config;
        extract($arryDetails);
        if (!empty($DelItem)) {
            $strSQLQuery = "delete from inv_item_disassembly where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }

        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);
if($arryDetails['WID' . $i]==''){ $arryDetails['WID' . $i]=1;}
                $id = $arryDetails['id' . $i];
                if ($id > 0) {
                    $sql = "update inv_item_disassembly set item_id='" . $arryDetails['item_id' . $i] . "', sku='" . addslashes($arryDetails['sku' . $i]) . "', description='" . addslashes($arryDetails['description' . $i]) . "', qty='" . addslashes($arryDetails['qty' . $i]) . "', unit_cost='" . addslashes($arryDetails['price' . $i]) . "', total_bom_cost='" . addslashes($arryDetails['amount' . $i]) . "' ,serial='" . addslashes($arryDetails['serial_value' . $i]) . "',`Condition`='" . addslashes($arryDetails['Condition' . $i]) . "',req_item='" . addslashes($arryDetails['req_item' . $i]) . "',binloc='" . addslashes($arryDetails['binloc' . $i]) . "',WID='".$arryDetails['WID' . $i]."'  where id='" . $id. "'";
                } else {

                    $sql = "insert into inv_item_disassembly (dsmID,bomID,bom_refID, item_id, sku, description,valuationType,available_qty, qty, unit_cost, total_bom_cost,serial_value,`Condition`,req_item,binloc,WID) values('" . $AID . "','" . $bomID . "','" . $id . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "','" . addslashes($arryDetails['valuationType' . $i]) . "','" . addslashes($arryDetails['on_hand' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['serial_value' . $i]) . "','" . addslashes($arryDetails['Condition' . $i]) . "','" . addslashes($arryDetails['req_item' . $i]) . "','" . addslashes($arryDetails['binloc' . $i]) . "','".$arryDetails['WID' . $i]."')";
                }
                $this->query($sql, 0);

                if ($arryDetails['Status'] == 2) {


                    /************** Add Serial Number ************************ */
                    if ($arryDetails['serial_value' . $i] != '') {
											$serial_noum = explode(",", $arryDetails['serial_value' . $i]);
											$serial_desc = explode(",", $arryDetails['serial_desc' . $i]);
//$arryDetails['warehouse'] =1;
                        for ($j = 0; $j <= sizeof($serial_noum) - 1; $j++) {


$strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,UsedSerial,disassembly,`Condition`,type,UnitCost,ReceiptDate,binid)  values ('".$arryDetails['WID' . $i]."','".$serial_noum[$j]."','".addslashes($arryDetails['sku'.$i])."','0','".$AID."','".addslashes($arryDetails['Condition'.$i])."','Receive Order','".$arryDetails['price'.$i]."','".$Config['TodayDate']."','".addslashes($arryDetails['binloc' . $i]) ."')";


                            //$strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,UsedSerial,disassembly,`Condition`,type,UnitCost,description,ReceiptDate)  values ('".$arryDetails['warehouse']."','".$serial_noum[$j]."','".addslashes($arryDetails['sku' . $i])."','0','".$AID."','".addslashes($arryDetails['Condition' . $i])."','Receive Order','".$arryDetails['price' . $i]."','".addslashes($serial_desc[$j])."','".$Config['TodayDate']."')";
                            $this->query($strSQLQuery, 0);
                            //echo   $serial_no[$i]."<br/>"; 
                        }
                    }
                    /************** Exit; ********************************** */


                    $UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+'" . $arryDetails['qty' . $i] . "'  where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($UpdateQtysql, 0);

  /*********Added By karishma based on Condition 6 Jan 2016*********************/
					//if($arryDetails['Condition' . $i]!=''){

	          $strAddQueryQty .= (!empty($arryDetails['WID' . $i])) ? (" and WID='".$arryDetails['WID' . $i]."'") : ("");
						$strAddQueryQty .= (!empty($arryDetails['Condition' . $i])) ? (" and `condition`='".$arryDetails['Condition' . $i]."'") : ("");
						//$strAddQueryQty .= (!empty($arryDetails['binloc' . $i])) ? (" and binid='".$arryDetails['binloc' . $i]."'") : ("");


						  /*$sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['sku' . $i]) . "' and ItemID='" . addslashes($arryDetails['item_id' . $i]) . "'
						and `condition`='".addslashes($arryDetails['Condition' . $i])."' and WID=1 "; */

 $sql="select count(*) as total from inv_item_quanity_condition where 
						(Sku='" . addslashes($arryDetails['sku' . $i]) . "' or ItemID='" . addslashes($arryDetails['item_id' . $i]) . "')
						".$strAddQueryQty."  "; 




						$restbl=$this->query($sql, 1);
						if($restbl[0]['total']==0){
							//If not find insert in tbl
							$strSQLQuery = "insert into inv_item_quanity_condition 
							(ItemID,`condition`,Sku,type,condition_qty,WID,binid)  
							values ('" . addslashes($arryDetails['item_id' . $i]) . "',
							'" . addslashes($arryDetails['Condition' . $i]) . "',
							'" . addslashes($arryDetails['sku' . $i]) . "','Disassembly',
							'" . addslashes($arryDetails['qty' . $i]) . "','".$arryDetails['WID' . $i]."','".addslashes($arryDetails['binloc' . $i]) ."')";
							$this->query($strSQLQuery, 0);
						}else{
							// update in tbl
							//$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "' and `condition` = '".$arryDetails['Condition' . $i]."' and WID=1";

 $UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $arryDetails['qty' . $i]. "  where (Sku='" . $arryDetails['sku' . $i] . "' or ItemID = '".$arryDetails['item_id' . $i]."')  ".$strAddQueryQty." ";


							$this->query($UpdateQtysql, 0);
						}
					//}
					
					
					/*********End By karishma based on Condition*********************/

                    $UpdateCostItem = "update inv_item_bom set unit_cost = '" . $arryDetails['price' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($UpdateCostItem, 0);

                    /*                     * ************ Update Unit Cost ************************ */
                    $strSQLItem = "update inv_items set purchase_cost = '" . $arryDetails['price' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($strSQLItem, 0);
                    /*                     * ************ Exit; ********************************** */
                }
            }
        }

        return true;
    }

    function GetDisassembleStock($DsmID) {
	 $strAddQuery ='';
        $strAddQuery .= (!empty($DsmID)) ? (" and DsmID='" . $DsmID. "'") : ("");
        $strSQLQuery = "select * from inv_item_disassembly  where 1" . $strAddQuery . " order by id asc";
        return $this->query($strSQLQuery, 1);
    }

    function CountSkuSerialNo($Sku) {
        $strSQLQuery = "select count(serialID) as TotalSerial from inv_serial_item where Status='1' and Sku='" . $Sku . "'";
        $arryRow = $this->query($strSQLQuery, 1);

        $sqlInvoiced = "select sum(i.qty_invoiced) as QtyInvoiced from s_order_item i inner join s_order s on i.OrderID=s.OrderID where s.Module='Invoice' and s.InvoiceID!='' and s.SaleID!='' and i.sku='" . $Sku . "' group by i.sku";
        $arryInvoiced = $this->query($sqlInvoiced);
        $NumLeft = $arryRow[0]['TotalSerial'] - $arryInvoiced[0]['QtyInvoiced'];

        if ($NumLeft < 0)
            $NumLeft = 0;
        return $NumLeft;
    }

    function CountSkuSerialNoAndQtyInvoiced($Sku) {
        $strSQLQuery = "select count(serialID) as TotalSerial from inv_serial_item where Status='1' and Sku='" . $Sku . "'";
        $arryRow = $this->query($strSQLQuery, 1);

        $sqlInvoiced = "select sum(i.qty_invoiced) as QtyInvoiced from s_order_item i inner join s_order s on i.OrderID=s.OrderID where s.Module='Invoice' and s.InvoiceID!='' and s.SaleID!='' and i.sku='" . $Sku . "' group by i.sku";
        $arryInvoiced = $this->query($sqlInvoiced);
        $SerialNoAndQtyInvoiced = $arryRow[0]['TotalSerial'] . "#" . $arryInvoiced[0]['QtyInvoiced'];

        return $SerialNoAndQtyInvoiced;
    }
//Serial 
    function selectSerialNumberForItem($Sku) {
        $strSQLQuery = "select * from inv_serial_item where Status='1' and Sku='" . $Sku . "' and UsedSerial = '0' and warehouse='1'";
        return $this->query($strSQLQuery, 1);
    }

    function checkSerializedItem($serialNumber) {
        $strSQLQuery = "select serialNumber from inv_serial_item where serialNumber='" . $serialNumber . "'";
        $arryRow = $this->query($strSQLQuery, 1);

        if (!empty($arryRow[0]['serialNumber'])) {
       	 return $arryRow[0]['serialNumber'];
	}
    }
	function checkSerialDisassemble($serialNumber,$Sku,$Condition='') {
	
		$arryRow =array();
	
		$strAddQuery = (!empty($Condition)) ? (" and `Condition`='" . $Condition. "'") : ("");
		$strSQLQuery = "select serialNumber from inv_serial_item where serialNumber='" . $serialNumber . "' and Sku = '".$Sku."' and UsedSerial = '0' ".$strAddQuery." ";
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['serialNumber']) && $arryRow[0]['serialNumber']!='') {
		   return $arryRow[0]['serialNumber'];
		}
	}
    function addSerailNumberForInvoice($arryDetails) {
        global $Config;
        extract($arryDetails);
        $strSQLQuery = "update inv_serial_item set UsedSerial = '1' where serialNumber = '" . addslashes($serialNumber) . "' and Sku = '" . addslashes($Sku) . "' and warehouse='1' ";
        $this->query($strSQLQuery, 0);
    }
    
       function getBinBySku($Wcode,$Sku){

                    $strAddQuery = (!empty($Wcode))?(" where s.Wcode='".$Wcode."'"):("");
                     $strAddQuery = (!empty($Sku))?(" where s.Sku='".$Sku."'"):("");
                     $strSQLQuery = "select b.*,s.Sku,s.Wcode,s.bin from w_binlocation b inner join inv_bin_stock s on  (s.Wcode!='' and b.warehouse_code = s.Wcode) ".$strAddQuery." ";
                    return $this->query($strSQLQuery, 1);

        }
    
    function NextPrevBom($bomID,$Next) {
		global $Config;
		if($bomID>0){		
			
		
			if($Next==1){
				$operator = "<"; $asc = 'desc';
			}else{
				$operator = ">"; $asc = 'asc';
			}

			$strSQLQuery = "select i.bomID  from inv_bill_of_material i where i.bomID".$operator."'" . $bomID . "'   order by i.bomID ".$asc." limit 0,1";

			$arrRow = $this->query($strSQLQuery, 1);
		if(!empty($arrRow[0]['bomID']))	return $arrRow[0]['bomID'];
		}
	}
    
    	 //By Chetan 18Aug//
        function AddOptionBillCodes($bomID,$arrayPost,$OldBID)
        { 
            global $Config;
            if(count($arrayPost['optionIds'])>0)
            {
                foreach($arrayPost['optionIds'] as $opId)
                {
                    $sql = "INSERT INTO inv_bom_cat (option_cat,bomID, option_code, option_price,TotalValue,qty, req_status, description1, description2)
    select option_cat,".$bomID.", option_code, option_price,TotalValue,qty, req_status, description1, description2  from inv_bom_cat WHERE optionID = '" . $opId . "'";
                    //echo $sql;die;    
                    $this->query($sql, 0);
                    $NewOpID = $this->lastInsertId();
                    
                    $sql2 = "INSERT INTO inv_item_bom (bomID,optionID, item_id, sku, description, wastageQty, bom_qty, unit_cost, total_bom_cost,`Condition`,req_item)
    select ".$bomID.",".$NewOpID.", item_id, sku, description, wastageQty, bom_qty, unit_cost, total_bom_cost,`Condition`,req_item from inv_item_bom WHERE optionID = '" . $opId . "'";
                    //echo $sql;die;    
                    $this->query($sql2, 0);
                }
            }    
        }
    
        //End//


	 //By Chetan 8Sept//
        function GetBomIdByItemId($ItemId) {
		global $Config;
		$strSQLQuery = "select bomID from inv_bill_of_material where item_id = '".$ItemId."'";
                $arrRow = $this->query($strSQLQuery, 1);
		if(isset($arrRow[0]['bomID']))return $arrRow[0]['bomID'];
		
        }    
                
        function RemoveBOMComponent($id,$type) 
        {
            if($type == 'component' )
            {
                $str = " && optionID = ''";
            }else{
                $str = " && optionID != ''";
                $strSQLQuery = "DELETE FROM inv_bom_cat WHERE bomID = '" . $id."'";
                $this->query($strSQLQuery, 0);
            }
            $strSQLQuery2 = "DELETE FROM inv_item_bom WHERE bomID = '" . $id."' ".$str."  ";
            $this->query($strSQLQuery2, 0);

            if (sizeof($rs))
                return true;
            else
                return false;
        }
        //End//
//By chetan 26Nov//
function AddUpdateOptionBOMItem($BID, $opId, $arryDetails,$index) {//$option_ID,//
        global $Config;
        extract($arryDetails);
        //print_r($arryDetails);//die;
        
        if ($opId == '') {
            $strUpSQLQuery = "update inv_bill_of_material set 
				total_cost='" . $TotalValue . "',
				UpdatedDate = '" . $Config['TodayDate'] . "'
				where bomID='" . $BID."'";
            //echo $strUpSQLQuery ;die;

            $this->query($strUpSQLQuery, 0);
        }
   
       
        for ($j = 1; $j<=$arryDetails['newNumberLine'.$index.'']; $j++) {
        
            if (!empty($arryDetails["newsku$index-$j"])) {
               
                $id =  $arryDetails["newid$index-$j"];
                //print_r($id);
                if ($id > 0) {
                         $sql = "update inv_item_bom set orderby = '".$arryDetails["orderby$index-$j"]."', item_id='" . $arryDetails["newitem_id$index-$j"] . "', sku='" . addslashes($arryDetails["newsku$index-$j"]) . "',`Primary`='" .$arryDetails["Primary$index-$j"] . "', description='" . addslashes($arryDetails["newdescription$index-$j"]) . "', wastageQty='" . addslashes($arryDetails["newWastageqty$index-$j"]) . "', bom_qty='" . addslashes($arryDetails["newqty$index-$j"]) . "', unit_cost='" . addslashes($arryDetails["newprice$index-$j"]) . "', total_bom_cost='" . addslashes($arryDetails["newamount$index-$j"]) . "',`Condition`='" . addslashes($arryDetails["newCondition$index-$j"]) . "',req_item='" . addslashes($arryDetails["newreq_item$index-$j"]) . "'  where id='" . $id."'"; 
                        $this->query($sql, 0);
                } 
              else {
                $sql = "insert into inv_item_bom (bomID,optionID, item_id, sku, description, wastageQty, bom_qty, unit_cost, total_bom_cost,`Condition`,req_item,orderby,`Primary`) values('" . $BID . "','" . $opId . "','" . $arryDetails["newitem_id$index-$j"] . "', '" . addslashes($arryDetails["newsku$index-$j"]) . "', '" . addslashes($arryDetails["newdescription$index-$j"]) . "', '" . addslashes($arryDetails["newWastageqty$index-$j"]) . "', '" . addslashes($arryDetails["newqty$index-$j"]) . "', '" . addslashes($arryDetails["newrice$index-$j"]) . "','" . addslashes($arryDetails["newamount$index-$j"]) . "','" . addslashes($arryDetails["newCondition$index-$j"]) . "','" . addslashes($arryDetails["newreq_item$index-$j"] ). "', orderby = '".$arryDetails["orderby$index-$j"]."','" . addslashes($arryDetails["Primary$index-$j"]) . "')";
                $this->query($sql, 0);
      
                    }
                    
            }
               
        
        }
        //die;
        return true;
    }

function GetUnitCost($Sku){

$strSQLQuery = "select purchase_cost from inv_items where  Sku = '".$Sku."'";
        $arryRow = $this->query($strSQLQuery, 1);

        return $arryRow[0]['purchase_cost'];
}

/*********************************Merge Item***********************************************/
 function ListMergeItem($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.id='" . $id. "'") : (" where 1 ");
        
        if ($SortBy == 'id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (a.id = '" . $SearchKey . "')") : ("");
        } else {
            if ($SortBy != '') {
$strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
                /*if ($SortBy == 'a.Status') {
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
                }*/
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (  a.Sku like '%" . $SearchKey . "%' or i.description like '%" . $SearchKey . "%'  ) " ) : ("");
            }
        }
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by a.id ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");
         $strSQLQuery = "select a.*,i.Sku,i.description,i.itemType,i.evaluationType from inv_mergeitem a left outer join  inv_items  i on i.Sku=a.Sku    " . $strAddQuery; 

        return $this->query($strSQLQuery, 1);
    }

 function GetMergeItemStock($ID) {
	$strAddQuery = '';
        //$strAddQuery .= (!empty($asmID)) ? (" and asmID='" . $asmID. "'") : ("");
        $strSQLQuery = "select s.*,i.description,i.itemType,i.evaluationType from inv_mergesubitem s left outer join  inv_items  i on i.Sku=s.sku   where 1" . $strAddQuery . " and RefID='" . $ID. "' order by id asc";
        return $this->query($strSQLQuery, 1);
    }
 function RemoveMergeItem($id) {

        $strSQLQuery = "DELETE FROM inv_mergeitem WHERE id = '" . $id. "'";
        $rs = $this->query($strSQLQuery, 0);
        $strSQLQuery2 = "DELETE FROM inv_mergesubitem WHERE id = '" . $id. "'";
        $this->query($strSQLQuery2, 0);
        if (sizeof($rs))
            return true;
        else
            return false;
    }
function AddMerge($arryDetails) {
        global $Config;
        extract($arryDetails);
        
       
        $strSQLQuery = "insert into inv_mergeitem(ItemID,Sku,AvgCost,ParentCondition,CreateDate,created_by,created_id,ParentPrice,	ParentValuationType,serial_Num,TotalCost,Status) 
				values('" . $ITEM_ID . "', '" . $SKU . "', '" . $TotalValue . "','".$ParentCondition."', '" . $Config['TodayDate'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['AdminID'] . "','".$ParentPrice."','".$ParentValuationType."','".$serial_Num."','".$TotalCost."','".$Status."')";


        $this->query($strSQLQuery, 0);
        $mergeID = $this->lastInsertId();
        if ($mergeID > 0) {

 $sQuery = "update inv_serial_item set UsedMergeItem = '1' where  serialNumber = '".$serial_Num."'"; 
										   $this->query($sQuery, 0);
            //$rs=$this->getPrefix(1);

            //$PrefixAD = "ASM";


            //$ModuleIDValue = $PrefixAD . '-000' . $materialID;
            //$strSQL = "update inv_assembly set asm_code='" . $ModuleIDValue . "' where asmID='" . $materialID. "'";
            //$this->query($strSQL, 0);
            
            
           
            

            if ($Status == 1) {
                
                
                    //SET TRANSACTION DATA

                       // $arryTransaction['TransactionOrderID'] = $materialID;
                       // $arryTransaction['TransactionInvoiceID'] = $ModuleIDValue;
                       // $arryTransaction['TransactionDate'] = $Config['TodayDate'];
                        //$arryTransaction['TransactionType'] = 'Assemble';

                        //$objItem = new items();
                        //$objItem->addItemTransaction($arryTransaction,$arryDetails,$type='ASM');


                    //END TRANSACTION DATA


                /************** Add Serial Number ************************ */
               /* if ($arryDetails['serial_Num'] != '') {
                    $serial_no = explode(",", $arryDetails['serial_Num']);
                    for ($j = 0; $j <= sizeof($serial_no); $j++) {
                        $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,disassembly)  values ('" . $warehouse . "','" . $serial_no[$j] . "','" . $Sku . "','" . $materialID . "')";
                        $this->query($strSQLQuery, 0);
                        
                    }
                }*/
            

              
         
    /*********Added By karishma based on Condition 6 Jan 2016*********************/
					
							// update in tbl
							//$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $assembly_qty . "  where Sku='" . $Sku . "'";
$UpdateQtysql = "update inv_item_quanity_condition set AvgCost = '".$TotalValue."'  where Sku='" . $SKU . "' and `condition` = '".$ParentCondition."' ";
							$this->query($UpdateQtysql, 0);
					
					
					
					/*********End By karishma based on Condition*********************/
        }
      }

        return $mergeID;
    }
function UpdateMergeItem($arryDetails) {
        global $Config;
        extract($arryDetails);




        /* if($Closed==1){
          $Status="Closed"; $ClosedDate=$Config['TodayDate'];
          }else{
          $Status="In Process"; $ClosedDate='';
          }
         */

         $strSQLQuery = "update inv_mergeitem set ItemID='" . $ITEM_ID . "',Sku='" . $SKU . "',	AvgCost='" . $TotalValue . "',ParentCondition = '".$ParentCondition."',ParentValuationType ='".$ParentValuationType."',serial_Num ='".$serial_Num."',ParentPrice = '".$ParentPrice."',TotalCost ='".$TotalCost."',Status='".$Status."'
where id='" . $editID. "'"; 
			//on_hand_qty='" . $on_hand_qty . "', 
			//description='" . addslashes($description) . "', 
			//UpdatedDate = '" . $Config['TodayDate'] . "',
			//Status      = '" . $Status . "',
                        //bomCondition      = '" . $bomCondition . "',
			//assembly_qty = '" . $assembly_qty . "'
			

        $this->query($strSQLQuery, 0);

        if ($Status == 2) {
            $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand+'" . $assembly_qty . "' where Sku='" . $Sku . "'";
            $this->query($strSQLItem, 0);
            

 /*********Added By karishma based on Condition 6 Jan 2016*********************
					if($bomCondition!=''){
						 $sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($Sku) . "' and ItemID='" . addslashes($item_id) . "'
						and `condition`='".addslashes($bomCondition)."' ";
						$restbl=$this->query($sql, 1);
						if($restbl[0]['total']==0){
							//If not find insert in tbl
							$strSQLQuery = "insert into inv_item_quanity_condition 
							(ItemID,`condition`,Sku,type,condition_qty)  
							values ('" . addslashes($item_id) . "',
							'" . addslashes($bomCondition) . "',
							'" . addslashes($Sku) . "','Assembly',
							'" . addslashes($assembly_qty) . "')";
							$this->query($strSQLQuery, 0);
						}else{
							// update in tbl
							$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $assembly_qty . "  where Sku='" . $Sku . "'";
							$this->query($UpdateQtysql, 0);
							
						}
					}
					
					
					*********End By karishma based on Condition*********************/


  


            //$strSQLBinItem = "update `inv_bin_stock` set quantity = quantity+" . $assembly_qty . " where Wcode ='".$warehouse."' and Sku='" . $Sku . "' order by id LIMIT 1";
                 //$this->query($strSQLBinItem, 0);
                 
                 
                 //SET TRANSACTION DATA

                        $arryTransaction['TransactionOrderID'] = $asmID;
                        $arryTransaction['TransactionInvoiceID'] = $ModuleIDValue;
                        $arryTransaction['TransactionDate'] = $Config['TodayDate'];
                        $arryTransaction['TransactionType'] = 'Assemble';

                        $objItem = new items();
                        $objItem->addItemTransaction($arryTransaction,$arryDetails,$type='ASM');


                    //END TRANSACTION DATA
        }

 $sQuery = "update inv_serial_item set UsedMergeItem = '1' where  serialNumber = '".$serial_Num."'"; 
										   $this->query($sQuery, 0);

        return 1;
    }

    function AddMergeItem($AID, $arryDetails) {
        global $Config;
        extract($arryDetails);




        if (!empty($DelItem)) {
            $strSQLQuery = "delete from inv_mergesubitem where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }

        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                

                $id = $arryDetails['id' . $i];
               
                $sql = "insert into inv_mergesubitem (RefID, item_id, sku, qty, price,amount,serial,SubCondition) values('" . $AID . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['serial_number' . $i]) . "','" . addslashes($arryDetails['SubCondition' . $i]) . "')";

               
                $this->query($sql, 0);

                if ($arryDetails['Status'] == 1) {
                    $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand-'" . $arryDetails['qty' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($strSQLItem, 0);

  /*********Added By karishma based on Condition 6 Jan 2016*********************/
					if($arryDetails['Condition' . $i]!=''){
						 $sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['sku' . $i]) . "' and ItemID='" . addslashes($arryDetails['item_id' . $i]) . "'
						and `condition`='".addslashes($arryDetails['Condition' . $i])."' "; 
						$restbl=$this->query($sql, 1);
						if($restbl[0]['total']>0){
							// update in tbl
							$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "'";
							$this->query($UpdateQtysql, 0);
						}
					}
					
					
					/*********End By karishma based on Condition*********************/
                }

 												$arryTransaction['TransactionOrderID'] = $AID;
                        $arryTransaction['TransactionInvoiceID'] = "MERGE".$AID;
                        $arryTransaction['TransactionDate'] = $Config['TodayDate'];
                        $arryTransaction['TransactionType'] = 'Merge Item';

                        $objItem = new items();
                        $objItem->addItemTransaction($arryTransaction,$arryDetails,$type='MRG');
	/*************CODE FOR ADD SERIAL NUMBERS******/
										                          
							if ($arryDetails['serial_number' . $i] != '') {
										  $serial_id = explode(",", $arryDetails['serial_number' . $i]);
//print_r($serial_id); exit;

										  for ($j = 0; $j < sizeof($serial_id); $j++) {
										            $sQuery = "update inv_serial_item set UsedSerial = '1' where  serialID = '".$serial_id[$j]."'"; 
										            $this->query($sQuery, 0);

										  }
							}
										                          
					/***********************END CODE**********************************************/
            }
        }

        return true;
    }

    function AddUpdateMergeItem($AID, $arryDetails) {
        global $Config;
        extract($arryDetails);




        if (!empty($DelItem)) {
            $strSQLQuery = "delete from inv_mergesubitem where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }

        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);

                $id = $arryDetails['id' . $i];
                if ($id > 0) {
                    $sql = "update inv_mergesubitem set RefID = '".$AID."',item_id='" . $arryDetails['item_id' . $i] . "', sku='" . addslashes($arryDetails['sku' . $i]) . "',  qty='" . addslashes($arryDetails['qty' . $i]) . "', price='" . addslashes($arryDetails['price' . $i]) . "', amount='" . addslashes($arryDetails['amount' . $i]) . "' ,serial='" . addslashes($arryDetails['serial_number' . $i]) . "',SubCondition = '" . addslashes($arryDetails['SubCondition' . $i]) . "'  where id='" . $id. "'";
                } else {

                     $sql = "insert into inv_mergesubitem (RefID, item_id, sku, qty, price,amount,serial,SubCondition) values('" . $AID . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['serial_number' . $i]) . "','" . addslashes($arryDetails['SubCondition' . $i]) . "')";
                }
                $this->query($sql, 0);
                if ($arryDetails['Status'] == 1) {
                    $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand-'" . $arryDetails['qty' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($strSQLItem, 0);

/*********Added By karishma based on Condition 6 Jan 2016*********************/
					if($arryDetails['Condition' . $i]!=''){
						 $sql="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['sku' . $i]) . "' and ItemID='" . addslashes($arryDetails['item_id' . $i]) . "'
						and `condition`='".addslashes($arryDetails['Condition' . $i])."' and WID='1' "; 
						$restbl=$this->query($sql, 1);
						if($restbl[0]['total']>0){
							// update in tbl
							$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "' and WID='1'";
							$this->query($UpdateQtysql, 0);
						}
					}
					
					
					/*********End By karishma based on Condition*********************/
                }


												$arryTransaction['TransactionOrderID'] = $AID;
                        $arryTransaction['TransactionInvoiceID'] = "MERGE".$AID;
                        $arryTransaction['TransactionDate'] = $Config['TodayDate'];
                        $arryTransaction['TransactionType'] = 'Merge Item';

                        $objItem = new items();
                        $objItem->addItemTransaction($arryTransaction,$arryDetails,$type='MRG');
					/*************CODE FOR ADD SERIAL NUMBERS******/
										                          
							if ($arryDetails['serial_number' . $i] != '') {
										  $serial_id = explode(",", $arryDetails['serial_number' . $i]);
print_r($serial_id); exit;

										  for ($j = 0; $j < sizeof($serial_id); $j++) {
										            $strSQLQuery = "update inv_serial_item set UsedSerial = '1' where  serialID = '".$serial_id[$j]."'"; exit;
										            $this->query($strSQLQuery, 0);

										  }
							}
										                          
					/***********************END CODE**********************************************/


            }
        }

        return true;
    }
function isMergeSkuExists($Sku, $id) {
        $strSQLQuery = "select asmID from inv_mergeitem where LCASE(Sku)='" . strtolower(trim($Sku)) . "'";
        $strSQLQuery .= ($id > 0) ? (" and id != '" . $id . "'") : ("");

        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['id'])) {
            return true;
        } else {
            return false;
        }
    }
/********** WorkOrder ******************/
 function ListWorkOrder($arrydetails) {

extract($arrydetails);
        $strAddQuery = '';
        $strAddQuery .= (!empty($id)) ? (" where o.Oid='" . $id. "'") : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and a.Status='".$Status."'"):(" ");
        /*if ($SortBy == 'id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (a.DsmID = '" . $SearchKey . "')") : ("");
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
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( a.DsmCode like '%" . $SearchKey . "%' or a.Sku like '%" . $SearchKey . "%' or i.description like '%" . $SearchKey . "%' or a.WarehouseCode like '%" . $SearchKey . "%' or w.warehouse_name like '%" . $SearchKey . "%' ) " ) : ("");
            }
        }*/
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by o.Oid ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");
        $strSQLQuery = "select o.*,w.warehouse_name,w.warehouse_code,w.WID from w_workorder o  left  join  w_warehouse  w on w.WID=o.warehouse " . $strAddQuery;
//echo $strSQLQuery; 
        return $this->query($strSQLQuery, 1);
    }


 function GetWorkOrderItem($Oid) {
        $strAddQuery = (!empty($Oid)) ? (" and Oid='" . $Oid. "'") : ("");
         $strSQLQuery = "select * from w_workorder_bom  where 1" . $strAddQuery . " order by id asc"; 
        return $this->query($strSQLQuery, 1);
    }

 function RemoveWorkOrder($Oid) {

        $strSQLQuery = "DELETE FROM w_workorder WHERE Oid = '" . $Oid."'";
        $rs = $this->query($strSQLQuery, 0);

        $strSQLQuery2 = "DELETE FROM w_workorder_bom WHERE Oid = '" . $Oid."'";
        $this->query($strSQLQuery2, 0);

        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function AddWorkOrder($arryDetails) {
        global $Config;
        extract($arryDetails);

        if (empty($Currency))
            $Currency = $Config['Currency'];

        $strSQLQuery = "insert into w_workorder(WON,description,SchDate,warehouse,WoQty,SaleID,OrderID,CustomerName,Status,CustID,CustCode,Priroty,OrderType,BOM,req_item,ItemID,woCondition) 
                         values('" . $WON . "','" . addslashes($description) . "', '" . $SchDate . "', '".$warehouse."' ,'" . $WoQty . "', '" . $SaleID . "', '" . $OrderID . "', '" . $CustomerName . "','" . $Status . "','" . $CustCode . "','" . $CustCode . "','".$Priroty."','".$OrderType."','" . $BOM . "','".$req_item."','".$item_id."','".addslashes($woCondition)."')";


        $this->query($strSQLQuery, 0);
         $materialID = $this->lastInsertId(); 
         if($materialID>0){


 for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);

                $id = $arryDetails['id' . $i];

          $sql = "insert into w_workorder_bom (Oid,sku,bomID, item_id, description, BomDate, qty,req_item,old_req_item,add_req_flag,parent_ItemID,Req_ItemID,`Condition`) values('".$materialID."', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['bomID' . $i]) . "','" . addslashes($arryDetails['item_id' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "', '" . addslashes($arryDetails['BomDate' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "','" . addslashes($arryDetails['req_item' . $i]) . "','" . addslashes($arryDetails['old_req_item' . $i]) . "','" . addslashes($arryDetails['add_req_flag' . $i]) . "','" . addslashes($arryDetails['parent_ItemID' . $i]) . "','" . addslashes($arryDetails['Req_ItemID' . $i]) . "','" .addslashes($arryDetails['Condition' . $i])."')";
                  $this->query($sql, 0);
}
}
          } 



	$objConfigure = new configure();
	$objConfigure->UpdateModuleAutoReceiptID('w_workorder','',$materialID,'Oid',$WON);


        return $materialID;
    }

function UpdateWorkOrder($arryDetails){
 global $Config;
        extract($arryDetails);
				  $strSQLQuery = "update w_workorder set  description='".addslashes($description)."',	SchDate='".addslashes($SchDate)."',						warehouse='" .addslashes($warehouse)."',WoQty='" . addslashes($WoQty) . "',	SaleID ='".addslashes($SaleID)."',OrderID='" . $OrderID . "',CustCode='" . addslashes($CustCode) . "',CustomerName='" . addslashes($CustomerName) . "', CustID = '" . addslashes($CustID) . "',Status      = '" . addslashes($Status) . "',Priroty='".addslashes($Priroty)."',OrderType ='".$OrderType."',BOM ='".$BOM."',req_item ='".$req_item."',ItemID ='".$item_id."',woCondition='".addslashes($woCondition)."'																				
				where Oid='" .$edit."'";  

        $this->query($strSQLQuery, 0); 



 if (!empty($DelItem)) {
$DelItem = explode(",",$DelItem);

$DelItem = implode("','",$DelItem);
             $strSQLQuery = "delete from w_workorder_bom where id in('" . $DelItem . "')"; 
            $this->query($strSQLQuery, 0);
        }

        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);

                $id = $arryDetails['id' . $i];
                if ($id > 0) {
                      $sql = "update w_workorder_bom set sku='" . addslashes($arryDetails['sku' . $i]) . "', bomID='" . addslashes($arryDetails['bomID' . $i]) . "', item_id='" . addslashes($arryDetails['item_id' . $i]) . "', description='" . addslashes($arryDetails['description' . $i]) . "', BomDate='" . addslashes($arryDetails['BomDate' . $i]) . "',qty='" . addslashes($arryDetails['qty' . $i]) . "',req_item = '" . addslashes($arryDetails['req_item' . $i]) . "',old_req_item='" . addslashes($arryDetails['old_req_item' . $i])."',add_req_flag='" .addslashes($arryDetails['add_req_flag' . $i]). "',parent_ItemID='" . addslashes($arryDetails['parent_ItemID' . $i]) . "',Req_ItemID='" .addslashes($arryDetails['Req_ItemID' . $i])."',`Condition`='" .addslashes($arryDetails['Condition' . $i])."'  where id='" . $id. "'"; 
 $this->query($sql, 0);
                }else{

$sql = "insert into w_workorder_bom (Oid,sku,bomID, item_id, description, BomDate, qty,req_item,old_req_item,add_req_flag,parent_ItemID,Req_ItemID,`Condition`) values('".$edit."', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['bomID' . $i]) . "','" . addslashes($arryDetails['item_id' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "', '" . addslashes($arryDetails['BomDate' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "','" . addslashes($arryDetails['req_item' . $i]) . "','" . addslashes($arryDetails['old_req_item' . $i]) . "','" . addslashes($arryDetails['add_req_flag' . $i]) . "','" . addslashes($arryDetails['parent_ItemID' . $i]) . "','" . addslashes($arryDetails['Req_ItemID' . $i]) . "','" .addslashes($arryDetails['Condition' . $i])."')";
                  $this->query($sql, 0);


        } 

    }
 }

	$objConfigure = new configure();
	$objConfigure->UpdateModuleAutoReceiptID('w_workorder','',$edit,'Oid',$WON);

}

	function UpdateRefID($DsmID,$asmID,$Oid){

         $strSQLQuery = "update w_workorder set  asmID='".addslashes($asmID)."',DsmID='".addslashes($DsmID)."' 	where Oid='" .$Oid."'";  
         $this->query($strSQLQuery, 0); 

}

   function isWoNumberExists($WON,$Oid) {

        $strSQLQuery = (!empty($Oid))?(" and Oid != '".$Oid."'"):("");
			  $strSQLQuery = "select Oid from w_workorder where WON='".trim($WON)."'".$strSQLQuery;
        $arryRow = $this->query($strSQLQuery, 1);
	
       if (!empty($arryRow[0]['Oid'])) {
            return true;
	
        } else {
            return false;
        }
    }
//added by nisha for row colour functionality
  
    function setRowColorWorkOrder($Oid,$RowColor) 
{
	   $sql = "update w_workorder set RowColor='".$RowColor."' where Oid in ( $Oid)"; 
         $this->query($sql, 0);
        return true;
}
}

?>
