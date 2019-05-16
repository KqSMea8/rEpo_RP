<?php 

class socialcrm extends dbClass
{
		//constructor
		public $field_types = array();
		function socialcrm()
		{
			$this->dbClass();
		} 
		
		///////  Connect Save  //////
	
		
		function SaveSocialConnect($arg=array()){
			
					
			$this->insert( 'c_socialuserconnect', $arg, $format = null );
			
		}
		function UpdateSocialConnect($arg=array(),$where=array()){
			
		return 	$this->update( 'c_socialuserconnect', $arg, $where ); 
		
			
		}
		function SaveSocialData($data, $type){
			 $salesCustomer = new Customer();
			if($type == "add_contact"){
				return $salesCustomer->addCustomerAddress($data,0,'contact'); 
			}
			
			
			if($type=="add_customer"){
				
				 return  $salesCustomer->addCustomer($data);
			}
		}
		
		
	   function GetAllData($data){
			 $sql = "Select ".$data['fields']." FROM ".$data['table']." WHERE 1=1";
			 if(!empty($data['where'])){
			 $sql .= " and ".$data['where']."";
			 }
			 
			return $this->query($sql);
				
		}
		function checkUserexist($registerTypeId,$type){
			
		
             if($type == "add_contact"){
			  $sql= "Select * FROM s_address_book WHERE  RigisterTypeID = '".$registerTypeId."'";
			 } 
			 
			 if($type=="add_customer"){
				
				$sql= "Select * FROM s_customers WHERE  RigisterTypeID = '".$registerTypeId."'";
			}
			
			$result = $this->query($sql);
			if(count($result)>0){
				return false;	
			}else{
				return true;
			}
			
		}
		function InsertMultiUserLead($arg=array()){
			$sql="";
		if(!empty($arg)){	
			foreach($arg as $data){
				$this->insert( 'c_socialuserlead', $data, $format = null );
			//	$sql =$this->_insert_replace_Query( 'c_socialuserlead', $data, null, 'INSERT' ).';';
			}
		}			
			
		}
		function getSocialLead($type='',$fields=array()){			
			$selectfield='*';
			$where='';
			if(!empty($fields))
			$selectfield=implode(', ',$fields);			
			if(!empty($type)){
				
				$where .=" AND social_type='".$type."'";
			}
			  $sql="Select $selectfield FROM c_socialuserlead WHERE 1=1 $where";
			return $this->query($sql);
		}
		
		function deleteSocialConnect($id,$type=''){			
			$sql="Delete FROM c_socialuserconnect WHERE id='".$id."' AND social_type='".$type."'";
			return $this->query($sql);
		}
		
		function deleteSocialPost($id,$type=''){
			$sql="Delete FROM c_socialpost WHERE id='".$id."' AND social_type='".$type."'";
			return $this->query($sql);
		}
		
