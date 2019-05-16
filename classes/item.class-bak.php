<?

class items extends dbClass {

    //constructor
    function items() 
    {
        $this->dbClass();
    }

    function GetItems($id = 0, $CategoryID, $Status, $shortby) {

        $strSQLQuery = "select p1.*,c1.ParentID,c1.valuationType as evaluationType from inv_items p1 left outer join inv_categories c1 on p1.CategoryID = c1.CategoryID";
        $strSQLQuery .= ($Status > 0) ? (" and p1.Status='" . $Status . "' and c1.Status='" . $Status."'") : (" and p1.Status='1' and c1.Status='1' ");
        $strSQLQuery .= (!empty($id)) ? (" where p1.ItemID='" . $id."'") : (" where 1 ");
        $strSQLQuery .= (!empty($CategoryID)) ? (" and p1.CategoryID='" . $CategoryID."'") : ("");
        //$strSQLQuery .= (!empty($Mfg))?(" and p1.Mid='".$Mfg."'"):("");
        if ($shortby == "description") {
            $strSQLQuery .= "  order by p1.description";
        } elseif ($shortby == "new") {
            $strSQLQuery .= "  order by p1.ItemID DESC";
        }
        //elseif($shortby == "hprice"){$strSQLQuery .= "  order by p1.Price DESC"; }
        //elseif($shortby == "lprice") {$strSQLQuery .= "  order by p1.Price ASC";}
        else {
            $strSQLQuery .= "  order by p1.description";
        }
        //echo $strSQLQuery; exit;
        return $this->query($strSQLQuery, 1);
    }

function GetItemForDrop($id) {

        $strAddQuery = ($id > 0) ? (" where p1.ItemID='" . $id."'") : (" where 1 ");
        $strSQLQuery = "select p1.ItemID,p1.description,p1.Sku,c1.valuationType from inv_items p1 left outer join inv_categories c1 on p1.CategoryID = c1.CategoryID " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
}

    function GetItemById($id) {

        $strAddQuery = ($id > 0) ? (" where p1.ItemID='" . $id."'") : (" where 1 ");
        $strSQLQuery = "select p1.*,c1.ParentID,c1.valuationType as evaluationType from inv_items p1 left outer join inv_categories c1 on p1.CategoryID = c1.CategoryID " . $strAddQuery;
        ;


       // echo $strSQLQuery; exit;
        return $this->query($strSQLQuery, 1);
    }

 function GetItemByINid($id) {

        $strAddQuery = ($id > 0) ? (" where p1.ItemID IN ('".$id."')") : (" where 1 ");
        $strSQLQuery = "select p1.*,c1.ParentID,c1.valuationType as evaluationType from inv_items p1 left outer join inv_categories c1 on p1.CategoryID = c1.CategoryID " . $strAddQuery;
        ;


       // echo $strSQLQuery; exit;
        return $this->query($strSQLQuery, 1);
    }


function GetItemBySku($Sku) {

        $strAddQuery = ($Sku != '') ? (" where p1.Sku='" . $Sku."'") : (" where 1 ");
        $strSQLQuery = "select p1.*,c1.ParentID,c1.valuationType as evaluationType from inv_items p1 left outer join inv_categories c1 on p1.CategoryID = c1.CategoryID " . $strAddQuery;
        ;


       // echo $strSQLQuery; exit;
        return $this->query($strSQLQuery, 1);
    }



    function GetItemsView($arryDetails) {
	global $Config;
        extract($arryDetails);
        
	/********* By Karishma for MultiStore 22 Dec 2015******/
	$CustomerID=$LeftJoin=$custJoin='';
	(empty($sortby))?($sortby=""):(""); 	
	(empty($DBName))?($DBName=""):(""); 

	if(!empty($_SESSION['UserData']['Cid']))  $CustomerID=$_SESSION['UserData']['Cid'];
	/*****End By Karishma for MultiStore 22 Dec 2015**********/
		
        $strAddQuery = ' where 1 ';
        $SearchKey = '';
	if(!empty($key)) $SearchKey = strtolower(trim($key));
        

	#if($Config['TrackInventory']=='0'){$strAddQuery .= " and p1.non_inventory='No'";}

        $strAddQuery .= (!empty($ItemID)) ? (" and p1.ItemID='" . $ItemID . "'") : ("");
        $strAddQuery .= (!empty($CatID)) ? (" and p1.CategoryID='" . $CatID . "'") : ("");
        $strAddQuery .= (!empty($finish)) ? (" and p1.itemType='" . $finish . "'") : ("");
        $strAddQuery .= (!empty($kit)) ? (" and p1.itemType='" . $kit . "'") : ("");
	$strAddQuery .= (!empty($Sku)) ? (" and p1.Sku='" . $Sku . "'") : ("");
        
        /********* By Karishma for MultiStore 22 Dec 2015******/
	if(!empty($module)){
        	$strAddQuery .= ($module == 'exclusive') ? (" and p1.is_exclusive ='Yes'") : ("");    
	}
 
    if(!empty($CustID))
    {
        $custJoin    = "left join inv_customer_items c2 on c2.ItemID=p1.ItemID";
        $strAddQuery   .= " and c2.CustomerID = '".$CustID."' ";     
    }
    //End//

	$is_exclusive = (!empty($_SESSION['is_exclusive']))?($_SESSION['is_exclusive']):("");


        if( $is_exclusive=='No')
		$strAddQuery .= (!empty($CustomerID)) ? (" and (c2.CustomerID='" . $CustomerID . "' or c2.CustomerID is null) and 	p1.Status='1'") : ("");
	  else $strAddQuery .= (!empty($CustomerID)) ? (" and c2.CustomerID='" . $CustomerID . "' and p1.Status='1'") : ("");
	  
	  /*****End By Karishma for MultiStore 22 Dec 2015**********/
		

        //$strAddQuery .= ($proc != '') ? (" and p1.procurement_method like '%" . $proc . "%'") : ("");

        $strAddQuery .= (!empty($Status)) ? (" and p1.Status='" . $Status. "'") : ("");

	$groupby='';

        if ($SearchKey == 'active' && ($sortby == 'p1.Status' || $sortby == '')) {
            $strAddQuery .= " and p1.Status='1'";
        }else if ($SearchKey == 'inactive' && ($sortby == 'p1.Status' || $sortby == '')) {
            $strAddQuery .= " and p1.Status='0'";
        }else if ($sortby != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '%" . $SearchKey . "%')") : ("");
        }else if(!empty($SearchKey)){
	    
            $strAddQuery .= " and (p1.description like '" . $SearchKey . "%' or p1.Sku like '%" . $SearchKey . "%' or p1.non_inventory like '%" . $SearchKey . "' or p1.evaluationType like '%" . $SearchKey . "%' or p1.itemType like '%" . $SearchKey . "%' or p1.qty_on_hand like '%" . $SearchKey . "%' or a1.ItemAliasCode like '%" . $SearchKey . "%')  ";

	    $groupby = " group by p1.ItemID ";	    

	    $LeftJoin = ' left outer join inv_item_alias a1 on p1.Sku=a1.sku';
        }
        
        /********* By Karishma for MultiStore 22 Dec 2015******/        
        if($CustomerID!=''){
			$custJoin=" left join ".$DBName."inv_customer_items c2 on c2.ItemID=p1.ItemID ";
		}
	
	/*****End By Karishma for MultiStore 22 Dec 2015**********/	

       

	if(!empty($Config['GetNumRecords'])){
		$Columns = " count(*) as NumCount ";				
	}else{

		$strAddQuery .= $groupby;

	 $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by p1.ItemID ");
	 $strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");

	/*   Add By Ravi*/
        $cColums='';
        if(!empty($customColums)){
            $cColums=' , '.$_GET['customColums'];
        }
            $Columns = " p1.Image,p1.description,p1.Sku,p1.non_inventory, c1.valuationType as evaluationType,p1.itemType,p1.qty_on_hand,p1.ItemID,p1.Status,p1.CategoryID,p1.Taxable,p1.sell_price,p1.purchase_cost,p1.average_cost,purchase_tax_rate,sale_tax_rate  ".$cColums; //update by chetan 23Feb//
				$LeftJoin .= " left outer join inv_categories c1 on c1.CategoryID =p1.CategoryID ";
		/*$Columns = " p1.description,p1.Sku,p1.non_inventory, p1.evaluationType,p1.itemType,p1.qty_on_hand,p1.ItemID,p1.Status,p1.CategoryID,p1.Taxable,p1.sell_price,p1.purchase_cost,p1.average_cost,purchase_tax_rate,sale_tax_rate  "; //update by chetan 23Feb//  ";
*/
		 
		if(!empty($Config['RecordsPerPage'])){
			$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
		}
		
	}

        //$strSQLQuery = "select p1.* from inv_items p1 " . $LeftJoin.  $custJoin .$strAddQuery;  
	$strSQLQuery = "select ".$Columns." from inv_items p1 " . $LeftJoin.  $custJoin .$strAddQuery;  
 
	 
        return $this->query($strSQLQuery, 1);
    }


function GetItemsCust($arryDetails) {
	global $Config;
        extract($arryDetails);  
	$SearchKey = strtolower(trim($key));
    	$LeftJoin='';	
        $strAddQuery = ' where 1 ';  	      
        $strAddQuery .= (!empty($ItemID)) ? (" and p1.ItemID='" . $ItemID . "'") : ("");
        $strAddQuery .= (!empty($CatID)) ? (" and p1.CategoryID='" . $CatID . "'") : ("");
        $strAddQuery .= (!empty($finish)) ? (" and p1.itemType='" . $finish . "'") : ("");
        $strAddQuery .= (!empty($kit)) ? (" and p1.itemType='" . $kit . "'") : ("");
	$strAddQuery .= (!empty($Sku)) ? (" and p1.Sku='" . $Sku . "'") : ("");        
        $strAddQuery .= (!empty($Status)) ? (" and p1.Status='" . $Status. "'") : ("");
    
	if($ExclusiveItem=="Yes"){
		$strAddQuery .= " and p1.is_exclusive = 'Yes' ";
		if(!empty($CustID))$LeftJoin .= " inner join inv_customer_items c2 on (p1.ItemID=c2.ItemID and c2.CustomerID='".$CustID."')";
	}else{
	        $strAddQuery .= " and p1.is_exclusive != 'Yes' ";
	}

 	if(!empty($SearchKey)){	    
            $strAddQuery .= " and (p1.description like '" . $SearchKey . "%' or p1.Sku like '%" . $SearchKey . "%' or p1.non_inventory like '%" . $SearchKey . "' or p1.evaluationType like '%" . $SearchKey . "%' or p1.itemType like '%" . $SearchKey . "%' or p1.qty_on_hand like '%" . $SearchKey . "%' or a1.ItemAliasCode like '%" . $SearchKey . "%') group by p1.ItemID ";
	    $LeftJoin .= ' left outer join inv_item_alias a1 on p1.Sku=a1.sku ';
        }
       
	if($Config['GetNumRecords']==1){
		$Columns = " count(p1.ItemID) as NumCount ";				
	}else{

		$strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by p1.ItemID ");
        	$strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");

		$Columns = " p1.Image,p1.description,p1.Sku,p1.non_inventory, c1.valuationType as evaluationType,p1.itemType,p1.qty_on_hand,p1.ItemID,p1.Status,p1.CategoryID,p1.Taxable,p1.sell_price,p1.purchase_cost,p1.average_cost,purchase_tax_rate,sale_tax_rate  "; 	
		if($Config['RecordsPerPage']>0){
			$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
		}		
	}   
     



	$strSQLQuery = "select ".$Columns." from inv_items p1 left outer join inv_categories c1 on p1.CategoryID=c1.CategoryID 		" .$LeftJoin.$strAddQuery; 
	

        return $this->query($strSQLQuery, 1);
    }


    
    function GetBOMItemsSelect($arryDetails) {
	global $Config;
        extract($arryDetails);
        $SearchKey = strtolower(trim($key));      

        $strSQLQuery = "select p1.ItemID,p1.description,p1.Sku,p1.Status,p1.itemType,p1.CategoryID,p1.purchase_cost,p1.sell_price,p1.qty_on_hand,p1.UnitMeasure,p1.procurement_method,c.valuationType as evaluationType from inv_items p1 left outer join inv_categories c on c.CategoryID =p1.CategoryID where p1.Sku like '" . $SearchKey . "%'" ;
	$arryRow = $this->query($strSQLQuery, 1);

	if(empty($arryRow[0]['ItemID'])){
		unset($arryRow);
//c.valuationType as evaluationType from inv_item_required r inner join inv_items i on r.item_id = i.ItemID left outer join inv_categories c on c.CategoryID =i.CategoryID
		$strSQLQuery = "select p1.ItemID,p1.description,p1.Sku,p1.Status,p1.itemType,p1.CategoryID,p1.purchase_cost,p1.sell_price,p1.qty_on_hand,p1.UnitMeasure,p1.procurement_method,c.valuationType as evaluationType from inv_items p1 left outer join inv_item_alias a1 on p1.ItemID=a1.item_id left outer join inv_categories c on c.CategoryID =p1.CategoryID where a1.ItemAliasCode like '" . $SearchKey . "%' group by p1.ItemID limit 0,1" ;
		$arryRowAlias = $this->query($strSQLQuery, 1);
		return $arryRowAlias;	
	}else{
		return $arryRow;
	}


       
    }



     function GetItemsViewForSale($arryDetails) {
	global $Config;
        extract($arryDetails);
  /********* By Karishma for MultiStore 22 Dec 2015******/
        $CustomerID=''; $custJoin='';
		if(!empty($_SESSION['UserData']['Cid']))  $CustomerID=$_SESSION['UserData']['Cid'];
	/*****End By Karishma for MultiStore 22 Dec 2015**********/
	$strAddQuery = ' where 1 ';

	$SearchKey = '';
	(empty($sortby))?($sortby=""):("");

	if(!empty($key))  $SearchKey = strtolower(trim($key));
        	

	#if($Config['TrackInventory']=='0'){$strAddQuery .= " and p1.non_inventory='No'";}

        $strAddQuery .= (!empty($ItemID)) ? (" and p1.ItemID='" . $ItemID . "'") : ("");
        $strAddQuery .= (!empty($CatID)) ? (" and p1.CategoryID='" . $CatID . "'") : ("");
        $strAddQuery .= (!empty($finish)) ? (" and p1.itemType='" . $finish . "'") : ("");
        $strAddQuery .= (!empty($kit)) ? (" and p1.itemType='" . $kit . "'") : ("");
        //$strAddQuery .= (!empty($proc)) ? (" and p1.procurement_method like '%" . $proc . "%'") : ("");

        $strAddQuery .= (!empty($Status)) ? (" and p1.Status='" . $Status. "'") : ("");
/********* By Karishma for MultiStore 22 Dec 2015******/
        $strAddQuery .= (!empty($CustomerID)) ? (" and c2.CustomerID='" . $CustomerID . "' ") : ("");
	/*****End By Karishma for MultiStore 22 Dec 2015**********/
        if ($SearchKey == 'active' && ($sortby == 'p1.Status' || $sortby == '')) {
            $strAddQuery .= " and p1.Status='1'";
        } else if ($SearchKey == 'inactive' && ($sortby == 'p1.Status' || $sortby == '')) {
            $strAddQuery .= " and p1.Status='0'";
        } else if ($sortby != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '" . $SearchKey . "%')") : ("");
        } else {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (p1.description like '%" . $SearchKey . "%' or p1.Sku like '%" . $SearchKey . "%' or p1.non_inventory like '" . $SearchKey . "' or p1.evaluationType like '%" . $SearchKey . "%' or p1.itemType like '%" . $SearchKey . "%' or p1.qty_on_hand like '%" . $SearchKey . "%' ) ") : ("");
        }
        $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by p1.ItemID ");
        $strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");
	
	
	

/********* By Karishma for MultiStore 22 Dec 2015******/
	if($CustomerID!=''){
			$custJoin=" inner join inv_customer_items c2 on c2.ItemID=p1.ItemID ";
		}

if(!empty($Config['GetNumRecords'])){
				$Columns = " count(p1.ItemID) as NumCount ";				
			}else{				
				$Columns = " p1.* ";
 
				if(!empty($Config['RecordsPerPage'])){
if(empty($Config['StartPage'])) $Config['StartPage'] =0;
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

	/*****End By Karishma for MultiStore 22 Dec 2015**********/

      //$strSQLQuery = "select p1.*,m.bill_option from inv_items as p1 left outer join inv_bill_of_material as m on m.item_id = p1.ItemID ". $custJoin . $strAddQuery;
    $strSQLQuery = "select ".$Columns." from inv_items as p1 ". $custJoin . $strAddQuery; 

        return $this->query($strSQLQuery, 1);
    }
    
    function getOptionCode($ItemID)
    {
     	$strAddQuery = '';
        $strAddQuery .= (!empty($ItemID)) ? (" where m.item_id='" . $ItemID."'") : ("");
        $strSQLQuery = "select c.option_code,c.optionID from inv_bom_cat c inner join inv_bill_of_material m on m.bomID = c.bomID  " . $strAddQuery;
        //echo "=>".$strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
     
        
    }

    function GetFinishItems($arryDetails) {

        extract($arryDetails);
        //$proc ="MAKE";GetItemsView

        $strAddQuery = ' where 1 ';
        $SearchKey = strtolower(trim($key));
        $strAddQuery .= ($ItemID > 0) ? (" and p1.ItemID='" . $ItemID . "'") : ("");
        $strAddQuery .= ($CatID > 0) ? (" and p1.CategoryID='" . $CatID . "'") : ("");
        //$strAddQuery .= ($finish != '') ? (" and p1.itemType='".$finish."'") : ("");
        //$strAddQuery .= (!empty($kit)) ? (" and p1.itemType='" . $kit . "'") : ("");


        $strAddQuery .= ($Status > 0) ? (" and p1.Status='" . $Status . "'") : ("");

        if ($SearchKey == 'active' && ($sortby == 'p1.StatuGetItemsViews' || $sortby == '')) {
            $strAddQuery .= " and p1.Status='1'";
        } else if ($SearchKey == 'inactive' && ($sortby == 'p1.Status' || $sortby == '')) {
            $strAddQuery .= " and p1.Status='0'";
        } else if ($sortby != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '" . $SearchKey . "%')") : ("");
        } else {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (p1.description like '%" . $SearchKey . "%' or p1.Sku like '%" . $SearchKey . "%' or p1.purchase_cost like '%" . $SearchKey . "%' or p1.sell_price like '%" . $SearchKey . "%' or p1.qty_on_hand like '%" . $SearchKey . "%' or p1.UnitMeasure like '%" . $SearchKey . "%' or p1.procurement_method like '%" . $SearchKey . "%' ) ") : ("");
        }
        $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by p1.ItemID ");
        $strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");

        $strSQLQuery = "select p1.* from inv_items p1 " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }




	function isSkuBomExists($Sku){
		$strSQLQuery = "SELECT Sku from inv_bill_of_material where Sku='".trim($Sku)."' ";
		$arryRow = $this->query($strSQLQuery, 1);

		if(!empty($arryRow[0]['Sku'])) {
			return true;
		} else {
			$strSQLQuery2 = "SELECT i.Sku from inv_item_alias a inner join inv_items i on i.ItemID=a.item_id where a.ItemAliasCode='".trim($Sku)."' ";
			$arryRow2 = $this->query($strSQLQuery2, 1);
			if(!empty($arryRow2[0]['Sku'])){
				$strSQLQuery3 = "SELECT Sku from inv_bill_of_material where Sku='".trim($arryRow2[0]['Sku'])."' ";
				$arryRow3 = $this->query($strSQLQuery3, 1);
				if(!empty($arryRow3[0]['Sku'])) {
					return true;
				} else {
					return false;
				}

			}

			return false;
		}
	}	



    function GetBillItems($arryDetails) {

        extract($arryDetails);
       $LeftJoin ='';

        $strAddQuery = " where  p1.Sku not in (select Sku from inv_bill_of_material) ";
	 

        $SearchKey = strtolower(trim($key));
        $strAddQuery .= (!empty($ItemID)) ? (" and p1.ItemID='" . $ItemID . "'") : ("");
        //$strAddQuery .= (!empty($CatID)) ? (" and p1.CategoryID='".$CatID."'") : ("");
        //$strAddQuery .= (!empty($finish)) ? (" and p1.itemType='".$finish."'") : ("");
        //$strAddQuery .= (!empty($kit)) ? (" and p1.itemType='" . $kit . "'") : ("");




        $strAddQuery .= (!empty($Status)) ? (" and p1.Status=" . $Status) : ("");

        if ($SearchKey == 'active' && ($sortby == 'p1.Status' || $sortby == '')) {
            $strAddQuery .= " and p1.Status='1'";
        } else if ($SearchKey == 'inactive' && ($sortby == 'p1.Status' || $sortby == '')) {
            $strAddQuery .= " and p1.Status='0'";
        } else if ($sortby != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '" . $SearchKey . "%')") : ("");
       }else if(!empty($SearchKey)){
            $strAddQuery .= (!empty($SearchKey)) ? (" and (p1.description like '%" . $SearchKey . "%' or p1.Sku like '%" . $SearchKey . "%' or p1.purchase_cost like '%" . $SearchKey . "%' or p1.sell_price like '%" . $SearchKey . "%' or p1.qty_on_hand like '%" . $SearchKey . "%' or p1.UnitMeasure like '%" . $SearchKey . "%' or p1.procurement_method like '%" . $SearchKey . "%' or a1.ItemAliasCode like '%" . $SearchKey . "%' ) group by p1.ItemID ") : ("");
		 $LeftJoin = ' left outer join inv_item_alias a1 on p1.Sku=a1.sku';
        }
        $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by p1.ItemID ");
        $strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");

       $strSQLQuery = "select p1.ItemID,p1.description,p1.Sku,p1.Status,p1.itemType,p1.CategoryID,p1.purchase_cost,p1.sell_price,p1.qty_on_hand,p1.UnitMeasure,p1.procurement_method from inv_items p1   " .  $LeftJoin. $strAddQuery . " ";

	 
        return $this->query($strSQLQuery, 1);
    }
//update By Chetan 8Jan(add sell_price col.)//
    function GetRequiredItem($ItemID, $id) {
	$strAddQuery ='';
        $strAddQuery .= (!empty($ItemID)) ? (" and r.ItemID='" . $ItemID . "'") : ("");
            $strAddQuery .=(" and r.Type!='Alias'");
        $strAddQuery .= (!empty($id)) ? (" and r.id='" . $id . "'") : ("");
        $strSQLQuery = "select r.*,i.ItemID,i.sell_price,i.Sku as sku,i.description,i.qty_on_hand,c.valuationType as evaluationType from inv_item_required r inner join inv_items i on r.item_id = i.ItemID left outer join inv_categories c on c.CategoryID =i.CategoryID where 1 " . $strAddQuery . " order by r.id asc";
        return $this->query($strSQLQuery, 1);
    }
//update By Chetan 8Jan(add sell_price col.)//
 function GetAliasRequiredItem($aliasID, $id) {
	$strAddQuery ='';
        $strAddQuery .= (!empty($aliasID)) ? (" and r.aliasID='" . $aliasID . "'") : ("");
          $strAddQuery .=(" and r.Type='Alias'");
        $strAddQuery .= (!empty($id)) ? (" and r.id='" . $id . "'") : ("");
        $strSQLQuery = "select r.*,i.sell_price,i.average_cost,i.Sku as sku,i.description,i.qty_on_hand,c.valuationType as evaluationType from inv_item_required r inner join inv_items i on r.item_id = i.ItemID left outer join inv_categories c on c.CategoryID =i.CategoryID where 1 " . $strAddQuery . " order by r.id asc";
        return $this->query($strSQLQuery, 1);
    }
    
