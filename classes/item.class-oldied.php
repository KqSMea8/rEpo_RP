<?

class items extends dbClass {

    //constructor
    function items() {
        $this->dbClass();
    }

    function GetItems($id = 0, $CategoryID, $Status, $shortby) {

        $strSQLQuery = "select p1.*,c1.ParentID from inv_items p1 left outer join inv_categories c1 on p1.CategoryID = c1.CategoryID";
        $strSQLQuery .= ($Status > 0) ? (" and p1.Status=" . $Status . " and c1.Status=" . $Status) : (" and p1.Status=1 and c1.Status=1 ");
        $strSQLQuery .= (!empty($id)) ? (" where p1.ItemID=" . $id) : (" where 1 ");
        $strSQLQuery .= (!empty($CategoryID)) ? (" and p1.CategoryID=" . $CategoryID) : ("");
        //$strSQLQuery .= (!empty($Mfg))?(" and p1.Mid=".$Mfg):("");
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

    function GetItemById($id) {

        $strAddQuery = ($id > 0) ? (" where p1.ItemID=" . $id) : (" where 1 ");
        $strSQLQuery = "select p1.*,c1.ParentID from inv_items p1 left outer join inv_categories c1 on p1.CategoryID = c1.CategoryID " . $strAddQuery;
        ;


        //echo $strSQLQuery; exit;
        return $this->query($strSQLQuery, 1);
    }

    function GetItemsView($arryDetails) {

        extract($arryDetails);

        $strAddQuery = ' where 1 ';
        $SearchKey = strtolower(trim($key));
        $strAddQuery .= ($ItemID > 0) ? (" and p1.ItemID='" . $ItemID."'") : ("");
        $strAddQuery .= ($CatID > 0) ? (" and p1.CategoryID='".$CatID."'") : ("");
        $strAddQuery .= ($finish != '') ? (" and p1.itemType='".$finish."'") : ("");
        $strAddQuery .= (!empty($kit)) ? (" and p1.itemType='" . $kit . "'") : ("");
        $strAddQuery .= ($proc != '') ? (" and p1.procurement_method like '%" . $proc . "%'") : ("");

        $strAddQuery .= ($Status > 0) ? (" and p1.Status=" . $Status) : ("");

        if ($SearchKey == 'active' && ($sortby == 'p1.Status' || $sortby == '')) {
            $strAddQuery .= " and p1.Status=1";
        } else if ($SearchKey == 'inactive' && ($sortby == 'p1.Status' || $sortby == '')) {
            $strAddQuery .= " and p1.Status=0";
        
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

    function GetPriceRange() {
        $strSQLQuery = 'select * from price_refine order by id asc';
        return $this->query($strSQLQuery, 1);
    }

    function SearchItemsCat($id = 0, $CategoryIDs, $Status, $key, $state_id, $PostedByID, $Bidding) {
        $strSQLQuery = "select p1.*,if(p1.CategoryID>0,c1.Name,'') as CategoryName,c1.ParentID,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName,m1.Website,m1.MembershipID,m1.CreditCard from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join inv_categories c1 on p1.CategoryID = c1.CategoryID ";

        $strSQLQuery .= ($CategoryIDs > 0) ? (" where (p1.CategoryID =" . $CategoryIDs . " or c1.ParentID = " . $CategoryIDs . ")") : (" where 1 ");

        $strSQLQuery .= ($PostedByID > 0) ? (" and p1.PostedByID=" . $PostedByID) : ("");

        $strSQLQuery .= ($Status > 0) ? (" and p1.Status=" . $Status . " and c1.Status=" . $Status . " and m1.Status=" . $Status . " ") : ("");

        $strSQLQuery .= (!empty($key)) ? (" and (p1.SearchTag LIKE '%" . $key . "%' OR p1.Name LIKE '%" . $key . "%' OR p1.ProductSku LIKE '%" . $key . "%')") : ("");

        $strSQLQuery .= ($state_id > 0) ? (" and m1.state_id=" . $state_id) : ("");

        $strSQLQuery .= ($Bidding == 'Auction') ? (" and p1.Bidding='" . $Bidding . "'") : ("");

        $strSQLQuery .= ' order by p1.Name asc ';

        return $this->query($strSQLQuery, 1);
    }

    function GetNewItems($CategoryID, $PostedByID, $Limit) {
        $strSQLQuery = "select p1.*,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join inv_categories c1 on p1.CategoryID = c1.CategoryID ";

        $strSQLQuery .= "where 1";

        $strSQLQuery .= ($PostedByID > 0) ? (" and p1.PostedByID=" . $PostedByID . " and c1.StoreID=" . $PostedByID) : ("");
        $strSQLQuery .= ($CategoryID > 0) ? (" and p1.CategoryID=" . $CategoryID) : ("");

        $Status = 1;
        $strSQLQuery .= ($Status > 0) ? (" and p1.Status=" . $Status . " and c1.Status=" . $Status . " and m1.Status=" . $Status . " ") : ("");


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

        $strSQLQuery = "select p1.* from inv_items p1 inner join inv_categories c1 on p1.CategoryID = c1.CategoryID where p1.Status=1 and c1.Status=1 " . $strSQLFeaturedQuery . "   order by rand() Desc LIMIT 0,9";
        return $this->query($strSQLQuery, 1);
    }

    function checkItemSku($Sku) {
        $strSQLQuery = "select * from inv_items where Sku = " . $Sku;
        return $this->query($strSQLQuery, 1);
    }

    function GetItemSku($ItemID) {
        $strSQLQuery = "select Sku from inv_items where ItemID = '".$ItemID."'";
        $row = $this->query($strSQLQuery, 1);
        return $row[0]['Sku'];
    }

    function AddItem($arryDetails) {

        extract($arryDetails);
        if ($CategoryID > 0) {
            $strUpdateQuery = "update inv_categories set NumProducts = NumProducts + 1 where CategoryID = '" . $CategoryID . "'";
            $this->query($strUpdateQuery, 0);
        }


	if($itemType =="Discontinue"){ $Status =0; }


        $procurment = implode(', ', $procurement_method);
        $strSQLQuery = "insert into inv_items (description,procurement_method,CategoryID,evaluationType ,itemType,non_inventory,UnitMeasure,min_stock_alert_level,max_stock_alert_level,purchase_tax_rate,sale_tax_rate,Status, AddedDate, Sku,item_alias, sell_price, qty_on_hand, long_description,Model,Generation,`Condition`,Extended,Manufacture) 
                         values ('" . addslashes($description) . "','" . addslashes($procurment) . "','" . $CategoryID . "' ,'" . addslashes($evaluationType) . "','" . addslashes($itemType) . "','".$non_inventory."','" . addslashes($UnitMeasure) . "',
                        '" . addslashes($min_stock_alert_level) . "','" . addslashes($max_stock_alert_level) . "',
                        '" . addslashes($purchase_tax_rate) . "','" . addslashes($sale_tax_rate) . "',
                         '" . $Status . "','" . date('Y-m-d') . "','" . addslashes($Sku) . "','" . addslashes($item_alias) . "' , '" . addslashes($sell_price) . "', '" . addslashes($qty_on_hand) . "', '" . addslashes($long_description) . "', '" . addslashes($Model) . "', '" . addslashes($Generation) . "', '" . addslashes($Condition) . "', '" . addslashes($Extended) . "', '" . addslashes($Manufacture) . "')";


        $this->query($strSQLQuery, 0);
        $lastInsertId = $this->lastInsertId();

        /* if($lastInsertId>0){
          $code="ITM000".$lastInsertId;
          $sql="update inv_items set Sku='".$code."' where ItemID=".$lastInsertId;
          $this->query($sql,0);

          } */

        return $lastInsertId;
    }

    function changeItemStatus($ItemID) {
        $sql = "select * from inv_items where ItemID=" . $ItemID;
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 1){
              $Status = 0;
              $itemType = 'Discontinue';
         $sql = "update inv_items set Status='".$Status."',itemType ='".$itemType."' where ItemID=" . $ItemID;
           } else{
                $Status = 1;

            $sql = "update inv_items set Status='".$Status."' where ItemID='".$ItemID."'";
           }
            $this->query($sql, 0);
        }


        if ($Status == 1 && $rs[0]['Status'] != 1 && $rs[0]['PostedByID'] > 1) {
            $this->ItemActiveEmail($ItemID);
        }

        return true;
    }

    function MultipleItemStatus($ItemID, $Status) {
        $sql = "select * from inv_items where ItemID in (" . $ItemID . ") and Status!=" . $Status;
        $arryRow = $this->query($sql);
        if (sizeof($arryRow) > 0) {

            $sql = "update inv_items set Status=" . $Status . " where ItemID in (" . $ItemID . ")";
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
        $sql = "select * from inv_items where ItemID=" . $ItemID;
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['itemType'] == 'Discontinue')
                $Featured = 'No';
            else
                $Featured = 'Yes';

            $sql = "update inv_items set Featured='$Featured' where ItemID=" . $ItemID;
            $this->query($sql, 0);
            return true;
        }
    }

