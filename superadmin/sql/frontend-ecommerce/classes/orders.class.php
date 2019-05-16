<?php //error_reporting( E_ALL ^ E_DEPRECATED );

class orders extends dbClass {

    //constructor
    function orders() {
        $this->dbClass();
    }

/*pdf protected function*/
	function pdfEncrypt ($origFile, $password, $destFile){
		
		//echo 'SSS'; die('asasasas');
		require_once('fpdi/FPDI_Protection.php');
		//
		$pdf =& new FPDI_Protection();
		
		$pdf->FPDF("P", "in", array('8','9'));

		
		$pagecount = $pdf->setSourceFile($origFile);

		
		for ($loop = 1; $loop <= $pagecount; $loop++) {
		$tplidx = $pdf->importPage($loop);
		$pdf->addPage();
		$pdf->useTemplate($tplidx);
		}

		// protect the new pdf file, and allow no printing, copy etc and leave only reading allowed
		$pdf->SetProtection(array(),$password);
		$pdf->Output($destFile, 'F');

		return $destFile;
	}

    function GetOrders($id = 0, $OrderStatus, $PaymentStatus, $CustomerName, $OrderPeriod) {
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));

        $strAddQuery .= (!empty($id)) ? (" WHERE o.OrderID=" . $id) : (" WHERE 1");

        if (!empty($OrderStatus)) {
            $strAddQuery .= " AND o.OrderStatus = '" . $OrderStatus . "'";
        }
        if (!empty($PaymentStatus)) {
            $strAddQuery .= " AND o.PaymentStatus = '" . $PaymentStatus . "'";
        }
        if (!empty($CustomerName)) {
            $strAddQuery .= " AND c.FirstName like '" . $CustomerName . "%'";
        }
        if (!empty($OrderPeriod)) {
            $strAddQuery .= " AND (DATE_ADD(o.OrderDate, INTERVAL " . $OrderPeriod . " HOUR) >= NOW())";
        }

        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" ORDER BY OrderID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");

        $strSQLQuery = "SELECT o.OrderID,o.CurrencySymbol,o.TotalPrice,o.OrderStatus,o.PaymentStatus,o.OrderDate,c.FirstName,c.LastName,c.Cid from e_orders AS o LEFT JOIN e_customers AS c ON c.Cid = o.Cid " . $strAddQuery;
        //echo "=>".$strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    function GetMyOrders($Cid) {

        global $Config;
        $strSQLQuery = "SELECT * FROM e_orders WHERE Cid='" . intval($Cid) . "' ORDER BY OrderID DESC";
        return $this->query($strSQLQuery, 1);
    }

    function GetOrderDetails($OrderID, $ProductIDs) {
        $strSQLQuery = "select od.*,o.*,p.ProductSku,p.product_type,p.secure_type,p.virtual_file from e_orderdetail od inner join e_orders o  on od.OrderID=o.OrderID left outer join e_products p on od.ProductID=p.ProductID where od.OrderID='" . $OrderID . "' and od.ProductID in(" . $ProductIDs . ")";

        return $this->query($strSQLQuery, 1);
    }

    function getOrderData($OrderID) {
        $strSQLQuery = "select OrderID,Cid,TotalPrice,SubTotalPrice,Tax,Shipping,ShippingMethod,PaymentGateway,PaymentGatewayID from e_orders  where OrderID='" . mysql_real_escape_string($OrderID) . "'";
        $arrayRows = $this->query($strSQLQuery, 1);
        return $arrayRows[0];
    }

    function deleteOrder($oid) {
        $strSQLQuery = "DELETE FROM e_orders WHERE OrderID = '" . mysql_real_escape_string($oid) . "'";
        $this->query($strSQLQuery, 0);
        $strSQLQuery = "DELETE FROM e_orderdetail WHERE OrderID = '" . mysql_real_escape_string($oid) . "'";
        $this->query($strSQLQuery, 0);
    }

    function getOrdererInfo($oid) {

        $strSQLQuery = "SELECT o.*,c.FirstName,c.LastName,c.Cid,c.Email from e_orders AS o LEFT JOIN e_customers AS c ON c.Cid = o.Cid WHERE o.OrderID='" . mysql_real_escape_string($oid) . "'";
        //echo $strSQLQuery;exit;
        $arrayRow = $this->query($strSQLQuery, 1);
        return $arrayRow[0];
    }

    function getOrderedProductById($oid) {

        $strSQLQuery = "SELECT od.*,o.OrderID,o.OrderID,CurrencySymbol,p.ProductSku FROM e_orderdetail od INNER JOIN e_orders o  on od.OrderID=o.OrderID LEFT OUTER JOIN e_products p on od.ProductID=p.ProductID WHERE od.OrderID='" . mysql_real_escape_string($oid) . "'";
        // echo $strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    function getShippingStatus() {
        $strSQLQuery = "SELECT * FROM e_delhivery_status";
        return $this->query($strSQLQuery, 1);
    }

    function saveOrderStatus($arryDetails) {
        extract($arryDetails);

        global $Config;
        ;

        if (!empty($OrderStatus)) {
            $strSQLQuery = "UPDATE e_orders SET OrderComplatedDate = '" . $Config['TodayDate'] . "', OrderStatus = '" . $OrderStatus . "' WHERE OrderID = '" . mysql_real_escape_string($oid) . "'";
            $this->query($strSQLQuery, 0);
            if ($OrderStatus == "Completed" && $send_notification_email == "Yes") {
                $this->emailOrderCompleted($oid);
            }
        }
        if (!empty($Shipping_status)) {
            $strSQLQuery = "UPDATE e_orders SET  ShippingStatus = '" . $Shipping_status . "' WHERE OrderID = '" . mysql_real_escape_string($oid) . "'";
            $this->query($strSQLQuery, 0);
        }
        if (!empty($PaymentStatus)) {
            $strSQLQuery = "UPDATE e_orders SET PaymentStatus = '" . $PaymentStatus . "' WHERE OrderID = '" . mysql_real_escape_string($oid) . "'";
            $this->query($strSQLQuery, 0);
        }
    }

    function GetCart($Cid) {
        $strSQLQuery = "select distinct c1.*,p1.ProductID,p1.Name,p1.ProductSku,p1.Image,c1.Weight,
        p1.InventoryControl,p1.Quantity as 'AvailableQuantity',a1.ItemAliasCode,a1.description as Aliasdescription 
        from e_cart c1 
        inner join e_products p1  on c1.ProductID=p1.ProductID 
        left join  e_item_alias a1 ON a1.AliasID = c1.AliasID  
        where c1.Cid='" . mysql_real_escape_string($Cid) . "'";

        return $this->query($strSQLQuery, 1);
    }

    function getCartSubtotalAmount($Cid) {
        $strSQLQuery = "SELECT SUM(Quantity * ROUND(Price, 2)) AS subtotal_amount FROM e_cart WHERE Cid='" . mysql_real_escape_string($Cid) . "'";
        $arrayRow = $this->query($strSQLQuery, 1);
        $subtotalAmount = 0;
        if (count($arrayRow) > 0) {
            $subtotalAmount = $arrayRow[0]["subtotal_amount"];
            $subtotalAmount = $subtotalAmount > 0 ? $subtotalAmount : 0.00;
        } else {
            $subtotalAmount = 0.00;
        }

        return $subtotalAmount;
    }

    function GetNumItemCart($Cid) {
        $strSQLQuery = "select sum(Quantity) as NumCartItem,sum(c1.Price*c1.Quantity) as TotalCartPrice from e_cart c1  where c1.Cid='" . mysql_real_escape_string($Cid) . "'";

        return $this->query($strSQLQuery, 1);
    }

    function GetItemCart($Cid) {
        $strSQLQuery = "select c1.*,p1.Name from e_cart c1 
		left join e_products p1 on p1.ProductID=c1.ProductID where c1.Cid='" . mysql_real_escape_string($Cid) . "'";

        return $this->query($strSQLQuery, 1);
    }

    public function parseOptions($options) {
        return explode("\n", $options);
    }

    function AddToCart($ProductID, $Cid, $Quantity, $attributes, $arr,$AliasID='',$uploadFileArray) {

        global $Config;
		
        $GroupID = $_SESSION['GroupID'];

        $strSQLQuery = "SELECT * FROM e_products WHERE ProductID='" . mysql_real_escape_string($ProductID) . "' AND Status='1'";
        $arryProductRow = $this->query($strSQLQuery, 1);
        $product = $arryProductRow[0];



        //calc price changes based on attributes
        //and store attributes
        $selected_options = "";
        $selected_options_clean = "";

		
        $strSQLQueryAttr = mysql_query("SELECT * FROM e_products_attributes WHERE pid = '" . mysql_real_escape_string($ProductID) . "' AND is_active = 'Yes' ORDER BY priority, name");
        //$arryRowAttr = $this->query($strSQLQueryAttr, 1);
        $GroupPrice = json_decode($product['GroupPrice'], true);

        $mod_price = ($GroupPrice[$GroupID] > 0) ? $GroupPrice[$GroupID] : $product['Price'];
        $mod_weight = $product['Weight'];
        $selected_attributes = array();
        //$intentory_list = "";
      $Attributeval='';
        while ($arryRowAttr = mysql_fetch_array($strSQLQueryAttr)) {
        	
            $options = array();
            $selected_attribute = array();
            $selected_attribute["attribute_value"] = 0;
            $selected_attribute["attribute_value_type"] = "amount";

            if ($arryRowAttr["attribute_type"] == "select") {
				

                if (array_key_exists($arryRowAttr["paid"], $attributes)) {
					
                    //$selected_option = urldecode($attributes[$arryRowAttr["paid"]]);
                    if( $attributes[$arryRowAttr["paid"]]!=''){
                    $res = $this->GetOptionVal($attributes[$arryRowAttr["paid"]]);
                    //$selected_option = $attributes[$arryRowAttr["paid"]];
                    $selected_optionsAttribute[$res[0]['Id']]=$arryRowAttr["name"] . " : " .$res[0]['title'];
					$selected_option=$res[0]['options'];
                    $selected_options.= $arryRowAttr["name"] . " : " . $selected_option . "\r\n";
					
					
                    if ($arryRowAttr["is_modifier"] == "Yes") { 
                        $option_parts = explode("(", $selected_option);
                        
                        $option_name = $arryRowAttr["name"];

                                //Code For Price Modifier

                               	$price_modifier = $res[0]["Price"];
                                if(strtolower($res[0]['PriceType']) == 'percentage')
                                $price_modifier = round($mod_price *$price_modifier /100* 1, 2); 
                                else $price_modifier = round($price_modifier * 1, 2); 
                                $totalAttrPrice += $price_modifier; 
                                $option_difference = $price_modifier;
                                $option_price = $mod_price + $price_modifier; 
                                if ($option_difference != 0 && $option_price != 0) {
                                    $option_modifier = ($price_modifier > 0 ? "+" : "-") . "" . $price_modifier * ($price_modifier > 0 ? 1 : -1);
                                }
                                //End
                                //Code For Weight Modifier
                                $weight_modifier = $res[0]["Weight"];
                                $weight_modifier *=1;
                                $totalAttrWeight += $weight_modifier; 
                                $weight_difference = $weight_modifier;
                                $option_weight = $mod_weight + $weight_modifier;
                                if ($weight_modifier != 0) {
                                    $option_modifier = (strlen(trim($option_modifier)) > 0 ? $option_modifier . ", " : $option_modifier) . ($weight_modifier > 0 ? "+" : "-") . "" . $weight_modifier * ($weight_modifier > 0 ? 1 : -1);
                                }
                                $weight_option_value = $weight_modifier;


                                //End
                           
                        
                    }
                    }
                    
                }
            } else {
                $selected_option = $attributes[$arryRowAttr["paid"]];
                $selected_options.= $arryRowAttr["name"] . " : " . $selected_option . "\r\n";
            }
            $selected_attributes[] = $selected_attribute;
        }
      
        
        $Attributeval=json_encode($selected_optionsAttribute);
        
		//echo $totalAttrPrice; die;
        $Price = $mod_price + $totalAttrPrice;
        $Weight = $mod_weight + $totalAttrWeight;
        //echo "=>".$Weight;exit;

        /*         * ******************************************************************************************************************************* */
        if (empty($Quantity)) {
            $Quantity = 1;
        }
        $strSQLQuery = "select * from e_cart where Cid='" . $Cid . "' And ProductID = '" . $ProductID . "' AND options LIKE '" . $selected_options . "'";
        $strSQLQuery .=" AND AliasID  = '" . $AliasID . "'";
		
        $arryRow = $this->query($strSQLQuery, 1);

        if (!empty($arryRow[0]['CartID'])) {
            //By Chetan 11Sep//
            if (!empty($arr)) {
                $str = ",Variant_ID = '" . $arr[0]['variantID'] . "', Variant_val_Id = '" . $arr[0]['variantVal'] . "'";
            }

            $strSQLQuery = "update e_cart set Quantity=Quantity+" . $Quantity . ", Options = '" . $selected_options . "', Weight = '" . $Weight . "', AddedDate='" . $Config['TodayDate'] . "' $str where CartID='" . $arryRow[0]['CartID'] . "' AND ProductID = '" . $ProductID . "'";
            //echo "=>".$strSQLQuery;exit;
            //End//
            $this->query($strSQLQuery, 0);
        } else {

            if ($product['FreeShipping'] == "Yes") {
                $FreeShipping = "Yes";
            } else {
                $FreeShipping = "No";
            }
            //By Chetan 11Sep//
            if (!empty($arr)) {
                $col = ",Variant_ID,Variant_val_Id";
                $val = ",'" . addslashes($arr[0]['variantID']) . "', '" .addslashes($arr[0]['variantVal']) . "'";
            }
            
            // for upload file
		$FileName='';
        if($uploadFileArray['name']!=''){
				
				$MainDir = "upload/ordersfile/";                         
								if (!is_dir($MainDir)) {
									mkdir($MainDir);
									chmod($MainDir,0777);
								}
				$FileExtension = GetExtension($uploadFileArray['name']); 
				
				$FileName = strtotime("now").".".$FileExtension;	 
							
				 $FileDestination = $MainDir.$FileName; 
				
						
				@move_uploaded_file($uploadFileArray['tmp_name'], $FileDestination);
			}
			
			
            $strSQLQuery = "insert into e_cart (Cid,ProductID,Price,PriceBeforeQuantityDiscount,Quantity,IsTaxable,TaxClassId,FreeShipping, Options,OptionsAttribute, Weight,AddedDate,UploadedFile,AliasID " . $col . ") values('" . $Cid . "', '" . $ProductID . "', '" . $Price . "','" . $Price . "','" . $Quantity . "', '" . $product['IsTaxable'] . "', '" . $product['TaxClassId'] . "', '" . $FreeShipping . "', '" . $selected_options . "', '" . addslashes($Attributeval) . "', '" . $Weight . "','" . $Config['TodayDate'] . "' ,'" .addslashes($FileName)  . "'  ,'" . $AliasID . "' " . $val . ")";
            //echo "=>".$strSQLQuery;exit;		
            //End//
            $this->query($strSQLQuery, 0);
        }
		

        return 1;
    }

    function ReOrder($oid, $Cid) {

        global $Config;

        $strSQLQuery = "SELECT od.ProductID,od.ProductOptions,od.Quantity,p.Price,p.IsTaxable,p.TaxClassId,p.TaxRate,p.FreeShipping,p.Weight,od.Variant_ID,od.Variant_val_Id  FROM e_orderdetail as od,e_products as p WHERE od.ProductID = p.ProductID AND od.OrderID='" . trim($oid) . "' AND p.Status=1";
        $arryProductRow = $this->query($strSQLQuery, 1);

        for ($i = 0; $i < count($arryProductRow); $i++) {
            $product = $arryProductRow[$i];
            $productOptions = $product['ProductOptions'];
            $options = $this->parseOptions($productOptions);

            $mod_price = $product['Price'];
            $mod_weight = $product['Weight'];
            $ProductID = $product['ProductID'];
            $Quantity = $product['Quantity'];
            $IsTaxable = $product['IsTaxable'];
            $TaxClassId = $product['TaxClassId'];
            $FreeShipping = $product['FreeShipping'];

            // added by karishma 5oct2015
            $Variant_ID = $product['Variant_ID'];
            $Variant_val_Id = $product['Variant_val_Id'];


            $totalAttrPrice = "";
            $totalAttrWeight = "";

            foreach ($options as $option) {
                $option_parts = explode("(", $option);
                $option_name = trim($option_parts[0]);
                $modifier = trim($option_parts[1]);

                if (strlen($modifier) > 2) {
                    if ($modifier[strlen($modifier) - 1] == ")") {
                        $modifier = trim(substr($modifier, 0, strlen($modifier) - 1));
                        $mod_parts = explode(",", $modifier);

                        //Code For Price Modifier

                        $price_modifier = $mod_parts[0];
                        $price_modifier = round($price_modifier * 1, 2);
                        $totalAttrPrice += $price_modifier;
                        $option_difference = $price_modifier;
                        $option_price = $mod_price + $price_modifier;
                        if ($option_difference != 0 && $option_price != 0) {
                            $option_modifier = ($price_modifier > 0 ? "+" : "-") . "" . $price_modifier * ($price_modifier > 0 ? 1 : -1);
                        }
                        //End
                        //Code For Weight Modifier
                        $weight_modifier = $mod_parts[1];
                        $weight_modifier *=1;
                        $totalAttrWeight += $weight_modifier;
                        $weight_difference = $weight_modifier;
                        $option_weight = $mod_weight + $weight_modifier;
                        if ($weight_modifier != 0) {
                            $option_modifier = (strlen(trim($option_modifier)) > 0 ? $option_modifier . ", " : $option_modifier) . ($weight_modifier > 0 ? "+" : "-") . "" . $weight_modifier * ($weight_modifier > 0 ? 1 : -1);
                        }
                        $weight_option_value = $weight_modifier;


                        //End
                    }
                }
            }


            $Price = $mod_price + $totalAttrPrice;
            $Weight = $mod_weight + $totalAttrWeight;


            /*             * ******************************************************************************************************************************* */
            if (empty($Quantity)) {
                $Quantity = 1;
            }

            $strSQLQuery = "select * from e_cart where Cid='" . $Cid . "' And ProductID = '" . $ProductID . "' AND options LIKE '" . $productOptions . "'";

            $arryRow = $this->query($strSQLQuery, 1);

            if (!empty($arryRow[0]['CartID'])) {
                $strSQLQuery = "update e_cart set Quantity=Quantity+" . $Quantity . ", Options = '" . $selected_options . "', Weight = '" . $Weight . "', AddedDate='" . $Config['TodayDate'] . "', Variant_ID='" . $Variant_ID . "', Variant_val_Id='" . $Variant_val_Id . "' where CartID='" . $arryRow[0]['CartID'] . "' AND ProductID = '" . $ProductID . "'";
                //echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
            } else {

                if ($product['FreeShipping'] == "Yes") {
                    $FreeShipping = "Yes";
                } else {
                    $FreeShipping = "No";
                }
                $strSQLQuery = "insert into e_cart (Cid,ProductID,Price,PriceBeforeQuantityDiscount,Quantity,IsTaxable,TaxClassId,FreeShipping, Options, Weight,AddedDate,Variant_ID,Variant_val_Id) values('" . $Cid . "', '" . $ProductID . "', '" . $Price . "','" . $Price . "','" . $Quantity . "', '" . $IsTaxable . "', '" . $TaxClassId . "', '" . $FreeShipping . "', '" . $productOptions . "', '" . $Weight . "','" . $Config['TodayDate'] . "','" . $Variant_ID . "','" . $Variant_val_Id . "')";
                // echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
            }
        }

        return 1;
    }

    function UpdateCart($arryDetails) {
        extract($arryDetails);

        $TotalQuantity = 0;
        $TotalPrice = 0;
        for ($i = 1; $i <= $numCart; $i++) {
            $Quantity = 'Quantity' . $i;
            $Quantity = $$Quantity;

            $ProductID = 'ProductID' . $i;
            $ProductID = $$ProductID;

            $CartID = 'CartID' . $i;
            $CartID = $$CartID;



            $DelCart = 'DelCart' . $i;
            $DelCart = $$DelCart;





            $strSQLQuery = "update e_cart set Quantity ='" . $Quantity . "' where CartID = '" . $CartID . "' and Cid='" . $Cid . "' and ProductID = '" . $ProductID . "'";
            // echo $strSQLQuery;exit;
            $this->query($strSQLQuery, 0);
        }

        $this->query($strSQLQuery, 0);

        return 1;
    }

    function UpdateCartWithTax($Cid, $ProductID, $TaxRate, $TaxDescription) {

        $strSQLQuery = "update e_cart SET TaxRate ='" . $TaxRate . "', TaxDescription = '" . $TaxDescription . "' WHERE  Cid='" . $Cid . "' and ProductID = '" . $ProductID . "'";
        $this->query($strSQLQuery, 0);
    }

    /**
     * Apply quantity discounts
     */
    public function checkQuantityDiscounts($Cid) {
        $strSQLQuery = "SELECT SUM(c.quantity) AS q, c.ProductID FROM e_cart AS c WHERE c.Cid = '" . $Cid . "' GROUP BY c.ProductID";
        $arryRow = $this->query($strSQLQuery, 1);
        for ($i = 0; $i < count($arryRow); $i++) {

            $discounts = mysql_query("SELECT * FROM e_products_quantity_discounts WHERE pid = '" . $arryRow[$i]['ProductID'] . "' AND is_active = 'Yes' AND " . $arryRow[$i]["q"] . " BETWEEN range_min AND range_max ORDER BY range_min LIMIT 1 ");
            //echo "=>"."SELECT * FROM e_products_quantity_discounts WHERE pid = ".$arryRow[$i]['ProductID']." AND is_active = 'Yes' AND ".$arryRow[$i]["q"]." BETWEEN range_min AND range_max ORDER BY range_min LIMIT 1 ";exit;
            if (mysql_num_rows($discounts) > 0) {
                if ($discount = mysql_fetch_array($discounts)) {

                    if (!empty($Cid)) {
                        if ($discount["discount_type"] == "amount") {
                            $discountAmount = number_format($discount["discount"], 2);
                            $nowProductPrice = $productPrice - $discountAmount;
                        } else {
                            $discountAmountPercent = number_format($discount["discount"], 2);
                            $discountAmount = 'PriceBeforeQuantityDiscount/100*' . $discountAmountPercent . '';
                        }


                        $discountAmount = str_replace(',', '', $discountAmount);

                        $strSQLQuery = "UPDATE e_cart SET Price = PriceBeforeQuantityDiscount-" . $discountAmount . " where Cid='" . $Cid . "' and ProductID = '" . $arryRow[$i]['ProductID'] . "'";
                        "";
                        //echo "=>". $strSQLQuery;exit;
                        $this->query($strSQLQuery, 0);
                    }
                }
            } else {
                $strSQLQuery = "UPDATE e_cart SET Price = PriceBeforeQuantityDiscount where Cid='" . $Cid . "' and ProductID = '" . $arryRow[$i]['ProductID'] . "'";
                "";
                // echo "=>". $strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
            }
        }
        // exit;
    }

    public function checkQuantityForDiscount($Cid) {
        $strSQLQuery = mysql_query("SELECT SUM(c.quantity) AS q, c.ProductID FROM e_cart AS c WHERE c.Cid = '" . $Cid . "' GROUP BY c.ProductID");

        while ($arryRow = mysql_fetch_array($strSQLQuery)) {
            $discounts = mysql_query("SELECT * FROM e_products_quantity_discounts WHERE pid = '" . $arryRow['ProductID'] . "' AND is_active = 'Yes' AND " . $arryRow["q"] . " BETWEEN range_min AND range_max ORDER BY range_min LIMIT 1 ");
            $numRecords += mysql_num_rows($discounts);
        }

        return $numRecords;
    }

    function deleteProductFromCart($Cid, $Productid, $CartID) {
        $strSQLQuery = "delete from e_cart where CartID = '" . mysql_real_escape_string($CartID) . "' and Cid='" . mysql_real_escape_string($Cid) . "' and ProductID = '" . mysql_real_escape_string($Productid) . "'";
        //echo $strSQLQuery;exit;
        $this->query($strSQLQuery, 0);
        return 1;
    }

    function AddMultipleCart($arryDetails) {
        extract($arryDetails);

        global $Config;

        for ($i = 1; $i <= $numPriceProduct; $i++) {


            $Quantity = 'Quantity' . $i;
            $Quantity = $$Quantity;

            $AddCart = 'AddCart' . $i;
            $ProductID = $$AddCart;

            $Price = 'Price' . $i;
            $Price = $$Price;

            $Tax = 'Tax' . $i;
            $Tax = $$Tax;

            if ($ProductID > 0) {
                //echo '<br>'.$ProductID.' '.$Quantity.' '.$Price;


                $strSQLQuery = "select * from e_cart where Cid='" . $Cid . "' And ProductID = '" . $ProductID . "' And StoreID = '" . $_SESSION['StoreID'] . "'";

                $arryRow = $this->query($strSQLQuery, 1);

                if ($Cid == $_SESSION['StoreID']) {
                    $_SESSION['MsgCart'] = CANT_BUY_STORE;
                    break;
                } else {

                    if (!empty($arryRow[0]['CartID'])) {
                        $strSQLQuery = "update e_cart set Quantity='" . $Quantity . "',AddedDate='" . $Config['TodayDate'] . "' where CartID='" . $arryRow[0]['CartID'] . "'";
                        $this->query($strSQLQuery, 0);
                    } else {
                        $strSQLQuery = "insert into e_cart (Cid,ProductID,Price,Tax,Quantity,StoreID,AddedDate) values('" . $Cid . "', '" . $ProductID . "', '" . $Price . "','" . $Tax . "','" . $Quantity . "','" . $_SESSION['StoreID'] . "','" . $Config['TodayDate'] . "')";
                        $this->query($strSQLQuery, 0);
                    }
                }
            }
        }


        return 1;
    }

    function RemoveCart($Cid) {
        $strSQLQuery = "delete from e_cart where Cid = '" . mysql_real_escape_string($Cid) . "'";
        $this->query($strSQLQuery, 0);
        return 1;
    }

    function AddOrder($arryDetails) {
        extract($arryDetails);
		
        global $Config;

        $objRegion1 = new region();
        $BCountry = $BillingCountry;
        $SCountry = $ShippingCountry;
        $BState = $BillingState;
        $SState = $ShippingState;
        $BCity = $BillingCity;
        $SCity = $ShippingCity;

        $GroupdiscountAmount = $_SESSION['GroupdiscountAmount'];
        $GroupDiscountSetting = json_encode($_SESSION['groupDiscontSetting']);

        $Variant_ID = $_SESSION['Variant_ID'];
        $Variant_val_Id = $_SESSION['Variant_val_Id'];

        unset($_SESSION['GroupdiscountAmount']);
        unset($_SESSION['groupDiscontSetting']);
        unset($_SESSION['Variant_ID']);
        unset($_SESSION['Variant_val_Id']);
        
        $strSQLQuery = "insert into e_orders SET Cid = '" . $Cid . "', ProductIDs = '" . $ProductIDs . "', currency_id = '" . $currency_id . "', Currency = '" . $Config['Currency'] . "',CurrencySymbol = '" . $Config['CurrencySymbol'] . "',CurrencyValue = '" . $Config['CurrencyValue'] . "', OrderDate = '" . $Config['TodayDate'] . "', OrderComplatedDate = '" . $Config['TodayDate'] . "', SubTotalPrice = '" . $SubTotalPrice . "', TotalPrice = '" . $TotalPrice . "',
                            TotalQuantity =  '" . $TotalQuantity . "', Tax =  '" . $Tax . "', Shipping =  '" . $Shipping . "', ShippingMethod =  '" . $ShippingMethod . "', Weight =  '" . $Weight . "', WeightUnit = '" . $WeightUnit . "', DiscountAmount = '" . $DiscountAmount . "', DiscountValue = '" . $DiscountValue . "', DiscountType = '" . $DiscountType . "',PromoCampaignID = '" . $PromoCampaignID . "',PromoDiscountAmount = '" . $PromoDiscountAmount . "',
                            BillingName =  '" . addslashes($BillingName) . "', BillingAddress = '" . addslashes($BillingAddress) . "', BillingCity = '" . $BCity . "', BillingState =  '" . $BState . "', BillingCountry =  '" . $BCountry . "',
                            BillingZip =  '" . $BillingZip . "', BillingCompany = '" . addslashes($BillingCompany) . "', Phone = '" . $Phone . "', Email = '" . $Email . "', ShippingName = '" . addslashes($ShippingName) . "', ShippingCompany = '" . addslashes($ShippingCompany) . "', ShippingAddress = '" . addslashes($ShippingAddress) . "',ShippingCity =  '" . $SCity . "', ShippingState = '" . $SState . "', ShippingCountry = '" . $SCountry . "',
                            ShippingZip = '" . $ShippingZip . "', ShippingPhone = '" . $ShippingPhone . "', ShippingAddressType = '" . $AddressType . "',  DelivaryDate = '" . $DelivaryDate . "',
                            GroupDiscount='" . addslashes($GroupdiscountAmount) . "' , GroupDiscountSetting='" . addslashes($GroupDiscountSetting) . "' ";
		

        $this->query($strSQLQuery, 0);
        $OrderID = $this->lastInsertId();
        $_SESSION['OrderID'] = $OrderID;

        $TrackNumber = rand(1000, 1000000) . $OrderID;
        $sqlTrack = "update e_orders set TrackNumber='" . $TrackNumber . "' where OrderID='" . $OrderID . "'";
        $this->query($sqlTrack, 0);

        $strSQL = "select distinct c1.*,p1.ProductID,p1.Name as PName,a1.ItemAliasCode,
		a1.description as Aliasdescription from e_cart c1 
        inner join e_products p1  on c1.ProductID=p1.ProductID 
        left join e_item_alias a1 ON a1.AliasID = c1.AliasID 
        where c1.Cid='" . $Cid . "' and p1.ProductID in (" . $ProductIDs . ")";



        $arryRow = $this->query($strSQL, 1);
        for ($i = 0; $i < sizeof($arryRow); $i++) {
			$AliasID=$arryRow[$i]['AliasID'];
            $Price = modified_price($arryRow[$i]['Price']);
            //$Price = $arryRow[$i]['Price'];
            $ProductID = $arryRow[$i]['ProductID'];
            $ProductName = $arryRow[$i]['PName'];
         	if(!empty($arryRow[$i]['AliasID'])){
             	$ProductName=$arryRow[$i]['ItemAliasCode'];
             }
            $Quantity = $arryRow[$i]['Quantity'];
            $ProductOptions = $arryRow[$i]['Options'];
            $TaxRate = $arryRow[$i]['TaxRate'];
            $TaxDescription = $arryRow[$i]['TaxDescription'];
            
			$OptionsAttribute = $arryRow[$i]['OptionsAttribute'];
			$Weight = $arryRow[$i]['Weight'];
			
			$UploadedFile = $arryRow[$i]['UploadedFile'];
			
            $strSQLQuery = "insert into e_orderdetail(OrderID,ProductID,ProductName,ProductOptions,OptionsAttribute,Quantity ,Price, TaxRate, TaxDescription,Variant_ID,Variant_val_Id,AliasID,Weight,UploadedFile) 
			values('" . $OrderID . "','" . $ProductID . "','" . addslashes($ProductName) . "', '" . addslashes($ProductOptions) . "', '" . addslashes($OptionsAttribute) . "','" . $Quantity . "', '" . $Price . "', 
			'" . $TaxRate . "', '" . addslashes($TaxDescription) . "', '" . addslashes($Variant_ID) . "', '" . addslashes($Variant_val_Id) . "', '" . addslashes($AliasID) . "', '" . addslashes($Weight) . "', '" . addslashes($UploadedFile) . "')";
           $this->query($strSQLQuery, 0);

            //$strUpdateQuery = "update e_products set Quantity = Quantity - ".$Quantity." where ProductID = '".$ProductID."' and Quantity>0 ";
            //$this->query($strUpdateQuery, 0);
        }

        return $OrderID;
    }

    function UpdateOrder($arryDetails) {
        extract($arryDetails);

        $TotalQuantity = 0;
        $TotalPrice = 0;
        for ($i = 1; $i <= $numProducts; $i++) {
            $Quantity = 'Quantity' . $i;
            $Quantity = $$Quantity;
            $Price = 'Price' . $i;
            $Price = $$Price;
            $ProductID = 'ProductID' . $i;
            $ProductID = $$ProductID;

            $strSQLQuery = "update e_orderdetail set Quantity ='" . $Quantity . "', Price ='" . $Price . "' where OrderID='" . mysql_real_escape_string($OrderID) . "' and ProductID = '" . mysql_real_escape_string($ProductID) . "'";

            $this->query($strSQLQuery, 0);

            $TotalQuantity += $Quantity;
            $TotalPrice += ($Price * $Quantity) + $Tax + $ShipCharge;
        }

        $strSQLQuery = "update e_orders set TotalQuantity='" . $TotalQuantity . "',  TotalPrice='" . $TotalPrice . "', BillingEmail='" . addslashes($BillingEmail) . "', BillingName='" . addslashes($BillingName) . "', BillingCity='" . addslashes($BillingCity) . "', BillingStreet='" . addslashes($BillingStreet) . "', BillingZip='" . $BillingZip . "',BillingCountry='" . $BillingCountry . "', BillingPhone='" . addslashes($BillingPhone) . "', BillingDistrict='" . $BillingDistrict . "',  Tax='" . $Tax . "', Shipping ='" . $Shipping . "'
			where OrderID=" . $OrderID;

        $this->query($strSQLQuery, 0);

        return 1;
    }

    function isOrderExists($Email, $OrderID = 0) {
        $strSQLQuery = (!empty($OrderID)) ? (" and OrderID != '" . $OrderID . "'") : ("");
        $strSQLQuery = "select * from e_orders where LCASE(Email)='" . strtolower(trim($Email)) . "'" . $strSQLQuery;

        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['OrderID'])) {
            return true;
        } else {
            return false;
        }
    }

    function GetCountries() {
        $strSQLQuery = "select * from countries";
        return $this->query($strSQLQuery, 1);
    }

    function MaxOrderId() {
        $strSQLQuery = "select MAX(OrderID) as maxid from e_orders";

        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['maxid'])) {
            return $arryRow[0]['maxid'];
        } else {
            return 0;
        }
    }

    function CancelOrder($OrderID) {
        $strSQLQuery = "select * from e_orders where OrderID='" . $OrderID . "'";
        $arryRow = $this->query($strSQLQuery, 1);

        if (sizeof($arryRow) > 0) {
            $strSQLQuery = "select od.ProductID,o.Cid from e_orderdetail od inner join e_orders o on od.OrderID=o.OrderID inner join e_products p on od.ProductID=p.ProductID where od.OrderID='" . $OrderID . "'";
            $arryProducts = $this->query($strSQLQuery, 1);
            if (sizeof($arryProducts) > 0) {
                for ($i = 0; $i < sizeof($arryProducts); $i++) {
                    $sql = "insert ignore into wishlist (ProductID,Cid) values('" . $arryProducts[$i]['ProductID'] . "','" . $arryProducts[$i]['Cid'] . "' )";
                    $this->query($sql, 0);
                }
            }

            $sqlPay = "update e_orders set CancelStatus=1 where OrderID='" . $OrderID . "'";
            $this->query($sqlPay, 0);

            global $Config;

            $OrderUrl = $Config['Url'] . 'OrderDetails.php?OrderID=' . $OrderID;

            $Mesg = "Dear " . $arryRow[0]['BillingName'] . ",<br><br>Your order having the Order Number #" . $OrderID . ", dated " . date('d-m-Y', strtotime($arryRow[0]['OrderDate'])) . " has been cancelled on the website <a href='" . $Config['Url'] . "' target='_blank'>" . $Config['SiteName'] . "</a>.<br><bR>
			Please click the below link to view the order details <br><a href='" . $OrderUrl . "&opt=Buyer' target='_blank'>" . $OrderUrl . "&opt=Buyer</a>";

            $AdminMesg = "Order having the Order Number #" . $OrderID . " has been cancelled on the website <a href='" . $Config['Url'] . "' target='_blank'>" . $Config['SiteName'] . "</a>.<br><bR>
			Please click the below link to view the order details <br><a href='" . $OrderUrl . "' target='_blank'>" . $OrderUrl . "</a>";

            $htmlPrefix = eregi('admin', $_SERVER['PHP_SELF']) ? ("../html/") : ("html/");

            $contents = file_get_contents($htmlPrefix . "ack.htm");
            $contents = str_replace("[MAIL_CONTENT]", $Mesg, $contents);
            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($arryRow[0]['Email']);
            $mail->sender($Config['StoreName'], $Config['NotificationEmail']);
            $mail->Subject = $Config['StoreName'] . " - Order Number #" . $OrderID . " has been cancelled.";
            $mail->IsHTML(true);
            //echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
            $mail->Body = $contents;
            if ($Config['DbUser'] != 'root') {
                $mail->Send();
            }
            /*             * ************************************* */

            $contents = file_get_contents($htmlPrefix . "ack.htm");
            $contents = str_replace("[MAIL_CONTENT]", $AdminMesg, $contents);
            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($Config['CompanyEmail']);
            $mail->sender($Config['StoreName'], $Config['NotificationEmail']);
            $mail->Subject = $Config['StoreName'] . " - Order Number #" . $OrderID . " has been cancelled.";
            $mail->IsHTML(true);
            //echo $Config['AdminEmail'].$contents; exit;
            $mail->Body = $contents;
            if ($Config['DbUser'] != 'root') {
                $mail->Send();
            }
        }
        return 1;
    }

    function SendPaymentReminder($OrderID) {
        $strSQLQuery = "select * from e_orders where OrderID='" . $OrderID . "'";
        $arryRow = $this->query($strSQLQuery, 1);

        if (sizeof($arryRow) > 0) {

            global $Config;

            $OrderUrl = $Config['Url'] . 'OrderDetails.php?OrderID=' . $OrderID;

            $Mesg = "Dear " . $arryRow[0]['BillingName'] . ",<br><br>Your payment for order having the Order Number #" . $OrderID . ", dated " . date('d-m-Y', strtotime($arryRow[0]['OrderDate'])) . " is due on the website <a href='" . $Config['Url'] . "' target='_blank'>" . $Config['SiteName'] . "</a>.<br><bR>
			Please click the below link to view the order details <br><a href='" . $OrderUrl . "&opt=Buyer' target='_blank'>" . $OrderUrl . "&opt=Buyer</a><br><br>Please complete the payment as soon as possible otherwise your order will be cancelled and the items will be added to your wishlist so that you can purchase the items in the near future.";

            $htmlPrefix = eregi('admin', $_SERVER['PHP_SELF']) ? ("../html/") : ("html/");

            $contents = file_get_contents($htmlPrefix . "ack.htm");
            $contents = str_replace("[MAIL_CONTENT]", $Mesg, $contents);
            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($arryRow[0]['Email']);
            $mail->sender($Config['StoreName'], $Config['NotificationEmail']);
            $mail->Subject = $Config['StoreName'] . " - Payment for Order Number #" . $OrderID . " is due.";
            $mail->IsHTML(true);
            //echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
            $mail->Body = $contents;
            if ($Config['DbUser'] != 'root') {
                $mail->Send();
            }
        }
        return 1;
    }

    function PaymentDone($Cid, $OrderID, $PaymentGateway) {

        global $Config;
        $strSQLQuery = "select * from e_orders where OrderID='" . $OrderID . "' and PaymentStatus!=1";
        $arryRow = $this->query($strSQLQuery, 1);

        if (sizeof($arryRow) > 0) {
            $TrackNumber = $arryRow[0]['TrackNumber'];


            $objConfig = new admin();
            $arrayConfig = $objConfig->GetSiteSettings(1);


            $strSQLQuery333 = "select *  from e_payment_gateway where PaymetMethodId='" . trim($PaymentGateway) . "'";

            $arryRow333 = $this->query($strSQLQuery333, 1);
            $payment_gateway = $arryRow333[0]['PaymentMethodName'];


            $payment_method_detail = '<table border=0 cellpadding=3 cellspacing=0 >';

            $payment_method_detail .= '<tr><td><strong>Payment Method:</strong> </td><td>' . $payment_gateway . '</td></tr>';

            $payment_method_detail .= '</table>';


            $strAddQuery .= (!empty($id)) ? (" where OrderID=" . $id) : (" where 1");

            if (!empty($payment_gateway)) {

                if (strtolower($payment_gateway) == 'cash on delivery')
                    $PaymentStatus = '4';
                else
                    $PaymentStatus = '1';
                $sqlPay = "UPDATE e_orders SET OrderStatus = 'Process', ShippingStatus = 'Pending', PaymentStatus='" . addslashes($PaymentStatus) . "', PaymentGateway='" . $payment_gateway . "',PaymentGatewayID='" . $PaymentGateway . "' WHERE OrderID='" . $OrderID . "'";
                $this->query($sqlPay, 0);
            }


            $arryProducts = $this->GetOrderDetails($OrderID, $arryRow[0]['ProductIDs']);
            $numProducts = $this->numRows();

            /* add in sales order
             *
             */
           // $this->sync_order_in_sales($OrderID);
            

            $Tax = $arryRow[0]['Tax'];
            $shipPrice = $arryRow[0]['Shipping'];

            if (is_array($arryProducts) && $numProducts > 0) {


                $TOTAL = 0;
                $Count = 0;
                $ProductsDet = '';
				$virtualFile=array();
                for ($i = 0; $i < sizeof($arryProducts); $i++) {
					if($arryProducts[$i]['product_type']=='Virtual'){
						$virtualFile[$i]['secure_type']=$arryProducts[$i]['secure_type'];
						$virtualFile[$i]['virtual_file']=$arryProducts[$i]['virtual_file'];
					}
                    $Count++;
                    $j = $i + 1;
                    $SubTotal += ($arryProducts[$i]['Quantity'] * $arryProducts[$i]['Price']);
                    $TotalQuantity += $arryProducts[$i]['Quantity'];

                    // added by karishma on 6 oct 
                    $variantData = '';
                    if ($arryProducts[$i]['Variant_ID'] != '') {
                        $objVariant = new varient();
                        $Variant_IDArray = explode(',', $arryProducts[$i]['Variant_ID']);
                        $Variant_val_IdArray = json_decode($arryProducts[$i]['Variant_val_Id'], true);

                        $variantData .= ' <br> ' . Configure . ':';

                        foreach ($Variant_IDArray as $key => $val) {
                            $variants = $objVariant->GetVariantDispaly($val);
                            if (is_array($Variant_val_IdArray[$val])) {

                                $vals = implode(',', $Variant_val_IdArray[$val]);
                            } else {

                                $vals = $Variant_val_IdArray[$val];
                            }

                            $variantData .= $variants[0]['variant_name'] . '(' . $vals . ')<br>';
                        }
                    }

                    $ProductsDet .='<tr>
                 <td height="25" colspan="2" align="left" valign="top"  ><SPAN>' . $arryProducts[$i]['ProductName'] . '</SPAN><br>' . $variantData . '</td>
                 <td height="25" align="center" valign="top"  >' . $arryProducts[$i]['Quantity'] . '</td>
                 <td height="25" align="center" valign="top"  >' . display_price($arryProducts[$i]['Price'], '', '', '', '')  . '<br>';
                    if ($arryProducts[$i]['TaxRate'] > 0)
                        $ProductsDet .='<span><b>' . $arryProducts[$i]['TaxDescription'] . '</b></span>';
                    else
                        $ProductsDet .='<span><i>(Not Taxable)</i></span>';
                    $ProductsDet .='</td>
                    <td height="25" align="center" valign="top"  >' .  display_price($arryProducts[$i]['Quantity'] * $arryProducts[$i]['Price'], '', '', '', '') . '</td>
                   </tr>';
                }




                $ProductsDet .='<tr>
            <td align="right" colspan="5">Sub Total:  ' . display_price($SubTotal, '', '', '', '') . '</td>
                </tr>';


                if ($arryRow[0]['DiscountAmount'] > 0) {
                    $ProductsDet .='<tr>
                            <td align="right" colspan="5">Discount:  - ' . display_price($arryRow[0]['DiscountAmount'], '', '', '', '')  . ' </td>
                                </tr>';
                }
                if ($arryRow[0]['PromoDiscountAmount'] > 0) {
                    $ProductsDet .='<tr>
                            <td align="right" colspan="5">Coupon Discount:  - ' . display_price($arryRow[0]['PromoDiscountAmount'], '', '', '', '')  . ' </td>
                                </tr>';
                }

                $sTotal = $SubTotal;
                $Total = $sTotal + $shipPrice + $Tax - $arryRow[0]['DiscountAmount'] - $arryRow[0]['PromoDiscountAmount'];
                $Total = number_format($Total, 2, '.', '');



                if ($Tax > 0) {
                    $ProductsDet .='<tr>
                            <td align="right" colspan="5">Tax:  ' . display_price($Tax, '', '', '', '')  . ' </td>
                                </tr>';
                }

                if ($shipPrice > 0) {
                    $ProductsDet .='<tr>
                       <td align="right" colspan="5">Shipping Amount:  ' . display_price($shipPrice, '', '', '', ''). ' </td>
                           </tr>';
                }
                
            }  //echo $ProductsDet;
            //exit;
$randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
		if($virtualFile[0]['secure_type']=='Secure'){
		$pdfpas="<b>PDF Document password is:".$randomString."</b>";
		}
            $StoreUrl = $Config['homeCompleteUrl'] . '/index.php';
            $cont = "Dear " . $arryRow[0]['BillingName'] . ",<br><br>Thanks for your interest in the selected product(s) from the store <a href='" . $StoreUrl . "' target='_blank'>" . stripslashes($Config['StoreName']) . "</a> on " . $Config['SiteName'] . ".<br><br>We have received the following order:<br><br>".$pdfpas;
            $htmlPrefix = $Config['EmailTemplateFolder'];

            /*             * ** Email to  Customer ***** */
            $contents = file_get_contents($htmlPrefix . "paymentOrder.htm");
            $contents = str_replace("[CONTENT]", $cont, $contents);
            $contents = str_replace("[FULLNAME]", $arryRow[0]['BillingName'], $contents);
            $contents = str_replace("[ORDERID]", $OrderID, $contents);
            $contents = str_replace("[TrackNumber]", $TrackNumber, $contents);
            $contents = str_replace("[AMOUNT]", display_price_symbol($Total, $arryRow[0]['CurrencySymbol']), $contents);
            $contents = str_replace("[Date]", $Config['TodayDate'], $contents);
            $contents = str_replace("[Phone]", $arryRow[0]['Phone'], $contents);
            $contents = str_replace("[Email]", $arryRow[0]['Email'], $contents);
            $contents = str_replace("[Billing Name]", $arryRow[0]['BillingName'], $contents);
            $contents = str_replace("[Billing Add]", $arryRow[0]['BillingAddress'], $contents);
            $contents = str_replace("[Billing City]", $arryRow[0]['BillingCity'], $contents);
            $contents = str_replace("[Billing State]", $arryRow[0]['BillingState'], $contents);
            $contents = str_replace("[Billing Country]", $arryRow[0]['BillingCountry'], $contents);
            $contents = str_replace("[Billing Zip]", $arryRow[0]['BillingZip'], $contents);
            $contents = str_replace("[Shipping Name]", $arryRow[0]['ShippingName'], $contents);
            $contents = str_replace("[Shipping Add]", $arryRow[0]['ShippingAddress'], $contents);
            $contents = str_replace("[Shipping City]", $arryRow[0]['ShippingCity'], $contents);
            $contents = str_replace("[Shipping Country]", $arryRow[0]['ShippingCountry'], $contents);
            $contents = str_replace("[Shipping State]", $arryRow[0]['ShippingState'], $contents);
            $contents = str_replace("[Shipping Zip]", $arryRow[0]['ShippingZip'], $contents);
            $contents = str_replace("[ProductsDet]", $ProductsDet, $contents);

            $contents = str_replace("[URL]", $StoreUrl, $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);

            $contents = str_replace("[PAYMENT_GATWAY]", $payment_gateway, $contents);
            $contents = str_replace("[SHIPPING_METHOD_DETAIL]", '<b>Shipping Method: </b>' . $arryRow[0]['ShippingMethod'], $contents);
            $contents = str_replace("[PAYMENT_METHOD_DETAIL]", $payment_method_detail, $contents);
	   //require_once('excel/PHPExcel.php');
			
            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($arryRow[0]['Email']);
            $mail->sender($Config['StoreName'], $Config['NotificationEmail']);
            $mail->Subject = $Config['StoreName'] . " - New Order Received - Order No." . $OrderID;
            $mail->IsHTML(true);
            for($i=0;$i<count($virtualFile);$i++){
				//echo $virtualFile[$i]['secure_type']; exit;
				//echo $virtualFile[$i]['virtual_file'];
				//$file_to_attach = "http://199.227.27.197/ecomstandalone/upload/products/document/".$Config['CmpID']."/";
				//$file_to_attach =getcwd().'/upload/products/document/'.$Config['CmpID'].'/150.xlsx';//.$virtualFile[$i]['virtual_file'];	
			if($virtualFile[$i]['secure_type']=="Secure"){
		
				$password =$randomString;
        #$origFile =getcwd().'/var/www/html/erp/upload/products/document/'.$Config['CmpID'].'/'.$virtualFile[$i]['virtual_file'];
				#$destFile =getcwd().'/var/www/html/erp/upload/products/document/'.$Config['CmpID'].'/'.time().$virtualFile[$i]['virtual_file'];
				$origFile ='/var/www/html/erp/upload/products/document/'.$Config['CmpID'].'/'.$virtualFile[$i]['virtual_file'];
				$destFile ='/var/www/html/erp/upload/products/document/'.$Config['CmpID'].'/'.time().$virtualFile[$i]['virtual_file'];
        //echo $origFile." == ".$destFile; exit;
				$this->pdfEncrypt($origFile, $password, $destFile);
			} else{
				//$destFile =getcwd().'/var/www/html/erp/upload/products/document/'.$Config['CmpID'].'/'.$virtualFile[$i]['virtual_file'];
$destFile ='/var/www/html/erp/upload/products/document/'.$Config['CmpID'].'/'.$virtualFile[$i]['virtual_file'];
			}
			//encrypt the book and create the protected file
				
				//$workbook = new PHPExcel();
				//$workbook =  $reader->load($file_to_attach);
				//$workbook->getSecurity()->setLockWindows(true);
				//$workbook->getSecurity()->setLockStructure(true);
				//$workbook->getSecurity()->setWorkbookPassword('123');

				//echo $file_to_attach; die('sdadasdasdsa');
			//print_r($Config);
				 $mail->addAttachment($destFile);
			 //$mail->addAttachment($file_to_attach, '150.xlsx', $encoding = 'base64', $type = 'application/octet-stream'/*$virtualFile[$i]['virtual_file']*/); 
			}
			//AddStringAttachment($file_to_attach, "150.xlsx", $encoding = 'base64', $type = 'application/octet-stream')
			
            $mail->Body = $contents;


            //echo $arryRow[0]['Email']."=>".$contents."=>".$Config['CompanyEmail']; exit;
            if ($Config['Online'] == '1') {

                $mail->Send();

            }


            /*             * ** Email to  admin ***** */
            $cont = "An order has been processed on your website <a href='" . $StoreUrl . "' target='_blank'>" . $Config['StoreName'] . "</a>.";

            $contents = file_get_contents($htmlPrefix . "paymentOrder.htm");

            $contents = str_replace("[FULLNAME]", $arryRow[0]['BillingName'], $contents);
            $contents = str_replace("[CONTENT]", $cont, $contents);
            $contents = str_replace("[ORDERID]", $OrderID, $contents);
            $contents = str_replace("[TrackNumber]", $TrackNumber, $contents);
            $contents = str_replace("[AMOUNT]", display_price_symbol($Total, $arryRow[0]['CurrencySymbol']), $contents);
            $contents = str_replace("[Date]", $Config['TodayDate'], $contents);
            $contents = str_replace("[Phone]", $arryRow[0]['Phone'], $contents);
            $contents = str_replace("[Email]", $arryRow[0]['Email'], $contents);
            $contents = str_replace("[Billing Name]", $arryRow[0]['BillingName'], $contents);
            $contents = str_replace("[Billing Add]", $arryRow[0]['BillingAddress'], $contents);
            $contents = str_replace("[Billing City]", $arryRow[0]['BillingCity'], $contents);
            $contents = str_replace("[Billing State]", $arryRow[0]['BillingState'], $contents);
            $contents = str_replace("[Billing Country]", $arryRow[0]['BillingCountry'], $contents);
            $contents = str_replace("[Billing Zip]", $arryRow[0]['BillingZip'], $contents);
            $contents = str_replace("[Shipping Name]", $arryRow[0]['ShippingName'], $contents);
            $contents = str_replace("[Shipping Add]", $arryRow[0]['ShippingAddress'], $contents);
            $contents = str_replace("[Shipping City]", $arryRow[0]['ShippingCity'], $contents);
            $contents = str_replace("[Shipping Country]", $arryRow[0]['ShippingCountry'], $contents);
            $contents = str_replace("[Shipping State]", $arryRow[0]['ShippingState'], $contents);
            $contents = str_replace("[Shipping Zip]", $arryRow[0]['ShippingZip'], $contents);
            $contents = str_replace("[ProductsDet]", $ProductsDet, $contents);

            $contents = str_replace("[URL]", $StoreUrl, $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);

            $contents = str_replace("[PAYMENT_GATWAY]", $payment_gateway, $contents);
            $contents = str_replace("[PAYMENT_METHOD_DETAIL]", $payment_method_detail, $contents);
            $contents = str_replace("[SHIPPING_METHOD_DETAIL]", '<b>Shipping Method: </b>' . $arryRow[0]['ShippingMethod'], $contents);

            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($Config['CompanyEmail']);
            $mail->sender($Config['StoreName'], $Config['NotificationEmail']);
            $mail->Subject = $Config['StoreName'] . " - New Order Processed - Order No." . $OrderID;
            $mail->IsHTML(true);
            $mail->Body = $contents;
            if ($Config['Online'] == '1') {
                $mail->Send();
            }
            //echo $arryRow22[0]['Email'].$contents; exit;
        }

        return 1;
    }

    function emailOrderCompleted($OrderID) {
        global $Config;

        $arryCartSetting = $this->getCartsettings();
        $settings = array();

        foreach ($arryCartSetting as $field) {
            $settings[$field["Name"]] = $field["Value"];
        }

        $Config['StoreName'] = $settings['StoreName'];
        $Config['CompanyEmail'] = $settings['CompanyEmail'];
        $Config['NotificationEmail'] = $settings['NotificationEmail'];

        $strSQLQuery = "select * from e_orders where OrderID='" . $OrderID . "'";
        //echo $strSQLQuery;
        //exit;
        $arryRow = $this->query($strSQLQuery, 1);
        $arryProducts = $this->GetOrderDetails($OrderID, $arryRow[0]['ProductIDs']);
        $numProducts = $this->numRows();
        if (is_array($arryProducts) && $numProducts > 0) {

            $TOTAL = 0;
            $Count = 0;

            for ($i = 0; $i < sizeof($arryProducts); $i++) {
                //foreach($arryProducts as $key=>$arryProducts[$i]){

                $Count++;
                $j = $i + 1;
                $SubTotal += ($arryProducts[$i]['Quantity'] * $arryProducts[$i]['Price']);
                $TotalQuantity += $arryProducts[$i]['Quantity'];




                $ProductsDet = '<tr>
         		<td height="25" colspan="2" align="left" valign="top"  ><SPAN >' . $arryProducts[$i]['ProductName'] . '</SPAN></td><td height="25" align="center" valign="top"  >' . $arryProducts[$i]['Quantity'] . '</td><td height="25" align="center" valign="top"  >&pound;' . display_price_symbol($arryProducts[$i]['Price'], $arryRow[0]['CurrencySymbol']) . '</td><td height="25" align="center" valign="top"  >&pound;' . number_format($arryProducts[$i]['Quantity'] * $arryProducts[$i]['Price'], 2, '.', '') . '</td></tr>';
            }

            $Tax = $arryRow[0]['Tax'];
            $shipPrice = $arryRow[0]['Shipping'];
            $discountAmount = $arryRow[0]['DiscountAmount'];
            $promoDiscountAmount = $arryRow[0]['PromoDiscountAmount'];


            $sTotal = $SubTotal;
            $Total = number_format(($sTotal + $shipPrice + $Tax - $discountAmount - $promoDiscountAmount), 2, '.', '');

            $ProductsDet .='<tr><td height="30" align="right"  colspan="5" >Sub Total   :  ' . display_price_symbol($SubTotal, $arryRow[0]['CurrencySymbol']) . '</td></tr>';
            if ($discountAmount > 0) {
                $ProductsDet .='<tr><td height="30" align="right"  colspan="5" >Discount   :  -' . display_price_symbol($discountAmount, $arryRow[0]['CurrencySymbol']) . '</td></tr>';
            }
            if ($promoDiscountAmount > 0) {
                $ProductsDet .='<tr><td height="30" align="right"  colspan="5" >Coupon Discount   :  -' . display_price_symbol($promoDiscountAmount, $arryRow[0]['CurrencySymbol']) . '</td></tr>';
            }
            $ProductsDet .='<tr><td colspan="5" align="right"  >Shipping   Charges   :  ' . display_price_symbol($shipPrice, $arryRow[0]['CurrencySymbol']) . '&nbsp;</td></tr>';
            $ProductsDet .='<tr><td colspan="5" align="right"  >Tax   :  ' . display_price_symbol($Tax, $arryRow[0]['CurrencySymbol']) . '&nbsp;</td></tr>';
        }  //echo $ProductsDet;
        //exit;


        $cont = "Your order has been dispatched successfully !!";
        $StoreUrl = $Config['homeCompleteUrl'] . '/index.php';
        $htmlPrefix = $Config['EmailTemplateFolder'];

        /**         * * Email to  Customer ***** */
        $contents = file_get_contents($htmlPrefix . "OrderCompleted.htm");

        $FullName = $arryRow[0]['BillingName'];
        $contents = str_replace("[FULLNAME]", $FullName, $contents);
        $contents = str_replace("[CONTENT]", $cont, $contents);
        $contents = str_replace("[ORDERID]", $OrderID, $contents);
        $contents = str_replace("[AMOUNT]", display_price_symbol($Total, $arryRow[0]['CurrencySymbol']), $contents);
        $contents = str_replace("[Date]", $Config['TodayDate'], $contents);
        $contents = str_replace("[Phone]", $arryRow[0]['Phone'], $contents);
        $contents = str_replace("[Email]", $arryRow[0]['Email'], $contents);
        $contents = str_replace("[Billing Name]", $arryRow[0]['BillingName'], $contents);
        $contents = str_replace("[Billing Add]", $arryRow[0]['BillingAddress'], $contents);
        $contents = str_replace("[Billing City]", $arryRow[0]['BillingCity'], $contents);
        $contents = str_replace("[Billing State]", $arryRow[0]['BillingState'], $contents);
        $contents = str_replace("[Billing Country]", $arryRow[0]['BillingCountry'], $contents);
        $contents = str_replace("[Billing Zip]", $arryRow[0]['BillingZip'], $contents);
        $contents = str_replace("[Shipping Name]", $arryRow[0]['ShippingName'], $contents);
        $contents = str_replace("[Shipping Add]", $arryRow[0]['ShippingAddress'], $contents);
        $contents = str_replace("[Shipping City]", $arryRow[0]['ShippingCity'], $contents);
        $contents = str_replace("[Shipping Country]", $arryRow[0]['ShippingCountry'], $contents);
        $contents = str_replace("[Shipping State]", $arryRow[0]['ShippingState'], $contents);
        $contents = str_replace("[Shipping Zip]", $arryRow[0]['ShippingZip'], $contents);
        $contents = str_replace("[ProductsDet]", $ProductsDet, $contents);
        $contents = str_replace("[DATE]", date("jS, F Y"), $contents);

        $contents = str_replace("[URL]", $Config['Url'], $contents);
        $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
        $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);


        $mail = new MyMailer();
        $mail->IsMail();
        $mail->AddAddress($arryRow[0]['Email']);
        $mail->sender($Config['StoreName'], $Config['NotificationEmail']);
        $mail->Subject = $Config['StoreName'] . " - Order delivery information";
        $mail->IsHTML(true);
        $mail->Body = $contents;

        if ($Config['Online'] == '1') {
            $mail->Send();
        }

        return 1;
    }

    function GetTrackMsg($TrackNumber) {
        $strSQLQuery = "select * from e_orders where TrackNumber='" . $TrackNumber . "'";
        return $this->query($strSQLQuery, 1);
    }

    function UpdateTrackMsg($arryDetails) {
        extract($arryDetails);

        $sql_discount = "update e_orders set TrackNumber='" . $TrackNumber . "', TrackMsg='" . addslashes($TrackMsg) . "',TrackMsgDate='" . date('Y-m-d H:i:s') . "' where OrderID='" . $OrderID . "'";
        $this->query($sql_discount, 0);

        return 1;
    }

    function getCartsettings() {
        $sqlSettings = "SELECT * FROM e_settings WHERE Visible='Yes'";
        return $this->query($sqlSettings, 1);
    }

    function getOrderAmountByDate($orderdate) {
        global $Config;
        //echo "=>".$Config['Currency'];exit;
        /* $strSQLQuery = "SELECT SUM(TotalPrice) as OrderTotal FROM e_orders WHERE DATE(OrderDate) = '".trim($orderdate)."' AND PaymentStatus=1 AND OrderStatus='Completed'";
          $arrayRow =  $this->query($strSQLQuery, 1); */
        $strSQLQuery = "SELECT TotalPrice,Currency FROM e_orders WHERE DATE(OrderDate) = '" . trim($orderdate) . "' AND PaymentStatus=1 AND OrderStatus='Completed'";
        $rs = $this->query($strSQLQuery, 1);
        for ($i = 0; $i <= count($rs); $i++) {
            if ($rs[$i]['TotalPrice'] > 0 && $Config['Currency'] != $rs[$i]['Currency']) {
                $avgCost += CurrencyConvertor($rs[$i]['TotalPrice'], $rs[$i]['Currency'], $Config['Currency']);
            } else {
                $avgCost += $rs[$i]['TotalPrice'];
            }
        }

        return ceil($avgCost);

        //return $arrayRow[0]['OrderTotal'];
    }

    function totalSale() {
        $strSQLQuery = "SELECT SUM(TotalPrice) as OrderTotal FROM e_orders WHERE PaymentStatus=1 AND OrderStatus='Completed'";
        $arrayRow = $this->query($strSQLQuery, 1);
        return $arrayRow[0]['OrderTotal'];
    }

    function totalSaleCurrentYear() {
        $strSQLQuery = "SELECT SUM(TotalPrice) as OrderTotal FROM e_orders WHERE (DATE(OrderDate) BETWEEN '" . date('Y') . '-1-1' . "' AND '" . date('Y') . '-12-31' . "') AND PaymentStatus=1 AND OrderStatus='Completed'";
        $arrayRow = $this->query($strSQLQuery, 1);
        return $arrayRow[0]['OrderTotal'];
    }

    function getLatestFiveOrders() {

        $strAddQuery .= " ORDER BY OrderID Desc LIMIT 0,5 ";


        $strSQLQuery = "SELECT o.OrderID,o.TotalPrice,o.OrderStatus,o.PaymentStatus,o.OrderDate,c.FirstName,c.LastName,c.Cid from e_orders AS o LEFT JOIN e_customers AS c ON c.Cid = o.Cid " . $strAddQuery;
        //echo "=>".$strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    function exportOrders() {

        $strSQLQuery = "SELECT o.*,c.FirstName,c.LastName,c.Cid, od.ProductID,od.ProductName,od.ProductOptions,od.Quantity,od.Price FROM e_orders o INNER JOIN e_orderdetail od ON o.OrderID = od.OrderID LEFT JOIN e_customers c ON o.Cid=c.Cid GROUP BY o.OrderID  ORDER BY o.OrderID ASC";
        return $this->query($strSQLQuery);
    }

    function sync_order_in_sales($OrderID) {
    	global $Config;
        if ($OrderID != '') {

            $sql = "SELECT o.* FROM e_orders as o
			where o.OrderID='" . addslashes($OrderID) . "' ";
            $orderres = $this->query($sql, 1);



            $Cid = $_SESSION['Cid'];
            $sql = "SELECT * FROM e_customers where Cid='" . addslashes($Cid) . "' ";
            $customerRes = $this->query($sql, 1);

            $arryDetails['Email'] = $customerRes['0']['Email'];
            $arryDetails['FirstName'] = $customerRes['0']['FirstName'];
            $arryDetails['LastName'] = $customerRes['0']['LastName'];
            $arryDetails['Phone'] = $customerRes['0']['Phone'];
            $arryDetails['Company'] = $customerRes['0']['Company'];

            list($CustID, $CustCode, $CustomerName, $CustomerCompany) = $this->sync_customer_in_sales($arryDetails);

            $SqlOrder = "INSERT INTO s_order SET
			OrderDate = '" . addslashes($orderres['0']['OrderDate']) . "',
			Module = 'Order',
			CustID = '" . addslashes($CustID) . "',
			CustCode = '" . addslashes($CustCode) . "',
			CustomerCurrency = '" . addslashes($orderres['0']['Currency']) . "',
			Status = 'Open',
			Approved = '1',
			DeliveryDate = '" . addslashes($orderres['0']['DelivaryDate']) . "',
			PaymentMethod = '" . addslashes($orderres['0']['PaymentGateway']) . "',			
			TotalAmount = '" . addslashes($orderres['0']['TotalPrice']) . "',
			CustomerName = '" . addslashes($CustomerName) . "',
			CustomerCompany = '" . addslashes($CustomerCompany) . "',
			BillingName = '" . addslashes($orderres['0']['BillingName']) . "',
			Address = '" . addslashes($orderres['0']['BillingAddress']) . "',
			City = '" . addslashes($orderres['0']['BillingCity']) . "',
			State = '" . addslashes($orderres['0']['BillingState']) . "',
			Country = '" . addslashes($orderres['0']['BillingCountry']) . "',
			ZipCode = '" . addslashes($orderres['0']['BillingZip']) . "',
			Mobile = '" . addslashes($orderres['0']['Phone']) . "',
			Email = '" . addslashes($orderres['0']['Email']) . "',
			ShippingName = '" . addslashes($orderres['0']['ShippingName']) . "',
			ShippingCompany = '" . addslashes($orderres['0']['ShippingCompany']) . "',
			ShippingAddress = '" . addslashes($orderres['0']['ShippingAddress']) . "',
			ShippingCity = '" . addslashes($orderres['0']['ShippingCity']) . "',
			ShippingState = '" . addslashes($orderres['0']['ShippingState']) . "',
			ShippingCountry = '" . addslashes($orderres['0']['ShippingCountry']) . "',
			ShippingZipCode = '" . addslashes($orderres['0']['ShippingZip']) . "',			
			ShippingMobile = '" . addslashes($orderres['0']['ShippingPhone']) . "',
			discountAmnt = '" . addslashes($orderres['0']['DiscountAmount']) . "',
			taxAmnt = '" . addslashes($orderres['0']['Tax']) . "',
			SalesPersonID = '" . addslashes($Config['CmpID']) . "',
			AdminID = '" . addslashes($Config['CmpID']) . "',
			ecom_order_id = '" . addslashes($OrderID) . "'";

            $this->query($SqlOrder, 0);
            $saleorderId = $this->lastInsertId();
            $SaleID = 'SO000' . $saleorderId;
            $sql = "update s_order set SaleID = '" . mysql_real_escape_string($SaleID) . "'
			 where OrderID='" . addslashes($saleorderId) . "'";
            $this->query($sql, 0);

            $sql = "SELECT od.*,CASE  WHEN od.AliasID = '0' THEN p.ProductSku   ELSE b.ItemAliasCode END as ProductSku,p.Quantity as stockQuantity FROM e_orderdetail as od
			inner join e_products p on p.ProductID=od.ProductID
			left join e_item_alias b on b.ProductID=p.ProductID and b.AliasID=od.AliasID
			where od.OrderID='" . addslashes($OrderID) . "' ";
            $orderitemsres = $this->query($sql, 1);

            for ($count = 0; $count < count($orderitemsres); $count++) {
                $SqlOrderitem = "INSERT INTO s_order_item SET
			OrderID = '" . addslashes($saleorderId) . "',
			item_id = '" . addslashes($orderitemsres[$count]['ProductID']) . "',
			sku = '" . addslashes($orderitemsres[$count]['ProductSku']) . "',
			description = '" . addslashes($orderitemsres[$count]['ProductName']) . "',
			qty = '" . addslashes($orderitemsres[$count]['Quantity']) . "',	
			on_hand_qty = '" . addslashes($orderitemsres[$count]['stockQuantity']) . "',					
			amount = '" . addslashes($orderitemsres[$count]['Price']) . "',
			tax = '" . addslashes($orderitemsres[$count]['TaxRate']) . "',
			UploadedFile = '" . addslashes($orderitemsres[$count]['UploadedFile']) . "'";
            
                $this->query($SqlOrderitem, 0);
            }
        }
    }

    function sync_customer_in_sales($arryDetails) {
        @extract($arryDetails);
        global $Config;

        /* check email exist or not if exit return sales customer id
         * or insert customer and return inserted customer id		 *
         */

        $sql = "select count(*) as total,Cid,CustCode,FullName,Company from s_customers where Email='" . addslashes($Email) . "' ";
        $res = $this->query($sql, 1);

        if ($res['0']['total'] == '0') {

            // add new
            $ipaddress = $_SERVER["REMOTE_ADDR"];
            $FullName = $FirstName . ' ' . $LastName;

            $SqlCustomer = "INSERT INTO s_customers SET
			CustomerType = 'Individual', 
			Company = '" . mysql_real_escape_string(strip_tags($Company)) . "',
			FirstName='" . mysql_real_escape_string(strip_tags($FirstName)) . "',
			LastName = '" . mysql_real_escape_string(strip_tags($LastName)) . "', 
			FullName = '" . mysql_real_escape_string(strip_tags($FullName)) . "', 
			Gender = 'Male', 
			 
			Mobile = '" . mysql_real_escape_string($Phone) . "', 
			Email = '" . mysql_real_escape_string(strip_tags($Email)) . "', 
			CreatedDate = '" . mysql_real_escape_string($Config['TodayDate']) . "', 
			ipaddress = '" . $ipaddress . "', 
			Status='Yes' ";

            $this->query($SqlCustomer, 0);



            $customerId = $this->lastInsertId();

            $CustCode = 'CUST00' . $customerId;

            $sql = "update s_customers set CustCode = '" . mysql_real_escape_string($CustCode) . "'
			 where Cid='" . addslashes($customerId) . "'";
            $this->query($sql, 0);
            return array($customerId, $CustCode, $FullName, $Company);
        } else {
            return array($res['0']['Cid'], $res['0']['CustCode'], $res['0']['FullName'], $res['0']['Company']);
        }
    }
    
	function  GetOptionVal($id) 
		{
		$strAddQuery .= (!empty($id))?(" and Id='".$id."'"):("");
				           
		$strSQLQuery = "select Id,title,PriceType,Price,Weight,concat(title,'(',IF(Price = '', 0, Price) ,',',IF(Weight = '', 0, Weight) ,')') as options from  e_global_optionList where   1 ".$strAddQuery." order by id asc";
		       
		return $this->query($strSQLQuery, 1);
           
		}

}

?>