//update By Chetan 21Mar2018(added checkprm functionality)//
    function GetKitItem($ItemID,$checkPrm='') {
        $strAddQuery ='';
        $strAddQuery .= (!empty($ItemID)) ? (" where m.item_id='" . $ItemID."'") : ("");
		$strAddQuery .= ($checkPrm!='') ? " and b.Primary = 1 " : '';
        $strSQLQuery = "select b.Primary,b.bom_qty as qty,b.item_id,i.sell_price,i.purchase_cost,i.average_cost,i.Sku as Sku,i.description,i.qty_on_hand,m.bill_option,i.evaluationType from inv_item_bom b inner join inv_bill_of_material m on m.bomID = b.bomID left outer join inv_items  i on i.ItemID=b.item_id  " . $strAddQuery; 
        //echo "=>".$strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

//update By Chetan 7Jan(add sell price,purchase cost /evaluationType col.)//
    function GetKitBomItem($ItemID) {
        $strAddQuery ='';
        $strAddQuery .= (!empty($ItemID)) ? (" where m.item_id In('" . $ItemID."')") : ("");
         $strSQLQuery = "select b.Primary,b.bom_qty as qty,b.item_id,i.sell_price,i.purchase_cost,i.average_cost,i.Sku as sku,i.description,i.qty_on_hand,m.bill_option,i.evaluationType from inv_item_bom b inner join inv_bill_of_material m on m.bomID = b.bomID left outer join inv_items  i on i.ItemID=b.item_id  " . $strAddQuery; 
        //echo "=>".$strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }
     //update By Chetan 11Jan(add sell price,purchase cost col.)//
    function GetOptionCodeItem($optionID) {
        $strAddQuery ='';
        $strAddQuery .= (!empty($optionID)) ? (" where b.optionID='" . $optionID."'") : ("");
        $strSQLQuery = "select b.bom_qty as qty,i.ItemID as item_id, i.sell_price,i.purchase_cost,i.average_cost,i.Sku as sku,i.description,i.qty_on_hand,c.valuationType  from inv_item_bom b left outer join inv_items  i on i.ItemID=b.item_id left outer join inv_categories c on c.CategoryID =i.CategoryID  " . $strAddQuery;
        //echo "=>".$strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    function AddUpdateRequiredItem($ItemID, $arryDetails) {
        global $Config;

        extract($arryDetails);

        if (!empty($DelItem) && empty($CopyItemID)) {
            $strSQLQuery = "delete from inv_item_required where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }

        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {

                $id = $arryDetails['id' . $i];

		if(!empty($CopyItemID)){ //copy item
			  $sql = "insert into inv_item_required (ItemID, item_id, qty,Type,aliasID) values('" . $ItemID . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['qty' . $i]) . "','" . addslashes($arryDetails['Type']) . "','" . addslashes($arryDetails['aliasID']) . "')";
                    	$this->query($sql, 0);
		}else{
				if ($id > 0) {
				     $sql = "update inv_item_required set item_id='" . $arryDetails['item_id' . $i] . "', qty='" . addslashes($arryDetails['qty' . $i]) . "'  where id='" . $id . "'";
				    $this->query($sql, 0);
				} else {
				    $sql = "insert into inv_item_required (ItemID, item_id, qty,Type,aliasID) values('" . $ItemID . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['qty' . $i]) . "','" . addslashes($arryDetails['Type']) . "','" . addslashes($arryDetails['aliasID']) . "')";
				    $this->query($sql, 0);
				}



		}

            }
        }
	
        return true;
    }

    function StockDetail($arryDetails) {

        extract($arryDetails);

        $strAddQuery = ' where 1 ';
        $SearchKey = strtolower(trim($keyword));
        $strAddQuery .= ($ItemID > 0) ? (" and p1.ItemID='" . $ItemID . "'") : ("");
        //$strAddQuery .= ($CategoryID > 0) ? (" and p1.CategoryID='" . $CategoryID . "' ") : ("");

         $strAddQuery .= ($CategoryID != '') ? (" and p1.CategoryID IN ($CategoryID)") : ("");
       $strAddQuery .= ($Genration != '') ? (" and (FIND_IN_SET('" . $Genration . "',p1.Generation) ) ") : ("");
       $strAddQuery .= ($Model != '') ? (" and (FIND_IN_SET('" . $Model . "',p1.Model))") : ("");
        //$strAddQuery .= (!empty($Condition)) ? (" and p1.Condition='" . $Condition . "'") : ("");
        $strAddQuery .= ($Manufacturer != '') ? (" and p1.Manufacture like '%" . $Manufacturer . "%'") : ("");
        $strAddQuery .= ($Status > 0) ? (" and p1.Status='" . $Status. "'") : ("");



        $strAddQuery .= (!empty($SearchKey)) ? (" and (p1.description like '%" . $SearchKey . "%' or p1.Sku like '%" . $SearchKey . "%' or p1.purchase_cost like '%" . $SearchKey . "%' or p1.sell_price like '%" . $SearchKey . "%' or p1.qty_on_hand like '%" . $SearchKey . "%' or p1.UnitMeasure like '%" . $SearchKey . "%' or p1.procurement_method like '%" . $SearchKey . "%' ) ") : (""); 

        $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by p1.ItemID ");
        $strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");

       $strSQLQuery = "select p1.* from inv_items p1 " . $strAddQuery;  
	//if($_GET['d']==1) echo $strSQLQuery;
        return $this->query($strSQLQuery, 1);
    }

    function CountPo($sku) {
        $strSQLQuery = "SELECT SUM(OrderID) AS totalPo FROM `p_order_item` WHERE 1 AND sku = '" . $sku . "' ";
        $rs = $this->query($strSQLQuery);
        if (sizeof($rs)) {
            if ($rs[0]['totalPo'] > 0) {
                return $rs[0]['totalPo'];
            } else {
                return 0;
            }
        }
    }

    function GetSumPo($sku) {

        $strSQLQuery = "SELECT SUM( p_order_item.qty ) AS sumPo,p_order_item.OrderID,p_order_item.sku,p_order.OrderID,p_order.Module FROM `p_order_item` p_order_item  LEFT OUTER JOIN p_order p_order ON p_order.OrderID = p_order_item.OrderID WHERE 1 AND sku = '" . $sku . "'AND p_order.Module = 'Order'";


        $rs = $this->query($strSQLQuery);
        if (sizeof($rs)) {
            if ($rs[0]['sumPo'] > 0) {
                return $rs[0]['sumPo'];
            } else {
                return 0;
            }
        }
    }

    function GetPriceRange() {
        $strSQLQuery = 'select * from price_refine order by id asc';
        return $this->query($strSQLQuery, 1);
    }

    function SearchItemsCat($id = 0, $CategoryIDs, $Status, $key, $state_id, $PostedByID, $Bidding) {
        $strSQLQuery = "select p1.*,if(p1.CategoryID>0,c1.Name,'') as CategoryName,c1.ParentID,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName,m1.Website,m1.MembershipID,m1.CreditCard from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join inv_categories c1 on p1.CategoryID = c1.CategoryID ";

        $strSQLQuery .= ($CategoryIDs > 0) ? (" where (p1.CategoryID ='" . $CategoryIDs . "' or c1.ParentID = '" . $CategoryIDs . "')") : (" where 1 ");

        $strSQLQuery .= ($PostedByID > 0) ? (" and p1.PostedByID='" . $PostedByID. "'") : ("");

        $strSQLQuery .= ($Status > 0) ? (" and p1.Status='" . $Status . "' and c1.Status='" . $Status . "' and m1.Status='" . $Status . "' ") : ("");

        $strSQLQuery .= (!empty($key)) ? (" and (p1.SearchTag LIKE '%" . $key . "%' OR p1.Name LIKE '%" . $key . "%' OR p1.ProductSku LIKE '%" . $key . "%')") : ("");

        $strSQLQuery .= ($state_id > 0) ? (" and m1.state_id='" . $state_id. "'") : ("");

        $strSQLQuery .= ($Bidding == 'Auction') ? (" and p1.Bidding='" . $Bidding . "'") : ("");

        $strSQLQuery .= ' order by p1.Name asc ';

        return $this->query($strSQLQuery, 1);
    }

    function GetNewItems($CategoryID, $PostedByID, $Limit) {
        $strSQLQuery = "select p1.*,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join inv_categories c1 on p1.CategoryID = c1.CategoryID ";

        $strSQLQuery .= "where 1";

        $strSQLQuery .= ($PostedByID > 0) ? (" and p1.PostedByID='" . $PostedByID . "' and c1.StoreID='" . $PostedByID. "'") : ("");
        $strSQLQuery .= ($CategoryID > 0) ? (" and p1.CategoryID='" . $CategoryID. "'") : ("");

        $Status = 1;
        $strSQLQuery .= ($Status > 0) ? (" and p1.Status='" . $Status . "' and c1.Status='" . $Status . "' and m1.Status='" . $Status . "' ") : ("");


        $strSQLQuery .= ' order by p1.ItemID desc ';
        $strSQLQuery .= ($Limit > 0) ? (" limit 0," . $Limit) : ("");

        return $this->query($strSQLQuery, 1);
    }

    function GetNameByParentID($id) {
        $strSQLQuery = "select c1.Name,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName from inv_categories c1 left outer join inv_categories c2 on c1.ParentID = c2.CategoryID where c1.CategoryID = " . $id;
        return $this->query($strSQLQuery, 1);
    }

    function GetFeaturedItems() {
        $strSQLFeaturedQuery .= (" and p1.Featured='Yes'");

        $strSQLQuery = "select p1.* from inv_items p1 inner join inv_categories c1 on p1.CategoryID = c1.CategoryID where p1.Status='1' and c1.Status='1' " . $strSQLFeaturedQuery . "   order by rand() Desc LIMIT 0,9";
        return $this->query($strSQLQuery, 1);
    }

    function checkItemSku($Sku,$Db='') {
	/********* By Karishma for MultiStore 22 Dec 2015******/
    	$CustomerID='';$custJoin='';
		if(!empty($_SESSION['UserData']['Cid']))  $CustomerID=$_SESSION['UserData']['Cid'];

		if(!empty($CustomerID)){
			$custJoin=" left join ".$Db."inv_customer_items c2 on c2.ItemID=p1.ItemID ";
		}

		$is_exclusive = (!empty($_SESSION['is_exclusive']))?($_SESSION['is_exclusive']):("");

		if($is_exclusive=='No')
		$whereAddQuery = (!empty($CustomerID)) ? (" and (c2.CustomerID='" . $CustomerID . "' or c2.CustomerID is null) and p1.Status='1'") : ("");
		else $whereAddQuery = (!empty($CustomerID)) ? (" and c2.CustomerID='" . $CustomerID . "' and p1.Status='1'") : ("");

       /*****End By Karishma for MultiStore 22 Dec 2015**********/
        /*****End By Karishma for MultiStore 22 Dec 2015**********/
       
       $strSQLQuery = "select p1.*,cat.valuationType as evaluationType from ".$Db."inv_items  p1 left join ".$Db."inv_categories cat on cat.CategoryID=p1.CategoryID ".$custJoin." where p1.Sku = '" . $Sku . "' ".$whereAddQuery."";
		
       
      //  $strSQLQuery = "select * from inv_items where Sku = '" . $Sku . "'";
        return $this->query($strSQLQuery, 1);
    }

    function GetItemSku($ItemID) {
        $strSQLQuery = "select Sku from inv_items where ItemID = '" . $ItemID . "'";
        $row = $this->query($strSQLQuery, 1);
        if(!empty($row[0]['Sku'])) return $row[0]['Sku'];
    }

    function AddItem($arryDetails) {

        extract($arryDetails);

	(!isset($itemType))?($itemType=""):("");
	(!isset($Condition))?($Condition=""):("");
	(!isset($procurment))?($procurment=""):("");
	(!isset($Model_type))?($Model_type=""):("");
	(!isset($evaluationType))?($evaluationType=""):("");
	(!isset($min_stock_alert_level))?($min_stock_alert_level=""):("");
	(!isset($max_stock_alert_level))?($max_stock_alert_level=""):("");
	(!isset($non_inventory))?($non_inventory=""):("");
	(!isset($UnitMeasure))?($UnitMeasure=""):("");
	(!isset($purchase_tax_rate))?($purchase_tax_rate=""):("");
	(!isset($item_alias))?($item_alias=""):("");
	(!isset($sell_price))?($sell_price=""):("");
	(!isset($qty_on_hand))?($qty_on_hand=""):("");
	(!isset($long_description))?($long_description=""):("");
	(!isset($Generation_type))?($Generation_type=""):("");
	(!isset($Extended))?($Extended=""):("");
	(!isset($Manufacture))?($Manufacture=""):("");
	(!isset($ReorderLevel))?($ReorderLevel=""):("");
	(!isset($is_exclusive))?($is_exclusive=""):("");
	(!isset($Reorderlabelbox))?($Reorderlabelbox=""):("");

        if(!empty($CategoryID)) {
            $strUpdateQuery = "update inv_categories set NumProducts = NumProducts + 1 where CategoryID = '" . $CategoryID . "'";
            $this->query($strUpdateQuery, 0);
        }


 
	if($itemType == "Discontinue") {
	    $Status = 0;
	}
	 
	if(!empty($Condition)) {
		$Condition = implode(',', $Condition);
	}
	if(!empty($procurement_method)) {
        	$procurment = implode(',', $procurement_method);
	}
	if(!empty($Model)) {
        	$Model_type = implode(',', $Model);
	}


        $strSQLQuery = "insert into inv_items (description,procurement_method,CategoryID,evaluationType ,itemType,non_inventory,UnitMeasure,min_stock_alert_level,max_stock_alert_level,purchase_tax_rate,sale_tax_rate,Status, AddedDate, Sku,item_alias, sell_price, qty_on_hand, long_description,Model,Generation,`Condition`,Extended,Manufacture,ReorderLevel,is_exclusive,Reorderlabelbox) 
	values ('" . addslashes($description) . "','" . addslashes($procurment) . "','" . $CategoryID . "' ,'" . addslashes($evaluationType) . "','" . addslashes($itemType) . "','" . $non_inventory . "','" . addslashes($UnitMeasure) . "',
	'" . addslashes($min_stock_alert_level) . "','" . addslashes($max_stock_alert_level) . "',
	'" . addslashes($purchase_tax_rate) . "','" . addslashes($sale_tax_rate) . "',
	'" . $Status . "','" . date('Y-m-d') . "','" . addslashes($Sku) . "','" . addslashes($item_alias) . "' , '" . addslashes($sell_price) . "', '" . addslashes($qty_on_hand) . "', '" . addslashes($long_description) . "', '" . addslashes($Model_type) . "', '" . addslashes($Generation_type) . "', '" . addslashes($Condition) . "', '" . addslashes($Extended) . "', '" . addslashes($Manufacture) . "','" . addslashes($ReorderLevel) . "','" . addslashes($is_exclusive) . "','".addslashes($Reorderlabelbox)."')";

	 

        $this->query($strSQLQuery, 0);
        $lastInsertId = $this->lastInsertId();

    /********* By Karishma for MultiStore 22 Dec 2015******/
        if($is_exclusive=='Yes'){
			if($CustomerID!=''){
				$CustomerArray=explode(',',$CustomerID);
			}
			foreach($CustomerArray as $key=>$val){
				if($val!=''){
					$strSQLQuery = "insert into inv_customer_items (ItemID,CustomerID )
				values ('" . addslashes($lastInsertId) . "','" . addslashes($val) . "')";
					$this->query($strSQLQuery, 0);
				}

					
			}
		}

/* Added By Bhoodev for valuationType update in item 25 Jan 2016 */
if($lastInsertId>0){
				$sql = "select valuationType from inv_categories where CategoryID = '" . $CategoryID. "'";
				$arryRow = $this->query($sql);


				$sqlUpdateQuery = "update inv_items set evaluationType = '".addslashes($arryRow[0]['valuationType'])."' where ItemID = '" . $lastInsertId . "' and CategoryID = '".$CategoryID."'";
				$this->query($sqlUpdateQuery, 0);
}
	/*****End**********/

	/*****End By Karishma for MultiStore 22 Dec 2015**********/

        /* if($lastInsertId>0){
          $code="ITM000".$lastInsertId;
          $sql="update inv_items set Sku='".$code."' where ItemID=".$lastInsertId;
          $this->query($sql,0);

          } */

        return $lastInsertId;
    }

    function changeItemStatus($ItemID) {
        $sql = "select * from inv_items where ItemID='" . $ItemID. "'";
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 1) {
                $Status = 0;
                $itemType = 'Discontinue';
                $sql = "update inv_items set Status='" . $Status . "',itemType ='" . $itemType . "' where ItemID='" . $ItemID. "'";
            } else {
                $Status = 1;

                $sql = "update inv_items set Status='" . $Status . "' where ItemID='" . $ItemID . "'";
            }
            $this->query($sql, 0);
        }


        if ($Status == 1 && $rs[0]['Status'] != 1 && $rs[0]['PostedByID'] > 1) {
            $this->ItemActiveEmail($ItemID);
        }

        return true;
    }

    function MultipleItemStatus($ItemID, $Status) {
        $sql = "select * from inv_items where ItemID in (" . $ItemID . ") and Status!='" . $Status. "'";
        $arryRow = $this->query($sql);
        if (sizeof($arryRow) > 0) {

            $sql = "update inv_items set Status='" . $Status . "' where ItemID in (" . $ItemID . ")";
            $this->query($sql, 0);

            for ($i = 0; $i < sizeof($arryRow); $i++) {

                if ($Status == 1 && $arryRow[$i]['Status'] != 1 && $arryRow[$i]['PostedByID'] > 1) {
                    $this->ItemActiveEmail($arryRow[$i]['ItemID']);
                }
            }
        }

        return true;
    }

    function changeFeaturedStatus($ItemID) {
        $sql = "select * from inv_items where ItemID='" . $ItemID. "'";
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['itemType'] == 'Discontinue')
                $Featured = 'No';
            else
                $Featured = 'Yes';

            $sql = "update inv_items set Featured='$Featured' where ItemID='" . $ItemID. "'";
            $this->query($sql, 0);
            return true;
        }
    }

    function UpdateViewedDate($ItemID) {
        $sql = "update inv_items set ViewedDate='" . date('Y-m-d') . "' where ItemID='" . $ItemID. "'";
        $this->query($sql, 0);
        return true;
    }

    function FeaturedDisabled($ItemID) {

        $sql = "update inv_items set Featured='No',FeaturedType='',Impression='0',ImpressionCount='0',  FeaturedStart='',FeaturedEnd=''   where ItemID in(" . $ItemID . ")";
        $this->query($sql, 0);
        return true;
    }

    function UpdateImage($imageName, $ItemID) {
        $strSQLQuery = "update inv_items set Image='" . $imageName . "' where ItemID='" . $ItemID . "'";
        return $this->query($strSQLQuery, 0);
    }

    function UpdateBasic($arryDetails) {
        extract($arryDetails);

	(empty($Condition))?($Condition=""):("");
	(empty($procurement_method))?($procurement_method=""):("");
	(empty($Model))?($Model=""):("");
	(empty($Taxable))?($Taxable=""):("");


	$Condition = implode(',', $Condition);
	$procurment = implode(',', $procurement_method);
	$Model_type = implode(',', $Model);
 
         $strSQLQuery = "update inv_items set CategoryID = '" . $CategoryID . "',
                    description='" . mysql_real_escape_string($description) . "',
                    non_inventory = '" . $non_inventory . "',
                    procurement_method='" . $procurment . "',
                    evaluationType='" . mysql_real_escape_string($evaluationType) . "',
                    itemType='" . mysql_real_escape_string($itemType) . "',
                    UnitMeasure='" . mysql_real_escape_string($UnitMeasure) . "',
                    min_stock_alert_level='" . $min_stock_alert_level . "' ,
                    max_stock_alert_level='" . $max_stock_alert_level . "',
                    Taxable='" . mysql_real_escape_string($Taxable) . "' ,
                   	ReorderLevel='" . mysql_real_escape_string($ReorderLevel) . "' ,
										Reorderlabelbox='" . mysql_real_escape_string($Reorderlabelbox) . "' ,
                    purchase_tax_rate='" . $purchase_tax_rate . "',
                    sale_tax_rate='" . $sale_tax_rate . "', 
                    Status        = '" . $Status . "',
                      `GenOrder`        = '" . mysql_real_escape_string($GenOrder) . "',                 
                    item_alias='" . mysql_real_escape_string($item_alias) . "',
                    LastAdminType='" . $_SESSION['AdminType'] . "',
                    LastCreatedBy='" . $_SESSION['DisplayName'] . "',
                    Model = '" . addslashes($Model_type) . "',
                    Generation = '" . mysql_real_escape_string($Generation_type) . "',
                        `Condition` = '" . mysql_real_escape_string($Condition) . "',
                    Extended = '" . mysql_real_escape_string($Extended) . "',
                    Manufacture = '" . mysql_real_escape_string($Manufacture) . "',
										is_exclusive = '" . mysql_real_escape_string($is_exclusive) . "'
                    where ItemID='" . $ItemID . "'"; 
        $this->query($strSQLQuery, 0);
 
    if($EditableSku==1 && $OldSku!=$Sku && !empty($Sku)){
        $strSQL2 = "update inv_items set Sku = '" . mysql_real_escape_string($Sku) . "'    where ItemID='" . mysql_real_escape_string($ItemID) . "'"; 
            $this->query($strSQL2, 0);
        $strSQL3 = "update inv_item_alias set sku = '" . mysql_real_escape_string($Sku) . "'    where item_id='" . mysql_real_escape_string($ItemID) . "'"; 
            $this->query($strSQL3, 0);
        
    }

 $strSQL4 = "update inv_bill_of_material set description='" . mysql_real_escape_string($description) . "' where Sku='" . mysql_real_escape_string($Sku) . "'"; 
$this->query($strSQL4, 0);

/********* By Karishma for MultiStore 22 Dec 2015******/
	if($is_exclusive=='Yes'){


			if($CustomerID!=''){
				$strSQLQuery = "SELECT CustomerID FROM inv_customer_items where ItemID = '" . $ItemID . "' and  CustomerID not in (".$CustomerID.") ";
				$custres=$this->query($strSQLQuery, 1);
				foreach($custres as $key=>$val){
					if($val['CustomerID']!=''){
						$strSQLQuery = "delete from inv_customer_items where ItemID='" . addslashes($ItemID) . "'
						and CustomerID ='" . addslashes($val['CustomerID']) . "' "; 
						$this->query($strSQLQuery, 0);
					}


				}

				$CustomerArray=explode(',',$CustomerID);


				foreach($CustomerArray as $key=>$val){
					if($val!=''){
						$strSQLQuery = "SELECT count(*) as total FROM inv_customer_items
						where ItemID = '" . $ItemID . "' and CustomerID ='" . addslashes($val) . "' ";
						$res=$this->query($strSQLQuery, 1);
							
						if($res[0]['total']=='0'){
							$strSQLQuery = "insert into inv_customer_items (ItemID,CustomerID )
						values ('" . addslashes($ItemID) . "','" . addslashes($val) . "')";
							$this->query($strSQLQuery, 0);
						}
					}


				}

					
			}

		}
		elseif($is_exclusive=='No'){
			$strSQLQuery = "delete from inv_customer_items where ItemID='" . addslashes($ItemID) . "'";
			$this->query($strSQLQuery, 0);

		}
		
		/*****End By Karishma for MultiStore 22 Dec 2015**********/

        return 1;
    }

    function GetAliasbyItemID($ItemID) {
        $strSQLQuery = "SELECT * FROM inv_item_alias where item_id = '" . $ItemID . "' ORDER BY AliasID ASC";
        //echo $strSQLQuery;
        return $this->query($strSQLQuery);
    }

 function GetAliasbyAliasID($AliasID) {
        $strSQLQuery = "SELECT * FROM inv_item_alias where AliasID = '" . $AliasID . "'";
        //echo $strSQLQuery;
        return $this->query($strSQLQuery);
    }
    function UpdateItemOther($arryDetails) {

        /*extract($arryDetails);

        $strSQLQuery = "update inv_items set description='" . addslashes($description) . "', long_description='" . addslashes($long_description) . "', Status='" . $Status . "',sell_price='" . addslashes($sell_price) . "',qty_on_hand='" . addslashes($qty_on_hand) . "', LastAdminType='" . $_SESSION['AdminType'] . "',LastCreatedBy='" . $_SESSION['DisplayName'] . "' where ItemID='" . $ItemID. "'";

        $this->query($strSQLQuery, 0);


        return 1;*/

	extract($arryDetails);
        //By Chetan21Aug//
        $objField = new field();
        $arryflds=$objField->getAllCustomFieldByModuleID(2003);
        $arry = array_map(function($arr){
                    if($arr['editable']==1){
                        return $arr['fieldname'];
                    }else{
                        unset($arr);
                    }   
                },$arryflds);
        $arryflds = array_values(array_filter($arry)); 
        foreach($arryflds as $key)
        {       
                $str.= "$key='".$arryDetails[$key]."'".',';
        }
        $strSQLQuery = "update inv_items set ".$str." Sku = '" . addslashes($Sku) . "',  long_description='" . addslashes($long_description) . "',Status='" . $Status . "',sell_price='" . addslashes($sell_price) . "',
        qty_on_hand='" . addslashes($qty_on_hand) . "', LastAdminType='" . $_SESSION['AdminType'] . "',LastCreatedBy='" . $_SESSION['DisplayName'] . "',description ='" . addslashes($description) . "'  where ItemID='" . $ItemID."'";
        //End//
       
        $this->query($strSQLQuery, 0);


        return 1;

    }

    function UpdateSuplier($arryDetails) {

        extract($arryDetails);

        $strSQLQuery = "update inv_items set SuppCode='" . $SuppCode . "' , LastAdminType='" . $_SESSION['AdminType'] . "',LastCreatedBy='" . $_SESSION['DisplayName'] . "' where ItemID='" . $ItemID. "'";

        $this->query($strSQLQuery, 0);

        return 1;
    }
//update by chetan for fixed price on 27feb2017//
    function UpdatePrice($arryDetails) {
        global $Config;
        extract($arryDetails);

        $SelectQuery = "select Sku,purchase_cost,sell_price from inv_items where ItemID='" . $ItemID . "'";
        $rs = $this->query($SelectQuery);
        if (sizeof($rs)) {
            if ($rs[0]['purchase_cost'] != $purchase_cost) {

                $oldPurchaseCost = $rs[0]['purchase_cost'];
                //$notify=1;
            }

            if ($rs[0]['sell_price'] != $sell_price) {
                //$notify=2;
                $oldSaleCost = $rs[0]['sell_price'];
            }
        }

        $strSQLQuery = "update inv_items set average_cost='" . $average_cost . "',last_cost='" . $last_cost . "', purchase_cost='" . $purchase_cost . "', sell_price='" . $sell_price . "', LastAdminType='" . $_SESSION['AdminType'] . "',LastCreatedBy='" . $_SESSION['DisplayName'] . "' where ItemID='" . $ItemID . "'";
        $this->query($strSQLQuery, 0);

//update by chetan for fixed price on 27feb2017//
if($pricetype == 'range')
{
	$numcount = count($qtyfrom);
	for($i=0;$i<$numcount;$i++)
	{
		if($qtyfrom[$i] == '' && $qtyto[$i] == '' && $fprice[$i] == '' && $prpercent[$i] == '' )
		{
			unset($qtyfrom[$i]);
			unset($qtyto[$i]);
			unset($fprice[$i]);
			unset($prpercent[$i]);
		}
	}

}
$fprice 	= implode(',', $fprice);
$prpercent 	= implode(',', $prpercent);
$qtyfrom 	= implode(',', $qtyfrom);
$qtyto 		= implode(',', $qtyto);
//End//

if($Condition!=''){

 $SRSql = "Select ID from inv_item_quanity_condition  where Sku = '" . mysql_real_escape_string($rs[0]['Sku']) . "' and `condition`='".addslashes($Condition)."' and ItemID ='" . $ItemID . "' and WID='1'";
			$rsCon = $this->query($SRSql);
			if($rsCon[0]['ID']>0){
							$strSQL = "update inv_item_quanity_condition set SalePrice = '" . mysql_real_escape_string($sell_price) . "',AvgCost = '" . mysql_real_escape_string($average_cost) . "',LastPrice = '" . mysql_real_escape_string($last_cost) . "', pricetype ='".mysql_real_escape_string($pricetype)."' , fprice = '".$fprice."' , prpercent = '".$prpercent."' , qtyfrom = '".$qtyfrom."' , qtyto = '".$qtyto."' where Sku = '" . mysql_real_escape_string($rs[0]['Sku']) . "' and `condition`='".addslashes($Condition)."' and ItemID ='" . $ItemID . "'  "; 
											$this->query($strSQL, 0);
			}else{

						  $ConSql = "INSERT INTO inv_item_quanity_condition (SalePrice,AvgCost,LastPrice,Sku,`condition`,ItemID,pricetype,fprice,prpercent,qtyfrom,qtyto,WID)
						VALUES ('".mysql_real_escape_string($sell_price)."','".mysql_real_escape_string($average_cost)."','".mysql_real_escape_string($last_cost)."','".mysql_real_escape_string($rs[0]['Sku'])."','".addslashes($Condition)."','".$ItemID."','".mysql_real_escape_string($pricetype)."','".mysql_real_escape_string($fprice)."','".mysql_real_escape_string($prpercent)."','".mysql_real_escape_string($qtyfrom)."','".mysql_real_escape_string($qtyto)."','1')";
						$this->query($ConSql, 0);
			}

}



        return 1;


    }


/*** Variant Update ************/

 function UpdateVariantItem($arryDetails) {

        extract($arryDetails);

        $Variant_id = implode(',', $ID);

        $strSQLQuery = "update  inv_items set variant_id='" . addslashes($Variant_id) . "'  where itemID='" . $ItemID . "'";


        $this->query($strSQLQuery, 0);
        

 return 1;

        //return $lastInsertId;
    }

    /*     * *******************Model Genration *********************** */

    function AddModelGen($arryDetails) {

        extract($arryDetails);

        $Generation_type = implode(',', $Generation);

        $strSQLQuery = "insert into inv_ModelGen (Model,item_id,Sku,Generation,Status ) 
	values ('" . addslashes($Model) . "','" . addslashes($ItemID) . "','" . addslashes($Sku) . "' ,'" . addslashes($Generation_type) . "','" . $Status . "')";


        $this->query($strSQLQuery, 0);
        $lastInsertId = $this->lastInsertId();



        return $lastInsertId;
    }

    function updateModel($arryDetails) {

        extract($arryDetails);
        $Generation_type = implode(',', $Generation);
        $strSQLQuery = "update  inv_ModelGen set Model='" . addslashes($Model) . "' , Generation='" . addslashes($Generation_type) . "',Status='" . $Status . "' where id='" . $id . "'";

        $this->query($strSQLQuery, 0);

        return 1;
    }


    function GetModelGen($id) {
       $strAddQuery='';
        $strAddQuery .= (!empty($id)) ? (" and id='" . $id . "'") : (" and Status ='1' ");
 	$strSQLQuery = "Select * from inv_ModelGen where 1 ".$strAddQuery." order by Model";
        return $this->query($strSQLQuery, 1);
    }

 function GetModel($ids) 
 {
 	if(!empty($ids)){
 $strSQLQuery = "Select * from inv_ModelGen where id in($ids) ";
    	
       // $strSQLQuery = "Select * from inv_ModelGen where 1 ";
       // $strSQLQuery .= (!empty($id)) ? (" and id in (" . $ids . ")") : ("  ");
#echo $strSQLQuery ; exit; 
        return $this->query($strSQLQuery, 1);
 	}
    }

    function deleteModel($id) {
        $strSQLQuery = "delete from inv_ModelGen where id='" . $id . "'";
        $this->query($strSQLQuery, 0);
        return true;
    }

    function ListModel($arryDetails) {
global $Config;
        extract($arryDetails);

        $strAddQuery = '';
        $SearchKey = strtolower(trim($key));
        $strAddQuery .= (!empty($id)) ? (" where id='" . $id . "'") : (" where 1 ");

        if (!empty($sortBy)) {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortBy . " like '%" . $SearchKey . "%')") : ("");
        } else {
            $strAddQuery .= (!empty($SearchKey)) ? (" and ( Model like '%" . $SearchKey . "%'   ) " ) : ("");
        }


        $strAddQuery .= (!empty($sortBy)) ? (" order by " . $sortBy . " ") : (" order by Model ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

if($Config['GetNumRecords']==1){
		$Columns = " count(id) as NumCount ";				
	}else{				
		$Columns = " * "; 


		if($Config['RecordsPerPage']>0){
			$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
		}
		
	}

        $strSQLQuery = "select ".$Columns." from inv_ModelGen  " . $strAddQuery;




        return $this->query($strSQLQuery, 1);
    }

    function isModelExists($Model, $id) {


        $strSQLQuery = "select id from inv_ModelGen where LCASE(Model)='" . strtolower($Model) . "'";

        $strSQLQuery .= ($id > 0) ? (" and id != '" . $id . "'") : ("");


        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['id'])) {
            return true;
        } else {
            return false;
        }
    }

    function changeModelStatus($id) {

        $sql = "select * from inv_ModelGen where id='" . $id . "'";
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 1) {
                $Status = 0;
            } else {
                $Status = 1;
            }
            $sql = "update inv_ModelGen set Status='" . $Status . "' where id='" . $id . "'";
            $this->query($sql, 0);
        }

        return true;
    }

    /*     * ***********************finish ******************** */

    /*     * **************************************************** */

    function ItemWarehouse($ids) {

        $strSQLQuery = "Select * from w_warehouse where WID in (" . $ids . ")";
        return $this->query($strSQLQuery, 1);
    }

    function AddItemBin($arryDetails) {
        extract($arryDetails);

        $Generation_type = implode(',', $Generation);

//for($i=0;$i<sizeof($bin);$i++){

        $strSQLQuery = "insert into inv_bin_stock (Wcode,Sku,reorderlevel,bin,QTID ) 
	values ('" . addslashes($warehouse) . "','" . addslashes($item_Sku) . "','" . addslashes($reorderlevel) . "' ,'" . addslashes($bin_location) . "','" . addslashes($QTID) . "')";


        $this->query($strSQLQuery, 0);
        $lastInsertId = $this->lastInsertId();
//}
        return $lastInsertId;
    }

    function GetBinBySku($Sku) {

        $strAddQuery = "where 1 ";
        $strAddQuery .= ($Sku != '') ? ("and inv_stock.Sku ='" . $Sku . "'") : (" ");
        $strSQLQuery = "select inv_stock.*,w.warehouse_name,w.warehouse_code,w.WID,bin.binlocation_name,bin.binid,q.`condition`,q.condition_qty from inv_bin_stock  inv_stock left outer join w_warehouse w  on inv_stock.Wcode = w.WID left outer join w_binlocation bin  on inv_stock.bin = bin.binid left outer join inv_item_quanity_condition q  on inv_stock.QTID = q.ID " . $strAddQuery;


        return $this->query($strSQLQuery, 1);
    }

function GetConQtyForBin($Sku,$ItemID,$WID=''){

  $strSQLQuery = ($WID > 0) ? (" and WID = '" . $WID . "'") : ("");
 $sql = "SELECT * FROM `inv_item_quanity_condition` where 1 and Sku='".$Sku."' and ItemID ='".$ItemID."'  ".$strSQLQuery." ";
return $arryQtyCond = $this->myquery($sql, 1);

}

