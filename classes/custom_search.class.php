<?php
class customsearch extends dbClass {
	//updated by chetan for model on 14july//	
    public  $ItemArr= array(
            array('fieldlabel' => 'Track Inventory','fieldname'=>  'non_inventory','type'=>'select'),
            array('fieldlabel' => 'SKU' ,'fieldname'=>  'Sku' ,'type'=>'text'),                   
            array('fieldlabel' => 'Item Description','fieldname'=>  'description','type'=>'text'),    
            array('fieldlabel' => 'Category /SubCategory','fieldname'=>  'CategoryID','type'=>'select'),
            array('fieldlabel' => 'Manufacture','fieldname'=>  'Manufacture','type'=>'select'),
            array('fieldlabel' => 'Unit Measure','fieldname'=>  'UnitMeasure','type'=>'select'),
            array('fieldlabel' => 'Reorder Level','fieldname'=>  'ReorderLevel','type'=>'select'),
            array('fieldlabel' => 'Purchase Tax Rate','fieldname'=>  'purchase_tax_rate','type'=>'select'),
            array('fieldlabel' => 'Sale Tax Rate','fieldname'=>  'sale_tax_rate','type'=>'select'),
            array('fieldlabel' => 'Status','fieldname'=>  'Status','type'=>'select'),
            array('fieldlabel' => 'Item Type','fieldname'=>  'itemType','type'=>'select'),
            array('fieldlabel' => 'Model & Generation','fieldname'=>  'Model','type'=>'select'),
	    //array('fieldlabel' => 'Generation','fieldname'=>  'Generation','type'=>'select'),
            array('fieldlabel' => 'Valuation Type','fieldname'=>  'evaluationType','type'=>'select'),
	    array('fieldlabel' => 'Warehouse','fieldname'=>  'warehouse','type'=>'select')	 //added by chetan 30Mar2017// 
       );
    //updated by chetan on 14July//
    public $dropdownClmArr = array('Manufacture'=> 'Manufacture', 'itemType' => 'ItemType', 'ReorderLevel' => 'Reorder', 
        'evaluationType' => 'EvaluationType', 'UnitMeasure' => 'Unit', 'adjust_reason' => 'AdjReason','transfer_reason' => 'AdjReason');
    public $taxclm = array('purchase_tax_rate' => 1,'sale_tax_rate' => 2);

    public $showVal = array('CategoryID','purchase_tax_rate','sale_tax_rate','Status','Model');
    
    
    public $stockAdjArr = array(
            array('fieldlabel' => 'Adjustment Location','fieldname'=>  'warehouse_code','type'=>'select'),
            array('fieldlabel' => 'Adjustment Reason' ,'fieldname'=>  'adjust_reason' ,'type'=>'select'),                   
            array('fieldlabel' => 'Adjustment Status' ,'fieldname'=>  'Status' ,'type'=>'select')
            );
    
    public $stockTransArr = array(
            array('fieldlabel' => 'Transfer From Location','fieldname'=>  'from_WID','type'=>'select'),
            array('fieldlabel' => 'Transfer To Location' ,'fieldname'=>  'to_WID' ,'type'=>'select'),                   
            array('fieldlabel' => 'Transfer Reason' ,'fieldname'=>  'transfer_reason' ,'type'=>'select'),
            array('fieldlabel' => 'Transfer Status' ,'fieldname'=>  'Status' ,'type'=>'select')
            );
    
    public $stockItemArrForTableHeader = array(
            array('fieldlabel' => 'SKU','fieldname'=>  'sku'),
            array('fieldlabel' => 'Condition' ,'fieldname'=>  'Condition' ),     //27July2018//                  
            array('fieldlabel' => 'Description' ,'fieldname'=>  'description' ),
            array('fieldlabel' => 'Qty on Hand' ,'fieldname'=>  'on_hand_qty' ),
            array('fieldlabel' => 'Adj Qty' ,'fieldname'=>  'qty' ),                   
            array('fieldlabel' => 'Unit Price' ,'fieldname'=>  'price' ),
            array('fieldlabel' => 'Total Value' ,'fieldname'=>  'amount' )
            );
    public  $stockItemArr = array(
            array('fieldlabel' => 'SKU','fieldname'=>  't2.sku'),
            array('fieldlabel' => 'Condition' ,'fieldname'=>  't2.Condition' ),                   
            array('fieldlabel' => 'Description' ,'fieldname'=>  't2.description' ),
            array('fieldlabel' => 'Qty on Hand' ,'fieldname'=>  't2.on_hand_qty' ),
            array('fieldlabel' => 'Adj Qty' ,'fieldname'=>  't2.qty' ),                   
            array('fieldlabel' => 'Unit Price' ,'fieldname'=>  't2.price' ),
            array('fieldlabel' => 'Total Value' ,'fieldname'=>  't2.amount' )
            );
   public  $CurrencyRate; //= '';
   public $isalias; //added by chetan on 10Mar2017//	
    //constructor
    function customsearch() {
        $this->dbClass();
    }
    
    function saveSearchData($post)
    {  //echo "<pre/>";print_r($post); die;
        
        if($post['search_ID']=='')
        {
            $strquery = "insert into c_customsearch set 
                         search_name    =   '".$post['search_name']."',
                         moduleID       =   '".$post['moduleID']."',
                         columns        =   '".$post['columns']."' ,
                         displayCol     =   '".$post['displayCol']."',
                         checkboxes     =   '".$post['checkboxes']."',
                         saleduration   =   '".$post['saleDuration']."' ,
                         purduration    =   '".$post['purDuration']."',
      		         userids   	=   '".$post['userids']."' ,
                         role    	=   '".$post['role']."',
			 showsopopop    =   '".$post['showsopopop']."',
			 currency    	=   '".$post['currency']."',
			 recordInsertedBy = '".$_SESSION['AdminID']."',    
                         status         = 	1 ";

            $this->query($strquery,0);
            $searchID = $this->lastInsertId();
                    
        }else{
            
            $strquery = "update c_customsearch set 
                         search_name    =   '".$post['search_name']."',
                         moduleID       =   '".$post['moduleID']."',
                         columns        =   '".$post['columns']."' ,
                         displayCol     =   '".$post['displayCol']."',
                         checkboxes     =   '".$post['checkboxes']."',
                         saleduration   =   '".$post['saleDuration']."' ,
                         purduration    =   '".$post['purDuration']."',
			 userids   	=   '".$post['userids']."' ,
                         role    	=   '".$post['role']."',
			 showsopopop    =   '".$post['showsopopop']."',
			 currency    	=   '".$post['currency']."',	
                         status         = 	1  where search_ID =  '".$post['search_ID']."'";
            $this->query($strquery,0);

        }
       
    }
    
    function generateInputsByPostData($colsArr,$post,$fr)
    {   //echo "<pre/>";print_r($post);die;
        if($colsArr)
        {
            $data = array();
            $Slctcolms = explode(',',$colsArr);
            $i = 0;
            foreach($Slctcolms as $field)
            {   //print_r(($post['moduleID'] != '601') ? str_replace('t2.','',$field) :$field);
                $ArrToPass = $this->getAllFldFrTableByModID($post['moduleID'],$fr);
                $_SESSION['field'] =  ($post['moduleID'] != '601') ? str_replace('t2.','',$field) : $field;
                $fltrArr = array_filter(array_map(function($arr){
                                                    if($arr['fieldname'] == $_SESSION['field']){
                                                        return $arr;

                                                    }  
                                                },$ArrToPass)); //23July2018//
                $data[$i]      = array_shift($fltrArr);//23July2018//
                $i++;  
                unset($_SESSION['field']);
            } 
        }
       //echo "<pre/>";print_r($data);die;
        return $data;
    }
    
    function GetSearchLists($ID = ''){
        global $Config;	
        if($ID)
        {   
            $where = " where search_ID=".$ID;
        }else{
            if($_SESSION['AdminType'] == 'admin')
	    {
		$where = "";
	    }else{ 	
            	$where =" where FIND_IN_SET('".$_SESSION['AdminID']."', userids) or recordInsertedBy = '".$_SESSION['AdminID']."' or role = 'public' ";
	    }
        }
        if(isset($Config['GetNumRecords']) && $Config['GetNumRecords']==1){  //24July2018//
            $Columns = " count(search_ID) as NumCount ";				
        }else{	
            $Columns = '*';
        }
    	$query = "SELECT $Columns FROM c_customsearch".$where;
    	return $this->query($query);
    	
    }
    //updated on 12jan by chetan///
    function deleteSearchList($delete_id){
        $query = "DELETE FROM c_customsearch Where search_ID=$delete_id";
        $this->query($query);
    }
   
