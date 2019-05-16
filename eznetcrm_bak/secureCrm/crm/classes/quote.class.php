<?
class quote extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function quote(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addQuote($arryDetails)
	{    global $Config;
     
		@extract($arryDetails);	

               
                if($Config['CronEntry']==1){ //cron entry
				$EntryType = 'one_time';
				$OrderDate = $Config['TodayDate'];
				$MainTaxRate = $TaxRate;
                                $opportunityID = $OpportunityID;
                                $AssignUser = $assignTo;

                        
			}else{
                        
                                
                                 if($assign == 'User'){
                                    $AssignUser = $AssignToUser;
                                    $AssignType = $assign;
                                    }else{
                                     $arryAsign = explode(":",$AssignToGroup);
                                     $AssignUser = $arryAsign[0];
                                     $AssignType = $assign;
                                     $GroupID =  $arryAsign[1];
                                 }
                                 
                                $CreatedBy = $_SESSION['UserName'];
				$AdminID = $_SESSION['AdminID'];
				$AdminType = $_SESSION['AdminType'];
                                $opportunityID = $opportunityID;
			}
                
                       
                          
                        if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}
                        
                        if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                        if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                        if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
                        if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}


			$sql = "INSERT INTO c_quotes SET EntryType='".$EntryType."',
                                EntryInterval='".$EntryInterval."',
                                EntryMonth='".$EntryMonth."', 
                                EntryWeekly = '".$EntryWeekly."',    
                                EntryFrom='".$EntryFrom."',
                                EntryTo='".$EntryTo."',
                                EntryDate='".$EntryDate."', 
                                subject = '".$subject."',
				CustType='".addslashes($CustType)."',
				CustCode='".addslashes($CustCode)."',
				CustID='".addslashes($CustID)."',
				CustomerName='".addslashes($CustomerName)."',
				CustomerCompany='".addslashes($CustomerCompany)."',
				ShippingName='".addslashes($ShippingName)."',
				ShippingCompany='".addslashes($ShippingCompany)."',
				quotestage='".addslashes($quotestage)."',
				validtill ='".$validtill."', 
				contactid = '".addslashes($contact_name)."', 
				carrier = '".$carrier."',
				shipping = '".addslashes($shipping)."',
				assignTo = '".$AssignUser."',
				AssignType = '".$AssignType."',
				GroupID = '".$GroupID."',
				currency_id = '".$currency_id."',
				description = '".$description."',
				opportunityName = '".$opportunityName."',
				OpportunityID = '".$opportunityID."',
				TotalAmount = '".addslashes($TotalAmount)."',
				Freight ='".addslashes($Freight)."', 
				taxAmnt ='".addslashes($taxAmnt)."',
				CreatedBy = '".addslashes($CreatedBy)."', 
				AdminID='".$AdminID."',
				AdminType='".$AdminType."',
				Taxable = '".addslashes($Taxable)."',
				Reseller='".addslashes($Reseller)."' ,
				ResellerNo='".addslashes($ResellerNo)."',
				PostedDate='".$Config['TodayDate']."',
				tax_auths = '".addslashes($tax_auths)."',
				TaxRate = '".addslashes($MainTaxRate)."',
				Comment = '".addslashes($Comment)."',
				UpdatedDate='".$Config['TodayDate']."'";

	//echo "=>".$sql;exit;
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
                        

		//'".addslashes($opportunityName)."','".addslashes($opportunityID)."',

		if(!empty($lastInsertId)){

         
		  /***************************BILL ADDRESS ADDED ******/ 
			  $sqlbillads = "insert into c_quotesbillads  (quoteid,bill_city,bill_code,bill_country,bill_state,bill_street,bill_pobox,ship_city,ship_code,ship_country,ship_state,ship_street,ship_pobox) values( '".$lastInsertId."', '".addslashes($bill_city)."','".addslashes($bill_code)."','".addslashes($bill_country)."','".addslashes($bill_state)."','".addslashes($bill_street)."',  '".addslashes($bill_pobox)."','".addslashes($ship_city)."','".addslashes($ship_code)."','".addslashes($ship_country)."','".addslashes($ship_state)."','".$ship_street."','".$ship_pobox."')";
                     
			  $this->query($sqlbillads, 0);
		  /***************************END BILL ADDRESS ******/


		  /********************OPPORTUNITY ADDED ******/

					if($opportunityID!=''){
							  $sqlOppAdd="insert into c_quote_opp  (quoteID,opportunityName,opportunityID,mode_type) values(  '".addslashes($lastInsertId)."','".addslashes($opportunityName)."','".addslashes($opportunityID)."','Quote')";
                                                          $this->query($sqlOppAdd, 0);
					}

		  /************End Opportunity**************/

		  /********************PRODUCT ADDED ******/

		/*for($i=1; $i<=$totalProductCount; $i++){
			  $sqlquoteProduct = "insert into c_quotes_products  (quoteId,productName,hdnProductId,qty,comment,type,listPrice ,discount_type ,discount ,discount_percentage ,discount_amount,qty_in_stock) values('".$lastInsertId."','".addslashes($_POST['productName'.$i])."' ,'".$_POST['hdnProductId'.$i]."','".$_POST['qty'.$i]."' ,'".addslashes($_POST['comment'.$i])."' , '".$_POST['type'.$i]."','".$_POST['listPrice'.$i]."' ,'".$_POST['discount_type'.$i]."' ,'".$_POST['discount'.$i]."' ,'".$_POST['discount_percentage'.$i]."' ,'".$_POST['discount_amount'.$i]."','".$_POST['qty_in_stock'.$i]."')";
			

		  $this->query($sqlquoteProduct, 0);
	}*/
	/************End PRODUCT**************/
		}
		return $lastInsertId;
		
	}

     function AddUpdateQuoteItem($order_id, $arryDetails)
		{  
		        global $Config;
                       
			extract($arryDetails);
			if(!empty($DelItem)){
				$strSQLQuery = "delete from c_quote_item where id in(".$DelItem.")"; 
				$this->query($strSQLQuery, 0);
			}
		   $discountAmnt = 0;$taxAmnt=0;
			for($i=1;$i<=$NumLine;$i++){
				if(!empty($arryDetails['sku'.$i])){
					$arryTax = explode(":",$arryDetails['tax'.$i]);
					$id = $arryDetails['id'.$i];
					
					if($arryDetails['discount'.$i] > 0){
					 $discountAmnt += $arryDetails['discount'.$i];
					}
				
					if($arryTax[1] > 0){
					 $actualAmnt = $arryDetails['price'.$i]-$arryDetails['discount'.$i];	
					 $taxAmnt = ($actualAmnt*$arryTax[1])/100;
					 $totalTaxAmnt += $taxAmnt;
					}
					if($id>0){
						$sql = "update c_quote_item set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', on_hand_qty='".addslashes($arryDetails['on_hand_qty'.$i])."', qty='".addslashes($arryDetails['qty'.$i])."', price='".addslashes($arryDetails['price'.$i])."', tax_id='".$arryTax[0]."', tax='".$arryTax[1]."', amount='".addslashes($arryDetails['amount'.$i])."', discount ='".addslashes($arryDetails['discount'.$i])."',Taxable='".addslashes($arryDetails['item_taxable'.$i])."',req_item='".addslashes($arryDetails['req_item'.$i])."'  where id='".$id."'"; 
					}else{
						$sql = "insert into c_quote_item(OrderID, item_id, sku, description, on_hand_qty, qty, price, tax_id, tax, amount, discount, Taxable, req_item) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".$arryTax[0]."', '".$arryTax[1]."', '".addslashes($arryDetails['amount'.$i])."','".addslashes($arryDetails['discount'.$i])."','".addslashes($arryDetails['item_taxable'.$i])."' ,'".addslashes($arryDetails['req_item'.$i])."')";
					}
					$this->query($sql, 0);	

				}
			}


			#$strSQL = "update c_quotes set discountAmnt ='".$discountAmnt."',taxAmnt = '".$taxAmnt."' where quoteid='".$order_id."'"; 

			$strSQL = "update c_quotes set discountAmnt ='".$discountAmnt."' where quoteid='".$order_id."'"; 
			$this->query($strSQL, 0);
			return true;

		}
                
	function updateQuote($arryDetails)
	{
		@extract($arryDetails);	

                                     if($assign == 'User'){
				         $AssignUser = $AssignToUser;
				         $AssignType = $assign;
				     }else{
					  $arryAsign = explode(":",$AssignToGroup);
				          $AssignUser = $arryAsign[0];
					  $AssignType = $assign;
					  $GroupID =  $arryAsign[1];
			              }
                                      
                                 if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}
                                 
                                  
                            if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                            if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                            if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
                            if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}

			$sql = "update c_quotes set EntryType='".$EntryType."',
                                        EntryInterval='".$EntryInterval."',  
                                        EntryMonth='".$EntryMonth."',
                                        EntryWeekly = '".$EntryWeekly."',     
                                        EntryFrom='".$EntryFrom."',
                                        EntryTo='".$EntryTo."',
                                        EntryDate='".$EntryDate."', 
                                        subject = '".$subject."',
					CustType='".addslashes($CustType)."',
					CustCode='".addslashes($CustCode)."',
					CustID='".addslashes($CustID)."',
					CustomerName='".addslashes($CustomerName)."',
					CustomerCompany='".addslashes($CustomerCompany)."',
					ShippingName='".addslashes($ShippingName)."',
					ShippingCompany='".addslashes($ShippingCompany)."',
					quotestage='".addslashes($quotestage)."',
					validtill ='".$validtill."', 
					contactid = '".addslashes($contact_name)."', 
					carrier = '".$carrier."',
					shipping = '".addslashes($shipping)."',
					assignTo = '".$AssignUser."',
                                        AssignType = '".$AssignType."',
                                        GroupID = '".$GroupID."',
					currency_id = '".$currency_id."',
					description = '".$description."',
					opportunityName = '".$opportunityName."',
		                        OpportunityID = '".$opportunityID."',
					TotalAmount = '".addslashes($TotalAmount)."',
					Freight ='".addslashes($Freight)."',
					taxAmnt ='".addslashes($taxAmnt)."',
					Taxable = '".addslashes($Taxable)."',			
					Reseller='".addslashes($Reseller)."' ,
					ResellerNo='".addslashes($ResellerNo)."',	
					tax_auths = '".addslashes($tax_auths)."',
					TaxRate = '".addslashes($MainTaxRate)."',
					Comment = '".addslashes($Comment)."'
                                        where quoteid = '".$quoteid."'"; 
                                        $rs = $this->query($sql,0);

		
  /********************OPPORTUNITY Update ******/
   $sql4 = "delete from c_quote_opp where quoteID = ".$quoteid;
		 $this->query($sql4,0);