function GetConWarehouseQty($Sku,$WID,$Condition){


$sql = "SELECT condition_qty FROM `inv_item_quanity_condition` where 1 and Sku='".$Sku."' and `Condition` ='".$Condition."' and WID='".$WID."' "; $arryQtyCond = $this->myquery($sql, 1);
if($arryQtyCond[0]['condition_qty']>0){

return $arryQtyCond[0]['condition_qty'];
}else{

return 0;
}

}

    function RemoveBinStock($id) {

        $sql = "delete from inv_bin_stock  where id= '" . $id . "'";
        $this->query($sql, 0);
        return 1;
    }

    /*     * **************************************************** */

    function PriceNotification($arryDetails) {
        global $Config;
        extract($arryDetails);
        $department = $Config['DepID'];
        $SelectQuery = "select description,purchase_cost,sell_price from inv_items where ItemID='" . $ItemID . "'";
        $rs = $this->query($SelectQuery);
        if (sizeof($rs)) {
            if ($rs[0]['purchase_cost'] != $purchase_cost) {

                $oldPurchaseCost = $rs[0]['purchase_cost'];
                $notify = 1;
            }

            if ($rs[0]['sell_price'] != $sell_price) {
                $notify2 = 2;
                $oldSaleCost = $rs[0]['sell_price'];
            }
        }


        if ($notify == 1) {
            /*             * ***************************** */


            $arryItem = $this->GetItemById($ItemID);
            if ($_SESSION['AdminType'] == 'admin') {
                $CreatedBy = 'Administrator';
            } else {
                $CreatedBy = $_SESSION['UserName'];
            }
            /** Notification * */
            $arryNotification['refID'] = $Sku;
            $arryNotification['refType'] = "PurchaseCost";
            $arryNotification['Name'] = $rs[0]['description'];
            $arryNotification['Subject'] = "Change Purchase cost for [SKU:" . $Sku . "]";
            $arryNotification['Message'] = 'Purchase cost for Item:' . $rs[0]['description'] . ' [SKU:' . $Sku . '] has been changed from ' . $Config['Currency'] . ' ' . $oldPurchaseCost . ' to ' . $Config['Currency'] . ' ' . $purchase_cost . '';
            $objConfigure = new configure();
            #print_r($arryNotification); exit;
            $objConfigure->AddNotification($arryNotification);
            /*             * **************** */

            /*
              $strSQLQuery = "insert into notification (refID,old_value,new_value,department,notifyDate,locationID,RefType,AdminID,AdminType,CreatedBy,Currency)  values ('" . $Sku. "','" . $oldPurchaseCost . "','" . $purchase_cost . "','".$department."','" .date('d:m:y h:i:s'). "','".$_SESSION['locationID']."','PurchaseCost','".$_SESSION['AdminID']."','".$_SESSION['AdminType']."','".$_SESSION['UserName']."','".$Config['Currency']."')";
              $this->query($strSQLQuery, 0);

              $UpdateDate = date($Config['DateFormat'], strtotime($Config['TodayDate']));

              $htmlPrefix = $Config['EmailTemplateFolder'];
              $contents = file_get_contents($htmlPrefix."price_notify_admin.htm");

              $CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
              $contents = str_replace("[URL]",$Config['Url'],$contents);
              $contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
              $contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
              $contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
              $contents = str_replace("[SKU]",$arryItem[0]['Sku'],$contents);
              $contents = str_replace("[UpdateDate]",$UpdateDate,$contents);
              $contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
              $contents = str_replace("[OLDCOST]",$oldPurchaseCost,$contents);
              $contents = str_replace("[CUR]",$Config['Currency'],$contents);
              $contents = str_replace("[PURCHASECOST]",$purchase_cost,$contents);

              $contents = str_replace("[DESC]",$arryItem[0]['description'],$contents);


              $mail = new MyMailer();
              $mail->IsMail();
              $mail->AddAddress($Config['AdminEmail']);
              $mail->sender($Config['SiteName'], $Config['AdminEmail']);
              $mail->Subject = $Config['SiteName']." - Purchase Price Update - For ".$arryItem[0]['Sku'];
              $mail->IsHTML(true);
              $mail->Body = $contents;
              #echo $Config['AdminEmail'].$contents; exit;
              if($Config['Online'] == '1'){
              $mail->Send();
              }
             */
        }
        if ($notify2 == 2) {
            /*             * ***************************** */
            $arryItem = $this->GetItemById($ItemID);
            if ($_SESSION['AdminType'] == 'admin') {
                $CreatedBy = 'Administrator';
            } else {
                $CreatedBy = $_SESSION['UserName'];
            }

            $arryNotification['refID'] = $Sku;
            $arryNotification['refType'] = "saleCost";
            $arryNotification['Name'] = $rs[0]['description'];
            $arryNotification['Subject'] = "Change Sales cost for [SKU:" . $Sku . "]";
            $arryNotification['Message'] = 'Sales cost for Item:' . $rs[0]['description'] . ' [SKU:' . $Sku . '] has been changed from ' . $Config['Currency'] . ' ' . $oldSaleCost . ' to ' . $Config['Currency'] . ' ' . $sell_price . '';
            $objConfigure = new configure();
            #print_r($arryNotification); exit;
            $objConfigure->AddNotification($arryNotification);


            /* $strSQLQuery = "insert into notification (refID,old_value,new_value,department,notifyDate,locationID,RefType,AdminID,AdminType,CreatedBy,Currency)  values ('" . $Sku. "','" . $oldSaleCost . "','" . $purchase_cost . "','".$department."','" .date('d:m:y h:i:s'). "','".$_SESSION['locationID']."','saleCost','".$_SESSION['AdminID']."','".$_SESSION['AdminType']."','".$_SESSION['UserName']."','".$Config['Currency']."')";
              $this->query($strSQLQuery, 0);
              $UpdateDate = date($Config['DateFormat'], strtotime($Config['TodayDate']));

              $htmlPrefix = $Config['EmailTemplateFolder'];
              $contents = file_get_contents($htmlPrefix."price_notify_sale_admin.htm");

              $CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
              $contents = str_replace("[URL]",$Config['Url'],$contents);
              $contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
              $contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
              $contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
              $contents = str_replace("[SKU]",$arryItem[0]['Sku'],$contents);
              $contents = str_replace("[UpdateDate]",$UpdateDate,$contents);
              $contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
              $contents = str_replace("[OLDCOST]",$oldSaleCost,$contents);
              $contents = str_replace("[SALECOST]",$sell_price,$contents);
              $contents = str_replace("[CUR]",$Config['Currency'],$contents);
              $contents = str_replace("[DESC]",$arryItem[0]['description'],$contents);



              $mail = new MyMailer();
              $mail->IsMail();
              $mail->AddAddress($Config['AdminEmail']);
              $mail->sender($Config['SiteName'], $Config['AdminEmail']);
              $mail->Subject = $Config['SiteName']." - Sale Price Update - For ".$arryItem[0]['Sku'];
              $mail->IsHTML(true);
              $mail->Body = $contents;
              #echo $Config['AdminEmail'].$contents; exit;
              if($Config['Online'] == '1'){
              $mail->Send();
              }
             */
        }
        return 1;
    }

    function PriceNotification555($arryDetails) {
        global $Config;
        extract($arryDetails);
        $department = $Config['DepID'];
        $SelectQuery = "select purchase_cost,sell_price from inv_items where ItemID='" . $ItemID . "'";
        $rs = $this->query($SelectQuery);
        if (sizeof($rs)) {
            if ($rs[0]['purchase_cost'] != $purchase_cost) {

                $oldPurchaseCost = $rs[0]['purchase_cost'];
                $notify = 1;
            }

            if ($rs[0]['sell_price'] != $sell_price) {
                $notify2 = 2;
                $oldSaleCost = $rs[0]['sell_price'];
            }
        }


        if ($notify == 1) {
            /*             * ***************************** */


            $arryItem = $this->GetItemById($ItemID);
            if ($_SESSION['AdminType'] == 'admin') {
                $CreatedBy = 'Administrator';
            } else {
                $CreatedBy = $_SESSION['UserName'];
            }
            #echo $Config['DepID']; exit;
            $strSQLQuery = "insert into notification (refID,old_value,new_value,department,notifyDate,locationID,RefType,AdminID,AdminType,CreatedBy,Currency)  values ('" . $Sku . "','" . $oldPurchaseCost . "','" . $purchase_cost . "','" . $department . "','" . date('d:m:y h:i:s') . "','" . $_SESSION['locationID'] . "','PurchaseCost','" . $_SESSION['AdminID'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['UserName'] . "','" . $Config['Currency'] . "')";
            $this->query($strSQLQuery, 0);





            $UpdateDate = date($Config['DateFormat'], strtotime($Config['TodayDate']));
            /*             * ******************* */
            $htmlPrefix = $Config['EmailTemplateFolder'];
            $contents = file_get_contents($htmlPrefix . "price_notify_admin.htm");

            $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
            $contents = str_replace("[COMPNAY_URL]", $CompanyUrl, $contents);
            $contents = str_replace("[SKU]", $arryItem[0]['Sku'], $contents);
            $contents = str_replace("[UpdateDate]", $UpdateDate, $contents);
            $contents = str_replace("[CreatedBy]", $CreatedBy, $contents);
            $contents = str_replace("[OLDCOST]", $oldPurchaseCost, $contents);
            $contents = str_replace("[CUR]", $Config['Currency'], $contents);
            $contents = str_replace("[PURCHASECOST]", $purchase_cost, $contents);


            $contents = str_replace("[DESC]", $arryItem[0]['description'], $contents);



            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($Config['AdminEmail']);
            $mail->sender($Config['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . " - Purchase Price Update - For " . $arryItem[0]['Sku'];
            $mail->IsHTML(true);
            $mail->Body = $contents;
            #echo $Config['AdminEmail'].$contents; exit;
            if ($Config['Online'] == '1') {
                $mail->Send();
            }
        }
        if ($notify2 == 2) {
            /*             * ***************************** */
            $arryItem = $this->GetItemById($ItemID);
            if ($_SESSION['AdminType'] == 'admin') {
                $CreatedBy = 'Administrator';
            } else {
                $CreatedBy = $_SESSION['UserName'];
            }

            $strSQLQuery = "insert into notification (refID,old_value,new_value,department,notifyDate,locationID,RefType,AdminID,AdminType,CreatedBy,Currency)  values ('" . $Sku . "','" . $oldSaleCost . "','" . $purchase_cost . "','" . $department . "','" . date('d:m:y h:i:s') . "','" . $_SESSION['locationID'] . "','saleCost','" . $_SESSION['AdminID'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['UserName'] . "','" . $Config['Currency'] . "')";
            $this->query($strSQLQuery, 0);





            $UpdateDate = date($Config['DateFormat'], strtotime($Config['TodayDate']));
            /*             * ******************* */
            $htmlPrefix = $Config['EmailTemplateFolder'];
            $contents = file_get_contents($htmlPrefix . "price_notify_sale_admin.htm");

            $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
            $contents = str_replace("[COMPNAY_URL]", $CompanyUrl, $contents);
            $contents = str_replace("[SKU]", $arryItem[0]['Sku'], $contents);
            $contents = str_replace("[UpdateDate]", $UpdateDate, $contents);
            $contents = str_replace("[CreatedBy]", $CreatedBy, $contents);
            $contents = str_replace("[OLDCOST]", $oldSaleCost, $contents);
            $contents = str_replace("[SALECOST]", $sell_price, $contents);
            $contents = str_replace("[CUR]", $Config['Currency'], $contents);
            $contents = str_replace("[DESC]", $arryItem[0]['description'], $contents);



            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($Config['AdminEmail']);
            $mail->sender($Config['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . " - Sale Price Update - For " . $arryItem[0]['Sku'];
            $mail->IsHTML(true);
            $mail->Body = $contents;
            #echo $Config['AdminEmail'].$contents; exit;
            if ($Config['Online'] == '1') {
                $mail->Send();
            }
        }
        return 1;
    }

    function UpdateQuantity($arryDetails) {

        extract($arryDetails);

        $strSQLQuery = "update inv_items set allocated_qty='" . $allocated_qty . "',qty_on_hand ='" . $qty_on_hand . "',qty_on_demand='" . $qty_on_demand . "' where ItemID='" . $ItemID."'";


        $this->query($strSQLQuery, 0);

        return 1;
    }

    function UpdateDimensions($arryDetails) {
        extract($arryDetails);


       // $strSQLQuery = "update inv_items set pack_size='" . addslashes($pack_size) . "',weight='" . addslashes($weight) . "',width='" . addslashes($width) . "',height='" . addslashes($height) . "',depth='" . addslashes($depth) . "' where ItemID='" . $ItemID."'";

        $strSQLQuery = "update inv_items set pack_size='" . addslashes($pack_size) . "',weight='" . addslashes($weight) . "',width='" . addslashes($width) . "',height='" . addslashes($height) . "',depth='" . addslashes($depth) . "',wt_Unit='".addslashes($wtUnit)."'  ,wd_Unit='" . addslashes($wdUnit). "' ,ht_Unit='" . addslashes($htUnit)."' ,ln_Unit='" . addslashes($lnUnit). "' where ItemID='" . $ItemID."'";
        $this->query($strSQLQuery, 0);

        return 1;
    }

    function UpdateSeo($arryDetails) {


        extract($arryDetails);


        $strSQLQuery = "update inv_items set MetaTitle='" . addslashes($MetaTitle) . "',MetaKeywords='" . addslashes($MetaKeywords) . "',MetaDescription = '" . addslashes($MetaDescription) . "',UrlCustom = '" . $UrlCustom . "'  where ItemID='" . $ItemID."'";

        $this->query($strSQLQuery, 0);

        return 1;
    }

    function UpdateInventory($arryDetails) {


        extract($arryDetails);


        $strSQLQuery = "update inv_items set Quantity='" . addslashes($Quantity) . "',InventoryControl='" . addslashes($InventoryControl) . "',InventoryRule = '" . $InventoryRule . "',StockWarning = '" . $StockWarning . "' where ItemID='" . $ItemID."'";

        $this->query($strSQLQuery, 0);

        return 1;
    }

    /*     * ***********************************Alternatative Images Function Start***************************************************************** */

    function AddAlternativeImage($ItemID) {

        $strSQLQuery = "select ItemID from inv_item_images where ItemID='" . $ItemID . "'";

        $arryRow = $this->query($strSQLQuery, 1);
        if (empty($arryRow[0]['ItemID'])) {

            $strSQLQuery = "insert into inv_item_images(ItemID) values ('" . $ItemID . "')";
            $this->query($strSQLQuery, 0);
        }

        return 1;
    }

    function UpdateAlternativeImage($imageId, $imageName, $alt_text) {

        $strSQLQuery = "INSERT INTO inv_item_images set  ItemID='" . $imageId . "', Image='" . $imageName . "', alt_text='" . $alt_text . "'";

        return $this->query($strSQLQuery, 0);
    }

    function GetTotalImagesCount($ItemID) {

        $strSQLQuery = "select count(Iid) as total from inv_item_images where ItemID='" . $ItemID . "'";
        return $this->query($strSQLQuery, 1);
    }

    function GetAlternativeImage($ItemID) {

        $strSQLQuery = "Select * from inv_item_images where ItemID='" . $ItemID . "'";
        return $this->query($strSQLQuery, 1);
    }




    function deleteImage($pid, $imageId) {
	global $Config;
        $objConfigure = new configure();
	 $objFunction=new functions();

        $select = mysql_query("select Image from inv_item_images where Iid = '" . $imageId . "' and ItemID='" . $pid . "'");
        $image = mysql_fetch_array($select);
	 
	if($image['Image']!=''){
		$objFunction->DeleteFileStorage($Config['ItemsSecondary'],$image['Image']);
	}
        $strSQLQuery = "delete from inv_item_images where Iid = '" . $imageId . "' and ItemID='" . $pid . "'";
        $this->query($strSQLQuery, 0);
        return 1;
    }

    /*     * ***********************************employeeative Images Function Start***************************************************************** */

    function RemoveItem($id, $CategoryID, $Front) {
        global $Config;
        $objConfigure = new configure();
	$objFunction=new functions();

        $strSQLQuery = "select Image from inv_items where ItemID='" . $id . "'";
        $arryRow = $this->query($strSQLQuery, 1);
 
        if($arryRow[0]['Image'] != '') {            
	    $objFunction->DeleteFileStorage($Config['Items'],$arryRow[0]['Image']); 
        }

        $sql2 = "select * from inv_item_images where ItemID='" . $id . "'";
        $arryRow2 = $this->query($sql2, 1);

        foreach ($arryRow2 as $key => $values) {
            $Image = $values['Image'];
            if ($Image != '') {
                $objFunction->DeleteFileStorage($Config['ItemsSecondary'],$Image); 
            }
        }

        $strSQLQuery = "delete from inv_items where ItemID='" . $id . "'";
        $this->query($strSQLQuery, 0);

        $strSQLQuery = "delete from inv_item_images where ItemID='" . $id . "'";
        $this->query($strSQLQuery, 0);

        $strSQLQuery = "delete from inv_item_required where ItemID='" . $id . "'";
        $this->query($strSQLQuery, 0);

	$strSQLQuery = "delete from inv_item_alias where item_id='" . $id . "'";
        $this->query($strSQLQuery, 0);

        if ($CategoryID > 0) {
            $strSQLQuery = "select NumProducts from inv_categories where CategoryID='" . $CategoryID . "'";
            $arryRow = $this->query($strSQLQuery, 1);
            if (!empty($arryRow[0]['NumProducts'])) {
                $strUpdateQuery = "update inv_categories set NumProducts = NumProducts - 1 where CategoryID = '" . $CategoryID . "'";
                $this->query($strUpdateQuery, 0);
            }
        }
        return 1;
    }

    function RemoveMultipleItem($ids, $Front) {


        $strSQLQuery = "select Image,CategoryID from inv_items where ItemID in (" . $ids . ")";
        $arryRow = $this->query($strSQLQuery, 1);

        $strSQLQuery = "delete from inv_items where ItemID in (" . $ids . ")";
        $this->query($strSQLQuery, 0);




        if ($Front > 0) {
            $ImgDir = 'upload/items/';
        } else {
            $ImgDir = 'upload/items/images/' . $_SESSION['CmpID'] . '/';
        }

        for ($i = 0; $i < sizeof($arryRow); $i++) {


            if ($arryRow[$i]['Image'] != '' && file_exists($ImgDir . $arryRow[$i]['Image'])) {

                unlink($ImgDir . $arryRow[$i]['Image']);
            }

            if ($arryRow[$i]['Image'] != '' && file_exists($ImgDir . 'secondary/' . $_SESSION['CmpID'] . '/' . $arryRow[$i]['Image'])) {
                unlink($ImgDir . 'secondary/' . $_SESSION['CmpID'] . '/' . $arryRow[$i]['Image']);
            }


            if ($arryRow[$i]['CategoryID'] > 0) {
                $strSQLQuery = "select NumProducts from inv_categories where CategoryID='" . $arryRow[$i]['CategoryID']."'";
                $arryRow2 = $this->query($strSQLQuery, 1);
                if (!empty($arryRow2[$i]['NumProducts'])) {
                    $strUpdateQuery = "update inv_categories set NumProducts = NumProducts - 1 where CategoryID = '" . $arryRow[$i]['CategoryID']."'";
                    $this->query($strUpdateQuery, 0);
                }
            }
        }

        return 1;
    }

    function isItemExists($Name, $ItemID = 0, $CategoryID) {

        $strSQLQuery = "select ItemID from inv_items where LCASE(Name)='" . strtolower(trim($Name)) . "'";

        $strSQLQuery .= ($ItemID > 0) ? (" and ItemID != '" . $ItemID."'") : ("");
        //$strSQLQuery .= (!empty($CategoryID))?(" and CategoryID = '".$CategoryID."'"):("");

        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['ItemID'])) {
            return true;
        } else {
            return false;
        }
    }

    function isItemNumberExists($ProductSku, $ItemID = 0, $PostedByID) {

        $strSQLQuery = "select ItemID from inv_items where LCASE(Sku)='" . strtolower(trim($ProductSku)) . "'";

        $strSQLQuery .= ($ItemID > 0) ? (" and ItemID != '" . $ItemID . "'") : ("");
        $strSQLQuery .= (!empty($PostedByID)) ? (" and PostedByID = '" . $PostedByID."'") : ("");

        $arryRow = $this->query($strSQLQuery, 1);
//echo 'test: '.$arryRow[0]['ItemID']; exit;
        if (!empty($arryRow[0]['ItemID'])) {
            return true;
        } else {
            return false;
        }
    }

    function isItemAliasExists($ItemAliasCode, $AliasID = 0) {

        $strSQLQuery = "select AliasID from inv_item_alias where LCASE(ItemAliasCode)='" . strtolower(trim($ItemAliasCode)) . "'";

        $strSQLQuery .= ($AliasID > 0) ? (" and AliasID != '" . $AliasID . "'") : ("");
       //echo $strSQLQuery; exit;
        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['AliasID'])) {
            return true;
        } else {
            return false;
        }
    }



    function IsActivatedItem($ItemID) {
        $strSQLQuery = "select * from inv_items where ItemID='" . $ItemID . "'";
        $arryRow = $this->query($strSQLQuery, 1);
        if ($arryRow[0]['ItemID'] > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /*     * ************************** */

    function countItemRating($pid) {

        $where = "WHERE Status = 'Yes' AND Pid = '" . $pid."'";
        $strSQLQuery = "SELECT SUM(Rating) as total FROM inv_items_reviews " . $where . "";
        //echo $strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    function changeReviewStatus($id) {
        $strSQLQuery = "SELECT * FROM inv_items_reviews WHERE ReviewId='" . $id."'";
        $rs = $this->query($strSQLQuery);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 'Yes')
                $Status = 'No';
            else
                $Status = 'Yes';

            $strSQLQuery = "UPDATE inv_items_reviews SET Status='" . $Status . "' WHERE ReviewId='" . $id."'";
            $this->query($strSQLQuery, 0);
            return true;
        }
    }

    function getDiscountByItem($id) {
        $where = "WHERE is_active = 'Yes' AND pid = '" . $id."'";
        $strSQLQuery = "SELECT * FROM e_products_quantity_discounts " . $where . "";
        //echo $strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    /*     * ********************* STOCK ADJUSTMENT *********** */

    function ListAdjustment($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {



        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.id='" . $id."'") : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");



        if ($SortBy == 'id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (a.id = '" . $SearchKey . "')") : ("");
        } else {

            if ($SortBy != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( a.adjust_reason like '%" . $SearchKey . "%' or a.Sku like '%" . $SearchKey . "%'  ) " ) : ("");
            }
        }

        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by a.id ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

        $strSQLQuery = "select a.*,i.Sku,i.description,i.itemType,c.valuationType as evaluationType from inv_stock_adjustment a left outer join  inv_items  i on i.Sku=a.Sku left outer join inv_categories c on c.CategoryID =i.CategoryID  " . $strAddQuery;




        return $this->query($strSQLQuery, 1);
    }

    function RemoveAdjustment($id) {

        $strSQLQuery = "DELETE FROM inv_adjustment WHERE adjID = '" . $id."'";
        $rs = $this->query($strSQLQuery, 0);

        $strSQLQuery2 = "DELETE FROM inv_stock_adjustment WHERE adjID = '" . $id."'";
        $this->query($strSQLQuery2, 0);

        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function AddAdjustment($arryDetails) {
        global $Config;
        extract($arryDetails);

        if (empty($Currency))
            $Currency = $Config['Currency'];

        $strSQLQuery = "insert into inv_adjustment(total_adjust_qty,total_adjust_value,WID,warehouse_code,adjust_reason,adjDate,created_by,created_id,Status) 
                            values('" . $TotalQty . "', '" . $TotalValue . "',  '" . $WID . "', '" . $warehouse . "', '" . addslashes($adjustment_reason) . "', '" . $Config['TodayDate'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['AdminID'] . "','" . $Status . "')";

        $this->query($strSQLQuery, 0);
        $adjID = $this->lastInsertId();
        if ($adjID > 0) {
            $rs = $this->getPrefix(1);

            $PrefixAD = $rs[0]['adjustmentPrefix'];


            $ModuleIDValue = $PrefixAD . '000' . $adjID;
            $strSQL = "update inv_adjustment set adjustNo='" . $ModuleIDValue . "' where adjID='" . $adjID."'";
            $this->query($strSQL, 0);
        }







        return $adjID;
    }

    function UpdateAdjustment($arryDetails) {
        global $Config;
        extract($arryDetails);



        /* if($Closed==1){
          $Status="Closed"; $ClosedDate=$Config['TodayDate'];
          }else{
          $Status="In Process"; $ClosedDate='';
          }
         */

        $strSQLQuery = "update inv_adjustment set total_adjust_qty='" . $TotalQty . "', total_adjust_value='" . $TotalValue . "', WID='" . $WID . "',  warehouse_code='" . $warehouse . "', adjust_reason='" . addslashes($adjustment_reason) . "', Status='" . $Status . "',UpdatedDate = '" . $Config['TodayDate'] . "',binloc ='".addslashes($binloc)."'
			where adjID='" . $adjID."'";

        $this->query($strSQLQuery, 0);

        return 1;
    }

    function AddUpdateStock($adjustID, $arryDetails) {



        global $Config;
        extract($arryDetails);


        if (!empty($DelItem)) {
            $strSQLQuery = "delete from inv_stock_adjustment where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }



        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);




                $id = $arryDetails['id' . $i];
                if ($id > 0) {
                    $sql = "update inv_stock_adjustment set item_id='" . $arryDetails['item_id' . $i] . "',valuationType='" . $arryDetails['valuationType' . $i] . "',serial_value='" . $arryDetails['serial_value' . $i] . "', sku='" . addslashes($arryDetails['sku' . $i]) . "', description='" . addslashes($arryDetails['description' . $i]) . "', on_hand_qty='" . addslashes($arryDetails['on_hand_qty' . $i]) . "',  price='" . addslashes($arryDetails['price' . $i]) . "', amount='" . addslashes($arryDetails['amount' . $i]) . "',`Condition`='" . addslashes($arryDetails['Condition' . $i]) . "',QtyType='".$arryDetails['QtyType' . $i]."',serialPrice = '".$arryDetails['serialPrice' . $i]."',serialdesc ='".addslashes($arryDetails['serialdesc' . $i])."',binlocID ='".$arryDetails['binloc']."'  where id='" . $id."'";
 $this->query($sql, 0);


                } else {

                    $sql = "insert into inv_stock_adjustment (adjID, item_id, sku, description, on_hand_qty, qty, price, amount,valuationType,serial_value,`Condition`,QtyType,serialPrice,serialdesc,binlocID) values('" . $adjustID . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "', '" . addslashes($arryDetails['on_hand_qty' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['valuationType' . $i]) . "','" . addslashes($arryDetails['serial_value' . $i]) . "','" . addslashes($arryDetails['Condition' . $i]) . "','".$arryDetails['QtyType' . $i]."','".$arryDetails['serialPrice' . $i]."','".$arryDetails['serialdesc' . $i]."','".$arryDetails['binloc']."')";

 $this->query($sql, 0);
 
         
                }
              

if ($arryDetails['Status'] == 2) {
                    $strSQLItem = "update inv_items set purchase_cost = '" . $arryDetails['price' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($strSQLItem, 0);

/*if($arryDetails['AdjustID']!=''){
	$strSQLItemSr = "update inv_serial_item set Status = '1' and UsedSerial =0 where adjustment_no ='".$adjustID."'  and  Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($strSQLItemSr, 0);
}*/



                    /*                     * ************ Add Serial Number ************************ */


                    if ($arryDetails['AdjustID' . $i] == '') {



if($arryDetails['QtyType' . $i] =='Add'){

#echo "Add"; exit;

                        $serial_noum = explode("|", $arryDetails['serial_value' . $i]);
												$serial_desc = explode("|", $arryDetails['serialdesc' . $i]);
												$serial_price = explode("|", $arryDetails['serialPrice' . $i]);
					if($arryDetails['valuationType' . $i]=='Serialized Average' || $arryDetails['valuationType' . $i]=='Serialized'){							
						for ($j = 0; $j <= sizeof($serial_noum) - 1; $j++) {

						//if(empty($serial_price[$j]) || $serial_price[$j]==''){

						//$srPrice = $arryDetails['price' . $i];
						//}else{
if($serial_price[$j]>0){
						$srPrice = $serial_price[$j];
}else{

$srPrice =$arryDetails['price' . $i];
}

						//}
						$strSQLQuery = "insert into inv_serial_item (adjustment_no,warehouse,serialNumber,Sku,disassembly,`Condition`,description,type,UnitCost,ReceiptDate,binid)  values ('".$adjustID."','" . $arryDetails['warehouse'] . "','" . addslashes($serial_noum[$j]). "','" . addslashes($arryDetails['sku' . $i]) . "','" . $AID . "','".$arryDetails['Condition' . $i]."','" . addslashes($serial_desc[$j]) . "','Adjustment', '".addslashes($srPrice)."','".$Config['TodayDate']."','".$arryDetails['binloc']."' )";
						$this->query($strSQLQuery, 0);
						//echo   $serial_no[$i]."<br/>"; 
						}
 }



   /*********Added By karishma based on Condition 6 Jan 2016*********************/
					if($arryDetails['Condition' . $i]!=''){
						/* $sqlcondV="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['sku' . $i]) . "' 	and `condition`='".addslashes($arryDetails['Condition' . $i])."' and WID='" . $arryDetails['warehouse'] . "' "; */

                $sqlcondV="select count(*) as total from inv_item_quanity_condition where 	Sku='" . addslashes($arryDetails['sku' . $i]) . "'";
                $sqlcondV .= (!empty($arryDetails['Condition' . $i])) ? (" and `condition`='".addslashes($arryDetails['Condition' . $i])."' ") : (" ");
                $sqlcondV .= (!empty($arryDetails['warehouse'])) ? (" and `WID`='".addslashes($arryDetails['warehouse'])."' ") : (" ");
                $sqlcondV .= (!empty($arryDetails['binloc'])) ? (" and `binid`='".addslashes($arryDetails['binloc'])."' ") : (" ");


						$restbl=$this->query($sqlcondV, 1);
						if($restbl[0]['total']==0){
							//If not find insert in tbl
							$strSQLQuery = "insert into inv_item_quanity_condition 
							(ItemID,`condition`,Sku,type,condition_qty,AvgCost,WID,binid)  
							values ('" . addslashes($arryDetails['item_id' . $i]) . "',
							'" . addslashes($arryDetails['Condition' . $i]) . "',
							'" . addslashes($arryDetails['sku' . $i]) . "','Adjustment',
							'" . addslashes($arryDetails['qty' . $i]) . "','" . addslashes($arryDetails['price' . $i]) . "','" . $arryDetails['warehouse'] . "','".addslashes($arryDetails['binloc'])."')";
							$this->query($strSQLQuery, 0);
						}else{
							// update in tbl

							/*$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $arryDetails['qty' . $i] . ",AvgCost =AvgCost +" . addslashes($arryDetails['amount' . $i]) . "  where Sku='" . $arryDetails['sku' . $i] . "' and `condition` = '" .$arryDetails['Condition' . $i]. "' and WID='" . $arryDetails['warehouse'] . "' ";*/
$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $arryDetails['qty' . $i] . ",AvgCost =AvgCost +" . addslashes($arryDetails['amount' . $i]) . "  where Sku='" . $arryDetails['sku' . $i] . "'";

                $UpdateQtysql .= (!empty($arryDetails['Condition' . $i])) ? (" and `condition`='".addslashes($arryDetails['Condition' . $i])."' ") : (" ");
                $UpdateQtysql .= (!empty($arryDetails['warehouse'])) ? (" and `WID`='".addslashes($arryDetails['warehouse'])."' ") : (" ");
                $UpdateQtysql .= (!empty($arryDetails['binloc'])) ? (" and `binid`='".addslashes($arryDetails['binloc'])."' ") : (" ");

							$this->query($UpdateQtysql, 0);
						}
					}


/*
												if($arryDetails['valuationType' . $i]=='Serialized Average'){

																$arrySerial = $this->GetSerialNumberByID('',$arryDetails['sku' . $i],$adjustID,'',$arryDetails['Condition' . $i]);
																$NumItem = count($arrySerial);
																	foreach($arrySerial as $SerVal){
																	     $SerValPrice += $SerVal['UnitCost'];
																	}

												         $SerValPrice = $SerValPrice/$NumItem;


												//$serial_price = explode("|", $arryDetails['serialPrice' . $i]);
												}else{

												         $SerValPrice = $arryDetails['price' . $i];
												}
if($arryDetails['serialPrice' . $i]==''){
$sqlSerialUpdate = "update inv_serial_item set UnitCost = '".$SerValPrice."' where UsedSerial = 0 and Sku = '".$arryDetails['sku' . $i]."' and `Condition` ='".$arryDetails['Condition' . $i]."'";
$this->query($sqlSerialUpdate, 0);
}*/
												$arryTransaction['TransactionOrderID'] = $adjustID;
                        $arryTransaction['TransactionInvoiceID'] = 'AD'.$adjustID;
                        $arryTransaction['TransactionDate'] = $Config['TodayDate'];
                        $arryTransaction['TransactionType'] = 'Adjustment';
												$arryTransaction['valuationType'] = $arryDetails['valuationType' . $i];
												$arryTransaction['TotalAmount'] = $arryDetails['amount' . $i];
												$arryTransaction['TranCondition'] = $arryDetails['Condition' . $i];
                        
                        //$objItem = new items();
                        $this->addItemTransaction($arryTransaction,$arryDetails,$type='ADJUST');


}else if($arryDetails['QtyType' . $i]=='Subtract'){

#echo "Subtract"; exit;
$serial_no = explode(",",$arryDetails['serial_value' . $i]);
//$result1 =  explode ( ",", $values['serial_value'] );
 $resultSr = "'" . implode ( "', '", $serial_no ) . "'";


                        //for ($k = 0; $k < sizeof($serial_no); $k++) {
                               
												//$strSQL = "update inv_serial_item set UsedSerial = '1' where serialNumber='".$serial_no[$j]."' and Sku ='" . addslashes($arryItem[$Count]["sku"]) ."' and `Condition` = '".addslashes($arryItem[$Count]["Condition"])."'"; 
//$strSQL = "update inv_serial_item set Status=0,UsedSerial =1 where serialNumber IN (".$resultSr.") and Sku ='" . addslashes($arryDetails['sku' . $i]) ."' and `Condition` ='".$arryDetails['Condition' . $i]."' and OrderID=0 and warehouse='".$arryDetails['warehouse']."'"; 
//$strSQL = "delete from inv_serial_item  where serialNumber='".trim($serial_no[$k])."' and Sku ='" . addslashes($arryDetails['sku' . $i]) ."' and `condition` = '" .$arryDetails['Condition' . $i]. "'  "; 
$strSQL = "update inv_serial_item set Status=0,UsedSerial =1 where serialNumber IN (".$resultSr.") and Sku ='" . addslashes($arryDetails['sku' . $i]) ."' and  OrderID=0  ";
	$strSQL .= (!empty($arryDetails['Condition' . $i])) ? (" and `Condition`='".addslashes($arryDetails['Condition' . $i])."' ") : (" ");
	$strSQL .= (!empty($arryDetails['warehouse'])) ? (" and `warehouse`='".addslashes($arryDetails['warehouse'])."' ") : (" ");
	$strSQL .= (!empty($arryDetails['binloc'])) ? (" and `binid`='".addslashes($arryDetails['binloc'])."' ") : (" ");

																$this->query($strSQL, 0);

                        //}

/*********Added By bhoodev based on Condition 6 june 2016*********************/
//if($Module=='Order' && empty($id)){
					//if($arryDetails['Condition'.$i]!=''){
						 /* $sqlCond="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['sku'.$i]) . "' and `condition`='".addslashes($arryDetails['Condition'.$i])."' ";  
						$restbl=$this->query($sqlCond, 1);
						if($restbl[0]['total']>0){*/
							
							// update in tbl
							 //$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['qty' . $i] . " ,AvgCost =AvgCost-" . addslashes($arryDetails['amount' . $i]) . "  where Sku='" . $arryDetails['sku'.$i] . "' and `condition`='".addslashes($arryDetails['Condition'.$i])."' and WID='".$arryDetails['warehouse']."' "; 

 $UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['qty' . $i] . " ,AvgCost =AvgCost-" . addslashes($arryDetails['amount' . $i]) . "  where Sku='" . $arryDetails['sku'.$i] . "' ";

                $UpdateQtysql .= (!empty($arryDetails['Condition' . $i])) ? (" and `condition`='".addslashes($arryDetails['Condition' . $i])."' ") : (" ");
                $UpdateQtysql .= (!empty($arryDetails['warehouse'])) ? (" and `WID`='".addslashes($arryDetails['warehouse'])."' ") : (" ");
                $UpdateQtysql .= (!empty($arryDetails['binloc'])) ? (" and `binid`='".addslashes($arryDetails['binloc'])."' ") : (" ");



							$this->query($UpdateQtysql, 0);
						//}
					//}
//}
/*********end By bhoodev based on Condition 6 june 2016*********************/

}
                    }
                    
                  } 

		if ($arryDetails['Status'] == 2) {
				$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "'";
				$this->query($UpdateQtysql, 0);

		}
					
					
					/*********End By karishma based on Condition*********************/

               
            }
        }

        return true;
    }

    function ListSerialNumber($arryDetails) {
					global $Config;
        extract($arryDetails);

if($WID>0){ $warehouse = $WID;}
        $strAddQuery = '';
        $SearchKey = strtolower(trim($key));
        $strAddQuery .= (!empty($id)) ? (" where s.serialID='" . $id."'") : (" where 1 ");
        $strAddQuery .= (!empty($selectIDs)) ? (" and s.serialID in ('" . $selectIDs . "')") : (" ");
        $strAddQuery .= (!empty($Status))?(" and w.Status='".$Status."'"):(" ");
	$strAddQuery .= (!empty($Condition))?(" and s.Condition='".$Condition."'"):(" ");
        $strAddQuery .= (!empty($UsedSerial))?(" and s.UsedSerial='".$UsedSerial."'"):(" ");
        $strAddQuery .= (!empty($warehouse))?(" and s.warehouse='".$warehouse."'"):(" ");
	$strAddQuery .= (!empty($UsedMergeItem))?(" and s.UsedMergeItem=0"):(" ");
        $strAddQuery .= (!empty($Sku)) ? (" and s.Sku='" . $Sku . "'") : (" ");
	$strAddQuery .= (!empty($FromDate))?(" and s.ReceiptDate>='".$FromDate."'"):("");
        $strAddQuery .= (!empty($ToDate))?(" and s.ReceiptDate<='".$ToDate."'"):("");

         if ($SearchKey == 'not available' && ($sortby == 's.UsedSerial' || $sortby == '')) {
            $strAddQuery .= " and (s.UsedSerial=1 or s.UsedSerial=2)";
        } else if ($SearchKey == 'available' && ($sortby == 's.UsedSerial' || $sortby == '')) {
            $strAddQuery .= " and s.UsedSerial=0";
        } else if ($sortby == 's.serialNumber') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (s.serialNumber like '%" . $SearchKey . "%')") : ("");
        } else if ($sortby == 's.Sku') {
         //if($sortby == 's.Sku'){
			
				$checkProduct=$this->checkItemSku($SearchKey);

						//By Chetan 9sep// 
						if(empty($checkProduct))
						{
						$arryAlias = $this->checkItemAliasSku($SearchKey);
							if(count($arryAlias)){
									
                  $mainSku =$arryAlias[0]['sku'];
							}
						}else{
            
						$mainSku = $SearchKey;
						}

				
            $strAddQuery .= (!empty($SearchKey)) ? (" and (s.Sku = '" . $mainSku . "')") : ("");
        } else {
            if ($sortby != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '%" . $SearchKey . "%')") : ("");
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (s.serialNumber like '%" . $SearchKey . "%' or w.warehouse_name like '%" . $SearchKey . "%' or s.Sku like '%" . $SearchKey . "%'  ) " ) : ("");
            }
        }
	
	//$strAddQuery .= (!empty($WID))?(" and w.WID = '".$WID."' "):(" and w.WID = 1 "); //added by chetan on 3Apr2017//
         //$strAddQuery .= " Group BY s.serialNumber ";
        $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by s.Sku ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" desc");

if($Config['GetNumRecords']==1){
		$Columns = " count(s.serialID) as NumCount ";				
	}else{

$Columns = " s.*, w.warehouse_name ,w.warehouse_code,w.WID ";
	if($Config['RecordsPerPage']>0){
			$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
		}
		
	}




          $strSQLQuery = "SELECT ".$Columns."  FROM inv_serial_item s left outer join w_warehouse w on s.warehouse = w.WID " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }



 function ListSerialNumberList1nov($arryDetails) {
					global $Config;
        extract($arryDetails);



        $strAddQuery = '';
        $SearchKey = strtolower(trim($key));
        $strAddQuery .= (!empty($id)) ? (" where s.serialID='" . $id."'") : (" where 1 ");
        $strAddQuery .= (!empty($selectIDs)) ? (" and s.serialID in ('" . $selectIDs . "')") : (" ");
        $strAddQuery .= (!empty($Status))?(" and w.Status='".$Status."'"):(" ");
				$strAddQuery .= (!empty($Condition))?(" and s.Condition='".$Condition."'"):(" ");
        $strAddQuery .= ($UsedSerial!='')?(" and s.UsedSerial='".$UsedSerial."'"):(" ");
      if($Multiple==1){

$serialVal = explode(",",$SerialSearch);
$allserial="'" . implode("','", $serialVal) . "'";
  $strAddQuery .=" and s.serialNumber IN($allserial) ";
}else{

$strAddQuery .=" ";

}
				$strAddQuery .= (!empty($UsedMergeItem))?(" and s.UsedMergeItem=0"):(" ");
        $strAddQuery .= (!empty($Sku)) ? (" and s.Sku='" . $Sku . "'") : (" ");
				$strAddQuery .= (!empty($FromDate))?(" and s.ReceiptDate>='".$FromDate."'"):("");
			  $strAddQuery .= (!empty($ToDate))?(" and s.ReceiptDate<='".$ToDate."'"):("");
        //$strAddQuery .= (!empty($ToDate))?(" and s.ReceiptDate<='".$ToDate."'"):("");
			$strAddQuery .= " and s.Status=1";

         if ($SearchKey == 'not available' && ($sortby == 's.UsedSerial' || $sortby == '')) {
            $strAddQuery .= " and (s.UsedSerial=1 or s.UsedSerial=2)";
        } else if ($SearchKey == 'available' && ($sortby == 's.UsedSerial' || $sortby == '')) {
            $strAddQuery .= " and s.UsedSerial=0";
        } else if ($sortby == 's.serialNumber') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (s.serialNumber like '%" . $SearchKey . "%')") : ("");
        } else if ($sortby == 's.Sku') {
         		$checkProduct=$this->checkItemSku($SearchKey);

						//By Chetan 9sep// 
						if(empty($checkProduct))
						{
						$arryAlias = $this->checkItemAliasSku($SearchKey);
							if(count($arryAlias)){
									
                  $mainSku =$arryAlias[0]['sku'];
							}
						}else{
            
						$mainSku = $SearchKey;
						}
            $strAddQuery .= (!empty($SearchKey)) ? (" and (s.Sku = '" . $mainSku . "')") : ("");
        } else {
            if ($sortby != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '%" . $SearchKey . "%')") : ("");
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (s.serialNumber like '%" . $SearchKey . "%' or w.warehouse_name like '%" . $SearchKey . "%' or s.Sku like '%" . $SearchKey . "%' or o.CustomerName like '%" . $SearchKey ."%' or p.SuppCompany like '%".$SearchKey."%' or o.InvoiceID like '%".$SearchKey."%' or pinv.InvoiceID like '%".$SearchKey."%'  )  " ) : ("");
            }
        }

         //$strAddQuery .= " Order BY s.serialNumber,s.Sku ";
 $strAddQuery .= " group BY s.serialID ";
       

