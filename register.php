<?php   
require_once("includes/header.php");
include_once("includes/header_menu.php");
	 
                    if (!empty($_POST)){
                                    
                               $customerId = $objCustomer->addCustomer($_POST);
                              
                               /********Connecting to main database*********/
                                            $Config['DbName'] = $Config['DbMain'];
                                            $objConfig->dbName = $Config['DbName'];
                                            $objConfig->connect();
                                            /*******************************************/
                                            $Country = $_POST['Country'];
                                            $main_state_id = $_POST['main_state_id'];
                                            $OtherState = $_POST['OtherState'];
                                            $main_city_id = $_POST['main_city_id'];
                                            $OtherCity = $_POST['OtherCity'];
                                            if($Country>0){
                                                    $arryCountryName = $objRegion->GetCountryName($Country);
                                                    $CountryName = stripslashes($arryCountryName[0]["name"]);
                                            }

                                            if(!empty($main_state_id)) {
                                                    $arryState = $objRegion->getStateName($main_state_id);
                                                    $StateName = stripslashes($arryState[0]["name"]);
                                            }else if(!empty($OtherState)){
                                                     $StateName = stripslashes($OtherState);
                                            }

                                            if(!empty($main_city_id)) {
                                                    $arryCity = $objRegion->getCityName($main_city_id);
                                                    $CityName = stripslashes($arryCity[0]["name"]);
                                            }else if(!empty($OtherCity)){
                                                     $CityName = stripslashes($OtherCity);
                                            }

                                            /*******************************************/
                                            
                                /********Connecting to main database*********/
                                            $Config['DbName'] = $_SESSION['CmpDatabase'];
                                            $objConfig->dbName = $Config['DbName'];
                                            $objConfig->connect();
                                            /*******************************************/              
                               
                             if(!empty($customerId))
                              {
                                 //Send Registration Email to Customer/Admin
                                  $objCustomer->customerRegistrationEmail($_POST,$CountryName,$StateName,$CityName);
                                 
                                 /**********************************************CODE FOR LOGIN USER********************************************************************/
                                     	if($arryMember = $objCustomer->ValidateCustomer($_POST['Email'], $_POST['Password'], $_POST['LoginType']))
                                                 {
                                                        $objCustomer->updateSessionCustomer($arryMember[0]['Cid']);
							$_SESSION['Password'] = $arryMember[0]['Password']; 
							$_SESSION['Email'] = $arryMember[0]['Email']; 
							$_SESSION['Cid'] =    $arryMember[0]['Cid'];
                                                        $_SESSION['Level'] =    $arryMember[0]['Level']; 
                                                        $_SESSION['GroupID'] =    $arryMember[0]['GroupID'];
							$_SESSION['Name'] = ucfirst($arryMember[0]['FirstName']).' '.ucfirst($arryMember[0]['LastName']); 
							$_SESSION['CompanyName']= $arryMember[0]['Company']; 

							if(!empty($_POST['Remember'])){
								setcookie("RememberUserName", $arryMember[0]['Email'], time()+(5*3600));
								setcookie("RememberPassword", $arryMember[0]['Password'], time()+(5*3600));
							}
							
						
                                                        
						/****** Update Member Cart On Login *****/
							$arryCart = $objOrder->GetCart(session_id());	
							$numCart  = $objOrder->numRows(); 
							if($numCart > 0){
								$PrdIDs = '';
								foreach($arryCart as $key=>$values){
									$PrdIDs .= $values['ProductID'].',';
								}
								$objCustomer->UpdateCustomerCart($_SESSION['Cid'],$PrdIDs);
							}


							if(!empty($_POST['ContinueUrl'])){
								$_POST['ContinueUrl'] = str_replace(",","&",$_POST['ContinueUrl']);
								header('location:'.$_POST['ContinueUrl']);
								exit;
							}
                                                        else{
                                                                if(!empty($_GET['ProductId']))
                                                                {
                                                                    header('location:productDetails.php?id='.$_GET['ProductId'].'&review=1');
                                                                    exit;
                                                                }
                                                                else {
                                                                    $_SESSION['successMsg'] = ACCOUNT_CREATED_SUCCESS;
                                                                    header('location:account.php');
                                                                    exit;
                                                                }
							 }
						
						
					   } else{
						 $_SESSION['errorMsg'] = INVALID_LOGIN;

					}
/**********************************************END CODE FOR LOGIN USER********************************************************************/
                              }
                          }
     

require_once("includes/footer.php"); 

               
?>