    function UpdateViewedDate($ItemID) {
        $sql = "update inv_items set ViewedDate='" . date('Y-m-d') . "' where ItemID=" . $ItemID;
        $this->query($sql, 0);
        return true;
    }

    function FeaturedDisabled($ItemID) {

        $sql = "update inv_items set Featured='No',FeaturedType='',Impression='0',ImpressionCount='0',  FeaturedStart='',FeaturedEnd=''   where ItemID in(" . $ItemID . ")";
        $this->query($sql, 0);
        return true;
    }

    function UpdateImage($imageName, $ItemID) {
        $strSQLQuery = "update inv_items set Image='" . $imageName . "' where ItemID='" . $ItemID."'"; 
        return $this->query($strSQLQuery, 0);
    }

    function UpdateBasic($arryDetails) {

        extract($arryDetails);
        $procurment = implode(',', $procurement_method);

//if($itemType =="Discontinue"){ $Status =0; }

   $strSQLQuery = "update inv_items set CategoryID = '" . $CategoryID . "',
					description='" . mysql_real_escape_string ($description) . "',
					non_inventory = '".$non_inventory."',
					procurement_method='" . $procurment . "',
					evaluationType='" . mysql_real_escape_string ($evaluationType) . "',
					itemType='" . mysql_real_escape_string ($itemType) . "',
					UnitMeasure='" . mysql_real_escape_string ($UnitMeasure) . "',
					min_stock_alert_level='" . $min_stock_alert_level . "' ,
					max_stock_alert_level='" . $max_stock_alert_level . "',
					purchase_tax_rate='" . $purchase_tax_rate . "',
					sale_tax_rate='" . $sale_tax_rate . "', 
					Status='" . $Status . "',
					item_alias='" . mysql_real_escape_string ($item_alias) . "',
					LastAdminType='".$_SESSION['AdminType']."',
					LastCreatedBy='".$_SESSION['DisplayName']."',
					Model = '".addslashes($Model)."',
					Generation = '".mysql_real_escape_string($Generation)."',
					`Condition` = '".mysql_real_escape_string ($Condition)."',
					Extended = '".mysql_real_escape_string ($Extended)."',
					Manufacture = '".mysql_real_escape_string ($Manufacture)."' 
					where ItemID='" . $ItemID."'"; 

        $this->query($strSQLQuery, 0);

       

        return 1;
    }


 function UpdateItemOther($arryDetails) {

        extract($arryDetails);

        $strSQLQuery = "update inv_items set description='" . addslashes($description) . "', long_description='" . addslashes($long_description) . "', Status='" . $Status . "',sell_price='" . addslashes($sell_price) . "',qty_on_hand='" . addslashes($qty_on_hand) . "', LastAdminType='".$_SESSION['AdminType']."',LastCreatedBy='".$_SESSION['DisplayName']."' where ItemID=" . $ItemID;

        $this->query($strSQLQuery, 0);     


        return 1;
    }



    function UpdateSuplier($arryDetails) {

        extract($arryDetails);

        //print_r($arryDetails); exit;



        $strSQLQuery = "update inv_items set SuppCode='" . $SuppCode . "' , LastAdminType='".$_SESSION['AdminType']."',LastCreatedBy='".$_SESSION['DisplayName']."' where ItemID=" . $ItemID;

        $this->query($strSQLQuery, 0);

        return 1;
    }

    function UpdatePrice($arryDetails) {
            global $Config;
        extract($arryDetails);
		
		$SelectQuery="select purchase_cost,sell_price from inv_items where ItemID='" . $ItemID."'";
		$rs = $this->query($SelectQuery);
        if (sizeof($rs)) {
				if ($rs[0]['purchase_cost'] != $purchase_cost){
				
				$oldPurchaseCost=$rs[0]['purchase_cost'];
				//$notify=1;
				}
				
				if ($rs[0]['sell_price'] != $sell_price){
					 //$notify=2;
					$oldSaleCost=$rs[0]['sell_price'];
				}

        }

         $strSQLQuery = "update inv_items set average_cost='" . $average_cost . "',last_cost='" . $oldPurchaseCost . "', purchase_cost='" . $purchase_cost . "', sell_price='" . $sell_price . "', LastAdminType='".$_SESSION['AdminType']."',LastCreatedBy='".$_SESSION['DisplayName']."' where ItemID='" . $ItemID."'";
       $this->query($strSQLQuery, 0);
           
		

        return 1;
    }
	
