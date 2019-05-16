<?php
class discount extends dbClass
{
            //constructor
            function discount()
            {
                    $this->dbClass();
            } 

            function  getDiscounts()
            {
                    $strSQLQuery = "SELECT * FROM e_discounts ORDER BY DID";
                    return $this->query($strSQLQuery, 1);
            }
            
            
          function updateDiscounts($arryDetails)
          {
                extract($arryDetails);
                $min_values = isset($min_values)?(is_array($min_values)?$min_values:array()):array();
		$max_values = isset($max_values)?(is_array($max_values)?$max_values:array()):array();
		$discounts = isset($discounts)?(is_array($discounts)?$discounts:array()):array();
		$types = isset($types)?(is_array($types)?$types:array()):array();
		$active = isset($active)?(is_array($active)?$active:array()):array();

		foreach ($min_values as $id=>$min)
		{
                    $activediscount = array_key_exists($id, $active)?"Yes":"No";
                    
                        $strSQLQuery = "UPDATE  e_discounts SET Min = '".$this->normalizeNumber($min_values[$id])."',Max = '".$this->normalizeNumber($max_values[$id])."',
                            Discount = '".$this->normalizeNumber($discounts[$id])."', Type = '".$types[$id]."', Active = '".$activediscount."' WHERE DID ='".$id."'";
                      
                        $this->query($strSQLQuery, 0);
		}
                
		
                 $strSQLQuery =  "UPDATE e_settings SET Value='".$DiscountsActive."' WHERE Name = 'DiscountsActive'";
                   
                 $this->query($strSQLQuery, 0);
                 
                 return $DiscountsActive;
          }
         
          
        function getDiscountAmount($subtotal,$Cid)
	{
		
                    global $Config;
            
                    $discountAmount = 0;
                    $discountValue = 0;
                    $discountType = "none";
		    $discountDetails  = array();
        
                    $arryCartSetting = $this->getCartsettings();
                    $settings = array();

                    foreach($arryCartSetting as $field)
                    {
                       $settings[$field["Name"]] = $field["Value"];
                    }

                  
                 
			if ($settings["DiscountsActive"] == "Yes")
			{
				$strSQLQuery = "SELECT * FROM e_discounts WHERE Active='Yes' AND ".$subtotal.">=Min AND ".$subtotal."<=Max ORDER BY DID";
                                //echo "=>".$strSQLQuery;
				$arrayRow = $this->query($strSQLQuery, 1);
				if (count($arrayRow) > 0)
				{
					$discountType = $arrayRow[0]["Type"];
					$discountValue = $arrayRow[0]["Discount"];
					
					switch($discountType)
					{
						case "percent" : 
						{
							$discountAmount = round($subtotal / 100 * $discountValue, 2);
							break;
						}
						case "amount" :
						{
							$discountValue = round($discountValue, 2);
							$discountAmount = $discountValue;
							break;
						}
					}
				}
			}
		$discountDetails['discountAmount'] = $discountAmount;
                $discountDetails['discountValue'] = $discountValue;
                $discountDetails['discountType'] = $discountType;
		
		return $discountDetails;
	}
            
      
	function normalizeNumber($number)
	{
		$s = "";
		$a = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
		$is_dot = false;
		$number = trim($number);
		if ($number != "")
		{
			if ($number[0] == "-")
			{
				$s = "-";
				$start = 1;	
			}
			else
			{
				$start = 0;	
			}
			for ($i = $start; $i < strlen($number); $i++)
			{
				$s.=in_array($number[$i], $a)?$number[$i]:"";
				if ($number[$i] == "." && ($is_dot == false))
				{
					$s.=".";
					$is_dot = true;
				}
			}
		}
		else
		{
			$s = 0;
		}
		return $s;
	}
	
	
	function myNum($j)
	{
		if ($j == "" || $j == 0) return "0";
		for ($i=2; $i<=5; $i++)
		{
			if(number_format($j, $i, ".", "")*1 == $j) return number_format($j, $i, ".", "");
		}
		return number_format($j, 5, ".", "");
	}
        
