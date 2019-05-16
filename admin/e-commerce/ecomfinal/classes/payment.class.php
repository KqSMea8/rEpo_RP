<?
class payment extends dbClass
{
	
		function  getPaymentMethods()
		{

			$strSQLQuery = "SELECT * FROM e_payment_gateway ORDER BY PaymentMethodName";
			return $this->query($strSQLQuery, 1);
		}
    
		function  getPaymentCofigureMethods()
		{

			 $strSQLQuery = "SELECT * FROM e_payment_gateway WHERE PaymentCofigure='Yes' ORDER BY Priority, PaymentMethodName";
			 return $this->query($strSQLQuery, 1);
		}
                
		function  getActivePaymentMethods()
		{

			$strSQLQuery = "SELECT * FROM e_payment_gateway WHERE PaymentCofigure='Yes' AND Status = 'Yes' ORDER BY Priority, PaymentMethodName";
			return $this->query($strSQLQuery, 1);
		}

		function  getPaymentById($PaymentID)
		{

			$strSQLQuery = "SELECT * FROM e_payment_gateway WHERE LCASE(PaymetMethodId)='".strtolower($PaymentID)."'";
			return $this->query($strSQLQuery, 1);


		}    
		
		function getPaypalPaymentFields($PaymentID)
		{
			$strSQLQuery = "SELECT * FROM e_settings WHERE GroupName = 'payment_".$PaymentID."' ORDER BY Priority";
			return $this->query($strSQLQuery, 1);


		}
		
		function updatePaymentMethod($arryDetails)
		{
			@extract($arryDetails);
			$strSQLQuery="UPDATE e_payment_gateway SET PaymentMethodName='".addslashes($PaymentMethodName)."', PaymentMethodTitle='".addslashes($PaymentMethodTitle)."', PaymentMethodMessage='".addslashes(strip_tags($PaymentMethodMessage))."', PaymentMethodDescription='".addslashes(strip_tags($PaymentMethodDescription))."', Priority = '".$Priority."',Status='".$Status."',PaymentCofigure='Yes' WHERE PaymetMethodId='".$PaymentID."'"; 
                        //echo $strSQLQuery;
			$this->query($strSQLQuery,0);
			//return true;
		}
		
		function updatePaymentSettingsField($arryDetails)
		{

			foreach ($arryDetails as $key=>$value)
			{
				$sqlSettings =  "UPDATE e_settings SET Value='".$value."' WHERE Name LIKE '".trim($key)."'";
				$this->query($sqlSettings, 0);
			}

		}
	 	
		function getPayment($PaymentID,$PaymentStatus)
		{
			$strSQLQuery  = " where 1 "; 
			$strSQLQuery .= (!empty($PaymentID))?(" and PaymentID='".$PaymentID."'"):("");
			$strSQLQuery .= (!empty($PaymentStatus))?(" and PaymentStatus=".$PaymentStatus):("");

			$strSQLQuery="select * from payments ".$strSQLQuery." order by Amount";
			return $this->query($strSQLQuery);
		}

		


		function changePaymentStatus($PaymentID)
		{
			$strSQLQuery="SELECT * from e_payment_gateway WHERE  PaymetMethodId='".$PaymentID."'";
			$rs = $this->query($strSQLQuery);
			if(sizeof($rs))
			{
				if($rs[0]['Status']== "Yes")
					$PaymentStatus= "No";
				else
					$PaymentStatus="Yes";
					
				$strSQLQuery="UPDATE e_payment_gateway SET Status='".$PaymentStatus."' WHERE  PaymetMethodId='".$PaymentID."'";
				$this->query($strSQLQuery,0);
				return true;
			}			
		}
		
		function deletePaymentMethod($PaymentID)
		{
		 	 $strSQLQuery = "DELETE FROM e_payment_gateway WHERE PaymetMethodId='".$PaymentID."'";
			$this->query($strSQLQuery,0);
			return true;
		}


		function isPaymentExists($PaymentFor,$PaymentID,$CatID)
		{
			$strSQLQuery ="select * from payments where LCASE(PaymentFor) = '".strtolower(trim($PaymentFor))."'";
			$strSQLQuery .= (!empty($PaymentID))?(" and PaymentID != '".$PaymentID."'"):("");
			$strSQLQuery .= (!empty($CatID))?(" and CatID = '".$CatID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['PaymentID'])) {
				return true;
			} else {
				return false;
			}

		}


		function createTransaction($orderdata, $response, $transaction_id)
		{
                           
                    global $Config;
			    $strSQLQuery="UPDATE e_orders SET SecurityId='".$transaction_id."' WHERE  OrderID='".$orderdata['OrderID']."'";
		        $this->query($strSQLQuery,0);
			
                        $strSQLQuery="INSERT INTO e_payment_transactions SET 
                                        OrderId='".$orderdata['OrderID']."',
                                        Cid='".$orderdata['Cid']."',
                                        Completed = '".$Config['TodayDate']."',
                                        Extra='', 
                                        PaymentType = '".$orderdata['PaymentGatewayID']."',
                                        PaymentGateway = '".$orderdata['PaymentGateway']."',
                                        PaymentResponse = '".$response."',
                                        OrderSubtotalAmount='".$orderdata['SubTotalPrice']."',
                                        OrderTotalAmount = '".$orderdata['TotalPrice']."',
                                        ShippingMethod='".$orderdata['ShippingMethod']."',
                                        ShippingSubmethod='',
                                        ShippingAmount='".$orderdata['Shipping']."',
                                        TaxAmount='".$orderdata['Tax']."'";
                                         $this->query($strSQLQuery,1);
                                        
		
		     }
	




}

?>