	function PriceNotification($arryDetails){
		 global $Config;
           extract($arryDetails);
		   $department= $Config['DepID']; 
		   $SelectQuery="select description,purchase_cost,sell_price from inv_items where ItemID='" . $ItemID."'";
			$rs = $this->query($SelectQuery);
			if (sizeof($rs)) {
				if ($rs[0]['purchase_cost'] != $purchase_cost){
				
				$oldPurchaseCost=$rs[0]['purchase_cost'];
				 $notify=1; 
				} 
				
				if ($rs[0]['sell_price'] != $sell_price){
					 $notify2=2; 
					$oldSaleCost=$rs[0]['sell_price'];
				}

        }


		 if($notify==1 ){
           /********************************/
		   
 
		  $arryItem = $this->GetItemById($ItemID);
				if($_SESSION['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
				}else{
					$CreatedBy = $_SESSION['UserName'];
				}
				 /** Notification **/
			   $arryNotification['refID'] = $Sku;
			   $arryNotification['refType'] = "PurchaseCost";
			   $arryNotification['Name'] = $rs[0]['description'];
			   $arryNotification['Subject'] = "Change Purchase cost for [SKU:".$Sku."]";
			   $arryNotification['Message'] = 'Purchase cost for Item:'.$rs[0]['description'].' [SKU:'.$Sku.'] has been changed from '.$Config['Currency'].' '.$oldPurchaseCost.' to '.$Config['Currency'].' '.$purchase_cost.'';
			   $objConfigure=new configure();
			   #print_r($arryNotification); exit;
			   $objConfigure->AddNotification($arryNotification);
               /*******************/
				
				/*
				$strSQLQuery = "insert into notification (refID,old_value,new_value,department,notifyDate,locationID,RefType,AdminID,AdminType,CreatedBy,Currency)  values ('" . $Sku. "','" . $oldPurchaseCost . "','" . $purchase_cost . "','".$department."','" .date('d:m:y h:i:s'). "','".$_SESSION['locationID']."','PurchaseCost','".$_SESSION['AdminID']."','".$_SESSION['AdminType']."','".$_SESSION['UserName']."','".$Config['Currency']."')";
                $this->query($strSQLQuery, 0); 		     
				
				$UpdateDate = date($Config['DateFormat'], strtotime($Config['TodayDate']));
			
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."price_notify_admin.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
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
		if( $notify2==2){
           /********************************/
		   $arryItem = $this->GetItemById($ItemID);
				if($_SESSION['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
				}else{
					$CreatedBy = $_SESSION['UserName'];
				}

			   $arryNotification['refID'] = $Sku;
			   $arryNotification['refType'] = "saleCost";
			   $arryNotification['Name'] = $rs[0]['description'];
			   $arryNotification['Subject'] = "Change Sales cost for [SKU:".$Sku."]";
			   $arryNotification['Message'] = 'Sales cost for Item:'.$rs[0]['description'].' [SKU:'.$Sku.'] has been changed from '.$Config['Currency'].' '.$oldSaleCost.' to '.$Config['Currency'].' '.$sell_price.'';
			   $objConfigure=new configure();
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
	
	


	function PriceNotification555($arryDetails){
		 global $Config;
           extract($arryDetails);
		   $department= $Config['DepID']; 
		   $SelectQuery="select purchase_cost,sell_price from inv_items where ItemID='" . $ItemID."'";
			$rs = $this->query($SelectQuery);
			if (sizeof($rs)) {
				if ($rs[0]['purchase_cost'] != $purchase_cost){
				
				$oldPurchaseCost=$rs[0]['purchase_cost'];
				 $notify=1; 
				} 
				
				if ($rs[0]['sell_price'] != $sell_price){
					 $notify2=2; 
					$oldSaleCost=$rs[0]['sell_price'];
				}

        }


		 if($notify==1 ){
           /********************************/
		   

		  $arryItem = $this->GetItemById($ItemID);
				if($_SESSION['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
				}else{
					$CreatedBy = $_SESSION['UserName'];
				}
				#echo $Config['DepID']; exit;
			 $strSQLQuery = "insert into notification (refID,old_value,new_value,department,notifyDate,locationID,RefType,AdminID,AdminType,CreatedBy,Currency)  values ('" . $Sku. "','" . $oldPurchaseCost . "','" . $purchase_cost . "','".$department."','" .date('d:m:y h:i:s'). "','".$_SESSION['locationID']."','PurchaseCost','".$_SESSION['AdminID']."','".$_SESSION['AdminType']."','".$_SESSION['UserName']."','".$Config['Currency']."')";
              $this->query($strSQLQuery, 0); 
			  


		     
				
				$UpdateDate = date($Config['DateFormat'], strtotime($Config['TodayDate']));
				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."price_notify_admin.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
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

		}
		if( $notify2==2){
           /********************************/
		   $arryItem = $this->GetItemById($ItemID);
				if($_SESSION['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
				}else{
					$CreatedBy = $_SESSION['UserName'];
				}

			 $strSQLQuery = "insert into notification (refID,old_value,new_value,department,notifyDate,locationID,RefType,AdminID,AdminType,CreatedBy,Currency)  values ('" . $Sku. "','" . $oldSaleCost . "','" . $purchase_cost . "','".$department."','" .date('d:m:y h:i:s'). "','".$_SESSION['locationID']."','saleCost','".$_SESSION['AdminID']."','".$_SESSION['AdminType']."','".$_SESSION['UserName']."','".$Config['Currency']."')";
              $this->query($strSQLQuery, 0);
			  


		       
				
				$UpdateDate = date($Config['DateFormat'], strtotime($Config['TodayDate']));
				/**********************/
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

		}
     return 1;
	}
	
	function UpdateQuantity($arryDetails) {

        extract($arryDetails);

        $strSQLQuery = "update inv_items set allocated_qty='" . $allocated_qty . "',qty_on_demand='" . $qty_on_demand . "' where ItemID=" . $ItemID;


        $this->query($strSQLQuery, 0);

        return 1;
    }

    function UpdateDimensions($arryDetails) {
        extract($arryDetails);


        $strSQLQuery = "update inv_items set pack_size='" . addslashes($pack_size) . "',weight='" . addslashes($weight) . "',width='" . addslashes($width) . "',height='" . addslashes($height) . "',depth='" . addslashes($depth) . "' where ItemID=" . $ItemID;

        $this->query($strSQLQuery, 0);

        return 1;
    }

    function UpdateSeo($arryDetails) {


        extract($arryDetails);


        $strSQLQuery = "update inv_items set MetaTitle='" . addslashes($MetaTitle) . "',MetaKeywords='" . addslashes($MetaKeywords) . "',MetaDescription = '" . addslashes($MetaDescription) . "',UrlCustom = '" . $UrlCustom . "'  where ItemID=" . $ItemID;

        $this->query($strSQLQuery, 0);

        return 1;
    }

    function UpdateInventory($arryDetails) {


        extract($arryDetails);


        $strSQLQuery = "update inv_items set Quantity='" . addslashes($Quantity) . "',InventoryControl='" . addslashes($InventoryControl) . "',InventoryRule = '" . $InventoryRule . "',StockWarning = '" . $StockWarning . "' where ItemID=" . $ItemID;

        $this->query($strSQLQuery, 0);

        return 1;
    }

    /*     * ***********************************Attribute Function Start***************************************************************** */

    function parseOptions($options) {
        return explode("\n", $options);
    }

    function InsertAttributes($arryDetails) {

        extract($arryDetails);

        $is_active = isset($is_active) ? $is_active : "No";

        $parsed_options = explode("\n", $options);

        foreach ($parsed_options as $option) {
            if (preg_match("/^.+\(\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?)\s*((\,\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?))?)\s*\)\s*$/", $option)) {
                $is_modifier = true;
            }
        }


        $is_modifierVal = isset($is_modifier) ? "Yes" : "No";

        $strSQLQuery = "Insert into inv_items_attributes set attribute_type='" . trim($attribute_type) . "',pid='" . trim($ItemID) . "',gaid='0', is_modifier = '" . $is_modifierVal . "', is_active='" . trim($is_active) . "',priority='" . trim($priority) . "',name='" . trim($attname) . "',caption='" . trim($caption) . "',options='" . trim($options) . "'";
        $this->query($strSQLQuery, 0);
        if ($ItemID > 0) {
            $attributes_countVal = 0;
            $sqlAttrVal = mysql_query("select AttributesCount from inv_items where ItemID=" . $ItemID);
            $attributes_countRow = mysql_fetch_array($sqlAttrVal);
            $attributes_countVal = $attributes_countRow['AttributesCount'];
            $attributes_countVal = $attributes_countVal + 1;
            $strSQLQueryAttr = "update inv_items set AttributesCount=" . $attributes_countVal . " where ItemID=" . $ItemID;
            $this->query($strSQLQueryAttr, 0);
        }
        return 1;
    }

    function UpdateAttributes($arryDetails) {

        extract($arryDetails);
        $is_active = isset($is_active) ? $is_active : "No";

        $parsed_options = explode("\n", $options);

        foreach ($parsed_options as $option) {
            if (preg_match("/^.+\(\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?)\s*((\,\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?))?)\s*\)\s*$/", $option)) {
                $is_modifier = true;
            }
        }


        $is_modifierVal = isset($is_modifier) ? "Yes" : "No";

        $strSQLQuery = "update inv_items_attributes set attribute_type='" . trim($attribute_type) . "',gaid='0', is_modifier = '" . $is_modifierVal . "', is_active='" . trim($is_active) . "',priority='" . trim($priority) . "',name='" . trim($attname) . "',caption='" . trim($caption) . "',options='" . trim($options) . "' where paid = '" . $AttributeId . "' and pid=" . $ItemID;
        $this->query($strSQLQuery, 0);
        return 1;
    }

    function GetAttributeByID($attId) {

        $strSQLQuery = "select * from inv_items_attributes where paid = " . $attId;
        return $this->query($strSQLQuery, 1);
    }

    function GetItemAttributes($ItemID) {

        $strSQLQuery = "Select * from inv_items_attributes where pid=" . $ItemID;
        return $this->query($strSQLQuery, 1);
    }

    function GetItemAttributesForFront($ItemID) {

        $strSQLQuery = "Select * from inv_items_attributes where pid=" . $ItemID . " AND is_active='Yes'";
        return $this->query($strSQLQuery, 1);
    }

    function deleteAttribute($pid, $attributeId) {
        $strSQLQuery = "delete from inv_items_attributes where paid=" . $attributeId . " and pid=" . $pid;
        $this->query($strSQLQuery, 0);

        $sqlAttrVal = mysql_query("select AttributesCount from inv_items where ItemID=" . $pid);
        $attributes_countRow = mysql_fetch_array($sqlAttrVal);
        $attributes_countVal = $attributes_countRow['AttributesCount'];
        $attributes_countVal = $attributes_countVal - 1;
        $strSQLQueryAttr = "update inv_items set AttributesCount=" . $attributes_countVal . " where ItemID=" . $pid;
        $this->query($strSQLQueryAttr, 0);
        return 1;
    }

    /************************************Attribute Function End***************************************************************** */

    /************************************Discount Function Start******************************************************************/

    function InsertDiscount($arryDetails) {

        extract($arryDetails);
        $is_active = isset($is_active) ? $is_active : "No";
        $strSQLQuery = "Insert into e_products_quantity_discounts set range_min='" . trim($range_min) . "',range_max = '" . $range_max . "',pid='" . trim($ItemID) . "',is_active='" . trim($is_active) . "',discount='" . trim($discount) . "',discount_type='" . trim($discount_type) . "',customer_type='" . trim($customer_type) . "'";
        $this->query($strSQLQuery, 0);

        return 1;
    }

    function GetItemDiscount($ItemID) {

        $strSQLQuery = "Select * from e_products_quantity_discounts where pid=" . $ItemID;
        return $this->query($strSQLQuery, 1);
    }

    function GetDiscountByID($disID) {

        $strSQLQuery = "select * from e_products_quantity_discounts where qd_id = " . $disID;
        return $this->query($strSQLQuery, 1);
    }

    function UpdateDiscount($arryDetails) {

        extract($arryDetails);
        $is_active = isset($is_active) ? $is_active : "No";
        $strSQLQuery = "update e_products_quantity_discounts set range_min='" . trim($range_min) . "',range_max = '" . $range_max . "',is_active='" . trim($is_active) . "',discount='" . trim($discount) . "',discount_type='" . trim($discount_type) . "',customer_type='" . trim($customer_type) . "' where qd_id = '" . $DiscountId . "' and pid=" . $ItemID;
        $this->query($strSQLQuery, 0);
        return 1;
    }

    function deleteDiscount($pid, $discId) {
        $strSQLQuery = "delete from e_products_quantity_discounts where qd_id=" . $discId . " and pid=" . $pid;
        $this->query($strSQLQuery, 0);
        return 1;
    }

    /************************************Discount Function End******************************************************************/

    function SendEmailToAdmin($ItemID) {

        $arryProduct = $this->GetItems($ItemID, 0, 0, 0);

        if ($arryProduct[0]['PostedByID'] > 0) {
            $contents = file_get_contents("html/newproduct.htm");
            global $Config;
            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);


            $contents = str_replace("[FULLNAME]", $_SESSION['Name'], $contents);
            $contents = str_replace("[USERNAME]", $_SESSION['UserName'], $contents);
            $contents = str_replace("[POSTED_FOR]", $arryProduct[0]['PostedFor'], $contents);
            $contents = str_replace("[PRODUCTNAME]", stripslashes($arryProduct[0]['Name']), $contents);
            $contents = str_replace("[DESCRIPTION]", nl2br(stripslashes($arryProduct[0]['Detail'])), $contents);
            $contents = str_replace("[PRICE]", $arryProduct[0]['Price'], $contents);
            $contents = str_replace("[QUANTITY]", $arryProduct[0]['Quantity'], $contents);
            $contents = str_replace("[Type]", $arryProduct[0]['Bidding'], $contents);

            if ($arryProduct[0]['Image'] != "") {
                $ImageDestination = $Config['Url'] . "upload/items/images/" . $arryProduct[0]['Image'];
            } else {
                $ImageDestination = $Config['Url'] . "images/no-image.jpg";
            }

            $contents = str_replace("[IMAGE]", $ImageDestination, $contents);
            $contents = str_replace("[ACTIVATE_URL]", $Config['Url'] . 'admin/editProduct.php?edit=' . $ItemID, $contents);


            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($Config['AdminEmail']);
            $mail->sender($_SESSION['Name'], $_SESSION['Email']);
            $mail->Subject = $Config['SiteName'] . " - New product has been posted ";
            $mail->IsHTML(true);

            //echo $Config['AdminEmail'].$_SESSION['Email'].$contents; exit;

            $mail->Body = $contents;
            if ($Config['DbUser'] != 'root') {
                $mail->Send();
            }
        }

        return 1;
    }

    function ItemActiveEmail($ItemID) {

        $arryProduct = $this->GetItems($ItemID, 0, 0, 0);

        if ($arryProduct[0]['PostedByID'] > 0) {
            $contents = file_get_contents("../html/activeproduct.htm");
            global $Config;
            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);


            $contents = str_replace("[USERNAME]", stripslashes($arryProduct[0]['UserName']), $contents);
            $contents = str_replace("[DATE]", date("jS, F Y"), $contents);

            $contents = str_replace("[PRODUCTNAME]", stripslashes($arryProduct[0]['Name']), $contents);
            $contents = str_replace("[DESCRIPTION]", nl2br(stripslashes($arryProduct[0]['Detail'])), $contents);
            $contents = str_replace("[Type]", $arryProduct[0]['Bidding'], $contents);

            if ($arryProduct[0]['Image'] != "") {
                $ImageDestination = $Config['Url'] . "upload/items/images/" . $arryProduct[0]['Image'];
            } else {
                $ImageDestination = $Config['Url'] . "images/no-image.jpg";
            }

            $contents = str_replace("[IMAGE]", $ImageDestination, $contents);


            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($arryProduct[0]['Email']);
            $mail->sender($Config['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . " - Your product posting has been approved ";
            $mail->IsHTML(true);

            //echo $Config['AdminEmail'].$arryProduct[0]['Email'].$contents; exit;

            $mail->Body = $contents;
            if ($Config['DbUser'] != 'root') {
                $mail->Send();
            }
        }

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

        $strSQLQuery = "INSERT INTO inv_item_images set  ItemID=" . $imageId . ", Image='" . $imageName . "', alt_text='" . $alt_text . "'";

        return $this->query($strSQLQuery, 0);
    }

    function GetTotalImagesCount($ItemID) {

        $strSQLQuery = "select count(Iid) as total from inv_item_images where ItemID='" . $ItemID . "'";
        return $this->query($strSQLQuery, 1);
    }

    function GetAlternativeImage($ItemID) {

        $strSQLQuery = "Select * from inv_item_images where ItemID='" .$ItemID."'";
        return $this->query($strSQLQuery, 1);
    }

    function deleteImage($pid, $imageId) {
        $select = mysql_query("select Image from inv_item_images where Iid = '" . $imageId . "' and ItemID=" . $pid . "");
        $image = mysql_fetch_array($select);
        $ImgDir = 'upload/items/images/secondary/'.$_SESSION['CmpID'].'/';
        unlink($ImgDir . $image['Image']);
        $strSQLQuery = "delete from inv_item_images where Iid = '" . $imageId . "' and ItemID='".$pid."'";
        $this->query($strSQLQuery, 0);
        return 1;
    }

    /*     * ***********************************Alternatative Images Function Start***************************************************************** */

    function RemoveItem($id, $CategoryID, $Front) {
        $strSQLQuery = "select Image from inv_items where ItemID=" . $id;
        $arryRow = $this->query($strSQLQuery, 1);

        $sql = "select * from inv_item_images where ItemID=" . $id;
        $arry = $this->query($sql, 1);

        if ($Front > 0) {
            $ImgDir = 'upload/items/images/';
        } else {
            $ImgDir = '../../upload/items/images/';
        }



        for ($i = 1; $i <= 20; $i++) {
            if ($arry[0]['Image' . $i] != '' && file_exists($ImgDir . $arry[0]['Image' . $i])) {
                unlink($ImgDir . $arry[0]['Image' . $i]);
            }
        }



        if ($arryRow[0]['Image'] != '' && file_exists($ImgDir . $arryRow[0]['Image'])) {
            unlink($ImgDir . $arryRow[0]['Image']);
        }


        $strSQLQuery = "delete from inv_items where ItemID=" . $id;
        $this->query($strSQLQuery, 0);

        $strSQLQuery = "delete from inv_item_images where ItemID=" . $id;
        $this->query($strSQLQuery, 0);



        if ($CategoryID > 0) {
            $strSQLQuery = "select NumProducts from inv_categories where CategoryID=" . $CategoryID;
            $arryRow = $this->query($strSQLQuery, 1);
            if (!empty($arryRow[0]['NumProducts'])) {
                $strUpdateQuery = "update inv_categories set NumProducts = NumProducts - 1 where CategoryID = " . $CategoryID;
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
            $ImgDir = '../../upload/items/';
        } else {
            $ImgDir = '../../upload/items/images/';
        }

        for ($i = 0; $i < sizeof($arryRow); $i++) {


            if ($arryRow[$i]['Image'] != '' && file_exists($ImgDir . $arryRow[$i]['Image'])) {

                unlink($ImgDir . $arryRow[$i]['Image']);
            }

            if ($arryRow[$i]['Image'] != '' && file_exists($ImgDir . 'secondary/' . $arryRow[$i]['Image'])) {
                unlink($ImgDir . 'secondary/' . $arryRow[$i]['Image']);
            }


            if ($arryRow[$i]['CategoryID'] > 0) {
                $strSQLQuery = "select NumProducts from inv_categories where CategoryID=" . $arryRow[$i]['CategoryID'];
                $arryRow2 = $this->query($strSQLQuery, 1);
                if (!empty($arryRow2[$i]['NumProducts'])) {
                    $strUpdateQuery = "update inv_categories set NumProducts = NumProducts - 1 where CategoryID = " . $arryRow[$i]['CategoryID'];
                    $this->query($strUpdateQuery, 0);
                }
            }
        }

        return 1;
    }

    function isItemExists($Name, $ItemID = 0, $CategoryID) {

        $strSQLQuery = "select ItemID from inv_items where LCASE(Name)='" . strtolower(trim($Name)) . "'";

        $strSQLQuery .= ($ItemID > 0) ? (" and ItemID != " . $ItemID) : ("");
        //$strSQLQuery .= (!empty($CategoryID))?(" and CategoryID = ".$CategoryID):("");

        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['ItemID'])) {
            return true;
        } else {
            return false;
        }
    }

    function isItemNumberExists($ProductSku, $ItemID = 0, $PostedByID) {

        $strSQLQuery = "select ItemID from inv_items where LCASE(Sku)='" . strtolower(trim($ProductSku)) . "'";

        $strSQLQuery .= ($ItemID > 0) ? (" and ItemID != '".$ItemID."'") : ("");
        $strSQLQuery .= (!empty($PostedByID)) ? (" and PostedByID = " . $PostedByID) : ("");
#echo $strSQLQuery; exit;
        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['ItemID'])) {
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

        $where = "WHERE Status = 'Yes' AND Pid = " . $pid;
        $strSQLQuery = "SELECT SUM(Rating) as total FROM inv_items_reviews " . $where . "";
        //echo $strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

   

    function changeReviewStatus($id) {
        $strSQLQuery = "SELECT * FROM inv_items_reviews WHERE ReviewId=" . $id;
        $rs = $this->query($strSQLQuery);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 'Yes')
                $Status = 'No';
            else
                $Status = 'Yes';

            $strSQLQuery = "UPDATE inv_items_reviews SET Status='" . $Status . "' WHERE ReviewId=" . $id;
            $this->query($strSQLQuery, 0);
            return true;
        }
    }

    function getDiscountByItem($id) {
        $where = "WHERE is_active = 'Yes' AND pid = " . $id;
        $strSQLQuery = "SELECT * FROM e_products_quantity_discounts " . $where . "";
        //echo $strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    /*     * ********************* STOCK ADJUSTMENT *********** */

    function ListAdjustment($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {



        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.id=" . $id) : (" where 1 ");
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

        $strSQLQuery = "select a.*,i.Sku,i.description,i.itemType,i.evaluationType from inv_stock_adjustment a left outer join  inv_items  i on i.Sku=a.Sku  " . $strAddQuery;




        return $this->query($strSQLQuery, 1);
    }

    function RemoveAdjustment($id) {

        $strSQLQuery = "DELETE FROM inv_adjustment WHERE adjID = " . $id;
        $rs = $this->query($strSQLQuery, 0);

        $strSQLQuery2 = "DELETE FROM inv_stock_adjustment WHERE adjID = " . $id;
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
            $strSQL = "update inv_adjustment set adjustNo='" . $ModuleIDValue . "' where adjID=" . $adjID;
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

        $strSQLQuery = "update inv_adjustment set total_adjust_qty='" . $TotalQty . "', total_adjust_value='" . $TotalValue . "', WID='" . $WID . "',  warehouse_code='" . $warehouse . "', adjust_reason='" . addslashes($adjustment_reason) . "', Status='" . $Status . "',UpdatedDate = '" . $Config['TodayDate'] . "'
			where adjID=" . $adjID;

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
                    $sql = "update inv_stock_adjustment set item_id='" . $arryDetails['item_id' . $i] . "', sku='" . addslashes($arryDetails['sku' . $i]) . "', description='" . addslashes($arryDetails['description' . $i]) . "', on_hand_qty='" . addslashes($arryDetails['on_hand_qty' . $i]) . "', qty='" . addslashes($arryDetails['qty' . $i]) . "', price='" . addslashes($arryDetails['price' . $i]) . "', amount='" . addslashes($arryDetails['amount' . $i]) . "'  where id=" . $id;
                } else {

                    $sql = "insert into inv_stock_adjustment (adjID, item_id, sku, description, on_hand_qty, qty, price, amount) values('" . $adjustID . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "', '" . addslashes($arryDetails['on_hand_qty' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "')";
                }
                $this->query($sql, 0);
            }
        }

        return true;
    }

    function ListSerialNumber($arryDetails) {

        extract($arryDetails);

        $strAddQuery = '';
        $SearchKey = strtolower(trim($key));
        $strAddQuery .= (!empty($id)) ? (" where s.serialID=" . $id) : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");


        if ($sortby == 's.Status') {


            $strAddQuery .= (!empty($SearchKey)) ? (" and (a.Status like '%" . $SearchKey2 . "%')") : ("");
        } else if ($SortBy == 's.serialNumber') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (s.serialNumber like '%" . $SearchKey . "%')") : ("");
        } else if ($SortBy == 's.Sku') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (s.Sku like '%" . $SearchKey . "%')") : ("");
        } else {
            if ($SortBy != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '%" . $SearchKey . "%')") : ("");
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (s.serialNumber like '%" . $SearchKey . "%' or w.warehouse_name like '%" . $SearchKey . "%' or s.Sku like '%" . $SearchKey . "%'  ) " ) : ("");
            }
        }


        $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by s.Sku ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

        $strSQLQuery = "SELECT s.*, w.warehouse_name ,w.warehouse_code  FROM inv_serial_item s left outer join w_warehouse w on BINARY(s.warehouse) = BINARY(w.warehouse_code) " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }

    function AddSerialNumber($arrayDetail) {

        extract($arrayDetail);


        for ($i = 0; $i < sizeof($serial_no); $i++) {
            $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku)  values ('".$warehouse."','" . $serial_no[$i] . "','" . $Sku . "')";
            $this->query($strSQLQuery, 0);
            //echo   $serial_no[$i]."<br/>"; 
        }
        return 1;
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

    function ListingAdjustment($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {


        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.adjID=" . $id) : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");


    

            if ($SortBy != '') {
		    if ($SortBy == 'a.Status') {
		    if ($SearchKey == "parked") {
		        $SearchKey = 1;
		    } else if ($SearchKey == "completed") {
		        $SearchKey = 2;
		    } else {
		        $SearchKey = 0;
		    }
		    	$strAddQuery .= " and a.Status = '".$SearchKey."'";
		} else {
		    	$strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
		}
                
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (a.adjustNo like '%" . $SearchKey . "%' or a.total_adjust_qty like '%" . $SearchKey . "%' or a.total_adjust_value like '%" . $SearchKey . "%'  ) " ) : ("");
            }
        


       $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by a.adjustNo ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

         $strSQLQuery = "SELECT a.*, w.warehouse_name ,w.warehouse_code  FROM inv_adjustment a left outer join w_warehouse w on BINARY(a.warehouse_code) = BINARY(w.warehouse_code) " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }

    function GetAdjustmentStock($adjID) {
        $strAddQuery .= (!empty($adjID)) ? (" and adjID=" . $adjID) : ("");
        $strSQLQuery = "select * from inv_stock_adjustment  where 1" . $strAddQuery . " order by id asc";
        return $this->query($strSQLQuery, 1);
    }

    /*     * *************** Stock Transfer ******************** */

    function ListingTransfer($arryDetails) {

        extract($arryDetails);
        $strAddQuery = '';
        $SearchKey = strtolower(trim($key));
        if($edit>0) $id = $edit;
        $strAddQuery .= (!empty($id)) ? (" where t.transferID=" . $id) : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and t.Status='".$Status."'"):(" ");



         if($sortby != ''){
				if($sortby == 't.Status'){
					if($SearchKey == 'completed'){
                                           $SearchKey =2;
                                          }elseif($SearchKey == 'parked'){
                                                $SearchKey =1;
                                          }elseif($SearchKey == 'cancel'){
                                          $SearchKey =1;                                   
                                           }
                                 $strAddQuery .= " and t.Status = '".$SearchKey."'";
				}else{
				    $strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
				}
			}else{ 
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( t.total_transfer_qty like '%" . $SearchKey . "%' or t.transferNo like '%" . $SearchKey . "%' or t.total_transfer_value like '%" . $SearchKey . "%' or t.Status like '%" . $SearchKey . "%' or w2.warehouse_name like '%" . $SearchKey . "%' or w1.warehouse_name like '%" . $SearchKey . "%' ) " ) : ("");
            }
       


        $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by t.transferNo ");
        $strAddQuery .= (!empty($AscDesc)) ? ($asc) : (" Asc");

        $strSQLQuery = "SELECT t.*, w1.warehouse_name as from_warehouse,w2.warehouse_code as from_warehouse_code,w2.warehouse_name as to_warehouse,w2.warehouse_code as to_warehouse_code  FROM inv_transfer t left outer join w_warehouse w1 on t.from_WID = w1.WID left outer join w_warehouse w2 on t.to_WID = w2.WID  " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }

    function ListTransfer($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {



        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.id=" . $id) : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");



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

        echo $strSQLQuery = "select a.*,i.Sku,i.description,i.itemType,i.evaluationType from inv_stock_transfer a left outer join  inv_items  i on i.Sku=a.Sku  " . $strAddQuery;




        return $this->query($strSQLQuery, 1);
    }

    function RemoveTransfer($id) {

        $strSQLQuery = "DELETE FROM inv_transfer WHERE transferID = " . $id;
        $rs = $this->query($strSQLQuery, 0);

        $strSQLQuery2 = "DELETE FROM inv_stock_transfer WHERE transferID = " . $id;
        $this->query($strSQLQuery2, 0);

        if (sizeof($rs))
            return true;
        else
            return false;
    }

	function  GetAdjustment($AdjID,$Status)
		{
			$strAddQuery .= (!empty($AdjID))?(" and a.adjID=".$AdjID):("");
			$strAddQuery .= (!empty($Status))?(" and a.Status='".$Status."'"):("");
			
			$strSQLQuery = "select a.*, w.warehouse_name,w.WID,w.warehouse_code  from inv_adjustment a left outer join w_warehouse  w on BINARY w.warehouse_code = BINARY a.warehouse_code where 1".$strAddQuery." order by a.adjID desc";
			return $this->query($strSQLQuery, 1);
		}	

    function AddTransfer($arryDetails) {
        global $Config;
        extract($arryDetails);

        if (empty($Currency))
            $Currency = $Config['Currency'];

        $strSQLQuery = "insert into inv_transfer(total_transfer_qty,total_transfer_value,to_WID,from_WID,transfer_reason,transferDate,created_by,created_id,Status) 
                            values('" . $TotalQty . "', '" . $TotalValue . "',  '" . $to_WID . "', '" . $from_WID . "', '" . addslashes($transfer_reason) . "', '" . $Config['TodayDate'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['AdminID'] . "','" . $Status . "')";

        $this->query($strSQLQuery, 0);
        $tranID = $this->lastInsertId();
        if ($tranID > 0) {
            $rs = $this->getPrefix(1);

            $PrefixAD = $rs[0]['ToP'];


            $ModuleIDValue = $PrefixAD . '000' . $tranID;
            $strSQL = "update inv_transfer set transferNo='" . $ModuleIDValue . "' where transferID=" . $tranID;
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

        $strSQLQuery = "update inv_transfer set total_transfer_qty='" . $TotalQty . "', total_transfer_value='" . $TotalValue . "', to_WID='" . $to_WID . "', from_WID='" . $from_WID . "', transfer_reason='" . addslashes($transfer_reason) . "', Status='" . $Status . "',UpdatedDate = '" . $Config['TodayDate'] . "'
			where transferID=" . $transferID;

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
                    $sql = "update inv_stock_transfer set item_id='" . $arryDetails['item_id' . $i] . "', sku='" . addslashes($arryDetails['sku' . $i]) . "', description='" . addslashes($arryDetails['description' . $i]) . "', on_hand_qty='" . addslashes($arryDetails['on_hand_qty' . $i]) . "', qty='" . addslashes($arryDetails['qty' . $i]) . "', price='" . addslashes($arryDetails['price' . $i]) . "', amount='" . addslashes($arryDetails['amount' . $i]) . "'  where id=" . $id;
                } else {

                    $sql = "insert into inv_stock_transfer (transferID, item_id, sku, description, on_hand_qty, qty, price, amount) values('" . $tID . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "', '" . addslashes($arryDetails['on_hand_qty' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "')";
                }
                $this->query($sql, 0);
            }
        }

        return true;
    }

    function GetTransferStock($transferID) {
        $strAddQuery .= (!empty($transferID)) ? (" and transferID=" . $transferID) : ("");
        $strSQLQuery = "select * from inv_stock_transfer  where 1" . $strAddQuery . " order by id asc";
        return $this->query($strSQLQuery, 1);
    }
    
    function GetTransfer($transferID) {
        $strAddQuery .= (!empty($transferID)) ? (" and t.transferID='" . $transferID."'") : ("");
        $strSQLQuery = "select t.*,  w1.warehouse_name as from_warehouse,w2.warehouse_code as from_warehouse_code,w2.warehouse_name as to_warehouse,w2.warehouse_code as to_warehouse_code  FROM inv_transfer t left outer join w_warehouse w1 on t.from_WID = w1.WID left outer join w_warehouse w2 on t.to_WID = w2.WID  where 1" . $strAddQuery . " order by t.transferID asc"; 
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
                    $sql = "update inv_items set qty_on_hand='" . $totalQTY . "'  where ItemID=" . $arryDetails['item_id' . $i];
                } else if ($arryDetails['Status'] == 1) {

                    $sql = "update inv_items set allocated_qty='" . $totalQTY . "'  where ItemID=" . $arryDetails['item_id' . $i];
                }
                $this->query($sql, 0);
            }
        }




        //$exequery = mysql_fetch_array($strSQLQuery);
    }

    /*     * *************** End Transfer ********************** */


	