        function getCartsettings()
        {
             $sqlSettings =  "SELECT * FROM e_settings WHERE Visible='Yes'";
             return $this->query($sqlSettings, 1);
        }
        
        //START FUNCTIONS FOR COUPON CODES
        
        function getCouponCodes($id=0,$Status=0,$SearchKey,$SortBy,$AscDesc)
        {
				$sql = '';
				$SearchKey   = strtolower(trim($SearchKey));
				$sql .= (!empty($id))?(" where PromoID=".$id):(" where 1");
				$sql .= ($Status>0)?(" and Status=".$Status." and Status=1  "):("");
				if($SearchKey=='active' && ($SortBy=='Status' || $SortBy=='') ){
				$sql .= " and Active='Yes'"; 
				}else if($SearchKey=='inactive' && ($SortBy=='Status' || $SortBy=='') ){
				$sql .= " and Active='No'";
				}else if($SortBy != ''){
				$sql .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
				}else{
				$sql .= (!empty($SearchKey))?(" and (Name like '".$SearchKey."%' OR PromoCode like '".$SearchKey."%') "):("");
				}
				$sql .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by PromoID ");
				$sql .= (!empty($AscDesc))?($AscDesc):(" Desc");
				
				 $sqlSettings =  "SELECT * FROM e_promo_codes ".$sql.""; 
				 //echo "=>".$sqlSettings;
				 return $this->query($sqlSettings, 1);
            
        }
        
        function getCouponCodeByID($promoID)
        {
             $sqlSettings =  "SELECT * FROM e_promo_codes WHERE PromoID = '".$promoID."'";
             return $this->query($sqlSettings, 1);
            
        }
        
        function addCouponCode($arryDetails)
        {
            
            extract($arryDetails);
            
            foreach($CustomerGroupID as $gid)
            {
                $CustomerGroupIDAll .= $gid.",";
            }
            
             //echo "=>".$CustomerGroupIDAll;exit;
            
             $CustomerGroupIDAll = substr($CustomerGroupIDAll,"0",-1);
            
             $strSQLQuery = "INSERT INTO e_promo_codes SET Name = '".addslashes($Name)."', PromoCode = '".addslashes($PromoCode)."',
                            PromoType = '".$PromoType."', CustomerGroupID = '".$CustomerGroupIDAll."', DateStart = '".$DateStart."', DateStop = '".$DateStop."', Active = '".$Active."', MinAmount = '".$MinAmount."', Discount = '".$Discount."', DiscountType = '".$DiscountType."',UsesTotal='".$UsesTotal."',UsesCustomer='".$UsesCustomer."'";
                    
               $this->query($strSQLQuery, 1);
               $promoID = $this->lastInsertId();
               return $promoID;
        }
        
        function updateCouponCode($arryDetails)
        {
            
            extract($arryDetails);
            
            foreach($CustomerGroupID as $gid)
            {
                $CustomerGroupIDAll .= $gid.",";
            }
            
             //echo "=>".$CustomerGroupIDAll;exit;
            
             $CustomerGroupIDAll = substr($CustomerGroupIDAll,"0",-1);
            
             $strSQLQuery = "UPDATE e_promo_codes SET Name = '".addslashes($Name)."', PromoType = '".$PromoType."', CustomerGroupID = '".$CustomerGroupIDAll."',
                            DateStart = '".$DateStart."', DateStop = '".$DateStop."', Active = '".$Active."', MinAmount = '".$MinAmount."', Discount = '".$Discount."', DiscountType = '".$DiscountType."',UsesTotal='".$UsesTotal."',UsesCustomer='".$UsesCustomer."' WHERE PromoID = '".$promoID."'";
                    
               $this->query($strSQLQuery, 0);
               
        }
        
