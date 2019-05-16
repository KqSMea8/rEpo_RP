<?php
class customreports extends dbClass {

   public $quoteFiledArr = array('bill_city','bill_code','bill_country','bill_state','bill_street','bill_pobox','ship_city',
                                'ship_code','ship_country','ship_state','ship_street','ship_pobox');
    
   public $customerFiledArr = array('Address','city_id','state_id','ZipCode','country_id','Mobile','Landline');
    //constructor
    function customreports() {
        $this->dbClass();
    }
    
    function saveReportData($post)
    {  //echo "<pre/>";print_r($post); //die;
         $groupby = $post['groupby'];
         $sortby  = $post['sortcol'].' '.$post['order'];
        
        if($post['fcol'])
        {
        	if(strstr($post['fcol'], ','))
        	{
        		$fcol = explode(',' , $post['fcol']);
        	}else{
        		$fcol = array($post['fcol']);
        	}
        	
        	if(strstr($post['fop'],','))
        	{
        		$fop = explode(',' , $post['fop']);
        	}else{
        		$fop = array($post['fop']);
        	}
        	
        	if(strstr($post['fval'],','))
        	{
        		$fval = explode(',' , $post['fval']);
        	}else{
        		$fval = array($post['fval']);
        	}
        
       
            //echo "<pre/>";print_r($fcol); print_r($fop); print_r($fval);die('rajan data');
            if(!empty($fcol))
            {
                $i=0;
                $filters ='';
                foreach($fcol as $col)
                {
                    $filters .= $col.','.$fop[$i].','.$fval[$i].'#';
                    $i++;
                }
                $filters=  rtrim($filters,'#');
            }
        
        }
        
        if($post['report_ID']=='')
        {
            $strquery = 'insert into c_customreport set 
                         report_name    =   "'.$post['report_name'].'",
                         report_desc    =   "'.$post['report_desc'].'",
                         moduleID       =   "'.$post['moduleID'].'",
                         columns        =   "'.$post['selectclms'].'" ,
                         groupby        =   "'.$groupby.'",
                         sortby         =   "'.$sortby.'",
                         filters        =   "'.$filters.'",
                         status         = 	1 ';

            $this->query($strquery,0);
            $reportID = $this->lastInsertId();

            /*$query = 'insert into admin_modules set Module = "'.$post['report_name'].'", Link= "vcreport.php?view='.$reportID.'&menu=1&curP=1", Parent= 116, Status = 1';
            $this->query($query,0);
            $adminmoduleId = $this->lastInsertId();
          
            $strquery2 = "update c_customreport set 
                         AdminModuleID = '".$adminmoduleId."' where report_ID =  '".$reportID."' ";
            $this->query($strquery2,0);*/
            
            
        }else{
            
            $strquery = 'update c_customreport set 
                         report_name    =   "'.$post['report_name'].'",
                         report_desc    =   "'.$post['report_desc'].'",
                         moduleID       =   "'.$post['moduleID'].'",
                         columns        =   "'.$post['selectclms'].'" ,
                         groupby        =   "'.$groupby.'",
                         sortby         =   "'.$sortby.'",
                         filters        =   "'.$filters.'",
                         status         = 	1 where report_ID =  "'.$post['report_ID'].'" ';
            $this->query($strquery,0);
            
           /* $details = $this->GetReportLists($post['report_ID']);
            $strquery2 = 'update admin_modules set 
                   Module = "'.$post['report_name'].'" where ModuleID =  "'.$details[0]['AdminModuleID'].'" ';
            $this->query($strquery2,0);*/
            
        }
       
    }
    