    function iscsearchNameExists($name, $searchID = 0) 
    {
        $strSQLQuery = (!empty($searchID)) ? (" and search_ID != " . $ID) : ("");
        $strSQLQuery = "select search_ID from c_customsearch where LCASE(search_name)='" . strtolower(trim($name)) . "'" . $strSQLQuery;
        $arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['search_ID'])) {
		    return true;
		} else {
		    return false;
		}
    }
    
    function getAllFldFrTableByModID($mod,$for = 1)
    {
        if($mod and $for == 1)
        {
           if($mod == '601')
           {
               return $this->ItemArr;
           }elseif($mod == '602')
           {
              
                return $this->stockAdjArr;
           }elseif($mod == '603')
           {
                return $this->stockTransArr;
           }
        }    
        
        if($for == '2')
        {
            return $this->stockItemArr;
            
        }elseif($for == '3')
        {
            return $this->stockItemArrForTableHeader;
        }
    }
    
    function getTableNameByModID($mod)
    {
        $arr = array('601'=> 'inv_items','602'=> 'inv_adjustment', '603' => 'inv_transfer');
        return ($mod !='601' ) ? $arr[$mod].' as t1' : $arr[$mod];
    }
    
    function selectOptions($field,$mod,$selVal)
    {
        $objCommon = new common();
        $objTax = new tax();
        $objItem = new items();

	(empty($html))?($html=""):("");  

        if(isset($this->dropdownClmArr[$field]))
        {
            $arryRes = $objCommon->GetCrmAttribute($this->dropdownClmArr[$field], '');
            for($i=0;$i<sizeof($arryRes);$i++) {
		$select = ($arryRes[$i]['attribute_value'] == $selVal)? 'selected="selected"' : '' ;                
		$html.= '<option value="'.$arryRes[$i]['attribute_value'].'"  '.($select).'>'.stripslashes($arryRes[$i]['attribute_value']).'</option>';
            } 
        }
        
        if(isset($this->taxclm[$field]))
        { 
            $arryRes = $objTax->GetTaxRate($this->taxclm[$field]);//print_r($arryRes);
            for ($i = 0; $i < sizeof($arryRes); $i++) {
	    $select = ($arryRes[$i]['RateId'] == $selVal)? 'selected="selected"' : '' ;
            $html.= '<option value="'.$arryRes[$i]['RateId'].'"  '.$select.'>'.$arryRes[$i]['RateDescription'].'- ('.number_format($arryRes[$i]['TaxRate'], 2).'%)</option>';
            }
        }
        
        if($field == 'Status' && ($mod == '602' || $mod == '603'))
        {
            if($mod == '603')
            {
                $html = '<option value="1" '.(($selVal == 1)? 'selected="selected"' : '' ).'>Parked</option><option value="2" '.(($selVal == 2)? 'selected="selected"' : '' ).'>Completed</option>';
            }else{
                $html = '<option value="1" '.(($selVal == 1)? 'selected="selected"' : '' ).'>Parked</option><option value="2" '.(($selVal == 2)? 'selected="selected"' : '' ).'>Completed</option><option value="0">Canceled</option>';
            }    
        }
        
        if($field == 'non_inventory' && $mod == '601')
        {
            $html = '<option value="Yes" '.(($selVal == 'Yes') ? 'selected="selected"' :'').'>Yes</option><option value="No" '.(($selVal == 'No') ? 'selected="selected"' :'').'>No</option>';
        }
        
        if($field == 'Status' && $mod == '601')
        {
            $html = '<option value="1" '.(($selVal == 1)? 'selected="selected"' :'').'>Active</option><option value="0" '.(($selVal == 0 && $selVal!='')? 'selected="selected"' : '').'>Inactive</option>';
        }
        
        if($field == 'warehouse_code' || $field == 'from_WID' || $field == 'to_WID')
        {   
            $objWarehouse = new warehouse();    
            $arryRes = $objWarehouse->ListWarehouse('', '', '', '', 1);//print_r($arryRes);
            for ($i = 0; $i < sizeof($arryRes); $i++) {
		$select = ($arryRes[$i]['warehouse_code'] == $selVal)? 'selected="selected"' : '' ;
                $html.= '<option value="'.$arryRes[$i]['warehouse_code'].'" '.$select.'>'.$arryRes[$i]['warehouse_name'].'</option>';
            }
        }
        
	if($field == 'Model' && $mod == '601')
        {
            $arryModel = $objItem->GetModelGen('');
            for($i=0;$i<sizeof($arryModel);$i++) {
                $html.= '<option value="'.$arryModel[$i]['id'].'" '.(($arryModel[$i]['id'] == $selVal)? "selected" : '' ).'>'.stripslashes($arryModel[$i]['Model']).'</option>';
            }    
        }
        
	//added by chetan on 30Mar2017//
	if($field == 'warehouse' && $mod == '601')
        {
	    $objwarehouse = new warehouse();
            $arrywarehouse = $objwarehouse->ListWarehouse('','','WID','','');//print_r($arrywarehouse);
            for($i=0;$i<sizeof($arrywarehouse);$i++) {
                $html.= '<option value="'.$arrywarehouse[$i]['WID'].'" '.(($arrywarehouse[$i]['WID'] == $selVal)? "selected" : '' ).'>'.stripslashes($arrywarehouse[$i]['warehouse_name']).'</option>';
            }    
        }

        return $html;
    }
    
    //update by chetan 19July//
    function generateQueryStringUsingCl($post)
    {//echo "<pre/>";print_r($post);die;
	$querystr='';
        if($post['columns']!="")
        {
            $clms = explode(',',$post['columns']);
            $pfix = ($post['moduleID'] != '601') ? 't1.' : '' ;
            foreach($clms as $clms)
            {
		if(!empty($post[$clms]) || $post[$clms] == '0')
		{
                    if($clms == 'Model' || $clms == 'description'){  //updated on 20Mar2017//
                            
                            $querystr .= "".$pfix.$clms." LIKE '%".trim($post[$clms])."%' or ";
                    }else{
                            $querystr .= "".$pfix.$clms." = '".trim($post[$clms])."' or ";
                    }    
		}
            }
		$querystr = ($querystr) ? 'where '.$querystr  : $querystr ;
		$querystr = rtrim($querystr,' or');
	        return $querystr;
        }
        return false;
    }
    
    function joinTable($post)
    {
        if($post['moduleID'] === '602')
        {
            $joinStr = 'join inv_stock_adjustment as t2 on t1.adjID = t2.adjID';
            return $joinStr;
        }elseif($post['moduleID'] === '603')
        {
            $joinStr = 'join inv_stock_transfer as t2 on t1.transferID = t2.transferID';
            return $joinStr;
        }else{
            return false;
        }
    }    
    
    function addPrefix($colStr,$mod)
    {
        if($mod !='601')
        {
            $ColArr =   explode(',', $colStr);
            $ColArr =   array_map(function($arr){ return 't2.'.$arr;},$ColArr);
            $ColStr =   implode(',',$ColArr); 
            return $ColStr;
            
        }else{
            return $colStr;
        }
    }
    //updated by chetan on 5Jan 2017 for alias search//
    function generateFilterRows($post)
    {  
	$Limit='';
	//added by chetan on 30MAr2017//
	if(strpos($post['columns'],'warehouse'))
	{
		$post['columns'] = str_replace(',warehouse','',$post['columns']);
	}//End//
        global $Config;
        $table  =   $this->getTableNameByModID($post['moduleID']);
        $where  =   $this->generateQueryStringUsingCl($post);

        $join   =   $this->joinTable($post);
	
        $colns = $this->getColListStr($post);
        //25July2018//
        if((isset($Config['GetNumRecords']) && $Config['GetNumRecords']=="") || !isset($Config['GetNumRecords']) ){
            $Limit = " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
        }
	 $Strquery = 'select '.$colns.' from '.$table.' '.$join.' '.$where.'  '.$Limit.'';
	$res = $this->query($Strquery,1);
	//print_r(strpos($post['columns'],Sku)); print_r(empty($res));die;
	if((strpos($post['columns'],'Sku') >= 0) && empty($res) && $post['moduleID'] == '601')
	{
		$Strquery = 'select item_id from inv_item_alias where ItemAliasCode = "'.$post['Sku'].'" ';
		$res = $this->query($Strquery,1);
#echo $Strquery;
		if(!empty($res)){
			$Strquery = 'select '.$colns.' from inv_items where ItemID =  '.$res[0]['item_id'].' ';
			$res = $this->query($Strquery,1);
			if(count($res)) $this->isalias = 1;	 //added by chetan on 10Mar2017//		
		}
  #echo $Strquery;
	}
	return $res;
             
    }
    
    //added by chetan on 10Mar2017//	
    function isAlias()
    {
	return $this->isalias;	
    }	
    //End// 	

    //update by chetan 14Sep2017 for modelpopup//
    function selectedVal($val ,$filedName, $ItemID)
    {
        if(isset($this->taxclm[$filedName]))
        { 
            $objTax = new tax();
            $arryRes = $objTax->GetTaxRate($this->taxclm[$filedName]);//print_r($arryRes);
            for ($i = 0; $i < sizeof($arryRes); $i++) {
                if($arryRes[$i]['RateId']==$val){ return $arryRes[$i]['RateDescription'].' - ('.number_format($arryRes[$i]['TaxRate'],2).'%)';} 
            }
        }
        elseif($filedName == 'Status')
        {
            return ($val === '0')? 'Inactive' : 'Active';
        }elseif($filedName == 'Model')
        {
            $objItem = new items();
            $arryRes = $objItem->GetModel($val);//print_r($arryRes);
           /* $models = array_map(function($arr){
                                    if($arr['Model']!=''){   
                                        return $arr['Model'];
                                    }
                                }
                                ,$arryRes);
            $models = join(', ', $models);
            return $models;*/
            $tablestr = '';
            $tablestr = '<a href="javascript:;" class="showpopup"><img border="0" title="View Model & Generation" src="../images/view.png"></a>		
                    <div class="popupback"></div>
                            <div class ="popup">
                    <div class="close"><a class="closepopup" href="javascript:;">close</a></div>
                    <div class="popup-heading"><h2>Model & Generation</h2></div>

                    <table align="center" cellspacing="1" cellpadding="3" width="100%" id="list_table" class="table-popup">
                    <tr>
                        <td class="head1">Model</td>
                        <td class="head1">Generation</td>		
                    </tr>';

                    if(!empty($arryRes))
                    {
                        foreach($arryRes as $val){
				$arrGen =  $objItem->GetModGen($ItemID, $val['id']);//echo "<pre/>";print_r($arrGen);
				$genration = (!empty($arrGen[0]['genration'])) ? ($arrGen[0]['genration']) :("");
				$tablestr .='<tr>
					<td>'.$val['Model'].'</td>
					<td>'.$genration.'</td>		
				      </tr>';
                        }
                        $tablestr .='<tr>&nbsp;</tr>';
                    }else{

                        return "<tr><td>No Record Found!</td></tr>";
                    }

            $tablestr .= '</table></div>';
            return $tablestr;
	   	

        }elseif($filedName === 'CategoryID')
        {   
            $objCategory = new category();
            $cat = $objCategory->GetCategoryNameByID($val);
            return (!empty($cat)) ? $cat[0]['Name'] : ''; //25July2018//
        }
        
    }
    
    function GetFieldLabel($name,$modID,$fr)
    {
        if($name){
            
           $Arr = $this->getAllFldFrTableByModID($modID,$fr);
           foreach($Arr as $arr)
           {
               if($arr['fieldname'] == $name )
               {
                    $newArr['fieldname']    = $arr['fieldname'];
                    $newArr['fieldlabel']   = $arr['fieldlabel'];
                    $newArr['type']         = isset($arr['type']) ? $arr['type'] : ''; //24/july/2018//
                    return $newArr;
               }
           }
        }
    }
    
    function getColListStr($post)
    {
        global $Config;
         if(isset($Config['GetNumRecords']) && $Config['GetNumRecords']==1) //7jan 2017 by chetan//25july2018//
        {
        
            $colns = $this->countFor($post['moduleID']);
            
        }else{
        
            if($post['displayCol']!='')	
            {	
                    $colns = $this->addPrefix($post['displayCol'],$post['moduleID']);
            }else{
                    $fr = $sku = ($post['moduleID'] != '601') ? '3' : '1';
                    $ColArr = $this->getAllFldFrTableByModID($post['moduleID'],$fr);
                    $colns = implode("," , array_map(function($arr){
                                            return $arr['fieldname'];
                                            },$ColArr));
            }      

            $sku = ($post['moduleID'] == '601') ? 'Sku' : 't2.sku';
            $ItemId = ($post['moduleID'] == '601') ? 'ItemID' : 't2.item_id as ItemID';
            if($post['displayCol']!='')
            {		
                    if(!strstr($post['displayCol'],$sku))
                    {
                            $colns = $colns.','.$sku;
                    }
            }		
            $colns = $colns.','.$ItemId;  
        }
        return $colns;
    }
    
    function countFor($mod)   //7jan 2017 by chetan//
    {
        if($mod == '601')
        {
            return 'count(ItemID) as NumCount';
        }elseif($mod == '602' || $mod == '603')
        {

             return 'count(item_id) as NumCount';
        }
    }
	//update 6Feb by chetan//
	function ShowIcons($checked,$values,$Line)
    {   
        if(!empty($checked))
        {
            $html = '<span style="width: 100%; display: block; text-align: center;">';
            $objbom  = new bom();
            $objItems=new items();
            
            if(in_array('1',$checked))
            {

                $BId = $objbom->GetBomIdByItemId($values['ItemID']);
                if(($values['itemType'] == 'Kit' or $values['itemType'] == 'Non Kit') && ($BId!=''))
                {  
                    $html.= ' <a class="fancybox fancybox.iframe" href="vBom.php?view='.$BId.'&curP=1&tab=bill_Information&pop=1"><img border="0" title="Bom" src="../images/bom.png"></a>';  
                }    

            }
            if(in_array('2',$checked))
            {
                $Arr = $objItems->GetAliasbyItemID($values['ItemID']);
                if(!empty($Arr))
                {  
                    $html.= ' <a class="fancybox fancybox.iframe" href="vItem.php?view='.$values['ItemID'].'&tab=Alias&pop=1"><img border="0" title="Alias" src="../images/alias.png"></a>';  
                }        
            }
            /*if(in_array('3',$checked))//update 11Jan by chetan//
            {
                $Arr = $objItems->GetSerialNumber('',$values['Sku']);
                if(!empty($Arr))
                { 
                    $html.=' <a class="fancybox fancybox.iframe" href="viewSerial.php?Sku='.$values['Sku'].'&pop=1"><img border="0" title="Serial Numbers" src="../images/serial.png"></a>';
                }

            }*/


	    $bomArr = $objItems->KitItemsOfComponent($values['ItemID']);
	    $num    = $objItems->numRows();	
            if($bomArr)
	    {
		$html.='   <a id="'.$Line.'" class="boom-active" href="javascript:;"><img border="0" title="Where Used?" src="../images/compbom.png"></a>

<!-- Modal -->
<div id="boom-overlay'.$Line.'" class="overlay-div"></div>
<div id="boom'.$Line.'" class="boom-table">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      
        <button type="button" class="cross-close boom-close" id="'.$Line.'">&times;</button>
        <h4 class="modal-title">Component Bom Item List</h4>
      
     
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
 	   <tr>
             <td id="ProductsListing" valign="top">
		<div id="preview_div">
<table align="center" cellspacing="1" cellpadding="3" width="100%" id="list_table">

		<tr align="left">
		<td width="10%" class="head1">Sku</td>
		</tr>';

                    if (is_array($bomArr) && $num > 0) {
                        $flag = true;
                        $Line = 0;$bgcolor='';
                        foreach ($bomArr as $key => $values) {
                            $flag = !$flag;
                            $Line++;

                            $html.='<tr align="left" valign="middle" bgcolor="'.$bgcolor.'">
                                <td >'.$values["Sku"].'</td>
                           </tr>';
			} // foreach end // 
			} else { 
			$html.='<tr >
			    <td  colspan="10" class="no_record">'.NO_RECORD.'</td>
			</tr>';

			} 

                    $html.='<tr><td  colspan="10" >Total Record(s) : &nbsp;'.$num.' </td> </tr>
                </table>
		
        </td>
    </tr>

</table>
      </div>
      
    </div>
  </div>
</div>';
            }


            $html.='</span>';
            return $html;
        }    
           
        return false;
    }
	
	//add 11Jan by chetan($type,$time,$values)//updated 20Mar2017//updated 5Apr2017//
    function showSalesPurchase($type,$time,$values,$condition = '',$itemids, $WID ='' )
    {	
	$objItems = new items();
	$Sku=''; $showRes='';
	(!isset($time[3]))?($time[3]=""):("");  

	if(is_array($itemids)){ 
		$itemID = $itemids;$comp = '&comp=yes&condition='.$condition.'';	

	}else{ 
		$Sku = $values['Sku'];$comp= '&condition='.$condition.'';

 	$itemID = $values['ItemID'];
	}
	if($type == 'sale'){	 
		if(!empty($time[1])){ 
			$TotalQty = $objItems->GetPOSOTotalQtyOnInterval($Sku, $time[1].'d','SO',$condition,$itemID, $WID);
	
		 $showRes = '<a class="'.(($time[3] == 'Yes')?'fancybox fancybox.iframe':'fancybox').'" href=" '.(($time[3] == 'Yes') ?  'viewSaleHistory.php?sku='.$values['Sku'].'&numHistory='.$time[1].'d&pop=1'.$comp.'&WID='.$WID.'' : 'javascript:;' ).'">'.$time[1].'d <span title="Qty">'.((!empty($TotalQty[0]['total'])) ? '('.$TotalQty[0]['total'].')' : '').'</span></a> '; 
		 }if(!empty($time[0])){
			$TotalQty = $objItems->GetPOSOTotalQtyOnInterval($Sku, $time[0].'m','SO',$condition,$itemID, $WID); 

		 $showRes .= '<a class="'.(($time[3] == 'Yes')?'fancybox fancybox.iframe':'fancybox').'" href="'.(($time[3] == 'Yes')?'viewSaleHistory.php?sku='.$values['Sku'].'&numHistory='.$time[0].'m&pop=1'.$comp.'&WID='.$WID.'' : 'javascript:;').'">'.$time[0].'m <span title="Qty">'.((!empty($TotalQty[0]['total'])) ? '('.$TotalQty[0]['total'].')' : '').'</span></a>';
		 }if(!empty($time[2])){ 
			$TotalQty = $objItems->GetPOSOTotalQtyOnInterval($Sku, $time[2].'year','SO',$condition,$itemID, $WID);
			
		 $showRes .= '<a class="'.(($time[3] == 'Yes')?'fancybox fancybox.iframe':'fancybox').'" href="'.(($time[3] == 'Yes') ?  'viewSaleHistory.php?sku='.$values['Sku'].'&numHistory='.$time[2].'year&pop=1'.$comp.'&WID='.$WID.'' : 'javascript:;' ).'">'.$time[2].'year <span title="Qty">'.((!empty($TotalQty[0]['total'])) ? '('.$TotalQty[0]['total'].')' : '').'</span></a>';
		 }
	 }else{

		 if(!empty($time[1])){ 
			$TotalQty = $objItems->GetPurchaseTotalQtyOnInterval($Sku, $time[1].'d', $condition,$itemID, $WID);		
		
                $showRes = '<a class="'.(($time[3] == 'Yes')?'fancybox fancybox.iframe':'fancybox').'" href="'.(($time[3] == 'Yes') ?  'viewPOHistory.php?sku='.$values['Sku'].'&numHistory='.$time[1].'d&pop=1'.$comp.'&WID='.$WID.'' : 'javascript:;' ).'">'.$time[1].'d <span title="Qty">'.((!empty($TotalQty[0]['total'])) ? '('.$TotalQty[0]['total'].')' : '').'</span></a> ';
                }if(!empty($time[0])){ 
			$TotalQty = $objItems->GetPurchaseTotalQtyOnInterval($Sku, $time[0].'m', $condition,$itemID, $WID);
		
                 $showRes .= '<a class="'.(($time[3] == 'Yes')?'fancybox fancybox.iframe':'fancybox').'" href="'.(($time[3] == 'Yes') ?  'viewPOHistory.php?sku='.$values['Sku'].'&numHistory='.$time[0].'m&pop=1'.$comp.'&WID='.$WID.'' : 'javascript:;' ).'">'.$time[0].'m <span title="Qty">'.((!empty($TotalQty[0]['total'])) ? '('.$TotalQty[0]['total'].')' : '').'</span></a> ';
                }if(!empty($time[2])){ 
			 $TotalQty = $objItems->GetPurchaseTotalQtyOnInterval($Sku, $time[2].'year', $condition,$itemID, $WID);
		        
                $showRes .= '<a class="'.(($time[3] == 'Yes')?'fancybox fancybox.iframe':'fancybox').'" href="'.(($time[3] == 'Yes') ?  'viewPOHistory.php?sku='.$values['Sku'].'&numHistory='.$time[2].'year&pop=1'.$comp.'&WID='.$WID.'' : 'javascript:;' ).'">'.$time[2].'year <span title="Qty">'.((!empty($TotalQty[0]['total'])) ? '('.$TotalQty[0]['total'].')' : '').'</span></a>';
                } 
	 } 	 
	 return $showRes;
    }

    function compItemTableHtml($CondQty,$val,$arr, $WID) //updated by chetan on 30Mar2017//
    {	
	global $Config;
#if($_GET['ff']==1){ print_r($val); echo $WID; exit;}
	$objItem = new items();

	if(!isset($val['ItemID'])) $val['ItemID']='';
	if(!isset($val['evaluationType'])) $val['evaluationType']='';

	if($val['evaluationType'] =='LIFO'){

	$arr['LMT']  = 1;
	$arr['Ordr'] = 'ASC';
	$arr['Sku']  = $val['Sku'];
	$arr['Condition']  = $CondQty;
	$avgPrice=$objItem->GetAvgTransPrice($val['ItemID'],$arr, $WID);

	}else if($val['evaluationType'] =='FIFO'){

	$arr['LMT']  = 1;
	$arr['Ordr'] = 'DESC';
	$arr['Sku']  = $val['Sku'];
	$arr['Condition']  = $CondQty;
	$avgPrice=$objItem->GetAvgTransPrice($val['ItemID'],$arr, $WID);

	}else{
	#echo "bhoodev";
	$arr['Sku']  	   = $val['Sku'];
 $arr['Condition']  = $CondQty;
	$avgPrice=$objItem->GetAvgSerialPrice($val['ItemID'],$arr, $WID);
	}
	
	#pr($avgPrice);
	return $avgPrice;	
    }

	//added by chetan/saiyed on 21Mar2018 for primary item functionality//
	function CheckPrimary($arr)
	{
		$firstArrVal = current($arr);
		foreach($arr as $val){
			if($firstArrVal['Sku'] != $val['Sku']){ return false; }
		}
		
		return $firstArrVal['Sku'];
	}


    function pairQuantNo($values,$condi,$tcost='', $WID='')   //updated by chetan on 30Mar2017//
    {
	$arr = array();
	$pair = array();
	$objItem = new items();
	$Arr = $objItem->GetKitItem($values['ItemID']);
   	$totalAvgCost=0;

	//Added primary item functionality on 21Mar2018 by chetan//
	
	$bomItemOp = $objItem->GetBOMById($values['ItemID'],1);
	$IsPRSame = '';
	if($bomItemOp == 'Yes'){
		$PrArr = $objItem->GetKitItem($values['ItemID'],'1');
		if(!empty($PrArr) && count($PrArr) > 1){
			$IsPRSame = $this->CheckPrimary($PrArr);
		}
	}
	
	if($IsPRSame == ''){     
			if(!empty($Arr))
			{       
			$made = '';
			$unmade = '';	
			foreach($Arr as $val)
				    {	    
				$arryCondQty=$objItem->getItemCondion($val['Sku'],$condi,$WID); 
				$numQty =count($arryCondQty);    
				if (is_array($arryCondQty) && $numQty > 0) 
				{	
					if($tcost){
						$AvgCost = $this->compItemTableHtml($condi,$val,$arr, $WID);//updated by chetan on 30Mar2017//
						$AvgCostprice = (!empty($AvgCost)) ? $AvgCost[0]['price'] : 0;//26July2018//
						$totalAvgCost = bcadd($totalAvgCost, ($AvgCostprice * $val['qty']), 2);//26July2018//
					}else{

						if($val['qty'] <=  $arryCondQty[0]['condition_qty'])
						{
							$made = 1; 
							$dvd  = floor(($arryCondQty[0]['condition_qty'])/($val['qty']));
							array_push($pair,$dvd);
						}else{
							$unmade = 1;	
						}
					}	

				}else{
					$unmade = 1;
				}                
				    }
			if($tcost){  return  $totalAvgCost;  }
			return  ($unmade) ? 0 : min($pair);
			}
	}else{

		$arryCondQty=$objItem->getItemCondion($IsPRSame,$condi,$WID);
		return (!empty($arryCondQty)) ? $arryCondQty[0]['condition_qty'] : 0; 
	}
	//End//	
	return 0;
    }	 	

  //added on 19Sept2017 by chetan for fullkits//
    function fullKitscost($values,$condi, $WID='')
    {		
	$objItem = new items();	
	$optionsArr = $objItem->getOptionCode($values['ItemID']);
	if(empty($optionsArr))
	{
		return $this->pairQuantNo($values,$condi,'totalcost', $WID);
	}else{
		
		if (is_array($optionsArr)) {
			$sumopair = $sumCostintopair = '' ;$AvgCostprice = 0; //26July2018//			
			foreach ($optionsArr as $key => $values) {
				$resArr = $objItem->GetOptionCodeItem($values['optionID']);
				if(count($resArr)>0 ) { 
				    $totalAvgCost = '';
				    $opair = $arr = array(); 	//26July2018// 	 
				    foreach($resArr as $res){
					$arryCondQty=$objItem->getItemCondion($res['sku'],$condi,$WID);
					$numQty =count($arryCondQty); 
					$condition_qty = (!empty($arryCondQty[0]['condition_qty'])) ? ($arryCondQty[0]['condition_qty']) : ("0");
   
					if (is_array($arryCondQty) && $numQty > 0) 
					{	
						$res['Sku'] = $res['sku'];
						$AvgCost = $this->compItemTableHtml($condi,$res,$arr,$WID);
						$AvgCostprice = (!empty($AvgCost)) ? $AvgCost[0]['price'] : 0;//26July2018//
					}
						$res['ItemID'] = $res['item_id'];
						$perpairQty = $this->pairQuantNo($res,$condi,'',$WID);
					        $perCompAvgCost = $this->pairQuantNo($res,$condi,'avgcost',$WID);	
						$Smprice =  ($AvgCostprice) + ($perCompAvgCost);//26July2018//
						$operpair = (int)$condition_qty + (int)$perpairQty;
						array_push($opair,$operpair);	
						$totalAvgCost = bcadd($totalAvgCost, ($Smprice * $res['qty']), 2);
								
				    }
				}

			$opair = min($opair);
			$sumopair = bcadd($sumopair,$opair);
			$sumCostintopair =  bcadd($sumCostintopair,($totalAvgCost * $opair), 2);		
		
			}
		
		$cost = ($sumopair != '0') ? round($sumCostintopair / $sumopair, 2) : round($sumCostintopair, 2);//26July2018//
		return  ($cost) ? $cost : 0; 
		}		 
	}
	

    }	 	
	//End//


 function NoNpairQuantNo($values,$condi,$tcost='', $WID='')   //updated by chetan on 31Mar2017//
    {
	$arr = array();
	$pair = array();
	$Nonpair = array();
	$objItem = new items();
	$Arr = $objItem->GetKitItem($values['ItemID']);
       		$totalAvgCost=0;     
        if(!empty($Arr))
        {       
		$made = '';
		$unmade = '';	
		foreach($Arr as $val)
                {	  
  			$arryCondQty=$objItem->getItemCondion($val['Sku'],$condi,$WID); 
			$numQty =count($arryCondQty);    
			if (is_array($arryCondQty) && $numQty > 0) 
			{	
				
			if($tcost){
				$AvgCost = $this->compItemTableHtml($condi,$val,$arr, $WID);//updated by chetan on 31Mar2017//
				$AvgCostprice = (!empty($AvgCost)) ? $AvgCost[0]['price'] : 0;//26July2018//
				$totalAvgCost = bcadd($totalAvgCost, ($AvgCostprice * $arryCondQty[0]['condition_qty']), 2);//26July2018//
				}else{
					if($val['qty'] <=  $arryCondQty[0]['condition_qty'])
					{
						$unmade = 1;	
						$dvd  = floor(($arryCondQty[0]['condition_qty'])/($val['qty']));
						array_push($Nonpair,$dvd);
					}else{

$unmade = 0;
            }
					}

			}            
    }
//echo $unmade;
		if($tcost){  return  $totalAvgCost;  }
		return  ($unmade) ? max($Nonpair) : 0;
        }	
	return 0;
    }				
	//End//

    //updated 18Jan//updated by chetan on 31Mar2017//
    function showOnSO($Cond,$allItem,$checked,$postdata)
    {	

	$yes = explode(',',$postdata['showsopopop']);

	if(empty($postdata['warehouse'])) $postdata['warehouse']='';

	if(in_array('7',$checked))
	{	 
		if($yes[0] == 'Yes'){
			$_SESSION['allBomItemidArr'] = $allItem;
			$countSo = $this->getQtyOrderfr('sale',$allItem,$Cond,'',$postdata['warehouse']);//updated by chetan on 31Mar2017//
			if($countSo !='N/A'){
$countSo = $countSo;
				echo '<td align="center"><a class="fancybox fancybox.iframe" style="display:block;" href="csviewsoorder.php?condition='.$Cond.'&type=sale" title="view"> '.$countSo.'</a></td>';
			}else{
				echo '<td align="center">'.$countSo.'</td>';
			}	
		}else{

			$countSo = $this->getQtyOrderfr('sale',$allItem,$Cond,'',$postdata['warehouse']);//updated by chetan on 31Mar2017//
			echo '<td align="center">'.$this->getQtyOrderfr('sale',$allItem,$Cond,'',$postdata['warehouse']).'</td>';	//updated by chetan on 31Mar2017//	
		}
	}
}
   //updated by chetan on 31Mar2017//
   function showOnPO($Cond,$allItem,$checked,$postdata)
   {	
	$yes = explode(',',$postdata['showsopopop']);
	
	if(!isset($postdata['warehouse'])) $postdata['warehouse']='';
	if(!isset($yes[1])) $yes[1]='';

	if(in_array('8',$checked))
        {	
		if($yes[1] == 'Yes'){

			$_SESSION['allBomItemidArr'] = $allItem;
			$countPo = $this->getQtyOrderfr('purchase',$allItem,$Cond,'',$postdata['warehouse']);//updated by chetan on 31Mar2017//
			if($countPo !='N/A'){
				echo '<td align="center"><a class="fancybox fancybox.iframe" style="display:block;" href="csviewpoorder.php?condition='.$Cond.'&type=purchase" title="view"> '.$countPo.'</a></td>';
			}else{
				echo '<td align="center">'.$countPo.'</td>';
			}
		}else{		
			echo '<td align="center">'.$this->getQtyOrderfr('purchase',$allItem,$Cond,'',$postdata['warehouse']).'</td>';//updated by chetan on 31Mar2017//
		}	
	}	

    }

 function getQtyOrderfr($type,$itemIds,$condition,$row='',$WID='',$dropship='')
    {	
//echo $dropship; exit;
	$tbl  = ($type == 'sale') ? 's_order_item'  : 'p_order_item'  ;		
	$tbl2 = ($type == 'sale') ? 's_order'  : 'p_order'  ;
	
  	$col2  = ($type == 'purchase') ? ' and (NOT EXISTS (SELECT 1 FROM p_order b WHERE b.PurchaseID = t2.PurchaseID and b.Module ="Invoice" and b.PostToGL=1  )OR NOT EXISTS (SELECT 1 FROM p_order p WHERE p.PurchaseID = t2.PurchaseID and p.Module ="Receipt" and p.ReceiptStatus="Completed"  ))   '  : ''  ;
	$col  = ($type == 'sale') ? ' and NOT EXISTS (SELECT 1 FROM s_order b WHERE b.SaleID = t2.SaleID and b.Module ="Invoice" and b.PostToGL=1 )  '  : ''  ;
	
	$sumcol = ($type == 'sale') ? ' SUM(t1.qty) as qty ' : ' SUM(t1.qty-t1.SaleQty) as qty,SUM(t1.qty_received) as qty_received ';
	if(is_array($itemIds)){
		$Itemids = implode("','",$itemIds);
		$str = " and t1.item_id IN('".$Itemids."') ";
	}else{
		$str = " and t1.item_id = '".$itemIds."' ";
	}
if($type == 'purchase'){

$Whrstr = " and t1.qty > t1.qty_received ";

}else{


}
	 $strAddQuery = (($dropship>0 && $dropship!='')  && $type == 'sale')?(" and t1.DropshipCheck = '".$dropship."' "):(" ");	//updated by chetan on 31Mar2017//
	$strAddQuery .= (!empty($WID))?(" and t1.WID = '".$WID."' "):(" and t1.WID = 1 ");	//updated by chetan on 31Mar2017//
	if($row)
	{
		 $Strquery = "SELECT * FROM $tbl as t1 inner join $tbl2 as t2 on t1.OrderID = t2.OrderID WHERE 1 and t2.Module ='Order' ".$str." and t1.Condition = '".$condition."' $Whrstr $col $col2 $strAddQuery"; //updated by chetan on 31Mar2017//
		$res = $this->query($Strquery,1);
		return $res;
	}else{
	
		 $Strquery = "SELECT t2.TrackingNo,t2.ShippingMethod, t1.sku,$sumcol,t2.OrderID,t1.`Condition`,t2.SaleID,t2.Module FROM $tbl as t1 inner join $tbl2 as t2 on t1.OrderID = t2.OrderID WHERE 1 and t2.Module ='Order' ".$str." and t1.Condition = '".$condition."'    $col $col2  $strAddQuery"; //updated by chetan on 31Mar2017//26July2018//

	#echo $Strquery;

if(!empty($res[0]['qty_received'])){
 $res[0]['qty']= $res[0]['qty']-$res[0]['qty_received']; 

}

		$res = $this->query($Strquery,1);	
		return (!empty($res) && $res[0]['qty'] != NULL) ? ($res[0]['qty']) : '0';
	}
 }
	//updated 18Jan//updated by chetan on 31Mar2017//
    function getQtyOrderfr23apr18($type,$itemIds,$condition,$row='',$WID='',$dropship='')
    {	
	$join='';
	$tbl  = ($type == 'sale') ? 's_order_item'  : 'p_order_item'  ;		
	$tbl2 = ($type == 'sale') ? 's_order'  : 'p_order'  ;
	
   	//$col2  = ($type == 'purchase') ? ' and NOT EXISTS (SELECT 1 FROM p_order b WHERE b.PurchaseID = t2.PurchaseID and b.Module ="Invoice" and b.PostToGL=1  )and NOT EXISTS (SELECT 1 FROM p_order p WHERE p.PurchaseID = t2.PurchaseID and p.Module ="Receipt" and p.ReceiptStatus="Completed"  )   '  : ''  ;
$col2  = ($type == 'purchase') ? ' and NOT EXISTS (SELECT 1 FROM p_order b WHERE b.PurchaseID = t2.PurchaseID and b.Module ="Invoice" and b.PostToGL=1  )  '  : ''  ;
	$col  = ($type == 'sale') ? ' and NOT EXISTS (SELECT 1 FROM s_order b WHERE b.SaleID = t2.SaleID and b.Module ="Invoice" and b.PostToGL=1 )  '  : ''  ;
	
	$sumcol = ($type == 'sale') ? ' SUM(t1.qty) ' : ' SUM(t1.qty-t1.SaleQty) ';
	if(is_array($itemIds)){
		$Itemids = implode("','",$itemIds);
		$str = " and t1.item_id IN('".$Itemids."') ";
	}else{
		$str = " and t1.item_id = '".$itemIds."' ";
	}
if($type == 'purchase'){
$recCol = ",SUM(t1.qty_received) as recqty,t2.PurchaseID,t2.SuppCompany,t2.SuppCode,t2.OrderDate ";
//$purCol = ",";
}
	 $strAddQuery = (($dropship>0 && $dropship!='')  && $type == 'sale')?(" and t1.DropshipCheck = '".$dropship."' "):(" ");	//updated by chetan on 31Mar2017//
	$strAddQuery .= (!empty($WID))?(" and t1.WID = '".$WID."' "):(" and t1.WID = 1 ");	//updated by chetan on 31Mar2017//
	if($row)
	{
		 $Strquery = "SELECT t1.*$recCol FROM $tbl as t1 inner join $tbl2 as t2 on t1.OrderID = t2.OrderID WHERE 1 and t2.Module ='Order' ".$str." and t1.Condition = '".$condition."' $col $col2 $strAddQuery"; //updated by chetan on 31Mar2017//
		$res = $this->query($Strquery,1);

		return $res;
	}else{
	
		$Strquery = "SELECT t2.TrackingNo,t2.ShippingMethod, t1.sku,$sumcol as qty,t2.OrderID,t1.`Condition` $recCol,t2.SaleID,t2.Module FROM $tbl as t1 inner join $tbl2 as t2 on t1.OrderID = t2.OrderID $join WHERE 1 and t2.Module ='Order' ".$str." and t1.Condition = '".$condition."'    $col $col2  $strAddQuery"; //updated by chetan on 31Mar2017//
$res = $this->query($Strquery,1);
	if(!empty($_GET['this'])){ echo $Strquery;}

		 $qty = $res[0]['qty']-$res[0]['recqty'];

		return (!empty($res) && $qty != NULL) ? $qty : '0';
	}
 }

    /*function GetCSAvgTransPrice($allBomItemidArr,$condition)
    {
	$arr = array();
	$objItem = new items();
	if(!empty($allBomItemidArr)){
		$Itcount = count($allBomItemidArr);
		for ($i=0; $i< $Itcount; $i++) 
		{	
			$ItemDtl	=   	$objItem->GetItemById($allBomItemidArr[$i]);
			$AvgCost	=	$this->compItemTableHtml($condition,$ItemDtl[0],$arr); //echo $allBomItemidArr[$i];print_r($AvgCost);
			$totalAvgCost   =  bcadd($totalAvgCost, $AvgCost[0]['price'], 2);
		}		
		return ($totalAvgCost) ? $totalAvgCost : 0;		
	}else{
		return 0;
	}
    }*/

 //updated by chetan on 6Apr2017//	
 function GetInKitAvgTransPrice($ItemID,$condition, $WID)
 {
	$arr = array();
	$objItem = new items();
	$bomArr = $objItem->KitItemsOfComponent($ItemID);

	if(!empty($bomArr)){
		$totalAvgCost = '';
		foreach($bomArr as $res){
			$arryCondQty=$objItem->getItemCondion($res['Sku'],$condition,$WID);

			$numQty =count($arryCondQty);
			if (is_array($arryCondQty) && $numQty > 0) {
				foreach ($arryCondQty as $key => $CondQty) {

					if($res['evaluationType'] =='LIFO'){

					$_GET['LMT'] = 1;
					$_GET['Ordr'] = 'ASC';
					$_GET['Sku']  = $res['Sku'];
					$_GET['Condition']  = $CondQty['condition'];
					$AvgCost=$objItem->GetAvgTransPrice($res['ItemID'],$_GET, $WID);
					}else if($res['evaluationType'] =='FIFO'){

					$_GET['LMT'] = 1;
					$_GET['Ordr'] = 'DESC';
					$_GET['Sku']  = $res['Sku'];
					$_GET['Condition']  = $CondQty['condition'];
					$AvgCost=$objItem->GetAvgTransPrice($res['ItemID'],$_GET, $WID);

					}else{
					$_GET['Sku']  = $res['Sku'];
					$_GET['Condition']  = $CondQty['condition'];
					$AvgCost=$objItem->GetAvgSerialPrice($res['ItemID'],$_GET, $WID);
					}

					if(!empty($AvgCost[0]['price']) && !empty($res['bom_qty'])){

					     $totalAvgCost += $AvgCost[0]['price']*$res['bom_qty'];
					}
				}

			}
			
				
		}
	 //$totalAvgCost = $totalAvgCost*$res[''];
	return ($totalAvgCost) ? $totalAvgCost : 0;
	}else{
		return 0;
	}
   
}
	//updated by chetan on 6APR//
    function getAllConditionofSOPO($itemIds,$type, $WID)
    {	
	$tbl  = ($type == 'sale') ? 's_order_item'  : 'p_order_item'  ;		
	$tbl2 = ($type == 'sale') ? 's_order'  : 'p_order'  ;
	
	if(is_array($itemIds)){
		$Itemids = implode("','",$itemIds);
		$str = " and t1.item_id IN('".$Itemids."') ";
	}else{
		$str = " and t1.item_id = '".$itemIds."' ";
	}
	$strAddQuery = (!empty($WID))?(" and t1.WID = '".addslashes($WID)."' "):("and t1.WID = 1 ");
	$Strquery = "SELECT distinct(t1.`Condition`) as `condition` FROM $tbl as t1 inner join $tbl2 as t2 on t1.OrderID = t2.OrderID WHERE 1 and t2.Module ='Order' ".$str."  ".$strAddQuery." ";//$col $col2
	$res = $this->query($Strquery,1);	
	return $res;
    } 		

    function getSalePrice($condi,$itemid)	 	 			
    {
	$Strquery = "SELECT SalePrice FROM inv_item_quanity_condition WHERE ItemID ='".$itemid['ItemID']."' and `condition` = '".$condi."'";
	$res = $this->query($Strquery,1);	
	return (!empty($res)) ? $res[0]['SalePrice'] : '0';
    }	
	