        function addCouponProductCategory($arryDetails)
        {
            
                extract($arryDetails);
                $promo_categories = isset($promo_categories) && is_array($promo_categories) ? $promo_categories:array();
                $promo_products = $promo_products == "" ? array() : explode(",", $promo_products);
                
              
		 $strSQLQuery =  "DELETE FROM e_promo_products WHERE PromoID='".$promoID."'";
                 $this->query($strSQLQuery, 0);
                  
                  $strSQLQuery =  "DELETE FROM e_promo_categories WHERE PromoID='".$promoID."'";
                  $this->query($strSQLQuery, 0);
                  
		
		// Insert the categories
		
		foreach ($promo_categories as $v)
		{
			if ($v != "")
			{
                            $strSQLQuery = "INSERT INTO e_promo_categories SET PromoID = '".$promoID."', CID = '".$v."'";
                            $this->query($strSQLQuery, 1);
                          
			}		
		}
		
		// Insert the individual products
		
		foreach ($promo_products as $v)
		{
			if ($v != "")
			{
                            $strSQLQuery = "INSERT INTO e_promo_products SET PromoID = '".$promoID."', ProductID = '".$v."'";
                            $this->query($strSQLQuery, 1);
			}			
		}
        }
        
        
        function deleteCoupon($promoID)
        {
              
                 $strSQLQuery =  "DELETE FROM e_promo_codes WHERE PromoID='".$promoID."'";
                 $this->query($strSQLQuery, 0);
                 
		 $strSQLQuery =  "DELETE FROM e_promo_products WHERE PromoID='".$promoID."'";
                 $this->query($strSQLQuery, 0);
                  
                 $strSQLQuery =  "DELETE FROM e_promo_categories WHERE PromoID='".$promoID."'";
                 $this->query($strSQLQuery, 0);
        }
        