    function generateReportData($post)
    {     
    	if(empty($post)){ return array(); }
        $this->join  = '';
        $field = new field();
        $where = " 1 ";
		$groupby = '';
		$orderby = '';
        global $objregion; 
        if($post['selectclms'])
        {
            $cols ='';
			$colname = '';
            $colLabel = array();
            $Slctcolms = explode(',',$post['selectclms']);
            foreach($Slctcolms as $FID)
            {   
                $colLabel[] =   $this->GetCrFieldName($FID, 'fieldlabel');
                $colm       =   $this->GetCrFieldName($FID, 'fieldname');
                
                $colm       =   $this->getcolumnbytable($colm,$post['moduleID']);
								$colname   .=	$colm.','; 
				$fieldType[] =  $this->GetCrFieldName($FID, 'type');    
                $cols      .=   $this->checkforalias($colm,$post['moduleID']);
                if($colm == 'AssignedTo' || $colm == 'AssignTo' && $post['moduleID'] != 107)
                {
                    $cols   .=   't1.AssignType,t1.GroupID,';
                }
            } 
            $cols = rtrim($cols,','); 
            if($post['moduleID']== 108)
            $this->join =   $this->checkForQuoteJoin($cols,$post['moduleID']);
             else if ($post['moduleID']== 2015)
            $this->join =   $this->checkForCustomerJoin($cols,$post['moduleID']);
            
        }
       
        if($post['moduleID'])
        {
            $table = $field->getTable($post['moduleID']);
            if($post['moduleID'] == 102)
            {
                $where .= ' and opportunity = 0 and Junk="0" ';
            }
            
            if($post['moduleID'] == 107)
            {
                $where .= ' and t1.CrmContact=1 and t1.AddType="contact" ';
            }
        }
        
        
         if($post['groupby'])
        {
            $groupby =  $this->GetCrFieldName($post['groupby'],'fieldname');	       
            $groupby = $this->getcolumnbytable($groupby,$post['moduleID']);
            $groupby = ' GROUP BY t1.'.$groupby.'';
                      
        }
        
    	if($post['sortcol'])
    	{
            $orderby = $this->GetCrFieldName($post['sortcol'],'fieldname');
            $orderby = $this->getcolumnbytable($orderby,$post['moduleID']);
    		$orderby = 'ORDER BY t1.'.$orderby.''; 
        }
        
        if(isset($post['fcol']))
        {
            $i     = 0;
                        
            foreach($post['fcol'] as $fcol)
            {
                if($fcol !='')
                {
                    $filterCol =  $this->GetCrFieldName($fcol,'fieldname');
                    
                    if((in_array($filterCol, $this->quoteFiledArr)  && $post['moduleID']== 108) || (in_array($filterCol, $this->customerFiledArr) && $post['moduleID']== 2015))
                    {
                        if($this->join == ''){  $this->join  .= $this->getJoinTable('Quote');$this->join  .= $this->getJoinTable('customer'); }
                        $filterCol = 't2.'.$filterCol;
                    }else{
                    	$filterCol = 't1.'.$filterCol;
                    }
                    
                    
                    if($filterCol == 't1.assign' || $filterCol == 't1.assignedTo' || $filterCol == 't1.product' || $filterCol == 't1.CustID' )
                    {
                        if($this->join ==""){ $alias = 't2'; }else{ $alias = 't3'; }  
                    	$this->join  .= $this->getJoinTable($filterCol,$post['moduleID']);
                    	if($filterCol == 't1.CustID'){ $filterCol = $alias.'.FullName'; }
                        if($filterCol == 't1.assign' || $filterCol == 't1.assignedTo'){ $filterCol = $alias.'.UserName'; }
                    }
             	

		  if($filterCol == 't1.AnnualRevenue' || $filterCol == 't1.Amount' || $filterCol == 't1.forecast_amount')
                {    
                $EncryptKey = $GLOBALS['useMainDB']['EncryptKey']; 
                $filterCol = 'DECODE('.$filterCol.',"'. $EncryptKey.'")';
                }





				      $filterColtype =  $this->GetCrFieldName($fcol,'type'); 
			          if($filterColtype == 'date')
			          {
			      			$filterCol = "date(".$filterCol.")";
			         	}  

                    if($post['fop'][$i]!='')
                    {
                        $operator = $this->getcomparator($post['fop'][$i]);
	                        
                             if($filterCol == 't1.Status')
                              {
                                if($post['fval'][$i] == 'Active'){
                                    $FinalVal = ($post['moduleID'] == '2015') ? "'Yes'" : '1';
                                }elseif($post['fval'][$i] == 'Inactive')
                                {
                                    $FinalVal = ($post['moduleID'] == '2015') ? "'No'" : '0';
                                }else{
                                    $FinalVal = "'".$post['fval'][$i]."'";
                                }
                                
                            }elseif($filterCol == 't1.country_id' || $filterCol == 't2.country_id' ){  
                           
	                            /********Connecting to main database*********/
	                            $objConfig=new admin();	
								$Config['DbName'] = $GLOBALS['useMainDB']['DbMain'];
								$objConfig->dbName = $Config['DbName'];
								$objConfig->connect();
	                            
								
	                            if( $operator == 'IN')
		                        {
		                            $arrVal = explode(".", $post['fval'][$i]); 
		                            $countryVal = '';
		                            foreach ($arrVal as $tempVal) {
		                            	if(!empty($tempVal))
		                            	{
		                            		$country =  $objregion->GetCountryID(trim($tempVal)); 
		                            		$Val =	(empty($country)) ? "''" : $country[0]['country_id'];
		                              		$countryVal .= '"' . $Val . '",';
		                            	} 
		                            }
		                             $FinalVal = '('.rtrim($countryVal, ',').')';
		                        }else{
	                               $country =  $objregion->GetCountryID($post['fval'][$i]); 
	                               $FinalVal =	(empty($country)) ? "''" : $country[0]['country_id'];
		                        }   
	                               /********Connecting to Company database*********/
	                               $Config['DbName'] = $_SESSION['CmpDatabase'];
								$objConfig->dbName = $Config['DbName'];
								$objConfig->connect();   
                                //$fieldType[] =  $field->GetCustomfieldByFieldId($FID, 'type');  

								}elseif($filterCol == 't1.state_id' || $filterCol == 't2.state_id' ){  
                           
		                            /********Connecting to main database*********/
		                            $objConfig=new admin();	
									$Config['DbName'] = $GLOBALS['useMainDB']['DbMain'];
									$objConfig->dbName = $Config['DbName'];
									$objConfig->connect();
	                            
								
	                            if( $operator == 'IN')
		                        {
		                            $arrVal = explode(".", $post['fval'][$i]); 
		                            $stateVal = '';
		                            foreach ($arrVal as $tempVal) {
		                            	if(!empty($tempVal))
		                            	{
		                            		$state =  $objregion->GetStatebyID(trim($tempVal)); 
		                            		$Val =	(empty($state)) ? "''" : $state[0]['state_id'];
		                              		$stateVal .= '"' . $Val . '",';
		                            	} 
		                            }
		                             $FinalVal = '('.rtrim($stateVal, ',').')';
		                        }else{
	                               $state =  $objregion->GetStatebyID($post['fval'][$i]); 
	                               $FinalVal =	(empty($state)) ? "''" : $state[0]['state_id'];
		                        }   
	                               /********Connecting to Company database*********/
	                               $Config['DbName'] = $_SESSION['CmpDatabase'];
								$objConfig->dbName = $Config['DbName'];
								$objConfig->connect();   
                                //$fieldType[] =  $field->GetCustomfieldByFieldId($FID, 'type');  
								
								
								 }elseif($filterCol == 't1.city_id' || $filterCol == 't2.city_id' ){  
                           
	                            /********Connecting to main database*********/
		                            $objConfig=new admin();	
									$Config['DbName'] = $GLOBALS['useMainDB']['DbMain'];
									$objConfig->dbName = $Config['DbName'];
									$objConfig->connect();
		                            
								
	                            if( $operator == 'IN')
		                        {
		                            $arrVal = explode(".", $post['fval'][$i]); 
		                            $cityVal = '';
		                            foreach ($arrVal as $tempVal) {
		                            	if(!empty($tempVal))
		                            	{
		                            		$city =  $objregion->GetCitybyID(trim($tempVal)); 
		                            		$Val =	(empty($city)) ? "''" : $city[0]['city_id'];
		                              		$cityVal .= '"' . $Val . '",';
		                            	} 
		                            }
		                             $FinalVal = '('.rtrim($cityVal, ',').')'; 
		                        }else{
	                               $city =  $objregion->GetCitybyID($post['fval'][$i]); 
	                               $FinalVal =	(empty($city)) ? "''" : $city[0]['city_id']; 
		                        }   
	                               /********Connecting to Company database*********/
	                               $Config['DbName'] = $_SESSION['CmpDatabase'];
								$objConfig->dbName = $Config['DbName'];
								$objConfig->connect();   
                                //$fieldType[] =  $field->GetCustomfieldByFieldId($FID, 'type');  
                                
								
								
                            }else{
                                
                            	if( $operator == 'IN')
		                        {
		                            $arrVal = explode(".", $post['fval'][$i]);
		                            $FinalVal = '';
		                            foreach ($arrVal as $tempVal) {
		                                $FinalVal .= '"' . trim($tempVal) . '",';
		                            }
		                             $FinalVal = '('.rtrim($FinalVal, ',').')';
		                        }else{
                            	
                            		$FinalVal = '"'.addslashes($post['fval'][$i]).'"';
		                        }	
                            }    
                         
                                      
                        $where .= " and ".$filterCol." ".$operator." ".$FinalVal." ";
                    }

                    $i++;
                
                }    
            }    
        }
        
 //       echo "<br/>";print_r($cols);
//        echo "<br/>";print_r($groupby);
//        echo "<br/>";print_r($orderby);
//        echo "<br/>";print_r($where); die('jhgfsdh');
//        print_r($table);
//        print_r($join);
         
              
        
        $query = " select $cols from $table t1 $this->join where $where $groupby $orderby   "; //print_r($query);die;
        $res   = $this->query($query); //print_r($res);die;
        $retArray = array();
        $retArray['colLabel'] = $colLabel;
        $retArray['res'] = $res; 
        $colname = explode(',',$colname);
        /*$retArray['colName'] = array_map(function($arr){
                                    if($arr == 't1.GroupID' || $arr == 't1.AssignType')  {      
                                        unset($arr);
                                    }else{
                                    	 $find = array("t1.","t2.");
                                        return str_replace($find,'',$arr);
                                    }
                                },$exp_arr);*/
                                
        $retArray['colName'] =  $colname;                        
        $retArray['colName'] = array_values(array_filter($retArray['colName']));
		$retArray['type'] = $fieldType;
        $retArray['post'] = $post;
        
         
        
        return $retArray; 
        
    }
    
    
    function getcomparator($compit) 
    {
        if($compit=='e'){
                return ('=');
        }else if($compit == 'n'){
               return ('!=');
        }else if($compit == 'l'){
               return ('<');
        }else if($compit == 'g'){
               return ('>');
        }else if($compit == 'in'){
               return ('IN');
        }

    } 