		function SaveSocialfield($contactid,$col='',$data){
		$Savedata=array();
			if(empty($contactid) OR empty($col))
			return false;
			$Savedata[$col]=$data;
			return 	$this->update( 's_address_book', $Savedata, array('AddID'=>$contactid) ); 			
		}
		
		
		function getSocialUserConnect($Socialtype='twitter',$fields=array()){
			$selectfield='*';
			if(!empty($fields))
			$selectfield=implode(', ',$fields);
			 $sql="Select $selectfield FROM c_socialuserconnect WHERE social_type='".$Socialtype."'";
			return $this->query($sql);
		}
	function SocialLeadList($socialtype,$id = 0, $SearchKey, $SortBy, $AscDesc){
		
		global $Config;
        $strAddQuery = 'where 1';
        $strAddQuery .=!empty($socialtype)?(" and sl.social_type='" . $socialtype. "'"):'';
        $SearchKey = strtolower(trim($SearchKey));
        
        $strAddQuery .= (!empty($id)) ? (" and sl.id='" . $id . "'") : "";
            if ($SortBy != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
            } else {
                #$strAddQuery .= (!empty($SearchKey))?(" and ( l.FirstName like '%".$SearchKey."%' or l.primary_email like '%".$SearchKey."%' or l.leadID like '%".$SearchKey."%' or l.lead_status like '%".$SearchKey."%' or e.UserName like '%".$SearchKey."%' or l.company like '%".$SearchKey."%'  ) "  ):(""); 
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( sl.name like '%" . $SearchKey . "%' or sl.social_id ='" . $SearchKey . "' " ) : ("");
            }
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by sl.id ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : ("desc");

        $strSQLQuery = "select sl.* From c_socialuserlead sl " . $strAddQuery;




        return $this->query($strSQLQuery, 1);
		
		}
		
	function SocialPostList($socialtype,$id = 0, $SearchKey, $SortBy, $AscDesc){
		
		global $Config;
        $strAddQuery = 'where 1';
        $strAddQuery .=!empty($socialtype)?(" and sp.social_type='" . $socialtype. "'"):'';
        $SearchKey = strtolower(trim($SearchKey));
        
        $strAddQuery .= (!empty($id)) ? (" and sp.id='" . $id . "'") : "";
            if ($SortBy != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
            } else {
                #$strAddQuery .= (!empty($SearchKey))?(" and ( l.FirstName like '%".$SearchKey."%' or l.primary_email like '%".$SearchKey."%' or l.leadID like '%".$SearchKey."%' or l.lead_status like '%".$SearchKey."%' or e.UserName like '%".$SearchKey."%' or l.company like '%".$SearchKey."%'  ) "  ):(""); 
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( sp.post like '%" . $SearchKey . "%' or sl.post_id ='" . $SearchKey . "' " ) : ("");
            }
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by sp.id ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : ("desc");

        $strSQLQuery = "select sp.* From c_socialpost sp " . $strAddQuery;




        return $this->query($strSQLQuery, 1);
		
		}
		
		function deleteSocialLead($id,$socialtype){
				global $Config;
        	$strAddQuery = 'where 1';
			$strAddQuery .=!empty($socialtype)?(" and social_type='" . $socialtype. "'"):'';
			$strAddQuery .= (!empty($id)) ? (" and id='" . $id . "'") : "";
			echo $strSQLQuery = "Delete  From c_socialuserlead " . $strAddQuery;
			 return $this->query($strSQLQuery, 1);
		}
		
		
		function InsertSocialpost($arg=array()){
		
			return $this->insert( 'c_socialpost', $arg, $format = null );
		
		}
		//********** Prepare Query ******************/
		public function prepare( $query, $args ) {
		if ( is_null( $query ) )
			return;

		// This is not meant to be foolproof -- but it will catch obviously incorrect usage.
		if ( strpos( $query, '%' ) === false ) {
			_doing_it_wrong( 'wpdb::prepare', sprintf( __( 'The query argument of %s must have a placeholder.' ), 'wpdb::prepare()' ), '3.9' );
		}

		$args = func_get_args();
		array_shift( $args );
		// If args were passed as an array (as in vsprintf), move them up
		if ( isset( $args[0] ) && is_array($args[0]) )
			$args = $args[0];
		$query = str_replace( "'%s'", '%s', $query ); // in case someone mistakenly already singlequoted it
		$query = str_replace( '"%s"', '%s', $query ); // doublequote unquoting
		$query = preg_replace( '|(?<!%)%f|' , '%F', $query ); // Force floats to be locale unaware
		$query = preg_replace( '|(?<!%)%s|', "'%s'", $query ); // quote the strings, avoiding escaped strings like %%s
		array_walk( $args, array( $this, 'escape_by_ref' ) );
		return @vsprintf( $query, $args );
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
	
		return $this->query( $this->prepare( $sql, $data ) );
	}
		function _insert_replace_Query( $table, $data, $format = null, $type = 'INSERT' ) {
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
				
				return  $this->prepare( $sql, $data );
			}
	
	public function update( $table, $data, $where, $format = null, $where_format = null ) {
		if ( ! is_array( $data ) || ! is_array( $where ) )
			return false;

		$formats = $format = (array) $format;
		$bits = $wheres = array();
		foreach ( (array) array_keys( $data ) as $field ) {
			if ( !empty( $format ) )
				$form = ( $form = array_shift( $formats ) ) ? $form : $format[0];
			elseif ( isset($this->field_types[$field]) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$bits[] = "`$field` = {$form}";
		}

		$where_formats = $where_format = (array) $where_format;
		foreach ( (array) array_keys( $where ) as $field ) {
			if ( !empty( $where_format ) )
				$form = ( $form = array_shift( $where_formats ) ) ? $form : $where_format[0];
			elseif ( isset( $this->field_types[$field] ) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$wheres[] = "`$field` = {$form}";
		}

		$sql = "UPDATE `$table` SET " . implode( ', ', $bits ) . ' WHERE ' . implode( ' AND ', $wheres );
		return $this->query( $this->prepare( $sql, array_merge( array_values( $data ), array_values( $where ) ) ) );
	}
		
}

?>
