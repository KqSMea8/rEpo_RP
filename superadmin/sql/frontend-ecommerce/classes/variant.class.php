<?php
class varient extends dbClass
{
function lead() {
        $this->dbClass();
    }
    
function GetVariantType(){
    
    $sql="select * from `inv_variant_type`";
    return $this->query($sql, 1);
}
public function insert( $table, $data, $format = null ) {
		return $this->_insert_replace_helper( $table, $data, $format, 'INSERT' );
	}
	function _insert_replace_helper( $table, $data, $format = null, $type = 'INSERT' ) {
		if ( ! in_array( strtoupper( $type ), array( 'REPLACE', 'INSERT' ) ) )
			return false;
		$this->insert_id = 0;
		$formats = $format = (array) $format;
		$fields = array_keys( $data );
		$formatted_fields = array();
		foreach ( $fields as $field ) {
			if ( !empty( $format ) )
				$form = ( $form = array_shift( $formats ) ) ? $form : $format[0];
			elseif ( isset( $this->field_types[$field] ) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$formatted_fields[] = $form;
		}
		 $sql = "{$type} INTO `$table` (`" . implode( '`,`', $fields ) . "`) VALUES (" . implode( ",", $formatted_fields ) . ")";
                 echo $sql;die;
		$this->prepare( $sql, $data );
		return $this->query( $this->prepare( $sql, $data ) );
	}
        
        function AddVariant($arryDetails){
            
                        @extract($arryDetails);	
			 $sql = "insert into inv_variant_value (variant_type_id,variant_name,required,item_id) values('".$variant_type_id."','".addslashes($variant_name)."', '".$required."','".$item_id."')"; 
			//$rs = $this->query($sql,0);
			
			//return $lastInsertId;
                        //echo $sql;die;
                        $vs = $this->query($sql, 1);
                        $lastInsertId = $this->lastInsertId();
                        return $lastInsertId;
			}
        function AddMultipleVariantOption($arryDetails){
            
            //echo '<pre>'; print_r($arryDetails);die;
            @extract($arryDetails);	
            for ($i = 0; $i < sizeof($option_value); $i++) {
                $strSQLQuery = "insert into inv_variant_manageOption (variant_name_id,option_value) values('" . $variant_name_id . "','" . addslashes($option_value[$i]) . "')";
                //echo $strSQLQuery;die;
                $this->query($strSQLQuery, 0);
            }

            //echo $campaignID[$i];
        

        return true;
        }
        
        
        function GetVariant($id,$item_id){
            global $Config;
            $sql = " where 1";
            $sql .= (!empty($id)) ? (" and v.id='" . $id . "'") : ("");
	    $sql .= (!empty($item_id)) ? (" and v.item_id='" . $item_id . "'") : ("");
            $sql="select v.*,t.field_name from inv_variant_value v INNER JOIN inv_variant_type t on v.variant_type_id=t.id".$sql." order by id desc";
            //echo $sql;die;
            return $this->query($sql, 1);
            
        }


function GetVariantDispaly($variant_id){
            global $Config;
            $sql = " where 1";
            $sql .= (!empty($variant_id)) ? (" and v.id in($variant_id )") : ("");
		$sql .= (!empty($item_id)) ? (" and v.item_id='" . $item_id . "'") : ("");
            $sql="select v.*,t.field_name from inv_variant_value v INNER JOIN inv_variant_type t on v.variant_type_id=t.id".$sql." order by id desc";
            #echo $sql;
            return $this->query($sql, 1);
            
        }

        function DeleteVariant($id){
            global $Config;
            $sql="DELETE From inv_variant_value where id='".$id."'";
            //echo $sql;die;
            return $this->query($sql, 1);
        }
        function deleteVariantOptionAll($id){
            global $Config;
            $sql="DELETE From inv_variant_manageOption where variant_name_id='".$id."'";
            //echo $sql;die;
            return $this->query($sql, 1);
        }
        function UpdateVariant($arryDetails){
            global $Config;
            @extract($arryDetails);
            $sql = " where 1";
            $sql="update inv_variant_value set variant_type_id='".$variant_type_id."',variant_name='".addslashes($variant_name)."',required='".$required."' where id='".$id."'";
            $vs = $this->query($sql, 1);
            $lastInsertId = $this->lastInsertId();
            //echo $sql;die;
            return $lastInsertId;
        }
        function GetMultipleVariantOption($id, $optionID=''){
	    global $Config;
	    $sql = " where 1";
	    $sql .= (!empty($id)) ? (" and o.variant_name_id='" . $id . "'") : ("");
	    $sql .= (!empty($optionID)) ? (" and o.id In(" . $optionID . ")") : ("");	    //By Chetan14Sep//
	    $sql ="select o.* from inv_variant_manageOption o".$sql;
             
            return $this->query($sql, 1);
        }
        function deleteVariantOption($id){
            
            global $Config;
            $sql="DELETE From inv_variant_manageOption where id='".$id."'";
            return $this->query($sql, 1);
        }
        
        function UpdateMultipleVariantOption($arryDetails){
            global $Config;
             //$sql = " where 1";
            //echo '<pre>'; print_r($arryDetails);die;
             @extract($arryDetails);
             
             //$sql="DELETE from inv_variant_manageOption where variant_name_id='".$variant_name_id."'";
             //$this->query($sql, 1);
             //echo $strSQLQuery;die;
            for ($i = 0; $i < sizeof($option_value); $i++) {
                if($id[$i]=='0'){
                    //echo 'insert ';
                    //echo $option_value[$i].'<br>';
                    $strSQLQuery = "insert into inv_variant_manageOption (variant_name_id,option_value) values('" . $variant_name_id . "','" . addslashes($option_value[$i]) . "')";
                    $this->query($strSQLQuery, 1);
                }
                else {
                    //echo 'delete ';
                    //echo $option_value[$i].'<br>';
                    $sql="update inv_variant_manageOption set option_value='".addslashes($option_value[$i])."' where id='".$id[$i]."' and variant_name_id='".$variant_name_id."'";
                    $this->query($sql, 1);
                }
                //$strSQLQuery = "insert into inv_variant_manageOption (variant_name_id,option_value) values('" . $variant_name_id . "','" . $option_value[$i] . "')";
                //echo $strSQLQuery;die;
                //$this->query($strSQLQuery, 0);
            }

            //echo $campaignID[$i];
        

        return true;
            
        }
        
        
        function GetQuoteVariantfotQuoteItem($id,$varianttype) {
            
            global $Config;
            $sql = " where 1";
            $sql .= (!empty($id)) ? (" and qv.quote_item_ID='" . $id . "'") : ("");
            $sql .= (!empty($varianttype)) ? (" and qv.type='" . $varianttype . "'") : ("");
            $sql="select qv.*,vt.variant_name,vt.variant_type_id from c_quote_item_variant qv INNER JOIN inv_variant_value vt on qv.variantID=vt.id".$sql." order by id desc";
            #echo $sql;die;
            return $this->query($sql, 1);
            
        }
        function GetQuoteVariantOptionValuefotQuoteItem($id,$variantid,$varianttype) {
            
            global $Config;
            $sql = " where 1";
            $sql .= (!empty($id)) ? (" and qvp.quote_item_ID='" . $id . "'") : ("");
            $sql .= (!empty($variantid)) ? (" and qvp.variantID='" . $variantid . "'") : ("");
            $sql .= (!empty($varianttype)) ? (" and qvp.type='" . $varianttype . "'") : ("");
            $sql="select qvp.*,vtp.option_value from c_quote_item_variantOptionValues qvp INNER JOIN inv_variant_manageOption vtp on qvp.variantOPID=vtp.id".$sql." order by id desc";
            //echo $sql;die;
            return $this->query($sql, 1);
            
        }
        
        function QuoteVariantInfoDelete($id,$variantid,$varianttype){
            
            global $Config;
            //echo $variantid.'<br>';
            $sql = " where 1";
            $sql .= (!empty($id)) ? (" and quote_item_ID='" . $id . "'") : ("");
            $sql .= (!empty($variantid)) ? (" and variantID='" . $variantid . "'") : ("");
            $sql .= (!empty($varianttype)) ? (" and type='" . $varianttype . "'") : ("");
            $sql ="DELETE from c_quote_item_variant".$sql;
            //echo $sql.'<br>';
            return $this->query($sql, 1);
            
        }
        
        function QuoteVariantOptionInfoDelete($id,$variantid,$varianttype){
            
            global $Config;
            //echo $variantid;
            $sql = " where 1";
            $sql .= (!empty($id)) ? (" and quote_item_ID='" . $id . "'") : ("");
            $sql .= (!empty($variantid)) ? (" and variantID='" . $variantid . "'") : ("");
            $sql .= (!empty($varianttype)) ? (" and type='" . $varianttype . "'") : ("");
            $sql ="DELETE from c_quote_item_variantOptionValues".$sql;
            //echo $sql; die;
            return $this->query($sql, 1);
            
        }
        function QuoteVariantOptionInfoDeleteFromVariantMasterAndImplentation($variantOPID){
            
            global $Config;
            //echo $variantOPID;
            $sql = " where 1";
            $sql .= (!empty($variantOPID)) ? (" and variantOPID='" . $variantOPID . "'") : ("");
            
            $sql ="DELETE from c_quote_item_variantOptionValues".$sql;
            //echo $sql; die;
            return $this->query($sql, 1);
            
        }
        function in_array_case_insensitive($needle, $haystack) 
                                {
                                 return in_array( strtolower($needle), array_map('strtolower', $haystack) );
                                }
        
	
}

?>
