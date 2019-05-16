<?php
class Customer extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function Customer(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

                function getCustomers($id=0,$Status,$SearchKey,$SortBy,$AscDesc)
                {
                        $strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where c1.Cid=".$id):(" where 1 and Login <> 'ExpressCheckoutUser'");
			
			$strAddQuery .= ($Status>0)?(" and c1.Status=".$Status.""):("");
			
			if($SearchKey=='active' && ($SortBy=='c1.Status' || $SortBy=='') ){
				$strAddQuery .= " and c1.Status='Yes'"; 
			}else if($SearchKey=='inactive' && ($SortBy=='c1.Status' || $SortBy=='') ){
				$strAddQuery .= " and c1.Status='No'";
			}else if($SortBy != '' && $SortBy!='c1.GroupID'){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
			}
                        else if($SortBy=='c1.GroupID'){
                                $gid = $this->getCustomerGroupId($SearchKey);
				$strAddQuery .= " and c1.GroupID = '".$gid."'";
			}
                        else{
				$strAddQuery .= (!empty($SearchKey))?(" and (c1.FirstName like '".$SearchKey."%' or c1.LastName like '%".$SearchKey."%' or c1.Email like '%".$SearchKey."%') "):("");
			}
			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c1.Cid ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");

                   
                    $SqlCustomer = "select c1.* from e_customers c1 ".$strAddQuery;
                    //echo $SqlCustomer;
                    return $this->query($SqlCustomer, 1);
                }
                
                function getCustomerGroupId($str)
                {
                     $SqlCustomer = "SELECT GroupID FROM e_customer_group WHERE GroupName like '".$str."%'";
               
                    $arrayGroup = $this->query($SqlCustomer, 1);
                    $GroupID = $arrayGroup[0]['GroupID'];
                    return $GroupID;
                    
                }
                
                
                
                function checkCustomerEmail($email)
                {
                    $SqlCustomer = "SELECT Cid FROM e_customers WHERE LOWER(email) = '".strtolower(trim($email))."' and Login <> 'ExpressCheckoutUser'";
                    return $this->query($SqlCustomer, 1);
                }
                
                function addCustomer($arryDetails)
                {
                       @extract($arryDetails);
                     global $Config;
                     $SqlCustomer = "INSERT INTO e_customers SET GroupID = '1', CreatedDate = '".$Config['TodayDate']."', FirstName='".addslashes($FirstName)."', LastName = '".addslashes($LastName)."', Company = '".addslashes($Company)."', Phone = '".$Phone."',Newsletters = '".$Newsletters."',
                          Address1 = '".addslashes($Address1)."', Address2 = '".addslashes($Address2)."', City = '".$main_city_id."',OtherCity = '".addslashes($OtherCity)."',State = '".$main_state_id."', OtherState = '".addslashes($OtherState)."', Country= '".$Country."', ZipCode = '".$ZipCode."',Email = '".addslashes($Email)."',Password='".md5($Password)."',Status='Yes', LastUpdate = '".$Config['TodayDate']."'"; 
	             $this->query($SqlCustomer,0);
                     $customerId = $this->lastInsertId();
                     return $customerId;
                   
                }
                
                function expressLogin()
                {
                   global $Config;
                       if(empty($_SESSION["SessionID"])){
                        $SqlCustomer = "INSERT INTO e_customers (Login, Password, Country, State, Newsletters, LastUpdate, CreatedDate) VALUES ('ExpressCheckoutUser', '".(md5(uniqid(rand())))."', '0', '0', 'No', '".$Config['TodayDate']."', '".$Config['TodayDate']."')";
                        $this->query($SqlCustomer,0);
                        $customerId = $this->lastInsertId();
                       
                        $session_id = uniqid(md5(rand(1, 1000000)));
                        $SqlCustomer = "UPDATE e_customers SET SessionId='".$session_id."', SessionDate=NOW() WHERE Cid='".$customerId."'";
                        $this->query($SqlCustomer,0);
                        $_SESSION["SessionID"] = $session_id;
                        $_SESSION["guestId"] = $customerId;
                        return $_SESSION["guestId"];
                       }
                }
                
               function UpdateMyProfile($arryDetails)
                {
                    @extract($arryDetails);
                        global $Config;
                        
                        $SqlCustomer = "UPDATE e_customers SET FirstName='".addslashes($FirstName)."', LastName = '".addslashes($LastName)."', Company = '".addslashes($Company)."', Phone = '".$Phone."', Address1 = '".addslashes($Address1)."', Address2 = '".addslashes($Address2)."', 
                            City = '".$main_city_id."',OtherCity = '".addslashes($OtherCity)."',State = '".$main_state_id."', OtherState = '".addslashes($OtherState)."', Country= '".$Country."', ZipCode = '".$ZipCode."', LastUpdate = '".$Config['TodayDate']."' WHERE Cid = '".$Cid."'"; 
                       
                        $this->query($SqlCustomer,0);
                        $customerId = $this->lastInsertId();
                        return $customerId;
                   
                }
                
                function changePassword($arryDetails)
                {
                       @extract($arryDetails);
                        global $Config;
                        $SqlCustomer = "UPDATE e_customers SET Password='".md5($Password)."', LastUpdate = '".$Config['TodayDate']."'  WHERE Cid = '".$Cid."'"; 
                        $this->query($SqlCustomer,0);
                }    
                
                function addNewsletter($arryDetails)
                {
                    @extract($arryDetails);
                       global $Config;
                       if($Newsletters == "Yes")
                       {
                            $Newsletters = "Yes";
                            $SqlCustomer = "SELECT Email FROM e_customers WHERE Cid = '".$Cid."'";
                            $arrayEmail = $this->query($SqlCustomer, 1);
                            $email = $arrayEmail[0]['Email'];
            
                            $checkCustomer = "SELECT EmailId FROM e_emails WHERE LOWER(Email) = '".strtolower(trim($email))."'";
                            $arrayEmailId =  $this->query($checkCustomer, 1);
                            $arrayEmailId = $arrayEmailId[0]['EmailId'];
                           
                            if(empty($arrayEmailId))
                            {
                                   
                                    $SqlCustomer = "INSERT INTO e_emails SET  Email = '".strtolower(trim($email))."',Status='Yes',Created_Date = '".$Config['TodayDate']."'";
                                    $this->query($SqlCustomer, 1);
                            }
                
                        }
                        else {
                            $Newsletters = "No";
                         }
                         
                           $SqlCustomer = "UPDATE e_customers SET Newsletters='".$Newsletters."', LastUpdate = '".$Config['TodayDate']."'  WHERE Cid = '".$Cid."'"; 
                           $this->query($SqlCustomer,0);
                }
                
                function customerRegistrationEmail($arryDetails,$CountryName,$StateName,$CityName)
                {
                       @extract($arryDetails);
                        
                       global $Config;
                        
                                $StoreUrl = $Config['homeCompleteUrl'].'/index.php';
                                $htmlPrefix = $Config['EmailTemplateFolder'];
                                 /**** Email to  Customer ******/
                                $ContentMsg = "Congratulations! You have successfully created a new account with <a href='".$StoreUrl."' target='_blank'>".stripslashes($Config['StoreName'])."</a>.";
                                $contents = file_get_contents($htmlPrefix."customerRegistrationEmail.htm");
				$FullName = ucfirst($FirstName)." ".ucfirst($LastName);
				$contents = str_replace("[ContentMsg]",$ContentMsg,$contents);
				$contents = str_replace("[SITENAME]",$Config['StoreName'],$contents);
				$contents = str_replace("[USERNAME]",ucfirst($FirstName),$contents);
                                $contents = str_replace("[FULLNAME]",$FullName,$contents);
                                $contents = str_replace("[Company]",$Company,$contents);
                                $contents = str_replace("[Address1]",$Address1,$contents);
                                $contents = str_replace("[Address2]",$Address2,$contents);
                                $contents = str_replace("[Country]",$CountryName,$contents);
                                $contents = str_replace("[State]",$StateName,$contents);
                                $contents = str_replace("[City]",$CityName,$contents);
                                $contents = str_replace("[Zipcode]",$ZipCode,$contents);
                                $contents = str_replace("[Phone]",$Phone,$contents);
				$contents = str_replace("[EMAIL]",$Email,$contents);
				$contents = str_replace("[PASSWORD]",$Password,$contents);	
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);			
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Email);
				$mail->sender($Config['StoreName']." - ", $Config['NotificationEmail']);   
				$mail->Subject = $Config['StoreName']." - Registration Details";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
   
				if($Config['Online'] == '1'){
					$mail->Send();	
				}
                             
                                 /**** Email to  Admin ******/
                                $ContentMsg = "There is a new user registered on ".stripslashes($Config['StoreName'])." website";
                                $contents = file_get_contents($htmlPrefix."customerRegistrationEmailToAdmin.htm");
				$FullName = ucfirst($FirstName)." ".ucfirst($LastName);
				$contents = str_replace("[ContentMsg]",$ContentMsg,$contents);
				$contents = str_replace("[SITENAME]",$Config['StoreName'],$contents);
				$contents = str_replace("[USERNAME]",ucfirst($FirstName),$contents);
                                $contents = str_replace("[FULLNAME]",$FullName,$contents);
                                $contents = str_replace("[Company]",$Company,$contents);
                                $contents = str_replace("[Address1]",$Address1,$contents);
                                $contents = str_replace("[Address2]",$Address2,$contents);
                                $contents = str_replace("[Country]",$CountryName,$contents);
                                $contents = str_replace("[State]",$StateName,$contents);
                                $contents = str_replace("[City]",$CityName,$contents);
                                $contents = str_replace("[Zipcode]",$ZipCode,$contents);
                                $contents = str_replace("[Phone]",$Phone,$contents);
				$contents = str_replace("[EMAIL]",$Email,$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);			
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['CompanyEmail']);
				$mail->sender($Config['StoreName']." - ", $Config['NotificationEmail']);   
				$mail->Subject = $Config['StoreName']." - New user registered";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
   
				if($Config['Online'] == '1'){
					$mail->Send();	
				}
                                
                }
                
                function getCustomerById($custId)
                {
                        $SqlCustomer = "SELECT * from e_customers WHERE Cid ='".$custId."'"; 
                        return $this->query($SqlCustomer, 1);
                }
                
                function updateCustomer($arryDetails)
                {
                       @extract($arryDetails);
                     global $Config;
                     $SqlCustomer = "UPDATE e_customers SET FirstName='".addslashes($FirstName)."', LastName = '".addslashes($LastName)."', Company = '".addslashes($Company)."', Phone = '".addslashes($Phone)."', Level = '".$Level."', Status = '".$Status."', GroupID = '".$GroupID."', Newsletters = '".$Newsletters."',
                          Address1 = '".addslashes($Address1)."', Address2 = '".addslashes($Address2)."', City = '".$main_city_id."',OtherCity = '".addslashes($OtherCity)."',State = '".$main_state_id."', OtherState = '".addslashes($OtherState)."', Country= '".$Country."', ZipCode = '".addslashes($ZipCode)."', LastUpdate = '".$Config['TodayDate']."' WHERE Cid = '".$CustId."'"; 
                        //echo "=>".$SqlCustomer;exit; 
	                  $this->query($SqlCustomer,0);
                   
                }
                
                function UpdateCustomerFromCheckoutPage($arryDetails)
                {
                       @extract($arryDetails);
                     
                     $SqlCustomer = "UPDATE e_customers SET FirstName='".$FirstName."', LastName = '".$LastName."', Company = '".$Company."', Phone = '".$Phone."', Address1 = '".$Address1."', Address2 = '".$Address2."',
                         City = '".$main_city_id."',OtherCity = '".$OtherCity."',State = '".$main_state_id."', OtherState = '".$OtherState."', Country= '".$Country."', Email = '".$Email."', ZipCode = '".$ZipCode."', ShippingName = '".$ShippingName."',
                             ShippingCompany = '".$ShippingCompany."', ShippingAddress1 = '".$ShippingAddress1."',ShippingAddress2 = '".$ShippingAddress2."', ShippingCountry = '".$country_id_shipp."',ShippingState = '".$main_state_id_shipp."',
                                 OtherShippingState = '".$OtherState_shipp."', ShippingCity = '".$main_city_id_shipp."', OtherShippingCity = '".$OtherCity_shipp."', ShippingPhone = '".$ShippingPhone."',ShippingZip='".$ShippingZip."', Status = 'Yes' WHERE Cid = '".$Cid."'"; 
                       //echo "=>".$SqlCustomer;exit; 
	                  $this->query($SqlCustomer,0);
                   
                }
                
                function UpdateCustomerShippingAddressFromCheckout($Cid)
                {
                      
                     $SqlCustomer = "UPDATE e_customers SET  ShippingName = '', ShippingCompany = '', ShippingAddress1 = '',ShippingAddress2 = '', ShippingCountry = '',ShippingState = '',
                                 OtherShippingState = '', ShippingCity = '', OtherShippingCity = '', ShippingPhone = '',ShippingZip='' WHERE Cid = '".$Cid."'"; 
                    
	                  $this->query($SqlCustomer,0);
                   
                }
                
                function ValidateCustomer($Email,$Password,$Type){
					$strSQLQuery = "select * from e_customers where LOWER(Email) = '".strtolower(trim($Email))."' and Password='".md5($Password)."' and Status='Yes'";
					$strSQLQuery .= (!empty($Type))?(" and Type='".$Type."'"):("");

					//echo $strSQLQuery; exit;
					return $this->query($strSQLQuery, 1);
				}
                
                function updateSessionCustomer($customerId)
                {
                     $session_id = uniqid(md5(rand(1, 1000000)));
                     $SqlCustomer = "UPDATE e_customers SET SessionId='".$session_id."', SessionDate=NOW(),Login='Registered' WHERE Cid='".$customerId."'";
                     $this->query($SqlCustomer,0);
                }
                
			function ValidateCustomerByEmail($Email,$Type){
				$strSQLQuery = "select * from e_customers where LOWER(Email) = '".strtolower(trim($Email))."' and Status='Yes'";
				$strSQLQuery .= (!empty($Type))?(" and Type='".$Type."'"):("");

				//echo $strSQLQuery; exit;
				return $this->query($strSQLQuery, 1);
			}
                
                function UpdateCustomerCart($Cid, $PrdIDs)
		{
			$ProductIDArry = explode(",",$PrdIDs);

			foreach($ProductIDArry as $ProductID){
			
				$strSQLQuery = "select * from e_cart where Cid='".$Cid."' and ProductID='".$ProductID."'";
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['CartID'])) {
					$strSQLQuery = "delete from e_cart where CartID='".$arryRow[0]['CartID']."'";
					$this->query($strSQLQuery, 0);
				} 
				
			}
			$strSQLQuery = "update e_cart set Cid='".$Cid."' where Cid='".session_id()."'"; 
			return $this->query($strSQLQuery, 0);
		}
                
                function ForgotPassword($Email)
		{
			$sql = "SELECT * FROM e_customers WHERE LOWER(Email) = '".strtolower(trim($Email))."' and Status='Yes'"; 
			
			$arryRow = $this->query($sql, 1);

			$UserName = $arryRow[0]['Email'];

			if(sizeof($arryRow)>0)
			{
				$new_password = generatePassword();
			    $sql_u = "UPDATE e_customers SET Password='".md5($new_password)."' WHERE LOWER(Email) = '".strtolower(trim($Email))."'";
				$this->query($sql_u, 0);
                                global $Config;
                                $htmlPrefix = $Config['EmailTemplateFolder'];
                              
                                $contents = file_get_contents($htmlPrefix."forgot.htm");
        
				
				$FullName = $arryRow[0]['FirstName']." ".$arryRow[0]['LastName'];
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[USERNAME]",ucfirst($arryRow[0]['FirstName']),$contents);
				$contents = str_replace("[EMAIL]",$Email,$contents);
				$contents = str_replace("[PASSWORD]",$new_password,$contents);	
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
						
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Email);
				$mail->sender($Config['StoreName']." - ", $Config['NotificationEmail']);   
				$mail->Subject = $Config['StoreName']." - New password";
				$mail->IsHTML(true);
				$mail->Body = $contents;  

				//echo $Email.$Config['AdminEmail'].$contents; exit;
                              
				if($Config['Online'] == '1'){
					$mail->Send();	
				}
				return 1;
			}else{
				return 0;
			}
		}
                
				
			function GetMyOrders($Cid) {

				global $Config;
				$strSQLQuery = "SELECT OrderID FROM e_orders WHERE Cid='".intval($Cid)."' ORDER BY OrderID DESC";
				$rs[] = $this->query($strSQLQuery, 1);
				return $rs[0];
			}		
			function deleteCustomer($Cid)
			{

				  $ros = $this->GetMyOrders($Cid);
					 if(count($ros) > 0){ 
						foreach($ros as $oid) {
							$strSQLQuery = "DELETE FROM e_orderdetail WHERE OrderID = '".$oid['OrderID']."'";
							//echo "=>".$strSQLQuery;exit;
							$this->query($strSQLQuery, 0);
					   }
				   }
					$strSQLQuery = "delete from e_customers where Cid = '".$Cid."'";    
					$this->query($strSQLQuery, 0);			
					$strSQLQuery = "delete from e_cart  where Cid = '".$Cid."'"; 
					$this->query($strSQLQuery, 0);

					$strSQLQuery = "DELETE FROM e_orders WHERE Cid = '".$Cid."'";    
					$this->query($strSQLQuery, 0);
				 
				
				return 1;

			}   
                
                function changeCustomerStatus($Cid)
                {
                        $strSQLQuery="select * from e_customers where Cid = '".$Cid."'";
                        $rs = $this->query($strSQLQuery);
                        if(sizeof($rs))
                        {
                                if($rs[0]['Status']== "Yes")
                                        $Status="No";
                                else
                                        $Status="Yes";

                                $strSQLQuery="update e_customers set Status='$Status' where Cid = '".$Cid."'";
                                $this->query($strSQLQuery,0);
                                return true;
                        }			
                }
                
                
                
             /****************************************Subscriber Functions Started********************************************/   
               function checkSubcribeEmail($email)
                {
                    $SqlCustomer = "SELECT EmailId FROM e_emails WHERE LOWER(Email) = '".strtolower(trim($email))."'";
                    return $this->query($SqlCustomer, 1);
                }
                function addSubcribeEmail($email)
                {
                   
                    global $Config;
                                       
                    $SqlCustomer = "INSERT INTO e_emails SET  Email = '".strtolower(trim($email))."',Status='Yes',Created_Date = '".$Config['TodayDate']."'";
                    $this->query($SqlCustomer, 1);
                    $lastInsertId = $this->lastInsertId();
		             return $lastInsertId;
                }
                
                 function getSubscribers($id=0,$Status,$SearchKey,$SortBy,$AscDesc)
                 {
                       $strAddQuery = '';
						$SearchKey   = strtolower(trim($SearchKey));
						$strAddQuery .= (!empty($id))?(" where EmailId='".$id."'"):(" where 1");

						$strAddQuery .= ($Status>0)?(" and Status=".$Status.""):("");

						if($SearchKey=='active' && ($SortBy=='Status' || $SortBy=='') ){
						$strAddQuery .= " and Status='Yes'"; 
						}else if($SearchKey=='inactive' && ($SortBy=='Status' || $SortBy=='') ){
						$strAddQuery .= " and Status='No'";
						}else if($SortBy != ''){
						$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
						}else{
						$strAddQuery .= (!empty($SearchKey))?(" and (Email like '".$SearchKey."%') "):("");
						}
						$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by EmailId ");
						$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");


						$SqlCustomer = "select * from e_emails ".$strAddQuery;
						// echo $SqlCustomer;exit;
						return $this->query($SqlCustomer, 1);
                }
                
                function getSubcriberById($id)
                 {
					$strAddQuery = '';
					$SearchKey   = strtolower(trim($SearchKey));
					$strAddQuery .= (!empty($id))?(" where EmailId='".$id."'"):(" where 1");
					$SqlCustomer = "select * from e_emails ".$strAddQuery;
					// echo $SqlCustomer;exit;
					return $this->query($SqlCustomer, 1);
                }
                
                function updateSubcriber($arryDetails)
                {
                    @extract($arryDetails);
                    $SqlCustomer = "UPDATE e_emails SET Email = '".strtolower(trim($Email))."',Status='".$Status."' WHERE EmailId = '".$EmailId."'";
                    return $this->query($SqlCustomer, 0);
                   
                }
                
                function deleteSubcriber($id)
				{
				 
				 	// added by karishma 12 oct 2015
					$SqlCustomer = "SELECT Email FROM e_emails where EmailId = '".$id."'"; 
				    $arrayEmail = $this->query($SqlCustomer, 1);
				    $email = $arrayEmail[0]['Email'];
				    
							$SqlCustomer = "UPDATE e_customers SET Newsletters='No'  WHERE Email = '".addslashes($email)."'"; 
				    $this->query($SqlCustomer,0);
				   
				    // end
				 
					$strSQLQuery = "delete from e_emails where EmailId = '".$id."'"; 
					$this->query($strSQLQuery, 0);
					return 1;

				}   
                
                function changeSubcriberStatus($id)
                {
                        $strSQLQuery="select * from e_emails where EmailId = '".$id."'";
                        $rs = $this->query($strSQLQuery);
                        if(sizeof($rs))
                        {
                                if($rs[0]['Status']== "Yes")
                                        $Status="No";
                                else
                                        $Status="Yes";

                                $strSQLQuery="update e_emails set Status='$Status' where EmailId = '".$id."'";
                                $this->query($strSQLQuery,0);
                                
                                // added by karishma 12 oct 2015
								$SqlCustomer = "SELECT Email FROM e_emails where EmailId = '".$id."'"; 
							    $arrayEmail = $this->query($SqlCustomer, 1);
							    $email = $arrayEmail[0]['Email'];
							    
										$SqlCustomer = "UPDATE e_customers SET Newsletters='$Status'  WHERE Email = '".addslashes($email)."'"; 
							    $this->query($SqlCustomer,0);
							   
							    // end
							    
                                return true;
                        }			
                }
                
                function  GetSubcribersForEmail($SortBy)
				{
								$strAddQuery .= " where Status = 'Yes'";
					if($SortBy != ""){
						$strAddQuery .= " and LOWER(Email) like '".strtolower($SortBy)."%'";
					}
					$strSQLQuery = "SELECT * FROM e_emails ".$strAddQuery;
					return $this->query($strSQLQuery, 1);
								
				}
                
                function sendNewsletterEmail($arryDetails)
                {
                     global $Config;
                          @extract($arryDetails);
                               
                             if($ToEmail == "allSubscriber")
                             {
                                    $SqlCustomer = "SELECT Email FROM e_emails WHERE Status = 'Yes'";
                                    $arrayRow = $this->query($SqlCustomer, 1);
                                    foreach($arrayRow as $k=>$v)
                                    {
                                        $arrayRowEmails[] =  $v['Email'];
                                    }
                             }
                            
                            else {
                              $arrayRowEmails  = $arryDetails['Email'];
                            }
                             
                            $array_Other_Email = explode(",",$Other_Email); 
                            if(!empty($Other_Email))
                            {  foreach ($array_Other_Email as $other)
                               {
                                 $arrayRowEmails[] = $other;
                               }
                            }
                            
                         
                            
                            foreach($arrayRowEmails as $Email)
                            {
                                                    
                                //$htmlPrefix = eregi('admin',$_SERVER['PHP_SELF'])?("../".$Config['EmailTemplateFolder']):($Config['EmailTemplateFolder']);
                                $htmlPrefix = $Config['EmailTemplateFolder'];
                                $contents = file_get_contents($htmlPrefix."newsletter.htm");
                                $contents = str_replace("[URL]",$Config['Url'],$contents);
                                $contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
                                $contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
                                $contents = str_replace("[EMAIL_CONTENT]",$Html_Content, $contents);
                                $contents = str_replace("[FULLNAME]",$DisplayName, $contents);

                                $mail = new MyMailer();
                                $mail->IsMail();			
                                $mail->AddAddress($Email);
                                $mail->sender($Name, $From_Email);   
                                $mail->Subject = $Config['StoreName']." - Company - ".$Subject;
                                $mail->IsHTML(true);
                                //echo "=>".$contents;exit;
                                $mail->Body = $contents;   
                                if($Config['Online'] == '1'){
                                         $mail->Send();	
                                }
                     
                            }
                }
                
             function getNewsletterTemplateList($id=0,$Status,$SearchKey,$SortBy,$AscDesc)
                 {
					$strAddQuery = '';
					$SearchKey   = strtolower(trim($SearchKey));
					$strAddQuery .= (!empty($id))?(" where Templapte_Id='".$id."'"):(" where 1");
					
					$strAddQuery .= ($Status>0)?(" and Status=".$Status.""):("");
					
					if($SearchKey=='active' && ($SortBy=='Status' || $SortBy=='') ){
						$strAddQuery .= " and Status='Yes'"; 
					}else if($SearchKey=='inactive' && ($SortBy=='Status' || $SortBy=='') ){
						$strAddQuery .= " and Status='No'";
					}else if($SortBy != ''){
						$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
					}else{
						$strAddQuery .= (!empty($SearchKey))?(" and (Template_Name like '".$SearchKey."%' or Template_Subject like '".$SearchKey."%' )"):("");
					}
					$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by Templapte_Id ");
					$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");

                   
                    $SqlCustomer = "select * from e_newsletter_template ".$strAddQuery;
                   // echo $SqlCustomer;exit;
                    return $this->query($SqlCustomer, 1);
                }
                
                function getNewsletterTemplateById($id)
                {
                     $SqlCustomer = "select * from e_newsletter_template WHERE Templapte_Id = '".$id."'";
                     return $this->query($SqlCustomer, 1);
                }
                
                function addNewsletterTemplate($arryDetails)
                {
                     @extract($arryDetails);
                     $SqlCustomer = "INSERT INTO e_newsletter_template SET Template_Subject = '".addslashes(strip_tags($Template_Subject))."', Template_Content = '".addslashes(strip_tags($Template_Content))."', Template_Name = '".addslashes(strip_tags($Template_Name))."', Created_Date = '".$Config['TodayDate']."',Status='".$Status."'";
                     $this->query($SqlCustomer, 1);
                }
                
                function updateNewsletterTemplate($arryDetails)
                {
                     @extract($arryDetails);
                     
                      $SqlCustomer = "UPDATE e_newsletter_template SET Template_Subject = '".addslashes(strip_tags($Template_Subject))."', Template_Name = '".addslashes(strip_tags($Template_Name))."', Template_Content = '".addslashes(strip_tags($Template_Content))."',Status = '".$Status."' WHERE Templapte_Id =".$TemplateId;
                     return $this->query($SqlCustomer, 0);
                }
                
                 function deleteNewsletterTemplate($id)
					{
					 
						$strSQLQuery = "delete from e_newsletter_template where Templapte_Id = '".$id."'"; 
						$this->query($strSQLQuery, 0);
						return 1;

					}   
                
                function changeNewsletterTemplateStatus($id)
                {
                        $strSQLQuery="select * from e_newsletter_template where Templapte_Id = '".$id."'"; 
                        $rs = $this->query($strSQLQuery);
                        if(sizeof($rs))
                        {
                                if($rs[0]['Status']== "Yes")
                                        $Status="No";
                                else
                                        $Status="Yes";

                                $strSQLQuery="update e_newsletter_template set Status='$Status' where Templapte_Id = '".$id."'"; 
                                $this->query($strSQLQuery,0);
                                return true;
                        }			
                }
                
                 function getNewsletterTemplateByStatus()
                 {
                     
                    $SqlCustomer = "select * from e_newsletter_template where Status = 'Yes'";
                    return $this->query($SqlCustomer, 1);
                }
                
             /*******************************************Subscriber Functions Ended******************************************************************/   
               
            
            /******************************************Shipping Address Functions Started************************************************************/    
           
                function addShippingAddress($arryDetails)                      
                {
                    @extract($arryDetails);
                    
                    //check is there already shipping addresses for user
						$SqlCustomer = "SELECT * FROM e_users_shipping_address WHERE Cid = '".$Cid."'";
							$arrayRow = $this->query($SqlCustomer, 1);
						if(empty($arrayRow))
						{
							//this shipping address is first one
							//set it as primary
							$IsPrimary = "Yes";
						}
						else
						{
							//check if there attempt to set primary address
							if (isset($IsPrimary) && ($IsPrimary == "Yes"))
							{
								//reset all existing addresses to "not primary"
								$strSQLQuery="update e_users_shipping_address set IsPrimary='No' where Cid = '".$Cid."'";
								$this->query($strSQLQuery,0);
								//set current to primary
								$IsPrimary = "Yes";
							}
							else
							{
								$IsPrimary = "No";
							}
						}
                        
                       $SqlCustomer = "INSERT INTO e_users_shipping_address SET Cid = '".$Cid."', IsPrimary = '".$IsPrimary."', AddressType = '".$AddressType."', Name ='".addslashes($Name)."',Company = '".addslashes($Company)."', Address1 = '".  addslashes($Address1)."', Address2 = '".  addslashes($Address2)."',
                           City = '".$main_city_id."',OtherCity = '".addslashes($OtherCity)."',State = '".$main_state_id."', OtherState = '".addslashes($OtherState)."', Zip = '".$Zip."', Phone = '".$Phone."', Country = '".$Country."'";
                      //echo "=>".$SqlCustomer;exit;
                       $this->query($SqlCustomer, 1); 
                        
                }
                
                function addShippingAddressFromCheckout($arryDetails)                      
                {
                    @extract($arryDetails);
                    
                       $SqlCustomer = "INSERT INTO e_users_shipping_address SET Cid = '".$Cid."', IsPrimary = 'No', AddressType = 'Residential', Name ='".addslashes($ShippingName)."',Company = '".addslashes($ShippingCompany)."', Address1 = '".  addslashes($ShippingAddress1)."', Address2 = '".  addslashes($ShippingAddress2)."',
                           City = '".$main_city_id_shipp."',OtherCity = '".addslashes($OtherCity_shipp)."',State = '".$main_state_id_shipp."', OtherState = '".addslashes($OtherState_shipp)."', Zip = '".$ShippingZip."', Phone = '".$ShippingPhone."', Country = '".$country_id_shipp."'";
                      //echo "=>".$SqlCustomer;exit;
                       $this->query($SqlCustomer, 1); 
                        
                }
                
               function getShippingAddresses($Cid)
                {
                        $SqlCustomer = "SELECT * FROM e_users_shipping_address WHERE Cid = '".$Cid."' ORDER BY IsPrimary";
                        return $this->query($SqlCustomer, 1);
                }  
                
                 function getShippingAddressById($address_id)
                {
                        $SqlCustomer = "SELECT * FROM e_users_shipping_address WHERE Csid = '".$address_id."'";
                        return $this->query($SqlCustomer, 1);
                }  
                
                function updateShippingAddress($arryDetails)
                {
                     @extract($arryDetails);
                    
                    //check is there already shipping addresses for user
			         $SqlCustomer = "SELECT * FROM e_users_shipping_address WHERE Cid = '".$Cid."'";
                        $arrayRow = $this->query($SqlCustomer, 1);
						if(empty($arrayRow))
						{
							//this shipping address is first one
							//set it as primary
							$IsPrimary = "Yes";
						}
						else
						{
							//check if there attempt to set primary address
							if (isset($IsPrimary) && ($IsPrimary == "Yes"))
							{
								//reset all existing addresses to "not primary"
								$strSQLQuery="update e_users_shipping_address set IsPrimary='No' where Cid = '".$Cid."'";
								$this->query($strSQLQuery,0);
								//set current to primary
								$IsPrimary = "Yes";
							}
							else
							{
								$IsPrimary = "No";
							}
						}
                        
                       $SqlCustomer = "UPDATE e_users_shipping_address SET  IsPrimary = '".$IsPrimary."', AddressType = '".$AddressType."', Name ='".addslashes($Name)."',Company = '".addslashes($Company)."', Address1 = '".  addslashes($Address1)."', Address2 = '".  addslashes($Address2)."',
                           City = '".$main_city_id."',OtherCity = '".addslashes($OtherCity)."',State = '".$main_state_id."', OtherState = '".addslashes($OtherState)."', Zip = '".$Zip."', Phone = '".$Phone."', Country = '".$Country."' WHERE Cid = '".$Cid."' and Csid = '".$Csid."'";
                       
                   
                       $this->query($SqlCustomer, 0); 
                }
                
                function deleteShippingAddress($Cid,$Csid)
                {
                    $SqlCustomer = "DELETE FROM e_users_shipping_address WHERE Cid = '".$Cid."' and Csid = '".$Csid."'";
                    $this->query($SqlCustomer, 0); 
                }
                
                /******************************************Shipping Address Functions Ended************************************************************/   
                
                /***************************************Customer Group Functions Started****************************************************/
                
                function addCustomerGroup($arryDetails)
                {
                      @extract($arryDetails);
                    
                    $SqlCustomer = "INSERT INTO e_customer_group SET GroupName='".addslashes($GroupName)."' ,Status='".$Status."'"; 
	                 $this->query($SqlCustomer,0);
                    
                   
                }
                
                  function checkCustomerGroupName($GroupName) {
                    $sqlSettings = "SELECT * from e_customer_group WHERE  GroupName='".trim($GroupName)."'";
                    return $this->query($sqlSettings, 1);
                }
                
                function getCustomerGroups()
                {
                    $sqlSettings = "SELECT * from e_customer_group";
                    return $this->query($sqlSettings, 1);
                }
                
               function getCustomerGroupById($customerGroupID) {
                    $sqlSettings = "SELECT * from e_customer_group WHERE  GroupID='".trim($customerGroupID)."'";
                    return $this->query($sqlSettings, 1);
                }
                
                function updateCustomerGroup($arryDetails)
                {
                      @extract($arryDetails);
                    
                     $SqlCustomer = "UPDATE e_customer_group SET GroupName='".addslashes($GroupName)."' ,Status='".$Status."' WHERE GroupID='".trim($customerGroupId)."'"; 
	                $this->query($SqlCustomer,0);
                    
                   
                } 
                
                function changeCustomerGroupStatus($customerGroupID) {
                    $SqlCustomer = "SELECT * FROM e_customer_group WHERE GroupID = '".$customerGroupID."'";
                    $rs = $this->query($SqlCustomer);
                    if (sizeof($rs)) {
                        if ($rs[0]['Status'] == 'Yes')
                            $Status = 'No';
                        else
                            $Status = 'Yes';

                        $SqlCustomer = "UPDATE e_customer_group SET Status='".$Status ."' WHERE GroupID= '".$customerGroupID."'";
                        $this->query($SqlCustomer, 0);
                        return true;
                    }
                }
                
                
                function deleteCustomerGroup($customerGroupID) {

                $SqlCustomer = "DELETE FROM e_customer_group WHERE GroupID = '".$customerGroupID."'";
                $rs = $this->query($SqlCustomer, 0);
  
             }
             
              function getCustomerGroupName($customerGroupID) {
                $SqlCustomer = "SELECT GroupName FROM e_customer_group WHERE GroupID = '".$customerGroupID."'";
                $arrayGroup = $this->query($SqlCustomer, 1);
                $GroupName = $arrayGroup[0]['GroupName'];
                return $GroupName;
             }
             
               function exportCustomers()
               {
                     $SqlCustomer = "SELECT * FROM e_customers WHERE Login <> 'ExpressCheckoutUser' ORDER BY Cid ASC";
                     return  $this->query($SqlCustomer);
                     
               }

  /*****************Added by karishma****************************/
			function getCustomerGroupsetting()
                {
                    $sqlSettings = "SELECT * from e_customer_group where GroupID!=1";
                    return $this->query($sqlSettings, 1);
                }
    
    
              /***************************************Customer Group Functions Ended****************************************************/  
}
?>