function getSaleQTY($type,$itemIds,$condition,$row='')
    {	
	$tbl  = ($type == 'sale') ? 's_order_item'  : 'p_order_item'  ;		
	$tbl2 = ($type == 'sale') ? 's_order'  : 'p_order'  ;
	//$col2 = ($type == 'purchase') ? ' and t2.Status != "Completed" '  : ''  ;
   $col2  = ($type == 'purchase') ? ' and NOT EXISTS (SELECT 1 FROM p_order b WHERE b.PurchaseID = t2.PurchaseID and b.Module ="Invoice" and b.PostToGL=1  )and NOT EXISTS (SELECT 1 FROM p_order p WHERE p.PurchaseID = t2.PurchaseID and p.Module ="Receipt" and p.ReceiptStatus="Completed"  )   '  : ''  ;
	$col  = ($type == 'sale') ? ' and NOT EXISTS (SELECT 1 FROM s_order b WHERE b.SaleID = t2.SaleID and b.Module ="Invoice" and b.PostToGL!=1 )  '  : ''  ;
	//$join = ($type == 'sale') ? ' left join s_order as t3 on t2.SaleID = t3.SaleID and t3.Module="Invoice"   ' : ' left join p_order as t3 on t2.PurchaseID = t3.PurchaseID and t3.Module="Invoice"  ';
	//$dspcol = ($type == 'sale') ? ' t3.Module as InvM,t3.PostToGL as PTG,t3.SaleID as INVSALE,t3.InvoiceID as INVID, ' : ' t3.Module as InvM,t3.PostToGL as PTG,t3.PurchaseID as INVPO,t3.InvoiceID as INVID, ';
	if(is_array($itemIds)){
		$Itemids = implode("','",$itemIds);
		$str = " and t1.item_id IN('".$Itemids."') ";
	}else{
		$str = " and t1.item_id = '".$itemIds."' ";
	}
	 //SELECT t3.Module as InvM,t3.PostToGL as PTG,t3.PurchaseID as INVPO,t3.InvoiceID as INVID, t1.sku,SUM(t1.qty) as qty,t2.OrderID,t1.`Condition`,t2.PurchaseID,t2.Module FROM p_order_item as t1 inner join p_order as t2 on t1.OrderID = t2.OrderID inner join p_order as t3 on (t2.PurchaseID = t3.PurchaseID and t3.Module="Invoice" and t3.PostToGL!=1) WHERE 1 and t2.Module ='Order' and t1.item_id IN() and t1.Condition = 'New Bulk'
	if($row)
	{
		$Strquery = "SELECT * FROM $tbl as t1 inner join $tbl2 as t2 on t1.OrderID = t2.OrderID WHERE 1 and t2.Module ='Order' ".$str." and t1.Condition = '".$condition."' $col $col2 ";
		$res = $this->query($Strquery,1);
		//return $res;
	}else{
	
	$Strquery = "SELECT $dspcol t1.sku,SUM(t1.qty) as qty,t2.OrderID,t1.`Condition`,t2.SaleID,t2.Module FROM $tbl as t1 inner join $tbl2 as t2 on t1.OrderID = t2.OrderID $join WHERE 1 and t2.Module ='Order' ".$str." and t1.Condition = '".$condition."'    $col $col2";

if($_GET['this']==1){ echo $Strquery;}
	$res = $this->query($Strquery,1);	
	//return (!empty($res) && $res[0]['qty'] != NULL) ? $res[0]['qty'] : 'N/A';
	}
return (!empty($res) && $res[0]['qty'] != NULL) ? $res[0]['qty'] : 'N/A';
    }

    //added by chetan 2Feb for currency converter//
   /* function getCurrencyConverted($amount, $currencys) 
    {       
	global $Config;	

//echo $amount;
	$amount = urlencode($amount);
	
	if(strstr($currencys,',') && $currencys != '')
	{
	    $currencyArr = explode(',',$currencys);
	    
	}else{
	    $currencyArr[] = $currencys;
	}

	$srch = array_search($Config['Currency'], $currencyArr );
	if($srch)
	{
		array_splice($currencyArr, array_search($Config['Currency'], $currencyArr ), 1);
	}	
	$res = '';
//print_r($currencyArr);
	foreach($currencyArr as $currency)
	{
		
		$from_Currency = urlencode($Config['Currency']);
		$to_Currency   = urlencode($currency);
if($from_Currency!=$to_Currency){
		$url = "http://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency";

		$ch = curl_init();
		$timeout = 0;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$rawdata = curl_exec($ch);
		curl_close($ch);
		$data = explode('bld>', $rawdata);
		$data = explode($to_Currency, $data[1]);
if($data[0]==''){
$data[0] = '0.00';
}
		$res .= '<b>'.$this->getCurrencySymbol($currency).' '. number_format($data[0], 2).'</b> <br/>';

}else{

$res .= '<b>'.$this->getCurrencySymbol($currency).' '. number_format($amount, 2).'</b> <br/>';
}
	}

	return $res;
    }	
*/