    function getJoinTable($filterCol,$module='')
    { 
            
        if($this->join ==""){ $alias = 't2'; }else{ $alias = 't3'; }    
        if($filterCol == 't1.assign' || $filterCol == 't1.assignedTo')
        {
            $fld = ($filterCol == 't1.assignedTo') ? $filterCol : ($module == 104 || $module == 136) ? 'AssignedTo' : 'AssignTo';
            $joinQuery = ' left join h_employee '.$alias.' on t1.'.$fld.' = '.$alias.'.EmpID ';
        }elseif($filterCol == 't1.product')
        {
            $joinQuery = ' left join inv_items '.$alias.' on t1.product = '.$alias.'.ItemID ';
        }elseif($filterCol == 't1.CustID' )
        {
            $joinQuery = ' left join s_customers '.$alias.' on t1.CustID = '.$alias.'.Cid ';
        }elseif($filterCol == 'Quote'){
            
            $joinQuery = ' left join c_quotesbillads '.$alias.' on t1.quoteid = '.$alias.'.quoteid ';
        }elseif($filterCol == 'customer'){
        	
        	$joinQuery = ' left join s_address_book '.$alias.' on t1.Cid = '.$alias.'.CustID ';
        }
        return $joinQuery;
    }
    
    function GetReportLists($ID = ''){
        if($ID)
        {   
            $where = " where report_ID=".$ID;
         
        }else{
            $where ='';
        }
        
    	$query = "SELECT * FROM c_customreport ".$where;
    	return $this->query($query);
    	
    }
    