if($opportunityID!=''){
	$sqlOppAdd="insert into c_quote_opp  (quoteID,opportunityName,opportunityID,mode_type) values(  '".addslashes				($quoteid)."','".addslashes($opportunityName)."','".addslashes($opportunityID)."','Quote')";
	$this->query($sqlOppAdd, 0);
}

		  /************End Opportunity**************/

		

 $sqlAddress = "update c_quotesbillads set bill_city = '".addslashes($bill_city)."',bill_code = '".addslashes($bill_code)."',bill_country = '".addslashes($bill_country)."',	bill_state = '".addslashes($bill_state)."',bill_street = '".addslashes($bill_street)."',									bill_pobox = '".$bill_pobox."',ship_city = '".$ship_city."',ship_code = '".$ship_code."',ship_country = '".addslashes($ship_country)."',						ship_state = '".addslashes($ship_state)."',ship_street = '".addslashes($ship_street)."',ship_pobox = '".addslashes($ship_pobox)."'
  where quoteid = '".$quoteid."'"; 
		  $rsUp = $this->query($sqlAddress,0);


		
		if(sizeof($rs)){	   

			return true;
		}else{
			return false;
		}
	}



function addQuoteEmp($arryDetails)
		{
			
			extract($arryDetails);
			$sql = "delete from c_quotes_emp where quoteID =".$quoteID;
			$rs = $this->query($sql,0);
			for($i=0;$i<sizeof($EmpID); $i++){
				$sql = "insert into c_quotes_emp( EmpID, quoteID) values('".$EmpID[$i]."', '".$quoteID."')";
				$rs = $this->query($sql,0);
				}
		
			return 1;

		}


	function GetCustomerQuote($CustID)
	{
		$sql = " where 1 ";
		$sql .= (!empty($CustID))?(" and q.CustID = '".$CustID."'"):("");
		$sql = "select q.*,e.Email as CreatedByEmail from c_quotes q  left outer join h_employee e on (q.AdminID=e.EmpID and q.AdminType!='admin')  ".$sql." order by q.quoteid Desc" ; 

		return $this->query($sql, 1);
	}


	function GetQuote($quoteid,$Limit)
	{
		$sql = " where 1 ";
		$sql .= (!empty($quoteid))?(" and q.quoteid = '".$quoteid."'"):("");

		$sql = "select q.*,e.Email as CreatedByEmail from c_quotes q  left outer join h_employee e on (q.AdminID=e.EmpID and q.AdminType!='admin')  ".$sql." order by q.quoteid Asc" ; 

		

		return $this->query($sql, 1);
	}