if($Config['GetNumRecords']==1){
		$Columns = " count(s.serialID) as NumCount ";				
	}else{

$Columns = " s.*, w.warehouse_name ,w.warehouse_code,w.WID,o.InvoiceID,o.CustCode,o.CustomerName as OrderCustomerName, IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName,p.SuppCode,p.SuppCompany,p.PurchaseID, p.ReceiptID, p.RefInvoiceID, pinv.InvoiceID as pInvoiceID,pinv.PurchaseID,pinv.OrderID as pInvID";
 //$strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" group by o.InvoiceID,s.serialNumber ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" desc");
	if($Config['RecordsPerPage']>0){
			$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
		}
		
	}




           $strSQLQuery = "SELECT ".$Columns."  FROM inv_serial_item s left join w_warehouse w on (s.warehouse = w.WID and s.warehouse>'0') left outer join s_order o on (o.OrderID=s.OrderID and s.OrderID>'0') left join p_order p on (p.OrderID=s.ReceiveOrderID and s.ReceiveOrderID>'0' and p.Module='Receipt')  left join p_order pinv on (pinv.PurchaseID=p.PurchaseID and pinv.Module='Invoice') left outer join s_customers c on o.CustCode=c.CustCode " . $strAddQuery; 

	  //echo $strSQLQuery;  
        return $this->query($strSQLQuery, 1);
    }


	
 function ListSerialNumberList($arryDetails) {
					global $Config;
        extract($arryDetails);






        $strAddQuery = '';
        $SearchKey = strtolower(trim($key));
        $strAddQuery .= (!empty($id)) ? (" where s.serialID='" . $id."'") : (" where s.serialNumber!='' ");
        $strAddQuery .= (!empty($selectIDs)) ? (" and s.serialID in ('" . $selectIDs . "')") : (" ");
        $strAddQuery .= (!empty($Status))?(" and w.Status='".$Status."'"):(" ");
				$strAddQuery .= (!empty($Condition))?(" and s.Condition='".$Condition."'"):(" ");
        $strAddQuery .= (!empty($UsedSerial) )?(" and s.UsedSerial='".$UsedSerial."'"):(" ");
if(!empty($UsedSerialCheck)){

if($UsedSerialCheck=='Used'){ $CheckSerial =1;} else{ $CheckSerial =0;}
 $strAddQuery .= (" and s.UsedSerial='".$CheckSerial."' and s.Status=1");
}


					if($Multiple==1){

								$serialVal = explode(",",$SerialSearch);
								$Config['RecordsPerPage'] = count($serialVal); 
								$Config['GetNumRecords'] = 0;
								$allserial="'" . implode("','", $serialVal) . "'";
								$strAddQuery .=" and s.serialNumber IN($allserial) ";

					}
				$strAddQuery .= (!empty($UsedMergeItem))?(" and s.UsedMergeItem='0'"):(" ");
        $strAddQuery .= (!empty($Sku)) ? (" and s.Sku='" . $Sku . "'") : (" ");
				$strAddQuery .= (!empty($FromDate))?(" and s.ReceiptDate>='".$FromDate."'"):("");
			  $strAddQuery .= (!empty($ToDate))?(" and s.ReceiptDate<='".$ToDate."'"):("");
        //$strAddQuery .= (!empty($ToDate))?(" and s.ReceiptDate<='".$ToDate."'"):("");
			$strAddQuery .= " and s.Status='1'";

         if ($SearchKey == 'not available' && ($sortby == 's.UsedSerial' || $sortby == '')) {
            $strAddQuery .= " and (s.UsedSerial='1' or s.UsedSerial='2')";
        } else if ($SearchKey == 'available' && ($sortby == 's.UsedSerial' || $sortby == '')) {
            $strAddQuery .= " and s.UsedSerial='0'";
        } else if ($sortby == 's.serialNumber') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (s.serialNumber like '%" . $SearchKey . "%')") : ("");
        } else if ($sortby == 's.Sku') {
         		$checkProduct=$this->checkItemSku($SearchKey);

						//By Chetan 9sep// 
						if(empty($checkProduct))
						{
						$arryAlias = $this->checkItemAliasSku($SearchKey);
							if(count($arryAlias)){
									
                  $mainSku =$arryAlias[0]['sku'];
							}
						}else{
            
						$mainSku = $SearchKey;
						}
            $strAddQuery .= (!empty($mainSku)) ? (" and (s.Sku = '" . $mainSku . "')") : ("");
        } else {
            if ($sortby != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '%" . $SearchKey . "%')") : ("");
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (s.serialNumber like '%" . $SearchKey . "%' or w.warehouse_name like '%" . $SearchKey . "%' or s.Sku like '%" . $SearchKey . "%' or o.CustomerName like '%" . $SearchKey ."%' or p.SuppCompany like '%".$SearchKey."%' or o.InvoiceID like '%".$SearchKey."%' or p.RefInvoiceID like '%".$SearchKey."%'  )  " ) : ("");
            }
        }

         //$strAddQuery .= " Order BY s.serialNumber,s.Sku ";
 
       

if($Config['GetNumRecords']==1){
		$Columns = " count(s.serialID) as NumCount ";				
	}else{
$strAddQuery .= " group BY s.serialID ";
$Columns = " s.*, w.warehouse_name ,w.warehouse_code,w.WID,o.InvoiceID,o.CustCode,o.CustomerName as OrderCustomerName, IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName,p.SuppCode,p.SuppCompany,p.PurchaseID, p.ReceiptID, p.RefInvoiceID as pInvoiceID ";
 //$strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" group by o.InvoiceID,s.serialNumber ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" desc");
	if($Config['RecordsPerPage']>0){
			$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
		}
		
	}



 
              $strSQLQuery = "SELECT ".$Columns."  FROM inv_serial_item s left outer join w_warehouse w on (s.warehouse = w.WID and s.warehouse>'0') left outer join s_order o on (o.OrderID=s.OrderID and s.OrderID>'0') left outer join p_order p on (p.OrderID=s.ReceiveOrderID and s.ReceiveOrderID>'0' and p.Module='Receipt')  left outer join s_customers c on (o.CustCode=c.CustCode and o.CustCode!='') " . $strAddQuery; 

  	 
        return $this->query($strSQLQuery, 1);
    }
function RelatedSerial($OrderID,$SelectType){

 $strSQLQuery = "SELECT serialNumber,Sku  FROM inv_serial_item where assembleID='".$OrderID."' ";
return $this->query($strSQLQuery, 1);

}
 
    function AddSerialNumber($arrayDetail) {

        extract($arrayDetail);


        for ($i = 0; $i < sizeof($serial_no); $i++) {
            $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku)  values ('1','" . $serial_no[$i] . "','" . $Sku . "')";
            $this->query($strSQLQuery, 0);
            //echo   $serial_no[$i]."<br/>"; 
        }
        return 1;
    }
    
    function AddSerialNumberByImport($arrDetailsPost,$arryDetailImp){
						extract($arrDetailsPost);
						
				foreach($arryDetailImp as $value){

						 $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,description,adjustment_no,Status,UsedSerial,Sku,`Condition`,type,UnitCost)  values ('1','" . $value['serialNo'] . "','" . $value['description'] . "','".$AdjustID."','0','1','" . $SerlSku . "','".$Condition."','Adjust','".$value['price']."')";
						$this->query($strSQLQuery, 0);

						}


    }
    
    function GetSerialNumberByID($id,$Sku,$adjustment_no,$disassembly,$Condition) {

        extract($arryDetails);

        $strAddQuery .= (!empty($id)) ? (" where s.serialID='" . $id."'") : (" where 1 and UsedSerial ='0' ");
        $strAddQuery .= (!empty($selectIDs)) ? (" and s.serialID in ('" . $selectIDs . "')") : (" ");
        $strAddQuery .= (!empty($adjustment_no))?(" and s.adjustment_no='".$adjustment_no."'"):(" ");
        $strAddQuery .= (!empty($disassembly))?(" and s.disassembly='".$disassembly."'"):(" ");
 $strAddQuery .= (!empty($Condition))?(" and s.`Condition`='".$Condition."'"):(" ");
        $strAddQuery .= (!empty($Sku)) ? (" and s.Sku='" . $Sku . "'") : (" ");
        $strAddQuery .= " order by s.Sku Desc";
        

         $strSQLQuery = "SELECT s.*, w.warehouse_name ,w.warehouse_code,w.WID  FROM inv_serial_item s left outer join w_warehouse w on s.warehouse = w.WID " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }
     function GetSerialNumber($id,$Sku,$adjustment_no,$disassembly) {

        extract($arryDetails);

        $strAddQuery .= (!empty($id)) ? (" where s.serialID='" . $id."'") : (" where 1 ");
        $strAddQuery .= (!empty($selectIDs)) ? (" and s.serialID in ('" . $selectIDs . "')") : (" ");
        $strAddQuery .= (!empty($adjustment_no))?(" and s.adjustment_no='".$adjustment_no."'"):(" ");
        $strAddQuery .= (!empty($disassembly))?(" and s.disassembly='".$disassembly."'"):(" ");
        $strAddQuery .= (!empty($Sku)) ? (" and s.Sku='" . $Sku . "'") : (" ");
        $strAddQuery .= " order by s.Sku Desc";
        

         $strSQLQuery = "SELECT s.*, w.warehouse_name ,w.warehouse_code  FROM inv_serial_item s left outer join w_warehouse w on s.warehouse = w.warehouse_code " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }

    /*     * **********UPDATE PREFIX***************** */

    function updatePrefix($arryDetails) {

        extract($arryDetails);

        $strSQLQuery = "Update  inv_prefix set adjustmentPrefix='" . $adjustmentPrefix . "',
							adjustPrefixNum='" . $adjustPrefixNum . "',
							ToP = '" . $ToP . "', 
							ToN='" . $ToN . "',
							bom_prefix='" . $bom_prefix . "',
							bom_number='" . $bom_number . "',
							updateDate='" . date('Y-m-d') . "',
							created_by='" . $_SESSION['AdminType'] . "',
							created_id='" . $_SESSION['AdminID'] . "' 
							where prefixID = '" . $prefixID . "'";
        $this->query($strSQLQuery, 0);
        return 1;
    }

    function getPrefix($prefixID) {

        $strSQLQuery = "SELECT * FROM inv_prefix where prefixID= '" . $prefixID . "'";
        //echo $strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    function ListingAdjustment($id = 0, $SearchKey, $SortBy, $AscDesc, $Status,$FromDate=0,$ToDate=0) {

global $Config;
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.adjID='" . $id."'") : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");
      $strAddQuery .= (!empty($FromDate))?(" and a.adjDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and a.adjDate<='".$ToDate."'"):("");



        if ($SortBy != '') {
            if ($SortBy == 'a.Status') {
                if ($SearchKey == "parked") {
                    $SearchKey = 1;
                } else if ($SearchKey == "completed") {
                    $SearchKey = 2;
                } else {
                    $SearchKey = 0;
                }
                $strAddQuery .= " and a.Status = '" . $SearchKey . "'";
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
            }
        } else {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (a.adjustNo like '%" . $SearchKey . "%' or a.total_adjust_qty like '%" . $SearchKey . "%' or a.total_adjust_value like '%" . $SearchKey . "%' or ast.sku like '%" . $SearchKey . "%'  ) " ) : ("");
        }



        //$strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by a.adjID ");
        //$strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");
if($Config['GetNumRecords']==1){
				$Columns = " count(a.adjID) as NumCount ";				
			}else{		


        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by a.adjID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");	
				$Columns = " a.*, w.warehouse_name ,w.warehouse_code,w.WID,d.Department,e.EmpID,e.Department as emp_department,e.Role,e.FirstName as emp_name ,e.UserName,e2.UserName as created,e2.Department as create_department,d2.Department as create_Department,e2.Role as create_role ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}



        $strSQLQuery = "SELECT ".$Columns."  FROM inv_adjustment a left outer join w_warehouse w on a.warehouse_code = w.WID left outer join  h_employee e on e.EmpID=a.created_id left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e2.EmpID=a.created_id left outer join  h_department d2 on e2.Department=d2.depID left outer join  inv_stock_adjustment ast on ast.adjID=a.adjID " . $strAddQuery;
        //$strSQLQuery = "SELECT a.*, w.warehouse_name ,w.warehouse_code  FROM inv_adjustment a left outer join w_warehouse w on BINARY(a.warehouse_code) = BINARY(w.warehouse_code) " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }

    function GetAdjustmentStock($adjID) {
	$strAddQuery =''; 
        $strAddQuery .= (!empty($adjID)) ? (" and adjID='" . $adjID."'") : ("");
        $strSQLQuery = "select * from inv_stock_adjustment  where 1" . $strAddQuery . " order by id asc";
        return $this->query($strSQLQuery, 1);
    }

    /*     * *************** Stock Transfer ******************** */

    function ListingTransfer($arryDetails) {

        extract($arryDetails);
        $strAddQuery = '';
        $SearchKey = strtolower(trim($key));
        if ($edit > 0)
            $id = $edit;
        $strAddQuery .= (!empty($id)) ? (" where t.transferID='" . $id."'") : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and t.Status='".$Status."'"):(" ");



        if ($sortby != '') {
            if ($sortby == 't.Status') {
                if ($SearchKey == 'completed') {
                    $SearchKey = 2;
                } elseif ($SearchKey == 'parked') {
                    $SearchKey = 1;
                } elseif ($SearchKey == 'cancel') {
                    $SearchKey = 1;
                }
                $strAddQuery .= " and t.Status = '" . $SearchKey . "'";
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '%" . $SearchKey . "%')") : ("");
            }
        } else {
            $strAddQuery .= (!empty($SearchKey)) ? (" and ( t.total_transfer_qty like '%" . $SearchKey . "%' or t.transferNo like '%" . $SearchKey . "%' or t.total_transfer_value like '%" . $SearchKey . "%' or t.Status like '%" . $SearchKey . "%' or w2.warehouse_name like '%" . $SearchKey . "%' or w1.warehouse_name like '%" . $SearchKey . "%' ) " ) : ("");
        }



        $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by t.transferID ");
        $strAddQuery .= (!empty($asc)) ? ($asc) : (" desc");

        $strSQLQuery = "SELECT t.*, w1.warehouse_name as from_warehouse,w2.warehouse_code as from_warehouse_code,w2.warehouse_name as to_warehouse,w2.warehouse_code as to_warehouse_code  FROM inv_transfer t left outer join w_warehouse w1 on t.from_WID = w1.WID left outer join w_warehouse w2 on t.to_WID = w2.WID  " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }

    function ListTransfer($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {



        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.id='" . $id."'") : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and w.Status='".$Status."'"):(" ");



        if ($SortBy == 'id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (a.id = '" . $SearchKey . "')") : ("");
        } else {

            if ($SortBy != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( a.transfer_reason like '%" . $SearchKey . "%' or  a.transferNo like '%" . $SearchKey . "%' or a.Sku like '%" . $SearchKey . "%'  ) " ) : ("");
            }
        }

        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by a.id ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

       $strSQLQuery = "select a.*,i.Sku,i.description,i.itemType,c.valuationType as evaluationType from inv_stock_transfer a left outer join  inv_items  i on i.Sku=a.Sku left outer join inv_categories c on c.CategoryID =i.CategoryID  " . $strAddQuery;




        return $this->query($strSQLQuery, 1);
    }

    function RemoveTransfer($id) {

        $strSQLQuery = "DELETE FROM inv_transfer WHERE transferID = '" . $id."'";
        $rs = $this->query($strSQLQuery, 0);

        $strSQLQuery2 = "DELETE FROM inv_stock_transfer WHERE transferID = '" . $id."'";
        $this->query($strSQLQuery2, 0);

        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function GetAdjustment($AdjID, $Status) {
        $strAddQuery .= (!empty($AdjID)) ? (" and a.adjID='" . $AdjID."'") : ("");
        $strAddQuery .= (!empty($Status)) ? (" and a.Status='" . $Status . "'") : ("");

        $strSQLQuery = "select a.*, w.warehouse_name,w.WID,w.warehouse_code  from inv_adjustment a left outer join w_warehouse  w on BINARY w.warehouse_code = BINARY a.warehouse_code where 1" . $strAddQuery . " order by a.adjID desc";
        return $this->query($strSQLQuery, 1);
    }

    function AddTransfer($arryDetails) {
        global $Config;
        extract($arryDetails);

        if (empty($Currency))
            $Currency = $Config['Currency'];

       /* $strSQLQuery = "insert into inv_transfer(total_transfer_qty,total_transfer_value,to_WID,from_WID,transfer_reason,transferDate,created_by,created_id,Status) 
                            values('" . $TotalQty . "', '" . $TotalValue . "',  '" . $to_WID . "', '" . $from_WID . "', '" . addslashes($transfer_reason) . "', '" . $Config['TodayDate'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['AdminID'] . "','" . $Status . "')";*/
$strSQLQuery = "insert into inv_transfer(total_transfer_qty,total_transfer_value,to_WID,binlocTo,from_WID,binlocFrom,transfer_reason,transferDate,created_by,created_id,Status) 
                            values('" . $TotalQty . "', '" . $TotalValue . "',  '" . $to_WID . "','" . $binlocTo . "', '" . $from_WID . "','" . $binlocFrom . "', '" . addslashes($transfer_reason) . "', '" . $Config['TodayDate'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['AdminID'] . "','" . $Status . "')";


        $this->query($strSQLQuery, 0);
        $tranID = $this->lastInsertId();
        if ($tranID > 0) {
            $rs = $this->getPrefix(1);
            $PrefixAD = $rs[0]['ToP'];
            $ModuleIDValue = $PrefixAD . '000' . $tranID;
            $strSQL = "update inv_transfer set transferNo='" . $ModuleIDValue . "' where transferID='" . $tranID."'";
            $this->query($strSQL, 0);
        }

        return $tranID;
    }

    function UpdateTransfer($arryDetails) {
        global $Config;
        extract($arryDetails);



        /* if($Closed==1){
          $Status="Closed"; $ClosedDate=$Config['TodayDate'];
          }else{
          $Status="In Process"; $ClosedDate='';
          }
         */

       /* $strSQLQuery = "update inv_transfer set total_transfer_qty='" . $TotalQty . "', total_transfer_value='" . $TotalValue . "', to_WID='" . $to_WID . "', from_WID='" . $from_WID . "', transfer_reason='" . addslashes($transfer_reason) . "', Status='" . $Status . "',UpdatedDate = '" . $Config['TodayDate'] . "'
			where transferID='" . $transferID."'";*/

        $strSQLQuery = "update inv_transfer set total_transfer_qty='" . $TotalQty . "', total_transfer_value='" . $TotalValue . "', to_WID='" . $to_WID . "',binlocTo='" . $binlocTo . "', from_WID='" . $from_WID . "',binlocFrom='" . $binlocFrom . "', transfer_reason='" . addslashes($transfer_reason) . "', Status='" . $Status . "',UpdatedDate = '" . $Config['TodayDate'] . "'
			where transferID='" . $transferID."'";

        $this->query($strSQLQuery, 0);

        return 1;
    }

    function AddUpdateTransferStock($tID, $arryDetails) {
        global $Config;
        extract($arryDetails);


        if (!empty($DelItem)) {
            $strSQLQuery = "delete from inv_transfer_adjustment where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }



        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);

                $id = $arryDetails['id' . $i];
                if ($id > 0) {
                    $sql = "update inv_stock_transfer set item_id='" . $arryDetails['item_id' . $i] . "', sku='" . addslashes($arryDetails['sku' . $i]) . "', description='" . addslashes($arryDetails['description' . $i]) . "', on_hand_qty='" . addslashes($arryDetails['on_hand_qty' . $i]) . "', price='" . addslashes($arryDetails['price' . $i]) . "', amount='" . addslashes($arryDetails['amount' . $i]) . "' ,`Condition`='" . addslashes($arryDetails['Condition' . $i]) . "',serial_value='".addslashes($arryDetails['serial_value' . $i])."' where id='" . $id."'";
                } else {

                    $sql = "insert into inv_stock_transfer (transferID, item_id, sku, description, on_hand_qty, qty, price, amount,valuationType,serial_value,`Condition`) values('" . $tID . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "', '" . addslashes($arryDetails['on_hand_qty' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['serial_value' . $i]) . "','" . addslashes($arryDetails['valuationType' . $i]) . "','" . addslashes($arryDetails['serial_value' . $i]) . "','" . addslashes($arryDetails['Condition' . $i]) . "')";
                }


if($Status==2){
$serial_no = explode(",",$arryDetails['serial_value' . $i]);
$resultSr = "'" . implode ( "', '", $serial_no ) . "'";

$strAddQuerySrial .= (!empty($arryDetails['Condition' . $i])) ? (" and `Condition`='" .addslashes($arryDetails['Condition' . $i])."'") : ("");
$strAddQuerySrial .= (!empty($from_WID)) ? (" and warehouse='" . $from_WID."'") : ("");
$strAddQuerySrial .= (!empty($binlocFrom)) ? (" and binid='".$binlocFrom."'") : ("");

 //$strSQL = "update inv_serial_item set warehouse= '".$to_WID."' where serialNumber IN (".$resultSr.") and Sku ='" . addslashes($arryDetails['sku' . $i]) ."' and `Condition` ='".$arryDetails['Condition' . $i]."' and UsedSerial =0  "; 
 $strSQL = "update inv_serial_item set warehouse= '".$to_WID."',binid='".$binlocTo."' where serialNumber IN (".$resultSr.") and Sku ='" . addslashes($arryDetails['sku' . $i]) ."'  and UsedSerial =0 and Status=1 ".$strAddQuerySrial." "; 
					$this->query($strSQL, 0);



//if($arryDetails['Condition' . $i]!=''){


$strAddQueryTo .= (!empty($to_WID)) ? (" and WID='" . $to_WID."'") : ("");
$strAddQueryTo .= (!empty($arryDetails['Condition' . $i])) ? (" and `condition`='" .addslashes($arryDetails['Condition' . $i])."'") : ("");
$strAddQueryTo .= (!empty($binlocTo)) ? (" and binid='" . $binlocTo."'") : ("");

$strAddQueryFrom .= (!empty($from_WID)) ? (" and WID='" . $from_WID."'") : ("");
$strAddQueryFrom .= (!empty($binlocFrom)) ? (" and binid='".$binlocFrom."'") : ("");
$strAddQueryFrom .= (!empty($arryDetails['Condition' . $i])) ? (" and `condition`='" .addslashes($arryDetails['Condition' . $i])."'") : ("");


						 /*$sqlToCount="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['sku' . $i]) . "' and ItemID='" . addslashes($arryDetails['item_id' . $i]) . "'
						and `condition`='".addslashes($arryDetails['Condition' . $i])."' and WID='".$to_WID."' "; */
 $sqlToCount="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['sku' . $i]) . "' and ItemID='" . addslashes($arryDetails['item_id' . $i]) . "'
						  ".$strAddQueryTo." "; 
						$restbl=$this->query($sqlToCount, 1);
						if($restbl[0]['total']>0){
							// update in tbl
							/*$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "' and `condition`='".addslashes($arryDetails['Condition' . $i])."' and WID='".$from_WID."'";*/
 $UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "' ".$strAddQueryFrom." ";
							$this->query($UpdateQtysql, 0);

//$UpdateToQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "' and WID='".$to_WID."' and `condition`='".addslashes($arryDetails['Condition' . $i])."'";
$UpdateToQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "' ".$strAddQueryTo." "; 
							$this->query($UpdateToQtysql, 0);

						}else{

$strSQLTransQuery = "insert into inv_item_quanity_condition 
							(ItemID,`condition`,Sku,type,condition_qty,WID,binid)  
							values ('" . addslashes($arryDetails['item_id' . $i]) . "',
							'" . addslashes($arryDetails['Condition' . $i]) . "',
							'" . addslashes($arryDetails['sku' . $i]) . "','Transfer',
							'" . addslashes($arryDetails['qty' . $i]) . "','".$to_WID."','".$binlocTo."')";
							$this->query($strSQLTransQuery, 0);

/*$UpdatetrQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "' and `condition` = '".$arryDetails['Condition' . $i]."' and WID='".$from_WID."'";*/
$UpdatetrQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "' ".$strAddQueryFrom." ";
							$this->query($UpdatetrQtysql, 0);

}
					//}


}

                $this->query($sql, 0);
            }
        }

        return true;
    }

    function GetTransferStock($transferID) {
        $strAddQuery = (!empty($transferID)) ? (" and transferID='" . $transferID."'") : ("");
        $strSQLQuery = "select * from inv_stock_transfer  where 1" . $strAddQuery . " order by id asc";
        return $this->query($strSQLQuery, 1);
    }

    function GetTransfer($transferID) {
	$strAddQuery = ''; 
        $strAddQuery .= (!empty($transferID)) ? (" and t.transferID='" . $transferID . "'") : ("");
        $strSQLQuery = "select t.*,  w1.warehouse_name as from_warehouse,w2.warehouse_code as from_warehouse_code,w2.warehouse_name as to_warehouse,w2.warehouse_code as to_warehouse_code  FROM inv_transfer t left outer join w_warehouse w1 on t.from_WID = w1.WID left outer join w_warehouse w2 on t.to_WID = w2.WID  where 1 " . $strAddQuery . " order by t.transferID asc";
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


                $totalQTY = $this->getTotalQtySum($arryDetails['qty' . $i]);


                $id = $arryDetails['id' . $i];
                $sql = "update inv_items set qty_on_hand = qty_on_hand+'" . $totalQTY . "'  where ItemID=" . $arryDetails['item_id' . $i];
                $this->query($sql, 0);
                /* if ($arryDetails['Status'] == 2) {
                  $sql = "update inv_items set qty_on_hand='" . $totalQTY . "'  where ItemID=" . $arryDetails['item_id' . $i];
                  } else if ($arryDetails['Status'] == 1) {

                  $sql = "update inv_items set allocated_qty='" . $totalQTY . "'  where ItemID=" . $arryDetails['item_id' . $i];
                  } */
            }
        }




        //$exequery = mysql_fetch_array($strSQLQuery);
    }

    /*     * *************** End Transfer ********************** */

    /*function GetPurchasedPriceItem($sku) {
	 $strAddQuery ='';
        $strAddQuery .= (!empty($sku)) ? (" and i.sku='" . $sku . "'") : ("");
        $strSQLQuery = "select o.SuppCode,o.SuppCompany,o.OrderID,o.PurchaseID,o.OrderDate,o.Currency, i.item_id,i.sku,i.qty,i.description,i.price from p_order o inner join p_order_item i on o.OrderID=i.OrderID where o.Status='Completed' and o.Approved='1'  and o.Module='Order' " . $strAddQuery . " order by o.OrderDate desc ";
        return $this->query($strSQLQuery, 1);
    }*/

 function GetPurchasedPriceItem($sku,$curP='') {
global $Config;
	$strAddQuery ='';
        $strAddQuery .= (!empty($sku)) ? (" and i.sku='" . $sku . "'") : ("");
        //$strSQLQuery = "select o.SuppCode,o.SuppCompany,o.OrderID,o.PurchaseID,o.OrderDate,o.Currency, i.item_id,i.sku,i.qty,i.description,i.price from p_order o inner join p_order_item i on o.OrderID=i.OrderID where o.Status='Completed' and o.Approved='1'  and o.Module='Order' " . $strAddQuery . " order by o.OrderDate desc ";GetPurchaseItem
//+i.freight_cost

if(!empty($Config['GetNumRecords'])){
		$Columns = " count(i.id) as NumCount ";				
	}else{

		//$strAddQuery .= $groupby;

	 $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by o.PostedDate desc,o.OrderID ");
	 $strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");

	
            $Columns = "o.OrderID,o.Currency, o.ConversionRate, o.PostedDate,o.SuppCompany,o.SuppCode,i.id, i.sku,i.description,i.qty,i.qty_received,i.amount, ((i.amount/i.qty_received)+i.freight_cost/i.qty_received) as ItemCost,c.valuationType as evaluationType"; 
				
	
		 
		if(!empty($Config['RecordsPerPage'])){
			$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
		}
		
	}


  $strSQLQuery = "select $Columns  from p_order o inner join p_order_item i on o.OrderID=i.OrderID  join inv_items item on item.Sku=i.sku left outer join inv_categories c on c.CategoryID =item.CategoryID where 1 and o.Module='Receipt' and o.ReceiptStatus ='Completed' and i.sku='" . $sku . "'   ".$strAddQuery." ";



//$StrQuery="SELECT ind.adjustNo as OrderID,'".$Config['Currency']."' as Currency,'0' as ConversionRate,ind.adjDate as PostedDate,'Adjustment' as SuppCompany,ind.adjustNo as SuppCode ,isa.qty as qty_received,isa.amount,sum(isa.amount/isa.qty) as ItemCost,isa.valuationType as evaluationType  FROM inv_stock_adjustment as isa join inv_adjustment as ind on isa.adjid = ind.adjid WHERE isa.sku = '" . $sku . "' and isa.Condition = '" . $condition . "' and ind.Status = '2'";

//$strSQLQuery = "select * from (".$strSQLQuery." UNION ".$StrQuery.") as total  ";
		return $arryRow = $this->query($strSQLQuery, 1);


//echo "<pre>";

//print_r($arryRow );
//exit;


        
    }

function GetAdjustmentPriceItem($sku){

$StrQuery="SELECT ind.adjustNo as OrderID,'' as Currency,'0' as ConversionRate,ind.adjDate as PostedDate,'Adjustment' as SuppCompany,ind.adjustNo as SuppCode ,isa.sku,isa.qty,isa.qty as qty_received,isa.amount,sum(isa.amount/isa.qty) as ItemCost,isa.valuationType as evaluationType FROM inv_stock_adjustment as isa join inv_adjustment as ind on isa.adjid = ind.adjid WHERE isa.sku = '" . $sku . "' and ind.Status = '2'";

return $arryRow = $this->query($StrQuery, 1);

}


function GetCostofGood($sku,$limit) {
       
	global $Config;
	$ItemCost = $LastCost = 0;

	if(!empty($sku)){		
		
	$strSQLQuery = "select o.OrderID,o.Currency,o.PostedDate, o.ConversionRate, i.sku,i.qty,i.qty_received,i.amount,  ((i.amount+i.freight_cost)/i.qty_received) as ItemCost,c.valuationType as evaluationType from p_order o inner join p_order_item i on o.OrderID=i.OrderID  join inv_items item on item.Sku=i.sku left outer join inv_categories c on c.CategoryID =item.CategoryID where 1 and o.Module='Receipt' and o.ReceiptStatus ='Completed' and i.sku='" . $sku . "' order by o.PostedDate desc,o.OrderID desc ";
$strSQLQuery .= ($limit !='') ? (" limit 0,$limit ") : ("limit 0,1");

	$arryRow = $this->query($strSQLQuery, 1);
 	if(!empty($arryRow[0]['OrderID'])){		
		$ItemCost = $arryRow[0]['ItemCost'];
		$LastCost = round($arryRow[0]['ItemCost'],2);
		$ConversionRate=$arryRow[0]['ConversionRate']; //from db

		if($arryRow[0]['evaluationType'] =='FIFO'){			
			if($arryRow[0]['Currency']!=$Config['Currency']){				
				$ItemCost = GetConvertedAmount($ConversionRate, $ItemCost);	
					
			}
                }else if($arryRow[0]['evaluationType'] =='LIFO'){
			$ItemCost = $arryRow[1]['ItemCost'];
			if($arryRow[1]['Currency']!=$Config['Currency']){
				$ConversionRate=$arryRow[1]['ConversionRate'];
				$ItemCost = GetConvertedAmount($ConversionRate, $arryRow[1]['ItemCost']);				
			}
		}else{
			 
			if($arryRow[0]['Currency']!=$Config['Currency']){				
				$ItemCost = GetConvertedAmount($ConversionRate, $ItemCost);	 		
			}

		}

		
		
		if($arryRow[0]['Currency']!=$Config['Currency']){			
			$LastCost = $ConversionRate * $LastCost;			
		}
		

		}
	}


		$arryCost[0]['CostOfGood'] =$ItemCost;
		$arryCost[0]['LastCost'] =$LastCost;
		return $arryCost[0];


    }