    function getcolumnbytable($name,$module)
    {
        if($name == 'assign')
        {   
            //$this->join  = $this->getJoinTable('t1.'.$name,$module);
            if($module == 104 || $module == 136){
                return 'AssignedTo';
            }else{
            return 'AssignTo';}
            
        }else{
            
            return $name;
        }
    }
    
    function checkForQuoteJoin($cols,$module)
    {
        if($module == 108)
        {
            $exp_arr = explode(',',$cols); 
            $colName = array_map(function($arr){
                                        $find = array("t1.","t2.");
                                        return str_replace($find,'',$arr);
                                    },$exp_arr);
                                
           
            $result=array_diff($this->quoteFiledArr,$colName); 
            if(count($result) != count($this->quoteFiledArr))
            {
                 $joinQuery  = $this->getJoinTable('Quote');
            }else{
				$joinQuery = '';
			}
           // print_r($joinQuery);die('sjsa');
            return $joinQuery;
            
        } 
         
    }
    
    function checkforalias($colm,$moduleID)
    {  
    	
      if((in_array($colm, $this->quoteFiledArr)  && $moduleID == 108) || (in_array($colm, $this->customerFiledArr) && $moduleID == 2015))
       {  
            return 't2.'.$colm.',';
       		
        }else{
           
        	if(($moduleID == 103 && ( $colm == 'Amount' || $colm == 'forecast_amount' )) || ($moduleID == 102 && ( $colm == 'AnnualRevenue')) )
        	{
        	 	$EncryptKey = $GLOBALS['useMainDB']['EncryptKey'];
        	 	return 'DECODE(t1.'.$colm.',"'. $EncryptKey.'") as '.$colm.',';
        	
        	}else{ 
        		return 't1.'.$colm.',';
        	}
        }
    }