//added by sanjiv 8march for currency converter//
    function getCurrencyConverted($amount, $currencys)
    {
    	global $Config;
    	$amount = urlencode($amount);
    	if(strstr($currencys,',') && $currencys != '')
    	{
    		$currencyArr = explode(',',$currencys);
    		 
    	}else{
    		$currencyArr[] = $currencys;
    	}
    	 
    	$srch = array_search($Config['Currency'], $currencyArr );
    	if($srch)
    	{
    		array_splice($currencyArr, array_search($Config['Currency'], $currencyArr ), 1);
    	}
    	$res = '';
    	
    	$return = $this->CurrencyRate;
    	if(empty($return) || !is_array($return)){ 
    		$return = $this->savecurrencyExchange($currencys,true);
    	}
    	
    	foreach($return as $currency=> $curencyRate)
    	{
    		if(in_array($currency,$currencyArr)){
		
		$amountVal = round(GetConvertedAmount($curencyRate, $amount) ,2);
		$res .= '<b>'.$this->getCurrencySymbol($currency).' '. $amountVal.'</b> <br/>';
    		#$res .= '<b>'.$this->getCurrencySymbol($currency).' '. round($amount*$curencyRate, 2).'</b> <br/>';
		}
    	} 
    
   // print_r($res);
    	return $res;
    }
    
    function savecurrencyExchange($currencys, $onload=false){
    	global $Config;//echo "in";
    	
   
    	
    	if(strstr($currencys,',') && $currencys != '')
    	{
    		$currencyArr = explode(',',$currencys);
    		 
    	}else{
    		$currencyArr[] = $currencys;
    	}
  	    $finalArr = array();
    	$currencyArr[] = $Config['Currency'];
    	$finalArr = $this->currencyExchange($currencyArr); //Added on 4Sep.2017 by chetan//

    	
    	if($onload){ $this->CurrencyRate = $_SESSION['CurrencyRealTimeRate'] = $finalArr;}
    	return $finalArr;
    }
	

    //added for excahnge as yahoo query is become unstable. on 4sept2017 by chetan//
    function currencyExchangeddsgdfgd214($currencyArr) 
    {       
	global $Config;	

	foreach($currencyArr as $currency)
	{	
		$from_Currency = urlencode($Config['Currency']);
		$to_Currency   = urlencode($currency);

	

$from_Currency = urlencode($from_Currency);
$to_Currency = urlencode($to_Currency);
$encode_amount = 1;


			$url = "https://xecdapi.xe.com/v1/convert_to.json/?to=".$from_Currency."&from=".$to_Currency."&amount=1";

			$cinit = curl_init();
			curl_setopt($cinit, CURLOPT_URL, $url);
			curl_setopt($cinit, CURLOPT_HEADER,0);
			curl_setopt($cinit, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
			curl_setopt($cinit, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
			curl_setopt($cinit, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($cinit, CURLOPT_TIMEOUT, 30);
			curl_setopt($cinit, CURLOPT_CUSTOMREQUEST, 'GET');  

			curl_setopt($cinit, CURLOPT_USERPWD, "virtualstackssystemsllc303099069:p6g9avhdeo5kic0h20l5fsji63");//xe
 

			$response = curl_exec($cinit);
			$httpCode = curl_getinfo($cinit, CURLINFO_HTTP_CODE); 
			$info = curl_getinfo($cinit);
			$err = curl_error($cinit);  
			curl_close($cinit); 
			if($err){
				$converted_amount = '';
			}else{
				//echo '<br><br>Response: '.$response; 
 				$converted_amount = '0';
				$jsonCardArray = json_decode($response, true);	
				if(!empty($jsonCardArray['from'][0]['mid'])){
					$converted_amount = round($jsonCardArray['from'][0]['mid'],4);
					if($converted_amount>0){
						$converted_amount = number_format($converted_amount, 2);
					}
				}


				/*$get = explode("<span class=bld>",$response);
				if(!empty($get[1]))$get = explode("</span>",$get[1]);  
				#$converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);				
				$converted_amount = (float)trim($get[0]);*/
			}






$res[$currency] = $converted_amount;



}
return $res;

    }
    
    
function currencyExchange($currencyArr) 
{       
	global $Config;	

$Config['RealTime']=1;

#pr($currencyArr); exit;
	foreach($currencyArr as $currency)
	{	
	#echo $currency."!=".$Config['Currency']."<br>";
		$from_Currency = urlencode($Config['Currency']);
		$to_Currency   = urlencode($currency);
		$encode_amount = 1;
		
		if($to_Currency!=$Config['Currency']){			
				$ConversionRate = CurrencyConvertor($encode_amount,$from_Currency,$to_Currency,'INV');
			}else{
				$ConversionRate=1;
			}
		if($_GET['BH']==1)	echo $ConversionRate;
		$res[$currency] = $ConversionRate;


    }
    #pr($res); exit;
          return $res;

    }
    
    
    
    
    
    
    //End//	
		
    //added 6Feb for currency symbol//
    function getCurrencySymbol($currcode)
    {
	$locale		= 'en-US'; //browser or user locale
	$currency	= $currcode;
	$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
	$symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
	header("Content-Type: text/html; charset=UTF-8;");
	return $symbol;
    }	
	//end// 

    function getCurrency($currency_id,$Status)
	{
		$sql  = " where 1 "; 
		$sql .= (!empty($currency_id ))?(" and currency_id ='".$currency_id."'" ):("");
		$sql .= (!empty($Status))?(" and Status='".$Status."'"):("");

		$sql="select * from erp.currencies ".$sql." order by name";
		return $this->query($sql);
	}
   	 	 //End////added 17Feb for fprice//update 20Mar2017
    function getfpriceDetail($condi,$itemdetail)
    {
	global $Config;
	$objItem = new items();
	$Line='';
	$res 	= $objItem->getItemCondionQty($itemdetail['Sku'],$condi);
	$html	= '<a id="'.$Line.'" class="fprice-active" href="javascript:;"><img style="width:13px" border="0" title="Price Detail" src="../images/fprice.png"></a>
<!-- Modal -->
<div id="fprice-overlay" class="overlay-div fpricediv"></div>
<div id="fprice" class="boom-table fprice" style="width:250px">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">    
        <button type="button" class="boom-close fprice-close">&times;</button>
        <h4 class="modal-title">Item Price Detail</h4>        
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
 	   <tr>
             <td valign="top">
		<div id="preview_div">
<table align="center" cellspacing="1" cellpadding="3" width="100%">';
		if(!empty($res[0]['pricetype'])){
		
		if($res[0]['pricetype']=='percentage' || $res[0]['pricetype']=='fixed')
		{	
			$html.=	'<tr align="left">
			<td width="10%" class="head1">Fixed Price</td>
			<td width="10%" class="">'.$this->getCurrencySymbol($Config['Currency']).$res[0]['fprice'].'</td>
			</tr>';
		}
				
		if($res[0]['pricetype']=='range')
		{	
			$html.='<tr>
			<td align="right"  class="blackbold"></td>
			<td align="left"  class="blacknormal">
			<table width="80%" cellspacing="1" cellpadding="3" align="left" id="list_table">
			<tr align="left">
				<td width="40%"  class="head1"> Qty</td>
				<td width="40%" class="head1"> Price</td>
			</tr>';
			$qtyfrom 	= explode(',',$res[0]['qtyfrom']);
			$qtyto	 	= explode(',',$res[0]['qtyto']);	
			$fprice 	= explode(',',$res[0]['fprice']);
			$prpercent	= explode(',',$res[0]['prpercent']);	
			$count 		= count($qtyfrom);

			for($i=0;$i<$count;$i++){
			$pr = ($fprice[$i] == "") ? 0 : $fprice[$i]; 
			$html.='<tr align="left">	
				<td width="40%" > '.$qtyfrom[$i].' - '.$qtyto[$i].' </td>
				<td width="40%" > '.$this->getCurrencySymbol($Config['Currency']). $pr.' </td>
				</tr>';
			}

			$html.='</table>
			</td>
			</tr>';
		}
               
	}else{
		$html.=	'<tr align="left">
			 <td width="10%" class="no_record">'.NO_RECORD.'</td>
			</tr>';
			
		}   
                $html.=	'</table>	
        </td>
    </tr>
</table>
      </div>
      
    </div>
  </div>
</div>';	
	return $html;	
    }	
	//End//

//added by chetan on 18Apr2017//
var $totKitqty = '';
function getAllQtKitItemsplusKitItems($item_id,$Cond,$WID)
{	
	$objItem = new items();
	$isArrKit = $objItem->GetKitItem($item_id);	
	if(!empty($isArrKit))
	{	
		foreach($isArrKit as $values)
		{		
			$arryCondQty = $objItem->getItemCondion($values['Sku'],$Cond, $WID);
			$conQty = (int)(($arryCondQty[0]['condition_qty']) ? $arryCondQty[0]['condition_qty'] : '0');			
			$this->totKitqty = ((int)$this->totKitqty) + (int)($conQty); 
			$isArrKit = $objItem->GetKitItem($values['item_id']);
			if($isArrKit)
			{
				$this->getAllQtKitItemsplusKitItems($values['item_id'],$Cond,$WID);
			}
		}
	}
	
	$totalQty = $this->totKitqty;
	$this->totKitqty = ''; 
	return  ($totalQty) ? (int)$totalQty : 0;
}
//End//


}    