function GetPurchaseLastPrice($SuppCode,$item_id,$key) {
	$strAddQuery ='';
      $strAddQuery .= (!empty($key))?(" and i.sku='".$key."' "):("");
			$strAddQuery .= (!empty($item_id)) ? (" and i.item_id='" . $item_id . "'") : ("");		
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");

      $strSQLQuery = "select i.*,t.RateDescription,o.OrderDate,o.Currency from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join p_order o on i.OrderID=o.OrderID where 1" . $strAddQuery . " order by o.OrderDate desc limit 0,1";
      return $this->query($strSQLQuery, 1);
      }

function GetAvgTransPrice($item_id,$key, $WID) { //updated by chetan on 30Mar2017//
	$strAddQuery = '';

$strAddQuery .= (!empty($key['Condition']))?(" and t.TranCondition='".$key['Condition']."' "):("");
$strAddQuery .= (!empty($key['key']))?(" and t.TransactionSku='".$key['key']."' "):("");
$strAddQuery .= (!empty($key['Sku']))?(" and (t.TransactionSku='".$key['Sku']."' OR t.TransactionItemID='" . $item_id . "') "):("");
$strAddQuery .= (!empty($WID)) ? (" and t.WID ='" . $WID . "'") : (" and WID = '1' "); //updated by chetan on 30Mar2017//
$strAddQuery .= (!empty($key['binid'])) ? (" and t.binid ='" . $key['binid'] . "'") : (" and t.binid ='0' ");  //bin location based
//$strAddQuery .= (!empty($item_id)) ? (" and t.TransactionItemID='" . $item_id . "'") : ("");		
			
 $LMT = (!empty($key['LMT']))?(" limit 0,1 "):("");
 $descAsc = (!empty($key['Ordr']))?(" ".$key['Ordr']." "):("");

  $Sql = "select t.ConvertAmt+(t.freight_cost/t.TransactionQty) as price,t.TransactionSku,t.TransactionItemID,i.CategoryID,c.valuationType from inv_item_transaction t left outer join inv_items i on (i.Sku = t.TransactionSku and t.TransactionSku!='') left outer join inv_categories c on (c.CategoryID =i.CategoryID and i.CategoryID>0) where 1 and (t.TransactionType ='Adjustment' or t.TransactionType='PO Receipt' ) " . $strAddQuery . "  order by t.TransactionID  ".$descAsc." ".$LMT.""; 
    #if($_GET['this']==1){  echo $Sql; }
      return $this->query($Sql, 1);
      }



function GetValuationReport($FilterBy,$FromDate,$ToDate,$Month,$Year,$valuationType){

$strAddQuery = "";

	if($FilterBy=='Year'){
			$strAddQuery .= " and YEAR(t.TransactionDate)='".$Year."'";
		}else if($FilterBy=='Month'){
			$strAddQuery .= " and MONTH(t.TransactionDate)='".$Month."' and YEAR(t.TransactionDate)='".$Year."'";
		}else{
			//$strAddQuery .= (!empty($FromDate))?(" and t.TransactionDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and t.TransactionDate ='".$ToDate."'"):("");
		}


			/*$strAddQuery .= (!empty($key['Condition']))?(" and t.TranCondition='".$key['Condition']."' "):("");
      $strAddQuery .= (!empty($key['key']))?(" and t.TransactionSku='".$key['key']."' "):("");
			$strAddQuery .= (!empty($item_id)) ? (" and t.TransactionItemID='" . $item_id . "'") : ("");*/
			//$strAddQuery .= (!empty($valuationType))?(" and c.valuationType='".$valuationType."' "):("");


 $Sql = "select sum(t.ConvertAmt+(t.freight_cost/t.TransactionQty)) as price,sum(t.TransactionQty) as qtyHand,t.TranCondition,t.TransactionSku,t.TransactionDate,t.TransactionItemID,i.CategoryID from inv_item_transaction t left outer join inv_items i on i.Sku = t.TransactionSku  where 1 and (t.TransactionType ='Adjustment' or t.TransactionType='PO Receipt' ) ".$strAddQuery." group by t.TransactionSku order by t.TransactionDate desc";

return $this->query($Sql, 1);

}


function getValuationTotAmount($FilterBy,$FromDate,$ToDate,$Month,$Year)
		{
			
		$strAddQuery = "";

	if($FilterBy=='Year'){
			$strAddQuery .= " and YEAR(t.TransactionDate)='".$Year."'";
		}else if($FilterBy=='Month'){
			$strAddQuery .= " and MONTH(t.TransactionDate)='".$Month."' and YEAR(t.TransactionDate)='".$Year."'";
		}else{
			$strAddQuery .= (!empty($FromDate))?(" and t.TransactionDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and t.TransactionDate<='".$ToDate."'"):("");
		}


			/*$strAddQuery .= (!empty($key['Condition']))?(" and t.TranCondition='".$key['Condition']."' "):("");
      $strAddQuery .= (!empty($key['key']))?(" and t.TransactionSku='".$key['key']."' "):("");
			$strAddQuery .= (!empty($item_id)) ? (" and t.TransactionItemID='" . $item_id . "'") : ("");*/
			//$strAddQuery .= (!empty($valuationType))?(" and c.valuationType='".$valuationType."' "):("");

			
			$strSQLQuery = "select sum(t.ConvertAmt+(t.freight_cost/t.TransactionQty)*t.TransactionQty)  as totalOrderAmnt  from inv_item_transaction t where 1 and (t.TransactionType ='Adjustment' or t.TransactionType='PO Receipt' ) ".$strAddQuery;
			#echo $strSQLQuery;exit;
			$rs = $this->query($strSQLQuery, 1);
		    return $rs[0]['totalOrderAmnt'];	
		
		}

function GetAvgSerialPrice($item_id,$key,$WID=0){

$strAddQuery = '';

$strAddQuery .= (!empty($key['Condition']))?(" and `Condition`='".$key['Condition']."' "):("");
$strAddQuery .= (!empty($key['WID']))?(" and `warehouse`='".$key['WID']."' "):(" and `warehouse`='1' ");
$strAddQuery .= (!empty($key['binid']))?(" and `binid`='".$key['binid']."' "):("");
$strAddQuery .= (!empty($key['Sku']))?(" and Sku='".$key['Sku']."' "):("");
 $Sql2 = "select count(serialID) as srQt ,SUM(UnitCost) as conAmt  from inv_serial_item where 1 and UsedSerial =0  ".$strAddQuery."";
//$Sql2 = "select count(serialID) as srQt ,SUM(UnitCost) as conAmt  from inv_serial_item where 1 and UsedSerial =0  ".$strAddQuery."";


#if($_GET['ff']==1){ echo $Sql2; }

$rs2 =  $this->query($Sql2, 1);

$TotCost=0;$toQty=0;
foreach($rs2 as $values){
	$frCost = 0;

	$TotCost += $values['conAmt']+$frCost;
	$toQty +=$values['srQt']; 
}

 $avrageCost[0]['price'] = ($toQty>0)?($TotCost/$toQty):(0) ; 
 //$avrageCost[0]['price'] = number_format(($avrageCost[0]['price']+$frCost),2,'.','') ;
$avrageCost[0]['price'] = number_format(($avrageCost[0]['price']),2,'.','') ;
$avrageCost[0]['TotQty'] = $toQty ; 
$avrageCost[0]['TotCost'] = $TotCost ;


return $avrageCost;
}