function GetQuoteAddress($quoteid,$Limit)
	{
		$sql = " where 1 ";
		$sql .= (!empty($quoteid))?(" and quoteid = '".$quoteid."'"):("");
		$sql = "select * from c_quotesbillads ".$sql; 

		return $this->query($sql, 1);
	}

            function  GetQuoteItem($quoteid)
		{
			$strAddQuery .= (!empty($quoteid))?(" and i.OrderID='".$quoteid."'"):("");
			$strSQLQuery = "select i.*,t.RateDescription from c_quote_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";

			return $this->query($strSQLQuery, 1);
		}

	function GetQuoteProduct($quoteid,$Limit)
	{
		$sql = " where 1 ";
		$sql .= (!empty($quoteid))?(" and q.quoteid = ".$quoteid):("");
		
		//$sql = "select * from c_quotes_products   ".$sql;

		$sql = "select q.*,p.Name,p.Price as SalePrice,p.Quantity from c_quotes_products q inner join e_products p on q.hdnProductId=p.ProductID ".$sql." order by q.qtpid Asc" ; 

		return $this->query($sql, 1);
	}
	function getUpQuote($Limit)
	{
		$sql = " where  e.startDate>=now() ";

		$sql = "select e.*, from c_quotes e  ".$sql." order by e.startDate asc";

		$sql .= (!empty($Limit))?(" limit 0,".$Limit):("");

		return $this->query($sql, 1);
	}


	
	function changeQuoteStatus($quoteID)
	{
		$sql="select * from c_quotes where quoteID=".$quoteID;
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update c_quotes set Status='$Status' where quoteID=".$quoteID;
			$this->query($sql,0);
			
		}
		if($Status==1 && $rs[0]['Status']!=1 ){
				$this->QuoteActiveEmail($quoteID);
			}
			return true;			
	}

	
	function RemoveQuote($quoteID)
	{


		$sql = "delete from c_quotes where quoteid = ".$quoteID;
		$rs = $this->query($sql,0);

		$sql2 = "delete from c_quotesbillads where quoteid = ".$quoteID;
		$rs2 = $this->query($sql2,0);

		$sql3 = "delete from c_quote_item where OrderID = ".$quoteID;
		$rs3 = $this->query($sql3,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}
	function SendEmailToAdmin($quoteID)
		{
			global $Config;
			 $objLead=new lead();
			$arryQuote = $this->GetQuote($quoteID,'','','','');

			$htmlPrefix = $Config['EmailTemplateFolder'];
            
			 if($arryQuote[0]['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
					$ToEmail = $Config['AdminEmail'];
			 }else{
				$CreatedBy = stripslashes($arryQuote[0]['CreatedBy']);
				$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$arryQuote[0]['AdminID']."'";
				$arryEmp = $this->query($strSQLQuery, 1);
				$ToEmail = $arryEmp[0]['Email'];
				$CC = $Config['AdminEmail'];
			  }

			  $SalesPerson='';
			  if(!empty($arryQuote[0]['assignTo'])){ 
				$arryEmp=$objLead->GetAssigneeUser($arryQuote[0]['assignTo']);
				for($i=0;$i<sizeof($arryEmp);$i++) {
					$SalesPerson .= $arryEmp[$i]['UserName'].', ';
				}
				$SalesPerson = rtrim($SalesPerson,", ");
			  }	

			

			
				$objCofigure = new configure();

                                $TemplateContent = $objCofigure->GetTemplateContent(7,1);
                                $contents   = $TemplateContent[0]['Content'];
           
				//$contents = file_get_contents($htmlPrefix."new_quote.htm");
				if($arryQuote[0]['CustType'] == "c")
                                {
                                    $CustType = "Customer";
                                }else{
                                    $CustType = "Opportunity";
                                }
                                
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[SUBJECT]",(!empty($arryQuote[0]['subject']))?(stripslashes($arryQuote[0]['subject'])):(NOT_SPECIFIED),$contents);
                                $contents = str_replace("[CUSTOMERTYPE]",(!empty($CustType))?(stripslashes($CustType)):(NOT_SPECIFIED),$contents);
                                $contents = str_replace("[QUOTESTAGE]",(!empty($arryQuote[0]['quotestage']))?(stripslashes($arryQuote[0]['quotestage'])):(NOT_SPECIFIED),$contents);
                                $contents = str_replace("[QUOTESTAGE]",(!empty($arryQuote[0]['quotestage']))?(stripslashes($arryQuote[0]['quotestage'])):(NOT_SPECIFIED),$contents);
                                $contents = str_replace("[CARRIER]",(!empty($arryQuote[0]['carrier']))?(stripslashes($arryQuote[0]['carrier'])):(NOT_SPECIFIED),$contents);
				$contents = str_replace("[OPPORTUNITY]",(!empty($arryQuote[0]['opportunityName']))?(stripslashes($arryQuote[0]['opportunityName'])):(NOT_SPECIFIED),$contents);
				$contents = str_replace("[QUOTEID]",(!empty($arryQuote[0]['quoteid']))?(stripslashes($arryQuote[0]['quoteid'])):(NOT_SPECIFIED),$contents);
				$contents = str_replace("[VALIDTILL]",date($Config['DateFormat'],strtotime($arryQuote[0]['validtill'])),$contents);
                                $contents = str_replace("[CREATED]",(!empty($CreatedBy))?(stripslashes($CreatedBy)):(NOT_SPECIFIED),$contents);
				 
				$contents= str_replace("[LINK_URL]",$Config['Url'].'admin/crm/vQuote.php?view='.$quoteID.'&module=Quote', $contents);
				$contents = str_replace("[ASSIGNEDTO]",(!empty($SalesPerson))?(stripslashes($SalesPerson)):(NOT_SPECIFIED),$contents);
				$contents = str_replace("[TOTALAMOUNT]",(!empty($arryQuote[0]['TotalAmount']))?($arryQuote[0]['TotalAmount'].' '.$Config['Currency']):(NOT_SPECIFIED),$contents);	

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
                                #$mail->AddAddress("bhoodev@sakshay.in");
                                //if(!empty($CC)) $mail->AddAddress($CC);
				$mail->sender($_SESSION['UserName'], $_SESSION['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - ". $TemplateContent[0]['subject'];
				$mail->IsHTML(true);
	
				$mail->Body = $contents;  
				//echo $ToEmail.$CC.$contents; exit;
                                   
				
				if($Config['Online'] == '1' && $TemplateContent[0]['Status'] == 1){
					$mail->Send();	
				}
		
			return 1;
		}
		

	function SendAssignEmail($quoteID)
	 {
	  global $Config;
           $objLead=new lead();
	 $arryQuote = $this->GetQuote($quoteID,'','','','');

	 $htmlPrefix = $Config['EmailTemplateFolder'];
            
                         if($arryQuote[0]['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
					//$ToEmail = $Config['AdminEmail'];
			 }else{
				$CreatedBy = stripslashes($arryQuote[0]['CreatedBy']);
				$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$arryQuote[0]['AdminID']."'";
				$arryEmp = $this->query($strSQLQuery, 1);
				//$ToEmail = $arryEmp[0]['Email'];
                                $CreatedBy = $arryEmp[0]['UserName'];
				//$CC = $Config['AdminEmail'];
				}


	  if($arryQuote[0]['assignTo']!=''){

                         $strSQLQuery = "select UserName,Email from h_employee where EmpID in (".$arryQuote[0]['assignTo'].")"; 
				 //$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$AssignedTo."'";
					$arryEmp = $this->query($strSQLQuery, 1);
					

					foreach($arryEmp as $email)
					{
						$ToEmail .= $email['Email'].",";
					}
					$ToEmail = rtrim($ToEmail,",");
					
					//$ToEmail = $arryEmp[0]['Email'];
					$CC = $Config['AdminEmail'];


		/*$AssignUser = $arryQuote[0]['assignTo'];
		$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$AssignUser."'";
		$arryEmp = $this->query($strSQLQuery, 1);
		$ToEmail = $arryEmp[0]['Email'];
		$CC = $Config['AdminEmail'];*/
              }
			

		if($arryQuote[0]['validtill']>0) 
			$validtill = date($Config['DateFormat'],strtotime($arryQuote[0]['validtill']));
	
                
                $SalesPerson='';
			  if(!empty($arryQuote[0]['assignTo'])){ 
				$arryEmp=$objLead->GetAssigneeUser($arryQuote[0]['assignTo']);
				for($i=0;$i<sizeof($arryEmp);$i++) {
					$SalesPerson .= $arryEmp[$i]['UserName'].', ';
				}
				$SalesPerson = rtrim($SalesPerson,", ");
			  }	
                          
                 $objCofigure = new configure();

                $TemplateContent = $objCofigure->GetTemplateContent(8,1);
                $contents   = $TemplateContent[0]['Content'];
                                
		//$contents = file_get_contents($htmlPrefix."assign_quote.htm");
                
                if($arryQuote[0]['CustType'] == "c")
                {
                    $CustType = "Customer";
                }else{
                    $CustType = "Opportunity";
                }
                
		$contents = str_replace("[URL]",$Config['Url'],$contents);
		$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
		$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
                $contents = str_replace("[USERNAME]",$arryEmp[0]['UserName'],$contents);
		$contents = str_replace("[SUBJECT]",(!empty($arryQuote[0]['subject']))?(stripslashes($arryQuote[0]['subject'])):(NOT_SPECIFIED),$contents);
		$contents = str_replace("[OPPORTUNITY]",(!empty($arryQuote[0]['opportunityName']))?(stripslashes($arryQuote[0]['opportunityName'])):(NOT_SPECIFIED),$contents);
		$contents = str_replace("[CUSTOMERTYPE]",(!empty($CustType))?(stripslashes($CustType)):(NOT_SPECIFIED),$contents);
                $contents = str_replace("[QUOTESTAGE]",(!empty($arryQuote[0]['quotestage']))?(stripslashes($arryQuote[0]['quotestage'])):(NOT_SPECIFIED),$contents);
                $contents = str_replace("[CARRIER]",(!empty($arryQuote[0]['carrier']))?(stripslashes($arryQuote[0]['carrier'])):(NOT_SPECIFIED),$contents);
                $contents = str_replace("[ASSIGNEDTO]",$SalesPerson,$contents);
		$contents = str_replace("[QUOTEID]",(!empty($arryQuote[0]['quoteid']))?(stripslashes($arryQuote[0]['quoteid'])):(NOT_SPECIFIED),$contents);
		$contents = str_replace("[VALIDTILL]",$validtill,$contents);
                $contents = str_replace("[CREATED]",$CreatedBy,$contents);
		$contents= str_replace("[LINK_URL]",$Config['Url'].'admin/crm/vQuote.php?view='.$quoteID.'&module=Quote', $contents);

		$mail = new MyMailer();
		$mail->IsMail();			
		$mail->AddAddress($ToEmail);
                #$mail->AddAddress("parwez.khan@sakshay.in");
                if(!empty($CC)) $mail->AddCC($CC);
		$mail->sender($_SESSION['UserName'], $_SESSION['AdminEmail']);   
		$mail->Subject = $Config['SiteName']." - ".$TemplateContent[0]['subject'];
		$mail->IsHTML(true);

		$mail->Body = $contents;  
                
                //echo $ToEmail.$CC.$contents; exit;
			
		if($Config['Online'] == '1' && $TemplateContent[0]['Status'] == 1){
			$mail->Send();	
		}
		
		

		return 1;
	}
		
		
		
	
	function  ListQuote($id=0,$parent_type,$parentID,$SearchKey,$SortBy,$AscDesc)
			{
			global $Config;
			$strAddQuery = ' where 1 ';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and q.quoteid=".$id):("");

			#$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (q.assignTo like '%".$_SESSION['AdminID']."%' OR q.AdminID='".$_SESSION['AdminID']."') "):("");

			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (FIND_IN_SET(".$_SESSION['AdminID'].",q.assignTo) OR q.AdminID='".$_SESSION['AdminID']."') "):("");


			if($SortBy == 'q.subject'){$strAddQuery .= (!empty($SearchKey))?(" and (q.subject like '%".$SearchKey."%')"):("");	}
			else if($SortBy == 'q.quoteid'){ $strAddQuery .= (!empty($SearchKey))?(" and (q.quoteid = '".$SearchKey."')"):("");}
			else{
			if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (q.subject like '%".$SearchKey."%' or q.quotestage like '%".$SearchKey."%' or q.TotalAmount like '%".$SearchKey."%' or q.quoteid like '%".$SearchKey."%'  )"):("");
			}
			}

			$strAddQuery .= (!empty($SortBy))?(" group by q.quoteid order by ".$SortBy." "):(" group by q.quoteid order by q.quoteid ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");


			$strSQLQuery = "select q.* from c_quotes q   ".$strAddQuery;

			return $this->query($strSQLQuery, 1);

	}
	
	
	
	function GetAssignee($arrayDetail) {
		$strSQLQuery = "select EmpID,UserName,Email from h_employee where EmpID in (".$arrayDetail.")";
		return $this->query($strSQLQuery, 1);

	}
	
	

	function UpdatePdf($Pdf,$quoteID)
	{
			$strSQLQuery = "update c_quotes set Pdf='".$Pdf."' where quoteID=".$quoteID;
			return $this->query($strSQLQuery, 0);
	}

	function isQuoteExists($heading,$quoteID)
	{

		$strSQLQuery ="select * from c_quotes where LCASE(subject)='".strtolower(trim($heading))."'";

		$strSQLQuery .= (!empty($quoteID))?(" and quoteid != ".$quoteID):("");
		

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['quoteid'])) {
			return true;
		} else {
			return false;
		}


	}

	function sendOrderToCustomer($arrDetails)
		{
			global $Config;	
			extract($arrDetails);

			if($quoteid>0){
				$arrySale = $this->GetQuote($quoteid,'','');
				$module = $arrySale[0]['Module'];
				(!$module)?($module='Quote'):(""); 

				if($module=='Quote'){	
					$ModuleIDTitle = "Quote Number"; $ModuleID = "quoteid"; 
				}else if($module=='Order'){
					$ModuleIDTitle = "Sales Order Number"; $ModuleID = "SaleID";
				}

				if($arrySale[0]['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
				}else{
					$CreatedBy = stripslashes($arrySale[0]['CreatedBy']);
				}
				
				$OrderDate = ($arrySale[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['PostedDate']))):(NOT_SPECIFIED);
				$Approved = ($arrySale[0]['Approved'] == 1)?('Yes'):('No');

				$DeliveryDate = ($arrySale[0]['DeliveryDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['DeliveryDate']))):(NOT_SPECIFIED);

				$PaymentTerm = (!empty($arrySale[0]['PaymentTerm']))? (stripslashes($arrySale[0]['PaymentTerm'])): (NOT_SPECIFIED);
				$PaymentMethod = (!empty($arrySale[0]['PaymentMethod']))? (stripslashes($arrySale[0]['PaymentMethod'])): (NOT_SPECIFIED);
				$ShippingMethod = (!empty($arrySale[0]['ShippingMethod']))? (stripslashes($arrySale[0]['ShippingMethod'])): (NOT_SPECIFIED);
				$Message = (!empty($Message))? ($Message): (NOT_SPECIFIED);
				
				#$CreatedBy = ($arrySale[0]['AdminType'] == 'admin')? ('Administrator'): ($arrySale[0]['CreatedBy']);


				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."sales_cust.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[Module]",$module,$contents);
				$contents = str_replace("[ModuleIDTitle]",$ModuleIDTitle,$contents);
				$contents = str_replace("[ModuleID]",$arrySale[0][$ModuleID],$contents);
				$contents = str_replace("[OrderDate]",$OrderDate,$contents);
				$contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
				$contents = str_replace("[Approved]",$Approved,$contents);
				$contents = str_replace("[Status]",$arrySale[0]['Status'],$contents);
				$contents = str_replace("[Subject]",$arrySale[0]['subject'],$contents);
				$contents = str_replace("[Message]",$Message,$contents);
				$contents = str_replace("[DeliveryDate]",$DeliveryDate,$contents);
				$contents = str_replace("[PaymentTerm]",$PaymentTerm,$contents);
				$contents = str_replace("[PaymentMethod]",$PaymentMethod,$contents);
				$contents = str_replace("[ShippingMethod]",$ShippingMethod,$contents);
				$contents = str_replace("[Customer]",stripslashes($arrySale[0]['CustomerName']),$contents);

					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);
				if(!empty($Attachment)) $mail->AddAttachment(getcwd()."/".$Attachment);
				if(!empty($AttachDocument)){
				 	$mail->AddAttachment(getcwd()."/".$AttachDocument);
					
				}
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Sales ".$module;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $ToEmail.$CCEmail.$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}
				if(!empty($AttachDocument))unlink($AttachDocument);
			}

			return 1;
		}



		function  GetLeadCustomer($leadID)
		{
			$strSQLQuery = "select leadID,FirstName,LastName, primary_email from c_lead where primary_email!= '' ";
			$strSQLQuery .= (!empty($leadID))?(" and leadID!='".$leadID."'"):("");
			$strSQLQuery .= " order by FirstName";
			return $this->query($strSQLQuery, 1);
		}
       function  GetNumQuote($quotestage)
	  {
		$strSQLQuery = "select count(quoteid) as TotalQuote from c_quotes where 1 ";
		$strSQLQuery .= (!empty($quotestage))?(" and quotestage = '".$quotestage."'"):("");
		return $this->query($strSQLQuery, 1);		
	  }
	function  GetDashboardQuote()
	{
	global $Config;
	$strSQLQuery = "select q.subject,q.assignTo,q.quoteid,q.AdminID from c_quotes q where 1 and q.quotestage = 'Created' ";

	#$strSQLQuery .= ($Config['vAllRecord']!=1)?(" and (q.assignTo like '%".$_SESSION['AdminID']."%' OR q.AdminID='".$_SESSION['AdminID']."') "):("");
	
	$strSQLQuery .= ($Config['vAllRecord']!=1)?(" and (FIND_IN_SET(".$_SESSION['AdminID'].",q.assignTo) OR q.AdminID='".$_SESSION['AdminID']."') "):("");

	$strSQLQuery .= "  order by  q.quoteid desc limit 0,7";

	//echo $strSQLQuery;

	return $this->query($strSQLQuery, 1);
	}	


	/*****************************/
	function  GetDoc($documentID,$Status)
	{
		if($documentID>0){
			$strSQLQuery = "select t.* from c_document t where  t.documentID='".$documentID."'";		
			$strSQLQuery .= ($Status>0)?(" and t.Status=".$Status):("");
			return $this->query($strSQLQuery, 1);
		}
	}
	function sendDocTo($arrDetails)
		{
			global $Config;	
			extract($arrDetails);

			if($documentID>0){
				$arryDoc = $this->GetDoc($documentID,'');			
				
				
				$Message = (!empty($Message))? ($Message): (NOT_SPECIFIED);
				
				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."send_doc.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

			
				$contents = str_replace("[title]",stripslashes($arryDoc[0]['title']),$contents);
				$contents = str_replace("[description]",stripslashes($arryDoc[0]['description']),$contents);
				
				$contents = str_replace("[Message]",$Message,$contents);
				
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);

				$MainDir = "upload/Document/".$_SESSION['CmpID']."/";
				if($arryDoc[0]['FileName'] !='' && file_exists($MainDir.$arryDoc[0]['FileName']) ){
					 $mail->AddAttachment(getcwd().'/upload/Document/'.$_SESSION['CmpID'].'/'.$arryDoc[0]['FileName']);

				}
				if(!empty($AttachDocument)){
				 	$mail->AddAttachment(getcwd()."/".$AttachDocument);
					
				}
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Document : ".stripslashes($arryDoc[0]['title']);
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				#echo $ToEmail.$CCEmail.$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}
				if(!empty($AttachDocument))unlink($AttachDocument);
			}

			return 1;
		}


	/***************************/
	function  GetRequiredItem($id)
	{
		$sql = "select i.req_item, i.sku from c_quote_item i where i.id='".$id."'";
		$arrayRow = $this->query($sql);
		return $arrayRow;
	}



	function CrmQuoteToSaleOrder($quoteid,$SaleID)
	{
		global $Config;		
		
		$objLead=new lead();
		$objCustomer=new Customer(); 		
		if(!empty($quoteid)){
			$arryQuote = $this->GetQuote($quoteid,'');

			if(!empty($arryQuote[0]['quoteid'])){
				$arryQuoteAddress = $this->GetQuoteAddress($quoteid,'');
				/********  Add Sales Order ********/

//print_r($arryQuote[0]);
				$objSale = new sale();
				$arryQuote[0]['Module'] = 'Order';
				$arryQuote[0]['ModuleID'] = 'SaleID';
				$arryQuote[0]['PrefixSale'] = 'SO';	
				$arryQuote[0]['SaleID'] = $SaleID;
				$arryQuote[0]['QuoteID'] = $quoteid;
				$arryQuote[0]['Approved'] = '1';
				$arryQuote[0]['Status'] = 'Open';
 				$arryQuote[0]['ShippingMethod'] = $arryQuote[0]['carrier'];
				$arryQuote[0]['PaymentTerm'] = $arryQuote[0]['terms'];
				$arryQuote[0]['OrderDate'] = $Config['TodayDate'];			
				$arryQuote[0]['ClosedDate'] = $arryQuote[0]['validtill'];			
				$arryQuote[0]['MainTaxRate'] = $arryQuote[0]['TaxRate']; 
				if(!empty($arryQuote[0]['assignTo'])){	
					unset($arryEmp);			
					$sqlEmp = "select EmpID,UserName from h_employee where EmpID in (".$arryQuote[0]['assignTo'].") ";
					$arryEmp = $this->query($sqlEmp, 1);
					$arryQuote[0]['SalesPersonID'] = $arryEmp[0]['EmpID'];	
					$arryQuote[0]['SalesPerson'] = $arryEmp[0]['UserName'];

				}
				

if($arryQuote[0]['CustType']=='o' && $arryQuote[0]['OpportunityID']>0){
	$arryQuote[0]['CustomerName'] = $arryQuote[0]['opportunityName'];
	
	$arryOppName = explode(" ",$arryQuote[0]['opportunityName']);
	
	$arryOpportunity = $objLead->GetOpportunity($arryQuote[0]['OpportunityID'],'');			

	if($arryOpportunity[0]['LeadID']>0){			
		$arryLead = $objLead->GetLead($arryOpportunity[0]['LeadID'],'');
	}

	unset($arryOpp);
	$arryOpp['FirstName'] = $arryOppName[0];
	$arryOpp['LastName'] = $arryOppName[1];
	$arryOpp['Email'] = $arryLead[0]['primary_email'];
	$arryOpp['Company'] = $arryOpportunity[0]['OrgName'];
	$arryOpp['Mobile'] = $arryLead[0]['Mobile'];
	$arryOpp['Landline'] = $arryLead[0]['LandlineNumber'];
	$arryOpp['CustomerType'] = 'Company';

	$sqlCustCheck = "select Cid from s_customers where FullName='".stripslashes($arryQuote[0]['opportunityName'])."'  and CustomerType='Company' ";
	if(!empty($arryLead[0]['primary_email'])) $sqlCustCheck .= " and Email='".$arryLead[0]['primary_email']."'";
	$arryCustCheck = $this->query($sqlCustCheck, 1);

	if(empty($arryCustCheck[0]['Cid'])){
		//echo '<pre>';print_r($arryLead);exit;

		$arryOppShipping['FirstName'] = $arryOpp['FirstName'];
		$arryOppShipping['LastName'] = $arryOpp['LastName'];
		$arryOppShipping['Company'] = $arryOpp['Company'];
		$arryOppShipping['Mobile'] = $arryLead[0]['Mobile'];
		$arryOppShipping['Landline'] = $arryLead[0]['LandlineNumber'];
		$arryOppShipping['Address'] = $arryQuoteAddress[0]['ship_street']; 
		$arryOppShipping['City'] = $arryQuoteAddress[0]['ship_city']; 
		$arryOppShipping['State'] = $arryQuoteAddress[0]['ship_state']; 
		$arryOppShipping['ZipCode'] = $arryQuoteAddress[0]['ship_code']; 
		$arryOppShipping['Country'] = $arryQuoteAddress[0]['ship_country']; 

		$arryOppBilling['FirstName'] = $arryOpp['FirstName'];
		$arryOppBilling['LastName'] = $arryOpp['LastName'];
		$arryOppBilling['Company'] = $arryOpp['Company'];
		$arryOppBilling['Mobile'] = $arryLead[0]['Mobile'];
		$arryOppBilling['Landline'] = $arryLead[0]['LandlineNumber'];
		$arryOppBilling['Address'] = $arryQuoteAddress[0]['bill_street']; 
		$arryOppBilling['City'] = $arryQuoteAddress[0]['bill_city']; 
		$arryOppBilling['State'] = $arryQuoteAddress[0]['bill_state']; 
		$arryOppBilling['ZipCode'] = $arryQuoteAddress[0]['bill_code']; 
		$arryOppBilling['Country'] = $arryQuoteAddress[0]['bill_country']; 


		$OppCustID =  $objCustomer->addCustomer($arryOpp);
		
		$billingID = $objCustomer->addCustomerAddress($arryOppBilling,$OppCustID,'billing');
		$shippingID = $objCustomer->addCustomerAddress($arryOppShipping,$OppCustID,'shipping');
		//echo $OppCustID;exit;
		$arryQuote[0]['CustID'] = $OppCustID;
	
		
	}else{
		$arryQuote[0]['CustID'] = $arryCustCheck[0]['Cid'];	
	}


	if($arryQuote[0]['OpportunityID']>0){
		$objLead->RemoveOpportunity($arryQuote[0]['OpportunityID']); //delete opp

		$sql = "update c_comments set parentID='" . $OppCustID . "',parent_type='Customer' where parentID='" . $arryQuote[0]['OpportunityID']. "' and parent_type='Opportunity'";
           	$this->query($sql, 0);
	}


}
				
				
		

			     if(!empty($arryQuote[0]['CustID'])){	
					unset($arryCust);
							
					$arryCust = $objCustomer->GetCustomer($arryQuote[0]['CustID'],'','');	
					$arryQuote[0]['CustCode'] = $arryCust[0]['CustCode'];
					$arryQuote[0]['Mobile'] = $arryCust[0]['Mobile']; 
					$arryQuote[0]['Landline'] = $arryCust[0]['Landline']; 
					$arryQuote[0]['Fax'] = $arryCust[0]['Fax']; 
					$arryQuote[0]['Email'] = $arryCust[0]['Email']; 
					$arryQuote[0]['CustomerCompany'] = $arryCust[0]['Company']; 

					$arryQuote[0]['ShippingMobile'] = $arryCust[0]['Mobile']; 
					$arryQuote[0]['ShippingLandline'] = $arryCust[0]['Landline']; 
					$arryQuote[0]['ShippingFax'] = $arryCust[0]['Fax']; 
					$arryQuote[0]['ShippingEmail'] = $arryCust[0]['Email']; 
					$arryQuote[0]['ShippingCompany'] = $arryCust[0]['Company']; 
				
				}
				$arryQuote[0]['ShippingName'] = $arryQuote[0]['CustomerName'];
				////////////////////// 
				$arryQuote[0]['ShippingAddress'] = $arryQuoteAddress[0]['ship_street']; 
				$arryQuote[0]['ShippingCity'] = $arryQuoteAddress[0]['ship_city']; 
				$arryQuote[0]['ShippingState'] = $arryQuoteAddress[0]['ship_state']; 
				$arryQuote[0]['ShippingZipCode'] = $arryQuoteAddress[0]['ship_code']; 
				$arryQuote[0]['ShippingCountry'] = $arryQuoteAddress[0]['ship_country']; 
				$arryQuote[0]['Address'] = $arryQuoteAddress[0]['bill_street']; 
				$arryQuote[0]['City'] = $arryQuoteAddress[0]['bill_city']; 
				$arryQuote[0]['State'] = $arryQuoteAddress[0]['bill_state']; 
				$arryQuote[0]['ZipCode'] = $arryQuoteAddress[0]['bill_code']; 
				$arryQuote[0]['Country'] = $arryQuoteAddress[0]['bill_country']; 
				
				//echo '<pre>';print_r($arryQuote); exit;
				$order_id = $objSale->AddSale($arryQuote[0]);
				
				/********  Add Item ********/
				$arryQuoteItem = $this->GetQuoteItem($quoteid);
				//echo '<pre>';print_r($arryQuoteItem);exit;
				$arrySOItem['NumLine'] = sizeof($arryQuoteItem);
				$Line=0;
				for($i=0;$i<sizeof($arryQuoteItem);$i++){
					$Line++;
					$arryQuoteItem[$i]['item_taxable'] =  $arryQuoteItem[$i]['Taxable'];		
					$arryQuoteItem[$i]['tax'] =  $arryQuoteItem[$i]['tax_id'].':'.$arryQuoteItem[$i]['tax'];					
					foreach($arryQuoteItem[$i] as $key=>$value){
						$arrySOItem[$key.$Line] = $value;
					}
 				      unset($arrySOItem['id'.$Line]);		
				      $arrySOItem['OrderID'.$Line] = $order_id;				
				}
				//echo '<pre>';print_r($arrySOItem);exit;
				$objSale->AddUpdateItem($order_id, $arrySOItem); 

				/********  Delete Quote from CRM ********/
				
				$this->RemoveQuote($quoteid);
			}
		}	

		return true;
	}



function CustomQuote($selectCol,$condition){
		global $Config;
		$strSQLQuery = "select * from c_quotes where 1  ".$condition."  ";

		#$strSQLQuery .= ($Config['vAllRecord']!=1)?(" and (assignTo like '%".$_SESSION['AdminID']."%' OR AdminID='".$_SESSION['AdminID']."') "):("");

		$strSQLQuery .= ($Config['vAllRecord']!=1)?(" and (FIND_IN_SET(".$_SESSION['AdminID'].",assignTo) OR AdminID='".$_SESSION['AdminID']."') "):("");

		$strSQLQuery .= ' order by quoteid desc ';

		//echo $strSQLQuery;

		return $this->query($strSQLQuery, 1);

	}
        
       /****************Recurring Function Satrt************************************/  
       function RecurringQuote($Module){       
          global $Config;
	  $Config['CronEntry']=1;
          $arryDate = explode(" ", $Config['TodayDate']);
   	  $arryDay = explode("-", $arryDate[0]);

	  $Month = (int)$arryDay[1];
	  $Day = $arryDay[2];	
	
	  $Din = date("l",strtotime($arryDate[0]));

	  $strSQLQuery = "select q.*,a.* from c_quotes as q left outer join c_quotesbillads as a on q.quoteid = a.quoteid where  q.quotestage != 'Rejected' and q.EntryType ='recurring' and q.EntryFrom<='".$arryDate[0]."' and q.EntryTo>='".$arryDate[0]."' ";
          $arryQuote = $this->myquery($strSQLQuery, 1);
          
         //echo "<pre>";
          //print_r($arryQuote);
          //exit;
	
	  foreach($arryQuote as $value){
		$OrderFlag=0;
               
		switch($value['EntryInterval']){
			case 'biweekly':
				$NumDay = 0;
				if($value['LastRecurringEntry']>0){
					$NumDay = (strtotime($arryDate[0]) - strtotime($value['LastRecurringEntry']))/(24*3600);	
				}			
				
				if($value['EntryWeekly']==$Din && ($NumDay==0 || $NumDay>10)){
					$OrderFlag=1;
				}
				break;
			case 'semi_monthly':
				if($Day=="01" || $Day=="15"){
					$OrderFlag=1;
				}
				break;
			case 'monthly':
				if($value['EntryDate']==$Day){
					$OrderFlag=1;
				}
				break;
			case 'yearly':
				if($value['EntryDate']==$Day && $value['EntryMonth']==$Month){
					$OrderFlag=1;
				}
				break;		
		
		}
		

		if($OrderFlag==1){
			//echo $value['quoteid'].'<br>';
	
			$NumLine = 0;
			$arryQuoteItem = $this->GetQuoteItem($value['quoteid']);
			$NumLine = sizeof($arryQuoteItem);	
			if($NumLine>0){		
                            
                           
				$order_id = $this->addQuote($value);
				$this->AddRecurringQuoteItem($order_id,$arryQuoteItem);
				
				$strSQL = "update c_quotes set LastRecurringEntry ='" . $Config['TodayDate'] . "' where quoteid='" . $value['quoteid'] . "'";
				$this->myquery($strSQL, 0);
		
			}


		}


	  }
       	  return true;
   }
   
   
    function AddRecurringQuoteItem($order_id, $arryDetails)
		{  
		        global $Config;
                       
			extract($arryDetails);
                        
		        $discountAmnt = 0;$taxAmnt=0;
                   
                        foreach($arryDetails as $values){

                            if(!empty($values['sku'])) {			          


                                    $sql = "insert into c_quote_item(OrderID, item_id, sku, description, on_hand_qty, qty, price, tax_id, tax, amount, discount, Taxable, req_item) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".addslashes($values['sku'])."', '".addslashes($values['description'])."', '".addslashes($values['on_hand_qty'])."', '".addslashes($values['qty'])."', '".addslashes($values['price'])."', '".$values['tax_id']."', '".$values['tax']."', '".addslashes($values['amount'])."','".addslashes($values['discount'])."','".addslashes($values['Taxable'])."' ,'".addslashes($values['req_item'])."')";

                                    $this->query($sql, 0);	

                            }
                        }


		}


}
?>
