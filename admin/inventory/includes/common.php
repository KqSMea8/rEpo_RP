<?php 
(empty($_GET['type']))?($_GET['type']=""):("");   
(empty($_GET['MemberID']))?($_GET['MemberID']=""):("");  
(empty($_GET['CatID']))?($_GET['CatID']=""):(""); 
(empty($_GET['CustID']))?($_GET['CustID']=""):(""); 
(empty($_GET['attID']))?($_GET['attID']=""):(""); 
(empty($_GET['id']))?($_GET['id']=""):("");     
(empty($_GET['finish']))?($_GET['finish']=""):("");     
(empty($_GET['ParentID']))?($_GET['ParentID']=""):(""); 
(empty($_GET['w'])) ? ($_GET['w']='') : (""); 
(empty($_GET['w1'])) ? ($_GET['w1']='') : (""); 
(empty($_GET['w2'])) ? ($_GET['w2']='') : (""); 
(empty($_GET['ast'])) ? ($_GET['ast']='') : (""); 
(empty($_GET['bc'])) ? ($_GET['bc']='') : (""); 
(empty($_GET['st'])) ? ($_GET['st']='') : (""); 
(empty($_GET['c'])) ? ($_GET['c']='') : (""); 
(empty($_GET['UsedSerial'])) ? ($_GET['UsedSerial']='') : ("");
(empty($_GET['MoveID'])) ? ($_GET['MoveID']='') : ("");
(empty($_GET['featured_id'])) ? ($_GET['featured_id']='') : (""); 
(empty($_GET['Condition'])) ? ($_GET['Condition']='') : ("");
(empty($_GET['Status'])) ? ($_GET['Status']='') : ("");
(empty($_GET['bomID'])) ? ($_GET['bomID']='') : ("");
(empty($_GET['optionID'])) ? ($_GET['optionID']='') : ("");
(empty($_GET['option_del_id'])) ? ($_GET['option_del_id']='') : ("");
(empty($_GET['AllStock'])) ? ($_GET['AllStock']='') : ("");
(empty($_GET['WID'])) ? ($_GET['WID']='') : ("");
(empty($_GET['menu'])) ? ($_GET['menu']='') : ("");
(empty($_GET['sku'])) ? ($_GET['sku']='') : ("");
(empty($_GET['SerialValue'])) ? ($_GET['SerialValue']='') : ("");
(empty($_GET['link'])) ? ($_GET['link']='') : ("");
(empty($_GET['keyword'])) ? ($_GET['keyword']='') : ("");
(empty($_GET['parent_type'])) ? ($_GET['parent_type']='') : ("");
(empty($_GET['condition'])) ? ($_GET['condition']='') : ("");
(empty($_GET['serial'])) ? ($_GET['serial']='') : ("");

(empty($_GET['UsedSerialCheck'])) ? ($_GET['UsedSerialCheck']='') : (""); 
(empty($_GET['sortby'])) ? ($_GET['sortby']='') : (""); 
(empty($_GET['UsedSerial'])) ? ($_GET['UsedSerial']='') : (""); 
(empty($_GET['Condition'])) ? ($_GET['Condition']='') : (""); 
(empty($_GET['key'])) ? ($_GET['key']='') : (""); 
(empty($_GET['FromDate'])) ? ($_GET['FromDate']='') : (""); 
(empty($_GET['ToDate'])) ? ($_GET['ToDate']='') : (""); 
(empty($_GET['asc'])) ? ($_GET['asc']='') : (""); 



(empty($bgcolor))?($bgcolor=""):("");        
(empty($bgcolor2))?($bgcolor2=""):(""); 
(empty($selectCond)) ? ($selectCond='') : (""); 
(empty($attribute_value)) ? ($attribute_value='') : (""); 
(empty($ParentCategory)) ? ($ParentCategory='') : (""); 
(empty($disabled)) ? ($disabled='') : (""); 
(empty($MainParentCategory)) ? ($MainParentCategory='') : (""); 
(empty($NumLanguages))?($NumLanguages=""):("");  
(empty($NumHeader))?($NumHeader=""):("");  
(empty($ParentID))?($ParentID=""):("");  
(empty($MainModuleName))?($MainModuleName=""):("");  
(empty($ModuleName))?($ModuleName=""):("");  
(empty($disNone))?($disNone=""):("");  
(empty($PrefixPO))?($PrefixPO=""):("");  
(empty($flag))?($flag=""):("");  
(empty($OldImage))?($OldImage=""):("");  
 

/*
(empty($Config['ItemID'])) ? ($Config['ItemID']='') : ("");   

(empty($class)) ? ($class='') : (""); 

(empty($arryCategory)) ? ($arryCategory='') : (""); 
(empty($Config['ItemCategory'])) ? ($Config['ItemCategory']='') : ("");
*/  




  # echo $MainModuleID;

if($EditPage==1 && empty($_GET['edit'])){    
	switch($MainModuleID) {	
		case '628': 
			if(empty($arryProduct)){
				$arryProduct = $objConfigure->GetDefaultArrayValue('inv_items');
			}                      
			break;
			
		case '634':     
			$arryCategory = $objConfigure->GetDefaultArrayValue('inv_categories');
			 
			break;
		
		case '638':    
			$arryAdjustment = $objConfigure->GetDefaultArrayValue('inv_adjustment');
			$arryAdjustmentItem = $objConfigure->GetDefaultArrayValue('inv_stock_adjustment');
			 
			break;
			
		case '640':     
			$arryTransfer = $objConfigure->GetDefaultArrayValue('inv_transfer');
			$arryTransferItem = $objConfigure->GetDefaultArrayValue('inv_stock_transfer');
			 
			break;


		case '641':
			if(empty($arryBOM)){    
				$arryBOM = $objConfigure->GetDefaultArrayValue('inv_bill_of_material');
			}
			
		
			break;
		
		case '648':    
				$arryModel = $objConfigure->GetDefaultArrayValue('inv_ModelGen');
			
			break;

		case '652':    
				$arryCondition = $objConfigure->GetDefaultArrayValue('inv_condition');
			
			break;

		case '656':    
				$arraydetails = $objConfigure->GetDefaultArrayValue('inv_writedown');
			
			break;

		 
 

	 	
		
		
				 	
	}
	 
}

?>