   /* function deleteReportList($delete_id){
    	
        $details = $this->GetReportLists($delete_id);
        $query2 = "DELETE FROM admin_modules Where ModuleID = '".$details[0]['AdminModuleID']."'"; 
    	$this->query($query2);
        $query = "DELETE FROM c_customreport Where report_ID=$delete_id";
        $this->query($query);
    }*/

 function deleteReportList($delete_id){
    	//updated by chetan 26Sept. 2016//
        /*$details = $this->GetReportLists($delete_id);
        $query2 = "DELETE FROM admin_modules Where ModuleID = '".$details[0]['AdminModuleID']."'"; 
    	$this->query($query2);*/
        $query = "DELETE FROM c_customreport Where report_ID=$delete_id";
        $this->query($query);
    }
   
    function setFormat($fetchRes)
    {
       
        $colms = $fetchRes['columns'];
	unset($fetchRes['columns']);
	$fetchRes = array_merge($fetchRes,array('selectclms' => $colms));

	$fop = array();
	$fval= array();
	$fcol = array();
	
	$sortby = '';
        
        if($fetchRes['filters']!="")
	{
		if(strstr($fetchRes['filters'],'#'))
		{
			$arr = explode("#",$fetchRes['filters']);
			if(count($arr))
			{
				foreach($arr as $Arr)
				{
					$resArr = explode(",",$Arr);
					array_push($fcol,$resArr[0]);
					array_push($fop,$resArr[1]);
					array_push($fval,$resArr[2]);
				}
			}
		}else{
		
					$resArr = explode(",",$fetchRes['filters']);
					array_push($fcol,$resArr[0]);
					array_push($fop,$resArr[1]);
					array_push($fval,$resArr[2]);
			}
			
			unset($fetchRes['filters']);
			$change = 1;
			$fetchRes = array_merge($fetchRes,array('fop' => $fop),array('fcol' => $fcol),array('fval' => $fval));
			//print_r($fetchRes);
	}
	
	if($fetchRes['sortby']!="")
	{
		if(strstr($fetchRes['sortby'],' '))
		{
			$arr = explode(" ",$fetchRes['sortby']);
			
			$sortcol = $arr[0];
			$order = $arr[1];
			unset($fetchRes['sortby']);
			$fetchRes = array_merge($fetchRes,array('sortcol' => $sortcol),array('order' => $order));
			//print_r($fetchRes); die('rararara');
		}
	}
        
        return $fetchRes;
    }
    
    function isc_reportNameExists($name, $reportID = 0) 
    {
        $strSQLQuery = (!empty($reportID)) ? (" and report_ID != " . $reportID) : ("");
        $strSQLQuery = 'select report_ID from c_customreport where LCASE(report_name)="' . strtolower(trim($name)) . '" '. $strSQLQuery;
        $arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['report_ID'])) {
		    return true;
		} else {
		    return false;
		}
    }
    
    function GetCrFieldName($FID,$for)
    {
    	if($FID == 'c_1' || $FID == "s_1")
    	{	
    		if($for == 'type'){ return 'text'; }else{
    		if($FID == 'c_1'){	
    			if($for =='fieldlabel')
    			 return 'City';
    			 else 
    			return 'city_id'; 
    		
    		}else{ 
    			if($for =='fieldlabel')
    			 return 'State';
    			 else 
    			return 'state_id';}}
    			
    	}else{
    	 	$field = new field();
    		return $field->GetCustomfieldByFieldId($FID, $for);	
    	}
    }
    
    function checkForCustomerJoin($cols,$module){
    	        if($module == 2015)
        {
            $exp_arr = explode(',',$cols); 
            $colName = array_map(function($arr){
                                        $find = array("t1.","t2.");
                                        return str_replace($find,'',$arr);
                                    },$exp_arr);
                                
           
            $re=array_diff($this->customerFiledArr,$colName);
            if(count($re) != count($this->customerFiledArr))
            {
                 $joinQuery  = $this->getJoinTable('customer');
            }else{
				$joinQuery = '';
			}
             // print_r($joinQuery);die('sjsa'); 
            return $joinQuery;
            
        } 
    	
    }
    
}    