function GetPurchasedPriceItem($sku)
{
	$strAddQuery .= (!empty($sku))?(" and i.sku='".$sku."'"):("");
	$strSQLQuery = "select o.SuppCode,o.SuppCompany,o.OrderID,o.PurchaseID,o.OrderDate,o.Currency, i.item_id,i.sku,i.qty,i.description,i.price from p_order o inner join p_order_item i on o.OrderID=i.OrderID where o.Status='Completed' and o.Approved=1  and o.Module='Order' ".$strAddQuery." order by o.OrderDate desc ";
	return $this->query($strSQLQuery, 1);
}

   /* function GetPurchasePriceItem2($OrderID,$key) {
	
        //$strAddQuery .= (!empty($key))?(" and i.sku='".$key."'):("");
        //$strAddQuery .= (!empty($key))?(" and i.OrderID='".$key."'):("");
        $strSQLQuery = "select i.*,t.RateDescription,o.OrderDate,o.Currency from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join p_order o on i.OrderID=o.OrderID where 1" . $strAddQuery . " order by o.OrderDate desc";
        return $this->query($strSQLQuery, 1);
    }*/
	
	function  GetTransactionItem($item_id,$OrderID,$PurchaseID,$Module){
                       $strAddQuery .= (!empty($item_id))?(" and i.item_id='".$item_id."'"):("");
                       $strAddQuery .= (!empty($OrderID))?(" and o.OrderID=".$OrderID):("");
                       $strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".$PurchaseID."'"):("");
                       //$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
                       $strSQLQuery = "select o.*, i.item_id,i.sku,i.qty,i.description,i.price from p_order o inner join p_order_item i on o.OrderID=i.OrderID where o.Status='Completed' and o.Approved=1 ".$strAddQuery." order by o.OrderID desc ";
                       return $this->query($strSQLQuery, 1);
            }
			
		/******************************************* Quantity **********************/	
	 function  GetOrderdedQty($sku)
		{
			//echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";
			
			 $sql="select SUM(i.qty) as purchase_qty FROM p_order as o	inner join p_order_item as i on o.OrderID=i.OrderID	inner join inv_items as p on i.item_id = p.ItemID	where o.Status!='Completed' and	i.sku='".$sku."'";
		 
			
			$rs = $this->query($sql);
			return $rs[0]['purchase_qty'];
		}

		 function  GetAdjustmentQty($sku)
		{
			//echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";
			
			  $sql="select SUM(i.qty) as adjust_qty FROM inv_adjustment as a inner join inv_stock_adjustment as i on a.adjID=i.adjID	inner join inv_items as p on i.item_id = p.ItemID	where	i.sku = '".$sku."' ";
		
			$rs = $this->query($sql);
			return $rs[0]['adjust_qty'];
		}
		

		function  GetRecievedQty($sku)
		{
			//echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";
			
			 $sql="select SUM(i.qty_received) as qty_received FROM p_order as o	inner join p_order_item as i on o.OrderID=i.OrderID	inner join inv_items as p on i.item_id = p.ItemID	where	i.sku = '".$sku."' ";
		 
			
			$rs = $this->query($sql);
			return $rs[0]['qty_received'];
		}
		

		 function  GetAssemblyQty($sku)
		 {
			//echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";
			
			   $sql="select SUM(i.qty) as adjust_qty FROM inv_adjustment as a	inner join inv_stock_adjustment as i on a.adjID=i.adjID	inner join inv_items as p on i.item_id = p.ItemID	where	i.sku = '".$sku."' ";
			  $rs = $this->query($sql);
			  return $rs[0]['adjust_qty'];
		}
		 function  GetSaleOrderdedQty($sku)
		{
			//echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";
			
			 $sql="select SUM(i.qty) as sales_qty FROM s_order as s	inner join s_order_item as i on s.OrderID=i.OrderID	where s.Status='Closed' and	i.sku='".$sku."'";
		 
			
			$rs = $this->query($sql);
			return $rs[0]['sales_qty'];
		}
		/************************** End Quantity **************/

		function  AdjustmentReport($FilterBy,$FromDate,$ToDate,$Month,$Year,$warehouse_code,$Status)
		{

			
            $strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(a.adjDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and a.adjDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and a.adjDate<='".$ToDate."'"):("");
			}



			$strAddQuery .= (!empty($warehouse_code))?(" and a.warehouse_code='".$warehouse_code."'"):("");
			$strAddQuery .= ($Status>=0)?(" and a.Status='".$Status."'"):("");

			 $strSQLQuery = "select  a.adjDate,a.adjustNo,a.total_adjust_qty, a.adjID, a.warehouse_code,a.adjust_reason, a.total_adjust_value, a.total_adjust_qty, a.Status,w.warehouse_name,w.WID,w.warehouse_code  from inv_adjustment a left outer join w_warehouse  w on BINARY w.warehouse_code = BINARY a.warehouse_code where 1 ".$strAddQuery." order by a.adjDate desc";
				
			return $this->query($strSQLQuery, 1);		
		}
		function  GetNumAdjByYear($FilterBy,$month,$Year,$FromDate,$ToDate,$warehouse_code,$Status)
		{

			$strAddQuery = "";
			
				
				$strAddQuery .= (!empty($FromDate))?(" and a.adjDate >= '".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and a.adjDate <= '".$ToDate."'"):("");
		   
			  $strAddQuery .= (!empty($warehouse_code))?(" and a.warehouse_code='".$warehouse_code."'"):("");
			  $strAddQuery .= (!empty($Status))?(" and a.Status='".$Status."'"):("");

			 $strSQLQuery = "select count(a.adjID) as TotalAdj  from inv_adjustment a where YEAR(a.adjDate)='".$Year."' ".$strAddQuery." order by a.adjDate desc"; 
				
			return $this->query($strSQLQuery, 1);		
		}

	function  GetNumAdjByMonth($Year,$FromDate,$ToDate,$warehouse_code,$Status)
		{
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and a.adjDate = '".$ToDate."' "):("");
			$strAddQuery .= (!empty($Year))?(" and YEAR(a.adjDate)='".$Year."' "):("");
			$strAddQuery .= (!empty($warehouse_code))?(" and a.warehouse_code='".$warehouse_code."'"):("");
			
			$strAddQuery .= (!empty($Status))?(" and a.Status='".$Status."'"):("");

			$strSQLQuery = "select count(a.adjID) as TotalAdj  from inv_adjustment a where 1 ".$strAddQuery." order by a.adjDate desc";
				//echo "=>".$strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);		
		}


	 function  TransferReport($FilterBy,$FromDate,$ToDate,$Month,$Year,$warehouse_code1,$warehouse_code2,$Status)
		{

			$strAddQuery = "";
		
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(t.transferDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and t.transferDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and t.transferDate<='".$ToDate."'"):("");
			}
			
			$strAddQuery .= (!empty($warehouse_code1))?(" and t.from_WID='".$warehouse_code1."'"):("");
			$strAddQuery .= (!empty($warehouse_code2))?(" and t.to_WID='".$warehouse_code2."'"):("");
			$strAddQuery .= ($Status >= 0)?(" and t.Status='".$Status."'"):("");

			 $strSQLQuery = "select  t.transferDate,t.transferNo,t.total_transfer_qty, t.transferID, t.from_WID,t.to_WID,t.transfer_reason, t.total_transfer_value, t.Status,w1.warehouse_code as from_warehouse,w1.warehouse_name as from_warehouse_name,w1.WID,w2.warehouse_code as to_warehouse,w2.warehouse_name as to_warehouse_name,w2.WID from inv_transfer t inner join w_warehouse w1 on w1.WID=t.from_WID inner join  w_warehouse w2  on w2.WID=t.to_WID  where 1 ".$strAddQuery." order by t.transferDate desc";
				
			return $this->query($strSQLQuery, 1);		
		}

           function ExportItem()
                 {
                      $strSQLQuery = "SELECT * FROM inv_items ORDER BY ItemID ASC";
                      return  $this->query($strSQLQuery);
                     
                 }

}

?>
