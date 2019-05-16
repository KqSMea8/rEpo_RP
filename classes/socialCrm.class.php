<?php 

class socialcrm extends dbClass
{
		//constructor
		public $field_types = array();
		function socialcrm()
		{
			$this->dbClass();
		} 
		/*Start Delete Social Info*/
                function DeleteSocialInfo($userId,$colum,$table,$wcolum){
                    
                    $sql = "UPDATE $table SET $colum='' WHERE $wcolum='".$userId."'";
                    //echo $sql;die;
                    return $this->query($sql);
                    //$sql= "Select * FROM s_address_book WHERE  RigisterTypeID = '".$registerTypeId."'";
                    
                }
              
                /*End Delete Social Info*/
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
			 $sql = "Select ".$data['fields']." FROM ".$data['table']." WHERE 1 ";
			 if(!empty($data['where'])){
			 $sql .= " and ".$data['where']."";
			 }
			 
			    $results =  $this->query($sql);
			    $array_result = array();
				if(count($results)>0){
				foreach($results as $val){
				$array_result[] = $val[$data['fields']];
				 }
				}
			return $array_result;
				
		}
		function checkUserexist($registerTypeId,$type){
			
		
             if($type == "add_contact"){
			  $sql= "Select * FROM s_address_book WHERE  RigisterTypeID = '".$registerTypeId."'";
                          //echo $sql;die;
			 } 
			 
			 if($type=="add_customer"){
				
				$sql= "Select * FROM s_customers WHERE  RigisterTypeID = '".$registerTypeId."'";
                                //echo $sql;
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
			  $sql="Select $selectfield FROM c_socialuserlead WHERE 1 $where";
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
		
		function SaveSocialfield($where=array(), $col='',$data, $socailID=array(),$table=''){
                    //echo 'ddd';
                    //die;
		    $Savedata=array();
			//if(empty($where) OR empty($col))
                        if(empty($where))   
			return false;
                        if(!empty($col)){
			$Savedata[$col]=$data;
                        }
			if(!empty($socailID)){
			$Savedata[$socailID['field']]=$socailID['value'];
                        //print_r($Savedata[$socailID['field']]);die;
			}
			return 	$this->update($table, $Savedata, $where); 			
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
	
        // google-plus function
        function google_plus($url){
                       //echo $url;die;
                        //$postData = '';
                        //$ch = curl_init();
            $file = file_get_contents ($url);
			
			//curl_setopt($ch, CURLOPT_URL,$url);
			
			//curl_setopt($ch, CURLOPT_POST, 1);
			//curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
			//curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
			//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			//$server_output = curl_exec ($ch);
			//curl_close ($ch);
			
			//echo "<pre>";print_r($server_output);die;
			$results = json_decode($file);
                        
			return $results;
        }
//*********************************Twitter Function By Amit Singh***************************//        
		
		//*****Search function
		function TwitterSearch($tablename,$field="*",$w=1){
			
			$strSQLQuery  = "select $field from `$tablename` where $w";
			return $this->query($strSQLQuery, 1);
		}
		//*******Delete function  in ('$data')
		function TwitterDelete($tablename,$wr=1)
		{
			$query_del="delete from `$tablename` where $wr";
			return $this->query($query_del, 1);
		}
		//******insert function
		function TwitterInsert($tablename,$value)
		{
			$query_insert="INSERT INTO `$tablename` (`". implode( '`,`', array_keys($value) ). "`) VALUES ('" . implode( "','", $value ) . "')";
			return $this->query($query_insert, 1);
		}
   		//******Update function
		function TwitterUpdate($tablename,$st,$wr=1)
		{
			$query_up="update `$tablename` set $st where $wr";
			return $this->query($query_up, 1);
		}
		function TwitterCronInsert($tablename,$value)
		{
			$query_cronIn="INSERT INTO `$tablename`(`alert_id`,`name`,`tweet_text`,`created_at`,`location`,`tweet_id`,`url`,`tweet_type`) values".(implode(',',$value));
			return $this->query($query_cronIn, 1);
		}
   
        function TwitterExlInsert($tablename,$field,$value)
		{
			$query_cronIn="INSERT INTO `$tablename`($field) values ".(implode(',',$value));// ('" . implode( "','", $value ) . "')";
			return $this->query($query_cronIn, 1);
		}
//*******************************Twitter Function End****************************//
}

?>
