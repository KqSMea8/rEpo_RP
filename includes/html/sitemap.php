<link href="css/sitemap.css" rel="stylesheet" type="text/css" />
<table cellspacing="0" cellpadding="0" width="100%" align="center">
      
	  <tr>
        <td  align="left" valign="middle" class="heading"><?=SITEMAP?></td>
      </tr> 
	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span >
          <?=$Nav_Home?>
          </span> <?=SITEMAP?></td>
      </tr>
     
      <tr>
        <td height="30"></td>
      </tr>
     
	  
	  <tr>
        <td  valign="top"  >
		
		
		<table cellspacing="0" cellpadding="0"  width="100%">
        
        
       
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
     
      <tr>
        <td valign="top"><div class="sitemap_link"><a href="index.php">Home</a></div></td>
      </tr>
      <tr>
        <td valign="top"><table width="905" border="0" align="right" cellpadding="0" cellspacing="0">
         
		 
		  <tr>
            <td class="sitemapborder">
			
			
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
          
		 <tr>
                <td class="sitemap_td"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="sitemap_maingap"></div><div class="sitemap_link">Categories</div></td>
                  </tr>
                  <tr>
                    <td><div class="sitemap_cross"></div>
					
					<?
			$LimitCat =5;
			for($i=0;$i<$LimitCat;$i++){
				$CatUrl = 'category.php?cat='.$arryTopCategory[$i]['CategoryID'].$StoreSuffix;
				  
				  echo '<div class="sitemap_sublink"><a href="'.$CatUrl.'">'.stripslashes($arryTopCategory[$i]['Name']).'</a></div>';
				  if($i < $LimitCat-1){
				  	echo '<div class="sitemap_subgap"></div>';
				  }
			}
			?>
					
					</td>
                  </tr>
				  <tr>
                    <td><div class="sitemap_curve"></div>
					
					<?
			for($i=$LimitCat;$i<sizeof($arryTopCategory);$i++){
				$CatUrl = 'category.php?cat='.$arryTopCategory[$i]['CategoryID'].$StoreSuffix;
				  
				  echo '<div class="sitemap_sublink"><a href="'.$CatUrl.'">'.stripslashes($arryTopCategory[$i]['Name']).'</a></div>';
				  if($i < sizeof($arryTopCategory)-1){
				  	echo '<div class="sitemap_subgap"></div>';
				  }
			}
			?>
					
					</td>
                  </tr>
                </table></td>
              </tr> 
		    
			
					
           
				    <tr><td class="sitemap_td"><div class="sitemap_maingap"></div>
                    <div class="sitemap_link"><a href="products.php" >Quick Order</a></div></td>
                    </tr>
					           
				   
				    <tr><td class="sitemap_td"><div class="sitemap_maingap"></div>
                    <div class="sitemap_link"><a href="special_offers.php" >Special&nbsp;offers</a></div></td>
                    </tr>
					
	 <tr>
                <td class="sitemap_td"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="sitemap_maingap"></div>
                        <div class="sitemap_link"><a href="member-area.php">My Account</a></div></td>
                  </tr>
				  
				 
                  <tr>
                    <td><div class="sitemap_curve"></div>
                      <div class="sitemap_sublink"><a href="signup.php">Registration</a></div>   
					  <div class="sitemap_subgap"></div>
					   <div class="sitemap_sublink"><a href="login.php">Login</a></div>   
						<div class="sitemap_subgap"></div>
					   <div class="sitemap_sublink"><a href="forgot.php"><?=FORGOT_PASSWORD?></a></div>   
				  
	<? if($_SESSION['MemberType']=='Seller'){ ?>
			 <div class="sitemap_subgap"></div>
					   <div class="sitemap_sublink"><a href="account-company.php"><?=EDIT_ACCOUNT?></a></div>
			  <div class="sitemap_subgap"></div>
					   <div class="sitemap_sublink"><a href="view-company.php?view=<?=$_SESSION['MemberID']?>"><?=VIEW_COMPANY_PROFILE?></a></div>
		  	<div class="sitemap_subgap"></div>
					   <div class="sitemap_sublink"><a href="upgrade-membership.php"><?=UPGRADE_MEMBERSHIP?></a></div>
		  <? }else{ ?>
			 <div class="sitemap_subgap"></div>
					   <div class="sitemap_sublink"><a href="account.php"><?=EDIT_ACCOUNT?></a></div>
			<? } ?> 
			<div class="sitemap_subgap"></div>
					   <div class="sitemap_sublink"><a href="change-password.php"><?=CHANGE_PASSWORD?></a></div>			  
			 <div class="sitemap_subgap"></div>
					   <div class="sitemap_sublink"><a href="myOrders.php"><?=MY_ORDERS?></a></div>
				  
				  
				  
					  
					                     </td>
                  </tr>
                </table></td>
              </tr>				
					
					
                     <tr><td class="sitemap_td"><div class="sitemap_maingap"></div>
                    <div class="sitemap_link"><a href="aboutus.php" >About Us</a></div></td>
                    </tr>
                    <tr><td class="sitemap_td"><div class="sitemap_maingap"></div>
                    <div class="sitemap_link"><a href="howtoorder.php" >How to Order</a></div></td>
                    </tr>
                    <tr><td class="sitemap_td"><div class="sitemap_maingap"></div>
                    <div class="sitemap_link"><a href="specialrequest.php" >Special Request</a></div></td>
                    </tr>
                    <tr><td class="sitemap_td"><div class="sitemap_maingap"></div>
                    <div class="sitemap_link"><a href="wholesale.php" >Wholesale</a></div></td>
                    </tr>
					
				 <tr><td class="sitemap_td"><div class="sitemap_maingap"></div>
                    <div class="sitemap_link"><a href="buyer_protection.php" >Buyer Protection</a></div></td>
                    </tr>
					
				 <tr><td class="sitemap_td"><div class="sitemap_maingap"></div>
                    <div class="sitemap_link"><a href="easy_transaction.php" >Easy Transaction Procedure</a></div></td>
                    </tr>		
					
			  <tr>
                <td class="sitemap_td"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="sitemap_maingap"></div><div class="sitemap_link">Search</div></td>
                  </tr>
                  <tr>
                    <td><div class="sitemap_curve"></div><div class="sitemap_sublink"><a href="search-products.php?SearchBy=Product&topkey=a">Search Product Keyword</a></div><div class="sitemap_subgap"></div><div class="sitemap_sublink"><a href="advanceSearch.php">Advanced Search</a></div><div class="sitemap_subgap"></div><div class="sitemap_sublink"><a href="alpha-products.php?ch=A">Search Products Alphabetically</a></div>
					
			
					
					</td>
                  </tr>
                </table></td>
              </tr>	
			  	
		  <tr><td class="sitemap_td"><div class="sitemap_maingap"></div>
                    <div class="sitemap_link"><a href="emailsignup.php" >Email sign up</a></div></td>
                    </tr>			
		  <tr><td class="sitemap_td"><div class="sitemap_maingap"></div>
                    <div class="sitemap_link"><a href="freight_instructions.php" >Freight Instructions</a></div></td>
                    </tr>			
					
             <tr>
                <td class="sitemap_td"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="sitemap_maingap"></div><div class="sitemap_link">Customer Service</div></td>
                  </tr>
                  <tr>
                    <td><div class="sitemap_curve"></div><div class="sitemap_sublink"><a href="help.php">Help</a></div><div class="sitemap_subgap"></div><div class="sitemap_sublink"><a href="faq.php">FAQ</a></div><div class="sitemap_subgap"></div><div class="sitemap_sublink"><a href="contact.php">Contact Us</a></div></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td class="sitemap_td"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="sitemap_maingap"></div>
                        <div class="sitemap_link">Payment</div></td>
                  </tr>
                  <tr>
                    <td><div class="sitemap_curve"></div>
                        <div class="sitemap_sublink"><a href="buyer_protection.php">Buyer Protection</a></div>
						
                      <div class="sitemap_subgap"></div>
                      <div class="sitemap_sublink"><a href="payment_methods.php">Payment Methods</a></div>  
					  
                      <div class="sitemap_subgap"></div>
                      <div class="sitemap_sublink"><a href="proceed_pay.php">Proceed to pay</a></div>  

                      <div class="sitemap_subgap"></div>
                      <div class="sitemap_sublink"><a href="payment_confirmation.php">Payment Confirmation</a></div>  

					  
					                      </td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td class="sitemap_td"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="sitemap_maingap"></div>
                        <div class="sitemap_link">Dispatch and Delivery </div></td>
                  </tr>
                  <tr>
                    <td><div class="sitemap_curve"></div>
                        <div class="sitemap_sublink"><a href="delivery_options.php">Delivery Options</a></div>
                      <div class="sitemap_subgap"></div>
                      <div class="sitemap_sublink"><a href="delivery_cost.php">Delivery Cost</a></div>
                      <div class="sitemap_subgap"></div>
                      <div class="sitemap_sublink"><a href="customs_import.php">Customs & Import Tax</a></div>
                      <div class="sitemap_subgap"></div>
                      <div class="sitemap_sublink"><a href="track_order.php">Tracking Your Items</a></div>
					  
					  
					  </td>



                  </tr>
                </table></td>
              </tr>
              <tr>
                <td class="sitemap_td"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="sitemap_maingap"></div>
                        <div class="sitemap_link">Dispute</div></td>
                  </tr>
                  <tr>
                    <td><div class="sitemap_curve"></div>
                        <div class="sitemap_sublink"><a href="dispute_process.php">Dispute Process</a></div>
                      <div class="sitemap_subgap"></div>
                      <div class="sitemap_sublink"><a href="escalated_disputes.php">Escalated Disputes</a></div>
                    
					</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
          </tr>
        </table></td>
      </tr>
    </table>