        function changeCouponStatus($promoID)
		{
			$sql="SELECT * FROM e_promo_codes WHERE PromoID= '".$promoID."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Active']=='Yes')
					$Active='No';
				else
					$Active='Yes';
					
				$sql="UPDATE e_promo_codes set Active='".$Active."' WHERE PromoID = '".$promoID."'";
				$this->query($sql,0);
				return true;

			}			
		}
                
           function updatePromoSetting($arryDetails)     
           {
                extract($arryDetails);
                $sql="UPDATE e_settings SET Value = '".$DiscountsPromo."' WHERE Name = 'DiscountsPromo'";
		        $this->query($sql,0);
           }
           
         
        //END FUNCTIONS

	public function checkPromoCode($SubtotalAmount,$promo_code,$Cid)
	{
		/**
		 * Recalc subtotal here again - but skip gift certificates - issue 770
		 */
          
		$subtotal = 0;
                $checkPromoID = 0;
		$subtotal = $SubtotalAmount;
                
                if(!empty($_SESSION['GroupID'])){
                    $GroupID = $_SESSION['GroupID'];
                }else{
                    $GroupID = 0;
                }
                
                $strSQLQuery = "SELECT *  FROM  e_promo_codes  WHERE  PromoCode='".trim($promo_code)."'";
		        $arrayRow = $this->query($strSQLQuery, 1);
                
                $checkPromoID = $arrayRow[0]["PromoID"];
                $CustomerGroupID = $arrayRow[0]["CustomerGroupID"];
                 $CustomerGroupID = explode(",",$CustomerGroupID);
                    foreach($CustomerGroupID as $grpID)
                    {
                        $arrayCustGroupID[] = $grpID;
                    }
               
                $strSQLQueryHistory = "SELECT COUNT(*) AS total  FROM  e_promo_history  WHERE  PromoID='".trim($checkPromoID)."'";
               
                $arrayRowHistory = $this->query($strSQLQueryHistory, 1);
                
                if ($arrayRow[0]['UsesTotal'] > 0 && ($arrayRowHistory[0]['total'] >= $arrayRow[0]['UsesTotal'])) { 
				$checkprostatus = false;
			}else{
                           
                                    $checkprostatus = true;
                                }
                        
                 
                    if(in_array($GroupID,$arrayCustGroupID))
                     {

                             $strSQLQueryHistory = "SELECT COUNT(*) AS total  FROM  e_promo_history  WHERE  PromoID='".trim($checkPromoID)."' AND Cid = '".$Cid."'";

                             $arrayRowHistory = $this->query($strSQLQueryHistory, 1);

                            if ($arrayRow[0]['UsesCustomer'] > 0 && ($arrayRowHistory[0]['total'] >= $arrayRow[0]['UsesCustomer'])) {
                                    $checkprostatus = false;
                            }else{
                                $checkprostatus = true;
                            }
                    }else{
                         $checkprostatus = false;
                    }
		
                
                
               
                 $arryCartSetting = $this->getCartsettings();
                    $settings = array();

                    foreach($arryCartSetting as $field)
                    {
                       $settings[$field["Name"]] = $field["Value"];
                    }


		if (!empty($checkPromoID) && $settings["DiscountsPromo"] == "Yes" && $checkprostatus == true)
		{
			//select promo code
                         
			$strSQLQuery = "SELECT * FROM e_promo_codes WHERE DateStart < NOW() AND DateStop > NOW() AND PromoCode='".trim($promo_code)."' AND Active='Yes' AND MinAmount <= ".$subtotal;
                        //echo $strSQLQuery;exit;
                        $arrayRows = $this->query($strSQLQuery, 1);
			if (count($arrayRows) > 0)
			{
				$promo = $arrayRows[0];
				$promoType = $promo['PromoType'];
				
				switch ($promo['PromoType'])
				{
					case 'Product': 
					{
						$product = false;
						
						//check does this promo applicable for current order - is PRODUCT attached to promo
						$strSQLQuery = "
							SELECT e_cart.* 
							FROM e_cart
							INNER JOIN e_promo_products ON e_promo_products.PromoID = '".$promo["PromoID"]."' AND e_promo_products.ProductID = e_cart.ProductID
							WHERE e_cart.Cid='".$Cid."'";
						$arrayProductRows = $this->query($strSQLQuery, 1);
                                                
						if (count($arrayProductRows) > 0)
						{
							$product = $arrayProductRows[0];
						}
						
						if (!$product)
						{
							//check does this promo applicable for current order - is PRODUCT CATEGORY attached to promo
							$strSQLQuery = "SELECT e_cart.* FROM e_cart INNER JOIN e_products_categories ON e_products_categories.pid = e_cart.ProductID  
								INNER JOIN e_promo_categories ON e_promo_categories.PromoID = '".$promo["PromoID"]."' AND e_promo_categories.CID = e_products_categories.cid WHERE  e_cart.Cid='".$Cid."'";
                                                       
                              $arrayProductRowss = $this->query($strSQLQuery, 1);
                                                            
							if (count($arrayProductRowss) > 0)
							{
								$product = $arrayProductRowss[0];
							}
						}
						
						if ($product)
						{ 
							if ($promo["DiscountType"] == "amount")
							{
                                                            
								$promo_discount_amount = round($promo["Discount"] * $product["Quantity"], 3);
                                                                
							}
							else
							{
								$promo_discount_amount = round(($product["Price"] * $product["Quantity"]) * ($promo["Discount"] / 100), 3);
							}
                                                        
                                                        
							
							$discountPromoArray = array();
							//$discountPromoArray['promo_discount_amount'] = $promo_discount_amount;
							$discountPromoArray['promo_campaign_id'] = $promo["PromoID"];
							$discountPromoArray['promo_type'] = $promo["PromoType"];
							 
							$discountPromoArray['promo_discount_amount'] =  $this->getPromoDiscountAmount($SubtotalAmount,$promo["PromoID"],$Cid);
                                                        
							return $discountPromoArray;
						}
						break;
					}
					
					
					
					case 'Global':
					{
                                          
						if ($promo["DiscountType"] == "amount")
						{
							$promo_discount_amount = round($promo["Discount"], 2);
						}
						else
						{
							$promo_discount_amount = round($subtotal / 100 * $promo["Discount"], 2);
						}
							
						        $discountPromoArray = array();
                                                        $discountPromoArray['promo_discount_amount'] = $promo_discount_amount;
                                                        $discountPromoArray['promo_campaign_id'] = $promo["PromoID"];
                                                        $discountPromoArray['promo_type'] = $promo["PromoType"];
                                                         
						  return $discountPromoArray;
					}	
				}
			}
		}
                else{
                    
                    $discountPromoArray = array();
                    return $discountPromoArray;
                }


            

		
	}
	
      public function getPromoDiscountAmount($SubtotalAmount,$promo_campaign_id,$Cid)
	{
		
		 $subtotal = 0;
		 $subtotal = $SubtotalAmount;
		 $promoDiscountAmount = 0;
		
		if ($promo_campaign_id)
		{
			 
			
			if ($promo_campaign_id == 0) return 0;
			
			$strSQLQuery = "SELECT * FROM e_promo_codes WHERE PromoID = '".$promo_campaign_id."' AND DateStart <= NOW() AND DateStop >= NOW()";
                        $arrayRow = $this->query($strSQLQuery, 1);
			$promo = $arrayRow[0];
			if (!$promo) return 0;
			
			
			switch ($promo['PromoType'])
			{
				/**
				 * Product level promo
				 */
				case 'Product': 
				{
					// We have to calculate a different sub total, and make sure the new
					// subtotal is bigger than our minimum amount. -- Ricky26
					$strSQLQuery = "SELECT DISTINCT c.ProductID, c.Price, c.Quantity FROM e_cart c "
					
					."INNER JOIN e_promo_codes pro ON pro.PromoID = '".$promo_campaign_id."' "
					."INNER JOIN e_products_categories pc ON c.ProductID = pc.pid "
					."LEFT JOIN e_promo_categories proc ON pc.cid = proc.CID AND proc.PromoID = pro.PromoID "
					."LEFT JOIN e_promo_products pp ON c.ProductID = pp.ProductID AND pp.PromoID = pro.PromoID "
					."WHERE c.Cid = '".$Cid."' AND (pp.PromoID IS NOT NULL OR proc.PromoID IS NOT NULL);";
	
                                        
                                         $arrayRows = $this->query($strSQLQuery, 1);
			              
					$totalPrice = 0.0;
					$quantity = 0;
					
					foreach($arrayRows as $key)
					{
						$totalPrice += $key["Price"] * $key["Quantity"];
						$quantity += $key["Quantity"];
					}
					
					
					
					if ($promo["DiscountType"] == "amount")
					{
						$promoDiscountAmount = round($promo["Discount"] * $quantity, 2);
					}
					else
					{
						$promoDiscountAmount = round($totalPrice / 100 * $promo["Discount"], 2);
					}
					
					//$promoDiscountValue = $promoDiscountAmount;
                                      
					break;
				}
				
				/**
				 * Global promo
				 */
				case 'Global':
				default:
				{
					if ($subtotal >= $promo["MinAmount"])
					{
						if ($promo["DiscountType"] == "amount")
						{
							$promoDiscountAmount = round($promo["Discount"], 2);
						}
						else
						{
							$promoDiscountAmount = round($subtotal / 100 * $promo["Discount"], 2);
						}
						$promoDiscountValue = $promo["Discount"];
					}
					
				}
			}
		}
		
		
		
		return $promoDiscountAmount;
	}
        
        function addPromoHistory($PromoID,$OrderID,$Cid,$Amount)
        {
             global $Config;
             $strSQLQuery = "INSERT INTO e_promo_history SET PromoID = '".$PromoID."', OrderID = '".$OrderID."',Cid = '".$Cid."', Amount = '".$Amount."', DateAdded = '".$Config['TodayDate']."'";
             $this->query($strSQLQuery, 1);
            
        }
        
        function checkPromoCodeExists($PromoCode)
        {
			$strSQLQuery = "SELECT *  FROM  e_promo_codes  WHERE  PromoCode='".trim($PromoCode)."'";
			$arrayRow = $this->query($strSQLQuery, 1);
			return $arrayRow;
            
        }
	     
		function isCouponCodeExists($CouponCode,$PromoID=0)
		{

			$strSQLQuery ="select PromoCode from e_promo_codes where LCASE(PromoCode)='".strtolower(trim($CouponCode))."'";

			$strSQLQuery .= ($PromoID>0)?(" and PromoID != ".$PromoID):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['PromoCode'])) {
				return true;
			} else {
				return false;
			}
		} 
         
}

?>
