<?php 
session_start();
require_once("includes/header.php");
 
include_once("includes/header_menu.php");

$post_form = $_REQUEST;

$orderid = base64_decode($post_form['OrderID']);

$orderdata = $objOrder->getOrderData($orderid);

if ((trim(strtolower($post_form["payment_status"])) == "completed") || (trim(strtolower($post_form["payment_status"])) == "pending"))
			{
				//reinsure all is OK - verify request
				$post_data = 'cmd=_notify-validate';
				reset($post_form);
				foreach ($_POST as $var_name=>$var_value)
				{
					$post_data .= "&".$var_name."=".urlencode($var_value);
				}
				
				//
                                
                                 if($settings['paypalipn_Mode'] == "TEST"){
                                    $post_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
                                    }else{
                                    $post_url = "https://secure.paypal.com/cgi-bin/webscr";
                                    }
				
				
				//send data back to server
				$c = curl_init();
				
				curl_setopt($c, CURLOPT_URL, trim($post_url));
				curl_setopt($c, CURLOPT_FAILONERROR, 1);
				curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($c, CURLOPT_POST, 1);
				curl_setopt($c, CURLOPT_POSTFIELDS, $post_data);
			
				curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 1);
				
				$buffer = curl_exec($c);
				
				
				
				curl_close($c);
				
				//check verification value
				if (trim(strtolower($buffer)) == "verified")
				{
					reset($post_form);
					$response = "Verification Status: ".$buffer."\n";
					foreach ($post_form as $var_name=>$var_value)
					{
						$response.=$var_name." = ".$var_value."\n";
						if ($var_name == "auth_id") $transaction_id = $var_value;
						if ($var_name == "payment_status") $payment_status = $var_value;	
						if ($var_name == "pending_reason") $PendingReason = $var_value;
					}
                                        
					$objPayment->createTransaction($orderdata, $response, $transaction_id);
                            
					
				}
				else
				{
                                    
					
					$errorMessage = "Can't complete your order. PayPal payment is not completed yet.";
                                        
                                    /*$yname = "aaaaaaaaaa";
                                    $yemail = "rajeev@sakshay.in";
                                    $fname = "bbbbbb";
                                    $femail = "rajeevsharma210@gmail.com";

                                    $htmlPrefix = $Config['EmailTemplateFolder'];
                                    $contents = file_get_contents($htmlPrefix."emailto_friend.htm");
                                    $subject  = "Hello, $fname. This is $yname You must see it!";

                                    $contents = str_replace("[COMPANY_NAME]",$Config['DisplayName'],$contents);
                                    $contents = str_replace("[YOUR_NAME]",$yname, $contents);
                                    $contents = str_replace("[FRIEND_NAME]",$fname, $contents);

                                    $contents = str_replace("[PRODUCT_NAME]",$errorMessage, $contents);


                                    $mail = new MyMailer();
                                    $mail->IsMail();			
                                    $mail->AddAddress($femail);
                                    $mail->sender($Config['SiteName'], $yemail);   
                                    $mail->Subject = $Config['SiteName']." - ".$subject;
                                    $mail->IsHTML(true);
                                    $mail->Body = $contents;   

                                   // echo "=>".$htmlPrefix."=>".$contents;exit;

                                    if($Config['Online'] == '1')
                                        {

                                            $mail->Send();	
                                        }*/
				}
			}

       




 ?>