function GetSerialUnitPrice($item_id,$Sku,$TransactionOrderID,$TransactionType){

$strAddQuery .= (!empty($Sku))?(" and t.TransactionSku='".$Sku."' "):("");
			$strAddQuery .= (!empty($item_id)) ? (" and t.TransactionItemID='" . $item_id . "'") : ("");
$strAddQuery .= (!empty($TransactionOrderID)) ? (" and t.TransactionOrderID='" . $TransactionOrderID. "'") : ("");
$strAddQuery .= (!empty($TransactionType)) ? (" and t.TransactionType='" . $TransactionType. "'") : ("");

 $sql ="select t.ConvertAmt,t.freight_cost,t.TransactionQty,t.TransactionID,t.TranCondition,t.TransactionDate,t.TransactionType from inv_item_transaction t   where 1  and  (t.valuationType ='Serialized' or t.valuationType='Serialized Average' ) " . $strAddQuery . " group by  t.TransactionOrderID";

if($_GET['this']==1){ echo  $sql; }
$rs = $this->query($sql, 1);

if($rs[0]['TransactionType'] == 'Adjustment'){

$amount = $rs[0]['ConvertAmt'];
$fr= 0;

}else{

$amount = $rs[0]['ConvertAmt'];
$fr= $rs[0]['freight_cost']/$rs[0]['TransactionQty'];
}


$ConvertAmt = $amount+$fr;

$rs[0]['ConvertAmt'] = number_format($ConvertAmt,2);

return $rs;
}

    /* function GetPurchasePriceItem2($OrderID,$key) {

      //$strAddQuery .= (!empty($key))?(" and i.sku='".$key."'):("");
      //$strAddQuery .= (!empty($key))?(" and i.OrderID='".$key."'):("");
      $strSQLQuery = "select i.*,t.RateDescription,o.OrderDate,o.Currency from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join p_order o on i.OrderID=o.OrderID where 1" . $strAddQuery . " order by o.OrderDate desc";
      return $this->query($strSQLQuery, 1);
      } */

    function GetTransactionItem($item_id, $OrderID, $PurchaseID, $Module) {
        $strAddQuery .= (!empty($item_id)) ? (" and i.item_id='" . $item_id . "'") : ("");
			
        $strAddQuery .= (!empty($OrderID)) ? (" and o.OrderID='" . $OrderID."'") : ("");
        $strAddQuery .= (!empty($PurchaseID)) ? (" and o.PurchaseID='" . $PurchaseID . "'") : ("");
        //
        $strSQLQuery = "select o.*, i.item_id,i.sku,i.qty,i.description,i.price from p_order o inner join p_order_item i on o.OrderID=i.OrderID where o.Status='Completed' and o.Approved=1 " . $strAddQuery . " order by o.OrderID desc ";
        return $this->query($strSQLQuery, 1);
    }
    
    
    function GetTransactionForSku($TransactionSku) {
      global $Config;
	if(!isset($Config['ItemID'])) $Config['ItemID']='';
	$strAddQuery='';

if($Config['GetNumRecords']==1){
				$Columns = " count(TransactionID) as NumCount ";				
			}else{				
				$Columns = " * ";
				if($Config['RecordsPerPage']>0){
if(empty($Config['StartPage'])) $Config['StartPage'] =0;
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

        $strSQLQuery = "select ".$Columns." from inv_item_transaction where 1 and (TransactionSku = '".$TransactionSku."' OR 	TransactionItemID='".$Config['ItemID']."' ) order by TransactionID desc";

        return $this->query($strSQLQuery, 1);
    }
    
    
    function addItemTransaction($arryTransaction,$arryDetails,$type){
                    
                      global $Config;
		      extract($arryDetails);
                      extract($arryTransaction); 


                      
                    if(empty($Currency)) $Currency =  $Config['Currency'];
                    if($type == 'SO' || $type == 'PO' || $type == 'ADJUST' || $type == 'MRG'){    
                            
                        for($i=1;$i<=$NumLine;$i++){
                                      if(!empty($arryDetails['qty'.$i])){



																					




																						if($arryDetails['evaluationType'.$i]!=''){

																						    $TranvaluationType = $arryDetails['evaluationType'.$i];
																						}else{

																						     $TranvaluationType = $arryDetails['valuationType'.$i];
																						}

                                              $id = $arryDetails['id'.$i];

                                              $sql = "insert into inv_item_transaction set TransactionOrderID = '".$TransactionOrderID."', TransactionInvoiceID='".$TransactionInvoiceID."', TransactionDate='".$TransactionDate."',TransactionType='".$TransactionType."', TransactionSku='".addslashes($arryDetails['sku'.$i])."',TransactionItemID='".$arryDetails['item_id'.$i]."',TransactionDescription='".addslashes($arryDetails['description'.$i])."',TransactionUnitPrice='".addslashes($arryDetails['price'.$i])."',TransactionCurrency='".$Currency ."',TransactionQty='".addslashes($arryDetails['qty'.$i])."',valuationType='".$TranvaluationType."',TotalAmount ='".$arryDetails['amount' . $i]."',TranCondition='".$arryDetails['Condition' . $i]."'"; 
                                             $this->query($sql, 0);	
 																						$TraID = $this->lastInsertId();


                                     
#echo $TranvaluationType;

																				/*	if($TranvaluationType =='LIFO'){

																								$_GET['LMT'] = 1;
																								$_GET['Ordr'] = 'DESC';
																								$_GET['Sku']  = $arryDetails['sku'.$i];
																								$arryVendorPrice=$this->GetAvgTransPrice($arryDetails['item_id'.$i],$_GET);
																						}else if($TranvaluationType =='FIFO'){

																									$_GET['LMT'] = 1;
																									$_GET['Ordr'] = 'ASC';
																									$_GET['Sku']  = $arryDetails['sku'.$i];
																									$arryVendorPrice=$this->GetAvgTransPrice($arryDetails['item_id'.$i],$_GET);

																						}else{
																									$_GET['Sku']  = $arryDetails['sku'.$i];
																									$arryVendorPrice=$this->GetAvgSerialPrice($arryDetails['item_id'.$i],$_GET);
																									$arryVendorPrice[0]['price'] = $arryVendorPrice[0]['price']/$arryVendorPrice[0]['total'];
																						}*/
																							
																							//$avgCost = $arryDetails['price'.$i]+$arryDetails['freight_cost'.$i];
$avgCost = $arryDetails['price'.$i];

																			if($Currency != $Config['Currency']){ 

																						$ConversionRate = $ConversionRate;
																									//$avgCost = round(GetConvertedAmount($ConversionRate, $avgCost),2);
																						//}
																								}else{
																									 $ConversionRate =1;
																										
																								}
																								
																				 $avgCost = round(GetConvertedAmount($ConversionRate, $avgCost),2); 
																				$FrightCost = round(GetConvertedAmount($ConversionRate, $arryDetails['freight_cost'.$i]),2);
 														 $SqulUpdateQuery = "update  inv_item_transaction  set ConvertAmt='".$avgCost."',freight_cost='".$FrightCost."' where TransactionID = '".$TraID."'"; 

														$this->query($SqulUpdateQuery, 0);

 }

                              }
                        
                     }  
                     
                     if($type == 'ASM' || $type == 'DSM'){
                         
                         if($type == 'ASM') $qty = $assembly_qty; else $qty = $disassembly_qty;
                         $unitPrice = 0;
                         $unitPrice = $TotalValue/$qty;
                         $unitPrice = number_format($unitPrice,2,'.','');
                         
                         $sql = "insert into inv_item_transaction set TransactionOrderID = '".$TransactionOrderID."', TransactionInvoiceID='".$TransactionInvoiceID."', TransactionDate='".$TransactionDate."',TransactionType='".$TransactionType."', TransactionSku='".addslashes($Sku)."',TransactionItemID='".$item_id."',TransactionDescription='".addslashes($description)."',TransactionUnitPrice='".addslashes($unitPrice)."',TransactionCurrency='".$Currency ."',TransactionQty='".addslashes($qty)."',valuationType='".$TranvaluationType."',TotalAmount ='".$arryDetails['amount' . $i]."',TranCondition='".$arryDetails['Condition' . $i]."'";
                         //exit;
                         $this->query($sql, 0);
                                              
                          
                     }   
                        
                    
                }

    /* * ***************************************** Quantity ********************* */

    function GetOrderdedQty($sku) {
        //echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";

        $sql = "select SUM(i.qty) as purchase_qty FROM p_order as o	inner join p_order_item as i on o.OrderID=i.OrderID	inner join inv_items as p on i.item_id = p.ItemID	where o.Status!='Completed' and	i.sku='" . $sku . "'";


        $rs = $this->query($sql);
        return $rs[0]['purchase_qty'];
    }

    function GetAdjustmentQty($sku) {
global $Config;
$strAddQuery = (!empty($Config['Condition']))?(" and i.Condition='".$Config['Condition']."' "):("");
        //echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";

        $sql = "select SUM(i.qty) as adjust_qty FROM inv_adjustment as a inner join inv_stock_adjustment as i on a.adjID=i.adjID	inner join inv_items as p on i.item_id = p.ItemID	where	i.sku = '" . $sku . "' ".$strAddQuery;

        $rs = $this->query($sql);
        return $rs[0]['adjust_qty'];
    }

    function GetRecievedQty($sku) {
global $Config;
        //echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";
$strAddQuery = (!empty($Config['Condition']))?(" and i.Condition='".$Config['Condition']."' "):("");
        $sql = "select SUM(i.qty_received) as qty_received FROM p_order as o	inner join p_order_item as i on o.OrderID=i.OrderID	inner join inv_items as p on i.item_id = p.ItemID	where	i.sku = '" . $sku . "' and o.Module='Receipt' and o.ReceiptStatus ='Completed' and o.OrderType !='Dropship'  ".$strAddQuery;


        $rs = $this->query($sql);

        return $rs[0]['qty_received'];
    }

    function GetAssemblyQty($sku) {
        //echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";

        $sql = "select SUM(i.qty) as adjust_qty FROM inv_adjustment as a	inner join inv_stock_adjustment as i on a.adjID=i.adjID	inner join inv_items as p on i.item_id = p.ItemID	where	i.sku = '" . $sku . "' ";
        $rs = $this->query($sql);
if($rs[0]['adjust_qty']>0){
        return $rs[0]['adjust_qty'];
}else{

return 0;
}
    }

    function GetSaleOrderdedQty($sku) {
global $Config;

$strAddQuery = (!empty($Config['Condition']))?(" and i.Condition='".$Config['Condition']."' "):("");
        //echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";

        //$sql = "select SUM(i.qty) as sales_qty FROM s_order as s	inner join s_order_item as i on s.OrderID=i.OrderID	where s.Status='Closed' and	i.sku='" . $sku . "'";

$sql = "select SUM(i.qty-i.qty_invoiced) as sales_qty,SUM(i.qty_invoiced) as qtyInvoice,i.Condition FROM s_order as s	inner join s_order_item as i on s.OrderID=i.OrderID	where s.Module='Order'	and i.sku='" . $sku . "'";


        $rs = $this->query($sql);
        return $rs;
    }

    /*     * ************************ End Quantity ************* */

    function AdjustmentReport($FilterBy, $FromDate, $ToDate, $Month, $Year, $warehouse_code, $Status) {


        $strAddQuery = "";
        if ($FilterBy == 'Year') {
            $strAddQuery .= " and YEAR(a.adjDate)='" . $Year . "'";
        } else {
            $strAddQuery .= (!empty($FromDate)) ? (" and a.adjDate>='" . $FromDate . "'") : ("");
            $strAddQuery .= (!empty($ToDate)) ? (" and a.adjDate<='" . $ToDate . "'") : ("");
        }



        $strAddQuery .= (!empty($warehouse_code)) ? (" and a.warehouse_code='" . $warehouse_code . "'") : ("");
        $strAddQuery .= ($Status >= 0) ? (" and a.Status='" . $Status . "'") : ("");

        $strSQLQuery = "select  a.adjDate,a.adjustNo,a.total_adjust_qty, a.adjID, a.warehouse_code,a.adjust_reason, a.total_adjust_value, a.total_adjust_qty, a.Status,w.warehouse_name,w.WID,w.warehouse_code  from inv_adjustment a left outer join w_warehouse  w on BINARY w.warehouse_code = BINARY a.warehouse_code where 1 " . $strAddQuery . " order by a.adjDate desc";

        return $this->query($strSQLQuery, 1);
    }

    function GetNumAdjByYear($FilterBy, $month, $Year, $FromDate, $ToDate, $warehouse_code, $Status) {

        $strAddQuery = "";


        $strAddQuery .= (!empty($FromDate)) ? (" and a.adjDate >= '" . $FromDate . "'") : ("");
        $strAddQuery .= (!empty($ToDate)) ? (" and a.adjDate <= '" . $ToDate . "'") : ("");

        $strAddQuery .= (!empty($warehouse_code)) ? (" and a.warehouse_code='" . $warehouse_code . "'") : ("");
        $strAddQuery .= (!empty($Status)) ? (" and a.Status='" . $Status . "'") : ("");

        $strSQLQuery = "select count(a.adjID) as TotalAdj  from inv_adjustment a where YEAR(a.adjDate)='" . $Year . "' " . $strAddQuery . " order by a.adjDate desc";

        return $this->query($strSQLQuery, 1);
    }

    function GetNumAdjByMonth($Year, $FromDate, $ToDate, $warehouse_code, $Status) {
        $strAddQuery = "";
        $strAddQuery .= (!empty($FromDate)) ? (" and a.adjDate = '" . $ToDate . "' ") : ("");
        $strAddQuery .= (!empty($Year)) ? (" and YEAR(a.adjDate)='" . $Year . "' ") : ("");
        $strAddQuery .= (!empty($warehouse_code)) ? (" and a.warehouse_code='" . $warehouse_code . "'") : ("");

        $strAddQuery .= (!empty($Status)) ? (" and a.Status='" . $Status . "'") : ("");

        $strSQLQuery = "select count(a.adjID) as TotalAdj  from inv_adjustment a where 1 " . $strAddQuery . " order by a.adjDate desc";
        //echo "=>".$strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    function TransferReport($FilterBy, $FromDate, $ToDate, $Month, $Year, $warehouse_code1, $warehouse_code2, $Status) {

        $strAddQuery = "";

        if ($FilterBy == 'Year') {
            $strAddQuery .= " and YEAR(t.transferDate)='" . $Year . "'";
        } else {
            $strAddQuery .= (!empty($FromDate)) ? (" and t.transferDate>='" . $FromDate . "'") : ("");
            $strAddQuery .= (!empty($ToDate)) ? (" and t.transferDate<='" . $ToDate . "'") : ("");
        }

        $strAddQuery .= (!empty($warehouse_code1)) ? (" and t.from_WID='" . $warehouse_code1 . "'") : ("");
        $strAddQuery .= (!empty($warehouse_code2)) ? (" and t.to_WID='" . $warehouse_code2 . "'") : ("");
        $strAddQuery .= ($Status >= 0) ? (" and t.Status='" . $Status . "'") : ("");

        $strSQLQuery = "select  t.transferDate,t.transferNo,t.total_transfer_qty, t.transferID, t.from_WID,t.to_WID,t.transfer_reason, t.total_transfer_value, t.Status,w1.warehouse_code as from_warehouse,w1.warehouse_name as from_warehouse_name,w1.WID,w2.warehouse_code as to_warehouse,w2.warehouse_name as to_warehouse_name,w2.WID from inv_transfer t inner join w_warehouse w1 on w1.WID=t.from_WID inner join  w_warehouse w2  on w2.WID=t.to_WID  where 1 " . $strAddQuery . " order by t.transferDate desc";

        return $this->query($strSQLQuery, 1);
    }

    function ExportItem() {
        $strSQLQuery = "SELECT * FROM inv_items ORDER BY ItemID ASC";
        return $this->query($strSQLQuery);
    }

    /*     * *************ITEM ALIAS***************** */

    function GetAliasbySku($sku) {
        $strSQLQuery = "SELECT * FROM inv_item_alias ";
        $strSQLQuery .= (!empty($sku)) ? (" where sku = '" . $sku . "'") : ("");
        $strSQLQuery .="  ORDER BY AliasID ASC";
        #echo $strSQLQuery;
        return $this->query($strSQLQuery);
    }

    function UpdateAliasItem($arryDetails) {

        extract($arryDetails);

        $strSQLQuery = "update inv_item_alias set ItemAliasCode = '" . addslashes($ItemAliasCode) . "', description='" . addslashes($description) . "', Manufacture='" . addslashes($Manufacture) . "', sku='" . addslashes($Sku) . "', item_id='" . addslashes($item_id) . "' where AliasID='" . $AliasID . "'";

        $this->query($strSQLQuery, 0);


        return 1;
    }

    function AddAliasItem($arryDetails) {

        extract($arryDetails);

        $strSQLQuery = "insert inv_item_alias (ItemAliasCode, description, sku, item_id, Manufacture) 
		                 values ('" . mysql_real_escape_string(strtoupper($ItemAliasCode)) . "','" . addslashes($description) . "','" . addslashes($Sku) . "','" . $item_id . "', '" . addslashes($Manufacture) . "')";

        $this->query($strSQLQuery, 0);
        //$aliID = $this->lastInsertId();

        return $aliID = $this->lastInsertId();
    }

    function GetAliasItem($AliasID) {
        $strSQLQuery = "SELECT * FROM inv_item_alias ";
        $strSQLQuery .= (!empty($AliasID)) ? (" where AliasID = '" . $AliasID . "'") : ("");
        #echo $strSQLQuery;
        return $this->query($strSQLQuery);
    }

    function RemoveAlias($AliasID) {
        $strSQLQuery = "delete from inv_item_alias where AliasID='" . $AliasID . "'";
        $this->query($strSQLQuery, 0);
    }

    /*     * *************FINISH********************* */


    /*     * ************** Sales Order ************* */

    //19jan2017update by chetan num and interval become dynamic16feb//updated 5Apr2017//
	function GetSOHistory($sku, $Status, $numHistory, $allItemid, $condition, $WID='') {
	$strAddQuery = "";
	$Num = preg_replace("/[^0-9]/","",$numHistory);
	$Interval = preg_replace("/[^a-zA-Z]/","",$numHistory);

	$strAddQuery .= ($Interval == 'year') ? (" AND s_order.OrderDate >= DATE_SUB(NOW(),INTERVAL ".$Num." YEAR)") : ("");
	$strAddQuery .= ($Interval == 'm') ? (" AND s_order.OrderDate >= DATE_SUB(NOW(), INTERVAL ".$Num." MONTH)") : ("");
	$strAddQuery .= ($Interval == 'd') ? (" AND s_order.OrderDate >= DATE_SUB(NOW(), INTERVAL ".$Num." DAY)") : ("");
       
        $strAddQuery .= (!empty($Status)) ? (" and s_order.Status='" . $Status . "'") : ("");
	if($allItemid!='')
	{
		$strAddQuery .= " and s_order_item.item_id IN('" . $allItemid . "') ";
	}
	if($condition!='')
	{       
		$strAddQuery .= (!empty($condition)) ? (" and s_order_item.Condition = '".$condition."'") : ("");
	}
	$strAddQuery .= ($WID) ? (" and s_order_item.WID = '".$WID."'") : (" and s_order_item.WID = '1'"); //Added by chetan on 5Apr2017//
	$strAddQuery .= (!empty($sku)) ? (" and s_order_item.sku='" . $sku . "'") : ("");
        $strSQLQuery = "SELECT s_order_item. * ,s_order.CustomerName,s_order.CustomerCurrency,s_order.ConversionRate,s_order.CustCode, s_order.OrderID, s_order.OrderDate, s_order.SaleID, s_order.Module
				FROM s_order_item s_order_item
				LEFT OUTER JOIN s_order s_order ON s_order.OrderID = s_order_item.OrderID
			WHERE s_order.Module = 'Order'  and  EXISTS (SELECT 1 FROM s_order b WHERE b.SaleID = s_order.SaleID and b.Module ='Invoice' and b.PostToGL='1')
				
				 " . $strAddQuery . " 
				ORDER BY s_order_item.OrderID DESC";
        //echo "=>".$strSQLQuery;
        return $this->query($strSQLQuery, 1);
    }

    /* function CountSo($sku,$din){
      $strSQLQuery = "SELECT SUM( qty ) AS totalso FROM `s_sale_item` WHERE 1 AND sku = '".$sku."' AND ";
      $rs = $this->query($strSQLQuery);
      if (sizeof($rs)) {
      if ($rs[0]['totalPo'] > 0){
      return $rs[0]['totalPo'];
      } else{
      return 0;
      }
      }

      } */

    //19jan2017update by chetan on 5Apr2017 on WID/
	function GetPOHistory($sku, $Status, $numHistory, $allItemid, $condition, $WID) {
		$strAddQuery = "";
		$Num = preg_replace("/[^0-9]/","",$numHistory);
                $Interval = preg_replace("/[^a-zA-Z]/","",$numHistory);
                
                $strAddQuery .= ($Interval == 'year') ? (" AND p_order.OrderDate >= DATE_SUB(NOW(),INTERVAL ".$Num." YEAR)") : ("");
		$strAddQuery .= ($Interval == 'm') ? (" AND p_order.OrderDate >= DATE_SUB(NOW(), INTERVAL ".$Num." MONTH)") : ("");
		$strAddQuery .= ($Interval == 'd') ? (" AND p_order.OrderDate >= DATE_SUB(NOW(), INTERVAL ".$Num." DAY)") : ("");
        /*$strAddQuery .= ($numHistory == '1year') ? (" AND p_order.OrderDate >= DATE_SUB(NOW(),INTERVAL 1 YEAR)") : ("");
        $strAddQuery .= ($numHistory == '6month') ? (" AND p_order.OrderDate >= DATE_SUB(NOW(), INTERVAL 6 MONTH)") : ("");
        $strAddQuery .= ($numHistory == '30d') ? (" AND p_order.OrderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)") : ("");
        $strAddQuery .= ($numHistory == '7d') ? (" AND p_order.OrderDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)") : ("");*/
        $strAddQuery .= (!empty($Status)) ? (" and p_order.Status='" . $Status . "'") : ("");
	if($allItemid!='' && $condition!='')
	{
		$strAddQuery .= " and p_order_item.item_id IN('" . $allItemid . "') ";
	}
	if($condition!='')
	{       
		$strAddQuery .= (!empty($condition)) ? (" and p_order_item.Condition = '".$condition."'") : ("");
	}
	$strAddQuery .= ($WID) ? (" and p_order_item.WID = '".$WID."'") : (" and p_order_item.WID = '1'"); //Added by chetan on 5Apr2017//
	$strAddQuery .= (!empty($sku)) ? (" and p_order_item.sku='" . $sku . "'") : ("");
        $strSQLQuery = "SELECT p_order_item. * ,p_order.SuppCompany,p_order.SuppCode, p_order.OrderID, p_order.OrderDate,p_order.Currency,p_order.ConversionRate,p_order.PurchaseID, p_order.Module
			FROM p_order_item p_order_item
			LEFT OUTER JOIN p_order p_order ON p_order.OrderID = p_order_item.OrderID
			WHERE p_order.Module = 'Receipt' and p_order.ReceiptStatus='Completed'		" . $strAddQuery . "
			Order BY p_order_item.OrderID DESC";
//and  EXISTS (SELECT 1 FROM p_order b WHERE b.PurchaseID = p_order.PurchaseID and b.Module ='Receipt' and b.ReceiptStatus='Completed')

        #echo "=>".$strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }
    
    
	function NextPrevItem($ItemID,$Next) {
		global $Config;
		$strAddQuery = ''; 
		if($ItemID>0){		
			
		
			if($Next==1){
				$operator = "<"; $asc = 'desc';
			}else{
				$operator = ">"; $asc = 'asc';
			}

			$strSQLQuery = "select i.ItemID,i.CategoryID  from inv_items i where i.ItemID".$operator."'" . $ItemID . "'  ". $strAddQuery. " order by i.ItemID ".$asc." limit 0,1";

			$arrRow = $this->query($strSQLQuery, 1);
			return $arrRow;
		}
	}

    
    
    function isSerialExists($Serial_No,$id)
     {
        $strSQLQuery = "select serialID from inv_serial_item where LCASE(serialNumber)='" . strtolower(trim($Serial_No)) . "' and UsedSerial='0' and Status='1'";
         $strSQLQuery .= ($id > 0) ? (" and serialID != '" . $id . "'") : ("");
        $arryRow = $this->query($strSQLQuery, 1);
        if ($arryRow[0]['serialID'] > 0) 
        {
            return 1;
        } else {
            return 0;
        }
    }


	function GetGenrationBasedOnModel($ModelId)
	{	   	
		if(!empty($ModelId)){
	  	 $strSQLQuery = "Select id,Generation from inv_ModelGen where id IN($ModelId) order by Generation asc";

	 	return  $this->query($strSQLQuery, 1);
		}
	 }



	function isSkuTransactionExist($Sku){
		$Sku = strtolower(trim($Sku));

		$AsmSql = "select 'Sku' as SkuCode from inv_assembly where Sku = '".$Sku."' limit 0,1";
		$BomSql = "select 'Sku' as SkuCode from inv_bill_of_material where Sku = '".$Sku."' limit 0,1";
		$BinSql = "select 'Sku' as SkuCode from inv_bin_stock where Sku = '".$Sku."' limit 0,1";
		$DisSql = "select 'Sku' as SkuCode from inv_disassembly where Sku = '".$Sku."' limit 0,1";
		$AsmSql = "select 'sku' as SkuCode from inv_item_assembly where sku = '".$Sku."' limit 0,1";
		$ItBomSql = "select 'sku' as SkuCode from inv_item_bom where sku = '".$Sku."' limit 0,1";
		$ItDisSql = "select 'sku' as SkuCode from inv_item_disassembly where sku = '".$Sku."' limit 0,1";
		$StkSql = "select 'sku' as SkuCode from inv_stock_transfer where sku = '".$Sku."' limit 0,1";
		$StkAdjSql = "select 'sku' as SkuCode from inv_stock_adjustment where sku = '".$Sku."' limit 0,1";
		$stkSaleSql = "select 'sku' as SkuCode from s_order_item where sku = '".$Sku."' limit 0,1";

       	 	$strSQLQuery = "(".$AsmSql.") UNION (".$BomSql.") UNION (".$BinSql.") UNION (".$DisSql.") UNION (".$AsmSql.") UNION (".$ItBomSql.") UNION (".$ItDisSql.") UNION (".$StkSql.") UNION (".$StkAdjSql.") UNION (".$stkSaleSql.") ";
		 $arryRow = $this->query($strSQLQuery, 1);
       		if (!empty($arryRow[0]['SkuCode'])) {
			return true;
		}else{
			return false;
		}
    }


function isBOMTransactionExist($Sku){
		$Sku = strtolower(trim($Sku));

		$AsmSql = "select 'Sku' as SkuCode from inv_assembly where Sku = '".$Sku."' limit 0,1";
		//$BomSql = "select 'Sku' as SkuCode from inv_bill_of_material where Sku = '".$Sku."' limit 0,1";
		//$BinSql = "select 'Sku' as SkuCode from inv_bin_stock where Sku = '".$Sku."' limit 0,1";
		$DisSql = "select 'Sku' as SkuCode from inv_disassembly where Sku = '".$Sku."' limit 0,1";
		$AsmSql = "select 'sku' as SkuCode from inv_item_assembly where sku = '".$Sku."' limit 0,1";
		$ItBomSql = "select 'sku' as SkuCode from inv_item_bom where sku = '".$Sku."' limit 0,1";
		$ItDisSql = "select 'sku' as SkuCode from inv_item_disassembly where sku = '".$Sku."' limit 0,1";
		//$StkSql = "select 'sku' as SkuCode from inv_stock_transfer where sku = '".$Sku."' limit 0,1";
		$StkAdjSql = "select 'sku' as SkuCode from inv_stock_adjustment where sku = '".$Sku."' limit 0,1";
		$stkSaleSql = "select 'sku' as SkuCode from s_order_item where sku = '".$Sku."' limit 0,1";



       	 	$strSQLQuery = "(".$AsmSql.") UNION (".$DisSql.") UNION (".$AsmSql.") UNION (".$ItBomSql.") UNION (".$ItDisSql.")  UNION (".$StkAdjSql.") UNION (".$stkSaleSql.") ";
		 $arryRow = $this->query($strSQLQuery, 1);
       		if (!empty($arryRow[0]['SkuCode'])) {
			return true;
		}else{
			return false;
		}
    }
function isSettingTransactionExist($DataVal){
		//$Sku = strtolower(trim($Sku));

	$ModelSql = "select 'Sku' as SkuCode from inv_items where  FIND_IN_SET ('".$DataVal."',Model) limit 0,1";
		$GenrationSql = "select 'Sku' as SkuCode from inv_items where  FIND_IN_SET ('".$DataVal."',Generation) limit 0,1";
		//$ConditionSql = "select 'Sku' as SkuCode from inv_items where Condition = '".$DataVal."' limit 0,1";


		$strSQLQuery = "(".$ModelSql.") UNION (".$GenrationSql.")  ";
		#echo $GenrationSql;exit;
		 $arryRow = $this->query($strSQLQuery, 1);
       		if (!empty($arryRow[0]['SkuCode'])) {
			return true;
		}else{
			return false;
		}
    }

function isConditionTransactionExist($DataVal){
$ConditionSql = "select 'Sku' as SkuCode from inv_items where Condition = '".$DataVal."' limit 0,1";


		
		#echo $GenrationSql;exit;
		 $arryRow = $this->query($ConditionSql, 1);
       		if (!empty($arryRow[0]['SkuCode'])) {
			return true;
		}else{
			return false;
		}
}


function isChildCategoryExist($CategoryID){
		//$Sku = strtolower(trim($Sku));

		$CatSql = "select 'CategoryID' as CatID from inv_items where CategoryID = '".$CategoryID."' limit 0,1";
		

       	 	$strSQLQuery = "(".$CatSql.")  ";
		 $arryRow = $this->query($strSQLQuery, 1);

       		if (!empty($arryRow[0]['CatID'])) {
			return true;
		}else{
			return false;
		}
    }

function GetMainCategory($CategoryID){
		//$Sku = strtolower(trim($Sku));
if($CategoryID!=''){
		  $CatSql = "select * from inv_categories where CategoryID = '".$CategoryID."' and Status=1 ";
		 $arryRow = $this->query($CatSql, 1);
		

     if(!empty($arryRow) && $arryRow[0]['ParentID'] > 0){
     
     //$CatSql = "select * from inv_categories where CategoryID = '".$arryRow[0]['ParentID']."' and Status=1 ";
          $arryR =  $this->GetMainCategory($arryRow[0]['ParentID']);
          if($arryR[0]['ParentID']==0) return $arryR;
           
     }else{
     
     return $arryRow;
     }
     
     
       }
    }


function isCategoryTransactionExist($CategoryID){
		//$Sku = strtolower(trim($Sku));

		$CatSql = "select CategoryID as CatID from inv_items where CategoryID = '".$CategoryID."' limit 0,1";
		

       	 	$strSQLQuery = "(".$CatSql.")  ";
		 $arryRow = $this->query($strSQLQuery, 1);

       		if (!empty($arryRow[0]['CatID'])) {
			return true;
		}else{
			return false;
		}
    }


function isCategoryTransactionExist2($CategoryID){
		//$Sku = strtolower(trim($Sku));

		#$CatSql = "select 'CategoryID' as CatID from inv_items where CategoryID = '".$CategoryID."' limit 0,1";
		$sql = "select p.ItemID from inv_items p
inner join inv_categories sc on sc.ParentID = p.CategoryID
inner join `inv_categories` c on c.CategoryID = p.CategoryID where p.CategoryID = '".$CategoryID."' ";

       	 	#$strSQLQuery = "(".$CatSql.")  ";
		 $arryRow = $this->query($sql, 1);



       		if (!empty($arryRow[0]['ItemID'])) {
			return true;
		}else{
			return false;
		}
    } 

	function checkSubCatByTran($CategoryID){

	$strSQLQuery = "SELECT CategoryID FROM `inv_categories` WHERE `ParentID`='".$CategoryID."'";

	return $this->query($strSQLQuery, 1);
	}
/*

function checkSubCatByTran($CategoryID){

	$query = "SELECT * FROM inv_categories WHERE ParentID ='".$CategoryID."'";

	$rs = $this->query($strSQLQuery, 1);
   if(is_array($rs)){
	foreach ($rs as $key => $SubValues) {
		if(!$this->isCategoryTransactionExist($SubValues['CategoryID'])){

			return 1;

		}else{
			return 0;
		}
	if($SubValues['ParentID'] > 0)
	{
		$this->checkSubCatByTran($SubValues['CategoryID']); 
	}
     }
}
	}
*/

 //By Chetan21Aug//
    function addCrmItems($arryDetails)
    {
        extract($arryDetails);
        $objField = new field();
        $arryflds=$objField->getAllCustomFieldByModuleID(2003);
        $arry = array_map(function($arr){
                    if($arr['editable']==1){
                        return $arr['fieldname'];
                    }else{
                        unset($arr);
                    }   
                },$arryflds);
        $arryflds = array_values(array_filter($arry)); 
        foreach($arryflds as $key)
        {       
                $str.= "$key='".$arryDetails[$key]."'".',';
        }
        $strSQLQuery = "insert into inv_items set ".$str." long_description ='" . addslashes($long_description) . "' ,Status = '" . $Status . "', AddedDate ='" . date('Y-m-d') . "' ,
            Sku = '" . addslashes($Sku) . "',sell_price ='" . addslashes($sell_price) . "' , qty_on_hand = '" . addslashes($qty_on_hand) ."',description ='" . addslashes($description) . "'  ";
        $this->query($strSQLQuery, 0);
        $lastInsertId = $this->lastInsertId();

        return $lastInsertId;

    }
    
    //By Chetan 29Jan//
    function checkItemAliasSku($Sku,$DB='') {
                $strSQLQuery = "select c.valuationType as evaluationType, ia.ItemAliasCode,ia.AliasID,ia.sku,ia.description,i.ItemID,i.itemType from ".$DB."inv_item_alias ia left join ".$DB."inv_items i on ia.item_id = i.ItemID left outer join ".$DB."inv_categories c on c.CategoryID =i.CategoryID where LOWER(ia.ItemAliasCode) = '" . strtolower($Sku) . "'";

if(!empty($_GET['this'])){ echo  $strSQLQuery; exit;}

        return $this->query($strSQLQuery, 1);
    }
//By bhoodev 20jan//
function checkItemAliasId($AliasID) {
        $strSQLQuery = "select ItemAliasCode,AliasID,sku,description,item_id from inv_item_alias where AliasID = '" . $AliasID . "'";
        return $this->query($strSQLQuery, 1);
    }
     //By Chetan 9sep//
    function getAliasRequiredItemByIds($ItemId,$AlaisId)
    {
        $strSQLQuery2 = "select ir.item_id,i.ItemID,i.description,i.sku,i.qty_on_hand from inv_item_required ir left join inv_items i on ir.item_id = i.ItemID where ir.ItemID = '".$ItemId."' and ir.AliasID = '" . $AlaisId . "' ";
        return $this->query($strSQLQuery2, 1);
    }
    
    //End//
    
    
    
    
    /*******************Function Sync Items***************************************/

	

	// Inventory to E-Commerce
	// E-Commerce to Inventory
	// both

	function sync_items($ItemsArray){
		
		
		if($ItemsArray['ItemID']){
				
			if($ItemsArray['synctypeselected']=='all'){
				$strSQLQuery = "select ItemID from inv_items order by ItemID asc ";
				$res=$this->query($strSQLQuery, 1);
				foreach($res as $items){
					$SyncItemsArray['ItemID'][]=$items['ItemID'];
				}
			}else{
				foreach($ItemsArray['ItemID'] as $items){
					$SyncItemsArray['ItemID'][]=$items;
				}
			}

		}

		if($ItemsArray['ProductID']){
			if($ItemsArray['synctypeselected']=='all'){
				$strSQLQuery = "select ProductID from e_products order by ProductID asc ";
				$res=$this->query($strSQLQuery, 1);
				foreach($res as $items){
					$SyncItemsArray['ItemID'][]=$items['ProductID'];
				}
			}else{
				foreach($ItemsArray['ProductID'] as $items){
					$SyncItemsArray['ItemID'][]=$items;
				}
			}
				
		}

		
		
		$sync_items = $_SESSION['sync_items'];
		
		switch ($sync_items) {
			case I2E:
				// code for Inventory to e-commerce

				foreach($SyncItemsArray['ItemID'] as $items){
					$sql = "select Item.* from inv_items as Item
					left join inv_item_images ItemImages on ItemImages.ItemID=Item.ItemID
					where Item.ItemID='".addslashes($items)."'"; 
					$ItemsArray = $this->query($sql, 1);

					$this->syncFromInventory($ItemsArray);



				}
				/*********end **********/

				break;
			case E2I:
				// code for e-commerce  to Inventory

				foreach($SyncItemsArray['ItemID'] as $items){
					$sql = "select Products.* from e_products as Products
					left join e_products_images ProductsImages on ProductsImages.ProductID=Products.ProductID
					where Products.ProductID='".addslashes($items)."'"; 
					$ItemsArray = $this->query($sql, 1);

					$this->syncFromEcommerce($ItemsArray);



				}
				/*********end **********/

				break;
			case both:
				// code for both
				// code for Inventory to e-commerce

				foreach($SyncItemsArray['ItemID'] as $items){
					$sql = "select Item.* from inv_items as Item
					left join inv_item_images ItemImages on ItemImages.ItemID=Item.ItemID
					where Item.ItemID='".addslashes($items)."'"; 
					$ItemsArray = $this->query($sql, 1);
					if($ItemsArray){
					 $this->syncFromInventory($ItemsArray);
					}


				}
				/*********end **********/

				// code for e-commerce  to Inventory

				foreach($SyncItemsArray['ItemID'] as $items){
					$sql = "select Products.* from e_products as Products
					left join e_products_images ProductsImages on ProductsImages.ProductID=Products.ProductID
					where Products.ProductID='".addslashes($items)."'"; 
					$ItemsArray = $this->query($sql, 1);
					if($ItemsArray){
					 $this->syncFromEcommerce($ItemsArray);
					}


				}
				/*********end **********/

				break;

		}
			
	}

	function checkSkuExist($Sku,$table,$field,$selectedFieldId){
		$sql = "select count(*) as total,".$selectedFieldId." from ".$table." where  ".$field."= '".addslashes($Sku)."' ";
		$ItemsAvail = $this->query($sql, 1);
		if($ItemsAvail[0]['total']==0){
			return '0';
		}
		return $ItemsAvail[0][$selectedFieldId];
			
	}

	function syncFromInventory($ItemsArray){

		$ItemID=$ItemsArray[0]['ItemID'];
		$Sku=$ItemsArray[0]['Sku'];
		$CategoryID=$ItemsArray[0]['CategoryID'];
		$description=$ItemsArray[0]['description'];
		$long_description=$ItemsArray[0]['long_description'];
		$Manufacture=$ItemsArray[0]['Manufacture'];
		$sell_price=$ItemsArray[0]['sell_price'];
		$Taxable=$ItemsArray[0]['Taxable'];
		$sale_tax_rate=$ItemsArray[0]['sale_tax_rate'];
		$weight=$ItemsArray[0]['weight'];
		$Image=$ItemsArray[0]['Image'];
		$Quantity=$ItemsArray[0]['qty_on_hand'];
		$VariantId=$ItemsArray[0]['variant_id'];
		$IsUpld=$ItemsArray[0]['is_upld'];
		$LabelTxt=$ItemsArray[0]['label_txt'];
		
		$AddedDate=date('Y-m-d');


		$is_exist=$this->checkSkuExist($Sku,'e_products','ProductSku','ProductID');


		// get manufacturer id by name beacuse inventory has varchar field type
		if($Manufacture!=''){
			$sql = "select * from e_manufacturers where  Mname= '".addslashes($Manufacture)."' limit 1 ";
			$ManufactureRes = $this->query($sql, 1);
			if($ManufactureRes){
				// if manufacturer available
				$Mid=$ManufactureRes[0]['Mid'];
			}else{
				// create new manufacturer
				$sql="insert into e_manufacturers set Mname='".addslashes($Manufacture)."', Status='1' ";
				$this->query($sql,0);
				$Mid=$this->lastInsertId();
				$sql="update e_manufacturers set Mcode='".addslashes($Mid)."' where Mid='".addslashes($Mid)."' ";
				$this->query($sql,0);
			}
		}
			
		
		
		/*******************
		 * Check category sync
		 * 
		 */
		if($CategoryID!='0'){
		$sql = "select CategoryID from e_categories where item_categoryId= '".addslashes($CategoryID)."' limit 1 ";
		$CategoryRes = $this->query($sql, 1);
		
		if($CategoryRes){
				// if category already sync
				$CategoryID=$CategoryRes[0]['CategoryID'];
			}else{				 
				// get parent category id

				if($this->checkCategoryExist($CategoryID,'inv_categories')){
					$MainCategoryId=$this->getParentCategoryId($CategoryID,'inv_categories');
				
					$catArray['Category']=json_encode(array($MainCategoryId));
				
					$this->syncCategorytoEcommerce($catArray);
				
					$sql = "select CategoryID from e_categories where item_categoryId= '".addslashes($CategoryID)."' limit 1 ";
					$CategoryRes = $this->query($sql, 1);
					$CategoryID=$CategoryRes[0]['CategoryID'];
				}else{
					$CategoryID=0;
				}
			}
		
		// end	
		}

		if($is_exist=='0'){

			/***********insert new item************/



			$sql="insert into e_products set Name='".addslashes($description)."' , ProductSku='".addslashes($Sku)."' ,
				Detail='".addslashes($long_description)."' ,ShortDetail='".addslashes($description)."' ,
				Price='".addslashes($sell_price)."' ,InventoryControl='Yes' ,
				IsTaxable='".addslashes($Taxable)."' ,TaxRate='".addslashes($sale_tax_rate)."' ,
				Weight='".addslashes($weight)."' , Image='".addslashes($Image)."' ,
				AddedDate='".addslashes($AddedDate)."'  ,Quantity='".addslashes($Quantity)."' ,
				Status='1',variant_id='".addslashes($VariantId)."' , CategoryID= '".addslashes($CategoryID)."', Mid= '".addslashes($Mid)."' ,is_upld= '".addslashes($IsUpld)."',label_txt= '".addslashes($LabelTxt)."' ";
			$this->query($sql,0);
			$lastInsertItemId=$this->lastInsertId();


			/***************add multiple image**************/
			$sql = "select * from inv_item_images where  ItemID= '".addslashes($ItemID)."' ";
			$AllImageArray = $this->query($sql, 1);

			foreach($AllImageArray as $imageArray){
				$Image=$imageArray['Image'];
				$alt_text=$imageArray['alt_text'];

				$sql="insert into e_products_images set Image='".addslashes($Image)."' ,
					alt_text='".addslashes($alt_text)."' ,ProductID ='".addslashes($lastInsertItemId)."'";
				$this->query($sql,0);
			}

			// end
 		/***************add alias**************/
			$sql = "select * from inv_item_alias where  item_id= '".addslashes($ItemID)."' ";
			$AllAliasArray = $this->query($sql, 1);

			foreach($AllAliasArray as $aliasArray){
				$ItemAliasCode=$aliasArray['ItemAliasCode'];
				$ItemAliassku=$aliasArray['sku'];
				$ItemAliasVendorCode=$aliasArray['VendorCode'];
				$ItemAliasdescription=$aliasArray['description'];
				$ItemAliasAliasType=$aliasArray['AliasType'];
				$ItemAliasManufacture=$aliasArray['Manufacture'];

				$sql="insert into e_item_alias set ItemAliasCode='".addslashes($ItemAliasCode)."' ,
					ProductSku='".addslashes($ItemAliassku)."' ,VendorCode ='".addslashes($ItemAliasVendorCode)."',
					ProductID='".addslashes($lastInsertItemId)."' ,description ='".addslashes($ItemAliasdescription)."',
					AliasType='".addslashes($ItemAliasAliasType)."' ,Manufacture ='".addslashes($ItemAliasManufacture)."' ";
				$this->query($sql,0);
			}

			// end




		}
		else {

			// update old item
			$lastInsertItemId=$is_exist;
			$sql="update e_products set Name='".addslashes($description)."' ,
				Detail='".addslashes($long_description)."' ,ShortDetail='".addslashes($description)."' ,
				Price='".addslashes($sell_price)."' ,InventoryControl='Yes' ,
				IsTaxable='".addslashes($Taxable)."' ,TaxRate='".addslashes($sale_tax_rate)."' ,
				Weight='".addslashes($weight)."' , Image='".addslashes($Image)."' ,
				AddedDate='".addslashes($AddedDate)."'  ,Status='1' , variant_id='".addslashes($VariantId)."' ,
				CategoryID= '".addslashes($CategoryID)."',Mid= '".addslashes($Mid)."'
				,is_upld= '".addslashes($IsUpld)."',label_txt= '".addslashes($LabelTxt)."'
				where ProductSku='".addslashes($Sku)."' ";
			$this->query($sql,0);

			/***************add multiple image**************/
			$sql = "select * from inv_item_images where  ItemID= '".addslashes($ItemID)."' ";
			$AllImageArray = $this->query($sql, 1);

			foreach($AllImageArray as $imageArray){
				$Image=$imageArray['Image'];
				$alt_text=$imageArray['alt_text'];
				$sql = "select count(*) as total from e_products_images where  ProductID= '".addslashes($lastInsertItemId)."'
				and Image= '".addslashes($Image)."'  ";
				$ExistImageArray = $this->query($sql, 1);
				if($ExistImageArray[0]['total']=='0'){
					$sql="insert into e_products_images set Image='".addslashes($Image)."' ,
					alt_text='".addslashes($alt_text)."' ,ProductID ='".addslashes($lastInsertItemId)."'";
					$this->query($sql,0);
				}

			}

			// end


/***************add Alias**************/
			$sql = "select * from inv_item_alias where  item_id= '".addslashes($ItemID)."' ";
			$AllAliasArray = $this->query($sql, 1);

			foreach($AllAliasArray as $aliasArray){
				$ItemAliasCode=$aliasArray['ItemAliasCode'];
				$ItemAliassku=$aliasArray['sku'];
				$ItemAliasVendorCode=$aliasArray['VendorCode'];
				$ItemAliasdescription=$aliasArray['description'];
				$ItemAliasAliasType=$aliasArray['AliasType'];
				$ItemAliasManufacture=$aliasArray['Manufacture'];
				
				$sql = "select count(*) as total from e_item_alias where  ProductID= '".addslashes($lastInsertItemId)."'
				and ItemAliasCode= '".addslashes($ItemAliasCode)."'  ";
				$ExistAliasArray = $this->query($sql, 1);
				if($ExistAliasArray[0]['total']=='0'){
					$sql="insert into e_item_alias set ItemAliasCode='".addslashes($ItemAliasCode)."' ,
					ProductSku='".addslashes($ItemAliassku)."' ,VendorCode ='".addslashes($ItemAliasVendorCode)."',
					ProductID='".addslashes($lastInsertItemId)."' ,description ='".addslashes($ItemAliasdescription)."',
					AliasType='".addslashes($ItemAliasAliasType)."' ,Manufacture ='".addslashes($ItemAliasManufacture)."' ";
					$this->query($sql,0);
				}else{
					$sql="update e_item_alias set ProductSku='".addslashes($ItemAliassku)."' ,
					VendorCode ='".addslashes($ItemAliasVendorCode)."',	description ='".addslashes($ItemAliasdescription)."',
					AliasType='".addslashes($ItemAliasAliasType)."' ,Manufacture ='".addslashes($ItemAliasManufacture)."'
					 where  ProductID= '".addslashes($lastInsertItemId)."' and ItemAliasCode= '".addslashes($ItemAliasCode)."' ";
					$this->query($sql,0);
				}

			}
			
			

			// end


		}

	}
	function syncFromEcommerce($ItemsArray){

		$ItemID=$ItemsArray[0]['ProductID'];
		$Sku=$ItemsArray[0]['ProductSku'];
		$CategoryID=$ItemsArray[0]['CategoryID'];
		$description=$ItemsArray[0]['Name'];
		$long_description=$ItemsArray[0]['Detail'];
		$Mid=$ItemsArray[0]['Mid'];
		$sell_price=$ItemsArray[0]['Price'];
		$Taxable=$ItemsArray[0]['IsTaxable'];
		$sale_tax_rate=$ItemsArray[0]['TaxRate'];
		$weight=$ItemsArray[0]['Weight'];
		$Image=$ItemsArray[0]['Image'];
		$Quantity=$ItemsArray[0]['Quantity'];
		$VariantId=$ItemsArray[0]['variant_id'];
		$AddedDate=date('Y-m-d');
		$IsUpld=$ItemsArray[0]['is_upld'];
		$LabelTxt=$ItemsArray[0]['label_txt'];

		$is_exist=$this->checkSkuExist($Sku,'inv_items','Sku','ItemID');

		// get manufacturer id by id beacuse product has int field type

		$sql = "select * from e_manufacturers where  Mid= '".addslashes($Mid)."' limit 1 ";
		$ManufactureRes = $this->query($sql, 1);
		$Manufacture=$ManufactureRes[0]['Mname'];

		
		/*******************
		 * Check category sync
		 * 
		 */
		if($CategoryID!='0'){
		$sql = "select CategoryID from inv_categories where e_categoryId= '".addslashes($CategoryID)."' limit 1 ";
		$CategoryRes = $this->query($sql, 1);
		
		if($CategoryRes){
				// if category already sync
				$CategoryID=$CategoryRes[0]['CategoryID'];
			}else{
				// get parent category id
				if($this->checkCategoryExist($CategoryID,'e_categories')){
					$MainCategoryId=$this->getParentCategoryId($CategoryID,'e_categories');
				
					$catArray['Category']=json_encode(array($MainCategoryId));
				
					$this->syncCategorytoInventory($catArray);
					$sql = "select CategoryID from inv_categories where e_categoryId= '".addslashes($CategoryID)."' limit 1 ";
					$CategoryRes = $this->query($sql, 1);
					$CategoryID=$CategoryRes[0]['CategoryID'];
				}else{
					$CategoryID=0;
				}
			}
		
		// end
		
		}
		if($is_exist=='0'){

			/***********insert new item************/

			$sql="insert into inv_items set description='".addslashes($description)."' ,
				Sku='".addslashes($Sku)."' ,long_description='".addslashes($long_description)."' ,
				sell_price='".addslashes($sell_price)."' ,Taxable='".addslashes($Taxable)."' ,
				sale_tax_rate='".addslashes($sale_tax_rate)."' ,weight='".addslashes($weight)."' , 
				Image='".addslashes($Image)."' , Manufacture='".addslashes($Manufacture)."' ,
				AddedDate='".addslashes($AddedDate)."' ,qty_on_hand='".addslashes($Quantity)."' ,
				Status='1' ,variant_id='".addslashes($VariantId)."' ,
				CategoryID= '".addslashes($CategoryID)."',is_upld= '".addslashes($IsUpld)."',label_txt= '".addslashes($LabelTxt)."'";
			$this->query($sql,0);
			$lastInsertItemId=$this->lastInsertId();

			/***************add multiple image**************/
			$sql = "select * from e_products_images where  ProductID= '".addslashes($ItemID)."' ";
			$AllImageArray = $this->query($sql, 1);

			foreach($AllImageArray as $imageArray){
				$Image=$imageArray['Image'];
				$alt_text=$imageArray['alt_text'];

				$sql="insert into inv_item_images set Image='".addslashes($Image)."' ,
					alt_text='".addslashes($alt_text)."' ,ItemID ='".addslashes($lastInsertItemId)."'";
				$this->query($sql,0);
			}

			// end

/***************add alias**************/
			$sql = "select * from e_item_alias where ProductID = '".addslashes($ItemID)."' ";
			$AllAliasArray = $this->query($sql, 1);

			foreach($AllAliasArray as $aliasArray){
				$ItemAliasCode=$aliasArray['ItemAliasCode'];
				$ItemAliassku=$aliasArray['ProductSku'];
				$ItemAliasVendorCode=$aliasArray['VendorCode'];
				$ItemAliasdescription=$aliasArray['description'];
				$ItemAliasAliasType=$aliasArray['AliasType'];
				$ItemAliasManufacture=$aliasArray['Manufacture'];

				$sql="insert into inv_item_alias set ItemAliasCode='".addslashes($ItemAliasCode)."' ,
					sku='".addslashes($ItemAliassku)."' ,VendorCode ='".addslashes($ItemAliasVendorCode)."',
					item_id='".addslashes($lastInsertItemId)."' ,description ='".addslashes($ItemAliasdescription)."',
					AliasType='".addslashes($ItemAliasAliasType)."' ,Manufacture ='".addslashes($ItemAliasManufacture)."' ";
				$this->query($sql,0);
			}

			// end

		}
		else {

			// update old item
			$lastInsertItemId=$is_exist;
			$sql="update inv_items set description='".addslashes($description)."' ,
						long_description='".addslashes($long_description)."' ,
						sell_price='".addslashes($sell_price)."' ,Taxable='".addslashes($Taxable)."' ,
						sale_tax_rate='".addslashes($sale_tax_rate)."' ,weight='".addslashes($weight)."' , 
						Image='".addslashes($Image)."' , Manufacture='".addslashes($Manufacture)."' ,
						AddedDate='".addslashes($AddedDate)."' ,Status='1' ,variant_id='".addslashes($VariantId)."' ,
						CategoryID= '".addslashes($CategoryID)."',is_upld= '".addslashes($IsUpld)."',label_txt= '".addslashes($LabelTxt)."'
						where Sku='".addslashes($Sku)."' ";
			$this->query($sql,0);


			/***************add multiple image**************/
			$sql = "select * from e_products_images where  ProductID= '".addslashes($ItemID)."' ";
			$AllImageArray = $this->query($sql, 1);

			foreach($AllImageArray as $imageArray){
				$Image=$imageArray['Image'];
				$alt_text=$imageArray['alt_text'];
				$sql = "select count(*) as total from inv_item_images where  ItemID= '".addslashes($lastInsertItemId)."'
				and Image= '".addslashes($Image)."'  ";
				$ExistImageArray = $this->query($sql, 1);
				if($ExistImageArray[0]['total']=='0'){
					$sql="insert into inv_item_images set Image='".addslashes($Image)."' ,
					alt_text='".addslashes($alt_text)."' ,ItemID ='".addslashes($lastInsertItemId)."'";
					$this->query($sql,0);
				}

			}

			// end
 /***************add Alias**************/
			$sql = "select * from e_item_alias where ProductID = '".addslashes($ItemID)."' "; 
			$AllAliasArray = $this->query($sql, 1);

			foreach($AllAliasArray as $aliasArray){
				$ItemAliasCode=$aliasArray['ItemAliasCode'];
				$ItemAliassku=$aliasArray['ProductSku'];
				$ItemAliasVendorCode=$aliasArray['VendorCode'];
				$ItemAliasdescription=$aliasArray['description'];
				$ItemAliasAliasType=$aliasArray['AliasType'];
				$ItemAliasManufacture=$aliasArray['Manufacture'];
				$sql = "select count(*) as total from inv_item_alias where  item_id= '".addslashes($lastInsertItemId)."'
				and ItemAliasCode= '".addslashes($ItemAliasCode)."'  ";
				$ExistAliasArray = $this->query($sql, 1);
				if($ExistAliasArray[0]['total']=='0'){
					$sql="insert into inv_item_alias set ItemAliasCode='".addslashes($ItemAliasCode)."' ,
					sku='".addslashes($ItemAliassku)."' ,VendorCode ='".addslashes($ItemAliasVendorCode)."',
					item_id='".addslashes($lastInsertItemId)."' ,description ='".addslashes($ItemAliasdescription)."',
					AliasType='".addslashes($ItemAliasAliasType)."' ,Manufacture ='".addslashes($ItemAliasManufacture)."' ";
				$this->query($sql,0);
				}
			else{
					$sql="update inv_item_alias set sku='".addslashes($ItemAliassku)."' ,
					VendorCode ='".addslashes($ItemAliasVendorCode)."',	description ='".addslashes($ItemAliasdescription)."',
					AliasType='".addslashes($ItemAliasAliasType)."' ,Manufacture ='".addslashes($ItemAliasManufacture)."' 
					 where  item_id= '".addslashes($lastInsertItemId)."' and ItemAliasCode= '".addslashes($ItemAliasCode)."' ";
					$this->query($sql,0);
				}

			}

			// end

		}

	}
	
	
 	
    function syncCategorytoEcommerce($get) {
        $catIds = json_decode(stripslashes($get['Category']));
        
        if(count($catIds))
        {   
            $this->insertData = array();
            $this->updateData = array();
            foreach ($catIds as $id) 
            {
                $strSQLQuery5 = "select count(*) count from e_categories where item_categoryId ='".$id."'";
                $res = $this->query($strSQLQuery5, 1);
                if($res[0]['count'] == 1){
                    array_push($this->updateData, (array('CategoryID' => $id, 'ParentID' => 0)));
                    $this->getAllDataFromInventory($id,2);
                }else{
                	
                    array_push($this->insertData, (array('CategoryID' => $id, 'ParentID' => 0)));
                   
                    $this->getAllDataFromInventory($id,1);
                }    
            }
			
           
            for ($i = 0; $i < sizeOf($this->insertData); $i++) {
                
                $strSQLQuery = "INSERT INTO e_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,item_categoryId)
                                   select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $this->insertData[$i]['ParentID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->insertData[$i]['CategoryID']." from inv_categories WHERE CategoryID = " . $this->insertData[$i]['CategoryID'] . "";
                $this->query($strSQLQuery, 1);
                for ($j = 0; $j < sizeOf($this->insertData); $j++) {
                    $this->insertData[$j]['ParentID'] = ($this->insertData[$j]['ParentID'] == $this->insertData[$i]['CategoryID']) ? $this->lastInsertId() : $this->insertData[$j]['ParentID'];
                }
            }
            
           
            
            for ($k = 0; $k < sizeOf($this->updateData); $k++) 
            {
                if($this->updateData[$k]['ParentID'] == 0)
                {
                    
                    $this->updateSynCatDatatoEcommerce($this->updateData[$k]['CategoryID']);
                    
                }else{
                    
                    $SQLQuery5 = "select count(*) count from e_categories where item_categoryId ='".$this->updateData[$k]['CategoryID']."'";
                    $res5 = $this->query($SQLQuery5, 1);
                    
                    if($res5[0]['count'] == 1)
                    {
                        
                        $this->updateSynCatDatatoEcommerce($this->updateData[$k]['CategoryID']);
                        
                    }else{
                        
                        $strSqlQuery3 = "select CategoryID from e_categories where item_categoryId ='".$this->updateData[$k]['ParentID']."'";
                        $resPCatID = $this->query($strSqlQuery3, 1);

                        $strSqlQuery4 = "INSERT INTO e_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,item_categoryId)
                                       select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $resPCatID[0]['CategoryID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->updateData[$k]['CategoryID']." from inv_categories WHERE CategoryID = " . $this->updateData[$k]['CategoryID'] . "";
                        $this->query($strSqlQuery4, 1);
                        
                    }
                    
                    
                }
                
            }    
        
        }   
    }
    
    
function syncCategorytoInventory($get) {
        $catIds = json_decode(stripslashes($get['Category']));
        if(count($catIds))
        {     
            $this->insertData = array();
            $this->updateData = array();
            foreach ($catIds as $id) 
            {
                $strSQLQuery5 = "select count(*) count from inv_categories where e_categoryId ='".$id."'";
                $res = $this->query($strSQLQuery5, 1);
                if($res[0]['count'] == 1){
                    array_push($this->updateData, (array('CategoryID' => $id, 'ParentID' => 0)));
                    $this->getAllDataFromEcommerce($id,2);
                }else{
                    array_push($this->insertData, (array('CategoryID' => $id, 'ParentID' => 0)));
                    $this->getAllDataFromEcommerce($id,1);
                }    
            }
            
            
            for ($i = 0; $i < sizeOf($this->insertData); $i++) {
                $added = date("Y-m-d");
                $strSQLQuery = "INSERT INTO inv_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,e_categoryId)
                                   select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $this->insertData[$i]['ParentID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->insertData[$i]['CategoryID']." from e_categories WHERE CategoryID = " . $this->insertData[$i]['CategoryID'] . "";
                $this->query($strSQLQuery, 1);
                for ($j = 0; $j < sizeOf($this->insertData); $j++) {
                    $this->insertData[$j]['ParentID'] = ($this->insertData[$j]['ParentID'] == $this->insertData[$i]['CategoryID']) ? $this->lastInsertId() : $this->insertData[$j]['ParentID'];
                }
            }
            
            for ($k = 0; $k < sizeOf($this->updateData); $k++) 
            {
                if($this->updateData[$k]['ParentID'] == 0)
                {
                    
                    $this->updateSynCatDatatoInventory($this->updateData[$k]['CategoryID']);
                    
                }else{
                    
                    $SQLQuery5 = "select count(*) count from inv_categories where e_categoryId ='".$this->updateData[$k]['CategoryID']."'";
                    $res5 = $this->query($SQLQuery5, 1);
                    
                    if($res5[0]['count'] == 1)
                    {
                        
                        $this->updateSynCatDatatoInventory($this->updateData[$k]['CategoryID']);
                        
                    }else{
                        
                        $strSqlQuery3 = "select CategoryID from inv_categories where e_categoryId ='".$this->updateData[$k]['ParentID']."'";
                        $resPCatID = $this->query($strSqlQuery3, 1);

                        $strSqlQuery4 = "INSERT INTO inv_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,e_categoryId)
                                       select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $resPCatID[0]['CategoryID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->updateData[$k]['CategoryID']." from e_categories WHERE CategoryID = '" . $this->updateData[$k]['CategoryID'] . "'";
                        $this->query($strSqlQuery4, 1);
                        
                    }
                    
                    
                }
                
            } 
        }    
    }
    
 function getAllDataFromInventory($parentId, $do) {
 		
        $query = mysql_query("select CategoryID,ParentID from inv_categories where ParentID In(" . $parentId . ")"); 
        while ($row = mysql_fetch_assoc($query)) {
            ($do == 1) ? array_push($this->insertData, $row) : array_push($this->updateData, $row);
            $this->getAllDataFromInventory($row['CategoryID']);
        }
        
    }
 

function getAllDataFromEcommerce($parentId, $do) {
        $query = mysql_query("select CategoryID,ParentID from e_categories where ParentID In(" . $parentId . ")");
        while ($row = mysql_fetch_assoc($query)) {
           ($do == 1) ? array_push($this->insertData, $row) : array_push($this->updateData, $row);
            $this->getAllDataFromEcommerce($row['CategoryID']);
        }
    }
    
function updateSynCatDatatoEcommerce($ID)
    {
        $strSqlQuery2 = "update e_categories ecat,(select * from inv_categories where CategoryID = '".$ID."') old 
                                        set ecat.Name               = old.Name,
                                            ecat.MetaTitle          = old.MetaTitle,
                                            ecat.MetaKeyword        = old.MetaKeyword,
                                            ecat.MetaDescription    = old.MetaDescription,
                                            ecat.CategoryDescription = old.CategoryDescription,
                                            ecat.Image              = old.Image,
                                            ecat.NumSubcategory     = old.NumSubcategory, 
                                            ecat.NumProducts        = old.NumProducts
                                        where item_categoryId = '".$ID."'"; 
        $result = $this->query($strSqlQuery2, 1);
    }
    
function updateSynCatDatatoInventory($ID)
    {
        $strSqlQuery2 = "update inv_categories ecat,(select * from e_categories where CategoryID = '".$ID."') old 
                                        set ecat.Name               = old.Name,
                                            ecat.MetaTitle          = old.MetaTitle,
                                            ecat.MetaKeyword        = old.MetaKeyword,
                                            ecat.MetaDescription    = old.MetaDescription,
                                            ecat.CategoryDescription = old.CategoryDescription,
                                            ecat.Image              = old.Image,
                                            ecat.NumSubcategory     = old.NumSubcategory, 
                                            ecat.NumProducts        = old.NumProducts
                                        where e_categoryId = '".$ID."'"; 
        $result = $this->query($strSqlQuery2, 1);
    }
    
    
    function getParentCategoryId($catId,$table){
    	$sql = "select ParentID,CategoryID from $table where CategoryID= '".addslashes($catId)."' limit 1 ";
		$Res = $this->query($sql, 1);
		
		if ($Res[0]['ParentID'] =='0') { 
        return $Res[0]['CategoryID']; 
	    } else { 
	        return $this->getParentCategoryId($Res[0]['ParentID'],$table); 
	    } 
    }



 function checkCategoryExist($catId,$table){
    	$sql = "select count(*) as total from $table where CategoryID= '".addslashes($catId)."' limit 1 ";
		$Res = $this->query($sql, 1);
		
		if ($Res[0]['total'] =='1') { 
        return true; 
	    } 
	    return false; 
    }



 /*************************************Attribute Function Start******************************************************************/      
                
                function parseOptions($options)
                {
                        return explode("\n", $options);
                }
	
                
			function getProductIds($catIDs){

				 $strSQLQuery = "select ItemID from inv_items where CategoryID in (".$catIDs.")"; 

				$arraRow = $this->query($strSQLQuery, 1);

				return $arraRow;

			}
                
			function getAllProductIds(){

				$strSQLQuery = "select ItemID from inv_items";
				$arraRow = $this->query($strSQLQuery, 1);

				return $arraRow;

			}
                
                function addGlobalAttribute($arryDetails)
                {
					extract($arryDetails);


					if(in_array('global',$select_products2)){
					$IsGlobal = 'Yes';
					$prductIds = $this->getAllProductIds();
					}else{

					$IsGlobal = 'No';
					foreach($select_products2 as $catID){

					$catIDs .= $catID.",";
					}
					$catIDs = rtrim($catIDs,",");

					$prductIds = $this->getProductIds($catIDs);
					}
                        
                   
                        
					$is_active = isset($is_active)?$is_active:"No";

					/*$parsed_options = explode("\n", $options);

					foreach ($parsed_options as $option)
					{
						if (preg_match("/^.+\(\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?)\s*((\,\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?))?)\s*\)\s*$/", $option))
						{
						$is_modifier = true;
						}
					}*/
$is_modifier = true;

					$is_modifierVal = isset($is_modifier) ? "Yes" : "No";

					 $strSQLQuery = "Insert into inv_global_attributes set AttributeType='".trim($attribute_type)."',IsGlobal='".$IsGlobal."', TextLength = '20', Status='".trim($is_active)."',Priority='".trim($priority)."',Name='".trim($attname)."',Caption='".trim($attname)."',required='".trim($required)."'"; 
					$this->query($strSQLQuery, 1);
					$lastInsertId = $this->lastInsertId();
					if($IsGlobal == "No")
					{
						foreach($select_products2 as $catID){

						$strSQLQuery = "Insert into inv_catalog_attributes set Cid='".$catID."',Gaid='".$lastInsertId."'";
						$this->query($strSQLQuery, 0);
					}
					}
                                
                    
                        if($update_mode == "rewrite"){    
                        foreach($prductIds as $productID){

                            $ProductID = $productID['ItemID'];
                          
                            $strSQLQuery = "Insert into inv_item_attributes set attribute_type='".trim($attribute_type)."',pid='".trim($ProductID)."',gaid='".$lastInsertId."', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($attname)."',options='".trim($options)."',required='".trim($required)."'";

			    $this->query($strSQLQuery, 0);

                            if($ProductID >0)
                                    {
                                        $attributes_countVal = 0;
                                        $sqlAttrVal= mysql_query("select AttributesCount from inv_items where ItemID=".$ProductID);
                                        $attributes_countRow = mysql_fetch_array($sqlAttrVal);
                                        $attributes_countVal = $attributes_countRow['AttributesCount'];
                                        $attributes_countVal = $attributes_countVal+1;
                                        $strSQLQueryAttr = "update inv_items set AttributesCount=".$attributes_countVal." where ItemID='".mysql_real_escape_string($ProductID)."'";
                                        $this->query($strSQLQueryAttr, 0);
                                    }
                          }                       
                        }
                                                     
					return $lastInsertId;
                        
                }
/************************OptionList********************/
function AddGlobalAttOption($global_id,$arryDetails){
	global $Config;
	extract($arryDetails);
	for($i=1;$i<=$NumLine;$i++){
	      if(!empty($arryDetails['title'.$i])){
		$sql = "insert into inv_global_optionList(Gaid, title, Price, PriceType, Weight, SortOrder) values('".$global_id."', '".$arryDetails['title'.$i]."',  '".addslashes($arryDetails['Price'.$i])."', '".addslashes($arryDetails['PriceType'.$i])."', '".addslashes($arryDetails['Weight'.$i])."', '".addslashes($arryDetails['SortOrder'.$i])."')";
					$this->query($sql, 0);	
	      }
	}

}
function AddUpdateGlobalAttOption($global_id,$arryDetails){
			global $Config;
			extract($arryDetails);


			if(!empty($DelItem)){
				$strSQLQuery = "delete from inv_global_optionList where id in(".$DelItem.")"; 
				$this->query($strSQLQuery, 0);
			}
	for($i=1;$i<=$NumLine;$i++){
	      if(!empty($arryDetails['title'.$i])){
$id = $arryDetails['id'.$i];

if($id>0){
	$sql = "update inv_global_optionList set  title='".addslashes($arryDetails['title'.$i])."',`Price`='".addslashes($arryDetails['Price'.$i])."', PriceType='".addslashes($arryDetails['PriceType'.$i])."', Weight='".addslashes($arryDetails['Weight'.$i])."', SortOrder='".addslashes($arryDetails['SortOrder'.$i])."' where id='".$id."'"; 

 $this->query($sql, 0);
}else{	$sql = "insert into inv_global_optionList(Gaid,paid, title, Price, PriceType, Weight, SortOrder) values('".$global_id."','".$PattID."' ,'".$arryDetails['title'.$i]."',  '".addslashes($arryDetails['Price'.$i])."', '".addslashes($arryDetails['PriceType'.$i])."', '".addslashes($arryDetails['Weight'.$i])."', '".addslashes($arryDetails['SortOrder'.$i])."')";
					$this->query($sql, 0);
}	
#echo $sql; exit;
	      }
	}

}
function  GetOptionList($global_id) 
		{
			$strAddQuery =''; 
			$strAddQuery .= (!empty($global_id))?(" and Gaid='".$global_id."'"):("");
			//$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
                        $strSQLQuery = "select * from inv_global_optionList  where 1 ".$strAddQuery." order by id asc";
			return $this->query($strSQLQuery, 1);
		}
function  GetProductOptionList($paid) 
		{
			$strAddQuery .= (!empty($paid))?(" and paid='".$paid."'"):("");
			//$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
                        $strSQLQuery = "select * from inv_global_optionList  where 1 ".$strAddQuery." order by id asc";
			return $this->query($strSQLQuery, 1);
		}
/************************OptionList********************/
                
                function updateGlobalAttribute($arryDetails)
                {
   
                    extract($arryDetails);
                      
                       
                        $strSQLQuery = "delete from inv_item_attributes where gaid='".mysql_real_escape_string($Gaid)."'";
                        $this->query($strSQLQuery,0);
                        $strSQLQuery = "delete from inv_catalog_attributes where Gaid='".mysql_real_escape_string($Gaid)."'";
                        $this->query($strSQLQuery,0);
                         
			         if(in_array('global',$select_products2)){
                            
                            $IsGlobal = 'Yes';
                            $prductIds = $this->getAllProductIds();
                        }else{
                             $IsGlobal = 'No';
                             
                             foreach($select_products2 as $catID){
                          
                                    $catIDs .= $catID.",";
                                }
                                $catIDs = rtrim($catIDs,",");
                                
                                 $prductIds = $this->getProductIds($catIDs);
                        }
                        
                       
                        
			            $is_active = isset($is_active)?$is_active:"No";
                        
                       /* $parsed_options = explode("\n", $options);
                        
                        foreach ($parsed_options as $option)
                        {
                                if (preg_match("/^.+\(\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?)\s*((\,\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?))?)\s*\)\s*$/", $option))
                                {
                                        $is_modifier = true;
                                }
                        }
                        */
                      $is_modifier = true;
                        $is_modifierVal = isset($is_modifier) ? "Yes" : "No";
                       
				$strSQLQuery = "UPDATE inv_global_attributes set AttributeType='".trim($attribute_type)."',IsGlobal='".$IsGlobal."', TextLength = '20', Status='".trim($is_active)."',Priority='".trim($priority)."',Name='".trim($attname)."',Caption='".trim($attname)."',required='".trim($required)."' WHERE Gaid = '".mysql_real_escape_string($Gaid)."'";
				$this->query($strSQLQuery, 0);
                     
                        if($IsGlobal == "No")
                        {
                             foreach($select_products2 as $catID){
                                 
                                  $strSQLQuery = "Insert into inv_catalog_attributes set Cid='".$catID."',Gaid='".$Gaid."'";
			          $this->query($strSQLQuery, 0);
                             }
                        }
                                
                    
                        if($update_mode == "rewrite"){    
                        foreach($prductIds as $productID){

                            $ProductID = $productID['ItemID'];
                          
                             $strSQLQuery = "Insert into inv_item_attributes set attribute_type='".trim($attribute_type)."',pid='".trim($ProductID)."',gaid='".$Gaid."', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($attname)."',options='".trim($options)."',required='".trim($required)."'";
							$this->query($strSQLQuery, 0);

                            if($ProductID >0)
                                    {
                                        $attributes_countVal = 0;
                                        $sqlAttrVal= mysql_query("select AttributesCount from inv_items where ItemID=".$ProductID);
                                        $attributes_countRow = mysql_fetch_array($sqlAttrVal);
                                        $attributes_countVal = $attributes_countRow['AttributesCount'];
                                        $attributes_countVal = $attributes_countVal+1;
                                        $strSQLQueryAttr = "update inv_items set AttributesCount=".$attributes_countVal." where ItemID='".mysql_real_escape_string($ProductID)."'";
                                        $this->query($strSQLQueryAttr, 0);
                                    }
                          }                       
                        }
                                                     
			return 1;
                    
                    
                }
                
               function getGlobalAttributes()
                {
                    $strSQLQuery = "SELECT * FROM inv_global_attributes ORDER BY Gaid DESC";
		return $this->query($strSQLQuery, 1);
                    
                }
                
               function getGlobalAttributeById($attrID)
                {
                    $strSQLQuery = "SELECT * FROM inv_global_attributes WHERE Gaid = '".$attrID."'";
					return $this->query($strSQLQuery, 1);
                    
                }
                
                function changeGlobalAttributeStatus($attrID)
                {
                    
					$strSQLQuery = "select * from inv_global_attributes where Gaid='".$attrID."'";
					$rs = $this->query($strSQLQuery);
					if(sizeof($rs))
					{
					if($rs[0]['Status'] == "Yes")
					$Status="No";
					else
					$Status="Yes";

					$strSQLQuery = "update inv_global_attributes set Status='$Status' where Gaid='".mysql_real_escape_string($attrID)."'";
					$this->query($strSQLQuery,0);

					}	
					
					return true;
        
                }
                
                function deleteGlobalAttribute($attrID)
                {
		$strSQLQuery = "delete from inv_global_attributes where Gaid='".mysql_real_escape_string($attrID)."'";
		  $this->query($strSQLQuery,0);
		$strSQLQuery = "delete from inv_item_attributes where gaid='".mysql_real_escape_string($attrID)."'";
		  $this->query($strSQLQuery,0);
		$strAttOptionQuery = "delete from inv_global_optionList where Gaid='".mysql_real_escape_string($attrID)."'";
		  $this->query($strAttOptionQuery,0);
		$strSQLQuery = "delete from inv_catalog_attributes where Gaid='".mysql_real_escape_string($attrID)."'";
		  $this->query($strSQLQuery,0);
                }
                               
                
        function InsertAttributes($arryDetails)
		{
			
			extract($arryDetails);
			
			$is_active = isset($is_active)?$is_active:"No";
                        
                       /* $parsed_options = explode("\n", $options);
                        
                        foreach ($parsed_options as $option)
                        {
                                if (preg_match("/^.+\(\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?)\s*((\,\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?))?)\s*\)\s*$/", $option))
                                {
                                        $is_modifier = true;
                                }
                        }*/
                    $is_modifier = true;    
                      
                        $is_modifierVal = isset($is_modifier) ? "Yes" : "No";
                       
			$strSQLQuery = "Insert into inv_item_attributes set attribute_type='".trim($attribute_type)."',pid='".trim($ProductID)."',gaid='0', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($attname)."',options='".trim($options)."',required='".trim($required)."'";
			$this->query($strSQLQuery, 0);
$lastInsertId = $this->lastInsertId();
                                                     if($ProductID >0)
                                                     {
                                                         $attributes_countVal = 0;
                                                         $sqlAttrVal= mysql_query("select AttributesCount from inv_items where ItemID=".$ProductID);
                                                         $attributes_countRow = mysql_fetch_array($sqlAttrVal);
                                                         $attributes_countVal = $attributes_countRow['AttributesCount'];
                                                         $attributes_countVal = $attributes_countVal+1;
                                                         $strSQLQueryAttr = "update inv_items set AttributesCount=".$attributes_countVal." where ItemID='".mysql_real_escape_string($ProductID)."'";
                                                         $this->query($strSQLQueryAttr, 0);
                                                     }
			return $lastInsertId;
		}
                
                
       function UpdateAttributes($arryDetails)
		{

			extract($arryDetails);
			$is_active = isset($is_active)?$is_active:"No";
                        
                       /*  $parsed_options = explode("\n", $options);
                        
                        foreach ($parsed_options as $option)
                        {
                                if (preg_match("/^.+\(\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?)\s*((\,\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?))?)\s*\)\s*$/", $option))
                                {
                                        $is_modifier = true;
                                }
                        }*/
                      $is_modifier = true;   
                      
                        $is_modifierVal = isset($is_modifier) ? "Yes" : "No";
                        
			$strSQLQuery = "update inv_item_attributes set attribute_type='".trim($attribute_type)."',gaid='0', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($attname)."',options='".trim($options)."',required='".trim($required)."' where paid = '".mysql_real_escape_string($AttributeId)."' and pid='".mysql_real_escape_string($ProductID)."'";
			$this->query($strSQLQuery, 0);
			return 1;
		}
                
		function GetAttributeByID($attId)
		{

			$strSQLQuery = "select * from inv_item_attributes where paid = '".$attId."'";
			return $this->query($strSQLQuery, 1);
		}
		function GetProductAttributes($ProductID)
		{

			 $strSQLQuery = "Select * from inv_item_attributes where pid='".$ProductID."'"; 
			return $this->query($strSQLQuery, 1);
		}
                
		function GetProductAttributesForFront($ProductID)
		{

			 $strSQLQuery = "Select * from inv_item_attributes where pid='".$ProductID."' AND is_active='Yes' order by priority asc"; 
			return $this->query($strSQLQuery, 1);
		}
             
                
                         
                                        
			function deleteAttribute($pid,$attributeId)
					{
						$strSQLQuery = "delete from inv_item_attributes where paid='".mysql_real_escape_string($attributeId)."' and pid='".mysql_real_escape_string($pid)."'"; 
						$this->query($strSQLQuery, 0);

						$sqlAttrVal= mysql_query("select AttributesCount from inv_items where ItemID='".mysql_real_escape_string($pid)."'");
						$attributes_countRow = mysql_fetch_array($sqlAttrVal);
						$attributes_countVal = $attributes_countRow['AttributesCount'];
						$attributes_countVal = $attributes_countVal-1;
						$strSQLQueryAttr = "update inv_items set AttributesCount=".$attributes_countVal." where ItemID='".mysql_real_escape_string($pid)."'";
						 $this->query($strSQLQueryAttr, 0);
							   return 1;
					}

 function  GetOptionListForList($global_id,$paid) 
		{
			$strAddQuery .= (!empty($global_id))?(" and Gaid='".$global_id."'"):("");
			$strAddQuery .= (!empty($paid))?(" and paid='".$paid."'"):("");
			
           $strSQLQuery = "select Id,concat(IF(PriceType = 'Fixed', 'F_', 'P_'), title,'(',IF(Price = '', 0, Price) ,',',IF(Weight = '', 0, Weight) ,')') as options,title
from inv_global_optionList where 1 ".$strAddQuery." order by id asc";
  
           return $this->query($strSQLQuery, 1);
           for($i=0;$i<count($res);$i++){
           	$result[]=$res[$i]['options'];
           	$title[]=$res[$i]['title'];
           }
			return array($result,$title);
		}
		
function  GetOptionVal($id) 
		{
		$strAddQuery .= (!empty($id))?(" and Id='".$id."'"):("");
				           
		$strSQLQuery = "select * from  inv_global_optionList where   1 ".$strAddQuery." order by id asc";
		       
		return $this->query($strSQLQuery, 1);
           
		}

 /*************************************Attribute Function End******************************************************************/ 

function AddUpdateModelGen($item_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);


			if(!empty($item_id)){
				$strSQLQuery = "delete from inv_item_modelGen where item_id = '".$item_id."'"; 
				$this->query($strSQLQuery, 0);
			}

		   $arryModel = $arryDetails['Model'];

		for($i=0;$i<=sizeof($arryModel);$i++){

			if(!empty($arryModel[$i])){
				$arryGen =$arryDetails['Gen_'.$arryModel[$i]];

				//echo $arryModel[$i];
					$arryModGen = implode(",",$arryGen);
	
				 $sql = "insert into inv_item_modelGen (item_id,model,genration) values( '".$item_id."', '".$arryModel[$i]."','".$arryModGen."')";	

				$this->query($sql, 0);
				    //echo $arryModel[$i]."==>".$arryModGen; 

			}

		}
                                        

                                                
		}

function GetModGen($item_id,$model){
$strAddQuery = '';
$strAddQuery .= (!empty($item_id))?(" and item_id='".$item_id."'"):("");
$strAddQuery .= (!empty($model))?(" and model='".$model."'"):("");
			//$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
                       $strSQLQuery = "select * from inv_item_modelGen  where 1 ".$strAddQuery." order by ID asc"; 
			return $this->query($strSQLQuery, 1);
}

//***********************************************Amit Singh*****************************************/
            function GetAttributPrice($id){

                $strAddQuery="and Id=".$id;
                $strSQLQuery = "select Price,paid from  inv_global_optionList where   1 ".$strAddQuery;

                return $this->query($strSQLQuery, 1);
            }

        //**********************************************End*************************************************************/

/********* By Karishma for MultiStore 22 Dec 2015******/

	/*function getCustomers($ItemID=0)
	{
		$CmpID=$_SESSION['CmpID'];
		$sql="Select id,permission,ref_id FROM erp.`company_user` WHERE 1 AND comId='" . addslashes($CmpID). "'  AND user_type='customer '";
		$res=$this->query($sql, 1);



		$customerArray=array();


		foreach($res as $val){

			$SqlCustomer = "select c1.Cid,IF(c1.CustomerType = 'Company' and c1.Company!='', c1.Company, c1.FullName) as FullName,b.ID from s_customers c1	left join inv_customer_items b on b.CustomerID=c1.Cid and b.ItemID='" . addslashes($ItemID). "'		WHERE c1.Cid='" . addslashes($val['ref_id']). "' "; 

//$SqlCustomer = "select c1.Cid,IF(c1.CustomerType = 'Company' and c1.Company!='', c1.Company, c1.FullName) as FullName,b.ID from s_customers c1	left join inv_customer_items b on b.CustomerID=c1.Cid and b.ItemID='" . addslashes($ItemID). "'		";

			//$SqlCustomer .= ($ItemID!=0)? " and  b.ItemID='" . addslashes($ItemID). "' ":'';
			$result=$this->query($SqlCustomer, 1);

//foreach($res as $val){

			//$customerArray[]=array('Cid'=>$val['Cid'],'FullName'=>stripslashes($val['FullName']));
		//}

			if(!empty($result[0]['Cid']) && ($result[0]['ID']=='0' || $result[0]['ID']==''))
			$customerArray[]=array('Cid'=>$result[0]['Cid'],'FullName'=>stripslashes($result[0]['FullName']));
		}
		return $result;
			

	}*/


function getCustomers($ItemID=0)
	{
		$CmpID=$_SESSION['CmpID'];
		$sql="Select id,permission,ref_id FROM erp.`company_user` WHERE 1 AND comId='" . addslashes($CmpID). "'  AND user_type='customer '";
		$res=$this->query($sql, 1);



		$customerArray=array();


		foreach($res as $val){

			$SqlCustomer = "select c1.Cid,IF(c1.CustomerType = 'Company' and c1.Company!='', c1.Company, c1.FullName) as FullName,b.ID from s_customers c1
			left join inv_customer_items b on b.CustomerID=c1.Cid and b.ItemID='" . addslashes($ItemID). "'
			WHERE c1.Cid='" . addslashes($val['ref_id']). "' "; 

			//$SqlCustomer .= ($ItemID!=0)? " and  b.ItemID='" . addslashes($ItemID). "' ":'';
			$result=$this->query($SqlCustomer, 1);
			if(!empty($result[0]['Cid']) && ($result[0]['ID']=='0' || $result[0]['ID']==''))
			$customerArray[]=array('Cid'=>$result[0]['Cid'],'FullName'=>stripslashes($result[0]['FullName']));
		}
		return $customerArray;
			

	}

	function getSelectedCustomers($ItemID=0)
	{

		$sql="select c1.Cid,IF(c1.CustomerType = 'Company' and c1.Company!='', c1.Company, c1.FullName) as FullName,b.ID from inv_customer_items  b
			Inner join s_customers  c1 on c1.Cid=b.CustomerID where ItemID='" . addslashes($ItemID). "'	";
		$res=$this->query($sql, 1);

		$customerArray=array();

		foreach($res as $val){

			$customerArray[]=array('Cid'=>$val['Cid'],'FullName'=>stripslashes($val['FullName']));
		}
		return $customerArray;
			

	}
	/*****End By Karishma for MultiStore 22 Dec 2015**********/
//update by chetan for 3rd paramter and its condition on 15jan2017//updated on 6Apr2017 by chetan//
function getItemCondion($Sku,$Condi,$WID=0) {//,$isdefault//
	$strAddQuery = (!empty($Condi))?(" and `condition`='".addslashes($Condi)."'"):("");
	$strAddQuery.= (!empty($WID))?(" and WID = '".addslashes($WID)."' "):("and WID = 1 ");
$strAddQuery.= (!empty($Sku))?(" and Sku = '".addslashes($Sku)."' "):(" ");
	 $strSQLQuery = "select SUM(condition_qty) as condition_qty,`condition`,AvgCost,SalePrice,ItemID,WID,Sku  from inv_item_quanity_condition where 1   ".$strAddQuery." group by `condition` desc ";
	$row = $this->query($strSQLQuery, 1);
	return $row;
}

function getItemCondionForQty($Sku,$Condi) {//,$isdefault//
	$strAddQuery = (!empty($Condi))?(" and `condition`='".addslashes($Condi)."'"):("");
	$strAddQuery.= (!empty($WID))?(" and WID = '".addslashes($WID)."' "):(" ");
$strAddQuery.= (!empty($Sku))?(" and Sku = '".addslashes($Sku)."' "):(" ");
	 $strSQLQuery = "select SUM(condition_qty) as condition_qty,`condition`,AvgCost,SalePrice,ItemID,WID,Sku  from inv_item_quanity_condition where 1   ".$strAddQuery." group by `condition`,WID desc ";
	$row = $this->query($strSQLQuery, 1);
	return $row;
}

/*function UpdateSalePriceByCondion($Sku,$Condi,$SalePrice) {
 $strSQL = "update inv_item_quanity_condition set SalePrice = '" . mysql_real_escape_string($SalePrice) . "',AvgCost = '" . mysql_real_escape_string($SalePrice) . "'    where Sku = '" . mysql_real_escape_string($Sku) . "' and `condition`='".addslashes($Condi)."'"; 
            $this->query($strSQL, 0);
		return $row;
	}*/
/*********Added By karishma based on Condition********************added more col by chetan on 16feb */
	function getItemCondionQty($Sku,$Condi,$WID=0,$binid=0) {
$strAddQuery = (!empty($Condi))?(" and `condition`='".addslashes($Condi)."'"):("");
$strAddQuery .= (!empty($WID))?(" and `WID`='".addslashes($WID)."'"):("");
$strAddQuery .= (!empty($binid))?(" and `binid`='".addslashes($binid)."'"):("");
		 $strSQLQuery = "select condition_qty,`condition`,AvgCost,SalePrice,pricetype,prpercent,fprice,qtyfrom,qtyto from inv_item_quanity_condition where Sku = '" . $Sku . "'  ".$strAddQuery;
		$row = $this->query($strSQLQuery, 1);
		return $row;
	}

/*********************/
function getCountItemCondion($Sku,$Condi,$WID=0) {//,$isdefault//
	$strAddQuery = (!empty($Condi))?(" and `condition`='".addslashes($Condi)."'"):("");
	$strAddQuery.= (!empty($WID))?(" and WID = '".addslashes($WID)."' "):("and WID = '1' ");
	$strSQLQuery = "select COUNT(condition_qty) as totQty,SalePrice,ItemID  from inv_item_quanity_condition where Sku = '" . $Sku . "'  ".$strAddQuery."  ";
	$row = $this->query($strSQLQuery, 1);
	return $row;
}

/*********************/

function getCondionQtyBySku($Sku,$Condi) {
$strAddQuery = (!empty($Condi))?(" and `condition`='".addslashes($Condi)."'"):("");
		 $strSQLQuery = "select condition_qty as OnHandQty,`condition`,AvgCost from inv_item_quanity_condition where Sku = '" . $Sku . "' and WID='1' ".$strAddQuery;
		$row = $this->query($strSQLQuery, 1);
		return $row;
	}
	/*********End By karishma based on Condition*********************/


//Added by chetan 14Jan to get avg. cost of MainItem//	
function getAvgCostsofPurOrderbyID($sku,$condition)
{ 
	$strSQLQuery = "select sum(qty) as totalQty , sum(price) as totalPrice, ROUND(sum(price)/sum(qty),2) as avgPrice,Currency from
 ( SELECT sum(poi.qty_received) as qty,sum(poi.price*poi.qty_received) as price,po.Currency FROM p_order_item as poi join p_order as po on poi.OrderID = po.OrderID WHERE poi.sku = '" . $sku . "' and poi.Condition = '" . $condition . "' and po.Status = 'Completed' and poi.ref_id>'0'
 UNION SELECT sum(invd.disassembly_qty) as qty,sum(invd.unit_cost*invd.disassembly_qty) as price,'".$Config['Currency']."' as Currency FROM inv_disassembly as invd WHERE invd.Sku = '" . $sku . "' 	   and invd.bomCondition = '" . $condition . "' and invd.Status = '2'
 UNION SELECT sum(isa.qty) as qty,sum(isa.price*isa.qty) as price,'".$Config['Currency']."' as Currency FROM inv_stock_adjustment as isa join inv_adjustment as ind on isa.adjid = ind.adjid WHERE isa.sku = '" . $sku . "' and isa.Condition = '" . $condition . "' and ind.Status = '2' ) as Total";

	return $this->query($strSQLQuery);
}


function getAvgCostForSku($sku,$condition)
{ 

global $Config;
	 //$strSQLQuery = "SELECT sum(poi.qty_received) as totalQty, sum(poi.price) as totalPrice,ROUND((sum(poi.amount)+sum(poi.freight_cost))/sum(poi.qty_received),2) as avgPrice ,poi.Condition as cond,po.Currency FROM p_order_item as poi join p_order as po on poi.OrderID = po.OrderID WHERE poi.sku = '" . $sku . "'  and poi.ref_id>'0' and po.Module='Receipt' and po.ReceiptStatus ='Completed' and po.OrderType !='Dropship' group by poi.Condition";


//$strSQLQuery = "select qty as totalQty , price as totalPrice, ROUND(price/qty,2) as avgPrice,cond from ( SELECT sum(poi.qty_received) as qty,sum(poi.price) as price,poi.Condition as cond,po.Currency  FROM p_order_item as poi join p_order as po on poi.OrderID = po.OrderID WHERE poi.sku = '" . $sku . "' and poi.Condition!='' and po.Status = 'Completed'  and poi.ref_id>'0' group by poi.Condition  UNION SELECT sum(invd.disassembly_qty) as qty,sum(invd.unit_cost) as price,invd.bomCondition as cond FROM inv_disassembly as invd WHERE invd.Sku = '" . $sku . "'  and invd.Status = '2' and invd.bomCondition!='' group by invd.bomCondition   UNION SELECT sum(isa.qty) as qty,sum(isa.price) as price,isa.Condition as cond FROM inv_stock_adjustment as isa join inv_adjustment as ind on isa.adjid = ind.adjid WHERE isa.sku = '" . $sku . "'  and ind.Status = '2' and isa.Condition!=''  group by isa.Condition  ) as Total ";




	 $strSQLQuery = "select qty as totalQty , price as totalPrice,avgPrice,cond,Currency from ( SELECT sum(poi.qty_received) as qty, sum(poi.price) as Price,ROUND((sum(poi.amount)+sum(poi.freight_cost))/sum(poi.qty_received),2) as avgPrice ,poi.Condition as cond,po.Currency FROM p_order_item as poi join p_order as po on poi.OrderID = po.OrderID WHERE poi.sku = '" . $sku . "'  and poi.ref_id>'0' and po.Module='Receipt' and po.ReceiptStatus ='Completed' and po.OrderType !='Dropship' group by poi.Condition  UNION SELECT sum(invd.disassembly_qty) as qty,sum(invd.unit_cost) as price,invd.unit_cost as avgPrice,invd.bomCondition as cond,'".$Config['Currency']."' as Currency FROM inv_disassembly as invd WHERE invd.Sku = '" . $sku . "'  and invd.Status = '2' and invd.bomCondition!='' group by invd.bomCondition   UNION SELECT sum(isa.qty) as qty,sum(isa.price) as price,isa.price as avgPrice,isa.Condition as cond,'".$Config['Currency']."' as Currency FROM inv_stock_adjustment as isa join inv_adjustment as ind on isa.adjid = ind.adjid WHERE isa.sku = '" . $sku . "'  and ind.Status = '2' and isa.Condition!=''  group by isa.Condition  ) as Total ";

	return $this->query($strSQLQuery);
}





	//***************************Start Ebay Code***************************************************
function Addebaycredentials($arryDetails)
		{
			extract($arryDetails);	
		
			/*$sql = "insert into ebay_settings(s_devID,s_appID,s_certID,s_userToken,s_paypalEmailAddress,p_devID,p_appID,p_certID,p_userToken,p_paypalEmailAddress,Status) values('".addslashes($DeveloperID)."','".$ApplicationID."', '".$CertificateID."', '".$UserToken."', '".$PaypalEmailAddress."','".$PDeveloperID."','".$PApplicationID."', '".$PCertificateID."', '".$PUserToken."', '".$PPaypalEmailAddress."','".$Status."')";
			$rs = $this->query($sql,0);*/
			$query = ", sync_product ='" .$sync_product. "',
					  site_id ='" . $site_id. "',
					  set_desc ='" . $set_desc. "',
					  product_type ='" . $product_type. "',
					  listing_duration ='" . $listing_duration. "',
					  item_condition ='" . $item_condition. "',
					 Fee ='" . $Fee. "',
					 FeeRate ='" . $FeeRate. "',
					  condition_note ='" . addslashes($condition_note). "'
					";
			if($Credentials=='Production'){
				$p_ReturnsPolicy = json_encode( array('p_ReturnsWithin'=>$p_ReturnsWithin,'p_ReturnsDesc'=>$p_ReturnsDesc));
				$p_ShippingDetail = json_encode( array('p_ShippingType'=>$p_ShippingType,'p_ShippingService'=>$p_ShippingService,'p_ShippingServiceCost'=>$p_ShippingServiceCost));
				 
				$strSQLQuery ="insert into ebay_settings set p_devID ='" . $PDeveloperID. "',P_appID= '" . $PApplicationID. "',p_certID = '" .$PCertificateID. "',p_userToken = '" .$PUserToken. "',p_paypalEmailAddress ='" . $PPaypalEmailAddress. "',credential_Type ='".$Credentials."',status='" . $Status. "',syncOders='" . $sync_orders. "',from_date='" . $from_date. "',p_payment_method='" . $p_payment_method. "',p_return_policy='" . $p_ReturnsPolicy. "',p_shipping_details='" . $p_ShippingDetail. "' $query ";
			}else{
				$s_ReturnsPolicy = json_encode( array('s_ReturnsWithin'=>$s_ReturnsWithin,'s_ReturnsDesc'=>$s_ReturnsDesc));
				$s_ShippingDetail = json_encode( array('s_ShippingType'=>$s_ShippingType,'s_ShippingService'=>$s_ShippingService,'s_ShippingServiceCost'=>$s_ShippingServiceCost));
				$strSQLQuery ="insert into ebay_settings set s_devID = '" .$DeveloperID. "',s_appID = '" . $ApplicationID. "',s_certID = '" . $CertificateID. "',s_userToken = '" . $UserToken. "',s_paypalEmailAddress = '" . $PaypalEmailAddress. "',credential_Type ='".$Credentials."',status='" . $Status. "',syncOders='" . $sync_orders. "',from_date='" . $from_date. "' ,s_payment_method='" . $s_payment_method. "',s_return_policy='" . $s_ReturnsPolicy. "',s_shipping_details='" . $s_ShippingDetail. "' $query ";
			}
			//echo $strSQLQuery;die;
			$this->query($strSQLQuery, 0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;

		}


 function Getdata()
		{
	$strSQLQuery = "Select * from ebay_settings";
	
return  $this->query($strSQLQuery, 1);
		
		}
 function GetEbayCredentials()
		{ 
	$strSQLQuery = "Select * from ebay_settings where status='1'";
	
	return  $this->query($strSQLQuery, 1);
		
		}			
		function  GetCredentialsById($id)
		{

			$strSQLQuery = "Select * from ebay_settings";
			$strSQLQuery .= (!empty($id))?(" where ebay_ID='".$id."'"):(" where 1 ");
			//echo $strSQLQuery; exit;
			return $this->query($strSQLQuery, 1);
		}
 function UpdateCredentials($arryDetails) 
		 {
	
        extract($arryDetails);
		$query = ", sync_product ='" .$sync_product. "', 
					  site_id ='" . $site_id. "',
					  set_desc ='" . $set_desc. "',
					  product_type ='" . $product_type. "',
					  listing_duration ='" . $listing_duration. "',
					  item_condition ='" . $item_condition. "',
 					  Fee ='" . $Fee. "',
					  FeeRate ='" . $FeeRate. "',
					  condition_note ='" . addslashes($condition_note). "'
					";
        if($Credentials=='Production'){
        	$p_ReturnsPolicy = json_encode( array('p_ReturnsWithin'=>$p_ReturnsWithin,'p_ReturnsDesc'=>$p_ReturnsDesc));
        	$p_ShippingDetail = json_encode( array('p_ShippingType'=>$p_ShippingType,'p_ShippingService'=>$p_ShippingService,'p_ShippingServiceCost'=>$p_ShippingServiceCost));
        	
		 $strSQLQuery ="update ebay_settings set p_devID ='" . $PDeveloperID. "',P_appID= '" . $PApplicationID. "',p_certID = '" .$PCertificateID. "',p_userToken = '" .$PUserToken. "',p_paypalEmailAddress ='" . $PPaypalEmailAddress. "',credential_Type ='".$Credentials."',status='" . $Status. "',syncOders='" . $sync_orders. "',from_date='" . $from_date. "',p_payment_method='" . $p_payment_method. "',p_return_policy='" . $p_ReturnsPolicy. "',p_shipping_details='" . $p_ShippingDetail. "' $query ";
        }else{
        	$s_ReturnsPolicy = json_encode( array('s_ReturnsWithin'=>$s_ReturnsWithin,'s_ReturnsDesc'=>$s_ReturnsDesc));
        	$s_ShippingDetail = json_encode( array('s_ShippingType'=>$s_ShippingType,'s_ShippingService'=>$s_ShippingService,'s_ShippingServiceCost'=>$s_ShippingServiceCost));
        	$strSQLQuery ="update ebay_settings set s_devID = '" .$DeveloperID. "',s_appID = '" . $ApplicationID. "',s_certID = '" . $CertificateID. "',s_userToken = '" . $UserToken. "',s_paypalEmailAddress = '" . $PaypalEmailAddress. "',credential_Type ='".$Credentials."',status='" . $Status. "',syncOders='" . $sync_orders. "',from_date='" . $from_date. "' ,s_payment_method='" . $s_payment_method. "',s_return_policy='" . $s_ReturnsPolicy. "',s_shipping_details='" . $s_ShippingDetail. "' $query ";
        } 
        $strSQLQuery .= (!empty($ebayid))?(" where ebay_ID='".$ebayid."'"):(" where 1 ");
	
	  $this->query($strSQLQuery, 0);
          
        return 1;
 
     
        }

function  GetEbayItemId($id)
		{
			$strSQLQuery = "select * from ebay_items";
			$strSQLQuery .= (!empty($id))?(" where title='".$id."'"):(" where 1 ");
			//echo $strSQLQuery; exit;
			return $this->query($strSQLQuery, 1);
		}
		function  Getebaydata()
		{
			$strSQLQuery = "SELECT * FROM `ebay_items` WHERE 1";
			//$strSQLQuery .= (!empty($id))?(" where title=".$id):(" where 1 ");
			//echo $strSQLQuery; exit;
			return $this->query($strSQLQuery, 1);
		}


	//***************************End Ebay*****************************************/


//added by chetan on 19jan2017// updated (sku and condition) by chetan on 15Jan2017//updated again for WID on 3Apr2017//
    function GetPOSOTotalQtyOnInterval($sku, $numHistory, $for, $condition,$itemID, $WID) {
        $strAddQuery = "";
        $Num = preg_replace("/[^0-9]/","",$numHistory);
        $Interval = preg_replace("/[^a-zA-Z]/","",$numHistory);
                 
        if($for == 'PO')
        {    
            $table         = 'p_order_item';
            $jointable     = 'p_order';
	    $Cond = " and  EXISTS (SELECT 1 FROM p_order b WHERE b.PurchaseID = t2.PurchaseID and b.Module ='Receipt' and b.ReceiptStatus='Completed') ";
        }else{
            $table         = 's_order_item';
            $jointable     = 's_order';
	     $Cond = " and  EXISTS (SELECT 1 FROM s_order b WHERE b.SaleID = t2.SaleID and b.Module ='Invoice' and b.PostToGL=1)  ";
        }
	//print_r($sku);
        $strAddQuery .= ($Interval == 'year') ? (" AND t2.OrderDate >= DATE_SUB(NOW(),INTERVAL ".$Num." YEAR)") : ("");
        $strAddQuery .= ($Interval == 'm') ? (" AND t2.OrderDate >= DATE_SUB(NOW(), INTERVAL ".$Num." MONTH)") : ("");
        $strAddQuery .= ($Interval == 'd') ? (" AND t2.OrderDate >= DATE_SUB(NOW(), INTERVAL ".$Num." DAY)") : ("");
       
	$strAddQuery .= (!empty($sku) || !empty($itemID)) ? (is_array($itemID)) ? " and ( t1.item_id IN('".implode("','",$itemID)."')) " : (" and (t1.sku='" . $sku . "' or t1.item_id='" . $itemID . "')") : ("");
	//$strAddQuery .= ($itemID) ? (" and t1.sku='" . $sku . "'") : ("");
 	$strAddQuery .= ($condition) ? (" AND t1.Condition = '".$condition."' ") : ("");
	$strAddQuery .= ($WID) ? (" AND t1.WID = '".$WID."' ") : (" and t1.WID = '1' ");  //added on 3Apr2017//
        $strSQLQuery = "SELECT Sum(t1.qty) as total FROM ".$table." as t1 LEFT OUTER JOIN ".$jointable." as t2 ON t2.OrderID = t1.OrderID WHERE   t2.Module = 'Order' " . $strAddQuery . " $Cond ";
 
        return $this->query($strSQLQuery, 1);
        }

//by chetan updated for WID on 3Apr2017//
function GetPurchaseTotalQtyOnInterval($sku, $numHistory, $condition,$itemID, $WID='') {
        $strAddQuery = "";$Cond='';
        $Num = preg_replace("/[^0-9]/","",$numHistory);
        $Interval = preg_replace("/[^a-zA-Z]/","",$numHistory);
             
$checkProduct=$this->checkItemSku($sku);

						//By Chetan 9sep// 
						if(empty($checkProduct))
						{
						$arryAlias = $this->checkItemAliasSku($sku);
							if(count($arryAlias)){
									
                  $sku =$arryAlias[0]['sku'];
							}
						}


    
        
	//print_r($sku);
        $strAddQuery .= ($Interval == 'year') ? (" AND t2.OrderDate >= DATE_SUB(NOW(),INTERVAL ".$Num." YEAR)") : ("");
        $strAddQuery .= ($Interval == 'm') ? (" AND t2.OrderDate >= DATE_SUB(NOW(), INTERVAL ".$Num." MONTH)") : ("");
        $strAddQuery .= ($Interval == 'd') ? (" AND t2.OrderDate >= DATE_SUB(NOW(), INTERVAL ".$Num." DAY)") : ("");
       
	$strAddQuery .= (!empty($sku) || !empty($itemID)) ? (is_array($itemID)) ? " and ( t1.item_id IN('".implode("','",$itemID)."')) " : (" and (t1.sku='" . $sku . "' or t1.item_id='" . $itemID . "')") : ("");
	//$strAddQuery .= ($sku) ? (" and t1.sku='" . $sku . "'") : ("");
 	$strAddQuery .= ($condition) ? (" AND t1.Condition = '".$condition."' ") : ("");
	$strAddQuery .= ($WID) ? (" AND t1.WID = '".$WID."' ") : (" and t1.WID = '1' ");  //added on 3Apr2017//
        $strSQLQuery = "SELECT SUM(t1.qty_received) as total FROM p_order_item as t1 LEFT OUTER JOIN p_order as t2 ON t2.OrderID = t1.OrderID WHERE   t2.Module = 'Receipt' and t2.ReceiptStatus='Completed' " . $strAddQuery . " $Cond ";

//SELECT SUM(t1.qty_received) as total FROM p_order_item as t1 LEFT OUTER JOIN p_order as t2 ON t2.OrderID = t1.OrderID WHERE t2.Module = 'Receipt' AND t2.OrderDate >= DATE_SUB(NOW(), INTERVAL 7 DAY) and t2.ReceiptStatus='Completed' 




 
        return $this->query($strSQLQuery, 1);
        }





//By Chetan on 12Aug//5Jan 2017/8jan//11jan(added evaluationType,description,ItemID col.)//
    function KitItemsOfComponent($ItemID)
    {
        $strSQLQuery = "SELECT bm.Sku as bomSku,bm.item_id as bomItemID,ib.Primary,it.Sku as Sku,it.evaluationType as evaluationType, it.description as description,it.ItemID as ItemID FROM inv_item_bom ib right join inv_bill_of_material bm on bm.bomID = ib.bomID right join inv_items it on it.`ItemID` = bm.`item_id` where ib.item_id = '".$ItemID."'";  
        return $this->query($strSQLQuery, 1);
    }

//By chetan 14Sept. 2016//
function getExlusiveItemsCustomers()
{
	$strSQLQuery = "select distinct(i.CustomerID) CustomerID,IF(s.CustomerType = 'Company' and s.Company!='', s.Company, s.FullName) as FullName  from inv_customer_items i join s_customers s on s.Cid = i.CustomerID ";
	return $this->query($strSQLQuery, 1);
}
//End//
	function getAllinvqtyandcost(){
		$strSQLQuery = "SELECT SUM(purchase_cost *qty_on_hand) as totalCost ,COUNT(Sku) as totalItems, SUM(qty_on_hand) as totalQty ,ROUND(SUM(purchase_cost*qty_on_hand)/ SUM(qty_on_hand),2) as avgCost FROM inv_items WHERE non_inventory='yes' AND `Status`='1'  ";
		return $this->query($strSQLQuery, 1);
	}

	function getAllCatItemsQtyandCostById($Id){
		$strSQLQuery = "SELECT SUM(qty_on_hand) as totalQty, SUM(purchase_cost *qty_on_hand) as totalCost, COUNT(Sku) as totalItems, ROUND(SUM(purchase_cost*qty_on_hand)/ SUM(qty_on_hand),2) as avgCost FROM `inv_items` WHERE `CategoryID`='".$Id."' AND `Status`='1' " ;
		return $this->query($strSQLQuery, 1);
	}
		
	function InvWriteDown($arryDetails){
		extract($arryDetails);
			
		if ($ID > 0){
			$strSQLQuery = "update inv_writedown set ItemID='".$ItemID."', Sku='".$All_Items."',CategoryID='".$CategoryID."',Inv_Writedown='".$Writedown_id."',Total_Items='".$total_items."',Total_Qty='".$total_qty."',Total_Cost='".$total_cost."',avg_Cost='".$avg_cost."',Market_cost='".$Market_cost."',`Condition`='".$Condition."',Status='".$Status."' where ID='".$ID."'   " ;
		}else{
			$strSQLQuery= "insert into inv_writedown (ItemID,Sku,CategoryID,Inv_Writedown,Total_Items,Total_Qty,Total_Cost,avg_Cost,Market_cost,`Condition`,Status)
 								values ('".$ItemID."','".$All_Items."','".$CategoryID."','".$Writedown_id."','".$total_items."','".$total_qty."','".$total_cost."','".$avg_cost."','".$Market_cost."','".$Condition."','".$Status."') ";
		}
		return $this->query($strSQLQuery, 1);
	}

	function UpdateAllInvAvgCost($arryDetails){
		extract($arryDetails);
			
		if(($Writedown_id =='Items')||($Inv_Writedown =='Items') ){

			$strSQLQuery = "update inv_items set average_cost = '".$Market_cost."' where ItemID = '".$ItemID."'  " ;

		}elseif(($Writedown_id =='Group')||($Inv_Writedown =='Group') ){

			$strSQLQuery = "update inv_items set average_cost = '".$Market_cost."' where CategoryID = '".$CategoryID."'  " ;

		}elseif (($Writedown_id =='Inventory')||($Inv_Writedown =='Inventory') ){

			$strSQLQuery = "update inv_items set average_cost = '".$Market_cost."' where non_inventory = 'yes'  " ;
		}

		$this->query($strSQLQuery, 0);
		return 1;
	}

	function getAllwritedown($data){
		if(!empty($data)){
			$strSQLQuery = "select * from inv_writedown where ID ='".$data."' " ;
		}else{
			$strSQLQuery = "select * from inv_writedown " ;
		}
		return $this->query($strSQLQuery, 1);
	}

	function DelWritedownInv($delId){
		$strSQLQuery = "delete from inv_writedown  where ID ='".$delId."' ";
		return $this->query($strSQLQuery, 1);
	}

	function ChangeInvWrtDownStatus($statusID){
		$strSQLQuery = "update inv_writedown set Status = '1' where ID ='".$statusID."'  ";
		return $this->query($strSQLQuery, 1);
	}

	/*****End By Rajan for inventory writedown 14 jan 2016 **********/

function GetTransactionDetailByID($TranID,$column,$selectID,$module,$table){
			if($selectID!='' && $table!=''){
					if($column==''){	$column='*'; }
					 $strSQLQuery = "select ".$column." from $table where ".$selectID." ='".$TranID."' and Module ='".$module."' " ;
						return $this->query($strSQLQuery, 1);
			}
}

function GetTransactionItemByID($TracID,$column,$sku,$table){
			if( $table!=''){
					if($column==''){	$column='*'; }
					 $strSQLQuery = "select ".$column." from $table where sku ='".$sku."' and OrderID ='".$TracID."' " ;
						return $this->query($strSQLQuery, 1);
			}
}


function GetMaxLastId(){

$strSQLQuery = "select max(adjID+1) as MaxAutoID from inv_adjustment";
						return $this->query($strSQLQuery, 1);

}

function DelSerialNum($arryDetail){
extract($arryDetail);
$strSQLQuery = "delete from inv_serial_item  where adjustment_no ='".$AdjustID."' and Sku ='".$SerlSku."' and Status =0 ";
		return $this->query($strSQLQuery, 1);
}
function InsertTempSerial($ReceiptDate,$UnitCost,$Condition,$serialID){
extract($arryDetail);

$strSQLQuery = "update inv_serial_item set ReceiptDate = '".$ReceiptDate."',UnitCost ='".$UnitCost."',`Condition` ='".$Condition."' where serialID = '".$serialID."' and warehouse=1  " ;

						return $this->query($strSQLQuery, 1);

}

function GetAdjustmentItem($adjID) {
global $Config;
//$strAddQuery = (!empty($Config['Condition']))?(" and i.Condition='".$Config['Condition']."' "):("");
        //echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";

        $sql = "select * FROM  inv_stock_adjustment 	where	id = '" . $adjID . "' ";

        return $this->query($sql);
        
    }

function getInvSettingVariable($settingKey)
		{
			$strSQLQuery = "select setting_value from settings where setting_key ='".trim($settingKey)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
			$settingValue = $arryRow[0]['setting_value'];	
			return $settingValue;
			
		}

//by chetan 13Jan 2017//updated by chetan on 6Apr2017//
function getAllConditionofItems($itemids, $WID)
{
	$strAddQuery = (!empty($WID))?(" and WID = '".addslashes($WID)."' "):(" and WID = '1' ");
	$strSQLQuery = "select distinct(`condition`) from inv_item_quanity_condition where ItemID IN('".$itemids."')  ".$strAddQuery."";  //and WID=1//
	$row = $this->query($strSQLQuery, 1);
	return $row;
}
function getTotQtByItemIdsOnCond($Itemids,$Condi,$WID)   //added 3rd parameter by chetan on 30Mar2017//
{
	$strAddQuery = (!empty($Condi))?(" and `condition`='".addslashes($Condi)."'"):("");
	$strAddQuery.= (!empty($WID))?(" and WID = '".addslashes($WID)."' "):("and WID = '1' ");
	$strSQLQuery = "select sum(condition_qty) as condition_qty,sum(AvgCost) as AvgCost from inv_item_quanity_condition where ItemID IN('".$Itemids."')  ".$strAddQuery."  ";

//if($_GET['this']==1){ echo $strSQLQuery; }
	return $this->query($strSQLQuery, 1);

}
//End//


function getTotQtBySerial($Sku,$Condi,$WID)   //added 3rd parameter by chetan on 30Mar2017//
{
	$strAddQuery = (!empty($Condi))?(" and `Condition`='".addslashes($Condi)."'"):("");
	$strAddQuery.= (!empty($WID))?(" and warehouse = '".addslashes($WID)."' "):("and warehouse = '1' ");
	  $strSQLQuery = "select COUNT(serialID) as condition_qty from inv_serial_item where UsedSerial=0 and Status=1 and Sku ='".$Sku."' ".$strAddQuery."  ";

//if($_GET['this']==1){ echo $strSQLQuery; }
	return $this->query($strSQLQuery, 1);

}
//End//



function changeSerialStatus($serialID) {
        $sql = "select * from inv_serial_item where serialID='" . $serialID. "' ";
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['UsedSerial'] == 1) {
                $Status = 0;
                $itemType = 'Discontinue';
                $sql = "update inv_serial_item set UsedSerial='" . $Status . "' where serialID='" . $serialID. "' and warehouse='1'";
if($rs[0]['Condition']!=''){
								$updateQty ="update inv_item_quanity_condition set condition_qty=condition_qty+1 where Sku='" . $rs[0]['Sku']. "' and `condition`='" . $rs[0]['Condition']. "' and WID='1'";
}


            } else {
                $Status = 1;

                $sql = "update inv_serial_item set UsedSerial='" . $Status . "' where serialID='" . $serialID . "' and warehouse='1'";
if($rs[0]['Condition']!=''){
								$updateQty ="update inv_item_quanity_condition set condition_qty=condition_qty-1 where Sku='" . $rs[0]['Sku']. "' and `condition`='" . $rs[0]['Condition']. "' and WID='1'";
}

            }
						$this->query($updateQty, 0);
            $this->query($sql, 0);

        }


        return true;
    }

function CountInvQty($ItemID,$Condition, $WID){ //updated by chetan on 30MAr2017//

$add = ($WID) ? '  and s_order_item.WID = "'.$WID.'"  ' : ' and s_order_item.WID = 1 ' ;	
 $Sql ="SELECT IFNULL(SUM(s_order_item.qty),0) as InvQty from s_order_item as s_order_item inner join s_order as s_order on s_order_item.OrderID =s_order.OrderID WHERE 1 and s_order.Module='Invoice' and s_order_item.`Condition`='".$Condition."' and s_order_item.item_id ='".$ItemID."' and s_order.PostToGL!='1' and s_order_item.DropshipCheck='0'  ".$add." ";

$rs = $this->query($Sql);
//if($_GET['this']==1){ echo  $Sql; exit;}
//if($rs)
return $rs;

}

//update by chetan/saiyed on 21Mar2018 for optioncode check //
function GetBOMById($id,$option='') {

        $strAddQuery = ($id > 0) ? (" where item_id='" . $id."'") : (" where 1 ");
        $strSQLQuery = "select bomID,bill_option from inv_bill_of_material " . $strAddQuery;
		$rs = $this->query($strSQLQuery, 1);
		if(!empty($option)) {
		
					return (!empty($rs)) ? $rs[0]['bill_option'] : false;
		}else{		
			if(!empty($rs))
			{
				return $rs[0]['bomID'];

			}else{
				return 0;
			} 
		}

       // echo $strSQLQuery; exit;
        //return $this->query($strSQLQuery, 1);
    }


	//added by chetan on 30Aug2017//
	function MoveRecordToMasterTable(){
		$sql1 = "SELECT * from inv_items_temp".$_SESSION['AdminID']." limit 0,1";
		$data = $this->query($sql1,1);
		if($data[0]['ItemID']){
			$sqlStr = "ALTER TABLE inv_items_temp".$_SESSION['AdminID']." DROP ItemID";
			$this->query($sqlStr);
	    	$sql = "insert into inv_items select null as ItemID, inv_items_temp".$_SESSION['AdminID'].".* from inv_items_temp".$_SESSION['AdminID']."";
	    	$this->query($sql);
        //$lastInsertId = $this->lastInsertId(); 


//$sqlQuery = "SELECT * from inv_items where ItemID='".$lastInsertId ."'";
		//$ArryItemdata = $this->query($sqlQuery,1);

$sqlQuery = "SELECT * from inv_items_temp".$_SESSION['AdminID']." ";
		$ArryTemItemdata = $this->query($sqlQuery,1);



foreach($ArryTemItemdata as $value){
		if($value['Condition']!=''){
						$sqlQuery2 = "SELECT * from inv_items where Sku='".$value['Sku']."'";
						$ArryItemdata = $this->query($sqlQuery2,1);

						$strSQLQuery = "insert into inv_item_quanity_condition(ItemID,WID,`condition`,Sku,SalePrice) 
						values ('" . addslashes($ArryItemdata[0]['ItemID']) . "','1','".addslashes($ArryItemdata[0]['Condition']). "','" . addslashes($ArryItemdata[0]['Sku']) . "','" . addslashes($ArryItemdata[0]['sell_price']). "')";

						$this->query($strSQLQuery, 0);

		}
}



		}
		$this->DropTempTableForImport();
    	}
    
	function CreateTempTableForImport(){
		$this->DropTempTableForImport();
	    	$sql = "CREATE TABLE inv_items_temp".$_SESSION['AdminID']." like inv_items";
	    	$this->query($sql);
    	}
    
    
	function DropTempTableForImport(){
		if($this->numRows($this->query("SHOW TABLES LIKE 'inv_items_temp".$_SESSION['AdminID']."'"))==1){
	    	$sql = "DROP TABLE inv_items_temp".$_SESSION['AdminID']."";
	    	$this->query($sql);
		}
    	}
    
	function CountForImport(){
		if($this->numRows($this->query("SHOW TABLES LIKE 'inv_items_temp".$_SESSION['AdminID']."'"))==1){
	    	$sql = "SELECT count(*) count from inv_items_temp".$_SESSION['AdminID']."";
	    	$count = $this->query($sql,1);
	    	return $c = ($count[0]['count']>0)?$count[0]['count']:0; 
		}else{
			return false;
		}
    	}

	function importToTemp($arryDetails)
	{
		extract($arryDetails);
		if ($itemType == "Discontinue") {
		    $Status = 0;
		}

		$strSQLQuery = "insert into inv_items_temp".$_SESSION['AdminID']." (description,procurement_method,CategoryID,evaluationType ,itemType,non_inventory,UnitMeasure,min_stock_alert_level,max_stock_alert_level,purchase_tax_rate,sale_tax_rate,Status, AddedDate, Sku,item_alias, sell_price, qty_on_hand, long_description,Model,Generation,`Condition`,Extended,Manufacture,ReorderLevel,is_exclusive,Reorderlabelbox) 
		values ('" . addslashes($description) . "','" . addslashes($procurment) . "','" . $CategoryID . "' ,'" . addslashes($evaluationType) . "','" . addslashes($itemType) . "','" . $non_inventory . "','" . addslashes($UnitMeasure) . "',
		'" . addslashes($min_stock_alert_level) . "','" . addslashes($max_stock_alert_level) . "',
		'" . addslashes($purchase_tax_rate) . "','" . addslashes($sale_tax_rate) . "',
		'" . $Status . "','" . date('Y-m-d') . "','" . addslashes($Sku) . "','" . addslashes($item_alias) . "' , '" . addslashes($sell_price) . "', '" . addslashes($qty_on_hand) . "', '" . addslashes($long_description) . "', '" . addslashes($Model_type) . "', '" . addslashes($Generation_type) . "', '" . addslashes($Condition) . "', '" . addslashes($Extended) . "', '" . addslashes($Manufacture) . "','" . addslashes($ReorderLevel) . "','" . addslashes($is_exclusive) . "','".addslashes($Reorderlabelbox)."')";

		$this->query($strSQLQuery, 0);
		$lastInsertId = $this->lastInsertId();   
		
		return $lastInsertId;

	}
	//End//

function BinLocationByWarehouse($WID){

 $strAddQuery = (" where warehouse_id='" . $WID."'");
        $strSQLQuery = "select * from w_binlocation " . $strAddQuery;
       
return $this->query($strSQLQuery, 1);

}

function GetonHandQty($Sku){
$strAddQuery = (!empty($Sku))?(" and Sku = '".addslashes($Sku)."' "):("  ");
	$strSQLQuery = "select q.*,c1.valuationType as evaluationType from inv_item_quanity_condition q left outer join inv_items p1 on p1.ItemID =q.itemID left outer join inv_categories c1 on c1.CategoryID =p1.CategoryID order by ID desc";  //and WID=1//
	$row = $this->query($strSQLQuery, 1);
	return $row;

}


function UpdateTotQtBySerial($Sku,$Condition,$WID,$Qty){

$strAddQuery = (!empty($WID))?(" and WID = '".addslashes($WID)."' "):(" and WID = '1' ");
 $updateQty ="update inv_item_quanity_condition set condition_qty='".$Qty."' where Sku='" . $Sku. "' and `condition`='" .$Condition. "' ".$strAddQuery."";
$this->query($updateQty, 0);
return 1;

}


function GetSerialValuationReport($FilterBy,$FromDate,$ToDate,$Month,$Year,$valuationType){

$strAddQuery = "";

	if($FilterBy=='Year'){
			$strAddQuery .= " and YEAR(ReceiptDate)='".$Year."'";
		}else if($FilterBy=='Month'){
			$strAddQuery .= " and MONTH(ReceiptDate)='".$Month."' and YEAR(ReceiptDate)='".$Year."'";
		}else{
			//$strAddQuery .= (!empty($FromDate))?(" and t.TransactionDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and (ReceiptDate <='".$ToDate."'  )"):("  ");
		}


$strAddQuery .= (!empty($key['Condition']))?(" and `Condition`='".$key['Condition']."' "):("");
//$strAddQuery .= (!empty($key['WID']))?(" and `warehouse`='".$key['WID']."' "):(" and `warehouse`='1' ");
$strAddQuery .= (!empty($key['binid']))?(" and `binid`='".$key['binid']."' "):("");
$strAddQuery .= (!empty($key['Sku']))?(" and Sku='".$key['Sku']."' "):("");
  $Sql2 = "select count(Sku) as srQt ,SUM(UnitCost) as conAmt,Sku,ReceiptDate  from inv_serial_item where 1 and Status=1    ".$strAddQuery." group by Sku";



$rs2 =  $this->query($Sql2, 1);

return $rs2;

}

function getSerailValuationTotAmount($FilterBy,$FromDate,$ToDate,$Month,$Year)
		{
			
	$strAddQuery = "";

	if($FilterBy=='Year'){
			$strAddQuery .= " and YEAR(ReceiptDate)='".$Year."'";
		}else if($FilterBy=='Month'){
			$strAddQuery .= " and MONTH(ReceiptDate)='".$Month."' and YEAR(ReceiptDate)='".$Year."'";
		}else{
			//$strAddQuery .= (!empty($FromDate))?(" and t.TransactionDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and (ReceiptDate <='".$ToDate."'  )"):("  ");
		}


			/*$strAddQuery .= (!empty($key['Condition']))?(" and t.TranCondition='".$key['Condition']."' "):("");
      $strAddQuery .= (!empty($key['key']))?(" and t.TransactionSku='".$key['key']."' "):("");
			$strAddQuery .= (!empty($item_id)) ? (" and t.TransactionItemID='" . $item_id . "'") : ("");*/
			//$strAddQuery .= (!empty($valuationType))?(" and c.valuationType='".$valuationType."' "):("");

			
		 $Sql2 = "select count(Sku) as srQt ,SUM(UnitCost) as conAmt,Sku,ReceiptDate  from inv_serial_item where 1 and Status=1   ".$strAddQuery." group by Sku";
			#echo $strSQLQuery;exit;
			$rs2 = $this->query($Sql2, 1);
			
		$TotCost=0;$toQty=0;
foreach($rs2 as $values){
	$frCost = 0;

	$TotCost += $values['conAmt']+$frCost;
	$toQty +=$values['srQt']; 
}
			
			
		    return $TotCost;	
		
		}


}


?>
